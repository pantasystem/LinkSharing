<template>
<div class="card cd">
    <div class="row media position-relative">
        

        <div class="col-12 media-body">

            <h5 class="single-line">
                {{ summary.title }}
            </h5>
            <div class="single-line" v-if="summary.description">
                {{ summary.description }}
            </div>
            <a class="url stretched-link" :href="summary.url" target="_blank">
                {{ summary.url }}

            </a>
            <div class="wrapper col-11" v-if="summary.image">
                <img  class="thumbnail" :src="summary.image" v-on:error="imgLoadError" />
            </div>
        </div>
            
    </div>
</div>
</template>
<script>
import axios from 'axios';
export default {
    props: {
        summary: {
            type: Object,
            required: true
        }
    },
    methods: {
        imgLoadError(element){
            element.target.src = axios.defaults.baseURL + "/ic_link.svg";

        }
    }
}
</script>
<style scoped>
.wrapper {
    overflow: hidden;

}

.wrapper:before {
    content:"";
    display: block;
    padding-top: 52.5%; /* 高さを幅の75%に固定 */
    overflow: hidden;

}
.thumbnail {
    position: absolute;
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
    object-fit: contain;

    max-width: 100%;
    height: auto; 
}

.summary_content{
    flex: 1;
}


.single-line{
    text-overflow: ellipsis;
    overflow: hidden;
    white-space: nowrap;
}

.url {
    text-overflow: ellipsis;
    display: block;
    overflow: hidden;
    white-space: nowrap;
}

.cd {
    padding: 0.5rem;
}

</style>