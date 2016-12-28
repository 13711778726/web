<?php
/**
 * 获取唯一字符串
 * @param $len 长度
 * @return string
 */
function getKeyString($len)
{
    $str = "";
    $strPol = "ABCDEFGHIJKLMNPQRSTUVWXYZ123456789";
    $max = strlen($strPol) - 1;
    for ($i = 0; $i < $len; $i++) {
        $str .= $strPol[rand(0, $max)];
    }
    return str_shuffle($str);
}
/**
 * 时间戳转换
 * @param unknown $time
 */
function timeGange($timeData){
    //当前时间
    $time = time();
    $con = $time-$timeData;
    $timeMode = array(
        '31536000'=>'年',
        '2592000'=>'月',
        '604800'=>'星期',
        '86400'=>'天',
        '3600'=>'小时',
        '60'=>'分钟',
        '1'=>'秒'
    );
    foreach ($timeMode as $k=>$v)    {
        if (0 !=$c=floor($con/(int)$k)) {
            return $c.$v.'前';
        }
    }
}