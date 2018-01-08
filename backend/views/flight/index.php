<?php

/* @var $this yii\web\View */

$this->title = '航班';
?>
<div class="manage-content">
    <ul class="search-con clearfix">
        <li>
            <span>航班号</span>
            <input type="text" class="form-control" placeholder="" style="width:100px;" id="flight_num">
        </li>
        <li>
            <span>始发站</span>
            <input type="text" class="form-control" placeholder="" style="width:100px;" id="start_station">
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
                    <button type="button" class="btn btn-primary grid-btn-sep">导入</button>
                    <a type="button" class="btn btn-primary" href="/flight/flight-edit/">新增</a>
                </div>
            </div>
        </div>
        
        <div class="grid-content" id="flight_grid">
            <table class="table form">
                <thead>
                  <tr>
                    <th width="60" class="align-c">序号</th>
                    <th>航班号</th>
                    <th>机型</th>
                    <th>航线</th>
                    <th>班期</th>
                    <th>始发站</th>
                    <th>开始日期</th>
                    <th>结束日期</th>
                    <th>操作</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    
    <script type="text/template" id="flight_grid_template">
        <td class="align-c"><%- i %></td>
        <td><%- flight_num %></td>
        <td><%- flight_model %></td>
        <td><%- air_line %></td>
        <td><%- schedule %></td>
        <td><%- start_station %></td>
        <td><%- start_date %></td>
        <td><%- end_date %></td>
        <td>
            <a class="edit" href="javascript:;" data-id="<%- id%>">修改</a>
            <a class="btn-del" href="javascript:;" data-id="<%- id%>">删除</a>
        </td>
    </script>
    
    <script type="text/template" id="name_template">
        <div class="form form-base">
            <input type="text" class="form-control" value="<%- name%>" id="newname">
        </div>
    </script>
    <script type="text/javascript">
        seajs.use('/js/flight/flight-index.js');
    </script>
</div>
