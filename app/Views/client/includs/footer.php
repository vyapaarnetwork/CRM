<footer>
    <div class="container">
        <div class="row">
            <div class="col-sm-6 footer-block">
                <h5 class="footer-title">Infomatin</h5>
                <ul class="list-unstyled ul-wrapper">
                    <li><a href="contact.html">Contact Us</a></li>
                    <?php if (!empty($session->client)) { ?>
                        <li><a href="#">My Account</a></li>
                    <?php } ?>
                </ul>
            </div>
            <div class="col-sm-6 footer-block">
                <div class="content_footercms_right">
                    <div class="footer-contact">
                        <h5 class="contact-title footer-title">Contact Us</h5>
                        <ul class="ul-wrapper">
                            <?php if (!empty($setting['site_address'])) : ?>
                                <li>
                                    <i class="fa fa-map-marker"></i>
                                    <span class="location2">
                                        <?php echo $setting['site_address']; ?>
                                    </span>
                                </li>
                            <?php endif; ?>
                            <?php if (!empty($setting['site_email'])) : ?>
                                <li>
                                    <i class="fa fa-envelope"></i>
                                    <span class="mail2">
                                        <a href="mailto:<?php echo $setting['site_email']; ?>">
                                            <?php echo $setting['site_email']; ?>
                                        </a>
                                    </span>
                                </li>
                            <?php endif; ?>
                            <?php if (!empty($setting['contact_number'])) : ?>
                                <li>
                                    <i class="fa fa-mobile"></i>
                                    <span class="phone2">
                                        <a href="tel:<?php echo $setting['contact_number']; ?>">
                                            <?php echo $setting['contact_number']; ?>
                                        </a>
                                    </span>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div id="bottom-footer">
            <ul class="footer-link">
                <li><a href="#">Home</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
            <div class="copyright">
                <?php if (!empty($setting['footer_copyright'])) {
                    $replace = array(
                        '{{year}}',
                        '{{devloper}}'
                    );
                    $replaceWith = array(
                        date('Y'),
                        '<a href="https://kbwebsol.com/"> K&B WEB SOLUTION PVT.LTD.</a>'
                    );
                    $copyRight = str_replace($replace, $replaceWith, $setting['footer_copyright']);
                    echo $copyRight;
                } ?>
            </div>
        </div>
    </div>
    <a id="scrollup">Scroll</a>
</footer>
<?php if (empty($session->client)) : ?>
    <div id="Register">
        <div class="modal-body">
            <p id="resultMessagefalse"></p>
            <form method="POST" id="clientRegistrationForm" novalidate>
                <input type="hidden" name="enckey" id="enckey" value="<?php echo random_string('md5', 32); ?>">
                <input type="hidden" value="" id="userType" />
                <div class="form-row">
                    <div class="col-md-4 mb-3">
                        <label for="rfName">First Name</label>
                        <input type="text" name="rfName" class="form-control" id="rfName" placeholder="First name">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="rlName">Last Name</label>
                        <input type="text" name="rlName" class="form-control" id="rlName" placeholder="Last name">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="ruName">User Name</label>
                        <input type="text" name="ruName" class="form-control" id="ruName" placeholder="User name">
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-4 mb-3">
                        <label for="rcompany">Company Name</label>
                        <input type="text" name="rcompany" class="form-control" id="rcompany" placeholder="Company Name">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="remail">Email Address</label>
                        <input type="email" name="remail" class="form-control" id="remail" placeholder="Email Address">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="rmobileNo">Mobile Number</label>
                        <input type="number" name="rmobileNo" class="form-control" id="rmobileNo" placeholder="Mobile Number">
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="rpassword">Password</label>
                        <input type="password" name="rpassword" class="form-control" id="rpassword" placeholder="Password">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="rcpassword">Confirm Password</label>
                        <input type="password" name="rcpassword" class="form-control" id="rcpassword" placeholder="Confirm Password">
                    </div>
                </div>
                <button class="btn btn-primary" id="addRegistration" type="submit">Add</button>
            </form>
        </div>
    </div>
    <div id="Login">
        <div class="modal-body">
            <p id="resultMessage"></p>
            <form method="POST" id="clientLoginForm" novalidate>
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <label for="luName">User Name</label>
                        <input type="text" name="luName" class="form-control" id="luName" placeholder="User name">
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <label for="password">Password</label>
                        <input type="password" name="lpassword" class="form-control" id="lpassword" placeholder="Password">
                    </div>
                </div>
                <div class="mb-3">
                    <button id="fgtPwd" type="button">Forgot Password?</button>
                </div>
                <button class="btn btn-primary" id="LoginBtn" type="submit">Login</button>
            </form>
        </div>
    </div>
    <div id="Forgot">
        <div class="modal-body">
            <p id="resultMessage"></p>
            <form method="POST" id="forgotForm" novalidate>
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <label for="fuName">User Name</label>
                        <input type="text" name="fuName" class="form-control" id="fuName" placeholder="Enter Register Username Or Email Address Or Mobile Number">
                    </div>
                </div>
                <button class="btn btn-primary" id="ForgotBtn" type="submit">Submit</button>
            </form>
        </div>
    </div>
<?php endif; ?>
<script type="text/javascript" src="<?php echo getFrontEndUrl('javascript/jquery-2.2.4.min.js?var=' . APPVERSION); ?>"></script>
<script type="text/javascript" src="<?php echo getFrontEndUrl('javascript/bootstrap.min.js?var=' . APPVERSION); ?>"></script>
<script type="text/javascript" src="<?php echo getFrontEndUrl('javascript/template_js/jstree.min.js?var=' . APPVERSION); ?>"></script>
<script type="text/javascript" src="<?php echo getFrontEndUrl('javascript/template_js/template.js?var=' . APPVERSION); ?>"></script>
<script type="text/javascript" src="<?php echo getFrontEndUrl('javascript/common.js?var=' . APPVERSION); ?>"></script>
<script type="text/javascript" src="<?php echo getFrontEndUrl('javascript/global.js?var=' . APPVERSION); ?>"></script>
<script type="text/javascript" src="<?php echo getFrontEndUrl('javascript/iziToast/iziToast.js?var=' . APPVERSION); ?>"></script>
<script type="text/javascript" src="<?php echo getFrontEndUrl('Loader/jquery-spinner.js?var=' . APPVERSION); ?>"></script>
<?php if ($page == 'changePassword') { ?>
    <script type="text/javascript" src="<?php echo getFrontEndUrl('javascript/forgotPassword.js?var=' . APPVERSION); ?>"></script>
<?php }
if ($page == 'profileDetails') { ?>
    <script type="text/javascript" src="<?php echo getFrontEndUrl('js/vendor/jquery.ui.widget.js?var=' . APPVERSION); ?>"></script>
    <script type="text/javascript" src="<?php echo getFrontEndUrl('js/load-image.all.min.js?var=' . APPVERSION); ?>"></script>
    <script type="text/javascript" src="<?php echo getFrontEndUrl('js/jquery.iframe-transport.js?var=' . APPVERSION); ?>"></script>
    <script type="text/javascript" src="<?php echo getFrontEndUrl('js/jquery.fileupload.js?var=' . APPVERSION); ?>"></script>
    <script type="text/javascript" src="<?php echo getFrontEndUrl('js/jquery.fileupload-process.js?var=' . APPVERSION); ?>"></script>
    <script type="text/javascript" src="<?php echo getFrontEndUrl('js/jquery.fileupload-image.js?var=' . APPVERSION); ?>"></script>
    <script type="text/javascript" src="<?php echo getFrontEndUrl('js/jquery.fileupload-validate.js?var=' . APPVERSION); ?>"></script>
    <script type="text/javascript" src="<?php echo getFrontEndUrl('js/jquery.fileupload-ui.js?var=' . APPVERSION); ?>"></script>
    <script type="text/javascript" src="<?php echo getFrontEndUrl('js/demo.js?var=' . APPVERSION); ?>"></script>
    <script type="text/javascript" src="<?php echo getFrontEndUrl('javascript/jquery.validate.js?var=' . APPVERSION); ?>"></script>
    <script type="text/javascript" src="<?php echo getFrontEndUrl('javascript/profile.js?var=' . APPVERSION); ?>"></script>
<?php }
if ($page == 'product') { ?>
    <script type="text/javascript" src="<?php echo getFrontEndUrl('javascript/DataTables/datatables.js?var=' . APPVERSION); ?>"></script>
    <script type="text/javascript" src="<?php echo getFrontEndUrl('DropZone/dropzone.js?var=' . APPVERSION); ?>"></script>
    <script type="text/javascript" src="<?php echo getFrontEndUrl('javascript/jquery.validate.js?var=' . APPVERSION); ?>"></script>
    <script type="text/javascript" src="<?php echo getFrontEndUrl('javascript/product.js?var=' . APPVERSION); ?>"></script>
<?php }
if ($page == 'lead') { ?>
    <script type="text/javascript" src="<?php echo getFrontEndUrl('javascript/DataTables/datatables.js?var=' . APPVERSION); ?>"></script>
    <script type="text/javascript" src="<?php echo getFrontEndUrl('javascript/LeadsList.js?var=' . APPVERSION); ?>"></script>
<?php } if ($page == 'leadDetails') { ?>
    <script type="text/javascript" src="<?php echo getFrontEndUrl('javascript/leadDetails.js?var=' . APPVERSION); ?>"></script>
<?php 
}?>
<script type="text/javascript" src="<?php echo getFrontEndUrl('javascript/jquery.validate.js?var=' . APPVERSION); ?>"></script>
<script type="text/javascript" src="<?php echo getFrontEndUrl('javascript/script.js?var=' . APPVERSION); ?>"></script>
<script type="text/javascript" src="<?php echo getFrontEndUrl('javascript/iziModal.js?var=' . APPVERSION); ?>"></script>
</body>

</html>