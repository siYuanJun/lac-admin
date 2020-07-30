<?php

namespace App\Admin\Controllers;

use App\Helpers\MapLocalDistance;
use App\Http\Model\Zbranchoffice;
use Doctrine\DBAL\Schema\Table;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class BranchofficeController extends AdminController
{
    use MapLocalDistance;

    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '分公司管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Zbranchoffice);
        $grid->disableExport();
        $grid->disableRowSelector();

        $grid->filter(function ($filter) {
            // 设置created_at字段的范围查询
            $filter->equal('busi_id', '所属事业部')->select(Zbranchoffice::busiSele());
        });

        $grid->model()->orderBy("id", "desc");
        $grid->column('id', __('Id'));
        $grid->column('number', __('账号'));
        $grid->column('gongsi', __('公司名称'));
        $grid->column('phone', __('公司电话'));
        $grid->column('fuzeren', __('负责人'))->filter('like');
        $grid->column('price', __('余额'))->display(function($value) {
            return "<i class='fa fa-yen'></i>{$value}元";
        })->totalRow(function ($amount) {
            return "<span class='text-danger text-bold'>共：<i class='fa fa-yen'></i> {$amount} 元</span>";
        });
        $grid->column('yzcprice', __('已支出'))->display(function ($value) {
            return "<i class='fa fa-yen'></i>{$value}元";
        })->totalRow(function ($amount) {
            return "<span class='text-danger text-bold'>共：<i class='fa fa-yen'></i> {$amount} 元</span>";
        });
        $grid->column('ysrprice', __('已收入'))->display(function ($value) {
            return "<i class='fa fa-yen'></i>{$value}元";
        })->totalRow(function ($amount) {
            return "<span class='text-danger text-bold'>共：<i class='fa fa-yen'></i> {$amount} 元</span>";
        });
        $grid->column('address', __('公司地址'));
//        $grid->column('address_latlnt', __('公司地址经纬度'));
        $grid->column('gzsnum', __('工作室数量'))->modal('旗下工作室', function ($model) {
            $comments = $model->studBelongsTo()->take(100)->get()->map(function ($comment) {
                return $comment->only(['id', 'title', 'number', 'price']);
            });
            return new \Encore\Admin\Widgets\Table(['ID', '工作室名称', '工作室账号', '工作室金额'], $comments->toArray());
        });
        $grid->column('busiBelongsTo.title', __('所属事业部'));
//        $grid->column('created_at', __('添加时间'));
//        $grid->column('updated_at', __('更新时间'));

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
        $show = new Show(Zbranchoffice::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('number', __('账号'));
        $show->field('gongsi', __('公司名称'));
        $show->field('password', __('密码'));
        $show->field('price', __('公司余额'));
        $show->field('address', __('公司地址'));
        $show->field('phone', __('公司电话'));
        $show->field('gzsnum', __('工作室数量'));
        $show->field('busi_id', __('所属事业部'));
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
        $form = new Form(new Zbranchoffice);

        $form->select('busi_id', __('所属事业部'))->options($form->model()->busiSele())->required();
        $form->text('number', __('账号'))->rules('required|min:3');
        $form->password('password', __('密码'))->rules('required|min:3');
        $form->text('gongsi', __('公司名称'))->rules('required|min:3');
        $form->currency('price', __('余额'))->symbol('￥')->readonly();
        $form->text('address', __('公司地址'))->rules('required|min:3');
        $form->mobile('phone', __('公司电话'))->rules('required|min:3');
        $form->text('fuzeren', __('负责人'))->rules('required|min:1');
        $form->hidden('address_latlnt');

        //保存前回调
        $form->saving(function (Form $form) {
            if ($form->address) {
                $latlnt = $this->MapGeocoderJk($form->address);
                if (isset($latlnt['location']['lat'])) {
                    $form->address_latlnt = $latlnt['location']['lat'] . ',' . $latlnt['location']['lng'];
                } else {
                    return back()->with(admin_warning('提示', '地址信息定位错误'));
                }
            }
            //修改时密码处理
            if ($form->password != $form->model()->password) {
                $form->password = bcrypt($form->password); //密码处理
            }
        });
        return $form;
    }
}
