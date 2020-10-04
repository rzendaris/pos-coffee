<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Image;
use File;

use App\Model\Tables\SeatTable;

class SeatTableManagementController extends Controller
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
    public function seatTable()
    {
        try{
            $data = SeatTable::where('branch_id', Auth::user()->branch_id)->get();
            $no = 1;
            foreach($data as $page){
                $page->no = $no;
                $no++;
            }
            return view('seat-table.index')->with('data', $data);
        
        } catch (Exception $e) {
            report($e);

            return redirect('seat-table-management');
        }
    }

    public function postSeatTable(Request $request){
        try{
            $type = new SeatTable([
                'seat_no' => $request->get('seat_no'),
                'location' => $request->get('location'),
                'branch_id' => Auth::user()->branch_id,
                'created_by' => Auth::user()->name
            ]);
            $type->save();

            return redirect('seat-table-management');
        } catch (Exception $e) {
            report($e);

            return redirect('seat-table-management');
        }
    }

    public function updateSeatTable(Request $request){
        try{
            $type = SeatTable::where('id', $request->seat_id)->update([
                'seat_no' => $request->get('seat_no'),
                'branch_id' => Auth::user()->branch_id
            ]);

            return redirect('seat-table-management');
        } catch (Exception $e) {
            report($e);

            return redirect('category-management');
        }
    }
}
