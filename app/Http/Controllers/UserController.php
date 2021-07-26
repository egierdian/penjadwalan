<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Datatables;
use Validator;
use Hash;

class UserController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $category = User::all();
        if ($request->ajax()) {
            $data = User::select('*');
            return datatables()->of(User::select('*'))
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btnView    = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm"><i class="far fa-delete"></i>View</a>';
                    $btnEdit    = '<a href="javascript:void(0)" class="edit btn btn-warning btn-sm mr-2" onclick="edit('.$row->id.')">Edit</a>';
                    $btnDelete  = '<a href="javascript:void(0)" class="edit btn btn-danger btn-sm mr-2" onclick="delete_data('.$row->id.')">Hapus</a>';

                    return $btnEdit.$btnDelete;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('backend.user.list');
    }
    public function save(Request $req, $id = "")
    {
        $status = false;
        $message = '';
        $req->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required|min:6',
        ]);
        if($id):
            #CARA I
            // $data = User::find($id)->update($user); 

            $User = User::findOrFail($id);
            $data = $User->update([
                'name'     => ucwords(strtolower($req->name)),
                'email'    => strtolower($req->email),
                'password' => Hash::make($req->password)
            ]);
            $message = 'Success edit data';
        else:
            $user = new User;
            $user->name = ucwords(strtolower($req->name));
            $user->email = strtolower($req->email);
            $user->password = Hash::make($req->password);
            $user->email_verified_at = \Carbon\Carbon::now();
            $data = $user->save();
            // $data = User::create($req->all());
            $message = 'Success save data';
        endif;
        if ($data) :
            $status = true;
        endif;
        echo json_encode(array("status" => $status, "data" => $data, "message"=>$message));
    }
    public function edit($id){
        $status = false;
        $User = User::find($id);
        if ($User) :
            $status = true;
        endif;
        echo json_encode(array("status" => $status, "data" => $User));
    }
    public function delete($id){
        $status = false;
        $data = '';
        $message = '';
        $User = User::where('id',$id)->delete();
        if($User):
            $status = true;
            $message = 'Success delete data with id ='.$id;
        endif;
        echo json_encode(array("status" => $status, "data" => $User, "message"=> $message));
    }

    public function showLogin()
    {
        if (Auth::check()) { 
            return redirect()->route('dashboard');
        }
        return view('login');
    }
  
    public function login(Request $request)
    {
        $rules = [
            'email'                 => 'required|email',
            'password'              => 'required|string'
        ];
  
        $messages = [
            'email.required'        => 'Email wajib diisi',
            'email.email'           => 'Email tidak valid',
            'password.required'     => 'Password wajib diisi',
            'password.string'       => 'Password harus berupa string'
        ];
  
        $validator = Validator::make($request->all(), $rules, $messages);
  
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }
  
        $data = [
            'email'     => $request['email'],
            'password'  => $request['password'],
        ];
  
        Auth::attempt($data);
  
        if (Auth::check()) {
            return redirect()->route('dashboard');
        } else {
            Session::flash('error', 'Email atau password salah');
            return redirect()->route('login');
        }
    }
    public function logout()
    {
        Auth::logout(); // menghapus session yang aktif
        return redirect()->route('login');
    }
}