<?php

namespace App\Admin\Controllers;

use App\Helpers\AdminUserTrait;
use App\Helpers\ConfigTrait;
use App\Http\Model\Zbranchoffice_price_log;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class BranPriceLogController extends AdminController
{
    use ConfigTrait, AdminUserTrait;

    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '分公司余额明细';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Zbranchoffice_price_log);
        $grid->disableExport();
        $grid->disableActions();
        $grid->disableCreateButton();
        if($this->branUser()) {
            $grid->model()->where('uid', '=', $this->branUser()->id);
        }

        $grid->model()->orderBy("id", "desc");
        $grid->column('id', __('Id'))->sortable();
        $grid->column('branBelongTo.gongsi', __('分公司名称'));
        $grid->column('price', __('金额'))->totalRow(function ($amount) {
            return "<span class='text-danger text-bold'>共：<i class='fa fa-yen'></i> {$amount} 元</span>";
        });
        $grid->column('yueprice', __('余额'));
        $grid->column('info', __('原因'));
        $grid->column('type', __('类型'))->using(extPriceLogType())->label([
            1 => 'warning',
            2 => 'default',
            3 => 'info',
        ]);
        $grid->column('created_at', __('操作时间'));

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
        $show = new Show(Zbranchoffice_price_log::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('uid', __('Uid'));
        $show->field('price', __('Price'));
        $show->field('yueprice', __('Yueprice'));
        $show->field('info', __('Info'));
        $show->field('type', __('Type'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Zbranchoffice_price_log);

        $form->number('uid', __('Uid'));
        $form->decimal('price', __('Price'))->default(0.00);
        $form->decimal('yueprice', __('Yueprice'))->default(0.00);
        $form->text('info', __('Info'));
        $form->number('type', __('Type'));

        return $form;
    }
}
