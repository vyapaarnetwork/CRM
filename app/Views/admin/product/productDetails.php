<div class="page-container">
    <?php echo $adminMenu; ?>
    <div class="main-content-inner">
        <div class="row">
            <div class="col-lg-12 mt-3">
                <span id="errorReturn"></span>
                <div class="card">
                    <div class="card-body">
                        <div class="container-fliud">
                            <div class="wrapper row">
                                <div class="preview col-md-6">
                                    <div class="preview-pic tab-content">
                                        <div class="tab-pane active" id="image">
                                            <img src="<?php echo getFrontEndImageUploadUrl('vendorProduct/' . $product[0]->spm_image) ?>" />
                                        </div>
                                        <?php if (!empty($mediaFiles)) {
                                            foreach ($mediaFiles as $key) : ?>
                                                <div class="tab-pane" id="<?php echo $key['smm_id'] ?>">
                                                    <img src="<?php echo getFrontEndImageUploadUrl('vendorProduct/' . $key['smm_value']) ?>" />
                                                </div>
                                        <?php endforeach;
                                        } ?>
                                    </div>
                                    <ul class="preview-thumbnail nav nav-tabs">
                                        <li class="active">
                                            <a data-target="#image" data-toggle="tab">
                                                <img src="<?php echo getFrontEndImageUploadUrl('vendorProduct/' . $product[0]->spm_image) ?>" />
                                            </a>
                                        </li>
                                        <?php if (!empty($mediaFiles)) {
                                            foreach ($mediaFiles as $key) : ?>
                                                <li class="">
                                                    <a data-target="#<?php echo $key['smm_id'] ?>" data-toggle="tab">
                                                        <img src="<?php echo getFrontEndImageUploadUrl('vendorProduct/' . $key['smm_value']) ?>" />
                                                    </a>
                                                </li>
                                        <?php endforeach;
                                        } ?>
                                    </ul>

                                </div>
                                <div class="details col-md-6">
                                    <h3 class="product-title">
                                        <?php echo $product[0]->spm_name ?>
                                    </h3>
                                    <h4 class="price">
                                        Vendor:
                                        <span><?php echo $product[0]->svm_name ?></span>
                                    </h4>
                                    <h4 class="price">
                                        Vendor Company:
                                        <span><?php echo $product[0]->svm_company_name ?></span>
                                    </h4>
                                    <h4 class="price">
                                        Vendor Email:
                                        <span>
                                            <?php echo $product[0]->svm_email ?>
                                            <?php echo (($product[0]->svm_verified_email == '0') ? ' <i class="fa fa-times text-danger" titel="Not Verified" aria-hidden="true"></i>' : ' <i class="fa fa-check-circle text-success" titel="Verified" aria-hidden="true"></i>'); ?>
                                        </span>
                                    </h4>
                                    <h4 class="price">
                                        Vendor Phone Number:
                                        <span><?php echo $product[0]->svm_phone ?></span>
                                    </h4>
                                    <p class="product-description d-inline-block text-truncate" style="max-height: 10%;">
                                        <?php echo $product[0]->spm_descrioption; ?>
                                    </p>
                                    <h4 class="price">
                                        price:
                                        <span><?php echo $product[0]->spm_price ?></span>
                                    </h4>
                                    <h4 class="price">
                                        sell price:
                                        <span><?php echo $product[0]->spm_sell_price ?></span>
                                    </h4>
                                    <!-- <p class="vote">
                                        <strong>91%</strong>
                                        of buyers enjoyed this product! <strong>(87 votes)</strong>
                                    </p> -->
                                    <div class="action">
                                        <button class="add-to-cart btn btn-default" type="button">add to cart</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>