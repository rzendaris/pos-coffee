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
          </div>

          <div class="row">
          
            <div class="card shadow mb-4 col-md-8">
              <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Produk</h6>
              </div>
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
                                <!-- <img src="http://venetaonline.com/uploads/product/CISS_EPSON_L800_Poto_Cyan2.jpg" width="80" height="80"> -->
                                <img src="{{ asset('images/'.$product->image)}}" width="120" height="80">
                                <div class="row no-gutters align-items-center">
                                  <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1 name_product_class">{{ $product->product_name }}</div>
                                    <div class="text-xs font-weight-bold text-gray-500 text-uppercase mb-1">Stock {{ $product->stock }}</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">Rp.{{ number_format($product->price) }}</div>
                                  </div>
                                  <div class="col mr-2">
                                    <div class="quantity">
                                      <!-- <a href="#" class="quantity__minus" id="quantity__minus{{ $product->no }}"><span>-</span></a> -->
                                      <!-- <input name="quantity" type="text" class="quantity__input" id="quantity__input{{ $product->no }}" value="0"> -->
                                      <!-- <input type="number" style="width:150%" value="0" min="0" max="99" id="quantity__input{{ $product->no }}" class="quantity__input"> -->

                                      <input type="hidden" id="product_pricing{{ $product->no }}" value="{{ $product->price }}"/>
                                      <input type="hidden" id="name_product{{ $product->no }}" value="{{ $product->product_name }}"/>
                                      <input type="hidden" id="product_id_store{{ $product->no }}" value="{{ $product->id }}"/>

                                      <!-- <a href="#" class="quantity__plus" id="quantity__plus{{ $product->no }}"><span>+</span></a> -->
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

              <div class="col-md-4">
                <div class="card shadow mb-4">
                  <!-- Card Header - Dropdown -->
                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Struk Record</h6> 
                  </div>
                  <!-- Card Body -->
                  <div class="card-body">
                    <div class="form-group">
                       <label for="exampleInputEmail1">No. Pesanan</label>
                       <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="#: INV-78225" value="{{ $data['transaction_number'] }}" disabled>
                    </div>
                    <hr>

                    <div class='d-flex justify-content-between'>
                      <label style="width:50%" for='exampleInputEmail1'>Nama Produk</label>
                      <label style="width:20%" for='exampleInputEmail1'>Jumlah</label>
                      <label style="width:30%" for='exampleInputEmail1'>Harga</label>
                    </div>
                    <div class="list_invoice">
                      
                    </div>
                    <hr>
                  </div>
                </div>

                <div class="card shadow mb-4">
                  <!-- Card Header - Dropdown -->
                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Record</h6> 
                  </div>
                  <!-- Card Body -->
                  <div class="card-body">
                    <div class="d-flex justify-content-between">
                      <label for="exampleInputEmail1">Subtotal</label>
                      <label for="exampleInputEmail1"><p id="price_product"></p></label>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                      <label for="exampleInputEmail1">PPN 0%</label>
                      <label for="exampleInputEmail1"><p id="ppn_10"></p></label>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                      <label for="exampleInputEmail1">Total</label>
                      <label for="exampleInputEmail1"><p id="total_price"></p></label>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                      <a href="#" data-toggle="modal" data-target="#payNow" class="btn btn-primary btn-icon-split">
                        <span class="icon text-white-50">
                          <i class="fas fa-flag"></i>
                        </span>
                        <span class="text">Bayar Sekarang</span>
                      </a>
                      <a href="#" data-toggle="modal" data-target="#payLater" class="btn btn-danger btn-icon-split">
                        <span class="icon text-white-50">
                          <i class="fas fa-flag"></i>
                        </span>
                        <span class="text">Bayar Nanti</span>
                      </a>
                    </div>
                  </div>
                </div>
              </div>

            </div>

            <div class="modal fade" id="payNow" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Review Transaksi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <form method="post" id="formPayNow" action="{{url('add-transaction')}}" enctype="multipart/form-data" class="mt-2">
                    {{csrf_field()}}
                    <div class="modal-body">
                      <div class='d-flex justify-content-between'>
                        <label style="width:50%" for='exampleInputEmail1'>Nama Produk</label>
                        <label style="width:20%" for='exampleInputEmail1'>Jumlah</label>
                        <label style="width:30%" for='exampleInputEmail1'>Harga</label>
                      </div>
                      <div class="list_invoice">
                      
                      </div>
                      <hr>
                      <div class='d-flex justify-content-between'>
                        <label style="width:70%" for='exampleInputEmail1'><b>Total Harga</b></label>
                        <label style="width:30%" for='exampleInputEmail1'><b><p id="total_price_pop"></p></b></label>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group data_cus_form">
                            <label for="message-text" class="col-form-label">Nama Pelanggan</label>
                            <input class="form-control" id="customer_name" name="customer_name" required/>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group data_cus_form">
                            <label for="message-text" class="col-form-label">Metode Pembayaran</label>
                            <select class="form-control" id="payment_method" name="payment_method">
                              <option value="TUNAI">TUNAI</option>
                              <option value="DEBIT">DEBIT</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group data_cus_form">
                            <label for="message-text" class="col-form-label">Pilih Meja</label>
                            <!-- <input class="form-control" id="seat_table" name="seat_table"/> -->
                            <select class="form-control" name="seat_table">
                              <option value="">--</option>
                              @foreach($data['seat_table'] as $table)
                                @if($table->status == 1)
                                  <option value="{{ $table->seat_no }}">{{ $table->seat_no }}</option>
                                @endif
                              @endforeach
                              <option value="">TAKEAWAY</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group data_cus_form">
                            <label for="message-text" class="col-form-label">Uang yang Dibayar:</label>
                            <input class="form-control" id="total_amount_paid" name="total_amount_paid" onkeyup="this.value=addCommas(this.value);" required/>
                            <input class="form-control" type="hidden" id="total_price_calculate" name="total_price_calculate"/>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group data_cus_form">
                            <label for="message-text" class="col-form-label">Kembalian :</label>
                            <input class="form-control" id="credit" name="credit" readonly required/>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group data_cus_form">
                            <label for="message-text" class="col-form-label">Catatan Tambahan:</label>
                            <textarea class="form-control" id="additional_request" name="additional_request"></textarea>
                          </div>
                        </div>
                      </div>
                      <div id="wings"></div>
                        <div id="seatmap">
                            <div id="plane">
                                <div id="cabin">        
                                    <table>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                      @foreach($data['seat_table'] as $seat)
                                        @if($seat->location == 'OUTDOOR')
                                          @if($seat->status == 1)
                                            <td title="1J" class="seatAvailable">{{ $seat->seat_no }}</td>
                                          @else
                                            <td title="1J" class="seatUnavailable">{{ $seat->seat_no }}</td>
                                          @endif
                                        @endif
                                      @endforeach
                                    </tr>
                                    <tr>
                                        <td class="noSeatGalley"></td>
                                        <td class="noSeatGalley"></td>
                                        <td class="noSeatGalley"></td>
                                        <td class="noSeatGalley"></td>
                                        <td class="noSeatGalley"></td>
                                        <td class="noSeatGalley"></td>
                                        <td class="noSeatGalley"></td>
                                        <td class="noSeatGalley"></td>
                                        <td class="noSeatGalley"></td>
                                        <td class="noSeatGalley"></td>
                                        <td class="noSeatGalley"></td>
                                    </tr>
                                    <tr>
                                        <td class="noSeatGalley">-</td>
                                        <td class="noSeatGalley">-</td>
                                        <td class="noSeatGalley">-</td>
                                        <td class="noSeatGalley">-</td>
                                        <td class="noSeatGalley">-</td>
                                        <td class="noSeatGalley">-</td>
                                        <td class="noSeatGalley">-</td>
                                        <td class="noSeatGalley">-</td>
                                        <td class="noSeatGalley">-</td>
                                        <td class="noSeatGalley">-</td>
                                        <td class="noSeatGalley">-</td>
                                    </tr>
                                    <tr>
                                        <td class="noSeatGalley"></td>
                                        <td class="noSeatGalley"></td>
                                        <td class="noSeatGalley"></td>
                                        <td class="noSeatGalley"></td>
                                        <td class="noSeatGalley"></td>
                                        <td class="noSeatGalley"></td>
                                        <td class="noSeatGalley"></td>
                                        <td class="noSeatGalley"></td>
                                        <td class="noSeatGalley"></td>
                                        <td class="noSeatGalley"></td>
                                        <td class="noSeatGalley"></td>
                                    </tr>
                                    <tr>
                                      @foreach($data['seat_table'] as $seat)
                                        @if($seat->location == 'INDOOR')
                                          @if($seat->status == 1)
                                            <td title="1J" class="seatAvailable">{{ $seat->seat_no }}</td>
                                          @else
                                            <td title="1J" class="seatUnavailable">{{ $seat->seat_no }}</td>
                                          @endif
                                        @endif
                                      @endforeach
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    </table>            
                                </div>
                                <div style="clear: both;"></div>
                            </div>
                        </div>
                        <div id="wings"></div>

                      <input type="hidden" id="product_id" name="product_id[]" />
                      <input type="hidden" id="product_qty" name="product_qty[]" />
                      <input type="hidden" id="product_qty" name="paid_status" value="1" />
                      <input type="hidden" id="transaction_number" name="transaction_number" value="{{ $data['transaction_number'] }}" />
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                      <button id="buttonSubmitNow" class="btn btn-primary" disabled>Simpan</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>

            <div class="modal fade" id="payLater" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Review Transaction</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <form method="post" id="formPayLater" action="{{url('add-transaction')}}" enctype="multipart/form-data" class="mt-2">
                    {{csrf_field()}}
                    <div class="modal-body">
                      <div class='d-flex justify-content-between'>
                        <label style="width:50%" for='exampleInputEmail1'>Nama Produk</label>
                        <label style="width:20%" for='exampleInputEmail1'>Jumlah</label>
                        <label style="width:30%" for='exampleInputEmail1'>Harga</label>
                      </div>
                      <div class="list_invoice">
                      
                      </div>
                      <hr>
                      <div class='d-flex justify-content-between'>
                        <label style="width:70%" for='exampleInputEmail1'><b>Total Harga</b></label>
                        <label style="width:30%" for='exampleInputEmail1'><b><p id="total_price_later"></p></b></label>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group data_cus_form">
                            <label for="message-text" class="col-form-label">Nama Pelanggan</label>
                            <input class="form-control" id="customer_name_later" name="customer_name" required/>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group data_cus_form">
                            <label for="message-text" class="col-form-label">Pilih Meja</label>
                            <!-- <input class="form-control" id="seat_table" name="seat_table"/> -->
                            <select class="form-control" name="seat_table">
                              <option value="">--</option>
                              @foreach($data['seat_table'] as $table)
                                @if($table->status == 1)
                                  <option value="{{ $table->seat_no }}">{{ $table->seat_no }}</option>
                                @endif
                              @endforeach
                              <option value="">TAKEAWAY</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group data_cus_form">
                            <label for="message-text" class="col-form-label">Catatan Tambahan:</label>
                            <textarea class="form-control" id="additional_request" name="additional_request"></textarea>
                          </div>
                        </div>
                      </div>
                      <input type="hidden" id="product_id_later" name="product_id[]" />
                      <input type="hidden" id="product_qty_later" name="product_qty[]" />
                      <input type="hidden" id="product_qty" name="paid_status" value="2" />
                      <input type="hidden" id="transaction_number" name="transaction_number" value="{{ $data['transaction_number'] }}" />
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                      <button id="buttonSubmitLater" class="btn btn-primary">Simpan</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Input Hide for Receipt -->
        <input type="hidden" id="branch_name" value="{{ $data['branch']->branch_name }}"/>
        <input type="hidden" id="branch_address" value="{{ $data['branch']->address }}"/>
        <input type="hidden" id="branch_city" value="Pekanbaru"/>
        <input type="hidden" id="branch_telp" value="{{ $data['branch']->telp }}"/>
        <input type="hidden" id="branch_email" value="{{ $data['branch']->email }}"/>
        <input type="hidden" id="branch_cashier" value="{{ Auth::user()->name }}"/>
        <input type="hidden" id="branch_wifi" value="{{ $data['branch']->wifi }}"/>
        <!-- End of input hide -->

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
      function addCommas(nStr) {
          nStr += '';
          var x = nStr.split('.');
          var x1 = x[0];
          var x2 = x.length > 1 ? '.' + x[1] : '';
          var rgx = /(\d+)(\d{3})/;
          while (rgx.test(x1)) {
              x1 = x1.replace(rgx, '$1' + ',' + '$2');
          }
          return x1 + x2;
      }
      
      var base_url = "http://127.0.0.1:8000";
      // var base_url = "http://pos.chopper-tech.com";

      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      
      var minus = [];
      var plus = [];
      var input = [];
      $(".quantity__minus").each(function(){
        minus.push($(this).attr('id'));
      });
      $(".quantity__plus").each(function(){
        plus.push($(this).attr('id'));
      });
      $(".quantity__input").each(function(){
        input.push($(this).attr('id'));
      });

      $.each(minus, function(){
        var urutan = this.substr(this.length - 1);
        $("#"+this).click(function(e) {
          e.preventDefault();
          var value = $("#quantity__input"+urutan).val();
          if (value > 0) {
            value -= 1;
          }
          $("#quantity__input"+urutan).val(value+1);
          getQty();
        });
      });
      
      $.each(plus, function(){
        var urutan = this.substr(this.length - 1);
        $("#"+this).click(function(e) {
          e.preventDefault();
          var value = parseInt($("#quantity__input"+urutan).val());
          if(value == 0){
            value = 1;
          }
          console.log("Value before " + value);
          value++;
          console.log("Value after " + value);
          if(parseInt($("#quantity__input"+urutan).val()) == (value - 1)){
            console.log("Disini");
          }
          $("#quantity__input"+urutan).val(value - 1);
          getQty();
        })
      });
      
      $.each(input, function(){
        var urutan = this.substr(this.length - 1);
        $("#"+this).change(function(e) {
          e.preventDefault();
          var value = $("#quantity__input"+urutan).val();
          $("#quantity__input"+urutan).val(value);
          getQty();
        })
      });
      var product_order = [];

      function getQty(newdiv){
        var count_product = <?php echo $data['count']; ?>;
        var list_invoice = [];
        var product_id_temp = [];
        var qty_temp = [];
        var product_order_temp = [];
        var total = 0;
        for(i = 1; i <= count_product; i++ ){
          var qty = $("#quantity__input"+i).val();
          console.log(" No > " + i + " , qty > " + qty);
          if(qty > 0){
            var price = $("#product_pricing"+i).val();
            var product_total = (qty * price).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            var newdiv = $( `<div class='d-flex justify-content-between'><label style="width:50%" for='exampleInputEmail1'>${$('#name_product'+i).val()}</label><label style="width:20%" for='exampleInputEmail1'>${qty}</label><label style="width:30%" for='exampleInputEmail1'>${product_total}</label></div>` );

            list_invoice.push(newdiv);
            product_id_temp.push($("#product_id_store"+i).val());
            qty_temp.push(qty);
            total += qty * price;

            var product_json = {
              "product_name": $('#name_product'+i).val(),
              "qty": qty,
              "price": price
            }
            product_order_temp.push(product_json);
          }
        }
        product_order = product_order_temp;
        $('.list_invoice').html( list_invoice );

        $('#product_id').val( product_id_temp );
        $('#product_qty').val( qty_temp );
        $('#product_id_later').val( product_id_temp );
        $('#product_qty_later').val( qty_temp );

        $('#price_product').html("Rp. " + total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        $('#ppn_10').html((0).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        $('#total_price').html("Rp. " + (total).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        $('#total_price_pop').html("Rp. " + (total).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        $('#total_price_later').html("Rp. " + (total).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        $('#total_price_calculate').val(total);
      }

      $('#total_amount_paid').on('input', function() {
        var amount_paid = $('#total_amount_paid').val().replace(/,/g, '');
        var total_price_after = $('#total_price_calculate').val();
        var credit = amount_paid - total_price_after;
        $('#credit').val("Rp. " + (credit).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","))
        if (credit < 0){
          $('#buttonSubmitNow').prop("disabled", true);
        } else {
          $('#buttonSubmitNow').prop("disabled", false);
        }
      });

      $("#payment_method").change(function(e) {
          e.preventDefault();
          var payment_method = $("#payment_method").val();
          if(payment_method != 'TUNAI'){
            $('#total_amount_paid').prop("disabled", true);
            $('#total_amount_paid').val($('#total_price_calculate').val());
            $('#buttonSubmitNow').prop("disabled", false);
          } else {
            $('#total_amount_paid').prop("disabled", false);
            $('#total_amount_paid').val(0);
            $('#buttonSubmitNow').prop("disabled", true);
          }
      });
      
      var printer = new Recta('8838015258', '1811')
      printer.open().then(() => {
          // Show print button, it's hidden by default
          $('#print').show();
      }).catch((e) => {
          // Show Error if get an Error
          $('#error').text(e);
      });
      
      function spaces(x) {
          var res = '';
          while(x--) res += ' ';
          return res;
      }
      function dateToNiceString(myDate){
        var month=new Array();
        month[0]="Jan";
        month[1]="Feb";
        month[2]="Mar";
        month[3]="Apr";
        month[4]="Mei";
        month[5]="Jun";
        month[6]="Jul";
        month[7]="Agu";
        month[8]="Sep";
        month[9]="Okt";
        month[10]="Nov";
        month[11]="Des";
        var hours = myDate.getHours();
        var minutes = myDate.getMinutes();
        var ampm = hours >= 12 ? 'pm' : 'am';
        hours = hours % 12;
        hours = hours ? hours : 12;
        minutes = minutes < 10 ? '0'+minutes : minutes;
        var strTime = hours + ':' + minutes + ampm;
        return myDate.getDate()+" "+month[myDate.getMonth()]+" "+myDate.getFullYear()+" "+strTime;
      }
      
      $( "#buttonSubmitNow" ).click(function() {
          printer
              .underline(false)
              .align('center')
                .text($('#branch_name').val())
              .align('center')
                .text($('#branch_address').val())
              .align('center')
                .text($('#branch_city').val())
                .text('--------------------------------')
              .align('left')
                .text('Waktu      : ' + dateToNiceString(new Date()))
                .text('No Pesanan : ' + $('#transaction_number').val())
                .text('Kasir      : ' + $('#branch_cashier').val())
                .text('Pelanggan  : ' + $('#customer_name').val())
                .text('--------------------------------')
                .feed(2);

          var total_price = 0;
          for (var i = 0, l = product_order.length; i < l; i++) {
              var obj = product_order[i]['product_name'];
              var sub_price = product_order[i]['qty'] * product_order[i]['price'];
              var left_side = product_order[i]['qty'] + " x @" + product_order[i]['price'].toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
              var right_side = sub_price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
              var space_available = 32 - (left_side.length + right_side.length);
              total_price += sub_price;
              printer
                  .align('left')
                    .text(product_order[i]['product_name'])
                  .align('left')
                    .text(left_side + spaces(space_available) + right_side);
          }
          var total_left_side = "Total  ";
          var total_right_side = total_price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
          var total_space_available = 32 - (total_left_side.length + total_right_side.length);
          var payment_method = $('#payment_method').val();
          var total_amount_paid = $('#total_amount_paid').val().replace(/,/g, '');
          var string_total_amount_paid = $('#total_amount_paid').val();
          var payment_space_available = 32 - (payment_method.length + string_total_amount_paid.length);
          var change = total_amount_paid - total_price;
          var change_space_available = 23 - change.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",").length;
          printer
              .feed(1)
            .align('center')
            .bold(true)
              .text(total_left_side + spaces(total_space_available) + total_right_side)
              .text('--------------------------------')
            .bold(false)
              .text(payment_method + spaces(payment_space_available) + string_total_amount_paid)
              .text("KEMBALIAN" + spaces(change_space_available) + change.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","))
              .feed(2)
              .text('--------------------------------');
          // Footer
          printer
            .align('center')
            .bold(false)
              .text('Hubungi kami:')
              .text($('#branch_email').val())
              .text($('#branch_telp').val())
              .text('Wifi Pass : ' + $('#branch_wifi').val())
              .text('--------------------------------')
              .cut()
              .print();
        $( "#formPayNow" ).submit();
      });
    });
  </script>
</body>

</html>