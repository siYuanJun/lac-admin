<?php
/*
 * 课程管理
 * */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Model\Zcollection;
use App\Http\Model\Zedu;
use App\Models\Zcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EduController extends PublicController
{
    public function api_index()
    {
        $formdata = $this->formdata;
        $where = [];
        $where[] = ['status', 1];
        if(isset($formdata['classid'])) {
            $where[] = ['classid', $formdata['classid']];
        }
        if(!isset($formdata['fid'])) {
            $formdata['fid'] = 0;
        }
        $data = Zedu::where($where)
            ->orderBy('ordernum', 'desc')
            ->orderBy('created_at', 'desc')->paginate(20);
        foreach ($data as $key => $val) {
            $val->desc = Str::limit($val->desc, 120);
            $val->content = contentfilter($val->content);
            $val->img = asset('/uploads/' . $val->img);
            $data->items()[$key] = $val;
        }
        $coll = [
            'edu' => $data->items(),
            'colunm' => $this->cateColunm($formdata['fid'])
        ];
        return $this->success($coll);
    }

    private function cateColunm($fid = 0)
    {
        $data = Zcategory::where('parent_id', $fid)->get();
        return $data;
    }

    public function api_details()
    {
        $formdata = $this->formdata;
        if(isset($formdata['id'])) {
            $data = Zedu::find($formdata['id']);
            $data->desc = Str::limit($data->desc, 120);
            $data->content = contentfilter($data->content);
//            $data->content = '内容更新中';
            $data->img = asset('/uploads/' . $data->img);
            $data->collif = Zcollection::where(['uid' => $this->user_id, 'shop_id' => $data->id])->value('status');

            $data->hy_fee = intval($data->vip_fee);
            $data->fhy_fee = intval($data->fhy_fee);
            $data->vip_fee = intval($data->vip_fee);
            $data->svip_fee = intval($data->svip_fee);
            if($data->classHasMany) {
                foreach ($data->classHasMany as $val) {
                    $val->title = Str::limit($val->title, 20);
                    $val->video = route('links.largefile', ['url' => $val->video]);
                }
            }
            return $this->success($data);
        }
    }
}
