import VueRouter from 'vue-router';
import Vue from 'vue';
import LoginPage from './pages/LoginPage.vue';
import RegisterPage from './pages/RegisterPage.vue';
import HomePage from './pages/HomePage.vue';
import UserPage from './pages/UserPage.vue';
import TagNotePage from './pages/TagsNotePage.vue';
import FollowingsPage from './pages/users/FollowingsPage.vue';
import FollowersPage from './pages/users/FollowersPage.vue';
import UserNotesPage from './pages/users/UserNotesPage.vue';
import HomeTimeline from './organisms/HomeTimeline.vue';
import UserDetail from './organisms/UserDetail.vue';
import UserNotification from './organisms/UserNotification.vue';

import store from './store';

Vue.use(VueRouter);

export default new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            component: HomePage,
            name: 'home',
            children: [
                {
                    path: "",
                    name: "home_timeline",
                    component: HomeTimeline
                },{
                    path: 'users/:userId',
                    component: UserDetail,
                    props: true,
                    children: [
                        {
                            path: 'followers',
                            name: 'followers',
                            component: FollowersPage,
                            props: true
                        },
                        {
                            path: 'followings',
                            name: 'followings',
                            component: FollowingsPage,
                            props: true
        
                        },
                        {
                            path: '',
                            name: 'user_notes',
                            props: true,
                            component: UserNotesPage
        
                        }
                    ]
                },
                {
                    path: 'notifications',
                    name: 'notifications',
                    component: UserNotification
                }
            ],
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
            path: '/notes/search-by-tag/:name',
            name: 'search_by_tag',
            component: TagNotePage
        }

    ]
});