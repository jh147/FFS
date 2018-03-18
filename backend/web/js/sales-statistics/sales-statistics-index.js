define(function (require, exports, module) { 
    require('/js/common/grid.js');
    require('/js/common/select-box.js');
    require('/js/lib/laydate/laydate.dev.js');

    // var flightGrid, airlineGrid, agentGrid;
    var grid = null;
    var compareType = 'flight';

    function initGrid(id){
        return $('#sales_statistics_'+id+'_grid').grid({
            url: '/sales-compare/ajax-get-list',
            idField: 'id',
            templateid: id+'_grid_template',
            pagesize: 20,
            scrollLoad: false,
            setEmptyText: function () {
                return '没有数据';
            },
            method: 'get',
            queryParams: function () {
                return 'type='+compareType+'&'
                        +'this_start_date='+$.trim($('#this_start_date').val())+'&'
                        +'this_end_date='+$.trim($('#this_end_date').val())+'&'
                        +'last_start_date='+$.trim($('#last_start_date').val())+'&'
                        +'last_end_date='+$.trim($('#last_end_date').val());
            }
        });
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

    $('#statistics-type').selectBox({
        options: [
            {
                value: 'flight',
                id: 'flight_option',
                text: '航班号',
                selected: true
            },{
                value: 'airline',
                id: 'airline_option',
                text: '航线'
            },{
                value: 'agent',
                id: 'agent_option',
                text: '代理人'
            },{
                value: 'goods',
                id: 'goods_option',
                text: '货源'
            }
        ],
        change: function(option){
            // 
        }
    });

    $('#date'+id).click(function(){
        laydate({
            elem: '#'+id,
            format: 'YYYY-MM-DD',
            istime: true,
            isclear: true
        })
    });

    // 搜索
    $('#search').click(function(){
        if(!paramsValidate()){
            return showMessage('请填写完整的查询条件');
        }
        
    });

    
    

    var _uploadExcelInstance = null;

    function showMessage(message, isNormal, delay) {
        alert(message);
    }
})