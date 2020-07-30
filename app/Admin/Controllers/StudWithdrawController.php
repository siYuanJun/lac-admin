<?php
/*
 * 工作室提现申请管理
 * */

namespace App\Admin\Controllers;

use App\Helpers\AdminUserTrait;
use App\Helpers\CommonTrait;
use App\Helpers\ConfigTrait;
use App\Http\Model\Zstud_withdraw;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class StudWithdrawController extends AdminController
{
    use ConfigTrait, AdminUserTrait, CommonTrait;

    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '工作室提现管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Zstud_withdraw);
        $grid->disableExport();
        $grid->disableActions();
        if (!$this->studUser()) {
            $grid->disableCreateButton();
        }

        if($this->studUser()) {
            $grid->model()->where('stud_id', '=', $this->studUser()->id);
        }

        $grid->model()->orderBy("id", "desc");
        $grid->filter(function ($filter) {
            // 设置created_at字段的范围查询
            $filter->like('ord', '单号');
            $filter->like('zfbkahao', '支付宝卡号');
            $filter->equal('status', '状态')->radio($this->extTxStatus);
        });

        $grid->column('id', __('Id'))->sortable();
        $grid->column('studBelongTo.title', __('工作室名称'));
        $grid->column('price', __('提现金额'));
        $grid->column('ord', __('单号'));
        $grid->column('type', __('提现方式'))->using($this->extTixianFs)->label([
            1 => 'default',
            2 => 'success',
        ]);
        $grid->column('zfbkahao', __('支付宝卡号'));
        // 工作室不能直接更改状态
        if ($this->studUser()) {
            $grid->column('status', __('状态'))->using($this->extTxStatus)->label([
                1 => 'warning',
                2 => 'default',
            ]);
        } else {
            $grid->column('status', __('状态'))->radio($this->extTxStatus);
        }
        $grid->column('created_at', __('提交时间'))->sortable();
        $grid->column('updated_at', __('更新时间 '))->sortable();

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
        $show = new Show(Zstud_withdraw::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('uid', __('工作室名称'));
        $show->field('type', __('提现方式'));
        $show->field('price', __('提现金额'));
        $show->field('ord', __('单号'));
        $show->field('status', __('状态'));
        $show->field('zfbkahao', __('支付宝卡号'));
        $show->field('created_at', __('提交时间'));
        $show->field('updated_at', __('更新时间 '));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Zstud_withdraw);
        $form->hidden('stud_id');
        $form->radio('type', __('提现方式'))->options($this->extTixianFs)->default(2);
        $form->currency('price', __('余额'))->symbol('￥');
        if($this->studUser()) {
            $form->html("当前可提现余额: <font color='red'>" . number_format($this->studUser()->price, 2) . "￥</font>");
        }
        $form->text('zfbkahao', __('支付宝账号'));
        $form->hidden('ord');
        if ($this->studUser()) {
            $form->hidden('status');
        } else {
            $form->radio('status', '状态')->options($this->extTxStatus);
        }
        $form->saving(function (Form $form) {
//            return back()->with(admin_warning('提示', '提现模块维护中'));
            // 单项数据修改
            if($form->model()->status == 2) {
                return response([
                    'status'  => true,
                    'message' => "已提现数据，不可重复操作！",
                ]);
            }

            if($this->studUser()) {
                $form->price = intval($form->price);
                $form->stud_id = $this->studUser()->id;
                $form->status = 1;
                if ($form->price < 5) {
                    return back()->with(admin_warning('提示', '提现金额不能小于五元'));
                }
                if ($this->studUser()->price < $form->price) {
                    return back()->with(admin_warning('提示', "工作室账户余额不足，当前余额 {$this->studUser()->price}￥"));
                }
                if ($form->type == 2) {
                    if (!$form->zfbkahao) {
                        return back()->with(admin_warning('提示', '请输入支付宝卡号'));
                    }
                }
                $this->action_money_log_in($this->studUser()->id, [
                    'price' => $form->price,
                    'info' => '提现',
                    'type' => 2
                ], 0, 'zstud_price_logs', 'Zstudio');
                if (empty($form->model()->ord)) {
                    $form->ord = get_order_sn();
                }
            }
        });
        return $form;
    }
}
