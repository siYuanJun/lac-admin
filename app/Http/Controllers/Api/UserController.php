<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/11/13
 * Time: 20:01
 */

namespace App\Http\Controllers\Api;

use App\Http\Model\Zuser_price_log;
use App\Http\Model\Zusernumber;

class UserController extends UserPublicController
{
    /*
     * 获取用户信息
     * */
    public function api_userInfo()
    {
        $data = [
            'xcxuser' => $this->userField($this->user),
        ];
        return $this->success($data);
    }

    /*
     * 处理用户数据字段
     * */
    private function userField($data)
    {
        $array['id'] = $data->id;
        $array['relname'] = $data->relname;
        $array['idcard'] = $data->idcard;
        $array['invite_code'] = $data->invite_code;
        $array['level'] = $data->level;
        $array['level_txt'] = $data->ext_level[$data->level];
        $array['phonenumber'] = $data->phonenumber;
        $array['price'] = number_format($data->price, 2);
        $array['yzcprice'] = number_format($data->yzcprice, 2);
        $array['ysrprice'] = number_format($data->ysrprice, 2);
        $array['stud_id'] = $data->stud_id;
        if($data->studioBelong) {
            $array['stud_txt'] = $data->studioBelong->title;
            $array['stud_address'] = $data->studioBelong->address;
        }
        $array['uid_onelevel'] = $data->uid_onelevel;
        if($data->userOneBelong) {
            $array['userone_name'] = $data->userOneBelong->relname ? $data->userOneBelong->relname : $data->userOneBelong->userWxHasOne->nickname;
        } else {
            $array['userone_name'] = "无";
        }
        $array['uid_twolevel'] = $data->uid_twolevel;
        $array['childidcard'] = $data->childidcard;
        $array['childname'] = $data->childname;
        $array['usernum'] = $data->usernum;
        $array['kechengnum'] = $data->uOrderEduNum($data);
        $array['invite_code_img'] = asset($data->invite_code_img);
        $array['created_at'] = get_last_time(strtotime($data->created_at));
        $array['user_wx_has_one'] = $data->userWxHasOne;
        return $array;
    }

    /*
     * 生成分享二维码接口
     * */
    public function api_everImgSave()
    {
        return $this->success($this->userEverImgSave($this->user->invite_code));
    }

    /*
     * 我的会员
     * */
    public function api_userChild()
    {
        $formdata = $this->formdata;
        if (isset($formdata['uid'])) {
            $uid = $formdata['uid'];
            $data = Zusernumber::where('uid_onelevel', $uid)
                ->orderBy('created_at', 'desc')
                ->paginate(20, ['id', 'relname', 'openid', 'phonenumber', 'invite_code', 'usernum', 'created_at']);
            foreach ($data as $key => $val) {
                $val->created_time = get_last_time(strtotime(date($val->created_at)));
//                dd($val);
                if ($val->userWxHasOne) {
                    $val->userWxHasOne->avatarurl = asset($val->userWxHasOne->avatarurl);
                } else {
                    $val->user_wx_has_one_nickname = $val->relname;
                    $val->user_wx_has_one_avatarurl = asset('/static/xcx/images/avatar.png');
                }
                $data->items()[$key] = $val;
            }
            return $this->success($data->items());
        }
    }

    /*
     * 余额明细
     * */
    public function api_userPriceLog()
    {
        $formdata = $this->formdata;
        $formdata['type'] = !empty($formdata['type']) ? $formdata['type'] : 0;
        $data = Zuser_price_log::where(['uid' => $this->user_id, 'type' => $formdata['type']])->orderBy('created_at', 'desc')->paginate(20);
        foreach ($data as $key => $val) {
            $data->items()[$key] = $val;
        }
        return $this->success($data->items());
    }
}