<?php

namespace App\Http\Controllers\Chef;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Image;
use File;

use App\Model\Tables\Transaction;
use App\Model\Tables\TransactionDetail;
use PDF;

class ChefManagementController extends Controller
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
    public function undeliveredOrder()
    {
        try{
            $data = Transaction::with(['branch', 'transaction_detail', 'transaction_detail.product'])->where('is_delivered', 2)->where('branch_id', Auth::user()->branch_id)->orderBy('id', 'desc')->get();
            $no = 1;
            $temp_index_removed_data = array();
            foreach($data as $transaction_key => $page){
                $temp_index_removed = array();
                foreach($page->transaction_detail as $key => $transaction){
                    if($transaction->product->handle_by != 'CHEFF'){
                        array_push($temp_index_removed, $key);
                    } else {
                        if($transaction->is_delivered == 1){
                            array_push($temp_index_removed, $key);
                        }
                    }
                }
                // dd(count($temp_index_removed));
                for($i = 0; $i < count($temp_index_removed); $i++){
                    unset($page->transaction_detail[$temp_index_removed[$i]]);
                }

                if($page->transaction_detail->count() == 0){
                    array_push($temp_index_removed_data, $transaction_key);
                }
            }

            for($i = 0; $i < count($temp_index_removed_data); $i++){
                unset($data[$temp_index_removed_data[$i]]);
            }
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

            return view('cheff.order-list-undelivered')->with('data', $data);
        
        } catch (Exception $e) {
            report($e);

            return redirect('chef-order-undelivered');
        }
    }

    public function updateOrder(Request $request){
        if($request->checklist_transaction){
            $transaction_detail = $request->checklist_transaction;
            for($i = 0; $i < count($transaction_detail); $i++){
                TransactionDetail::where('id', $transaction_detail[$i])
                ->update(['is_delivered' => 1]);
            }
        }
        $this->OrderCheck($request->id);
        return redirect('chef-order-undelivered');
    }
}
