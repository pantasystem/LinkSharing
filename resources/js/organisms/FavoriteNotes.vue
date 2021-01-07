<template>
    <notes-pager 
        :requestBuilder="requestBuilder"
        title="お気に入り"
        ref="notes"
    />
</template>
<script>
import NotesPager from './NotesPager';
import axios from 'axios';

export default {
    components: {
        NotesPager
    },

    methods: {
        requestBuilder(page){
            return axios.get('/api/favorites', {
                params: {
                    page
                },
            })
        },
        
    },
    beforeRouteUpdate(to, from, next){
        this.$refs.notes.init();
    },

    
    
}
</script>