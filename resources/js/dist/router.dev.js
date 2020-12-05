"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports["default"] = void 0;

var _vueRouter = _interopRequireDefault(require("vue-router"));

var _vue = _interopRequireDefault(require("vue"));

var _LoginPage = _interopRequireDefault(require("./pages/LoginPage.vue"));

var _RegisterPage = _interopRequireDefault(require("./pages/RegisterPage.vue"));

var _HomePage = _interopRequireDefault(require("./pages/HomePage.vue"));

var _Followings = _interopRequireDefault(require("./organisms/users/Followings.vue"));

var _Followers = _interopRequireDefault(require("./organisms/users/Followers.vue"));

var _UserNotes = _interopRequireDefault(require("./organisms/users/UserNotes.vue"));

var _HomeTimeline = _interopRequireDefault(require("./organisms/HomeTimeline.vue"));

var _UserDetail = _interopRequireDefault(require("./organisms/UserDetail.vue"));

var _UserNotification = _interopRequireDefault(require("./organisms/UserNotification.vue"));

var _SearchNotes = _interopRequireDefault(require("./organisms/SearchNotes.vue"));

var _store = _interopRequireDefault(require("./store"));

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { "default": obj }; }

_vue["default"].use(_vueRouter["default"]);

var _default = new _vueRouter["default"]({
  mode: 'history',
  routes: [{
    path: '/',
    component: _HomePage["default"],
    name: 'home',
    children: [{
      path: "",
      name: "home_timeline",
      component: _HomeTimeline["default"]
    }, {
      path: 'users/:userId',
      component: _UserDetail["default"],
      props: true,
      children: [{
        path: 'followers',
        name: 'followers',
        component: _Followers["default"],
        props: true
      }, {
        path: 'followings',
        name: 'followings',
        component: _Followings["default"],
        props: true
      }, {
        path: '',
        name: 'user_notes',
        props: true,
        component: _UserNotes["default"]
      }]
    }, {
      path: 'notifications',
      name: 'notifications',
      component: _UserNotification["default"]
    }, {
      path: 'search-by-tag/:search_condition',
      name: 'searchByTag',
      props: true,
      component: _SearchNotes["default"]
    }],
    beforeEnter: function beforeEnter(to, from, next) {
      if (_store["default"].state.token == null) {
        next('/login');
      } else {
        next();
      }
    }
  }, {
    path: '/login',
    name: 'login',
    component: _LoginPage["default"]
  }, {
    path: '/register',
    name: 'register',
    component: _RegisterPage["default"]
  }]
});

exports["default"] = _default;