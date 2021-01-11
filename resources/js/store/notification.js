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
        unshiftNotification(state, notification){
            state.notifications.unshift(notification);
        },
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
        loadNext({commit, state, }){
            console.log("notification#loadNext");
            if(state.isLoading){
                return;
            }
            commit('setLoading', true);
            axios.get(
                '/api/notifications',
                {
                    params: { page: state.currentPage + 1 }
                }
            ).then((res)=>{  
                commit('pushNotifications', res.data.data);
                let notifications  = res.data.data;
                console.assert(Array.isArray(notifications), "配列以外許可されていません");
                notifications = notifications.map((n)=>{
                    commit('user', n.publisher, { root: true});
                    if(n.favorite != null && n.favorite.note != null){
                        let note = n.favorite.note;
                        commit('setNote', note, { root: true});
                        
                    }
                    Vue.delete(n.publisher, 'publisher');
                    return n;
                });
                commit('pushNotifications', notifications);
                if (res.data.data != null && res.data.data.length) {
                    commit('setCurrentPage', res.data.current_page);
                }
                commit('setLoading', false);
            }).catch((e)=>{
                console.log(e);
            });
        },
        onRecieveNotification({commit, state }, notification){
            if(state.isLoading){
                return;
            }
            commit('setLoading', true);

            axios.get(`/api/notifications/${notification.id}`,
            {
                params: { page: state.currentPage + 1 }
            })
                .then((res)=>{
                    let n = res.data;
                    commit('user', n.publisher, { root: true});
                    if(n.favorite != null && n.favorite.note != null){
                        let note = n.favorite.note;
                        commit('setNote', note, { root: true});
                        
                    }
                    Vue.delete(n.publisher, 'publisher');
                    commit('unshiftNotification', n);
                })
                .catch((error)=>{
                    console.log(error);
                })
                .finally(()=>{
                    commit('setLoading', false);
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
            return state.notifications.map((notify) => {
                return {
                    ...notify
                }
            });
        }
    }
}