<template>
    <div class="container">
        <div class="row justify-content">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                    </div>
                    <div class="card-body">
                        <form v-on:submit.prevent="register">
                            <text-field 
                                v-model="email"
                                type="email"
                                :reqiured="true"
                                :autofocus="true"
                                hint="メールアドレス"
                                :error="errors.email"
                            />
                            <text-field 
                                v-bind:input="inputUserName"
                                :value="userName"
                                :required="true"
                                hint="ユーザー名"
                                :error="errors.userName"
                            />
                            <text-field
                                
                            />
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>
<script>
import TextFieldComponent from '../components/TextFieldComponent';
export default {
    data(){
        return {
            errors: {
                email: '',
                userName: '',
                password: '',
                confirmPassword: ''
            },
            email: '',
            userName: '',
            password: '',
            confirmPassword: ''

        }
    },
    components: {
        'text-field': TextFieldComponent
    },
    methods: {
        register(){

        },
        inputUserName(userName){
            this.userName = userName;
        }
    }
    
}
</script>