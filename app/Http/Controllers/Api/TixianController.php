<?php
/*
 * 用户提现管理
 * */

namespace App\Http\Controllers\Api;

use App\Http\Model\Zuser_withdraw;

class TixianController extends UserPublicController
{
    public function api_add()
    {
        $formdata = $this->formdata;
        if($result = $this->strvalidator($formdata)) {
            return $result;
        }
        $logresult = $this->action_money_log_in($this->user_id, [
            'price' => $formdata['price'],
            'info' => '提现',
            'type' => 2
        ], 0);
        if($logresult) {
            $this->userTxSave($formdata);
            return $this->message("提现申请已提交");
        } else {
            return $this->message("提现信息错误，请重试", -1);
        }
    }

    private function strvalidator($formdata)
    {
        $validator = validator($formdata, [
            'formid' => 'bail|required',
            'zfbkahao' => 'bail|required',
            'price' => "bail|required",
        ], [
            'formid.required' => '请使用微信访问',
            'zfbkahao.required' => '请先输入支付宝账号',
            'price.required' => '请输入金额',
        ]);
        if ($errors = $validator->fails()) {
            foreach ($validator->errors()->all() as $val) {
                return $this->message($val, -1);
            }
        }
        $this->addFormid($formdata['formid']);
        if ($formdata['price'] < 5) {
            return $this->message("提现金额必须大于5元", -1);
        }
        if ($this->user->price < $formdata['price']) {
            return $this->message("余额不足", -1);
        }
    }

    /*
     * 记录用户提现申请
     * */
    private function userTxSave($formdata)
    {
        $model = new Zuser_withdraw;
        $model->uid = $this->user_id;
        $model->type = 1; //微信
        $model->price = $formdata['price'];
        $model->zfbkahao = $formdata['zfbkahao'];
        $model->ord = get_order_sn();
        $model->status = 1;
        $model->save();
    }
}
