<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Zpayorder extends Model
{
    public $fillable = ['uid', 'shop_id', 'desc', 'fee', 'payord', 'status', 'createtime'];

    public $timestamps = false;

    // 支付状态
    public $extPayStatus = ['默认', '待支付', '已支付'];

    // 关联用户
    public function userNumberBelong()
    {
        return $this->belongsTo(Zusernumber::class, 'uid', 'id');
    }

    // 关联商品
    public function eduBelong()
    {
        return $this->belongsTo(Zedu::class, 'shop_id', 'id');
    }
}
