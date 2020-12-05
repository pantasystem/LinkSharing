import axios from 'axios';


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