<template>
    <article>
        <div class="row">
            <div class="col-2">
                <avatar-icon :user="comment.author" />
            </div>
            <div class="col-10">
                
            </div>
        </div>
        <div>
            <p v-html="$sanitize(comment.text)"></p>
        </div>
    </article>
</template>
<script>
import AvatarIcon from '../atoms/AvatarIcon';
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
        AvatarIcon