<template>
    <notes-component 
        id="timeline-view" 
        :notes="timeline.notes" 
        :title="title" 
        v-on:loadNext="loadNext"
        :isLoading="isLoading" />
</template>
<script>
import axios from 'axios';
import NotesComponent from '../components/NotesComponent.vue';
import LoadButton from '../atoms/LoadButton.vue';


import { mapState, mapActions } from 'vuex';

export default {
        components: {
        'notes-component': NotesComponent,
        'load-button': LoadButton,
    },
    data() {
        return {
            title: "ホームタイムライン"
        }
    },
    computed: {
        
        timeline(){
            return this.$store.state.timeline;
        },
        isLoading(){
            return this.$store.state.timeline.isLoading;
        },
        
    },
    
    methods: {
        loadInitTimeline(){
            this.$store.dispatch('timeline/initTimeline');
        },

        loadNext(){
            this.$store.dispatch('timeline/loadNext');

        },
        
    }
}
</script>