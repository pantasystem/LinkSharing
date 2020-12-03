<template>
    <div class="card">
        <div class="card-header">
            <div v-if="user">
                {{ user.user_name }}
            </div>
        </div>
        <div class="card-body">
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
            user: null
        }
    },

    mounted(){
        this.loadUser();
    },
    beforeRouteUpdate(to, from, next){
        this.loadUser(to.params.userId);
        next();
    },

    computed: {
        isMe(){
            let me = this.$store.state.user;
            
            return me && this.user.id == this.$store.state.user.id;
        }
    },
    methods: {
        loadUser(userId = this.userId){
            axios.get(
                `/api/users/${userId}`,
                {
                    headers: this.getHeader(),
                    
                }
            ).then((res)=>{
                this.user = res.data;
            }).catch((e)=>{
                console.log(e);
            });
        },
        follow(){
            this.$store.dispatch('follow', this.user)
                .then((user)=>{
                    this.user = user;
                })
                .catch((e)=>{
                    console.log(e);
                });
        },
        unfollow(){
            this.$store.dispatch('unfollow', this.user)
                .then((user)=>{
                    this.user = user;
                })
                .catch((e)=>{
                    console.log(e);
                });
        },
        getHeader(){
            return { Authorization: `Bearer ${this.$store.state.token }` };
        }
    }
}
</script>