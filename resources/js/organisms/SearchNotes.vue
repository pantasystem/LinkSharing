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
    props:{
        name: {
            required: false,
            default: ''
        },
        search_condition: {
            required: false,
            default: null
        }
    },
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
        getConditions(){
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

        },
        loadNext(){
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
        initByName(name){
            this.conditionKey += 1;
            this.conditions = [];
            this.addCondition(name);
            this.init();
        },
        initByCondition(condition){
            this.conditionKey += 1;
            for(str in this.search_condition){
                this.addCondition(str);

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
            let searchCondition = this.getConditions();
            let req = {
                name: 'searchByTag',
                query: {
                    search_condition: searchCondition
                }
            }

            console.log(req);
            this.$router.push(req);
            

        }
    },
    created(){
        this.loadNext();
        
    },
    beforeRouteUpdate(to, from, next){
        console.log("遷移しようとしている");
        if(to.query.search_condition){
            this.initByCondition(to.params.search_condition);
        }else{
            this.initByName(to.query.name);
        }
        next();
    },
}
</script>