<template>
    <div class="card">
        <div class="card-body">
            <div class="container">
                <div>
                    <img class="img-fluid" :src="user.user_name">
                    <h3> {{ user.user_name }}</h3>
                    <div v-if="user.is_follower">
                        フォローされています。
                    </div>
                    <div class="row">
                        <router-link class="col-6" :to="{ name: 'followings', params: { userId: user.id } }">{{ user.followings_count}} フォロー</router-link>
                        <router-link class="col-6" :to="{ name: 'followers', params: { userId: user.id } }">{{ user.followers_count }} ヒョロワー</router-link>
                    </div>
                    <div v-if="!isMine">
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
    </div>
</template>
<script>
export default {
    props: {
        user: {
            type: Object,
            required: true
        },
        isMine: {
            type: Boolean,
            required: false,
            default: false
        }
    },
    data(){
        return {
            isUpdate: false
        };
    }
}
</script>