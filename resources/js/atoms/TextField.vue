<template>
<div class="form-group row">
    <div class="col-md-12">
        <label v-if="hint" for="input-text-field" class="text-md-left">{{ hint }}</label>

        <input 
            id="input-text-field" 
            :type="type"
            class="form-control" 
            :class="{ 'is-invalid': error }" 
            :placeholder="hint"
            
            :required="required"
            :autofocus="autofocus"

            :autocomplete="autocomplete"
            v-on:input="$emit('input', $event.target.value)"
            v-bind:value="value"

            
        />
        <!--
            
            -->

        <span class="invalid-feedback" role="alert" v-if="error">
            <strong>{{ error }}</strong>
        </span>
    </div>
</div>
</template>
<script>
export default {
    props: {
        hint: {
            type: String,
            required: true
        },
        error: {
            type: String,
            required: false,
            default: ''
        },
        type: {
            type: String,
            required: false,
            default: 'text'
        },
        required: {
            type: Boolean,
            required: false,
            default: false
        },
        autofocus: {
            type: Boolean,
            default: false,
            required: false
        },
        autocomplete: {
            type: String,
            default: 'off',
            required: false
        },
        value: {
            type: String,
            required: false
        }
    },
    methods: {
        onChanged(event){
            console.log(event.target.value);
            this.$emit('change', event.target.value);
        }
    },
    mounted(){
        console.log(this);
    }
}
</script>