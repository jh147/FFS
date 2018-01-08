<?php
/**
 * Created by PhpStorm.
 * User: jhe
 * Date: 2018/1/6
 * Time: 21:43
 */

namespace backend\services;


use backend\models\FlightModel;
use backend\repositories\FlightRepository;
use common\entities\Flight;
use common\utils\PagingHelper;

class FlightService extends ServiceBase
{
    private $_respository;
    private $_importResult;

    public function __construct(FlightRepository $flightRepository)
    {
        $this->_respository = $flightRepository;
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
        return $this->_respository->getOne(new Flight, $id);
    }

    public function delete($id)
    {
        $model = new FlightModel($id);
        if ($model->delete()) {
            return $model->id;
        }
        return null;
    }

    /**
     * 保存航班号
     * @param $data
     * @return null
     */
    public function save($data)
    {
        $model = new FlightModel($data['id']);
        if (!$model->load($data, '')) {
            throw new \InvalidArgumentException($model->errMsg());
        }

        if ($model->save()) {
            return $model->id;
        }
        return null;
    }

    /**
     * 导入航班号
     * @param $file
     * @return array
     * @throws \PHPExcel_Reader_Exception
     */
    public function import($file)
    {
        if (empty($file)) {
            return ["code" => 40014, "msg" => '导入航班号失败', "detail" => '请重新选择文件并导入'];
        }
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
            $validResult = $this->validRowData($excelData);
            if ($validResult['code'] != 0) {
                return $validResult;
            }
            unset($excelData[1]); //删除第一行(Title行)
            //校验成功，开始导入数据
            \Yii::info('002.数据导入：校验成功，开始导入数据。' . memory_get_usage());
            $this->_importResult['success']['导入成功'] = $this->_importResult['fail']['导入失败'] = 0;
            $cols = $values = [];
            foreach ($excelData as $row) {
                $fieldData = $this->getFieldData($row);
                if (empty($cols)) {
                    $cols = array_keys($fieldData);
                }
                $values[] = array_values($fieldData);
                $this->_importResult['success']['导入成功']++;
            }
            $this->_respository->batchInsert('flight', $cols, $values);
        } catch (\Exception $ex) {
            \Yii::error($ex);
            return ["code" => 40014, "msg" => '航班号导入失败', "detail" => ['excel中数据格式不符合要求，' . $ex->getMessage()]];
        } finally {
            unset($objPHPExcel);
            unset($objReader);
        }

        return ['code' => 0, 'msg' => '航班号导入成功', 'detail' => $this->getImportResultDetail()];
    }

    /**
     * 导入-校验
     * @return $dataArray
     */
    private function validRowData($dataArray)
    {
        $columnRules = $this->excelColumnRules();

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
                //字段值是否唯一
                if ($columnRules[$key]['unique'] && $value && $this->_respository->isExists($columnRules[$key]['field_name'], $value)) {
                    $failRows[$columnRules[$key]['column'] . '已存在'][] = $key . key($dataArray);
                }
            }
        }
        if (!empty($failRows)) {
            return ["code" => 40014, "msg" => '航班号校验失败', "detail" => $this->getFailDetail($failRows)];
        }
        return ["code" => 0, "msg" => '航班号校验成功，可以导入'];
    }

    /**
     * 导入-列规则
     * @return array
     */
    private function excelColumnRules()
    {
        return [
            'A' => ['column' => '序号', 'type' => 'string', 'required' => false],
            'B' => ['column' => '航班号', 'type' => 'string', 'required' => true, 'field_name' => 'flight_num'],
            'C' => ['column' => '机型', 'type' => 'string', 'required' => true, 'unique' => true, 'field_name' => 'flight_model'],
            'D' => ['column' => '航线', 'type' => 'string', 'required' => false, 'unique' => true, 'field_name' => 'air_line'],
            'E' => ['column' => '班期', 'type' => 'string', 'required' => false, 'unique' => true, 'field_name' => 'schedule'],
            'F' => ['column' => '始发站', 'type' => 'string', 'required' => false, 'field_name' => 'start_station'],
            'G' => ['column' => '起飞1', 'type' => 'string', 'required' => false, 'field_name' => 'take_off_1'],
            'H' => ['column' => '降落1', 'type' => 'string', 'required' => false, 'field_name' => 'land_1'],
            'I' => ['column' => '经停站', 'type' => 'string', 'required' => false, 'field_name' => 'stopover_station_1'],
            'J' => ['column' => '起飞2', 'type' => 'string', 'required' => false, 'field_name' => 'take_off_2'],
            'K' => ['column' => '降落2', 'type' => 'string', 'required' => false, 'field_name' => 'land_2'],
            'L' => ['column' => '目的站', 'type' => 'string', 'required' => false, 'field_name' => 'destination_station'],
            'M' => ['column' => '开始日期', 'type' => 'string', 'required' => false, 'field_name' => 'start_date'],
            'N' => ['column' => '结束日期', 'type' => 'string', 'required' => false, 'field_name' => 'end_date'],
        ];
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
     * @return array
     */
    public function getFieldData($dataRow)
    {
        $columnRules = $this->excelColumnRules();

        $fieldData = [];
        foreach ($dataRow as $key => $value) {
            if ($columnRules[$key]['field_name']) {
                $fieldData[$columnRules[$key]['field_name']] = $value;
            }
        }
        return $fieldData;
    }
}