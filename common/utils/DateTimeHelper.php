<?php
/**
 * Created by PhpStorm.
 * User: jhe
 * Date: 2018/1/7
 * Time: 0:03
 */

namespace common\utils;


class DateTimeHelper
{

    /**
     * 当前系统时间，精确到秒
     * @param string $timezone 时区
     * @return bool|string
     */
    public static function now($timezone = 'PRC')
    {
        date_default_timezone_set($timezone);
        return date('Y-m-d H:i:s', time());
    }
}