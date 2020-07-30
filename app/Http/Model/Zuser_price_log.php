<?php
/*
 * 用户余额记录
 * */

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Zuser_price_log extends Model
{
    // 关联用户
    public function userHelongsTo()
    {
        return $this->belongsTo(Zusernumber::class, 'uid', 'id');
    }
}
