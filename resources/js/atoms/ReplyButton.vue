<template>
    <b-button variant="link" size="sm">
        <b-icon-reply class="reply" @click="onClick" />
    </b-button>
</template>
<script>
export default {
    methods: {
        onClick(){
            this.$emit('onClick');
        }
    }
}
</script>
<style>
.reply{
    width: 1.5rem;
    height: 1.5rem;
    color: #646464
}
</style>