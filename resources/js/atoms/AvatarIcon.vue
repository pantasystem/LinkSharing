<template>
    <div class="wrapper">
        <img 
            class="img img-fluid col" 
            :src="image" 
             >                 
    </div>
</template>
<script>
import Identicon from 'identicon.js';
import jsHash from 'jssha';

export default {
    props: {
        user:{
            required: true,
            type: Object
        }
    },
    
    computed: {
        image(){
            if(this.user.avatar_url){
                return window.location.protocol + '//' + window.location.host + this.user.avatar_url;
            }else{
                let hash = new jsHash("SHA-256","TEXT");
                hash.update(this.user.user_name);
                let data = new Identicon(hash.getHash("HEX"), 200).toString();
                return "data:image/png;base64," + data;
            }
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