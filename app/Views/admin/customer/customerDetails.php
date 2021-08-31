
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
                            <h4 class="card-title m-t-10"><?php echo ucwords($customer['customer_name']); ?></h4>
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
                        <h6><?php echo $customer['customer_email'] ?></h6> <small class="text-muted p-t-30 db">Phone</small>
                        <h6><?php echo $customer['customer_phone'] ?></h6>
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
                        <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#details" role="tab">Details</a> </li>
                        <li class="nav-item"> <a class="nav-link " data-toggle="tab" href="#leads" role="tab">Leads</a> </li>

                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">

                        <!--second tab-->


                        <div class="tab-pane active" id="details" role="tabpanel">
                            <div class="card-body">
                                <form class="form-horizontal form-material" action="<?php echo base_url('admin/customerupdate') ?>" method="post" enctype="multipart/form-data">
                                    <div class="form-row">

                                        <input type="hidden" name="customer_id" value="<?= $customer['customer_id'] ?>">

                                        <div class="col-md-6 mb-5">
                                            <label for="companyname">Company Name</label>
                                            <input type="text" placeholder="Company Name" name="customer_compnay" class="form-control form-control-line" value="<?= $customer['customer_company'] ?>">
                                        </div>
                                        <div class="col-md-6 mb-5">
                                            <label for="companyname">Company Position</label>
                                            <input type="text" placeholder="Company Postition" name="customer_position" class="form-control form-control-line" value="<?= $customer['customer_position'] ?>">
                                        </div>
                                       
                                        <div class="col-md-6 mb-5">
                                            <label for="companyname">Email Id</label>
                                            <input type="text" placeholder="Company Name" name="customer_email" class="form-control form-control-line" value="<?= $customer['customer_email'] ?>">
                                        </div>
                                        <div class="col-md-6 mb-5">
                                            <label for="companyname">Phone Number</label>
                                            <input type="text" placeholder="Company Phone" name="customer_phone" class="form-control form-control-line" value="<?= $customer['customer_phone'] ?>">
                                        </div>
                                        <div class="col-md-6 mb-5">
                                            <label for="companyname">Address</label>
                                            <?php $address = json_decode($customer['customer_address']);?>
                                            <input type="text" placeholder="Address" name="address" class="form-control form-control-line" value="<?= $address->address?>">
                                        </div>
                                        <div class="col-md-6 mb-5">
                                            <label for="companyname">Address</label>
                                            <input type="text" placeholder="City" name="city" class="form-control form-control-line" value="<?= $address->city?>">
                                        </div>
                                        <div class="col-md-6 mb-5">
                                            <label for="companyname">City</label>
                                            <input type="text" placeholder="State" name="state" class="form-control form-control-line" value="<?= $address->state?>">
                                        </div>
                                        <div class="col-md-6 mb-5">
                                            <label for="companyname">Zipcode</label>
                                            <input type="text" placeholder="Zip Code" name="zipcode" class="form-control form-control-line" value="<?= $address->zipcode?>">
                                        </div>
                                        <div class="col-md-6 mb-5">
                                            <label for="companyname">Country</label>
                                            <input type="text" placeholder="Country" name="country" class="form-control form-control-line" value="<?= $address->country?>">
                                        </div>
                                    </div>

                                   
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <button class="btn btn-success">Update Details</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="tab-pane" id="leads" role="tabpanel">
                            <div class="card-body">
                                
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