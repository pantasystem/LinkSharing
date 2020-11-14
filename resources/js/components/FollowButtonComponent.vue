<template>
<div>
    <div v-if="following"> 
                            
        <b-button 
            block variant="outline-primary"
            :disable="isNeedUpdate"
            @click="unfollow"
        >
            フォロー解除
        </b-button>
        </div>
    <div v-else>
        <b-button 
            block variant="primary" 
            :disable="isNeedUpdate"
            @click="follow"
        >
            フォロー
        </b-button>
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
        return { isNeedUpdate: false };
    },
    computed: {
        following(){
            return this.user.is_following;
        }
    },
    methods: {
        unfollow(){
            this.$emit("unfollow", this.user);
        },
        follow(){
            this.$emit('follow', this.user);
        }
    },
    

}
</script>