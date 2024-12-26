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

// 登录页面路由
Route::get('login', 'Admin\AuthController@showLoginForm')->name('admin.login');
Route::post('login', 'Admin\AuthController@login');
Route::post('logout', 'Admin\AuthController@logout')->name('admin.logout');

// 需要认证的后台路由组
Route::middleware(['auth:admin'])->namespace('Admin')->group(function () {
    // 仪表板
    Route::get('/', 'DashboardController@index')->name('admin.dashboard');
    Route::get('dashboard', 'DashboardController@index')->name('admin.dashboard');

    // 产品管理
    Route::resource('products', 'ProductController')->names([
        'index' => 'admin.products.index',
        'create' => 'admin.products.create',
        'store' => 'admin.products.store',
        'edit' => 'admin.products.edit',
        'update' => 'admin.products.update',
        'destroy' => 'admin.products.destroy',
    ]);
    Route::patch('products/{id}/toggle-status', 'ProductController@toggleStatus')
        ->name('admin.products.toggle-status');

    // 菜单管理
    Route::resource('menus', 'MenuController');
});
