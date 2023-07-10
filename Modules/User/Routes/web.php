<?php

use Illuminate\Support\Facades\Route;


Route::get('profile/{user}', 'UserController@show')->name('users.profile');
Route::resource('users', 'UserController')->except('show');
Route::get('users/{user}/role/create', 'UserController@showRoles')->name('users.role.show');
Route::post('users/{user}/role/create', 'UserController@addRoleToUser')->name('users.role.add');
Route::get('users/{user}/permission/create', 'UserController@showPermissions')->name('users.permission.show');
Route::post('users/{user}/permission/create', 'UserController@addPermissionToUser')->name('users.permission.add');
Route::post('users/{user}/download', 'UserController@download')->name('users.download');

Route::put('users/updateName/{user}', 'UserController@updateName')->name('users.name.update');
Route::put('users/updatenatioanlCode/{user}', 'UserController@updatenatioanlCode')->name('users.national-code.update');
Route::put('users/updateBirthDate/{user}', 'UserController@updateBirthDate')->name('users.birth-date.update');
//Route::get('users', 'UserController@index')->name('user.index');
//Route::get('users', 'UserController@index')->name('user.index');

Route::resource('roles', 'RoleController')->except('show');
Route::get('roles/{role}/status/{status}', 'RoleController@changeStatus')->name('roles.status');

Route::get('roles/{role}/permission/create', 'RoleController@showPermissions')->name('roles.permission.show');
Route::post('roles/{role}/permission/create', 'RoleController@addPermissionToRole')->name('roles.permission.add');
