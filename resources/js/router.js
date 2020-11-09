import VueRouter from 'vue-router';
import Vue from 'vue';
import LoginPage from './pages/LoginPage.vue';
import RegisterPage from './pages/RegsiterPage.vue';

Vue.use(VueRouter);

export default new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/login',
            name: 'login',
            component: LoginPage

        },
        {
            path: '/register',
            name: 'register',
            compoennt: RegisterPage
        }
    ]
});