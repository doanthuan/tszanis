<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', 'HomeController@showWelcome');

Route::get('/test', 'HomeController@testEmail');

Route::controller('user', 'UserController');

Route::controller('password', 'RemindersController');

Route::controller('timezone', 'TimeZoneController');

Route::controller('language', 'LanguageController');

Route::controller('country', 'CountryController');

Route::controller('role', 'RoleController');

Route::resource('request', 'TransRequestController');

Route::controller('specialty', 'SpecialtyController');

/*
|--------------------------------------------------------------------------
| Admin Controllers
|--------------------------------------------------------------------------
*/

Route::controller('admin/user', 'AdminUserController');

Route::controller('admin/language', 'AdminLanguageController');

Route::controller('admin/time-zone', 'AdminTimeZoneController');

Route::controller('admin/country', 'AdminCountryController');

Route::controller('admin/specialty', 'AdminSpecialtyController');

Route::controller('admin/email-template', 'AdminEmailTemplateController');

/*
|--------------------------------------------------------------------------
| Admin Auth
|--------------------------------------------------------------------------
*/

Route::get('admin', 'AdminLanguageController@anyIndex');
Route::get('admin/login', 'AdminAuthenController@login');
Route::post('admin/login', 'AdminAuthenController@postLogin');
Route::get('admin/logout', 'AdminAuthenController@logout');