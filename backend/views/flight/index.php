<?php

/* @var $this yii\web\View */

$this->title = '航班';
?>
<div class="manage-content">
    <ul class="search-con clearfix">
        <li>
            <span>航班号</span>
            <input type="text" class="form-control" placeholder="" style="width:100px;">
        </li>
        <li>
            <span>始发站</span>
            <input type="text" class="form-control" placeholder="" style="width:100px;">
        </li>
        <li class="search-inline">
            <span>开始日期</span>
            <input type="text" readonly="readonly" class="form-control Wdate" id="stime" style="width:200px;">
        </li>
        <li class="search-inline">
            <span>结束日期</span>
            <input type="text" readonly="readonly" class="form-control Wdate" id="etime" style="width:200px;">
        </li>
        <li>
            <span>&nbsp;</span>
            <button type="button" class="btn btn-primary">搜索</button>
        </li>
    </ul>


    <div class="grid">
        <div class="grid-toolbar">
            <div class="grid-btns clearfix">
                <div class="pull-right">
                    <button type="button" class="btn btn-primary grid-btn-sep">导入</button>
                    <button type="button" class="btn btn-primary" id="getPage">新增</button>
                </div>
            </div>
        </div>
        
        <div class="grid-content" id="grid">
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
                  </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    
    <script type="text/template" id="gridrow_template">
        <td class="align-r">
            <label class="form-checkbox" for="checkbox_<%- i %>">
                <i class="icon-checkbox"></i>
                <span class="align-m"></span>
                <input type="checkbox" class="form-checkbox-input" id="checkbox_<%- i %>">
            </label>
        </td>
        <td class="align-c"><%- i %></td>
        <td><%- weixin %></td>
        <td allowedit="name_template"><%- name %></td>
        <td class="color-gray"><%- card %></td>
        <td class="color-gray"><%- mobile %></td>
        <td>
            <p><a href="/index.php?r=index/form">编辑</a></p>
            <p><a href="javascript:;" class="del">删除</a></p>
        </td>
    </script>
    
    <script type="text/template" id="name_template">
        <div class="form form-base">
            <input type="text" class="form-control" value="<%- name%>" id="newname">
        </div>
    </script>
</div>
