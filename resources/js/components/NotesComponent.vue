<template>        
<div>        
    <div class="card">
        <div class="card-header">{{ title }}</div>
        <div class="card-body">
            <note-component v-for="note in notes" :key="note.id" :note="note" />

        </div>
        
    </div>
    <load-button :isLoading="isLoading" v-on:load="loadNext"/>
</div>
    
</template>
<script>
import NoteComponent from './NoteComponent.vue';
import LoadButton from '../components/LoadButtonComponent.vue';

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
        }
    }
}
</script>