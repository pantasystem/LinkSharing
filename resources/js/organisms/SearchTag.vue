<template>
    <div class="row">
        <!-- 検索候補 -->
        <div class="col-md-6">
            <div class="card">

                <div class="card-header">
                    候補タグ
                </div>
                <div class="card-body">
                    <b-form-input class="mb-2" @input="search" hint="タグを検索する"/>
                    <div v-if="isLoading" class="text-center">
                        <div class="spinner-border text-primary" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                    
                    <div v-else>
                        <div class="row">
                            <b-form-checkbox 
                                class="m-1"
                                v-for="tag in tags" :key="tag.name" 
                                :checked="selected.some((t)=> t.name == tag.name)"
                                @input="(e)=>changed(e, tag)"
                            >
                                    {{ tag.name}}
                            </b-form-checkbox>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 選択済みのタグ -->
        <div class="col-md-6">
            <div class="card"> 
                <div class="card-header">
                    選択済みタグ
                </div>
                <div class="card-body">
                    <div class="row">
                        <b-form-checkbox 
                            class="m-1"
                            v-for="tag in selected" :key="tag.name" 
                            :checked="selected.some((t)=> t.name == tag.name)"
                            @input="(e)=>changed(e, tag)"
                        >
                                {{ tag.name}}
                        </b-form-checkbox>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios';
export default {
    
    data() {
        return {
            tags: [],
            selected: [],
            isLoading: false,
            v: 0,
            form: {
                input: ''
            }
        }
    },

    methods: {
        input(e) {
            this.search(e.target.value);
        },
        search(word) {
            this.v ++;
            let v = this.v;
            this.isLoading = true;
            axios.get('/api/tags/', {
                params: {
                    'word': word
                }
            }).catch((e)=>{
                console.log(e);
            }).then((res)=>{
                this.tags = res.data;
            }).finally(()=>{
                if(v == this.v){
                    this.isLoading = false;
                }
            });
        },
        changed(e, tag) {
            let isAlreadySelected = this.selected.some((t)=> t.name == tag.name);

            if(isAlreadySelected == e){
                return;
            }
            if(isAlreadySelected){
                this.unselect(tag);
            }else{
                this.select(tag);
            }
            this.$emit('changed', this.selected);
        },
        select(tag) {
            if(!this.selected.some((e)=> tag.name == e.name)){
                this.selected.push(tag);
                this.$emit('selected', this.selected);
            }
        },
        unselect(tag) {
            this.selected = this.selected.filter((t)=>t.name != tag.name);
        }
    },
    created() {
        this.search();
    }
    
}
</script>