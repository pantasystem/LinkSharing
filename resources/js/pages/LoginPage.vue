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
                            :error="errors.email" 
                            type="password"
                            :required="true"
                            :autofocus="false"
                            v-model="password"></text-field>

                        <div class="form-group row mb-0">
                            <div class="col-md-12 offset-md-9">
                                <button type="submit" class="btn btn-primary">
                                    ログイン
                                </button>
                            </div>
                        </div>
                        

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
                console.log(response);
            }).catch((e)=>{
                console.log(e);
            });
        }
    }
}
</script>