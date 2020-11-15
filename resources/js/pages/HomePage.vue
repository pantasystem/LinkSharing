<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <timeline-component id="timeline-view" :notes="timeline.notes" :title="title" />
                <load-button :isLoading="isLoading" v-on:load="loadNext"/>
            </div>
            <div class="col-md-4 d-none d-lg-block">
                <user-profile :user="user" :isMine="true" />
            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios';
import TimelineComponent from '../components/TimelineComponent.vue';
import UserProfileComponent from '../components/UserProfileComponent.vue';
import LoadButton from '../components/LoadButtonComponent.vue';

import { mapState, mapActions } from 'vuex';

export default {
    components: {
        'timeline-component': TimelineComponent,
        'user-profile': UserProfileComponent,
        'load-button': LoadButton,
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
        }
    },
    
    methods: {
        loadInitTimeline(){
            this.$store.dispatch('initTimeline');
        },

        loadNext(){
            this.$store.dispatch('loadNext');

        },
        infiniteListener(){
            console.log(`読み込みを開始します nextPage:${this.nextPage}`);
            this.loadNext();
        }
    }

}
</script>