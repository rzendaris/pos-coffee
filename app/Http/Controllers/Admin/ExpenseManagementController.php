<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Image;
use File;

use App\Model\Tables\Expense;
use App\Model\Tables\Branch;

class ExpenseManagementController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public $path;
    public $dimensions;

    public function __construct()
    {
        $this->path = public_path(). '/expense';
        $this->dimensions = ['300', '600'];
    }

    protected function convertImage($image){
        
        $file = $image;
        $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        Image::make($file)->save($this->path . '/' . $fileName);
        foreach ($this->dimensions as $row) {
            $canvas = Image::canvas($row, $row);
            $resizeImage  = Image::make($file)->resize($row, $row, function($constraint) {
                $constraint->aspectRatio();
            });
            
            // if (!File::isDirectory($this->path . '/' . $row)) {
            //     File::makeDirectory($this->path . '/' . $row);
            // }
            $canvas->insert($resizeImage, 'center');
            $canvas->save($this->path . '/' . $row . '/' . $fileName);
        }
        $data = array(
            'filename' => $fileName,
            'dimensions' => implode('|', $this->dimensions),
            'path' => $this->path
        );
        return $data;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function mainExpense()
    {
        try{
            $expense = Expense::where('branch_id', Auth::user()->branch_id)->where('status', 1)->get();
            $no = 1;
            foreach($expense as $page){
                $page->no = $no;

                if($page->status == 1){
                    $page->status_name = 'Active';
                } else {
                    $page->status_name = 'Inactive/Block';
                }
                $no++;
            }
            $data = array(
                "expense" => $expense
            );
            return view('expense.expense-management')->with('data', $data);
        
        } catch (Exception $e) {
            report($e);

            return redirect('expense-management');
        }
    }

    public function addExpenseView()
    {
        return view('expense.expense-add');
    }

    public function postExpense(Request $request){
        try{
            $convertImage = $this->convertImage($request->file('image'));
            $expense = new Expense([
                'name' => $request->get('name'),
                'qty' => $request->get('qty'),
                'measure' => $request->get('measure'),
                'price' => str_replace(",","", $request->get('price')),
                'description' => $request->get('description'),
                'image' => $convertImage['filename'],
                'branch_id' => Auth::user()->branch_id,
                'created_by' => Auth::user()->name
            ]);
            $expense->save();

            return redirect('expense-management');
        } catch (Exception $e) {
            report($e);

            return redirect('expense-management');
        }
    }

    public function updateProduct(Request $request){
        try{
            if($request->hasFile('image')){
                $convertImage = $this->convertImage($request->file('image'));
                Product::where('id', $request->id)->update([
                    'image' => $convertImage['filename'],
                    'updated_by' => Auth::user()->name
                ]);
            }
            $product = Product::where('id', $request->id)->update([
                'product_name' => $request->get('product_name'),
                'category_id' => $request->get('category_id'),
                'price' => $request->get('price'),
                'stock' => $request->get('stock'),
                'handle_by' => $request->get('handle_by'),
                'updated_by' => Auth::user()->name
            ]);

            return redirect('item-management');
        } catch (Exception $e) {
            report($e);

            return redirect('item-management');
        }
    }

    public function inactiveProduct(Request $request){
        try{
            $product = Product::where('id', $request->remove_id)->first();
            if(empty($product)){
                return redirect('item-management');
            } else {
                $status = 1;
                if($product->status == 1){
                    $status = 2;
                }
                $update = Product::where('id', $product->id)->update(['status' => $status]);
                return redirect('item-management');
            }
        } catch (Exception $e) {
            report($e);

            return redirect('item-management');
        }
    }
}
