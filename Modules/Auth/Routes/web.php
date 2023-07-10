<?php



use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Controllers\AuthController;

Route::controller(AuthController::class)->group(function(){
    Route::get('login',  'showOtpForm')->name('auth.show-otp-form');
    Route::post('login', 'otp')->name('auth.otp');
    Route::get('confirm/{token}', 'showConfirmForm')->name('auth.show-confirm-form');
    Route::post('confirm/{token}', 'confirm')->name('auth.confirm');
    Route::get('otp/resend/{token}', 'resendOtpCode')->name('auth.otp.resend');
    Route::get('logout', 'logout')->name('logout');
});
