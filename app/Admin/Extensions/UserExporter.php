<?php
/*
 * 用户数据导出模型
 * */

namespace App\Admin\Extensions;

use App\Helpers\ConfigTrait;
use Encore\Admin\Grid\Exporters\ExcelExporter;
use Maatwebsite\Excel\Concerns\WithMapping;

class UserExporter extends ExcelExporter implements WithMapping
{
    protected $fileName = '会员数据.xlsx';

    protected $columns = [
        'id'            => 'ID',
        'bran_id'       => '所属分公司',
        'ysstud_id'     => '原始工作室',
        'stud_id'       => '服务工作室',
        'relname'       => '姓名',
        'phonenumber'   => '手机号',
        'idcard'        => '身份证',
        'childname'     => '孩子姓名',
        'childidcard'   => '孩子身份证',
        'price'         => '余额',
        'usernum'       => '会员数量',
        'uid_onelevel'  => '所属上级会员',
        'level'         => '级别',
    ];

    public function map($user) : array
    {
        $bran = "";
        // 获取分公司
        if($user->studioBelong) {
            if($user->studioBelong->studOneBelongTo) {
                $bran = $user->studioBelong->studOneBelongTo->gongsi;
            }
        }

        return [
            $user->id,
            $bran,
            "(".data_get($user, 'studioFirstBelong.id').")" . data_get($user, 'studioFirstBelong.title'),    // 读取关联关系数据
            "(".data_get($user, 'studioBelong.id').")" . data_get($user, 'studioBelong.title'),    // 读取关联关系数据
            $user->relname,
            $user->phonenumber,
            $user->idcard,
            $user->childname,
            $user->childidcard,
            $user->price,
            $user->usernum,
            data_get($user, 'userOneBelong.relname'),
            $user->ext_level[$user->level],
        ];

//        data_get($user, 'studioBelong.title'),    // 读取关联关系数据
    }
}