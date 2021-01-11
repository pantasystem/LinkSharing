<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        登録
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

                            <router-link class="btn btn-link btn-lg btn-block" to="/login">ログイン</router-link>
                            <button type="submit" class="btn btn-primary btn-lg btn-block" :disabled="isLoading">
                                登録
                            </button>
                            
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>
<script>
import TextFieldComponent from './../atoms/TextField';

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
            confirmPassword: '',
            isLoading: false

        }
    },
    components: {
        'text-field': TextFieldComponent
    },
    methods: {
        register(){
            this.isLoading = true;
            this.$store.dispatch('register', this).catch((e)=>{
                console.log("エラー発生" + e);
                let errors = e.response.data.errors;
                
                this.errors.email = errors.email ? errors.email[0] : ''
                this.errors.password = errors.password ? errors.password[0] : ''
                this.errors.userName = errors.user_name ? errors.user_name[0] : ''
                
            }).then((response)=>{
                console.log("アカウント作成完了");
                this.$router.push("/");

            }).finally(()=>{
                this.isLoading = false;
            })
        },
        inputUserName(userName){
            this.userName = userName;
        }
    }
    
}
</script>