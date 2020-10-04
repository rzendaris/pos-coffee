<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Image;
use File;
use Maatwebsite\Excel\Facades\Excel;
use PHPExcel_Style_Alignment;

use App\Model\Tables\Customer;
use App\Model\Tables\Branch;
use App\Model\Tables\Transaction;
use App\Model\Tables\Payment;
use App\Model\Tables\Expense;

class ReportManagementController extends Controller
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
    public function mainReport(Request $request)
    {
        try{
            $to = Carbon::tomorrow('Asia/Jakarta')->format('Y-m-d');
            $from = Carbon::now()->subDays(30)->format('Y-m-d');
            $now = Carbon::now();
            if(isset($request->from) && isset($request->to)){
                $from = $request->from;
                $to = $request->to;
            }
            $sales = Transaction::with(['branch', 'transaction_detail', 'transaction_detail.product'])->where('branch_id', Auth::user()->branch_id)->where('created_at', '>=', $from)->where('created_at', '<=', $to)->orderBy('id', 'asc')->get();
            $expense = Expense::with(['branch'])->where('branch_id', Auth::user()->branch_id)->where('created_at', '>=', $from)->where('created_at', '<=', $to)->orderBy('id', 'asc')->get();

            $no = 1;
            $total_transaction = 0;
            foreach($sales as $page){
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
            $expense_no = 1;
            $total_expense = 0;
            foreach($expense as $page){
                $page->no = $expense_no;

                if($page->status == 1){
                    $page->status_name = 'Approved';
                } else {
                    $page->status_name = 'Cancelled';
                }
                $total_expense += $page->price;

                $expense_no++;
            }

            $data = array(
                "sales" => $sales,
                "expense" => $expense,
                "total_transaction" => $total_transaction,
                "total_expense" => $total_expense,
                "from" => $from,
                "to" => $to,
                "now_date" => $now
            );
            return view('reportManagement')->with('data', $data);
        
        } catch (Exception $e) {
            report($e);

            return redirect('report-management');
        }
    }
    
    public function newReport(){
        return view('reporting.report');
    }

    public function generateReport(Request $request, $type)
    {
        try{
            return Excel::create('Reporting', function($excel) use ($request){
                $report = array("Penerimaan Cash", "Laporan Piutang", "Laporan Penjualan");
                for($i = 0; $i < count($report); $i++){
                    $excel->sheet($report[$i], function($sheet) use ($report, $request, $i)
                    {
                        if($i == 0){
                            $align = array(
                                'alignment' => array(
                                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                                )
                            );
                            $sheet->mergeCells('A1:H1');
                            $sheet->mergeCells('A2:H2');
                            $sheet->cell('A1', function($cell) {$cell->setValue('Reporting')->setFontSize(14);   });
                            $sheet->cell('A2', function($cell) use ($report, $i) {$cell->setValue($report[$i])->setFontSize(14);   });
                            $sheet->getStyle("A1:H1")->applyFromArray($align);
                            $sheet->getStyle("A2:H2")->applyFromArray($align);
        
                            $sheet->cell('A4', function($cell) {$cell->setValue('Date')->setBorder('thin', 'thin', 'thin', 'thin')->setAlignment('center');   });
                            $sheet->cell('B4', function($cell) {$cell->setValue('No. Order')->setBorder('thin', 'thin', 'thin', 'thin')->setAlignment('center');   });
                            $sheet->cell('C4', function($cell) {$cell->setValue('Branches')->setBorder('thin', 'thin', 'thin', 'thin')->setAlignment('center');   });
                            $sheet->cell('D4', function($cell) {$cell->setValue('Customer')->setBorder('thin', 'thin', 'thin', 'thin')->setAlignment('center');   });
                            $sheet->cell('E4', function($cell) {$cell->setValue('Payment Method')->setBorder('thin', 'thin', 'thin', 'thin')->setAlignment('center');   });
                            $sheet->cell('F4', function($cell) {$cell->setValue('Bank Account')->setBorder('thin', 'thin', 'thin', 'thin')->setAlignment('center');   });
                            $sheet->cell('G4', function($cell) {$cell->setValue('Amount Paid')->setBorder('thin', 'thin', 'thin', 'thin')->setAlignment('center');   });
                            $sheet->cell('H4', function($cell) {$cell->setValue('Cashier')->setBorder('thin', 'thin', 'thin', 'thin')->setAlignment('center');   });
                            $payment = Payment::with(['transaction', 'transaction.branch', 'transaction.customer'])->where('created_at', '>=', $request->from)->where('created_at', '<=', $request->to)->orderBy('id', 'desc')->where('status', 1)->get();
                            if (isset($payment[0])) {
                                foreach ($payment as $key => $value) {
                                    $a= $key+5;
                                    $sheet->cell('A'.$a, function($cell) use ($value) {$cell->setValue($value->created_at)->setBorder('thin', 'thin', 'thin', 'thin');   });
                                    $sheet->cell('B'.$a, function($cell) use ($value) {$cell->setValue($value->transaction_number)->setBorder('thin', 'thin', 'thin', 'thin')->setAlignment('center');   });
                                    $sheet->cell('C'.$a, function($cell) use ($value) {$cell->setValue($value->transaction->branch->branch_name)->setBorder('thin', 'thin', 'thin', 'thin')->setAlignment('center');   });
                                    $sheet->cell('D'.$a, function($cell) use ($value) {$cell->setValue($value->transaction->customer->customer_name)->setBorder('thin', 'thin', 'thin', 'thin');   });
                                    $sheet->cell('E'.$a, function($cell) use ($value) {$cell->setValue($value->payment_method)->setBorder('thin', 'thin', 'thin', 'thin')->setAlignment('center');   });
                                    $sheet->cell('F'.$a, function($cell) use ($value) {$cell->setValue($value->bank_account)->setBorder('thin', 'thin', 'thin', 'thin')->setAlignment('center');   });
                                    $sheet->cell('G'.$a, function($cell) use ($value) {$cell->setValue("Rp. ".number_format($value->amount_paid))->setBorder('thin', 'thin', 'thin', 'thin');   });
                                    $sheet->cell('H'.$a, function($cell) use ($value) {$cell->setValue($value->created_by)->setBorder('thin', 'thin', 'thin', 'thin')->setAlignment('center');   });
                                }
                            }
                        } elseif($i == 1){
                            $align = array(
                                'alignment' => array(
                                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                                )
                            );
                            $sheet->mergeCells('A1:M1');
                            $sheet->mergeCells('A2:M2');
                            $sheet->cell('A1', function($cell) {$cell->setValue('Reporting')->setFontSize(14);   });
                            $sheet->cell('A2', function($cell) use ($report, $i) {$cell->setValue($report[$i])->setFontSize(14);   });
                            $sheet->getStyle("A1:M1")->applyFromArray($align);
                            $sheet->getStyle("A2:M2")->applyFromArray($align);
        
                            $sheet->cell('A4', function($cell) {$cell->setValue('Date')->setBorder('thin', 'thin', 'thin', 'thin')->setAlignment('center');   });
                            $sheet->cell('B4', function($cell) {$cell->setValue('No. Order')->setBorder('thin', 'thin', 'thin', 'thin')->setAlignment('center');   });
                            $sheet->cell('C4', function($cell) {$cell->setValue('Branches')->setBorder('thin', 'thin', 'thin', 'thin')->setAlignment('center');   });
                            $sheet->cell('D4', function($cell) {$cell->setValue('Customer')->setBorder('thin', 'thin', 'thin', 'thin')->setAlignment('center');   });
                            $sheet->cell('E4', function($cell) {$cell->setValue('Qty Item')->setBorder('thin', 'thin', 'thin', 'thin')->setAlignment('center');   });
                            $sheet->cell('F4', function($cell) {$cell->setValue('PPN 10%')->setBorder('thin', 'thin', 'thin', 'thin')->setAlignment('center');   });
                            $sheet->cell('G4', function($cell) {$cell->setValue('Discount')->setBorder('thin', 'thin', 'thin', 'thin')->setAlignment('center');   });
                            $sheet->cell('H4', function($cell) {$cell->setValue('Total Price')->setBorder('thin', 'thin', 'thin', 'thin')->setAlignment('center');   });
                            $sheet->cell('I4', function($cell) {$cell->setValue('Amount Paid')->setBorder('thin', 'thin', 'thin', 'thin')->setAlignment('center');   });
                            $sheet->cell('J4', function($cell) {$cell->setValue('Credit')->setBorder('thin', 'thin', 'thin', 'thin')->setAlignment('center');   });
                            $sheet->cell('K4', function($cell) {$cell->setValue('Duration')->setBorder('thin', 'thin', 'thin', 'thin')->setAlignment('center');   });
                            $sheet->cell('L4', function($cell) {$cell->setValue('Time Of Payment')->setBorder('thin', 'thin', 'thin', 'thin')->setAlignment('center');   });
                            $sheet->cell('M4', function($cell) {$cell->setValue('Cashier')->setBorder('thin', 'thin', 'thin', 'thin')->setAlignment('center');   });
                            $piutang = Transaction::with(['branch', 'customer'])->where('created_at', '>=', $request->from)->where('created_at', '<=', $request->to)->orderBy('id', 'desc')->where('status', 2)->get();
                            if (isset($piutang[0])) {
                                foreach ($piutang as $key => $value) {
                                    $a= $key+5;
                                    $sheet->cell('A'.$a, function($cell) use ($value) {$cell->setValue($value->created_at)->setBorder('thin', 'thin', 'thin', 'thin');   });
                                    $sheet->cell('B'.$a, function($cell) use ($value) {$cell->setValue($value->transaction_number)->setBorder('thin', 'thin', 'thin', 'thin')->setAlignment('center');   });
                                    $sheet->cell('C'.$a, function($cell) use ($value) {$cell->setValue($value->branch->branch_name)->setBorder('thin', 'thin', 'thin', 'thin')->setAlignment('center');   });
                                    $sheet->cell('D'.$a, function($cell) use ($value) {$cell->setValue($value->customer->customer_name)->setBorder('thin', 'thin', 'thin', 'thin');   });
                                    $sheet->cell('E'.$a, function($cell) use ($value) {$cell->setValue($value->item_qty)->setBorder('thin', 'thin', 'thin', 'thin')->setAlignment('center');   });
                                    $sheet->cell('F'.$a, function($cell) use ($value) {$cell->setValue("Rp. ".number_format($value->total_ppn))->setBorder('thin', 'thin', 'thin', 'thin');   });
                                    $sheet->cell('G'.$a, function($cell) use ($value) {$cell->setValue("Rp. ".number_format($value->total_discount))->setBorder('thin', 'thin', 'thin', 'thin');   });
                                    $sheet->cell('H'.$a, function($cell) use ($value) {$cell->setValue("Rp. ".number_format($value->total_price))->setBorder('thin', 'thin', 'thin', 'thin');   });
                                    $sheet->cell('I'.$a, function($cell) use ($value) {$cell->setValue("Rp. ".number_format($value->total_amount_paid))->setBorder('thin', 'thin', 'thin', 'thin');   });
                                    $sheet->cell('J'.$a, function($cell) use ($value) {$cell->setValue("Rp. ".number_format($value->total_price - $value->total_amount_paid))->setBorder('thin', 'thin', 'thin', 'thin');   });
                                    $sheet->cell('K'.$a, function($cell) use ($value) {$cell->setValue($value->created_at->diffInDays(Carbon::now(), false)." day(s)")->setBorder('thin', 'thin', 'thin', 'thin');   });
                                    $sheet->cell('L'.$a, function($cell) use ($value) {$cell->setValue($value->time_of_payment)->setBorder('thin', 'thin', 'thin', 'thin')->setAlignment('center');   });
                                    $sheet->cell('M'.$a, function($cell) use ($value) {$cell->setValue($value->created_by)->setBorder('thin', 'thin', 'thin', 'thin')->setAlignment('center');   });
                                }
                            }
                        } else {
                            
                            $align = array(
                                'alignment' => array(
                                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                                )
                            );
                            $sheet->mergeCells('A1:J1');
                            $sheet->mergeCells('A2:J2');
                            $sheet->cell('A1', function($cell) {$cell->setValue('Reporting')->setFontSize(14);   });
                            $sheet->cell('A2', function($cell) use ($report, $i) {$cell->setValue($report[$i])->setFontSize(14);   });
                            $sheet->getStyle("A1:J1")->applyFromArray($align);
                            $sheet->getStyle("A2:J2")->applyFromArray($align);
        
                            $sheet->cell('A4', function($cell) {$cell->setValue('Date')->setBorder('thin', 'thin', 'thin', 'thin')->setAlignment('center');   });
                            $sheet->cell('B4', function($cell) {$cell->setValue('No. Order')->setBorder('thin', 'thin', 'thin', 'thin')->setAlignment('center');   });
                            $sheet->cell('C4', function($cell) {$cell->setValue('Branches')->setBorder('thin', 'thin', 'thin', 'thin')->setAlignment('center');   });
                            $sheet->cell('D4', function($cell) {$cell->setValue('Customer')->setBorder('thin', 'thin', 'thin', 'thin')->setAlignment('center');   });
                            $sheet->cell('E4', function($cell) {$cell->setValue('Qty Item')->setBorder('thin', 'thin', 'thin', 'thin')->setAlignment('center');   });
                            $sheet->cell('F4', function($cell) {$cell->setValue('PPN 10%')->setBorder('thin', 'thin', 'thin', 'thin')->setAlignment('center');   });
                            $sheet->cell('G4', function($cell) {$cell->setValue('Discount')->setBorder('thin', 'thin', 'thin', 'thin')->setAlignment('center');   });
                            $sheet->cell('H4', function($cell) {$cell->setValue('Total Price')->setBorder('thin', 'thin', 'thin', 'thin')->setAlignment('center');   });
                            $sheet->cell('I4', function($cell) {$cell->setValue('Amount Paid')->setBorder('thin', 'thin', 'thin', 'thin')->setAlignment('center');   });
                            $sheet->cell('J4', function($cell) {$cell->setValue('Cashier')->setBorder('thin', 'thin', 'thin', 'thin')->setAlignment('center');   });
                            $sales = Transaction::with(['branch', 'customer'])->where('created_at', '>=', $request->from)->where('created_at', '<=', $request->to)->orderBy('id', 'desc')->where('status', 1)->get();

                            if (isset($sales[0])) {
                                foreach ($sales as $key => $value) {
                                    $a= $key+5;
                                    $sheet->cell('A'.$a, function($cell) use ($value) {$cell->setValue($value->created_at)->setBorder('thin', 'thin', 'thin', 'thin');   });
                                    $sheet->cell('B'.$a, function($cell) use ($value) {$cell->setValue($value->transaction_number)->setBorder('thin', 'thin', 'thin', 'thin')->setAlignment('center');   });
                                    $sheet->cell('C'.$a, function($cell) use ($value) {$cell->setValue($value->branch->branch_name)->setBorder('thin', 'thin', 'thin', 'thin')->setAlignment('center');   });
                                    $sheet->cell('D'.$a, function($cell) use ($value) {$cell->setValue($value->customer->customer_name)->setBorder('thin', 'thin', 'thin', 'thin');   });
                                    $sheet->cell('E'.$a, function($cell) use ($value) {$cell->setValue($value->item_qty)->setBorder('thin', 'thin', 'thin', 'thin')->setAlignment('center');   });
                                    $sheet->cell('F'.$a, function($cell) use ($value) {$cell->setValue("Rp. ".number_format($value->total_ppn))->setBorder('thin', 'thin', 'thin', 'thin');   });
                                    $sheet->cell('G'.$a, function($cell) use ($value) {$cell->setValue("Rp. ".number_format($value->total_discount))->setBorder('thin', 'thin', 'thin', 'thin');   });
                                    $sheet->cell('H'.$a, function($cell) use ($value) {$cell->setValue("Rp. ".number_format($value->total_price))->setBorder('thin', 'thin', 'thin', 'thin');   });
                                    $sheet->cell('I'.$a, function($cell) use ($value) {$cell->setValue("Rp. ".number_format($value->total_amount_paid))->setBorder('thin', 'thin', 'thin', 'thin');   });
                                    $sheet->cell('J'.$a, function($cell) use ($value) {$cell->setValue($value->created_by)->setBorder('thin', 'thin', 'thin', 'thin')->setAlignment('center');   });
                                }
                            }
                        }
                    });
                }
            })->download($type);
        
        } catch (Exception $e) {
            report($e);

            return redirect('report-management');
        }
    }
}
