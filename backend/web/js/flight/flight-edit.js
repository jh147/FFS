define(function (require, exports, module) { 
    require('/js/lib/laydate/laydate.dev.js');

    var saving = false;

    $.each(['start_date', 'end_date'], function(i, id){
        $('#'+id).click(function(){
            laydate({
                elem: '#'+id,
                format: 'YYYY-MM-DD',
                istime: true,
                isclear: true
            })
        });
    });
    
	$('#save').click(function(){
        var keys = [
                'flight_num',
                'flight_model',
                'air_line',
                'schedule',
                'start_station',
                'take_off_1',
                'land_1',
                'stopover_station_1',
                'take_off_2',
                'land_2',
                'start_date',
                'end_date'
            ],
            notEmptyKeys = {
                'flight_num': '航班号',
                'flight_model': '机型',
                'air_line': '航线',
                'schedule': '班期',
                'start_station': '始发站',
                'take_off_1': '起飞1',
                'land_1': '降落1',
                'stopover_station_1': '经停站',
                'start_date': '开始日期',
                'end_date': '结束日期'
            },
            data = {id: $('#agent_id').val()},
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
            url: '/flight/save',
            data: data,
            method: 'post',
            success: function(res){
                if(res.code == 0){
                    location.href = "/flight/index/"
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