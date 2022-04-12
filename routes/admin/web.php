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

        });

    });
