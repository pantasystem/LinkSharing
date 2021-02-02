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
            /*let users = {
                ...state.users
            };*/
            let user = state.users[id];
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
       
        getAll(state){
            return state.users;
        }
    },
    actions: {
        fetchUser({commit, state}, userId){
            if(state.users[userId]){
                console.log("既に存在しています。")
            }
            axios.get(
                `/api/users/${userId}`
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
