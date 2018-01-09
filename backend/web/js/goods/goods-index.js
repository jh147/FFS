define(function (require, exports, module) { 
    require('/js/common/grid.js');
    require('/js/lib/plupload/plupload.full.min.js'); //用于导入文件
    $.getScript("/js/lib/plupload/i18n/zh_CN.js"); //中文提示包

    var goods_grid = $('#goods_grid').grid({
        url: '/goods/ajax-get-list',
        idField: 'id',
        templateid: 'goods_grid_template',
        pagesize: 20,
        scrollLoad: false,
        setEmptyText: function () {
            return '没有数据';
        },
        method: 'get',
        queryParams: function () {
            return 'flight_station='+$.trim($('#start_station').val())
                    +'&freight_rates_code='+$.trim($('#freight_rates_code').val())
                    +'&product_name='+$.trim($('#product_name').val());
        }
    });

    // 搜索
    $('#search').click(function(){
        goods_grid.refresh();
    });

    // 编辑
    $('#goods_grid').on('click', '.edit', function(){
        location.href = "/goods/edit?id="+$(this).data('id');
    });

    // 删除
    $('#goods_grid').on('click', '.btn-del', function(){
        if(!confirm('确定要删除该代理人信息吗？')){
            return;
        }

        $.ajax({
            url: '/goods/delete',
            data: {
                id: $(this).data('id')
            },
            method: 'post',
            success: function(res){
                if(res.code == 0){
                    goods_grid.refresh();
                }else{
                    alert(res.msg || '删除失败')
                }
            }
        })
        
    });

    var _uploadExcelInstance = null;

    function showMessage(message, isNormal, delay) {
        alert(message);

        /*$.topTips({
            mode: isNormal ? 'normal' : 'warning',
            tip_text: message,
            delay: delay
        });*/
    }

    // 导入
    function importExcel(browseButtonId, url, beforeUpload, callback) {
        if (_uploadExcelInstance) {
            _uploadExcelInstance.destroy();
        }
        _uploadExcelInstance = new plupload.Uploader({
            runtimes: 'html5,flash,silverlight,html4',
            browse_button: browseButtonId,
            multi_selection: false,
            url: url,
            flash_swf_url: '../../frontend/components/plupload/Moxie.swf',
            silverlight_xap_url: '../../frontend/components/plupload/Moxie.xap',
            filters: {
                mime_types: [{
                    title: 'Excel文件',
                    extensions: 'xlsx'
                }],
                max_file_size: '10mb'
            },
            init: {
                // 获取开始上传的时刻
                UploadFile: function(uploader, files) {
                    // console.log('开始上传！');
                },
                FilesAdded: function(up, files) {
                    // $.topLoading.show('正在导入，请稍后');
                    (!beforeUpload ? true : beforeUpload()) && _uploadExcelInstance.start();
                },
                FileUploaded: function(up, file, info) {
                    var data = JSON.parse(info.response) || {};
                    if (data.code == 0) {
                        showMessage('上传成功！');
                        goods_grid.refresh();
                    } else {
                        showMessage('上传失败！\r\n' + data.detail.join('\r\n'), false, 4000);
                    }
                },
                Error: function(up, err) {
                    // $.topLoading.hide();
                    err.message = plupload.FILE_SIZE_ERROR == err.code ? '只允许上传10mb以下文件' : err.message;
                    showMessage(err.message, false, 6000);
                }
            }
        });
        _uploadExcelInstance.init();
    }

    importExcel('import_goods_btn', '/goods/import', null, function() {
        if (goods_grid) {
            goods_grid.refresh();
        }
    })
})