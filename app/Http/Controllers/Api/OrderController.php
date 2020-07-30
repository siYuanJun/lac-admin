<?php
/*
 * 订单管理
 * */

namespace App\Http\Controllers\Api;

use App\Helpers\wxMinppPayTrait;
use App\Http\Controllers\Controller;
use App\Http\Model\Zedu;
use App\Http\Model\Zpayorder;
use App\Http\Model\Zuseraddres;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class OrderController extends UserPublicController
{

    use wxMinppPayTrait;

    public function api_index()
    {
        $where = [];
        $where['uid'] = $this->user_id;
        $where['status'] = 2;
        $data = Zpayorder::where($where)->orderBy('createtime', 'desc')->paginate(20);
        foreach ($data as $key => $val) {
            if ($val->eduBelong) {
                $val->eduBelong->title = Str::limit($val->eduBelong->title, 20);
                $val->eduBelong->desc = Str::limit($val->eduBelong->desc, 30);
                $val->eduBelong->content = contentfilter($val->eduBelong->content);
                $val->eduBelong->img = asset('/uploads/' . $val->eduBelong->img);
            }
            $data->items()[$key] = $val;
        }
        return $this->success($data->items());
    }

    public function api_add()
    {
        $formdata = $this->formdata;
        $addr_id = isset($formdata['addr_id']) ? $formdata['addr_id'] : 0;
        $shop_id = isset($formdata['shop_id']) ? $formdata['shop_id'] : 0;

        $addrdata = Zuseraddres::find($addr_id);
        if (empty($addrdata->id)) {
            return $this->message("请先选择收货地址", -1);
        }

        $shopdata = Zedu::find($shop_id);
        if($shopdata->id) {
            return $this->strPayUnif($shopdata);
        } else {
            return $this->message("商品信息为空", -1);
        }
    }

    // 需确认确认行程操作
    private function strPayUnif($shopdata)
    {
        $fee = 0;
        if($this->user->level == 1) {
            $fee = $shopdata->fhy_fee;
        }
        if($this->user->level == 2) {
            $fee = $shopdata->vip_fee;
        }
        if($this->user->level == 3) {
            $fee = $shopdata->svip_fee;
        }
        if(empty($fee) || $fee == "0.00") {
            $fee = 0.01;
        }
        // Log::info("下单商品数据拼接：" . json_encode($shopdata));
        $paydata = Zpayorder::updateOrCreate([
            'uid' => $this->user_id,
            'shop_id' => $shopdata['id'],
            'status' => 1
        ], [
            'uid' => $this->user_id,
            'shop_id' => $shopdata['id'],
            'desc' => $shopdata['title'] . "[课程购买]",
            'fee' => $fee,
            'payord' => get_order_sn(),
            'status' => 1,
            'createtime' => date("Y-m-d H:i:s")
        ]);

        if ($paydata) {
            $studData = $this->user->studioBelong;
            if(!$studData) {
                return $this->message("请选择工作室后操作");
            }
            if($paydata->fee > 5000) {
                return $this->message("下单成功, 待线下支付");
            }
            // 工作室的上级分公司
            if($studData->studOneBelongTo) {
                $studData = $studData->studOneBelongTo;
            }
            $payform = [
                'mch_id' => $studData->busiBelongsTo->mch_id,
                'mch_api_key' => $studData->busiBelongsTo->mch_api_key,
                'openid' => $this->user->userWxHasOne->openid,
                'out_trade_no' => $paydata['payord'],
                'body' => $paydata['payord'] . "[课程购买]",
                'total_fee' => intval($paydata['fee'] * 100),
//                'total_fee' => intval(0.01 * 100),
            ];
            // Log::info("下单支付数据拼接：" . json_encode($payform));
            $result = $this->PayUnif($payform);
            Log::info("下单支付微信返回数据：" . json_encode($result));
            if (isset($result['err_code'])) {
                return $this->internalError($result['err_code_des']);
            } else {
                return $this->resomess($result, "发起支付");
            }
        }
    }
}
