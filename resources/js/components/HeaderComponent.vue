<template>
    <b-navbar type="light" toggleable="md" class="shadow-sm">
        <div class="container">
            <b-navbar-brand to="/">Linkboard</b-navbar-brand>
                
                

            <b-collapse id="navbarSupportedContent" is-nav>
                <b-navbar-nav class="mr-auto">
                </b-navbar-nav>
                <b-navbar-nav class="ml-auto">
                    <b-nav-item to="/login" v-if="!isLoggedIn">ログイン</b-nav-item>
                    <b-nav-item to="/register" v-if="!isLoggedIn">登録</b-nav-item>
                    <b-nav-item to="/notifications" v-if="isLoggedIn">
                        <i class="fas fa-bell pull-left" height="100%"></i><span class="nav-link d-md-none d-inline icon-title">通知</span>

                    </b-nav-item>
                    <b-nav-item-dropdown :text="user.user_name" v-if="user">
                        <b-dropdown-item to="/profile" v-if="user">
                            プロフィール
                        </b-dropdown-item>
                        <b-dropdown-item @click="logout" v-if="token">
                            ログアウト
                        </b-dropdown-item>
                    </b-nav-item-dropdown>

                </b-navbar-nav>
                
                
            </b-collapse>
            <button class="btn btn-primary ml-auto mr-1">投稿</button>
            <b-navbar-toggle target="navbarSupportedContent" />

        </div>
                
    </b-navbar>
    
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
    },
    methods: {
        logout(){
            this.$store.dispatch("logout");
            this.$router.push("/login");
        }
    }
}
</script>
<style scoped>
.icon-title{
    margin-left: 0.5em
}
</style>