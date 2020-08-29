<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Image;
use File;

use App\Model\Tables\Branch;

class BranchManagementController extends Controller
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
    public function mainBranch()
    {
        try{
            $data = Branch::get();
            $no = 1;
            foreach($data as $page){
                $page->no = $no;

                if($page->status == 1){
                    $page->status_name = 'Active';
                } else {
                    $page->status_name = 'Inactive/Block';
                }
                $no++;
            }
            return view('content.branch')->with('data', $data);
        
        } catch (Exception $e) {
            report($e);

            return redirect('branch-management');
        }
    }

    public function addBranch()
    {
        return view('content.branch-add');
    }

    public function postBranch(Request $request){
        try{
            $branch = new Branch([
                'branch_name' => $request->get('branch_name'),
                'head_office' => $request->get('head_office'),
                'email' => $request->get('email'),
                'telp' => $request->get('telp'),
                'fax' => $request->get('fax'),
                'address' => $request->get('address'),
                'created_by' => Auth::user()->name
            ]);
            $branch->save();

            return redirect('branch-management');
        } catch (Exception $e) {
            report($e);

            return redirect('branch-management');
        }
    }

    public function updateBranch(Request $request){
        try{
            $branch = Branch::where('id', $request->id)->update([
                'branch_name' => $request->get('branch_name'),
                'head_office' => $request->get('head_office'),
                'email' => $request->get('email'),
                'telp' => $request->get('telp'),
                'fax' => $request->get('fax'),
                'address' => $request->get('address'),
                'updated_by' => Auth::user()->name
            ]);

            return redirect('branch-management');
        } catch (Exception $e) {
            report($e);

            return redirect('branch-management');
        }
    }
}
