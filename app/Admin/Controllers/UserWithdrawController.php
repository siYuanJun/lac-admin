<?php
/*
 * 用户提现申请管理
 * */

namespace App\Admin\Controllers;

use App\Helpers\ConfigTrait;
use App\Http\Model\Zuser_withdraw;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class UserWithdrawController extends AdminController
{
    use ConfigTrait;

    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '用户提现管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Zuser_withdraw);
        $grid->disableExport();
        $grid->disableCreateButton();
        $grid->disableActions();

        $grid->filter(function ($filter) {
            // 设置created_at字段的范围查询
            $filter->like('ord', '单号');
            $filter->like('zfbkahao', '支付宝卡号');
            $filter->equal('status', '状态')->radio($this->extTxStatus);
        });

        $grid->model()->orderBy("id", "desc");
        $grid->column('id', __('Id'))->sortable();
        $grid->column('userBelongsTo.relname', __('用户名'));
        $grid->column('price', __('提现金额'));
        $grid->column('ord', __('单号'));
        $grid->column('type', __('提现方式'))->using($this->extTixianFs)->label([
            0 => 'default',
            1 => 'success',
            2 => 'info',
        ]);
        $grid->column('zfbkahao', __('支付宝卡号'));
        $grid->column('status', __('状态'))->radio($this->extTxStatus);
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
        $show = new Show(Zuser_withdraw::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('uid', __('用户名'));
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
        $form = new Form(new Zuser_withdraw);

        $form->display('uid', __('用户'));
        $form->radio('type', __('提现方式'))->options($this->extTixianFs);
        $form->currency('price', __('余额'))->symbol('￥')->required();
        $form->text('ord', __('单号'));
        $form->text('zfbkahao', __('支付宝账号'));
        $form->radio('status', '状态')->options($this->extTxStatus);

        $form->saving(function (Form $form) {
            // 单项数据修改
            if($form->model()->status == 2) {
                return response([
                    'status'  => true,
                    'message' => "已提现数据，不可重复操作！",
                ]);
            }
        });
        return $form;
    }
}
