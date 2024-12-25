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

Route::domain(env('ADMIN_URL'))->group(function () {
    // 根路径重定向到登录页面
    Route::get('/', function () {
        return redirect()->route('admin.login');
    });

    // 登录页面路由
    Route::get('login', 'Admin\AuthController@showLoginForm')->name('admin.login');
    Route::post('login', 'Admin\AuthController@login')->name('admin.login.submit');
    Route::post('logout', 'Admin\AuthController@logout')->name('admin.logout');

    // 需要认证的后台路由组
    Route::middleware(['auth:admin'])->group(function () {
        // 仪表板
        Route::get('dashboard', 'Admin\DashboardController@index')->name('admin.dashboard');
    });
});
