<header class="topbar">
    <nav class="navbar top-navbar navbar-expand-md navbar-dark">
        <!-- ============================================================== -->
        <!-- Logo -->
        <!-- ============================================================== -->
        <div class="navbar-header">
            <a class="navbar-brand" href="<?php redirect()->to(menuUrl($session->admin['admin_type'], 'home')) ?>">
                <!-- Logo icon -->
                <!--End Logo icon -->
                <!-- Logo text --><span>
                    <!-- dark Logo text -->
                    <img src="<?php echo base_url("assets/images/logo-text.png") ?>" alt="homepage" class="dark-logo" style="height: 49px;" />
                    <!-- Light Logo text -->
                    <!-- <img src="../assets/images/logo-light-text.png" class="light-logo" alt="homepage" /></span> </a> -->
        </div>
        <!-- ============================================================== -->
        <!-- End Logo -->
        <!-- ============================================================== -->
        <div class="navbar-collapse">
            <!-- ============================================================== -->
            <!-- toggle and nav items -->
            <!-- ============================================================== -->
            <ul class="navbar-nav mr-auto">
                <!-- This is  -->
                <li class="nav-item"> <a class="nav-link nav-toggler d-block d-md-none waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
                <li class="nav-item"> <a class="nav-link sidebartoggler d-none d-lg-block d-md-block waves-effect waves-dark" href="javascript:void(0)"><i class="icon-menu"></i></a> </li>
                <!-- ============================================================== -->
                <!-- Search -->
                <!-- ============================================================== -->
                <li class="nav-item">
                    <form class="app-search d-none d-md-block d-lg-block">
                        <input type="text" class="form-control" placeholder="Search & enter">
                    </form>
                </li>
            </ul>
            <!-- ============================================================== -->
            <!-- User profile and search -->
            <!-- ============================================================== -->
            <ul class="navbar-nav my-lg-0">
                <!-- ============================================================== -->
                <!-- Comment -->
                <!-- ============================================================== -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="mdi mdi-bell"></i>
                        <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right mailbox animated bounceInDown">
                        <ul>
                            <li>
                                <div class="drop-title">Notifications</div>
                            </li>
                            <li>
                                <div class="message-center">
                                    <!-- Message -->
                                    <a href="javascript:void(0)">
                                        <div class="btn btn-danger btn-circle"><i class="fa fa-link"></i></div>
                                        <div class="mail-contnet">
                                            <h5>Luanch Admin</h5> <span class="mail-desc">Just see the my new admin!</span> <span class="time">9:30 AM</span>
                                        </div>
                                    </a>
                                    <!-- Message -->
                                    <a href="javascript:void(0)">
                                        <div class="btn btn-success btn-circle"><i class="ti-calendar"></i></div>
                                        <div class="mail-contnet">
                                            <h5>Event today</h5> <span class="mail-desc">Just a reminder that you have event</span> <span class="time">9:10 AM</span>
                                        </div>
                                    </a>
                                    <!-- Message -->
                                    <a href="javascript:void(0)">
                                        <div class="btn btn-info btn-circle"><i class="ti-settings"></i></div>
                                        <div class="mail-contnet">
                                            <h5>Settings</h5> <span class="mail-desc">You can customize this template as you want</span> <span class="time">9:08 AM</span>
                                        </div>
                                    </a>
                                    <!-- Message -->
                                    <a href="javascript:void(0)">
                                        <div class="btn btn-primary btn-circle"><i class="ti-user"></i></div>
                                        <div class="mail-contnet">
                                            <h5>Pavan kumar</h5> <span class="mail-desc">Just see the my admin!</span> <span class="time">9:02 AM</span>
                                        </div>
                                    </a>
                                </div>
                            </li>
                            <li>
                                <a class="nav-link text-center link" href="javascript:void(0);"> <strong>Check all notifications</strong> <i class="fa fa-angle-right"></i> </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <!-- ============================================================== -->
                <!-- End Comment -->
                <!-- ============================================================== -->

            </ul>
        </div>
    </nav>
</header>
<!-- ============================================================== -->
<!-- End Topbar header -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->
<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- User Profile-->
        <div class="user-profile">
            <div class="user-pro-body">
                <div><img src="<?php echo (!empty($session->admin['admin_image']) && file_exists(ADMIN_PROFILE_IMAGE . $session->admin['admin_image'])) ? getImageUrl($session->admin['admin_image']) : base_url("assets/images/users/avatar.png"); ?>" alt="user-img" class="img-circle"></div>
                <div class="dropdown">
                    <a href="javascript:void(0)" class="dropdown-toggle u-dropdown link hide-menu" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $session->admin['admin_name'] ?> <span class="caret"></span></a>
                    <div class="dropdown-menu animated flipInY">
                        <!-- text-->
                        <a href="javascript:void(0)" class="dropdown-item"><i class="ti-user"></i> My Profile</a>

                        <!-- text-->
                        <div class="dropdown-divider"></div>
                        <!-- text-->
                        <a href="<?php echo base_url('admin/logout') ?>" class="dropdown-item"><i class="fas fa-power-off"></i> Logout</a>
                        <!-- text-->
                    </div>
                </div>
            </div>
        </div>
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li>
                    <a class="waves-effect waves-dark <?php echo ($title == 'Dashboard') ? 'active' : ''; ?>" href="<?php echo menuUrl($session->admin['admin_type'], 'home') ?>" aria-expanded="false">
                        <i class="icon-speedometer"></i>
                        <span class="hide-menu">Dashboard</span>
                    </a>
                </li>
                <?php $access = unserialize($session->admin['admin_access']);
                if ($session->admin['admin_type'] == "super" || (!empty($access) && !empty($access['admin']) && $access['admin'] == 'true')) : ?>
                    <li> <a class="has-arrow waves-effect waves-dark <?php echo (($title == 'Admin\'s') ? 'active' : (!empty($page) && $page == 'profile' ? 'active' : '')) ?>" href="javascript:void(0)" aria-expanded="false"><i class="icon-people"></i><span class="hide-menu">Admins</span></a>
                        <ul aria-expanded="false" class="collapse">
                            <li><a href="<?php echo menuUrl($session->admin['admin_type'], 'admin-list') ?>">Admin List</a></li>

                        </ul>
                    </li>
                <?php endif; ?>
                <?php $access = unserialize($session->admin['admin_access']);
                if ($session->admin['admin_type'] == "super" || (!empty($access) && !empty($access['admin']) && $access['admin'] == 'true')) : ?>
                    <li> <a class="has-arrow waves-effect waves-dark <?php echo (($title == 'Vendor\'s') ? 'active' : (!empty($page) && $page == 'profile' ? 'active' : '')) ?>" href="javascript:void(0)" aria-expanded="false"><i class="icon-handbag"></i><span class="hide-menu">Vendors</span></a>
                        <ul aria-expanded="false" class="collapse">
                            <li><a href="<?php echo menuUrl($session->admin['admin_type'], 'vendor') ?>">Vendor List</a></li>

                        </ul>
                    </li>
                <?php endif; ?>

                <?php $access = unserialize($session->admin['admin_access']);
                if ($session->admin['admin_type'] == "super" || (!empty($access) && !empty($access['admin']) && $access['admin'] == 'true')) : ?>
                    <li> <a class="has-arrow waves-effect waves-dark <?php echo (($title == 'customer\'s') ? 'active' : (!empty($page) && $page == 'profile' ? 'active' : '')) ?>" href="javascript:void(0)" aria-expanded="false"><i class="icon-people"></i><span class="hide-menu">Customers</span></a>
                        <ul aria-expanded="false" class="collapse">
                            <li><a href="<?php echo menuUrl($session->admin['admin_type'], 'customer') ?>">Customers List</a></li>

                        </ul>
                    </li>
                <?php endif; ?>
                <?php $access = unserialize($session->admin['admin_access']);
                if ($session->admin['admin_type'] == "super" || (!empty($access) && !empty($access['admin']) && $access['admin'] == 'true')) : ?>
                    <li> <a class="has-arrow waves-effect waves-dark <?php echo (($title == 'leads\'s') ? 'active' : (!empty($page) && $page == 'profile' ? 'active' : '')) ?>" href="javascript:void(0)" aria-expanded="false"><i class="fas fa-handshake"></i><span class="hide-menu">Leads</span></a>
                        <ul aria-expanded="false" class="collapse">
                            <li><a href="<?php echo menuUrl($session->admin['admin_type'], 'leads') ?>">Leads List</a></li>
                            <li><a href="<?php echo menuUrl($session->admin['admin_type'], 'leadsource') ?>">Leads Source</a></li>
                            <li><a href="<?php echo menuUrl($session->admin['admin_type'], 'leadstatus') ?>">Leads Status</a></li>

                        </ul>
                    </li>
                <?php endif; ?>


                <?php $access = unserialize($session->admin['admin_access']);
                if ($session->admin['admin_type'] == "super" || (!empty($access) && !empty($access['admin']) && $access['admin'] == 'true')) : ?>
                    <li> <a class="has-arrow waves-effect waves-dark <?php echo (($title == 'categories\'s') ? 'active' : (!empty($page) && $page == 'profile' ? 'active' : '')) ?>" href="javascript:void(0)" aria-expanded="false"><i class="fas fa-bars"></i><span class="hide-menu">Categories</span></a>
                        <ul aria-expanded="false" class="collapse">
                            <li><a href="<?php echo menuUrl($session->admin['admin_type'], 'categories') ?>">Main categories</a></li>
                            <li><a href="<?php echo menuUrl($session->admin['admin_type'], 'Subcategories') ?>">Sub categories</a></li>

                        </ul>
                    </li>
                <?php endif; ?>
                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="icon-docs"></i><span class="hide-menu">Reports</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="#">Customer Reports</a></li>
                        <li><a href="<?php echo menuUrl($session->admin['admin_type'], 'reportleads') ?>">Leads Reports</a></li>
                        <li><a href="#">Sales Reports</a></li>
                        <li><a href="#">Users Login Reports</a></li>
                    </ul>
                </li>



            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
<!-- ============================================================== -->
<!-- End Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->