<?php

use Illuminate\Routing\Router;

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

//Route::get('/', function () {
//    return view('welcome');
//});

// 编辑器config.js图片上传入口配置
Route::post('stripe/ckeditor/upload', 'CkeditorUploadController@uploadImage');

// 工作室登录入口
Route::group([
    'prefix' => "stud",
    'namespace' => "Studio",
], function (Router $router) {
    $router->get('/login', ['as' => 'stud.login', 'uses' => 'LoginController@auto_login']);
    $router->post('/login', ['as' => 'stud.login.auth', 'uses' => 'LoginController@auto_login']);
});

// 分公司登录入口
Route::group([
    'prefix' => "bran",
    'namespace' => "Brancho",
], function (Router $router) {
    $router->get('/login', ['as' => 'bran.login', 'uses' => 'LoginController@auto_login']);
    $router->post('/login', ['as' => 'bran.login.auth', 'uses' => 'LoginController@auto_login']);
});

// 大文件访问地址
Route::get('largefile/{url}', ['as' => 'links.largefile', 'uses' => 'FileWebPathController@largefile']);