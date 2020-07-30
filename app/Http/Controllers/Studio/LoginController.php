<?php

namespace App\Http\Controllers\Studio;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class LoginController extends Controller
{
    public function auto_login(Request $request)
    {
        if($request->post()) {
            $data = Auth::guard('studio')->attempt([
                'number' => $request->post('number'),
                'password' => $request->post('password'),
                'status' => 1
            ]);
            if ($data) {
                Auth::guard('admin')->attempt(['username' => '13522841822', 'password' => '1']);
                return Redirect::to('/admin')
                    ->with('message', '成功登录');
            } else {
                return Redirect::to('stud/login')
                    ->with('message', '用户名密码不正确')
                    ->withInput();
            }
        }
        return view('studio.login');
    }
}
