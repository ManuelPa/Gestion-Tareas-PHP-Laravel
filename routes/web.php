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

Auth::routes();//Rutas de autenticación de Laravel.

Route::get('/', 'HomeController@index')->name('mainpage');

Route::post('newtask', 'HomeController@nuevotask');

Route::post('newtab', 'HomeController@nuevotab');

Route::post('deletetask', 'HomeController@eliminartask');

Route::post('deletetab', 'HomeController@eliminartab');

Route::get('setHW', 'HomeController@setAltoAncho');

Route::get('setCheck', 'HomeController@setcheck');

Route::get('setText', 'HomeController@settexto');

Route::get('setTextTab', 'HomeController@settextotab');

Route::get('setOrder', 'HomeController@setOrder');

Route::get('setOrderTab', 'HomeController@setOrderTab');

Route::get('setColor', 'HomeController@setColor');