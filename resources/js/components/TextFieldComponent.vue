<template>
<div class="form-group row">
    <div class="col-md-6">
        <label v-if="hint" for="input-text-field" class="text-md-left">{{ hint }}</label>

        <input 
            id="input-text-field" 
            :type="type"
            class="form-control" 
            :class="{ 'is-invalid': error }" 
            :value="error" 
            :placeholder="hint"
            
            @input="onChanged"
            :required="required"
            :autofocus="autofocus"

            :autocomplete="autocomplete"
            
        >
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
    //props: {
        /*error: {
            type: 'String',
            default: '',
            required: false
        },*/
        /*required: {
            type: 'Boolean',
            default: false,
            required: false

        },
        autofocus: {
            type: 'Boolean',
            default: false,
            required: false
        },
        type: {
            type: 'String',
            default: 'text',
            required: false
        },*/
        /*hint: {
            
            type: 'String',
            default: '',
            required: false
        },*/
        /*autocomplete: {
            type: 'String',
            default: 'on',
            required: false
        }*/

    //},
    //props: ['hint', 'error', 'type'],
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
            default: 'on',
            required: false
        }
    },
    methods: {
        onChanged(event){
            this.$emit('change', event.target.value);
        }
    },
    mounted(){
        console.log(this);
    }
}
</script>