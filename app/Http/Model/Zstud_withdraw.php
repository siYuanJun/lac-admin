<?php
/*
 * 工作室提现记录
 * */

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Zstud_withdraw extends Model
{
    // 关联工作室
    public function studBelongTo()
    {
        return $this->belongsTo(Zstudio::class, 'stud_id', 'id');
    }
}
