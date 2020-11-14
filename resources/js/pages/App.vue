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
        this.$store.dispatch("loadMe")
            .catch((e)=>{
                console.log(`アカウントの読み込みに失敗: ${e}`);
                if(e.status == 401){
                    this.$router.push("/login");
                }
            });
        this.$store.dispatch("initTimeline");
        
    }
}
</script>