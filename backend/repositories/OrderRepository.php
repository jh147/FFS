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
        $items = $sqlObj->select('prefix, order_num, flight_num, destination_station, flight_date, simple_code, quantity, actual_weight, (actual_weight - pg_weight) as real_weight, freight_rates_code, product_name, freight_rates, ((billing_weight-pg_weight)*freight_rates+fuel_fee) as real_freight_fee')
            ->orderBy(['created_on' => SORT_DESC])
            ->offset($skip)
            ->limit($limit)
            ->createCommand()
            ->queryAll();

        $total = $sqlObj
            ->count();
        return ['items' => $items, 'total' => $total];
    }

    /**
     * 获取销售对比数据 - 航班
     * @param $conditions
     * @param $totalDays
     * @return array
     */
    public function getSalesCompareByFlight($conditions, $totalDays)
    {
        $sqlObj = ShippingOrder::find()->where('1=1');
        $sqlObj = $this->handleConditions($sqlObj, $conditions);
        return $sqlObj->select('flight_num, sum(actual_weight - pg_weight) as real_weight, (sum(actual_weight - pg_weight)/:totalDays) as avg_weight,
        sum((billing_weight-pg_weight)*freight_rates+fuel_fee) as real_freight_fee, (sum((billing_weight-pg_weight)*freight_rates+fuel_fee)/:totalDays) as avg_freight_fee,
        sum((billing_weight-pg_weight)*freight_rates+fuel_fee) / sum(actual_weight - pg_weight) as avg_fee')
            ->orderBy('real_weight desc')
            ->groupBy('flight_num')
            ->createCommand()
            ->bindParam(':totalDays', $totalDays)
            ->queryAll();
    }

    /**
     * 获取销售对比数据 - 航线
     * @param $conditions
     * @param $totalDays
     * @return array
     */
    public function getSalesCompareByAirline($conditions, $totalDays)
    {
        $sqlObj = ShippingOrder::find()
            ->alias('o')
            ->innerJoin('flight as f', 'f.flight_num = o.flight_num')
            ->where('1=1');
        $sqlObj = $this->handleConditions($sqlObj, $conditions);
        return $sqlObj->select('f.air_line, sum(actual_weight - pg_weight) as real_weight, (sum(actual_weight - pg_weight)/:totalDays) as avg_weight,
        sum((billing_weight-pg_weight)*freight_rates+fuel_fee) as real_freight_fee, (sum((billing_weight-pg_weight)*freight_rates+fuel_fee)/:totalDays) as avg_freight_fee,
        sum((billing_weight-pg_weight)*freight_rates+fuel_fee) / sum(actual_weight - pg_weight) as avg_fee')
            ->orderBy('real_weight desc')
            ->groupBy('f.air_line')
            ->createCommand()
            ->bindParam(':totalDays', $totalDays)
            ->queryAll();
    }

    /**
     * 获取销售对比数据 - 代理人
     * @param $conditions
     * @param $totalDays
     * @return array
     */
    public function getSalesCompareByAgent($conditions, $totalDays)
    {
        $sqlObj = ShippingOrder::find()
            ->alias('o')
            ->innerJoin('agents as a', 'a.simple_code = o.simple_code')
            ->where('1=1');
        $sqlObj = $this->handleConditions($sqlObj, $conditions);
        return $sqlObj->select('a.name, sum(actual_weight - pg_weight) as real_weight, (sum(actual_weight - pg_weight)/:totalDays) as avg_weight,
        sum((billing_weight-pg_weight)*freight_rates+fuel_fee) as real_freight_fee, (sum((billing_weight-pg_weight)*freight_rates+fuel_fee)/:totalDays) as avg_freight_fee,
        sum((billing_weight-pg_weight)*freight_rates+fuel_fee) / sum(actual_weight - pg_weight) as avg_fee')
            ->orderBy('real_weight desc')
            ->groupBy('a.name')
            ->createCommand()
            ->bindParam(':totalDays', $totalDays)
            ->queryAll();
    }



    /**
     * 获取周期销售分析数据 - 航班
     * @param $conditions
     * @return array
     */
    public function getSalesStatisticsByFlight($conditions)
    {
        $sqlObj = ShippingOrder::find()->where('1=1');
        $sqlObj = $this->handleConditions($sqlObj, $conditions);
        return $sqlObj->select('flight_num as name, flight_date, sum(actual_weight - pg_weight) as real_weight')
            ->groupBy('flight_num, flight_date')
            ->createCommand()
            ->queryAll();
    }
    /**
     * 获取销售分析数据 - 航线
     * @param $conditions
     * @return array
     */
    public function getSalesStatisticsByAirline($conditions)
    {
        $sqlObj = ShippingOrder::find()
            ->alias('o')
            ->innerJoin('flight as f', 'f.flight_num = o.flight_num')
            ->where('1=1');
        $sqlObj = $this->handleConditions($sqlObj, $conditions);
        return $sqlObj->select('f.air_line as name, o.flight_date, sum(actual_weight - pg_weight) as real_weight')
            ->groupBy('f.air_line, o.flight_date')
            ->createCommand()
            ->queryAll();
    }

    /**
     * 获取销售分析数据 - 代理人
     * @param $conditions
     * @return array
     */
    public function getSalesStatisticsByAgent($conditions)
    {
        $sqlObj = ShippingOrder::find()
            ->alias('o')
            ->innerJoin('agents as a', 'a.simple_code = o.simple_code')
            ->where('1=1');
        $sqlObj = $this->handleConditions($sqlObj, $conditions);
        return $sqlObj->select('a.name, o.flight_date, sum(actual_weight - pg_weight) as real_weight')
            ->groupBy('a.name, o.flight_date')
            ->createCommand()
            ->queryAll();
    }

    /**
     * 获取货源分析列表
     * @param $conditions
     * @return array
     */
    public function getGoodsStatisticsList($conditions)
    {
        $sqlObj = ShippingOrder::find()->where('1=1');
        $sqlObj = $this->handleConditions($sqlObj, $conditions);
        return $sqlObj->select('flight_num, freight_rates_code, start_station, destination_station, sum(actual_weight - pg_weight) as sum_weight, sum((billing_weight-pg_weight)*freight_rates+fuel_fee) as real_freight_fee, avg((billing_weight-pg_weight)*freight_rates+fuel_fee) as avg_freight_fee')
            ->orderBy(['flight_num' => SORT_ASC])
            ->groupBy(['flight_num', 'freight_rates_code', 'destination_station'])
            ->createCommand()
            ->queryAll();
    }

    /**
     * 获取出货分析列表
     * @param $conditions
     * @param $groupBy
     * @return array
     */
    public function getShipmentStatisticsList($conditions, $groupBy)
    {
        $sqlObj = ShippingOrder::find()->where('1=1');
        $sqlObj = $this->handleConditions($sqlObj, $conditions);
        $items = $sqlObj->select('flight_date, flight_num, simple_code, freight_rates_code, start_station, destination_station, sum(quantity-pg_quantity) as sum_quantity, sum(actual_weight - pg_weight) as sum_weight, sum((billing_weight-pg_weight)*freight_rates+fuel_fee) as real_freight_fee, avg((billing_weight-pg_weight)*freight_rates+fuel_fee) as avg_freight_fee')
            ->orderBy(['flight_date' => SORT_ASC])
            ->groupBy($groupBy)
            ->createCommand()
            ->queryAll();

        return ['items' => $items, 'total' => 1];
    }
}