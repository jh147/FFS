
<?php

/* @var $this yii\web\View */

$this->title = '货物种类';
?>
<style type="text/css">
    .col-md-1 {
        width: 12.5%!important;
    }
</style>
<h4 class="padding manage-title border-bottom mb30">编辑货物种类</h4>

<div class="breadcrumbs padding mb30">
    <a href="/agent/index" class="icon-merge icon-goback" title="返回上一层">返回上一层</a>
    <a href="/agent/index" class="parent">货物种类</a> / 
    <span>编辑货物种类</span>
</div>

<div class="form form-base form-horizontal padding">
    <div class="form-group">
        <label class="form-label col-md-1">航站</label>
        <div class="col-md-3">
            <input type="text" class="form-control fm_required">
        </div>
        <label class="form-label col-md-2 align-c">运价代码</label>
        <div class="col-md-3 ">
            <input type="text" class="form-control fm_required">
        </div>
    </div>

    <div class="form-group">
        <label class="form-label col-md-1">品名</label>
        <div class="col-md-3 ">
            <input type="text" class="form-control fm_required">
        </div>
    </div>

    <div class="form-bottom">
        <button type="button" class="btn btn-primary">保存</button>
    </div>
</div>
    
