<div class="container">
    <div class="row">
        <div class="col-lg-12 mt-3">
            <div class="card">
                <div class="card-body">
                    <span id="errorReturn"></span>
                    <div class="row">
                        <div class="col-lg-12">
                            <span id="errorReturn"></span>
                            <div class="container">
                                <div class="row">
                                    <h1>Lead Details</h1>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <ul>
                                            <li>
                                                <spam class="d-flex justify-content-left"><b>Source Name</b></spam>
                                                <?php echo $leadDetails['sam_name'] ?>
                                            </li>
                                            <li>
                                                <spam class="d-flex justify-content-left"><b>Source</b></spam>
                                                <span class="ml-2"> <?php echo (!empty($leadDetails['slm_source_from']) ? $leadDetails['sam_user_name'] : (!empty($leadDetails['sam_admin_type']) ? ucwords($leadDetails['sam_admin_type']) : 'Staff')) ?></span>
                                            </li>
                                            <li>
                                                <spam class="d-flex justify-content-left"><b>Lead Status</b></spam>
                                                <span class="ml-2">
                                                    <span id="leadstatus"><?php echo $leadDetails['slm_leads_status'] ?></span>
                                                    <a href="javascript:void(0)" id="leadStatusEdit">
                                                        <i title="Edit" class="fa fa-pencil-square-o ml-2"></i>
                                                    </a>
                                                </span>
                                            </li>
                                            <li>
                                                <spam class="d-flex justify-content-left"><b>Lead Value</b></spam>
                                                <spam class="ml-2"><?php echo $leadDetails['slm_leads_value'] ?></spam>
                                            </li>
                                            <?php if (!empty($leadDetails['slm_leads_document']) && file_exists(LEADS_DOCUMENT_PATH . $leadDetails['slm_leads_document'])) { ?>
                                                <li>
                                                    <span class="d-flex justify-content-left"><b>Lead Document</b></span>
                                                    <a class="ml-2" href="<?php echo getBackendUrl('leadsDocument/' . $leadDetails['slm_leads_document']) ?>" download>Download</a>
                                                </li>
                                            <?php }
                                            if (!empty($leadDetails['slm_leads_product_url'])) { ?>
                                                <li>
                                                    <span class="d-flex justify-content-left"><b>Website Product Url</b></span>
                                                    <span class="ml-2"><?php echo $leadDetails['slm_leads_product_url'] ?></span>
                                                </li>
                                            <?php }
                                            if (!empty($leadDetails['slm_lead_product'])) { ?>
                                                <li>
                                                    <span class="d-flex justify-content-left"><b>Website Product Name</b></span>
                                                    <span class="ml-2"><?php echo $leadDetails['slm_leads_product'] ?></span>
                                                </li>
                                            <?php } ?>
                                            <li>
                                                <span class="d-flex justify-content-left"><b>Lead Created</b></span>
                                                <span class="ml-2"><?php echo humanTiming(strtotime($leadDetails['slm_inserted_at'])) . " a go." ?></span>
                                            </li>
                                            <?php if (!empty($assignVendor)) { ?>
                                                <li>
                                                    <span class="d-flex justify-content-left"><b>Lead Assign To</b></span>
                                                    <a href="<?php echo base_url('profile/' . $assignVendor['svm_slug']) ?>" class="ml-2" target="_blank"><?php echo $assignVendor['svm_name'] ?></a>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <h5 class="my-2"><b>Lead Description</b></h5>
                                        <p>
                                            <?php echo $leadDetails['slm_leads_description'] ?>
                                        </p>
                                        <h4 class="my-2">Client Details</h4>
                                        <ul>
                                            <li>
                                                <span class="d-flex justify-content-left"><b>Client Name</b></span>
                                                <span class="ml-2"><?php echo $leadDetails['sum_user_name']; ?></span>
                                            </li>
                                            <li>
                                                <span class="d-flex justify-content-left"><b>Client Address</b></span>
                                                <?php $address = unserialize($leadDetails['sum_user_address']); ?>
                                                <address class="ml-2">
                                                    <?php echo $address['address'] . ', ' . $address['city'] . ' - ' . $address['zipCode'] . ',<br/>' . $address['state'] . ', ' . $address['country'] . '.'; ?>
                                                </address>
                                            </li>
                                            <li>
                                                <span class="d-flex justify-content-left"><b>Client Position</b></span>
                                                <span class="ml-2"><?php echo $leadDetails['sum_user_position']; ?></span>
                                            </li>
                                            <li>
                                                <span class="d-flex justify-content-left"><b>Client Phone Number</b></span>
                                                <span class="ml-2"><?php echo $leadDetails['sum_user_phone']; ?></span>
                                            </li>
                                            <li>
                                                <span class="d-flex justify-content-left"><b>Client E-Mail</b></span>
                                                <a href="mailto:<?php echo $leadDetails['sum_user_email'] ?>" class="ml-2">
                                                    <?php echo $leadDetails['sum_user_email']; ?>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="row">
                                    <h3>Lead Comment</h3>
                                    <div class="col-md-12">
                                        <div class="card">
                                            <ul class="list-unstyled">
                                                <div id="newComment"></div>
                                                <?php if (!empty($comments)) :
                                                    foreach ($comments as $key) :
                                                        if (empty($key->slcm_subcomment_id)) : ?>
                                                            <li class="media mb-3">
                                                                <span class="round">
                                                                    <?php if (!empty($key->slcm_admin_id)) { ?>
                                                                        <img src="<?php echo ((!empty($key->sam_admin_image) && file_exists(ADMIN_PROFILE_IMAGE . $key->sam_admin_image)) ? getImageUrl($key->sam_admin_image) : base_url("assets/backend-assest/images/author/avatar.png")) ?>" class="align-self-start mr-3">
                                                                    <?php } else { ?>
                                                                        <img src="<?php echo ((!empty($key->svm_image) && file_exists(ADMIN_PROFILE_IMAGE . $key->svm_image)) ? getImageUrl($key->svm_image) : base_url("assets/backend-assest/images/author/avatar.png")) ?>" class="align-self-start mr-3">
                                                                    <?php } ?>
                                                                </span>
                                                                <div class="media-body">
                                                                    <div class="row d-flex">
                                                                        <h6 class="user">
                                                                            <?php if (!empty($key->slcm_admin_id)) {
                                                                                echo $key->sam_name;
                                                                            } else {
                                                                                echo $key->svm_name;
                                                                            } ?>
                                                                        </h6>
                                                                        <div class="ml-auto">
                                                                            <p class="text"><?php echo date('D d, M Y', strtotime($key->slcm_created_at)) ?></p>
                                                                        </div>
                                                                    </div>
                                                                    <p class="text"><?php echo $key->slcm_comment ?></p>
                                                                    <div class="images">
                                                                        <div class="btn-group btn-group-toggle">
                                                                            <label class="btn btn-success btn-sm" data-id="<?php echo $key->slcm_id ?>" data-comment="<?php echo 'form' . $key->slcm_id ?>">Reply</label>
                                                                            <?php if ($session->client['svm_id'] == $key->slcm_vendor_id) { ?>
                                                                                <label class="btn btn-danger btn-sm" data-id="<?php echo $key->slcm_id ?>">Delete</label>
                                                                            <?php } ?>
                                                                        </div>
                                                                    </div>
                                                                    <div id="form<?php echo $key->slcm_id; ?>"></div>
                                                                    <div id="subcomment<?php echo $key->slcm_id ?>"></div>
                                                                    <?php foreach ($comments as $subkey) :
                                                                        if (!empty($subkey->slcm_subcomment_id) && $key->slcm_id == $subkey->slcm_subcomment_id) : ?>
                                                                            <div class="media mt-3 comment">
                                                                                <a href="#">
                                                                                    <?php if (!empty($key->slcm_admin_id)) { ?>
                                                                                        <img src="<?php echo ((!empty($key->sam_admin_image) && file_exists(ADMIN_PROFILE_IMAGE . $key->sam_admin_image)) ? getImageUrl($key->sam_admin_image) : base_url("assets/backend-assest/images/author/avatar.png")) ?>" class="align-self-start mr-3">
                                                                                    <?php } else { ?>
                                                                                        <img src="<?php echo ((!empty($key->svm_image) && file_exists(ADMIN_PROFILE_IMAGE . $key->svm_image)) ? getImageUrl($key->svm_image) : base_url("assets/backend-assest/images/author/avatar.png")) ?>" class="align-self-start mr-3">
                                                                                    <?php } ?>
                                                                                </a>
                                                                                <div class="media-body">
                                                                                    <div class="row d-flex">
                                                                                        <h6 class="user">
                                                                                            <?php if (!empty($subkey->slcm_admin_id)) {
                                                                                                echo $subkey->sam_name;
                                                                                            } else {
                                                                                                echo $subkey->svm_name;
                                                                                            } ?>
                                                                                        </h6>
                                                                                        <div class="ml-auto">
                                                                                            <p class="text mr-3"><?php echo date('D d, M Y', strtotime($subkey->slcm_created_at)) ?></p>
                                                                                        </div>
                                                                                    </div>
                                                                                    <p class="reply"><?php echo $subkey->slcm_comment ?></p>
                                                                                </div>
                                                                            </div>
                                                                    <?php endif;
                                                                    endforeach; ?>
                                                                </div>
                                                            </li>
                                                <?php endif;
                                                    endforeach;
                                                endif; ?>

                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <form id="statusComment" method="POST" style="display: none;">
                                    <input type="hidden" name="slm_id" value="<?php echo $leadDetails['slm_id'] ?>" />
                                    <h3 class="my-4">Change Status</h3>
                                    <div class="form-row">
                                        <div class="col-md-6 col-sm-6 mb-4">
                                            <label for="status">Leads Status</label>
                                            <select name="status" class="form-control" id="status">
                                                <option value=""> Select Here</option>
                                                <option value="pending">Pending</option>
                                                <option value="on-hold">On Hold</option>
                                                <option value="in-progress">In-Progress</option>
                                                <option value="not-responding">Not Responding</option>
                                                <option value="open">Open</option>
                                                <option value="close">Close</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 col-sm-6 mb-4">
                                            <label for="comment">Comment</label>
                                            <textarea name="comment" class="form-control" id="comment" placeholder="Add Comment"></textarea>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary" id="addAdmin" type="submit">Add</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>