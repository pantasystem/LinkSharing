<template>
    <div class="row mt-2 mb-2">
        <div class="col-2 wrapper">
            <avatar-icon :user="user" />
        </div>
        <div class="col-10 container row">
            <div class="col-md-7">
                <router-link :to="{ name: 'user_notes', params: { userId: user.id }}">

                    <h4>{{ user.user_name }}</h4>
                </router-link>
            </div>
            <div class="col-md-5" v-if="me && user && me.id != user.id">
                <follow-button v-on:follow="follow" v-on:unfollow="unfollow" :user="user" />
            </div>
        </div>
    </div>
</template>
<script>
import AvatarIcon from '../atoms/AvatarIcon.vue';
import FollowButton from '../atoms/FollowButton.vue';

export default {

    props: {
        user: {
            type: Object,
            required: true
        },
        me: {
            type: Object
        }
    },
    components: {
        'avatar-icon': AvatarIcon,
        'follow-button': FollowButton
    },
    methods: {
        follow(user){
            this.$emit('follow', user);
        },
        unfollow(user){
            this.$emit('unfollow', user);
        }
    }
}
</script>