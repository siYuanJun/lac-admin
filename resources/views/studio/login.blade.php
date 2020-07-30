<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="renderer" content="webkit">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>工作室登录</title>
    <link href="{{asset('static/plugins/pintuer.css')}}" rel="stylesheet">
    <link href="{{asset('static/studio/style.css')}}" rel="stylesheet">
    <script src="{{asset('static/plugins/jquery.js')}}"></script>
    <script src="{{asset('static/plugins/pintuer.js')}}"></script>
    <script src="{{asset('static/plugins/common.js')}}"></script>
</head>
<body>
<div align="center">
    <form action="{{route('stud.login.auth')}}" method="post">
        <div class="page-login">
            <div class="panel padding">
                <div class="text-center"><br>
                    <h2><strong>工作室登录</strong></h2></div>
                <div class="padding-large">
                    <div class="form-group form-tips">
                        <div class="field field-icon-right">
                            <input type="text" class="input" name="number" placeholder="登录账号"
                                   data-validate="required:请填写账号,length#>=5:账号长度不符合要求"/>
                            <span class="icon icon-user"></span>
                        </div>
                    </div>
                    <div class="form-group form-tips">
                        <div class="field field-icon-right">
                            <input type="password" class="input" name="password" placeholder="登录密码"
                                   data-validate="required:请填写密码,length#>=3:密码长度不符合要求"/>
                            <span class="icon icon-key"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="field">
                            <button class="button button-block bg-main text-big">立即登录</button>
                        </div>
                    </div>
                    @if(Session::has('message'))
                        <div class="alert alert-blue">
                            <span class="close rotate-hover"></span>
                            <strong>提示：</strong>{{Session::get('message')}}
                        </div>
                    @endif
                    <div class="text-right text-small text-gray padding-top">
                        <a class="text-gray" target="_blank" href="#">{{config('admin.name')}}</a> 版权所有
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" name="_token" value="{{csrf_token()}}">
    </form>
</div>
</body>
</html>