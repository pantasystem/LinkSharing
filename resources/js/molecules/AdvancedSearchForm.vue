<template>
<div>
    <div v-for="str in conditions" :key="str.id" >
        <b-form-input 
        v-model="str.condition"
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
        input(id, value){
            console.log(value);
            this.$emit('input', {
                'id': id,
                'condition': value
            });
        }
    }

}
</script>