<?php
/*
 * 工作室余额记录
 * */

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Zbranchoffice_price_log extends Model
{
    // 关联分公司
    public function branBelongTo()
    {
        return $this->belongsTo(Zbranchoffice::class, 'uid', 'id');
    }
}
