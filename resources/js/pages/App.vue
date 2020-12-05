<template>
<div>
    <header-component id="main-header"/>
    <main  id="main-content">
        <router-view/>
    </main>
</div>
    
</template>
<script>
export default {

    created(){
        console.log("created");
        console.log(`timeline${JSON.stringify(this.$store.state)}`);
        this.$store.dispatch("loadMe")
            .catch((e)=>{
                console.log(`アカウントの読み込みに失敗: ${e}`);
                if(e.status == 401){
                    this.$router.push("/login");
                }
            });
        console.log(this.$store);
        this.$store.dispatch('timeline/initTimeline');
        this.$store.dispatch('notification/init');
        this.$store.dispatch('notification/loadNext');
        
        
    }
}
</script>
<style scoped>
#main-content{
    padding-top:4.5rem;
}


</style>