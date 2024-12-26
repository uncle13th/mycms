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

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    // 登录相关路由
    Route::get('login', 'Admin\Auth\LoginController@showLoginForm')->name('login');
    Route::post('login', 'Admin\Auth\LoginController@login');
    Route::post('logout', 'Admin\Auth\LoginController@logout')->name('logout');

    // 需要登录才能访问的路由
    Route::middleware(['auth:admin'])->group(function () {
        Route::get('/dashboard', 'Admin\DashboardController@index')->name('dashboard');
        Route::get('/password', 'Admin\PasswordController@showChangeForm')->name('password.show');
        Route::post('/password', 'Admin\PasswordController@update')->name('password.update');
        
        // 产品管理
        Route::resource('products', 'Admin\ProductController');
        Route::patch('products/{product}/toggle-status', 'Admin\ProductController@toggleStatus')->name('products.toggle-status');
        Route::post('products/upload-image', 'Admin\ProductController@uploadImage')->name('products.upload-image');
        Route::post('products/upload-editor-image', 'Admin\ProductController@uploadEditorImage')->name('products.upload-editor-image');
        
        // 分类管理
        Route::resource('categories', 'Admin\CategoryController');
        
        // 图片管理
        Route::resource('images', 'Admin\ImageController');
    });
});
