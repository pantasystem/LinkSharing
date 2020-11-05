<template>
    <div class="col-md-6">
        <label for="input-email-field" class="text-md-left">メールアドレス</label>
        <input 
            id="input-email-field" 
            type="email" 
            class="form-control" 
            :class="{ 'is-invalid': error }" 
            :value="props.error" 
            required 
            autocomplete="email" 
            autofocus,
            @input="onInput"
        >

        <span class="invalid-feedback" role="alert" v-if="error">
            <strong>{{ props.error }}</strong>
        </span>
    </div>
</template>
<script>
export default {
    props: {
        error: {
            type: 'String',
            required: false,

        },
        value: {
            type: 'String',
            required: false,
        },
    },
    methods: {
        onInput(event){
            this.$emit('onInput');
        }
    }
}
</script>