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
import Comments from './organisms/Comments';
import FavoriteNotes from './organisms/FavoriteNotes';
import UserSetting from './pages/UserSetting';

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
                },
                {
                    path: 'favorites',
                    name: 'favorites',
                    component: FavoriteNotes
                },
                {
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
                    path: 'search-by-tag',
                    name: 'searchByTag',
                    props: true,
                    component: SearchNotes
                },
                {
                    path: 'notes/:noteId',
                    name: 'note_replies',
                    props: true,
                    component: Comments
                },
                {
                    path: 'notes/:noteId/comments/:commentId',
                    name: 'comment_replies',
                    props: true,
                    component: Comments
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
            path: '/profile',
            component: UserSetting
        }
        
        

    ],
    scrollBehavior (to, from, savedPosition) {
        if (savedPosition) {
          return savedPosition
        } else {
          return { x: 0, y: 0 }
        }
      }
});