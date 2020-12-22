<template>
    <div>
        <form @submit.prevent="submit">
            <b-form-textarea v-model="form.text" autofocus :error="textError" :aria-invalid="'error'"></b-form-textarea>
            <div>
                <b-button type="submit" variant="primary" class="mt-2">送信</b-button>
            </div>
        </form>
    </div>
</template>
<script>
/**
 * バリデーションなどはここで行い送信が決定されたときに親コンポーネントにデータを投げる
 */
export default {
    props:{
        text: {
            required: false,
            type: String
        },
        errors: {
            required: false
        }
    },
    computed: {
        textError(){
            return this.errors ? this.errors.text[0] : '';
        }
    },

    data(){
        return {
            form: {text: ''}
        }
    },
    methods: {
        submit(){
            this.$emit('submit', this.form.text);
            this.form.text = '';
        },
       
    },

    created(){
        this.form.text = this.text;
    }
}
</script>