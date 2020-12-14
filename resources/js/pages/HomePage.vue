<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-12">
                <router-view />
            </div>
            <div class="col-md-4 d-none d-lg-block">
                <login-form v-if="!user" />
                <user-profile v-if="user" :user="user" :isMine="true" />
                <user-notification v-if="user" class="mt-2"/>
            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios';
import UserProfileComponent from '../components/UserProfileComponent.vue';
import UserNotification from '../organisms/UserNotification.vue';
import LoginForm from '../organisms/LoginForm';

import { mapState, mapActions } from 'vuex';

export default {
    components: {
        'user-profile': UserProfileComponent,
        'user-notification': UserNotification,
        'login-form': LoginForm
    },
    data() {
        return {
            title: "ホームタイムライン"
        }
    },
    computed: {
        ...mapState([
            'user'
        ]),
       
        timeline(){
            return this.$store.state.timeline;
        },
        isLoading(){
            return this.$store.state.timeline.isLoading;
        },
        notification(){
            return this.$store.state.notification;
        }
    },
    
  

}
</script>