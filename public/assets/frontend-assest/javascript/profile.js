$(document).ready(function () {    
    var spinnerfgp = new jQuerySpinner({
        parentId: 'changePassword'
    });
    $('#details').click(function () {
        $.ajax({
            url: base_url + '/vendorData',
            type: 'post',
            data: {
                slug: $("#VendorSlug").val()
            },
            success: function (result) {
                var responce = $.parseJSON(result);
                if (responce.status) {
                    $('#edfName').val(responce.data.svm_name);
                    $('#eduName').val(responce.data.svm_username);
                    $('#edcompany').val(responce.data.svm_company_name);
                    $('#edemail').val(responce.data.svm_email);
                    $('#edmobileNo').val(responce.data.svm_phone);
                    $('#Details').iziModal('open');
                } else {
                    iziToast.show({
                        theme: 'light',
                        color: 'red',
                        position: 'bottomCenter',
                        title: 'Error',
                        message: response.message
                    });
                }
            },
        })
    
    });
    $("#EditDetalis").validate({
        errorElement: "small",
        errorClass: "text-danger",
        rules: {
            edcompany: {
                required: true,
            },
            edfName: {
                required: true,
            }
        },
        messages: {
            edcompany: {
                required: "User Name Is Required.",
            },
            edfName: {
                required: 'Name Not Be Empty.'
            }
        },
        highlight: function (element) {
            $(element).addClass("is-invalid").removeClass('is-valid');
        },
        unhighlight: function (element) {
            $(element).addClass("is-valid").removeClass("is-invalid");
        },
        submitHandler: function (form) {
            $.ajax({
                url: base_url + '/vendorUpdate',
                type: 'post',
                data: {
                    svm_company_name: $("#edcompany").val(),
                    svm_name: $('#edfName').val(),
                    svm_slug: $('#VendorSlug').val()
                },
                success: function (result) {
                    var response = $.parseJSON(result);
                    if (response.status) {
                        iziToast.show({
                            theme: 'light',
                            color: 'blue',
                            position: 'bottomCenter',
                            title: 'Success',
                            message: response.message
                        });
                        $('#udname').text(response.data.svm_name);
                        $('#udcompany').text(response.data.svm_company_name);
                        $('#Details').iziModal('close');
                    } else {
                        iziToast.show({
                            theme: 'light',
                            color: 'red',
                            position: 'bottomCenter',
                            title: 'Error',
                            message: response.message,
                        });
                    }
                }
            });
        }
    });
    $.validator.addMethod("IFSCCode",
        function (value, element) {
            return this.optional(element) || /[A-Z]{4}[0-9]{6}$/i.test(value);
        },
        "Passwords are 6-16 characters"
    );
    $('#bank').click(function () {
        $.ajax({
            url: base_url + '/vendorBankData',
            type: 'post',
            data: {
                slug: $("#VendorSlug").val()
            },
            success: function (result) {
                var responce = $.parseJSON(result);
                if (responce.status) {
                    if (responce.data.sbm_id) {
                        $('#sbm_id').val(responce.data.sbm_id);
                    } if (responce.data.sbm_account_no) {
                        $('#bankaccountnumber').val(responce.data.sbm_account_no);
                    } if (responce.data.sbm_holder_name) {
                        $('#bankholdername').val(responce.data.sbm_holder_name);
                    } if (responce.data.sbm_ifsc_code) {
                        $('#bankifsccode').val(responce.data.sbm_ifsc_code);
                    }
                    $('#svm_id').val(responce.data.svm_id);
                    $("#BankAdd").iziModal('open')
                } else {
                    iziToast.show({
                        theme: 'light',
                        color: 'red',
                        position: 'bottomCenter',
                        title: 'Error',
                        message: response.message
                    });
                }
            },
        });
    });
    // console.log($('#BankDetails').validate());
    $("#BankDetails").validate({
        errorElement: "small",
        errorClass: "text-danger",
        rules: {
            bankholdername: {
                required: true,
            },
            bankaccountnumber: {
                number: true,
                rangelength: [9, 18],
                required: true,
            },
            bankifsccode: {
                IFSCCode: true,
                required: true,
            }
        },
        messages: {
            bankholdername: {
                required: "Bank Account Holder Name Not Be Empty.",
            },
            bankaccountnumber: {
                number: "Account Number Is Not Valid",
                required: 'Account Number Not Be Empty.'
            },
            bankifsccode: {
                IFSCCode: "Ifsc Code Is Not Valid",
                required: 'Ifsc Code Is Required.',
            }
        },
        highlight: function (element) {
            $(element).addClass("is-invalid").removeClass('is-valid');
        },
        unhighlight: function (element) {
            $(element).addClass("is-valid").removeClass("is-invalid");
        },
        submitHandler: function (form) {
            console.log('here');
            $.ajax({
                url: base_url + '/vendorBankUpdate',
                type: 'post',
                data: {
                    id: $('#sbm_id').val(),
                    vendor_id : $('#svm_id').val(),
                    name: $("#bankholdername").val(),
                    number: $('#bankaccountnumber').val(),
                    code: $('#bankifsccode').val()
                },
                success: function (result) {
                    var response = $.parseJSON(result);
                    if (response.status) {
                        iziToast.show({
                            theme: 'light',
                            color: 'blue',
                            position: 'bottomCenter',
                            title: 'Success',
                            message: response.message
                        });
                        $('#holdername').text(response.data.sbm_holder_name);
                        $('#accountnumber').text(response.data.sbm_account_no);
                        $('#ifsccode').text(response.data.sbm_ifsc_code);
                        $("#BankAdd").iziModal('close');
                    } else {
                        iziToast.show({
                            theme: 'light',
                            color: 'red',
                            position: 'bottomCenter',
                            title: 'Error',
                            message: response.message,
                        });
                    }
                }
            });
        }
    });
});