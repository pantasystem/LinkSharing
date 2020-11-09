import Vuex from 'vuex';
import Vue from 'vue';
import axios from 'axios';

Vue.use(Vuex);

export default new Vuex.Store({
    namespaced: true,

    state:{
        user: null,
        token: null,
        
    },
    getters:{

    },

    mutations: {
        setAccount(state, { token, user }){
            state.user = user;
            state.token = token;
        }
    },

    actions: {
        async createAccount(
            { commit }, 
            { email, userName, password, confirmPassword}
        ){
            const response = await axios.post(
                '/api/register',
                { email, userName, password, confirmPassword, deviceName: 'Client' }
            );
            if(response.data){
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
                commit("setAccount", res.data);
            }
            return res;
            
        },


    }
});