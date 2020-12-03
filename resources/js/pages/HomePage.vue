<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <router-view />
            </div>
            <div class="col-md-4 d-none d-lg-block">
                <user-profile :user="user" :isMine="true" />
                <user-notification class="mt-2"/>
            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios';
import UserProfileComponent from '../components/UserProfileComponent.vue';
import UserNotification from '../organisms/UserNotification.vue';

import { mapState, mapActions } from 'vuex';

export default {
    components: {
        'user-profile': UserProfileComponent,
        'user-notification': UserNotification
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