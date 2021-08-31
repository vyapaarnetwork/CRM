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
                <h4 class="text-themecolor"><?php echo ucwords($title); ?></h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active"><?php echo ucwords($title); ?></li>
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
                        <h4 class="card-title"><?php echo ucwords('Customer Details'); ?></h4>
                        <hr>
                        <small class="text-muted">Customer Name </small>
                        <h6><?php echo $customer['customer_name'] ?></h6>
                        <small class="text-muted">Customer Email </small>
                        <h6><?php echo $customer['customer_email'] ?></h6>
                        <small class="text-muted p-t-30 db">Customer Phone</small>
                        <h6><?php echo $customer['customer_phone'] ?></h6>
                        <small class="text-muted p-t-30 db">Address</small>
                        <h6><?php if (!empty($customer['customer_address'])) {
                                $address = json_decode($customer['customer_address']);
                            }
                            if (!empty($address)) {
                                echo $address->address . ',' . $address->city . ',' . $address->state . ',' . $address->country . ',' . $address->zipcode;
                            } ?></h6>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title"><?php echo ucwords('Vendor Details'); ?></h4>
                        <hr>
                        <?php if (!empty($vendor->vendor_name)) : ?>
                            <small class="text-muted">Vendor Name </small>
                            <h6><?php echo $vendor->vendor_name ?></h6>
                            <small class="text-muted">Vendor Email </small>
                            <h6><?php echo $vendor->vendor_email ?></h6>
                            <small class="text-muted p-t-30 db">Customer Phone</small>
                            <h6><?php echo $vendor->vendor_phone ?></h6>
                            <hr>
                            <center>
                                <button class="btn btn-success btn-sm"
                                        onclick="location.href='<?php echo base_url('admin/VendorDetails') . '/' . $vendor->vendor_slug ?>'">
                                    View More Details
                                </button>
                            </center>
                            </center>
                        <?php else : ?>
                            <div style="text-align: center;">
                                <button class="btn btn-success btn-sm"
                                        onclick="assign_lead(<?= $leadDetails['lead_id'] ?>)">Assign Lead
                                </button>
                            </div>
                        <?php endif ?>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <!-- Column -->
            <div class="col-lg-8 col-xlg-9 col-md-7">
                <div class="card">
                    <!-- Nav tabs -->

                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4 col-sm-12">
                                <h4 class="card-title"><?php echo ucwords('Lead Details'); ?>
                                    <small class="btn btn-sm btn-warning">Hold</small></h4>


                            </div>
                            <div class="col-lg-8 col-sm-12">

                                <h5 class="float-left">Lead Status:</h5>
                                <h5 class="float-left"><?php
                                    $qurey = array(
                                            'table' => 'tblleads_status',
                                            'where' => array('status_id' => $leadDetails['lead_status']),
                                         'object_data' => '1'
                                    );
                                    $status = get_dbdata($qurey);

                                   echo $status[0]->status_name;

                                    ?></h5>
                                <button class="btn btn-success btn-sm float-right"
                                        onclick="change_status(<?= $leadDetails['lead_id'] ?>)">Change Status
                                </button>
                            </div>
                        </div>
                        <hr>

                        <div class="form-row">

                            <div class="col-md-3 mb-3">
                                <small class="text-muted">Lead Main Service</small>
                                <h5>
                                    <?php echo ucwords($leadDetails['lead_maincat_name']); ?>
                                </h5>
                            </div>
                            <div class="col-md-3 mb-3">
                                <small class="text-muted">Lead Sub Service</small>
                                <h5>
                                    <?php echo ucwords($leadDetails['lead_subcat_name']); ?>
                                </h5>
                            </div>
                            <div class="col-md-3 mb-3">
                                <small class="text-muted">Lead Value</small>
                                <h5>
                                    <?= ucwords($leadDetails['lead_value']); ?>
                                </h5>
                            </div>
                            <div class="col-md-3 mb-3">
                                <small class="text-muted">Vyapaar Commission</small>
                                <h5>
                                    <?= (!empty($leadDetails['lead_commission'])) ? round($leadDetails['lead_value'] * $leadDetails['lead_commission']/100) . ' (' . $leadDetails['lead_commission'] . '%)' : 'Commission Not Set' ?>
                                </h5>
                            </div>
                            <div class="col-md-3 mb-3">

                                <small class="text-muted">Lead Source</small>
                                <h5>
                                    <?= ucwords($leadsource[0]->lead_source_name); ?> <?php if (!empty($leadDetails['lead_by_vendor'])): ?>
                                        <?php $qurey = array(

                                            'table' => array('tblvendor_master'),
                                            'where' => array('vendor_id' => $leadDetails['lead_by_vendor']),
                                            'object_data' => '1'
                                        );

                                        $vendor = get_dbdata($qurey);


                                        ?>
                                        <button class="btn btn-warning btn-sm"
                                                onclick="location.href='<?php echo base_url('admin/VendorDetails') . '/' . $vendor[0]->vendor_slug ?>'"><?= $vendor[0]->vendor_name ?></button><?php endif ?>
                                </h5>
                            </div>
                            <div class="col-md-6 mb-3">

                                <small class="text-muted">Lead Documents</small>
                                <h5>
                                    <?php if(empty($leadDetails['lead_documents'])):?>
                                    <input type="file" id="file-to-upload" />
                                    <button id="upload-button">Upload</button>
<?php else:?>
                                    <?= "<a href=".base_url().LEADS_DOCUMENT_DOWNLOAD.ucwords($leadDetails['lead_documents'])." download>Download File</a>" ?>
                                    <?php endif?>
                                </h5>
                            </div>
                            <div class="col-md-3 mb-3">

                                <small class="text-muted">Lead Source</small>
                                <h5>
                                    <?= date("d/m/Y", strtotime($leadDetails['lead_creted_at'])) ?>
                                </h5>
                            </div>
                            <div class="col-md-12 mb-3">
                                <small class="text-muted">Lead Description</small>
                                <h5>
                                    <?php echo ucwords($leadDetails['lead_description']); ?>
                                </h5>
                            </div>

                        </div>


                    </div>


                </div>
                <div class="card chat-main-box">

                    <!-- .chat-right-panel -->
                    <div class="chat-rbox">
                        <ul class="chat-list p-3">
                            <!--chat Row -->

                            <?php if (!empty($comments)) : ?>

                                <?php foreach ($comments as $row) : ?>

                                    <li <?= (!empty($userdata['admin_slug'])) ? (($userdata['admin_slug'] == $row['admin_m_id']) ? 'class="reverse"' : '') : '' ?>>
                                        <div class="chat-content">
                                            <div class="chat-img"><img
                                                        src="<?= base_url('assets/images/users/236832.png') ?>"
                                                        alt="user"/></div>

                                            <div class="chat-content">
                                                <h5><?= !empty($row['vendor_name']) ? $row['vendor_name'] : '' ?><?= !empty($row['admin_name']) ? $row['admin_name'] : '' ?></h5>
                                                <div class="box bg-light-info"><?= $row['comments'] ?></div>
                                                <div class="chat-time"><?= date("d/m/Y h:i:s", strtotime($row['created_at'])) ?></div>
                                            </div>

                                    </li>

                                <?php endforeach ?>
                            <?php endif ?>
                            <!--chat Row -->
                        </ul>
                    </div>
                    <div class="card-body border-top">
                        <div class="row">
                            <div class="col-8">
                                <form class="form-phone" name="frm" method="post" enctype="multipart/form-data"
                                      id="comments" action="">
                                    <input type="hidden" class="form-control" id="admin_m_id" name="admin_m_id"
                                           value="<?= (!empty($userdata['admin_id'])) ? $userdata['admin_id'] : '' ?>">
                                    <input type="hidden" class="form-control" id="lead_m_id" name="lead_m_id"
                                           value="<?= (!empty($leadDetails['lead_id'])) ? $leadDetails['lead_id'] : '' ?>">

                                    <textarea name="comments" id="comment_msg" placeholder="Type your message here"
                                              class="form-control border-0"></textarea>
                            </div>
                            <div class="col-4 text-right">
                                <button type="button" id="comment" class="btn btn-info btn-circle btn-lg"><i
                                            class="fas fa-paper-plane"></i></button>
                            </div>
                            </form>
                        </div>
                    </div>
                    <!-- .chat-right-panel -->

                </div>

                <!-- /.chat-row -->
            </div>
            <!-- Column -->

        </div>
        <!-- Row -->
        <!-- ============================================================== -->
        <!-- End PAge Content -->
        <!-- ============================================================== -->

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

<!-- Chnage Status -->
<div id="status_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="status_label">Update Lead Status</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <div class="modal-body">

                <form class="form-phone" name="frm" method="post" enctype="multipart/form-data" id="assign_v" action="">

                    <input type="hidden" class="form-control" id="lead_id" name="lead_id"
                           value="<?= (!empty($leadDetails['lead_id'])) ? $leadDetails['lead_id'] : '' ?>">


                    <div class="col-md-6 mb-3">
                        <label for="changestatus">Change Status</label>
                        <select id="change_value" class="form-control form-control-line" name="change_status">
                            <?php foreach ($lead_status as $status):?>
                            <option value="<?=$status['status_id']?>" <?=($status['status_id'] == $leadDetails['lead_status']?'selected' :'') ?>><?=$status['status_name']?></option>

                            <?php endforeach;?>
<!--                            <option value="qualification">Qualification</option>-->
<!--                            <option value="need_analysis">Need Analysis</option>-->
<!--                            <option value="proposal">Proposal/Price Quote</option>-->
<!--                            <option value="review">Negotiation/Review</option>-->
<!--                            <option value="close_won">Close Won</option>-->
<!--                            <option value="close_lost">Close Lost</option>-->


                        </select>
                    </div>

                    <button type="button" id="status_button" class="btn btn-info btn-rounded m-t-10 float-right">
                        Submit
                    </button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>