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
        timeline: {
            notes: [],
            isLoading: false,
            currentPageNumber: 0
        }
        
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
        },
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
                state.timeline.notes.push(...page.data);
            }
            state.timeline.isLoading = false;
            state.timeline.currentPageNumber = page.current_page;
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

        loadNext({commit, state}){
            if(state.timeline.isLoading){
                return;
            }
            state.timeline.isLoading = true;

            axios.get(
                '/api/notes',
                {
                    headers: { Authorization: `Bearer ${state.token}`},
                    params: { page: state.timeline.currentPageNumber + 1 }
                }
            ).then((res)=>{
                
                commit('nextPage', res.data);
            }).catch((e)=>{
                console.log(e);
                commit('nextPage', null);
            });


        },

        initTimeline(context){
            context.state.timeline.notes = [];
            context.state.timeline.isLoading = false;
            context.state.timeline.currentPageNumber = 0;
            context.dispatch('loadNext');
        },

        async follow(context, user){
            const res = await axios.post(
                `/api/users/${user.id}`,
                null,
                {
                    headers: { Authorization: `Bearer ${context.state.token}`}
                }
            );
            context.dispatch('initTimeline');
            return res.data;
        },

        async unfollow(context, user){
            const res = await axios.delete(
                `/api/users/${user.id}`,
                {
                    headers: { Authorization: `Bearer ${context.state.token}`}
                }
            );
            context.dispatch('initTimeline');
            return res.data;
        }

      
    }
});