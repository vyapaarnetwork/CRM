$(document).ready(function() {
    $("#login_submit").click(function() {
        var email = $('#admin_mail').val();
        var valid = false
        if (!email) {
            valid = false;
            $("#admin_mail-error").show().text("Please Enter Your Email Address.");
        } else {
            valid = true;
            $("#admin_mail-error").hide();
        }
        var pattern = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i
        if (!pattern.test(email)) {
            valid = false;
            $("#admin_mail-error").show().text("Please Enter Valid Email Address.");
        } else {
            valid = true;
            $("#admin_mail-error").hide();
        }
        var password = $('#admin_password').val();
        if (!password) {
            valid = false;
            $("#admin_password-error").show().text("Please Enter Your Password.");
        } else {
            valid = true;
            $("#admin_password-error").hide();
        }
        if (valid) {
            $.ajax({
                url: base_url + '/admin/admin-check',
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
    $("#admin_mail").on("change keyup", function() {
        if (!$(this).val()) {
            $("#admin_mail-error").show().text("Please Enter Your Email Address.")
        } else {
            $("#admin_mail-error").hide();
        }
        var pattern = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i
        if (!pattern.test($(this).val())) {
            $("#admin_mail-error").show().text("Please Enter Valid Email Address.")
        } else {
            $("#admin_mail-error").hide();
        }
        return false
    });
    $("#admin_password").on("change keyup", function() {
        if (!$(this).val()) {
            $("#admin_password-error").show().text("Please Enter Your Password.")
        } else {
            $("#admin_password-error").hide();
        }
        return false
    });
});