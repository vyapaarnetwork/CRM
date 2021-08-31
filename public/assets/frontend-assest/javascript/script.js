$(document).ready(function (){
    $('#clientRegister').click(function () {
        $('#Register').iziModal('open');
    });
    $('#sallRegister').click(function () {
        $('#userType').val("sales");
        $('#Register').iziModal('open');
    });
    $(document).on('closing', '#Register', function (e) {
        $("#userType").val('');
    });

    $('#clientLogin').click(function () {
        $('#Login').iziModal('open');
    });
    var isSuccess = null;
    $.validator.addMethod("uniqueUser",
        function (value, element) {
            if (value) {
                $.ajax({
                    url: base_url + '/uniqueCheck',
                    type: 'post',
                    data: {
                        val: value,
                        user: $('#userType').val(),
                        code: "svm_username",
                        codetwo: 'ssam_username'
                    },
                    success: function (result) {
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
        function (value, element) {
            if (value) {
                $.ajax({
                    url: base_url + '/uniqueCheck',
                    type: 'post',
                    data: {
                        val: value,
                        user: $('#userType').val(),
                        code: "svm_email",
                        codetwo: 'ssam_email'
                    },
                    success: function (result) {
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
        function (value, element) {
            if (value) {
                $.ajax({
                    url: base_url + '/uniqueCheck',
                    type: 'post',
                    data: {
                        val: value,
                        user: $('#userType').val(),
                        code: "svm_phone",
                        codetwo: 'ssam_phone'
                    },
                    success: function (result) {
                        var mobileNo = $.parseJSON(result);
                        isSuccess = mobileNo.status
                    }
                });
            }
            return this.optional(element) || isSuccess;
        },
        "Mobile Number Already Exists."
    );
    var spinnerReg = new jQuerySpinner({
        parentId: 'Register'
    });
    $("#clientRegistrationForm").validate({
        errorElement: "small",
        errorClass: "text-danger",
        ignore: '.ignore',
        rules: {
            rfName: "required",
            rlName: "required",
            ruName: {
                required: true,
                uniqueUser: true,
            },
            remail: {
                required: true,
                email: true,
                uniqueEmail: true
            },
            rmobileNo: {
                required: true,
                number: true,
                rangelength: [10, 10],
                uniqueMobile: true
            },
            rpassword: {
                required: true,
                minlength: 8
            },
            rcpassword: {
                required: true,
                minlength: 8,
                equalTo: "#rpassword"
            },
            rcompany: 'required'
        },
        messages: {
            rfName: "First Name Is Required.",
            rlName: "Last Name Is Required.",
            ruName: {
                required: "User Name Is Required.",
            },
            remail: {
                required: "Email Is Required.",
                email: "Email Is Not Valid.",
            },
            rmobileNo: {
                required: "Mobile Number Is Required.",
                number: "You Can Enter Only Numbers.",
                rangelength: "Please Enter 10 Numbers Only.",
            },
            rpassword: {
                required: "Password Can Not Be Empty.",
                minlength: "Password Must Be At Least 8 Characters."
            },
            rcpassword: {
                required: "Confirm Password Can Not Be Empty.",
                minlength: "Confirm Password Must Be At Least 8 Characters.",
                equalTo: "Enter Confirm Password Same As Password."
            },
            rcompany: 'Company Name Is Required.'
        },
        highlight: function (element) {
            $(element).addClass("is-invalid").removeClass('is-valid');
        },
        unhighlight: function (element) {
            $(element).addClass("is-valid").removeClass("is-invalid");
        },
        submitHandler: function (form) {
            spinnerReg.show();
            $.ajax({
                url: base_url + '/registerVendor',
                type: 'post',
                data: {
                    user: $('#userType').val(),
                    name: $("#rfName").val() + " " + $("#rlName").val(),
                    uName: $("#ruName").val(),
                    email: $("#remail").val(),
                    mobileNo: $("#rmobileNo").val(),
                    password: $("#rpassword").val(),
                    company: $('#rcompany').val()
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
                        $('#Register').iziModal('close');
                        form.reset();
                        spinnerReg.hide();
                        $('#Login').iziModal('open');
                    } else {
                        iziToast.show({
                            theme: 'light',
                            color: 'red',
                            position: 'bottomCenter',
                            title: 'Error',
                            message: response.message
                        });
                        spinnerReg.hide();
                    }
                }
            });
        }
    });
    $("#clientLoginForm").validate({
        errorElement: "small",
        errorClass: "text-danger",
        rules: {
            ruName: {
                required: true,
                uniqueUser: true,
            },
            rpassword: {
                required: true,
                minlength: 8
            }
        },
        messages: {
            ruName: {
                required: "User Name Is Required.",
            },
            rpassword: {
                required: "Password Can Not Be Empty.",
                minlength: "Password Must Be At Least 8 Characters."
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
                url: base_url + '/loginVendor',
                type: 'post',
                data: {
                    uName: $("#luName").val(),
                    password: $("#lpassword").val()
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
                        $('#Login').iziModal('close');
                        window.location.reload();
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
    $('#fgtPwd').click(function () {
        $('#Login').iziModal('close');
        $('#Forgot').iziModal('open');
    });
    var spinnerfgp = new jQuerySpinner({
        parentId: 'Forgot'
    });
    $("#forgotForm").validate({
        errorElement: "small",
        errorClass: "text-danger",
        rules: {
            fuName: {
                required: true
            },
        },
        highlight: function (element) {
            $(element).addClass("is-invalid").removeClass('is-valid');
        },
        unhighlight: function (element) {
            $(element).addClass("is-valid").removeClass("is-invalid");
        },
        submitHandler: function (form) {
            spinnerfgp.show();
            $.ajax({
                url: base_url + '/forgotPassword',
                type: 'post',
                data: {
                    uName: $("#fuName").val(),
                },
                success: function (result) {
                    var response = $.parseJSON(result);
                    if (response.status) {
                        iziToast.show({
                            theme: 'light',
                            color: 'blue',
                            position: 'center',
                            title: 'Success',
                            message: response.message
                        });
                        spinnerfgp.hide();
                        $('#Forgot').iziModal('close');
                    } else {
                        iziToast.show({
                            theme: 'light',
                            color: 'red',
                            position: 'bottomCenter',
                            title: 'Error',
                            message: response.message,
                        });
                        spinnerfgp.hide();
                    }
                }
            });
        }
    });
})