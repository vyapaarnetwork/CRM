var isSuccess = false;
$(document).ready(function() {
       table = $('#adminTableList').DataTable({
        processing: true,
        serverSide: true,
        displayStart: $('#page').val(),
        "columnDefs": [
            {
                "targets": 0,
                "orderable": false
            }, {
                "targets":6,
                "orderable": false
            },
        ],
        ajax: {
            url: base_url + "/admin/vendorList",
            type: "POST",
            complete: function() {
                $(".ti-marker-alt").click(function() {
                    $('#add_vendor').modal('show');
                    $('#admin_label').text('Edit Admin');
                    $.ajax({
                        url: base_url + "/admin/editVendor",
                        type: 'post',
                        data: "editId=" + $(this).data("id"),
                        success: function(result) {
                            var edit = $.parseJSON(result);
                            if (edit.status) {
                                $("#vendor_id").val(edit.data[0].vendor_id)
                                $("#fName").val(edit.data[0].vendor_name[0]);
                                $("#lName").val(edit.data[0].vendor_name[1]);
                                $("#uName").val(edit.data[0].vendor_username);
                                $("#email").val(edit.data[0].vendor_email);
                                $("#mobileNo").val(edit.data[0].vendor_phone);
                                $("#vendor_status").val(edit.data[0].vendor_status);
                                $("#noteMsg").show()
                                
                                $("#password").addClass('ignore')
                                $("#cpassword").addClass("ignore")
                                
                                $("#mobileNo").addClass("ignore")

                                $("#uName").addClass("ignore").attr('disabled', 'disabled')
                                $("#email").addClass("ignore").attr('disabled', 'disabled')

                            } else {
                                $("#errorReturn").show().text(edit.message);
                            }
                        }
                    })
                })
                $(".ti-trash").click(function() {
                    var delete_admin = $(this);
                    duDialog('Confirm', 'Are You Sure You Want To Remove This Data?', {
                        init: true,
                        dark: false,
                        buttons: duDialog.OK_CANCEL,
                        okText: 'Yes',
                        cancelText: 'No',
                        callbacks: {
                            okClick: function(e) {
                                this.hide()
                                $.ajax({
                                    url: base_url + '/admin/VendorDelete',
                                    type: 'post',
                                    data: 'deleteVendor=' + delete_admin.data("id"),
                                    success: function(result) {
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
            }
        },
    });

    $('#first_level').multiselect({
        enableFiltering: true,
        includeSelectAllOption: false,
        maxHeight: 500,
        dropDown: true,
        onChange:function(option, checked){
            $('#second_level').html('');
            $('#second_level').multiselect('rebuild');
            let selected = this.$select.val();
            let vendor = $("#vendor_m_id").val();
            if(selected.length > 0)
            {
             $.ajax({
                url: base_url + '/admin/getSubcategories',
                method:"POST",
                data:{selected:selected,vendor:vendor},
                success:function(data)
              {
               $('#second_level').html(data);
               $('#second_level').multiselect('rebuild');
              }
             })
            }
           }
          });



    $('#add_vendor').on('hidden.bs.modal', function (e) {

        $('#adminData').find("input[type=text], textarea").val("");
        $('#adminData').find("input[type=hidden], textarea").val("");
        $('#adminData').find("input[type=email], textarea").val("");
        $('#adminData').find("input[type=number], textarea").val("");
        $('#adminData').find("select, textarea").val("");

        $("#email").prop("disabled", false).removeClass('ignore');
        $("#mobileNo").removeClass('ignore');
        $("#password").removeClass('ignore');
        $("#noteMsg").hide()

        $("#cpassword").removeClass('ignore');


        $("#uName").prop("disabled", false).removeClass('ignore');
        removeError();
        $('#admin_label').text('Add Admin');
    
    
    })
    $.validator.addMethod("uniqueUser",
        function(value, element) {
            if (value) {
                $.ajax({
                    url: base_url + '/admin/vendorUserName' + ($("#vendor_id").val() ? '/' + $('#vendor_id').val() : ''),
                    type: 'post',
                    data: 'val=' + value,
                    success: function(result) {
                        var response = $.parseJSON(result)
                        isSuccess = response.status;
                    }
                });
                return this.optional(element) || isSuccess;
            }
        },
        "UserName Already Taken."
    );
    $.validator.addMethod("uniqueEmail",
        function(value, element) {
            if (value) {
                $.ajax({
                    url: base_url + '/admin/vendorEmail' + ($("#vendor_id").val() ? '/' + $('#vendor_id').val() : ''),
                    type: 'post',
                    data: 'val=' + value,
                    success: function(result) {
                        var email = $.parseJSON(result);
                        isSuccess = email.status;
                    }
                });
            }
            return this.optional(element) || isSuccess;
        },
        "Email Already Exists."
    );
    $.validator.addMethod("uniqueMobile",
        function(value, element) {
            if (value) {
                $.ajax({
                    url: base_url + '/admin/vendorphoneNo' + ($("#vendor_id").val() ? '/' + $('#vendor_id').val() : ''),
                    type: 'post',
                    data: 'val=' + value,
                    success: function(result) {
                        var mobileNo = $.parseJSON(result);
                        isSuccess = mobileNo.status
                    }
                });
            }
            return this.optional(element) || isSuccess;
        },
        "Mobile Number Already Exists."
    );
    $("#vendorData").validate({ 
        errorElement: "small",
        errorClass: "text-danger",
        ignore: '.ignore',
        rules: {
            fName: "required",
            lName: "required",
            uName: {
                required: true,
                uniqueUser: true,
            },
            email: {
                required: true,
                email: true,
                uniqueEmail: true
            },
            mobileNo: {
                required: true,
                number: true,
                rangelength: [10, 13],
                uniqueMobile: true
            },
            type: {
                required: true
            },
            password: {
                required: true,
                minlength: 8
            },
            cpassword: {
                required: true,
                minlength: 8,
                equalTo: "#password"
            },
        },
        messages: {
            fName: "First Name Is Required.",
            lName: "Last Name Is Required.",
            uName: {
                required: "User Name Is Required.",
            },
            email: {
                required: "Email Is Required.",
                email: "Email Is Not Valid.",
            },
            mobileNo: {
                required: "Mobile Number Is Required.",
                number: "You Can Enter Only Numbers.",
                step: "Maximum 13 Numbers allow.",
            },
            type: {
                required: "Please Select Any Other Admin Type Not Select."
            },
            password: {
                required: "Password Can Not Be Empty.",
                minlength: "Password Must Be At Least 8 Characters."
            },
            cpassword: {
                required: "Confirm Password Can Not Be Empty.",
                minlength: "Confirm Password Must Be At Least 8 Characters.",
                equalTo: "Enter Confirm Password Same As Password."
            }
        },
        highlight: function(element) {
            $(element).addClass("is-invalid").removeClass('is-valid');
        },
        unhighlight: function(element) {
            $(element).addClass("is-valid").removeClass("is-invalid");
        },
        submitHandler: function(form) {
            $.ajax({
                url: base_url + '/admin/addvendor' + ($("#vendor_id").val() ? '/' + $('#vendor_id').val() : ''),
                type: 'post',
                data: {
                    id: $("#vendor_id").val(),
                    vendor_name: $("#fName").val() + " " + $("#lName").val(),
                    vendor_username: $("#uName").val(),
                    vendor_email: $("#email").val(),
                    vendor_phone: $("#mobileNo").val(),
                    vendor_password: $("#password").val(),
                    vendor_status:$("#vendor_status").val()
                },
                success: function(result) {
                    var response = $.parseJSON(result);
                    console.log(response);
                    if (response.status) {
                        $.toast({
                            heading: response.message,
                            position: 'top-right',
                            loaderBg: '#ff6849',
                            icon: 'success',
                            hideAfter: 3500,
                            stack: 6
                        });
                        table.ajax.reload();
                        $('#add_vendor').modal('hide');
                    } else {
                        $.toast({
                            heading: response.message,
                            position: 'top-right',
                            loaderBg: '#ff6849',
                            icon: 'error',
                            hideAfter: 3500,
                            stack: 6
                        });                    }
                }
            });
        }
    });
    
});




function removeError() {
    $("#fName").removeClass("is-valid is-invalid");
    $("#lName").removeClass("is-valid is-invalid");
    $("#uName").removeClass("is-valid is-invalid");
    $("#email").removeClass("is-valid is-invalid");
    $("#mobileNo").removeClass("is-valid is-invalid");
    $("#type").removeClass("is-valid is-invalid");
    $("#password").removeClass("is-valid is-invalid");
    $("#cpassword").removeClass("is-valid is-invalid");
    $("#fName-error").remove();
    $("#lName-error").remove();
    $("#uName-error").remove();
    $("#email-error").remove();
    $("#mobileNo-error").remove();
    $("#type-error").remove();
    $("#password-error").remove();
    $("#cpassword-error").remove();
}