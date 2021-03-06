
<?php

/* @var $this yii\web\View */

$this->title = '代理人';
?>
<style type="text/css">
    .col-md-1 {
        width: 12.5%!important;
    }
</style>
<h4 class="padding manage-title border-bottom mb30">编辑代理人</h4>

<div class="breadcrumbs padding mb30">
    <a href="/agents/index" class="icon-merge icon-goback" title="返回上一层">返回上一层</a>
    <a href="/agents/index" class="parent">代理人</a> / 
    <span>编辑代理人</span>
</div>
<div class="form form-base form-horizontal padding">
    <input type="hidden" id="agent_id" value="<?= $data['id']?>">
    <div class="form-group">
        <label class="form-label col-md-1">始发站</label>
        <div class="col-md-3">
            <input type="text" class="form-control fm_required" id="start_station" value="<?= $data['start_station']?>">
        </div>
        <label class="form-label col-md-2 align-c">简码</label>
        <div class="col-md-3 ">
            <input type="text" class="form-control fm_required" id="simple_code" value="<?= $data['simple_code'] ?>">
        </div>
    </div>

    <div class="form-group">
        <label class="form-label col-md-1">财务结算代码</label>
        <div class="col-md-3 ">
            <input type="text" class="form-control fm_required" id="financial_code" value="<?= $data['financial_code'] ?>">
        </div>
    </div>

    <div class="form-group">
        <label class="form-label col-md-1">代理人名称</label>
        <div class="col-md-8">
            <input type="text" class="form-control fm_required" id="name" value="<?= $data['name'] ?>">
        </div>
    </div>

    <div class="form-group">
        <label class="form-label col-md-1">经理名称</label>
        <div class="col-md-3">
            <input type="text" class="form-control fm_required" id="manager" value="<?= $data['manager'] ?>">
        </div>
        <label class="form-label col-md-2 align-c">经理电话</label>
        <div class="col-md-3 ">
            <input type="tel" class="form-control fm_required" id="manager_phone" value="<?= $data['manager_phone'] ?>">
        </div>
    </div>
    
    <div class="form-group">
        <label class="form-label col-md-1">查询人</label>
        <div class="col-md-3">
            <input type="text" class="form-control" id="query" value="<?= $data['query'] ?>">
        </div>
        <label class="form-label col-md-2 align-c">查询人电话</label>
        <div class="col-md-3 ">
            <input type="text" class="form-control" id="query_phone" value="<?= $data['query_phone'] ?>">
        </div>
    </div>
    
    <div class="form-group">
        <label class="form-label col-md-1">加货人</label>
        <div class="col-md-3">
            <input type="text" class="form-control" id="add_goods" value="<?= $data['add_goods'] ?>">
        </div>
        <label class="form-label col-md-2 align-c">加货人电话</label>
        <div class="col-md-3 ">
            <input type="text" class="form-control" id="add_goods_phone" value="<?= $data['add_goods_phone'] ?>">
        </div>
    </div>
    
    
    <div class="form-group">
        <label class="form-label col-md-1">调度人</label>
        <div class="col-md-3">
            <input type="text" class="form-control" id="dispatch" value="<?= $data['dispatch'] ?>">
        </div>
        <label class="form-label col-md-2 align-c">传真</label>
        <div class="col-md-3 ">
            <input type="text" class="form-control" id="dispatch_fax" value="<?= $data['dispatch_fax'] ?>">
        </div>
    </div>

    <div class="form-bottom">
        <button type="button" class="btn btn-primary" id="save">保存</button>
    </div>
</div>
<script type="text/javascript">
    seajs.use('/js/agents/agents-edit.js');
</script>
    
