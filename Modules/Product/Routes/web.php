<?php

use Illuminate\Support\Facades\Route;

Route::prefix('products')->group(function(){
    Route::resource('categories', 'CategoryController')->except('show');
    Route::get('categories/{category}/status/{status}', 'CategoryController@changeStatus')->name('categories.status');

    Route::resource('brands', 'BrandController')->except('show');
    Route::get('brands/{brand}/status/{status}', 'BrandController@changeStatus')->name('brands.status');
});
