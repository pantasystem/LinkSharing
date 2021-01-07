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
                    <a-comment :comment="comment"/>
                </div>
            </div>
            <b-alert show dismissible v-if="submitted.success" variant="success">
                {{ submitted.success }}
            </b-alert>
            <b-alert show dismissible v-else-if="submitted.error" variant="danger">
                {{ submitted.error }}
            </b-alert>
            <comment-form @submit="submit" :errors="submitted.errors"/>
            <div v-for="aComment in comments" :key="aComment.id">
                <a-comment :comment="aComment" />
            </div>
        </div>
    </div>
</template>
<script>
import Comment from '../molecules/Comment';
import Note from '../components/NoteComponent';
import CommentForm from '../molecules/CommentForm.vue';
import axios from 'axios';
import LoadButton from '../atoms/LoadButton';

export default {
    props:{
        noteId: {
            required: false,
            type: Number
        },
        commentId: {
            required: false,
            type: Number,
            default: null
        },
    },
    components: {
        'a-comment': Comment,
        'a-note': Note,
        'comment-form': CommentForm,
        'load-button': LoadButton
    },
    computed: {
        note(){
            return this.$store.getters['getNoteById'](this.noteId);
        },
        
    },
    
    data(){
        return {
            comment: null,
            comments: [],
            currentPage: 0,
            isLoading: false,
            submitted: {
                success: null,
                error: null,
                errors : null
            }
        }
    },
    created(){
        this.$store.dispatch('fetchNote', this.noteId);
        this.init();
    },

    methods: {
        favorite(noteId){
            this.$store.dispatch('favorite', noteId);
        },

        unfavorite(noteId){
            this.$store.dispatch('unfavorite', noteId);
        },
        fetchReplyToComment(){
            if(this.commentId === undefined || this.commentId === null){
                return;
            }
            axios.get(`/api/notes/${this.noteId}/comments/${this.commentId}`
            ).then((res)=>{
                this.comment = res.data;
            })
            .catch((e)=>{
                console.log(e);
            });
        },

        submit(text){
            let endpoint = `/api/notes/${this.noteId}/comments`;
            if(this.commentId !== undefined && this.commentId !== null){
                endpoint += `/${this.commentId}`;
            }
            axios.post(endpoint, { text: text })
            .then((res)=>{
                this.comments.push(res.data);
                this.submitted.success = '返信に成功しました。';
                this.submitted.error = '';
                this.submitted.errors = '';
            }).catch((e)=>{
                this.submitted.error = '返信に失敗しました。';
                this.submitted.success = '';
                this.submitted.errors = e.response.data.errors;
                
            })
        },

        loadNext(){
            if(this.isLoading){
                return;
            }
            this.isLoading = true;
            let endpoint;
            if(this.commentId !== undefined && this.commentId !== null){
                endpoint = `/api/comments/${this.commentId}`;
            }else{
                endpoint = `/api/notes/${this.noteId}/comments`;
            }

            axios.get(endpoint,{
                params: { page: this.currentPage + 1},
            }).then((res)=>{
                if(res.data.data != null){
                    this.currentPage = res.data.current_page;
                    this.comments.push(...res.data.data);
                    console.log(this.comments);
                }
            }).finally(()=>{
                this.isLoading = false;

            });
        },
        init(){
            this.currentPage = 0;
            this.comments = [];
            this.comment = null;
            this.isLoading = false;
            this.loadNext();
            this.fetchReplyToComment();
        },


    },


    beforeRouteUpdate(to, from, next){
        if(to.params !== undefined){
            this.noteId = null;
            this.commentId = null;
            if(to.params.noteId){
                this.noteId = parseInt(to.params.noteId);
            }
            if(to.params.commentId){
                this.commentId = parseInt(to.params.commentId);

            }
        }
        
        this.init();
        next();
    }
    
    

    

}
</script>