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
                        <?php $lead_by = $_SESSION['vendor']['vendor_id'];?>
                        <?php if (($accept > 0) || ($lead_by === $leadDetails['lead_by_vendor'])): ?>
                        <small class="text-muted">Customer Name </small>
                        <h6><?php echo $customer['customer_name'] ?></h6>
                        <small class="text-muted">Customer Email </small>
                        <h6><?php echo $customer['customer_email'] ?></h6>
                        <small class="text-muted p-t-30 db">Customer Phone</small>
                        <h6><?php echo $customer['customer_phone'] ?></h6>
                        <small class="text-muted p-t-30 db">Address</small>
                        <h6><?php if(!empty($customer['customer_address'])){
                            $address = json_decode($customer['customer_address']);
                        }
                        if(!empty($address)){
                            echo $address->address . ',' . $address->city . ',' . $address->state . ',' . $address->country . ',' . $address->zipcode;
                         } ?></h6>
                         <?php else: ?>

                         <h6>For Customer details first you need to accept lead.</h6>

                         <?php endif?>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title"><?php echo ucwords('Assign To'); ?></h4>
                        <hr>
                        <?php if (!empty($vendor->vendor_name)) : ?>
                            <small class="text-muted">Vendor Name </small>
                            <h6><?php echo $vendor->vendor_name ?></h6>
                            <?php if($lead_by === $leadDetails['lead_by_vendor']): ?>
                            <?php else:?>
                            <small class="text-muted">Vendor Email </small>
                            <h6><?php echo $vendor->vendor_email ?></h6>
                            <small class="text-muted p-t-30 db">Customer Phone</small>
                            <h6><?php echo $vendor->vendor_phone ?></h6>
                            <?php endif?>
                            <hr>
                <?php endif?>
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
                                <h4 class="card-title"><?php echo ucwords('Lead Details'); ?></h4>

                            </div>
                            <div class="col-lg-8 col-sm-12">
                            <?php if ($accept > 0): ?>

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
                                <button class="btn btn-success btn-sm float-right" onclick="change_status(<?= $leadDetails['lead_id']?>)">Change Status</button>
<?php elseif($lead_by === $leadDetails['lead_by_vendor']): ?>

<?php else:?>
    <button class="btn btn-success float-right" onclick="accept_lead(<?= $leadDetails['lead_id']?>)">Accept</button>

                                <?php endif?>
                            </div>
                        </div>
                        <hr>

                        <div class="form-row">
                         
                            <div class="col-md-4 mb-3">
                                <small class="text-muted">Lead Main Service</small>
                                <h5>
                                    <?php echo ucwords($leadDetails['lead_maincat_name']); ?>
                                </h5>
                            </div>
                            <div class="col-md-4 mb-3">
                            <small class="text-muted">Lead Sub Service</small>
                        <h5>
                            <?php echo ucwords($leadDetails['lead_subcat_name']); ?>
                        </h5>
                            </div>
                            <div class="col-md-4 mb-3">
                            <small class="text-muted">Lead Value</small>
                        <h5>
                            <?php echo ucwords($leadDetails['lead_value']); ?>
                        </h5>
                            </div>
                            <div class="col-md-4 mb-3">
                            
                            <small class="text-muted">Lead Source</small>
                            <h5>
                                <?= ucwords($leadsource[0]->lead_source_name); ?>
                            </h5>
                                </div>
                            <div class="col-md-4 mb-3">
                            
                        <small class="text-muted">Lead Documents</small>
                        <h5>
                            <?php if(empty($leadDetails['lead_documents'])):?>
                               <a>No document uploaded.</a>
                            <?php else:?>
                                <?= "<a href=".base_url().LEADS_DOCUMENT_DOWNLOAD.ucwords($leadDetails['lead_documents'])." download>Download File</a>" ?>
                            <?php endif?>
                        </h5>
                            </div>
                            <div class="col-md-4 mb-3">
                            
                            <small class="text-muted">Lead Source</small>
                            <h5>
                                <?= date("d/m/Y",strtotime($leadDetails['lead_creted_at'])) ?>
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

                <?php if(!empty($comments)):?>

                                            <?php foreach($comments as $row):?>
                                                <li <?= (!empty($userdata['vendor_slug'])) ? (($userdata['vendor_slug'] == $row['vendor_m_id']) ? 'class="reverse"':''):'' ?>>
                                                <div class="chat-img"><img src="<?= base_url('assets/images/users/236832.png')?>" alt="user" /></div>

                                                <div class="chat-content">
                                                    <h5><?= !empty($row['vendor_name']) ? $row['vendor_name']:''?><?= !empty($row['admin_name']) ? $row['admin_name']:''?></h5>
                                                    <div class="box bg-light-info"><?= $row['comments']?></div>
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
                                            <form class="form-phone" name="frm" method="post" enctype="multipart/form-data" id="comments" action="">
                                            <input type="hidden" class="form-control" id="lead_m_id" name="lead_m_id" value="<?=(!empty($leadDetails['lead_id'])) ? $leadDetails['lead_id']:''?>">

                                                <textarea name="comments" id="comment_msg" placeholder="Type your message here" class="form-control border-0"></textarea>
                                            </div>
                                            <div class="col-4 text-right">
                                                <button  type="button"  id="comment" class="btn btn-info btn-circle btn-lg"><i class="fas fa-paper-plane"></i> </button>
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

       <input type="hidden" class="form-control" id="lead_id" name="lead_id" value="<?=(!empty($leadDetails['lead_id'])) ? $leadDetails['lead_id']:''?>">


   <div class="col-md-6 mb-3">
                        <label for="changestatus">Change Status</label>
                        <select id="change_value" class="form-control form-control-line" name="change_status">
                            <?php foreach ($lead_status as $status):?>
                                <option value="<?=$status['status_id']?>" <?=($status['status_id'] == $leadDetails['lead_status']?'selected' :'') ?>><?=$status['status_name']?></option>

                            <?php endforeach;?>

                        </select>
                    </div>    
                   
        <button  type="button"  id="status_button" class="btn btn-info btn-rounded m-t-10 float-right" >Submit</button>                   
</form>
       </div>
       <div class="modal-footer">
           <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
       </div>
   </div>
</div>