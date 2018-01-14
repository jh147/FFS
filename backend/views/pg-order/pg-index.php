<?php

/* @var $this yii\web\View */

$this->title = '拉货';
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
        <div class="grid-toolbar">
            <div class="grid-btns clearfix">
                <div class="pull-right">
                    <button type="button" class="btn btn-primary grid-btn-sep" id="import_orders_btn">导入</button>
                    <a type="button" class="btn btn-primary"  href="/pg-order/edit">新增</a>
                </div>
            </div>
        </div>
                             
        <div class="grid-content" id="pg_order_grid">
            <table class="table form">
                <thead>
                  <tr>
                    <th width="60" class="align-c">序号</th>
                    <th>航班日期 </th>
                    <th>运单号</th>
                    <th>航班号</th>
                    <th>目的站</th>
                    <th>代理人</th>
                    <th>重量</th>
                    <th>费率</th>
                    <th>运费</th>
                    <th>拉货重量</th>
                    <th>拉货原因</th>
                    <th>处理结果</th>
                    <th>备注</th>
                    <th>操作</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    
    <script type="text/template" id="pg_order_grid_template">
        <td class="align-c"><%- i %></td>
        <td><%- flight_date %></td>
        <td><%- order_num %></td>
        <td><%- flight_num %></td>
        <td><%- destination_station%></td>
        <td><%- simple_code%></td>
        <td><%- billing_weight%></td>
        <td><%- freight_rates%></td>
        <td><%- freight_fee%></td>
        <td><%- pg_weight%></td>
        <td><%- pg_reason%></td>
        <td><%- pg_processing_method%></td>
        <td><%- pg_remark%></td>
        <td>
            <a class="edit" href="javascript:;" data-id="<%- id%>">修改</a>
            <a class="btn-del" href="javascript:;" data-id="<%- id%>">删除</a>
        </td>
    </script>
    
    <script type="text/javascript">
        seajs.use('/js/pg-order/pg-index.js');
    </script>
</div>
