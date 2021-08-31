const isSuccess = false;
$(document).ready(function () {
    table = $('#StatusTable').DataTable({
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
            url: base_url + "/admin/LeadStatusList",
            type: "POST",
            complete: function () {
                $(".ti-marker-alt").click(function () {
                    $('#add_status').modal('show');
                    $('#status_label').text('Edit LeadStatus');
                    $.ajax({
                        url: base_url + "/admin/editStatus",
                        type: 'post',
                        data: "editId=" + $(this).data("id"),
                        success: function (result) {
                            var edit = $.parseJSON(result);

                            if (edit.status) {
                                $("#status_id").val(edit.data[0].status_id)
                                $("#status_name").val(edit.data[0].status_name);
                            } else {
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
                                    url: base_url + '/admin/StatusDelete',
                                    type: 'post',
                                    data: 'deleteStatus=' + delete_admin.data("id"),
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
                // $('#all').on('change', function () {
                //     if ($(this).is(':checked')) {
                //         $('.vendorIds').prop('checked', true);
                //     } else {
                //         $('.vendorIds').prop('checked', false);
                //     }
                // })
                // $('.vendorIds').on('change', function () {
                //     var vendorList = $('.vendorIds').length;
                //     var i = 0;
                //     $(".vendorIds").each(function (index) {
                //         if ($(this).is(':checked')) {
                //             i++;
                //         }
                //     });
                //     if (i == vendorList) {
                //         $('#all').prop('checked', true);
                //     } else {
                //         $('#all').prop('checked', false);
                //     }
                // })
            }
        },
    });
    // var ids = [];
    // $('#statusBulk').on('change', function () {
    //     ids.length = 0;
    //     $('.vendorIds:checked').each(function () {
    //         ids.push(this.value);
    //     });
    //     if (ids.length === 0) {
    //         $('#errorReturn').addClass('text-danger').removeClass('text-success').html('Please Select Leadsource.').show();
    //         return false;
    //     }
    //     if ($(this).val() == 'delete') {
    //         duDialog('Confirm', 'Are You Sure You Want To Remove This Status?', {
    //             init: true,
    //             dark: false,
    //             buttons: duDialog.OK_CANCEL,
    //             okText: 'Yes',
    //             cancelText: 'No',
    //             callbacks: {
    //                 okClick: function (e) {
    //                     this.hide()
    //                     $.ajax({
    //                         url: base_url + '/admin/StatusDelete',
    //                         type: 'post',
    //                         data: 'deleteStatus=' + ids,
    //                         success: function (result) {
    //                             let Delete = $.parseJSON(result);
    //                             if (Delete.status) {
    //                                 table.ajax.reload();
    //                             }
    //                         }
    //                     });
    //                 }
    //             }
    //         }).show();
    //     }
    // });



});


$('#add_status').on('hidden.bs.modal', function (e) {

    $('#add_status').find("input[type=text], textarea").val("");
    $('#add_status').find("input[type=hidden], textarea").val("");
    $('#status_label').text('Add Status');


})


$(function(){
    $("#status_add").validate({
        rules: {

            status_name: "required"
        },
        messages: {

            status_name: "Please enter some data"
        }
    })

    $("#subBtn").on("click", function(){
        if($("#status_add").valid()){
            //alert("success");
            let status_name = $("#status_name").val();
            let status_id = $("#status_id").val();

        
        
            $.ajax({
                url: base_url + '/admin/addStatus',
                type: 'post',
                data: { status_id:status_id,status_name: status_name},
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
                        $("#add_status").modal('hide');
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
                        $("#add_status").modal('hide');
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
