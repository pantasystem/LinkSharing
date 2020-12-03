<template>
    <div>
        <notes-view
            title="検索結果"
            :notes="notes"
            :isLoading="isLoading"
            @loadNext="loadNext"

        />
    </div>
</template>

<script>
import Notes from './../components/NotesComponent';
import axios from 'axios';

export default {
    props:{
        name: {
            required: false,
            default: ''
        }
    },
    components: {
        'notes-view': Notes
    },

    data(){
        return {
            notes: [],
            isLoading: false,
            conditions: [[this.name]],
            currentPage: 0
        }
    },
   

    methods: {
        loadNext(){
            if(this.isLoading){
                return;
            }
            this.isLoading = true;

            axios.post(
                '/api/notes/search-by-tag',
                {
                    'conditions': this.conditions
                },
                {
                    headers: { Authorization: `Bearer ${this.$store.state.token}` },
                    params: {
                        page: this.currentPage + 1
                    }
                }
            ).then((res)=>{
                if(this.isLoading){
                    this.currentPage = res.data.current_page;
                    this.notes.push(...res.data.data);
                }
                
            }).catch((e)=>{
                console.log(e);
            }).finally(()=>{
                this.isLoading = false;
            });
        },
        init(name){
            this.isLoading = false;
            this.notes = [];
            this.currentPage = 0;
            this.conditions = [[name]];
            this.loadNext();
        }
    },
    created(){
        this.loadNext();
        
    },
    beforeRouteUpdate(to, from, next){
        this.init(to.params.name);
        next();
    },
}
</script>