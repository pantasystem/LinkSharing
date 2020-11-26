<template>
<div>
    <div class="card">
        <div class="card-header">
            通知
        </div>
        <div class="card-body">
            <notification-component v-for="notification in notifications" :key="notification.id" :notification="notification"/>
        </div>
        

    </div>
    <load-button :isLoading="isLoading" @load="loadNext"/>
</div>
</template>
<script>
import NotificationComponent from './NotificationComponent.vue';
import LoadButtonComponent from './LoadButtonComponent.vue';

export default {
    props: {
        notifications: {
            type: Array
        },
        isLoading: {
            type: Boolean,
            default: false
        }
    },
    components: {
        'notification-component' : NotificationComponent,
        'load-button' : LoadButtonComponent
    },
    methods: {
        loadNext(){
            this.$emit('loadNext');
        }
    }
}
</script>