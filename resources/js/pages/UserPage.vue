<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <user-profile :user="user" :isMine="isMe"  v-if="user" v-on:follow="follow" v-on:unfollow="unfollow" />
            </div>
            <div class="col-md-8">
                <router-view></router-view>
            </div>
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

    computed: {
        isMe(){
            let me = this.$store.state.user;
            
            return me && this.user.id == this.$store.state.user.id;
        }
    },
    methods: {
        loadUser(){
            axios.get(
                `/api/users/${this.userId}`,
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