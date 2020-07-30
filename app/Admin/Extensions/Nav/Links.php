<?php

namespace App\Admin\Extensions\Nav;

use App\Helpers\AdminUserTrait;
use App\Http\Model\Zpayorder;
use App\Http\Model\Zstud_withdraw;
use App\Http\Model\Zuser_withdraw;

class Links
{
    use AdminUserTrait;

    public function __toString()
    {
        $z_user_withdraws = route('z_user_withdraws.index', ['status' => 1]);
        $z_stud_withdraws = route('z_stud_withdraws.index', ['status' => 1]);
        $z_payorders = route('z_payorders.index', ['status' => 1, 'fee' => 5000]);
        $user_tx_count = Zuser_withdraw::where('status', 1)->count();
        $stud_tx_count = Zstud_withdraw::where('status', 1)->count();
        $order_tx_count = Zpayorder::where('status', 1)->where('fee', '>', 5000)->count();
        $z_count = $user_tx_count + $stud_tx_count + $order_tx_count;

        // 非总后台管理员不显示通知
        if($this->users()->isRole('branchoffices') || $this->users()->isRole('studios')) {
            return '';
        }

        return <<<HTML
<li class="dropdown notifications-menu">
<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
  <i class="fa fa-bell-o"></i>
  <span class="label label-warning">{$z_count}</span>
</a>
<ul class="dropdown-menu">
  <li class="header">待处理消息</li>
  <li>
    <!-- inner menu: contains the actual data -->
    <ul class="menu">
      <li>
        <a href="{$z_user_withdraws}">
          <i class="fa fa-warning text-yellow"></i> {$user_tx_count} 条待处理用户提现消息
        </a>
      </li>
      <li>
        <a href="{$z_payorders}">
          <i class="fa fa-warning text-yellow"></i> {$order_tx_count} 条待处理用户未支付订单消息
        </a>
      </li>
      <li>
        <a href="{$z_stud_withdraws}">
          <i class="fa fa-warning text-yellow"></i> {$stud_tx_count} 条待处理工作室提现消息
        </a>
      </li>
    </ul>
  </li>
  <!--<li class="footer"><a href="#">View all</a></li>-->
</ul>
</li>
HTML;
    }
}