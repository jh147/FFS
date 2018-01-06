<?php
/**
 * Created by PhpStorm.
 * User: jhe
 * Date: 2018/1/1
 * Time: 23:56
 */

namespace backend\models;


use yii\base\Model;

class ModelBase extends Model
{

    public function __construct(array $config)
    {
        parent::__construct($config);
    }

    public function isNewRecord()
    {
        return empty($this->id);
    }

    public function errMsg()
    {
        $errors = $this->getFirstErrors();
        if (!empty($errors)) {
            $errMsg = '';
            foreach ($errors as $error) {
                $errMsg .= $error . ' <br />' . PHP_EOL;
            }
            return trim(trim($errMsg, PHP_EOL), ' <br />');
        }
        return null;
    }

}