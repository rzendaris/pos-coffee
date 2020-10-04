<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Coffee Shop Dashboard</title>

  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <link href="css/sb-admin-2.min.css" rel="stylesheet">
  <link href="css/custom.css" rel="stylesheet">
  <link href="css/select2.min.css" rel="stylesheet">
  <link href="css/seatmap.css" rel="stylesheet">
</head>

<body id="page-top">
  <script>
    function addCommas(nStr) {
      return nStr.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
  </script>

  <!-- Page Wrapper -->
  <div id="wrapper">

  @include('components.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        @include('components.topbar')

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">POS</h1>
            <div id="open">
              OPEN Print
            </div>
            <div id="print">
              Test Print
            </div>
            <input id="branch_name" value="Mit Coffee"/>
          </div>
        </div>

          <!-- Content Row -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; Coffe Shop 2020</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>
  <script src="js/custom.js"></script>

  <!-- Page level plugins -->
  <script src="vendor/chart.js/Chart.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="js/demo/chart-area-demo.js"></script>
  <script src="js/demo/chart-pie-demo.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>

  <script>
    $("#js-example-tags").select2({
      tags: true
    });
  </script>
  <script src="https://cdn.jsdelivr.net/npm/recta/dist/recta.js"></script>

  <script>
    $(document).ready(function() {
        var printer;

        $('#open').click(() => {
            // Initial printer with key and port from form input
            printer = new Recta('8838015258', '1811')
            // Opening printer
            printer.open().then(() => {
                    // Show print button, it's hidden by default
                    $('#print').show();
                }).catch((e) => {
                    // Show Error if get an Error
                    $('#error').text(e);
                });
        });

        $('#print').click(() => {
            console.log("Branch Name > " + $('#branch_name').val())
            printer.align('center')
                .text($('#branch_name').val())
                .bold(true)
                .text('This is bold text')
                .bold(false)
                .underline(true)
                .text('This is underline text')
                .underline(false)
                .barcode('UPC-A', '123456789012')
                .cut()
                .print()
        });
    });
  </script>
</body>

</html>