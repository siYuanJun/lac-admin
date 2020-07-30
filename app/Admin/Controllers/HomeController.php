<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Zcategory;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;

class HomeController extends Controller
{
    public function index(Content $content)
    {
        $data = Zcategory::find(9);
        return $content
            ->title('后台首页')
            ->description()
            ->view('admin.welcome', ['data' => $data]);
//            ->row(Dashboard::title())
//            ->row(function (Row $row) {

//                $row->column(4, function (Column $column) {
//                    $column->append(Dashboard::environment());
//                });
//
//                $row->column(4, function (Column $column) {
//                    $column->append(Dashboard::extensions());
//                });
//
//                $row->column(4, function (Column $column) {
//                    $column->append(Dashboard::dependencies());
//                });
//            });
    }
}
