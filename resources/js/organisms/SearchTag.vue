<template>
    <div class="row">
        <!-- 検索候補 -->
        <div class="col-md-6">
            <div class="card">

                <div class="card-header">
                    候補タグ
                </div>
                <div class="card-body">
                    <b-form-input @input="search" hint="タグを検索する"/>
                    <div>
                        {{ this.tags}} 
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
        select(tag) {
            let index = this.selected.indexOf(tag);
            if(index < 0){
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