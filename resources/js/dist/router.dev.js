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

var _UserPage = _interopRequireDefault(require("./pages/UserPage.vue"));

var _TagsNotePage = _interopRequireDefault(require("./pages/TagsNotePage.vue"));

var _FollowingsPage = _interopRequireDefault(require("./pages/users/FollowingsPage.vue"));

var _FollowersPage = _interopRequireDefault(require("./pages/users/FollowersPage.vue"));

var _UserNotesPage = _interopRequireDefault(require("./pages/users/UserNotesPage.vue"));

var _HomeTimeline = _interopRequireDefault(require("./organisms/HomeTimeline.vue"));

var _UserDetail = _interopRequireDefault(require("./organisms/UserDetail.vue"));

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
        component: _FollowersPage["default"],
        props: true
      }, {
        path: 'followings',
        name: 'followings',
        component: _FollowingsPage["default"],
        props: true
      }, {
        path: '',
        name: 'user_notes',
        props: true,
        component: _UserNotesPage["default"]
      }]
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
  }, {
    path: '/notes/search-by-tag/:name',
    name: 'search_by_tag',
    component: _TagsNotePage["default"]
  }]
});

exports["default"] = _default;