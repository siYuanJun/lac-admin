<?php

namespace App\Admin\Controllers;

use App\Helpers\AdminUserTrait;
use App\Helpers\ConfigTrait;
use App\Helpers\MapLocalDistance;
use App\Http\Model\Zstudio;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\MessageBag;

class StudioController extends AdminController
{
    use MapLocalDistance, ConfigTrait, AdminUserTrait;

    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '工作室管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $model = new Zstudio;
        $grid = new Grid($model);
        $grid->disableExport();
        $grid->disableRowSelector();
        $branuser = $this->branUser();
        if ($branuser) {
            $grid->disableCreateButton();
            $grid->disableActions();
        }

        $grid->actions(function ($actions) {
            // 去掉查看
            $actions->disableView();
        });
        $grid->filter(function ($filter) {
            $filter->between('created_at', '添加时间')->date();
            if (!$this->branUser()) {
                $filter->equal('bran_id_one', '原分公司')->select(Zstudio::branSele());
                $filter->equal('bran_id_two', '	转移分公司')->select(Zstudio::branSele());
            }
        });

        if ($branuser) {
            $grid->model()->whereIn('id', $branuser->stud_arr);
        }
        $grid->model()->orderBy("id", "desc");
        $grid->column('id', __('Id'))->sortable();
        $grid->column('number', __('账号'))->filter('like');
        $grid->column('title', __('名称'))->filter('like');
        $grid->column('address', __('地址'))->limit(10)->filter('like');
        $grid->column('fuzeren', __('负责人'))->filter('like');
        $grid->column('phone', __('电话'))->filter('like');
        $grid->column('studFidBelongTo.title', __('上级工作室'))->display(function ($val) {
            return $val ? $val : '无';
        });
        $grid->column('numstud', __('旗下工作室数量'))->modal('旗下工作室', function ($model) {
            $comments = $model->studFidHasMany()->take(100)->get()->map(function ($data) {
                return $data->only(['id', 'title']);
            });
            return new \Encore\Admin\Widgets\Table(['ID', '工作室名称'], $comments->toArray());
        });
        $grid->column('numbernum', __('旗下会员数量'))->modal('旗下会员', function ($model) {
            $comments = $model->userNumberHasMany()->take(100)->get()->map(function ($data) {
                return $data->only(['id', 'phonenumber', 'relname', 'price', 'childname', 'recent_createtime']);
            });
            return new \Encore\Admin\Widgets\Table(['ID', '手机号', '姓名', '余额', '孩子姓名', '最近登录时间'], $comments->toArray());
        });
        $grid->column('price', __('余额'))->filter('range')->display(function ($value) {
            return "<i class='fa fa-yen'></i>{$value}元";
        })->totalRow(function ($amount) {
            return "<span class='text-danger text-bold'>共：<i class='fa fa-yen'></i> {$amount} 元</span>";
        });
        $grid->column('yzcprice', __('已支出'))->filter('range')->display(function ($value) {
            return "<i class='fa fa-yen'></i>{$value}元";
        })->totalRow(function ($amount) {
            return "<span class='text-danger text-bold'>共：<i class='fa fa-yen'></i> {$amount} 元</span>";
        });
        $grid->column('ysrprice', __('已收入'))->filter('range')->display(function ($value) {
            return "<i class='fa fa-yen'></i>{$value}元";
        })->totalRow(function ($amount) {
            return "<span class='text-danger text-bold'>共：<i class='fa fa-yen'></i> {$amount} 元</span>";
        });
        $grid->column('studOneBelongTo.gongsi', __('原分公司'));
        $grid->column('studTwoBelongTo.gongsi', __('转移分公司'))->display(function ($val) {
            return $val ? $val : '无';
        });
        $grid->column('status', '状态')->filter($this->extFilterStatus)->switch($this->extCaoStatus);
//        $grid->column('created_at', __('添加时间'))->sortable();
//        $grid->column('updated_at', __('更新时间'))->sortable();

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
        $show = new Show(Zstudio::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('bran_id_one', __('原分公司'));
        $show->field('bran_id_two', __('转移分公司'));
        $show->field('stud_fid', __('上级工作室'));
        $show->field('number', __('账号'));
        $show->field('title', __('工作室名称'));
        $show->field('address', __('工作室地址'));
        $show->field('phone', __('工作室电话'));
        $show->field('price', __('工作室余额'));
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
        $form = new Form(new Zstudio);
        $form->select('bran_id_one', __('原分公司'))->options($form->model()->branSele())->rules('required');
        $form->select('bran_id_two', __('转移分公司'))->options($form->model()->branSele());
        $form->select('stud_fid', __('上级工作室'))->options($form->model()->studSele());
        $form->text('number', __('账号'))->required()->creationRules(['required', "unique:zstudios"])
            ->updateRules(['required', "unique:zstudios,number,{{id}}"]);
        $form->password('password', __('密码'))->rules('required|min:3');
        $form->text('title', __('工作室名称'))->rules('required|min:3');
        $form->text('address', __('工作室地址'))->rules('required|min:3');
        $form->text('fuzeren', __('工作室负责人'))->rules('required|min:1');
        $form->mobile('phone', __('工作室电话'))->creationRules(['required', "unique:zstudios"])
            ->updateRules(['required', "unique:zstudios,phone,{{id}}"]);
        $form->currency('price', __('余额'))->symbol('￥')->readonly();
        $form->switch('status', '状态')->states($this->extCaoStatus)->default(1);
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
            if ($form->stud_fid && $form->stud_fid == $form->model()->id) {
                return back()->with(admin_warning('提示', '上级工作室不能是当前数据'));
            }
            //修改时密码处理
            if ($form->password != $form->model()->password) {
                $form->password = bcrypt($form->password); //密码处理
            }
        });
        $form->saved(function (Form $form) {
            $form->model()->studNumUpda();
            $form->model()->branNumUpda();
        });
        return $form;
    }
}
