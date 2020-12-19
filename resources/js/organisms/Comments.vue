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
            <comment-form @submit="submit"/>
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
        }
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
            isLoading: false
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
            axios.get(`/api/notes/${this.noteId}/comments/${this.commentId}`,
                {
                    headers: this.createHeaders(),
                }
            ).then((res)=>{
                this.comment = res.data;
            })
            .catch((e)=>{
                console.log(e);
            });
        },

        submit(text){

        },

        loadNext(){
            if(this.isLoading){
                return;
            }
            this.isLoading = true;
            let headers = this.createHeaders();
            let endpoint;
            if(this.commentId !== undefined && this.commentId !== null){
                endpoint = `/api/comments/${this.commentId}`;
            }else{
                endpoint = `/api/notes/${this.noteId}/comments`;
            }

            axios.get(endpoint,{
                params: { page: this.currentPage + 1},
                headers: headers
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

        createHeaders(){
            return { Authorization: `Bearer ${this.$store.state.token}`};
        }

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