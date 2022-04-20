<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Auth route
Route::post('/login', 'AuthController@login');
Route::post('/register', 'AuthController@register');

Route::middleware('auth:sanctum')->group(function () {

    //user route
    Route::get('/user', 'AuthController@user');

    //logout route
    Route::get('/logout', 'AuthController@logout');
});
