import {
    checkBlacklist,
    emptyInput,
    maxLength,
    required, showErrors,
    getData, checkPattern
} from "../../../../../public/js/modules/validation";
import {getRouteByName} from "../../../../../public/js/modules/route";
import {formEvent} from "../../../../../public/js/modules/event";

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
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        }
    });


    $('#role-form').on('submit', function (event) {
        event.preventDefault();
        // console.log(getResultModal());
        // if(getResultModal()){

        let selectors = ['name', 'persian_name', 'status'];
        if (required([
                {
                    name: 'name',
                    attribute: 'نام نقش (انگلیسی)'
                },
                {
                    name: 'persian_name',
                    attribute: 'نام نقش (فارسی)'
                }
            ])
            || maxLength([
                {
                    name: 'name',
                    length: 30,
                    message: 'نام نقش (انگلیسی) نباید بیشتر از 30 کاراکتر باشد'
                },
                {
                    name: 'persian_name',
                    length: 30,
                    message: 'نام نقش (فارسی) نباید بیشتر از 30 کاراکتر باشد'
                }
            ])
            ||
                checkPattern([
                    {
                        name: 'name',
                        regex: /^([a-z A-Z]{1,30})$/,
                        message: 'نام نقش باید به صورت حروف انگلیسی باشد'
                    },
                    {
                        name: 'persian_name',
                        regex: /^([ضصثقفغعهخحجچشسیبلاتنمکگپظطزرذدئو.ءِ]{1,30})$/,
                        message: 'نام نقش باید به صورت حروف فارسی باشد'
                    }
                ])
            ||
            checkBlacklist(selectors)) {
            // showErrors();
            return false;
        }

        showLoading();
        let method = typeof $("input[name='_method']").val() === 'undefined' ? 'POST' : $("input[name='_method']").val().toUpperCase();
        $.ajax({
            type: method,
            url: $(this).attr('action'),
            data: getData(selectors, {description: 'textarea', status: 'checkbox'}),
            statusCode: {
                500: function () {
                    toastError('خطا در ثبت نقش');
                }
            },
            success: function ({hasError, message, url, updated}) {
                hasError ? toastError(message) : toastSuccess(message);
                emptyInput(selectors);
                if (updated) {
                    window.location.href = url;
                }
                hideLoading();
            },
            error: function (data) {
                if (data.responseJSON.time) {
                    // $(".submit-btn").html('ثبت نقش');
                    let countDownTime = (+(new Date().getTime()) + data.responseJSON.time);
                    let minutes, seconds;
                    let time = setInterval(function () {
                        const now = new Date().getTime();
                        const distance = countDownTime - now;
                        minutes = '0' + Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                        seconds = Math.floor((distance % (1000 * 60)) / 1000);
                        seconds = seconds < 10 ? '0' + seconds : seconds;
//                         $('#error-confirm-code').empty().append(`خطا در ارسال اطلاعات . لطفا پس از <span class="small-copy-strong px-1">
// ${minutes}</span>:<span class="small-copy-strong px-1">${seconds}</span> دوباره امتحان کنید`);
//                         ;
                        if (distance < 0) {
                            clearInterval(time);
                            emptyInput([selectors]);
                            $('.submit-btn').prop('disabled', false);
                        }
                    }, 1000);
                } else {
                    // $('.submit-btn').prop('disabled', false).html('ثبت نقش');
                    hideLoading();
                    if(data.status !== 500){
                    showErrors(data.responseJSON.errors, selectors);
                    }
                }
            }
        });
        // }
    });

    $('.delete-role').click(function (event) {
        event.preventDefault();
        // $("#confirm-modal").modal('show');
        //
        // $("#confirm-modal").on('hidden.bs.modal', function () {
        //     console.log(!!$('#result-confirm').html());
        // });

        let element = $(this);
        // confirmModal('برای حذف مطمئن هستید؟',   'این آیتم حذف خواهد شد', (result) => {
        //      if(result){
        element.html(`<i class="fa-solid fa-spinner loading"></i>`);
        $.ajax({
            type: 'DELETE',
            url: element.attr('href'),
            data: {
                role: element.attr('id')
            },
            statusCode: {
                404: function () {
                    toastError('نقش مورد نظر یافت نشد');
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
                    $('section.table-content').html(`
                      <section
                        class="table-empty w-100 h-100 d-flex flex-wrap justify-content-center align-content-center">
                        <i class="fa-solid fa-file-circle-question red__shade-3" style="font-size: 40px"></i>

                        <p class="w-100 text-center small-copy-light black__shade-1">
                            <span class="body-copy-medium">"نقش"</span>
                            برای نمایش وجود ندارد
                        </p>
                       <a href="" class="add-row d-flex align-items-center ms-2">
<span class="rounded-circle mx-1 plus-button bg-primary__shade-2 white__default d-flex align-items-center justify-content-center">
    <i class="fa-solid fa-plus"></i>
</span>
    <span class="small-copy-medium ps-1 black__shade-1">افزودن نقش جدید</span>
</a>
                    </section>
                    `);
                    $('a.add-row').attr('href', getRouteByName('roles.create'));
                }
            },
            error: function (data) {
                // if(data.status === 404){
                toastError(data.responseJSON.errors);
                element.html(`<i class="fa-solid fa-trash"></i>`);
                // }
            }
        })
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
        let element = $(this);
        $.ajax({
            type: 'GET',
            url: $(this).attr('href'),
            success: function ({hasError, message, changed, url}) {
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
            error: function (data) {
                toastError(data.responseJSON.errors);
            }
        })
    });

});
