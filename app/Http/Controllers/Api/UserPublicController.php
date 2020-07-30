<?php
/*
 * 用户登录中间控制器
 * */

namespace App\Http\Controllers\Api;

use App\Http\Model\Zuserformid;

class UserPublicController extends PublicController
{
    public function __construct()
    {
        parent::__construct();
        if(empty($this->user_id)) {
            exit($this->statusCustomize(403));
        }
    }

    /*
     * 添加用户formid
     * */
    public function addFormid($formid)
    {
        if($formid) {
            $uforModel = new Zuserformid;
            $uforval = $uforModel->where('uid', $this->user_id)->first();
            $uforModel = $uforval ? $uforval : $uforModel;
            $uforModel->uid = $this->user_id;
            $uforModel->formid = $formid;
            $uforModel->save();
        }
    }
}