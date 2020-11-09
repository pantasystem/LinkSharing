<template>
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <router-link class="navbar-brand" to="/">
                    Linkboard
                </router-link>
                

                <!--トグル-->
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        <li class="nav-item" v-if="!isLoggedIn">
                            <router-link class="nav-link" to="/login">ログイン</router-link>
                        </li>

                        <li class="nav-item" v-if="!isLoggedIn">
                            <router-link class="nav-link" to="/register">登録</router-link>
                        </li>

                        <li class="nav-item">
                            
                            

                            <a class="nav-link" v-if="isLoggedIn">
                                <i class="fas fa-bell pull-left" height="100%"></i><span class="nav-link d-md-none d-inline icon-title">通知</span>

                            </a>
                        </li>
                           
                      
                    </ul>
                </div>
            </div>
        </nav>
</template>

<script>
import { mapState } from 'vuex';
export default {
    computed: {
        ...mapState([
            'user',
            'token'
        ]),
        isLoggedIn(){
            return this.$store.state.user != null;
        }
    }
}
</script>
<style scoped>
.icon-title{
    margin-left: 0.5em
}
</style>