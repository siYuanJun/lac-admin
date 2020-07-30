<?php
/*
 * 分公司提现记录
 * */

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Zbran_withdraw extends Model
{
    // 关联工作室
    public function branBelongTo()
    {
        return $this->belongsTo(Zbranchoffice::class, 'bran_id', 'id');
    }
}
