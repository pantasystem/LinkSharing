<template>
    <div>
        <div v-for="c in conditions" :key="c">

        </div>
    </div>
    
</template>
<script>
export default {
    props: {
        conditions: {
            type: Array
        }
    }

}
</script>