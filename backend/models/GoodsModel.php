<?php
namespace backend\models;

use Yii;
use common\entities\Goods;


/**
 * Class GoodsModel
 * @package backend\models
 */
class GoodsModel extends ModelBase
{

    public $id;
    public $flight_station;
    public $freight_rates_code;
    public $product_name;
    public $created_on;
    public $created_by;
    public $modified_on;
    public $modified_by;

    private static $_entity; //实体单例对象
    private $_one;

    public function __construct($id = null, $config = [])
    {
        $this->id = $id;
        parent::__construct($config);
    }

    public function init()
    {
        if (!(self::$_entity instanceof Goods)) {
            self::$_entity = new Goods;
            self::$_entity->loadDefaultValues();
        }
        if ($this->isNewRecord()) {
            $this->_one = self::$_entity;
        } else {
            $this->_one = $this->getOne();
            if (!$this->_one) {
                throw new \InvalidArgumentException("货物种类不存在");
            }
        }
        $this->setAttributes($this->_one->getAttributes(), false);
    }

    public function getOne()
    {
        return self::$_entity->findOne(['id' => $this->id]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['id', 'string'],

            ['product_name', 'trim'],
            ['product_name', 'required'],
            ['product_name', 'validateUnique', 'message' => '品名已经存在'],
            ['product_name', 'string', 'min' => 2, 'max' => 100],

            [['flight_station', 'freight_rates_code'], 'string', 'min' => 2, 'max' => 100],

            [['created_on', 'modified_on', 'created_by', 'modified_by'], 'string'],

        ];
    }

    public function delete()
    {
        return $this->_one->delete();
    }

    public function save()
    {
        if (!$this->validate()) {
            throw new \InvalidArgumentException($this->errMsg());
        }
        $this->_one->setAttributes($this->attributes, false);
        if ($this->_one->save()) {
            $this->setAttributes($this->_one->attributes, false);
            self::$_entity = null;
            return true;
        }
        return false;
    }

    /**
     * 验证
     * @param $attribute
     * @return bool
     */
    public function validateUnique($attribute)
    {
        switch ($attribute) {
            case 'product_name' :
                $exists = self::$_entity->find()
                    ->where(['product_name' => $this->product_name])
                    ->andFilterWhere(['<>', 'id', $this->id])
                    ->exists();
                if ($exists) {
                    $this->addError($attribute, '品名已经存在');
                    return false;
                }
                break;
        }
    }

}
