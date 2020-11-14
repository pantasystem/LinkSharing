import VueRouter from 'vue-router';
import Vue from 'vue';
import LoginPage from './pages/LoginPage.vue';
import RegisterPage from './pages/RegisterPage.vue';
import HomePage from './pages/HomePage.vue';
import UserPage from './pages/UserPage.vue';
import TagNotePage from './pages/TagsNotePage.vue';
import FollowingsPage from './pages/FollowingsPage.vue';
import FollowersPage from './pages/FollowersPage.vue';

import store from './store';

Vue.use(VueRouter);

export default new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            component: HomePage,
            name: 'home',
            beforeEnter: (to, from, next)=>{
                if(store.state.token == null){
                    next('/login');
                }else{
                    next();
                }
            }
        },
        {
            path: '/login',
            name: 'login',
            component: LoginPage

        },
        {
            path: '/register',
            name: 'register',
            component: RegisterPage
        },
        {
            path: '/users/:userId',
            name: 'user_detail',
            component: UserPage,
            props: true,
            children: [
                {
                    path: 'followers',
                    name: 'followers',
                    component: FollowersPage
                },
                {
                    path: 'followings',
                    name: 'followings',
                    component: FollowingsPage
                },
                {
                    path: 'notes',
                    name: 'user_notes',

                }
            ]
        },
        {
            path: '/notes/search-by-tag/:name',
            name: 'search_by_tag',
            component: TagNotePage
        }

    ]
});