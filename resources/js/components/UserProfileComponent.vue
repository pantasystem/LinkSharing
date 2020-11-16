<template>
    <div class="card">
        <div class="card-body">
            <div class="container">
                <div>
                    <div class="col-8 mx-auto mb-2 mt-2">
                        <avatar-icon 
                            :avatar_icon="user.avatar_icon"
                        />

                    </div>
                    <h3 class="text-center"> {{ user.user_name }}</h3>
                    <div v-if="user.is_follower" class="mx-auto">
                        フォローされています。
                    </div>
                    <div class="row">
                        <router-link class="col-md-4" :to="{ name: 'user_notes', params: { userId: user.id} }">
                            <div class="main-text">{{ user.notes_count }}</div> 
                            <div class="sub-text">投稿</div>
                        </router-link>
                        <router-link class="col-md-4" :to="{ name: 'followings', params: { userId: user.id } }">
                            <div class="main-text">{{ user.followings_count}}</div> 
                            <div class="sub-text">フォロー</div>
                        </router-link>
                        <router-link class="col-md-4" :to="{ name: 'followers', params: { userId: user.id } }">
                            <div class="main-text">{{ user.followers_count }}</div> 
                            <div class="sub-text">ヒョロワー</div>
                        </router-link>
                    </div>
                    <div v-if="isShowFollowButton" class="mt-2" >
                        <follow-button v-on:follow="follow" v-on:unfollow="unfollow" :user="user" />
                    </div>
                </div>
                

            </div>
        </div>
    </div>
</template>
<script>
import FollowButton from './FollowButtonComponent';
import AvatarIcon from './AvatarIconComponent';

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
    components: {
        'follow-button': FollowButton,
        'avatar-icon': AvatarIcon
    },
    computed: {
        isShowFollowButton(){
            return !this.isMine && this.$store.state.user;
        }
    },
    
    methods: {
        loadAvatarIcon(e){
            e.target.src = "/ic_avatar.png";
        },
        follow(){
            this.$emit('follow');
        },
        unfollow(){
            this.$emit('unfollow');
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

.sub-text{
    font-size: 12px;
    color:gray;
    text-align: center;
}
.main-text{
    font-size: 1.5em;
    color: rgb(19, 19, 19);
    text-align: center;
}
</style>