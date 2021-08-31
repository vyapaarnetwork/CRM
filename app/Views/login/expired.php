<?php echo $header; ?>
<section id="wrapper">
        <div class="login-register" style="background-image:url(../assets/images/background/login-register.jpg);">
            <div class="login-box card">
                <div class="card-body">
                    <div class="col-xs-12">
                        <p style="color: red;text-align: center">Token not Found or Expired. Please try again..</p>
                    </div>
                    <div class="col-xs-12">
                        <button class="btn btn-info btn-md w-100 text-uppercase waves-effect waves-light text-white" onclick="window.location.href='<?= base_url('/vendor/') ?>'">Return to Home</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php echo $footer; ?>
