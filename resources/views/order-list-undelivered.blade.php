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
  <style>
    #fontimpact {
      font-family: Impact, Charcoal, sans-serif;
      font-size: 30px;
      /* letter-spacing: 2px;
            word-spacing: 2px; */
      color: #000000;
      font-weight: 700;
      text-decoration: none solid rgb(68, 68, 68);
      font-style: italic;
      font-variant: normal;
      text-transform: none;
    }
  </style>
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
          <h1 class="h3 mb-2 text-gray-800">Pesanan Menunggu</h1>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Daftar Pesanan Menunggu</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Tanggal</th>
                      <th>No. Pesanan</th>
                      <th>Nama Pelanggan</th>
                      <th>Cabang</th>
                      <th>Total Harga</th>
                      <th>Jumlah Pembayaran</th>
                      <th>Status Pembayaran</th>
                      <th>Aksi</th>
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
                    @foreach($data['order'] as $page)
                    <tr>
                      <td>{{ $page->no }}</td>
                      <td>{{ $page->created_at }}</td>
                      <td><a href="#" class="btn btn-primary">{{ $page->transaction_number }}</a></td>
                      <td>{{ $page->customer_name }}</td>
                      <td>{{ $page->branch->branch_name }}</td>
                      <td>{{ number_format($page->total_price) }}</td>
                      <td>{{ number_format($page->total_amount_paid) }}</td>
                      <td>{{ $page->status_name }}</td>
                      <td style="width:15%">
                        @if($page->is_delivered == 1)
                          <div class="row">
                            <div class="col-md-12">
                              <button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#editModal{{ $page->id }}">
                                <!-- <i class="fas fa-fw fa-info" style="margin-left:-6px"></i> --> Terkirim
                              </button>
                            </div>
                          </div>
                        @else
                          @if($page->status == 3)
                            <div class="row">
                              <div class="col-md-12">
                                <button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#editModal{{ $page->id }}">
                                  <!-- <i class="fas fa-fw fa-info" style="margin-left:-6px"></i> --> Dibatalkan
                                </button>
                              </div>
                            </div>
                          @elseif($page->status == 2)
                            <div class="row">
                              <div class="col-md-6">
                                <button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#updateOrderModal{{ $page->id }}">
                                  <i class="fas fa-fw fa-plus" style="margin-left:-6px"></i>
                                </button>
                              </div>
                              <div class="col-md-6">
                                <button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#checkoutModal{{ $page->id }}">
                                  <i class="fas fa-fw fa-money-bill" style="margin-left:-6px"></i>
                                </button>
                              </div>
                            </div>
                          @else
                            <div class="row">
                              <div class="col-md-6">
                                <button type="button" class="btn btn-warning btn-block" data-toggle="modal" data-target="#editModal{{ $page->id }}">
                                  <i class="fas fa-fw fa-info" style="margin-left:-6px"></i>
                                </button>
                              </div>
                              <div class="col-md-6">
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
        @foreach($data['order'] as $page)
        <div class="modal fade" id="editModal{{ $page->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <form method="post" action="{{url('update-order')}}" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="modal-dialog modal-primary" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Informasi Pesanan</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="exampleInputPassword1">Nomor Pesanan</label>
                        <input type="text" class="form-control" name="price" value="{{ $page->transaction_number }}" placeholder="" readonly required />
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Tanggal Pesanan</label>
                        <input type="text" class="form-control" name="stock" value="{{ $page->created_at }}" placeholder="" readonly required />
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                          <tr>
                            <th>Nama Produk</th>
                            <th>Harga per Unit</th>
                            <th>Jumlah</th>
                            <th>Subtotal</th>
                            <th>Status</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($page['transaction_detail'] as $detail)
                          <tr>
                            <td>{{ $detail->product->product_name }}</td>
                            <td>Rp. {{ number_format($detail->unit_price / $detail->qty) }}</td>
                            <td>{{ $detail->qty }}</td>
                            <td>Rp. {{ number_format($detail->unit_price) }}</td>
                            @if($detail->is_delivered == 1)
                              <td>
                                <button type="button" class="btn btn-success btn-block">Terkirim</button>
                              </td>
                            @else
                              <td>
                                <button type="button" class="btn btn-danger btn-block">Belum Terkirim</button>
                              </td>
                            @endif
                          </tr>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="exampleInputPassword1">Catatan Tambahan</label>
                        <textarea class="form-control" id="additional_request" name="additional_request" disabled>{{ $page->additional_request }}</textarea>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="exampleInputPassword1">Total Diskon</label>
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
                        <label for="exampleInputPassword1">Total Harga</label>
                        <input type="text" class="form-control" name="price" value="Rp. {{ number_format($page->total_price) }}" placeholder="" readonly required />
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Total Pembayaran</label>
                        <input type="text" class="form-control" name="stock" value="Rp. {{ number_format($page->total_amount_paid) }}" placeholder="" readonly required />
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="exampleInputPassword1">Status Pembayaran</label>
                        <input type="text" class="form-control" name="price" value="{{ $page->status_name }}" placeholder="" readonly required />
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Status Pesanan</label>
                        <input type="text" class="form-control" name="stock" value="{{ $page->deliver_name }}" placeholder="" readonly required />
                      </div>
                    </div>
                  </div>

                  <input type="hidden" name="id" value="{{ $page->id }}" />
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                  <!-- <a href="order-list/cetak-suratJalan-pdf/{{ $page->id }}" class="btn btn-primary">Cetak Surat Jalan</a> -->
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
        @foreach($data['order'] as $page)
        <div class="modal fade" id="updateOrderModal{{ $page->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <form method="post" action="{{url('add-new-order')}}" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="modal-dialog modal-primary" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Informasi Pesanan</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="exampleInputPassword1">Nomor Pesanan</label>
                        <input type="text" class="form-control" name="price" value="{{ $page->transaction_number }}" placeholder="" readonly required />
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Tanggal Pesanan</label>
                        <input type="text" class="form-control" name="stock" value="{{ $page->created_at }}" placeholder="" readonly required />
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                          <tr>
                            <th>Nama Produk</th>
                            <th>Harga per Unit</th>
                            <th>Jumlah</th>
                            <th>Subtotal</th>
                            <th>Status</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($page['transaction_detail'] as $detail)
                          <tr>
                            <td>{{ $detail->product->product_name }}</td>
                            <td>Rp. {{ number_format($detail->unit_price / $detail->qty) }}</td>
                            <td>{{ $detail->qty }}</td>
                            <td>Rp. {{ number_format($detail->unit_price) }}</td>
                            @if($detail->is_delivered == 1)
                              <td>
                                <button type="button" class="btn btn-success btn-block">Terkirim</button>
                              </td>
                            @else
                              <td>
                                <button type="button" class="btn btn-danger btn-block">Belum Terkirim</button>
                              </td>
                            @endif
                          </tr>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <button type="button" class="btn btn-info btn-block" data-toggle="modal" data-target="#addNewOrderModal">
                          Tambahkan Pesanan Baru
                        </button>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="exampleInputPassword1">Catatan Tambahan</label>
                        <textarea class="form-control" id="additional_request" name="additional_request">{{ $page->additional_request }}</textarea>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="exampleInputPassword1">Total Diskon</label>
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
                        <label for="exampleInputPassword1">Total Harga</label>
                        <input type="text" class="form-control" name="price" value="Rp. {{ number_format($page->total_price) }}" placeholder="" readonly required />
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Total Pembayaran</label>
                        <input type="text" class="form-control" name="stock" value="Rp. {{ number_format($page->total_amount_paid) }}" placeholder="" readonly required />
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="exampleInputPassword1">Status Pembayaran</label>
                        <input type="text" class="form-control" name="price" value="{{ $page->status_name }}" placeholder="" readonly required />
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Status Pesanan</label>
                        <input type="text" class="form-control" name="stock" value="{{ $page->deliver_name }}" placeholder="" readonly required />
                      </div>
                    </div>
                  </div>

                  <input type="hidden" name="id" value="{{ $page->id }}" />
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                  <!-- <a href="order-list/cetak-suratJalan-pdf/{{ $page->id }}" class="btn btn-primary">Cetak Surat Jalan</a> -->
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
        
        <div class="modal fade" id="addNewOrderModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-primary" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Daftar Produk</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="row">
                  <div class="card shadow mb-4 col-md-12">
                    <div class="card-body">
                      <ul class="nav nav-tabs" id="myTab" role="tablist">

                        @foreach($data['product_category'] as $key => $product_category)
                          <li class="nav-item">

                          @if($key == 0)
                            <a class="nav-link" id="home-tab-{{ $product_category->id }}" data-toggle="tab" href="#home-{{ $product_category->id }}" role="tab" aria-controls="home-{{ $product_category->id }}" aria-selected="true">{{ $product_category->category_name }}</a>
                          @else
                            <a class="nav-link" id="home-tab-{{ $product_category->id }}" data-toggle="tab" href="#home-{{ $product_category->id }}" role="tab" aria-controls="home-{{ $product_category->id }}" aria-selected="false">{{ $product_category->category_name }}</a>
                          @endif
                          </li>
                        @endforeach
                      </ul>

                      <div class="tab-content" id="myTabContent">
                        @foreach($data['product_category'] as $key => $product_category)
                          @if($key == 0)
                            <div class="tab-pane fade show active" id="home-{{ $product_category->id }}" role="tabpanel" aria-labelledby="home-tab-{{ $product_category->id }}">
                          @else
                            <div class="tab-pane fade" id="home-{{ $product_category->id }}" role="tabpanel" aria-labelledby="home-tab-{{ $product_category->id }}">
                          @endif
                            <div class="row">
                              <!-- Earnings (Monthly) Card Example -->
                              @foreach($product_category->product as $product)
                                <div class="col-xl-3 col-md-6 mb-4">
                                  <div class="card border-left-primary shadow h-100 py-2">
                                    <div class="card-body">
                                      <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                          <div class="text-xs font-weight-bold text-primary text-uppercase mb-1 name_product_class">{{ $product->product_name }}</div>
                                          <div class="text-xs font-weight-bold text-gray-500 text-uppercase mb-1">Stock {{ $product->stock }}</div>
                                          <div class="h5 mb-0 font-weight-bold text-gray-800">Rp.{{ number_format($product->price) }}</div>
                                        </div>
                                        <div class="col mr-2">
                                          <div class="quantity">
                                            <input type="hidden" id="product_pricing{{ $product->no }}" value="{{ $product->price }}"/>
                                            <input type="hidden" id="name_product{{ $product->no }}" value="{{ $product->product_name }}"/>
                                            <input type="hidden" id="product_id_store{{ $product->no }}" value="{{ $product->id }}"/>
                                          </div>
                                        </div>
                                        <div class="col-auto">
                                          <input type="number" style="width:50%" value="0" min="0" max="99" id="quantity__input{{ $product->no }}" class="quantity__input">
                                          <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              @endforeach
                            </div>
                          </div>
                        @endforeach
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>

        <!-- Modal !-->
        @foreach($data['order'] as $page)
        <div class="modal fade" id="deliveredModal{{ $page->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <form method="post" action="{{url('delivered-order')}}" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="modal-dialog modal-primary" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Konfirmasi Pesanan terkirim</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="exampleInputPassword1">Nomor Pesanan</label>
                        <input type="text" class="form-control" name="price" value="{{ $page->transaction_number }}" placeholder="" readonly required />
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Tanggal Pesanan</label>
                        <input type="text" class="form-control" name="stock" value="{{ $page->created_at }}" placeholder="" readonly required />
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                          <tr>
                            <th>Nama Produk</th>
                            <th>Harga per Unit</th>
                            <th>Jumlah</th>
                            <th>Subtotal</th>
                            <th>Status</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($page['transaction_detail'] as $detail)
                          <tr>
                            <td>{{ $detail->product->product_name }}</td>
                            <td>{{ number_format($detail->unit_price / $detail->qty) }}</td>
                            <td>{{ $detail->qty }}</td>
                            <td>{{ number_format($detail->unit_price) }}</td>
                            @if($detail->is_delivered == 1)
                              <td>
                                <button type="button" class="btn btn-success btn-block">Terkirim</button>
                              </td>
                            @else
                              <td>
                                <button type="button" class="btn btn-danger btn-block">Belum Terkirim</button>
                              </td>
                            @endif
                          </tr>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="exampleInputPassword1">Catatan Tambahan</label>
                        <textarea class="form-control" id="additional_request" name="additional_request" disabled>{{ $page->additional_request }}</textarea>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="exampleInputPassword1">Total Diskon</label>
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
                        <label for="exampleInputPassword1">Total Harga</label>
                        <input type="text" class="form-control" name="price" value="Rp. {{ number_format($page->total_price) }}" placeholder="" readonly required />
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Total Pembayaran</label>
                        <input type="text" class="form-control" name="stock" value="Rp. {{ number_format($page->total_amount_paid) }}" placeholder="" readonly required />
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="exampleInputPassword1">Status Pembayaran</label>
                        <input type="text" class="form-control" name="price" value="{{ $page->status_name }}" placeholder="" readonly required />
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Status Pesanan</label>
                        <input type="text" class="form-control" name="stock" value="{{ $page->deliver_name }}" placeholder="" readonly required />
                      </div>
                    </div>
                  </div>

                  <input type="hidden" name="id" value="{{ $page->id }}" />
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                  <button type="submit"  class="btn btn-primary">Pesanan Dikirim</button>
                  <!-- <a href="order-list/cetak-suratJalan-pdf/{{ $page->id }}" class="btn btn-primary">Cetak Surat Jalan</a> -->
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
        @foreach($data['order'] as $page)
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
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="exampleInputPassword1">Catatan Tambahan</label>
                        <textarea class="form-control" id="additional_request" name="additional_request" disabled>{{ $page->additional_request }}</textarea>
                      </div>
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
              <span>Copyright &copy; Coffe Shop 2019</span>
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
      $('.printFaktur').click(function() {
        $(".fakturPrint").print();
      });
    </script>
</body>

</html>