<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url("/assets/images/favicon.png") ?>">
    <link rel="shortcut icon" type="image/png" href="<?php echo getSettingUrl($setting['flip_icon'] . "?ver=" . APPVERSION) ?>">

    <title>Vyaapar- <?php echo $title ?></title>




    <!-- Login page css -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/dist/css/pages/login-register-lock.css?ver=" . APPVERSION) ?>" />

    <!-- Login CSS -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/dist/css/style.min.css?ver=" . APPVERSION) ?>" />
    <!-- Dashboard -->
    <link rel="stylesheet" href="<?php echo base_url("assets/dist/css/pages/dashboard1.css?ver=" . APPVERSION) ?>" />
    <!-- chat -->
    <link rel="stylesheet" href="<?php echo base_url("assets/dist/css/pages/chat-app-page.css?ver=" . APPVERSION) ?>" />


    <!-- chartist CSS -->
    <link rel="stylesheet" href="<?php echo base_url("assets/node_modules/morrisjs/morris.css?ver=" . APPVERSION) ?>" />
    <!--Toaster Popup message CSS -->
    <link rel="stylesheet" href="<?php echo base_url("assets/node_modules/toast-master/css/jquery.toast.css?ver=" . APPVERSION) ?>" />
    <!-- datatable -->

    <link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/node_modules/datatables.net-bs4/css/dataTables.bootstrap4.css?ver=" . APPVERSION) ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/node_modules/datatables.net-bs4/css/responsive.dataTables.min.css?ver=" . APPVERSION) ?>" />

    <link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/dist/css/duDialog.min.css?ver=" . APPVERSION) ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/dist/css/custom.css?ver=" . APPVERSION) ?>" />






    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
    <script>
        var base_url = "<?php echo base_url(); ?>";
    </script>
</head>

<body class="skin-default card-no-border">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="loader">
            <div class="loader__figure"></div>
            <p class="loader__label">Vyapaar CRM</p>
        </div>
    </div>
    <div id="main-wrapper">