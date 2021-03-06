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

    Route::post('/mark', 'MainController@mark')->name('mark');
    Route::post('/markExpert', 'MainController@markExpert')->name('markExpert');

    Route::get('/vote', 'MainController@votePage')->name('votePage');

    Route::get('/check-reports', 'MainController@checkReports');
    Route::get('/get-vote-results', 'MainController@getVoteResults');

    Route::post('/signout', 'MainController@signout')->name('signout');

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
        Route::get('/report/{id}/toggle', 'ReportController@toggle')->name('report.toggle');
        Route::get('/report/{id}/edit', 'ReportController@edit')->name('report.edit');
        Route::post('/report/{id}', 'ReportController@update')->name('report.update');
        Route::get('/report/{id}/delete', 'ReportController@delete')->name('report.delete');
        Route::post('/report/change-status/{id}', 'ReportController@changeStatus')->name('report.status');

        Route::get('/expert', 'ExpertController@index')->name('expert.index');
        Route::get('/expert/create', 'ExpertController@create')->name('expert.create');
        Route::post('/expert', 'ExpertController@store')->name('expert.store');
        Route::get('/expert/{id}', 'ExpertController@edit')->name('expert.edit');
        Route::post('/expert/{id}', 'ExpertController@update')->name('expert.update');
        Route::get('/expert/{id}/delete', 'ExpertController@delete')->name('expert.delete');

        Route::get('/results', 'ResultsController@index')->name('results.index');
        Route::get('/results/viewers', 'ResultsController@viewers')->name('results.viewers');

        Route::get('/results/get-viewer-results', 'ResultsController@getViewerResults');
        Route::get('/results/get-expert-results', 'ResultsController@getExpertResults');
        Route::get('/results/get-viewer-reports', 'ResultsController@getViewerReports');
        Route::get('/results/get-expert-reports', 'ResultsController@getExpertReports');
    });
});

Route::get('/signin', 'SignInController@index')->name('signin');
Route::post('/signin', 'SignInController@store')->name('signup');

Route::get('/s/{token}', 'SignInController@byToken')->name('signin.byToken');

Auth::routes(['register' => false]);