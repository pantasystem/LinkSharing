<template>
    <div class="card">
        <div class="card-header">
            <div v-if="user">
                {{ user.user_name }}
            </div>
        </div>
        <div class="card-body">
            

            <user-profile 
                :user="user" :isMine="isMe"  v-if="user" v-on:follow="follow" v-on:unfollow="unfollow" >
                <div>
                    <tag-list :tags="user.using_tag_counts" />
                </div>
            </user-profile>
            <router-view></router-view>

        </div>

    </div>
</template>
<script>
import UserProfileComponent from './../components/UserProfileComponent';
import TagList from '../components/TagsComponent';
import axios from 'axios';

export default {
    components : {
        'user-profile': UserProfileComponent,
        TagList
    },
    props: {
        userId: {
            required: true,

        }
    },
    
    data(){
        return {
            uId: null,
        }
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
            let uId = parseInt(this.uId);
            let u = this.$store.getters['get'](uId);
            return u;
        },

    },
    methods: {
        getUser(){
            return this.$store.state.users.users[this.uId];
        },
        loadUser(userId = this.userId){
            this.uId = userId;
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
        /*changed(){
            console.log("変更!!!!!!!");
            let u  = this.$store.state.users[this.userId];
            if(u){
                this.user = u;
                console.log(this.user);

            }
            console.log(this.user);
        }*/
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