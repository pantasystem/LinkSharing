<template>
    <div>
        <form @submit.prevent="submit">
            <b-textarea v-model="text"></b-textarea>
            <b-button type="submit" :variant="primary">送信</b-button>
        </form>
    </div>
</template>
<script>
/**
 * バリデーションなどはここで行い送信が決定されたときに親コンポーネントにデータを投げる
 */
export default {
    data(){
        return {
            text: ''
        }
    },
    methods: {
        submit(){
            this.$emit('submit', this.text);
        }
    }
}
</script>