<template>
    <div class="wrapper">
        <img 
            class="img img-fluid col-12" 
            :src="image" 
             >                 
    </div>
</template>
<script>
import Identicon from 'identicon.js';
import jsHash from 'jssha';

export default {
    props: {
        avatar_icon: {
            required: false
        }
    },
    
    computed: {
        image(){
            if(this.avatar_icon){
                return this.avatar_icon;
            }else{
                let hash = new jsHash("SHA-256","TEXT");
                hash.update("Panta");
                let data = new Identicon(hash.getHash("HEX"), 200).toString();
                console.log(data);
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