import Vuex from 'vuex';
import Vue from 'vue';
import axios from 'axios';
import { reject } from 'lodash';

Vue.use(Vuex);

export default new Vuex.Store({
    namespaced: true,

    state:{
        user: null,
        token: localStorage.getItem("token"),
        
    },
    getters:{

    },

    mutations: {
        setAccount(state, { token, user }){
            state.user = user;
            state.token = token;
        },
        
        setToken(_state, token){
            localStorage.setItem('token', token);
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
            console.log(this.state);
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
        

            console.log(`token: ${token}`);
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
        }


    }
});