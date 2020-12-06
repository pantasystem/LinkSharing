<template>
    <div class="container">
        <div class="row justify-content-center">
        <div class="col-md-8">
            <login-form @success="success"></login-form>
        </div>
    </div>
</div>

</template>
<script>
import LoginForm from './../organisms/LoginForm';
export default {
    components: {
        'login-form': LoginForm
    },
    methods: {
        success(){
            this.$router.push('/');
        }
    }
}
</script>