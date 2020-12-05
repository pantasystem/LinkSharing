export default {
    namespaced: true,
    state(){
        return {
            users: {},
        }
    },
    
    mutations: {
        addUser(state, user){
            this.$set(state.users, user);
        },
        
        addAllUser(state, users){
            console.assert(Array.isArray(users), "配列以外許可されていません");
            if(Array.isArray(users)){
                for(let i = 0; i < users.length; i ++){
                    state.users[users[i].id] = users[i];
                }
            }

        }
    },

    getters: {
        get: (state)=>(id)=>{
            let user = state.users[id];
            console.assert(Boolean(user), "ユーザーの状態が無効です");

            return user;
        },
        getByUserIds(userIds){
            console.assert(Array.isArray(userIds), "配列しか許可されていません");
            return userIds.map((id)=> this.state.users[id]);
        }
    }
}
