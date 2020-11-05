<template>
    <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <div class="form-group row">
                            <required-email-field v-bind:text="email" ></required-email-field>

                            <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                    <span class="invalid-feedback" role="alert" v-if="error.password">
                                        <strong>{{  }}</strong>
                                    </span>
                            </div>
                        </div>
                        </div>

<!--
                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>
                    -->

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>

</template>
<script>
import RequiredEmailFieldCompoent from './../pages/RequiredEmailFieldComponent';
export default {
    
    components: {
        'required-email-field': RequiredEmailFieldCompoent
    },
    data(){
        return {
            errors: {
                'email': '',
                'password': '',
                'device_name': ''  
            },
            email: '',
            password: ''
                        
        };
    },
    methods: {
        onInputEmail($event){
            console.log("入力を受けた:" + $event.data);
            this.$emit('input', $event.data);
        }
    }
}
</script>