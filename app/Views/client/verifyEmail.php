<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <?php if (!empty($session->client) && $session->client['svm_status'] == 'pending') { ?>
                <h3 class="title-subline">
                    You Can Not Access Any Thin Becauses Currently You Are Not Active. Please Wait For Activation Or If Late Contact Admin At
                    <a href="mailto:<?php echo $setting['site_email']; ?>">
                        <?php echo $setting['site_email']; ?>
                    </a>
                </h3>
            <?php } ?>
        </div>
    </div>
</div>
