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
        if ($conditions['eq']) {
            foreach ($conditions['eq'] as $k => $v) {
                $sqlObj->andFilterWhere(['=', $k, $v]);
            }
        }
        if ($conditions['like']) {
            foreach ($conditions['like'] as $k => $v) {
                $sqlObj->andFilterWhere(['like', $k, $v]);
            }
        }
        if ($conditions['ge']) {
            foreach ($conditions['ge'] as $k => $v) {
                $sqlObj->andFilterWhere(['>=', $k, $v]);
            }
        }
        if ($conditions['le']) {
            foreach ($conditions['le'] as $k => $v) {
                $sqlObj->andFilterWhere(['<=', $k, $v]);
            }
        }
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
     * 获取列表
     * @param $skip
     * @param $limit
     * @param $conditions
     * @return array
     */
    public function getDailBusiness($skip, $limit, $conditions)
    {
        $sqlObj = ShippingOrder::find()->where('1=1');
        if ($conditions['eq']) {
            foreach ($conditions['eq'] as $k => $v) {
                $sqlObj->andFilterWhere(['=', $k, $v]);
            }
        }
        if ($conditions['like']) {
            foreach ($conditions['like'] as $k => $v) {
                $sqlObj->andFilterWhere(['like', $k, $v]);
            }
        }
        if ($conditions['ge']) {
            foreach ($conditions['ge'] as $k => $v) {
                $sqlObj->andFilterWhere(['>=', $k, $v]);
            }
        }
        if ($conditions['le']) {
            foreach ($conditions['le'] as $k => $v) {
                $sqlObj->andFilterWhere(['<=', $k, $v]);
            }
        }
        $items = $sqlObj->select('*')
            ->orderBy(['created_on' => SORT_DESC])
            ->offset($skip)
            ->limit($limit)
            ->groupBy('order_num')
            ->createCommand()
            ->queryAll();

        $total = $sqlObj
            ->groupBy('order_num')
            ->count();
        return ['items' => $items, 'total' => $total];
    }

}