define(function (require, exports, module) { 
    require('/js/common/grid.js');
    require('/js/lib/laydate/laydate.dev.js');

    var grid = null;

    function initGrid(){
        return $('#grid').grid({
            url: '/goods-statistics/ajax-get-list',
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
        var tips = ['本期开始时间','本期结束时间','同比开始时间','同比结束时间','环比开始时间','环比结束时间']
        
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

    var _uploadExcelInstance = null;

    function showMessage(message, isNormal, delay) {
        alert(message);
    }
})