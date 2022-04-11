<?php

use Illuminate\Support\Facades\Route;


Route::get('/', 'WelcomeController@index')->name('welcome');

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();
