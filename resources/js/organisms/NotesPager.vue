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
import NotesComponent from '../components/NotesComponent';
export default {
    props: {
        title: {
            required: true,
            type: String
        },
        requestBuilder: {
            required: true,
            type: Function
        }
    },
    components: {
        'notes-component': NotesComponent
    },
    data(){
        return {
            noteIds: [],
            currentPage: 0,
            isLoading: false
        }
    },

    computed: {
        notes(){
            console.assert(Array.isArray(this.noteIds), "NoteIdsは配列ではありません");
            return this.$store.getters['getNotesByIds'](this.noteIds);
        }
    },

    methods: {
        loadNext(){
            if(this.isLoading){
                return;
            }
            this.isLoading = true;
            this.requestBuilder(this.currentPage + 1)
                .then((res)=>{
                    let page = res.data;
                    let notes = page.data;
                    console.assert(Array.isArray(notes), "notesは配列ではありません。");
                    let ids = notes.map((note)=>note.id)
                    this.$store.commit('setNotes', notes);
                    this.noteIds.push(...ids);
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
    }
    
}
</script>