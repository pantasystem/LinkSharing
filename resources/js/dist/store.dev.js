"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports["default"] = void 0;

var _vuex = _interopRequireDefault(require("vuex"));

var _vue = _interopRequireDefault(require("vue"));

var _axios = _interopRequireDefault(require("axios"));

var _lodash = require("lodash");

var _timeline = _interopRequireDefault(require("./store/timeline"));

var _notification = _interopRequireDefault(require("./store/notification"));

var _users = _interopRequireDefault(require("./store/users"));

var _notes = _interopRequireDefault(require("./store/notes"));

var _streaming = _interopRequireDefault(require("./streaming"));

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { "default": obj }; }

function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(source, true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(source).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

_vue["default"].use(_vuex["default"]);

var _default = new _vuex["default"].Store({
  namespaced: true,
  modules: {
    'timeline': _timeline["default"],
    'notification': _notification["default"],
    'users': _users["default"],
    'notes': _notes["default"]
  },
  state: {
    user: null,
    token: localStorage.getItem("token")
  },
  mutations: {
    setAccount: function setAccount(state, _ref) {
      var token = _ref.token,
          user = _ref.user;
      localStorage.setItem('token', token);
      state.user = user;
      state.token = token;
    },
    setToken: function setToken(_state, token) {
      localStorage.setItem('token', token);
    }
  },
  getters: {
    token: function token(_ref2) {
      var state = _ref2.state;
      return state.token;
    }
  },
  actions: {
    register: function register(_ref3, req) {
      var commit, dispatch, response;
      return regeneratorRuntime.async(function register$(_context) {
        while (1) {
          switch (_context.prev = _context.next) {
            case 0:
              commit = _ref3.commit, dispatch = _ref3.dispatch;
              _context.next = 3;
              return regeneratorRuntime.awrap(_axios["default"].post('/api/register', {
                email: req.email,
                user_name: req.userName,
                password: req.password,
                password_confirmation: req.confirmPassword,
                device_name: 'Client'
              }));

            case 3:
              response = _context.sent;

              if (response.data) {
                this.localStorage.setItem("token", response.data.token);
                commit("setAccount", response.data);
                dispatch('listen');
              }

              return _context.abrupt("return", response);

            case 6:
            case "end":
              return _context.stop();
          }
        }
      }, null, this);
    },
    login: function login(_ref4, req) {
      var commit, dispatch, data, res;
      return regeneratorRuntime.async(function login$(_context2) {
        while (1) {
          switch (_context2.prev = _context2.next) {
            case 0:
              commit = _ref4.commit, dispatch = _ref4.dispatch;
              data = _objectSpread({}, req, {
                device_name: 'Web Client'
              });
              _context2.next = 4;
              return regeneratorRuntime.awrap(_axios["default"].post('/api/login', data));

            case 4:
              res = _context2.sent;

              if (res.data) {
                localStorage.setItem("token", res.data.token);
                commit("setAccount", res.data);
                dispatch('listen');
              }

              return _context2.abrupt("return", res);

            case 7:
            case "end":
              return _context2.stop();
          }
        }
      });
    },
    loadMe: function loadMe(_ref5) {
      var commit, dispatch, token, res, account;
      return regeneratorRuntime.async(function loadMe$(_context3) {
        while (1) {
          switch (_context3.prev = _context3.next) {
            case 0:
              commit = _ref5.commit, dispatch = _ref5.dispatch;
              token = this.state.token;

              if (!token) {
                token = localStorage.getItem("token");
                commit('setAccount', {
                  token: token,
                  user: null
                });
              }

              _context3.next = 5;
              return regeneratorRuntime.awrap(_axios["default"].get('/api/me', {
                headers: {
                  Authorization: "Bearer ".concat(token)
                }
              }));

            case 5:
              res = _context3.sent;

              if (!(res.status == 200)) {
                _context3.next = 11;
                break;
              }

              account = {
                token: token,
                user: res.data
              };
              commit("setAccount", account);
              dispatch('listen');
              return _context3.abrupt("return", account);

            case 11:
              return _context3.abrupt("return", null);

            case 12:
            case "end":
              return _context3.stop();
          }
        }
      }, null, this);
    },
    logout: function logout(_ref6) {
      var commit = _ref6.commit,
          dispatch = _ref6.dispatch;
      commit('setAccount', {
        token: null,
        user: null
      });
      dispatch('timeline/init');
      dispatch('notification/init');
      dispatch('dispose');
    },
    follow: function follow(context, user) {
      var res;
      return regeneratorRuntime.async(function follow$(_context4) {
        while (1) {
          switch (_context4.prev = _context4.next) {
            case 0:
              _context4.next = 2;
              return regeneratorRuntime.awrap(_axios["default"].post("/api/users/".concat(user.id), null, {
                headers: {
                  Authorization: "Bearer ".concat(context.state.token)
                }
              }));

            case 2:
              res = _context4.sent;
              context.commit('user', res.data);
              context.dispatch('timeline/initTimeline');
              return _context4.abrupt("return", res.data);

            case 6:
            case "end":
              return _context4.stop();
          }
        }
      });
    },
    unfollow: function unfollow(context, user) {
      var res;
      return regeneratorRuntime.async(function unfollow$(_context5) {
        while (1) {
          switch (_context5.prev = _context5.next) {
            case 0:
              _context5.next = 2;
              return regeneratorRuntime.awrap(_axios["default"]["delete"]("/api/users/".concat(user.id), {
                headers: {
                  Authorization: "Bearer ".concat(context.state.token)
                }
              }));

            case 2:
              res = _context5.sent;
              context.commit('user', res.data);
              context.dispatch('timeline/initTimeline');
              return _context5.abrupt("return", res.data);

            case 6:
            case "end":
              return _context5.stop();
          }
        }
      });
    },
    dispose: function dispose() {
      _streaming["default"].disconnect();
    },
    listen: function listen(_ref7) {
      var state = _ref7.state;

      _streaming["default"].connect(state.token);

      var echo = _streaming["default"].getEcho();

      console.assert(echo != null, "echoがNULLです");
      console.assert(state.user.id, "user.idが無効です");
      echo["private"]("notifications.subscriber.".concat(state.user.id)).listen('Notified', function (e) {
        console.log("通知が来ました");
        console.log(e);
      });
      console.log("listen処理完了");
    }
  }
});

exports["default"] = _default;