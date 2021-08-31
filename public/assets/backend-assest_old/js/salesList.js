var isSuccess = false;
$(document).ready(function () {
    table = $('#salesTableList').DataTable({
        processing: true,
        serverSide: true,
        displayStart: $('#page').val(),
        "columnDefs": [
            {
                "targets": 0,
                "orderable": false
            }, {
                "targets": 6,
                "orderable": false
            },
        ],
        ajax: {
            url: base_url + "/admin/salesList",
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
                                    url: base_url + '/admin/salesDelete',
                                    type: 'post',
                                    data: 'deleteAdmin=' + delete_admin.data("id"),
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
                        $('.salesIds').prop('checked', true);
                    } else {
                        $('.salesIds').prop('checked', false);
                    }
                })
                $('.salesIds').on('change', function () {
                    var vendorList = $('.salesIds').length;
                    var i = 0;
                    $(".salesIds").each(function (index) {
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
    $('#vendorBulk').on( 'change', function(){
        ids.length = 0;
        $('.salesIds:checked').each(function() {
            ids.push(this.value);
        });
        if(ids.length === 0){
            $('#errorReturn').addClass('text-danger').removeClass('text-success').html('Please Select Vendor.').show();
            return false;
        }
        if($(this).val() == 'delete'){
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
                            url: base_url + '/admin/salesDelete',
                            type: 'post',
                            data: 'deleteSales=' + ids,
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
                url: base_url + '/admin/salesStatus',
                type: 'post',
                data: {
                    editSales: ids,
                    status : $(this).val(),
                },
                success: function (result) {
                    var Edit = $.parseJSON(result);
                    if (Edit.status) {
                        table.ajax.reload();
                        $('#all').prop('checked', false);
                        $('#vendorBulk').prop('selectedIndex',0);
                    }
                }
            });
        }
    });
});