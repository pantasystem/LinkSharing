<template>
    <div class="contaienr mb-2">
        <div class="row">
            <router-link class="col-1" :to="{ name: 'user_notes', params: {userId: notification.publisher.id}}">
                <avatar-icon :avatar_icon="notification.publisher.avatar_icon"/>
            </router-link>
            <router-link class="col-11" :to="{ name: 'user_notes', params: {userId: notification.publisher.id}}"> 
                {{ notiifcation.publisher.user_name }}
            </router-link>
        </div>

    </div>
</template>
<script>
import AvatarIcon from './AvatarIconComponent';

export default {
    props: {
        notification: {
            type: Object,
            required: true
        }
    },
    components: {
        'avatar-icon': AvatarIcon
    }
}
</script>