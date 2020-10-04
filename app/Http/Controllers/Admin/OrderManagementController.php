<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Image;
use File;

use App\Model\Tables\Customer;
use App\Model\Tables\Branch;
use App\Model\Tables\Transaction;
use App\Model\Tables\Payment;
use App\Model\Tables\TransactionDetail;
use App\Model\Tables\ProductCategory;
use App\Model\Tables\Product;
use PDF;

class OrderManagementController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function allOrder()
    {
        try{
            $data = Transaction::with(['branch', 'transaction_detail', 'transaction_detail.product'])->whereDate('created_at', date("Y-m-d"))->where('status','!=', 3)->where('branch_id', Auth::user()->branch_id)->orderBy('id', 'desc')->get();
            $no = 1;
            $total_transaction = 0;
            foreach($data as $page){
                $page->no = $no;

                if($page->status == 1){
                    $page->status_name = 'Paid';
                } else {
                    $page->status_name = 'Not Paid';
                }

                if($page->is_delivered == 1){
                    $page->deliver_name = 'Delivered';
                } else {
                    $page->deliver_name = 'Not Delivered';
                }
                $total_transaction += $page->total_price;

                $no++;
            }
            $return_data = array(
                'transaction' => $data,
                'total_transaction' => $total_transaction
            );

            return view('order-list')->with('data', $return_data);
        
        } catch (Exception $e) {
            report($e);

            return redirect('order-list');
        }
    }
    
    public function orderRetur()
    {
        try{
            $data = Transaction::with(['branch', 'customer', 'transaction_detail', 'transaction_detail.product'])->where('status', 3)->where('branch_id', Auth::user()->branch_id)->orderBy('id', 'desc')->get();
            $no = 1;
            foreach($data as $page){
                $page->no = $no;

                if($page->status == 1){
                    $page->status_name = 'Paid';
                } else {
                    $page->status_name = 'Not Paid';
                }

                if($page->is_delivered == 1){
                    $page->deliver_name = 'Delivered';
                } else {
                    $page->deliver_name = 'Not Delivered';
                }

                $no++;
            }

            return view('order-retur')->with('data', $data);
        
        } catch (Exception $e) {
            report($e);

            return redirect('order-list');
        }
    }

    public function deliveredOrder(Request $request)
    {
        try{
            Transaction::where('id', $request->id)->update([
                'is_delivered' => 1,
                'updated_by' => Auth::user()->name
            ]);

            return redirect('order-undelivered');
        
        } catch (Exception $e) {
            report($e);

            return redirect('order-undelivered');
        }
    }

    public function cetakPdf($id)
    {
        try{
            $data = Transaction::with(['branch', 'customer', 'transaction_detail', 'transaction_detail.product'])->where('id', $id)->first();
            return view('invoicePdf')->with('data', $data);

            // $pdf = \PDF::loadView('invoicePdf');
            // $filename = "invoicePdf".$id.".pdf";
            // // $pdf->save(storage_path().$filename);

            // return $pdf->download('invoice-pdf.pdf');
            // // redirect('order-list');
        
        } catch (Exception $e) {
            report($e);

            return redirect('order-list');
        }
    }

    public function cetakReturPdf($id)
    {
        try{
            $data = Transaction::with(['branch', 'customer', 'transaction_detail', 'transaction_detail.product'])->where('id', $id)->first();
            return view('invoiceReturPdf')->with('data', $data);

            // $pdf = \PDF::loadView('invoicePdf');
            // $filename = "invoicePdf".$id.".pdf";
            // // $pdf->save(storage_path().$filename);

            // return $pdf->download('invoice-pdf.pdf');
            // // redirect('order-list');
        
        } catch (Exception $e) {
            report($e);

            return redirect('order-list');
        }
    }

    public function cetakSuratJalan($id)
    {
        try{
            $data = Transaction::with(['branch', 'customer', 'transaction_detail', 'transaction_detail.product'])->where('id', $id)->first();
            return view('suratJalan')->with('data', $data);

            // $pdf = \PDF::loadView('invoicePdf');
            // $filename = "invoicePdf".$id.".pdf";
            // // $pdf->save(storage_path().$filename);

            // return $pdf->download('invoice-pdf.pdf');
            // // redirect('order-list');
        
        } catch (Exception $e) {
            report($e);

            return redirect('order-list');
        }
    }

    public function cetakNota($id)
    {
        try{
            $data = Transaction::with(['branch', 'customer', 'transaction_detail', 'transaction_detail.product', 'transaction_payment'])->where('transaction_number', $id)->first();
            $no = 1;

            $data->payment_type = "";
            foreach($data['transaction_payment'] as $payment){
                $payment->no = $no;
                if($payment->payment_method == "Tunai"){
                    $data->payment_type = "Cash";
                } else {
                    $data->payment_type = $payment->bank_account. " - " . $payment->number_account. " - a/n " .$data->customer->customer_name;
                }
                
                $no++;
            }
            return view('notaPenjualan')->with('data', $data);
        
        } catch (Exception $e) {
            report($e);

            return redirect('order-list');
        }
    }

    public function cancelOrder(Request $request)
    {
        try{
            Transaction::where('id', $request->id)->update([
                'status' => 3,
                'updated_by' => Auth::user()->name
            ]);

            return redirect('order-list');
        
        } catch (Exception $e) {
            report($e);

            return redirect('order-list');
        }
    }

    public function mainPayment()
    {
        try{

            return view('penerimaanCash');
        
        } catch (Exception $e) {
            report($e);

            return redirect('payment');
        }
    }

    public function checkTransaction($transaction_number)
    {
        try{
            $data = Transaction::where('transaction_number', $transaction_number)->where('status', 2)->first();
            if(isset($data)){
                $data->total_price = "Rp. ". number_format($data->total_price - $data->total_amount_paid);
                return response()->json([
                    "code" => 501,
                    "data" => $data
                ],200);
            } else {
                return response()->json([
                    "code" => 1000,
                    "error" => "Data not Found"
                ],200);
            }
        } catch (Exception $e) {
            report($e);

            return response()->json([
                "code" => 1000,
                "error" => "Data not Found"
            ],200);
        }
    }

    public function postPayment(Request $request)
    {
        try{
            $data = Transaction::where('transaction_number', $request->transaction_number)->where('status', 2)->first();
            if(isset($data)){
                $payment = new Payment([
                    'transaction_number' => $data->transaction_number,
                    'payment_method' => $request->payment_method,
                    'bank_account' => $request->bank_account,
                    'number_account' => $request->number_account,
                    'amount_paid' => str_replace(",","",$request->amount_paid),
                    'created_by' => Auth::user()->name
                ]);
                $payment->save();

                $total_amount_paid = 0;
                $payment_list = Payment::where('transaction_number', $data->transaction_number)->get();
                foreach($payment_list as $payment_history){
                    $total_amount_paid += $payment_history->amount_paid;
                }

                if($total_amount_paid >= $data->total_price){
                    Transaction::where('id', $data->id)->update([
                        'total_amount_paid' => $total_amount_paid,
                        'status' => 1,
                        'updated_by' => Auth::user()->name
                    ]);
                } else {
                    Transaction::where('id', $data->id)->update([
                        'total_amount_paid' => $total_amount_paid,
                        'updated_by' => Auth::user()->name
                    ]);
                }
                return redirect('nota-penjualan/cetak-pdf/'.$data->transaction_number);
            }
                      
            return redirect('payment');
        } catch (Exception $e) {
            report($e);

            return redirect('payment');
        }
    }

    public function undeliveredOrder()
    {
        try{
            $product_category = ProductCategory::where('status', 1)->where('branch_id', Auth::user()->branch_id)->get();
            $data = Transaction::with(['branch', 'transaction_detail', 'transaction_detail.product'])->where('is_delivered', 2)->where('branch_id', Auth::user()->branch_id)->whereDate('created_at', Carbon::today())->orderBy('id', 'desc')->get();
            $no = 1;
            foreach($data as $page){
                $page->no = $no;

                if($page->status == 1){
                    $page->status_name = 'Dibayar';
                } else {
                    $page->status_name = 'Belum Dibayar';
                }

                if($page->is_delivered == 1){
                    $page->deliver_name = 'Terkirim';
                } else {
                    $page->deliver_name = 'Belum dikirim';
                }

                $no++;
            }
            $product_no = 1;
            foreach($product_category as $category){
                $product = Product::where('status', 1)->where('category_id', $category->id)->get();
                foreach($product as $page){
                    $page->no = $product_no;
                    $product_no++;
                }
                $category->product = $product;
            }
            $return_data = array(
                "order" => $data,
                "product_category" => $product_category
            );

            return view('order-list-undelivered')->with('data', $return_data);
        
        } catch (Exception $e) {
            report($e);

            return redirect('order-undelivered');
        }
    }

    public function deliveredOrderPos()
    {
        try{
            $data = Transaction::with(['branch', 'transaction_detail', 'transaction_detail.product'])->where('branch_id', Auth::user()->branch_id)->where('is_delivered', 1)->whereDate('created_at', Carbon::today())->orderBy('id', 'desc')->get();
            $no = 1;
            foreach($data as $page){
                $page->no = $no;

                if($page->status == 1){
                    $page->status_name = 'Dibayar';
                } else {
                    $page->status_name = 'Belum Dibayar';
                }

                if($page->is_delivered == 1){
                    $page->deliver_name = 'Terkirim';
                } else {
                    $page->deliver_name = 'Belum dikirim';
                }

                $no++;
            }

            return view('order-list-delivered')->with('data', $data);
        
        } catch (Exception $e) {
            report($e);

            return redirect('order-list');
        }
    }
}
