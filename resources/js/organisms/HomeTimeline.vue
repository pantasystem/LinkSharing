<template>
    <notes-component 
        id="timeline-view" 
        :notes="notes" 
        :title="title" 
        v-on:loadNext="loadNext"
        :isLoading="isLoading"
        @favorite="favorite"
        @unfavorite="unfavorite"
         />
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
        notes(){
            return this.$store.getters['timeline/notes'];
        }
        
    },
    
    methods: {
        loadInitTimeline(){
            this.$store.dispatch('timeline/initTimeline');
        },

        loadNext(){
            this.$store.dispatch('timeline/loadNext');

        },
        favorite(noteId){
            this.$store.dispatch('favorite', noteId);
        },
        unfavorite(noteId){
            this.$store.dispatch('unfavorite', noteId);
        }
        
    }
}
</script>