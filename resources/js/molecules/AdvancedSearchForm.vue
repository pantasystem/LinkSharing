<template>
<div>
    <div v-for="str in strConditions" :key="str" >
        <b-from-input 
        :v-text="str"
        type="text"
        required
        placeholder="or条件は区切って入力">
        />
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

    computed:{
        strConditions(){
            let c = [];
            for(let orCondition in this.conditions){
                let strCondition = '';
                for(let c in orCondition){
                    strCondition = `${strCondition} ${c}`;
                }
                c.push(c);
            }
            return c;
        }
    }

}
</script>