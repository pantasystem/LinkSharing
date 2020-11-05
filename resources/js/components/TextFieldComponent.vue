<template>
    <div class="col-md-6">
        <label for="input-text-field" class="text-md-left">{{ hint }}}</label>
        <input 
            id="input-text-field" 
            :type="type"
            class="form-control" 
            :class="{ 'is-invalid': error }" 
            :value="props.error" 
            :autocomplete="autocomplete"
            :placeholder="hint"
            :autofocus="autofocus"
            @input="onChanged"
            :required="required"
            
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
            type: 'String'
        },
        required: {
            type: 'Boolean',
            default: false
        },
        autofocus: {
            type: 'Boolean',
            default: false,
        },
        type: {
            type: 'String',
            default: 'text'
        },
        hint: {
            type: ['String', 'Number']
        },
        autocomplete: {
            type: 'String',
            default: 'on'
        }

    },
    methods: {
        onChanged(event){
            this.$emit('change', event.target.value);
        }
    }
}
</script>