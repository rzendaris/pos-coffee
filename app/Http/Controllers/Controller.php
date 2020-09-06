<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Model\Tables\Transaction;
use App\Model\Tables\TransactionDetail;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function OrderCheck($transaction_id){
        $transaction_details = TransactionDetail::where('transaction_id', $transaction_id)->get();
        $deliver_status = True;
        foreach($transaction_details as $transaction_detail){
            if($transaction_detail->is_delivered == 2){
                $deliver_status = False;
            }
        }

        if($deliver_status){
            Transaction::where('id', $transaction_id)->update(['is_delivered' => 1]);
        }
        return True;
    }
}
