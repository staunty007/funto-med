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

Auth::routes();

Route::get('/doctor/dashboard', 'DoctorController@index')->name('doctor.dashbaord');
Route::get('/admin/dashboard', 'HomeController@index')->name('admin.dashboard');

Route::get('{path}',"HomeController@index")->where('path','([A-z\d-\/_.]+)?');
Route::get('{path}',"DoctorController@index")->where('path','([A-z\d-\/_.]+)?');