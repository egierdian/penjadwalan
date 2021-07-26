<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dosen;
use Datatables;
// use Yajra\Datatables\Facades\Datatables;

class DosenController extends Controller
{
    public function index(Request $request)
    {
        $category = Dosen::all();
        if ($request->ajax()) {
            $data = Dosen::select('*');
            return datatables()->of(Dosen::select('*'))
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btnView    = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm"><i class="far fa-delete"></i>View</a>';
                    $btnEdit    = '<a href="javascript:void(0)" class="edit btn btn-warning btn-sm mr-2" onclick="edit('.$row->id.')">Ubah</a>';
                    $btnDelete  = '<a href="javascript:void(0)" class="edit btn btn-danger btn-sm mr-2" onclick="delete_data('.$row->id.')">Hapus</a>';

                    return $btnEdit.$btnDelete;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('backend.dosen.list');
    }
    public function save(Request $req, $id = "")
    {
        $status = false;
        $message = '';
        $req->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'telp' => 'required'
        ]);
        if($id):
            $data = Dosen::find($id)->update($req->all()); 
            $message = 'Berhasil ubah data';
        else:
            $data = Dosen::create($req->all());
            $message = 'Berhasil simpan data';
        endif;
        if ($data) :
            $status = true;
        endif;
        echo json_encode(array("status" => $status, "data" => $data, "message"=>$message));
    }
    public function edit($id){
        $status = false;
        $Dosen = Dosen::find($id);
        if ($Dosen) :
            $status = true;
        endif;
        echo json_encode(array("status" => $status, "data" => $Dosen));
    }
    public function delete($id){
        $status = false;
        $data = '';
        $message = '';
        $dosen = Dosen::where('id',$id)->delete();
        if($dosen):
            $status = true;
            $message = 'Berhasil menghapus data';
        endif;
        echo json_encode(array("status" => $status, "data" => $dosen, "message"=> $message));
    }
}
