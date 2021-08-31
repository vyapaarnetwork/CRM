var spinnerfgp = new jQuerySpinner({
    parentId: 'changePassword'
});
$("#changePassword").validate({
    errorElement: "small",
    errorClass: "text-danger",
    rules: {
        fcpassword: {
            required: true,
            minlength: 8,
        },
        frcpassword: {
            required: true,
            minlength: 8,
            equalTo: "#fcpassword"
        }
    },
    messages:{
        fcpassword: {
            required: "New Password Can Not Be Empty.",
            minlength: "New Password Must Be At Least 8 Characters."
        },
        frcpassword: {
            required: "Password Can Not Be Empty.",
            minlength: "Password Must Be At Least 8 Characters.",
            equalTo: "Enter This Password Same As Password."
        }
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
            url: base_url + '/passwordChange',
            type: 'post',
            data: {
                password: $("#fcpassword").val(),
                slug: $('#slug').val()
            },
            success: function (result) {
                var response = $.parseJSON(result);
                if (response.status) {
                    spinnerfgp.hide();
                    window.location.replace(base_url+"?pwdCng=true")
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