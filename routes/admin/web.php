<?php

use Illuminate\Support\Facades\Route;

Route::middleware([
    'auth',
    'role:super_admin|admin',
])
    ->group(function () {

        Route::name('admin.')->prefix('admin')->group(function () {

            //home
            Route::get('/home', 'HomeController@index')->name('home');

            //role routes
            Route::get('/roles/data', 'RoleController@data')->name('roles.data');
            Route::delete('/roles/bulk_delete', 'RoleController@bulkDelete')->name('roles.bulk_delete');
            Route::resource('roles', 'RoleController');

            //admin routes
            Route::get('/admins/data', 'AdminController@data')->name('admins.data');
            Route::delete('/admins/bulk_delete', 'AdminController@bulkDelete')->name('admins.bulk_delete');
            Route::resource('admins', 'AdminController');

            //user routes
            Route::get('/users/data', 'UserController@data')->name('users.data');
            Route::delete('/users/bulk_delete', 'UserController@bulkDelete')->name('users.bulk_delete');
            Route::resource('users', 'UserController');

            //setting routes
            Route::get('/settings/general', 'SettingController@general')->name('settings.general');
            Route::resource('settings', 'SettingController')->only(['store']);

            //profile routes
            Route::get('/profile/edit', 'ProfileController@edit')->name('profile.edit');
            Route::patch('/profile/update', 'ProfileController@update')->name('profile.update');

            //profile password routes
            Route::name('profile.')->namespace('Profile')->group(function () {
                Route::get('/password/edit', 'PasswordController@edit')->name('password.edit');
                Route::patch('/password/update', 'PasswordController@update')->name('password.update');
            });

        });

    });
