<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CkeditorUploadController extends Controller
{
    public function uploadImage(Request $request)
    {
        $CKEditorFuncNum = $request->get('CKEditorFuncNum');
        $responseType = $request->get('responseType');
        $result = uploads_action_simple('ckeditor', 'upload');
        if($result['state'] == "SUCCESS") {
            $file_url = $result['url'];
            if ($responseType == "json") {
                $arr = array(
                    'uploaded' => 1,
                    'fileName' => 'filename',
                    'url' => $file_url
                );
                return json_encode($arr);
            } else {
                return "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction(" . $CKEditorFuncNum . ",'" . $file_url . "')</script>";
            }
        } else {
            return json_encode($result);
        }
//        return '<script>window.parent.CKEDITOR.tools.callFunction('.$funcNum.', "'.$url.'", "'.$message.'")</script>'
    }

}
