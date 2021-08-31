<div class="container">
    <div class="row ">
        <div class="col-md-12 col-xl-12 col-sm-12">
            <h1 class="mt-4 text-center" style="font-size: 20px;">
                <b>Product List</b>
            </h1>
        </div>
        <?php if (!empty($product)) {
            foreach ($product as $key) : ?>
                <div class="col-md-3 col-sm-6 mt-1">
                    <div class="product-grid">
                        <div class="product-image">
                            <a href="#" class="image">
                                <img class="pic-1" src="<?php echo getFrontEndImageUploadUrl('vendorProduct/' . $key['spm_image']) ?>" />
                                <img class="pic-2" src="<?php echo getFrontEndImageUploadUrl('vendorProduct/' . $key['smm_value']) ?>" />
                            </a>
                            <ul class="product-links">
                                <li id="favrate" data-productSlug="<?php echo $key['spm_slug'] ?>">
                                    <a href="#">
                                        <i class="fa fa-heart"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url('product/detail/' . $key['spm_slug']) ?>">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="product-content">
                            <h3 class="title">
                                <a href="<?php echo base_url('product/detail/' . $key['spm_slug']) ?>" class="d-inline-block text-truncate" style="max-width: 270px;">
                                    <?php echo $key['spm_name']; ?>
                                </a>
                            </h3>
                            <p class="price product-price">
                                <?php echo '₹' . $key['spm_price']; ?>
                                <span class="less"><?php echo '₹' . ($key['spm_price'] - $key['spm_sell_price']); ?></span>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php } else {?>
            <?php } ?>
    </div>
    <?php if (!empty($page)) { ?>
        <div class="row">
            <div class="col-md-12 d-flex justify-content-center">
                <?php echo $page ?>
            </div>
        </div>
    <?php  } ?>
</div>