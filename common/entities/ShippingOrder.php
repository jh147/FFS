<?php
/**
 * Created by PhpStorm.
 * User: jhe
 * Date: 2018/1/6
 * Time: 21:04
 */

namespace common\entities;


class ShippingOrder extends EntityBase
{
    public static function tableName()
    {
        return 'shipping_order';
    }
}