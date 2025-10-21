<?php

namespace App\Http\Controllers\Berkas;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\model_has_roles;
use App\Models\struktur_organisasi;
use App\Models\roles;
use App\Models\berkas_laporan_bulanan;
use App\Models\berkas_laporan_bulanan_verif;
use App\Models\berkas_laporan_bulanan_catatan;
use App\Models\unit;
use App\Models\User;
use App\Models\users;
use Carbon\Carbon;
use Redirect;
use Storage;
use Auth;
use Response;
use Exception;

class LaporanBulananController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    // LAPORAN BULANAN ----------------------------------------------------------------------------------------------------------------------------------
    public function index()
    {
        $thn = Carbon::now()->isoFormat('Y');

        // COUNT ALL LAPORAN
        $bulan = Carbon::now()->subMonth()->isoFormat('MM');
        $tahun = Carbon::now()->isoFormat('YYYY');
        $count = berkas_laporan_bulanan::where('bln',$bulan)->where('thn',$tahun)->count();

        $data = [
            'count' => $count,
            'thn'  => $thn,
        ];

        return view('pages.berkas.laporanbulanan.index')->with('list', $data);
    }

    // Validasi User boleh Upload atau tidak
    public function formUpload($id)
    {
        // $cek = struktur_organisasi::where('id_user',$id)->first();

        // if (!empty($cek->nama_user)) {
        //     $res = 1;
        //     return response()->json($res, 200);
        // } else {
        //     $res = 0;
        //     return response()->json($res, 200);
        // }

        // if(Auth::user()->getPermission('laporan_bulanan') == true) {
        //     $res = 1;
        //     return response()->json($res, 200);
        // } else {
        //     $res = 0;
        //     return response()->json($res, 200);
        // }

        // $user = $this->userUpload($id);

        // if ($user == 1) {
        //     $res = 1;
        //     return response()->json($res, 200);
        // } else {
        //     $res = 0;
        //     return response()->json($res, 200);
        // }

        $getPermission = User::join('model_has_roles','model_has_roles.model_id','=','users.id')
                    ->join('role_has_permissions','role_has_permissions.role_id','=','model_has_roles.role_id')
                    ->join('permissions','permissions.id','=','role_has_permissions.permission_id')
                    ->whereIn('permissions.name', ['laporan_bulanan','admin_laporan_bulanan'])
                    ->where('model_has_roles.model_id', $id)
                    ->select('users.name')
                    ->first();

        if (!empty($getPermission->name)) {
            $res = 1;
            return response()->json($res, 200);
        } else {
            $res = 0;
            return response()->json($res, 200);
        }
    }

    public function create()
    {
        //
    }

    // Upload dokumen laporan bulanan
    public function store(Request $request)
    {
        $user = Auth::user();
        $userId = $user->id;
        // $unit = $user->roles; //kabag-keperawatan

        $role = model_has_roles::join('roles', 'model_has_roles.role_id', '=', 'roles.id')->select('roles.name')->where('model_has_roles.model_id', $userId)->get();

        foreach ($role as $key => $value) {
            $unit[] = $value->name;
        }

        $request->validate([
            'file' => ['max:5000'],
            ]);
        // $request->validate([
        //     'file' => ['max:20000','mimes:pdf'],
        //     ]);

        // tampung berkas yang sudah diunggah ke variabel baru
        // 'file' merupakan nama input yang ada pada form
        $uploadedFile = $request->file('file');

        // simpan berkas yang diunggah ke sub-direktori 'public/files'
        // direktori 'files' otomatis akan dibuat jika belum ada
        $path = $uploadedFile->store('public/files/laporan-bulanan/'.$request->thn.'/'.$request->bln);

        $find = berkas_laporan_bulanan::where('id_user',$userId)->get();

        foreach ($find as $key => $value) {
            if ($value->title == $uploadedFile->getClientOriginalName()) {
                return redirect()->back()->withErrors('Maaf, Nama file '.$value->title.' sudah pernah diupload oleh seseorang. Mohon Ganti Nama File yang berbeda. Disarankan untuk menambahkan identitas Unit/Bulan/Tahun untuk membuat nama yang unik pada File Anda.');
            }
        }

        $data = new berkas_laporan_bulanan;
        $data->judul = $request->judul;
        $data->bln = $request->bln;
        $data->thn = $request->thn;
        $data->id_user = $userId;
        $data->unit = json_encode($unit);

            $data->title = $request->title ?? $uploadedFile->getClientOriginalName();
            $data->filename = $path;

        $data->ket = $request->ket;

        $data->save();
        return Redirect::back()->with('message','Tambah Laporan Bulanan Berhasil');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = berkas_laporan_bulanan::find($id);
        return Storage::download($data->filename, $data->title);

        // $headers = [
        //     'Content-Description' => 'Laporan Bulanan',
        //     'Content-Type' => 'application/pdf',
        // ];

        // $data = berkas_laporan_bulanan::find($id);
        // $path1 = 'storage/'.substr($data->filename,7,10000);
        // return response()->file($path1, $headers);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    // Menampilkan tabel laporan bulanan
    public function table($id)
    {
        $show = berkas_laporan_bulanan::leftJoin('berkas_laporan_bulanan_catatan as cat', function($join) {
                                            $join->on('cat.id_laporan', '=', 'berkas_laporan_bulanan.id')
                                                ->whereNull('cat.deleted_at');
                                        })
                                        ->select(
                                            'berkas_laporan_bulanan.*',

                                            // has_catatan
                                            DB::raw('CASE WHEN EXISTS (
                                                SELECT 1 FROM berkas_laporan_bulanan_catatan c
                                                WHERE c.id_laporan = berkas_laporan_bulanan.id
                                                AND c.deleted_at IS NULL
                                            ) THEN 1 ELSE 0 END AS has_catatan'),

                                            // has_verified
                                            DB::raw('CASE WHEN EXISTS (
                                                SELECT 1 FROM berkas_laporan_bulanan_verif v2
                                                WHERE v2.lap_id = berkas_laporan_bulanan.id
                                                AND v2.deleted_at IS NULL
                                            ) THEN 1 ELSE 0 END AS has_verified'),

                                            // verif_list
                                            DB::raw('(
                                                SELECT CONCAT(
                                                    "[",
                                                    GROUP_CONCAT(
                                                        CONCAT(
                                                            "{",
                                                            "\"id\":", v.id, ",",
                                                            "\"lap_id\":", v.lap_id, ",",
                                                            "\"queue\":", v.queue, ",",
                                                            "\"nama_user\":\"", IFNULL(v.user_name, ""), "\",",
                                                            "\"nama_role\":\"", REPLACE(IFNULL(v.role_name, ""), \'"\', \'\\\"\'), "\"",
                                                            "}"
                                                        )
                                                        ORDER BY v.queue ASC SEPARATOR ","
                                                    ),
                                                    "]"
                                                )
                                                FROM berkas_laporan_bulanan_verif v
                                                WHERE v.lap_id = berkas_laporan_bulanan.id
                                                AND v.deleted_at IS NULL
                                            ) AS verif_list'),

                                            // catatan_list (baru dengan join users)
                                            DB::raw('(
                                                SELECT CONCAT(
                                                    "[",
                                                    GROUP_CONCAT(
                                                        CONCAT(
                                                            "{",
                                                            "\"id\":", c.id, ",",
                                                            "\"id_laporan\":", c.id_laporan, ",",
                                                            "\"user_id\":", c.user, ",",
                                                            "\"nama_user\":\"", IFNULL(u.nama, ""), "\",",
                                                            "\"tgl\":\"", IFNULL(c.tgl, ""), "\",",
                                                            "\"deskripsi\":\"", REPLACE(IFNULL(c.deskripsi, ""), \'"\', \'\\\"\'), "\",",
                                                            "\"extra\":\"", IFNULL(c.extra, ""), "\",",
                                                            "\"solved\":", IFNULL(c.solved, 0), ",",
                                                            "\"tgl_solved\":\"", IFNULL(c.tgl_solved, ""), "\"",
                                                            "}"
                                                        )
                                                        ORDER BY c.tgl DESC SEPARATOR ","
                                                    ),
                                                    "]"
                                                )
                                                FROM berkas_laporan_bulanan_catatan c
                                                LEFT JOIN users u ON u.id = c.user
                                                WHERE c.id_laporan = berkas_laporan_bulanan.id
                                                AND c.deleted_at IS NULL
                                            ) AS catatan_list')
                                        )
                                        ->where('berkas_laporan_bulanan.id_user', $id)
                                        ->distinct()
                                        ->orderBy('berkas_laporan_bulanan.updated_at', 'desc')
                                        ->get();

        // Decode JSON agar langsung siap dipakai di view
        foreach ($show as $item) {
            foreach (['verif_list', 'catatan_list'] as $field) {
                if (!empty($item->$field)) {
                    $decoded = json_decode($item->$field, true);
                    $item->$field = json_last_error() === JSON_ERROR_NONE ? $decoded : [];
                } else {
                    $item->$field = [];
                }
            }
        }

        // print_r($show);
        // die();

        $tgl = Carbon::now()->isoFormat('YYYY/MM/DD');
        $tglAfter3Day = Carbon::now()->addDays(3)->isoFormat('YYYY/MM/DD');
        $tglAfter2Day = Carbon::now()->addDays(2)->isoFormat('YYYY/MM/DD');
        $tglAfter1Day = Carbon::now()->addDays(1)->isoFormat('YYYY/MM/DD');

        $data = [
            // 'verif' => $getVerif,
            'show' => $show,
            'tgl' => $tgl,
            'tglAfter1Day' => $tglAfter1Day,
            'tglAfter2Day' => $tglAfter2Day,
            'tglAfter3Day' => $tglAfter3Day,
        ];

        return response()->json($data, 200);
    }
    
    public function previewLaporan($id)
    {
        $show = berkas_laporan_bulanan::find($id);

        if (!$show) {
            return response()->json(['message' => 'Data tidak ditemukan.'], 404);
        }

        // Ambil path file dari database, contoh:
        // public/files/laporan-bulanan/2025/8/YzekBgDmSIOgO3nZM7dZXubS6xuxKZFS2wre5JR7.docx
        $filename = $show->filename;

        // Pastikan file benar-benar ada
        if (!Storage::exists($filename)) {
            return response()->json(['message' => 'File tidak ditemukan.'], 404);
        }

        // Hapus prefix "public/" agar bisa dicek dan diakses via storage
        $relativePath = str_replace('public/', '', $filename);

        // Buat URL publik dari file (karena storage:link mengarah ke public/storage)
        $publicUrl = asset('storage/' . $relativePath);

        // Dapatkan ekstensi file
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        return response()->json([
            'url' => $publicUrl,
            'ext' => $extension,
        ]);
    }

    // VERIF LAPORAN BULANAN ----------------------------------------------------------------------------------------------------------------------------------
    // Verifikasi User boleh verifikasi atau tidak / boleh berpindah ke halaman laporan bawahan atau tidak
    public function formVerif($id)
    {
        $cek = struktur_organisasi::where('id_user',$id)->first();
        $user = User::find($id);

        if ($user->hasPermissionTo('admin_laporan_bulanan_verifall')) {
            $res = 1;
            return response()->json($res, 200);
        } else {
            if (!empty($cek->nama_user)) {
                $res = 1;
                return response()->json($res, 200);
            } else {
                $res = 0;
                return response()->json($res, 200);
            }
        }
    }

    // Berpindah ke halaman Verifikasi
    function showVerif()
    {
        $cek = struktur_organisasi::where('id_user',Auth::user()->id)->first();
        $user = User::find(Auth::user()->id);

        if ($user->hasPermissionTo('admin_laporan_bulanan_verifall')) {
            return view('pages.berkas.laporanbulanan.verif');
        } else {
            if (!empty($cek->nama_user)) {
                return view('pages.berkas.laporanbulanan.verif');
            } else {
                return redirect()->back()->withErrors('Anda tidak memiliki Akses untuk Verifikasi Laporan Bulanan Bawahan atau Akses Laporan Bawahan tidak ditemukan. Silakan hubungi IT.');
            }
        }
    }

    // Menampilkan tabel laporan Bawahan
    public function tableVerif($id)
    {
        $jabatan = struktur_organisasi::where('id_user',$id)->orderBy('updated_at','desc')->first();

        $getVerif = berkas_laporan_bulanan_verif::where('user_id',$id)->get();

        $user = User::find($id);

        if ($user->hasPermissionTo('admin_laporan_bulanan_verifall')) {
            $show = berkas_laporan_bulanan::join('users', 'berkas_laporan_bulanan.id_user', '=', 'users.id')
                    ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                    ->leftJoin('berkas_laporan_bulanan_catatan as cat', function($join) {
                        $join->on('cat.id_laporan', '=', 'berkas_laporan_bulanan.id')
                            ->whereNull('cat.deleted_at');
                    })
                    ->where('berkas_laporan_bulanan.id_user', '!=', $id)
                    ->orderBy('berkas_laporan_bulanan.updated_at', 'desc')
                    ->select(
                        'users.nama',
                        'berkas_laporan_bulanan.id',
                        'berkas_laporan_bulanan.unit',
                        'berkas_laporan_bulanan.judul',
                        'berkas_laporan_bulanan.bln',
                        'berkas_laporan_bulanan.thn',
                        'berkas_laporan_bulanan.ket',
                        'berkas_laporan_bulanan.updated_at',
                        DB::raw('CASE WHEN COUNT(cat.id) > 0 THEN 1 ELSE 0 END AS has_catatan'),
                        DB::raw('COUNT(cat.id) AS total_catatan')
                    )
                    ->groupBy(
                        'users.nama',
                        'berkas_laporan_bulanan.id',
                        'berkas_laporan_bulanan.unit',
                        'berkas_laporan_bulanan.judul',
                        'berkas_laporan_bulanan.bln',
                        'berkas_laporan_bulanan.thn',
                        'berkas_laporan_bulanan.ket',
                        'berkas_laporan_bulanan.updated_at'
                    )
                    ->get();
            // $show = berkas_laporan_bulanan::Join('users', 'berkas_laporan_bulanan.id_user', '=', 'users.id')
            //         ->Join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            //         ->where('berkas_laporan_bulanan.id_user','!=',$id)
            //         ->orderBy('berkas_laporan_bulanan.updated_at', 'desc')
            //         ->select('users.nama','berkas_laporan_bulanan.id','berkas_laporan_bulanan.unit','berkas_laporan_bulanan.judul','berkas_laporan_bulanan.bln','berkas_laporan_bulanan.thn','berkas_laporan_bulanan.ket','berkas_laporan_bulanan.updated_at')
            //         ->groupBy('users.nama','berkas_laporan_bulanan.id','berkas_laporan_bulanan.unit','berkas_laporan_bulanan.judul','berkas_laporan_bulanan.bln','berkas_laporan_bulanan.thn','berkas_laporan_bulanan.ket','berkas_laporan_bulanan.updated_at')
            //         ->get();
        } else {
            $show = berkas_laporan_bulanan::join('users', 'berkas_laporan_bulanan.id_user', '=', 'users.id')
                    ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                    ->leftJoin('berkas_laporan_bulanan_catatan as cat', function($join) {
                        $join->on('cat.id_laporan', '=', 'berkas_laporan_bulanan.id')
                            ->whereNull('cat.deleted_at');
                    })
                    ->whereIn('model_has_roles.role_id', json_decode($jabatan->bawahan))
                    ->where('berkas_laporan_bulanan.id_user', '!=', $id)
                    ->orderBy('berkas_laporan_bulanan.updated_at', 'desc')
                    ->select(
                        'users.nama',
                        'berkas_laporan_bulanan.id',
                        'berkas_laporan_bulanan.unit',
                        'berkas_laporan_bulanan.judul',
                        'berkas_laporan_bulanan.bln',
                        'berkas_laporan_bulanan.thn',
                        'berkas_laporan_bulanan.ket',
                        'berkas_laporan_bulanan.updated_at',
                        DB::raw('CASE WHEN COUNT(cat.id) > 0 THEN 1 ELSE 0 END AS has_catatan'),
                        DB::raw('COUNT(cat.id) AS total_catatan')
                    )
                    ->groupBy(
                        'users.nama',
                        'berkas_laporan_bulanan.id',
                        'berkas_laporan_bulanan.unit',
                        'berkas_laporan_bulanan.judul',
                        'berkas_laporan_bulanan.bln',
                        'berkas_laporan_bulanan.thn',
                        'berkas_laporan_bulanan.ket',
                        'berkas_laporan_bulanan.updated_at'
                    )
                    ->get();
            // $show = berkas_laporan_bulanan::Join('users', 'berkas_laporan_bulanan.id_user', '=', 'users.id')
            //         ->Join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            //         // ->Join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            //         ->whereIn('model_has_roles.role_id',json_decode($jabatan->bawahan))
            //         ->where('berkas_laporan_bulanan.id_user','!=',$id)
            //         ->orderBy('berkas_laporan_bulanan.updated_at', 'desc')
            //         ->select('users.nama','berkas_laporan_bulanan.id','berkas_laporan_bulanan.unit','berkas_laporan_bulanan.judul','berkas_laporan_bulanan.bln','berkas_laporan_bulanan.thn','berkas_laporan_bulanan.ket','berkas_laporan_bulanan.updated_at')
            //         ->groupBy('users.nama','berkas_laporan_bulanan.id','berkas_laporan_bulanan.unit','berkas_laporan_bulanan.judul','berkas_laporan_bulanan.bln','berkas_laporan_bulanan.thn','berkas_laporan_bulanan.ket','berkas_laporan_bulanan.updated_at')
            //         ->get();
        }

        $data = [
            'verif' => $getVerif,
            'show' => $show,
        ];

        return response()->json($data, 200);
    }

    // Menampilkan siapa saja yg sudah verif
    public function verif($id)
    {
        $data = berkas_laporan_bulanan_verif::where('lap_id', $id)->get();

        return response()->json($data, 200);
    }

    // Proses Verifikasi laporan bulanan
    function verifUser($id , $user)
    {
        $getLast = berkas_laporan_bulanan_verif::where('lap_id', $id)->orderBy('updated_at')->first();
        $getUser = users::where('id', $user)->first();
        $getJabatan = struktur_organisasi::where('id_user',$user)->first();
        $getRoles = roles::select('id','name')->get();

        if ($getJabatan) {
            foreach (json_decode($getJabatan->role) as $a => $valjab) {
                foreach ($getRoles as $b => $valrol) {
                    if ($valjab == $valrol->id) {
                        $unit[] = $valrol->name;
                    }
                }
            }

            $data = new berkas_laporan_bulanan_verif;
            if (empty($getLast)) {
                $data->queue = 1;
            } else {
                $data->queue = $getLast->queue + 1;
            }
            $data->lap_id = $id;
            $data->user_id = $getUser->id;
            $data->user_name = $getUser->nama;
            $data->role_name = json_encode($unit);
            $data->save();

            return response()->json($data, 200);
        } else {
            return response()->json([
                'message' => 'Verifikasi tidak diizinkan, Akun Anda tidak termasuk dalam Struktur Organisasi di RS.',
            ], 400);
        }
    }

    // Proses Verifikasi laporan bulanan
    function batalVerif($id)
    {
        berkas_laporan_bulanan_verif::where('id', $id)->delete();

        return response()->json($id, 200);
    }

    public function getubah($id)
    {
        $show = berkas_laporan_bulanan::where('id',$id)->first();
        $tgl = Carbon::parse($show->created_at)->diffForHumans();
        $bulan = ["","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
        $jml_bulan=count($bulan);
        $tahun = Carbon::now()->isoFormat('Y');

        $sizeFile = number_format(Storage::size($show->filename) / 1048576,2);

        $data = [
            'id' => $id,
            'tgl' => $tgl,
            'show' => $show,
            'bulan' => $bulan,
            'jml_bulan' => $jml_bulan,
            'tahun' => $tahun,
            'sizeFile' => $sizeFile,
        ];

        return response()->json($data, 200);
    }

    public function ubah(Request $request)
    {
        $tgl = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');

        $data = berkas_laporan_bulanan::find($request->id);
        $data->judul = $request->judul;
        $data->bln = $request->bln;
        $data->thn = $request->thn;
        $data->ket = $request->ket;
        $data->save();

        return response()->json($tgl, 200);
    }

    public function hapus($id)
    {
        $tgl = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');

        $data = berkas_laporan_bulanan::find($id);
        $file = $data->filename;

        Storage::delete($file);
        $data->delete();

        return response()->json($tgl, 200);
    }

    // CATATAN LAPORAN BULANAN ---------------------------------------------------------------------------
    function showCatatan($id)
    {
        $data = berkas_laporan_bulanan_catatan::leftJoin('users','berkas_laporan_bulanan_catatan.user','=','users.id')
                                                ->select('berkas_laporan_bulanan_catatan.*','users.nama as nama_user')
                                                ->where('berkas_laporan_bulanan_catatan.id_laporan',$id)
                                                ->whereNull('berkas_laporan_bulanan_catatan.deleted_at')
                                                ->get();

        return response()->json($data, 200);
    }

    function storeCatatan(Request $request)
    {
        $tgl = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');

        $data = new berkas_laporan_bulanan_catatan;
        $data->id_laporan = $request->id_laporan;
        $data->user = $request->user;
        $data->tgl = Carbon::now();
        $data->deskripsi = $request->deskripsi;
        $data->save();

        return response()->json($tgl, 200);
    }

    function deleteCatatan($id)
    {
        $tgl = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');

        $data = berkas_laporan_bulanan_catatan::find($id);
        $data->delete();

        return response()->json($tgl, 200);
    }
}
