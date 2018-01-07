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
            data = {id: ''},
            hasErr = false;

        $.each(keys, function(i, key){
            data[key] = $.trim($('#'+key).val());
        });

        $.each(notEmptyKeys, function(key, tipText){
            if(!data[key]){
                alert(tipText+'不能为空');
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
                if(res.code == 0){
                    location.href = "/agents/index/"
                }else{
                    alert(res.msg || '保存失败');
                }
            },
            complete: function(){
                saving = false;
            }
        });
		
	});

    function getQuery(key){
        var querys = location.search.replace('?', '').splite('&'),
            keyValue;

        if(!key){
            return null;
        }

        for(var i = 0; i < querys.length; i++){
            keyValue = querys[i].splite('=');
            if(key == keyValue[0]){
                return keyValue[1];
            }
        }

        return null;
    }
})