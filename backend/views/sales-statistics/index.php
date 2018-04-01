<?php

/* @var $this yii\web\View */

$this->title = '周期销售对比';
?>
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
                        <th width="60" class="align-c">排名</th>
                        <th>货量</th>
                        <th>日均货量</th>
                        <th>收益</th>
                        <th>日均收益</th>
                        <th>平均运价</th>
                        <th>货量</th>
                        <th>日均货量</th>
                        <th>收益</th>
                        <th>日均收益</th>
                        <th>平均运价</th>
                        <th>货量</th>
                        <th>收益</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>

        <div class="grid-content" id="sales_compare_airline_grid" style="display: none;">
            <table class="table form">
                <thead>
                    <tr>
                        <th width="60" class="align-c" rowspan=2 style="vertical-align: middle;border-right: 1px solid #e7e6eb;">排名</th>
                        <th rowspan="2" class="align-c" style="vertical-align: middle;border-right: 1px solid #e7e6eb;">航线</th>
                        <th colspan="5" class="align-c" style="vertical-align: middle;border-right: 1px solid #e7e6eb;">上期</th>
                        <th colspan="5" class="align-c" style="vertical-align: middle;border-right: 1px solid #e7e6eb;">本期</th>
                        <th colspan="2" class="align-c">增幅</th>
                    </tr>
                    <tr>
                        <th>货量</th>
                        <th>日均货量</th>
                        <th>收益</th>
                        <th>日均收益</th>
                        <th>平均运价</th>
                        <th>货量</th>
                        <th>日均货量</th>
                        <th>收益</th>
                        <th>日均收益</th>
                        <th>平均运价</th>
                        <th>货量</th>
                        <th>收益</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>

        <div class="grid-content" id="sales_compare_agent_grid" style="display: none;">
            <table class="table form">
                <thead>
                    <tr>
                        <th width="60" class="align-c" rowspan=2 style="vertical-align: middle;border-right: 1px solid #e7e6eb;">排名</th>
                        <th rowspan="2" class="align-c" style="vertical-align: middle;border-right: 1px solid #e7e6eb;">代理人</th>
                        <th colspan="4" class="align-c" style="vertical-align: middle;border-right: 1px solid #e7e6eb;">上期</th>
                        <th colspan="4" class="align-c" style="vertical-align: middle;border-right: 1px solid #e7e6eb;">本期</th>
                        <th colspan="2" class="align-c">增幅</th>
                    </tr>
                    <tr>
                        <th>货量</th>
                        <th>日均货量</th>
                        <th>收益</th>
                        <th>日均收益</th>
                        <th>货量</th>
                        <th>日均货量</th>
                        <th>收益</th>
                        <th>日均收益</th>
                        <th>货量</th>
                        <th>收益</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    
    <script type="text/template" id="grid_template">
        <td class="align-c"><%- i %></td>
        <td><%- flight_num %></td>
        <td><%- last_real_weight %></td>
        <td><%- last_avg_weight %></td>
        <td><%- last_real_freight_fee%></td>
        <td><%- last_avg_fee %></td>
        <td><%- last_avg_freight_fee %></td>
        <td><%- this_real_weight%></td>
        <td><%- this_avg_weight%></td>
        <td><%- this_real_freight_fee%></td>
        <td><%- this_avg_fee%></td>
        <td><%- this_avg_freight_fee %></td>
        <td><%- add_real_weight%></td>
        <td><%- add_real_freight_fee%></td>
    </script>
    
    
    <script type="text/javascript">
        seajs.use('/js/sales-statistics/sales-statistics-index.js');
    </script>
</div>
