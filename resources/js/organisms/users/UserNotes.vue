<template>
    <notes-component 
        :notes="notes" 
        :isLoading="isLoading"
        @loadNext="loadNext"
        title="投稿"
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
            notes: [],
            isLoading: false,
            currentPage: 0
        };
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
                this.notes.push(...res.data.data);
                this.currentPage = res.data.current_page;
            })
            .catch((e)=>{
                console.log(e);
            })
            .finally(()=>{
                this.isLoading = false;
            })
        }
    },
    created(){
        this.notes = [];
        this.isLoading = false;
        this.loadNext();
    }
}
</script>