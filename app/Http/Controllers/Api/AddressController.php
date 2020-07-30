<?php
/*
 * 用户地址管理
 * */

namespace App\Http\Controllers\Api;

use App\Http\Model\Zuseraddres;

class AddressController extends UserPublicController
{
    public function api_index()
    {
        $formdata = $this->formdata;
        $params = new Zuseraddres;
        // 读取默认地址
        if(isset($formdata['moren'])) {
            if($formdata['moren'] == "index") {
                $data = $params->where(['uid' => $this->user_id, 'status' => 1])->first();
                return $this->success($data);
            }
        }
        $data = $params->where('uid', $this->user_id)->orderBy('status', 'desc')->orderBy('updated_at', 'desc')->get();
        return $this->success($data);
    }

    public function api_save()
    {
        $formdata = $this->formdata;
        $params = new Zuseraddres;
        $formdata['id'] = isset($formdata['id']) ? $formdata['id'] : 0;
        $data = $params->where('uid', $this->user_id)->find($formdata['id']);
        if($data) {
            $params = $data;
            // 设置默认地址
            if(isset($formdata['moren'])) {
                $params->where(['uid' => $this->user_id])->update(['status' => 0]);
                $params->status = 1;
                $params->save();
                return $this->message("设置成功");
            }
        } else {
            $params->where(['uid' => $this->user_id])->update(['status' => 0]);
            $params->status = 1;
            $params->uid = $this->user_id;
        }
        if (empty($formdata['name']) || empty($formdata['mobile']) || empty($formdata['addr'])) {
            return $this->message("请先完善数据", -1);
        }
        $params->name = $formdata['name'];
        $params->mobile = $formdata['mobile'];
        $params->addr = $formdata['addr'];
        $params->save();
        return $this->message("添加成功");
    }

    public function api_delete()
    {
        $formdata = $this->formdata;
        if (!empty($formdata['id'])) {
            $model = Zuseraddres::where('id', $formdata['id'])->where('uid', $this->user_id)->delete();
            if ($model) {
                return $this->message("删除成功");
            } else {
                return $this->message("删除失败");
            }
        }
    }

    /*
     * 设置默认地址
     * */
    public function api_setdeault()
    {
        $formdata = $this->formdata;
        if (!empty($formdata['id'])) {
            Zuseraddres::where('id', $formdata['id'])->where('uid', $this->user_id)->update(['status' => 1]);
            return $this->message("已设置");
        }
    }
}
