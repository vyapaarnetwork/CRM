<?php echo $header; ?>
<section id="wrapper">
        <div class="login-register" style="background-image:url(../assets/images/background/login-register.jpg);">
            <div class="login-box card">
                <div class="card-body">
                    <form class="form-horizontal form-material" id="newPass">
                        <h3 class="box-title m-b-20">New Password</h3>
                                          <div class="form-group">
                            <div class="col-xs-12">
                                <input class="form-control" id="new_pass" name="new_pass" type="password" required="" placeholder="New Password">
                                <input class="form-control" id="token" name="token" type="hidden" value="<?= $forget_m_data->forget_token ?>">
                            </div>
                                              <code id="new_pass-error" class="mb-1" for="new_pass" style="display:none"></code>

                                          </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <input class="form-control" id="confirm_pass" name="confirm_pass" type="password" required="" placeholder="Confirmation Password">
                            </div>
                            <code id="confirm_pass-error" class="mb-1" for="confirm_pass" style="display:none"></code>

                        </div>
                        <div class="form-group text-center p-b-10">
                            <div class="col-xs-12">
                                <button class="btn btn-info btn-lg w-100 text-uppercase waves-effect waves-light text-white" id="changePass">Change</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
<?php echo $footer; ?>
<script>


    $("#newPass").validate({
        errorElement: "small",
        errorClass: "text-danger",
        ignore: '.ignore',
        rules: {
                        new_pass: {
                required: true,
                minlength: 8
            },
            confirm_pass: {
                required: true,
                minlength: 8,
                equalTo: "#new_pass"
            },
        },
        messages: {
            new_pass: {
                required: "Password Can Not Be Empty.",
                minlength: "Password Must Be At Least 8 Characters."
            },
            confirm_pass: {
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
            let new_pass = $("#new_pass").val();
            let token = $("#token").val();

            $.ajax({
                url: base_url + '/vendor/change-password',
                type: 'post',
                data: {new_pass:new_pass,token:token},
                success: function(result) {
                    let response = $.parseJSON(result);
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
                        $('#new_pass').attr('disabled', true);
                        $('#confirm_pass').attr('disabled', true);

                        window.setTimeout(function(){location.href = base_url},5000)


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
</script>