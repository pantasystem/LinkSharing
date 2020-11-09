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
            commit("setAccount", response.data);
            return response;
        },

        async login({ commit }, req){
            
            data = {
                ...req,
                device_name: 'Web Client'
            };

            const response = await axios.post(
                '/api/login',
                data
            );
            commit("setAccount", response.data);
            console.log(response);
            return response;
        },


    }
});