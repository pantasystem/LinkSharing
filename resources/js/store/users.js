import { isNumber } from 'lodash';
import Vue from 'vue';

export default {
    namespaced: true,
    state(){
        return {
            users: {},
        }
    },
    
    mutations: {
        user(state, user){
            Vue.set(state.users, user.id, user);
        },
        
        users(state, users){
            console.assert(Array.isArray(users), "配列以外許可されていません");
            if(Array.isArray(users)){
                let newObj = {
                    ...state.users
                };
                for(let i = 0; i < users.length; i ++){
                    newObj[String(users[i].id)] = users[i];
                }
                state.users = newObj;
            }

        }
    },

    getters: {
        get: (state)=>(id)=>{
            let user = state.users[id];
            console.assert(Boolean(user), "ユーザーの状態が無効です");

            return user;
        },
        getByUserIds: (state)=>(userIds)=>{
            console.assert(Array.isArray(userIds), "配列しか許可されていません");
            let mapped =  userIds.map((id)=>{
                console.assert(isNumber(id), "数値では有りません");
                let u = state.users[id];
                return u;
            });  
            return mapped;
        },
        token(state, getters, rootState){
            return rootState.token;
        }
    },
    actions: {
        follow({ dispatch, commit},user){
            dispatch('follow', user, { root: true })
                .then((res)=>{
                    commit('user', res);
                    
                })
                .catch((e)=>{
                    console.log(e);
                });
        },
        unfollow({ dispatch, commit}, user){
            dispatch('unfollow', user, { root: true })
                .then((res)=>{
                    commit('user', res);
                })
                .catch((e)=>{
                    console.log(e);
                })
        }

    }
}
