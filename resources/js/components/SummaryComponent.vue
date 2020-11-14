<template>
    <div class="row media position-relative">
        

        <div class="col-12 media-body">

            <h5 class="single-line">
                {{ summary.title }}
            </h5>
            <div class="single-line" v-if="summary.description">
                {{ summary.description }}
            </div>
            <a class="url stretched-link" :href="summary.url">
                {{ summary.url }}

            </a>
            <div class="wrapper col-10">
                <img  class="content img-fluid" :src="summary.image" v-on:error="imgLoadError" />
            </div>
        </div>
            
    </div>
</template>
<script>
export default {
    props: {
        summary: {
            type: Object,
            required: true
        }
    },
    methods: {
        imgLoadError(element){
            element.target.src = "ic_link.svg";

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
.content {
    position: absolute;
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
    object-fit: contain;
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


</style>