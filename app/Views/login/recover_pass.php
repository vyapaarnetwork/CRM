<?php echo $header; ?>
<section id="wrapper">
        <div class="login-register" style="background-image:url(../assets/images/background/login-register.jpg);">
            <div class="login-box card">
                <div class="card-body">
                    <form class="form-horizontal form-material" id="forgetPassword">
                        <h3 class="box-title m-b-20">Recover Password</h3>
                                          <div class="form-group">
                            <div class="col-xs-12">
                                <input class="form-control" id="vendor_email" name="vendor_email" type="text" required="" placeholder="Email">
                            </div>
                                              <code id="vendor_mail-error" class="mb-1" for="vendor_mail" style="display:none"></code>

                                          </div>
                        <div class="form-group text-center p-b-10">
                            <div class="col-xs-12">
                                <button class="btn btn-info btn-lg w-100 text-uppercase waves-effect waves-light text-white" id="forgetButton">Reset</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
<?php echo $footer; ?>
<script>
    $("#forgetButton").on("click", function () {

            // alert("success");


        let vendor_email = $("#vendor_email").val();
        $.ajax({
                url: base_url + '/vendor/password/forgetPassword',
                type: 'post',
                data: {vendor_email:vendor_email},
                success: function (result) {
                    let Success = $.parseJSON(result);
                    if (Success.status == true) {
                        $.toast({
                            heading: Success.message,
                            position: 'top-right',
                            loaderBg: '#ff6849',
                            icon: 'success',
                            hideAfter: 3500,
                            stack: 6
                        });

                    } else {
                        $.toast({
                            heading: Success.message,
                            position: 'top-right',
                            loaderBg: '#ff6849',
                            icon: 'error',
                            hideAfter: 3500,
                            stack: 6
                        });

                    }
                }

            });


        return false;
    });
</script>