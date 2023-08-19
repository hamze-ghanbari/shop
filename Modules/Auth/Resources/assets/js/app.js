import {
    checkPattern,
    minLength,
    maxLength,
    required, checkBlacklist, email, phone, convertNumbersToEnglish, isNumber
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
    let userNameConverted = textField.val();

    if (textField) {
        textField.on('keyup', function () {
            userNameConverted = convertNumbersToEnglish(textField.val());
            if (userNameConverted.trim().length > 0) {
                if (email(userNameConverted) || phone(userNameConverted)) {
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


        if (!email(convertNumbersToEnglish(textField.val())) && !phone(convertNumbersToEnglish(textField.val()))) {
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

    $('#confirm-form input').on('keyup', function () {
        if (required([
            {
                name: 'confirm_code',
                attribute: 'کد تایید'
            }
        ]) ||  isNumber([
            {
                name: 'confirm_code',
                attribute: 'کد تایید'
            }
        ])|| minLength([
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
        // if($(this).val().length > 4){
        sendConfirmAjax();
        // }
    });

// confirm form
    $('#confirm-form').on('submit', function (event) {
        event.preventDefault();
        if (
            required([
                {
                    name: 'confirm_code',
                    attribute: 'کد تایید'
                }
            ]) || isNumber([
                {
                    name: 'confirm_code',
                    attribute: 'کد تایید'
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
        sendConfirmAjax();
    });
});

function sendConfirmAjax() {
    $('.login-btn').prop('disabled', true).html(`<i class="fa-solid fa-spinner loading"></i>`);
    $.ajax({
        type: 'POST',
        url: $(this).attr('action'),
        data: {
            confirm_code: convertNumbersToEnglish($("input[name='confirm_code']").val())
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
}
