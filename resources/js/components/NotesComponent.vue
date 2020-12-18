<template>        
<div>        
    <div class="card">
        <div class="card-header">{{ title }}</div>
        <transition-group name="note-list" tag="div" class="card-body">
                <note-component v-for="note in notes" :key="note.id" :note="note" @favorite="favorite" @unfavorite="unfavorite"/>

        </transition-group>
    </div>
    <load-button :isLoading="isLoading" v-on:load="loadNext"/>
</div>
    
</template>
<script>
import NoteComponent from './NoteComponent.vue';
import LoadButton from '../atoms/LoadButton.vue';

export default {
    components: {
        'note-component': NoteComponent,
        'load-button': LoadButton
    },
    props: {
        notes: {
            type: Array,
            required: true
        },
        title: {
            type: String,
            required: true
        },
        isLoading: {
            type: Boolean,
            required: true
        }
    },
    methods: {
        loadNext(){
            this.$emit('loadNext');
        },
        favorite(noteId){
            this.$emit('favorite', noteId);
        },
        unfavorite(noteId){
            this.$emit('unfavorite', noteId);
        }
    }
}
</script>
<style scoped>
.note-list-move {
  transition: transform 0.5s;
}
</style>