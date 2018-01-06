<?php
/**
 * Created by PhpStorm.
 * User: jhe
 * Date: 2018/1/6
 * Time: 21:04
 */

namespace common\entities;


use common\utils\DateTimeHelper;
use yii\db\ActiveRecord;
use common\utils\StringHelper;

class EntityBase extends ActiveRecord
{

    public function beforeSave($insert)
    {
        if (empty($this->id)) {
            $this->id = StringHelper::uuid();
        }
        if ($this->getIsNewRecord()) {
            $this->created_on = DateTimeHelper::now();
            if (empty($this->created_by)) {
                $this->created_by = \Yii::$app->user->identity->getId();
            }
        } else {
            $this->modified_on = DateTimeHelper::now();
            if (empty($this->modified_by)) {
                $this->modified_by = \Yii::$app->user->identity->getId();
            }
        }

        return parent::beforeSave($insert);
    }

}