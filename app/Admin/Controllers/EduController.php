<?php

namespace App\Admin\Controllers;

use App\Helpers\ConfigTrait;
use App\Http\Model\Zedu;
use App\Models\Zcategory;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Illuminate\Support\Str;

class EduController extends AdminController
{
    use ConfigTrait;

    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '商品管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Zedu);
        $grid->disableExport();
        $grid->disableRowSelector();
        $grid->filter(function ($filter) {
            // 设置created_at字段的范围查询
            $filter->equal('classid', '所属分类')->select(Zcategory::selectOptions());
        });

        $grid->model()->orderBy("id", "desc");
        $grid->column('id', __('Id'));
        $grid->column('cateBelong.title', __('所属分类'));
        $grid->column('title', __('标题'))->filter('like')->display(function ($val) {
            return Str::limit($val, 30);
        });
        $grid->column('lsname', __('老师名称'))->filter('like');
        $grid->column('img', __('图片'))->gallery(['width' => 100, 'zooming' => true]);
        $grid->column('fhy_fee', __('非会员价格'));
        $grid->column('vip_fee', __('vip价格'));
        $grid->column('svip_fee', __('svip价格'));
        $grid->column('uone_fee', __('一级会员获利'));
        $grid->column('utwo_fee', __('二级会员获利'));
//        $grid->column('three_fee', __('三级会员获利'));
        $grid->column('stud_fee', __('工作室获利'));
        $grid->column('branone_fee', __('分公司获利'));
//        $grid->column('brantwo_fee', __('二级分公司获利'));
        $grid->column('status', '状态')->filter($this->extFilterStatus)->switch($this->extCaoStatus);
        $grid->column('shop_type', __('类型'))->using($this->extShopType)->label([
            0 => 'default',
            1 => 'default',
            2 => 'warning',
            3 => 'info',
        ]);
        $grid->column('attributes', '属性')->radio($this->extRadioAttributes);
        $grid->column('ordernum', __('排序'))->editable();

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
        $show = new Show(Zedu::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('classid', __('所属分类'));
        $show->field('title', __('标题'));
        $show->field('lsname', __('老师名称'));
        $show->field('img', __('图片'));
        $show->field('hy_fee', __('会员价格'));
        $show->field('fhy_fee', __('非会员价格'));
        $show->field('uone_fee', __('一级会员获利'));
        $show->field('utwo_fee', __('二级会员获利'));
//        $show->field('three_fee', __('三级会员获利'));
        $show->field('stud_fee', __('工作室获利'));
        $show->field('branone_fee', __('分公司获利'));
//        $show->field('brantwo_fee', __('二级分公司获利'));
        $show->field('status', __('状态'));
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
        $form = new Form(new Zedu);
        $form->tab('简介', function ($form) {
            $form->select('classid', '分类')->options(Zcategory::selectOptions());
            $form->text('title', __('标题'))->required();
            $form->textarea('desc', '详情')->rules('required|max:255', [
                'max' => '详情不能大于255个字符',
            ]);
            $form->text('lsname', __('老师名称'))->required();
            $form->cropper('img', '图片');
            $form->radio('attributes', '属性')->options($this->extRadioAttributes);
            $form->radio('shop_type', '类型')->options($this->extShopType)->default(1);
            $form->switch('status', '状态')->states($this->extCaoStatus)->default(1);
            $form->number('ordernum', __('排序'))->default(0);
        })->tab('金额设置', function ($form) {
            $form->currency('fhy_fee', __('非会员金额'))->symbol('￥')->required();
            $form->currency('vip_fee', __('vip金额'))->symbol('￥')->required();
            $form->currency('svip_fee', __('svip金额'))->symbol('￥')->required();
            $form->divider();
//            $form->currency('three_fee', __('三级会员获利金额'))->symbol('￥')->required();
//            $form->currency('brantwo_fee', __('二级分公司获利金额'))->symbol('￥')->required();
            $form->currency('uone_fee', __('一级会员获利金额'))->symbol('￥')->required();
            $form->currency('utwo_fee', __('二级会员获利金额'))->symbol('￥')->required();
            $form->currency('stud_fee', __('工作室获利金额'))->symbol('￥')->required();
            $form->currency('branone_fee', __('分公司获利金额'))->symbol('￥')->required();
            $form->divider();
            $form->currency('vip_uone_fee', __('vip一级会员获利金额'))->symbol('￥')->required();
            $form->currency('vip_utwo_fee', __('vip二级会员获利金额'))->symbol('￥')->required();
            $form->currency('vip_stud_fee', __('vip工作室获利金额'))->symbol('￥')->required();
            $form->currency('vip_branone_fee', __('vip分公司获利金额'))->symbol('￥')->required();
            $form->divider();
            $form->currency('svip_uone_fee', __('svip一级会员获利金额'))->symbol('￥')->required();
            $form->currency('svip_utwo_fee', __('svip二级会员获利金额'))->symbol('￥')->required();
            $form->currency('svip_stud_fee', __('svip工作室获利金额'))->symbol('￥')->required();
            $form->currency('svip_branone_fee', __('svip分公司获利金额'))->symbol('￥')->required();
        })->tab('内容设置', function ($form) {
            $form->ckeditor('content', '内容');
        });
        $form->saving(function (Form $form) {
        });
        return $form;
    }
}
