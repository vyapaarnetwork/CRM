<div class="container pt-5">
    <div class="row">
        <div id="column-left" class="col-sm-3 hidden-xs column-left">
            <div class="Categories left-sidebar-widget">
                <div class="columnblock-title">Menu</div>
                <div class="category_block">
                    <ul class="box-category treeview-list treeview collapsable">
                        <!-- <li class="expandable">
                        <a href="#" class="activSub">
                            Profile
                        </a>
                        <ul class="collapsable">
                            <li class="active">
                                <a id="details" href="" onclick="return false;">Profile Edit</a>
                            </li>
                            <li class="last">
                                <a id="bank" href="" onclick="return false;">Bank Details Edit</a>
                            </li>
                        </ul>
                    </li> -->
                        <li>
                            <a href="" onclick="return false;">
                                Profile
                            </a>
                        </li>
                        <li>
                            <a href="" onclick="return false;">
                                Tablets
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-sm-9" id="content">
            <div class="well well-sm">
                <div class="row">
                    <div class="col-sm-6 col-md-4 text-center">
                        <form id="fileupload" method="POST" enctype="multipart/form-data">
                            <input type="hidden" id="VendorSlug" name="svm_slug" value="<?php echo $slug; ?>" />
                            <img id="vendorProfileImage" src="<?php echo ((!empty($user->svm_image) && file_exists(VENDOR_IMAGE_PATH . $user->svm_image)) ? getFrontEndImageUploadUrl('vendorImage/' . $user->svm_image) : getFrontEndUrl('image/default-user.png')) ?>" alt="" class="img-rounded img-responsive m-2" width="226px" />
                            <?php if ($user->svm_id == $session->client['svm_id']) { ?>
                                <span class="btn btn-success fileinput-button">
                                    <i class="fa fa-cloud-upload"></i>
                                    <input type="file" name="profilePic" />
                                </span>
                            <?php } ?>
                        </form>
                    </div>
                    <div class="col-sm-6 col-md-8">
                        <div class="pt-2 pb-5">
                            <h1>User Details</h1>
                            <h2>
                                <div class="row">
                                    <div class="col-md-6">
                                        <i class="fa fa-user"></i> Name :-
                                    </div>
                                    <div id="udname" class="col-md-6">
                                        <?php echo $user->svm_name; ?>
                                    </div>
                                </div>
                            </h2>
                            <h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <i class="fa fa-building"></i> Company Name :-
                                    </div>
                                    <div id="udcompany" class="col-md-6">
                                        <?php echo $user->svm_company_name; ?>
                                    </div>
                                </div>
                            </h4>
                            <h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <i class="fa fa-phone"></i> Mobile Number :-
                                    </div>
                                    <div id="udphone" class="col-md-6">
                                        <?php echo $user->svm_phone; ?>
                                    </div>
                                </div>
                            </h5>
                            <h5 title=" <?php echo (($user->svm_id == $session->client['svm_id']) ? (($user->svm_verified_email == 0) ? 'Not Verified' : 'Verified') : "") ?>">
                                <div class="row">
                                    <div class="col-md-6">
                                        <i class="fa fa-envelope"></i> Email :-
                                    </div>
                                    <div class="col-md-6">
                                        <?php echo $user->svm_email; ?>
                                        <?php if ($user->svm_id == $session->client['svm_id']) {
                                            if ($user->svm_verified_email == 0) { ?>
                                                <i class="fa fa-times text-danger"></i>
                                            <?php } else { ?>
                                                <i class="fa fa-check text-success"></i>
                                        <?php }
                                        } ?>
                                    </div>
                                </div>
                            </h5>
                            <div class="row">
                                <div class="col-md-6">
                                </div>
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-outline-primary" id="details" href="" onclick="return false;">Profile Edit</button>
                                </div>
                            </div>
                        </div>
                        <div class="pb-5">
                            <h1>Bank Details</h1>
                            <h2>
                                <div class="row">
                                    <div class="col-md-6">
                                        <i class="fa fa-university"></i> Bank Holder Name :-
                                    </div>
                                    <div id="holdername" class="col-md-6">
                                        <?php echo (!empty($user->sbm_holder_name) ? $user->sbm_holder_name : '-'); ?>
                                    </div>
                                </div>
                            </h2>
                            <h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <i class="fa fa-sort-numeric-asc"></i> Bank Account Number :-
                                    </div>
                                    <div id="accountnumber" class="col-md-6">
                                        <?php echo (!empty($user->sbm_account_no) ? $user->sbm_account_no : '-'); ?>
                                    </div>
                                </div>
                            </h4>
                            <h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <i class="fa fa-code"></i> Bank Ifsc Code :-
                                    </div>
                                    <div id="ifsccode" class="col-md-6">
                                        <?php echo (!empty($user->sbm_ifsc_code) ? $user->sbm_ifsc_code : '-'); ?>
                                    </div>
                                </div>
                            </h5>
                            <div class="row">
                                <div class="col-md-6">
                                </div>
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-outline-primary" id="bank" href="" onclick="return false;">Edit Bank Details</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="Details">
    <div class="modal-body">
        <p id="resultMessagefalse"></p>
        <form method="POST" id="EditDetalis" novalidate>
            <div class="form-row">
                <div class="col-md-4 mb-3">
                    <label for="edfName">Name</label>
                    <input type="text" name="edfName" class="form-control" id="edfName" placeholder="Name">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="eduName">User Name</label>
                    <input type="text" name="eduName" class="form-control" disabled id="eduName" placeholder="Name">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="edcompany">Company Name</label>
                    <input type="text" name="edcompany" class="form-control" id="edcompany" placeholder="Company Name">
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-4 mb-3">
                    <label for="edemail">Email Address</label>
                    <input type="email" name="edemail" class="form-control" disabled id="edemail" placeholder="Email Address">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="edmobileNo">Mobile Number</label>
                    <input type="number" name="edmobileNo" class="form-control" disabled id="edmobileNo" placeholder="Mobile Number">
                </div>
            </div>
            <button class="btn btn-primary" id="edit" type="submit">Add</button>
        </form>
    </div>
</div>
<div id="BankAdd">
    <div class="modal-body">
        <p id="resultMessagefalse"></p>
        <form method="POST" id="BankDetails" novalidate>
            <input type="hidden" value="" id="sbm_id" />
            <input type="hidden" value="" id="svm_id" />
            <div class="form-row">
                <div class="col-md-12 mb-3">
                    <label for="bankholdername">Bank Holder Name</label>
                    <input type="text" name="bankholdername" class="form-control" id="bankholdername" placeholder="Bank Holder Name">
                </div>
                <div class="col-md-12 mb-3">
                    <label for="bankaccountnumber">Bank Account Number</label>
                    <input type="text" name="bankaccountnumber" class="form-control" id="bankaccountnumber" placeholder="Bank Account Number">
                </div>
                <div class="col-md-12 mb-3">
                    <label for="bankifsccode">Bank IFSC Code</label>
                    <input type="text" name="bankifsccode" class="form-control" id="bankifsccode" placeholder="Bank IFSC Code">
                </div>
            </div>
            <button class="btn btn-primary" type="submit">Add</button>
        </form>
    </div>
</div>