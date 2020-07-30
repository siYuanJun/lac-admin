<?php
/*
 * 用户提现记录
 * */

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Zuser_withdraw extends Model
{
    // 关联用户
    public function userBelongsTo()
    {
        return $this->belongsTo(Zusernumber::class, 'uid', 'id');
    }
}
