<template>
    <div>
        <advanced-search-form
            @input="input"
            :conditions="conditions"
            @addCondition="addCondition"

        />
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
            let strConditions = this.conditions;
            let conditions = [];
            let exp = /[\t\s\S]+/
            for(str in strConditions){
                let orConditions = str.split(/[\t\s\S]+/).filter((str)=>{
                    return !str.match(exp);
                });
                conditions.push(orConditions);
            }
            console.log(JSON.parse(conditions));
            return conditions;

        },
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
        },
        input(event){
            this.conditions = this.conditions.map((c)=>{
                if(c.id == event.id){
                    c.condition = event.text;
                    return c;
                }
                return c;
            });
        },
        addCondition(){
            this.conditions.push({
                id: this.conditionKey + 1,
                condition: ''
            });
            this.conditionKey += 1;
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