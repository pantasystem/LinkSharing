<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <timeline-component :notes="notes" :title="title" />
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
            isLoading: false
        }
    },
    mounted(){
        this.loadInitTimeline();
    },
    methods: {
        loadInitTimeline(){
            let token = this.$store.state.token;
            axios.get(
                '/api/notes', 
                {
                    headers: { Authorization: `Bearer ${token}` }
                }
            ).then((page)=>{
                console.log(JSON.stringify(page.data.data));
                this.notes = page.data.data;
            }).catch((e)=>{
                console.log(e);
            })
        }
    }

}
</script>