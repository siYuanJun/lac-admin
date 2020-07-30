<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Model\Zcollection;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CollectionController extends UserPublicController
{
    public function api_index()
    {
        $where = [];
        $where['uid'] = $this->user_id;
        $where['status'] = 1;
        $data = Zcollection::where($where)->orderBy('created_at', 'desc')->paginate(20);
        foreach ($data as $key => $val) {
            if($val->collBelong) {
                $val->collBelong->title = Str::limit($val->collBelong->title, 14);
                $val->collBelong->desc = Str::limit($val->collBelong->desc, 120);
                $val->collBelong->content = contentfilter($val->collBelong->content);
                $val->collBelong->img = asset('/uploads/' . $val->collBelong->img);
            }
            $data->items()[$key] = $val;
        }
        return $this->success($data->items());
    }

    public function api_add()
    {
        $formdata = $this->formdata;
        if(isset($formdata['shop_id'])) {
            $model = new Zcollection;
            $where = [];
            $where['uid'] = $this->user_id;
            $where['shop_id'] = $formdata['shop_id'];
            $data = $model->where($where)->first();
            if($data) {
                $data->status = !$data->status;
            } else {
                $data = $model;
                $data->status = 1;
            }
            $data->uid = $this->user_id;
            $data->shop_id = $formdata['shop_id'];
            $data->save();
            if($data->status) {
                return $this->message("收藏成功", 1);
            } else {
                return $this->message("已取消", 0);
            }
        }
    }
}
