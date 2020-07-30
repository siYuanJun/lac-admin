<?php
/******************************************
 ****AuThor:2039750417@qq.com
 ****Title :Map经纬度距离计算
 *******************************************/

namespace App\Helpers;

trait MapLocalDistance
{
	/**
	 * 腾讯地图-距离矩阵（多对多）
	 * 链接：https://lbs.qq.com/webservice_v1/guide-distancematrix.html
	 */
    public function MapDistanceJk($from, $to)
    {
        $parames = "key=".config('hashpass.qq_map_key')."&mode=driving&from={$from}&to={$to}";
        $url = "https://apis.map.qq.com/ws/distance/v1/?{$parames}";
        $result = json_decode(http_curl_request_get($url), true);
        // dd($result);
        return isset($result['result']['elements']) ? $result['result']['elements'] : [];
    }

    /**
     * 腾讯地图-地址解析(地址转坐标)
     * 链接：https://lbs.qq.com/webservice_v1/guide-geocoder.html
     */
    public function MapGeocoderJk($address)
    {
        $parames = "key=".config('hashpass.qq_map_key')."&address={$address}";
        $url = "https://apis.map.qq.com/ws/geocoder/v1/?{$parames}";
        $result = json_decode(http_curl_request_get($url), true);
        return isset($result['result']) ? $result['result'] : [];
    }
}