<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <timeline-component id="timeline-view" :notes="notes" :title="title" />
                <button class="btn btn-link btn-lg btn-block" @click="loadNext" v-bind:disabled="isLoading">
                    <span v-if="!isLoading">読み込む</span>
                    <span v-if="isLoading">読み込み中</span>
                </button>
            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios';
import TimelineComponent from '../components/TimelineComponent.vue';

export default {
    components: {
        'timeline-component': TimelineComponent
    },
    data() {
        return {
            notes: [],
            title: "ホームタイムライン",
            isLoading: false,
            nextPage: 1
        }
    },
    mounted(){
        this.loadInitTimeline();
    },
    created(){

    },
    destroyed(){

    },
    methods: {
        loadInitTimeline(){
            let token = this.$store.state.token;
            this.nextPage = 1;
            this.notes = [];
            axios.get(
                '/api/notes', 
                {
                    headers: { Authorization: `Bearer ${token}` }
                }
            ).then((page)=>{
                console.log(JSON.stringify(page.data.data));
                this.notes = page.data.data;
                this.isLoading = false;
                this.nextPage = page.data.current_page + 1;
            }).catch((e)=>{
                console.log(e);
                this.isLoading = false;
            })
        },

        loadNext(){
            let token = this.$store.state.token;
            if(this.isLoading){
                return;
            }
            this.isLoading = true;
            axios.get(
                '/api/notes',
                {
                    headers: { Authorization: `Bearer ${token}`},
                    params: { page: this.nextPage }
                }
            ).then((res)=>{
                
                if(res.data.data.length){
                    console.log(`現在ページ:${res.data.current_page}`)
                    this.notes.push(...res.data.data);
                    this.nextPage = res.data.current_page + 1;
                    this.isLoading = false;
                }
            }).catch((e)=>{
                console.log(e);
                this.isLoading = false;
            })

        },
        infiniteListener(){
            console.log(`読み込みを開始します nextPage:${this.nextPage}`);
            this.loadNext();
        }
    }

}
</script>