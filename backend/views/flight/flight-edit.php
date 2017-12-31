
<?php

/* @var $this yii\web\View */

$this->title = '航班';
?>
<style type="text/css">
    .col-md-1 {
        width: 12.5%!important;
    }
</style>
<h4 class="padding manage-title border-bottom mb30">编辑航班</h4>

<div class="breadcrumbs padding mb30">
    <a href="/flight/index" class="icon-merge icon-goback" title="返回上一层">返回上一层</a>
    <a href="/flight/index" class="parent">航班</a> / 
    <span>编辑航班</span>
</div>

<div class="form form-base form-horizontal padding">
    <div class="form-group">
        <label class="form-label col-md-1">航班号</label>
        <div class="col-md-3">
            <input type="text" class="form-control fm_required">
        </div>
        <label class="form-label col-md-2 align-c">机型</label>
        <div class="col-md-3 ">
            <input type="text" class="form-control fm_required">
        </div>
    </div>

    <div class="form-group">
        <label class="form-label col-md-1">航线</label>
        <div class="col-md-3">
            <input type="text" class="form-control fm_required">
        </div>
        <label class="form-label col-md-2 align-c">班期</label>
        <div class="col-md-3">
            <input type="text" class="form-control fm_required">
        </div>
    </div>

    <div class="form-group">
        <label class="form-label col-md-1">始发站</label>
        <div class="col-md-3">
            <input type="text" class="form-control fm_required">
        </div>
        
    </div>
    
    <div class="form-group">
        <label class="form-label col-md-1">起飞1</label>
        <div class="col-md-3">
            <input type="text" class="form-control ">
        </div>
        <label class="form-label col-md-2 align-c">降落1</label>
        <div class="col-md-3">
            <input type="text" class="form-control ">
        </div>
    </div>
    
    <div class="form-group">
        <label class="form-label col-md-1">起飞2</label>
        <div class="col-md-3">
            <input type="text" class="form-control ">
        </div>
        <label class="form-label col-md-2 align-c">降落2</label>
        <div class="col-md-3 ">
            <input type="text" class="form-control ">
        </div>
    </div>

    <div class="form-group">
        <label class="form-label col-md-1">目的站</label>
        <div class="col-md-3">
            <input type="text" class="form-control ">
        </div>
    </div>
    
    
    <div class="form-group">
        <label class="form-label col-md-1">开始日期</label>
        <div class="col-md-3">
            <input type="text" class="form-control Wdate" readonly="readonly">
        </div>
        <label class="form-label col-md-2 align-c">结束日期</label>
        <div class="col-md-3 ">
            <input type="text" class="form-control Wdate" readonly="readonly">
        </div>
    </div>

    <div class="form-bottom">
        <button type="button" class="btn btn-primary">保存</button>
    </div>
</div>
    
