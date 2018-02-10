<?php
namespace backend\controllers;

use common\utils\ArrayHelper;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\services\OrderService;

/**
 * 销售对比
 * Class DailyBusinessController
 * @package backend\controllers
 */
class SalesCompareController extends ControllerBase
{
    private $_service;

    /**
     * PgOrderController constructor.
     * @param string $id
     * @param \yii\base\Module $module
     * @param OrderService $orderService
     * @param array $config
     */
    public function __construct($id, $module, OrderService $orderService, $config = [])
    {
        $this->_service = $orderService;
        parent::__construct($id, $module, $config);
    }

    /**
     * 基础数据 - 拉货
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'edit', 'save', 'delete', 'ajax-get-list', 'import'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * 获取列表
     * @return \yii\web\Response
     */
    public function actionAjaxGetList()
    {
        $type = Yii::$app->request->get('type');
        $conditions = [];
        $conditions['geq']['flight_date'] = Yii::$app->request->get('last_start_date');
        $conditions['leq']['flight_date'] = Yii::$app->request->get('last_end_date');
        $lastResult = $this->_service->getSalesCompare($conditions, $type);

        $conditions = [];
        $conditions['geq']['flight_date'] = Yii::$app->request->get('this_start_date');
        $conditions['leq']['flight_date'] = Yii::$app->request->get('this_end_date');
        $thisResult = $this->_service->getSalesCompare($conditions, $type);

        $result = $this->mergeSalesCompare($lastResult, $thisResult, $type);
        return $this->asJson($result);
    }

    /**
     * 合并上期和本期的数据
     * @param $lastResult
     * @param $thisResult
     * @param $type
     * @return array
     */
    private function mergeSalesCompare($lastResult, $thisResult, $type)
    {
        if (empty($lastResult) && empty($thisResult)) {
            return [];
        }
        if (empty($lastResult) && empty($thisResult)) {
            return [];
        }

        $typeMap = [
            'flight' => 'flight_num',
            'airline' => 'air_line',
            'agent' => 'name',
        ];
        $groupField = $typeMap[$type];

        $groupFieldArr1 = ArrayHelper::getColumn($lastResult, $groupField);
        $groupFieldArr2 = ArrayHelper::getColumn($thisResult, $groupField);
        $groupFieldArr = array_merge($groupFieldArr1, $groupFieldArr2);

        $lastResult = ArrayHelper::toDict($lastResult, $groupField);
        $thisResult = ArrayHelper::toDict($thisResult, $groupField);
        $data = [];
        foreach ($groupFieldArr as $groupVal) {
            $row = [];

            if ($lastResult[$groupVal]) {// 上期
                $row[$groupField] = $groupVal;
                $row['last_real_weight'] = $lastResult[$groupVal]['real_weight'];
                $row['last_avg_weight'] = $lastResult[$groupVal]['avg_weight'];
                $row['last_real_freight_fee'] = $lastResult[$groupVal]['real_freight_fee'];
                $row['last_avg_freight_fee'] = $lastResult[$groupVal]['avg_freight_fee'];
                $row['last_avg_fee'] = $lastResult[$groupVal]['avg_fee'];
            }
            if ($thisResult[$groupVal]) {// 本期
                $row[$groupField] = $groupVal;
                $row['this_real_weight'] = $thisResult[$groupVal]['real_weight'];
                $row['this_avg_weight'] = $thisResult[$groupVal]['avg_weight'];
                $row['this_real_freight_fee'] = $lastResult[$groupVal]['real_freight_fee'];
                $row['this_avg_freight_fee'] = $lastResult[$groupVal]['avg_freight_fee'];
                $row['this_avg_fee'] = $lastResult[$groupVal]['avg_fee'];
            }
            // 增幅
            if ($row['last_real_weight']) {
                $row['add_real_weight'] = number_format(($row['this_real_weight'] - $row['last_real_weight']) / $row['last_real_weight'], 4, '.', '') * 100 . '%';
                $row['add_real_freight_fee'] = number_format(($row['this_real_freight_fee'] - $row['last_real_freight_fee']) / $row['last_real_freight_fee'], 4, '.', '') * 100 . '%';
            } else {
                $row['add_real_weight'] = '100%';
            }

            $data[] = $row;
        }
        return $data;
    }

}
