<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {
    // 默认后台首页
    $router->get('/', 'HomeController@index')->name('admin.home');
    // 事业部管理一级
    $router->resource('z_businessunits', BusinessunitController::class);
    // 分公司管理二级
    $router->resource('z_branchoffices', BranchofficeController::class);
    // 分公司余额记录
    $router->resource('z_bran_price_logs', BranPriceLogController::class);
    // 分公司提现管理
    $router->resource('z_bran_withdraws', BranWithdrawController::class);
    // 工作室管理三级
    $router->resource('z_studios', StudioController::class);
    // 会员管理
    $router->resource('z_usernumbers', UsernumberController::class);
    // 用户提现管理
    $router->resource('z_user_withdraws', UserWithdrawController::class);
    // 用户数据导出
    $router->get('users/export', ['as' => 'users.export', 'uses' => 'UsernumberController@export']);
    // 课程管理
    $router->resource('z_edus', EduController::class);
    // 分类管理
    $router->resource('z_categorys', CategoryController::class);
    // 广告图管理
    $router->resource('z_ads', AdController::class);
    // 工作室提现管理
    $router->resource('z_stud_withdraws', StudWithdrawController::class);
    // 工作室余额记录
    $router->resource('z_stud_price_logs', StudPriceLogController::class);
    // 订单管理
    $router->resource('z_payorders', PayOrderController::class);
    // 课时管理
    $router->resource('z_classes', ClassController::class);

});
