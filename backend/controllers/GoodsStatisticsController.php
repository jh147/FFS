<?php
namespace backend\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\services\GoodsService;
use yii\web\UploadedFile;

/**
 * Goods controller
 */
class GoodsStatisticsController extends ControllerBase
{
    private $_service;

    /**
     * GoodsController constructor.
     * @param string $id
     * @param \yii\base\Module $module
     * @param GoodsService $goodsService
     * @param array $config
     */
    public function __construct($id, $module, GoodsService $goodsService, $config = [])
    {
        $this->_service = $goodsService;
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
        
    }
   
}
