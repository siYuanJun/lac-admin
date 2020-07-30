<?php
/*
 * 工作室管理三级
 * */

namespace App\Http\Model;

use App\Helpers\AdminUserTrait;
use Encore\Admin\Admin;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class Zstudio extends User
{
    use AdminUserTrait;

    protected $fillable = [
        'number', 'phone', 'password'
    ];

    protected $hidden = [];

    // 工作室列表
    public function studSele()
    {
        // 分公司显示旗下控制室控制
        $branUser = $this->branUser();
        if ($branUser) {
            $studData = $this->whereIn('id', $branUser->stud_arr)->get()->toArray();
        } else {
            $studData = $this->get()->toArray();
        }

        $data = [];
        array_unshift($data, '无');
        foreach ($studData as $val) {
            $data[$val['id']] = $val['title'] . "-" . $val['number'];
        }
        return $data;
    }

    // 分公司列表
    public static function branSele()
    {
        $data = [];
        foreach (Zbranchoffice::get()->toArray() as $val) {
            $data[$val['id']] = $val['gongsi'] . "[" . $val['number'] . "]";
        }
        return $data;
    }

    // 关联上级工作室
    public function studFidBelongTo()
    {
        return $this->belongsTo(Zstudio::class, 'stud_fid', 'id');
    }

    // 拥有工作室列表
    public function studFidHasMany()
    {
        return $this->hasMany(Zstudio::class, 'stud_fid', 'id');
    }

    // 关联原分公司
    public function studOneBelongTo()
    {
        return $this->belongsTo(Zbranchoffice::class, 'bran_id_one', 'id');
    }

    // 关联转移分公司
    public function studTwoBelongTo()
    {
        return $this->belongsTo(Zbranchoffice::class, 'bran_id_two', 'id');
    }

    // 拥有用户列表
    public function userNumberHasMany()
    {
        return $this->hasMany(Zusernumber::class, 'stud_id', 'id');
    }

    // 关联工作室提现记录
    public function withHasMany()
    {
        return $this->hasMany(Zstud_withdraw::class, 'stud_id', 'id');
    }

    // 关联工作室余额记录
    public function priceLogHasMany()
    {
        return $this->hasMany(Zstud_price_log::class, 'stud_id', 'id');
    }

    /*
     * 工作室数量更新
     * */
    public function studNumUpda()
    {
        foreach ($this->get() as $key => $val) {
            $studcount = $val->studFidHasMany->count();
            $val->numstud = $studcount;
            $val->save();
        }
    }

    /*
     * 分公司数量更新
     * */
    public function branNumUpda()
    {
        foreach (Zbranchoffice::get() as $key => $val) {
            $studcount = $val->studBelongsTo->count();
            $val->gzsnum = $studcount;
            $val->save();
        }
    }
}
