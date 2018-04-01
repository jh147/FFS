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

    /**
     * @param $result1
     * @param $result2
     * @param $result3
     * @return array
     */
    private function mergeResult($result1, $result2, $result3)
    {
        $flightNum1 = ArrayHelper::getColumn($result1, 'flight_num');
        $flightNum2 = ArrayHelper::getColumn($result2, 'flight_num');
        $flightNum3 = ArrayHelper::getColumn($result3, 'flight_num');
        $flightNumArr = array_merge($flightNum1, $flightNum2, $flightNum3);

        $result1 = ArrayHelper::group($result1, 'flight_num');
        $result2 = ArrayHelper::group($result2, 'flight_num');
        $result3 = ArrayHelper::group($result3, 'flight_num');
        $data = [];
        foreach ($flightNumArr as $flightNum) {
            if ($result1[$flightNum]) {
                foreach ($result1[$flightNum] as $item1) {
                    $data[$flightNum][$item1['start_station']][$item1['destination_station']][$item1['freight_rates_code']]['flight_num'] = $flightNum;
                    $data[$flightNum][$item1['start_station']][$item1['destination_station']][$item1['freight_rates_code']]['start_station'] = $item1['start_station'];
                    $data[$flightNum][$item1['start_station']][$item1['destination_station']][$item1['freight_rates_code']]['destination_station'] = $item1['destination_station'];

                    $data[$flightNum][$item1['start_station']][$item1['destination_station']][$item1['freight_rates_code']]['sum_weight_1'] = $item1['sum_weight'];
                    $data[$flightNum][$item1['start_station']][$item1['destination_station']][$item1['freight_rates_code']]['real_freight_fee_1'] = $item1['real_freight_fee'];
                    $data[$flightNum][$item1['start_station']][$item1['destination_station']][$item1['freight_rates_code']]['avg_freight_fee_1'] = $item1['avg_freight_fee'];
                }
            }
            if ($result2[$flightNum]) {
                foreach ($result2[$flightNum] as $item2) {
                    $data[$flightNum][$item2['start_station']][$item2['destination_station']][$item2['freight_rates_code']]['flight_num'] = $flightNum;
                    $data[$flightNum][$item2['start_station']][$item2['destination_station']][$item2['freight_rates_code']]['start_station'] = $item2['start_station'];
                    $data[$flightNum][$item2['start_station']][$item2['destination_station']][$item2['freight_rates_code']]['destination_station'] = $item2['destination_station'];

                    $data[$flightNum][$item2['start_station']][$item2['destination_station']][$item2['freight_rates_code']]['sum_weight_2'] = $item2['sum_weight'];
                    $data[$flightNum][$item2['start_station']][$item2['destination_station']][$item2['freight_rates_code']]['real_freight_fee_2'] = $item2['real_freight_fee'];
                    $data[$flightNum][$item2['start_station']][$item2['destination_station']][$item2['freight_rates_code']]['avg_freight_fee_2'] = $item2['avg_freight_fee'];
                }
            }
            if ($result3[$flightNum]) {
                foreach ($result3[$flightNum] as $item3) {
                    $data[$flightNum][$item3['start_station']][$item3['destination_station']][$item3['freight_rates_code']]['flight_num'] = $flightNum;
                    $data[$flightNum][$item3['start_station']][$item3['destination_station']][$item3['freight_rates_code']]['start_station'] = $item3['start_station'];
                    $data[$flightNum][$item3['start_station']][$item3['destination_station']][$item3['freight_rates_code']]['destination_station'] = $item3['destination_station'];

                    $data[$flightNum][$item3['start_station']][$item3['destination_station']][$item3['freight_rates_code']]['sum_weight_3'] = $item3['sum_weight'];
                    $data[$flightNum][$item3['start_station']][$item3['destination_station']][$item3['freight_rates_code']]['real_freight_fee_3'] = $item3['real_freight_fee'];
                    $data[$flightNum][$item3['start_station']][$item3['destination_station']][$item3['freight_rates_code']]['avg_freight_fee_3'] = $item3['avg_freight_fee'];
                }
            }
        }
        return $data;
    }
}
