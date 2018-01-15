<?php
namespace backend\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\services\OrderService;
use yii\web\UploadedFile;

/**
 * Class DailyBusinessController
 * @package backend\controllers
 */
class DailyBusinessController extends ControllerBase
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
        $page = Yii::$app->request->get('page', 1);
        $pageSize = Yii::$app->request->get('pageSize', 10);
        $conditions['like']['simple_code'] = Yii::$app->request->get('simple_code');
        $conditions['like']['flight_num'] = Yii::$app->request->get('flight_num');
        $conditions['like']['destination_station'] = Yii::$app->request->get('destination_station');
        $conditions['like']['freight_rates_code'] = Yii::$app->request->get('freight_rates_code');
        $conditions['geq']['flight_date'] = Yii::$app->request->get('start_date');
        $conditions['leq']['flight_date'] = Yii::$app->request->get('end_date');

        $result = $this->_service->getDailBusiness($page, $pageSize, $conditions);

        return $this->asJson($result);
    }

}
