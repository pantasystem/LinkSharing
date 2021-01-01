<template>
    <b-modal v-model="isShow">
        <form @submit="submitListener">
            <div>
                <b-form-input
                :value="url"
                @input="inputUrl"
                placeholder="共有URL"
                class="mb-2"
                />
            </div>
            <b-form-textarea

                :required="true"
                placeholder="本文"
                v-model="text"
            />

            <div class="row mt-2 contaienr ml-3 mr-3">
                <b-form-checkbox
                    v-for="tag in tags" :key="tag.id" v-model="tag.select"
                    class="m-1"
                    :checked="tag.select"
                >
                    {{tag.name}}
                </b-form-checkbox>
                    
            </div>
            <div class="row mt-2 container">
                
                
                <b-form-input
                    class="col-7 mr-1"
                    placeholder="タグ名"
                    v-model="tag"
                />
                <b-button variant="primary" class="col-3" @click="addTag" :disabled="!checkTagName">タグを追加</b-button>
            </div>
            
        </form>
        <template #modal-footer>
            <b-button variant="primary" :disabled="!validation" @click="create">投稿</b-button>
        </template>
    </b-modal>
</template>

<script>
import { formatError } from '../errorutil';
import axios from 'axios';

export default {
    data(){
        return {
            url: '',
            text: '',
            tag: '',
            tags: [],
            errors: {},
            isShow: false,
            currentTagId: 1,
        }
    },
    computed:{
        checkTagName(){
            return !this.tags.some((t)=> t.name == this.tag) && this.tag.length >= 2 && this.tag.length <= 15;
        },
        
        validation(){
            return this.url.length && this.text.length >= 3 && this.text.length <= 200;
        }
    },

    methods: {
        addTag(){
            if(!this.checkTagName){

                return;
            }
            let newTag = this.generateTag(this.tag);
            this.tags.push(newTag);
            this.tag = '';
        },
        
        submitListener(){
            this.create();
        },
        inputUrl(e){
            this.url = e;
            this.fetchSummary();
        },
        create(){
            let note = {
                url: this.url,
                text: this.text,
                tags: this.tags.filter((tag)=> tag.select).map((tag)=>
                    tag.name
                )
            };
            this.$store.dispatch('timeline/createNote', note)
                .then((res)=>{
                    console.log(`作成成功:${res.data}`);
                    this.submit(res.data);
                    this.errors = {};
                    this.initForm();
                })
                .catch((e)=>{
                    this.errors = formatError(e);
                });

        },
        okListener(e){
            console.log("作成しようとしています");
            this.tryCreate();
            e.preventDefault();
        },
        submit(note){
            console.log(`作成されたnote: ${JSON.stringify(note)}`);
            
            this.isShow = false;
        },
        show(){
            console.log('on show');
            this.isShow = true;
        },

        initForm(){
            this.text = '';
            this.url = '';
            this.tag = '';
            this.tags = [];
        },
        containsTagName(name){
            this.tags.some((t)=> t.name == name);
        },
        pushTags(words){
            words.filter((word)=>{
                return !this.containsTagName(word) && word.length >= 2 && word.length <= 15;
            }).forEach((word)=>{
                this.tags.push(this.generateTag(word, false));
            });
        },
        fetchSummary(){
            axios.post('/api/summaries/fetch',{
                url: this.url
            }).catch((e)=>{
                console.log(e);
            }).then((res)=>{
                let words = res.data.aggregate_words;
                this.pushTags(words);
            });
        },
        generateTag(word, select = true){
            let tag = {
                id: this.nextTagId(),
                name: word,
                select: select
            };
            console.log(tag);
            return tag;
        },
        nextTagId(){
            return this.currentTagId++;
        }
    }
}
</script>