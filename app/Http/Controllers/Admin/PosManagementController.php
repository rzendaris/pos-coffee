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
use App\Model\Tables\Product;
use App\Model\Tables\Transaction;
use App\Model\Tables\TransactionDetail;
use App\Model\Tables\ProductCategory;
use App\Model\Tables\SeatTable;

class PosManagementController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function mainTransaction()
    {
        try{
            $customer = Customer::with(['branch'])->get();
            $product = Product::where('status', 1)->where('branch_id', Auth::user()->branch_id)->get();
            $count_product = Product::where('status', 1)->where('branch_id', Auth::user()->branch_id)->count();
            $product_category = ProductCategory::where('status', 1)->where('branch_id', Auth::user()->branch_id)->get();
            $seat_table = SeatTable::where('branch_id', Auth::user()->branch_id)->get();
            $no = 1;
            foreach($customer as $page){
                $page->no = $no;

                if($page->status == 1){
                    $page->status_name = 'Active';
                } else {
                    $page->status_name = 'Inactive/Block';
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
            // dd($product_category);
            $data = array(
                "customer" => $customer,
                "product" => $product,
                "count" => $count_product,
                "product_category" => $product_category,
                "seat_table" => $seat_table
            );
            return view('welcome')->with('data', $data);
        
        } catch (Exception $e) {
            report($e);

            return redirect('/');
        }
    }

    public function pos(){
        try{
            $customer = Customer::with(['branch'])->get();
            $product = Product::where('status', 1)->get();
            $count_product = Product::where('status', 1)->count();
            $product_category = ProductCategory::where('status', 1)->get();
            $no = 1;
            foreach($customer as $page){
                $page->no = $no;

                if($page->status == 1){
                    $page->status_name = 'Active';
                } else {
                    $page->status_name = 'Inactive/Block';
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
            // dd($product_category);
            $data = array(
                "customer" => $customer,
                "products" => $product,
                "count" => $count_product,
                "product_category" => $product_category
            );
            return view('pos')->with('products', $product);
        
        } catch (Exception $e) {
            report($e);

            return redirect('/');
        }
    }

    public function addCustomerView(){
        $branch = Branch::get();

        $data = array(
            "branch" => $branch
        );
        return view('content.customer-add')->with('data', $data);
    }

    public function postTransaction(Request $request){
        try{
            if(isset($request->product_id[0])){
                $now_date = Carbon::now();
                $date = Carbon::parse($now_date)->format('Y-m-d');
                $rand_no = rand(100000, 1000000);
                $last_transaction_id = 0;
                $last_transaction = Transaction::orderBy('id', 'desc')->first();
                if(empty($last_transaction)){
                    $last_transaction_id = 0;
                } else {
                    $last_transaction_id = $last_transaction->id;
                }
                $transaction_number = $rand_no.$last_transaction_id;

                $transaction = new Transaction([
                    'transaction_number' => $transaction_number,
                    'branch_id' => Auth::user()->branch_id,
                    'item_qty' => 0,
                    'total_discount' => 0,
                    'total_ppn' => 0,
                    'total_price' => 0,
                    'total_amount_paid' => 0,
                    'is_delivered' => 2,
                    'status' => $request->paid_status,
                    'created_by' => Auth::user()->name
                ]);
                $transaction->save();

                $product_form = explode("," , $request->product_id[0]);
                $qty_form = explode("," , $request->product_qty[0]);

                $item_qty = 0;
                $total_price = 0;
                $total_ppn = 0;
                for($i = 0; $i < count($product_form); $i++){
                    $get_product = Product::where('id', $product_form[$i])->first();
                    if(isset($get_product)){
                        $transaction_detail = new TransactionDetail([
                            'transaction_id' => $transaction->id,
                            'product_id' => $get_product->id,
                            'qty' => (int)$qty_form[$i],
                            'unit_price' => $get_product->price * (int)$qty_form[$i],
                            'ppn' => 0,
                            'total_price' => ($get_product->price * (int)$qty_form[$i]) + ($get_product->price * (int)$qty_form[$i]),
                            'is_delivered' => 2,
                            'status' => 1,
                            'created_by' => Auth::user()->name
                        ]);
                        $transaction_detail->save();

                        $item_qty += (int)$qty_form[$i];
                        $total_ppn += 0;
                        $total_price += $get_product->price * (int)$qty_form[$i];
                    }
                }
                Transaction::where('id', $transaction->id)->update([
                    'item_qty' => $item_qty,
                    'total_ppn' => $total_ppn,
                    'total_price' => $total_price + $total_ppn,
                    'total_amount_paid' => $total_price + $total_ppn
                ]);
                if($request->seat_table != ""){
                    SeatTable::where('branch_id', Auth::user()->branch_id)
                        ->where('seat_no', $request->seat_table)
                        ->update(['status' => 2]);
                }

            }

            return redirect('/');
        } catch (Exception $e) {
            report($e);

            return redirect('/');
        }
    }

    protected function postCustomer($request){
        $customer_id = 0;
        $branch_id = 1;
        if($request->customer_id == 0){
            $branch_id_insert = 1;
            if(Auth::user()->branch_id != 0){
                $branch_id_insert = Auth::user()->branch_id;
            }
            $customer_save = new Customer([
                'branch_id' => $branch_id_insert,
                'customer_name' => $request->customer_name,
                'address' => $request->address,
                'telp' => $request->telp,
                'company' => $request->company,
                'created_by' => Auth::user()->name
            ]);
            $customer_save->save();
            $customer_id = $customer_save->id;
            $branch_id = $customer_save->branch_id;
        } else {
            $customer_temp = Customer::where('id', $request->customer_id)->first();
            Customer::where('id', $request->customer_id)->update([
                'customer_name' => $request->customer_name,
                'address' => $request->address,
                'telp' => $request->telp,
                'company' => $request->company,
                'updated_by' => Auth::user()->name
            ]);
            $customer = $request->customer_id;
            $customer_id = $customer_temp->id;
            $branch_id = $customer_temp->branch_id;
        }
        $customer = array(
            "customer_id" => $customer_id,
            "branch_id" => $branch_id
        );
        return $customer;
    }

    public function detailCustomer($customer_id)
    {
        try{
            $data = Customer::where('id', $customer_id)->first();
            if(isset($data)){
                $data->piutang = 0;
                $transaction = Transaction::where('customer_id', $data->id)->where('status', 2)->get();
                foreach($transaction as $detail){
                    $data->piutang += ($detail->total_price - $detail->total_amount_paid);
                }

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
}
