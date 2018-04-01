<?php

/* @var $this yii\web\View */

$this->title = '出货分析';
?>
<style type="text/css">
    .table>thead>tr>th{
        padding: 8px 5px;
    }
    .flight_num, .destination_station, .simple_code, .freight_rates_code{
        display: none;
    }
</style>
<div>
    <ul class="search-con clearfix">
        <li class="search-inline">
            <span>日期</span>
            <input type="text" readonly="readonly" class="form-control Wdate" id="start_date" style="width:130px;">
            <span class="inline-sep" style="margin-right: auto">-</span>
            <input type="text" readonly="readonly" class="form-control Wdate" id="end_date" style="width:130px;">
        </li>
        <li>
            <span>&nbsp;</span>
            <label class="form-checkbox" for="checkbox">
                <i class="icon-checkbox"></i>
                <span class="align-m">航班号</span>
                <input type="checkbox" class="form-checkbox-input" value="1" id="flight_num" name="name">
            </label>
            <label class="form-checkbox" for="checkbox">
                <i class="icon-checkbox"></i>
                <span class="align-m">目的站</span>
                <input type="checkbox" class="form-checkbox-input" value="1" id="destination_station" name="name">
            </label>
            <label class="form-checkbox" for="checkbox">
                <i class="icon-checkbox"></i>
                <span class="align-m">代理人</span>
                <input type="checkbox" class="form-checkbox-input" value="1" id="simple_code" name="name">
            </label>
            <label class="form-checkbox" for="checkbox">
                <i class="icon-checkbox"></i>
                <span class="align-m">运价代码</span>
                <input type="checkbox" class="form-checkbox-input" value="1" id="freight_rates_code" name="name">
            </label>
            <!-- <label class="form-checkbox selected disabled" for="checkbox">
                <i class="icon-checkbox"></i>
                <span class="align-m">已选效果禁用</span>
                <input type="checkbox" class="form-checkbox-input" value="1" id="simple_code" name="name">
            </label>
            <label class="form-checkbox disabled" for="checkbox">
                <i class="icon-checkbox"></i>
                <span class="align-m">未选效果禁用</span>
                <input type="checkbox" class="form-checkbox-input" value="1" id="freight_rates_code" name="name">
            </label> -->
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
                        <th class="flight_num">航班号</th>
                        <th class="destination_station">目的站</th>
                        <th class="simple_code">代理人</th>
                        <th class="freight_rates_code">运价代码</th>
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
        <td><%- flight_date %></td>
        <td class="flight_num"><%- flight_num %></td>
        <td class="destination_station"><%- destination_station %></td>
        <td class="simple_code"><%- simple_code %></td>
        <td class="freight_rates_code"><%- freight_rates_code %></td>
        <td><%- sum_quantity %></td>
        <td><%- sum_weight %></td>
        <td><%- real_freight_fee %></td>
        <td><%- (+avg_freight_fee).toFixed(2) %></td>
        
    </script>
    
    
    <script type="text/javascript">
        seajs.use('/js/shipment-statistics/index.js');
    </script>
</div>
