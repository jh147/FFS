
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
    <a href="/goods/index" class="icon-merge icon-goback" title="返回上一层">返回上一层</a>
    <a href="/goods/index" class="parent">货物种类</a> / 
    <span>编辑货物种类</span>
</div>

<div class="form form-base form-horizontal padding">
    <input type="hidden" id="goods_id" value="<?= $data['id']?>">
    <div class="form-group">
        <label class="form-label col-md-1">航站</label>
        <div class="col-md-3">
            <input type="text" class="form-control fm_required" id="flight_station" value="<?= $data['flight_station'] ?>">
        </div>
        <label class="form-label col-md-2 align-c">运价代码</label>
        <div class="col-md-3 ">
            <input type="text" class="form-control fm_required" id="freight_rates_code" value="<?= $data['freight_rates_code'] ?>">
        </div>
    </div>

    <div class="form-group">
        <label class="form-label col-md-1">品名</label>
        <div class="col-md-3 ">
            <input type="text" class="form-control fm_required" id="product_name" value="<?= $data['product_name'] ?>">
        </div>
    </div>

    <div class="form-bottom">
        <button type="button" class="btn btn-primary" id="save">保存</button>
    </div>
</div>
<script type="text/javascript">
    seajs.use('/js/goods/goods-edit.js');
</script>
