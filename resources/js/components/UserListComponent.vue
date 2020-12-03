<template>
<div>
    <div class="card">
        <div class="card-header" v-if="title">
            {{ title }}
        </div>
        <div class="card-body">
            <div v-for="user in users" :key="user.id">
                <slot>
                    <followee-component :user="user" :me="me" @follow="follow" @unfollow="unfollow" />
                </slot>
            </div>
        </div>
    </div>
    <load-button :isLoading="isLoading" v-on:load="loadNext" />
</div>
</template>
<script>
import FollowButton from './FollowButtonComponent';
import AvatarIcon from '../atoms/AvatarIcon';
import LoadButton from '../atoms/LoadButton.vue';
import FolloweeComponent from './FolloweeComponent.vue';


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
        'followee-component': FolloweeComponent
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
            this.isLoading = true;
            
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