<template>
    <div>
        <advanced-search-form
            :conditions="conditions"
            @addCondition="addCondition"

        />
        <b-button @click="search">検索</b-button>
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
import AdvancedSearchForm from './../molecules/AdvancedSearchForm.vue';

import axios from 'axios';
import { mapGetters, mapActions } from 'vuex';
import queryString from 'query-string';

export default {
    
    components: {
        'notes-view': Notes,
        'advanced-search-form': AdvancedSearchForm
    },

    data(){
        return {
            noteIds: [],
            isLoading: false,
            conditionKey: 0,
            conditions: [{ condition: this.name, id: 0}],
            currentPage: 0
        }
    },
    computed:{
        notes(){
            return this.$store.getters['getNotesByIds'](this.noteIds);
        }
    },

    methods: {
        
        getConditions(){
            let srcConditions = this.conditions;

            console.assert(Array.isArray(srcConditions), "エラー：配列ではありません");

            let searchConditions = srcConditions.map((conditionObj)=> conditionObj.condition)
                .map((condition)=> {console.log(condition); return condition.split(/\s/)});

            console.assert(Array.isArray(searchConditions), "できたオブジェクトはなんと配列ではありませんでした！！");
            return searchConditions;
        },
        loadNext(){
            console.log('リクエスト条件');
            console.log(this.getConditions());
            if(this.isLoading){
                return;
            }
            this.isLoading = true;

            axios.post(
                '/api/notes/search-by-tag',
                {
                    'conditions': this.getConditions()
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
        
        initByCondition(condition){
            this.conditions.splice(0);
            this.conditionKey += 1;

            if(!Array.isArray(condition)){
                this.addCondition(condition);
                this.init();

                return;
            }
            for(let i = 0; i < condition.length; i ++){
                this.addCondition(condition[i]);

            }
            this.init();
        },
       
        addCondition(str = ''){
            this.conditions.push({
                id: this.conditionKey + 1,
                condition: str
            });
            this.conditionKey += 1;
        },
        search(){
            let searchCondition = this.conditions.map((obj)=>obj.condition);
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
        let condition = queryString.parse(window.location.search);
        this.initByCondition(condition.condition);
    },
    
    beforeRouteUpdate(to, from, next){
        console.log('push');
        console.log(to);
        this.initByCondition(to.query.condition);

        next();
    },
}
</script>