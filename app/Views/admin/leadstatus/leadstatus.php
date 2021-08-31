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
                        <h4 class="card-title">Status List</h4>
                        <button type="button" class="btn btn-info btn-rounded m-t-10 m-b-10 float-right" data-toggle="modal" data-target="#add_status">Add New Status</button>
                        <div class="table-responsive m-t-40">
                            <table id="StatusTable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>
                                            <input type="checkbox" class="custom-control-input m-t-10" id="all" name="leadstatus[]">
                                        </th>

                                        <th>ID</th>
                                        <th>Status Name</th>
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
<div id="add_status" class="modal fade" role="dialog">
    <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
       <div class="modal-header">
              <h4 class="modal-title" id="status_label">Add Status</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>

       </div>
       <div class="modal-body">

       <form class="form-phone" name="frm" method="post" enctype="multipart/form-data" id="status_add" action="">
        <input type="hidden" class="form-control" id="status_id" name="status_id">
        <input type="text" class="form-control" id="status_name" name="status_name" required>
        <button  type="button"  id="subBtn" class="btn btn-info btn-rounded m-t-10 float-right" >Submit</button>                   
</form>
       </div>
       <div class="modal-footer">
           <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
       </div>
   </div>
</div>
</div>