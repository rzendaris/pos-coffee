<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Image;
use File;

use App\Model\Tables\ProductCategory;

class CategoryManagementController extends Controller
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
    public function mainCategory()
    {
        try{
            $data = ProductCategory::where('branch_id', Auth::user()->branch_id)->get();
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
            return view('content.category')->with('data', $data);
        
        } catch (Exception $e) {
            report($e);

            return redirect('category-management');
        }
    }

    public function postCategory(Request $request){
        try{
            $type = new ProductCategory([
                'category_name' => $request->get('type_name'),
                'description' => $request->get('description'),
                'created_by' => Auth::user()->name,
                'branch_id' => Auth::user()->branch_id
            ]);
            $type->save();

            return redirect('category-management');
        } catch (Exception $e) {
            report($e);

            return redirect('category-management');
        }
    }

    public function updateCategory(Request $request){
        try{
            $type = ProductCategory::where('id', $request->id_edit)->update([
                'category_name' => $request->get('type_name_edit'),
                'description' => $request->get('description_edit'),
                'updated_by' => Auth::user()->name
            ]);

            return redirect('category-management');
        } catch (Exception $e) {
            report($e);

            return redirect('category-management');
        }
    }
}
