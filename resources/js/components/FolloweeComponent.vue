<template>
    <div class="container">
        <div class="row">

            <router-link :to="{ name: 'user_notes', params: { userId: user.id } }" class="col-2">
                <img :src="user.avatar_icon" :alt="user.user_name" class="img-fluid">
            </router-link>

            <div class="col-7 flex-column p-1">
                <h5> {{ user.user_name }}</h5>
                
            </div>
            <div class="col-2">
                <b-button v-if="user.is_following === true" variant="outline-primary">フォロー中</b-button>
                <b-button v-else-if="user.is_following === false" variant="primary">フォロー</b-button>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    
    props: {
        user: {
            type: Object,
            required: true
        }
    }
}
</script>