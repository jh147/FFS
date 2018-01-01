<?php
namespace common\models;

use backend\models\BaseModels;
use common\utils\StringHelper;
use Yii;
use yii\base\InvalidParamException;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * Agent model
 *
 * @property integer $id
 * @property string $name
 * @property string $start_station
 * @property string $simple_code
 * @property string $financial_code
 * @property string $manager
 * @property integer $manager_phone
 * @property integer $query
 * @property integer $query_phone
 * @property string $add_goods
 * @property string $add_goods_phone
 * @property string $dispatch
 * @property string $dispatch_fax
 * @property string $created_on
 * @property string $created_by
 * @property string $modified_on
 * @property string $modified_by
 */
class Agent extends BaseModels
{

    public $username;
    public $simple_code;
    public $start_station;
    public $financial_code;
    public $created_by;
    public $modified_by;

    private $user_id;
    private $user_name;

    public function __construct($id = null, $config = [])
    {
        parent::__construct($config);

        $this->id = $id;
        $this->user_id = Yii::$app->user->identity->getId();
        $this->user_name = Yii::$app->user->identity->username;

        if ($this->isNewRecord()) {
            $this->setScenario('insert');
            $this->created_by = $this->user_id;
        } else {
            $this->setScenario('update');
            $this->_one = $this->findIdentity($this->id);
            if ($this->_one) {
                $this->setAttributes($this->_one->getAttributes(), false);
            } else {
                throw new InvalidParamException('代理人不存在');
            }

            $this->modified_by = $this->user_id;
        }
    }

    public function isNewRecord()
    {
        return empty($this->id);
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%agents}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'create_on',
                'updatedAtAttribute' => 'modified_on',
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['name', 'trim'],
            ['name', 'required'],
            ['name', 'unique', 'message' => 'This name has already been taken.'],
            ['name', 'string', 'min' => 2, 'max' => 100],

            ['simple_code', 'trim'],
            ['simple_code', 'required'],
            ['simple_code', 'unique', 'message' => 'This simple_code has already been taken.'],
            ['simple_code', 'string', 'min' => 2, 'max' => 10],

            ['start_station', 'trim'],
            ['start_station', 'required'],
            ['start_station', 'string', 'min' => 2, 'max' => 50],

            ['financial_code', 'trim'],
            ['financial_code', 'required'],
            ['financial_code', 'string', 'min' => 2, 'max' => 50],

            ['created_by', 'string'],
            ['modified_by', 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    public function beforeSave($insert)
    {
        if (empty($this->id)) {
            $this->id = StringHelper::uuid();
        }
        return parent::beforeSave($insert);
    }

}
