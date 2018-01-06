<?php
/**
 * Created by PhpStorm.
 * User: jhe
 * Date: 2018/1/6
 * Time: 21:42
 */

namespace backend\repositories;


use common\entities\Agents;

class AgentsRepository extends RepositoryBase
{

    /**
     * 获取列表
     * @param $skip
     * @param $limit
     * @return array
     */
    public function getList($skip, $limit)
    {

        $items = Agents::find()
            ->orderBy(['created_on' => SORT_DESC])
            ->offset($skip)
            ->limit($limit)
            ->createCommand()
            ->queryAll();

        $total = Agents::find()
            ->count();
        return ['items' => $items, 'total' => $total];
    }
}