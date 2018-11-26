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

Route::group([
    'middleware' => ['auth']
], function () {
    Route::get('/', 'MainController@index')->name('main');

    //Route::get('/result', 'MainController@result')->name('result');

    Route::post('/mark/{id}', 'MainController@mark')->name('mark');
    Route::post('/markExpert/{id}', 'MainController@markExpert')->name('markExpert');

    Route::group([
        'middleware' => ['isAdmin'],
        'prefix' => 'admin',
        'as' => 'admin.',
        'namespace' => 'Admin'
    ], function () {
        Route::get('/', 'MainController@index')->name('index');

        Route::get('/report', 'ReportController@index')->name('report.index');
        Route::get('/report/create', 'ReportController@create')->name('report.create');
        Route::post('/report', 'ReportController@store')->name('report.store');
        Route::get('/report/{id}', 'ReportController@show')->name('report.show');
        Route::get('/report/{id}/edit', 'ReportController@edit')->name('report.edit');
        Route::post('/report/{id}', 'ReportController@update')->name('report.update');
        Route::get('/report/{id}/delete', 'ReportController@delete')->name('report.delete');

        Route::get('/expert', 'ExpertController@index')->name('expert.index');
        Route::get('/expert/create', 'ExpertController@create')->name('expert.create');
        Route::post('/expert', 'ExpertController@store')->name('expert.store');
        Route::get('/expert/{id}', 'ExpertController@edit')->name('expert.edit');
        Route::post('/expert/{id}', 'ExpertController@update')->name('expert.update');
        Route::get('/expert/{id}/delete', 'ExpertController@delete')->name('expert.delete');
    });
});

Route::get('/signin', 'SignInController@index')->name('signin');
Route::post('/signin', 'SignInController@store')->name('signup');

Route::get('/signin/{token}', 'SignInController@byToken')->name('signin.byToken');

Auth::routes(['register' => false]);