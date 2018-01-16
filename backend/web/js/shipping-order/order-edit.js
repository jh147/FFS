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

    if(!$('#order_id').val()){
        var today = new Date(),
        yesteday = new Date(today - 24*3600*1000),
        ytd = yesteday.getFullYear() + '-' + ('0'+(yesteday.getMonth() + 1)).slice(-2) + '-' + ('0'+(yesteday.getDate() + '')).slice(-2);

        $('#flight_date').val(ytd);
    }
    

    function showMessage(msg){
        alert(msg);
    }

    $('#billing_weight, #prefix').on('input',function(){
        var billing_weight = $('#billing_weight').val(),
            prefix = $('#prefix').val(),
            oilFee = 0,
            hasErr = false;

        if( isNaN(billing_weight) || billing_weight < 0 || billing_weight > 1000000){
            // showMessage('计费重量必须大于0，小于 1,000,000 千克');
            hasErr = true;
        }

        if( prefix !== '000'){
            oilFee = 0.2;
        }

        if(!hasErr){
            $('#fuel_fee').val( (billing_weight*oilFee).toFixed(2) );
            $('#freight_total_fee').val((+$('#freight_fee').val() + billing_weight*oilFee).toFixed(2))
        }else{
            $('#fuel_fee').val('0.00');
        }
    });

    $('#billing_weight, #freight_rates').on('input',function(){
        var billing_weight = $('#billing_weight').val(),
            freight_rates = $('#freight_rates').val(),
            hasErr = false;

        if( isNaN(billing_weight) || billing_weight < 0 || billing_weight > 1000000){
            // showMessage('计费重量必须大于0，小于 1,000,000 千克');
            hasErr = true;
        }else if(isNaN(freight_rates) || freight_rates < 0 || freight_rates > 1000){
            // showMessage('费率（净运价）必须大于0，小于 1,000 千克/元');
            hasErr = true;
        }

        if(!hasErr){
            $('#freight_fee').val( (billing_weight*freight_rates).toFixed(2) );
            $('#freight_total_fee').val((+$('#fuel_fee').val() + billing_weight*freight_rates).toFixed(2))
        }else{
            $('#freight_fee').val('0.00');
        }
    });


    var saving = false;

    $('#save').click(function(){

        var data,
            hasErr = false;

        var prefix = $('#prefix').val(),
            agent_input = $('#agent_input').val(),
            flight_input = $('#flight_input').val() ,
            order_num = $('#order_num').val(),
            freight_rates_code_input = $('#freight_rates_code_input').val(),
            actual_weight = $('#actual_weight').val(),
            quantity = $('#quantity').val(),
            billing_weight = $('#billing_weight').val(),
            freight_rates = $('#freight_rates').val();
        
        if(!agent_input){
            showMessage('请选择代理人');
            hasErr = true;
        }else if(!/^[0-9]{3}$/.test(prefix)){
            showMessage('前缀必须是3位数字');
            hasErr = true; 
        }else if(!/^[0-9]{8}$/.test(order_num)){
            showMessage('运单号为八位数字');
            hasErr = true;
        }else if(!flight_input){
            showMessage('请选择航班');
            hasErr = true;
        }else if(!freight_rates_code_input){
            showMessage('请填写运价代码');
            hasErr = true;
        }else if( isNaN(actual_weight) || actual_weight < 0 || actual_weight > 1000000){
            showMessage('实际重量必须大于0，小于 1,000,000 千克');
            hasErr = true;
        }else if( isNaN(quantity) || quantity < 0 || quantity > 10000){
            showMessage('实际重量必须大于0，小于 10,000');
            hasErr = true;
        }else if( isNaN(billing_weight) || billing_weight < 0 || billing_weight > 1000000){
            showMessage('计费重量必须大于0，小于 1,000,000 千克');
            hasErr = true;
        }else if(isNaN(freight_rates) || freight_rates < 0 || freight_rates > 1000){
            showMessage('费率（净运价）必须大于0，小于 1,000 千克/元');
            hasErr = true;
        }


        if(hasErr || saving){
            return;
        }

        saving = true;
        data = {
            id: $('#order_id').val(),
            flight_date: $('#flight_date').val(),
            prefix: prefix,
            // agent_id: $('#agent_input_id').val(),
            simple_code: agent_input,
            flight_num: flight_input,
            // flight_id: $('#flight_input_id').val(),
            start_station: $('#start_station').val(),
            stopover_station: $('#stopover_station').val(),
            destination_station: $('#destination_station').val(),
            order_num: order_num,
            freight_rates_code: freight_rates_code_input,
            product_name: $('#product_name').val(),
            actual_weight: actual_weight,
            quantity: quantity,
            billing_weight: billing_weight,
            freight_rates: freight_rates,
            freight_fee: $('#freight_fee').val(),
            fuel_fee: $('#fuel_fee').val(),
            freight_total_fee: $('#freight_total_fee').val()
        };

        $.ajax({
            url: '/shipping-order/save',
            data: data,
            method: 'post',
            success: function(res){
                if(res.code == 0){
                    // location.href = "/agents/index/"
                }else{
                    showMessage(res.msg || '保存失败');
                }
            },
            complete: function(){
                saving = false;
            }
        });
        
    });
});