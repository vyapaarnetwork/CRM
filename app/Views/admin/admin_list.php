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
                        <h4 class="card-title">Admin List</h4>
                        <button type="button" class="btn btn-info btn-rounded m-t-10 m-b-10 float-right" data-toggle="modal" data-target="#add_admin">Add New Admin</button>
                        <div class="table-responsive m-t-40">
                            <table id="adminTableList" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>
                                            <input type="checkbox" class="custom-control-input m-t-10" id="all" name="categories[]">
                                        </th>
                                        <th>Name</th>
                                            <th>User Name</th>
                                            <th>Email</th>
                                            <th>Mobile Number</th>
                                            <th>Admin Type</th>
                                            <th>Status</th>
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
<div id="add_admin" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
       <div class="modal-header">
              <h4 class="modal-title" id="admin_label">Add Admin</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>

       </div>
       <div class="modal-body ">

       <p id="resultMessage"></p>
        <form method="POST" id="adminData" novalidate>
            <input type="hidden" name="admin_id" id="admin_id" value="">
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
                    <label for="uName">User Name</label>
                    <input type="text" name="uName" class="form-control" id="uName" placeholder="User name">
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-4 mb-3">
                    <label for="email">Email Address</label>
                    <input type="email" name="email" class="form-control" id="email" placeholder="Email Address">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="mobileNo">Mobile Number</label>
                    <input type="number" name="mobileNo" class="form-control" id="mobileNo" placeholder="Mobile Number">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="type">Admin Type</label>
                    <select name="type" class="form-control required" id="type">
                        <option value="">Select</option>
                        <option value="super">Super Admin</option>
                        <option value="staff">Staff</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-12 text-center">
                    <small id="noteMsg" class="text-info" style="display: none;">
                        If You Enter Any Value In Password And Confirm Password The Password Will Change.
                    </small>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control" id="password" placeholder="Password">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="cpassword">Confirm Password</label>
                    <input type="password" name="cpassword" class="form-control" id="cpassword" placeholder="Confirm Password">
                </div>
            </div>
            <button class="btn btn-primary" id="addAdmin" type="submit">Submit</button>
        </form>
       </div>
       <div class="modal-footer">
           <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
       </div>
   </div>
</div>
</div>
