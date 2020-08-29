<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>SB Admin 2 - Tables</title>

  <!-- Custom fonts for this template -->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

  <!-- Custom styles for this page -->
  <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
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
          <h1 class="h3 mb-2 text-gray-800">Penerimaan Cash</h1>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Form Input</h6>
            </div>
            <div class="card-body">
              <form method="post" action="{{url('payment')}}" enctype="multipart/form-data" class="mt-2">
                {{csrf_field()}}
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="exampleInputEmail1">No. Order (Invoice)</label>
                      <input type="text" name="transaction_number" id="transaction_number" class="form-control" id="" placeholder=""><span style="display:none" id="notif"> <i>Transaction Not Found!</i> </span>
                      <button class="btn btn-primary check-trx">Check</button>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword1">Nama Bank</label>
                      <select name="bank_account" id="bank_account" class="form-control" disabled>
                        <option value="">Choose...</option>
                        <option value="BNI">BNI</option>
                        <option value="Mandiri">Mandiri</option>
                        <option value="BCA">BCA</option>
                        <option value="BRI">BRI</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword1">Jumlah Bayar</label>
                      <input type="text" class="form-control" name="amount_paid" id="amount_paid" placeholder="" onkeyup="this.value=addCommas(this.value);" required disabled />
                      <span style="display:none" id="price"></span>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword1">Nomor Rekening</label>
                      <input type="text" class="form-control" name="number_account" id="number_account" placeholder=""  required disabled />
                      <!-- <span style="display:none" id="price"></span> -->
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Metode Bayar</label>
                      <select name="payment_method" id="payment_method" class="form-control" required disabled>
                        <option selected>Choose...</option>
                        <option value="Tunai">Tunai</option>
                        <option value="Transfer">Transfer</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword1">Keterangan (optional)</label>
                      <textarea name="note" class="form-control" id="note" rows="4" disabled></textarea>
                    </div>
                  </div>
                </div>
                <button type="submit" class="btn btn-primary submit-form" disabled>Submit</button>
              </form>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

        <!-- Footer -->
        <footer class="sticky-footer bg-white">
          <div class="container my-auto">
            <div class="copyright text-center my-auto">
              <span>Copyright &copy; Tinta 2019</span>
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
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
            <a class="btn btn-primary" href="login.html">Logout</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>
    <script>
      $(document).ready(function() {
        'use strict';

        // var base_url = "http://localhost:8090/pos-tinta/public";
        var base_url = "http://pos.chopper-tech.com";

        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });

        $("#payment_method").change(function() {
          console.log(this.value)
          if (this.value == "Transfer"){
            $("#number_account").removeAttr('disabled')
          } else {
            $("#number_account").prop('disabled', true);
          }
        });

        $(".check-trx").click(function(e) {
          console.log("Check Transaction Number");
          e.preventDefault();
          var id = $("input[name=transaction_number]").val();
          console.log(id);
          $.ajax({
            type: 'GET',
            url: base_url + '/check-transaction/' + id,
            success: function(data) {
              if (data.code == 501) {
                console.log("ada dong :" + id);
                $("#bank_account").removeAttr('disabled');
                $("#amount_paid").removeAttr('disabled');
                $("#payment_method").removeAttr('disabled');
                $("#note").removeAttr('disabled');
                $(".submit-form").removeAttr('disabled');
                $("#notif").css('display', 'none');
                $("#price").text("Total Amount " + data.data.total_price);
                $("#price").css('display', 'block');
              } else {
                console.log("nggak ada dong :" + id);
                $("#bank_account").attr('disabled', 'disabled');
                $("#amount_paid").attr('disabled', 'disabled');
                $("#payment_method").attr('disabled', 'disabled');
                $("#note").attr('disabled', 'disabled');
                $(".submit-form").attr('disabled', 'disabled');
                $("#notif").css('display', 'block');
                $("#price").css('display', 'none');
              }
            }
          });
        });
      });
    </script>

</body>

</html>