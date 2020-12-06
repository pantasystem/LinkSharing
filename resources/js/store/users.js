import { isNumber } from 'lodash';
import axios from 'axios';
import Vue from 'vue';

export default {
    namespaced: false,
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
            let users = {
                ...state.users
            };
            let user = users[id];
            return user;
            if(user){
                console.log('getters: get:' + user);
                return user;
            }else{
                console.warn("ユーザーの状態が無効です:" + user);
                return null;
            }

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
        },
        getAll(state){
            return state.users;
        }
    },
    actions: {
        fetchUser({commit, state, rootState}, userId){
            if(state.users[userId]){
                console.log("既に存在しています。")
                return;
            }
            axios.get(
                `/api/users/${userId}`,
                {
                    headers: { Authorization: `Bearer ${rootState.token }` }
                    
                }
            ).then((res)=>{
                console.log(state.users);
                console.log('fetchedUser:' + JSON.stringify(res.data));
                commit('user', res.data);
                console.log(state.users);

            }).catch((e)=>{
                console.log(e);
            });
        }
    }
}
