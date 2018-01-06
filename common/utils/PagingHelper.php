<?php
/**
 * Created by PhpStorm.
 * User: jhe
 * Date: 2018/1/6
 * Time: 22:38
 */

namespace common\utils;


class PagingHelper
{
    public static function getSkip($page, $pageSize)
    {
        return $pageSize * ($page - 1);
    }
}