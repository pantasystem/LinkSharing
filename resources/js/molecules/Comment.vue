<template>
    <article>
        <router-link :to="{ name: 'user_notes', params: { userId: comment.author.id}}">
            <div class="col-2">
                <avatar-icon
                    :user="comment.author"
                />
            </div>
            
            <div class="col-10">
                {{ comment.author.user_name }}   
            </div>
            
        </router-link>
        
        <div>
            <p v-html="$sanitize(comment.text)"></p>
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