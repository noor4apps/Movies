<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Auth route
Route::post('/login', 'AuthController@login');
Route::post('/register', 'AuthController@register');

//genre routes
Route::get('/genres', 'GenreController@index');

//movie routes
Route::get('/movies', 'MovieController@index');
Route::get('/movies/{movie}/actors', 'MovieController@actors');
Route::get('/movies/{movie}/images', 'MovieController@images');
Route::get('/movies/{movie}/related', 'MovieController@related');

Route::middleware('auth:sanctum')->group(function () {

    //movie route
    Route::get('/movies/toggle-favorite', 'MovieController@toggleFavorite');
    Route::get('/movies/{movie}/is-favored', 'MovieController@isFavored');
    Route::get('/movies/favorite', 'MovieController@favorite');

    //user route
    Route::get('/user', 'AuthController@user');

    //logout route
    Route::get('/logout', 'AuthController@logout');
});
