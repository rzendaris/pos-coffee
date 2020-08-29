<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <!--Fontawesome CDN-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <style>
        #fontimpact {
            font-family: Impact, Charcoal, sans-serif;
            font-size: 30px;
            color: #000000;
            font-weight: 700;
            text-decoration: none solid rgb(68, 68, 68);
            font-style: italic;
            font-variant: normal;
            text-transform: none;
        }
    </style>
    <script>
            $(document).ready(function() {
                window.print();
            });

            (function () {

                var beforePrint = function () {
                    console.log('Functionality to run before printing.');
                };

                var afterPrint = function () {
                    console.log('Functionality to run after printing');
                    window.top.close();
                };

                if (window.matchMedia) {
                    var mediaQueryList = window.matchMedia('print');

                    mediaQueryList.addListener(function (mql) {
                        //alert($(mediaQueryList).html());
                        if (mql.matches) {
                            beforePrint();
                        } else {
                            afterPrint();
                        }
                    });
                }

                window.onbeforeprint = beforePrint;
                window.onafterprint = afterPrint;

            }());
    </script>
</head>

<body>

    <div class="container">
        <div class="card">
            <div class="card-header">
                <span id="fontimpact">NOTA PENJUALAN</span>
                <span class="float-right" id="fontimpact">Centro Links</span>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-sm-6">
                        <div class="d-flex justify-content-between" style="width: 100%">
                            <p class="mb-3">No</p>
                            <p style="width: 50%;font-weight: bold">: {{ $data->transaction_number }}</p>
                        </div>
                        <div class="d-flex justify-content-between" style="width: 100%">
                            <p class="mb-3">To</p>
                            <p style="width: 50%;font-weight: bold">: {{ $data->customer->customer_name }}</p>
                        </div>
                        <div class="d-flex justify-content-between" style="width: 100%">
                            <p class="mb-3">Address</p>
                            <p style="width: 50%;font-weight: bold">: {{ $data->customer->address }}</p>
                        </div>
                        <div class="d-flex justify-content-between" style="width: 100%">
                            <p class="mb-3">Jenis Pembayaran</p>
                            <p style="width: 50%;font-weight: bold">: {{ $data->payment_type }}</p>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="d-flex justify-content-between" style="width: 100%">
                            <p class="mb-3">Date</p>
                            <p style="width: 50%;font-weight: bold">: {{ $data->created_at }}</p>
                        </div>
                        <div class="d-flex justify-content-between" style="width: 100%">
                            <p class="mb-3">No. PO</p>
                            <p style="width: 50%;font-weight: bold">: {{ $data->transaction_number }}</p>
                        </div>
                        <div class="d-flex justify-content-between" style="width: 100%">
                            <p class="mb-3">Term</p>
                            <p style="width: 50%;font-weight: bold">: - </p>
                        </div>
                        <div class="d-flex justify-content-between" style="width: 100%">
                            <p class="mb-3">Cabang</p>
                            <p style="width: 50%;font-weight: bold">: {{ $data->branch->branch_name }}</p>
                        </div>
                        <div class="d-flex justify-content-between" style="width: 100%">
                            <p class="mb-3">User</p>
                            <p style="width: 50%;font-weight: bold">: {{ $data->created_by }}</p>
                        </div>
                    </div>
                </div>

                <div class="table-responsive-sm">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Description</th>
                                <th class="center">Qty</th>
                                <th class="right">Price</th>
                                <th class="right">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data['transaction_detail'] as $detail)
                            <tr>
                                <td>{{ $detail->product->product_name }}</td>
                                <td>{{ $detail->qty }}</td>
                                <td>{{ number_format($detail->unit_price / $detail->qty) }}</td>
                                <td>{{ number_format($detail->unit_price) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-sm-5">
                        <table class="table table-clear">
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-lg-4 col-sm-5 ml-auto">
                        <table class="table table-clear">
                            <tbody>
                                <tr>
                                    <td class="left">
                                        <strong>Total :</strong>
                                    </td>
                                    <td class="left">
                                        <strong>Rp. {{ number_format($data->total_price) }} <i>(+ppn {{number_format($data->total_ppn)}} )</i></strong>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-sm-5">
                        <table class="table table-clear">
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-lg-4 col-sm-5 ml-auto">
                        <table class="table table-clear">
                            <tbody>
                            @foreach($data['transaction_payment'] as $payment)
                                <tr>
                                    <td class="left">
                                        <strong>Pembayaran {{ $payment->no }} :</strong>
                                    </td>
                                    <td class="right">
                                        <strong>Rp. {{ number_format($payment->amount_paid) }}</strong>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-sm-5">
                        <table class="table table-clear">
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    @if($data->total_amount_paid < $data->total_price)
                    <div class="col-lg-4 col-sm-5 ml-auto">
                        <table class="table table-clear">
                            <tbody>
                                <tr>
                                    <td class="left">
                                        <strong>Sisa pembayaran anda adalah :</strong>
                                    </td>
                                    <td class="right">
                                        <strong>Rp. {{ number_format($data->total_price - $data->total_amount_paid) }}</strong>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
                <div class="d-flex justify-content-between" style="padding: 30px">
                    <p class="mt-3">{{ $data->customer->customer_name }}</p>
                    <p class="mt-3">PT Centro Links Indonesia</p>
                    <p class="mt-3">Pengirim</p>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>
</body>

</html>