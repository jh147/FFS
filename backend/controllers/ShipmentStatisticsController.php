<?php
namespace backend\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\services\OrderService;

/**
 * 出货分析
 * ShipmentStatistics controller
 */
class ShipmentStatisticsController extends ControllerBase
{
    private $_service;

    /**
     * ShipmentStatisticsController constructor.
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
     * 基础数据
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
     * 获取出货分析列表
     * @return \yii\web\Response
     */
    public function actionAjaxGetList()
    {
        $conditions = [];
        $groupBy[] = 'flight_date';
        $groupBy[] = Yii::$app->request->get('flight_num') ? 'flight_num' : '';
        $groupBy[] = Yii::$app->request->get('destination_station') ? 'destination_station' : '';
        $groupBy[] = Yii::$app->request->get('agent') ? 'simple_code' : '';
        $groupBy[] = Yii::$app->request->get('freight_rates_code') ? 'freight_rates_code' : '';
        $groupBy = array_filter($groupBy);

        $conditions['geq']['flight_date'] = Yii::$app->request->get('start_date');
        $conditions['leq']['flight_date'] = Yii::$app->request->get('end_date');

        $result = $this->_service->getShipmentStatisticsList($conditions, $groupBy);

        return $this->asJson($result);
    }

}
