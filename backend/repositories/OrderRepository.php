<?php
/**
 * Created by PhpStorm.
 * User: jhe
 * Date: 2018/1/6
 * Time: 21:42
 */

namespace backend\repositories;


use common\entities\ShippingOrder;

class OrderRepository extends RepositoryBase
{

    /**
     * 获取列表
     * @param $skip
     * @param $limit
     * @param $conditions
     * @return array
     */
    public function getList($skip, $limit, $conditions)
    {
        $sqlObj = ShippingOrder::find()->where('1=1');
        $sqlObj = $this->handleConditions($sqlObj, $conditions);
        $items = $sqlObj->orderBy(['created_on' => SORT_DESC])
            ->offset($skip)
            ->limit($limit)
            ->createCommand()
            ->queryAll();

        $total = $sqlObj->count();
        return ['items' => $items, 'total' => $total];
    }

    /**
     * 判断字段值是否唯一
     * @param $field
     * @param $val
     * @param $id
     * @return bool
     */
    public function isExists($field, $val, $id = null)
    {
        return ShippingOrder::find()
            ->where([$field => $val])
            ->andFilterWhere(['!=', 'id', $id])
            ->exists();
    }

    /**
     * 根据运单号获取记录
     * @param $orderNum
     * @return array|false
     */
    public function getByOrderNum($orderNum)
    {
        return ShippingOrder::find()
            ->where(['order_num' => $orderNum])
            ->createCommand()
            ->queryOne();
    }

    /**
     * 获取日常营业列表
     * @param $skip
     * @param $limit
     * @param $conditions
     * @return array
     */
    public function getDailBusiness($skip, $limit, $conditions)
    {
        $sqlObj = ShippingOrder::find()->where('1=1');
        $sqlObj = $this->handleConditions($sqlObj, $conditions);
        $items = $sqlObj->select('prefix, order_num, flight_num, destination_station, flight_date, simple_code, quantity, actual_weight, (actual_weight - pg_weight) as real_weight, freight_rates_code, product_name, freight_rates')
            ->orderBy(['created_on' => SORT_DESC])
            ->offset($skip)
            ->limit($limit)
            ->createCommand()
            ->queryAll();

        $total = $sqlObj
            ->count();
        return ['items' => $items, 'total' => $total];
    }

}