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
            url: base_url + "/admin/LeadSourceList",
            type: "POST",
            complete: function () {
                $(".ti-marker-alt").click(function () {
                    $('#add_leadsource').modal('show');
                    $('#leadsource_label').text('Edit Leadsource');
                    $.ajax({
                        url: base_url + "/admin/editleadsource",
                        type: 'post',
                        data: "editId=" + $(this).data("id"),
                        success: function (result) {
                            var edit = $.parseJSON(result);

                            if (edit.status) {
                                $("#lead_source_id").val(edit.data[0].lead_source_id)
                                $("#lead_source_name").val(edit.data[0].lead_source_name);
                            }
                            else {
                                $("#errorReturn").show().text(edit.message);
                            }
                        }
                    })

                })


                $(".ti-trash").click(function () {
                    var delete_admin = $(this);
                    duDialog('Confirm', 'Are You Sure You Want To Remove This LeadSource?', {
                        init: true,
                        dark: false,
                        buttons: duDialog.OK_CANCEL,
                        okText: 'Yes',
                        cancelText: 'No',
                        callbacks: {
                            okClick: function (e) {
                                this.hide()
                                $.ajax({
                                    url: base_url + '/admin/leadsourceDelete',
                                    type: 'post',
                                    data: 'deleteLeadsource=' + delete_admin.data("id"),
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
            $('#errorReturn').addClass('text-danger').removeClass('text-success').html('Please Select Leadsource.').show();
            return false;
        }
        if ($(this).val() == 'delete') {
            duDialog('Confirm', 'Are You Sure You Want To Remove This leadsource?', {
                init: true,
                dark: false,
                buttons: duDialog.OK_CANCEL,
                okText: 'Yes',
                cancelText: 'No',
                callbacks: {
                    okClick: function (e) {
                        this.hide()
                        $.ajax({
                            url: base_url + '/admin/leadsourceDelete',
                            type: 'post',
                            data: 'deleteLeadsource=' + ids,
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


$('#add_leadsource').on('hidden.bs.modal', function (e) {

    $('#add_leadsource').find("input[type=text], textarea").val("");
    $('#add_leadsource').find("input[type=hidden], textarea").val("");
    $('#leadsource_label').text('Add Leadsource');


})


$(function(){
    $("#leadsource_add").validate({
        rules: {
           
            lead_source_name: "required"
        },
        messages: {
               
            lead_source_name: "Please enter some data"
        }
    })

    $("#subBtn").on("click", function(){
        if($("#leadsource_add").valid()){
            //alert("success");
            var lead_source_name = $("#lead_source_name").val();
            var lead_source_id = $("#lead_source_id").val();

        
        
            $.ajax({
                url: base_url + '/admin/addleadsource',
                type: 'post',
                data: { lead_source_id:lead_source_id,lead_source_name: lead_source_name},
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
                        $("#add_leadsource").modal('hide');
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
                        $("#add_leadsource").modal('hide');
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
