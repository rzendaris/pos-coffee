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
          <h1 class="h3 mb-2 text-gray-800">User Management</h1>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">List Users</h6>
            </div>
            <div class="card-body">

            <div class="d-sm-flex align-items-center justify-content-center mt-2">
              <a href="{{url('add-user')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-upload fa-sm text-white-50"></i> Add User</a>
            </div>

              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>No.</th>
                      <th>Username</th>
                      <th>Email</th>
                      <th>Role</th>
                      <th>Branch</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <!-- <tfoot>
                    <tr>
                      <th>Branches</th>
                      <th>Product</th>
                      <th>Category</th>
                      <th>Price</th>
                      <th>Stock</th>
                      <th>Sales</th>
                      <th>Action</th>
                    </tr>
                  </tfoot> -->
                  <tbody>
                    @foreach($data['user'] as $page)
                    <tr>
                      <td style="width:5%;text-align:center">{{ $page->no }}</td>
                      <td>{{ $page->name }}</td>
                      <td>{{ $page->email }}</td>
                      <td>{{ $page->role_name }}</td>
                      <td>{{ $page->branch_name }}</td>
                      <td style="width:15%">
                        <div class="row">
                          <div class="col-md-6">
                            <button type="button" class="btn btn-warning btn-block" data-toggle="modal" data-target="#editModal{{ $page->id }}">
                                <i class="fas fa-fw fa-pencil-alt"></i>
                            </button>
                          </div>
                          <div class="col-md-6">
                            <button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#inactiveModal{{ $page->id }}">
                                <i class="fas fa-fw fa-minus-circle"></i>
                            </button>
                          </div>
                        </div>
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

        
        @foreach($data['user'] as $page)
        <div class="modal fade" id="inactiveModal{{ $page->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <form method="post" action="{{url('inactive-user')}}" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="modal-dialog modal-primary" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Are You Sure to Remove This User? </h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                          <div class="form-group">
                              <label for="exampleInputEmail1">User Name</label>
                              <input type="text" class="form-control" name="product_name" value="{{ $page->name }}" placeholder="" disabled />
                          </div>
                          <div class="row">
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="exampleInputPassword1">Email</label>
                                      <input type="text" class="form-control" name="price" value="{{ $page->email }}" placeholder="" disabled />
                                  </div>
                              </div>
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="exampleInputEmail1">Role</label>
                                      <input type="text" class="form-control" name="stock" value="{{ $page->role_name }}" placeholder="" disabled />
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

        <!-- Modal !-->
        @foreach($data['user'] as $page)
        <div class="modal fade" id="editModal{{ $page->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <form method="post" action="{{url('update-user')}}" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="modal-dialog modal-primary" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Edit User</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                          <div class="row">
                              <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Username</label>
                                    <input type="text" class="form-control" name="name" value="{{ $page->name }}" placeholder="" required />
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Email</label>
                                    <input type="email" class="form-control" name="email" value="{{ $page->email }}" placeholder="" required />
                                </div>
                              </div>
                          </div>
                          <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Role</label>
                                    <select class="form-control"  name="role" required>
                                      <option value="{{ $page->role }}"> {{ $page->role_name }} </option>
                                      <option value="2"> Cashier </option>
                                      <option value="1"> Admin </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Branch</label>
                                    <select class="form-control" name="branch_id">
                                      <option value="{{ $page->branch_id }}"> {{ $page->branch_name }} </option>
                                      @foreach($data['branch'] as $branch)
                                        <option value="{{ $branch->id }}"> {{ $branch->branch_name }} </option>
                                      @endforeach
                                    </select>
                                </div>
                            </div>
                          </div>
                            <input type="hidden" name="id" value="{{ $page->id }}" />
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save</button>
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