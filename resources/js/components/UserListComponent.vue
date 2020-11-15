<template>
<div>
    <div class="card">
        <div class="card-header" v-if="title">
            {{ title }}
        </div>
        <div class="card-body">
            <div v-for="user in users" :key="user.id">
                <slot>
                    <div class="row mt-2 mb-2">
                        <div class="col-2 wrapper">
                            <avatar-icon :avatar_icon="user.avatar_icon" />
                        </div>
                        <div class="col-7">
                            <router-link :to="{ name: 'user_detail', params: { userId: user.id }}">

                                <h4>{{ user.user_name }}</h4>
                            </router-link>
                        </div>
                        <div class="col-3" v-if="me && user && me.id != user.id">
                            <follow-button v-on:follow="follow" v-on:unfollow="unfollow" :user="user" />
                        </div>
                    </div>
                </slot>
            </div>
        </div>
    </div>
    <load-button :isLoading="isLoading" v-on:load="loadNext" />
</div>
</template>
<script>
import FollowButton from './FollowButtonComponent';
import AvatarIcon from './AvatarIconComponent';
import LoadButton from './LoadButtonComponent';


import { mapState } from 'vuex';
export default {
    props: {
        title: {
            required: false
        },
        load: {
            type: Function,
            required: true
        }
    },
    components: {
        'follow-button': FollowButton,
        'avatar-icon': AvatarIcon,
        'load-button': LoadButton,
    },
    data(){
        return {
            currentPage: 0,
            isLoading: false,
            users: []

        }
    },
    computed: {
        me(){
            return this.$store.state.user;
        }
    },
    methods: {
        loadNext(){
            if(this.isLoading){
                return;
            }
            
            this.load(this.currentPage + 1)
                .then((res)=>{
                    this.users.push(...res.data.data);
                    this.currentPage = res.data.current_page;
                    this.isLoading = false;
                })
                .catch((e)=>{
                    console.log(e);
                    this.isLoading = false;
                });
        },
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
                    console.log(res);
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
    },
    mounted(){
        this.loadNext();
    },

}
</script>