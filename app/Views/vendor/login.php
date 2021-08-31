<?php echo $header; ?>
<div class="login-area">
    <div class="container">
        <div class="login-box ptb--100">
            <form id="admin-login" method="POST">
                <div class="login-form-head">
                    <h4>Sign In</h4>
                    <!-- <p>Hello there, Sign in and start managing your Admin Template</p> -->
                </div>
                <div class="login-form-body">
                    <div class="form-gp">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="email" name="admin_mail" id="admin_mail">
                        <i class="ti-email"></i>
                        <div class="text-danger"></div>
                    </div>
                    <label id="admin_mail-error" class="error" for="admin_mail" style="display:none"></label>
                    <div class="form-gp">
                        <label for="exampleInputPassword1">Password</label>
                        <input type="password" name="admin_password" id="admin_password">
                        <i class="ti-lock"></i>
                        <div class="text-danger"></div>
                    </div>
                    <label id="admin_password-error" class="error" for="admin_password" style="display:none"></label>
                    <div class="submit-btn-area">
                        <div class="login-other row mt-4">
                            <div class="col-12">
                                <label id="message-return"></label>
                            </div>
                        </div>
                        <button id="login_submit">Submit <i class="ti-arrow-right"></i></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php echo $footer; ?>