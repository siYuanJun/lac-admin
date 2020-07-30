<?php

namespace App\Http\Model;

use App\Models\Zcategory;
use Illuminate\Database\Eloquent\Model;

class Zad extends Model
{
    // 关联分类
    public function cateBelong()
    {
        return $this->belongsTo(Zcategory::class, 'classid', 'id');
    }
}
