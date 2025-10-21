<?php

namespace App\Http\Controllers\Inventaris\Aset;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Crypt;
use App\Models\aset;
use App\Models\aset_pemeliharaan;
use App\Models\aset_penarikan;
use App\Models\roles;
use App\Models\users;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Storage;
use Auth;
use \PDF;
use Validator,Redirect,Response,File;

class AsetPemeliharaanController extends Controller
{
    function index($id) {
        $users = users::join('model_has_roles','model_has_roles.model_id','=','users.id')
                    ->join('roles','roles.id','=','model_has_roles.role_id')
                    ->whereIn('roles.name', ['karu-it','it','kasubag-aset-gudang','kasubag-ipsrs','ipsrs','elektromedis'])
                    ->select('users.id','users.nama')
                    ->distinct()
                    ->where('users.id','!=',341) // BUDI SATRIJO
                    ->where('users.id','!=',257) // ERVAN HADI
                    ->whereNotNull('users.nik')
                    ->where('users.status',null)
                    ->orderBy('nama','ASC')
                    ->get();

        $show = aset_pemeliharaan::join('aset','aset.id','=','aset_pemeliharaan.id_aset')
                    ->join('users','users.id','=','aset_pemeliharaan.petugas')
                    ->select('aset.sarana','users.nama as nama_petugas','aset_pemeliharaan.*')
                    ->get();
        $validasi_penarikan = aset_penarikan::where('id_aset',$id)->first();

        $data = [
            'show' => $show,
            'users' => $users,
            'penarikan' => $validasi_penarikan,
        ];
        // print_r($show);
        // die();

        return response()->json($data, 200);
    }

    function store(Request $request) {
        $tgl = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');

        $data = new aset_pemeliharaan;
        $data->id_aset = $request->aset;
        $data->id_user = $request->user;
        $data->hasil = $request->hasil;
        $data->rekomendasi = $request->rekomendasi;
        $data->petugas = $request->petugas;
        $data->save();

        return response()->json($tgl, 200);
    }

    function destroy($id){
        $tgl = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');

        $data = aset_pemeliharaan::where('id', $id)->first();
        $data->delete();

        return response()->json($tgl, 200);
    }
}
