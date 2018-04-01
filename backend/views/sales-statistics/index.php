<?php

/* @var $this yii\web\View */

$this->title = '周期销售分析';
?>
<style type="text/css">
    .table>thead>tr>th{
        padding: 8px 5px;
    }
</style>
<div>
    <ul class="search-con clearfix">
        <li>
            <span>对比维度</span>
            <input type="text" class="form-control" placeholder="" style="width:150px;" id="statistics-type">
        </li>
        
        <li class="search-inline">
            <span>日期</span>
            <input type="text" readonly="readonly" class="form-control Wdate" id="date" style="width:130px;">
        </li>
        <li>
            <span>&nbsp;</span>
            <button type="button" class="btn btn-primary" id="search">搜索</button>
        </li>
    </ul>
    <div class="grid">
        <div class="grid-content" id="grid">
            <table class="table form">
                <thead>
                    <tr>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>

    </div>
    
    <script type="text/template" id="grid_template">
        <td><%- real_weight0 %></td>
        <td><%- real_weight1 %></td>
        <td><%- real_weight2 %></td>
        <td><%- real_weight3 %></td>
        <td><%- real_weight4 %></td>
        <td><%- real_weight5 %></td>
        <td><%- real_weight6 %></td>
        <td><%- real_weight7 %></td>
        <td><%- real_weight8 %></td>
        <td><%- real_weight9 %></td>
        
    </script>
    
    
    <script type="text/javascript">
        seajs.use('/js/sales-statistics/sales-statistics-index.js');
    </script>
</div>
