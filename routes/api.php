<?php

use Illuminate\Routing\Router;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

/*
 * 基础接口配置搭建
 * */
Route::group([
    'prefix' => 'xcx',
    'namespace' => 'Api',
], function(Router $router) {
    // 首页数据接口
    $router->post("/common/home", ['as' => 'api.xcx.common.home', 'uses' => 'CommonController@api_home']);
    // 用户注册接口
    $router->post("/reg", ['as' => 'api.xcx.login.reg', 'uses' => 'LoginController@api_reg']);
    // 用户登录接口
    $router->post("/login", ['as' => 'api.xcx.login', 'uses' => 'LoginController@api_login']);
    $router->post("/login_test", ['as' => 'api.xcx.login_test', 'uses' => 'LoginController@api_login_test']);
    // 用户信息接口
    $router->post("/userinfo", ['as' => 'api.xcx.userinfo', 'uses' => 'UserController@api_userInfo']);
    // 生成用户分享二维码
    $router->post("/userever", ['as' => 'api.xcx.userever', 'uses' => 'UserController@api_everImgSave']);
    // 我的旗下会员
    $router->post("/userchild", ['as' => 'api.xcx.childuser', 'uses' => 'UserController@api_userChild']);
    // 余额明细
    $router->post("/userpricelog", ['as' => 'api.xcx.userpricelog', 'uses' => 'UserController@api_userPriceLog']);
    // 课程管理
    $router->post("/edu", ['as' => 'api.xcx.edu', 'uses' => 'EduController@api_index']);
    $router->post("/edu/details", ['as' => 'api.xcx.edu.details', 'uses' => 'EduController@api_details']);
    // 提现管理
    $router->post("/tixian/add", ['as' => 'api.xcx.tixian.add', 'uses' => 'TixianController@api_add']);
    // 用户收藏
    $router->post("/coll", ['as' => 'api.xcx.coll', 'uses' => 'CollectionController@api_index']);
    $router->post("/coll/add", ['as' => 'api.xcx.coll.add', 'uses' => 'CollectionController@api_add']);
    // 订单管理
    $router->post("/order", ['as' => 'api.xcx.order', 'uses' => 'OrderController@api_index']);
    $router->post("/order/add", ['as' => 'api.xcx.order.add', 'uses' => 'OrderController@api_add']);
    // 支付异步通知
    $router->post('/wxpay/tocpaynotifyurl', ['as' => 'api.xcx.wxpay.tocpaynotifyurl', 'uses' => 'WxNotifyController@api_tocPayNotifyUrl']);
    // 退款异步通知
    $router->post('/wxpay/tocrefundnotifyurl', ['as' => 'api.xcx.wxpay.tocrefundnotifyurl', 'uses' => 'WxNotifyController@api_tocRefundNotifyUrl']);
    // 工作室列表
    $router->post("/studsele", ['as' => 'api.xcx.studsele', 'uses' => 'CommonController@api_studSele']);
    // 用户收货地址接口
    $router->post('/address', ['as' => 'api.xcx.address', 'uses' => 'AddressController@api_index']);
    $router->post('/address/save', ['as' => 'api.xcx.address.save', 'uses' => 'AddressController@api_save']);
    $router->post('/address/delete', ['as' => 'api.xcx.address.delete', 'uses' => 'AddressController@api_delete']);
    $router->post('/address/setdeault', ['as' => 'api.xcx.address.setdeault', 'uses' => 'AddressController@api_setdeault']);
});

