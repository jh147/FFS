<?php
/**
 * Created by PhpStorm.
 * User: jhe
 * Date: 2018/1/6
 * Time: 21:38
 */

namespace backend\repositories;


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
}