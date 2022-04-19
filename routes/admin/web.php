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
            Route::get('/home/top_statistics', 'HomeController@topStatistics')->name('home.top_statistics');

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

            //genre routes
            Route::get('/genres/data', 'GenreController@data')->name('genres.data');
            Route::delete('/genres/bulk_delete', 'GenreController@bulkDelete')->name('genres.bulk_delete');
            Route::resource('genres', 'GenreController')->only(['index', 'destroy']);

            //movie routes
            Route::get('/movies/data', 'MovieController@data')->name('movies.data');
            Route::delete('/movies/bulk_delete', 'MovieController@bulkDelete')->name('movies.bulk_delete');
            Route::resource('movies', 'MovieController')->only(['index', 'show', 'destroy']);

            //actor routes
            Route::get('/actors/data', 'ActorController@data')->name('actors.data');
            Route::delete('/actors/bulk_delete', 'ActorController@bulkDelete')->name('actors.bulk_delete');
            Route::resource('actors', 'ActorController')->only(['index', 'destroy']);

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
