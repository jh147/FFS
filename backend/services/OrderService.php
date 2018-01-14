<?php
/**
 * Created by PhpStorm.
 * User: jhe
 * Date: 2018/1/6
 * Time: 21:43
 */

namespace backend\services;


use backend\models\OrderModel;
use backend\models\PgOrderModel;
use backend\repositories\OrderRepository;
use common\entities\ShippingOrder;
use common\utils\PagingHelper;

class OrderService extends ServiceBase
{
    private $_respository;
    private $_importResult;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->_respository = $orderRepository;
    }

    /**
     * @param $page
     * @param $pageSize
     * @param $conditions
     * @param bool $isLazyLoad
     * @return array
     */
    public function getList($page, $pageSize, $conditions, $isLazyLoad = false)
    {
        $page = max(1, (int)$page);
        $pageSize = max(0, (int)$pageSize);
        $skip = PagingHelper::getSkip($page, $pageSize);
        $limit = $isLazyLoad ? ($pageSize + 1) : $pageSize; //如果为懒加载，则比pageSize多查询一条记录，以便知道是否有下一页，多的这条记录将在控制器中删掉。

        return $this->_respository->getList($skip, $limit, $conditions);
    }

    public function getOne($id)
    {
        return $this->_respository->getOne(new ShippingOrder, $id);
    }

    public function delete($id)
    {
        $model = new OrderModel($id);
        if ($model->delete()) {
            return $model->id;
        }
        return null;
    }

    /**
     * 保存货物种类
     * @param $data
     * @param $type
     * @return null
     */
    public function save($data, $type = 'common')
    {
        if ($type == 'common') {
            $model = new OrderModel($data['id']);
        } else {
            $model = new PgOrderModel($data['id']);
        }

        if (!$model->load($data, '')) {
            throw new \InvalidArgumentException($model->errMsg());
        }

        if ($model->save()) {
            return $model->id;
        }
        return null;
    }

    /**
     * 导入
     * @param $file
     * @param $type
     * @return array
     * @throws \PHPExcel_Reader_Exception
     */
    public function import($file, $type = 'common')
    {
        if (empty($file)) {
            return ["code" => 40014, "msg" => '导入货物种类失败', "detail" => '请重新选择文件并导入'];
        }

        $funcName = $type == 'common' ? '运单' : '拉货';
        $fileName = $file->tempName;
        $ext = pathinfo($file->name, PATHINFO_EXTENSION);
        $readerType = $ext == 'xls' ? 'Excel5' : 'Excel2007';

        $cacheMethod = \PHPExcel_CachedObjectStorageFactory::cache_in_memory_gzip;
        \PHPExcel_Settings::setCacheStorageMethod($cacheMethod);

        $objReader = \PHPExcel_IOFactory::createReader($readerType);//设置以Excel5格式(Excel97-2003工作簿)
        $objPHPExcel = $objReader->load($fileName);// 载入excel文件
        \Yii::info('001.数据导入：开始校验数据。' . memory_get_usage());
        try {
            $excelData = $objPHPExcel->getActiveSheet()->toArray('', false, true, true);
            $validResult = $this->validRowData($excelData, $type);
            if ($validResult['code'] != 0) {
                return $validResult;
            }
            unset($excelData[1]); //删除第一行(Title行)
            //校验成功，开始导入数据
            \Yii::info('002.数据导入：校验成功，开始导入数据。' . memory_get_usage());
            $this->_importResult['success']['导入成功'] = $this->_importResult['fail']['导入失败'] = 0;
            $cols = $values = [];
            foreach ($excelData as $row) {
                $fieldData = $this->getFieldData($row, $type);
                if (empty($cols)) {
                    $cols = array_keys($fieldData);
                }
                $values[] = array_values($fieldData);
                $this->_importResult['success']['导入成功']++;
            }
            $this->_respository->batchInsert(ShippingOrder::tableName(), $cols, $values);
        } catch (\Exception $ex) {
            \Yii::error($ex);
            return ["code" => 40014, "msg" => $funcName . '导入失败', "detail" => ['excel中数据格式不符合要求，' . $ex->getMessage()]];
        } finally {
            unset($objPHPExcel);
            unset($objReader);
        }

        return ['code' => 0, 'msg' => $funcName . '导入成功', 'detail' => $this->getImportResultDetail()];
    }

    /**
     * 导入-校验
     * @return $dataArray
     */
    private function validRowData($dataArray, $type)
    {
        $columnRules = $this->excelColumnRules($type);

        $failRows = [];
        //根据第一行（即title）校验列顺序和完整性是否正确, dataArray键从1开始!
        foreach (current($dataArray) as $key => $value) {
            if ($value && $columnRules[$key]['column'] != $value) {
                $failRows['格式错误'] = '列名有误，请检查列顺序或完整性： ' . $key . key($dataArray);
            }
        }
        while ($currData = next($dataArray)) {
            foreach ($currData as $key => $value) {
                //如果列为必填值，则不能为空字符串
                if ($columnRules[$key]['required'] && $value === '') {
                    $failRows['必填值为空'][] = $key . key($dataArray);
                }
                //字符长度
                if ($columnRules[$key]['type'] == 'string' && $columnRules[$key]['maxlen'] && $value != '' && strlen($value) > $columnRules[$key]['maxlen']) {
                    $failRows['字符长度超长'][] = $key . key($dataArray);
                }
                //数字最大最小值
                if ($columnRules[$key]['type'] == 'mumber' && $columnRules[$key]['min'] && $value != '' && $value < $columnRules[$key]['min']) {
                    $failRows['数字小于最小值'][] = $key . key($dataArray);
                }
                if ($columnRules[$key]['type'] == 'mumber' && $columnRules[$key]['max'] && $value != '' && $value > $columnRules[$key]['max']) {
                    $failRows['数字大于最大值'][] = $key . key($dataArray);
                }
                //字段值是否唯一
                if ($columnRules[$key]['unique'] && $value && $this->_respository->isExists($columnRules[$key]['field_name'], $value)) {
                    $failRows[$columnRules[$key]['column'] . '已存在'][] = $key . key($dataArray);
                }
            }
        }
        if (!empty($failRows)) {
            return ["code" => 40014, "msg" => '校验失败', "detail" => $this->getFailDetail($failRows)];
        }
        return ["code" => 0, "msg" => '校验成功，可以导入'];
    }

    /**
     * 导入-列规则
     * @return array
     */
    private function excelColumnRules($type)
    {
        if ($type == 'common') {
            return [
                'A' => ['column' => '航班日期', 'type' => 'string', 'required' => false, 'field_name' => 'flight_date'],
                'B' => ['column' => '前缀', 'type' => 'mumber', 'required' => true, 'field_name' => 'prefix', 'maxlen' => 3],
                'C' => ['column' => '运单号', 'type' => 'mumber', 'required' => true, 'field_name' => 'order_num', 'maxlen' => 8],
                'D' => ['column' => '始发站', 'type' => 'string', 'required' => true, 'unique' => true, 'field_name' => 'start_station'],
                'E' => ['column' => '中转站', 'type' => 'string', 'required' => false, 'field_name' => 'stopover_station', 'maxlen' => 3],
                'F' => ['column' => '目的站', 'type' => 'string', 'required' => false, 'field_name' => 'destination_station', 'maxlen' => 3],
                'G' => ['column' => '航班号', 'type' => 'mumber', 'required' => false, 'field_name' => 'flight_num', 'maxlen' => 4],
                'H' => ['column' => '代理人简码', 'type' => 'string', 'required' => false, 'field_name' => 'simple_code', 'maxlen' => 10],
                'I' => ['column' => '运价代码', 'type' => 'string', 'required' => false, 'field_name' => 'freight_rates_code', 'maxlen' => 10],
                'J' => ['column' => '品名', 'type' => 'string', 'required' => false, 'field_name' => 'product_name', 'maxlen' => 150],
                'K' => ['column' => '件数', 'type' => 'mumber', 'required' => false, 'field_name' => 'quantity', 'min' => 0, 'max' => 10000],
                'L' => ['column' => '实际重量', 'type' => 'mumber', 'required' => false, 'field_name' => 'actual_weight', 'min' => 0, 'max' => 1000000],
                'M' => ['column' => '计费重量', 'type' => 'mumber', 'required' => false, 'field_name' => 'billing_weight', 'min' => 0, 'max' => 1000000],
                'N' => ['column' => '费率（净运价）', 'type' => 'mumber', 'required' => false, 'field_name' => 'freight_rates', 'min' => 0, 'max' => 1000],
                'O' => ['column' => '航空运费', 'type' => 'mumber', 'required' => false, 'field_name' => 'freight_fee'],
                'P' => ['column' => '燃油费', 'type' => 'mumber', 'required' => false, 'field_name' => 'fuel_fee'],
                'Q' => ['column' => '运费总额（含燃油）', 'type' => 'mumber', 'required' => false, 'field_name' => 'freight_total_fee'],
            ];
        } else {
            return [
                'A' => ['column' => '航班日期', 'type' => 'string', 'required' => false, 'field_name' => 'flight_date'],
                'B' => ['column' => '前缀', 'type' => 'string', 'required' => true, 'field_name' => 'prefix', 'maxlen' => 3],
                'C' => ['column' => '运单号', 'type' => 'string', 'required' => true, 'field_name' => 'order_num', 'maxlen' => 8],
                'D' => ['column' => '航班号', 'type' => 'string', 'required' => true, 'unique' => true, 'field_name' => 'flight_num', 'maxlen' => 4],
                'E' => ['column' => '拉货件数', 'type' => 'string', 'required' => false, 'field_name' => 'pg_quantity', 'min' => 0, 'max' => 10000],
                'F' => ['column' => '拉货重量', 'type' => 'string', 'required' => false, 'field_name' => 'pg_weight', 'min' => 0, 'max' => 1000000],
                'G' => ['column' => '费率', 'type' => 'string', 'required' => false, 'field_name' => 'pg_freight_rates', 'min' => 0, 'max' => 1000],
                'H' => ['column' => '拉货损失金额', 'type' => 'string', 'required' => false, 'field_name' => 'pg_loss_fee'],
                'I' => ['column' => '拉货原因', 'type' => 'string', 'required' => false, 'field_name' => 'pg_reason'],
                'J' => ['column' => '处理方式', 'type' => 'string', 'required' => false, 'field_name' => 'pg_processing_method'],
                'K' => ['column' => '备注', 'type' => 'string', 'required' => false, 'field_name' => 'pg_remark'],
            ];
        }
        return [];
    }

    /**
     * 转换失败记录描述
     * @param $failRows
     * @return array
     */
    private function getFailDetail($failRows)
    {
        $detail = [];
        $index = 0;

        foreach ($failRows as $text => $failRow) {
            $index++;
            if (is_array($failRow)) {
                $count = count($failRow);
                $cells = implode(',', $failRow);
                $detail[] = "{$index}、{$text}：【{$count}】条：{$cells}";
            } else {
                $detail[] = "{$index}、{$text}：{$failRow}";
            }
        }
        return $detail;
    }

    /**
     * 导入成功记录描述
     * @return array
     */
    private function getImportResultDetail()
    {
        $detail = [];
        $index = 0;
        foreach ($this->_importResult as $result) {
            if (!empty($result)) {
                foreach ($result as $text => $count) {
                    if ($count > 0) {
                        $index++;
                        $detail[] = $index . '、' . $text . '：' . '【' . (is_array($count) ? count($count) : $count) . '】条';
                    }
                }
            }
        }
        return $detail;
    }

    /**
     * 把excel的值转为数据库字段值
     * @param $dataRow
     * @param $type
     * @return array
     */
    public function getFieldData($dataRow, $type)
    {
        $columnRules = $this->excelColumnRules($type);

        $fieldData = [];
        foreach ($dataRow as $key => $value) {
            if ($columnRules[$key]['field_name']) {
                $fieldData[$columnRules[$key]['field_name']] = $value;
            }
        }
        if ($fieldData) {
            $fieldData['type'] = $type;
        }
        return $fieldData;
    }
}