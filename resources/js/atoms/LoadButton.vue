<template>
    <button class="btn btn-link btn-lg btn-block" v-on:click="load" v-bind:disabled="isLoading">
        <span v-if="!isLoading">読み込む</span>
        <span v-if="isLoading">読み込み中</span>
    </button>
</template>
<script>
export default {
    props: {
        isLoading: {
            type: Boolean,
            required: false,
            default: false
        }
    },
    methods: {
        load(){
            this.$emit('load');
        }
    }
}
</script>