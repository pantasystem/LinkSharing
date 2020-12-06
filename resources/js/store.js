import Vuex from 'vuex';
import Vue from 'vue';
import axios from 'axios';
import { reject } from 'lodash';
import timeline from './store/timeline';
import notification from './store/notification';
import users from './store/users';

Vue.use(Vuex);


export default new Vuex.Store({
    namespaced: true,

    modules:{
        'timeline': timeline,
        'notification': notification,
        'users': users
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
            { commit }, 
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
            if(response.data){
                this.localStorage.setItem("token", response.data.token);
                commit("setAccount", response.data);
            }
            return response;
        },

        async login({ commit }, req){
            
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
            }
            return res;
            
        },

        async loadMe({ commit }){
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
            dispatch('timeline/init');
            dispatch('notification/init');
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
        }

      
    }
});