define(function (require, exports, module) { 
    require('/js/common/lookup.js');
    
    //lookup
    $('#order').lookup({
        gridid: 'orders_grid',
        gridDataUrl: '/shipping-order/ajax-get-list',
        gridTemplateId: 'orders_grid_template',
        idField: 'id',
        valueField: 'order_num',
        searchInput: 'order_input',
        pagesize:5,
        queryParams: function () {
            var order_input = $('#order_input');
            var order_input_val = $.trim(order_input.val());
            return 'order_num='+encodeURIComponent(order_input_val);
        },
        onRowClick: function (model) {
            $.each(['flight_date', 'prefix', 'flight_num', 'freight_rates'], function(i, key){
                $('#'+key).val(model.get(key)||'');
            });
            calcFee();
        },
        onClear: function(){
            $.each(['flight_date', 'prefix', 'flight_num', 'freight_rates'], function(i, key){
                $('#'+key).val('');
            });
            $('#pg_loss_fee').val('0.00')
        }
    });

    function showMessage(msg){
        alert(msg);
    }

    function calcFee(){
        var freight_rates = $('#freight_rates').val(),
            pg_weight = $('#pg_weight').val(),
            prefix = $('#prefix').val(),
            fee = 0;
        
        if(freight_rates && pg_weight){
            fee = freight_rates * pg_weight;
        }

        if( prefix !== '000'){
            fee += pg_weight * 0.2;
        }
        $('#pg_loss_fee').val(fee.toFixed(2))
    }


    $('#pg_weight').on('input',function(e){
        var val = $(this).val(),
            hasErr = false;

        if( isNaN(val) || val < 0 || val > 1000000){
            // showMessage('重量必须大于0，小于 1,000,000 千克');
            hasErr = true;
        }

        if(hasErr){
            return e.preventDefault();
        }
        calcFee();
        
    });


    var saving = false;

    $('#save').click(function(){

        var data,
            hasErr = false;

        var pg_quantity = $('#pg_quantity').val(),
            pg_weight = $('#pg_weight').val(),
            pg_reason = $('#pg_reason').val(),
            pg_processing_method = $('#pg_processing_method').val() ,
            pg_remark = $('#pg_remark').val() ,
            pg_loss_fee = $('#pg_loss_fee').val();
        
        if(isNaN(pg_quantity) || pg_quantity < 0 || pg_quantity > 10000){
            showMessage('拉货件数必须大于0，小于10,000');
            hasErr = true;
        }else if(isNaN(pg_weight) || pg_weight < 0 || pg_weight > 1000000){
            showMessage('拉货重量必须大于0，小于1,000,000kg');
            hasErr = true; 
        }else if(!pg_reason){
            showMessage('请填写拉货原因');
            hasErr = true;
        }else if(!pg_processing_method){
            showMessage('请填写处理方式');
            hasErr = true;
        }

        if(hasErr || saving){
            return;
        }

        saving = true;
        data = {
            id: $('#order_id').val(),
            pg_quantity: pg_quantity,
            pg_weight: pg_weight,
            pg_reason: pg_reason,
            pg_processing_method: pg_processing_method,
            pg_remark: pg_remark,
            pg_loss_fee: pg_loss_fee
        };

        $.ajax({
            url: '/pg-order/save',
            data: data,
            method: 'post',
            success: function(res){
                if(res.code == 0){
                    location.href = "/pg-order/index/"
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