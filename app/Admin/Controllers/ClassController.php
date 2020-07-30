<?php

namespace App\Admin\Controllers;

use App\Helpers\ConfigTrait;
use App\Http\Model\Zclasse;
use App\Http\Model\Zedu;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use http\Env\Request;

class ClassController extends AdminController
{
    use ConfigTrait;

    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '课时管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Zclasse);
        $grid->disableExport();
        $grid->disableRowSelector();
        $grid->filter(function ($filter) {
            $filter->like('title', '标题');
            $filter->equal('edu_id', '所属课程')->select(Zedu::eduSele());
            $filter->equal('status', '状态')->radio($this->extFilterStatus);
        });

        $grid->model()->orderBy("id", "desc");
        $grid->column('id', __('Id'));
        $grid->column('eduBelongsTo.title', __('所属课程'));
        $grid->column('title', __('标题'))->filter('like')->editable();
        $grid->column('video', __('视频'));
        $grid->column('status', '状态')->switch($this->extCaoStatus);
        $grid->column('created_at', __('添加时间'));

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
        $show = new Show(Zclasse::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('edu_id', __('Edu id'));
        $show->field('title', __('Title'));
        $show->field('video', __('Video'));
        $show->field('status', __('Status'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form($id = 0)
    {
        $form = new Form(new Zclasse);
        $data = $form->model()->find($id);
        $form->select('edu_id', __('所属课程'))->options(Zedu::eduSele())->rules('required');
        $form->text('title', __('标题'))->rules('required|min:3');
        $form->largefile('video', __('文件'));
        if($data) {
            $form->html('<a href="'.route('links.largefile', ['url' => $data->video]).'" target="_blank" class="btn btn-primary btn-sm">查看文件</a>');
        }
//        $form->file('video', __('视频文件'))->rules('required');
        $form->switch('status', '状态')->states($this->extCaoStatus)->default(1);

        return $form;
    }
}
