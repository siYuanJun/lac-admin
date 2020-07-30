<?php

namespace App\Admin\Controllers;

use App\Helpers\AdminUserTrait;
use App\Http\Model\Zbusinessunit;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class BusinessunitController extends AdminController
{
    use AdminUserTrait;

    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '事业部管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Zbusinessunit);
        $grid->disableExport();
        $grid->disableRowSelector();

        $grid->model()->orderBy("id", "desc");
        $grid->column('id', __('Id'));
        $grid->column('title', __('事业部名称'));
        $grid->column('mch_id', __('商户Mch_id'));
        $grid->column('mch_api_key', __('商户Mch_api_key'));
        $grid->column('mch_cert', __('商户秘钥文件Mch_cert'));
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
        $show = new Show(Zbusinessunit::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('title', __('事业部名称'));
        $show->field('mch_id', __('商户Mch_id'));
        $show->field('mch_api_key', __('商户Mch_api_key'));
        $show->field('mch_cert', __('商户秘钥文件Mch_cert'));
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
        $form = new Form(new Zbusinessunit);

        $form->text('title', __('事业部名称'))->required();
        $form->text('mch_id', __('商户mch_id'))->required();
        $form->text('mch_api_key', __('商户mch_api_key'))->required();
        $form->file('mch_cert', __('商户秘钥文件mch_cert'));
//        $form->largefile('mch_cert', __('文件'));

        return $form;
    }
}
