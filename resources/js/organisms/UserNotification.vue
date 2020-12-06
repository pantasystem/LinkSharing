<template>
    <notifications-component 
        :isLoading="notification.isLoading" 
        @loadNext="loadNextNotifications" 
        :notifications="notifications" >
    </notifications-component>
</template>
<script>
import axios from 'axios';
import NotesComponent from '../components/NotesComponent.vue';
import UserProfileComponent from '../components/UserProfileComponent.vue';
import LoadButton from '../atoms/LoadButton.vue';

import NotificationsComponent from '../components/NotificationsComponent.vue';

import { mapState, mapActions } from 'vuex';
export default {
    components: {
        'notes-component': NotesComponent,
        'user-profile': UserProfileComponent,
        'load-button': LoadButton,
        'notifications-component': NotificationsComponent
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
        },
        notifications(){
            console.log(this.$store);
            return this.$store.getters['notification/getNotifications'];
        }
    },
    
    methods: {
        loadInitTimeline(){
            this.$store.dispatch('timeline/initTimeline');
        },

        loadNext(){
            this.$store.dispatch('timeline/loadNext');

        },
        infiniteListener(){
            console.log(`読み込みを開始します nextPage:${this.nextPage}`);
            this.loadNext();
        },
        loadNextNotifications(){
            console.log("通知を読み込もうとしている");
            console.log(this.$store);
            this.$store.dispatch('notification/loadNext');
        }
    }
}
</script>