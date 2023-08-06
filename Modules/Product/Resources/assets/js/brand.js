import {
    checkBlacklist,
    emptyInput,
    maxLength,
    required, showErrors,
    getData, checkPattern
} from "../../../../../public/js/modules/validation";
import {getRouteByName} from "../../../../../public/js/modules/route";
import {indexOf} from "lodash/array";

$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        }
    });


    $('#ImageBrowse').change(function () {
        let reader = new FileReader();
        reader.onload = (e) => {
            // $('#ddddd').attr('src', e.target.result);
            $('#ImageBrowse').attr('data-image', e.target.result);
        }
        reader.readAsDataURL(this.files[0]);
    });

    $('#brand-form').on('submit', function (event) {
        event.preventDefault();

        let selectors = ['name', 'persian_name', 'description'];

        if (required([
                {
                    name: 'name',
                    attribute: 'نام برند (انگلیسی)'
                },
                {
                    name: 'persian_name',
                    attribute: 'نام برند (فارسی)'
                },
                {
                    name: 'description',
                    attribute: 'توضیحات برند'
                },
                {
                    name: 'image',
                    attribute: 'تصویر برند'
                }
            ])
            || maxLength([
                {
                    name: 'name',
                    length: 50,
                    message: 'نام برند (انگلیسی) نباید بیشتر از 50 کاراکتر باشد'
                },
                {
                    name: 'persian_name',
                    length: 50,
                    message: 'نام برند (فارسی) نباید بیشتر از 50 کاراکتر باشد'
                },
                {
                    name: 'description',
                    length: 5000,
                    message: 'توضیحات برند نباید بیشتر از 5000 کاراکتر باشد'
                }
            ])
            || checkPattern([
                {
                    name: 'name',
                    regex: /^([a-z A-Z]{1,30})$/,
                    message: 'نام برند باید به صورت حروف انگلیسی باشد'
                },
                {
                    name: 'persian_name',
                    regex: /^([ضصثقفغعهخحجچشسیبلاتنمکگپظطزرذدئو.ءِ]{1,30})$/,
                    message: 'نام برند باید به صورت حروف فارسی باشد'
                }
            ])
        ) {
            // ||
            //     checkBlacklist(selectors)
            // showErrors();
            return false;
        }

        showLoading();
        let image = $("#ImageBrowse").attr('data-image');
        let data = getData(selectors, {description: 'textarea', show_in_menu: 'checkbox', parent_id: 'select'});
        data.image = image;
        let method = typeof $("input[name='_method']").val() === 'undefined' ? 'POST' : $("input[name='_method']").val().toUpperCase();
        $.ajax({
            type: method,
            url: $(this).attr('action'),
            data: data,
            statusCode: {
                500: function () {
                    toastError('خطا در ثبت برند');
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
                hideLoading();
                if (data.status !== 500) {
                    showErrors(data.responseJSON.errors, selectors);
                }
            }
        });
        // }
    });

    $('.delete-brand').click(function (event) {
        event.preventDefault();
        let element = $(this);
        // confirmModal('برای حذف مطمئن هستید؟',   'این آیتم حذف خواهد شد', (result) => {
        //      if(result){
        element.html(`<i class="fa-solid fa-spinner loading"></i>`);
        $.ajax({
            type: 'DELETE',
            url: element.attr('href'),
            data: {
                brand: element.attr('id')
            },
            statusCode: {
                404: function () {
                    toastError('برند مورد نظر یافت نشد');
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
                            <span class="body-copy-medium">"برند"</span>
                            برای نمایش وجود ندارد
                        </p>
                       <a href="" class="add-row d-flex align-items-center ms-2">
<span class="rounded-circle mx-1 plus-button bg-primary__shade-2 white__default d-flex align-items-center justify-content-center">
    <i class="fa-solid fa-plus"></i>
</span>
    <span class="small-copy-medium ps-1 black__shade-1">افزودن برند جدید</span>
</a>
                    </section>
                    `);
                    $('a.add-row').attr('href', getRouteByName('categories.create'));
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

    $('.change-show-menu').click(function (event) {
        event.preventDefault();
        let element = $(this);
        $.ajax({
            type: 'GET',
            url: $(this).attr('href'),
            success: function ({hasError, message, changed, url}) {
                hasError ? toastError(message) : toastSuccess(message);
                element.attr('href', url);
                if (changed === '1') {
                    element.attr('title', 'غیرفعال کردن برند');
                    element.html('فعال');
                    element.removeClass('bg-red__default');
                    element.addClass('bg-green__default');
                } else {
                    element.attr('title', 'فعال کردن برند');
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
