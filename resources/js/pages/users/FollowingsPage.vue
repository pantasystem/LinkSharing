<template>
    <user-list :load="loadFollowers.bind(this)" title="フォロー"></user-list>
</template>
<script>
import axios from 'axios';

import UserListComponent from '../../components/UserListComponent';

export default {
    components: {
        'user-list': UserListComponent
    },
    props: {
        userId: {
            required: true
        }
    },
    

    methods: {
        loadFollowers(pageNumber){
            let token = this.$store.state.token;
            return axios.get(
                `/api/users/${this.userId}/followings`,
                {
                    headers: { Authorization: `Bearer ${token}`},
                    params: { page: pageNumber }
                }
            );
        }
    }
}
</script>