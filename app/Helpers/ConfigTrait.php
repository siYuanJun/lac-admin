<?php
/*
 * 控制器通用参数
 * */

namespace App\Helpers;

trait ConfigTrait
{
    // 状态快捷搜索
    public $extFilterStatus = ['未开启', '开启'];
    // 信息开关
    public $extCaoStatus = [
        'off' => ['value' => 0, 'text' => '未开启', 'color' => 'danger'],
        'on'  => ['value' => 1, 'text' => '开启', 'color' => 'success'],
    ];
    // 文章属性
    public $extRadioAttributes = ['默认', '推荐', '最新'];
    // 商品类型
    public $extShopType = [0 => '默认', 1 => '课程', 2 => 'vip礼包', 3 => 'svip礼包'];
    // 审核信息状态
    public $extShStatus = [1 => '待审核', 2 => '已处理'];
    // 提现信息状态
    public $extTxStatus = [1 => '待提现', 2 => '已提现'];
    // 提现方式
//    public $extTixianFs = [1 => '微信', 2 => '支付宝'];
    public $extTixianFs = [2 => '支付宝'];
    // 支付状态
    public $extPayStatus = [1 => '待支付', 2 => '已支付'];
}