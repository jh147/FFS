<?php
namespace backend\models;

use Yii;
use common\entities\ShippingOrder;


/**
 * Class PgOrderModel
 * @package backend\models
 */
class PgOrderModel extends ModelBase
{

    public $id;
    public $type;
    public $flight_date;
    public $prefix;
    public $order_num;
    public $flight_num;
    public $pg_quantity;
    public $pg_weight;
    public $pg_freight_rates;
    public $pg_loss_fee;
    public $pg_reason;
    public $pg_processing_method;
    public $pg_remark;
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
                throw new \InvalidArgumentException("拉货单不存在");
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
            ['order_num', 'validateUnique', 'message' => '拉货单号已经存在'],

            [['type', 'flight_date', 'prefix', 'order_num', 'flight_num', 'pg_reason', 'pg_processing_method', 'pg_remark'], 'string', 'min' => 1, 'max' => 255],
            [['pg_freight_rates', 'pg_loss_fee'], 'double'],
            [[ 'pg_quantity', 'pg_weight'], 'integer'],
            ['type', 'default', 'value' => 'pg'],

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
                    ->where(['order_num' => $this->order_num, 'type' => 'common'])
                    ->andFilterWhere(['<>', 'id', $this->id])
                    ->exists();
                if ($exists) {
                    $this->addError($attribute, '拉货单号已经存在');
                    return false;
                }
                break;
        }
    }
}
