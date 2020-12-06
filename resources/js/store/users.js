import axios from 'axios';
import { isNumber } from 'lodash';

export default {
    namespaced: true,
    state(){
        return {
            users: {},
        }
    },
    
    mutations: {
        user(state, user){
            this.$set(state.users, String(user.id), user);
        },
        
        users(state, users){
            console.log("usersが呼び出された");
            console.log(users);
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
        follow(user){
            this.$store.dispatch('follow', user)
                .then((res)=>{
                    this.users = this.users.map((u)=>{
                        if(res.id == u.id){
                            return res;
                        }
                        return u;
                    })
                })
                .catch((e)=>{
                    console.log(e);
                });
        },
        unfollow(user){
            this.$store.dispatch('unfollow', user)
                .then((res)=>{
                    this.users = this.users.map((u)=>{
                        if(res.id == u.id){
                            return res;
                        }
                        return u;
                    });
                })
                .catch((e)=>{
                    console.log(e);
                })
        }

    }
}
