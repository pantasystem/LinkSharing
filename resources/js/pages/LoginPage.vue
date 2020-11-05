<template>
    <div class="container">
        <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">ログイン</div>

                <div class="card-body">
                    <form v-on:submit.prevent="doLogin">
                                <!--<required-email-field v-bind:text="email" ></required-email-field>-->
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
                        <textarea type="text" v-model="deviceName"/>
                                {{ deviceName }}

                    </form>            
                    
                </div>


                
                   
            </div>
        </div>
    </div>
</div>

</template>
<script>
import RequiredEmailFieldCompoent from './../components/RequiredEmailFieldComponent';
import TextFieldComponent from './../components/TextFieldComponent';

export default {
    
    components: {
        'required-email-field': RequiredEmailFieldCompoent,
        'text-field': TextFieldComponent
    },
    data: function(){
        return {
            errors: {
                'email': '',
                'password': '',
                'device_name': ''  
            },
            email: 'hogehogehogepi',
            password: '',
            deviceName: 'deviceName'
                        
        };
    },
    methods: {
        onInputEmail($event){
            console.log("入力を受けた:" + $event.target.value);
            //this.$emit('input', $event.data);
        },
        doLogin(){

        }
    },
    mounted(){
        console.log("mounted");
    }
}
</script>