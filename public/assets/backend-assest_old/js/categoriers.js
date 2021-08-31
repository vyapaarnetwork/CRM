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
                "targets": 3,
                "orderable": false
            },
        ],
        ajax: {
            url: base_url + "/admin/CategoriersList",
            type: "POST",
            complete: function () {
                $(".ti-marker-alt").click(function() {
                    $('#Edit').iziModal('open');
                    $.ajax({
                        url: base_url + "/admin/editCategoriers",
                        type: 'post',
                        data: "editId=" + $(this).data("id"),
                        success: function(result) {
                            var edit = $.parseJSON(result);

                            if (edit.status) {
                                $("#id").val(edit.data[0].main_cat_id)
                                $("#cat_name").val(edit.data[0].cat_name);
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
                                    url: base_url + '/admin/CategoriersDelete',
                                    type: 'post',
                                    data: 'deleteCategoriers=' + delete_admin.data("id"),
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
    $('#categoriersBulk').on( 'change', function(){
        ids.length = 0;
        $('.vendorIds:checked').each(function() {
            ids.push(this.value);
        });
        if(ids.length === 0){
            $('#errorReturn').addClass('text-danger').removeClass('text-success').html('Please Select categoriers.').show();
            return false;
        }
        if($(this).val() == 'delete'){
            duDialog('Confirm', 'Are You Sure You Want To Remove This categoriers?', {
                init: true,
                dark: false,
                buttons: duDialog.OK_CANCEL,
                okText: 'Yes',
                cancelText: 'No',
                callbacks: {
                    okClick: function (e) {
                        this.hide()
                        $.ajax({
                            url: base_url + '/admin/categoriersDelete',
                            type: 'post',
                            data: 'deleteCategoriers=' + ids,
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
        }
    });
   


});

$('#Edit').iziModal({
    title: 'Add Admin',
    width: 900,
    headerColor: '#007bff',
});
$('#addCategoriers').click(function() {
    $('#Edit').iziModal('open');
});
    $("#addCategorie").submit(function(){

    var cat_name = $("#cat_name").val();
    var id = $("#id").val();


    $.ajax({
        url: base_url + '/admin/addcategoriers',
        type: 'post',
        data : {main_cat_id: id,cat_name: cat_name},
 
    });


  });
