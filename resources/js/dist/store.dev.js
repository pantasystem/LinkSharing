"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports["default"] = void 0;

var _vuex = _interopRequireDefault(require("vuex"));

var _vue = _interopRequireDefault(require("vue"));

var _axios = _interopRequireDefault(require("axios"));

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { "default": obj }; }

function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(source, true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(source).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

_vue["default"].use(_vuex["default"]);

var _default = new _vuex["default"].Store({
  namespaced: true,
  state: {
    user: null,
    token: null
  },
  getters: {},
  mutations: {
    setAccount: function setAccount(state, _ref) {
      var token = _ref.token,
          user = _ref.user;
      state.user = user;
      state.token = token;
    }
  },
  actions: {
    createAccount: function createAccount(_ref2, _ref3) {
      var commit, email, userName, password, confirmPassword, response;
      return regeneratorRuntime.async(function createAccount$(_context) {
        while (1) {
          switch (_context.prev = _context.next) {
            case 0:
              commit = _ref2.commit;
              email = _ref3.email, userName = _ref3.userName, password = _ref3.password, confirmPassword = _ref3.confirmPassword;
              _context.next = 4;
              return regeneratorRuntime.awrap(_axios["default"].post('/api/register', {
                email: email,
                userName: userName,
                password: password,
                confirmPassword: confirmPassword,
                deviceName: 'Client'
              }));

            case 4:
              response = _context.sent;

              if (response.data) {
                commit("setAccount", response.data);
              }

              return _context.abrupt("return", response);

            case 7:
            case "end":
              return _context.stop();
          }
        }
      });
    },
    login: function login(_ref4, req) {
      var commit, data, res;
      return regeneratorRuntime.async(function login$(_context2) {
        while (1) {
          switch (_context2.prev = _context2.next) {
            case 0:
              commit = _ref4.commit;
              data = _objectSpread({}, req, {
                device_name: 'Web Client'
              });
              _context2.next = 4;
              return regeneratorRuntime.awrap(_axios["default"].post('/api/login', data));

            case 4:
              res = _context2.sent;

              if (res.data) {
                commit("setAccount", res.data);
              }

              return _context2.abrupt("return", res);

            case 7:
            case "end":
              return _context2.stop();
          }
        }
      });
    }
  }
});

exports["default"] = _default;