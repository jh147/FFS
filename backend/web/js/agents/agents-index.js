define(function (require, exports, module) { 
    require('/js/common/grid.js');

    var agent_grid = $('#agent_grid').grid({
        url: '/agents/ajax-get-list',
        idField: 'id',
        templateid: 'agent_grid_template',
        pagesize: 20,
        scrollLoad: false,
        setEmptyText: function () {
            return '没有数据';
        },
        method: 'get',
        queryParams: function () {
            return 'start_station='+$.trim($('#start_station').val());
        }
    });

    $('#search').click(function(){
        agent_grid.refresh();
    });

    $('#agent_grid').on('click', '.edit', function(){
        location.href = "/agents/edit?id="+$(this).data('id');
    });
})