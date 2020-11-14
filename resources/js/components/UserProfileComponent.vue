<template>
    <div class="card">
        <div class="card-body">
            <div class="container">
                <div>
                    <div class="wrapper col-8 mx-auto">
                        <img 
                            class="img img-fluid" 
                            :src="user.avatar_icon ? user.avatar_icon : 'ic_avatar.png'" 
                            v-on:error="loadAvatarIcon" >

                    </div>
                    <h3 class="text-center"> {{ user.user_name }}</h3>
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
    },
    methods: {
        loadAvatarIcon(e){
            e.target.src = "ic_avatar.png";
        }
    }
}
</script>
<style scoped>
.wrapper{
    overflow: hidden;    
}

.wrapper::before{
    content: "";
    display: block;
    padding-bottom: 100%;
    overflow: hidden;

}

.img{
    position: absolute;
    top: 0;
    right: 0;
    left: 0;
    bottom: 0;
    object-fit: contain;
}
</style>