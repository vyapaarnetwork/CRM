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
                        <button type="button" class="btn btn-info btn-rounded m-t-10 m-b-10 float-right" data-toggle="modal" data-target="#add_customer">Add New Customer</button>
                        <div class="table-responsive m-t-40">
                            <table id="adminTableList" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>
                                            <input type="checkbox" class="custom-control-input m-t-10" id="all" name="vendors[]">
                                        </th>
                                            <th>Customer Name</th>
                                            <th>Email</th>
                                            <th>Phone Number</th>
                                            <th>Company Name</th>
                                            <th>Created</th>

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
<div id="add_customer" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
       <div class="modal-header">
              <h4 class="modal-title" id="customer_label">Add Customer</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>

       </div>
       <div class="modal-body ">

       <p id="resultMessage"></p>
        <form method="POST" id="customerData" novalidate>
            <input type="hidden" name="customer_id" id="customer_id" value="">
            <div class="form-row">
                <div class="col-md-4 mb-3">
                    <label for="fName">First Name</label>
                    <input type="text" name="fName" class="form-control" id="fName" placeholder="First name">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="lName">Last Name</label>
                    <input type="text" name="lName" class="form-control" id="lName" placeholder="Last name">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="email">Email Address</label>
                    <input type="email" name="email" class="form-control" id="email" placeholder="Email Address">
                </div>
           
            </div>
            <div class="form-row">
            
                <div class="col-md-4 mb-3">
                    <label for="mobileNo">Mobile Number</label>
                    <input type="number" name="mobileNo" class="form-control" id="mobileNo" placeholder="Mobile Number">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="companyname">Company Name</label><small> (Optinal)</small>
                    <input type="text" name="customer_company" class="form-control" id="customer_company" placeholder="Enter Company Name">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="companyname">Customer Postition</label><small> (Optinal)</small>
                    <input type="text" name="customer_position" class="form-control" id="customer_position" placeholder="Enter Current Postition">
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-4 mb-3">
                    <label for="address">Address</label>
                    <textarea class="form-control" id="address" name="address"></textarea>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="city">City</label>
                    <select class="form-control" id='city' name="city" style="width: 100%" require>
                        <option value="">Select State First</option>
                    </select>                </div>
                <div class="col-md-4 mb-3">
                    <label for="State">State</label>
                    <select class="form-control" id='state' name="state" style="width: 100%" require>
                        <option value="">Select Country First</option>
                    </select>                </div>
           
            </div>
            <div class="form-row">
               
                <div class="col-md-4 mb-3">
                    <label for="zipcode">Zip Code</label>
                    <input type="text" name="zipcode" class="form-control" id="zipcode" placeholder="Zip Code">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="county">Country</label>
                    <select class="form-control" id='country' name="country" style="width: 100%" require>
                        <?php foreach ($country as $cu):?>

                            <option value="<?=$cu['name']?>"><?=$cu['name']?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
        
        
           
            </div>
          
            <button class="btn btn-primary" id="addCustomer" type="submit">Submit</button>
        </form>
       </div>
       <div class="modal-footer">
           <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
       </div>
   </div>
</div>
</div>
