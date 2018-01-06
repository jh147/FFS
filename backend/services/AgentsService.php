<?php
/**
 * Created by PhpStorm.
 * User: jhe
 * Date: 2018/1/6
 * Time: 21:43
 */

namespace backend\services;


use backend\models\AgentsModel;
use backend\repositories\AgentsRepository;
use common\utils\PagingHelper;

class AgentsService extends ServiceBase
{
    private $_respository;

    public function __construct(AgentsRepository $agentsRepository)
    {
        $this->_respository = $agentsRepository;
    }

    public function getList($page, $pageSize, $isLazyLoad = false)
    {
        $page = max(1, (int)$page);
        $pageSize = max(0, (int)$pageSize);
        $skip = PagingHelper::getSkip($page, $pageSize);
        $limit = $isLazyLoad ? ($pageSize + 1) : $pageSize; //如果为懒加载，则比pageSize多查询一条记录，以便知道是否有下一页，多的这条记录将在控制器中删掉。

        return $this->_respository->getList($skip, $limit);
    }

    /**
     * 保存代理人
     * @param $data
     * @return null
     */
    public function save($data)
    {
        $model = new AgentsModel($data['id']);
        if (!$model->load($data, '')) {
            throw new \InvalidArgumentException($model->errMsg());
        }

        if ($model->save()) {
            return $model->id;
        }
        return null;
    }
}