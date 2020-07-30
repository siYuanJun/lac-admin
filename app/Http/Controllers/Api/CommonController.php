<?php
/*
 * 文章信息接口
 * */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Model\Zad;
use App\Http\Model\Zedu;
use App\Http\Model\Zstudio;
use App\Models\Zcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CommonController extends PublicController
{
    /*
     * 默认首页数据
     * */
    public function api_home()
    {
        $formdata = $this->formdata;
        $data = [];
        if (isset($formdata['classid'])) {
            $data['edutuijian'] = $this->eduData(1);
            $data['eduzuixin'] = $this->eduData(2);
            $data['bannerdata'] = $this->adImg();
            $data['about'] = $this->cateGoryDetails($formdata['classid']);
        }
        return $this->success($data);
    }

    /*
     * 广告图数据
     * */
    private function adImg()
    {
        $data = Zad::where('classid', 6)->orderBy('ordernum', 'desc')->get();
        foreach ($data as $key => $val) {
            $val->img = asset('/uploads/' . $val->img);
        }
        return $data;
    }

    /*
     * 分类数据
     * */
    private function cateGoryDetails($classid)
    {
        $data = Zcategory::find($classid);
        $data->content = $data->content ? contentfilter($data->content) : '';
        return $data;
    }

    /*
     * 课程调用
     * */
    private function eduData($attributes)
    {
        $data = Zedu::where(['attributes' => $attributes, 'status' => 1])
            ->orderBy('ordernum', 'desc')
            ->orderBy('created_at', 'desc')->limit(20)->get();
        foreach ($data as $key => $val) {
            $val->title = Str::limit($val->title, 15);
            $val->desc = Str::limit($val->desc, 100);
            $val->content = contentfilter($val->content);
            $val->img = asset('/uploads/' . $val->img);
            $data[$key] = $val;
        }
        return $data;
    }

    /*
     * 工作室列表
     * */
    public function api_studSele()
    {
        $data = Zstudio::where(['status' => 1])->where('id', '!=', 1)->get(['id', 'title', 'address']);
        $datas = [];
        foreach ($data as $key => $val) {
            $datas['titlearr'][$key] = "({$val['address']})" . $val['title'];
            $datas['idarr'][$key] = $val['id'];
        }
        array_unshift($datas['titlearr'], '请选择工作室');
        array_unshift($datas['idarr'], 0);
        return $this->success($datas);
    }
}
