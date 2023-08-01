import {getRouteByName} from "../../../../../public/js/modules/route";
import {  getData,  maxLength, nationalCode} from "../../../../../public/js/modules/validation";

$(document).ready(function () {
    let fullNameModal = new bootstrap.Modal($('#fullName'), {
        backdrop: 'static'
    });
    let nationalCodeModal = new bootstrap.Modal($('#nationalCode'), {
        backdrop: 'static'
    });
    let birthDateModal = new bootstrap.Modal($('#birthDate'), {
        backdrop: 'static'
    });


    $("#fullName").on('shown.bs.modal', function () {
        $("input[name='first_name']").focus();
    });
    $("#nationalCode").on('shown.bs.modal', function () {
        $("input[name='national_code']").focus();
    });
    // $("#birthDate").on('shown.bs.modal', function () {
    //     $("input[name='birth_date']").focus();
    // });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        }
    });


    $('#user-role-form').on('submit', function (event) {
        event.preventDefault();
        let values = [];
        $('.switch-checkbox').not('#select-all').each(function (index, element) {
            if ($(element).is(':checked'))
                values.push($(element).val());
        });
        showLoading();
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: {
                roles: values
            },
            success({hasError, message, url}) {
                hasError ? toastError(message) : toastSuccess(message);
                hideLoading();
                window.location.href = url;
            },
            error(data) {
                toastError(data.responseJSON.errors);
                hideLoading();
            }
        })
    });

    $('.delete-user').on('click', function (event) {
        event.preventDefault();
        alert('hi');
        let element = $(this);
        element.html(`<i class="fa-solid fa-spinner loading"></i>`);
        $.ajax({
            type: 'DELETE',
            url: $(this).attr('href'),
            data: {
                id: $(this).attr('id')
            },
            statusCode: {
                404: function () {
                    toastError('کاربر مورد نظر یافت نشد');
                }
            },
            success: function ({hasError, message}) {
                hasError ? toastError(message) : toastSuccess(message);
                let num = 0;
                element.parents('tr').remove();
                $('td.row-num').each(function (index, elem) {
                    $(elem).text(++num);
                });
                if ($('table.table-responsive tbody tr.bg-light').length < 1) {
                    $('table.table-responsive').remove();
//                     $('section.table-content').html(`
//                       <section
//                         class="table-empty w-100 h-100 d-flex flex-wrap justify-content-center align-content-center">
//                         <i class="fa-solid fa-file-circle-question red__shade-3" style="font-size: 40px"></i>
//
//                         <p class="w-100 text-center small-copy-light black__shade-1">
//                             <span class="body-copy-medium">"کاربر"</span>
//                             برای نمایش وجود ندارد
//                         </p>
//                        <a href="" class="add-row d-flex align-items-center ms-2">
// <span class="rounded-circle mx-1 plus-button bg-primary__shade-2 white__default d-flex align-items-center justify-content-center">
//     <i class="fa-solid fa-plus"></i>
// </span>
//     <span class="small-copy-medium ps-1 black__shade-1">افزودن کاربر جدید</span>
// </a>
//                     </section>
//                     `);
                    $('a.add-row').attr('href', getRouteByName('users.create'));
                }
            },
            error: function (data) {
                // if(data.status === 404){
                toastError(data.responseJSON.errors);
                element.html(`<i class="fa-solid fa-trash"></i>`);
                // }
            }
        })
    });

    $('#full-name-form').on('submit', function (event) {
        event.preventDefault();
        let selectors = ['first_name', 'last_name'];
        if(maxLength([
            {
                name : 'first_name',
                length : 30,
                message : 'نام نباید بیشتر از 30 کاراکتر باشد'
            },
            {
                name : 'last_name',
                length : 30,
                message : 'نام  خانوادگی نباید بیشتر از 30 کاراکتر باشد'
            },
        ])){
            return false;
        }
        showLoading();
        $.ajax({
            url: $(this).attr('action'),
            type: 'PUT',
            data: getData(selectors),
            success({hasError, message, fullName}) {
                hideLoading();
                fullNameModal.hide();
                $("#fullName").on('hidden.bs.modal', function () {
                    hasError ? toastError(message) : toastSuccess(message);
                    $(".full-name").text(fullName);
                });
            },
            error(data) {
                toastError(data.responseJSON.message.split('.').shift());
                hideLoading();
            }
        })
    });

    $('#national-code-form').on('submit', function (event) {
        event.preventDefault();
        if(nationalCode(getData(['national_code'])['national_code'])){
            return false;
        }
        showLoading();
        $.ajax({
            url: $(this).attr('action'),
            type: 'PUT',
            data: getData(['national_code']),
            success({hasError, message, nationalCode}) {
                hideLoading();
                nationalCodeModal.hide();
                $("#nationalCode").on('hidden.bs.modal', function () {
                    hasError ? toastError(message) : toastSuccess(message);
                    $(".national-code").text(nationalCode);
                });
            },
            error(data) {
                toastError(data.responseJSON.errors['national_code']);
                hideLoading();
            }
        })
    });

    $('#birth-date-form').on('submit', function (event) {
        event.preventDefault();
        let birthDate = `${$('#year').val()}/${$('#month').val()}/${$('#day').val()}`;
        // console.log(!!birthDate.match('/^([1]{1}[3|4]{1}[0-9]{2}/[0-9]{2}/[0-9]{2})$/'));
        // // if(!birthDate.match('/^([1][3-4][0-9]{2}\/[0-9]{2}\/[0-9]{2})$/')){
        // //     $("#error-birth-date").text('فرمت تاریخ معتبر نمی باشد');
        // //     return false;
        // // }
        showLoading();
        $.ajax({
            url: $(this).attr('action'),
            type: 'PUT',
            data: {
                birth_date : birthDate
            },
            success({hasError, message}) {
                hideLoading();
                birthDateModal.hide();
                $("#birthDate").on('hidden.bs.modal', function () {
                    hasError ? toastError(message) : toastSuccess(message);
                    $(".birth-date").text(birthDate);
                });
            },
            error(data) {
                toastError(data.responseJSON.errors['birth_date'][0]);
                hideLoading();
            }
        })
    });

    $('#filter-date-view').persianDatepicker({
        format: 'YYYY/MM/DD',
        altField: '#filter-date',
        autoClose: true,
        // maxDate: new persianDate().add('month', 3).valueOf(),
        // minDate: new persianDate().subtract('month', 3).valueOf(),
        // onSelect: function (unix) {
        //     to.touched = true;
        //     if (from && from.options && from.options.maxDate != unix) {
        //         var cachedValue = from.getState().selected.unixDate;
        //         from.options = {maxDate: unix};
        //         if (from.touched) {
        //             from.setDate(cachedValue);
        //         }
        //     }
        // }
    });
});


