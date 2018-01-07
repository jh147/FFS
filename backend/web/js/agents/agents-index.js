define(function (require, exports, module) { 
	require('/js/common/grid.js');

	$('#agent_grid').grid({
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

	$('#editAgent').click(function(){
		location.href = "/agents/edit/"
	});
})