<template>
    <a :href="summary.url" target="_blank" class="row">
        <div class="summary col-2">
            <img class="img-fluid" :href="summary.image"/>
        <div class="col-10">

            <p class="title">
                {{ summary.title }}
            </p>
            <p v-if="summary.description">
                {{ summary.description }}
            </p>
            <a class="url text-primary" :href="summary.url">
                {{ summary.url }}
            </a>
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

.summary > .summary_thumbnail{
    width: 58px;
    height: 58px;
    margin-right: 8px;
    margin-bottom: 16px;
}
.summary > .summary_content{
    flex: 1;
}

.summary > .title{
    text-overflow: ellipsis;
    height: 1em;
    overflow: hidden;
    white-space: nowrap;

}

.summary > .url {
    text-overflow: ellipsis;
    height: 1em;
    overflow: hidden;
    white-space: nowrap;
}


</style>