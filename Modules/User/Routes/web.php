<?php

use Illuminate\Support\Facades\Route;


Route::get('profile/{user}', 'UserController@show')->name('users.profile');
Route::resource('users', 'UserController')->except(['show', 'destroy']);
Route::prefix('users')->group(function(){
    Route::match(['get', 'delete'], '{user}', 'UserController@destroy')->name('users.destroy');
Route::get('{user}/role/create', 'UserController@showRoles')->name('users.role.show');
Route::post('{user}/role/create', 'UserController@addRoleToUser')->name('users.role.add');
Route::get('{user}/permission/create', 'UserController@showPermissions')->name('users.permission.show');
Route::post('{user}/permission/create', 'UserController@addPermissionToUser')->name('users.permission.add');
Route::post('{user}/download', 'UserController@download')->name('users.download');
Route::put('updateName/{user}', 'UserController@updateName')->name('users.name.update');
Route::put('updatenatioanlCode/{user}', 'UserController@updatenatioanlCode')->name('users.national-code.update');
Route::put('updateBirthDate/{user}', 'UserController@updateBirthDate')->name('users.birth-date.update');
});

//Route::get('users', 'UserController@index')->name('user.index');
//Route::get('users', 'UserController@index')->name('user.index');

Route::resource('roles', 'RoleController')->except(['show', 'destroy']);
Route::match(['get', 'delete'], '{role}','RoleController@destroy')->name('roles.destroy');
Route::get('roles/{role}/status/{status}', 'RoleController@changeStatus')->name('roles.status');
Route::get('roles/{role}/permission/create', 'RoleController@showPermissions')->name('roles.permission.show');
Route::post('roles/{role}/permission/create', 'RoleController@addPermissionToRole')->name('roles.permission.add');
