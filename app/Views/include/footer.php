</div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
        <?php if ($page !== "admin_login" && $page !== "vendor_login" && $page !== "pass_forget") { ?>

<footer class="footer">
            © 2021 Vyapaar Network

    <a class="float-right"> Version: <?=$setting['version']?></a>
            </footer>
        <?php }?>
        <!-- ============================================================== -->
        <!-- End footer -->
        <!-- ============================================================== -->
    </div>
  <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src=<?php echo base_url("assets/node_modules/jquery/jquery-3.2.1.min.js")?>></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src=<?php echo base_url("assets/node_modules/popper/popper.min.js")?>></script>
    <script src=<?php echo base_url("assets/node_modules/bootstrap/dist/js/bootstrap.min.js")?>></script>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/node_modules/bootstrap-mutliselect/bootstrap-multiselect.min.css?ver=" . APPVERSION) ?>" />
    <script src=<?php echo base_url("assets/node_modules/bootstrap-mutliselect/bootstrap-multiselect.min.js")?>></script> 
-  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    

      <!--Custom JavaScript -->
    <script src=<?php echo base_url("assets/dist/js/custom.min.js")?>></script>

    <script src=<?php echo base_url("assets/dist/js/sidebarmenu.js")?>></script>

    <script src=<?php echo base_url("assets/dist/js/waves.js")?>></script>



<!-- ============================================================== -->
    <!-- This page plugins -->
    <!-- ============================================================== -->
    <!--morris JavaScript -->
    <script src=<?php echo base_url("assets/node_modules/raphael/raphael-min.js")?>></script>
    <script src=<?php echo base_url("assets/node_modules/morrisjs/morris.min.js")?>></script>
    <script src=<?php echo base_url("assets/node_modules/jquery-sparkline/jquery.sparkline.min.js")?>></script>

    <!-- Popup message jquery -->
    <script src=<?php echo base_url("assets/node_modules/toast-master/js/jquery.toast.js")?>></script>
    <!-- Chart JS -->
    <script src=<?php echo base_url("assets/dist/js/dashboard1.js")?>></script>
    <script src=<?php echo base_url("assets/node_modules/toast-master/js/jquery.toast.js")?>></script>

    <!-- jQuery peity -->
    <script src=<?php echo base_url("assets/node_modules/peity/jquery.peity.min.js")?>></script>
    <script src=<?php echo base_url("assets/node_modules/peity/jquery.peity.init.js")?>></script>


<script src=<?php echo base_url("assets/dist/js/perfect-scrollbar.jquery.min.js")?>></script>
<!-- DataTable -->

<!-- This is data table -->
<script src="<?php echo base_url("assets/node_modules/datatables.net/js/jquery.dataTables.min.js?ver=" . APPVERSION) ?>"></script>
<script src="<?php echo base_url("assets/node_modules/datatables.net-bs4/js/dataTables.responsive.min.js?ver=" . APPVERSION) ?>"></script>


 
    <!-- start - This is for export functionality only -->
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>

    <script src="<?php echo base_url("assets/dist/js/duDialog.min.js?ver=" . APPVERSION) ?>"></script>

    <script src="<?php echo base_url("assets/node_modules/toast-master/js/jquery.toast.js?ver=" . APPVERSION) ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.min.js"></script>


  <!-- login -->
  <?php if ($page == "admin_login") { ?>
    <script src="<?php echo base_url("assets/dist/js/admin/login.js?ver=" . APPVERSION) ?>"></script>
   
    <?php }
if ($page == "admin_list") { ?>
    <script src="<?php echo base_url("assets/dist/js/admin/adminList.js?ver=" . APPVERSION) ?>"></script>
    <?php }
    if ($page == "categories") { ?>
    
    <script src="<?php echo base_url("assets/dist/js/admin/categories.js?ver=" . APPVERSION) ?>"></script>
    <?php }
    if ($page == "subcategories") { ?>
    <script src="<?php echo base_url("assets/dist/js/admin/subcategories.js?ver=" . APPVERSION) ?>"></script>
    <?php }
if ($page == "Vendor" || $page == "vendorDetails"  ) { ?>
    <script src="<?php echo base_url("assets/dist/js/admin/vendorList.js?ver=" . APPVERSION) ?>"></script>
<?php }
 
if ($page == "leads") { ?>
    <script src="<?php echo base_url("assets/dist/js/admin/adminleads.js?ver=" . APPVERSION) ?>"></script>
    <?php }
 
if ($page == "reportlead") { ?>
    <script src="<?php echo base_url("assets/dist/js/admin/reportleads.js?ver=" . APPVERSION) ?>"></script>
<?php }
if ($page == "leadDetails") { ?>
    <script src="<?php echo base_url("assets/dist/js/admin/leadDetails.js?ver=" . APPVERSION) ?>"></script>
    
<?php }
if ($page == "leadsource") { ?>
    <script src="<?php echo base_url("assets/dist/js/admin/leadssource.js?ver=" . APPVERSION) ?>"></script>

<?php }
  if ($page == "LeadStatus") { ?>
      <script src="<?php echo base_url("assets/dist/js/admin/leadstatus.js?ver=" . APPVERSION) ?>"></script>

  <?php }
if ($page == "customers") { ?>
    <script src="<?php echo base_url("assets/dist/js/admin/customerList.js?ver=" . APPVERSION) ?>"></script>

<?php }?>



<!-- Vendor -->

<?php 
if ($page == "vendor_login") { ?>
    <script src="<?php echo base_url("assets/dist/js/vendor/login.js?ver=" . APPVERSION) ?>"></script>
    <?php }
    if (!empty($_SESSION['vendor'])) { ?>
    <script src="<?php echo base_url("assets/dist/js/vendor/vendor.js?ver=" . APPVERSION) ?>"></script>

<?php } ?>

<script src=<?php echo base_url("assets/dist/js/core.js")?>></script>



    <script type="text/javascript">
        $(function() {
            $(".preloader").fadeOut();
        });
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        });
        // ============================================================== 
        // Login and Recover Password 
        // ============================================================== 
        $('#to-recover').on("click", function() {
            $("#loginform").slideUp();
            $("#recoverform").fadeIn();
        });

    
    </script>
    
    <?php if(!empty($_SESSION['flashdata'])): ?>
<script>
  $.toast({
            heading: "<?php echo $_SESSION['flashdata']['msg'];?>",
            position: 'top-right',
            loaderBg: '#ff6849',
            icon: '<?php if($_SESSION['flashdata']['status'] == 'success'){ echo 'success'; } else {echo 'error'; }  ?>',
            hideAfter: 3500,
            stack: 6
        });

</script>
<?php unset($_SESSION['flashdata']);?>
    <?php endif?>
    
</body>

</html>