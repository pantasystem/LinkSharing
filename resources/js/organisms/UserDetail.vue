<template>
    <div class="card">
        <div class="card-header">
            <div v-if="user">
                {{ user.user_name }}
            </div>
        </div>
        <div class="card-body">
            <span>
                {{user}}

            </span>
            {{ user }}

            <user-profile 
                :user="user" :isMine="isMe"  v-if="user" v-on:follow="follow" v-on:unfollow="unfollow" />
            <router-view></router-view>

        </div>

    </div>
</template>
<script>
import UserProfileComponent from './../components/UserProfileComponent';
import axios from 'axios';

export default {
    components : {
        'user-profile': UserProfileComponent
    },
    props: {
        userId: {
            required: true,

        }
    },
    
    data(){
        return {
            _userId: undefined,
        }
    },
    watch:{
        allUsers(){
            this.changed();
        },
        
    },

    beforeRouteUpdate(to, from, next){
        console.log(`遷移しようとしている:${to.params.userId}`);
        this.loadUser(to.params.userId);
        next();
    },

    computed: {
        isMe(){
            let me = this.$store.state.user;
            
            return me && this.user.id == this.$store.state.user.id;
        },
        user(){
            let u = this.$store.state.users.users;
            let b = {
                ...u
            };
            //if(this._userId)
            console.log(b + "kensyoutyuuだぽよ");
            
            if(this._userId === undefined){
                return "undefinedだぽよ";
            }else{
                //return b[this._userId];
                //return "hogeeeeeeeeeeee";
                let c = b[this._userId];
                //return "hogeeeeeeeeeeeeeeeeeee" + c + this._userId;
                return c;
            }
        },

        /*user(){
            let uId = this._userId
            //let u = this.$store.getters['getByUserIds']([this.uId]);
            console.log(u);
            if(u.length){
                console.log("user() 無効な値が返ってきた");
                return null; 
            }
            let aUser = u[0];
            console.log("user() 正常値");
            console.log(aUser);
            return aUser;
        },*/
        

        allUsers(){
            return this.$store.getters['getAll'];
        }
    },
    methods: {
        getUser(){
            return this.$store.users.users[this._userId];
        },
        loadUser(userId = this.userId){
            this._userId = userId;
            this.$store.dispatch('fetchUser', userId);
            
        },
        follow(){
            this.$store.dispatch('follow', this.getUser())
                .then((user)=>{
                    //this.user = user;
                })
                .catch((e)=>{
                    console.log(e);
                });
        },
        unfollow(){
            this.$store.dispatch('unfollow', this.getUser())
                .then((user)=>{
                    //this.user = user;
                })
                .catch((e)=>{
                    console.log(e);
                });
        },
        getHeader(){
            return { Authorization: `Bearer ${this.$store.state.token }` };
        },
        changed(){
            console.log("変更!!!!!!!");
            let u  = this.$store.state.users[this.userId];
            if(u){
                this.user = u;
                console.log(this.user);

            }
            console.log(this.user);
        }
    },
    mounted(){
        this.loadUser();
    }
}
</script>
<style scoped>
span{
    color: red;
}
</style>