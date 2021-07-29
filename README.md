<p align="center">
    <img src="https://s1.ax1x.com/2020/08/14/diu3WT.png" />
</p>

<h1 align="center">Lac-Admin</h1>

<p align="center">
<a href="http://blog.lvtcn.com"><img src="https://img.shields.io/badge/version-1.0.0-green"></a>
<a href="https://github.com/laravel/laravel/tree/v6.2.0"><img src="https://img.shields.io/badge/laravel-6.2-%23ef3b2d"></a>
<a href="https://laravel-admin.org/"><img src="https://img.shields.io/badge/laraveladmin-1.7-%234c5ec2"></a>
<a href="http://blog.lvtcn.com"><img src="https://img.shields.io/badge/MYSQL-5.7-%2300758f"></a>
</p>

### 项目介绍

项目是经作者（siYuanJun）之前做过的一个 `知识付费系统` 的进一步整理，以 `Laravel^6.2` `Laravel-admin^1.7` 为基础搭建的Web应用房屋模型， 可供 `Cms` `商城` `微信小程序` 便捷开发使用。
<p align="left">
    <b>如果对您有帮助，您可以点右上角 "Star" 支持一下 谢谢！</b>
</p>

### 安装说明

> 为防止 composer-vendor 拉取过慢，已把扩展包文件进行压缩，可直接在 /vendor 文件夹进行解压操作！

1. 解压过后运行一下命令进行 Laravel-Admin 资源包发布

```
php artisan vendor:publish --provider="Encore\Admin\AdminServiceProvider"
```

如感觉依次发布各个扩展包资源文件比较麻烦，可直接当前解压 /public/vendor 资源文件即可！

2. Mysql 数据库可直接把 /database/Lac-Admin.sql 文件导入即可。默认后台账号密码 super super

License
------------
Licensed under [The MIT License (MIT)](LICENSE).
