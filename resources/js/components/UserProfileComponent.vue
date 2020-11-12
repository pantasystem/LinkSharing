<template>
    <div class="card">
        <div class="card-body">
            <div class="container">
                <div>
                    <img >
                    <h3> {{ user.user_name }}</h3>
                    <div v-if="user.is_follower">
                        フォローされています。
                    </div>
                    <div class="row">
                        <router-link :to="{ name: 'followings', params: { userId: user.id } }">{{ user.following_count}} フォロー</router-link>
                        <router-link :to="{ name: 'followers', params: { userId: user.id } }">{{ user.followers_count }} ヒョロワー</router-link>
                    </div>

                    <div v-if="user.is_following"> 
                        <b-button block variant="primary" :disable="isUpdate">フォロー</b-button>
                    </div>
                    <div v-else>
                        <b-button block variant="outline-primary">フォロー解除</b-button>
                    </div>
                </div>
                

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
    },
    data(){
        return {
            isUpdate: false
        };
    }
}
</script>