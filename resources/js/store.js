import Vuex from 'vuex';
import Vue from 'vue';
import axios from 'axios';
import { reject } from 'lodash';

Vue.use(Vuex);

const timeline = {
    namespaced: true,
    state(){
        return {
            notes: [],
            isLoading: false,
            currentPage: 0
        }
    },
    mutations: {
        pushNotes(state, notes){
            if(Array.isArray(notes)){
                state.timeline.notes.push(...notes);
            }else{
                state.timeline.notes.push(notes);
            }

        },
        addNotesAtTheFirst(state, notes){
            if(Array.isArray(notes)){
                state.timeline.notes.unshift(...notes);

            }else{
                state.timeline.notes.unshift(notes);
            }
        },

        nextPage(state, page){
            if(Array.isArray(page.data) && page.data.length){
                state.notes.push(...page.data);
            }
            state.isLoading = false;
            state.currentPage = page.current_page;
        }

    },
    actions: {
        async createNote({ commit }, note){
            let res = await axios.post(
                'api/notes',
                note,
                {
                    headers: { Authorization: `Bearer ${this.state.token}` }

                }
            );

            let createdNote = res.data;
            commit('addNotesAtTheFirst', createdNote);
            return res;
        },

        loadNext({commit, state, rootState}){
            if(state.isLoading){
                return;
            }
            state.isLoading = true;

            console.log("load開始");
            console.log(rootState.token);
            axios.get(
                '/api/notes',
                {
                    headers: { Authorization: `Bearer ${rootState.token}`},
                    params: { page: state.currentPage + 1 }
                }
            ).then((res)=>{                
                commit('nextPage', res.data);
            }).catch((e)=>{
                console.log(e);
                commit('nextPage', null);
            });


        },

        initTimeline(context){
            console.log("initTimeline開始しました");
            context.state.notes = [];
            context.state.isLoading = false;
            context.state.currentPage = 0;

            context.dispatch('loadNext');
        },

    }
};

const notification = {
    namespaced: true,
    state(){
        return {
            notifications: [],
            isLoading: false,
            currentPage: 0
        }
    },
    mutations: {
        pushNotifications(state, notifications){
            state.notifications.push(...notifications);
        },
        setNotifications(state, notifications){
            state.notifications = notifications;
        },
        setLoading(state, isLoading){
            state.isLoading = isLoading;
        },
        setCurrentPage(state, page){
            state.currentPage = page;
        }
    },
    actions: {
        loadNext({commit, state, rootState}){
            console.log("notification#loadNext");
            if(state.isLoading){
                return;
            }
            commit('setLoading', true);
            let token = rootState.token;
            axios.get(
                '/api/notifications',
                {
                    headers: { Authorization: `Bearer ${token}`},
                    params: { page: state.currentPage + 1 }
                }
            ).then((res)=>{  
                commit('pushNotifications', res.data.data);
                commit('setCurrentPage', res.data.current_page);
                commit('setLoading', false);
            }).catch((e)=>{
                console.log(e);
            });
        },

        init({commit}){
            commit('setLoading', false);
            commit('setNotifications', []);
            commit('setCurrentPage', 0);
        }
    }
}
export default new Vuex.Store({
    namespaced: true,

    modules:{
        'timeline': timeline,
        'notification': notification
    },
    state:{
        user: null,
        token: localStorage.getItem("token"),
        
    },


    mutations: {
        setAccount(state, { token, user }){
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

        logout({ commit }){
            commit(
                'setAccount',
                {
                    token: null,
                    user: null
                }
            );
        },

        
        async follow(context, user){
            const res = await axios.post(
                `/api/users/${user.id}`,
                null,
                {
                    headers: { Authorization: `Bearer ${context.state.token}`}
                }
            );
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
            context.dispatch('timeline/initTimeline');
            return res.data;
        }

      
    }
});