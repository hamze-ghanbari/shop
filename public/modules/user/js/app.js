/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

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
  'roles.create': 'roles/create'
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
    element = type[item] === 'textarea' ? 'textarea' : 'input';
    data[item] = $("".concat(element, "[name=").concat(item, "] ").concat(typeInput)).val();
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
/*!*************************************************!*\
  !*** ./Modules/User/Resources/assets/js/app.js ***!
  \*************************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _public_js_modules_validation__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../../../public/js/modules/validation */ "./public/js/modules/validation.js");
/* harmony import */ var _public_js_modules_route__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../../../../public/js/modules/route */ "./public/js/modules/route.js");


$(document).ready(function () {
  // $('.search').click(function(){
  //     $.ajax({
  //         url: $(this).parents('form').attr('action'),
  //         type: 'POST',
  //         data : {
  //            term :  $('input[name="search"]').val()
  //         },
  //         success: function (data){
  //             if(data.length > 0) {
  //                 data.forEach(function (item, index) {
  //                     $('table tr.bg-light').eq(index).children('td').first().text(index + 1)
  //                         .end().eq(1).text(item.name)
  //                         .end().eq(2).text(item.description ?? '-----');
  //                 });
  //             }else{
  //                 // $('table').empty();
  //             }
  //         },
  //         error: function (data){
  //
  //         }
  //     })
  // });

  var trutyArrayChecked = [];
  $('.switch-checkbox').not('#select-all').each(function (index, element) {
    trutyArrayChecked.push($(element).is(':checked'));
  });
  if (trutyArrayChecked.includes(false)) {
    $('#select-all').prop('checked', false);
  } else {
    $('#select-all').prop('checked', true);
  }
  $("#select-all").change(function () {
    $('.switch-checkbox').prop('checked', $(this).is(":checked"));
  });
  $('#permission-form').on('submit', function (event) {
    event.preventDefault();
    var values = [];
    $('.switch-checkbox').not('#select-all').each(function (index, element) {
      if ($(element).is(':checked')) values.push($(element).val());
    });
    showLoading();
    $.ajax({
      url: $(this).attr('action'),
      type: 'POST',
      data: {
        permissions: values
      },
      success: function success(_ref) {
        var hasError = _ref.hasError,
          message = _ref.message,
          url = _ref.url;
        hasError ? toastError(message) : toastSuccess(message);
        hideLoading();
        window.location.href = url;
      },
      error: function error(data) {
        toastError(data.responseJSON.errors);
        hideLoading();
      }
    });
  });
});
})();

/******/ })()
;