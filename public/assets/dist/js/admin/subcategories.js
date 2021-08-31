var isSuccess = false;
$(document).ready(function () {
    table = $('#adminTableList').DataTable({
        processing: false,
        serverSide: true,
        displayStart: $('#page').val(),
        "columnDefs": [
            {
                "targets": 0,
                "orderable": false
            }, {
                "targets": 4,
                "orderable": false
            },
        ],
        ajax: {
            url: base_url + "/admin/SubcategoriesList",
            type: "POST",
            complete: function () {
                $(".ti-marker-alt").click(function() {
                    $('#add_subcategories').modal('show');
                    $('#subcat_label').text('Edit Subcategories');

                    $.ajax({
                        url: base_url + "/admin/editSubcategories",
                        type: 'post',
                        data: "editId=" + $(this).data("id"),
                        
                        success: function(result) {
                            var edit = $.parseJSON(result);

                            if (edit.status) {
                                $("#sub_id").val(edit.data[0].sub_id)
                                $("#sub_cat_name").val(edit.data[0].sub_cat_name);
                                $("#main_cat_id").val(edit.data[0].main_cat_name);


                            }
                         else {
                            $("#errorReturn").show().text(edit.message);
                        }
                        }
                    })

                })


                $(".ti-trash").click(function () {
                    var delete_admin = $(this);
                    duDialog('Confirm', 'Are You Sure You Want To Remove This Sub-Categories?', {
                        init: true,
                        dark: false,
                        buttons: duDialog.OK_CANCEL,
                        okText: 'Yes',
                        cancelText: 'No',
                        callbacks: {
                            okClick: function (e) {
                                this.hide()
                                $.ajax({
                                    url: base_url + '/admin/SubcategoriesDelete',
                                    type: 'post',
                                    data: 'deleteSubcategories=' + delete_admin.data("id"),
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
    $('#categoriesBulk').on( 'change', function(){
        ids.length = 0;
        $('.vendorIds:checked').each(function() {
            ids.push(this.value);
        });
        if(ids.length === 0){
            $('#errorReturn').addClass('text-danger').removeClass('text-success').html('Please Select categories.').show();
            return false;
        }
        if($(this).val() == 'delete'){
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
                            url: base_url + '/admin/SubcategoriesDelete',
                            type: 'post',
                            data: 'deleteSubcategories=' + ids,
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
            }).show();
        }
    });
   


});

$('#add_subcategories').on('hidden.bs.modal', function (e) {

    $('#add_subcat').find("input[type=text], textarea").val("");
    $('#add_subcat').find("input[type=hidden], textarea").val("");
    $('#subcat_label').text('Add Sub categories');


})


$(function(){
    $("#add_subcat").validate({
        rules: {
           
            cat_name: "required"
        },
        messages: {
               
            cat_name: "Please enter some data"
        }
    })

    $("#subBtn").on("click", function(){
        if($("#add_subcat").valid()){
            //alert("success");
            var main_cat_id = $("#main_cat_id").val();
            var sub_id = $("#sub_id").val();
            var sub_cat_name = $("#sub_cat_name").val();
            
        
        
            $.ajax({
                url: base_url + '/admin/addSubcategories',
                type: 'post',
                data: { main_cat_name: main_cat_id,sub_id:sub_id, sub_cat_name: sub_cat_name },
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
                        $("#add_subcategories").modal('hide');
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
                        $("#add_subcategories").modal('hide');
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
