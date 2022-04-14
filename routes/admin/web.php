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
        });

    });
