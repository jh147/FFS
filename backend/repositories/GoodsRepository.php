<?php
/**
 * Created by PhpStorm.
 * User: jhe
 * Date: 2018/1/6
 * Time: 21:42
 */

namespace backend\repositories;


use common\entities\Goods;

class GoodsRepository extends RepositoryBase
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
        $sqlObj = Goods::find()->where('1=1');
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
        return Goods::find()
            ->where([$field => $val])
            ->andFilterWhere(['!=', 'id', $id])
            ->exists();
    }

}