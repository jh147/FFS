<?php
namespace backend\models;

use Yii;
use common\entities\Flight;


/**
 * Class FlightModel
 * @package backend\models
 */
class FlightModel extends ModelBase
{

    public $id;
    public $flight_num;
    public $flight_model;
    public $air_line;
    public $schedule;
    public $start_station;
    public $take_off_1;
    public $land_1;
    public $stopover_station_1;
    public $take_off_2;
    public $land_2;
    public $destination_station;
    public $start_date;
    public $end_date;
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
        if (!(self::$_entity instanceof Flight)) {
            self::$_entity = new Flight;
            self::$_entity->loadDefaultValues();
        }
        if ($this->isNewRecord()) {
            $this->_one = self::$_entity;
        } else {
            $this->_one = $this->getOne();
            if (!$this->_one) {
                throw new \InvalidArgumentException("航班记录不存在");
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

            ['flight_num', 'trim'],
            ['flight_num', 'required'],
            ['flight_num', 'validateUnique', 'message' => '航班号已经存在'],
            ['flight_num', 'string', 'min' => 2, 'max' => 100],

            ['flight_model', 'trim'],
            ['flight_model', 'required'],
            ['flight_model', 'string', 'min' => 2, 'max' => 10],

            ['air_line', 'trim'],
            ['air_line', 'required'],
            ['air_line', 'string', 'min' => 2, 'max' => 50],

            [['schedule', 'start_station', 'take_off_1', 'land_1', 'stopover_station_1', 'take_off_2', 'land_2', 'destination_station', 'start_date', 'end_date'], 'string', 'min' => 2, 'max' => 200],

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
            case 'flight_num' :
                $exists = self::$_entity->find()
                    ->where(['flight_num' => $this->flight_num])
                    ->andFilterWhere(['<>', 'id', $this->id])
                    ->exists();
                if ($exists) {
                    $this->addError($attribute, '航班号已经存在');
                    return false;
                }
                break;
        }
    }

}
