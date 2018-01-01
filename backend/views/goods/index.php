<?php

/* @var $this yii\web\View */

$this->title = '货物种类';
?>
<div>
    
    <ul class="search-con clearfix">
        <li>
            <span>航站</span>
            <input type="text" class="form-control" placeholder="" style="width:200px;">
        </li>
        <li>
            <span>运价代码</span>
            <input type="text" class="form-control" placeholder="" style="width:200px;">
        </li>
        <li>
            <span>品名</span>
            <input type="text" class="form-control" placeholder="" style="width:200px;">
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
                    <a type="button" class="btn btn-primary" id="editAgent" href="/goods/goods-edit">新增</a>
                </div>
            </div>

        </div>
        
        <div class="grid-content" id="grid">
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
    <script type="text/javascript">
        seajs.use('/js/agent/agent-index.js');
    </script>
</div>
