<template>
<div>
    <header-component />
    <main class="py-4">
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
        
        
    }
}
</script>