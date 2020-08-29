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
          <h1 class="h3 mb-2 text-gray-800">Order</h1>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Order Retur</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Date</th>
                      <th>No. Order</th>
                      <th>Branches</th>
                      <th>Customer</th>
                      <th>Total Price</th>
                      <th>Amount Paid</th>
                      <th>Credit</th>
                      <th>Payment Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <!-- <tfoot>
                    <tr>
                      <th>Date</th>
                      <th>No. Order</th>
                      <th>Branches</th>
                      <th>Customer</th>
                      <th>Action</th>
                    </tr>
                  </tfoot> -->
                  <tbody>
                    @foreach($data as $page)
                    <tr>
                      <td>{{ $page->no }}</td>
                      <td>{{ $page->created_at }}</td>
                      <td><a href="order-list/cetak-retur-pdf/{{ $page->id }}" class="btn btn-primary" target="_blank">{{ $page->transaction_number }}</a></td>
                      <td>{{ $page->branch->branch_name }}</td>
                      <td>{{ $page->customer->customer_name }}</td>
                      <td>{{ number_format($page->total_price) }}</td>
                      <td>{{ number_format($page->total_amount_paid) }}</td>
                      <td>{{ number_format($page->total_price - $page->total_amount_paid) }}</td>
                      <td>{{ $page->status_name }}</td>
                      <td style="width:15%">
                        @if($page->is_delivered == 1)
                          <div class="row">
                            <div class="col-md-12">
                              <button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#editModal{{ $page->id }}">
                                  <!-- <i class="fas fa-fw fa-info" style="margin-left:-6px"></i> --> Delivered
                              </button>
                            </div>
                          </div>
                        @else
                          @if($page->status == 3)
                          <div class="row">
                            <div class="col-md-12">
                              <button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#editModal{{ $page->id }}">
                                  <!-- <i class="fas fa-fw fa-info" style="margin-left:-6px"></i> --> Cancelled
                              </button>
                            </div>
                          </div>
                          @else
                          <div class="row">
                            <div class="col-md-4">
                              <button type="button" class="btn btn-warning btn-block" data-toggle="modal" data-target="#editModal{{ $page->id }}">
                                  <i class="fas fa-fw fa-info" style="margin-left:-6px"></i>
                              </button>
                            </div>
                            <div class="col-md-4">
                              <button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#cancelledModal{{ $page->id }}">
                                  <i class="fas fa-fw fa-minus-circle" style="margin-left:-6px"></i>
                              </button>
                            </div>
                            <div class="col-md-4">
                              <button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#deliveredModal{{ $page->id }}">
                                  <i class="fas fa-fw fa-truck" style="margin-left:-6px"></i>
                              </button>
                            </div>
                          </div>
                          @endif
                        @endif
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

        <!-- Modal !-->
        @foreach($data as $page)
        <div class="modal fade" id="editModal{{ $page->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <form method="post" action="{{url('update-order')}}" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="modal-dialog modal-primary" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Detail Order</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                          <div class="form-group">
                              <label for="exampleInputEmail1">Customer Name</label>
                              <input type="text" class="form-control" name="product_name" value="{{ $page->customer->customer_name }}" placeholder="" readonly required />
                          </div>
                          <div class="row">
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="exampleInputPassword1">Order Number</label>
                                      <input type="text" class="form-control" name="price" value="{{ $page->transaction_number }}" placeholder="" readonly required />
                                  </div>
                              </div>
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="exampleInputEmail1">Order Date</label>
                                      <input type="text" class="form-control" name="stock" value="{{ $page->created_at }}" placeholder="" readonly required />
                                  </div>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-md-12">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                  <thead>
                                    <tr>
                                      <th>Product Name</th>
                                      <th>Unit Price</th>
                                      <th>Qty</th>
                                      <th>Subtotal</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    @foreach($page['transaction_detail'] as $detail)
                                    <tr>
                                      <td>{{ $detail->product->product_name }}</td>
                                      <td>Rp. {{ number_format($detail->unit_price / $detail->qty) }}</td>
                                      <td>{{ $detail->qty }}</td>
                                      <td>Rp. {{ number_format($detail->unit_price) }}</td>
                                    </tr>
                                    @endforeach
                                  </tbody>
                                </table>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="exampleInputPassword1">Total Discount</label>
                                      <input type="text" class="form-control" name="price" value="Rp. {{ number_format($page->total_discount) }}" placeholder="" readonly required />
                                  </div>
                              </div>
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="exampleInputEmail1">PPN</label>
                                      <input type="text" class="form-control" name="stock" value="Rp. {{ number_format($page->total_ppn) }}" placeholder="" readonly required />
                                  </div>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="exampleInputPassword1">Total Price</label>
                                      <input type="text" class="form-control" name="price" value="Rp. {{ number_format($page->total_price) }}" placeholder="" readonly required />
                                  </div>
                              </div>
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="exampleInputEmail1">Total Amount Paid</label>
                                      <input type="text" class="form-control" name="stock" value="Rp. {{ number_format($page->total_amount_paid) }}" placeholder="" readonly required />
                                  </div>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="exampleInputPassword1">Payment Status</label>
                                      <input type="text" class="form-control" name="price" value="{{ $page->status_name }}" placeholder="" readonly required />
                                  </div>
                              </div>
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="exampleInputEmail1">Deliver Status</label>
                                      <input type="text" class="form-control" name="stock" value="{{ $page->deliver_name }}" placeholder="" readonly required />
                                  </div>
                              </div>
                          </div>

                            <input type="hidden" name="id" value="{{ $page->id }}" />
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <!-- <button type="submit" class="btn btn-primary">Save</button> -->
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </form>
            <!-- /.modal-dialog -->
        </div>
        @endforeach

        <!-- Modal !-->
        @foreach($data as $page)
        <div class="modal fade" id="deliveredModal{{ $page->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <form method="post" action="{{url('delivered-order')}}" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="modal-dialog modal-primary" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Confirm Delivered Order</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                          <div class="form-group">
                              <label for="exampleInputEmail1">Customer Name</label>
                              <input type="text" class="form-control" name="product_name" value="{{ $page->customer->customer_name }}" placeholder="" readonly required />
                          </div>
                          <div class="row">
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="exampleInputPassword1">Order Number</label>
                                      <input type="text" class="form-control" name="price" value="{{ $page->transaction_number }}" placeholder="" readonly required />
                                  </div>
                              </div>
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="exampleInputEmail1">Order Date</label>
                                      <input type="text" class="form-control" name="stock" value="{{ $page->created_at }}" placeholder="" readonly required />
                                  </div>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-md-12">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                  <thead>
                                    <tr>
                                      <th>Product Name</th>
                                      <th>Unit Price</th>
                                      <th>Qty</th>
                                      <th>Subtotal</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    @foreach($page['transaction_detail'] as $detail)
                                    <tr>
                                      <td>{{ $detail->product->product_name }}</td>
                                      <td>Rp. {{ number_format($detail->unit_price / $detail->qty) }}</td>
                                      <td>{{ $detail->qty }}</td>
                                      <td>Rp. {{ number_format($detail->unit_price) }}</td>
                                    </tr>
                                    @endforeach
                                  </tbody>
                                </table>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="exampleInputPassword1">Total Discount</label>
                                      <input type="text" class="form-control" name="price" value="Rp. {{ number_format($page->total_discount) }}" placeholder="" readonly required />
                                  </div>
                              </div>
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="exampleInputEmail1">PPN</label>
                                      <input type="text" class="form-control" name="stock" value="Rp. {{ number_format($page->total_ppn) }}" placeholder="" readonly required />
                                  </div>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="exampleInputPassword1">Total Price</label>
                                      <input type="text" class="form-control" name="price" value="Rp. {{ number_format($page->total_price) }}" placeholder="" readonly required />
                                  </div>
                              </div>
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="exampleInputEmail1">Total Amount Paid</label>
                                      <input type="text" class="form-control" name="stock" value="Rp. {{ number_format($page->total_amount_paid) }}" placeholder="" readonly required />
                                  </div>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="exampleInputPassword1">Payment Status</label>
                                      <input type="text" class="form-control" name="price" value="{{ $page->status_name }}" placeholder="" readonly required />
                                  </div>
                              </div>
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="exampleInputEmail1">Deliver Status</label>
                                      <input type="text" class="form-control" name="stock" value="{{ $page->deliver_name }}" placeholder="" readonly required />
                                  </div>
                              </div>
                          </div>

                            <input type="hidden" name="id" value="{{ $page->id }}" />
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Delivered</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </form>
            <!-- /.modal-dialog -->
        </div>
        @endforeach

        <!-- Modal !-->
        @foreach($data as $page)
        <div class="modal fade" id="cancelledModal{{ $page->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <form method="post" action="{{url('cancel-order')}}" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="modal-dialog modal-primary" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Are you sure to cancel this Order?</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                          <div class="form-group">
                              <label for="exampleInputEmail1">Customer Name</label>
                              <input type="text" class="form-control" name="product_name" value="{{ $page->customer->customer_name }}" placeholder="" readonly required />
                          </div>
                          <div class="row">
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="exampleInputPassword1">Order Number</label>
                                      <input type="text" class="form-control" name="price" value="{{ $page->transaction_number }}" placeholder="" readonly required />
                                  </div>
                              </div>
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="exampleInputEmail1">Order Date</label>
                                      <input type="text" class="form-control" name="stock" value="{{ $page->created_at }}" placeholder="" readonly required />
                                  </div>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-md-12">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                  <thead>
                                    <tr>
                                      <th>Product Name</th>
                                      <th>Unit Price</th>
                                      <th>Qty</th>
                                      <th>Subtotal</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    @foreach($page['transaction_detail'] as $detail)
                                    <tr>
                                      <td>{{ $detail->product->product_name }}</td>
                                      <td>Rp. {{ number_format($detail->unit_price / $detail->qty) }}</td>
                                      <td>{{ $detail->qty }}</td>
                                      <td>Rp. {{ number_format($detail->unit_price) }}</td>
                                    </tr>
                                    @endforeach
                                  </tbody>
                                </table>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="exampleInputPassword1">Total Discount</label>
                                      <input type="text" class="form-control" name="price" value="Rp. {{ number_format($page->total_discount) }}" placeholder="" readonly required />
                                  </div>
                              </div>
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="exampleInputEmail1">PPN</label>
                                      <input type="text" class="form-control" name="stock" value="Rp. {{ number_format($page->total_ppn) }}" placeholder="" readonly required />
                                  </div>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="exampleInputPassword1">Total Price</label>
                                      <input type="text" class="form-control" name="price" value="Rp. {{ number_format($page->total_price) }}" placeholder="" readonly required />
                                  </div>
                              </div>
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="exampleInputEmail1">Total Amount Paid</label>
                                      <input type="text" class="form-control" name="stock" value="Rp. {{ number_format($page->total_amount_paid) }}" placeholder="" readonly required />
                                  </div>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="exampleInputPassword1">Payment Status</label>
                                      <input type="text" class="form-control" name="price" value="{{ $page->status_name }}" placeholder="" readonly required />
                                  </div>
                              </div>
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="exampleInputEmail1">Deliver Status</label>
                                      <input type="text" class="form-control" name="stock" value="{{ $page->deliver_name }}" placeholder="" readonly required />
                                  </div>
                              </div>
                          </div>

                            <input type="hidden" name="id" value="{{ $page->id }}" />
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                            <button type="submit" class="btn btn-primary">Yes</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </form>
            <!-- /.modal-dialog -->
        </div>
        @endforeach

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