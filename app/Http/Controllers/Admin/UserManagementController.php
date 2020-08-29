<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Image;
use File;

use App\User;
use App\Model\Tables\Branch;

class UserManagementController extends Controller
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
        $this->path = public_path() . '/images';
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
            
            if (!File::isDirectory($this->path . '/' . $row)) {
                File::makeDirectory($this->path . '/' . $row);
            }
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
    public function mainUser()
    {
        try{
            $user = User::where('status', 1)->get();
            $no = 1;
            foreach($user as $page){
                $page->no = $no;

                if($page->status == 1){
                    $page->status_name = 'Active';
                } else {
                    $page->status_name = 'Inactive/Block';
                }

                if($page->role == 1){
                    $page->role_name = 'Admin';
                } else {
                    $page->role_name = 'Cashier';
                }

                $branch_select = Branch::where('id', $page->branch_id)->first();
                if(isset($branch_select)){
                    $page->branch_name = $branch_select->branch_name;
                } else {
                    $page->branch_name = "--";
                }
                $no++;
            }

            $branch = Branch::get();

            $data = array(
                "user" => $user,
                "branch" => $branch
            );
            return view('userManagement')->with('data', $data);
        
        } catch (Exception $e) {
            report($e);

            return redirect('user-management');
        }
    }

    public function addUserView()
    {
        $branch = Branch::get();

        $data = array(
            "branch" => $branch
        );
        return view('components.addUser')->with('data', $data);
    }

    public function postUser(Request $request){
        try{
            $branch_id = 0;
            if($request->role == 2){
                $branch_id = $request->branch_id;
            }
            $user = new User([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'role' => $request->get('role'),
                'branch_id' => $branch_id,
                'password' => bcrypt($request->get('password')),
                'created_by' => Auth::user()->name
            ]);
            $user->save();

            return redirect('user-management');
        } catch (Exception $e) {
            report($e);

            return redirect('user-management');
        }
    }

    public function updateUser(Request $request){
        try{
            $branch_id = 0;
            if($request->role == 2){
                $branch_id = $request->branch_id;
            }
            $user = User::where('id', $request->id)->update([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'role' => $request->get('role'),
                'branch_id' => $branch_id,
                'updated_by' => Auth::user()->name
            ]);

            return redirect('user-management');
        } catch (Exception $e) {
            report($e);

            return redirect('user-management');
        }
    }

    public function inactiveUser(Request $request){
        try{
            $user = User::where('id', $request->id)->first();
            if(empty($user)){
                return redirect('user-management');
            } else {
                $status = 1;
                if($user->status == 1){
                    $status = 2;
                }
                $update = User::where('id', $user->id)->update(['status' => $status]);
                return redirect('user-management');
            }
        } catch (Exception $e) {
            report($e);

            return redirect('user-management');
        }
    }
}
