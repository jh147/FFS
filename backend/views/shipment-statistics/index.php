<?php

/* @var $this yii\web\View */

$this->title = '出货分析';
?>
<style type="text/css">
    .table>thead>tr>th{
        padding: 8px 5px;
    }
</style>
<div>
    <ul class="search-con clearfix">
        <li>
            <span>航班号</span>
            <input type="text" class="form-control" placeholder="" style="width:150px;" id="flight_num">
        </li>
        <li>
            <span>目的站</span>
            <input type="text" class="form-control" placeholder="" style="width:150px;" id="destination_station">
        </li>
        <li>
            <span>代理人</span>
            <input type="text" class="form-control" placeholder="" style="width:150px;" id="agent">
        </li>
        <li>
            <span>运价代码</span>
            <input type="text" class="form-control" placeholder="" style="width:150px;" id="freight_rates_code">
        </li>
        <li class="search-inline">
            <span>日期</span>
            <input type="text" readonly="readonly" class="form-control Wdate" id="start_date" style="width:130px;">
            <span class="inline-sep" style="margin-right: auto">-</span>
            <input type="text" readonly="readonly" class="form-control Wdate" id="end_date" style="width:130px;">
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
                        <th>序号</th>
                        <th>日期</th>
                        <th>航班号</th>
                        <th>目的站</th>
                        <th>代理人</th>
                        <th>运价代码</th>
                        <th>件数</th>
                        <th>货量</th>
                        <th>运费</th>
                        <th>平均运价</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>

    </div>
    
    <script type="text/template" id="grid_template">
        <td class="align-c"><%- i %></td>
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
        seajs.use('/js/shipment-statistics/index.js');
    </script>
</div>
