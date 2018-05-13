<?php

/* @var $this yii\web\View */

$this->title = '周期运价分析';
?>
<style type="text/css">
    .grid-content{
        height: 400px;
    }
</style>
<div>
    
    <ul class="search-con clearfix">
        <li class="search-inline">
            <span>始发站</span>
            <input type="text" class="form-control" style="width:130px;" id="start_station">
        </li>
        <li class="search-inline">
            <span>目的站</span>
            <input type="text" class="form-control" style="width:130px;" id="destination_station">
        </li>
        <li class="search-inline">
            <span>航班号</span>
            <input type="text" class="form-control" style="width:130px;" id="flight_num">
        </li>
        <li class="search-inline">
            <span>运价代码</span>
            <input type="text" class="form-control" style="width:130px;" id="freight_rates_code">
        </li>
        <li class="search-inline">
            <span>开始日期</span>
            <input type="text" readonly="readonly" class="form-control Wdate" id="start_date_1" style="width:130px;">
        </li>
        <li class="search-inline">
            <span>结束日期</span>
            <input type="text" readonly="readonly" class="form-control Wdate" id="end_date_1" style="width:130px;">
        </li>
        <li id="timeFilter">
            <span>&nbsp;</span>
            <label class="form-radio selected">
                <i class="icon-radio"></i>
                <span class="align-m">按日</span>
                <input name="timeSec" type="radio" class="form-radio-input" value="0">
            </label>
            <span>&nbsp;</span>
            <label class="form-radio">
                <i class="icon-radio"></i>
                <span class="align-m">按月</span>
                <input name="timeSec" type="radio" class="form-radio-input" value="1">
            </label>
        </li>
        <li>
            <span>&nbsp;</span>
            <button type="button" class="btn btn-primary" id="search_1">查询</button>
        </li>
    </ul>

    <div class="grid">
        <div class="grid-content" id="chart_1">
           
        </div>
    </div>
    
    <ul class="search-con clearfix">
        <li class="search-inline">
            <span>航班号</span>
            <input type="text" class="form-control" style="width:130px;" id="flight_num_2">
        </li>
        <li class="search-inline">
            <span>开始日期</span>
            <input type="text" readonly="readonly" class="form-control Wdate" id="start_date_2" style="width:130px;">
        </li>
        <li class="search-inline">
            <span>结束日期</span>
            <input type="text" readonly="readonly" class="form-control Wdate" id="end_date_2" style="width:130px;">
        </li>
        <li>
            <span>&nbsp;</span>
            <button type="button" class="btn btn-primary" id="search_2">查询</button>
        </li>
    </ul>
    <div class="grid">
        <div class="grid-content" id="chart_2">
           
        </div>
    </div>
    <script type="text/javascript" src="/js/lib/echarts.min.js"></script>
    <script type="text/javascript" src="/js/lib/underscore.min.js"></script>
    <script type="text/javascript">
        seajs.use('/js/price-cycle/index.js');
    </script>
</div>
