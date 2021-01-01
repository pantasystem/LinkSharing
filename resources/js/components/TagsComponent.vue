<template>
    
    <div class="mt-1 mb-1">
        <router-link 
            v-for="tag in tags" :key="tag.name"
            :to="{ name: 'searchByTag', query: { condition: [tag.name] } }" 
            class="badge badge-light mr-2">
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