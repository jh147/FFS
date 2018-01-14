
<?php

/* @var $this yii\web\View */

$this->title = '运单';
?>
<style type="text/css">
    .col-md-1 {
        width: 12.5%!important;
    }
</style>
<h4 class="padding manage-title border-bottom mb30">编辑运单</h4>

<div class="breadcrumbs padding mb30">
    <a href="/shipping-order/index" class="icon-merge icon-goback" title="返回上一层">返回上一层</a>
    <a href="/shipping-order/index" class="parent">运单</a> / 
    <span>编辑运单</span>
</div>

<div class="form form-base form-horizontal padding">
    <input type="hidden" id="order_id" value="<?= $data['id']?>">
    <div class="form-group">
        <label class="form-label col-md-1">航班日期</label>
        <div class="col-md-3">
            <input type="text" class="form-control Wdate" readonly="readonly" id="flight_date" value="<?= $data['flight_date'] ?>">
        </div>
        
    </div>
    <div class="form-group">
        <label class="form-label col-md-1">代理人</label>
        <div class="col-md-5 form-lookup clearfix" id="agent">
            <div class="search-bar">
                <input type="text" class="search-input" placeholder="请输入代理人简码" name="name" id="agent_input">
                <input type="hidden" name="id" id="agent_input_id" value="">
                <span class="x-icon x-icon-clear" id="x_clear" style="display: none;">×</span>
                <div class="search-btn search-icon"></div>
            </div>
            <div class="grid " id="agents_grid" style="z-index: 10; width: 100%; height: 180px;">
                <table class="table">
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="form-label col-md-1">前缀</label>
        <div class="col-md-3">
            <input type="text" class="form-control " id="prefix" value="<?= $data['prefix'] ?>">
        </div>
        <label class="form-label col-md-2 align-c">运单号</label>
        <div class="col-md-3">
            <input type="text" class="form-control " id="order_num" value="<?= $data['order_num'] ?>">
        </div>
    </div>
    
    <div class="form-group">
        <label class="form-label col-md-1">航班号</label>
        <div class="col-md-3 form-lookup clearfix" id="flight">
            <div class="search-bar">
                <input type="text" class="search-input" placeholder="请输入航班号" name="name" id="flight_input">
                <input type="hidden" name="id" id="flight_input_id" value="">
                <span class="x-icon x-icon-clear" id="x_clear" style="display: none;">×</span>
                <div class="search-btn search-icon"></div>
            </div>
            <div class="grid " id="flights_grid" style="z-index: 10; width: 100%; height: 180px;">
                <table class="table">
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
        <label class="form-label col-md-2 align-c">始发站</label>
        <div class="col-md-3">
            <input type="text" class="form-control " readonly="readonly" id="start_station" value="<?= $data['start_station'] ?>" tabIndex="-1">
        </div>
    </div>
    <div class="form-group">
        
        <label class="form-label col-md-1 ">中转站</label>
        <div class="col-md-3">
            <input type="text" class="form-control" readonly="readonly" id="stopover_station" value="<?= $data['stopover_station'] ?>" tabIndex="-1">
        </div>
        <label class="form-label col-md-2 align-c">目的站</label>
        <div class="col-md-3">
            <input type="text" class="form-control" readonly="readonly" id="destination_station" value="<?= $data['destination_station'] ?>" tabIndex="-1">
        </div>
    </div>
    
    <div class="form-group">
        <label class="form-label col-md-1">运价代码</label>
        <div class="col-md-3">
            <input type="text" class="form-control" id="take_off_1" value="<?= $data['take_off_1'] ?>">
        </div>
        <label class="form-label col-md-2 align-c">品名</label>
        <div class="col-md-3">
            <input type="text" class="form-control" id="product_name" value="<?= $data['product_name'] ?>">
        </div>
    </div>
   
    <div class="form-group">
        <label class="form-label col-md-1">实际重量</label>
        <div class="col-md-3">
            <input type="text" class="form-control" id="actual_weight" value="<?= $data['actual_weight'] ?>">
        </div>
        <label class="form-label col-md-2 align-c">件数</label>
        <div class="col-md-3 ">
            <input type="text" class="form-control" id="quantity" value="<?= $data['quantity'] ?>">
        </div>
    </div>

    <div class="form-group">
        <label class="form-label col-md-1">计费重量</label>
        <div class="col-md-3">
            <input type="text" class="form-control" id="billing_weight" value="<?= $data['billing_weight'] ?>">
        </div>
        <label class="form-label col-md-2 align-c">费率（净运价）</label>
        <div class="col-md-3">
            <input type="text" class="form-control " id="freight_rates" value="<?= $data['freight_rates'] ?>">
        </div>
    </div>
    
    <div class="form-group">
        <label class="form-label col-md-1">航空运费</label>
        <div class="col-md-3">
            <input type="text" class="form-control" readonly="readonly" id="freight_fee" value="<?= $data['freight_fee'] ?>" tabIndex="-1">
        </div>
        <label class="form-label col-md-2 align-c">燃油费</label>
        <div class="col-md-3 ">
            <input type="text" class="form-control" readonly="readonly" id="fuel_fee" value="<?= $data['fuel_fee'] ?>" tabIndex="-1">
        </div>
    </div>
    <div class="form-group">
        <label class="form-label col-md-1">运费总额（含燃油）</label>
        <div class="col-md-3">
            <input type="text" class="form-control " readonly="readonly" id="freight_total_fee" value="<?= $data['freight_total_fee'] ?>" tabIndex="-1">
        </div>
    </div>
    <div class="form-bottom">
        <button type="button" class="btn btn-primary" id="save">保存</button>
    </div>
</div>
<script type="text/template" id="agents_grid_template">
    <td><%- simple_code %> - <%- name %></td>
</script>
<script type="text/template" id="flights_grid_template">
    <td><%- flight_num %> - <%- air_line %></td>
</script>
<script type="text/javascript">
    seajs.use('/js/shipping-order/order-edit.js');
</script>
    
