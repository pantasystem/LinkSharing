import Vuex from 'vuex';
import Vue from 'vue';
import axios from 'axios';
import { isSet, reject } from 'lodash';
import timeline from './store/timeline';
import notification from './store/notification';
import users from './store/users';
import notes from './store/notes';
import streaming from './streaming';

Vue.use(Vuex);


export default new Vuex.Store({
    namespaced: true,

    modules:{
        'timeline': timeline,
        'notification': notification,
        'users': users,
        'notes': notes
    },
    state:{
        user: null,
        
    },


    mutations: {
        
        SET_USER(state, user) {
            state.user = user;
        }
        
    },

    actions: {
        async register(
            { dispatch }, 
            req,
        ){
            const response = await axios.post(
                '/register',
                { 
                    email: req.email, 
                    user_name: req.userName, 
                    password: req.password,
                    password_confirmation: req.confirmPassword,
                }
            );
            if (response.status >= 200 && response.status < 300) {
                let user = await dispatch('loadMe');
                if (user) {
                    dispatch('timeline/initTimeline');
                    dispatch('notification/init');
                    dispatch('listen');
                }

            }
            
            return response;
        },

        async login({ dispatch }, req){
            
            let data = {
                ...req,
                device_name: 'Web Client'
            };
            await axios.get('/sanctum/csrf-cookie');

            const res = await axios.post(
                '/login',
                data
            );

            if (res.status == 200) {
                await dispatch('loadMe');
                dispatch('listen');
                dispatch('timeline/initTimeline');
                dispatch('notification/init');
            }
           
            
            return res;
            
        },

        async loadMe({ commit, dispatch }){
            
        

            const res = await axios.get(
                '/api/me'
            );
            if (res.status == 200) {
                
                commit('SET_USER', res.data);
                dispatch('listen');

                return res.data;
            }
            return null;
        },

        logout({ commit, dispatch }){
            axios.post('/logout')
                .catch((e) => {
                    console.log(e);
                }).then((res) => {
                    commit('SET_USER', null);
                    dispatch('timeline/initTimeline');
                    dispatch('notification/init');
                    dispatch('dispose');
                })
            
        },

        
        async follow(context, user){
            const res = await axios.post(
                `/api/users/${user.id}`,
            );
            context.commit('user', res.data);
            context.dispatch('timeline/initTimeline');
            return res.data;
        },

        async unfollow(context, user){
            const res = await axios.delete(`/api/users/${user.id}`);
            context.commit('user', res.data);
            context.dispatch('timeline/initTimeline');
            return res.data;
        },

        async uploadAvatar(context, file) {
            let form = new FormData();
            form.append('avatar_image', file);
            let res = await axios.post(
                '/api/settings/profile/avatar',
                form,
                {
                    headers: {
                        'content-type': 'multipart/form-data',
                    },
                }
            );
            if (res.status == 200) {
                context.commit('SET_USER', res.data);
            }
            return res;
        },

        async updateProfile(context, data) {
            let res = await axios.post(
                '/api/settings/profile',
                data
            );
            if (res.status == 200) {
                context.commit('SET_USER', res.data);
            }
            return res;
        },


        dispose(){
            streaming.disconnect();
        },
        listen({ state, dispatch }){
            try{
                streaming.connect();
                let echo = streaming.getEcho();
                console.assert(echo != null, "echoがNULLです");
                console.assert(state.user.id, "user.idが無効です");
                echo.private(`notifications.subscriber.${state.user.id}`)
                    .listen('Notified', (e)=>{
                        console.log('通知');
                        dispatch('notification/onRecieveNotification', e.notification);
                    });
                console.log('notifications.subscriber開始');
                echo.channel('favorite')
                    .listen('Favorited', (e)=>{
                        console.log("受信");
                        console.log(e);
                    });
                console.log("listen処理完了");
                console.log(echo);
                echo.private(`timeline.streaming.${state.user.id}`)
                    .listen('TimelineUpdated', (e) => {
                        dispatch('timeline/onTimelineUpdated', e.noteId);
                    });
            }catch(e){
                console.log(e);
                console.log(streaming.getEcho());
            }
        }

      
    }
});

