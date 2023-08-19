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

    $('#category-form').on('submit', function (event) {
        event.preventDefault();

        let selectors = ['name', 'persian_name', 'description', 'parent_id', 'show_in_menu'];

        if (required([
                {
                    name: 'name',
                    attribute: 'نام دسته بندی (انگلیسی)'
                },
                {
                    name: 'persian_name',
                    attribute: 'نام دسته بندی (فارسی)'
                },
                {
                    name: 'description',
                    attribute: 'توضیحات دسته بندی'
                },
                {
                    name: 'image',
                    attribute: 'تصویر دسته بندی'
                }
            ])
            || maxLength([
                {
                    name: 'name',
                    length: 50,
                    message: 'نام دسته بندی (انگلیسی) نباید بیشتر از 50 کاراکتر باشد'
                },
                {
                    name: 'persian_name',
                    length: 50,
                    message: 'نام دسته بندی (فارسی) نباید بیشتر از 50 کاراکتر باشد'
                },
                {
                    name: 'description',
                    length: 5000,
                    message: 'توضیحات دسته بندی نباید بیشتر از 5000 کاراکتر باشد'
                }
            ])
            || checkPattern([
                {
                    name: 'name',
                    regex: /^([a-z A-Z]{1,30})$/,
                    message: 'نام دسته بندی باید به صورت حروف انگلیسی باشد'
                },
                {
                    name: 'persian_name',
                    regex: /^([ضصثقفغعهخحجچشسیبلاتنمکگپظطزرذدئو.ءِ]{1,30})$/,
                    message: 'نام دسته بندی باید به صورت حروف فارسی باشد'
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
        // image = image.replace('data:image/', '');
        // image = image.replace('data:image/jpeg;base64,', '');
        // image = image.replace(' ', '+');
        let data = getData(selectors, {description: 'textarea', show_in_menu: 'checkbox', parent_id: 'select'});
        data.image = image;
        let method = typeof $("input[name='_method']").val() === 'undefined' ? 'POST' : $("input[name='_method']").val().toUpperCase();
        $.ajax({
            type: method,
            url: $(this).attr('action'),
            data: data,
            statusCode: {
                500: function () {
                    toastError('خطا در ثبت دسته بندی');
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
                // if (data.status !== 500) {
                //     console.log(data.status);
                if(data.responseJSON.errors['image']){
                    $('#error-image').text(data.responseJSON.errors['image'][0])
                }
                    showErrors(data.responseJSON.errors, selectors);
                // }
            }
        });
        // }
    });

    $('.delete-category').click(function (event) {
        event.preventDefault();
        let element = $(this);
        // confirmModal('برای حذف مطمئن هستید؟',   'این آیتم حذف خواهد شد', (result) => {
        //      if(result){
        element.html(`<i class="fa-solid fa-spinner loading"></i>`);
        $.ajax({
            type: 'DELETE',
            url: element.attr('href'),
            data: {
                category: element.attr('id')
            },
            statusCode: {
                404: function () {
                    toastError('دسته بندی مورد نظر یافت نشد');
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
                            <span class="body-copy-medium">"دسته بندی"</span>
                            برای نمایش وجود ندارد
                        </p>
                       <a href="" class="add-row d-flex align-items-center ms-2">
<span class="rounded-circle mx-1 plus-button bg-primary__shade-2 white__default d-flex align-items-center justify-content-center">
    <i class="fa-solid fa-plus"></i>
</span>
    <span class="small-copy-medium ps-1 black__shade-1">افزودن دسته بندی جدید</span>
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
                    element.attr('title', 'غیرفعال کردن دسته بندی');
                    element.html('فعال');
                    element.removeClass('bg-red__default');
                    element.addClass('bg-green__default');
                } else {
                    element.attr('title', 'فعال کردن دسته بندی');
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
