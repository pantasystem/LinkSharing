<template>
    <div>
        <div class="reply-to">
            <div v-if="note">
            </div>
            <div v-else>

            </div>
        </div>
        <div v-for="comment in comments" :key="comment.id">
            <div>

            </div>
            <div v-if="showCommentForms.includes(comment.id)">
                
            </div>
        </div>
    </div>
</template>
<script>
import Comment from '../molecules/Comment';
import Note from '../components/NoteComponent';
import CommentForm from '../molecules/CommentForm';

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
        'comment-form': CommentForm
    },
    computed: {
        note(){
            return this.$store.getters['getNoteById'](this.noteId);
        }
    },
    
    data(){
        return {
            replyTo: null,
            showCommentForms: []
        }
    },
    created(){
        this.$store.dispatch('fetchNote', this.noteId);
    }    
}
</script>