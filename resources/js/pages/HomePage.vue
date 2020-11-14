<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <timeline-component id="timeline-view" :notes="timeline.notes" :title="title" />
                <button class="btn btn-link btn-lg btn-block" @click="loadNext" v-bind:disabled="isLoading">
                    <span v-if="!isLoading">読み込む</span>
                    <span v-if="isLoading">読み込み中</span>
                </button>
            </div>
            <div class="col-md-4 d-none d-lg-block">
                <user-profile :user="user" :isMine="true" />
            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios';
import TimelineComponent from '../components/TimelineComponent.vue';
import UserProfileComponent from '../components/UserProfileComponent.vue';
import { mapState, mapActions } from 'vuex';

export default {
    components: {
        'timeline-component': TimelineComponent,
        'user-profile': UserProfileComponent,
    },
    data() {
        return {
            title: "ホームタイムライン"
        }
    },
    computed: {
        ...mapState([
            'user'
        ]),
       
        timeline(){
            return this.$store.state.timeline;
        },
        isLoading(){
            return this.$store.state.timeline.isLoading;
        }
    },
    mounted(){
        //this.loadInitTimeline();
        this.$store.dispatch('initTimeline');
    },
    created(){

    },
    destroyed(){

    },
    methods: {
        loadInitTimeline(){
            this.$store.dispatch('initTimeline');
        },

        loadNext(){
            this.$store.dispatch('loadNext');

        },
        infiniteListener(){
            console.log(`読み込みを開始します nextPage:${this.nextPage}`);
            this.loadNext();
        }
    }

}
</script>