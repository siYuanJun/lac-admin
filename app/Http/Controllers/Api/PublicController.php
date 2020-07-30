<?php

namespace App\Http\Controllers\Api;

use App\Common\lib\aes\WXBizDataCrypt;
use App\Helpers\ApiResponse;
use App\Helpers\CommonTrait;
use App\Http\Controllers\Controller;
use App\Http\Model\Zusernumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Log;

class PublicController extends Controller
{
    use ApiResponse, CommonTrait;

    protected $user;
    protected $user_id;
    protected $formdata;

    /*
     * 参数初始化
     * */
    public function __construct()
    {
        $request = Request();
        // 获取API接口,POST所有参数,进行参数解析,传入当前token
        $request = $this->request_token($request->all());
        if ($request) {
            $this->formdata = $request;
            if (isset($request['openid']) && $request['openid'] != 'undefined') {
                $opdata = Redis::get($request['openid']);
                $this->user = Zusernumber::where('openid', substr($opdata, -28))->first();
                if ($this->user) {
                    $this->user_id = $this->user->id;
                }
            }
        } else {
            exit($this->statusCustomize(500, "错误的[TOKEN]"));
        }
    }

    /*
     * 请求token处理API通用验证
     * */
    public function request_token($param)
    {
        if (isset($param['token'])) {
            if ($param['token'] == config('hashpass.apiToken')) {
                return $param;
            }
        }
    }

    /*
    * Name： 数据解密身份对比
    * Return：小程序解密后用户数据
    * session_key：当前登陆请求者sessionkey
    * iv：小程序加密版本号
    * encryptedData: 小程序加密数据
    * */
    public function decode_encryptedData($appid, $sessionKey, $encryptedData, $iv)
    {
        $wxCrypt = new WXBizDataCrypt;
        $wxCrypt->WXBizDataCrypt($appid, $sessionKey);
        $errCode = $wxCrypt->decryptData($encryptedData, $iv, $data);
        if ($errCode == 0) {
            $res['status'] = 1;
            $res['data'] = json_decode($data, true);
        } else {
            $res['status'] = 0;
            $res['data'] = $errCode;
        }
        return $res;
    }

    /*
     * 生成分享二维码接口
     * */
    public function userEverImgSave($invite_code)
    {
        $picurl = "uploads/userever/" . md5($invite_code) . $invite_code . ".png";
        $path = public_path($picurl);
        // 二维码URL usercode 参数和微信设置同步
//        if(!file_exists($path)) {
        // /weixin/?usercode=123 登录页面 /weixin?usercode=123 首页
        $everurl = asset("/weixin/?usercode={$invite_code}");
//        dd($everurl);
        QrCode::format('png')->size(400)->color(0, 0, 0)->backgroundColor(255, 255, 255)->margin(2)->generate($everurl, $path);
//        }
        return $picurl;
    }
}
