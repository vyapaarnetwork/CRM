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
                <h4 class="text-themecolor"><?php echo $title ?></h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active"><?php echo $title ?></li>
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
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title"><?php echo $title ?> List</h4>
                        <button type="button" class="btn btn-info btn-rounded m-t-10 m-b-10 float-right" data-toggle="modal" data-target="#add_leads">Add New Lead</button>
                        <div class="table-responsive m-t-40">
                            <table id="adminTableList" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                   
                                        <th>Lead Number</th>

                                        <th>Customer Name</th>
                                        <th>Source</th>

                                        <th>Lead Assign</th>


                                        <th>Services</th>
                                        <th>Lead Status</th>
                                        <th>Lead Created</th>

                                        <th>Action</th>

                                    </tr>
                                </thead>

                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>



            </div>

        </div>
        <!-- ============================================================== -->
        <!-- End PAge Content -->
        <!-- ============================================================== -->

    </div>
    <!-- ============================================================== -->
    <!-- End Container fluid  -->
    <!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- End Page wrapper  -->
<!-- ============================================================== -->
<!-- Button trigger modal -->



<!-- Modal -->
<div id="add_leads" class="modal fade" role="dialog">
    <div class="modal-dialog  modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="lead_label">Add Leads</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <div class="modal-body">

                <form class="form-horizontal" name="frm" method="post" enctype="multipart/form-data" id="add_lead">
                    <input type="hidden" class="form-control" id="lead_id" name="lead_id">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Customer Type</label>
                                <select class="form-control" name="exiting_customer" id="exiting_customer" require>
                                <option value="">Select Customer</option>

                                
                                    <option value="1">New Customer</option>
                                    <option value="2">Exiting Customer</option>
                                 

                                </select>
                            </div>
                            <div id="exiting_1">
                                <div class="form-group">
                                    <label class="control-label">Customer Name</label>
                                    <input type="text" name="customer_name" id="customer_name" class="form-control" placeholder="Customer Name">
                                </div>


                                <div class="form-group">
                                    <label class="control-label">Customer Company</label>
                                    <input type="text" name="customer_company" id="customer_company" class="form-control" placeholder="Company Name">
                                </div>


                                <div class="form-group">
                                    <label class="control-label">Customer Email</label>
                                    <input type="email" name="customer_email" id="customer_email" class="form-control" placeholder="Email">
                                </div>


                                <div class="form-group">
                                    <label class="control-label">Customer Phone</label>
                                    <input type="text" name="customer_phone" id="customer_phone" class="form-control" placeholder="Phone No.">
                                </div>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div id="exiting_3" style="display: none;">
                                <div class="form-group">
                                    <label for="id_label_single">Search Customer</label>
     

                                    <select class="form-control" id='selcustomer' name="selcustomer" style="width: 100%" require>
                                        <option value="">-- Select Customer-</option>
                                    </select>

                                </div>
                            </div>
                            
                            <div id="exiting_2">
                                <div class="form-group">
                                    <label class="control-label">Customer Address</label>
                                    <input type="text" name="customer_address" id="customer_address" class="form-control" placeholder="Address">
                                </div>


                                <div class="form-group">
                                    <label class="control-label">Customer City</label>
                                    <select class="form-control" id='city' name="city" style="width: 100%" require>
                                        <option value="">Select State First</option>
                                    </select>
                                </div>


                                <div class="form-group">
                                    <label class="control-label">Customer State</label>
                                    <select class="form-control" id='state' name="state" style="width: 100%" require>
                                        <option value="">Select Country First</option>
                                    </select>
                                </div>



                                <div class="form-group">
                                    <label class="control-label">Customer ZipCode</label>
                                    <input type="text" name="customer_zipcode" id="customer_zipcode" class="form-control" placeholder="Zipcode">
                                </div>


                                <div class="form-group">
                                    <label class="control-label">Customer Country</label>
                                    <select class="form-control" id='country' name="country" style="width: 100%" require>
                                   <?php foreach ($country as $cu):?>

                                   <option value="<?=$cu['name']?>"><?=$cu['name']?></option>
                                        <?php endforeach; ?>
                                    </select>

                                </div>

                            </div>
                        </div>
                        <div class="col-md-4 mt-3">
                            <div class="form-group">
                                <label class="control-label">Lead Main Service</label>
                                <!-- <input type="text" name="lead_maincat_name" id="lead_maincat_name" class="form-control" placeholder="Lead Main Service"> -->
                                <select name="lead_maincat_name" id="lead_maincat_name" class="form-control">
                                <option value="">Select Service</option>

                                                <?php foreach ($main_cat as $mc) : ?>

                                                    <option value="<?php echo $mc['cat_name'] ?>"><?php echo $mc['cat_name'] ?></option>

                                                <?php endforeach ?>


                                            </select>
                            </div>
                        </div>
                        <div class="col-md-4 mt-3">
                            <div class="form-group">
                                <label class="control-label">Lead Sub Service</label>
                             
                               <select id="lead_subcat_name" class="form-control" name="lead_subcat_name">
</select>
                               
                            </div>
                        </div>
                        <div class="col-md-4 mt-3">
                            <!-- <div class="form-group">
                                <label for="id_label_single">Lead Assign</label>

                                <select id="lead_assign_id" class="form-control" name="lead_assign_id"></select>

                            </div> -->
                            <div class="form-group">
                                    <label for="id_label_single">Search Vendor</label>
     

                                    <select class="form-control" id='lead_assign_id' name="lead_assign_id" style="width: 100%" require>
                                        <option value="">Select Vendor</option>
                                    </select>

                                </div>
                        </div>
                        <div class="col-md-4 mt-3">
                            <div class="form-group">
                                <label class="control-label">Lead Value</label>
                                <input type="text" name="lead_value" id="lead_value" class="form-control" placeholder="Lead Value">
                            </div>
                        </div>
                        <div class="col-md-4 mt-3">
                            <div class="form-group">
                                <label class="control-label">Lead Commission</label>
                                <input type="text" name="lead_commission" id="lead_commission" class="form-control" placeholder="Lead Commission">
                            </div>
                        </div>
                        <div class="col-md-4 mt-3">
                            <div class="form-group">
                                <label class="control-label">Lead Source</label>
                                <select class="form-control" name="lead_source_id" id="lead_source_id">
                               <?php foreach($lead_source as $lead):?>
                                <option value="<?=$lead['lead_source_id']?>"><?= $lead['lead_source_name']?></option>

                               <?php endforeach ?>
                               
                               </select>
                            </div>
                        </div>

                        <div class="col-md-12 mt-3">
                            <div class="form-group">
                                <label class="control-label">Lead Description</label>
                                <textarea name="lead_description" id="lead_description" class="form-control"></textarea>
                            </div>
                        </div>

                    </div>

                    <button type="button" id="subBtn" class="btn btn-info btn-rounded m-t-10 float-right">Submit</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div> 

<!-- Assign Modal -->
<div id="assign_lead" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="assign_label">Assign Lead Define Services</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <div class="modal-body">

                <form class="form-phone" name="frm" method="post" enctype="multipart/form-data" id="assign_v" action="">

                    <div class="col-md-6 mb-3">
                        <label for="mainservices">Select Vendor</label>
                        <select id="get_vendor" class="form-control form-control-line" name="lead_assign_id">
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label class="control-label">Vyapaar Commission</label>
                            <input type="text" name="lead_commission" id="assign_com" class="form-control" placeholder="Lead Commission">
                        </div>
                    </div>
                   <div id="ref_com"></div>
                    <button type="button" id="assign_button" class="btn btn-info btn-rounded m-t-10 float-right">Submit</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>