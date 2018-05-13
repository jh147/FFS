define(function (require, exports, module) { 
    require('/js/common/grid.js');
    require('/js/common/select-box.js');
    require('/js/lib/laydate/laydate.dev.js');

    var cachedGridData = [];
    var startTime_1, endTime_1;
    var compareType = 'flight';
    var dayMonthMap = {
        '_1': 31,
        '_2': 28,
        '_3': 31,
        '_4': 30,
        '_5': 31,
        '_6': 30,
        '_7': 31,
        '_8': 31,
        '_9': 30,
        '_10': 31,
        '_11': 30,
        '_12': 31
    };

    // 初始化echarts实例
    var myChart_1 = echarts.init(document.getElementById('chart_1'));

    // 指定图表的配置项和数据
    var option = {
        // title: {
        //     text: '运价分析',
        //     align: 'center'
        // },
        // tooltip: {},
        // legend: {
        //     data:['运价']
        // },
        xAxis: {
            data: []
        },
        yAxis: {
            type: 'value'
        },
        series: [{
            name: '运价',
            type: 'line',
            data: []
        }]
    };

    function getData(params){
        return $.ajax({
            type: 'get',
            data: params,
            url: '/shipping-order/ajax-get-list',
            success: function(){

            },
        })
    }

    function paramsValidate(){
        var validate = true;
        $.each(['last_start_date', 'last_end_date', 'this_start_date', 'this_end_date'], function(i, id){
            if(!$('#'+id).val()){
                validate = false;
                return false;
            }
        })
        return validate;
    }

    function isLeapYear(year){
        if(year%100 ===0){
            if(year%400 == 0){
                return true;
            }
        }else if(year%4 ===0){
            return true;
        }
        return false;
    }

    function updateChart(){
        var endDate = new Date(endTime_1);
        var startDate = new Date(startTime_1);
        var xAxis = option.xAxis.data = [], j= 0;
        
        option.series[0].data = [0];

        if($('#timeFilter [name=timeSec]:checked').val() == 1){
            var monthLen = endDate.getMonth() - startDate.getMonth() + 1 + (endDate.getFullYear() - startDate.getFullYear())*12;
            xAxis[0] = startDate.getFullYear()+'-'+ (startDate.getMonth()+1);

            for(var i = 1; i < monthLen; i += 1){
                var startMonth = startDate.getMonth();
                startDate.setMonth(startMonth+1);
                xAxis.push(startDate.getFullYear()+'-'+ (startDate.getMonth()+1));
                option.series[0].data[i] = 0 //10*Math.random();
            }

            var gridDataMap = _.groupBy(cachedGridData, function(item){
                return item.flight_date.slice(0, 7);
            });
            hasDataMonth = _.sortBy(_.keys(gridDataMap));

            _.each(hasDataMonth, function(month, i){
                var fee = 0;
                _.each(gridDataMap[month], function(item){
                    fee += item.freight_rates;
                });
                for(var j = 0; j < xAxis.length; j++){
                    if( -1 !== xAxis[j].flight_date.indexOf(month)){
                        option.series[0].data[j] = +fee;
                        break;
                    }
                }
            });
            
            // console.log(xAxis);
        }else{

            for(var i = startTime_1; i <= endTime_1; i += 24*3600*1000){
                var d = new Date(i);
                xAxis.push(d.getMonth()+1+'-'+d.getDate());
                option.series[0].data[j] = 0 //10*Math.random();
                j++;
            }
            for(var i = 0; i < cachedGridData.length; i++){
                for(var j = 0; j < xAxis.length; j++){
                    if( isTheSameMonthAndDate(list[i].flight_date, xAxis[j])){
                        option.series[0].data[j] = +list[i].freight_rates;
                        break;
                    }
                }
            }
        }

        myChart_1.setOption(option);
    }

    $('#timeFilter').on('click', 'label', function(){
        if($(this).hasClass('selected')){
            return ;
        }

        $(this).addClass('selected').siblings('.selected').removeClass('selected');

        // updateChart();
    });

    $.each(['start_date_1', 'end_date_1', 'start_date_2', 'end_date_2'], function(i, id){
        $('#'+id).click(function(){
            laydate({
                elem: '#'+id,
                format: 'YYYY-MM-DD',
                istime: true,
                isclear: true
            })
        });
    });

    $('#search_1').click(function(){    
        var startTime = $('#start_date_1').val(),
            endTime = $('#end_date_1').val(),
            params = {
                start_station: $('#start_station').val(),
                destination_station:$('#destination_station').val(),
                flight_num: $('#flight_num').val(),
                freight_rates_code: $('#freight_rates_code').val(),
                start_date: startTime,
                end_date: endTime
            };

        if(!params.start_station){
            return alert('请输入始发站');
        }

        if(!params.destination_station){
            return alert('请输入目的站');
        }

        if(!params.flight_num){
            return alert('请输入航班号');
        }

        if(!params.freight_rates_code){
            return alert('请输入运价代码');
        }

        if(!startTime){
            return alert('请输入开始时间');
        }
        if(!endTime){
            return alert('请输入结束时间');
        }
        if( startTime > endTime){
            return alert('开始时间不能大于结束时间');
        }

        startDate = new Date(startTime);
        endDate = new Date(endTime);

        startDate.setHours(0)  
        startDate.setMinutes(0)    
        startDate.setSeconds(0)    
        startDate.setMilliseconds(0)

        endDate.setHours(0)  
        endDate.setMinutes(0)    
        endDate.setSeconds(0)    
        endDate.setMilliseconds(0)

        startTime_1 = startTime = startDate.getTime(), 
        endTime_1 = endTime = endDate.getTime();

        if($('#timeFilter [name=timeSec]:checked').val() == 1){
            if(isLeapYear(endDate.getFullYear()) && endDate.getMonth() == 1){
                endDate.setDate(29);
            }else{
                endDate.setDate(dayMonthMap['_'+(endDate.getMonth() + 1) ]);
            }
            startDate.setDate(1);

            if( endDate.getMonth() - startDate.getMonth() + 1 + (endDate.getFullYear() - startDate.getFullYear())*12 > 12){
                return alert('按月查询，不能大于12个月');
            }
        }else{
            if(endDate.getTime()-startDate.getTime() > 60*24*3600*1000){
                return alert('按日查询，不能大于60天');
            }
        }

        getData(params).then(function(list){
            // console.log(list);
            cachedGridData = list.items;
            updateChart();
        });
    });

    
    
    var option2 = {
        // title: {
        //     text: '运价分析',
        //     align: 'center'
        // },
        // tooltip: {},
        // legend: {
        //     data:['运价']
        // },
        xAxis: {
            type: 'category',
            data: []
        },
        yAxis: {
            type: 'value',
            logBase: 10,
            name: 'y'
        },
        series: [{
            name: '运价',
            type: 'line',
            data: []
        },{
            name: '货量',
            type: 'line',
            data: []
        },{
            name: '收入',
            type: 'line',
            data: []
        }]
    };

    var myChart_2 = echarts.init(document.getElementById('chart_2'));

    $('#search_2').click(function(){    
        var startTime = $('#start_date_2').val(),
            endTime = $('#end_date_2').val(),
            params = {
                flight_num: $('#flight_num_2').val(),
                start_date: startTime,
                end_date: endTime
            };


        if(!params.flight_num){
            return alert('请输入航班号');
        }

        if(!startTime){
            return alert('请输入开始时间');
        }
        if(!endTime){
            return alert('请输入结束时间');
        }
        if( startTime > endTime){
            return alert('开始时间不能大于结束时间');
        }

        startDate = new Date(startTime);
        endDate = new Date(endTime);

        startDate.setHours(0)  
        startDate.setMinutes(0)    
        startDate.setSeconds(0)    
        startDate.setMilliseconds(0)

        endDate.setHours(0)  
        endDate.setMinutes(0)    
        endDate.setSeconds(0)    
        endDate.setMilliseconds(0)
        
        if(endDate.getTime()-startDate.getTime() > 60*24*3600*1000){
            return alert('时间跨度不能大于60天');
        }

        getData(params).then(function(data){
            var list =data.items || [];
            var stime = startDate.getTime(), etime = endDate.getTime();
            var xAxis = option2.xAxis.data = [];
            var j = 0;
            for(var i = stime; i <= etime; i += 24*3600*1000){
                var d = new Date(i);
                xAxis.push(d.getMonth()+1+'-'+d.getDate());
                option2.series[0].data[j] = 0;
                option2.series[1].data[j] = 0;
                option2.series[2].data[j] = 0;
                j++;
            }
            for(var i = 0; i < list.length; i++){
                for(var j = 0; j < xAxis.length; j++){
                    if( isTheSameMonthAndDate(list[i].flight_date, xAxis[j])){
                        option2.series[0].data[j] = +list[i].freight_rates;
                        option2.series[1].data[j] = +list[i].billing_weight;
                        option2.series[2].data[j] = +list[i].freight_total_fee;
                        break;
                    }
                }
            }
            myChart_2.setOption(option2);
            // updateChart();
        });
    });

    function isTheSameMonthAndDate(date1, date2){
        var s1 = date1.split('-'), s2 = date2.split('-');

        if(+s1[1] === +s2[0] && +s1[2] === +s2[1]){
            return true;
        }
        return false;
    }
})