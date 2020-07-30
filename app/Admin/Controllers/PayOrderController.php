<?php

namespace App\Admin\Controllers;

use App\Helpers\CommonTrait;
use App\Helpers\ConfigTrait;
use App\Http\Model\Zpayorder;
use App\Http\Model\Zusernumber;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Str;

class PayOrderController extends AdminController
{
    use ConfigTrait, CommonTrait;

    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '订单管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Zpayorder);
        $grid->disableExport();
        $grid->disableRowSelector();
        $grid->disableCreateButton();
        $grid->actions(function ($actions) {
            // 去掉查看
            $actions->disableView();
        });
        $grid->filter(function ($filter) {
            // 设置created_at字段的范围查询
            $newuser = new Zusernumber;
            $filter->equal('uid', '所属用户')->select($newuser->userSele());
            $filter->equal('status', '状态')->radio($this->extPayStatus);
            $filter->gt('fee', '金额');
        });
        $grid->model()->orderBy("id", "desc");
        $grid->column('id', __('Id'))->sortable();
        $grid->column('userNumberBelong.relname', __('用户'));
        $grid->column('desc', __('详情'))->display(function($val) {
            return Str::limit($val, 30);
        });
        $grid->column('fee', __('金额'));
        $grid->column('payord', __('商户订单号'));
        $grid->column('transaction_id', __('微信订单流水号'))->display(function($val) {
            return $val ? $val : '无';
        });
        $grid->column('paycreatetime', __('支付时间'))->sortable();
        $grid->column('createtime', __('创建时间'))->sortable();
        $grid->column('status', '状态')->using($this->extPayStatus)->label([
            1 => 'default',
            2 => 'success',
        ]);

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
        $show = new Show(Zpayorder::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('uid', __('用户'));
        $show->field('desc', __('详情'));
        $show->field('fee', __('金额'));
        $show->field('payord', __('商户订单号'));
        $show->field('transaction_id', __('微信订单流水号'));
        $show->field('paycreatetime', __('支付时间'));
        $show->field('createtime', __('创建时间'));
        $show->field('status', __('状态'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Zpayorder);

        $form->display('uid', __('用户'));
        $form->display('desc', __('订单详情'));
        $form->display('fee', __('余额'));
        $form->display('paycreatetime', __('支付时间'));
        $form->display('createtime', __('创建时间'));
        $form->display('transaction_id', __('微信订单流水号'));
        $form->display('payord', __('商户订单号'));
        $form->radio('status', '状态')->options($form->model()->extPayStatus)->default(0);
        $form->saving(function (Form $form) {
            if($form->model()->status == 2) {
                return back()->with(admin_warning('提示', '已支付订单不可重复操作！'));
            }
            if($form->status == 2) {
                $this->payCashBack($form->model());
            }
        });
        return $form;
    }
}
