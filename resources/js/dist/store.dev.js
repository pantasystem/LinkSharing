"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports["default"] = void 0;

var _vuex = _interopRequireDefault(require("vuex"));

var _vue = _interopRequireDefault(require("vue"));

var _axios = _interopRequireDefault(require("axios"));

var _lodash = require("lodash");

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { "default": obj }; }

function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(source, true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(source).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _nonIterableSpread(); }

function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance"); }

function _iterableToArray(iter) { if (Symbol.iterator in Object(iter) || Object.prototype.toString.call(iter) === "[object Arguments]") return Array.from(iter); }

function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) { for (var i = 0, arr2 = new Array(arr.length); i < arr.length; i++) { arr2[i] = arr[i]; } return arr2; } }

_vue["default"].use(_vuex["default"]);

var timeline = {
  namespaced: true,
  state: function state() {
    return {
      notes: [],
      isLoading: false,
      currentPage: 0
    };
  },
  mutations: {
    pushNotes: function pushNotes(state, notes) {
      if (Array.isArray(notes)) {
        var _state$timeline$notes;

        (_state$timeline$notes = state.timeline.notes).push.apply(_state$timeline$notes, _toConsumableArray(notes));
      } else {
        state.timeline.notes.push(notes);
      }
    },
    addNotesAtTheFirst: function addNotesAtTheFirst(state, notes) {
      if (Array.isArray(notes)) {
        var _state$timeline$notes2;

        (_state$timeline$notes2 = state.timeline.notes).unshift.apply(_state$timeline$notes2, _toConsumableArray(notes));
      } else {
        state.timeline.notes.unshift(notes);
      }
    },
    nextPage: function nextPage(state, page) {
      if (Array.isArray(page.data) && page.data.length) {
        var _state$notes;

        (_state$notes = state.notes).push.apply(_state$notes, _toConsumableArray(page.data));
      }

      state.isLoading = false;
      state.currentPage = page.current_page;
    }
  },
  actions: {
    createNote: function createNote(_ref, note) {
      var commit, res, createdNote;
      return regeneratorRuntime.async(function createNote$(_context) {
        while (1) {
          switch (_context.prev = _context.next) {
            case 0:
              commit = _ref.commit;
              _context.next = 3;
              return regeneratorRuntime.awrap(_axios["default"].post('api/notes', note, {
                headers: {
                  Authorization: "Bearer ".concat(this.state.token)
                }
              }));

            case 3:
              res = _context.sent;
              createdNote = res.data;
              commit('addNotesAtTheFirst', createdNote);
              return _context.abrupt("return", res);

            case 7:
            case "end":
              return _context.stop();
          }
        }
      }, null, this);
    },
    loadNext: function loadNext(_ref2) {
      var commit = _ref2.commit,
          state = _ref2.state,
          rootState = _ref2.rootState;

      if (state.isLoading) {
        return;
      }

      state.isLoading = true;
      console.log("load開始");
      console.log(rootState.token);

      _axios["default"].get('/api/notes', {
        headers: {
          Authorization: "Bearer ".concat(rootState.token)
        },
        params: {
          page: state.currentPage + 1
        }
      }).then(function (res) {
        commit('nextPage', res.data);
      })["catch"](function (e) {
        console.log(e);
        commit('nextPage', null);
      });
    },
    initTimeline: function initTimeline(context) {
      console.log("initTimeline開始しました");
      context.state.notes = [];
      context.state.isLoading = false;
      context.state.currentPage = 0;
      context.dispatch('loadNext');
    }
  }
};
var notification = {
  namespaced: true,
  state: function state() {
    return {
      notifications: [],
      isLoading: false,
      currentPage: 0
    };
  },
  mutations: {
    pushNotifications: function pushNotifications(_ref3, notifications) {
      var _state$notifications;

      var state = _ref3.state;

      (_state$notifications = state.notifications).push.apply(_state$notifications, _toConsumableArray(notifications));
    },
    setNotifications: function setNotifications(_ref4, notifications) {
      var state = _ref4.state;
      state.notifications = notifications;
    },
    setLoading: function setLoading(_ref5, isLoading) {
      var state = _ref5.state;
      state.isLoading = isLoading;
    },
    setCurrentPage: function setCurrentPage(_ref6, page) {
      var state = _ref6.state;
      state.currentPage = page;
    }
  },
  actions: {
    loadNext: function loadNext(_ref7) {
      var commit = _ref7.commit,
          state = _ref7.state,
          rootState = _ref7.rootState;
      console.log("notification#loadNext");

      if (state.isLoading) {
        return;
      }

      commit('setLoading', true);
      var token = rootState.token;

      _axios["default"].get('/api/notifications', {
        headers: {
          Authorization: "Bearer ".concat(token)
        },
        params: {
          page: state.currentPage + 1
        }
      }).then(function (res) {
        commit('pushNotifications', res.data);
        commit('setCurrentPage', res.current_page);
        commit('setLoading', false);
      })["catch"](function (e) {
        console.log(e);
      });
    },
    init: function init(_ref8) {
      var commit = _ref8.commit;
      commit('setLoading', false);
      commit('setNotifications', []);
      commit('setCurrentPage', 0);
    }
  }
};

var _default = new _vuex["default"].Store({
  namespaced: true,
  modules: {
    'timeline': timeline,
    'notification': notification
  },
  state: {
    user: null,
    token: localStorage.getItem("token")
  },
  mutations: {
    setAccount: function setAccount(state, _ref9) {
      var token = _ref9.token,
          user = _ref9.user;
      state.user = user;
      state.token = token;
    },
    setToken: function setToken(_state, token) {
      localStorage.setItem('token', token);
    }
  },
  getters: {
    token: function token(_ref10) {
      var state = _ref10.state;
      return state.token;
    }
  },
  actions: {
    register: function register(_ref11, req) {
      var commit, response;
      return regeneratorRuntime.async(function register$(_context2) {
        while (1) {
          switch (_context2.prev = _context2.next) {
            case 0:
              commit = _ref11.commit;
              _context2.next = 3;
              return regeneratorRuntime.awrap(_axios["default"].post('/api/register', {
                email: req.email,
                user_name: req.userName,
                password: req.password,
                password_confirmation: req.confirmPassword,
                device_name: 'Client'
              }));

            case 3:
              response = _context2.sent;

              if (response.data) {
                this.localStorage.setItem("token", response.data.token);
                commit("setAccount", response.data);
              }

              return _context2.abrupt("return", response);

            case 6:
            case "end":
              return _context2.stop();
          }
        }
      }, null, this);
    },
    login: function login(_ref12, req) {
      var commit, data, res;
      return regeneratorRuntime.async(function login$(_context3) {
        while (1) {
          switch (_context3.prev = _context3.next) {
            case 0:
              commit = _ref12.commit;
              data = _objectSpread({}, req, {
                device_name: 'Web Client'
              });
              _context3.next = 4;
              return regeneratorRuntime.awrap(_axios["default"].post('/api/login', data));

            case 4:
              res = _context3.sent;

              if (res.data) {
                localStorage.setItem("token", res.data.token);
                commit("setAccount", res.data);
              }

              return _context3.abrupt("return", res);

            case 7:
            case "end":
              return _context3.stop();
          }
        }
      });
    },
    loadMe: function loadMe(_ref13) {
      var commit, token, res, account;
      return regeneratorRuntime.async(function loadMe$(_context4) {
        while (1) {
          switch (_context4.prev = _context4.next) {
            case 0:
              commit = _ref13.commit;
              token = this.state.token;

              if (!token) {
                token = localStorage.getItem("token");
                commit('setAccount', {
                  token: token,
                  user: null
                });
              }

              _context4.next = 5;
              return regeneratorRuntime.awrap(_axios["default"].get('/api/me', {
                headers: {
                  Authorization: "Bearer ".concat(token)
                }
              }));

            case 5:
              res = _context4.sent;

              if (!(res.status == 200)) {
                _context4.next = 10;
                break;
              }

              account = {
                token: token,
                user: res.data
              };
              commit("setAccount", account);
              return _context4.abrupt("return", account);

            case 10:
              return _context4.abrupt("return", null);

            case 11:
            case "end":
              return _context4.stop();
          }
        }
      }, null, this);
    },
    logout: function logout(_ref14) {
      var commit = _ref14.commit;
      commit('setAccount', {
        token: null,
        user: null
      });
    },
    follow: function follow(context, user) {
      var res;
      return regeneratorRuntime.async(function follow$(_context5) {
        while (1) {
          switch (_context5.prev = _context5.next) {
            case 0:
              _context5.next = 2;
              return regeneratorRuntime.awrap(_axios["default"].post("/api/users/".concat(user.id), null, {
                headers: {
                  Authorization: "Bearer ".concat(context.state.token)
                }
              }));

            case 2:
              res = _context5.sent;
              context.dispatch('timeline/initTimeline');
              return _context5.abrupt("return", res.data);

            case 5:
            case "end":
              return _context5.stop();
          }
        }
      });
    },
    unfollow: function unfollow(context, user) {
      var res;
      return regeneratorRuntime.async(function unfollow$(_context6) {
        while (1) {
          switch (_context6.prev = _context6.next) {
            case 0:
              _context6.next = 2;
              return regeneratorRuntime.awrap(_axios["default"]["delete"]("/api/users/".concat(user.id), {
                headers: {
                  Authorization: "Bearer ".concat(context.state.token)
                }
              }));

            case 2:
              res = _context6.sent;
              context.dispatch('timeline/initTimeline');
              return _context6.abrupt("return", res.data);

            case 5:
            case "end":
              return _context6.stop();
          }
        }
      });
    }
  }
});

exports["default"] = _default;