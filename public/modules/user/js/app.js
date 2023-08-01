/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*************************************************!*\
  !*** ./Modules/User/Resources/assets/js/app.js ***!
  \*************************************************/
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
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
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
/******/ })()
;