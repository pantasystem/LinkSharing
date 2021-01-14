<template>
    <div>
        <div class="d-flex mb-2">
            <b-form-input v-model="condition">

            </b-form-input>
            <b-button @click="search" class="text-nowrap">
                検索
            </b-button>
            
        </div>
        <notes-view
            title="検索結果"
            :notes="notes"
            :isLoading="isLoading"
            @loadNext="loadNext"
            @favorite="favorite"
            @unfavorite="unfavorite"

        />
    </div>
</template>

<script>
import Notes from './../components/NotesComponent';

import axios from 'axios';
import { mapGetters, mapActions } from 'vuex';
import queryString from 'query-string';

export default {
    
    components: {
        'notes-view': Notes,
    },

    data(){
        return {
            noteIds: [],
            isLoading: false,
            conditionKey: 0,
            currentPage: 0,
            condition: ''
        }
    },
    computed:{
        notes(){
            return this.$store.getters['getNotesByIds'](this.noteIds);
        }
    },

    methods: {
        
        
        loadNext(){
            console.log('リクエスト条件');
            if(this.isLoading){
                return;
            }
            this.isLoading = true;

            
            axios.post(
                '/api/notes/search-by-tag',
                {
                    'conditions': this.condition.split(/\s/),
                },
                {
                    params: {
                        page: this.currentPage + 1
                    }
                }
            ).then((res)=>{
                if(this.isLoading){
                    this.currentPage = res.data.current_page;
                    this.$store.commit('setNotes', res.data.data);
                    this.noteIds.push(...res.data.data.map((note)=>note.id));
                }
                
            }).catch((e)=>{
                console.log(e);
            }).finally(()=>{
                this.isLoading = false;
            });
        },
        init(){
            console.log(this.conditions);
            this.isLoading = false;
            this.noteIds.splice(0);
            this.currentPage = 0;
            this.loadNext();
        },
        
        
       
        
        search(){
            let searchCondition = this.condition.split('/\s/');
            let req = {
                name: 'searchByTag',
                query: {
                    condition: searchCondition
                }
            }

            console.log(req);
            this.$router.push(req).catch((e)=>{ console.log(e) });
            

        },
        ...mapActions(['favorite', 'unfavorite']),
    },

    /*created(){
        console.log("created");
        console.log(this.$router.query.condition);
        this.initByCondition(this.$router.query.condition);
        this.loadNext();
        
    },*/
    created(){
        let condition = queryString.parse(window.location.search).condition;
        if(Array.isArray(condition)){
            let str = '';
            for(let i = 0; i < condition.length; i ++){
                str += i == 0 ? condition[i] : ' ' + condition[i];
            }
            this.condition = str;
            

        }
        this.condition = condition;
        this.init();
        //this.condition = condition;
    },
    
    beforeRouteUpdate(to, from, next){
        console.log('push');
        console.log(to);
        //this.condition = to.query.condition;
        this.init();

        next();
    },
}
</script>