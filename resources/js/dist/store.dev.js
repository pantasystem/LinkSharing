"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports["default"] = void 0;

var _vuex = _interopRequireDefault(require("vuex"));

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { "default": obj }; }

var _default = new _vuex["default"].Store({
  namespaced: true,
  state: {
    account: null,
    notes: []
  },
  getters: {},
  mutations: {},
  actions: {}
});

exports["default"] = _default;