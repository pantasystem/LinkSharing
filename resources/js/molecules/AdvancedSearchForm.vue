<template>
<div>
    <div v-for="str in conditions" :key="str.id" >
        <b-form-input 
        :v-text="str.condition"
        :v-bind="str.condition"
        @input="input(str.id, $event.target.value)"
        type="text"
        required
        placeholder="or条件は区切って入力">
        
        </b-form-input>
    </div>
    <b-button variant="primary" @click="addCondition">AND条件追加</b-button>
    
</div>    
</template>
<script>
export default {
    props: {
        conditions: {
            type: Array
        }
    },

   
    methods: {
        addCondition(){
            this.$emit('addCondition');
        },
        input(evt, id){
            this.$emit('input', {
                'id': id,
                'condition': evt
            });
        }
    }

}
</script>