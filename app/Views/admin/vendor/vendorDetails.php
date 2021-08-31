<?php echo $adminMenu; ?>

<!-- ============================================================== -->
<!-- Page wrapper  -->
<!-- ============================================================== -->
<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Profile</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Profile</li>
                    </ol>
                   
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Start Page Content -->
        <!-- ============================================================== -->
        <!-- Row -->
        <div class="row">
            <!-- Column -->
            <div class="col-lg-4 col-xlg-3 col-md-5">
                <div class="card">
                    <div class="card-body">
                        <center class="m-t-30"> <img id="UserImage" src="<?php echo getBackendImageUrl('avatar.png') ?>" class="img-circle" width="150" />
                            <h4 class="card-title m-t-10"><?php echo ucwords($vendor['vendor_name']); ?><?php echo ($vendor['vendor_status'] == 'active') ? ' <i class="fas fa-check-circle text-success" title=' . ucwords($vendor['vendor_status']) . '></i>' : ' <i class="fas fa-times-circle text-danger

" title=' . ucwords($vendor['vendor_status']) . '></i>' ?></h4>
                            <h6 class="card-subtitle"></h6>
                            <!-- <div class="row text-center justify-content-md-center">
                                        <div class="col-4"><a href="javascript:void(0)" class="link"><i class="icon-people"></i> <font class="font-medium">254</font></a></div>
                                        <div class="col-4"><a href="javascript:void(0)" class="link"><i class="icon-picture"></i> <font class="font-medium">54</font></a></div>
                                    </div> -->
                        </center>
                    </div>
                    <div>
                        <hr>
                    </div>
                    <div class="card-body"> <small class="text-muted">Email address </small>
                        <h6><?php echo $vendor['vendor_email'] ?></h6> <small class="text-muted p-t-30 db">Phone</small>
                        <h6><?php echo $vendor['vendor_phone'] ?></h6>
                        <!-- <small class="text-muted p-t-30 db">Address</small> -->
                        <h6></h6>
                        <!-- <div class="map-box">
                                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d470029.1604841957!2d72.29955005258641!3d23.019996818380896!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x395e848aba5bd449%3A0x4fcedd11614f6516!2sAhmedabad%2C+Gujarat!5e0!3m2!1sen!2sin!4v1493204785508" width="100%" height="150" frameborder="0" style="border:0" allowfullscreen></iframe>
                                </div> <small class="text-muted p-t-30 db">Social Profile</small> -->
                        <br />
                        <!-- <button class="btn btn-circle btn-secondary"><i class="fab fa-facebook-f"></i></button>
                                <button class="btn btn-circle btn-secondary"><i class="fab fa-twitter"></i></button>
                                <button class="btn btn-circle btn-secondary"><i class="fab fa-youtube"></i></button> -->
                    </div>
                </div>
            </div>
            <!-- Column -->
            <!-- Column -->
            <div class="col-lg-8 col-xlg-9 col-md-7">
                <div class="card">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs profile-tab" role="tablist">
                        <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#companydetails" role="tab">Company Details</a> </li>
                        <li class="nav-item"> <a class="nav-link " data-toggle="tab" href="#profile" role="tab">Profile</a> </li>

                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">

                        <!--second tab-->


                        <div class="tab-pane active" id="companydetails" role="tabpanel">
                            <div class="card-body">
                                <form class="form-horizontal form-material" action="<?php echo base_url('admin/vendorcompany') ?>" method="post" enctype="multipart/form-data">
                                    <div class="form-row">
                                        <input type="hidden" name="vendor_slug" value="<?= $vendor['vendor_slug'] ?>">

                                        <input type="hidden" name="vendor_m_id" id="vendor_m_id" value="<?= $vendor['vendor_id'] ?>">
                                        <div class="col-md-6 mb-3">
                                            <label for="vendortype">Vendor Type</label>
                                            <select class="form-control form-control-line" name="vendor_type">
                                                <option value="">Select Type</option>

                                                <option value="public" <?= (!empty($vendor_details['vendor_type'])) ? ($vendor_details['vendor_type'] == 'public' ? 'selected' : '') : '' ?>>Public</option>
                                                <option value="private" <?= (!empty($vendor_details['vendor_type'])) ? ($vendor_details['vendor_type'] == 'private' ? 'selected' : '') : ''  ?>>Private</option>
                                                <option value="proprietorship" <?= (!empty($vendor_details['vendor_type'])) ? ($vendor_details['vendor_type'] == 'proprietorship' ? 'selected' : '') : ''  ?>>Proprietorship</option>

                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-5">
                                            <label for="companyname">Company Name</label>
                                            <input type="text" placeholder="Company Name" name="vendor_compnay" class="form-control form-control-line" value="<?= (!empty($vendor_details['vendor_compnay'])? $vendor_details['vendor_compnay'] :'') ?>">
                                        </div>
                                        <div class="col-md-4 mb-4">
                                            <label for="companypan">Company Pan</label>
                                            <input type="text" placeholder="Company Pan" name="vendor_pancard" class="form-control form-control-line" value="<?= (!empty($vendor_details['vendor_compnay'])? $vendor_details['vendor_pancard'] :'') ?>">
                                        </div>
                                        <div class="col-md-4 mb-4">
                                            <label for="companygst">Company GST</label>
                                            <input type="text" placeholder="Company GST" name="vendor_gst" class="form-control form-control-line" value="<?=  (!empty($vendor_details['vendor_compnay'])? $vendor_details['vendor_gst'] :'') ?>">
                                        </div>
                                        <div class="col-md-4 mb-5">
                                            <label for="companycin">Company CIN</label>
                                            <input type="text" placeholder="Company CIN" name="vendor_cin" class="form-control form-control-line" value="<?=  (!empty($vendor_details['vendor_compnay'])? $vendor_details['vendor_cin'] :'')?>">
                                        </div>

                                    </div>

                                    <div class="form-row mb-5">
                                        <div class="col-md-4 mb-3">
                                            <label for="bankname">Bank Name</label>
                                            <?php $bank = json_decode((!empty($vendor_details['vendor_bankdetails'])? $vendor_details['vendor_bankdetails'] :'')); ?>
                                            <input type="text" name="bank_name" class="form-control" value="<?= (!empty($bank->bankname)? $bank->bankname:'') ?>" placeholder="Bank Name">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="Bankac">Bank Account Number</label>
                                            <input type="text" name="bank_number" class="form-control" value="<?= (!empty($bank->bankaccountnumber)? $bank->bankaccountnumber:'') ?>" placeholder="Bank Account Number">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="ifsc">IFSC Code</label>
                                            <input type="text" name="ifsc_code" class="form-control" value="<?= (!empty($bank->ifsccode)? $bank->ifsccode:'')?>" placeholder="IFSC Code">
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                            <label for="ifsc">Vendor Commission</label>
                                            <input type="text" name="vendor_commission" class="form-control" value="<?= (!empty($vendor_details['vendor_commission'])? $vendor_details['vendor_commission']:'')?>" placeholder="commission">
                                        </div>
                                    <?php $cat = json_decode((!empty($vendor_details['vendor_categoriers'])? $vendor_details['vendor_categoriers'] :'')) ?>


                                    <div class="form-row">
                                        <div class="col-md-6 mb-3">
                                            <label for="mainservices">Main Services</label>
                                            <select id="first_level" name="main_cat[]"  multiple>
                                                <?php foreach ($main_cat as $mc) : ?>

                                                    <option value="<?php echo $mc['cat_name'] ?>" <?php if(!empty($cat->main_cat)):?><?php foreach ($cat->main_cat as $sl) : ?> <?php if ($mc['cat_name'] == $sl) {
                                                                                                                                                    echo "selected";
                                                                                                                                                } ?> <?php endforeach ?><?php endif?>><?php echo $mc['cat_name'] ?></option>

                                                <?php endforeach ?>


                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="mainservices">Parent Services</label>
                                            <select id="second_level" class="selectpicker form-control form-control-line" name="sub_cat[]" multiple>

                                                <?php if(!empty($cat->sub_cat)):?>
                                                <?php foreach ($cat->sub_cat as $sub_cat):?>
                                                <option value="<?php echo $sub_cat ?>" selected><?php echo $sub_cat ?></option>
                                                <?php endforeach;?>
                                                <?php endif?>
                                            </select>
                                        </div>
                                    </div>
                                    <script>
                                    </script>
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <button class="btn btn-success">Update Details</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="tab-pane" id="profile" role="tabpanel">
                            <div class="card-body">
                                <form class="form-horizontal form-material"  action="<?php echo base_url('admin/addvendor') ?>" method="post" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label class="col-md-12">Full Name</label>
                                        <div class="col-md-12">
                                            <input type="hidden" name="vendor_id" value="<?= $vendor['vendor_id'] ?>">
                                            <input type="text" name="vendor_name" value="<?= $vendor['vendor_name'] ?>" class="form-control form-control-line">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="example-email" class="col-md-12">Email</label>
                                        <div class="col-md-12">
                                            <input type="email" class="form-control form-control-line" name="vendor_email" value="<?= $vendor['vendor_email'] ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Password</label>
                                        <div class="col-md-12">
                                            <input type="password" name="password" class="form-control form-control-line">
                                            <small id="noteMsg" class="text-info">If You Enter Any Value In Password The Password Will Change. </small>

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Phone No</label>
                                        <div class="col-md-12">
                                            <input type="text" value="<?= $vendor['vendor_phone'] ?>" class="form-control form-control-line">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-12">Status</label>
                                        <div class="col-sm-12">
                                            <select class="form-control form-control-line" name="vendor_status">
                                                <option value="active" <?= $vendor['vendor_status'] == 'active' ? 'selected' : '' ?>>Active</option>
                                                <option value="deactivate" <?= $vendor['vendor_status'] == 'deactivate' ? 'selected' : '' ?>>Deactivated</option>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <button class="btn btn-success">Update Profile</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- Column -->
        </div>
        <!-- Row -->
        <!-- ============================================================== -->
        <!-- End PAge Content -->
        <!-- ============================================================== -->

    </div>
</div>