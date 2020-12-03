<template>
    <div class="wrapper">
        <img 
            class="img img-fluid col-12" 
            :src="avatar_icon ? avatar_icon : '/ic_avatar.png'" 
            v-on:error="loadAvatarIcon" >                 
    </div>
</template>
<script>
export default {
    props: {
        avatar_icon: {
            required: false
        }
    },
    methods: {
        loadAvatarIcon(e){
            e.target.src = "/ic_avatar.png";
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