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

_vue["default"].use(_vuex["default"]);

var _default = new _vuex["default"].Store({
  namespaced: true,
  state: {
    user: null,
    token: localStorage.getItem("token"),
    timeline: {
      notes: [],
      isLoading: false
    }
  },
  getters: {},
  mutations: {
    setAccount: function setAccount(state, _ref) {
      var token = _ref.token,
          user = _ref.user;
      state.user = user;
      state.token = token;
    },
    setToken: function setToken(_state, token) {
      localStorage.setItem('token', token);
    },
    pushNotes: function pushNotes(state, notes) {
      state.timeline.notes.push(notes);
    },
    addNotesAtTheFirst: function addNotesAtTheFirst(state, notes) {
      state.timeline.notes.splice(0, 0, notes);
    }
  },
  actions: {
    register: function register(_ref2, req) {
      var commit, response;
      return regeneratorRuntime.async(function register$(_context) {
        while (1) {
          switch (_context.prev = _context.next) {
            case 0:
              commit = _ref2.commit;
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
              }

              return _context.abrupt("return", response);

            case 6:
            case "end":
              return _context.stop();
          }
        }
      }, null, this);
    },
    login: function login(_ref3, req) {
      var commit, data, res;
      return regeneratorRuntime.async(function login$(_context2) {
        while (1) {
          switch (_context2.prev = _context2.next) {
            case 0:
              commit = _ref3.commit;
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
              }

              return _context2.abrupt("return", res);

            case 7:
            case "end":
              return _context2.stop();
          }
        }
      });
    },
    loadMe: function loadMe(_ref4) {
      var commit, token, res, account;
      return regeneratorRuntime.async(function loadMe$(_context3) {
        while (1) {
          switch (_context3.prev = _context3.next) {
            case 0:
              commit = _ref4.commit;
              console.log(this.state);
              token = this.state.token;

              if (!token) {
                token = localStorage.getItem("token");
                commit('setAccount', {
                  token: token,
                  user: null
                });
              }

              console.log("token: ".concat(token));
              _context3.next = 7;
              return regeneratorRuntime.awrap(_axios["default"].get('/api/me', {
                headers: {
                  Authorization: "Bearer ".concat(token)
                }
              }));

            case 7:
              res = _context3.sent;

              if (!(res.status == 200)) {
                _context3.next = 12;
                break;
              }

              account = {
                token: token,
                user: res.data
              };
              commit("setAccount", account);
              return _context3.abrupt("return", account);

            case 12:
              return _context3.abrupt("return", null);

            case 13:
            case "end":
              return _context3.stop();
          }
        }
      }, null, this);
    },
    logout: function logout(_ref5) {
      var commit = _ref5.commit;
      commit('setAccount', {
        token: null,
        user: null
      });
    },
    createNote: function createNote(_ref6, note) {
      var commit;
      return regeneratorRuntime.async(function createNote$(_context4) {
        while (1) {
          switch (_context4.prev = _context4.next) {
            case 0:
              commit = _ref6.commit;
              _context4.next = 3;
              return regeneratorRuntime.awrap(_axios["default"].post('api/notes', note, {
                headers: {
                  Authorization: "Bearer ".concat(this.state.token)
                }
              }));

            case 3:
              return _context4.abrupt("return", _context4.sent);

            case 4:
            case "end":
              return _context4.stop();
          }
        }
      }, null, this);
    }
  }
});

exports["default"] = _default;