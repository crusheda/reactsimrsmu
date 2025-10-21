<?php

namespace App\Http\Controllers\Kepegawaian\Rekrutmen;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\users;
use App\Models\datalogs;
use App\Models\kepegawaian\rekrutmen\pengumuman;
use App\Models\kepegawaian\rekrutmen\registrasi;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use Auth;
use Validator,Redirect,Response,File;

class RegistrasiController extends Controller
{
    function index()
    {
        if (
                Auth::user()->getPermission('admin_kepegawaian') == true ||
                Auth::user()->getPermission('admin_kepegawaian_kepala') == true
            ) {

            $pengumuman = pengumuman::where('status',1)->whereNull('deleted_at')->orderBy('mulai','DESC')->get();

            $data = [
                'pengumuman' => $pengumuman
            ];

            return view('pages.kepegawaian.rekrutmen.peserta.index')->with('list', $data);
        } else {
            return redirect()->back()->withErrors("Maaf, Anda tidak memiliki akses untuk membuka halaman Daftar Peserta!");
        }
    }

    function table($id)
    {
        if ($id == 0) {
            $show = registrasi::where('status',1)
                ->whereNull('deleted_at')
                ->get()
                ->map(function ($item) {
                    $item->encrypted_id = urlencode(Crypt::encryptString($item->id));
                    return $item;
                });
        } else {
            $show = registrasi::where('status',1)
                ->where('id_pengumuman',$id)
                ->whereNull('deleted_at')
                ->get()
                ->map(function ($item) {
                    $item->encrypted_id = urlencode(Crypt::encryptString($item->id));
                    return $item;
                });
            // $show = registrasi::where('status',1)->where('id_pengumuman',$id)->whereNull('deleted_at')->get();
        }

        $data = [
            'show' => $show,
        ];

        return response()->json($data, 200);
    }

    function hasil(Request $request)
    {
        $push = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');

        $data = registrasi::find($request->id);
        $old = $data;
        $data->hasil = $request->hasil;
        if ($request->hasil == 2) {
            $data->keterangan_seleksi = $request->ket;
            $data->tgl_seleksi = null;
            $data->ruang_seleksi = null;
        } elseif ($request->hasil == 3) {
            $data->keterangan_lolos = $request->ket;
        } elseif ($request->hasil == 0) {
            $data->keterangan_tidak_lolos = $request->ket;
        } else { // RESET to hasil = 1
            $data->keterangan_seleksi = null;
            $data->keterangan_lolos = null;
            $data->keterangan_tidak_lolos = null;
            $data->tgl_seleksi = null;
            $data->ruang_seleksi = null;
        }
        $data->save();

        datalogs::record($request->pegawai, 'Baru saja melakukan perubahan hasil peserta seleksi ID#'.$request->id, $request->hasil, $old, $data, '["kepala-sumber-daya-insani","staf-sumber-daya-insani"]');
        return Response::json(array(
            'message' => $push,
            'code' => 200,
        ));
    }
}
