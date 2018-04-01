<?php
namespace backend\controllers;

use common\utils\ArrayHelper;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\services\OrderService;

/**
 * 货源分析
 * Goods controller
 */
class GoodsStatisticsController extends ControllerBase
{
    private $_service;

    /**
     * GoodsStatisticsController constructor.
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
     * 基础数据 - 货物种类
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
        $conditions = [];
        $conditions['like']['flight_num'] = Yii::$app->request->get('flight_num');
        $conditions['like']['destination_station'] = Yii::$app->request->get('destination_station');
        $conditions['like']['freight_rates_code'] = Yii::$app->request->get('freight_rates_code');
        $conditions['geq']['flight_date'] = Yii::$app->request->get('start_date_1');
        $conditions['leq']['flight_date'] = Yii::$app->request->get('end_date_1');
        $result1 = $this->_service->getGoodsStatisticsList($conditions);

        $conditions['geq']['flight_date'] = Yii::$app->request->get('start_date_2');
        $conditions['leq']['flight_date'] = Yii::$app->request->get('end_date_2');
        $result2 = $this->_service->getGoodsStatisticsList($conditions);

        $conditions['geq']['flight_date'] = Yii::$app->request->get('start_date_3');
        $conditions['leq']['flight_date'] = Yii::$app->request->get('end_date_3');
        $result3 = $this->_service->getGoodsStatisticsList($conditions);

        return $this->asJson(['items' => $this->mergeResult($result1, $result2, $result3), 'total' => 1]);
    }

    private function mergeResult($result1, $result2, $result3)
    {
        $flightNum1 = ArrayHelper::getColumn($result1, 'flight_num');
        $flightNum2 = ArrayHelper::getColumn($result2, 'flight_num');
        $flightNum3 = ArrayHelper::getColumn($result3, 'flight_num');
        $flightNumArr = array_merge($flightNum1, $flightNum2, $flightNum3);

//        $result1 = array_
//        foreach ($flightNumArr as $flightNum) {
//
//        }
    }
}
