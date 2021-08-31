$(document).ready(function () {
    table = $('#productTableList').DataTable({
        processing: true,
        serverSide: true,
        displayStart: $('#page').val(),
        "columnDefs": [
            {
                "targets": 0,
                "orderable": false
            }, {
                "targets": 7,
                "orderable": false
            },
        ],
        ajax: {
            url: base_url + "/admin/productList",
            type: "POST",
            complete: function () {
                $(".ti-trash").click(function () {
                    var delete_admin = $(this);
                    duDialog('Confirm', 'Are You Sure You Want To Remove This Vendor?', {
                        init: true,
                        dark: false,
                        buttons: duDialog.OK_CANCEL,
                        okText: 'Yes',
                        cancelText: 'No',
                        callbacks: {
                            okClick: function (e) {
                                this.hide()
                                $.ajax({
                                    url: base_url + '/admin/productDelete',
                                    type: 'post',
                                    data: 'deleteProduct=' + delete_admin.data("id"),
                                    success: function (result) {
                                        var Delete = $.parseJSON(result);
                                        if (Delete.status) {
                                            table.ajax.reload();
                                        }
                                    }
                                });
                            }
                        }
                    }).show()
                });
                $('#all').on('change', function () {
                    if ($(this).is(':checked')) {
                        $('.prosuctIds').prop('checked', true);
                    } else {
                        $('.prosuctIds').prop('checked', false);
                    }
                })
                $('.prosuctIds').on('change', function () {
                    var vendorList = $('.prosuctIds').length;
                    var i = 0;
                    $(".prosuctIds").each(function (index) {
                        if($(this).is(':checked')){
                            i++;
                        }
                    });
                    if(i == vendorList){
                        $('#all').prop('checked', true);
                    } else {
                        $('#all').prop('checked', false);
                    }
                })
            }
        },
    });
    var ids = [];
    $('#productBulk').on( 'change', function(){
        console.log('here');
        ids.length = 0;
        $('.prosuctIds:checked').each(function() {
            ids.push(this.value);
        });
        if(ids.length === 0){
            $('#errorReturn').addClass('text-danger').removeClass('text-success').html('Please Select Product.').show();
            return false;
        }
        if($(this).val() == 'delete'){
            duDialog('Confirm', 'Are You Sure You Want To Remove This Product?', {
                init: true,
                dark: false,
                buttons: duDialog.OK_CANCEL,
                okText: 'Yes',
                cancelText: 'No',
                callbacks: {
                    okClick: function (e) {
                        this.hide()
                        $.ajax({
                            url: base_url + '/admin/productDelete',
                            type: 'post',
                            data: 'deleteProduct=' + ids,
                            success: function (result) {
                                var Delete = $.parseJSON(result);
                                if (Delete.status) {
                                    table.ajax.reload();
                                }
                            }
                        });
                    }
                }
            }).show();
        } else {
            $.ajax({
                url: base_url + '/admin/ProductStatus',
                type: 'post',
                data: {
                    editProduct: ids,
                    status : $(this).val(),
                },
                success: function (result) {
                    var Edit = $.parseJSON(result);
                    if (Edit.status) {
                        table.ajax.reload();
                        $('#all').prop('checked', false);
                        $('#productBulk').prop('selectedIndex',0);
                    }
                }
            });
        }
    });
})