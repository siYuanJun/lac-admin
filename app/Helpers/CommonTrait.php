<?php
/*
 * 通用接口类
 * */

namespace App\Helpers;

trait CommonTrait
{
    /*
     * 金额操作记录操作
     * */
    public function action_money_log_in($uid, $data, $cztype = 1, $logtable = 'zuser_price_logs', $umodel = 'Zusernumber', $ufield = 'price')
    {
        $rule = 0;
        $table = $logtable;
        $usernew = "App\Http\Model\\$umodel";
        $usernew = new $usernew;
        $db = "Illuminate\Support\Facades\DB";
        $db::beginTransaction();
        try {
            $userdata = $usernew->find($uid);
            if ($userdata->id) {
                $parmdata = [
                    'uid' => $userdata->id,
                    'price' => $data['price'],
                    'info' => $data['info'],
                    'type' => $data['type'],
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s"),
                ];
                $resultid = $db::table($table)->insertGetId($parmdata);
                if ($resultid) {
                    $rule = 1;
                    //积分操作 0减 1加
                    if ($cztype === 0) {
                        $userdata->decrement($ufield, $data['price']);
                        // 已支出
                        $userdata->increment('yzcprice', $data['price']);
                    }
                    if ($cztype === 1) {
                        $userdata->increment($ufield, $data['price']);
                        // 驳回金额不计入当前账号收入记录
                        if ($data['type'] != 3) {
                            // 已收入
                            $userdata->increment('ysrprice', $data['price']);
                        }
                    }
                    $db::table($table)->where('id', $resultid)->update(['yueprice' => $userdata->price]);
                    $db::commit();
                } else {
                    $db::rollBack();
                }
            } else {
                throw new \Exception("没有找到该用户");
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
            $db::rollBack();
        }
        return $rule;
    }

    /*
     * 用户支付后返利操作
     * */
    public function payCashBack($paydata)
    {
        // 处理返利逻辑 round
        $edudata = $paydata->eduBelong;
        $udata = $paydata->userNumberBelong;
        if ($edudata) {
            $edudata->three_fee = 0;
            $edudata->brantwo_fee = 0;
            // vip返利金额
            if($udata->level == 2) {
                $edudata->stud_fee = $edudata->vip_stud_fee;
                $edudata->branone_fee = $edudata->vip_branone_fee;
                $edudata->uone_fee = $edudata->vip_uone_fee;
                $edudata->utwo_fee = $edudata->vip_utwo_fee;
            }
            // svip返利金额
            if($udata->level == 3) {
                $edudata->stud_fee = $edudata->svip_stud_fee;
                $edudata->branone_fee = $edudata->svip_branone_fee;
                $edudata->uone_fee = $edudata->svip_uone_fee;
                $edudata->utwo_fee = $edudata->svip_utwo_fee;
            }
            // 会员升级
            if($edudata->shop_type == 2 || $edudata->shop_type == 2) {
                $udata->level = $edudata->shop_type;
                $udata->save();
            }
            // dd($edudata);
            $infolog = $udata->relname . "[{$udata->ext_level[$udata->level]} 返利]";
            // 工作室返利操作
            $studData = $udata->studioBelong;
            if ($studData) {
                $this->action_money_log_in($studData->id, [
                    'price' => $edudata->stud_fee,
                    'info' => $infolog,
                    'type' => 1
                ], 1, 'zstud_price_logs', 'Zstudio');
            }
            // 分公司返利操作
            $branone = $studData->studOneBelongTo;
            $brantwo = $studData->studTwoBelongTo;
            // 转移后分公司
            if ($brantwo) {
                $branone_fee = $edudata->branone_fee;
                if ($edudata->brantwo_fee) {
                    $this->action_money_log_in($brantwo->id, [
                        'price' => $edudata->brantwo_fee,
                        'info' => $infolog,
                        'type' => 1
                    ], 1, 'zbranchoffice_price_logs', 'Zbranchoffice');
                }
            } else {
                // 如果没有转移过分公司直接给一级分公司一二级金额
                $branone_fee = $edudata->branone_fee + $edudata->brantwo_fee;
            }
            // 一级分公司
            if ($branone) {
                if ($edudata->branone_fee) {
                    $this->action_money_log_in($branone->id, [
                        'price' => $branone_fee,
                        'info' => $infolog,
                        'type' => 1
                    ], 1, 'zbranchoffice_price_logs', 'Zbranchoffice');
                }
            }
            // 是付费会员才可以给上级会员返利 礼包的这个非会员的上级就得有返利拿了
            if ($udata->level = 2 || $udata->level = 3) {
                // 一级所属会员
                $udataone = $udata->userOneBelong;
                if ($udataone) {
                    if ($edudata->uone_fee) {
                        $this->action_money_log_in($udataone->id, [
                            'price' => $edudata->uone_fee,
                            'info' => $infolog,
                            'type' => 1
                        ], 1);
                    }
                    // 二级所属会员
                    $udatatwo = $udataone->userOneBelong;
                    // dd($udatatwo);
                    if ($udatatwo) {
                        if ($edudata->utwo_fee) {
                            $this->action_money_log_in($udatatwo->id, [
                                'price' => $edudata->utwo_fee,
                                'info' => $infolog,
                                'type' => 1
                            ], 1);
                        }
                        // 三级所属会员
                        $udatathree = $udatatwo->userOneBelong;
                        if ($udatathree) {
                            if ($edudata->three_fee) {
                                $this->action_money_log_in($udatathree->id, [
                                    'price' => $edudata->three_fee,
                                    'info' => $infolog,
                                    'type' => 1
                                ], 1);
                            }
                        }
                    }
                }
            }
        }
    }
}