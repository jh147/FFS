<?php

/* @var $this yii\web\View */

$this->title = '货源分析';
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
            <span>运价代吗</span>
            <input type="text" class="form-control" placeholder="" style="width:150px;" id="freight_rates_code">
        </li>
        <li class="search-inline">
            <span>本期</span>
            <input type="text" readonly="readonly" class="form-control Wdate" id="start_date_1" style="width:130px;">
            <span class="inline-sep" style="margin-right: auto">-</span>
            <input type="text" readonly="readonly" class="form-control Wdate" id="end_date_1" style="width:130px;">
        </li>
        <li class="search-inline">
            <span>环比</span>
            <input type="text" readonly="readonly" class="form-control Wdate" id="start_date_2" style="width:130px;">
            <span class="inline-sep" style="margin-right: auto">-</span>
            <input type="text" readonly="readonly" class="form-control Wdate" id="end_date_2" style="width:130px;">
        </li>
        <li class="search-inline">
            <span>同比</span>
            <input type="text" readonly="readonly" class="form-control Wdate" id="start_date_3" style="width:130px;">
            <span class="inline-sep" style="margin-right: auto">-</span>
            <input type="text" readonly="readonly" class="form-control Wdate" id="end_date_3" style="width:130px;">
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
                        <th>始发站</th>
                        <th>目的站</th>
                        <th>航班号</th>
                        <th>运价代码</th>
                        <th>本期货量</th>
                        <th>本期运费</th>
                        <th>本期运价</th>
                        <th>环比货量</th>
                        <th>环比运费</th>
                        <th>环比运价</th>
                        <th>同比货量</th>
                        <th>同比运费</th>
                        <th>同比运价</th>
                        
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
        seajs.use('/js/goods-statistics/index.js');
    </script>
</div>
