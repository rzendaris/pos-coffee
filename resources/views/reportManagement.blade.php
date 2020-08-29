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
          <h1 class="h3 mb-2 text-gray-800">Report Management</h1>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <div class="row">
                <div class="col-md-6">
                  <div class="col-md-5">
                    <form method="GET" action="{{url('generate-report/xlsx')}}" class="form-horizontal form-bordered">
                      <input type="hidden" class="form-control" name="from" value="{{ $data['from'] }}" />
                      <input type="hidden" class="form-control" name="to" value="{{ $data['to'] }}" />
                      <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</button>
                    </form>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="col-md-12">
                    <form method="GET" action="{{url('report-management')}}" class="form-horizontal form-bordered">
                      <div class="form-body">
                        <div class="form-group">
                          <div class="col-md-12">
                            <div class="input-group input-large date-picker input-daterange" data-date-format="yyyy-mm-dd">
                              <input type="date" class="form-control" value="{{ $data['from'] }}" name="from" required />
                              <span class="input-group-addon"> to </span>
                              <input type="date" class="form-control" value="{{ $data['to'] }}" name="to" required />

                              <button type="submit" class="btn btn-sm btn-primary">
                                Refresh
                              </button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>

            </div>
            <div class="card-body">
              <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Laporan Pembayaran Customer</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Laporan Piutang</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Laporan Penjualan</a>
                </li>
              </ul>

              <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">

                  <div class="d-sm-flex align-items-center justify-content-center mt-2">
                    <!-- <form method="GET" action="{{url('generate-report/xlsx')}}" class="form-horizontal form-bordered">
                          <input type="hidden" class="form-control" name="from" value="{{ $data['from'] }}"/>
                          <input type="hidden" class="form-control" name="to" value="{{ $data['to'] }}"/>
                          <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</button>
                        </form> -->

                  </div>
                  <div class="table-responsive mt-2">
                    <table class="table table-bordered " id="dataTable" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                          <th>Date</th>
                          <th>No. Order</th>
                          <th>Branches</th>
                          <th>Payment Method</th>
                          <th>Bank Account</th>
                          <th>Amount Paid</th>
                          <th>Cashier</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($data['payment'] as $page)
                        <tr>
                          <td>{{ $page->created_at }}</td>
                          <td><a href="nota-penjualan/cetak-pdf/{{ $page->transaction_number }}" class="btn btn-primary" target="_blank">{{ $page->transaction_number }}</a></td>
                          <td>{{ $page->transaction->branch->branch_name }}</td>
                          <td>{{ $page->payment_method }}</td>
                          <td>{{ $page->bank_account }}</td>
                          <td>Rp. {{ number_format($page->amount_paid) }}</td>
                          <td>{{ $page->created_by }}</td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>

                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">

                  <div class="d-sm-flex align-items-center justify-content-center mt-2">
                    <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
                  </div>

                  <div class="table-responsive mt-2">
                    <table class="table table-bordered" id="dataTable1" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                          <th>Date</th>
                          <th>No. Order</th>
                          <th>Branches</th>
                          <th>Total Price</th>
                          <th>Amount Paid</th>
                          <th>Credit</th>
                          <th>Duration</th>
                          <th>Time Of Payment</th>
                          <th>Cashier</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($data['piutang'] as $page)
                        <tr>
                          <td>{{ $page->created_at }}</td>
                          <td>{{ $page->transaction_number }}</td>
                          <td>{{ $page->branch->branch_name }}</td>
                          <td>{{ number_format($page->total_price) }}</td>
                          <td>{{ number_format($page->total_amount_paid) }}</td>
                          <td>{{ number_format($page->total_price - $page->total_amount_paid) }}</td>
                          <td>{{ $page->created_at->diffInDays($data['now_date'], false) }} day(s)</td>
                          <td>{{ $page->time_of_payment }}</td>
                          <td>{{ $page->created_by }}</td>
                          @endforeach
                      </tbody>
                      <tfoot>
                        <tr>
                          <th colspan="10" style="text-align:right"></th>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                </div>

                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">

                  <div class="d-sm-flex align-items-center justify-content-center mt-2">
                    <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
                  </div>

                  <div class="table-responsive mt-2">
                    <table class="table table-bordered" id="dataTable2" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                          <th>Date</th>
                          <th>No. Order</th>
                          <th>Branches</th>
                          <th>PPN 10%</th>
                          <th>Discount</th>
                          <th>Total Price</th>
                          <th>Amount Paid</th>
                          <th>Cashier</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($data['sales'] as $page)
                        <tr>
                          <td>{{ $page->created_at }}</td>
                          <td>{{ $page->transaction_number }}</td>
                          <td>{{ $page->branch->branch_name }}</td>
                          <td>Rp. {{ number_format($page->total_ppn) }}</td>
                          <td>Rp. {{ number_format($page->total_discount) }}</td>
                          <td>Rp. {{ number_format($page->total_price) }}</td>
                          <td>{{ number_format($page->total_amount_paid) }}</td>
                          <td>{{ $page->created_by }}</td>
                          @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
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

</body>

</html>