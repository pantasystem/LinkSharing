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
                                v-model="userName"
                                :required="true"
                                hint="ユーザー名"
                                :error="errors.userName"
                            />
                            <text-field
                                v-model="password"
                                type="password"
                                :required="true"
                                hint="パスワード"
                                :error="errors.password"
                                
                            />
                            <text-field
                                v-model="confirmPassword"
                                type="password"
                                :required="true"
                                hint="パスワードの確認"
                                :error="errors.password"
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
            this.$store.dispatch('register', this).then((response)=>{
                console.log("アカウント作成完了");
            }).catch((e)=>{
                console.log("エラー発生" + JSON.stringify(e.response));
                let data = e.response.data.errors;
                if(data.email){
                    this.errors.email = data.email[0];
                }
                if(data.password){
                    this.errors.password = data.password[0];
                }
                
                if(data.user_name){
                    this.errors.userName = data.user_name[0];
                }
            });
        },
        inputUserName(userName){
            this.userName = userName;
        }
    }
    
}
</script>