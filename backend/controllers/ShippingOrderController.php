<?php
namespace backend\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\services\OrderService;
use yii\web\UploadedFile;

/**
 * Class ShippingOrderController
 * @package backend\controllers
 */
class ShippingOrderController extends ControllerBase
{
    private $_service;

    /**
     * ShippingOrderController constructor.
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
     * 基础数据 - 运单
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
        return $this->render('order-index');
    }

    /**
     *
     * @return string
     */
    public function actionEdit()
    {
        $id = Yii::$app->request->get('id');
        $obj = $this->_service->getOne($id);
        $data = [];
        if ($obj) {
            $data = $obj->toArray();
        }
        return $this->render('order-edit', ['data' => $data]);
    }

    /**
     * 获取列表
     * @return \yii\web\Response
     */
    public function actionAjaxGetList()
    {
        $page = Yii::$app->request->get('page', 1);
        $pageSize = Yii::$app->request->get('pageSize', 10);
        $conditions['geq']['flight_date'] = Yii::$app->request->get('start_date');
        $conditions['leq']['flight_date'] = Yii::$app->request->get('end_date');
        $conditions['like']['order_num'] = Yii::$app->request->get('order_num');
        $conditions['like']['start_station'] = Yii::$app->request->get('start_station');
        $conditions['like']['destination_station'] = Yii::$app->request->get('destination_station');
        $conditions['like']['flight_num'] = Yii::$app->request->get('flight_num');
        $conditions['like']['freight_rates_code'] = Yii::$app->request->get('freight_rates_code');

        $result = $this->_service->getList($page, $pageSize, $conditions);

        return $this->asJson($result);
    }

    /**
     * 保存运单
     *
     * @return string
     */
    public function actionSave()
    {
        try {
            $data = Yii::$app->request->post();
            $id = $this->_service->save($data, 'common');
            return $this->asJson(['code' => 0, 'msg' => ($data['id'] ? '修改成功' : '新增成功'), 'data' => ['id' => $id]]);
        } catch (\Exception $ex) {
            \Yii::error($ex->getMessage());
            return $this->asJson(['code' => 40013, 'msg' => $ex->getMessage()]);
        }
    }

    /**
     * @return string
     */
    public function actionDelete()
    {
        try {
            $id = Yii::$app->request->post('id');
            $this->_service->delete($id);
            return $this->asJson(['code' => 0, 'msg' => '删除成功']);
        } catch (\Exception $ex) {
            \Yii::error($ex->getMessage());
            return $this->asJson(['code' => 40013, 'msg' => $ex->getMessage()]);
        }
    }

    /**
     * 导入excel操作
     * @return string
     */
    public function actionImport()
    {
        set_time_limit(0);
        $file = UploadedFile::getInstanceByName('file');
        $result = $this->_service->import($file, 'common');

        return json_encode($result);
    }
}
