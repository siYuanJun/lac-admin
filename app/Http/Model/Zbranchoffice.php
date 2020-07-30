<?php
/*
 * 分公司管理二级
 * */

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;

class Zbranchoffice extends User
{
    protected $fillable = [
        'number', 'phone', 'password'
    ];

    protected $hidden = [];

    /*
     * 事业部列表
     * */
    public static function busiSele()
    {
        $data = [];
        foreach (Zbusinessunit::get()->toArray() as $val) {
            $data[$val['id']] = $val['title'] . "[" . $val['mch_id'] . "]";
        }
        return $data;
    }

    // 关联事业部
    public function busiBelongsTo()
    {
        return $this->belongsTo(Zbusinessunit::class, 'busi_id', 'id');
    }

    // 关联工作室列表
    public function studBelongsTo()
    {
        return $this->hasMany(Zstudio::class, 'bran_id_one', 'id');
    }
}
