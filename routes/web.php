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
    return view('welcome');
});

// Route::get('/getsheet', 'SecondAttempt@index');

Route::get('/getsheet', function () {
    return view('sheetIndex');
});

Route::get('/showList', 'GoogleSheetController@index');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/update', 'GoogleSheetController@update');

Route::get('/insert', 'GoogleSheetController@insert');
