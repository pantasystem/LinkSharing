<template>
    <div class="container">
        <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">ログイン</div>

                <div class="card-body">
                    <form v-on:submit.prevent="loginAccount">
                
                        <text-field 
                            hint="メールアドレス" 
                            :error="errors.email" 
                            type="email"
                            :required="true"
                            :autofocus="true"
                            v-model="email"
                            ></text-field>
                        <text-field 
                            hint="パスワード" 
                            :error="errors.password" 
                            type="password"
                            :required="true"
                            :autofocus="false"
                            v-model="password"></text-field>

                        <router-link class="btn btn-link btn-lg btn-block" to="/register">登録</router-link>
                        <button type="submit" class="btn btn-primary btn-lg btn-block">
                            ログイン
                        </button>
                        
                        

                    </form>            
                    
                </div>


                
                   
            </div>
        </div>
    </div>
</div>

</template>
<script>
import { mapActions } from 'vuex';
import TextFieldComponent from './../components/TextFieldComponent';

export default {
    
    components: {
        'text-field': TextFieldComponent
    },
    data(){
        return {
            errors: {
                'email': '',
                'password': '',
            },
            email: '',
            password: '',
                        
        };
    },
    methods: {
        
        loginAccount(){
            let email = this.email;
            let password = this.password;
            let req = {
                email, password
            };
            console.log("email, password" + JSON.stringify(req));
            let res = this.$store.dispatch("login", req);
            res.then((response)=>{
                console.log("レスポンスが来た");
                this.errors = {};
                this.$router.push("/");
            }).catch((e)=>{
                console.log(e.response);
                let errors = e.response.data.errors;
                if(errors.password){
                    this.errors.password = errors.password[0];
                }
                if(errors.email){
                    this.errors.email = errors.email[0];
                }
                console.log(this.errors);
            });
        }
    }
}
</script>