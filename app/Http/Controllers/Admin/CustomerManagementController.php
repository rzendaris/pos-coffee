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

class CustomerManagementController extends Controller
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
    public function mainCustomer()
    {
        try{
            $customer = Customer::with(['branch'])->get();
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
            $branch = Branch::get();
            $data = array(
                "customer" => $customer,
                "branch" => $branch
            );
            return view('content.customer')->with('data', $data);
        
        } catch (Exception $e) {
            report($e);

            return redirect('customer-management');
        }
    }

    public function addCustomerView(){
        $branch = Branch::get();

        $data = array(
            "branch" => $branch
        );
        return view('content.customer-add')->with('data', $data);
    }

    public function postCustomer(Request $request){
        try{
            $customer = new Customer([
                'branch_id' => $request->get('branch_id'),
                'customer_name' => $request->get('customer_name'),
                'address' => $request->get('address'),
                'telp' => $request->get('telp'),
                'company' => $request->get('company'),
                'created_by' => Auth::user()->name
            ]);
            $customer->save();

            return redirect('customer-management');
        } catch (Exception $e) {
            report($e);

            return redirect('customer-management');
        }
    }

    public function updateCustomer(Request $request){
        try{
            $customer = Customer::where('id', $request->id)->update([
                'branch_id' => $request->get('branch_id'),
                'customer_name' => $request->get('customer_name'),
                'address' => $request->get('address'),
                'telp' => $request->get('telp'),
                'company' => $request->get('company'),
                'updated_by' => Auth::user()->name
            ]);

            return redirect('customer-management');
        } catch (Exception $e) {
            report($e);

            return redirect('customer-management');
        }
    }
}
