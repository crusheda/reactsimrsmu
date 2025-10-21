<?php

namespace App\Http\Controllers\Kepegawaian\Rekrutmen;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\users;
use App\Models\datalogs;
use App\Models\kepegawaian\ref_jenjang_pendidikan;
use App\Models\kepegawaian\rekrutmen\pengumuman;
use App\Models\kepegawaian\rekrutmen\registrasi;
use Carbon\Carbon;
use Auth;
use Validator,Redirect,Response,File;

class PengumumanController extends Controller
{
    function index()
    {
        if (Auth::user()->getPermission('admin_kepegawaian') == true) {
            $jenjang_pendidikan = ref_jenjang_pendidikan::orderBy('kategori','ASC')->get();

            $data = [
                'pendidikan' => $jenjang_pendidikan,
            ];

            return view('pages.kepegawaian.rekrutmen.pengumuman.index')->with('list', $data);
        } else {
            return redirect()->back()->withErrors("Maaf, Anda tidak memiliki akses untuk membuka halaman Rekrutmen/Lowongan Kerja")->withInput();
        }
    }

    function table()
    {
        $dateNow = Carbon::now()->isoFormat('YYYY-MM-DD');
        // Ambil semua jenjang pendidikan dan simpan dalam bentuk [id => nama]
        $jenjangMap = DB::table('referensi_jenjang_pendidikan')
            ->pluck('nama', 'id');

        // Subquery: hitung jumlah pendaftar per pengumuman
        $subQuery = DB::table('rekrutmen_registrasi')
            ->select('id_pengumuman', DB::raw('COUNT(*) as total_pendaftar'))
            ->whereNull('deleted_at')
            ->groupBy('id_pengumuman');

        // Query utama: join dengan user dan subquery pendaftar
        $show = DB::table('rekrutmen_pengumuman')
            ->join('users', 'users.id', '=', 'rekrutmen_pengumuman.user_id')
            ->leftJoinSub($subQuery, 'pendaftar', function ($join) {
                $join->on('rekrutmen_pengumuman.id', '=', 'pendaftar.id_pengumuman');
            })
            ->select(
                'rekrutmen_pengumuman.*',
                'users.nama as nama_user',
                DB::raw('COALESCE(pendaftar.total_pendaftar, 0) as total_pendaftar')
            )
            ->get();

        // Tambahkan kualifikasi_nama
        $show->transform(function ($item) use ($jenjangMap) {
            $kualifikasi_ids = json_decode($item->kualifikasi, true);
            if (!is_array($kualifikasi_ids)) $kualifikasi_ids = [];

            $item->kualifikasi_nama = collect($kualifikasi_ids)
                ->map(fn($id) => $jenjangMap[$id] ?? 'Tidak Diketahui')
                ->implode(', ');

            return $item;
        });

        $data = [
            'show' => $show,
            'now' => $dateNow,
        ];

        return response()->json($data, 200);
    }

    function show($id)
    {
        $show = pengumuman::where('id',$id)->first();
        $pendidikan = ref_jenjang_pendidikan::orderBy('kategori','ASC')->get();

        $data = [
            'show' => $show,
            'pendidikan' => $pendidikan,
        ];

        return response()->json($data, 200);
    }

    function simpan(Request $request)
    {
        $push = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');

        $validasi = pengumuman::where('nama',$request->nama)->count();
        if ($validasi > 0) {
            return Response::json(array(
                'message' => 'Nama Kebutuhan sudah pernah digunakan, silakan menggunakan nama lain.',
                'code' => 400,
            ));
        } else {
            $data = new pengumuman;
            $data->token = Crypt::encryptString($request->nama); // decryptString to Decrypt
            $data->unit = $request->unit;
            $data->nama = $request->nama;
            $data->jumlah = $request->jumlah;
            $data->kualifikasi = $request->kualifikasi;
            $data->tugas = $request->tugas;
            $data->keahlian = $request->keahlian;
            $data->persyaratan = $request->persyaratan;
            $data->umur_min = $request->umur_min;
            $data->umur_max = $request->umur_max;
            $data->kuota = $request->kuota;
            $data->mulai = $request->mulai;
            $data->selesai = $request->selesai;
            $data->keterangan = $request->keterangan;
            $data->user_id = $request->pegawai;
            $data->save();

            datalogs::record($request->pegawai, 'Baru saja melakukan penambahan Lowongan Kerja '.$request->nama, 'dari '.$request->mulai.' sampai '.$request->selesai, null, $data, '["kepala-sumber-daya-insani","staf-sumber-daya-insani"]');
            return Response::json(array(
                'message' => $push,
                'code' => 200,
            ));
        }
    }

    function ubah(Request $request)
    {
        $push = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');

        $validasi = pengumuman::where('nama',$request->nama)->count();
        if ($validasi > 0) {
            return Response::json(array(
                'message' => 'Nama Kebutuhan sudah pernah digunakan, silakan menggunakan nama lain.',
                'code' => 400,
            ));
        } else {
            $data = pengumuman::find($request->id);
            $data->token = Crypt::encryptString($request->nama); // decryptString to Decrypt
            $data->unit = $request->unit;
            $data->nama = $request->nama;
            $data->jumlah = $request->jumlah;
            $data->kualifikasi = $request->kualifikasi;
            $data->tugas = $request->tugas;
            $data->keahlian = $request->keahlian;
            $data->persyaratan = $request->persyaratan;
            $data->umur_min = $request->umur_min;
            $data->umur_max = $request->umur_max;
            $data->kuota = $request->kuota;
            $data->mulai = $request->mulai;
            $data->selesai = $request->selesai;
            $data->keterangan = $request->keterangan;
            $data->user_id = $request->pegawai;
            $data->save();

            datalogs::record($request->pegawai, 'Baru saja melakukan perubahan Lowongan Kerja '.$request->nama, 'dari '.$request->mulai.' sampai '.$request->selesai, null, $data, '["kepala-sumber-daya-insani","staf-sumber-daya-insani"]');
            return Response::json(array(
                'message' => $push,
                'code' => 200,
            ));
        }
    }

    function nonaktif($user,$id)
    {
        $tgl = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');

        // Inisialisasi
        $data = pengumuman::find($id);
        $old = $data;
        $data->status = 0;
        $data->save();
        // $data->delete();

        datalogs::record($user, 'Baru saja melakukan penonaktifan pengumuman ID#'.$id, $data->status, $old, $data, '["kepala-sumber-daya-insani","staf-sumber-daya-insani"]');
        return response()->json($tgl, 200);
    }

    function makeEncrypt($id)
    {
        return response()->json(Crypt::encryptString($id), 200);
    }

    function makeDecrypt($id)
    {
        return response()->json(Crypt::decryptString($id), 200);
    }
}
