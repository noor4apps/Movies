<?php

use Illuminate\Support\Facades\Route;

Route::middleware([
    'auth'
])
    ->group(function () {

        Route::name('admin.')->prefix('admin')->group(function () {

            //home
            Route::get('/home', 'HomeController@index')->name('home');

        });

    });
