
<?php

/* @var $this yii\web\View */

$this->title = '拉货';
?>
<style type="text/css">
    .col-md-1 {
        width: 12.5%!important;
    }
</style>
<h4 class="padding manage-title border-bottom mb30">编辑拉货</h4>

<div class="breadcrumbs padding mb30">
    <a href="/pg-order/index" class="icon-merge icon-goback" title="返回上一层">返回上一层</a>
    <a href="/pg-order/index" class="parent">拉货</a> / 
    <span>编辑拉货</span>
</div>

<div class="form form-base form-horizontal padding">
    <input type="hidden" id="order_id" value="<?= $data['id']?>">

    <div class="form-group">
        <label class="form-label col-md-1">运单号</label>
        <?php if($data['id']){?>
            <div class="col-md-3">
                <input type="text" class="form-control" readonly="readonly" id="order_num" value="<?= $data['order_num'] ?>" tabIndex="-1">
            </div>
        <?php }else{?>
            <div class="col-md-5 form-lookup clearfix" id="order">
                <div class="search-bar">
                    <input type="text" class="search-input" 
                    placeholder="请输入代理人简码" name="name" id="order_input" value="<?= $data['order_num']?>">
                    <input type="hidden" name="id" id="order_input_id" value="<?= $data['order_num']?>">
                    <span class="x-icon x-icon-clear" id="x_clear" style="display: none;">×</span>
                    <div class="search-btn search-icon"></div>
                </div>
                <div class="grid " id="orders_grid" style="z-index: 10; width: 100%; height: 180px;">
                    <table class="table">
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php }?>
    </div>

    <div class="form-group">
        <label class="form-label col-md-1">航班日期</label>
        <div class="col-md-3">
            <input type="text" class="form-control" readonly="readonly" id="flight_date" value="<?= $data['flight_date'] ?>" tabIndex="-1">
        </div>
        <label class="form-label col-md-2 align-c">前缀</label>
        <div class="col-md-3">
            <input type="text" class="form-control" id="prefix" readonly="readonly" value="<?= $data['prefix'] ?>" tabIndex="-1">
        </div>
    </div>
    
    <div class="form-group">
        <label class="form-label col-md-1">航班号</label>
        <div class="col-md-3">
            <input type="text" class="form-control" id="flight_num" readonly="readonly" value="<?= $data['flight_num'] ?>" tabIndex="-1">
        </div>
        <label class="form-label col-md-2 align-c">费率（净运价）</label>
        <div class="col-md-3">
            <input type="text" class="form-control" id="freight_rates" readonly="readonly" value="<?= $data['freight_rates'] ?>" tabIndex="-1">
        </div>
    </div>

    <div class="form-group">
        <label class="form-label col-md-1 ">拉货件数</label>
        <div class="col-md-3">
            <input type="text" class="form-control" id="pg_quantity" value="<?= $data['pg_quantity'] ?>" >
        </div>
        <label class="form-label col-md-2 align-c">拉货重量</label>
        <div class="col-md-3">
            <input type="text" class="form-control" id="pg_weight" value="<?= $data['pg_weight'] ?>">
        </div>
    </div>
    
    <div class="form-group">
        <label class="form-label col-md-1">拉货原因</label>
        <div class="col-md-3">
            <input type="text" class="form-control" id="pg_reason" value="<?= $data['pg_reason'] ?>">
        </div>
        <label class="form-label col-md-2 align-c">处理方式</label>
        <div class="col-md-3">
            <input type="text" class="form-control" id="pg_processing_method" value="<?= $data['pg_processing_method'] ?>">
        </div>
    </div>
   
    <div class="form-group">
        <label class="form-label col-md-1">备注</label>
        <div class="col-md-8">
            <textarea class="form-control" id="pg_remark" value="<?= $data['pg_remark'] ?>"></textarea>
        </div>
    </div>

    <div class="form-group">
        <label class="form-label col-md-1">拉货损失金额</label>
        <div class="col-md-3">
            <input type="text" class="form-control" id="pg_loss_fee" readonly="readonly" value="<?= $data['pg_loss_fee'] ?>" tabIndex="-1">
        </div>
    </div>
    <div class="form-bottom">
        <button type="button" class="btn btn-primary" id="save">保存</button>
    </div>
</div>
<script type="text/template" id="orders_grid_template">
    <td>运单号：<%- order_num %> | 日期：<%- flight_date %> | 航班：<%- flight_num %></td>
</script>
<script type="text/javascript">
    seajs.use('/js/pg-order/pg-edit.js');
</script>
    
