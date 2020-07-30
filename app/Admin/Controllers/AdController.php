<?php

namespace App\Admin\Controllers;

use App\Http\Model\Zad;
use App\Models\Zcategory;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class AdController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '广告图管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Zad);
        $grid->disableExport();
        $grid->disableRowSelector();
        $grid->filter(function ($filter) {
            // 设置created_at字段的范围查询
            $filter->equal('classid', '所属分类')->select(Zcategory::selectOptions());
        });

        $grid->model()->orderBy("id", "desc");
        $grid->column('id', __('Id'));
        $grid->column('cateBelong.title', __('分类'));
        $grid->column('title', __('标题'))->editable();
        $grid->column('img', __('图片'))->gallery(['width' => 30, 'zooming' => true]);
        $grid->column('ordernum', __('排序'))->editable();
        $grid->column('created_at', __('添加时间'));
        $grid->column('updated_at', __('更新时间'));

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Zad::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('classid', __('分类'));
        $show->field('title', __('标题'));
        $show->field('img', __('图片'));
        $show->field('ordernum', __('排序'));
        $show->field('created_at', __('添加时间'));
        $show->field('updated_at', __('更新时间'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Zad);

        $form->select('classid', '分类')->options(Zcategory::selectOptions());
        $form->text('title', __('标题'));
        $form->textarea('desc', __('详情'));
        $form->cropper('img', '图片');
        $form->number('ordernum', __('排序'))->default(0);
        $form->saving(function (Form $form) {
            if(!$form->title) {
                $form->title = "未命名";
            }
        });
        return $form;
    }
}
