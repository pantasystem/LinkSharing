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
                        <b-form-checkbox v-for="tag in tags" :key="tag.name" 
                            :checked="selected.some((t)=> t.name == tag.name)"
                            @input="changed(tag)"
                        >
                            {{ tag.name}}
                        </b-form-checkbox>

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
                    <input v-for="tag in selected" :key="tag.name" 
                        type="checkbox"
                        :checked="selected.some((t)=> t.name == tag.name)"

                        @input="changed(tag)"
                        value="hoge"

                    />
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
        changed(tag) {
            if(this.selected.some((t)=> t.name == tag.name)){
                this.unselect(tag);
            }else{
                this.select(tag);
            }
        },
        select(tag) {
            console.log(tag);
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