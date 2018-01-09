define(function (require, exports, module) { 


    var saving = false;

	$('#save').click(function(){

        var keys = [
                'flight_station',
                'freight_rates_code',
                'product_name'
            ],
            notEmptyKeys = {
                'flight_station': '航站',
                'freight_rates_code': '运价代码',
                'product_name': '品名',
            },
            data = {id: $('#goods_id').val()},
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
            url: '/goods/save',
            data: data,
            method: 'post',
            success: function(res){
                if(res.code == 0){
                    location.href = "/goods/index/"
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