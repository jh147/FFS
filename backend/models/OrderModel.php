<?php
namespace backend\models;

use Yii;
use common\entities\ShippingOrder;


/**
 * Class OrderModel
 * @package backend\models
 */
class OrderModel extends ModelBase
{

    public $id;
    public $flight_date;
    public $prefix;
    public $order_num;
    public $start_station;
    public $stopover_station;
    public $destination_station;
    public $flight_num;
    public $simple_code;
    public $freight_rates_code;
    public $product_name;
    public $quantity;
    public $actual_weight;
    public $billing_weight;
    public $freight_rates;
    public $freight_fee;
    public $fuel_fee;
    public $freight_total_fee;
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
        if (!(self::$_entity instanceof ShippingOrder)) {
            self::$_entity = new ShippingOrder;
            self::$_entity->loadDefaultValues();
        }
        if ($this->isNewRecord()) {
            $this->_one = self::$_entity;
        } else {
            $this->_one = $this->getOne();
            if (!$this->_one) {
                throw new \InvalidArgumentException("运单不存在");
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

            ['order_num', 'trim'],
            ['order_num', 'required'],
            ['order_num', 'string', 'min' => 2, 'max' => 100],
            ['order_num', 'validateUnique', 'message' => '运单号已经存在'],

            [['flight_date', 'prefix', 'start_station', 'stopover_station', 'destination_station', 'flight_num', 'simple_code', 'freight_rates_code', 'product_name'], 'string', 'min' => 1, 'max' => 255],
            [['freight_rates', 'freight_fee', 'fuel_fee', 'freight_total_fee'], 'double'],
            [['quantity', 'actual_weight', 'billing_weight'], 'integer'],

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
            case 'order_num' :
                $exists = self::$_entity->find()
                    ->where(['order_num' => $this->order_num])
                    ->andFilterWhere(['<>', 'id', $this->id])
                    ->exists();
                if ($exists) {
                    $this->addError($attribute, '运单号已经存在');
                    return false;
                }
                break;
        }
    }

}
