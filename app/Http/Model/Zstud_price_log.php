<?php
/*
 * 工作室余额记录
 * */

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Zstud_price_log extends Model
{
    // 关联工作室
    public function studBelongTo()
    {
        return $this->belongsTo(Zstudio::class, 'uid', 'id');
    }
}
