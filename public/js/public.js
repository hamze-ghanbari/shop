/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!********************************!*\
  !*** ./resources/js/public.js ***!
  \********************************/
// let exampleEl = document.getElementById('example')
// let tooltip = new bootstrap.Tooltip(exampleEl, options)
//
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl);
});
$(document).ready(function () {
  $("#notification").click(function (event) {
    event.preventDefault();
    $('.notification-box').toggleClass('toggle-notification');
  });
  $('.menu').click(function () {
    $(this).toggleClass('toggle-sub-menu menu');
  });
  $("#toggle-side").click(function () {
    $('.side-panel').toggleClass('toggle-side');
  });
});
/******/ })()
;