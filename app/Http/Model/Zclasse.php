<?php
/*
 * 课时管理
 * */

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Zclasse extends Model
{
    // 关联课程模型
    public function eduBelongsTo()
    {
        return $this->belongsTo(Zedu::class, 'edu_id', 'id');
    }
}
