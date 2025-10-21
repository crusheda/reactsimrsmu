<?php

namespace App\Http\Controllers\Kepegawaian;

use App\Http\Controllers\Controller;
use App\Models\referensi;
use App\Models\datalogs;
use App\Models\users;
use App\Models\users_foto;
use App\Models\kepegawaian\jadwal;
use App\Models\kepegawaian\jadwal_detail;
use App\Models\kepegawaian\ref_jadwal_shift;
use App\Models\kepegawaian\ref_jadwal_users;
use App\Models\kepegawaian\ref_jadwal_jabatan;
use App\Models\kepegawaian\ref_jadwal_ln;
use App\Models\struktur_organisasi;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth, DB;
use Validator,Redirect,Response,File,Storage;

class JadwalController extends Controller
{
    function index()
    {
        if (Auth::user()->getPermission('admin_kepegawaian') == true) {
            return view('pages.kepegawaian.jadwal.index-admin');
        } else {
            $users  = users::where('nik','!=',null)->where('nama','!=',null)->orderBy('nama', 'asc')->get();
            $data = [
                // 'show' => $show,
                'users' => $users,
            ];
            return view('pages.kepegawaian.jadwal.index-user')->with('list', $data);
        }
    }

    function cetak($id)
    {
        $data = [
            // 'show' => $show,
            'id' => $id,
        ];
        return view('pages.kepegawaian.jadwal.cetak')->with('list', $data);
    }

    function indexBawahan()
    {
        $jabatan = struktur_organisasi::where('id_user',Auth::user()->id)->orderBy('updated_at','desc')->first();
        if ($jabatan) {
            $users  = users::where('nik','!=',null)->where('nama','!=',null)->orderBy('nama', 'asc')->get();
            $data = [
                // 'show' => $show,
                'users' => $users,
            ];
            return view('pages.kepegawaian.jadwal.index-bawahan')->with('list', $data);
        } else {
            return redirect()->back()->withErrors("Pengguna tidak memiliki akses verifikasi / tidak mempunyai bawahan");
        }
    }

    function indexShift()
    {
        $pegawai = Auth::user()->id; // misal: 232
        $pegawai = Auth::user()->id; // misal: 232

        $show = DB::table('referensi_jadwal_users')
            ->whereJsonContains('staf', (string) $pegawai)
            ->whereNull('deleted_at')
            ->first();

        $data = [
            'show' => $show,
        ];
        return view('pages.kepegawaian.jadwal.ref.shift')->with('list', $data);
    }

    function indexStaf()
    {
        $pegawai = Auth::user()->id; // misal: 232
        $users  = users::where('nik','!=',null)->where('nama','!=',null)->orderBy('nama', 'asc')->get();
        $cekUser = DB::table('referensi_jadwal_users')
                    ->whereJsonContains('staf', (string) $pegawai)
                    ->whereNull('deleted_at')
                    ->first();
        if ($cekUser) {
            $show = ref_jadwal_users::join('users','users.id','=','referensi_jadwal_users.pegawai_id')
                        ->select('referensi_jadwal_users.*','users.nama as nama_user')
                        ->where('referensi_jadwal_users.pegawai_id',$cekUser->pegawai_id)
                        ->first();
        } else {
            $show = null;
        }

        $data = [
            'show' => $show,
            'users' => $users,
        ];
        return view('pages.kepegawaian.jadwal.ref.staf')->with('list', $data);
    }

    function indexLN()
    {
        if (Auth::user()->getPermission('admin_kepegawaian') == true) {
            return view('pages.kepegawaian.jadwal.ref.ln');
        } else {
            return redirect()->back()->withErrors("Pengguna tidak memiliki akses menuju halaman Referensi Libur Nasional");
        }
        // $users  = users::where('nik','!=',null)->where('nama','!=',null)->orderBy('nama', 'asc')->get();
        // $show = ref_jadwal_ln::get();

        // $data = [
        //     'show' => $show,
        //     'users' => $users,
        // ];

        // return view('pages.kepegawaian.jadwal.ref.staf')->with('list', $data);
    }

    function formTambah($id)
    {
        $pegawai = Auth::user()->id; // misal: 232

        // Langkah 1: Cari pegawai induk (pegawai_id) dari referensi_jadwal_users yang memiliki pegawai ini di kolom staf
        $ref_users = DB::table('referensi_jadwal_users')
            ->whereJsonContains('staf', (string) $pegawai)
            ->whereNull('deleted_at')
            ->first();

        $ref_shift = DB::table('referensi_jadwal_shift')
            ->whereIn('pegawai_id',[$pegawai,$ref_users->pegawai_id])
            ->whereNull('deleted_at')
            ->get();

        $users  = users::where('nik','!=',null)->where('nama','!=',null)->orderBy('nama', 'asc')->get();

        $jadwal  = jadwal::join('users','users.id','=','kepegawaian_jadwal.pegawai_id')
                            ->select('users.nama','users.name','kepegawaian_jadwal.*')
                            ->where('kepegawaian_jadwal.id',$id)
                            ->whereNull('kepegawaian_jadwal.deleted_at')
                            ->orderBy('kepegawaian_jadwal.created_at','DESC')
                            ->first();

        if (!empty($jadwal)) {
            $jadwal_detail = jadwal_detail::where('id_jadwal',$id)->whereNull('deleted_at')->orderBy('created_at','DESC')->first();
            if ($jadwal_detail) {
                return redirect()->route('kepegawaian.jadwaldinas.index')->withErrors('Jadwal Dinas sudah terisi, silakan mengubah/melengkapi Jadwal!');
            } else {
                $ref_ln = ref_jadwal_ln::where('tahun', (int) $jadwal->tahun)
                    ->where('bulan', (int) $jadwal->bulan)
                    ->whereNull('deleted_at')
                    ->orderBy('tgl','ASC')
                    ->get();
                $ref_jabatan = ref_jadwal_jabatan::whereIn('pegawai_id',[$pegawai,$ref_users->pegawai_id])
                                                    ->whereNull('deleted_at')
                                                    ->orderBy('urutan','ASC')
                                                    ->get();
                $jml_tgl = Carbon::create($jadwal->tahun, $jadwal->bulan)->format('t');

                if ($jadwal->staf != $ref_users->staf) {
                    $jadwal->staf = $ref_users->staf;
                    $jadwal->save();

                    // REINITIATE
                    $jadwal  = jadwal::join('users','users.id','=','kepegawaian_jadwal.pegawai_id')
                                        ->select('users.nama','users.name','kepegawaian_jadwal.*')
                                        ->where('kepegawaian_jadwal.id',$id)
                                        ->whereNull('kepegawaian_jadwal.deleted_at')
                                        ->first();
                }

                $data = [
                    // 'show' => $show,
                    'jadwal' => $jadwal,
                    'ref_shift' => $ref_shift,
                    'ref_users' => $ref_users,
                    'ref_jabatan' => $ref_jabatan,
                    'ref_ln' => $ref_ln,
                    'users' => $users,
                    'jml_tgl' => $jml_tgl,
                ];

                return view('pages.kepegawaian.jadwal.user.tambah')->with('list', $data);
            }
        } else {
            return redirect()->back()->withErrors('Akses Jadwal tidak disetujui!');
        }
    }

    function formUbah($id)
    {
        $pegawai = Auth::user()->id; // misal: 232

        // Langkah 1: Cari pegawai induk (pegawai_id) dari referensi_jadwal_users yang memiliki pegawai ini di kolom staf
        $ref_users = DB::table('referensi_jadwal_users')
            ->whereJsonContains('staf', (string) $pegawai)
            ->whereNull('deleted_at')
            ->first();

        $ref_shift = DB::table('referensi_jadwal_shift')
            ->whereIn('pegawai_id',[$pegawai,$ref_users->pegawai_id])
            ->whereNull('deleted_at')
            ->get();

        $jadwal  = jadwal::leftJoin('users','users.id','=','kepegawaian_jadwal.pegawai_id')
                            ->select('users.nama','users.name','kepegawaian_jadwal.*')
                            ->where('kepegawaian_jadwal.id',$id)
                            ->whereNull('kepegawaian_jadwal.deleted_at')
                            ->orderBy('kepegawaian_jadwal.created_at','DESC')
                            ->first();

        if (!empty($jadwal)) {
            if ($jadwal->progress == 0 || $jadwal->progress == 3) {
                if ($jadwal->progress == 0) {
                    $status = 'Ditolak';
                } else {
                    $status = 'Divalidasi';
                }

                return Redirect::back()->withErrors(['msg' => 'Mohon maaf, status Jadwal Dinas Anda telah '.$status]);
            } else {
                $ref_ln = ref_jadwal_ln::where('tahun', (int) $jadwal->tahun)
                    ->where('bulan', (int) $jadwal->bulan)
                    ->whereNull('deleted_at')
                    ->orderBy('tgl','ASC')
                    ->get();
                $ref_jabatan = ref_jadwal_jabatan::leftJoin('users','users.id','=','referensi_jadwal_users_jabatan.id_staf')
                                                ->select('referensi_jadwal_users_jabatan.*','users.name as name_staf','users.nick as panggilan_staf','users.nama as nama_staf')
                                                ->whereIn('referensi_jadwal_users_jabatan.pegawai_id',[$pegawai,$ref_users->pegawai_id])
                                                ->whereNull('referensi_jadwal_users_jabatan.deleted_at')
                                                ->orderBy('referensi_jadwal_users_jabatan.urutan','ASC')
                                                ->get();

                // if ($jadwal->staf != $ref_users->staf) {
                //     $jadwal->staf = $ref_users->staf;
                //     $jadwal->save();

                //     // REINITIATE
                //     $jadwal  = jadwal::join('users','users.id','=','kepegawaian_jadwal.pegawai_id')
                //                         ->select('users.nama','users.name','kepegawaian_jadwal.*')
                //                         ->where('kepegawaian_jadwal.id',$id)
                //                         ->whereNull('kepegawaian_jadwal.deleted_at')
                //                         ->orderBy('kepegawaian_jadwal.created_at','DESC')
                //                         ->first();
                // }

                $users  = users::where('nik','!=',null)->where('nama','!=',null)->orderBy('nama', 'asc')->get();
                $detail = jadwal_detail::join('users','users.id','=','kepegawaian_jadwal_detail.pegawai_id')
                            ->where('kepegawaian_jadwal_detail.id_jadwal',$id)
                            ->select('kepegawaian_jadwal_detail.*','users.nama as nama_pegawai','users.nick','users.name')
                            ->orderBy('kepegawaian_jadwal_detail.id','asc')
                            ->get();
                $jml_tgl = Carbon::create($jadwal->tahun, $jadwal->bulan)->format('t');

                $data = [
                    // 'show' => $show,
                    'jadwal' => $jadwal,
                    'detail' => $detail,
                    'ref_shift' => $ref_shift,
                    'ref_users' => $ref_users,
                    'ref_jabatan' => $ref_jabatan,
                    'ref_ln' => $ref_ln,
                    'users' => $users,
                    'jml_tgl' => $jml_tgl,
                ];

                // print_r($ref_jabatan->);
                // die();
                return view('pages.kepegawaian.jadwal.user.ubah')->with('list', $data);
            }
        } else {
            return redirect()->back()->withErrors('Akses Jadwal tidak disetujui!');
        }
    }

    // function prosesSimpan(Request $request) // TIDAK DIPAKAI (HANYA UNTUK BACKUP)
    // {
    //     $tgl = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');
    //     $getJadwal = jadwal::where('id',$request->id_jadwal)->first();
    //     $totalDay = Carbon::create($getJadwal->tahun, $getJadwal->bulan)->format('t');

    //     for ($i=0; $i < count($request->id_staf) ; $i++) {
    //         $data = new jadwal_detail;
    //         $data->id_jadwal = $request->id_jadwal;
    //         $data->pegawai_id = $request->id_staf[$i];
    //         $data->pegawai_nama = $request->nama_staf[$i];
    //         $data->jabatan = $request->jabatan_staf[$i];
    //         $data->color = $request->color_staf[$i];
    //         for ($t = 1; $t <= $totalDay; $t++) {
    //             $hit = 'tgl'.$t;
    //             if ($request->$hit[$i]) {
    //                 $data->$hit = strtoupper($request->$hit[$i]);
    //             } else {
    //                 $data->$hit = null;
    //             }
    //         }
    //         $data->save();
    //     }

    //     return redirect()->route('kepegawaian.jadwaldinas.index')->with('message','Jadwal Dinas Karyawan berhasil disimpan pada '.$tgl);
    // }

    function prosesTambah(Request $request)
    {
        $tgl = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');
        $getJadwal = jadwal::where('id',$request->id_jadwal)->first();
        $totalDay = Carbon::create($getJadwal->tahun, $getJadwal->bulan)->format('t');

        if (empty($request->id_staf)) {
            return redirect()->back()->with('error', 'Tidak ada staf yang dipilih, silakan isi jadwal terlebih dahulu.');
        }

        for ($i=0; $i < count($request->id_staf) ; $i++) {
            $data = new jadwal_detail;
            $data->id_jadwal = $request->id_jadwal;
            $data->pegawai_id = $request->id_staf[$i];
            $data->pegawai_nama = $request->nama_staf[$i];
            $data->jabatan = $request->jabatan_staf[$i];
            $data->color = $request->color_staf[$i];
            for ($t = 1; $t <= $totalDay; $t++) {
                $hit = 'tgl'.$t;
                if ($request->$hit[$i]) {
                    $data->$hit = strtoupper($request->$hit[$i]);
                } else {
                    $data->$hit = null;
                }
            }
            $data->save();
        }

        datalogs::record($getJadwal->pegawai_id, 'Baru saja melakukan penambahan Jadwal Dinas Pegawai Bulan '.$getJadwal->bulan.' Tahun '.$getJadwal->tahun, $getJadwal->staf, null, $getJadwal, '["kepala-sumber-daya-insani","staf-sumber-daya-insani"]');

        return redirect()->route('kepegawaian.jadwaldinas.index')->with('message','Jadwal Dinas Karyawan berhasil disimpan/diajukan pada '.$tgl);
    }

    function prosesUbah(Request $request)
    {
        $tgl = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');
        $getJadwal = jadwal::where('id',$request->id_jadwal)->first();
        $totalDay = Carbon::create($getJadwal->tahun, $getJadwal->bulan)->format('t');
        $getData = jadwal_detail::where('id_jadwal',$request->id_jadwal)
                                ->whereIn('pegawai_id', $request->id_staf)
                                ->get()
                                ->keyBy('pegawai_id');
        // $data = jadwal_detail::where('id_jadwal',$request->id_jadwal)->get();
        // $data = $getData;
        // print_r($getData.'<br><br><br>');
        // print_r($data.'<br><br><br>');
        // for ($i=0; $i < count($getData) ; $i++) {
        // if (count($getData) !== count($request->id_staf)) {
        //     dd("Mismatch: DB punya ".count($getData)." record, request punya ".count($request->id_staf)." record");
        // }
        // for ($i=0; $i < count($request->id_staf) ; $i++) {
        foreach ($request->id_staf as $idx => $pegawaiId) {
        // print_r($request->nama_staf[$idx].' - '.$pegawaiId.'<br>');
            $row = $getData[$pegawaiId] ?? null;
            if (!$row) continue;
            for ($t = 1; $t <= $totalDay; $t++) {
                $hit = "tgl{$t}";
                $value = $request->$hit[$idx] ?? null;
                $row->$hit = $value ? strtoupper($value) : null;
                // if ($request->$hit[$i]) {
                //     $data[$i]->$hit = strtoupper($request->$hit[$i]);
                // } else {
                //     $data[$i]->$hit = null;
                // }
                // if (isset($request->$hit[$i])) {
                //     echo "$i - {$request->$hit[$i]} - $hit <br>";
                // } else {
                //     echo "$i - (kosong) - $hit <br>";
                // }
                // print_r($idx.' - '.$row->$hit.' - '.$hit.'<br>');
            }
            $row->save();
        }
        // die();

        datalogs::record($getJadwal->pegawai_id, 'Baru saja melakukan perubahan Jadwal Dinas Pegawai Bulan '.$getJadwal->bulan.' Tahun '.$getJadwal->tahun, $getJadwal->staf, null, $getJadwal, '["kepala-sumber-daya-insani","staf-sumber-daya-insani"]');

        return redirect()->route('kepegawaian.jadwaldinas.index')->with('message','Perubahan Jadwal Dinas Karyawan berhasil dilakukan pada '.$tgl);
        // return Redirect::route()->with('message','Perubahan Jadwal Dinas Karyawan berhasil dilakukan pada '.$tgl);
    }

    // AJAX JSON ---------------------------------------------------------------------------------------------
    function dokumentasiAbsensi()
    {
        $path = public_path().'/doc/dokumentasi_e-absensi.pdf';
        return response()->file($path,[
            'Content-Type' => 'application/pdf',
        ]);
    }

    function downloadDokumentasiAbsensi()
    {
        $path = public_path('doc/dokumentasi_e-absensi.pdf');

        return response()->download($path, 'Dokumentasi E-Absensi Versi 3.1.0.pdf');
    }

    function storePengajuan(Request $request)
    {
        $pegawai = $request->pegawai; // misal: 232

        // Langkah 1: Cari pegawai induk (pegawai_id) dari referensi_jadwal_users yang memiliki pegawai ini di kolom staf
        $users = DB::table('referensi_jadwal_users')
            ->whereJsonContains('staf', (string) $pegawai)
            ->whereNull('deleted_at')
            ->first();

        if ($users) {
            // Langkah 2: Ambil semua shift dari pegawai_id tersebut
            $shift = DB::table('referensi_jadwal_shift')
                ->whereIn('pegawai_id',[$request->pegawai,$users->pegawai_id])
                ->whereNull('deleted_at')
                ->first();

            if (!$shift) { // Tidak ada shift ditemukan untuk pegawai_id tersebut
                return Response::json(array(
                    'message' => 'Data Shift tidak ditemukan. Silakan melengkapi Referensi Jaga Shift!',
                    'code' => 400,
                ));
            }
        } else {
            // $shift = collect(); // kosong
            return Response::json(array(
                'message' => 'Data Anda tidak ditemukan pada Referensi Staf. Silakan melengkapi data Referensi Staf terlebih dahulu!',
                'code' => 400,
            ));
        }

        // Get Reference
        $now = Carbon::now();
        // Init
        $tgl = $now->isoFormat('DD');
        $bulan = Carbon::parse($request->tgl)->isoFormat('MM');
        $tahun = Carbon::parse($request->tgl)->isoFormat('YYYY');
        // $getData = jadwal::where('pegawai_id',$request->pegawai)->whereIn('progress',[1,2,3])->orderBy('updated_at','desc')->first();
        $getData = jadwal::where('bulan',$bulan)
                            ->where('tahun',$tahun)
                            ->whereIn('progress',[1,2,3])
                            ->whereIn('pegawai_id',[$request->pegawai,$users->pegawai_id])
                            ->whereNull('deleted_at')
                            ->orderBy('updated_at','desc')
                            ->first();
        // $submonth = $now->subMonth()->isoFormat('YYYY-MM');
        $thisDate = $now->isoFormat('YYYY-MM-DD');
        $setDate = Carbon::parse($tahun.'-'.$bulan.'-27')->isoFormat('YYYY-MM-DD');

        if ($thisDate <= $setDate) { // JIKA PENGAJUAN MELEBIHI TGL 27 PADA BULAN/TAHUN YANG DIPILIH
            if ($getData != null) { // JIKA ADA PENGAJUAN YANG MASIH DALAM PROSES (PENDING/VERIFIKASI/VALIDASI)
                if ($getData->progress == 1) {
                    return Response::json(array(
                        'message' => 'Masih terdapat proses pengajuan Jadwal Dinas yang berstatus <b>PENDING</b>, silakan konfirmasi Atasan Langsung atau hapus pengajuan sebelumnya <b>BILA PERLU</b>! ',
                        'code' => 400,
                    ));
                } else {
                    if ($getData->progress == 2) {
                        return Response::json(array(
                            'message' => 'Masih terdapat proses pengajuan Jadwal Dinas yang berstatus <b>DIVERIFIKASI</b>, silakan konfirmasi Bagian Kepegawaian untuk proses <b>VALIDASI</b> Jadwal selanjutnya! ',
                            'code' => 400,
                        ));
                    } else {
                        return Response::json(array(
                            'message' => 'Penambahan Jadwal Dinas <b>GAGAL</b> dilakukan karena jadwal pada Bulan dan Tahun yang dipilih <b><u>SUDAH ADA</u></b>! ',
                            'code' => 400,
                        ));
                    }
                }
            } else {
                $data = new jadwal;
                $data->pegawai_id = $request->pegawai;
                $data->staf = $users->staf;
                $data->unit = $users->unit;
                $data->bulan = $bulan;
                $data->tahun = $tahun;
                $data->keterangan = $request->keterangan;
                $data->progress = 1;
                $data->save();

                $getData = jadwal::where('progress',1)->whereIn('pegawai_id',[$request->pegawai,$users->pegawai_id])->orderBy('updated_at','desc')->whereNull('deleted_at')->first();
                datalogs::record($request->pegawai, 'Baru saja mengajukan penambahan Jadwal Dinas Pegawai Bulan '.$bulan.' Tahun '.$tahun, $getData->staf, null, $data, '["kepala-sumber-daya-insani","staf-sumber-daya-insani"]');
                return Response::json(array(
                    'message' => $getData,
                    'code' => 200,
                ));
            }
        } else {
            return Response::json(array(
                'message' => 'Pengajuan Jadwal Dinas maksimal tanggal 27 setiap bulannya dan tidak diperkenankan menambah jadwal pada Bulan/Tahun Sebelumnya. Silakan pilih Bulan dan Tahun lainnya!',
                'code' => 400,
            ));
        }
    }

    // function cekShift($id,$user)
    // {
    //     if ($id == 'L' || $id == 'C' || $id == 'CM' || $id == 'CU' || $id == 'CH' || $id == 'CD') {
    //         return Response::json(array(
    //             'message' => $id,
    //             'code' => 200,
    //         ));
    //     } else {
    //         $ref_users = DB::table('referensi_jadwal_users')
    //                             ->whereJsonContains('staf', (string) $user)
    //                             ->whereNull('deleted_at')
    //                             ->first();
    //         $ref_shift = ref_jadwal_shift::where('singkat',$id)
    //                                         ->whereIn('pegawai_id',[$user,$ref_users->pegawai_id])
    //                                         // ->where('pegawai_id',$user)
    //                                         ->first();

    //         if (empty($ref_shift)) {
    //             return Response::json(array(
    //                 'message' => 'Shift Tidak Ditemukan',
    //                 'code' => 500,
    //             ));
    //         } else {
    //             return Response::json(array(
    //                 'message' => $ref_shift,
    //                 'code' => 200,
    //             ));
    //         }
    //     }
    // }

    function getShift($id,$user)
    {
        $ref_users = DB::table('referensi_jadwal_users')
                            ->whereJsonContains('staf', (string) $user)
                            ->whereNull('deleted_at')
                            ->first();
        $shift = ref_jadwal_shift::whereIn('pegawai_id',[$user,$ref_users->pegawai_id])->get();
        $jadwal = jadwal::join('users','users.id','=','kepegawaian_jadwal.pegawai_id')
                ->select('kepegawaian_jadwal.*','users.nama as nama_pegawai')
                ->where('kepegawaian_jadwal.id',$id)
                ->first();
        $detail = jadwal_detail::join('users','users.id','=','kepegawaian_jadwal_detail.pegawai_id')
                ->select('kepegawaian_jadwal_detail.*','users.nama as nama_pegawai')
                ->where('kepegawaian_jadwal_detail.id_jadwal',$id)
                ->orderBy('kepegawaian_jadwal_detail.id','ASC')
                ->get();
        $staf = ref_jadwal_jabatan::join('users','users.id','=','referensi_jadwal_users_jabatan.id_staf')
                ->select('referensi_jadwal_users_jabatan.*','users.nama as nama_pegawai')
                ->whereIn('referensi_jadwal_users_jabatan.pegawai_id',[$user,$ref_users->pegawai_id])
                ->whereNull('referensi_jadwal_users_jabatan.deleted_at')
                ->orderBy('referensi_jadwal_users_jabatan.urutan','ASC')
                ->get();
        $users  = users::where('nik','!=',null)->where('nama','!=',null)->orderBy('nama', 'asc')->get();
        $totalDay = Carbon::create($jadwal->tahun, $jadwal->bulan)->format('t');

        for($i = 0; $i < count($shift); $i++)
        {
            $shiftArr[] = $shift[$i]->singkat;
        }

        // print_r($shiftArr);
        // die();

        $data = [
            'users' => $users,
            'shift' => $shift,
            'shiftArr' => $shiftArr,
            'staf' => $staf,
            'jadwal' => $jadwal,
            'detail' => $detail,
            'totalDay' => $totalDay,
        ];

        return response()->json($data, 200);
    }

    // TAMPIL JADWAL
    function jadwal($id)
    {
        $detail = jadwal_detail::where('id_jadwal',$id)
                ->orderBy('id','ASC')
                ->get();

        $jadwal  = jadwal::join('users','users.id','=','kepegawaian_jadwal.pegawai_id')
                ->select('kepegawaian_jadwal.*','users.nama as nama_pegawai')
                ->where('kepegawaian_jadwal.id',$id)
                ->whereNull('kepegawaian_jadwal.deleted_at')
                ->first();

        // SHIFT & STAF & JABATAN
            // Ambil pegawai_id referensi dari staf JSON
            $pegawaiUtama = DB::table('referensi_jadwal_users')
                ->join('kepegawaian_jadwal', function ($join) {
                    $join->on(DB::raw('JSON_CONTAINS(referensi_jadwal_users.staf, JSON_QUOTE(CAST(kepegawaian_jadwal.pegawai_id AS CHAR)))'), '=', DB::raw('1'));
                })
                ->where('kepegawaian_jadwal.id', $id)
                ->whereNull('referensi_jadwal_users.deleted_at')
                ->select('referensi_jadwal_users.pegawai_id')
                ->first();

            // Gunakan pegawai_id dari staf jika ketemu, kalau tidak fallback ke pegawai_id asli
            $pegawaiId = $pegawaiUtama->pegawai_id ?? DB::table('kepegawaian_jadwal')->where('id', $id)->value('pegawai_id');

            // Ambil libur nasional
            $ln = ref_jadwal_ln::where('tahun', (int) $jadwal->tahun)
                ->where('bulan', (int) $jadwal->bulan)
                ->whereNull('deleted_at')
                ->orderBy('tgl','ASC')
                ->get();
            // Ambil shift
            $shift = DB::table('referensi_jadwal_shift')
                ->where('pegawai_id', $pegawaiId)
                ->whereNull('deleted_at')
                ->get();
            $jabatan = DB::table('referensi_jadwal_users_jabatan')
                ->where('pegawai_id', $pegawaiId)
                ->whereNull('deleted_at')
                ->orderBy('urutan','ASC')
                ->get();
            $staf = DB::table('referensi_jadwal_users')
                ->where('pegawai_id', $pegawaiId)
                ->whereNull('deleted_at')
                ->first();

        // $shift  = ref_jadwal_shift::join('kepegawaian_jadwal','kepegawaian_jadwal.pegawai_id','=','referensi_jadwal_shift.pegawai_id')
        //         ->select('referensi_jadwal_shift.*')
        //         ->where('kepegawaian_jadwal.id',$id)
        //         ->where('referensi_jadwal_shift.deleted_at',null)
        //         ->get();
        // $staf = ref_jadwal_users::join('kepegawaian_jadwal','kepegawaian_jadwal.pegawai_id','=','referensi_jadwal_users.pegawai_id')
        //         ->select('referensi_jadwal_users.*')
        //         ->where('kepegawaian_jadwal.id',$id)
        //         ->where('referensi_jadwal_users.deleted_at',null)
        //         ->first();

        // STAF
        // $staf = DB::table('referensi_jadwal_users')
        //         ->join('kepegawaian_jadwal', function ($join) {
        //             $join->on('kepegawaian_jadwal.pegawai_id', '=', 'referensi_jadwal_users.pegawai_id')
        //                 ->orWhereRaw('JSON_CONTAINS(referensi_jadwal_users.staf, JSON_QUOTE(CAST(kepegawaian_jadwal.pegawai_id AS CHAR)))');
        //         })
        //         ->select('referensi_jadwal_users.*')
        //         ->where('kepegawaian_jadwal.id', $id)
        //         ->whereNull('referensi_jadwal_users.deleted_at')
        //         ->first();

        // $jabatan = ref_jadwal_jabatan::join('kepegawaian_jadwal','kepegawaian_jadwal.pegawai_id','=','referensi_jadwal_users_jabatan.pegawai_id')
        //         ->select('referensi_jadwal_users_jabatan.*')
        //         ->where('referensi_jadwal_users_jabatan.deleted_at',null)
        //         ->where('kepegawaian_jadwal.id',$id)
        //         ->get();

        // print_r($shift);
        // die();

        $totalDay = Carbon::create($jadwal->tahun, $jadwal->bulan)->format('t');
        for($i = 1; $i <= $totalDay; $i++)
        {
            $dataArray[] = Carbon::create($jadwal->tahun, $jadwal->bulan, $i)->dayName;
        }

        $getBulan = ['','Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        foreach ($getBulan as $key => $value) {
            if ($key == $jadwal->bulan) {
                $bulan = $value;
            }
        }

        $data = [
            'bulan' => $bulan,
            'detail' => $detail,
            'ln' => $ln,
            'shift' => $shift,
            'staf' => $staf,
            'jabatan' => $jabatan,
            'jadwal' => $jadwal,
            'totalDay' => $totalDay,
            'dataArray' => $dataArray,
        ];

        return response()->json($data, 200);
    }

    // TABEL RIWAYAT JADWAL
    function table($id)
    {
        $users  = users::select('id','nama')->where('nik','!=',null)->where('nama','!=',null)->orderBy('nama', 'asc')->get();

        // Ambil daftar staf yang menjadi tanggung jawab user
        $stafList = DB::table('referensi_jadwal_users')
            ->whereJsonContains('staf', (string) $id)
            ->whereNull('deleted_at')
            ->pluck('staf')
            ->first();

        $pegawaiIds = [];

        if ($stafList) {
            // Decode JSON yang tersimpan di kolom `staf`
            $pegawaiIds = json_decode($stafList, true);
        }

        $show = DB::table('kepegawaian_jadwal')
            ->leftJoin('users as us', 'us.id', '=', 'kepegawaian_jadwal.pegawai_id')
            ->leftJoin('users as vr', 'vr.id', '=', 'kepegawaian_jadwal.verif')
            ->leftJoin('users as vl', 'vl.id', '=', 'kepegawaian_jadwal.valid')
            ->select(
                'kepegawaian_jadwal.*',
                'us.nama as nama_pegawai',
                'vr.nama as nama_verif',
                'vl.nama as nama_valid'
            )
            ->whereJsonContains('staf', (string) $id)
            // ->whereIn('kepegawaian_jadwal.pegawai_id', $pegawaiIds)
            ->whereIn('kepegawaian_jadwal.progress', [1, 2, 3])
            ->whereNull('kepegawaian_jadwal.deleted_at')
            ->get();

        $data = [
            'users' => $users,
            'show' => $show,
        ];

        return response()->json($data, 200);
    }

    // SHOW TABLE ADMIN
    function tableAll()
    {
        $users  = users::select('id','nama')->where('nik','!=',null)->where('nama','!=',null)->orderBy('nama', 'asc')->get();

        $show = DB::table('kepegawaian_jadwal')
            ->distinct()
            ->leftJoin('users as us', 'us.id', '=', 'kepegawaian_jadwal.pegawai_id')
            ->leftJoin('users as vr', 'vr.id', '=', 'kepegawaian_jadwal.verif')
            ->leftJoin('users as vl', 'vl.id', '=', 'kepegawaian_jadwal.valid')
            ->leftJoin('referensi_jadwal_users as rju_staf', function ($join) {
                $join->whereRaw('JSON_CONTAINS(rju_staf.staf, JSON_QUOTE(CAST(kepegawaian_jadwal.pegawai_id AS CHAR)))');
                    // ->whereNull('rju_staf.deleted_at');
            })
            ->leftJoin('referensi_jadwal_users as rju_direct', function ($join) {
                $join->on('kepegawaian_jadwal.pegawai_id', '=', 'rju_direct.pegawai_id');
                    // ->whereNull('rju_direct.deleted_at');
            })
            ->select(
                'kepegawaian_jadwal.*',
                'us.nama as nama_pegawai',
                'vr.nama as nama_verif',
                'vl.nama as nama_valid'
            )
            ->whereIn('kepegawaian_jadwal.progress', [1, 2, 3])
            ->whereNull('kepegawaian_jadwal.deleted_at')
            ->get();

        $data = [
            'users' => $users,
            'show' => $show,
        ];

        return response()->json($data, 200);
    }
    function tableAllMonth($month)
    {
        list($year, $month) = explode('-', $month); // misal $input = "2025-08"
        $month = sprintf("%02d", $month); // "08"
        $year = sprintf("%04d", $year);   // "2025" (opsional)

        $users  = users::select('id','nama')->where('nik','!=',null)->where('nama','!=',null)->orderBy('nama', 'asc')->get();

        $show = DB::table('kepegawaian_jadwal')
            ->distinct()
            ->leftJoin('users as us', 'us.id', '=', 'kepegawaian_jadwal.pegawai_id')
            ->leftJoin('users as vr', 'vr.id', '=', 'kepegawaian_jadwal.verif')
            ->leftJoin('users as vl', 'vl.id', '=', 'kepegawaian_jadwal.valid')
            ->leftJoin('referensi_jadwal_users as rju_staf', function ($join) {
                $join->whereRaw('JSON_CONTAINS(rju_staf.staf, JSON_QUOTE(CAST(kepegawaian_jadwal.pegawai_id AS CHAR)))');
                    // ->whereNull('rju_staf.deleted_at');
            })
            ->leftJoin('referensi_jadwal_users as rju_direct', function ($join) {
                $join->on('kepegawaian_jadwal.pegawai_id', '=', 'rju_direct.pegawai_id');
                    // ->whereNull('rju_direct.deleted_at');
            })
            ->select(
                'kepegawaian_jadwal.*',
                'us.nama as nama_pegawai',
                'vr.nama as nama_verif',
                'vl.nama as nama_valid'
            )
            ->where(function ($query) use ($year,$month) {
                $query->where('kepegawaian_jadwal.tahun', $year)
                        ->where('kepegawaian_jadwal.bulan', $month);
            })
            ->whereIn('kepegawaian_jadwal.progress', [1, 2, 3])
            ->whereNull('kepegawaian_jadwal.deleted_at')
            ->get();

        $data = [
            'users' => $users,
            'show' => $show,
        ];

        return response()->json($data, 200);
    }

    // SHOW TABLE ATASAN LANGSUNG
    function tableAllBawahan($user)
    {
        $users  = users::select('id','nama')->where('nik','!=',null)->where('nama','!=',null)->orderBy('nama', 'asc')->get();
        // Ambil data struktur organisasi user tersebut
        $jabatan = struktur_organisasi::where('id_user', $user)
                    ->orderBy('updated_at','desc')
                    ->first();

        if (!$jabatan) {
            return collect(); // Kosongkan hasil jika tidak ada jabatan
        }

        $bawahanRoles = json_decode($jabatan->bawahan); // Contoh: ["14","93","94","95","55","56"]
        $referensi = DB::table('referensi_jadwal_users')->whereNull('deleted_at')->get();
        $pegawaiUnitMap = [];

        foreach ($referensi as $row) {
            // unit milik pegawai_id
            $pegawaiUnitMap[$row->pegawai_id] = $row->unit;

            // unit diwariskan ke staf-nya juga
            $stafList = json_decode($row->staf, true);
            if (is_array($stafList)) {
                foreach ($stafList as $stafId) {
                    $pegawaiUnitMap[$stafId] = $row->unit;
                }
            }
        }

        // 1. Pegawai yang punya role bawahan (user seperti 164)
        $pegawaiDenganRole = DB::table('model_has_roles')
            ->whereIn('role_id', $bawahanRoles)
            ->pluck('model_id')
            ->unique();

        // 2. Pegawai penginput (pegawai_id dari referensi_jadwal_users) yang staf-nya mengandung pegawai bawahan
        $pegawaiPenginput = DB::table('referensi_jadwal_users')
            ->where(function ($query) use ($pegawaiDenganRole) {
                foreach ($pegawaiDenganRole as $pegawaiId) {
                    $query->orWhereRaw("JSON_CONTAINS(staf, JSON_QUOTE(?))", [(string) $pegawaiId]);
                }
            })
            ->whereNull('deleted_at')
            ->pluck('pegawai_id')
            ->unique();

        // 3. Gabungkan keduanya — yang bisa input sendiri atau staf dari orang lain
        $finalPegawaiIds = $pegawaiDenganRole->merge($pegawaiPenginput)->unique();

        // 4. Ambil data jadwal dengan unit
        $show = jadwal::leftJoin('users as us', 'us.id', '=', 'kepegawaian_jadwal.pegawai_id')
                        ->leftJoin('users as vr', 'vr.id', '=', 'kepegawaian_jadwal.verif')
                        ->leftJoin('users as vl', 'vl.id', '=', 'kepegawaian_jadwal.valid')
                        ->select('kepegawaian_jadwal.*', 'us.nama as nama_pegawai', 'vr.nama as nama_verif', 'vl.nama as nama_valid')
                        ->whereIn('kepegawaian_jadwal.pegawai_id', $finalPegawaiIds)
                        ->whereNull('kepegawaian_jadwal.deleted_at')
                        ->get();

        // Tambahkan unit berdasarkan mapping
        // $show->transform(function ($item) use ($pegawaiUnitMap) {
        //     $item->unit = $pegawaiUnitMap[$item->pegawai_id] ?? null;
        //     return $item;
        // });

        $data = [
            'jabatan' => $jabatan,
            'users' => $users,
            'show' => $show,
        ];

        return response()->json($data, 200);
    }

    function countBawahan($user)
    {
        $jabatan = struktur_organisasi::where('id_user', $user)
                    ->orderBy('updated_at','desc')
                    ->first();

        if (!$jabatan) {
            return collect(); // Kosongkan hasil jika tidak ada jabatan
        }

        $bawahanRoles = json_decode($jabatan->bawahan); // Contoh: ["14","93","94","95","55","56"]

        // 1. Pegawai yang punya role bawahan (user seperti 164)
        $pegawaiDenganRole = DB::table('model_has_roles')
            ->whereIn('role_id', $bawahanRoles)
            ->pluck('model_id')
            ->unique();

        // 2. Pegawai penginput (pegawai_id dari referensi_jadwal_users) yang staf-nya mengandung pegawai bawahan
        $pegawaiPenginput = DB::table('referensi_jadwal_users')
            ->where(function ($query) use ($pegawaiDenganRole) {
                foreach ($pegawaiDenganRole as $pegawaiId) {
                    $query->orWhereRaw("JSON_CONTAINS(staf, JSON_QUOTE(?))", [(string) $pegawaiId]);
                }
            })
            ->pluck('pegawai_id')
            ->unique();

        // 3. Gabungkan keduanya — yang bisa input sendiri atau staf dari orang lain
        $finalPegawaiIds = $pegawaiDenganRole->merge($pegawaiPenginput)->unique();

        // 4. Ambil data jadwal dengan unit
        $show = jadwal::join('users', 'users.id', '=', 'kepegawaian_jadwal.pegawai_id')
            ->select('kepegawaian_jadwal.*', 'users.nama as nama_pegawai')
            ->whereIn('kepegawaian_jadwal.pegawai_id', $finalPegawaiIds)
            ->where('kepegawaian_jadwal.progress',1)
            ->whereNull('kepegawaian_jadwal.deleted_at')
            ->count();

        // print_r($show);
        // die();
        $data = [
            'jabatan' => $jabatan,
            'show' => $show,
        ];

        return response()->json($data, 200);
    }

    function hapus($id)
    {
        $tgl = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');

        // Inisialisasi
        $jadwal = jadwal::find($id);

        // Delete
        $jadwal->delete();
        $detail = jadwal_detail::where('id_jadwal',$id)->delete();

        return response()->json($tgl, 200);
    }

    // ADMIN == PROSES VERIFIKASI DAN PENOLAKAN
    function verif($id,$user)
    {
        // print_r($id);
        // die();
        $tgl = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');

        // Inisialisasi
        $jadwal = jadwal::find($id);

        // Change
        $jadwal->progress = 3;
        $jadwal->valid = $user;
        $jadwal->tgl_valid = Carbon::now();
        $jadwal->save();

        return response()->json($tgl, 200);
    }
    function batalVerif($id,$user)
    {
        $tgl = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');

        // Inisialisasi
        $jadwal = jadwal::find($id);

        // Change
        $jadwal->progress = 2;
        $jadwal->valid = $user;
        $jadwal->tgl_valid = Carbon::now();
        $jadwal->save();

        return response()->json($tgl, 200);
    }
    // function tolak($id,$user)
    // {
    //     $tgl = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');

    //     // Inisialisasi
    //     $jadwal = jadwal::find($id);

    //     // Change
    //     $jadwal->progress = 0;
    //     $jadwal->valid = $user;
    //     $jadwal->tgl_valid = Carbon::now();
    //     $jadwal->save();

    //     return response()->json($tgl, 200);
    // }
    // function batalTolak($id,$user)
    // {
    //     $tgl = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');

    //     // Inisialisasi
    //     $jadwal = jadwal::find($id);

    //     // Change
    //     $jadwal->progress = 1;
    //     $jadwal->valid = $user;
    //     $jadwal->tgl_valid = Carbon::now();
    //     $jadwal->save();

    //     return response()->json($tgl, 200);
    // }

    // ATASAN LANGSUNG == PROSES VERIFIKASI DAN PENOLAKAN
    function verifBawahan($id,$user)
    {
        $tgl = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');

        // Inisialisasi
        $jadwal = jadwal::find($id);
        $detail = jadwal_detail::where('id_jadwal',$id)->whereNull('deleted_at')->get();

        $hitungTgl = Carbon::createFromDate($jadwal->tahun, $jadwal->bulan, 1);
        $jmlHari = $hitungTgl->daysInMonth;

        if (count($detail) > 0) {
            foreach ($detail as $key => $value) {
                for ($i=1; $i <= $jmlHari; $i++) {
                    $hit = "tgl".$i;
                    if (!$value->$hit) {
                        return response()->json([
                            'message' => $hit . " masih kosong / belum terisi. Periksa Jadwal Dinas sekali lagi."
                        ], 404);
                    }
                }
            }
        } else {
            return response()->json($tgl, 401);
        }

        // Change
        $jadwal->progress = 2;
        $jadwal->verif = $user;
        $jadwal->tgl_verif = Carbon::now();
        $jadwal->save();

        return response()->json($tgl, 200);
    }
    function batalVerifBawahan($id,$user)
    {
        $tgl = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');

        // Inisialisasi
        $jadwal = jadwal::find($id);

        // Change
        $jadwal->progress = 1;
        $jadwal->verif = $user;
        $jadwal->tgl_verif = Carbon::now();
        $jadwal->save();

        return response()->json($tgl, 200);
    }
    function tolakBawahan($id,$user)
    {
        $tgl = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');

        // Inisialisasi
        $jadwal = jadwal::find($id);

        // Change
        $jadwal->progress = 0;
        $jadwal->verif = $user;
        $jadwal->tgl_verif = Carbon::now();
        $jadwal->save();

        return response()->json($tgl, 200);
    }
    function batalTolakBawahan($id,$user)
    {
        $tgl = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');

        // Inisialisasi
        $jadwal = jadwal::find($id);

        // Change
        $jadwal->progress = 1;
        $jadwal->verif = $user;
        $jadwal->tgl_verif = Carbon::now();
        $jadwal->save();

        return response()->json($tgl, 200);
    }

    // REFERENSI SHIFT -----------------------------------------------------------------------------------------------------------
    function tableShift($id)
    {
        $pegawai = $id; // misal: 232
        $cekUser = DB::table('referensi_jadwal_users')
            ->whereJsonContains('staf', (string) $pegawai)
            ->whereNull('deleted_at')
            ->first();

        if ($cekUser) {
            $users  = users::select('id','nama')->where('nik','!=',null)->where('nama','!=',null)->orderBy('nama', 'asc')->get();
            $show  = ref_jadwal_shift::join('users','users.id','=','referensi_jadwal_shift.pegawai_id')
                    ->select('referensi_jadwal_shift.*','users.nama as nama_pegawai')
                    ->where('referensi_jadwal_shift.pegawai_id',$cekUser->pegawai_id)
                    ->get();

            $data = [
                'users' => $users,
                'atasan' => $cekUser->pegawai_id,
                'show' => $show,
            ];

            return response()->json($data, 200);
        } else {
            return response()->json($pegawai, 400);
        }
    }

    function tambahShift(Request $request)
    {
        $tgl = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');
        $getDuplicate = ref_jadwal_shift::where('pegawai_id', $request->pegawai)->where('singkat',$request->singkat)->whereNull('deleted_at')->first();

        // HITUNG SELISIH
        $berangkat = Carbon::parse($request->berangkat);
        $pulang    = Carbon::parse($request->pulang);
        // Jika pulang lebih kecil dari berangkat, tambahkan 1 hari ke pulang
        if ($pulang->lessThan($berangkat)) {
            $pulang->addDay();
        }
        $selisihJam = $berangkat->diffInHours($pulang);

        if ($selisihJam < 4) {
            return Response::json(array(
                'message' => 'Jam Berangkat ('.$berangkat->format('H:i').') dan Jam Pulang ('.$pulang->format('H:i').') tidak valid, periksa data penambahan shift Anda sekali lagi!',
                'code' => 500,
            ));
        } else {
            if (!empty($getDuplicate)) {
                return Response::json(array(
                    'message' => 'Terdapat datarecord yang sama pada pengisian Nama Singkat Shift ('.$request->singkat.'), mohon ubah shift dengan penamaan lainnya!',
                    'code' => 500,
                ));
            } else {
                $data = new ref_jadwal_shift;
                $data->pegawai_id = $request->pegawai;
                $data->singkat = $request->singkat;
                $data->shift = $request->shift;
                $data->berangkat = Carbon::parse($request->berangkat)->isoFormat('HH:mm');
                $data->pulang = Carbon::parse($request->pulang)->isoFormat('HH:mm');
                $data->ket = $request->ket;
                $data->save();

                return Response::json(array(
                    'message' => $tgl,
                    'code' => 200,
                ));
            }
        }
    }

    function showUbahShift($id)
    {
        $show  = ref_jadwal_shift::join('users','users.id','=','referensi_jadwal_shift.pegawai_id')
                                ->select('referensi_jadwal_shift.*','users.nama as nama_pegawai')
                                ->where('referensi_jadwal_shift.id',$id)
                                ->first();

        $data = [
            'show' => $show,
        ];

        return response()->json($data, 200);
    }

    function ubahShift(Request $request)
    {
        $tgl = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');
        $getDuplicate = ref_jadwal_shift::where('pegawai_id', $request->pegawai)->where('singkat',$request->singkat)->whereNull('deleted_at')->count();

        // HITUNG SELISIH
        $berangkat = Carbon::parse($request->berangkat);
        $pulang    = Carbon::parse($request->pulang);
        // Jika pulang lebih kecil dari berangkat, tambahkan 1 hari ke pulang
        if ($pulang->lessThan($berangkat)) {
            $pulang->addDay();
        }
        $selisihJam = $berangkat->diffInHours($pulang);

        if ($selisihJam < 4) {
            return Response::json(array(
                'message' => 'Jam Berangkat ('.$berangkat->format('H:i').') dan Jam Pulang ('.$pulang->format('H:i').') tidak valid, periksa data penambahan shift Anda sekali lagi!',
                'code' => 500,
            ));
        } else {
            if ($getDuplicate > 1) {
                return Response::json(array(
                    'message' => 'Terdapat datarecord yang sama pada pengisian Nama Singkat Shift ('.$request->singkat.'), mohon tambahkan data shift lainnya!',
                    'code' => 500,
                ));
            } else {
                $data = ref_jadwal_shift::find($request->id);
                $data->singkat = $request->singkat;
                $data->shift = $request->shift;
                $data->berangkat = Carbon::parse($request->berangkat)->isoFormat('HH:mm');
                $data->pulang = Carbon::parse($request->pulang)->isoFormat('HH:mm');
                $data->ket = $request->ket;
                $data->save();

                return Response::json(array(
                    'message' => $tgl,
                    'code' => 200,
                ));
            }
        }
    }

    function hapusShift($id)
    {
        $tgl = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');

        // Inisialisasi
        $data = ref_jadwal_shift::find($id);
        $data->delete();

        return response()->json($tgl, 200);
    }

    // REFERENSI STAFF -----------------------------------------------------------------------------------------------------------
    function tableStaf($id)
    {
        $pegawai = $id; // misal: 232
        $cekUser = DB::table('referensi_jadwal_users')
            ->whereJsonContains('staf', (string) $pegawai)
            ->whereNull('deleted_at')
            ->first();

        if ($cekUser) {
            $users  = users::select('id','nama')
                            ->leftJoin('users_foto','users_foto.user_id','=','users.id')
                            ->select('users.*','users_foto.title','users_foto.filename')
                            ->get();
            $foto_user = users_foto::get();
            $jabatan = ref_jadwal_jabatan::where('pegawai_id',$cekUser->pegawai_id)->get();
            $check = ref_jadwal_users::join('users','users.id','=','referensi_jadwal_users.pegawai_id')
                            ->select('referensi_jadwal_users.*','users.nama as nama_user')
                            ->where('referensi_jadwal_users.pegawai_id',$cekUser->pegawai_id)
                            ->first();
            $show = ref_jadwal_users::join('users','users.id','=','referensi_jadwal_users.pegawai_id')
                            ->select('referensi_jadwal_users.*','users.nama as nama_user')
                            ->where('referensi_jadwal_users.pegawai_id',$cekUser->pegawai_id)
                            ->first();

            $data = [
                'users' => $users,
                'foto_user' => $foto_user,
                'jabatan' => $jabatan,
                'show' => $show,
            ];

            return response()->json($data, 200);
        } else {
            return response()->json($cekUser, 400);
        }
    }

    function tambahStaf(Request $request)
    {
        // print_r(json_decode($request->staf));
        $getData = ref_jadwal_users::get();
        $user = '';
        $input = '';
        $count = 0;
        foreach ($getData as $key => $value) {
            foreach (json_decode($request->staf) as $loop => $item) {
                if (in_array($item,json_decode($value->staf))) {
                    $user = users::select('nama')->where('id',$item)->first();
                    $input = users::select('nama')->where('id',$value->pegawai_id)->first();
                    $count++;
                }
            }
        }
        if ($count > 0) {
            // ref_jadwal_users::where('pegawai_id', $request->pegawai)->delete();
            $status = 400;
            $message = "Karyawan bernama ".$user->nama." sudah pernah dimasukkan oleh ".$input->nama.". Silakan menambahkan Staf lain atau konfirmasi kepada yang bersangkutan.";
        } else {
            $status = 200;
            $message = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');

            $data = new ref_jadwal_users;
            $data->pegawai_id = $request->pegawai;
            $data->staf = $request->staf;
            $data->unit = $request->unit;
            $data->save();
        }

        $results = array(
            'status' => $status,
            'message' => $message,
        );

        return response()->json($results);
    }

    function showUbahStaf($id)
    {
        $users  = users::select('id','nama')->where('nik','!=',null)->where('nama','!=',null)->orderBy('nama', 'asc')->get();
        $show  = ref_jadwal_users::where('id',$id)->first();

        $data = [
            'users' => $users,
            'show' => $show,
        ];

        return response()->json($data, 200);
    }

    function ubahStaf(Request $request)
    {
        $getData = ref_jadwal_users::where('id','!=',$request->id)->get();
        // $getData = ref_jadwal_users::get();
        $user = '';
        $input = '';
        $count = 0;
        foreach ($getData as $key => $value) {
            foreach (json_decode($request->staf) as $loop => $item) {
                if (in_array($item,json_decode($value->staf))) {
                    $user = users::select('nama')->where('id',$item)->first();
                    $input = users::select('nama')->where('id',$value->pegawai_id)->first();
                    $count++;
                }
            }
        }
        if ($count > 0) {
            // ref_jadwal_users::where('pegawai_id', $request->pegawai)->delete();
            $status = 400;
            $message = "Karyawan bernama ".$user->nama." sudah pernah dimasukkan oleh ".$input->nama.". Silakan menambahkan Staf lain atau konfirmasi kepada yang bersangkutan.";
        } else {
            $status = 200;
            $message = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');
            // $validate = ref_jadwal_jabatan::where('pegawai_id',$request->pegawai)->get();
            $validate = ref_jadwal_jabatan::where('pegawai_id',$request->pegawai)->whereNotIn('id_staf',json_decode($request->staf))->get();
            if ($validate) {
                foreach ($validate as $key => $value) {
                    $delete = ref_jadwal_jabatan::find($value->id);
                    $delete->delete();
                }
            }

            $data = ref_jadwal_users::find($request->id);
            $data->pegawai_id = $request->pegawai;
            $data->staf = $request->staf;
            $data->unit = $request->unit;
            $data->save();
        }

        $results = array(
            'status' => $status,
            'message' => $message,
        );

        return response()->json($results);
    }

    function hapusStaf($id)
    {
        $tgl = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');

        // Inisialisasi
        $data = ref_jadwal_users::find($id);

        // Pastikan decode JSON ke array
        $stafIds = json_decode($data->staf, true);

        if (is_array($stafIds)) {
            // Hapus di ref_jadwal_jabatan yang id_staf ada di array
            ref_jadwal_jabatan::whereIn('id_staf', $stafIds)->delete();
        }

        // Hapus ref_jadwal_users
        $data->delete();

        return response()->json($tgl, 200);
    }

    function ambilAlihStaf($id,$user)
    {
        $tgl = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');

        // Validasi
        $cek = ref_jadwal_users::where('pegawai_id',$user)->whereNull('deleted_at')->first();

        if ($cek) {
            return response()->json($tgl, 400);
        } else {
            // Inisialisasi
            $oldData = ref_jadwal_users::where('pegawai_id',$id)->whereNull('deleted_at')->first();
            $newData = new ref_jadwal_users;
            $newData->pegawai_id = $user;
            $newData->staf = $oldData->staf;
            $newData->unit = $oldData->unit;
            $newData->save();
            $oldData->delete();

            $data2 = ref_jadwal_jabatan::where('pegawai_id',$id)->whereNull('deleted_at')->get();
            if ($data2->count() > 0) {
                foreach ($data2 as $item) {
                    $newData2 = new ref_jadwal_jabatan;
                    $newData2->urutan = $item->urutan;
                    $newData2->pegawai_id = $user;
                    $newData2->id_staf = $item->id_staf;
                    $newData2->jabatan = $item->jabatan;
                    $newData2->color = $item->color;
                    $newData2->save();
                    $item->delete();
                }
            }

            $data3 = ref_jadwal_shift::where('pegawai_id',$id)->whereNull('deleted_at')->get();
            if ($data3->count() > 0) {
                foreach ($data3 as $item) {
                    $newData3 = new ref_jadwal_shift;
                    $newData3->pegawai_id = $user;
                    $newData3->unit = null;
                    $newData3->shift = $item->shift;
                    $newData3->singkat = $item->singkat;
                    $newData3->berangkat = $item->berangkat;
                    $newData3->pulang = $item->pulang;
                    $newData3->ket = $item->ket;
                    $newData3->save();
                    $item->delete();
                }
            }

            return response()->json($tgl, 200);
        }
    }

    function showAturStaf($id)
    {
        // $users  = users::select('id','nama')->where('nik','!=',null)->where('nama','!=',null)->orderBy('nama', 'asc')->get();
        $show  = ref_jadwal_jabatan::where('id_staf',$id)->first();
        return response()->json($show, 200);
    }

    function aturStaf(Request $request)
    {
        $getData = ref_jadwal_jabatan::where('id_staf',$request->staf)->where('deleted_at',null)->get();

        // print_r(count($getData));
        // die();
        if (count($getData)>0) { // IF getData EXIST !!
            foreach ($getData as $key => $value) {
                $del = ref_jadwal_jabatan::find($value->id);
                // $getData->deleted_at=Carbon::now();
                // $getData->save();
                $del->delete();
            }
        }

        $getUrutan = ref_jadwal_jabatan::where('pegawai_id',$request->pegawai)->get();

        foreach ($getUrutan as $key => $value) {
            if ($value->urutan == $request->urutan) {
                $status = 400;
                $message = 'Nomor Urutan sudah terpakai pada Unit Anda, silakan ganti urutan lainnya.';
                $results = array(
                    'status' => $status,
                    'message' => $message,
                );
                return response()->json($results);
            }
        }

        $data = new ref_jadwal_jabatan;
        $data->urutan = $request->urutan;
        $data->pegawai_id = $request->pegawai;
        $data->id_staf = $request->staf;
        $data->jabatan = $request->jabatan;
        $data->color = $request->color;
        $data->save();

        $status = 200;
        $message = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');

        $results = array(
            'status' => $status,
            'message' => $message,
        );

        return response()->json($results);
    }

    // REFERENSI LIBUR NASIONAL -------------------------------------------------------------------------------------------------------
    function tableLN()
    {
        $show = ref_jadwal_ln::get();

        $data = [
            'show' => $show,
        ];

        return response()->json($data, 200);
    }

    function tambahLN(Request $request)
    {
        $tgl = explode('-',$request->tgl);
        $getData = ref_jadwal_ln::where('tgl',(int) $tgl[2])->where('bulan',(int) $tgl[1])->where('tahun',(int) $tgl[0])->whereNull('deleted_at')->first();
        $message = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');

        if ($getData) {
            $status = 400;
            $message = "Tanggal ".$request->tgl." sudah ada di dalam data Libur Nasional, silakan masukkan tanggal lainnya.";
        } else {
            $status = 200;
            $data = new ref_jadwal_ln;
            $data->tahun = (int) $tgl[0];
            $data->bulan = (int) $tgl[1];
            $data->tgl = (int) $tgl[2];
            $data->deskripsi = $request->deskripsi;
            $data->keterangan = $request->keterangan;
            $data->save();
        }

        $results = array(
            'status' => $status,
            'message' => $message,
        );

        return response()->json($results);
    }

    function hapusLN($id)
    {
        $tgl = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');

        // Inisialisasi
        $data = ref_jadwal_ln::find($id);
        $data->delete();

        return response()->json($tgl, 200);
    }

}
