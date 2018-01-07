<?php
/**
 * Created by PhpStorm.
 * User: jhe
 * Date: 2018/1/6
 * Time: 21:38
 */

namespace backend\repositories;


use common\utils\StringHelper;

abstract class RepositoryBase
{
    /**
     * @return \yii\db\Connection
     */
    public function getDb()
    {
        return \Yii::$app->getDb();
    }

    /**
     * 获取
     * @param $entity
     * @param $id
     * @return array|null|\yii\db\ActiveRecord
     */
    public function getOne($entity, $id)
    {
        return $entity->find()
            ->where(['id' => $id])
            ->one();
    }

    /**
     * 批量插入
     * @param $table
     * @param $cols
     * @param $rows
     * @return $this|null
     */
    public function batchInsert($table, $cols, $rows)
    {
        if (empty($table) || empty($cols) || empty($rows)) {
            return null;
        }
        if (!in_array('id', $cols)) {
            array_push($cols, 'id');
            $rows = array_map(function ($val) {
                $id = StringHelper::uuid();
                array_push($val, $id);
                return $val;
            }, $rows);
        }
        return $this->getDb()->createCommand()->batchInsert($table, $cols, $rows)->execute();
    }
}