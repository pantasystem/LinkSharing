<template>
    <article class="row">
        
        <div class="col-1">
            <router-link :to="{ name: 'user_notes', params: { userId: comment.author.id}}">
            
                <avatar-icon
                    :user="comment.author"
                />
            
            </router-link>
            
        </div>
        <div class="col-11">
            <div>{{ comment.author.user_name }}</div> 
            <div>
                <p v-html="$sanitize(comment.text.replace(/\n/g, '<br>'))"></p>
            </div>
        </div>   
        
        
    </article>
</template>
<script>
import AvatarIcon from '../atoms/AvatarIcon.vue';
export default {
    props: {
        comment: {
            type: Object,
            required: true
        }
    },
    components: {
        'avatar-icon': AvatarIcon
    }
}
</script>