<?php
namespace backend\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\services\FlightService;
use yii\web\UploadedFile;

/**
 * Flight controller
 */
class FlightController extends ControllerBase
{
    private $_service;

    /**
     * FlightController constructor.
     * @param string $id
     * @param \yii\base\Module $module
     * @param FlightService $flightService
     * @param array $config
     */
    public function __construct($id, $module, FlightService $flightService, $config = [])
    {
        $this->_service = $flightService;
        parent::__construct($id, $module, $config);
    }

    /**
     * 基础数据 - 航班
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
        return $this->render('flight-edit', ['data' => $data]);
    }

    /**
     * 获取列表
     * @return \yii\web\Response
     */
    public function actionAjaxGetList()
    {
        $page = Yii::$app->request->get('page', 1);
        $pageSize = Yii::$app->request->get('pageSize', 10);
        $conditions['like']['flight_num'] = Yii::$app->request->get('flight_num');
        $conditions['like']['start_station'] = Yii::$app->request->get('start_station');
        $conditions['ge']['start_date'] = Yii::$app->request->get('start_date');
        $conditions['le']['end_date'] = Yii::$app->request->get('end_date');
        $result = $this->_service->getList($page, $pageSize, $conditions);

        return $this->asJson($result);
    }

    /**
     * 保存航班号
     *
     * @return string
     */
    public function actionSave()
    {
        try {
            $data = Yii::$app->request->post();
            $id = $this->_service->save($data);
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
        $result = $this->_service->import($file);

        return json_encode($result);
    }
}
