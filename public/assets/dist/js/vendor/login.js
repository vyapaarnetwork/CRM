$(document).ready(function() {
    $("#login_submit").click(function() {
        var email = $('#vendor_mail').val();
        var valid = false
        if (!email) {
            valid = false;
            $("#vendor_mail-error").show().text("Please Enter Username/Email ID.");
        } else {
            valid = true;
            $("#vendor_mail-error").hide();
        }
        // var pattern = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i
        // if (!pattern.test(email)) {
        //     valid = false;
        //     $("#vendor_mail-error").show().text("Please Enter Valid Email Address.");
        // } else {
        //     valid = true;
        //     $("#vendor_mail-error").hide();
        // }
        var password = $('#vendor_password').val();
        if (!password) {
            valid = false;
            $("#vendor_password-error").show().text("Please Enter Your Password.");
        } else {
            valid = true;
            $("#vendor_password-error").hide();
        }
        if (valid) {
            $.ajax({
                url: base_url + '/vendor/vendor-check',
                type: 'post',
                data: {
                    user_address: email,
                    password: password
                },
                success: function(data) {
                    var Json = $.parseJSON(data);
                    if (Json.status) {
                        window.location.replace(Json.url);
                    } else {
                        $("#message-return").text(Json.message)
                    }
                },
            });
        } else {
            console.log("here");
        }
        return false
    })
    $("#vendor_mail").on("change keyup", function() {
        if (!$(this).val()) {
            $("#vendor_mail-error").show().text("Please Enter Your Email Address.")
        } else {
            $("#vendor_mail-error").hide();
        }
        // var pattern = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i
        // if (!pattern.test($(this).val())) {
        //     $("#vendor_mail-error").show().text("Please Enter Valid Email Address.")
        // } else {
        //     $("#vendor_mail-error").hide();
        // }
        return false
    });
    $("#vendor_password").on("change keyup", function() {
        if (!$(this).val()) {
            $("#vendor_password-error").show().text("Please Enter Your Password.")
        } else {
            $("#vendor_password-error").hide();
        }
        return false
    });
});
