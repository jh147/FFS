<?php

/* @var $this yii\web\View */

$this->title = '日常营业';
?>
<div>
    
    <ul class="search-con clearfix">
        <li>
            <span>航班号</span>
            <input type="text" class="form-control" placeholder="" style="width:100px;" id="flight_num">
        </li>
        <li>
            <span>目的站</span>
            <input type="text" class="form-control" placeholder="" style="width:100px;" id="destination_station">
        </li>
        <li>
            <span>代理人</span>
            <input type="text" class="form-control" placeholder="" style="width:100px;" id="simple_code">
        </li>
        <li>
            <span>运价代码</span>
            <input type="text" class="form-control" placeholder="" style="width:100px;" id="freight_rates_code">
        </li>
        <li class="search-inline">
            <span>开始日期</span>
            <input type="text" readonly="readonly" class="form-control Wdate" id="start_date" style="width:130px;">
        </li>
        <li class="search-inline">
            <span>结束日期</span>
            <input type="text" readonly="readonly" class="form-control Wdate" id="end_date" style="width:130px;">
        </li>
        <li>
            <span>&nbsp;</span>
            <button type="button" class="btn btn-primary" id="search">搜索</button>
        </li>
    </ul>

    <div class="grid">
        <div class="grid-content" id="daily_business_grid">
            <table class="table form">
                <thead>
                  <tr>
                    <th width="60" class="align-c">序号</th>
                    <th>航班日期 </th>
                    <th>运单号</th>
                    <th>航班号</th>
                    <th>目的站</th>
                    <th>代理人</th>
                    <th>实际重量</th>
                    <th>实走重量</th>
                    <th>运价代码</th>
                    <th>费率</th>
                    <th>实收运费</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    
    <script type="text/template" id="daily_business_grid_template">
        <td class="align-c"><%- i %></td>
        <td><%- flight_date %></td>
        <td><%- order_num %></td>
        <td><%- flight_num %></td>
        <td><%- destination_station%></td>
        <td><%- simple_code%></td>
        <td><%- actual_weight%></td>
        <td><%- actual_weight - pg_weight %></td>
        <td><%- freight_rates_code %></td>
        <td><%- freight_rates %></td>
        <td><%- (billing_weight-pg_weight)*(freight_rates+ (prefix==='000'?0:0.2) ) %></td>
    </script>
    
    <script type="text/javascript">
        seajs.use('/js/daily-business/daily-index.js');
    </script>
</div>
