<template>
    <div class="card">
        <div class="card-header">{{ title }}</div>
        <div class="card-body">
            <note-component v-for="note in notes" :key="note.id" :note="note" />

        </div>
        
    </div>
    
</template>
<script>
import NoteComponent from './NoteComponent.vue';

export default {
    components: {
        'note-component': NoteComponent
    },
    props: {
        notes: {
            type: Array,
            required: true
        },
        title: {
            type: String,
            required: true
        }
    }
}
</script>