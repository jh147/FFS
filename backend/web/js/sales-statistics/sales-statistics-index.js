define(function (require, exports, module) { 
    require('/js/common/grid.js');
    require('/js/common/select-box.js');
    require('/js/lib/laydate/laydate.dev.js');

    // var flightGrid, airlineGrid, agentGrid;
    var grid = null;
    var compareType = 'flight';

    function initGrid(){
        return $('#grid').grid({
            url: '/sales-statistics/ajax-get-list',
            idField: 'id',
            templateid: 'grid_template',
            pagesize: 20,
            scrollLoad: false,
            setEmptyText: function () {
                return '没有数据';
            },
            method: 'get',
            queryParams: function () {
                return 'type='+compareType+'&'
                        +'date='+$.trim($('#date').val());
            },
            beforeRender: function(){
                
            }
        });
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

    $('#date').click(function(){
        laydate({
            elem: '#date',
            format: 'YYYY-MM-DD',
            istime: true,
            isclear: true
        })
    });

    // 搜索
    $('#search').click(function(){
        if(grid){
            grid.refresh();
        }else{
            grid = initGrid();
        }
    });


    var _uploadExcelInstance = null;

    function showMessage(message, isNormal, delay) {
        alert(message);
    }
})