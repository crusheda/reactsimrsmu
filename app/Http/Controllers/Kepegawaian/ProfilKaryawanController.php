<?php

namespace App\Http\Controllers\Kepegawaian;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use App\Models\referensi;
use App\Models\datalogs;
use App\Models\users;
use App\Models\users_foto;
use App\Models\users_doc;
use App\Models\users_rotasi;
use App\Models\users_status;
use App\Models\users_spkrkk;
use App\Models\logs;
use App\Models\alamat;
use App\Models\model_has_roles;
use App\Models\roles;
use Carbon\Carbon;
use Auth;
use Storage;
use Exception;
use Redirect;

class ProfilKaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $show  = users::where('nik','!=',null)->orderBy('nama', 'asc')->get();
        // $showMin  = users::where('nik',null)->count();

        // $role = users::Join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
        //     ->Join('roles', 'model_has_roles.role_id', '=', 'roles.id')
        //     ->select('roles.name as nama_role', 'users.id as id_user')
        //     ->get();

        $data = [
            // 'show' => $show,
            // 'showmin' => $showMin,
            // 'role' => $role,
        ];

        return view('pages.profilkaryawan.index')->with('list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) // TAMPILAN HALAMAN DETAIL PROFIL KEPEGAWAIAN
    {
        $show = DB::table('users')
                ->leftJoin('users as us', 'us.id', '=', 'users.user_hapus')
                ->select('us.nama as nama_admin','users.*')
                ->where('users.id','=', $id)
                ->first();
        $users = users::where('nik','!=',null)->where('nik','!=',0)->orderBy('nama', 'asc')->get();
        $foto = DB::table('users_foto')->where('user_id', '=', $id)->first();
        $showlog = logs::where('user_id', $id)->where('log_type', '=', 'login')->select('log_date')->orderBy('log_date', 'DESC')->get();
        $role = model_has_roles::join('roles', 'model_has_roles.role_id', '=', 'roles.id')->select('model_has_roles.model_id as id_user','roles.name as nama_role')->get();
        $onlyRole = roles::get();
        $provinsi = alamat::select('provinsi')->groupBy('provinsi')->get();
        $kota = alamat::select('nama_kabkota')->groupBy('nama_kabkota')->get();
        $model = model_has_roles::where('model_id', $id)->get();

        // GET DATA OF USER
        $users_status = users_status::join('referensi','referensi.id','=','users_status.ref_id')
                    ->select('users_status.*','referensi.deskripsi as nama_referensi')
                    ->where('users_status.pegawai_id',$id)
                    ->where('users_status.status',1)
                    ->orderBy('users_status.updated_at','desc')
                    ->first();
        // print_r($users_status);
        // die();
        // REFERENSI
        $ref_dokumen = referensi::where('ref_jenis',8)->orderBy('queue','ASC')->get(); // 8 is Jenis Dokumen User
        $ref_rotasi = referensi::where('ref_jenis',9)->orderBy('queue','ASC')->get(); // 10 is Jenis Rotasi Pegawai
        $ref_penetapan = referensi::where('ref_jenis',10)->orderBy('queue','ASC')->get(); // 10 is Jenis Penetapan Pegawai

        $data = [
            'id_user' => $id,
            'showlog' => $showlog,
            'model' => $model,
            'show' => $show,
            'users' => $users,
            'foto' => $foto,
            'role' => $role,
            'onlyRole' => $onlyRole,
            'provinsi' => $provinsi,
            'kota' => $kota,
            'users_status' => $users_status,
            'ref_dokumen' => $ref_dokumen,
            'ref_rotasi' => $ref_rotasi,
            'ref_penetapan' => $ref_penetapan,
        ];

        return view('pages.profilkaryawan.detail')->with('list', $data);
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
        $tgl = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');

        $data = users::find($id);
        $data->delete();

        return Redirect::back()->with('message','Anda berhasil menonaktifkan Karyawan pada '.$tgl);
    }

    public function hapus($id)
    {
        $tgl = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');

        $data = users::find($id);
        $data->delete();

        return Redirect::back()->with('message','Anda berhasil menonaktifkan Karyawan pada '.$tgl);
    }

    // API
    function table()
    {
        $show = users::where('status',null)->orderBy('updated_at','desc')->get();

        $data = [
            'show' => $show
        ];

        return response()->json($data, 200);
    }

    function tableAll()
    {
        $show = users::leftJoin('referensi as rp','rp.id','=','users.ref_profesi')
                ->leftJoin('users_status as us', function($join) {
                    $join->on('us.pegawai_id', '=', 'users.id')
                            ->where('us.status', '=', 1)
                            ->whereNull('us.deleted_at');
                })
                ->leftJoin('referensi as rus', function($join) {
                    $join->on('rus.id', '=', 'us.ref_id')
                            ->where('rus.ref_jenis', '=', 10);
                })
                // ->where('us.deleted_at',null)
                ->where('users.status',null)
                ->select('users.*','rus.deskripsi as profesi','rp.deskripsi as klasifikasi_user','rus.deskripsi as status_pegawai')
                ->orderBy('users.nip','asc')
                ->get();
        $role = model_has_roles::join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                ->select('model_has_roles.model_id as id_user','roles.name as nama_role')
                ->get();

        $data = [
            'show' => $show,
            'role' => $role,
        ];

        return response()->json($data, 200);
    }

    function tableNonaktif()
    {
        $show = users::onlyTrashed()->orderBy('deleted_at','desc')->get();

        $data = [
            'show' => $show
        ];

        return response()->json($data, 200);
    }

    function tableNonLengkap()
    {
        $show = users::where('nik', null)->whereNull('deleted_at')->whereNull('status')->orderBy('updated_at','desc')->get();

        $data = [
            'show' => $show
        ];

        return response()->json($data, 200);
    }

    function setAktif($user,$id)
    {
        $tgl = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');

        // $data = DB::table('users')->where('id',$id)->first();
        $data = users::onlyTrashed()->where('id',$id)->first();
        $data->status = null;
        $data->user_hapus = null;
        $data->deleted_at = null;
        $data->save();

        // CEK DATA & SAVE LOG
        datalogs::record($user, 'Baru saja mengaktifkan status Login Pegawai ID : '.$id, null, null, null, '["kepala-sumber-daya-insani","staf-sumber-daya-insani"]');

        return response()->json($tgl, 200);
    }

    function setNonAktif($id)
    {
        $tgl = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');

        $data = users::find($id);
        $data->delete();

        // CEK DATA & SAVE LOG
        // datalogs::record($user, 'Baru saja mengaktifkan status Login Pegawai ID : '.$id, null, null, null, '["kepala-sumber-daya-insani","staf-sumber-daya-insani"]');
        return response()->json($tgl, 200);
    }

    function hapusPegawai($user,$id)
    {
        $tgl = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');

        // print_r($id);
        // die();
        // Inisialisasi
        $data = users::find($id);
        $switch = $data;

        // Proses Hapus Data dari DB
        $data->user_hapus = $user;
        $data->status = 1;
        $data->save();
        $data->delete();

        // CEK DATA & SAVE LOG
        datalogs::record($user, 'Baru saja menghapus/menonaktifkan Pegawai ID : '.$id, null, null, $switch, '["kepala-sumber-daya-insani","staf-sumber-daya-insani"]');

        return response()->json($tgl, 200);
    }

    public function grafik1() // Jenis Pegawai (ref_profesi -> referensi.ref_jenis = 11)
    {
        $data = DB::table('referensi')
            ->select('referensi.id', 'referensi.deskripsi', DB::raw('COUNT(users.id) as total'))
            ->leftJoin('users', 'users.ref_profesi', '=', 'referensi.id')
            ->where('referensi.ref_jenis', 11)
            ->whereNull('users.deleted_at')
            ->groupBy('referensi.id', 'referensi.deskripsi')
            ->get();

        $belumMasuk = DB::table('users')
            ->whereNull('ref_profesi')
            ->whereNull('deleted_at')
            ->count();

        return response()->json([
            'refid' => $data->pluck('id'),
            'labels' => $data->pluck('deskripsi'),
            'series' => $data->pluck('total'),
            'belumMasuk' => $belumMasuk,
        ]);
    }

    public function grafik2() // Jenis Kelamin
    {
        $data = DB::table('users')
            ->select('jns_kelamin', DB::raw('COUNT(id) as total'))
            ->whereNull('deleted_at')
            ->groupBy('jns_kelamin')
            ->get();

        $labels = [];
        $series = [];
        $refid  = [];

        foreach ($data as $row) {
            $label = $row->jns_kelamin ?: 'BELUM DIISI';
            $labels[] = $label;
            $series[] = $row->total;
            $refid[]  = $row->jns_kelamin ?: 0;
        }

        $belumMasuk = DB::table('users')->whereNull('jns_kelamin')->whereNull('deleted_at')->count();

        return response()->json([
            'refid' => $refid,
            'labels' => $labels,
            'series' => $series,
            'belumMasuk' => $belumMasuk,
        ]);
    }

    public function grafik3()
    {
        $data = DB::table('users')
            ->select(DB::raw("
                CASE
                    WHEN (users.s3 IS NOT NULL AND users.s3 <> '') OR (users.th_s3 IS NOT NULL AND users.th_s3 <> '') THEN 'S3'
                    WHEN (users.s2 IS NOT NULL AND users.s2 <> '') OR (users.th_s2 IS NOT NULL AND users.th_s2 <> '') THEN 'S2'
                    WHEN (users.s1_profesi IS NOT NULL AND users.s1_profesi <> '') OR (users.th_s1_profesi IS NOT NULL AND users.th_s1_profesi <> '') THEN 'S1 Profesi'
                    WHEN (users.s1 IS NOT NULL AND users.s1 <> '') OR (users.th_s1 IS NOT NULL AND users.th_s1 <> '') THEN 'S1'
                    WHEN (users.d4 IS NOT NULL AND users.d4 <> '') OR (users.th_d4 IS NOT NULL AND users.th_d4 <> '') THEN 'D4'
                    WHEN (users.d3 IS NOT NULL AND users.d3 <> '') OR (users.th_d3 IS NOT NULL AND users.th_d3 <> '') THEN 'D3'
                    WHEN (users.d2 IS NOT NULL AND users.d2 <> '') OR (users.th_d2 IS NOT NULL AND users.th_d2 <> '') THEN 'D2'
                    WHEN (users.d1 IS NOT NULL AND users.d1 <> '') OR (users.th_d1 IS NOT NULL AND users.th_d1 <> '') THEN 'D1'
                    WHEN (users.sma IS NOT NULL AND users.sma <> '') OR (users.th_sma IS NOT NULL AND users.th_sma <> '') THEN 'SMA'
                    WHEN (users.smp IS NOT NULL AND users.smp <> '') OR (users.th_smp IS NOT NULL AND users.th_smp <> '') THEN 'SMP'
                    WHEN (users.sd IS NOT NULL AND users.sd <> '') OR (users.th_sd IS NOT NULL AND users.th_sd <> '') THEN 'SD'
                    ELSE 'Belum Terisi'
                END as pendidikan,
                COUNT(*) as total
            "))
            ->whereNull('users.deleted_at')
            ->groupBy('pendidikan')
            ->orderByRaw("FIELD(pendidikan, 'SD','SMP','SMA','D1','D2','D3','D4','S1','S1 Profesi','S2','S3','Belum Terisi')")
            ->get();

        $labels = $data->pluck('pendidikan');
        $series = $data->pluck('total');

        // hitung khusus untuk "Belum Terisi"
        $belumMasuk = DB::table('users')
            ->whereNull('deleted_at')
            ->where(function($q) {
                $q->where(function($sub) {
                    $sub->whereNull('s3')->orWhere('s3','');
                })->where(function($sub) {
                    $sub->whereNull('th_s3')->orWhere('th_s3','');
                })
                ->where(function($sub) {
                    $sub->whereNull('s2')->orWhere('s2','');
                })->where(function($sub) {
                    $sub->whereNull('th_s2')->orWhere('th_s2','');
                })
                ->where(function($sub) {
                    $sub->whereNull('s1_profesi')->orWhere('s1_profesi','');
                })->where(function($sub) {
                    $sub->whereNull('th_s1_profesi')->orWhere('th_s1_profesi','');
                })
                ->where(function($sub) {
                    $sub->whereNull('s1')->orWhere('s1','');
                })->where(function($sub) {
                    $sub->whereNull('th_s1')->orWhere('th_s1','');
                })
                ->where(function($sub) {
                    $sub->whereNull('d4')->orWhere('d4','');
                })->where(function($sub) {
                    $sub->whereNull('th_d4')->orWhere('th_d4','');
                })
                ->where(function($sub) {
                    $sub->whereNull('d3')->orWhere('d3','');
                })->where(function($sub) {
                    $sub->whereNull('th_d3')->orWhere('th_d3','');
                })
                ->where(function($sub) {
                    $sub->whereNull('d2')->orWhere('d2','');
                })->where(function($sub) {
                    $sub->whereNull('th_d2')->orWhere('th_d2','');
                })
                ->where(function($sub) {
                    $sub->whereNull('d1')->orWhere('d1','');
                })->where(function($sub) {
                    $sub->whereNull('th_d1')->orWhere('th_d1','');
                })
                ->where(function($sub) {
                    $sub->whereNull('sma')->orWhere('sma','');
                })->where(function($sub) {
                    $sub->whereNull('th_sma')->orWhere('th_sma','');
                })
                ->where(function($sub) {
                    $sub->whereNull('smp')->orWhere('smp','');
                })->where(function($sub) {
                    $sub->whereNull('th_smp')->orWhere('th_smp','');
                })
                ->where(function($sub) {
                    $sub->whereNull('sd')->orWhere('sd','');
                })->where(function($sub) {
                    $sub->whereNull('th_sd')->orWhere('th_sd','');
                });
            })
            ->count();

        return response()->json([
            'refid' => $labels,
            'labels' => $labels,
            'series' => $series,
            'belumMasuk' => $belumMasuk
        ]);
    }

    public function grafik4()
    {
        $data = DB::table('referensi')
            ->select(
                DB::raw("
                    CASE
                        WHEN referensi.deskripsi LIKE 'Kepala Bagian%' THEN 'Kepala Bagian'
                        WHEN referensi.deskripsi LIKE 'Kepala Sub Bagian%' THEN 'Kepala Sub Bagian'
                        WHEN referensi.deskripsi LIKE 'Koordinator%' THEN 'Koordinator'
                        WHEN referensi.deskripsi LIKE 'Sekretaris Direktur%' THEN 'Sekretaris Direktur'
                        WHEN referensi.deskripsi LIKE 'Direktur%' THEN 'Direksi'
                        WHEN referensi.deskripsi LIKE 'Manajer Pelayanan%' THEN 'Manajer Pelayanan'
                        WHEN referensi.deskripsi LIKE 'Manajer Penunjang%' THEN 'Manajer Penunjang'
                        WHEN referensi.deskripsi LIKE 'Kepala Ruang%' THEN 'Kepala Ruang'
                        WHEN referensi.deskripsi IN ('Dokter','Dokter Umum','Dokter Spesialis') THEN 'Dokter'
                        WHEN referensi.deskripsi IN ('PPI','Tim PMKP','Tim Asuransi','SPI','Ketua Tim Asuransi') THEN 'TIM'
                        WHEN referensi.deskripsi LIKE 'Staff%' THEN 'Staf'
                        ELSE referensi.deskripsi
                    END as kategori,
                    GROUP_CONCAT(DISTINCT(referensi.id)) as refid,
                    COUNT(users.id) as total
                ")
            )
            ->leftJoin('users', 'users.ref_subprofesi', '=', 'referensi.id')
            ->where('referensi.ref_jenis', 14)
            ->whereNull('users.deleted_at')
            ->groupBy('kategori')
            ->orderBy('kategori')
            ->get();

        $belumMasuk = DB::table('users')
            ->whereNull('ref_subprofesi')
            ->whereNull('deleted_at')
            ->count();

        return response()->json([
            'refid' => $data->pluck('refid'),
            'labels' => $data->pluck('kategori'),
            'series' => $data->pluck('total'),
            'belumMasuk' => $belumMasuk,
        ]);
    }

    function grafik5()
    {
        $data = DB::table('referensi')
            ->select(
                'referensi.id',
                'referensi.deskripsi',
                DB::raw('COUNT(users.id) as total')
            )
            ->leftJoin('users_status', function($join) {
                $join->on('referensi.id', '=', 'users_status.ref_id')
                        ->where('users_status.status', 1)
                        ->where('users_status.deleted_at',null);
            })
            ->leftJoin('users','users_status.pegawai_id', '=', 'users.id')
            // ->leftJoin('users', function($join) {
            //     $join->on('users_status.pegawai_id', '=', 'users.id')
            //             ->where('users.status', null)
            //             ->where('users.deleted_at',null);
            // })
            ->where('referensi.ref_jenis', 10)
            ->groupBy('referensi.id', 'referensi.deskripsi')
            ->get();

        $belumMasuk = DB::table('users')
            ->leftJoin('users_status', function($join) {
                $join->on('users.id', '=', 'users_status.pegawai_id')
                    ->where('users_status.status', 1)
                    ->whereNull('users_status.deleted_at');
            })
            ->whereNull('users_status.id') // belum ada di users_status
            ->whereNull('users.deleted_at') // user aktif
            ->count('users.id');

        // Format agar mudah dipakai ApexCharts
        $refid = $data->pluck('id');
        $labels = $data->pluck('deskripsi');
        $series = $data->pluck('total');

        return response()->json([
            'refid' => $refid,
            'labels' => $labels,
            'series' => $series,
            'belumMasuk' => $belumMasuk,
        ]);
    }

    public function grafik6() // Status Perkawinan
    {
        $data = DB::table('users')
            ->select('status_kawin', DB::raw('COUNT(id) as total'))
            ->whereNull('deleted_at')
            ->groupBy('status_kawin')
            ->get();

        $labels = [];
        $series = [];
        $refid  = [];

        foreach ($data as $row) {
            $label = $row->status_kawin ?: 'BELUM DIISI';
            $labels[] = $label;
            $series[] = $row->total;
            $refid[]  = $row->status_kawin ?: 0;
        }

        $belumMasuk = DB::table('users')->whereNull('status_kawin')->whereNull('deleted_at')->count();

        return response()->json([
            'refid' => $refid,
            'labels' => $labels,
            'series' => $series,
            'belumMasuk' => $belumMasuk,
        ]);
    }
}
