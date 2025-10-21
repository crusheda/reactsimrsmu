<?php

namespace App\Http\Controllers\Inventaris\Aset;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Crypt;
use App\Models\User;
use App\Models\aset;
use App\Models\aset_peminjaman;
use App\Models\aset_pengembalian;
use App\Models\aset_penarikan;
use App\Models\aset_ruangan;
use App\Models\roles;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Storage;
use Auth;
use \PDF;
use Validator,Redirect,Response,File;

class AsetPeminjamanPengembalianController extends Controller
{
    function getPeminjamanAset($id)
    {
        $users = User::whereNotNull('nik')->where('status',null)->orderBy('nama','ASC')->get();
        $validasi1 = aset_penarikan::where('id_aset',$id)->orderBy('created_at','desc')->first();
        $validasi2 = aset_peminjaman::where('id_aset',$id)->where('status',true)->orderBy('created_at','desc')->first();
        $ruangan = aset_ruangan::get();
        $show = aset::join('aset_ruangan','aset_ruangan.id','=','aset.id_ruangan')
                    // ->join('aset_penarikan','aset_penarikan.id_aset','=','aset.id')
                    ->select('aset_ruangan.ruangan','aset_ruangan.lokasi','aset.*')
                    ->where('aset.id',$id)
                    ->first();

        $data = [
            'penarikan' => $validasi1,
            'peminjaman' => $validasi2,
            'ruangan' => $ruangan,
            'users' => $users,
            'show' => $show,
        ];

        return response()->json($data, 200);
    }

    function getPengembalianAset($id)
    {
        $users = User::whereNotNull('nik')->where('status',null)->orderBy('nama','ASC')->get();
        $validasi1 = aset_penarikan::where('id_aset',$id)->orderBy('created_at','desc')->first();
        // $validasi3 = aset_pengembalian::where('id_aset',$id)->orderBy('created_at','desc')->first();
        $ruangan = aset_ruangan::get();
        $show = aset::join('aset_ruangan','aset_ruangan.id','=','aset.id_ruangan')
                    // ->join('aset_penarikan','aset_penarikan.id_aset','=','aset.id')
                    ->select('aset_ruangan.ruangan','aset_ruangan.lokasi','aset.*')
                    ->where('aset.id',$id)
                    ->first();
        $peminjaman = aset_peminjaman::where('id_aset',$id)->where('status',true)->orderBy('created_at','desc')->first();

        $data = [
            'penarikan' => $validasi1,
            'peminjaman' => $peminjaman,
            // 'pengembalian' => $validasi3,
            'ruangan' => $ruangan,
            'users' => $users,
            'show' => $show,
        ];

        return response()->json($data, 200);
    }

    // STORE FUNCTION ----------------------------------------------------------------------------------------------------------------------------------
    function storePeminjaman(Request $request) {
        $tgl = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');

        $penarikan = aset_penarikan::where('id_aset', $request->aset)->first();
        $aset = aset::where('id',$request->aset)->first();

        if(!empty($penarikan)) {
            if ($penarikan->status != 3) {
                // SAVE TO PEMINJAMAN
                $data = new aset_peminjaman;
                $data->id_aset = $request->aset;
                $data->tgl_peminjaman = $request->tgl_peminjaman;
                $data->tgl_pengembalian = $request->tgl_pengembalian;
                $data->kondisi = $request->kondisi;
                $data->penanggungjawab = $request->pj;
                $data->id_ruangan = $request->lokasi;
                $data->kelengkapan = $request->kelengkapan;
                $data->id_user = $request->user;
                $data->status = true;
                $data->save();

                // SAVE TO ASET
                $aset->id_ruangan = $request->lokasi;
                $aset->kondisi = $request->kondisi;
                $aset->status = true;
                $aset->save();

                // HAPUS ASET PENARIKAN YANG ADA
                $penarikan->delete();
            }
        } else {
            // SAVE TO PEMINJAMAN
            $data = new aset_peminjaman;
            $data->id_aset = $request->aset;
            $data->tgl_peminjaman = $request->tgl_peminjaman;
            $data->tgl_pengembalian = $request->tgl_pengembalian;
            $data->kondisi = $request->kondisi;
            $data->penanggungjawab = $request->pj;
            $data->id_ruangan = $request->lokasi;
            $data->kelengkapan = $request->kelengkapan;
            $data->ket = $request->ket;
            $data->id_user = $request->user;
            $data->status = true;
            $data->save();

            // SAVE TO ASET
            $aset->id_ruangan = $request->lokasi;
            $aset->kondisi = $request->kondisi;
            $aset->status = true;
            $aset->save();
        }

        return response()->json($tgl, 200);
    }

    function storePengembalian(Request $request) {
        $tgl = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');
        $aset = aset::where('id',$request->aset)->first();
        $peminjaman = aset_peminjaman::where('id_aset',$request->aset)->where('status',true)->orderBy('created_at','desc')->first();

        // SAVE TO PENGEMBALIAN
        $data = new aset_pengembalian;
        $data->id_aset = $request->aset;
        $data->id_user = $request->user;
        $data->tgl_pengembalian = $request->tgl_pengembalian;
        $data->kondisi = $request->kondisi;
        $data->pengantar = $request->pengantar;
        $data->penerima = $request->penerima;
        $data->ket = $request->ket;
        $data->status = false; // False = telah dikembalikan
        $data->save();

        // UPDATE TO ASET
        $aset->id_ruangan = 1; // DIKEMBALIKAN KE GUDANG ASET LAGI
        $aset->kondisi = $request->kondisi;
        $aset->status = 0;
        $aset->save();

        // UPDATE PEMINJAMAN YANG ADA
        $peminjaman->status = false;
        $peminjaman->save();

        return response()->json($tgl, 200);
    }
}
