<template>
    <a :href="summary.url" target="_blank" class="row">
        <div class="summary col-4">
            <img class="img-fluid" :href="summary.image"/>
        </div>

        <div class="col-8">

            <div class="single-line">
                {{ summary.title }}
            </div>
            <div class="single-line" v-if="summary.description">
                {{ summary.description }}
            </div>
            <div class="single-line">
                {{ summary.url }}

            </div>
        </div>
            
    </a>
</template>
<script>
export default {
    props: {
        summary: {
            type: Object,
            required: true
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
    height: 1em;
    overflow: hidden;
    white-space: nowrap;
}


</style>