<?php
/*
 * 文件访问路径控制器 【未使用】
 * */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileWebPathController extends Controller
{
    public function largefile($file_name)
    {
        $file_name = str_replace("_", "/", $file_name);
        return response()->file(storage_path() . "/app/aetherupload/" . $file_name);
    }
}