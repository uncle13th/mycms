<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application.
|
*/

Route::group(['domain' => env('ADMIN_URL')], function () {
    // 登录页面路由
    Route::get('login', 'Admin\AuthController@showLoginForm')->name('admin.login');
    Route::post('login', 'Admin\AuthController@login');
    Route::post('logout', 'Admin\AuthController@logout')->name('admin.logout');

    // 需要认证的后台路由组
    Route::middleware(['auth:admin'])->group(function () {
        // 仪表板
        Route::get('/', 'Admin\DashboardController@index')->name('admin.dashboard');
        Route::get('dashboard', 'Admin\DashboardController@index')->name('admin.dashboard');
    });
});
