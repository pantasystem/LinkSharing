<template>
    <div class="card">
        <div class="card-header" v-if="title">
            {{ title }}
        </div>
        <div class="card-body">
            <div v-for="user in users" :key="user.id">
                {{ user.user_name }}
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        title: {
            required: false
        },
        load: {
            type: Function,
            required: true
        }
    },
    data(){
        return {
            currentPage: 0,
            isLoading: false,
            users: []

        }
    },
    methods: {
        loadNext(){
            if(this.isLoading){
                return;
            }
            
            this.load(this.currentPage + 1)
                .then((res)=>{
                    this.users.push(...res.data.data);
                    this.isLoading = false;
                })
                .catch((e)=>{
                    console.log(e);
                    this.isLoading = false;
                });
        },
        follow(user){
            this.$store.dispatch('follow', user)
                .then((user)=>{
                    
                })
                .catch((e)=>{
                    console.log(e);
                });
        },
        unfollow(user){
            this.$store.dispatch('unfollow', user)
                .then((user)=>{

                })
                .catch((e)=>{
                    console.log(e);
                })
        }
    },
    mounted(){
        this.loadNext();
    }
}
</script>