<?php echo $header; ?>
<section">
        <div class="login-register">
            <div class="login-box card">
                <div class="card-body">
                    <form class="form-horizontal form-material" id="admin-login" method="POST">
                        <h3 class="text-center m-b-20">Sign In</h3>
                        <div class="form-group ">
                            <div class="col-xs-12">
                                <input class="form-control" type="email" name="admin_mail" id="admin_mail" placeholder="Username/Email"> </div>
                                <div class="text-danger"></div>

                        </div>
                        <code id="admin_mail-error" class="mb-1" for="admin_mail" style="display:none"></code>

                        <div class="form-group">
                            <div class="col-xs-12">
                                <input class="form-control" type="password" name="admin_password" id="admin_password" placeholder="Password"> </div>
                                <div class="text-danger"></div>

                        </div>
                        <code id="admin_password-error" class="mb-1" for="admin_password" style="display:none"></code>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <div class="d-flex no-block align-items-center">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="customCheck1">
                                        <label class="custom-control-label" for="customCheck1">Remember me</label>
                                    </div> 
                                    <div class="ml-auto">
                                        <a href="javascript:void(0)" id="to-recover" class="text-muted"><i class="fas fa-lock m-r-5"></i> Forgot pwd?</a> 
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                                <code id="message-return"></code>
                            </div>
                        <div class="form-group text-center">
                            <div class="col-xs-12 p-b-20">
                                <button class="btn btn-block btn-lg btn-info btn-rounded" id="login_submit">Log In</button>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </section>
<?php echo $footer; ?>