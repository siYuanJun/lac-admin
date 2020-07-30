<?php
/*
 * 订单管理
 * */

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Zuserwxinfo extends Model
{
    public $fillable = ['openid', 'nickname', 'gender', 'province', 'city', 'country', 'avatarurl'];

    // 关联用户
    public function userNumberBelongsTo()
    {
        return $this->belongsTo(Zusernumber::class, 'openid', 'openid');
    }
}
