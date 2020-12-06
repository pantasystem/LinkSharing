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
import LoadButton from '../atoms/LoadButton.vue';
import AvatarIcon from '../atoms/AvatarIcon';
import FolloweeComponent from './FolloweeComponent.vue';
import FollowButton from'./../atoms/FollowButton';

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
            userIds: []

        }
    },
    computed: {
        me(){
            return this.$store.state.user;
        },
        users(){
            let f = this.$store.getters['users/getByUserIds'];
            let users = f(this.userIds);
            console.log('computed');
            console.log(this.$store.getters['users/getByUserIds']);
            console.log(users);
            return users;
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
                    console.log(res);
                    this.$store.commit('users/users', res.data.data);
                    let ids = res.data.data.map((user)=> user.id);
                    this.userIds.push(...ids);
                    this.currentPage = res.data.current_page;
                    this.isLoading = false;
                })
                .catch((e)=>{
                    console.log(e);
                })
                .finally(()=>{
                    this.isLoading = false;

                });
        },
        follow(user){
            console.log(this.$store);
            this.$store.dispatch('users/follow', user);
        },
        unfollow(user){
            this.$store.dispatch('users/unfollow', user);
            
        }
    },
    mounted(){
        console.log(this.$store.users);
        console.log(this.$store);
        console.log(this.$store.getters['users/token']);

        this.loadNext();
    },

}
</script>