define(function (require, exports, module) { 
    var saving = false;

	$('#save').click(function(){

        var keys = [
                'name',
                'start_station',
                'simple_code',
                'financial_code',
                'manager',
                'manager_phone',
                'query',
                'query_phone',
                'add_goods',
                'add_goods_phone',
                'dispatch',
                'dispatch_fax'
            ],
            notEmptyKeys = {
                'start_station': '始发站',
                'simple_code': '简码',
                'financial_code': '财务结算代码',
                'name': '代理人名称',
                'manager': '经理',
                'manager_phone': '电话'
            },
            data = {id: '2123'},
            hasErr = false;

        $.each(keys, function(i, key){
            data[key] = $.trim($('#'+key).val());
        });

        $.each(notEmptyKeys, function(key, tipText){
            if(!data[key]){
                console.log(tipText+'不能为空');
                hasErr = true;
                return false;
            }
        });

        if(hasErr || saving){
            return;
        }

        saving = true;

        $.ajax({
            url: '/agents/save',
            data: data,
            method: 'post',
            success: function(res){
                console.log(res);
                location.href = "/agents/index/"
            },
            complete: function(){
                saving = false;
            }
        });
		
	});
})