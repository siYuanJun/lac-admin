<?php
/*
 * 课程管理
 * */

namespace App\Http\Model;

use App\Models\Zcategory;
use Illuminate\Database\Eloquent\Model;

class Zedu extends Model
{
    // 课程列表
    public static function eduSele()
    {
        $data = [];
        foreach (self::get()->toArray() as $val) {
            $data[$val['id']] = $val['title'];
        }
        return $data;
    }

    // 关联课时列表
    public function classHasMany()
    {
        return $this->hasMany(Zclasse::class, 'edu_id');
    }

    // 关联分类
    public function cateBelong()
    {
        return $this->belongsTo(Zcategory::class, 'classid', 'id');
    }
}
