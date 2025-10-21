<?php

namespace App\Http\Controllers\Inventaris\Aset;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Crypt;
use App\Models\aset;
use App\Models\aset_peminjaman;
use App\Models\aset_penarikan;
use App\Models\roles;
use App\Models\users;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Storage;
use Auth;
use \PDF;
use Validator,Redirect,Response,File;

class AsetPenarikanController extends Controller
{
    function index($id) {
        $validasi1 = aset_penarikan::where('id_aset',$id)->orderBy('created_at','desc')->first();
        $validasi2 = aset_peminjaman::where('id_aset',$id)->where('status',true)->orderBy('created_at','desc')->first();
        $show = aset::join('aset_ruangan','aset_ruangan.id','=','aset.id_ruangan')
                    // ->join('aset_penarikan','aset_penarikan.id_aset','=','aset.id')
                    ->select('aset_ruangan.ruangan','aset_ruangan.lokasi','aset.*')
                    ->where('aset.id',$id)
                    ->first();

        $data = [
            'validasi1' => $validasi1,
            'validasi2' => $validasi2,
            'show' => $show,
        ];

        return response()->json($data, 200);
    }

    function store(Request $request) {
        $tgl = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');

        $aset = aset::where('id',$request->aset)->first();

        $data = new aset_penarikan;
        $data->id_aset = $request->aset;
        $data->id_user = $request->user;
        $data->ket = $request->alasan;
        $data->kondisi = $request->kondisi;
        $data->kondisi_awal = $aset->kondisi;
        $data->lokasi_awal = $aset->id_ruangan;
        $data->status = $request->status;
        $data->save();

        $aset->id_ruangan = 1;
        $aset->kondisi = $request->kondisi;
        $aset->status = $request->status;
        $aset->save();

        return response()->json($tgl, 200);
    }

    function destroy($id){
        $tgl = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');

        $data = aset_penarikan::where('id', $id)->first();

            $aset = aset::where('id', $data->id_aset)->first();
            $aset->id_ruangan = $data->lokasi_awal;
            $aset->kondisi = $data->kondisi_awal;
            $aset->status = false;
            $aset->save();

        $data->delete();

        return response()->json($tgl, 200);
    }
}
