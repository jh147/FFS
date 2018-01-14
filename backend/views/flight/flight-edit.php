
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
    <input type="hidden" id="flight_id" value="<?= $data['id']?>">
    <div class="form-group">
        <label class="form-label col-md-1">航班号</label>
        <div class="col-md-3">
            <input type="text" class="form-control fm_required" id="flight_num" value="<?= $data['flight_num'] ?>">
        </div>
        <label class="form-label col-md-2 align-c">机型</label>
        <div class="col-md-3 ">
            <input type="text" class="form-control fm_required" id="flight_model" value="<?= $data['flight_model'] ?>">
        </div>
    </div>

    <div class="form-group">
        <label class="form-label col-md-1">航线</label>
        <div class="col-md-3">
            <input type="text" class="form-control fm_required" id="air_line" value="<?= $data['air_line'] ?>">
        </div>
        <label class="form-label col-md-2 align-c">班期</label>
        <div class="col-md-3">
            <input type="text" class="form-control fm_required" id="schedule" value="<?= $data['schedule'] ?>">
        </div>
    </div>

    <div class="form-group">
        <label class="form-label col-md-1">始发站</label>
        <div class="col-md-3">
            <input type="text" class="form-control fm_required" id="start_station" value="<?= $data['start_station'] ?>">
        </div>
    </div>
    
    <div class="form-group">
        <label class="form-label col-md-1">起飞1</label>
        <div class="col-md-3">
            <input type="text" class="form-control" id="take_off_1" value="<?= $data['take_off_1'] ?>">
        </div>
        <label class="form-label col-md-2 align-c">降落1</label>
        <div class="col-md-3">
            <input type="text" class="form-control" id="land_1" value="<?= $data['land_1'] ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="form-label col-md-1">经停站</label>
        <div class="col-md-3">
            <input type="text" class="form-control fm_required" id="stopover_station" value="<?= $data['stopover_station'] ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="form-label col-md-1">起飞2</label>
        <div class="col-md-3">
            <input type="text" class="form-control" id="take_off_2" value="<?= $data['take_off_2'] ?>">
        </div>
        <label class="form-label col-md-2 align-c">降落2</label>
        <div class="col-md-3 ">
            <input type="text" class="form-control" id="land_2" value="<?= $data['land_2'] ?>">
        </div>
    </div>

    <div class="form-group">
        <label class="form-label col-md-1">目的站</label>
        <div class="col-md-3">
            <input type="text" class="form-control" id="destination_station" value="<?= $data['destination_station'] ?>">
        </div>
    </div>
    
    
    <div class="form-group">
        <label class="form-label col-md-1">开始日期</label>
        <div class="col-md-3">
            <input type="text" class="form-control Wdate" readonly="readonly" id="start_date" value="<?= $data['start_date'] ?>">
        </div>
        <label class="form-label col-md-2 align-c">结束日期</label>
        <div class="col-md-3 ">
            <input type="text" class="form-control Wdate" readonly="readonly" id="end_date" value="<?= $data['end_date'] ?>">
        </div>
    </div>

    <div class="form-bottom">
        <button type="button" class="btn btn-primary" id="save">保存</button>
    </div>
</div>
<script type="text/javascript">
    seajs.use('/js/flight/flight-edit.js');
</script>
    
