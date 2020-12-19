<template>
    <div>
        <form @submit.prevent="submit">
            <b-textarea v-model="text" autofocus></b-textarea>
            <div>
                <b-button type="submit" variant="primary">送信</b-button>
                <b-button @click="cancel">やっぱりやめる</b-button>
            </div>
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
        },
        cancel(){
            this.$emit('cancel');
        }
    }
}
</script>