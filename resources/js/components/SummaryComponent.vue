<template>
    <a :href="note.summary.url" target="_blank">
        <div class="summary">
            <img :href="note.summary.image"/>
            <p class="title">
                {{ note.summary.title }}
            </p>
            <p v-if="note.summary.description">
                {{ note.summary.description }}
            </p>
            <a class="url text-primary" :href="summary.url">
                {{ summary.url }}
            </a>
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