define(function (require, exports, module) { 
    require('/js/common/grid.js');
    require('/js/lib/plupload/plupload.full.min.js'); //用于导入文件
    $.getScript("/js/lib/plupload/i18n/zh_CN.js"); //中文提示包
    require('/js/lib/laydate/laydate.dev.js');

    var daily_business_grid = $('#daily_business_grid').grid({
        url: '/daily-business/ajax-get-list',
        idField: 'id',
        templateid: 'daily_business_grid_template',
        pagesize: 20,
        scrollLoad: false,
        setEmptyText: function () {
            return '没有数据';
        },
        method: 'get',
        queryParams: function () {
            return 'simple_code='+$.trim($('#simple_code').val())+'&'
                    +'flight_num='+$.trim($('#flight_num').val())+'&'
                    +'destination_station='+$.trim($('#destination_station').val())+'&'
                    +'freight_rates_code='+$.trim($('#freight_rates_code').val())+'&'
                    +'start_date='+$.trim($('#start_date').val())+'&'
                    +'end_date='+$.trim($('#end_date').val());
        }
    });

    // 搜索
    $('#search').click(function(){
        daily_business_grid.refresh();
    });

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

    function showMessage(message, isNormal, delay) {
        alert(message);

        /*$.topTips({
            mode: isNormal ? 'normal' : 'warning',
            tip_text: message,
            delay: delay
        });*/
    }

})