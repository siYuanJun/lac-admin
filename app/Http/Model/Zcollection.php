<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Zcollection extends Model
{
    // 关联课程
    public function collBelong()
    {
        return $this->belongsTo(Zedu::class, 'shop_id');
    }
}
