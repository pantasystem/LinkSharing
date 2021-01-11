<template>
<div class="card mb-2">
    <div class="card-header">
        検索条件
    </div>
    
    <div class="card-body">
        <div v-for="(str) in conditions" :key="str.id" class="mb-2">
            <div class="d-flex ">
                <b-form-input 
                    v-model="str.condition"
                    type="text"
                    required
                    placeholder="or条件は区切って入力"
                    class="align-self-center flex-grow-1">
                
                </b-form-input>
                
            </div>
        </div>
        <div class="d-flex justify-content-end mt-3">
            <b-button 
                @click="addCondition" 
                class="text-nowrap mr-2"
            >AND条件追加</b-button>
            <b-button variant="primary" @click="$emit('search')">
                検索
            </b-button>
        </div>
    </div>
   
    
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