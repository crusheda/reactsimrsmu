<?php

namespace App\Http\Controllers\Kepegawaian;

use App\Http\Controllers\Controller;
use App\Models\referensi;
use App\Models\datalogs;
use App\Models\users;
use App\Models\kepegawaian\pd;
use App\Models\kepegawaian\pd_ceklis;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;
use Validator,Redirect,Response,File,Storage;

class PDController extends Controller
{
    function index()
    {
        if (
                Auth::user()->getPermission('admin_kepegawaian_kepala') == true ||
                Auth::user()->getPermission('admin_kepegawaian') == true ||
                Auth::user()->getPermission('admin_pd_keuangan') == true
            ) {
            $users  = users::where('nik','!=',null)->where('nama','!=',null)->orderBy('nama', 'asc')->get();

            $data = [
                'users' => $users,
            ];

            return view('pages.kepegawaian.pd.index')->with('list', $data);
        } else {
            return redirect()->back()->withErrors("Maaf, Anda tidak memiliki akses untuk membuka halaman Perjalanan Dinas!");
        }
    }

    function table()
    {
        $users  = users::select('id','nama')->where('nik','!=',null)->where('nama','!=',null)->orderBy('nama', 'asc')->get();
        $show  = pd::join('users','users.id','=','kepegawaian_pd.user_id')
                    ->select('users.name as name_user','users.nama as nama_user','kepegawaian_pd.*')
                    ->get();

        $data = [
            'show' => $show,
            'users' => $users,
        ];

        return response()->json($data, 200);
    }

    function tambah(Request $request)
    {
        // $request->validate([
        //     'file' => ['max:2000','mimes:pdf'],
        // ]);

        // print_r($request->all());
        // die();
        $push = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');

        $data = new pd;
        $data->user_id = $request->user;
        $data->pegawai_id = $request->pegawai;
        $data->jenis = $request->jenis;
        $data->kendaraan = $request->kendaraan;
        $data->kendaraan_pegawai = $request->kendaraan_pegawai;
        $data->lama1 = $request->lama1;
        $data->lama2 = $request->lama2;
        $data->tgl = $request->tgl;
        $data->acara = $request->acara;
        $data->lokasi = $request->lokasi;
        $data->deskripsi = $request->deskripsi;
        $data->paid = false;
        $data->save();

        return Response::json(array(
            'message' => $push,
            'code' => 200,
        ));
    }

    function show($id) // TAMPIL RINCIAN
    {
        $show = pd::leftJoin('users','users.id','=','kepegawaian_pd.user_paid')
                    ->select('kepegawaian_pd.*','users.nama as nama_user_paid')
                    ->where('kepegawaian_pd.id',$id)
                    ->first();
        $users  = users::where('nik','!=',null)->orderBy('nama', 'asc')->get();
        $data = [
            'show' => $show,
            'users' => $users,
        ];
        return response()->json($data, 200);
    }

    function update(Request $request)
    {
        $push = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');

        $data = pd::find($request->id);
        $data->pegawai_id = $request->pegawai;
        $data->jenis = $request->jenis;
        $data->kendaraan = $request->kendaraan;
        $data->kendaraan_pegawai = $request->kendaraan_pegawai;
        $data->lama1 = $request->lama1;
        $data->lama2 = $request->lama2;
        $data->tgl = $request->tgl;
        $data->acara = $request->acara;
        $data->lokasi = $request->lokasi;
        $data->deskripsi = $request->deskripsi;
        $data->save();

        return Response::json(array(
            'message' => $push,
            'code' => 200,
        ));
    }

    function download($id)
    {
        $data = pd::where('id', $id)->first();
        $filename = $data->filename;
        $title = $data->title;
        return Storage::download($filename, $title);
    }

    function hapus($id)
    {
        $tgl = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');

        // Inisialisasi
        $data = pd::find($id);

        // Proses Hapus Lampiran
        Storage::delete($data->filename);

        // Hapus Record DB
        $data->delete();

        return response()->json($tgl, 200);
    }

    function confirmPaid(Request $request)
    {
        $push = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');

        $data = pd::find($request->id);
        $data->paid = true;
        $data->user_paid = $request->pegawai;
        $data->tgl_paid = Carbon::now();
        $data->save();

        return response()->json($push, 200);
    }

    function cancelPaid(Request $request)
    {
        $push = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');

        $data = pd::find($request->id);
        $data->paid = false;
        $data->user_paid = $request->pegawai;
        $data->tgl_paid = Carbon::now();
        $data->save();

        return response()->json($push, 200);
    }
}
