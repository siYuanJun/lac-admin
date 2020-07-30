<?php

/**
 * Laravel-admin - admin builder based on Laravel.
 * @author z-song <https://github.com/z-song>
 *
 * Bootstraper for Admin.
 *
 * Here you can remove builtin form field:
 * Encore\Admin\Form::forget(['map', 'editor']);
 *
 * Or extend custom form field:
 * Encore\Admin\Form::extend('php', PHPEditor::class);
 *
 * Or require js and css assets:
 * Admin::css('/packages/prettydocs/css/styles.css');
 * Admin::js('/packages/prettydocs/js/main.js');
 *
 */

use Encore\Admin\Facades\Admin;

Encore\Admin\Form::forget(['map', 'editor']);
Encore\Admin\Form::extend('largefile', \Encore\LargeFileUpload\LargeFileField::class);

Admin::navbar(function (\Encore\Admin\Widgets\Navbar $navbar) {

//    $navbar->left('html...');
    $navbar->right(new \App\Admin\Extensions\Nav\Links());
//    $navbar->right(view('links-bar'));
});