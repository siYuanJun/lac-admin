<?php
/*
 * 用户登录相关
 * */

namespace App\Http\Controllers\Api;

use App\Helpers\IdentityCardTrait;
use App\Http\Controllers\Controller;
use App\Http\Model\Zusernumber;
use App\Http\Model\Zuserwxinfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class LoginController extends PublicController
{
    use IdentityCardTrait;

    private $table;
    private $model;

    public function __construct()
    {
        parent::__construct();
        $this->table = "zusernumbers" ;
        $this->model = new Zusernumber;
    }

    /*
     * 用户个人信息注册
     * */
    public function api_reg()
    {
        $formdata = $this->formdata;
        if(!$this->user_id) {
            exit($this->statusCustomize(403));
        }
        if($return = $this->strValidator($formdata)) {
            return $return;
        } else {
            $formdata = [
                'stud_id' => $formdata['stud_id'],
                'ysstud_id' => $formdata['stud_id'],
                'relname' => $formdata['relname'],
                'idcard' => $formdata['idcard'],
                'childname' => $formdata['childname'],
                'childidcard' => $formdata['childidcard'],
            ];
            if($data = $this->model->where('id', $this->user_id)->update($formdata)) {
                return $this->message("完善成功");
            } else {
                return $this->message("提交失败");
            }
        }
    }

    /*
     * 登录表单验证
     * */
    private function strValidator($formdata)
    {
        if(!idcardCheck($formdata['idcard'])) {
            return $this->message("请输入正确的身份证号", -1);
        }
        if(!idcardCheck($formdata['childidcard'])) {
            return $this->message("请输入正确的孩子身份证号", -1);
        }
        $validator = validator($formdata, [
            'openid' => "bail|required",
            'stud_id' => "bail|required",
            'relname' => "bail|required",
            'idcard' => "bail|required",
            'childname' => "bail|required",
            'childidcard' => "bail|required",
        ], [
            'openid.required' => '请先微信注册',
            'stud_id.required' => '请选择工作室',
            'relname.required' => '姓名不能为空',
            'idcard.required' => '身份证号不能为空',
//            'idcard.unique' => '已完善不可更改',
            'childname.required' => '请输入孩子姓名',
            'childidcard.required' => '请输入孩子身份证号',
        ]);

        if($errors = $validator->fails()) {
            foreach ($validator->errors()->all() as $val) {
                return $this->message($val, -1);
            }
        }

        if(empty($formdata['stud_id'])) {
            return $this->message("请选择工作室", -1);
        }
    }

    /*
     * 微信登录接口
     * */
    public function api_login()
    {
        $result = $this->loginGetSessionKey();
        if(!empty($array_data = $result['xudata'])) {
            $return = $this->success($this->login_cache_status($array_data));
        } else {
            $return = $this->internalError("登录失败");
        }
        return $return;
    }

    /*
     * 测试环境登录接口
     * */
    public function api_login_test()
    {
        $formdata = $this->formdata;
        // 登录所需参数
        $result = [
            'xudata' => [
                'openId' => $formdata['openid'],
                'unionId' => ''
            ]
        ];
        if(!empty($array_data = $result['xudata'])) {
            $return = $this->success($this->login_cache_status($array_data));
        } else {
            $return = $this->internalError("登录失败");
        }
        return $return;
    }

    /*
     * 用户登录状态存储
     * */
    private function login_cache_status($array_data)
    {
        $params = $this->model;
        // 绑定微信手机号
        if(isset($array_data['phoneNumber'])) {
            $xcxuser = $params->find($this->user_id);
            $xcxuser->phonenumber = $array_data['phoneNumber'];
            $params = $xcxuser;
            $openid = $params->openid;
        } else {
            // 微信 openId大写
            $openid = $array_data['openId'];
            $unionid = isset($array_data['unionId']) ? $array_data['unionId'] : '';
            $xcxuser = $params->where(['openid' => $openid, 'unionid' => $unionid])->first();
            // 首次注册
            if(empty($xcxuser)) {
                $params->openid = $openid;
                $params->unionid = $unionid;
                $params = $this->creatingStr($params);
                if($params) {
                    $this->createdStr($params);
                }
            } else {
                $params = $xcxuser;
                $params->recent_createtime = date("Y-m-d H:i:s");
            }
            // 存入微信信息
            if(isset($array_data['nickName'])) {
                $this->userwxinfo($array_data);
            }
            $params->invite_code_img = $this->userEverImgSave($params->invite_code);
        }
//        dd($params);
        //服务器存储newsession_id
        $params->newsession_id = gtk(0, 28);
        //存贮当前微信用户openid信息到redis
        Redis::setex($params->newsession_id, 2505600, gtk(0, 28) . $openid); //29天有效2505600
        $params->save();
        return $params->newsession_id;
    }

    /*
     * 获取当前授权微信解密信息
     * */
    private function loginGetSessionKey()
    {
        $formdata = $this->formdata;
        if (isset($formdata['code'])) {
            $appid = config('hashpass.wx_appid');
            $appsecret = config('hashpass.wx_appsecret');
            //获取code请求微信服务器
            $url = "https://api.weixin.qq.com/sns/jscode2session?appid=" . $appid . "&secret=" . $appsecret . "&js_code=" . $formdata['code'] . "&grant_type=authorization_code";
            $result = json_decode(http_curl_request($url), true);
            if (!empty($result['errcode'])) {
                exit($this->statusCustomize($result['errcode'], $result['errmsg']));
            }
            $xudata = $this->decode_encryptedData($appid, $result['session_key'], $formdata['encryptedData'], $formdata['iv']);
            Log::info(json_encode($xudata));
            if ($xudata['status'] === 1) {
                $result['xudata'] = $xudata['data'];
                return $result;
            }
        }
    }

    /*
     * 存储
     * */
    private function userwxinfo($array_data)
    {
        $paramss = new Zuserwxinfo;
        $data = $paramss->where('openid', $array_data['openId'])->first();
        $params = $data ? $data : $paramss;
        $params->openid = $array_data['openId'];
        $params->nickname = $array_data['nickName'];
        $params->gender = $array_data['gender'];
        $params->province = $array_data['province'];
        $params->city = $array_data['city'];
        $params->country = $array_data['country'];
        $params->avatarurl = $array_data['avatarUrl'];
        $params->save();
    }

    /*
     * 注册开始事务处理
     * */
    public function creatingStr($book)
    {
        // 有邀请码处理
        $formdata = $this->formdata;
//        dd($formdata);
        if(isset($formdata['usercode'])) {
            $userdataone = $book->where('invite_code', $formdata['usercode'])->first();
            if($userdataone) {
                // 原始/服务工作室
                $book->ysstud_id = $userdataone->stud_id;
                $book->stud_id = $userdataone->stud_id;
                // 我的一级
                $book->uid_onelevel = $userdataone->id;
                // 一级的上级
                $userdatatwo = $userdataone->userOneBelong;
                if($userdatatwo) {
                    $book->uid_twolevel = $userdatatwo->id;
                }
            }
        }
        $book->password = bcrypt($book->password);
        $book->invite_code = gen_invite_code();
        $book->reg_createtime = date("Y-m-d H:i:s");
        $book->recent_createtime = date("Y-m-d H:i:s");
        $book->price = 0;
        $book->level = 1;
        $book->save();
        return $book->findOrFail($book->id);
    }

    /*
     * 注册成功事务处理
     * */
    public function createdStr($book)
    {
        $book->createdPull();
    }
}
