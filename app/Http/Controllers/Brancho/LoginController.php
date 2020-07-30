<?php

namespace App\Http\Controllers\Brancho;

use App\Helpers\AdminUserTrait;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class LoginController extends Controller
{
    use AdminUserTrait;

    public function auto_login(Request $request)
    {
        if($request->post()) {
            $data = Auth::guard('brancho')->attempt([
                'number' => $request->post('number'),
                'password' => $request->post('password'),
            ]);
            if ($data) {
                Auth::guard('admin')->attempt(['username' => '13522841811', 'password' => '1']);
                $this->branUser();
                return Redirect::to('/admin')
                    ->with('message', '成功登录');
            } else {
                return Redirect::to('bran/login')
                    ->with('message', '用户名密码不正确')
                    ->withInput();
            }
        }
        return view('brancho.login');
    }
}
