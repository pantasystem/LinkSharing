<template>
    <div class="contaienr mb-2">
        <div class="row">
            <router-link class="col-1" :to="{ name: 'user_notes', params: {userId: notification.publisher.id}}">
                <avatar-icon :user="notification.publisher"/>
            </router-link>
            <router-link class="col-11" :to="{ name: 'user_notes', params: {userId: notification.publisher.id}}"> 
                <!--{{ notiifcation.publisher.user_name }}-->
                {{ notification.publisher.user_name }}
            </router-link>
            
            
        </div>
        <div class="row">
        </div>
        <div>
            <div v-if="notification.favorite">
                <slot name="favorite" :favorite="notification.favorite">
                    <note-component :note="notification.favorite.note" />
                </slot>
            </div>
            <div v-else-if="notification.comment">
                <slot name="comment" :comment="notification.favorite">
                    
                </slot>
            </div>
            <div v-else>
                <slot name="follow" :publisher="notification.publisher">
                    <followee-component :user="notification.publisher" :me="user" @follow="follow" @unfollow="unfollow" />
                </slot>
                
            </div>
        </div>

    </div>
</template>
<script>
import AvatarIcon from '../atoms/AvatarIcon';
import NoteComponent from './NoteComponent';
import FolloweeComponent from './FolloweeComponent';
import { mapState, mapActions } from 'vuex';

export default {
    props: {
        notification: {
            type: Object,
            required: true
        }
    },
    components: {
        'avatar-icon': AvatarIcon,
        'followee-component': FolloweeComponent,
        'note-component': NoteComponent
    },
    computed: {
        ...mapState(['user'])
    },
    methods: {
        follow(user){
            this.$store.dispatch('follow', user)
                .then((res)=>{
                    
                });
        },
        unfollow(user){
            this.$store.dispatch('unfollow', user)
                .then((res)=>{

                });
        }

    }
}
</script>