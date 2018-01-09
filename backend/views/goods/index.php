<?php

/* @var $this yii\web\View */

$this->title = '货物种类';
?>
<div>
    
    <ul class="search-con clearfix">
        <li>
            <span>航站</span>
            <input type="text" class="form-control" placeholder="" style="width:200px;" id="flight_station">
        </li>
        <li>
            <span>运价代码</span>
            <input type="text" class="form-control" placeholder="" style="width:200px;" id="freight_rates_code">
        </li>
        <li>
            <span>品名</span>
            <input type="text" class="form-control" placeholder="" style="width:200px;" id="product_name">
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
                    <button type="button" class="btn btn-primary grid-btn-sep" id="import_goods_btn">导入</button>
                    <a type="button" class="btn btn-primary" id="editAgent" href="/goods/edit">新增</a>
                </div>
            </div>

        </div>
        
        <div class="grid-content" id="goods_grid">
            <table class="table form">
                <thead>
                  <tr>
                    <th width="60" class="align-c">序号</th>
                    <th>航站</th>
                    <th>运价代码</th>
                    <th>品名</th>
                    <th>操作</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    
    <script type="text/template" id="goods_grid_template">
        <td class="align-c"><%- i %></td>
        <td><%- flight_station %></td>
        <td><%- freight_rates_code %></td>
        <td><%- product_name %></td>
        <td>
            <a class="edit" href="javascript:;" data-id="<%- id%>">修改</a>
            <a class="btn-del" href="javascript:;" data-id="<%- id%>">删除</a>
        </td>
    </script>
    
    <script type="text/javascript">
        seajs.use('/js/goods/goods-index.js');
    </script>
</div>
