<?php
/*
 * 事业部管理一级
 * */


namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Zbusinessunit extends Model
{
    // 关联下级分公司
    public function branHasMany()
    {
        return $this->hasMany(Zbranchoffice::class, 'bran_id','id');
    }
}
