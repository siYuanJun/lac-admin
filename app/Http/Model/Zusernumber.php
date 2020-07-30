<?php
/*
 * 会员管理
 * */

namespace App\Http\Model;

use App\Helpers\AdminUserTrait;
use Illuminate\Database\Eloquent\Model;

class Zusernumber extends Model
{
    use AdminUserTrait;

    public $catadata = [];

    protected $fillable = ['relname', 'idcard', 'childname', 'childidcard'];

    public $ext_level = [1 => '普通会员', 2 => 'VIP会员', 3 => 'SVIP会员'];

    // 我的课程
    public function uOrderEduNum($data)
    {
        return Zpayorder::where(['status' => 2, 'uid' => $data->id])->count();
    }

    // 用户列表
    public function userSele($uid = 0)
    {
        $this->getcata($uid);
        $data = $this->catadata;
        array_unshift($data, ['id' => 0, 'title' => '顶级']);
        $data = array_column($data, 'title', 'id');
        return $data;
    }

    // 我的一级用户列表
    public function userOneHasm()
    {
        return $this->hasMany(Zusernumber::class, 'uid_onelevel', 'id');
    }

    // 我的二级用户列表
    public function userTwoHasm()
    {
        return $this->hasMany(Zusernumber::class, 'uid_twolevel', 'id');
    }

    // 关联一级用户
    public function userOneBelong()
    {
        return $this->belongsTo(Zusernumber::class, 'uid_onelevel', 'id');
    }

    // 关联二级用户
    public function userTwoBelong()
    {
        return $this->belongsTo(Zusernumber::class, 'uid_twolevel', 'id');
    }

    // 关联服务工作室
    public function studioBelong()
    {
        return $this->belongsTo(Zstudio::class, 'stud_id', 'id');
    }

    // 关联原始工作室
    public function studioFirstBelong()
    {
        return $this->belongsTo(Zstudio::class, 'ysstud_id', 'id');
    }

    // 关联用户提现记录
    public function withHasMany()
    {
        return $this->hasMany(Zuser_withdraw::class, 'id', 'uid');
    }

    // 关联用户余额记录
    public function priceLogHasMany()
    {
        return $this->hasMany(Zuser_price_log::class, 'uid', 'id');
    }

    // 关联微信用户信息
    public function userWxHasOne()
    {
        return $this->hasOne(Zuserwxinfo::class, 'openid', 'openid');
    }

    // 添加时更新动态数据
    public function createdPull()
    {
        $this->updatesort();
        $this->uNumUpda();
        $this->studUserNum();
    }

    // 处理层级关系
    private function updatesort($fid = 0, $dp = 0, $sorts = "")
    {
        $dp = $dp + 1;
        $data = $this->where('uid_onelevel', $fid)->get();
        foreach ($data as $key => $val) {
            if ($fid == 0) {
                $sortss = "|{$val->id}|";
            } else {
                $sortss = "{$sorts}{$val->id}|";
            }
            $val->sorts = $sortss;
            $val->deep = $dp;
            $val->save();
            $this->updatesort($val->id, $dp, $sortss);
        }
    }

    // 处理族谱的会员数量
    private function uNumUpda()
    {
        // 我的层级记录值
        foreach ($this->get() as $key => $val) {
            $model = $val;
            $sortsarr = explode("|", $model->sorts);
            array_pop($sortsarr);
            array_shift($sortsarr);
            $sort = "";
            foreach ($sortsarr as $keys => $vals) {
                if ($keys == 0) {
                    $sort .= "|$vals|";
                } else {
                    $sort .= "$vals|";
                }
                // 计算家族数量，每个会员的数量除去自己
                $count = $this->where('sorts', 'like', "%{$sort}%")->where('sorts', '!=', $sort)->count();
                $this->where('id', $vals)->update(['usernum' => $count]);
            }
        }
    }

    // 工作室会员数量更新
    private function studUserNum()
    {
        foreach (Zstudio::get() as $key => $val) {
            // 旗下会员
            $val->numbernum = $val->userNumberHasMany->count();
            $val->save();
        }
    }

    // 用户列表层级处理
    private function getcata($fid = 0)
    {
        $branUser = $this->branUser();
        if($fid == 0 && $branUser) {
            $data = $this->where(['uid_onelevel' => $fid])->whereIn('ysstud_id', $branUser->stud_arr)->get();
        } else {
            $data = $this->where(['uid_onelevel' => $fid])->get();
        }
        foreach ($data as $key => $val) {
            $datas = array(
                'id' => $val->id,
                'title' => $this->showstr($val->deep) . $val->relname . "-" . $val->invite_code . "-" . $val->phonenumber,
            );
            $this->catadata[] = $datas;
            //判断当前父亲是否有孩子
            $fidData = $this->getcata($val->id);
            if ($fidData) {
                $this->catadata[] = $fidData;
            }
        }
    }

    private function showstr($len)
    {
        $nstr = '';
        if ($len > 1) {
            for ($i = 1; $i <= $len * 2 - 2; $i++) {
                $nstr .= '┈';
            }
            $nstr = "└{$nstr}┤";
        }
        return $nstr;
    }
}
