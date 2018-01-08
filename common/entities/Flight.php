<?php
/**
 * Created by PhpStorm.
 * User: jhe
 * Date: 2018/1/6
 * Time: 21:04
 */

namespace common\entities;


class Flight extends EntityBase
{
    public static function tableName()
    {
        return 'flight';
    }
}