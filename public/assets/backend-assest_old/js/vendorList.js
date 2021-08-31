var isSuccess = false;
$(document).ready(function () {
    table = $('#adminTableList').DataTable({
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
            url: base_url + "/admin/vendorList",
            type: "POST",
            complete: function () {
                $(".ti-marker-alt").click(function() {
                    $('#Edit').iziModal('open');

                    $.ajax({
                        url: base_url + "/admin/editVendor",
                        type: 'post',
                        data: "editId=" + $(this).data("id"),
                        
                        success: function(result) {
                            var edit = $.parseJSON(result);

                            if (edit.status) {
                                $("#sub_id").val(edit.data[0].sub_id)
                                $("#sub_cat_name").val(edit.data[0].sub_cat_name);
                                $("#main_cat_id").val(edit.data[0].main_cat_id);


                            }
                         else {
                            $("#errorReturn").show().text(edit.message);
                        }
                        }
                    })

                })
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
                                    url: base_url + '/admin/VendorDelete',
                                    type: 'post',
                                    data: 'deleteVendor=' + delete_admin.data("id"),
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
                        $('.vendorIds').prop('checked', true);
                    } else {
                        $('.vendorIds').prop('checked', false);
                    }
                })
                $('.vendorIds').on('change', function () {
                    var vendorList = $('.vendorIds').length;
                    var i = 0;
                    $(".vendorIds").each(function (index) {
                        if ($(this).is(':checked')) {
                            i++;
                        }
                    });
                    if (i == vendorList) {
                        $('#all').prop('checked', true);
                    } else {
                        $('#all').prop('checked', false);
                    }
                })
            }
        },
    });
    var ids = [];
    $('#vendorBulk').on('change', function () {
        ids.length = 0;
        $('.vendorIds:checked').each(function () {
            ids.push(this.value);
        });
        if (ids.length === 0) {
            $('#errorReturn').addClass('text-danger').removeClass('text-success').html('Please Select Vendor.').show();
            return false;
        }
        if ($(this).val() == 'delete') {
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
                            url: base_url + '/admin/VendorDelete',
                            type: 'post',
                            data: 'deleteVendor=' + ids,
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
                url: base_url + '/admin/vendorStatus',
                type: 'post',
                data: {
                    editVendor: ids,
                    status: $(this).val(),
                },
                success: function (result) {
                    var Edit = $.parseJSON(result);
                    if (Edit.status) {
                        table.ajax.reload();
                        $('#all').prop('checked', false);
                        $('#vendorBulk').prop('selectedIndex', 0);
                    }
                }
            });
        }
    });
});

$('#Edit').iziModal({
    title: 'Add Vendor',
    width: 900,
    headerColor: '#007bff',
});
$('#addVendor').click(function() {
    $('#Edit').iziModal('open');
});
    $("#addVendors").submit(function(){

    var main_cat_id = $("#main_cat_id").val();
    var sub_cat_name = $("#sub_cat_name").val();
    var id = $("#sub_id").val();


    $.ajax({
        url: base_url + '/admin/addSubCategoriers',
        type: 'post',
        data : {sub_id: id,main_cat_id: main_cat_id,sub_cat_name:sub_cat_name},
 
    });

  });
  $(document).on('closing', '#Edit', function(e) {
    $("#noteMsg").hide()
    $("#main_cat_id").val("")
    $("#sub_cat_name").val("")
    $("#sub_id").val("")
    $('#Edit').iziModal('close');

});
