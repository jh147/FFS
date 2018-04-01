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
                var queryParams = 'start_date='+$.trim($('#start_date').val())+'&'
                        +'end_date='+$.trim($('#end_date').val());
                $('.selected').each(function(){
                    queryParams += '&'+$(this).find('.form-checkbox-input').attr('id')+'=1'
                });
                console.log(queryParams);
                return queryParams;
            },
            loaded: function(){
                $('.form-checkbox').each(function(){
                    if($(this).hasClass('selected')){
                        $('.'+$(this).find('.form-checkbox-input').attr('id')).show();
                    }else{
                        $('.'+$(this).find('.form-checkbox-input').attr('id')).hide();
                    }
                    
                });
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

    $('.form-checkbox').click(function(){
        $(this).toggleClass('selected');
        $('#search').trigger('click');
    });

    function showMessage(message, isNormal, delay) {
        alert(message);
    }
})