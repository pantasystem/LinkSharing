import VueRouter from 'vue-router';
import Vue from 'vue';
import LoginPage from './pages/LoginPage.vue';
import RegisterPage from './pages/RegisterPage.vue';
import HomePage from './pages/HomePage.vue';
import Followings from './organisms/users/Followings.vue';
import Followers from './organisms/users/Followers.vue';
import UserNotes from './organisms/users/UserNotes.vue';
import HomeTimeline from './organisms/HomeTimeline.vue';
import UserDetail from './organisms/UserDetail.vue';
import UserNotification from './organisms/UserNotification.vue';
import SearchNotes from './organisms/SearchNotes.vue';

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
                            component: Followers,
                            props: true
                        },
                        {
                            path: 'followings',
                            name: 'followings',
                            component: Followings,
                            props: true
        
                        },
                        {
                            path: '',
                            name: 'user_notes',
                            props: true,
                            component: UserNotes
        
                        }
                    ]
                },
                {
                    path: 'notifications',
                    name: 'notifications',
                    component: UserNotification
                },
                {
                    path: 'search-by-tag/:search_condition',
                    name: 'searchByTag',
                    props: true,
                    component: SearchNotes
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
        
        

    ]
});