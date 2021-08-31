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
            url: base_url + "/admin/customerList",
            type: "POST",
            complete: function() {
                $(".ti-marker-alt").click(function() {
                    $('#add_customer').modal('show');
                    $('#admin_label').text('Edit Admin');
                    $.ajax({
                        url: base_url + "/admin/editCustomer",
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
                                    url: base_url + '/admin/CustomerDelete',
                                    type: 'post',
                                    data: 'deleteCustomer=' + delete_admin.data("id"),
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

    

    $('#add_customer').on('hidden.bs.modal', function (e) {

        $('#customerData').find("input[type=text], textarea").val("");
        $('#customerData').find("input[type=hidden], textarea").val("");
        $('#customerData').find("input[type=email], textarea").val("");
        $('#customerData').find("input[type=number], textarea").val("");
        $('#customerData').find("select, textarea").val("");

        $("#email").prop("disabled", false).removeClass('ignore');
        $("#mobileNo").removeClass('ignore');
        $("#noteMsg").hide()



        $("#uName").prop("disabled", false).removeClass('ignore');
        removeError();
        $('#customer_label').text('Add Customer');
    
    
    })

    $.validator.addMethod("uniqueEmail",
        function(value, element) {
            if (value) {
                $.ajax({
                    url: base_url + '/admin/CustomerEmail' + ($("#customer_id").val() ? '/' + $('#customer_id').val() : ''),
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
   
    $("#customerData").validate({ 
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
            },
            type: {
                required: true
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
         
        },
        highlight: function(element) {
            $(element).addClass("is-invalid").removeClass('is-valid');
        },
        unhighlight: function(element) {
            $(element).addClass("is-valid").removeClass("is-invalid");
        },
        submitHandler: function(form,event) {
            $.ajax({
                url: base_url + '/admin/addcustomer' + ($("#customer_id").val() ? '/' + $('#customer_id').val() : ''),
                type: 'post',
                data: {
                    id: $("#customer_id").val(),
                    name: $("#fName").val() + " " + $("#lName").val(),
                    uName: $("#uName").val(),
                    email: $("#email").val(),
                    mobileNo: $("#mobileNo").val(),
                    customer_company: $("#customer_company").val(),
                    customer_position: $("#customer_position").val(),
                    address: $("#address").val(),
                    city: $("#city").val(),
                    state: $("#state").val(),
                    zipcode: $("#zipcode").val(),
                    country: $("#country").val(),



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
                        $('#add_customer').modal('hide');
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
            event.preventDefault();
      
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