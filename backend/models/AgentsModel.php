<?php
namespace backend\models;

use Yii;
use common\entities\Agents;


/**
 * Class AgentsModel
 * @package backend\models
 */
class AgentsModel extends ModelBase
{

    public $id;
    public $name;
    public $simple_code;
    public $start_station;
    public $financial_code;
    public $manager;
    public $manager_phone;
    public $query;
    public $query_phone;
    public $add_goods;
    public $add_goods_phone;
    public $dispatch;
    public $dispatch_fax;
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
        if (!(self::$_entity instanceof Agents)) {
            self::$_entity = new Agents;
            self::$_entity->loadDefaultValues();
        }
        if ($this->isNewRecord()) {
            $this->_one = self::$_entity;
        } else {
            $this->_one = $this->getOne();
            if (!$this->_one) {
                throw new \InvalidArgumentException("代理人记录不存在");
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

            ['name', 'trim'],
            ['name', 'required'],
            ['name', 'validateUnique', 'message' => '代理人名称已经存在'],
            ['name', 'string', 'min' => 2, 'max' => 100],

            ['simple_code', 'trim'],
            ['simple_code', 'required'],
            ['simple_code', 'validateUnique', 'message' => '简码已经存在'],
            ['simple_code', 'string', 'min' => 2, 'max' => 10],

            ['start_station', 'trim'],
            ['start_station', 'required'],
            ['start_station', 'string', 'min' => 2, 'max' => 50],

            ['financial_code', 'trim'],
            ['financial_code', 'required'],
            ['financial_code', 'validateUnique', 'message' => '财务结算代码已经存在'],
            ['financial_code', 'string', 'min' => 2, 'max' => 50],

            [['manager', 'manager_phone', 'query', 'query_phone', 'add_goods', 'add_goods_phone', 'dispatch', 'dispatch_fax'], 'string', 'min' => 2, 'max' => 200],

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
            case 'name' :
                $exists = self::$_entity->find()
                    ->where(['name' => $this->name])
                    ->andFilterWhere(['<>', 'id', $this->id])
                    ->exists();
                if ($exists) {
                    $this->addError($attribute, '代理人名称已经存在');
                    return false;
                }
                break;
            case 'simple_code' :
                $exists = self::$_entity->find()
                    ->where(['simple_code' => $this->simple_code])
                    ->andFilterWhere(['<>', 'id', $this->id])
                    ->exists();
                if ($exists) {
                    $this->addError($attribute, '简码已经存在');
                    return false;
                }
                break;
            case 'financial_code' :
                $exists = self::$_entity->find()
                    ->where(['financial_code' => $this->financial_code])
                    ->andFilterWhere(['<>', 'id', $this->id])
                    ->exists();
                if ($exists) {
                    $this->addError($attribute, '财务结算代码已经存在');
                    return false;
                }
                break;
        }
    }

}
