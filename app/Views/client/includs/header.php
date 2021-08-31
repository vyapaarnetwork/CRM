<!DOCTYPE html>
<html lang="en">

<head>
    <title>Vyapar<?php echo !empty($title) ? ' - ' . $title : '' ?></title>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?php echo !empty($setting['site_description']) ? $setting['site_description'] : ''; ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href="<?php echo getFrontEndUrl('image/favicon.png?var=' . APPVERSION); ?>" rel="icon" type="image/png">
    <link href="<?php echo getFrontEndUrl('css/bootstrap.min.css?var=' . APPVERSION); ?>" rel="stylesheet" media="screen" />
    <link href="<?php echo getFrontEndUrl('javascript/font-awesome/css/font-awesome.css?var=' . APPVERSION); ?>" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" />
    <link href="<?php echo getFrontEndUrl('css/stylesheet.css?var=' . APPVERSION); ?>" rel="stylesheet">
    <link href="<?php echo getFrontEndUrl('css/responsive.css?var=' . APPVERSION); ?>" rel="stylesheet">
    <link href="<?php echo getFrontEndUrl('javascript/owl-carousel/owl.carousel.css?var=' . APPVERSION); ?>" type="text/css" rel="stylesheet" media="screen" />
    <link href="<?php echo getFrontEndUrl('javascript/owl-carousel/owl.transitions.css?var=' . APPVERSION); ?>" type="text/css" rel="stylesheet" media="screen" />
    <link href="<?php echo getFrontEndUrl('css/iziModal.css?var=' . APPVERSION); ?>" type="text/css" rel="stylesheet" />
    <link href="<?php echo getFrontEndUrl('css/iziToast/iziToast.css?var=' . APPVERSION); ?>" type="text/css" rel="stylesheet" />
    <link href="<?php echo getFrontEndUrl('Loader/jquery-spinner.css?var=' . APPVERSION); ?>" type="text/css" rel="stylesheet" />
    <?php if (!empty($page) && $page == 'profileDetails') { ?>
        <link rel="stylesheet" href="<?php echo getFrontEndUrl('css/jquery.fileupload.css?var=' . APPVERSION); ?>" />
        <link rel="stylesheet" href="<?php echo getFrontEndUrl('css/jquery.fileupload-ui.css?var=' . APPVERSION); ?>" />
        <noscript>
            <link rel="stylesheet" href="<?php echo getFrontEndUrl('css/jquery.fileupload-noscript.css?var=' . APPVERSION); ?>" />
        </noscript>
        <noscript>
            <link rel="stylesheet" href="<?php echo getFrontEndUrl('css/jquery.fileupload-ui-noscript.css?var=' . APPVERSION); ?>" />
        </noscript>
    <?php }
    if (!empty($page) && $page == 'product') { ?>
        <link rel="stylesheet" href="<?php echo getFrontEndUrl('DropZone/dropzone.css?var=' . APPVERSION); ?>" />
        <link rel="stylesheet" href="<?php echo getFrontEndUrl('javascript/DataTables/datatables.css?var=' . APPVERSION); ?>" />
    <?php } if (!empty($page) && $page == 'lead') { ?>
        <link rel="stylesheet" href="<?php echo getFrontEndUrl('javascript/DataTables/datatables.css?var=' . APPVERSION); ?>" />
    <?php } ?>
    <?php if($title == 'Lead Details'){ ?>
        <link rel="stylesheet" type="text/css" href="<?php echo getFrontEndUrl("css/commentLead.css?ver=".APPVERSION) ?>" />
    <?php } ?>
    <script>
        var base_url = '<?php echo base_url(); ?>';
    </script>
</head>

<body class="index">
    <div class="preloader loader" style="display: block;">
        <img src="<?php echo getFrontEndUrl('image/loader.gif'); ?>" alt="#" />
    </div>
    <header>
        <div class="header-top">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="top-right pull-right">
                            <div id="top-links" class="nav pull-right">
                                <div class="list-inline">
                                    <?php if (!empty($session->client)) : ?>
                                        <?php if (!empty($session->client['svm_slug'])) { ?>
                                            <a href="<?php echo base_url('profile/' . $session->client['svm_slug']) ?>">
                                                <?php echo $session->client['svm_name']; ?>
                                            </a>
                                        <?php } else if ($session->client['ssam_slug']) { ?>
                                            <a href="<?php echo base_url('profile/' . $session->client['ssam_slug']) ?>">
                                                <?php echo $session->client['ssam_name']; ?>
                                            </a>
                                        <?php } ?>
                                        |
                                        <a href="<?php echo base_url('/logout') ?>">Logout</a>
                                    <?php else : ?>
                                        <a id="sallRegister" href="#">Register As Sales Associate</a>
                                        |
                                        <a id="clientRegister" href="#">Register As Vendor</a>
                                        |
                                        <a id="clientLogin" href="#">Login</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-sm-3 col-xs-3 d-flex align-items-center flex-row">
                    <div id="logo">
                        <a href="<?php echo base_url(); ?>">
                            <img src="<?php echo !empty($setting['hader_logo']) ? getSettingUrl($setting['hader_logo']) : ''; ?>" title="E-Commerce" alt="E-Commerce" class="img-responsive" />
                            <h2><?php echo !empty($setting['site_name']) ? $setting['site_name'] : ''; ?></h2>
                        </a>
                    </div>
                </div>
                <div class="col-sm-5 col-md-5 col-xs-5"></div>
                <div class="col-sm-4 col-xs-4 d-flex align-items-center flex-row-reverse">
                    <form method="POST" action="<?php echo base_url('product/list') ?>">
                        <div class="form-row align-items-center">
                            <div class="col-auto">
                                <label class="sr-only" for="inlineFormInput">Name</label>
                                <input type="text" name="search" class="form-control mb-2" value="<?php echo !empty($_POST['search']) ? $_POST['search'] : '' ?>" placeholder="Search">
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-info mb-2">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </header>
    <nav id="menu" class="navbar">
        <div class="nav-inner">
            <div class="navbar-header"><span id="category" class="visible-xs">Menu</span>
                <button type="button" class="btn btn-navbar navbar-toggle">
                    <i class="fa fa-bars"></i>
                </button>
            </div>
            <div class="navbar-collapse">
                <ul class="main-navigation">
                    <li>
                        <a href="<?php echo base_url(); ?>" class="parent">
                            Home
                        </a>
                    </li>
                    <?php if (!empty($session->client) && empty($session->client['ssam_id'])) { ?>
                        <li>
                            <a href="<?php echo base_url('product/') ?>" class="parent">
                                Product
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('leads/') ?>" class="parent">
                                Your Leads
                            </a>
                        </li>
                    <?php } ?>
                    <!-- <li><a href="category.html" class="parent">Women</a> </li>
                    <li><a href="category.html" class="parent">Men</a> </li> -->
                    <li><a href="#" class="active parent">Page</a>
                        <ul>
                            <li><a href="category.html">Category Page</a></li>
                            <li><a href="cart.html">Cart Page</a></li>
                            <li><a href="checkout.html">Checkout Page</a></li>
                            <li><a href="blog.html">Blog Page</a></li>
                            <li><a href="single-blog.html">Singale Blog Page</a></li>
                            <li><a href="register.html">Register Page</a></li>
                            <li><a href="contact.html">Contact Page</a></li>
                            <li><a href="affiliate.html">Affiliate</a></li>
                            <li><a href="forgetpassword.html">Forget Password</a></li>
                        </ul>
                    </li>
                    <!-- <li><a href="blog.html" class="parent">Blog</a></li>
                    <li><a href="about-us.html">About us</a></li>
                    <li><a href="contact.html">Contact Us</a> </li> -->
                </ul>
            </div>
        </div>
    </nav>