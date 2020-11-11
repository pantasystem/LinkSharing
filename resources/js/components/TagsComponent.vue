<template>
    
    <div class="row">
        <router-link 
            v-for="tag in tags" :key="tag.name"
            :to="{ name: 'search_by_tag', params: { name: tag.name } }" 
            class="badge badge-light">
            {{ tag.name }}
        </router-link>
    </div>
</template>
<script>
export default {
    props: {
        
        tags: {
            type: Array,
            required: true
        }
    }
}
</script>