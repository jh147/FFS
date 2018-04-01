<?php
namespace backend\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\services\OrderService;

/**
 * 周期销售分析
 * Class SalesStatisticsController
 * @package backend\controllers
 */
class SalesStatisticsController extends ControllerBase
{
    private $_service;

    /**
     * SalesStatisticsController constructor.
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
     * 获取列表
     * @return \yii\web\Response
     */
    public function actionAjaxGetList()
    {
        $type = Yii::$app->request->get('type');
        $dateTime[] = $flightDate = Yii::$app->request->get('date');//当前选择的日期

        $dateTime[] = $lastYearflightDate = $this->getDateByLastYear($flightDate);//去年同一天
        $dateTime[] = $lastMonthflightDate = $this->getDateByLastMonth($flightDate);//上个月同一天
        $time = strtotime($flightDate);
        $dateTime[] = $last7Date = date("Y-m-d", strtotime("-7 days", $time));
        $dateTime[] = $last6Date = date("Y-m-d", strtotime("-6 days", $time));
        $dateTime[] = $last5Date = date("Y-m-d", strtotime("-5 days", $time));
        $dateTime[] = $last4Date = date("Y-m-d", strtotime("-4 days", $time));
        $dateTime[] = $last3Date = date("Y-m-d", strtotime("-3 days", $time));
        $dateTime[] = $last2Date = date("Y-m-d", strtotime("-2 days", $time));
        $dateTime[] = $last1Date = date("Y-m-d", strtotime("-1 days", $time));
        //echo $flightDate . '--' . $lastYearflightDate . ' -- ' . $lastMonthflightDate . '--' . $last1Date . '--' . $last7Date;
        //exit;

        $conditions = [];
        $conditions['in']['flight_date'] = $dateTime;
        $result = $this->_service->getSalesStatistics($conditions, $type);
        $result = $this->mergeStatisticsData($dateTime, $result);

        return $this->asJson(['items' => $result, 'total' => 1]);
    }

    /**
     * 去年同一天
     * @param $date
     * @return bool|string
     */
    private function getDateByLastYear($date)
    {
        list(, $month, $day) = explode('-', $date);
        $time = strtotime($date);//取得一个日期的 Unix 时间戳;
        $rYear = date("L", $time) == 1 ? 1 : 0;
        $timeStr = "last year";
        if ($rYear == 1 && ($month . $day) == '0229') {
            $timeStr = "last year -1 day";
        }
        return date("Y-m-d", strtotime($timeStr, $time));
    }

    /**
     * 上个月同一天
     * @param $date
     * @return bool|string
     */
    private function getDateByLastMonth($date)
    {
        list($year, $month, $day) = explode('-', $date);
        $time = strtotime($date);//取得一个日期的 Unix 时间戳;
        $timeStr = "last month";
        $lastMonthDay = date("d", strtotime($timeStr, $time));
        if ($day != $lastMonthDay) {
            $time = mktime(1, 1, 1, $month, 1, $year);
            $timeStr = "-1 day";
        }
        return date("Y-m-d", strtotime($timeStr, $time));
    }

    /**
     * 合并时间和货量
     * @param $dateTime
     * @param $data
     * @return array
     */
    private function mergeStatisticsData($dateTime, $data)
    {
        $result = [];
        $i = 0;
        foreach ($dateTime as $k => $time) {
            $result[$i]['name'] = '航班/航线/代理人/货源';
            $result[$i]["time" . $k] = $time;
        }
        $i++;
        $data2 = [];
        foreach ($data as $item) {
            $data2[$item['name']][$item['flight_date']] = $item;
        }

        foreach ($data2 as $name => $item) {
            $result[$i]['name'] = $name;
            foreach ($dateTime as $k => $time) {
                $result[$i]["time" . $k] = $time;
                if (isset($data2[$name][$time])) {
                    $result[$i]["real_weight" . $k] = (int)$data2[$name][$time]['real_weight'];
                } else {
                    $result[$i]["real_weight" . $k] = 0;
                }
            }
            $i++;
        }
        return $result;
    }

}
