import axios from 'axios';
import Vue from 'vue';


export default {
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
                let notifications  = res.data.data;
                console.assert(Array.isArray(notifications), "配列以外許可されていません");
                notifications = notifications.map((n)=>{
                    commit('user', n.publisher, { root: true});
                    Vue.delete(n.publisher, 'publisher');
                    return n;
                })
                commit('pushNotifications', notifications);
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
    },
    getters:{
        getNotifications(state, getters, rootState, rootGetters){
            console.log('getNotifications');
            console.log(state.notifications);
            return state.notifications.map((notify)=>{
                return {
                    ...notify
                }
            })
            .map((notify)=>{
                notify.publisher = rootGetters.get(notify.publisher_id);
                return notify;
            })
        }
    }
}