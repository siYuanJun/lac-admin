<?php
/*
 * 小程序微信异步通知
 * */

namespace App\Http\Controllers\Api;

use App\Helpers\CommonTrait;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\wxMinppPayTrait;

class WxNotifyController extends Controller
{
    use wxMinppPayTrait, CommonTrait;

    // 支付异步通知类
    public function api_tocPayNotifyUrl(Request $request)
    {
        $paydata = $this->tocPayNotifyUrl($request);
        if ($paydata['code'] == 1) {
            $this->payCashBack($paydata['data']);
        }
    }

    // 退款异步通知类
    public function api_tocRefundNotifyUrl(Request $request)
    {
        return $this->RefundNotifyUrl($request);
    }
}
