<?php
namespace backend\controllers;

use backend\services\AgentsService;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

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
                        'actions' => ['index', 'edit', 'save', 'ajax-get-list'],
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
     * @return json
     */
    public function actionAjaxGetList($page = 1, $pageSize = 10)
    {
        $result = $this->_service->getList($page, $pageSize);

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
            return $this->asJson([true, $data['id'] ? '修改成功' : '新增成功', 'id' => $id]);
        } catch (\Exception $ex) {
            \Yii::error($ex->getMessage());
            return $this->asJson([false, $ex->getMessage()]);
        }
    }

    /**
     *
     *
     * @return string
     */
    public function actionEdit()
    {
        return $this->render('edit');
    }
}
