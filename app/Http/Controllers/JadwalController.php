<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ruang;
use App\Models\Dosen;
use App\Models\Mapel;
use App\Models\Jadwal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Hash;
use Session;
use Datatables;
class JadwalController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // $data = Jadwal::select('*');
            // $data = DB::table('user')->where('user_id', Auth::user()->id);
            $data = Jadwal::join('dosens', 'dosens.id', '=', 'jadwals.id_dosen')
            ->join('ruangs', 'ruangs.id', '=', 'jadwals.id_ruang')
            ->join('mapels', 'mapels.id', '=', 'jadwals.id_mapel')
            ->get(['jadwals.id','jadwals.hari','jadwals.mulai','jadwals.selesai','jadwals.status', 'mapels.nama as mapel','dosens.nama as dosen','ruangs.nama as ruang']);
            return datatables()->of($data)
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
        return view('backend.jadwal.list');
    }
    public function save(Request $req, $id = "")
    {
        $status = false;
        $message = '';
        $req->validate([
            'id_ruang' => 'required',
            'id_mapel' => 'required',
            'id_dosen' => 'required',
            'mulai' => 'required',
            'selesai' => 'required',
            'hari' => 'required',
            // 'status' => 'required',
        ]);
        if($id):
            $Jadwal = Jadwal::findOrFail($id);
            $data = $Jadwal->update([
                'id_ruang'    => $req->id_ruang,
                'id_mapel'    => $req->id_mapel,
                'id_dosen'    => $req->id_dosen,
                'mulai'       => $req->mulai,
                'selesai'     => $req->selesai,
                'hari'        => $req->hari,
                'status'      => $req->status
            ]);
            $message = 'Berhasil ubah data';
        else:
            $content = new Jadwal;
            $content->id_ruang = $req->id_ruang;
            $content->id_mapel = $req->id_mapel;
            $content->id_dosen = $req->id_dosen;
            $content->mulai = $req->mulai;
            $content->selesai = $req->selesai;
            $content->hari = $req->hari;
            $content->status = $req->status;
            $data = $content->save();
            $message = 'Berhasil simpan data';
        endif;
        if ($data) :
            $status = true;
        endif;
        echo json_encode(array("status" => $status, "data" => $data, "message"=>$message));
    }
    public function edit($id){
        $status = false;
        $Jadwal = Jadwal::find($id);
        if ($Jadwal) :
            $status = true;
        endif;
        echo json_encode(array("status" => $status, "data" => $Jadwal));
    }
    public function delete($id){
        $status = false;
        $data = '';
        $message = '';
        $Jadwal = Jadwal::where('id',$id)->delete();
        if($Jadwal):
            $status = true;
            $message = 'Success delete data';
        endif;
        echo json_encode(array("status" => $status, "data" => $Jadwal, "message"=> $message));
    }
    public function listDosen(){
        $Dosen = Dosen::all();
        echo json_encode(array("data_dosen" => $Dosen));
    }
    public function listRuang(){
        $Ruang = Ruang::all();
        echo json_encode(array("data_ruang" => $Ruang));
    }
    public function listMapel(){
        $Mapel = Mapel::all();
        echo json_encode(array("data_mapel" => $Mapel));
    }
}
