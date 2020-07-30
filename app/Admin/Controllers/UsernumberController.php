<?php

namespace App\Admin\Controllers;

use App\Admin\Extensions\UserExporter;
use App\Exports\UsersExport;
use App\Helpers\AdminUserTrait;
use App\Http\Model\Zstudio;
use App\Http\Model\Zusernumber;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use http\Env\Request;
use Illuminate\Support\MessageBag;
use Maatwebsite\Excel\Facades\Excel;

class UsernumberController extends AdminController
{
    use AdminUserTrait;

    private $model;
    private $zstudio;

    public function __construct()
    {
        $this->model = new Zusernumber;
        $this->zstudio = new Zstudio;
    }

    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '会员管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid($this->model);
//        $grid->disableExport();
//        $grid->disableRowSelector();
        $grid->exporter(new UserExporter());
        $grid->disableCreateButton();

        if ($this->studUser()) {
            $grid->disableActions();
        }
        $grid->actions(function ($actions) {
            // 去掉删除
            $actions->disableDelete();
            $actions->disableView();
        });
        $grid->tools(function ($tools) {
            $tools->batch(function ($batch) {
                $batch->disableDelete();
            });
        });

        $grid->filter(function ($filter) {
            // 设置created_at字段的范围查询
            $filter->column(1/2, function ($filter) {
                $filter->like('relname', '姓名');
                $filter->like('phonenumber', '手机号');
                $filter->like('idcard', '身份证号');
                $filter->like('childname', '孩子姓名');
                $filter->like('childidcard', '孩子身份证');
            });
            $filter->column(1/2, function ($filter) {
                $filter->between('created_at', '注册时间')->date();
                // 原始工作室 服务工作室查询
                $filter->where(function ($query) {
                    $query->where('stud_id', $this->input)->orWhere('ysstud_id', $this->input);
                }, '原始/服务工作室')->select($this->zstudio->studSele());
//                $filter->equal('stud_id', '原始/服务工作室')->select($this->zstudio->studSele());
                $filter->equal('uid_onelevel', '助教老师')->select($this->model->userSele());
            });
        });

        if ($this->studUser()) {
            $grid->model()->where('ysstud_id', $this->studUser()->id);
        }
        if ($branUser = $this->branUser()) {
            $grid->model()->WhereIn('ysstud_id', $branUser->stud_arr);
        }

        $grid->model()->orderBy("id", "desc");
        $grid->column('id', __('Id'))->sortable();
        $grid->column('studioFirstBelong.title', __('原始工作室'))->display(function ($val) {
            return $val ? $val : '无';
        });
        $grid->column('studioBelong.title', __('服务工作室'))->display(function ($val) {
            return $val ? "{$val} [" . $this->studioBelong->number . "]" : '无';
        });
        $grid->column('phonenumber', __('手机号'));
        $grid->column('userWxHasOne.avatarurl', __('头像'))->gallery(['width' => 30, 'zooming' => true]);
        $grid->column('relname', __('姓名'));
        $grid->column('idcard', __('身份证号'));
        $grid->column('childname', __('孩子姓名'));
        $grid->column('childidcard', __('孩子身份证'));
        $grid->column('price', __('余额'))->display(function ($value) {
            return "<i class='fa fa-yen'></i>{$value}元";
        })->totalRow(function ($amount) {
            return "<span class='text-danger text-bold'>共：<i class='fa fa-yen'></i> {$amount} 元</span>";
        })->modal('金额明细', function ($model) {
            $comments = $model->priceLogHasMany()->take(100)->get()->map(function ($comment) {
                $comment->type = extPriceLogType($comment->type);
                return $comment->only(['id', 'price', 'info', 'yueprice', 'type', 'created_at']);
            });
            return new \Encore\Admin\Widgets\Table(['ID', '金额', '原因', '余额', '类型', '时间'], $comments->toArray());
        });
//        $grid->column('price', __('余额'))->display(function ($value) {
//            return "<i class='fa fa-yen'></i>{$value}元";
//        })->totalRow(function ($amount) {
//            return "<span class='text-danger text-bold'>共：<i class='fa fa-yen'></i> {$amount} 元</span>";
//        });
        $grid->column('invite_code', __('邀请码'));
        $grid->column('usernum', __('会员数量'));
        $grid->column('userOneBelong.id', __('助教老师'))
            ->display(function ($val) {
                if ($this->userOneBelong) {
                    $relname = $this->userOneBelong->relname;
                    if ($relname) {
                        $val .= " <span class='label label-danger'> " . $relname . "</span>";
                    }
                }
                return $val ? $val : '无';
            });
//        $grid->column('userTwoBelong.relname', __('所属二级会员'))
//            ->display(function ($val) {
//                return $val ? $val . " <span class='label label-danger'> ID:" . $this->userTwoBelong->id . "</span>" : '无';
//            });
        $grid->column('level', __('会员级别'))->using($this->model->ext_level)->label([
            0 => 'default',
            1 => 'default',
            2 => 'warning',
            3 => 'info',
        ]);
        $grid->column('recent_createtime', __('最近登录时间'))->sortable();
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
        $show = new Show($this->model->findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('stud_id', __('所属工作室'));
        $show->field('phonenumber', __('手机号'));
        $show->field('relname', __('姓名'));
        $show->field('idcard', __('身份证号'));
        $show->field('childname', __('孩子姓名'));
        $show->field('childidcard', __('孩子身份证'));
        $show->field('price', __('余额'));
        $show->field('invite_code', __('邀请码'));
        $show->field('uid_onelevel', __('所属上级会员'));
        $show->field('uid_twolevel', __('所属二级会员'));
        $show->field('level', __('会员级别'));
        $show->field('openid', __('微信openid'));
        $show->field('newsession_id', __('登录秘钥'));
        $show->field('reg_createtime', __('注册时间'));
        $show->field('recent_createtime', __('最近登录时间'));
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
        $form = new Form($this->model);

        $form->tools(function (Form\Tools $tools) {
            $tools->disableView();
            $tools->disableDelete();
        });

        $form->display('id', 'ID');
        $form->select('stud_id', __('服务工作室'))->options($this->zstudio->studSele())->rules('required');
        if(!$this->branUser()) {
            $form->select('uid_onelevel', __('助教老师'))->options($this->model->userSele());
            $form->radio('level', __('会员级别'))->options($this->model->ext_level)->default(1);
        }
        $form->mobile('phonenumber', __('手机号'))->required();
//            $form->password('password', __('密码'));
        $form->text('relname', __('姓名'));
        $form->text('idcard', __('身份证号'));
        $form->text('childname', __('孩子姓名'));
        $form->text('childidcard', __('孩子身份证'));
        $form->currency('price', __('余额'))->symbol('￥')->readonly();
        $form->display('reg_createtime', __('注册时间'));
        $form->display('recent_createtime', __('最近登录时间'));
        $form->hidden('invite_code');
        $form->hidden('usernum');
        $form->hidden('uid_twolevel');

        //保存前回调
        $form->saving(function (Form $form) {
            $form->uid_twolevel = 0;
            if (!$form->stud_id) {
                return back()->with(admin_warning('提示', '对不起，请指定工作室'));
            }
            if ($form->uid_onelevel) {
                // 新上级
                $newfid = $form->model()->find($form->uid_onelevel);
                $fsorts = $newfid->sorts;
                // 原上级
                $sorts = $form->model()->sorts;
                if ($sorts) {
                    if (strpos("{$fsorts}", "{$sorts}") !== false) {
                        return back()->with(admin_warning('提示', '对不起，当前会员不能移动至其子会员上'));
                    }
                }
                // 所属二级会员处理
                $usertwo = $newfid->userOneBelong;
                if ($usertwo) {
                    $form->uid_twolevel = $usertwo->id;
                }
            }
            //修改时密码处理
            if ($form->password != $form->model()->password) {
                $form->password = bcrypt($form->password); //密码处理
            }
            //邀请码
            if ($form->model()->invite_code == '') {
                $form->invite_code = gen_invite_code();
            }
        });
        $form->saved(function (Form $form) {
            $form->model()->createdPull();
        });
        return $form;
    }

    /**
     * 数据导出
     *
     * */
    public function export()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }
}
