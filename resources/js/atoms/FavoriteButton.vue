<template>
    <div class="favorite">
        <b-button variant="link" size="sm">
            <b-icon-star-fill v-if="favorite" class="favorite rounded" @click="onClick"/>
            <b-icon-star v-else class="favorite rounded" @click="onClick" />
        </b-button> 
    </div>
</template>
<script>
export default {
    props: {
        favorite: {
            required: true,
            type: Boolean,
        }
    },
    methods: {
        onClick(){
            if(this.favorite){
                this.$emit('unfavorite');
            }else{
                this.$emit('favorite');
            }
        }
    }
}
</script>
<style scoped>

.favorite{
    width: 1.5rem;
    height: 1.5rem;
    color: #f5f242;
}

</style>