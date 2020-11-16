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
        <div class="row">
        </div>
        <div>
            <div v-if="notification.favorite">
                <slot name="favorite" :favorite="notification.favorite">
                    <div>

                    </div>
                </slot>
            </div>
            <div v-else-if="notification.comment">
                <slot name="comment" :comment="notification.favorite">
                </slot>
            </div>
            <div v-else>
                <slot name="follow" :user="notification.publisher">
                </slot>
            </div>
        </div>

    </div>
</template>
<script>
import AvatarIcon from './AvatarIconComponent';
import NoteComponent from './NoteComponent';

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