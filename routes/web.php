<?php

use Illuminate\Support\Facades\Route;

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

Route::group(['domain' => env('APP_URL')], function () {
    Route::get('/', function () {
        return view('welcome');
    });
});

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth:admin']], function () {
    Route::get('/dashboard', 'Admin\DashboardController@index')->name('dashboard');
    Route::get('/password', 'Admin\PasswordController@showChangeForm')->name('password.show');
    Route::post('/password', 'Admin\PasswordController@update')->name('password.update');
    
    // 用户管理
    Route::resource('users', 'Admin\UserController');
    
    // 系统设置
    Route::get('/settings', 'Admin\SettingController@index')->name('settings.index');
    
    // 内容管理
    Route::resource('contents', 'Admin\ContentController');
});
