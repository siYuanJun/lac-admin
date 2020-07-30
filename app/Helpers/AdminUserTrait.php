<?php
/*
 * 后台用户角色实例化资源
 * */

namespace App\Helpers;

use Encore\Admin\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Redis;

trait AdminUserTrait
{
    public $users;
    public $branUser;

    public function users()
    {
        $adminNew = new Admin();
        $this->users = $adminNew->user();
        return $this->users;
    }

    // 工作室登录账号
    public function studUser()
    {
        if ($this->users()->isRole('studios')) {
            if (Auth::guard('studio')->check()) {
                return Auth::guard('studio')->user();
            } else {
                alert(route('stud.login'), '未登录工作室账号');
            }
        }
    }

    // 分公司登录账号
    public function branUser()
    {
        if ($this->users()->isRole('branchoffices')) {
            if (Auth::guard('brancho')->check()) {
                $data = Auth::guard('brancho')->user();
                $data->stud_arr = array_column($data->studBelongsTo->toArray(), 'id');
                Cache::store('redis')->put('admin_user_stud_id', $data->stud_arr, 600000);
                return $data;
            } else {
                alert(route('bran.login'), '未登录分公司账号');
            }
        }
    }
}