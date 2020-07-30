<?php

namespace App\Admin\Controllers;

use App\Models\Zcategory;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Layout\Content;
use Encore\Admin\Tree;

class CategoryController extends AdminController
{
    protected $title = '分类管理';

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->title($this->title)
            ->body($this->tree());
    }

    /**
     * Make a grid builder.
     *
     * @return Tree
     */
    protected function tree()
    {
        return Zcategory::tree(function (Tree $tree) {

            $tree->branch(function ($branch) {
                if($branch['logo']) {
                    $src = config('admin.upload.host') . '/' . $branch['logo'];
                    $logo = "<img src='$src' style='max-width:30px;max-height:30px' class='img'/>";
                    return "{$branch['id']} - {$branch['title']} $logo";
                }
                return "{$branch['id']} - {$branch['title']}";
            });
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Zcategory);
        //        $form->largefile('ColumnName', 'LabelName');
        $form->tab('简介', function ($form) {
            $form->select('parent_id', '上级分类')->options(Zcategory::selectOptions());
            $form->text('title', '标题')->rules('required');
            $form->textarea('desc', '详情');
            $form->cropper('logo','图片');
        })->tab('动态信息', function ($form) {
            $form->ckeditor('content', '内容');
        });
        return $form;
    }
}
