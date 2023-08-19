<?php

use Illuminate\Support\Facades\Route;

Route::prefix('products')->group(function(){
    Route::resource('categories', 'CategoryController')->except(['show', 'destroy']);
    Route::get('categories/{category}/status/{status}', 'CategoryController@changeStatus')->name('categories.status');
    Route::match(['get', 'delete'],'categories/{category}', 'CategoryController@destroy')->name('categories.destroy');

    Route::resource('brands', 'BrandController')->except(['show', 'destroy']);
    Route::get('brands/{brand}/status/{status}', 'BrandController@changeStatus')->name('brands.status');
    Route::match(['get', 'delete'],'brands/{brand}', 'BrandController@destroy')->name('brands.destroy');
});
