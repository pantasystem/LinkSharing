<template>
    <div class="container">
        <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">ログイン</div>

                <div class="card-body">
                    <form v-on:submit.prevent="doLogin">
                
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
                            :autofocus="false"></text-field>

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
        
        doLogin(){

        }
    }
}
</script>