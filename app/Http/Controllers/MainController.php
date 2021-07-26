<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Content;
use Session;

class MainController extends Controller
{
    //
    public function dashboard()
    {
        return view('backend.home');
    }
    public function data_dashboard()
    {
        $mapel = DB::table('mapels')->count();
        $ruang = DB::table('ruangs')->count();
        $dosen = DB::table('dosens')->count();
        echo json_encode(array("mapel" => $mapel, "dosen" => $dosen, "ruang"=>$ruang));
    }
}
