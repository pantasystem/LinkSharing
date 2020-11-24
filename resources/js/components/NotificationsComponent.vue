<template>
<div>
    <div class="card">
        <div class="card-header">
            通知
        </div>
        <div class="card-body">
            <notification-component v-for="notification in notifications" :key="notification.id"/>
        </div>
    </div>
</div>
</template>
<script>
import NotificationComponent from './NotificationComponent';
import NotificationComponent from './NotificationComponent.vue';
export default {
    props: {
        notifications: {
            type: Array
        }
    },
    components: {
        'notification-compoennt' : NotificationComponent
    }
}
</script>