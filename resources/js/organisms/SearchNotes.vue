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

        />
    </div>
</template>

<script>
import Notes from './../components/NotesComponent';
import AdvancedSearchForm from './../molecules/AdvancedSearchForm.vue';

import axios from 'axios';

export default {
    
    components: {
        'notes-view': Notes,
        'advanced-search-form': AdvancedSearchForm
    },

    data(){
        return {
            notes: [],
            isLoading: false,
            conditionKey: 0,
            conditions: [{ condition: this.name, id: 0}],
            currentPage: 0
        }
    },

    methods: {
        /*getConditions(){
            let srcCondition = this.conditions;
            console.log(srcCondition);
            let searchCondition = [];
            let exp = /[\t\s\S]+/
            for(let i = 0; i < srcCondition.length; i ++){
                console.log(srcCondition[i]);
                let strCondition = srcCondition[i].condition;
                const regex = /\s+/;
                console.log(strCondition);
                let orConditions = strCondition.split(regex);
                searchCondition.push(orConditions);
            }
            
            console.log(searchCondition);
            return searchCondition;

        },*/

        getConditions(){
            let srcConditions = this.conditions;

            console.assert(Array.isArray(srcConditions), "エラー：配列ではありません");

            let searchConditions = srcConditions.map((conditionObj)=> conditionObj.condition)
                .map((condition)=> condition.split(/\s/));

            console.assert(Array.isArray(searchConditions), "できたオブジェクトはなんと配列ではありませんでした！！");
            return searchConditions;
        },
        loadNext(){
            console.log(this.conditions);
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
        init(){
            this.isLoading = false;
            this.notes = [];
            this.currentPage = 0;
            this.loadNext();
        },
        
        initByCondition(condition){
            console.assert(Array.isArray(condition), "initByCondition:引数は配列を要求している");
            this.conditions = [];
            this.conditionKey += 1;
            for(let i = 0; i < condition.length; i ++){
                this.addCondition(condition[i]);

            }
            this.init();
        },
        /*input(event){
            this.conditions = this.conditions.map((c)=>{
                if(c.id == event.id){
                    c.condition = event.text;
                    return c;
                }
                return c;
            });
        },*/
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
            this.$router.push(req).catch((e)=>{});
            

        }
    },

    /*created(){
        console.log("created");
        console.log(this.$router.query.condition);
        this.initByCondition(this.$router.query.condition);
        this.loadNext();
        
    },*/
    
    beforeRouteUpdate(to, from, next){
        console.log("遷移しようとしている");
        console.log(to);
        if(to.query.condition){
            console.log("query + ");
            console.log(to.query);
            console.log(" + query end");
            this.initByCondition(to.query.condition);
        }
        next();
    },
}
</script>