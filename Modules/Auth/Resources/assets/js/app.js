import {
    checkPattern,
    minLength,
    maxLength,
    required,checkBlacklist, email, phone
} from "../../../../../public/js/modules/validation";

$(document).ready(function () {
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    }
});
    let textField = $('#user-name');
    let emptyBtn = $('#empty-icon');
    let confirmIcon = $('#confirm-icon');
    let fieldBox = $('#field-box');

    if (textField) {
        textField.on('keyup', function () {

            if (textField.val().trim().length > 0) {
                if (email(textField.val()) || phone(textField.val())) {
                    confirmIcon.removeClass('d-none');
                    emptyBtn.addClass('d-none');
                    fieldBox.removeClass('border-red').addClass('border-green');
                } else {
                    confirmIcon.addClass('d-none');
                    emptyBtn.removeClass('d-none');
                    fieldBox.removeClass('border-green').addClass('border-red');
                }

            } else {
                emptyBtn.addClass('d-none');
                confirmIcon.addClass('d-none');
                fieldBox.removeClass('border-green').removeClass('border-red');
            }

        });
    }

    if (emptyBtn) {
        emptyBtn.click(function () {
            textField.val('');
            emptyBtn.addClass('d-none');
            fieldBox.removeClass('border-red');
            textField.focus();
        });
    }



    // otp form
    $('#otp-form').on('submit', function (event) {
        event.preventDefault();
        if (required([
            {
                name: 'user_name',
                attribute: 'ایمیل یا شماره موبایل',
            }
        ]) || checkBlacklist(['user_name'])) {
            return false;
        }


        if (!email(textField.val()) && !phone(textField.val())) {
            $('#error-user-name').text('ایمیل یا شماره موبایل وارد شده معتبر نمی باشد');
            return false;
        }

        $('.login-btn').html(`<i class="fa-solid fa-spinner loading"></i>`).prop('disabled', true);
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: {
                user_name: $("#user-name").val(),
            },
            success: function ({hasError, message, url}) {
                if (hasError) {
                    $('#error-user-name').empty();
                    toastError(message);
                    $('.login-btn').prop('disabled', false).html('ورود');
                } else {
                    window.location.replace(url);
                }
            },
            error: function (data) {
                if (data.responseJSON.time) {
                    $(".login-btn").html('ورود');
                    let countDownTime = (+(new Date().getTime()) + data.responseJSON.time);
                    let minutes, seconds;
                    let time = setInterval(function () {
                        let now = new Date().getTime();
                        let distance = countDownTime - now;
                        minutes = '0' + Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                        seconds = Math.floor((distance % (1000 * 60)) / 1000);
                        seconds = seconds < 10 ? '0' + seconds : seconds;
                        $('#error-user-name').empty().append(`خطا در ارسال اطلاعات . لطفا پس از <span class="small-copy-strong px-1">
${minutes}</span>:<span class="small-copy-strong px-1">${seconds}</span> دوباره امتحان کنید`);
                        if (distance < 0) {
                            clearInterval(time);
                            $('#error-user-name').empty();
                            $('.login-btn').prop('disabled', false);
                        }
                    }, 1000);
                } else {
                    $('.login-btn').prop('disabled', false).html('ورود');
                    $('#error-user-name').html(data.responseJSON.message);
                }
            }
        });
    });

// confirm form
    $('#confirm-form').on('submit', function (event) {
        event.preventDefault();
        if (required([
            {
                name: 'confirm_code',
                attribute: 'کد تایید'
            }
        ]) || checkPattern([
            {
                name: 'confirm_code',
                regex: /^[0-9]+$/,
                message: 'کد تایید باید عدد باشد'
            }
        ]) || minLength([
            {
                name: 'confirm_code',
                length: 5,
                message: 'کد تایید نباید کمتر از 5 رقم باشد'
            }
        ]) || maxLength(([
            {
                name: 'confirm_code',
                length: 5,
                message: 'کد تایید نباید بیشتر از 5 رقم باشد'
            }
        ])) || checkBlacklist(['confirm_code'])) {
            return false;
        }
        $('.login-btn').prop('disabled', true).html(`<i class="fa-solid fa-spinner loading"></i>`);
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: {
                confirm_code: $("input[name='confirm_code']").val()
            },
            success: function ({hasError, message, url}) {
                if (hasError) {
                    $('#error-confirm-code').empty();
                    toastError(message);
                    $('.login-btn').prop('disabled', false).html('تایید');
                } else {
                    window.location.href = url;
                }
            },
            error: function (data) {
                if (data.responseJSON.time) {
                    $(".login-btn").html('تایید');
                    let countDownTime = (+(new Date().getTime()) + data.responseJSON.time);
                    let minutes, seconds;
                    let time = setInterval(function () {
                        const now = new Date().getTime();
                        const distance = countDownTime - now;
                        minutes = '0' + Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                        seconds = Math.floor((distance % (1000 * 60)) / 1000);
                        seconds = seconds < 10 ? '0' + seconds : seconds;
                        $('#error-confirm-code').empty().append(`خطا در ارسال اطلاعات . لطفا پس از <span class="small-copy-strong px-1">
${minutes}</span>:<span class="small-copy-strong px-1">${seconds}</span> دوباره امتحان کنید`);
                        ;
                        if (distance < 0) {
                            clearInterval(time);
                            $('#error-confirm-code').empty();
                            $('.login-btn').prop('disabled', false);
                        }
                    }, 1000);


                } else {
                    $('.login-btn').prop('disabled', false).html('تایید');
                    $('#error-confirm-code').html(data.responseJSON.message);
                }
            }
        });
    });
})
;
