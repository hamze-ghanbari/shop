/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./public/js/modules/event.js":
/*!************************************!*\
  !*** ./public/js/modules/event.js ***!
  \************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "formEvent": () => (/* binding */ formEvent)
/* harmony export */ });
/* harmony import */ var _validation__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./validation */ "./public/js/modules/validation.js");

function formEvent(selector, event, handler) {
  document.querySelector(selector).addEventListener(event, function () {
    handler();
    // if (event.target.tagName === 'INPUT' && event.target.type === 'text') {

    // }
  });
}

/***/ }),

/***/ "./public/js/modules/route.js":
/*!************************************!*\
  !*** ./public/js/modules/route.js ***!
  \************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "RouteNames": () => (/* binding */ RouteNames),
/* harmony export */   "currentRoute": () => (/* binding */ currentRoute),
/* harmony export */   "getAllParam": () => (/* binding */ getAllParam),
/* harmony export */   "getHost": () => (/* binding */ getHost),
/* harmony export */   "getOrigin": () => (/* binding */ getOrigin),
/* harmony export */   "getParam": () => (/* binding */ getParam),
/* harmony export */   "getRouteByName": () => (/* binding */ getRouteByName),
/* harmony export */   "requestUrl": () => (/* binding */ requestUrl),
/* harmony export */   "setParam": () => (/* binding */ setParam)
/* harmony export */ });
function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }
function _defineProperty(obj, key, value) { key = _toPropertyKey(key); if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }
function _toPropertyKey(arg) { var key = _toPrimitive(arg, "string"); return _typeof(key) === "symbol" ? key : String(key); }
function _toPrimitive(input, hint) { if (_typeof(input) !== "object" || input === null) return input; var prim = input[Symbol.toPrimitive]; if (prim !== undefined) { var res = prim.call(input, hint || "default"); if (_typeof(res) !== "object") return res; throw new TypeError("@@toPrimitive must return a primitive value."); } return (hint === "string" ? String : Number)(input); }
var RouteNames = {
  'roles.create': 'roles/create',
  'categories.create': 'products/categories/create'
};
function getParam(param) {
  var params = new URLSearchParams(location.search);
  if (params.has(param)) {
    return params.get(param);
  } else {
    return '';
  }
}
function getAllParam() {
  var params = new URLSearchParams(location.search);
  var result = [];
  params.forEach(function (item, index) {
    result.push(_defineProperty({}, index, item));
  });
  return result;
}
function setParam(name, value) {
  var url = new URL(window.location);
  url.searchParams.set(name, value);
  window.history.pushState({}, '', url);
}
function getOrigin() {
  return location.origin;
}
function currentRoute() {
  return location.pathname;
}
function requestUrl(url) {
  return getOrigin() + url;
}
function getHost() {
  var host = document.URL.split(':').shift();
  if (host === "http") {
    return "http://" + document.domain + ':' + location.port;
  } else if (host === "https") {
    return "https://" + document.domain + ':' + location.port;
  } else {
    return false;
  }
}
function getRouteByName(name) {
  return getOrigin() + '/' + RouteNames[name];
}

/***/ }),

/***/ "./public/js/modules/validation.js":
/*!*****************************************!*\
  !*** ./public/js/modules/validation.js ***!
  \*****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "checkBlacklist": () => (/* binding */ checkBlacklist),
/* harmony export */   "checkPattern": () => (/* binding */ checkPattern),
/* harmony export */   "email": () => (/* binding */ email),
/* harmony export */   "emailRegex": () => (/* binding */ emailRegex),
/* harmony export */   "emptyInput": () => (/* binding */ emptyInput),
/* harmony export */   "getData": () => (/* binding */ getData),
/* harmony export */   "isNumber": () => (/* binding */ isNumber),
/* harmony export */   "max": () => (/* binding */ max),
/* harmony export */   "maxLength": () => (/* binding */ maxLength),
/* harmony export */   "min": () => (/* binding */ min),
/* harmony export */   "minLength": () => (/* binding */ minLength),
/* harmony export */   "nationalCode": () => (/* binding */ nationalCode),
/* harmony export */   "phone": () => (/* binding */ phone),
/* harmony export */   "phoneRegex": () => (/* binding */ phoneRegex),
/* harmony export */   "required": () => (/* binding */ required),
/* harmony export */   "showErrors": () => (/* binding */ showErrors)
/* harmony export */ });
function _createForOfIteratorHelper(o, allowArrayLike) { var it = typeof Symbol !== "undefined" && o[Symbol.iterator] || o["@@iterator"]; if (!it) { if (Array.isArray(o) || (it = _unsupportedIterableToArray(o)) || allowArrayLike && o && typeof o.length === "number") { if (it) o = it; var i = 0; var F = function F() {}; return { s: F, n: function n() { if (i >= o.length) return { done: true }; return { done: false, value: o[i++] }; }, e: function e(_e) { throw _e; }, f: F }; } throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); } var normalCompletion = true, didErr = false, err; return { s: function s() { it = it.call(o); }, n: function n() { var step = it.next(); normalCompletion = step.done; return step; }, e: function e(_e2) { didErr = true; err = _e2; }, f: function f() { try { if (!normalCompletion && it["return"] != null) it["return"](); } finally { if (didErr) throw err; } } }; }
function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }
function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) arr2[i] = arr[i]; return arr2; }
var blackList = ["!", "'", ';', '<', '>', '#', '%27', 'script', 'delete', 'DELETE', 'hack', '"', 'cookie', 'document', 'alert', '<script>', '</script>', 'document.cookie'];
var phoneRegex = /^[0]{1}[9]{1}[0-9]{9}$/;
var emailRegex = /^[a-z \d]{1,40}@[a-z \d]{1,40}\.[a-z]{2,10}$/i;
function createIconInput(parent, icon, color) {
  var _iterator = _createForOfIteratorHelper(parent.children),
    _step;
  try {
    for (_iterator.s(); !(_step = _iterator.n()).done;) {
      var child = _step.value;
      if (child.tagName === 'I') {
        child.removeAttribute('class');
        child.classList.add("fa-solid", "fa-".concat(icon), "".concat(color, "__default"));
      }
    }
  } catch (err) {
    _iterator.e(err);
  } finally {
    _iterator.f();
  }
}
function errorClass(parent) {
  parent.classList.remove(arguments.length <= 1 ? undefined : arguments[1]);
  parent.classList.add(arguments.length <= 2 ? undefined : arguments[2]);
}
function blacklistFn(input) {
  var result = [];
  var _iterator2 = _createForOfIteratorHelper(blackList),
    _step2;
  try {
    for (_iterator2.s(); !(_step2 = _iterator2.n()).done;) {
      var black = _step2.value;
      if (input.value.toLowerCase().match(black)) {
        // input.value = input.value.replace(black, '');
        result.push(black);
      }
    }
  } catch (err) {
    _iterator2.e(err);
  } finally {
    _iterator2.f();
  }
  return result;
}
function required(elements) {
  var result = false;
  var _iterator3 = _createForOfIteratorHelper(elements),
    _step3;
  try {
    for (_iterator3.s(); !(_step3 = _iterator3.n()).done;) {
      var element = _step3.value;
      var field = document.getElementsByName(element['name']);
      var messageBox = document.getElementById("error-".concat(element['name'].replace('_', '-')));
      if (field[0].value.trim().length === 0) {
        var _element$message;
        // allSelectorsError.push(element['name']);
        // allErrors[element['name']] = [...element['message'] ?? `وارد کردن ${element['attribute']} الزامی است`];
        messageBox.innerText = (_element$message = element['message']) !== null && _element$message !== void 0 ? _element$message : "\u0648\u0627\u0631\u062F \u06A9\u0631\u062F\u0646 ".concat(element['attribute'], " \u0627\u0644\u0632\u0627\u0645\u06CC \u0627\u0633\u062A");
        errorClass(field[0].parentNode, 'border-success', 'border-red');
        createIconInput(field[0].parentNode, 'warning', 'red');
        result = true;
      } else {
        messageBox.innerText = '';
        errorClass(field[0].parentNode, 'border-red', 'border-success');
        createIconInput(field[0].parentNode, 'check', 'green');
      }
    }
  } catch (err) {
    _iterator3.e(err);
  } finally {
    _iterator3.f();
  }
  return result;
}
function email(value) {
  var result = true;
  if (!emailRegex.test(value)) {
    result = false;
  }
  return result;
}
function max(elements) {
  var result = false;
  var _iterator4 = _createForOfIteratorHelper(elements),
    _step4;
  try {
    for (_iterator4.s(); !(_step4 = _iterator4.n()).done;) {
      var element = _step4.value;
      var field = document.getElementsByName(element['name']);
      var messageBox = document.getElementById("error-".concat(element['name'].replace('_', '-')));
      if (field[0].value > element.length) {
        messageBox.innerText = "\u0639\u062F\u062F \u0648\u0627\u0631\u062F \u0634\u062F\u0647 \u0628\u0627\u06CC\u062F \u06A9\u0645\u062A\u0631 \u0627\u0632  ".concat(element.length, " \u0628\u0627\u0634\u062F");
        errorClass(field[0].parentNode, 'border-success', 'border-red');
        createIconInput(field[0].parentNode, 'warning', 'red');
        result = true;
      } else {
        messageBox.innerText = '';
        errorClass(field[0].parentNode, 'border-red', 'border-success');
        createIconInput(field[0].parentNode, 'check', 'green');
      }
    }
  } catch (err) {
    _iterator4.e(err);
  } finally {
    _iterator4.f();
  }
  return result;
}
function min(elements) {
  var result = false;
  var _iterator5 = _createForOfIteratorHelper(elements),
    _step5;
  try {
    for (_iterator5.s(); !(_step5 = _iterator5.n()).done;) {
      var element = _step5.value;
      var field = document.getElementsByName(element['name']);
      var messageBox = document.getElementById("error-".concat(element['name'].replace('_', '-')));
      if (field[0].value < element.length) {
        messageBox.innerText = "\u0639\u062F\u062F \u0648\u0627\u0631\u062F \u0634\u062F\u0647 \u0628\u0627\u06CC\u062F \u0628\u06CC\u0634\u062A\u0631 \u0627\u0632  ".concat(element.length, " \u0628\u0627\u0634\u062F");
        errorClass(field[0].parentNode, 'border-success', 'border-red');
        createIconInput(field[0].parentNode, 'warning', 'red');
        result = true;
      } else {
        messageBox.innerText = '';
        errorClass(field[0].parentNode, 'border-red', 'border-success');
        createIconInput(field[0].parentNode, 'check', 'green');
      }
    }
  } catch (err) {
    _iterator5.e(err);
  } finally {
    _iterator5.f();
  }
  return result;
}
function phone(value) {
  var result = true;
  if (!phoneRegex.test(value)) {
    result = false;
  }
  return result;
}
function maxLength(elements) {
  var result = false;
  var _iterator6 = _createForOfIteratorHelper(elements),
    _step6;
  try {
    for (_iterator6.s(); !(_step6 = _iterator6.n()).done;) {
      var element = _step6.value;
      var field = document.getElementsByName(element['name']);
      var messageBox = document.getElementById("error-".concat(element['name'].replace('_', '-')));
      if (field[0].value.trim().length > element['length']) {
        // allSelectorsError.push(element['name']);
        // allErrors[element['name']] = [element['message']];
        messageBox.innerText = element['message'];
        errorClass(field[0].parentNode, 'border-success', 'border-red');
        createIconInput(field[0].parentNode, 'warning', 'red');
        result = true;
      } else {
        messageBox.innerText = '';
        // allSelectorsError.splice(allSelectorsError.indexOf(element['name']), 1);
        errorClass(field[0].parentNode, 'border-red', 'border-success');
        createIconInput(field[0].parentNode, 'check', 'green');
      }
    }
  } catch (err) {
    _iterator6.e(err);
  } finally {
    _iterator6.f();
  }
  return result;
}
function minLength(elements) {
  var result = false;
  var _iterator7 = _createForOfIteratorHelper(elements),
    _step7;
  try {
    for (_iterator7.s(); !(_step7 = _iterator7.n()).done;) {
      var element = _step7.value;
      var field = document.getElementsByName(element['name']);
      var messageBox = document.getElementById("error-".concat(element['name'].replace('_', '-')));
      if (field[0].value.trim().length < element['length']) {
        messageBox.innerText = element['message'];
        errorClass(field[0].parentNode, 'border-success', 'border-red');
        createIconInput(field[0].parentNode, 'warning', 'red');
        result = true;
      } else {
        messageBox.innerText = '';
        errorClass(field[0].parentNode, 'border-red', 'border-success');
        createIconInput(field[0].parentNode, 'check', 'green');
      }
    }
  } catch (err) {
    _iterator7.e(err);
  } finally {
    _iterator7.f();
  }
  return result;
}
function checkBlacklist(names) {
  var result = [];
  for (var i = 0; i < names.length; i++) {
    var field = document.getElementsByName(names[i]);
    var messageBox = document.getElementById("error-".concat(names[i].replace('_', '-')));
    var black = blacklistFn(field[0]);
    if (black.length > 0) {
      var word = black.length === 1 ? 'کلمه' : 'کلمات';
      messageBox.innerText = "\u0648\u0627\u0631\u062F \u06A9\u0631\u062F\u0646 ".concat(word, " ").concat(black.join(' , '), " \u0645\u062C\u0627\u0632 \u0646\u0645\u06CC \u0628\u0627\u0634\u062F");
      errorClass(field[0].parentNode, 'border-success', 'border-red');
      createIconInput(field[0].parentNode, 'warning', 'red');
      result.push(true);
    } else {
      messageBox.innerText = '';
      errorClass(field[0].parentNode, 'border-red', 'border-success');
      createIconInput(field[0].parentNode, 'check', 'green');
      result.splice(i, 1);
    }
  }
  return result.includes(true);
}
function checkPattern(rules) {
  var result = false;
  var _iterator8 = _createForOfIteratorHelper(rules),
    _step8;
  try {
    for (_iterator8.s(); !(_step8 = _iterator8.n()).done;) {
      var rule = _step8.value;
      var field = document.getElementsByName(rule['name']);
      var messageBox = document.getElementById("error-".concat(rule['name'].replace('_', '-')));
      if (field[0].value.match(rule['regex'])) {
        messageBox.innerText = '';
        errorClass(field[0].parentNode, 'border-red', 'border-success');
        createIconInput(field[0].parentNode, 'check', 'green');
      } else {
        messageBox.innerText = rule['message'];
        errorClass(field[0].parentNode, 'border-success', 'border-red');
        createIconInput(field[0].parentNode, 'warning', 'red');
        result = true;
      }
    }
  } catch (err) {
    _iterator8.e(err);
  } finally {
    _iterator8.f();
  }
  return result;
}
function isNumber(elements) {
  var result = false;
  var _iterator9 = _createForOfIteratorHelper(elements),
    _step9;
  try {
    for (_iterator9.s(); !(_step9 = _iterator9.n()).done;) {
      var element = _step9.value;
      var field = document.getElementsByName(element['name']);
      var messageBox = document.getElementById("error-".concat(element['name'].replace('_', '-')));
      // typeof field[0].value !== 'number'
      if (field[0].value.match('/^[0-9]$/') || isNaN(field[0].value)) {
        messageBox.innerText = "".concat(element['attribute'], " \u0628\u0627\u06CC\u062F \u0639\u062F\u062F \u0628\u0627\u0634\u062F");
        errorClass(field[0].parentNode, 'border-success', 'border-red');
        createIconInput(field[0].parentNode, 'warning', 'red');
        result = true;
      } else {
        messageBox.innerText = '';
        errorClass(field[0].parentNode, 'border-red', 'border-success');
        createIconInput(field[0].parentNode, 'check', 'green');
      }
    }
  } catch (err) {
    _iterator9.e(err);
  } finally {
    _iterator9.f();
  }
  return result;
}
function nationalCode(nationalCode) {
  var selector = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 'national-code';
  var messageBox = document.getElementById("error-".concat(selector));
  var result = false;
  var national = nationalCode.trim(' .');
  // $nationalCode = convertArabicToEnglish($nationalCode);
  // $nationalCode = convertPersianToEnglish($nationalCode);
  var bannedArray = ['0000000000', '1111111111', '2222222222', '3333333333', '4444444444', '5555555555', '6666666666', '7777777777', '8888888888', '9999999999'];
  if (national.length < 1) {
    result = false;
  } else if (national.length !== 10) {
    result = false;
  } else if (bannedArray.includes(national)) {
    result = false;
  } else {
    var sum = 0;
    var lastDigit;
    for (var i = 0; i < 9; i++) {
      sum += +national[i] * (10 - i);
    }
    var divideRemaining = sum % 11;
    if (divideRemaining < 2) {
      lastDigit = divideRemaining;
    } else {
      lastDigit = 11 - divideRemaining;
    }
    result = +national[9] === lastDigit;
  }
  if (!result) {
    messageBox.innerText = 'کد ملی وارد شده معتبر نمی باشد';
  } else {
    messageBox.innerText = '';
  }
  return !result;
}
function emptyInput(selectors) {
  selectors.map(function (item) {
    $("#error-".concat(item)).empty();
  });
}
function showErrors(errors, selectors) {
  selectors.forEach(function (item) {
    var selector = document.getElementById("error-".concat(item.replace('_', '-')));
    selector.innerText = '';
    selector.innerText = errors[item] !== undefined ? errors[item][0] : '';
  });
}
function getData(selectors) {
  var type = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};
  var data = {};
  var element = 'input';
  var typeInput;
  selectors.forEach(function (item) {
    typeInput = type[item] === 'checkbox' ? ':checked' : '';
    // element = type[item] === 'textarea' ? 'textarea' : 'input';
    switch (type[item]) {
      case 'textarea':
        element = 'textarea';
        break;
      case 'select':
        element = 'select';
        break;
      default:
        element = 'input';
        break;
    }
    if (type[item] !== 'file') {
      data[item] = $("".concat(element, "[name=").concat(item, "]").concat(typeInput)).val();
    } else {
      data[item] = $("".concat(element, "[name=").concat(item, "]"))[0].files[0];
    }
  });
  return data;
}

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be isolated against other modules in the chunk.
(() => {
/*!**************************************************!*\
  !*** ./Modules/User/Resources/assets/js/role.js ***!
  \**************************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _public_js_modules_validation__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../../../public/js/modules/validation */ "./public/js/modules/validation.js");
/* harmony import */ var _public_js_modules_route__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../../../../public/js/modules/route */ "./public/js/modules/route.js");
/* harmony import */ var _public_js_modules_event__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../public/js/modules/event */ "./public/js/modules/event.js");




// formEvent('#role-form', 'keyup', function () {
//     let selectors = ['name', 'persian_name', 'status'];
//     required([
//         {
//             name: 'name',
//             attribute: 'نام نقش'
//         }
//     ]);
//     maxLength([
//         {
//             name: 'name',
//             length: 30,
//             message: 'نام نقش نباید بیشتر از 30 کاراکتر باشد'
//         }
//     ]);
//     checkBlacklist(selectors);
// });

$(document).ready(function () {
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $('#role-form').on('submit', function (event) {
    event.preventDefault();
    // console.log(getResultModal());
    // if(getResultModal()){

    var selectors = ['name', 'persian_name', 'status'];
    if ((0,_public_js_modules_validation__WEBPACK_IMPORTED_MODULE_0__.required)([{
      name: 'name',
      attribute: 'نام نقش (انگلیسی)'
    }, {
      name: 'persian_name',
      attribute: 'نام نقش (فارسی)'
    }]) || (0,_public_js_modules_validation__WEBPACK_IMPORTED_MODULE_0__.maxLength)([{
      name: 'name',
      length: 30,
      message: 'نام نقش (انگلیسی) نباید بیشتر از 30 کاراکتر باشد'
    }, {
      name: 'persian_name',
      length: 30,
      message: 'نام نقش (فارسی) نباید بیشتر از 30 کاراکتر باشد'
    }]) || (0,_public_js_modules_validation__WEBPACK_IMPORTED_MODULE_0__.checkPattern)([{
      name: 'name',
      regex: /^([a-z A-Z]{1,30})$/,
      message: 'نام نقش باید به صورت حروف انگلیسی باشد'
    }, {
      name: 'persian_name',
      regex: /^([ضصثقفغعهخحجچشسیبلاتنمکگپظطزرذدئو.ءِ]{1,30})$/,
      message: 'نام نقش باید به صورت حروف فارسی باشد'
    }]) || (0,_public_js_modules_validation__WEBPACK_IMPORTED_MODULE_0__.checkBlacklist)(selectors)) {
      // showErrors();
      return false;
    }
    showLoading();
    var method = typeof $("input[name='_method']").val() === 'undefined' ? 'POST' : $("input[name='_method']").val().toUpperCase();
    $.ajax({
      type: method,
      url: $(this).attr('action'),
      data: (0,_public_js_modules_validation__WEBPACK_IMPORTED_MODULE_0__.getData)(selectors, {
        description: 'textarea',
        status: 'checkbox'
      }),
      statusCode: {
        500: function _() {
          toastError('خطا در ثبت نقش');
        }
      },
      success: function success(_ref) {
        var hasError = _ref.hasError,
          message = _ref.message,
          url = _ref.url,
          updated = _ref.updated;
        hasError ? toastError(message) : toastSuccess(message);
        (0,_public_js_modules_validation__WEBPACK_IMPORTED_MODULE_0__.emptyInput)(selectors);
        if (updated) {
          window.location.href = url;
        }
        hideLoading();
      },
      error: function error(data) {
        if (data.responseJSON.time) {
          // $(".submit-btn").html('ثبت نقش');
          var countDownTime = +new Date().getTime() + data.responseJSON.time;
          var minutes, seconds;
          var time = setInterval(function () {
            var now = new Date().getTime();
            var distance = countDownTime - now;
            minutes = '0' + Math.floor(distance % (1000 * 60 * 60) / (1000 * 60));
            seconds = Math.floor(distance % (1000 * 60) / 1000);
            seconds = seconds < 10 ? '0' + seconds : seconds;
            //                         $('#error-confirm-code').empty().append(`خطا در ارسال اطلاعات . لطفا پس از <span class="small-copy-strong px-1">
            // ${minutes}</span>:<span class="small-copy-strong px-1">${seconds}</span> دوباره امتحان کنید`);
            //                         ;
            if (distance < 0) {
              clearInterval(time);
              (0,_public_js_modules_validation__WEBPACK_IMPORTED_MODULE_0__.emptyInput)([selectors]);
              $('.submit-btn').prop('disabled', false);
            }
          }, 1000);
        } else {
          // $('.submit-btn').prop('disabled', false).html('ثبت نقش');
          hideLoading();
          if (data.status !== 500) {
            (0,_public_js_modules_validation__WEBPACK_IMPORTED_MODULE_0__.showErrors)(data.responseJSON.errors, selectors);
          }
        }
      }
    });
    // }
  });

  $('.delete-role').click(function (event) {
    event.preventDefault();
    var element = $(this);
    // confirmModal('برای حذف مطمئن هستید؟',   'این آیتم حذف خواهد شد', (result) => {
    //      if(result){
    element.html("<i class=\"fa-solid fa-spinner loading\"></i>");
    $.ajax({
      type: 'DELETE',
      url: element.attr('href'),
      data: {
        role: element.attr('id')
      },
      statusCode: {
        404: function _() {
          toastError('نقش مورد نظر یافت نشد');
        }
      },
      success: function success(_ref2) {
        var hasError = _ref2.hasError,
          message = _ref2.message;
        hasError ? toastError(message) : toastSuccess(message);
        var num = 0;
        element.parents('tr').remove();
        $('td.row-num').each(function (index, elem) {
          $(elem).text(++num);
        });
        if ($('table.table-responsive tbody tr.bg-light').length < 1) {
          $('table.table-responsive').remove();
          $('section.table-content').html("\n                      <section\n                        class=\"table-empty w-100 h-100 d-flex flex-wrap justify-content-center align-content-center\">\n                        <i class=\"fa-solid fa-file-circle-question red__shade-3\" style=\"font-size: 40px\"></i>\n\n                        <p class=\"w-100 text-center small-copy-light black__shade-1\">\n                            <span class=\"body-copy-medium\">\"\u0646\u0642\u0634\"</span>\n                            \u0628\u0631\u0627\u06CC \u0646\u0645\u0627\u06CC\u0634 \u0648\u062C\u0648\u062F \u0646\u062F\u0627\u0631\u062F\n                        </p>\n                       <a href=\"\" class=\"add-row d-flex align-items-center ms-2\">\n<span class=\"rounded-circle mx-1 plus-button bg-primary__shade-2 white__default d-flex align-items-center justify-content-center\">\n    <i class=\"fa-solid fa-plus\"></i>\n</span>\n    <span class=\"small-copy-medium ps-1 black__shade-1\">\u0627\u0641\u0632\u0648\u062F\u0646 \u0646\u0642\u0634 \u062C\u062F\u06CC\u062F</span>\n</a>\n                    </section>\n                    ");
          $('a.add-row').attr('href', (0,_public_js_modules_route__WEBPACK_IMPORTED_MODULE_1__.getRouteByName)('roles.create'));
        }
      },
      error: function error(data) {
        // if(data.status === 404){
        toastError(data.responseJSON.errors);
        element.html("<i class=\"fa-solid fa-trash\"></i>");
        // }
      }
    });
    //     }
    // });
    // console.log(result, result.next(), result.next());
    // if(result()){
    //     console.log('yes');
    // }else{
    //     console.log('no');
    // }
  });

  $('.change-status').click(function (event) {
    event.preventDefault();
    var element = $(this);
    $.ajax({
      type: 'GET',
      url: $(this).attr('href'),
      success: function success(_ref3) {
        var hasError = _ref3.hasError,
          message = _ref3.message,
          changed = _ref3.changed,
          url = _ref3.url;
        hasError ? toastError(message) : toastSuccess(message);
        element.attr('href', url);
        if (changed === '1') {
          element.attr('title', 'غیرفعال کردن نقش');
          element.html('فعال');
          element.removeClass('bg-red__default');
          element.addClass('bg-green__default');
        } else {
          element.attr('title', 'فعال کردن نقش');
          element.html('غیرفعال');
          element.removeClass('bg-green__default');
          element.addClass('bg-red__default');
        }
      },
      error: function error(data) {
        toastError(data.responseJSON.errors);
      }
    });
  });
});
})();

/******/ })()
;