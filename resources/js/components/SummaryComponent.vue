<template>
    <div class="row media position-relative">
        <div class="summary col-2">
            <img class="img-fluid" :src="summary.image" v-on:error="imgLoadError" />
        </div>

        <div class="col-10 media-body">

            <h5 class="single-line">
                {{ summary.title }}
            </h5>
            <div class="single-line" v-if="summary.description">
                {{ summary.description }}
            </div>
            <a class="url stretched-link" :href="summary.url">
                {{ summary.url }}

            </a>
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
.summary{
    display: flex;
}

.summary_thumbnail{
    width: 58px;
    height: 58px;
    margin-right: 8px;
    margin-bottom: 16px;
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