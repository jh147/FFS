define(function (require, exports, module) { 
    require('/js/common/lookup.js');
    require('/js/lib/laydate/laydate.dev.js');
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
            $.each(['start_station','destination_station'], function(i, key){
                $('#'+key).val(model.get(key)||'');
            });
            
        },
        onClear: function(){
            $.each(['start_station','destination_station'], function(i, key){
                $('#'+key).val('');
            });
        }
    });

    //lookup
    $('#freight_rates_code').lookup({
        gridid: 'goods_grid',
        gridDataUrl: '/goods/ajax-get-list/',
        gridTemplateId: 'goods_grid_template',
        idField: 'id',
        valueField: 'freight_rates_code',
        searchInput: 'freight_rates_code_input',
        pagesize:5,
        queryParams: function () {
            var search_input = $('#freight_rates_code_input');
            var search_input_val = $.trim(search_input.val());
            return 'freight_rates_code='+encodeURIComponent(search_input_val);
        },
        onRowClick: function (model) {
            $('#product_name').val(model.get('product_name')||'');
        },
        onClear: function(){
            $('#product_name').val('');
        }
    });


    $('#flight_date').click(function(){
        laydate({
            elem: '#flight_date',
            format: 'YYYY-MM-DD',
            istime: true,
            isclear: true
        })
    });

    var today = new Date(),
        yesteday = new Date(today - 24*3600*1000);
    console.log(yesteday);

});