<template>
<div>
    <header-component id="main-header"/>
    <main  id="main-content">
        <router-view/>
    </main>
</div>
    
</template>
<script>
import StreamingAPI from '../streaming';
export default {

    created(){
        console.log("created");
        
        if(this.$store.state.user == null){
            this.$router.push("/login");
            return;

        }

        this.$store.dispatch('timeline/initTimeline');
        this.$store.dispatch('notification/init');
        this.$store.dispatch('notification/loadNext');
        this.$store.dispatch('listen');
        
        
    },
    beforeDestroy(){
        this.$store.dispatch('dispose');
    }
}
</script>
<style scoped>
#main-content{
    padding-top:5rem;
}


</style>