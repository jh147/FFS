define(function (require, exports, module) { 
    require('/js/common/grid.js');
    require('/js/lib/laydate/laydate.dev.js');

    var grid = null;

    function initGrid(){
        return $('#grid').grid({
            url: '/shipment-statistics/ajax-get-list',
            idField: 'id',
            templateid: 'grid_template',
            pagesize: 20,
            scrollLoad: false,
            setEmptyText: function () {
                return '没有数据';
            },
            method: 'get',
            queryParams: function () {
                return  'flight_num='+$.trim($('#flight_num').val())+'&'
                        +'destination_station='+$.trim($('#destination_station').val())+'&'
                        +'agent='+$.trim($('#agent').val())+'&'
                        +'freight_rates_code='+$.trim($('#freight_rates_code').val())+'&'
                        +'start_date='+$.trim($('#start_date').val())+'&'
                        +'end_date='+$.trim($('#end_date').val());
            }
        });
    }


    $('.Wdate').each(function(){
        var id = $(this).attr('id');
        $(this).click(function(){
            laydate({
                elem: '#'+id,
                format: 'YYYY-MM-DD',
                istime: true,
                isclear: true
            })
        });
    });

    // 搜索
    $('#search').click(function(){
        var err = false;
        var tips = ['开始时间','结束时间']
        
        $('.Wdate').each(function(i){
            if(!$(this).val()){
                err = true;
                showMessage('请选择'+tips[i])
                return false;
            }
        });
        if(err){
            return ;
        }
        if(grid){
            grid.refresh();
        }else{
            grid = initGrid();
        }
    });

    function showMessage(message, isNormal, delay) {
        alert(message);
    }
})