<?php
namespace backend\controllers;

use backend\services\AgentsService;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;

/**
 * 基础数据 - 代理人
 * Agent controller
 */
class AgentsController extends ControllerBase
{
    private $_service;

    /**
     * AgentsController constructor.
     * @param string $id
     * @param \yii\base\Module $module
     * @param AgentsService $agentsService
     * @param array $config
     */
    public function __construct($id, $module, AgentsService $agentsService, $config = [])
    {
        $this->_service = $agentsService;
        parent::__construct($id, $module, $config);
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'save', 'edit', 'delete', 'ajax-get-list', 'import'],
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
        $keywords = Yii::$app->request->get('keywords');
        $result = $this->_service->getList($page, $pageSize, $keywords);

        return $this->asJson($result);
    }

    /**
     * 保存代理人
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
    public function actionEdit()
    {
        $id = Yii::$app->request->get('id');
        $agent = $this->_service->getOne($id);
        $data = [];
        if ($agent) {
            $data = $agent->toArray();
        }
        return $this->render('edit', ['data' => $data]);
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
