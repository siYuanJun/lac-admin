<?php
/******************************************
 ****AuThor:2039750417@qq.com
 ****Title :小程序微信支付操作类
 *******************************************/

namespace App\Helpers;

use App\Common\lib\wpay\WxPayConfig;
use App\Http\Model\Zpayorder;
use Illuminate\Support\Facades\Log;

trait wxMinppPayTrait
{
    // 发起支付
    public function PayUnif($data)
    {
        $pay_conf = [
            'mch_id' => $data['mch_id'],
            'mch_api_key' => $data['mch_api_key'],
            'openid' => $data['openid'],
            'out_trade_no' => $data['out_trade_no'],
            'body' => $data['body'],
            'total_fee' => $data['total_fee'],
            'notify_url' => route('api.xcx.wxpay.tocpaynotifyurl'), //异步返回地址
        ];
        $weixinpay = new WxPayConfig($pay_conf['mch_id'], $pay_conf['mch_api_key'], $pay_conf['openid'], $pay_conf['out_trade_no'], $pay_conf['body'], $pay_conf['total_fee'], $pay_conf['notify_url']);
        $payResult = $weixinpay->pay();
        return $payResult; //发起支付
    }

    // 支付成功异步回调
    public function tocPayNotifyUrl($request)
    {
        $postXml = $request->getContent();
        //将xml格式转换成数
        if ($attr = xml_parser($postXml)) {
            Log::info('支付异步返回=' . json_encode($attr));
            $out_trade_no = $attr['out_trade_no'];
            $transaction_id = $attr['transaction_id'];
            $time_end = date("Y-m-d H:i:s", strtotime($attr['time_end']));
            if ($attr["return_code"] == "SUCCESS" && $attr["result_code"] == "SUCCESS") {
                // 业务逻辑
                $paydata = Zpayorder::where(['payord' => $out_trade_no, 'status' => 1])->first();
                if($paydata) {
                    $paydata->status = 2;
                    $paydata->transaction_id = $transaction_id;
                    $paydata->paycreatetime = $time_end;
                    $paydata->save();
                    return ['code' => 1, 'data' => $paydata];
                }
            } else {
                return ['code' => 0, 'message' => '返回信息错误'];
            }
        }
    }

    // 发起退款
    public function PayRefund($data)
    {
        $pay_conf = [
            'openid' => $data['openid'], //用户id
            'out_trade_no' => $data['out_trade_no'],
            'body' => $data['body'],
            'total_fee' => $data['total_fee'],
            'refund_fee' => $data['refund_fee'],
            'out_refund_no' => $data['out_refund_no'],
            'notify_url' => route('api.xcx.wxpay.tocrefundnotifyurl'), //异步返回地址
        ];
        $weixinpay = new WxPayConfig($pay_conf['openid'], $pay_conf['out_trade_no'], $pay_conf['body'], $pay_conf['total_fee'], $pay_conf['notify_url']);
        return $weixinpay->refund($pay_conf); //发起支付
    }

    // 退款异步通知
    public function RefundNotifyUrl($request)
    {
        $postXml = $request->getContent();
        if ($attr = xml_parser($postXml)) {
            Log::info('退款异步返回=' . json_encode($attr));
            $out_trade_no = $attr['out_trade_no'];
            $out_refund_no = $attr['out_refund_no'];
            $refund_id = $attr['refund_id'];
            if ($attr["return_code"] == "SUCCESS" && $attr["result_code"] == "SUCCESS") {
                //业务逻辑
            } else {
                return '信息错误';
            }
        }
    }

    // 企业付款给用户提现
    public function PayTransfers($data)
    {
        $pay_conf = [
            'openid' => $data['openid'], //用户id
            'out_trade_no' => $data['out_trade_no'],
            'body' => '余额提现',
            'total_fee' => $data['total_fee'],
            'notify_url' => '', //异步返回地址
        ];
        $weixinpay = new WxPayConfig($pay_conf['openid'], $pay_conf['out_trade_no'], $pay_conf['body'], $pay_conf['total_fee'], $pay_conf['notify_url']);
        return $weixinpay->transfers($pay_conf); //发起支付
    }
}