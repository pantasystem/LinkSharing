<template>
    <div class="card">
        <div class="card-header">
            コメントなど
        </div>
        <div class="card-body">
            <div class="reply-to">
                <div v-if="note">
                    <a-note @favorite="favorite" @unfavorite="unfavorite" :note="note"/>
                </div>
                <div v-else-if="comment">
                    <a-comment :coment="comment"/>
                </div>
            </div>
            <comment-form @submit="submit"/>
            <div v-for="comment in comments" :key="comment.id">
                <a-comment :comment="comment" />
            </div>
        </div>
    </div>
</template>
<script>
import Comment from '../molecules/Comment';
import Note from '../components/NoteComponent';
import CommentForm from '../molecules/CommentForm.vue';
import axios from 'axios';

export default {
    props:{
        noteId: {
            required: true,
            type: Number
        },
        commentId: {
            required: false,
            type: Number,
            default: null
        }
    },
    components: {
        'a-comment': Comment,
        'a-note': Note,
        'comment-form': CommentForm
    },
    computed: {
        note(){
            return this.$store.getters['getNoteById'](this.noteId);
        },
        
    },
    
    data(){
        return {
            comment: null
        }
    },
    created(){
        this.$store.dispatch('fetchNote', this.noteId);
    },
    
    favorite(noteId){
        this.$store.dispatch('favorite', noteId);
    },

    unfavorite(noteId){
        this.$store.dispatch('unfavorite', noteId);
    },
    fetchComments(){

    },

    submit(text){

    },

}
</script>