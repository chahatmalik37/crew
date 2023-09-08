<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <title> HR software</title>
        <!-- <link rel = "icon" href = "images/favi_icon.png"> -->

        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
         <!-- CSS -->
        <link href="<?php echo base_url('public/css/bootstrap.min.css'); ?>" type="text/css" rel="stylesheet" />
        <link href="<?php echo base_url('public/css/custom.css'); ?>" type="text/css" rel="stylesheet" />
                
        <link href="<?php echo base_url('public/css/bootstrap-table.min.css'); ?>" type="text/css" rel="stylesheet" />
      
        <link href="<?php echo base_url('public/css/sb-admin-2.min.css'); ?>" type="text/css" rel="stylesheet" />
         
        <link href='<?php echo base_url('public/vendor/fontawesome-free/css/all.min.css'); ?>' rel="stylesheet" type="text/css">
        
        <link href="<?php echo base_url('public/css/bootstrap-table-fixed-columns.min.css'); ?>" type="text/css" rel="stylesheet" />

        
        <!-- JS -->
        <script src='<?php echo base_url('public/js/bootstrap.min.js'); ?>' type='text/javascript'></script>
        <script src='<?php echo base_url('public/js/bootstrap.bundle.min.js'); ?>' type='text/javascript'></script>
        <!--<script src='<?php //echo base_url('public/js/sidebars.js'); ?>' type='text/javascript'></script>-->
        
         
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

          
        <script src='<?php echo base_url('public/js/bootstrap-table.min.js'); ?>' type='text/javascript'></script>
        <script src='<?php echo base_url('public/js/common.js'); ?>' type='text/javascript'></script>
        <script src='<?php echo base_url('public/js/bootstrap-table-export.min.js'); ?>' type='text/javascript'></script>
        <script src='<?php echo base_url('public/js/bootstrap-table-fixed-columns.min.js'); ?>' type='text/javascript'></script>
        <script src='<?php echo base_url('public/js/tableExport.min.js'); ?>' type='text/javascript'></script>
        <script src='<?php echo base_url('public/fullcalendar/dist/index.global.js'); ?>'></script>
         <script src='<?php echo base_url('public/vendor/fontawesome-free/js/all.min.js'); ?>'></script>
      
      <!-- Custom fonts for this template-->
 
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    

    </head>

   <body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper" >

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion d-none d-md-inline" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon rotate-n-15">
                </div>
                
              <img src="<?php echo base_url('public/images/crew_logo_final.png'); ?>" style="width: 100px;">
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">
              <?php $session= session(); if( $session->get('login_type')=='User'){ ?>
            
 <!-- Nav Item - Attendance -->
            <li class="nav-item active">
                <a class="nav-link" href="<?php echo base_url('Attendance'); ?>">
                    <i class="fas fa-fw fa-user-clock icons_rotate"></i>
                    <span>Attendance</span></a>
            </li>
<?php }else{ ?>
            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="<?php echo base_url('Dashboard'); ?>">
                    <i class="fas fa-fw fa-tachometer-alt icons_rotate"></i>
                    <span>Dashboard</span></a>
            </li>
            
            <!-- Divider -->
            <hr class="sidebar-divider">

    
            <!-- Heading -->
            <div class="sidebar-heading">
                STAFF MASTER
            </div>

            <!-- Nav Item - Staff menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-user icons_rotate"></i>
                    <span>Staff</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <!--<h6 class="collapse-header">Custom Components:</h6>-->
                        <a class="collapse-item" href="<?php echo base_url('Employee'); ?>">Enter Staff</a>
                        <a class="collapse-item" href="<?php echo base_url('SearchStaff'); ?>">Search Staff</a>
                    </div>
                </div>
            </li>
            
            <!-- Nav Item - Allotment-->
            <li class="nav-item">
                <a class="nav-link collapsed" href="<?php echo base_url('EmailIdController'); ?>">
                    <i class="fas fa-fw fa-tasks icons_rotate"></i>
                    <span>Allotment</span>
                </a>
            </li>
            
             <!-- Nav Item - Approval-->
            <li class="nav-item">
                <a class="nav-link collapsed" href="<?php echo base_url('Attendance/view_approval'); ?>">
                    <i class="fas fa-fw fa-check-circle icons_rotate"></i>
                    <span>Approval</span>
                </a>
            </li>
            
            <!-- Nav Item - Interview -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="<?php echo base_url('Question'); ?>">
                    <i class="fas fa-fw fab fa-rocketchat icons_rotate"></i>
                    <span>Interview</span>
                </a>
            </li>
            
            <!-- Nav Item - Attendance Report-->
             <li class="nav-item">
                <a class="nav-link collapsed" href="<?php echo base_url('AttendanceReport'); ?>">
                    <i class="fas fa-user-clock icons_rotate"></i>
                    <span>Attendance Report</span>
                </a>
            </li>
            <!-- Nav Item - Renewal-->
            <!--<li class="nav-item">-->
            <!--    <a class="nav-link collapsed" href="<?php echo base_url('Renewal'); ?>">-->
            <!--    <i class="fa fa-refresh"></i>-->
            <!--        <span>Renewal</span>-->
            <!--    </a>-->
            <!--</li>-->

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">ONCE</div>
            
            <!-- Nav Item - ONCE menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseonce"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-puzzle-piece icons_rotate"></i>
                    <span>Once</span>
                </a>
                <div id="collapseonce" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <!--<h6 class="collapse-header">Custom Components:</h6>-->
                        <a class="collapse-item" href="<?php echo base_url('OnceAntivirus'); ?>">Antivirus</a>
                        <a class="collapse-item" href="<?php echo base_url('OnceDepartment'); ?>">Department</a>
                        <a class="collapse-item" href="<?php echo base_url('OnceDesignation'); ?>">Designation</a>
                        <a class="collapse-item" href="<?php echo base_url('OnceEmail'); ?>">Email</a>
                        <a class="collapse-item" href="<?php echo base_url('SimCard'); ?>">Simcard</a>
                        <a class="collapse-item" href="<?php echo base_url('OnceStarSquare'); ?>">Star/Square </a>
                        <a class="collapse-item" href="<?php echo base_url('Renewal'); ?>">Renewals</a>

                    </div>
                </div>
            </li>

            <!-- Nav Item - Charts -->
            <!--<li class="nav-item">-->
            <!--    <a class="nav-link" href="charts.html">-->
            <!--        <i class="fas fa-fw fa-chart-area"></i>-->
            <!--        <span>Charts</span></a>-->
            <!--</li>-->

            <!-- Nav Item - Tables -->
            <!--<li class="nav-item">-->
            <!--    <a class="nav-link" href="tables.html">-->
            <!--        <i class="fas fa-fw fa-table"></i>-->
            <!--        <span>Tables</span></a>-->
            <!--</li>-->

            <!-- Divider -->
            <!--<hr class="sidebar-divider d-none d-md-block">-->
<?php } ?>
            <!-- Sidebar Toggler (Sidebar) -->
            <!--<div class="text-center d-none d-md-inline">-->
            <div class="text-center">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

           
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow header_border">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <!-- Nav Item - Alerts -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <!-- Counter - Alerts -->
                                <span class="badge badge-danger badge-counter">3+</span>
                            </a>
                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    Alerts Center
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-primary">
                                            <i class="fas fa-file-alt text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 12, 2019</div>
                                        <span class="font-weight-bold">Ansh IT team is working on this!</span>
                                    </div>
                                </a>
                                <!--<a class="dropdown-item d-flex align-items-center" href="#">-->
                                <!--    <div class="mr-3">-->
                                <!--        <div class="icon-circle bg-success">-->
                                <!--            <i class="fas fa-donate text-white"></i>-->
                                <!--        </div>-->
                                <!--    </div>-->
                                    <!--<div>-->
                                    <!--    <div class="small text-gray-500">December 7, 2019</div>-->
                                    <!--    $290.29 has been deposited into your account!-->
                                    <!--</div>-->
                                <!--</a>-->
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-warning">
                                            <i class="fas fa-exclamation-triangle text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 2, 2019</div>
                                        Exciting Features: Real time login, Easy leave application, Simpler Reporting.
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                            </div>
                        </li>

                      
                        <div class="topbar-divider border border-secondary d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-dark-900 small"><?= $session->get('username') ?></span>
                                <i class="fas fa-user"></i>
                                <!--<img class="img-profile rounded-circle" src="<?php //echo base_url('public/images/ektaji.jpg'); ?>">-->
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <!--<a class="dropdown-item" href="#">-->
                                <!--    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>-->
                                <!--    Profile-->
                                <!--</a>-->
                                <!--<a class="dropdown-item" href="#">-->
                                <!--    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>-->
                                <!--    Settings-->
                                <!--</a>-->
                                <!--<a class="dropdown-item" href="#">-->
                                <!--    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>-->
                                <!--    Activity Log-->
                                <!--</a>-->
                                <!--<div class="dropdown-divider"></div>-->
                                <a class="dropdown-item" href="<?php echo base_url('Login/logout'); ?>" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="main">
                
                    <?= $this->renderSection('content') ?>
                </div>    

                <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white header_border d-none d-sm-block">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Crew 2023</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="<?php echo base_url('Login/logout'); ?>">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<?php $session = session();
?>
<script>
    
    $(document).ready(function() {
                    <?php if ($session->getflashdata('status')) { ?>
                        swal({
                            title: "<?= $session->getflashdata('status') ?>",
                            text: "<?= $session->getflashdata('status_text') ?>",
                            icon: "<?= $session->getflashdata('status_icon') ?>",
                         button: {
                         text: "OK",
                         className: "btn btn-primary",
                         },
                        });

                    <?php } ?>
                });
</script>
    
    <!--<script src="vendor/jquery/jquery.min.js"></script>-->
    <script src='<?php echo base_url('public/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>'></script>
    


    <!-- Core plugin JavaScript-->
    <!--<script src="vendor/jquery-easing/jquery.easing.min.js"></script>-->

    <!-- Custom scripts for all pages-->
    <!--<script src="js/sb-admin-2.min.js"></script>-->
    
     <script src='<?php echo base_url('public/js/sb-admin-2.min.js'); ?>' type='text/javascript'></script>

    <!-- Page level plugins -->
    <!--<script src="vendor/chart.js/Chart.min.js"></script>-->

    <!-- Page level custom scripts -->
    <!--<script src="js/demo/chart-area-demo.js"></script>-->
    <!--<script src="js/demo/chart-pie-demo.js"></script>-->
    <div class="p-2 w-100">
<?php $session = session();
  ?>

 

<?php if($session->getFlashdata('success')){?>
<div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
<?php echo  $session->getFlashdata('success');?>
</div><?php }?>

 

<?php if($session->getFlashdata('info')){?>
<div class="alert alert-info alert-dismissible fade show" role="alert" id="info-alert">
<?php echo  $session->getFlashdata('info');?>
</div><?php }?>

 

<?php if($session->getFlashdata('warning')){?>
<div class="alert alert-warning alert-dismissible fade show" role="alert" id="warning-alert">
<?php echo  $session->getFlashdata('warning');?>
</div><?php }?>

 

 

 

<script type="text/javascript">
  // $('.alert').alert()
  $("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
    $("#success-alert").slideUp(1000);
});

 

  $("#info-alert").fadeTo(2000, 500).slideUp(500, function(){
    // alert("hii");
    $("#info-alert").slideUp(1000);
});

 

  $("#warning-alert").fadeTo(2000, 500).slideUp(500, function(){
    $("#warning-alert").slideUp(1000);
});

 

</script>

</body>
</html>

