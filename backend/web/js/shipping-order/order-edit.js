define(function (require, exports, module) { 
    require('/js/common/lookup.js');
    //lookup
    $('#agent').lookup({
        gridid: 'agents_grid',
        gridDataUrl: '/agents/ajax-get-list/',
        gridTemplateId: 'agents_grid_template',
        idField: 'id',
        valueField: 'simple_code',
        searchInput: 'agent_input',
        pagesize:5,
        queryParams: function () {
            var search_input = $('#agent_input');
            var search_input_val = $.trim(search_input.val());
            return 'keywords='+encodeURIComponent(search_input_val);
        },
        onRowClick: function (model) {
            // simple_code
        }
    });

    //lookup
    $('#flight').lookup({
        gridid: 'flights_grid',
        gridDataUrl: '/flight/ajax-get-list/',
        gridTemplateId: 'flights_grid_template',
        idField: 'id',
        valueField: 'flight_num',
        searchInput: 'flight_input',
        pagesize:5,
        queryParams: function () {
            var search_input = $('#flight_input');
            var search_input_val = $.trim(search_input.val());
            return 'flight_num='+encodeURIComponent(search_input_val);
        },
        onRowClick: function (model) {
            // simple_code
            console.log(model);
        }
    });
});