<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ruang;
use Datatables;
// use Yajra\Datatables\Facades\Datatables;

class RuangController extends Controller
{
    public function index(Request $request)
    {
        $category = Ruang::all();
        if ($request->ajax()) {
            $data = Ruang::select('*');
            return datatables()->of(Ruang::select('*'))
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

        return view('backend.ruang.list');
    }
    public function save(Request $req, $id = "")
    {
        $status = false;
        $message = '';
        $req->validate([
            'kode' => 'required',
            'nama' => 'required',
            'keterangan' => 'required'
        ]);
        if($id):
            $data = Ruang::find($id)->update($req->all()); 
            $message = 'Berhasil ubah data';
        else:
            $data = Ruang::create($req->all());
            $message = 'Berhasil simpan data';
        endif;
        if ($data) :
            $status = true;
        endif;
        echo json_encode(array("status" => $status, "data" => $data, "message"=>$message));
    }
    public function edit($id){
        $status = false;
        $Ruang = Ruang::find($id);
        if ($Ruang) :
            $status = true;
        endif;
        echo json_encode(array("status" => $status, "data" => $Ruang));
    }
    public function delete($id){
        $status = false;
        $data = '';
        $message = '';
        $ruang = Ruang::where('id',$id)->delete();
        if($ruang):
            $status = true;
            $message = 'Berhasil menghapus data';
        endif;
        echo json_encode(array("status" => $status, "data" => $ruang, "message"=> $message));
    }
}
