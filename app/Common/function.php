<?php
/****************************************************************************************************
 ****Title :函数库
 ****AuThor:siyuanjunr@qq.com
 *****************************************************************************************************/

/***********************************
 *  打印var_dump数据
 */
function ddx($str = "")
{
    print_r($str);
    exit;
}

/***********************************
 *  富士文本编辑器图片地址转换
 */
function contentfilter($content)
{
    if (!empty($content)) {
        $http_host = env('APP_URL');
        $content = str_replace('src="/', 'src="' . $http_host . '/', $content);
        $content = str_replace("src='/", "src='{$http_host}", $content);
    }
    return $content;
}

/***********************************
 *  验证手机号
 */
function chkmobile($mobilephone = "")
{
    if (preg_match('/^(13[0-9]|14[5|7]|15[0|1|2|3|5|6|7|8|9]|18[0|1|2|3|5|6|7|8|9]|5|6|7|8|9)\d{8}$/', $mobilephone)) {
        return true;
    } else {
        return false;
    }
}

/***********************************
 *  判断是否存在该自定义函数
 */
function isfun($funName)
{
    return (false !== function_exists($funName)) ? 'YES' : 'NO';
}

/***********************************
 * 查找字符串中是否存在某字符
 ***********************************/
function check_string_sub($string, $sub, $type = 1)
{
    $rule = 0;
    $returntext = "";
    if (!empty($sub)) {
        $strarray = explode(',', $string);
        if (is_array($strarray)) {
            foreach ($strarray as $key => $val) {
                if ($val == $sub) {
                    $rule = 1;
                }
            }
        }
        if ($rule == 1) {
            switch ($type) {
                case 1:
                    $returntext = "checked";
                    break;
                case 2:
                    $returntext = true;
                    break;
            }
        }
    }
    return $returntext;
}

/***********************************
 * layer 封装提示跳转
 ***********************************/
function alert($url, $info)
{
    echo '<script language="javascript" type="text/javascript"> alert("' . $info . '");window.location.href="' . $url . '";</script>';
}

/***********************************
 * Curl 请求 POST
 ***********************************/
function http_curl_request($url, $data = null, $isjson = 0)
{
    $curl = curl_init(); // 启动一个CURL会话
    curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 对认证证书来源的检查
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); // 从证书中检查SSL加密算法是否存在
//    curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
    if ($data != null) {
        if ($isjson == 0) {
            $data = http_build_query($data);
        }
        curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包
    }
    curl_setopt($curl, CURLOPT_TIMEOUT, 300); // 设置超时限制防止死循环
    curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
    $info = curl_exec($curl); // 执行操作
    if (curl_errno($curl)) {
        echo 'Errno:' . curl_getinfo($curl);//捕抓异常
        var_dump(curl_getinfo($curl));
    }
    return $info;
}

/***********************************
 * Curl 请求 GET
 ***********************************/
function http_curl_request_get($url)
{
    $ch = curl_init();
    //设置选项，包括URL
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//绕过ssl验证
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    //执行并获取HTML文档内容
    $output = curl_exec($ch);
    //释放curl句柄
    curl_close($ch);
    return $output;
}

/***********************************
 * 判断访问终端是否手机
 ***********************************/
function is_mobile_request()
{
    $_SERVER['ALL_HTTP'] = isset($_SERVER['ALL_HTTP']) ? $_SERVER['ALL_HTTP'] : '';
    $mobile_browser = '0';
    if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|iphone|ipad|ipod|android|xoom)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) $mobile_browser++;
    if ((isset($_SERVER['HTTP_ACCEPT'])) and (strpos(strtolower($_SERVER['HTTP_ACCEPT']), 'application/vnd.wap.xhtml+xml') !== false)) $mobile_browser++;
    if (isset($_SERVER['HTTP_X_WAP_PROFILE'])) $mobile_browser++;
    if (isset($_SERVER['HTTP_PROFILE'])) $mobile_browser++;
    $mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
    $mobile_agents = array('w3c ', 'acs-', 'alav', 'alca', 'amoi', 'audi', 'avan', 'benq', 'bird', 'blac', 'blaz', 'brew', 'cell', 'cldc', 'cmd-', 'dang', 'doco', 'eric', 'hipt', 'inno', 'ipaq', 'java', 'jigs', 'kddi', 'keji', 'leno', 'lg-c', 'lg-d', 'lg-g', 'lge-', 'maui', 'maxo', 'midp', 'mits', 'mmef', 'mobi', 'mot-', 'moto', 'mwbp', 'nec-', 'newt', 'noki', 'oper', 'palm', 'pana', 'pant', 'phil', 'play', 'port', 'prox', 'qwap', 'sage', 'sams', 'sany', 'sch-', 'sec-', 'send', 'seri', 'sgh-', 'shar', 'sie-', 'siem', 'smal', 'smar', 'sony', 'sph-', 'symb', 't-mo', 'teli', 'tim-', 'tosh', 'tsm-', 'upg1', 'upsi', 'vk-v', 'voda', 'wap-', 'wapa', 'wapi', 'wapp', 'wapr', 'webc', 'winw', 'winw', 'xda', 'xda-');
    if (in_array($mobile_ua, $mobile_agents)) $mobile_browser++;
    if (strpos(strtolower($_SERVER['ALL_HTTP']), 'operamini') !== false) $mobile_browser++;   // Pre-final check to reset everything if the user is on Windows
    if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'windows') !== false) $mobile_browser = 0;    // But WP7 is also Windows, with a slightly different characteristic
    if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'windows phone') !== false) $mobile_browser++;
    if ($mobile_browser > 0) return true;
    else   return false;
}

/***********************************
 * PHP stdClass Object转array
 ***********************************/
function object_array($array)
{
    if (is_object($array)) {
        $array = (array)$array;
    }
    if (is_array($array)) {
        foreach ($array as $key => $value) {
            $array[$key] = object_array($value);
        }
    }
    return $array;
}

/***********************************
 * PHP stdClass array转Object
 ***********************************/
function arrayToObject($arr)
{
    if (is_array($arr)) {
        return (object)array_map(__FUNCTION__, $arr);
    } else {
        return $arr;
    }
}

/***********************************
 *  用上下文信息替换记录信息中的占位符
 ***********************************/
function interpolate($message, array $context = array())
{
    // 构建一个花括号包含的键名的替换数组
    $replace = array();
    foreach ($context as $key => $val) {
        $replace['{' . $key . '}'] = $val;
    }
    // 替换记录信息中的占位符，最后返回修改后的记录信息。
    return strtr($message, $replace);
}

/***********************************
 * 作者： 解析html标签
 ***********************************/
function htmlcontent($content)
{
    $tmp_content = stripslashes(htmlspecialchars_decode(trim($content)));
    return $tmp_content;
}

/**
 * 直接上传图片
 * */
function uploads_action_simple($filename, $filefieid = 'file')
{
    $config = array(
        "pathFormat" => "/uploads/{$filename}/{time}{rand:6}",
        "maxSize" => "838860800",
        "allowFiles" => array('.doc', '.docx', '.xls', '.xlsx', '.ppt', '.txt', '.zip', '.rar', '.pdf', '.bz2', '.gif', '.jpg', '.jpeg', '.png', '.bmp', '.swf', '.flv', '.mp3', '.mp4')
    );
    /* 生成上传实例对象并完成上传 */
    $up = new \App\Common\lib\Uploader($filefieid, $config);
    return $up->getFileInfo();
}

/***********************************
 * 过滤文件后缀
 ***********************************/
function filter_suffixes($str)
{
    $str = str_replace(".html", "", $str);
    $str = str_replace(".htm", "", $str);
    $str = str_replace(".php", "", $str);
    $str = str_replace(".asp", "", $str);
    $str = str_replace(".aspx", "", $str);
    $str = str_replace(".js", "", $str);
    $str = str_replace(".css", "", $str);
    return $str;
}

/******************************************
 * 订单流水号
 *******************************************/
function get_order_sn()
{
    $yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
    $orderSn = $yCode[intval(date('Y')) - 2011] . strtoupper(dechex(date('m'))) . date('d') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf('%02d', rand(0, 99));
    return $orderSn;
}

/******************************************
 * 时间戳转换为多少分钟（天、小时）
 *******************************************/
function get_last_time($time)
{
    $time = intval($time);
    $todayLast = strtotime(date('Y-m-d 23:59:59'));
    $agoTimeTrue = time() - $time;
    $agoTime = $todayLast - $time;
    $agoDay = floor($agoTime / 86400);
    $formathi = date('H:i', $time);
    if ($agoTimeTrue > 0) {
        if ($agoTimeTrue < 60) {
            $result = '刚刚 ' . $formathi;
        } elseif ($agoTimeTrue < 3600) {
            $result = '约 ' . (ceil($agoTimeTrue / 60)) . '分钟前';
        } elseif ($agoTimeTrue < 3600 * 12) {
            $result = $formathi . ' 约' . (ceil($agoTimeTrue / 3600)) . '小时前';
        } elseif ($agoDay == 1) {
            $result = '昨天 ' . $formathi;
        } elseif ($agoDay == 2) {
            $result = '前天 ' . $formathi;
        } else {
            $format = date('Y') != date('Y', $time) ? "Y-m-d" : "m-d";
            $result = date($format, $time);
        }
    } else {
        $format = date('Y') != date('Y', $time) ? "Y-m-d H:i" : "m-d H:i";
        $result = date($format, $time);
    }
    return $result;
}

/******************************************
 * 将一个数组分割成多个数组 array_chunk(array,size,preserve_key)
 *******************************************/
function getd($data, $from, $to)
{
    $arr = [];
    foreach ($data as $key => $val) {
        //从 form开始 to结束
        if ($key >= $from && $key <= $to) {
            $arr[] = $val;
        }
    }
    return $arr;
}

function array_chunk_pull($data, $pagesize = 4)
{
    $total = count($data);
    if ($total <= 0) {
        return [];
    }
    $pagenum = ceil($total / $pagesize);
    $arr = [];
    for ($i = 1; $i <= $pagenum; $i++) {
        $from = ($i - 1) * $pagesize;
        $to = $pagesize * $i - 1;
        $arr[] = getd($data, $from, $to);
    }
    return $arr;
}

/**
 * 生成用户邀请码
 */
function gen_invite_code()
{
    $chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $res = "";
    while (true) {
        for ($i = 0; $i < 5; $i++) {
            $res .= $chars[mt_rand(0, strlen($chars) - 1)];
        }
        $user = \App\Http\Model\Zusernumber::where('invite_code', $res)->first();
        if (!$user) {
            break;
        }
    }
    return $res;
}

/**
 * 生成Token秘值
 */
function gtk($str = 0, $s = 16)
{
    return mb_substr(md5(config('hash.webToken') . get_order_sn() . $str), 0, $s);
}

/**
 * 简化中文验证字符
 */
function gkCjh($str)
{
    return mb_substr(md5(base64_encode($str)), 0, 16);
}

/**
 * 距离单位计算
 */
function distceJh($dce)
{
    if ($dce > 1000) {
        $dce = floor($dce / 1000) . 'km';
    } else {
        $dce = '<' . '1km';
    }
    return $dce;
}

/**
 * XML转换数组
 */
function xml_parser($str)
{
    $str = str_replace('<![CDATA[', '', $str);
    $str = str_replace(']]>', '', $str);
    $xml_parser = xml_parser_create();
    if (!xml_parse($xml_parser, $str, true)) {
        xml_parser_free($xml_parser);
    } else {
        return (json_decode(json_encode(simplexml_load_string($str)), true));
    }
}

/**
 * @title  二维数组根据某值 排序
 * @param  [type] $arr  [数组]
 * @param  [type] $keys [键名]
 * @param  string $type [排序类型]
 */
function array_sort_key($arr, $keys, $type = 'asc')
{
    $keysvalue = array();
    $new_array = array();

    foreach ($arr as $k => $v) {
        $keysvalue[$k] = $v[$keys];
    }

    if ($type == 'asc') {
        asort($keysvalue);
    } else {
        arsort($keysvalue);
    }
    reset($keysvalue);

    foreach ($keysvalue as $k => $v) {
        $new_array[$k] = $arr[$k];
    }

    return $new_array;
}

/**
 * 验证身份证号 [110120200612105811] 存在异常
 *
 * @param $idcard
 * @return bool
 */
function idcardCheck($idcard)
{
    if (strlen($idcard) == 18 || strlen($idcard) == 15) {
        return true;
    } else {
        return false;
    }
//    if (strlen($idcard) != 15) {
//        return false;
//    }
//    $idcard_base = substr($idcard, 0, 17);
//    if (_verifyNumber($idcard_base) != strtoupper(substr($idcard, 17, 1))) {
//        return false;
//    } else {
//        return true;
//    }
}

/**
 * 根据身份证号前17位计算第18位
 *
 * @param $idcard_base
 * @return bool
 */
function _verifyNumber($idcard_base)
{
    if (strlen($idcard_base) != 17) {
        return false;
    }
    $factor = array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2); //debug 加权因子
    $verify_number_list = array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2'); //debug 校验码对应值
    $checksum = 0;
    for ($i = 0; $i < strlen($idcard_base); $i++) {
        $checksum += substr($idcard_base, $i, 1) * $factor[$i];
    }
    $mod = $checksum % 11;
    $verify_number = $verify_number_list[$mod];
    return $verify_number;
}

// 账户余额去向类型
function extPriceLogType($status = "")
{
    $array = [1 => '收入', 2 => '支出', 3 => '驳回'];
    if($status != "") {
        return $array[$status];
    } else {
        return $array;
    }
}