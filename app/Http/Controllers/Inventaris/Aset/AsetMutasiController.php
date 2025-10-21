<?php

namespace App\Http\Controllers\Inventaris\Aset;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Crypt;
use App\Models\aset;
use App\Models\aset_ruangan;
use App\Models\aset_mutasi;
use App\Models\aset_penarikan;
use App\Models\aset_peminjaman;
use App\Models\roles;
use App\Models\users;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Storage;
use Auth;
use \PDF;
use Validator,Redirect,Response,File;

class AsetMutasiController extends Controller
{
    function index($id) {
        $ruangan = aset_ruangan::get();
        $show = aset_mutasi::join('aset','aset.id','=','aset_mutasi.id_aset')
                    ->join('aset_ruangan as ara','ara.id','=','aset_mutasi.lokasi_awal')
                    ->join('aset_ruangan as art','art.id','=','aset_mutasi.lokasi_tujuan')
                    ->select('aset.sarana','aset_mutasi.*','ara.ruangan as ruangan_awal_aset','ara.lokasi as lokasi_awal_aset','art.ruangan as ruangan_tujuan_aset','art.lokasi as lokasi_tujuan_aset')
                    ->get();
        $aset = aset::join('aset_ruangan','aset_ruangan.id','=','aset.id_ruangan')
                    ->select('aset_ruangan.ruangan','aset_ruangan.lokasi','aset.*')
                    ->where('aset.id',$id)
                    ->first();
        $validasi_penarikan = aset_penarikan::where('id_aset',$id)->first();
        $validasi_peminjaman = aset_peminjaman::where('id_aset',$id)->where('status',true)->first();

        $data = [
            'ruangan' => $ruangan,
            'show' => $show,
            'aset' => $aset,
            'penarikan' => $validasi_penarikan,
            'peminjaman' => $validasi_peminjaman,
        ];

        return response()->json($data, 200);
    }

    function store(Request $request) {
        // INISIALISASI
        $carbon = Carbon::now();
        $tgl = $carbon->isoFormat('dddd, D MMMM Y, HH:mm a');
        $aset = aset::where('id',$request->aset)->first();
        $getRuangan = aset_ruangan::where('id',$request->lokasi_tujuan)->first();
        $getUrutan = aset::where('id_ruangan',$request->lokasi_tujuan)->orderBy('urutan','desc')->first();

        // CEK URUTAN PER RUANGAN
        if (!empty($getUrutan)) {
            $urutan = $getUrutan->urutan + 1;
        } else {
            $urutan = '1';
        }

        // CEK INPUT JENIS
        if ($aset->jenis == 1) {
            $jenis = 'A';
        } else {
            $jenis = 'B';
        }

        // CEK TAHUN PEROLEHAN
        if ($aset->tgl_perolehan == null) {
            $year = $carbon->isoFormat('YYYY');
        } else {
            $year = substr($aset->tgl_perolehan,0,4);
        }

        // PUSH NOMOR INVENTARIS
        $no_inventaris_baru = '00.03.27.'.$getRuangan->kode.'.'.$jenis.'.'.$urutan.'.'.$year;

        // PROSES SIMPAN KE DB ASET_MUTASI
        $data = new aset_mutasi;
        $data->id_aset = $request->aset;
        $data->id_user = $request->user;

            $data->urutan_lama = $aset->urutan;
            $data->urutan_baru = $urutan;
            $data->no_inventaris_lama = $aset->no_inventaris;
            $data->no_inventaris_baru = $no_inventaris_baru;

        $data->lokasi_awal = $aset->id_ruangan;
        $data->lokasi_tujuan = $request->lokasi_tujuan;
        $data->ket = $request->ket;
        $data->kondisi = $request->kondisi;
        $data->kondisi_awal = $aset->kondisi;
        $data->save();

        // PROSES SIMPAN KE DB ASET
        $aset->id_ruangan = $request->lokasi_tujuan;
        $aset->token = Crypt::encryptString($no_inventaris_baru); // decryptString to Decrypt
        $aset->urutan = $urutan;
        // $aset->jenis = $no_inventaris_baru; // JENIS MASIH TETAP SAMA
        $aset->no_inventaris = $no_inventaris_baru;
        $aset->kondisi = $request->kondisi;
        $aset->status = false;
        $aset->save();

        $reset = aset_penarikan::where('id_aset', $request->aset)->first();
        if(!empty($reset)){
            $reset->delete();
        }

        return response()->json($tgl, 200);
    }

    function cariAsetDestroy($id){
        $data = aset_mutasi::where('id_aset', $id)->orderBy('id','desc')->first();

        return response()->json($data, 200);
    }

    function destroy($id){
        $tgl = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');

        $data = aset_mutasi::where('id', $id)->first();

            $aset = aset::where('id', $data->id_aset)->first();
            $aset->id_ruangan = $data->lokasi_awal;
            $aset->token = Crypt::encryptString($data->no_inventaris_lama); // decryptString to Decrypt
            $aset->urutan = $data->urutan_lama;
            $aset->no_inventaris = $data->no_inventaris_lama;
            $aset->kondisi = $data->kondisi_awal;
            $aset->save();

        $data->delete();

        return response()->json($tgl, 200);
    }
}
