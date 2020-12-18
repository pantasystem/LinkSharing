import Vuex from 'vuex';
import Vue from 'vue';
import axios from 'axios';
import { reject } from 'lodash';
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
        token: localStorage.getItem("token"),
        
    },


    mutations: {
        setAccount(state, { token, user }){
            localStorage.setItem('token', token);
            state.user = user;
            state.token = token;
        },
        
        setToken(_state, token){
            localStorage.setItem('token', token);
        },
        
    },

    getters: {
        token({state}){
            return state.token;
        }
    },

    actions: {
        async register(
            { commit, dispatch }, 
            req,
        ){
            const response = await axios.post(
                '/api/register',
                { 
                    email: req.email, 
                    user_name: req.userName, 
                    password: req.password,
                    password_confirmation: req.confirmPassword,
                    device_name: 'Client' 
                }
            );
            if (response.data) {
                console.log(response.data);
                console.log(response.data.token);
                commit("setAccount", {
                    user: response.data.user,
                    token: response.data.token.plainTextToken
                });
                dispatch('listen');
            }
            return response;
        },

        async login({ commit, dispatch }, req){
            
            let data = {
                ...req,
                device_name: 'Web Client'
            };

            const res = await axios.post(
                '/api/login',
                data
            );

            if (res.data) {
                localStorage.setItem("token", res.data.token);

                commit("setAccount", res.data);
                dispatch('listen');
            }
            return res;
            
        },

        async loadMe({ commit, dispatch }){
            let token = this.state.token;
            if( ! token){
                token = localStorage.getItem("token");
                commit(
                    'setAccount',
                    { 
                        token: token,
                        user: null
                    }
                );
            }
        

            const res = await axios.get(
                '/api/me',
                {
                    headers: { Authorization: `Bearer ${token}` }
                }
            );
            if (res.status == 200) {
                let account = {
                    token: token,
                    user: res.data
                };
                commit("setAccount", account);
                dispatch('listen');

                return account;
            }
            return null;
        },

        logout({ commit, dispatch }){
            commit(
                'setAccount',
                {
                    token: null,
                    user: null
                }
            );
            dispatch('timeline/initTimeline');
            dispatch('notification/init');
            dispatch('dispose')
        },

        
        async follow(context, user){
            const res = await axios.post(
                `/api/users/${user.id}`,
                null,
                {
                    headers: { Authorization: `Bearer ${context.state.token}`}
                }
            );
            context.commit('user', res.data);
            context.dispatch('timeline/initTimeline');
            return res.data;
        },

        async unfollow(context, user){
            const res = await axios.delete(
                `/api/users/${user.id}`,
                {
                    headers: { Authorization: `Bearer ${context.state.token}`}
                }
            );
            context.commit('user', res.data);
            context.dispatch('timeline/initTimeline');
            return res.data;
        },
        dispose(){
            streaming.disconnect();
        },
        listen({ state, dispatch }){
            try{
                streaming.connect(state.token);
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