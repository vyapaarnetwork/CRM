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
            url: base_url + "/admin/categoriesList",
            type: "POST",
            complete: function () {
                $(".ti-marker-alt").click(function () {
                    $('#add_categories').modal('show');
                    $('#cat_label').text('Edit Categories');
                    $.ajax({
                        url: base_url + "/admin/editcategories",
                        type: 'post',
                        data: "editId=" + $(this).data("id"),
                        success: function (result) {
                            var edit = $.parseJSON(result);

                            if (edit.status) {
                                $("#main_cat_id").val(edit.data[0].main_cat_id)
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
                                    url: base_url + '/admin/categoriesDelete',
                                    type: 'post',
                                    data: 'deletecategories=' + delete_admin.data("id"),
                                    success: function (result) {
                                        var Delete = $.parseJSON(result);
                                        if (Delete.status) {
                                            $.toast({
                                                heading: Delete.message,
                                                position: 'top-right',
                                                loaderBg: '#ff6849',
                                                icon: 'error',
                                                hideAfter: 3500,
                                                stack: 6
                                            });
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
    $('#categoriesBulk').on('change', function () {
        ids.length = 0;
        $('.vendorIds:checked').each(function () {
            ids.push(this.value);
        });
        if (ids.length === 0) {
            $('#errorReturn').addClass('text-danger').removeClass('text-success').html('Please Select categories.').show();
            return false;
        }
        if ($(this).val() == 'delete') {
            duDialog('Confirm', 'Are You Sure You Want To Remove This categories?', {
                init: true,
                dark: false,
                buttons: duDialog.OK_CANCEL,
                okText: 'Yes',
                cancelText: 'No',
                callbacks: {
                    okClick: function (e) {
                        this.hide()
                        $.ajax({
                            url: base_url + '/admin/categoriesDelete',
                            type: 'post',
                            data: 'deletecategories=' + ids,
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


$('#add_categories').on('hidden.bs.modal', function (e) {

    $('#add_cat').find("input[type=text], textarea").val("");
    $('#add_cat').find("input[type=hidden], textarea").val("");
    $('#cat_label').text('Add categories');


})


$(function(){
    $("#add_cat").validate({
        rules: {
           
            cat_name: "required"
        },
        messages: {
               
            cat_name: "Please enter some data"
        }
    })

    $("#subBtn").on("click", function(){
        if($("#add_cat").valid()){
            //alert("success");
            var cat_name = $("#cat_name").val();
            var main_cat_id = $("#main_cat_id").val();
        
        
            $.ajax({
                url: base_url + '/admin/addcategories',
                type: 'post',
                data: { main_cat_id: main_cat_id, cat_name: cat_name },
                success: function (result) {
                    var Success = $.parseJSON(result);
                    if (Success.status == true) {
                        $.toast({
                            heading: Success.message,
                            position: 'top-right',
                            loaderBg: '#ff6849',
                            icon: 'success',
                            hideAfter: 3500,
                            stack: 6
                        });
                        table.ajax.reload();
                        $("#add_categories").modal('hide');
                    } else {
                        $.toast({
                            heading: Success.message,
                            position: 'top-right',
                            loaderBg: '#ff6849',
                            icon: 'error',
                            hideAfter: 3500,
                            stack: 6
                        });
                        table.ajax.reload();
                        $("#add_categories").modal('hide');
                    }
                }
        
            });

        } else {
            //alert("Values are not entered");
            //whatever you want to do when values are not entered
        }
        return false;
    });
})
