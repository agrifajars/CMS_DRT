<?php
session_start();
include "conf/connection.php";

if (isset($_SESSION['user_id']) == 0){
  echo '<script>alert("Anda harus login terlebih dahulu!");
  window.location.href="login.php"</script>';
} else {
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>DRT | Dashboard</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
<!-- Select2 -->
  <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
  </div>

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index.php" class="brand-link">
      <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Bengkel Motor DRT</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"> <?php echo $_SESSION['name']?> </a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
              with font-awesome or any other icon font library -->
            <li class="nav-item">
            <a href="index.php?menu=user" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>
                User
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="index.php?menu=supplier" class="nav-link">
              <i class="nav-icon fas fa-truck"></i>
              <p>
                Supplier
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="index.php?menu=category" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Category
              </p>
            </a>
          <li class="nav-item">
            <a href="index.php?menu=inventory" class="nav-link">
              <i class="nav-icon fas fa-box"></i>
              <p>
                Inventory
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="index.php?menu=inbound" class="nav-link">
              <i class="nav-icon fas fa-download"></i>
              <p>
                Inbound
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="index.php?menu=outbound" class="nav-link">
              <i class="nav-icon fas fa-upload"></i>
              <p>
                Outbound
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="index.php?menu=transaction" class="nav-link">
              <i class="nav-icon fas fa-dollar-sign"></i>
              <p>
                Transaction
              </p>
            </a>
          </li>
          </li>
          <li class="nav-header">Settings</li>
          <li class="nav-item">
            <a href="pages/auth/function_auth.php?act=logout" class="nav-link">
            <i class="nav-icon fas fa-sign-out-alt"></i>
              <p class="text">Log Out</p>
            </a>
          </li>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
      <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                  <h3 class="m-0">
                  <?php
                    $menu = isset($_GET['menu']) ? $_GET['menu'] : "homepage";
                    $menu = str_replace('_', ' ', $menu);

                    echo ucwords($menu);
                  ?>
                  </h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active">
                        <?php
                          $menu = isset($_GET['menu']) ? $_GET['menu'] : "homepage";
                          $menu = str_replace('_', ' ', $menu);

                          echo ucwords($menu);
                        ?>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <?php include "conf/page.php"; ?>
  </div>

  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.2.0
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script> $.widget.bridge('uibutton', $.ui.button) </script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>
<!-- Select2 -->
<script src="plugins/select2/js/select2.full.min.js"></script>
<!-- Datatables  -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="plugins/jszip/jszip.min.js"></script>
<script src="plugins/pdfmake/pdfmake.min.js"></script>
<script src="plugins/pdfmake/vfs_fonts.js"></script>
<script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<script>
  $(function () {
    $('#reservationdatetime').datetimepicker({ icons: { time: 'far fa-clock' } });

    $("#datatable").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      buttons: [
              {
                extend: 'csv',
                title: "DRT | Dashboard",
                exportOptions: {
                  columns: ':not(:last-child)',
                }
              },
              {
                extend: 'excel',
                title: "DRT | Dashboard",
                exportOptions: {
                  columns: ':not(:last-child)',
                }
              },
              {
                extend: 'pdf',
                title: "DRT | Dashboard",
                exportOptions: {
                  columns: ':not(:last-child)',
                }
              },
              {
                extend: 'print',
                title: "DRT | Dashboard",
                exportOptions: {
                  columns: ':not(:last-child)',
                }
              },
              "colvis"
        ]
      
    }).buttons().container().appendTo('#datatable_wrapper .col-md-6:eq(0)');
    // $('#example2').DataTable({
    //   "paging": true,
    //   "lengthChange": false,
    //   "searching": false,
    //   "ordering": true,
    //   "info": true,
    //   "autoWidth": false,
    //   "responsive": true,
    // });

    $('#search_inventory').select2({
        theme: 'bootstrap4',
        ajax: {
            url: 'pages/inventory/function_inventory.php?act=search',
            dataType: 'json',
            delay: 250, // Menambahkan delay untuk menghindari permintaan yang terlalu cepat
            data: function (data) {
                return {
                    searchTerm: data.term // search term
                };
            },
            processResults: function (response) {
                return {
                    results:response
                };
            },
            cache: true
        }
    });

    $('#search_supplier').select2({
        theme: 'bootstrap4',
        ajax: {
            url: 'pages/supplier/function_supplier.php?act=search',
            dataType: 'json',
            delay: 250, // Menambahkan delay untuk menghindari permintaan yang terlalu cepat
            data: function (data) {
                return {
                    searchTerm: data.term // search term
                };
            },
            processResults: function (response) {
                return {
                    results:response
                };
            },
            cache: true
        }
    });

    $(document).on("click", ".open-detail-modal", function () {
        var idTransaction = $(this).data('id-transaction');
        $.ajax({
            type: "GET",
            url: "pages/transaction/function_transaction.php?act=get&id_transaction=" + idTransaction,
            success: function (response) {
                // Masukkan tabel hasil query ke dalam modal body
                $("#detailModal .modal-body").html(response);
                // Tampilkan modal
                $("#detailModal").modal("show");
            }
        });
    });
  });
</script>
</body>
</html>
<?php } ?>