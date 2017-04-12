<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::get('/home', function (){
    return redirect('/dashboard');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    Route::get('/projects', 'ProjectsController@index')->name('projects');

    Route::group(['prefix' => 'loops'], function (){
        Route::get('', function (){
            return redirect('dashboard');
        });
        Route::post('', 'LoopsController@store')->name('loop-store');
        Route::get('{loop}', 'LoopsController@show')->name('loop-show');
        Route::post('{loop}/notes', 'LoopsController@addNote')->name('loop-add-note');
    });
});
