<template>
    <notes-component 
        :notes="notes" 
        :isLoading="isLoading"
        @loadNext="loadNext"
        title="投稿"
        @favorite="favorite"
        @unfavorite="unfavorite"
    />
</template>
<script>
import axios from 'axios';

import NotesComponent from '../../components/NotesComponent.vue';

export default {
    components: {
        'notes-component': NotesComponent
    },
    props: {
        userId: {
            required: true
        }
    },
    data(){
        return {
            isLoading: false,
            currentPage: 0,
            noteIds: []
        };
    },
    computed: {
        notes(){
            return this.$store.getters['getNotesByIds'](this.noteIds);
        }
    },
    methods: {
        loadNext(){
            if(this.isLoading){
                return;
            }
            this.isLoading = true;
            axios.get(
                `/api/users/${this.userId}/notes`,
                {
                    headers: { Authorization: `Bearer ${this.$store.state.token}` },
                    params: {
                        page: this.currentPage + 1
                    }
                }
            ).then((res)=>{
                this.$store.commit('setNotes', res.data.data);
                this.noteIds.push(...res.data.data.map((note)=>note.id));
                this.currentPage = res.data.current_page;
            })
            .catch((e)=>{
                console.log(e);
            })
            .finally(()=>{
                this.isLoading = false;
            })
        },

        favorite(noteId){
            this.$store.dispatch('favorite', noteId);
        },
        unfavorite(noteId){
            this.$store.dispatch('unfavorite', noteId);
        }
    },
    created(){
        this.noteIds = [];
        this.isLoading = false;
        this.loadNext();
    },
    
}
</script>