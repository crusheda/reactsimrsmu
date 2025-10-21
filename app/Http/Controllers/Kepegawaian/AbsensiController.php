<?php

namespace App\Http\Controllers\Kepegawaian;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use App\Models\referensi;
use App\Models\datalogs;
use App\Models\users;
use App\Models\users_foto;
use App\Models\kepegawaian\absensi;
use App\Models\kepegawaian\jadwal;
use App\Models\kepegawaian\jadwal_detail;
use App\Models\kepegawaian\ref_jadwal_shift;
use App\Models\kepegawaian\ref_jadwal_users;
use App\Models\kepegawaian\ref_jadwal_jabatan;
use App\Models\model_has_roles;
use App\Models\struktur_organisasi;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Auth, DB;
use Validator,Redirect,Response,File,Storage;

class AbsensiController extends Controller
{
    function index()
    {
        if (
                Auth::user()->getPermission('admin_kepegawaian') == true ||
                Auth::user()->getPermission('admin_kepegawaian_kepala') == true
            ) {
            $bulan = Carbon::now()->isoFormat('MM');
            $tahun = Carbon::now()->isoFormat('YYYY');

            $users  = users::where('nik','!=',null)->where('nama','!=',null)->orderBy('nama', 'asc')->get();
            $jabatan = ref_jadwal_users::select('id','unit')->groupBy('id','unit')->orderBy('unit','asc')->get();
            $totalDay = Carbon::create($tahun, $bulan)->format('t');

            $data = [
                'users' => $users,
                'jabatan' => $jabatan,
                'totalDay' => $totalDay
            ];

            return view('pages.kepegawaian.absensi.rekapitulasi')->with('list', $data);
        } else {
            return redirect()->back()->withErrors("Maaf, Anda tidak memiliki akses untuk membuka halaman Absensi Karyawan!");
        }
    }

    function checkBulan($bln)
    {
        $bulan = Carbon::parse($bln)->isoFormat('MM');
        $tahun = Carbon::parse($bln)->isoFormat('YYYY');

        $show = jadwal::leftJoin('users', 'users.id', '=', 'kepegawaian_jadwal.pegawai_id')
                        ->select('kepegawaian_jadwal.*','users.nama as nama_pegawai')
                        ->where('kepegawaian_jadwal.bulan',$bulan)
                        ->where('kepegawaian_jadwal.tahun',$tahun)
                        ->whereIn('kepegawaian_jadwal.progress',[1,2,3])
                        ->whereNull('kepegawaian_jadwal.deleted_at')
                        ->orderBy('kepegawaian_jadwal.unit','asc')
                        ->get();

        return response()->json($show);
    }

    function checkJadwal($id)
    {
        $show = jadwal_detail::leftJoin('users', 'users.id', '=', 'kepegawaian_jadwal_detail.pegawai_id')
                        ->select('kepegawaian_jadwal_detail.*','users.nama as nama_pegawai')
                        ->where('kepegawaian_jadwal_detail.id_jadwal',$id)
                        ->whereNull('kepegawaian_jadwal_detail.deleted_at')
                        ->orderBy('kepegawaian_jadwal_detail.id','asc')
                        ->get();

        return response()->json($show);
    }

    function checkPegawai($id)
    {
        $show = jadwal_detail::where('id',$id)->first();
        $jadwal = jadwal::where('id',$show->id_jadwal)->first();
        $totalDay = Carbon::create($jadwal->tahun, $jadwal->bulan)->format('t');

        $data = [
            'show' => $show,
            'jadwal' => $jadwal,
            'bulan' => $jadwal->bulan,
            'tahun' => $jadwal->tahun,
            'totalDay' => $totalDay,
        ];

        return response()->json($data);
    }

    function storeIjin(Request $request)
    {
        $request->validate([
            'file' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        $push = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');

        $show = jadwal_detail::where('id',$request->jadwal)->first();
        $jadwal = jadwal::where('id',$show->id_jadwal)->first();

        // range tanggal
        $periode = CarbonPeriod::create($request->dari, $request->sampai);

        $hasil = [];
        foreach ($periode as $tanggal) {
            $hasil[] = [
                'tanggal' => $tanggal->format('Y-m-d'),
                'besok'   => $tanggal->copy()->addDay()->format('Y-m-d'),
                'bulan'   => $tanggal->format('m'),
                'hari'    => $tanggal->format('d'),
                'kolom'   => 'tgl' . (int) $tanggal->format('d'), // contoh: tgl30, tgl31, tgl1
            ];
        }

        // insert ke tabel absensi
        foreach ($hasil as $row) {
            $hit = 'tgl' . (int) $row['hari'];
            $callShift = $show->$hit;
            if (
                $callShift == 'L' ||
                $callShift == 'C' ||
                $callShift == 'CM' ||
                $callShift == 'CU' ||
                $callShift == 'CH' ||
                $callShift == 'CD'
                ) {
                $kd_shift = $callShift;
                $nm_shift = 'Ijin/Tidak Masuk';
                $berangkat = '00:00:00';
                $pulang = '00:00:00';
            } else {
                $shift = ref_jadwal_shift::leftJoin('referensi_jadwal_users', function($join) {
                        $join->on('referensi_jadwal_users.pegawai_id', '=', 'referensi_jadwal_shift.pegawai_id')
                            ->whereNull('referensi_jadwal_users.deleted_at');
                    })
                    ->select('referensi_jadwal_shift.*')
                    ->whereRaw("
                        FIND_IN_SET(?,
                            REPLACE(REPLACE(REPLACE(referensi_jadwal_users.staf, '\"', ''), '[', ''), ']', '')
                        )
                    ", [$jadwal->pegawai_id])
                    ->where('referensi_jadwal_shift.singkat',$callShift)
                    ->whereNull('referensi_jadwal_shift.deleted_at')
                    ->first();
                if ($shift) {
                    $kd_shift = $shift->singkat;
                    $nm_shift = $shift->shift;
                    $berangkat = $shift->berangkat;
                    $pulang = $shift->pulang;
                } else {
                    return response()->json([
                        'status'  => 'error',
                        'message' => 'Jadwal Shift untuk pegawai '.$show->pegawai_nama.' pada tanggal '.$row['tanggal'].' tidak ditemukan. Pastikan pada Jadwal/tanggal tersebut memang terdapat shift masuk/bekerja.'
                    ], 500);
                }
            }

            $ref_jam_masuk = Carbon::createFromFormat('Y-m-d H:i:s', $row['tanggal'].' '.$berangkat);
            if ($berangkat >= $pulang) {
                $ref_jam_pulang = Carbon::createFromFormat('Y-m-d H:i:s', $row['besok'].' '.$pulang); // Pulang Lewat Hari
            } else {
                $ref_jam_pulang = Carbon::createFromFormat('Y-m-d H:i:s', $row['tanggal'].' '.$pulang);
            }

            $validasi = absensi::where('ref_jam_masuk', $ref_jam_masuk)
                                ->where('ref_jam_pulang', $ref_jam_pulang)
                                ->whereNull('deleted_at')
                                ->first();

            if ($validasi) {
                $data = $validasi; // UPDATE OLD DATA
            } else {
                $data = new Absensi; // CREATE NEW DATA
            }

            $data->jenis         = 3; // ijin
            $data->pegawai_id    = $show->pegawai_id; // pakai dari request atau $show->pegawai
            $data->kd_shift      = $kd_shift;
            $data->nm_shift      = $nm_shift;
            $data->ref_jam_masuk = $ref_jam_masuk; // atau $jamMasuk dari logic shift
            $data->ref_jam_pulang= $ref_jam_pulang;
            $data->keterlambatan = null;
            $data->lembur        = null;
            $data->tgl_in        = Carbon::createFromFormat('Y-m-d H:i:s', $row['tanggal'].' '.$berangkat);        // simpan sesuai tanggal loop
            $data->tgl_out       = null;
            $data->selisih_jam   = null;

            $uploadedFile = $request->file('file');
            $title = uniqid() . '.png';
            if ($request->hasFile('file')) {
                $path = $uploadedFile->storeAs(
                    'public/files/kepegawaian/absensi/ijin',
                    $title
                );
            } else {
                // path asal di public/images
                $path_original = public_path("images/no-image.jpeg");
                $path_moved = "public/files/kepegawaian/absensi/ijin/";
                // simpan ke storage
                Storage::put(
                    $path_moved . $title,
                    file_get_contents($path_original)
                );
                $path = 'public/files/kepegawaian/absensi/ijin/' . $title;
            }

            $data->foto_in       = $title;
            $data->path_in       = $path;
            $data->foto_out      = null;
            $data->path_out      = null;
            $data->lokasi_in     = "-7.677851238136329, 110.83968584828327";
            $data->lokasi_out    = null;
            $data->terlambat     = null;

            // ambil value switch (string "true"/"false")
            $isManual = filter_var($request->input('switch'), FILTER_VALIDATE_BOOLEAN);

            if ($isManual) {
                $ket = $request->ket;
            } else {
                if ($request->ket == 1) {
                    $ket = 'Izin menikah';
                } elseif ($request->ket == 2) {
                    $ket = 'Izin menikahkan anak kandung';
                } elseif ($request->ket == 3) {
                    $ket = 'Izin istri melahirkan';
                } elseif ($request->ket == 4) {
                    $ket = 'Izin mengkhitankan anak kandung';
                } elseif ($request->ket == 5) {
                    $ket = 'Izin menunggu anak kandung/istri/suami rawat inap';
                } elseif ($request->ket == 6) {
                    $ket = 'Izin karena suami/istri, orang tua/mertua, anak kandung, menantu meninggal dunia';
                } else {
                    $ket = 'Izin khusus atas persetujuan Direktur Utama';
                }
            }

            $data->keterangan    = $ket;
            $data->lewat_hari    = false;
            $data->is_fake_gps   = false;
            $data->manual_user   = $request->user;
            $data->manual_tgl   = Carbon::now();
            $data->save();
        }
        // print_r(public_path().'/images/no-image.png');
        // die();
        return response()->json($push);
    }

    function tableMonitoring(Request $request)
    {
        // ============ UNIT ====================================================
        $unit_ids = json_decode($request->input('unit'), true); // [2, 11]
        // ============ DARI - SAMPAI ==========================================
        if ($request->dari != null && $request->sampai != null) {
            $dari = Carbon::parse($request->dari)->isoFormat('YYYY-MM-DD');
            $sampai = Carbon::parse($request->sampai)->isoFormat('YYYY-MM-DD');
        } else {
            $dari = Carbon::parse()->isoFormat('YYYY-MM-DD');
            $sampai = Carbon::parse()->isoFormat('YYYY-MM-DD');
        }
        // ============ JENIS ==================================================
        $jenis = $request->jenis;
        // =====================================================================
        $show = absensi::leftJoin('users', 'users.id', '=', 'kepegawaian_absensi.pegawai_id')
                        ->leftJoin('users_foto', 'users.id', '=', 'users_foto.user_id')
                        ->select('kepegawaian_absensi.*', 'users.nama as nama_pegawai', 'users_foto.filename as foto_user')
                        // Menambahkan kondisi untuk memeriksa apakah unit_ids tidak kosong
                        ->when(!empty($unit_ids), function ($query) use ($unit_ids) {
                            // Lakukan join hanya jika unit_ids ada
                            $query->join('referensi_jadwal_users', function ($join) {
                                // Pastikan nilai yang dibandingkan dalam JSON_CONTAINS adalah string
                                $join->on(DB::raw('JSON_CONTAINS(referensi_jadwal_users.staf, JSON_QUOTE(CAST(kepegawaian_absensi.pegawai_id AS CHAR)))'), '=', DB::raw('TRUE'))
                                    ->whereNull('referensi_jadwal_users.deleted_at'); // Menambahkan filter deleted_at IS NULL
                            })
                            ->whereIn('referensi_jadwal_users.id', $unit_ids);
                        })
                        ->when($jenis != 0, function ($query) use ($jenis) {
                            $query->where('kepegawaian_absensi.jenis', $jenis);
                        })
                        ->when($request->dari && $request->sampai, function ($query) use ($dari, $sampai) {
                            $start = $dari . ' 00:00:00';
                            $end = $sampai . ' 23:59:59';
                            $query->whereBetween('kepegawaian_absensi.tgl_in', [$start, $end]);
                        })
                        ->whereNull('kepegawaian_absensi.deleted_at')
                        ->orderBy('kepegawaian_absensi.tgl_in', 'desc')
                        ->get();
        $users  = users::where('nik','!=',null)->where('nama','!=',null)->orderBy('nama', 'asc')->get();
        $role = model_has_roles::join('roles', 'model_has_roles.role_id', '=', 'roles.id')->select('model_has_roles.model_id as id_user','roles.name as nama_role')->get();

        $data = [
            'show' => $show,
            'users' => $users,
            'role' => $role,
        ];

        return response()->json($data);
    }

    function tableAll(Request $request)
    {
        // ============ UNIT ====================================================
        $unit_ids = json_decode($request->input('unit'), true); // [2, 11]
        // ============ DARI - SAMPAI ==========================================
        if ($request->dari != null && $request->sampai != null) {
            $dari = Carbon::parse($request->dari)->isoFormat('YYYY-MM-DD');
            $sampai = Carbon::parse($request->sampai)->isoFormat('YYYY-MM-DD');
        } else {
            $dari = Carbon::parse()->isoFormat('YYYY-MM-DD');
            $sampai = Carbon::parse()->isoFormat('YYYY-MM-DD');
        }
        // ============ JENIS ==================================================
        $jenis = $request->jenis;
        // =====================================================================
        $show = absensi::leftJoin('users', 'users.id', '=', 'kepegawaian_absensi.pegawai_id')
                        ->leftJoin('users_foto', 'users.id', '=', 'users_foto.user_id')
                        ->select('kepegawaian_absensi.*', 'users.id as id_pegawai','users.nama as nama_pegawai','users.nip as nip_pegawai', 'users_foto.filename as foto_user')
                        // Menambahkan kondisi untuk memeriksa apakah unit_ids tidak kosong
                        ->when(!empty($unit_ids), function ($query) use ($unit_ids) {
                            // Lakukan join hanya jika unit_ids ada
                            $query->join('referensi_jadwal_users', function ($join) {
                                // Pastikan nilai yang dibandingkan dalam JSON_CONTAINS adalah string
                                $join->on(DB::raw('JSON_CONTAINS(referensi_jadwal_users.staf, JSON_QUOTE(CAST(kepegawaian_absensi.pegawai_id AS CHAR)))'), '=', DB::raw('TRUE'))
                                    ->whereNull('referensi_jadwal_users.deleted_at'); // Menambahkan filter deleted_at IS NULL
                            })
                            ->whereIn('referensi_jadwal_users.id', $unit_ids);
                        })
                        ->when($jenis != 0, function ($query) use ($jenis) {
                            $query->where('kepegawaian_absensi.jenis', $jenis);
                        })
                        ->when($request->dari && $request->sampai, function ($query) use ($dari, $sampai) {
                            $start = $dari . ' 00:00:00';
                            $end = $sampai . ' 23:59:59';
                            $query->whereBetween('kepegawaian_absensi.tgl_in', [$start, $end]);
                        })
                        ->whereNull('kepegawaian_absensi.deleted_at')
                        ->orderBy('kepegawaian_absensi.tgl_in', 'desc')
                        ->orderBy('users.nama', 'desc')
                        ->get();
        $users  = users::where('nik','!=',null)->where('nama','!=',null)->orderBy('nama', 'asc')->get();
        $role = model_has_roles::join('roles', 'model_has_roles.role_id', '=', 'roles.id')->select('model_has_roles.model_id as id_user','roles.name as nama_role')->get();

        $data = [
            'show' => $show,
            'users' => $users,
            'role' => $role,
        ];

        return response()->json($data);
    }

    function tableRekapAbsensi(Request $request) // REQUEST LINDA
    {
        // Ambil input dan parsing tanggal
        $unit_ids = json_decode($request->input('unit'), true);
        $jenis = $request->jenis;

        $dari = $request->dari ? Carbon::parse($request->dari)->format('Y-m-d') : now()->format('Y-m-d');
        $sampai = $request->sampai ? Carbon::parse($request->sampai)->format('Y-m-d') : now()->format('Y-m-d');

        // ambil semua kombinasi bulan-tahun dalam rentang
        $start = Carbon::parse($dari);
        $end = Carbon::parse($sampai);

        $periode = [];
        $current = $start->copy();
        while ($current <= $end) {
            $periode[] = [
                'bulan' => $current->format('m'),
                'tahun' => $current->format('Y')
            ];
            $current->addMonthNoOverflow();
        }

        // ubah jadi 2 array agar gampang dipakai di query
        $bulanList = array_column($periode, 'bulan');
        $tahunList = array_column($periode, 'tahun');

        // Ambil semua pegawai yang termasuk staf dari referensi_jadwal_users
        $show = DB::table('kepegawaian_jadwal as kj')
            ->select(
                'u.id as pegawai_id',
                'u.nama',
                'u.nip',
                'kj.unit',
                DB::raw('IFNULL((
                    SELECT COUNT(*) FROM kepegawaian_absensi as a
                    WHERE a.pegawai_id = u.id
                    AND a.deleted_at IS NULL
                    AND a.tgl_in BETWEEN "' . $dari . ' 00:00:00" AND "' . $sampai . ' 23:59:59"
                    ' . ($jenis != 0 ? 'AND a.jenis = ' . (int) $jenis : '') . '
                ), 0) as total_absensi'),
                DB::raw('IFNULL((
                    SELECT COUNT(*) FROM kepegawaian_absensi as a
                    WHERE a.pegawai_id = u.id AND a.jenis = 3
                    AND a.deleted_at IS NULL
                    AND a.tgl_in BETWEEN "' . $dari . ' 00:00:00" AND "' . $sampai . ' 23:59:59"
                ), 0) as total_ijin'),
                DB::raw('IFNULL((
                    SELECT COUNT(*) FROM kepegawaian_absensi as a
                    WHERE a.pegawai_id = u.id AND a.jenis = 4
                    AND a.deleted_at IS NULL
                    AND a.tgl_in BETWEEN "' . $dari . ' 00:00:00" AND "' . $sampai . ' 23:59:59"
                ), 0) as total_dinas_luar'),
                DB::raw('IFNULL((
                    SELECT COUNT(*) FROM kepegawaian_absensi as a
                    WHERE a.pegawai_id = u.id AND a.jenis = 1 AND a.tgl_out IS NULL
                    AND a.deleted_at IS NULL
                    AND a.tgl_in BETWEEN "' . $dari . ' 00:00:00" AND "' . $sampai . ' 23:59:59"
                ), 0) as total_alpha'),
                DB::raw('IFNULL((
                    SELECT COUNT(*) FROM kepegawaian_absensi as a
                    WHERE a.pegawai_id = u.id AND a.jenis = 1 AND a.tgl_out IS NOT NULL AND a.terlambat = 1
                    AND a.deleted_at IS NULL
                    AND a.tgl_in BETWEEN "' . $dari . ' 00:00:00" AND "' . $sampai . ' 23:59:59"
                ), 0) as total_terlambat'),
                DB::raw('IFNULL((
                    SELECT COUNT(*) FROM kepegawaian_absensi as a
                    WHERE a.pegawai_id = u.id AND a.jenis = 1 AND a.tgl_out IS NOT NULL AND a.terlambat = 0
                    AND a.deleted_at IS NULL
                    AND a.tgl_in BETWEEN "' . $dari . ' 00:00:00" AND "' . $sampai . ' 23:59:59"
                ), 0) as total_tidak_terlambat')
            )
            ->leftJoin('users as u', function ($join) {
                $join->on(DB::raw('JSON_CONTAINS(kj.staf, JSON_QUOTE(CAST(u.id AS CHAR)))'), '=', DB::raw('TRUE'));
            })
            ->when(!empty($unit_ids), function ($q) use ($unit_ids, $bulanList, $tahunList) {
                $q->where(function ($subQuery) use ($unit_ids, $bulanList, $tahunList) {
                    $subQuery
                        // kondisi: masih ada di referensi_jadwal_users unit_ids
                        ->whereExists(function ($sub) use ($unit_ids) {
                            $sub->select(DB::raw(1))
                                ->from('referensi_jadwal_users as rju2')
                                ->whereNull('rju2.deleted_at')
                                ->whereIn('rju2.id', $unit_ids)
                                ->whereRaw('JSON_CONTAINS(rju2.staf, JSON_QUOTE(CAST(u.id AS CHAR)))');
                        })
                        // ATAU kondisi: punya absensi di periode filter untuk unit_ids
                        ->orWhereExists(function ($sub) use ($unit_ids, $bulanList, $tahunList) {
                            $sub->select(DB::raw(1))
                                ->from('kepegawaian_absensi as ka2')
                                ->join('kepegawaian_jadwal_detail as kj2', function ($join) {
                                    $join->on('kj2.pegawai_id', '=', 'ka2.pegawai_id')
                                        ->whereNull('kj2.deleted_at');
                                })
                                ->join('kepegawaian_jadwal as kj3', function ($join) {
                                    $join->on('kj2.id_jadwal', '=', 'kj3.id')
                                        ->whereNull('kj3.deleted_at');
                                })
                                ->join('referensi_jadwal_users as rju3', 'rju3.id', '=', 'kj3.unit') // ✅ betulnya ke sini
                                ->whereNull('rju3.deleted_at')
                                ->whereRaw('ka2.pegawai_id = u.id')
                                ->whereIn('rju3.id', $unit_ids)   // filter unit
                                ->whereIn('kj3.bulan', $bulanList)
                                ->whereIn('kj3.tahun', $tahunList);
                        });
                });
            })
            ->whereNull('kj.deleted_at')
            ->whereIn('kj.bulan', $bulanList)
            ->whereIn('kj.tahun', $tahunList)
            // ->when(!empty($unit_ids), fn($q) => $q->whereIn('rju.id', $unit_ids))
            // ->where('kj.pegawai_id',232)
            ->groupBy('u.id', 'u.nama', 'u.nip', 'kj.unit')
            ->get();

        // Iterasi tiap pegawai
        foreach ($show as $item) {
            // Ambil detail absensi untuk analisa status
            $absensiDetail = DB::table('kepegawaian_absensi as a')
                ->where('a.pegawai_id', $item->pegawai_id)
                ->when($jenis != 0, fn($q) => $q->where('a.jenis', $jenis))
                ->whereBetween('a.tgl_in', ["$dari 00:00:00", "$sampai 23:59:59"])
                ->whereNull('a.deleted_at')
                ->orderBy('a.tgl_in')
                ->get(['a.tgl_in', 'a.terlambat', 'a.tgl_out']);

            $absenArray = $absensiDetail->map(fn($d) => [
                'tgl_in' => $d->tgl_in,
                'terlambat' => $d->terlambat ?? 1,
                'alpha' => $d->tgl_out === null ? 1 : 0,
            ])->values();

            // Status: hangus beruntun, tidak beruntun, disiplin
            $hangus_beruntun = false;
            for ($i = 0; $i <= count($absenArray) - 5; $i++) {
                $chunk = array_slice($absenArray->toArray(), $i, 5);
                $jumlahTerlambat = collect($chunk)->where('terlambat', 1)->count();
                if ($jumlahTerlambat > 4) {
                    $hangus_beruntun = true;
                    break;
                }
            }

            // Ambil unit
            $item->unit = DB::table('referensi_jadwal_users')
                ->whereNull('deleted_at')
                ->whereRaw('JSON_CONTAINS(staf, JSON_QUOTE(?))', [(string) $item->pegawai_id])
                ->value('unit') ?? '-';

            // Ambil rentang bulan
            $bulanTahun = collect(Carbon::parse($dari)->startOfMonth()->monthsUntil(Carbon::parse($sampai)->startOfMonth()->addMonth()))
                ->map(fn($d) => [$d->format('m'), $d->format('Y')])
                ->unique()
                ->values();

            $jadwalPerTanggal = [];

            // Tambahan counter shift khusus
            $shiftCounts = [
                'L'  => 0,  // Libur
                'C'  => 0,  // Cuti Tahunan
                'CM' => 0,  // Cuti Melahirkan
                'CU' => 0,  // Cuti Umroh
                'CH' => 0,  // Cuti Haji
                'CD' => 0,  // Cuti di Luar Tanggungan
            ];

            foreach ($bulanTahun as [$bulan, $tahun]) {
                $jadwal = DB::table('kepegawaian_jadwal as kj')
                    ->join('kepegawaian_jadwal_detail as kd', function($join) {
                        $join->on('kd.id_jadwal', '=', 'kj.id')
                            ->whereNull('kd.deleted_at');
                    })
                    ->where('kd.pegawai_id', $item->pegawai_id)
                    ->where('kj.bulan', $bulan)
                    ->where('kj.tahun', $tahun)
                    ->where('kj.progress', '!=', 0)
                    ->whereNull('kj.deleted_at')
                    ->select('kd.*', 'kj.id as jadwal_id', 'kj.unit as jadwal_unit')
                    ->first();

                if (!$jadwal) {
                    // Tidak ada jadwal bulan ini → skip tapi jangan hilangkan jadwal sebelumnya
                    continue;
                }

                // Perbarui unit jika ada di jadwal
                if ($jadwal && $jadwal->jadwal_unit) {
                    $item->unit = $jadwal->jadwal_unit;
                }

                // Pegawai induk
                $pegawaiInduk = $this->getPegawaiInduk($item->pegawai_id, $jadwal->jadwal_id ?? null);
                // $pegawaiInduk = DB::table('referensi_jadwal_users')
                //     ->whereNull('deleted_at')
                //     ->whereRaw('JSON_CONTAINS(staf, JSON_QUOTE(?))', [(string) $item->pegawai_id])
                //     ->value('pegawai_id');

                // Ambil peta shift
                $shiftMap = DB::table('referensi_jadwal_shift')
                    ->where('pegawai_id', $pegawaiInduk)
                    ->whereNull('deleted_at')
                    ->pluck('shift', 'singkat')
                    ->toArray();

                // if ($item->pegawai_id == 267) {
                //     logger()->info("SHIFT MAP PEGAWAI INDUK 6", $shiftMap);
                // }

                // Tentukan batas tanggal
                $startTgl = (int) (($bulan == Carbon::parse($dari)->format('m') && $tahun == Carbon::parse($dari)->format('Y')) ? Carbon::parse($dari)->format('d') : 1);
                $endTgl = (int) (($bulan == Carbon::parse($sampai)->format('m') && $tahun == Carbon::parse($sampai)->format('Y')) ? Carbon::parse($sampai)->format('d') : 31);

                for ($i = $startTgl; $i <= $endTgl; $i++) {
                    if (!checkdate($bulan, $i, $tahun)) continue;

                    $tgl = sprintf('%04d-%02d-%02d', $tahun, $bulan, $i);
                    if ($tgl < $dari || $tgl > $sampai) continue;

                    $key = 'tgl' . $i;
                    $kodeShift = $jadwal->$key ?? null;

                    if ($kodeShift) {
                        // Hitung shift khusus
                        if (array_key_exists($kodeShift, $shiftCounts)) {
                            $shiftCounts[$kodeShift]++;
                        }

                        // Hitung shift reguler
                        $dihitung = !in_array($kodeShift, ['L', 'C', 'CM', 'CU', 'CH', 'CD']) && array_key_exists($kodeShift, $shiftMap);
                        if ($dihitung) {
                            $jadwalPerTanggal[$tgl] = $kodeShift;
                        }

                        // if ($item->pegawai_id == 267) {
                        //     logger()->info("JADWAL HARIAN", [
                        //         'tanggal' => $tgl,
                        //         'shift' => $kodeShift,
                        //         'dihitung' => $dihitung,
                        //     ]);
                        // }
                    }
                }
            }

            $item->total_masuk_shift = count($jadwalPerTanggal);
            $item->total_L  = $shiftCounts['L'];
            $item->total_C  = $shiftCounts['C'];
            $item->total_CM = $shiftCounts['CM'];
            $item->total_CU = $shiftCounts['CU'];
            $item->total_CH = $shiftCounts['CH'];
            $item->total_CD = $shiftCounts['CD'];

            $totalMasukShift  = (int) $item->total_masuk_shift;
            $totalAbsensi     = (int) $item->total_absensi;
            $totalTerlambat   = (int) $item->total_terlambat;
            $totalAlpha       = (int) $item->total_alpha;
            $totalHilang      = $totalMasukShift - $totalAbsensi;
            $totalPelanggaran = $totalHilang + $totalTerlambat + $totalAlpha;

            // === Hitung mangkir ===
            $absenTanggal = collect($absenArray)->map(fn($a) => Carbon::parse($a['tgl_in'])->format('Y-m-d'))->toArray();

            $mangkirCount = collect($jadwalPerTanggal)
                ->keys()
                ->filter(fn($tgl) => !in_array($tgl, $absenTanggal))
                ->count();

            $item->total_mangkir = $mangkirCount;

            $item->status = match (true) {
                $totalMasukShift === 0 => 'toleransi',
                $hangus_beruntun => 'hangus beruntun',
                ($totalAbsensi === $totalMasukShift && $totalTerlambat === 0 && $totalAlpha === 0) => 'disiplin',
                ($totalPelanggaran > 10) => 'hangus tidak beruntun',
                default => 'disiplin',
            };
        }

        $data = [
            'show' => $show,
        ];

        return response()->json($data);
    }

    private function getPegawaiInduk($pegawaiId, $idJadwal = null)
    {
        // 1️⃣ Cari dari kepegawaian_jadwal (jika id_jadwal tersedia)
        if ($idJadwal) {
            $indukFromJadwal = DB::table('kepegawaian_jadwal')
                ->where('id', $idJadwal)
                ->whereNull('deleted_at')
                ->value('pegawai_id');

            if ($indukFromJadwal) {
                return $indukFromJadwal;
            }
        }

        // 2️⃣ Cari dari referensi_jadwal_users JSON staf
        $indukFromRef = DB::table('referensi_jadwal_users')
            ->whereNull('deleted_at')
            ->whereRaw('JSON_CONTAINS(staf, JSON_QUOTE(?))', [(string) $pegawaiId])
            ->value('pegawai_id');

        if ($indukFromRef) {
            return $indukFromRef;
        }

        // fallback → pakai pegawai itu sendiri
        return $pegawaiId;
    }

    public function cobaJadwal()
    {
        $pegawaiId = 381; // Tasya
        $dari = '2025-09-01';
        $sampai = '2025-09-20';

        $pegawaiInduk = $this->getPegawaiInduk($pegawaiId, 153 ?? null);
        $shiftMap = DB::table('referensi_jadwal_shift')
            ->where('pegawai_id', $pegawaiInduk)
            ->whereNull('deleted_at')
            ->pluck('shift', 'singkat')
            ->toArray();

        logger()->info("SHIFT MAP TASYA", $shiftMap);

        $bulanTahun = collect(Carbon::parse($dari)->startOfMonth()->monthsUntil(Carbon::parse($sampai)->startOfMonth()->addMonth()))
            ->map(fn($d) => [$d->format('m'), $d->format('Y')])
            ->unique()
            ->values();

        $jadwalPerTanggal = [];
        foreach ($bulanTahun as [$bulan, $tahun]) {
            $jadwal = DB::table('kepegawaian_jadwal as kj')
                ->join('kepegawaian_jadwal_detail as kd', function($join) {
                    $join->on('kd.id_jadwal', '=', 'kj.id')
                        ->whereNull('kd.deleted_at');
                })
                ->where('kd.pegawai_id', $pegawaiId)
                ->where('kj.bulan', $bulan)
                ->where('kj.tahun', $tahun)
                ->where('kj.progress', '!=', 0)
                ->whereNull('kj.deleted_at')
                ->select('kd.*')
                ->first();

            if (!$jadwal) {
                logger()->warning("Tidak ada jadwal untuk $bulan-$tahun");
                continue;
            }

            // Tentukan batas tanggal
            $startTgl = ($bulan == Carbon::parse($dari)->format('m') && $tahun == Carbon::parse($dari)->format('Y'))
                ? (int) Carbon::parse($dari)->format('d') : 1;
            $endTgl = ($bulan == Carbon::parse($sampai)->format('m') && $tahun == Carbon::parse($sampai)->format('Y'))
                ? (int) Carbon::parse($sampai)->format('d') : 31;

            for ($i = $startTgl; $i <= $endTgl; $i++) {
                if (!checkdate($bulan, $i, $tahun)) continue;

                $tgl = sprintf('%04d-%02d-%02d', $tahun, $bulan, $i);
                if ($tgl < $dari || $tgl > $sampai) continue;

                $key = 'tgl' . $i;
                $kodeShift = $jadwal->$key ?? null;

                if ($kodeShift) {
                    $dihitung = !in_array($kodeShift, ['L','C','CM','CU','CH','CD'])
                        && array_key_exists($kodeShift, $shiftMap);

                    logger()->info("TGL $tgl → $kodeShift (dihitung=$dihitung)");

                    if ($dihitung) {
                        $jadwalPerTanggal[$tgl] = $kodeShift;
                    }
                }
            }
        }

        return response()->json([
            'pegawai' => $pegawaiId,
            'total_masuk_shift' => count($jadwalPerTanggal),
            'jadwal' => $jadwalPerTanggal,
        ]);
    }

    function tableRekapAbsensiDetail(Request $request)
    {
        $unit_ids = json_decode($request->input('unit'), true);
        $jenis = $request->jenis;

        $dari = $request->dari ? Carbon::parse($request->dari)->format('Y-m-d') : now()->format('Y-m-d');
        $sampai = $request->sampai ? Carbon::parse($request->sampai)->format('Y-m-d') : now()->format('Y-m-d');

        $query = DB::table('kepegawaian_absensi as a')
            ->join('users as u', 'u.id', '=', 'a.pegawai_id')
            ->leftJoin('referensi_jadwal_users as rju', function ($join) {
                $join->on(DB::raw('JSON_CONTAINS(rju.staf, JSON_QUOTE(CAST(a.pegawai_id AS CHAR)))'), '=', DB::raw('TRUE'))
                    ->whereNull('rju.deleted_at');
            })
            ->select(
                'a.pegawai_id',
                'u.nama',
                'u.nip',
                'rju.unit',
                DB::raw("DATE(a.tgl_in) as tanggal"),
                DB::raw("TIME(a.tgl_in) as jam_masuk"),
                DB::raw("IF(a.tgl_out IS NOT NULL, TIME(a.tgl_out), NULL) as jam_pulang"),
                DB::raw("IF(a.jenis = 1, IF(a.tgl_out IS NULL, 'Absen 1x', IF(a.terlambat = 1, 'Terlambat', 'Tepat Waktu')), 'Toleransi') as status_keterangan"),
                DB::raw("IF(a.jenis = 3, 1, 0) as is_ijin"),
                DB::raw("IF(a.jenis = 4, 1, 0) as is_dinas_luar"),
                DB::raw("IF(a.jenis = 1, IF(a.tgl_out IS NULL, 1, 0), 0) as is_alpha"),
                DB::raw("IF(a.jenis = 1, IF(a.tgl_out IS NOT NULL AND a.terlambat = 1, 1, 0), 0) as is_terlambat"),
                DB::raw("IF(a.jenis = 1, IF(a.tgl_out IS NOT NULL AND a.terlambat = 0, 1, 0), 0) as is_tidak_terlambat")
            )
            ->when(!empty($unit_ids), function ($query) use ($unit_ids) {
                $query->whereIn('rju.id', $unit_ids);
            })
            ->when($jenis != 0, function ($query) use ($jenis) {
                $query->where('a.jenis', $jenis);
            })
            ->whereBetween('a.tgl_in', [$dari . ' 00:00:00', $sampai . ' 23:59:59'])
            ->whereNull('a.deleted_at')
            ->orderBy('a.pegawai_id')
            ->orderBy('a.tgl_in');

        $show = $query->get();

        $data = [
            'show' => $show,
        ];

        return response()->json($data);
    }

    public function getCutiPegawai(Request $request)
    {
        $dari = Carbon::parse($request->dari ?? now());
        $sampai = Carbon::parse($request->sampai ?? now());

        $data = [];

        // Ambil semua bulan-tahun dalam range filter
        $bulanTahun = collect($dari->copy()->startOfMonth()->monthsUntil($sampai->copy()->startOfMonth()))
            ->map(fn($d) => [$d->format('m'), $d->format('Y')])
            ->unique()
            ->values();

        foreach ($bulanTahun as [$bulan, $tahun]) {
            $jadwal = DB::table('kepegawaian_jadwal as kj')
                ->join('kepegawaian_jadwal_detail as kd', function ($join) {
                    $join->on('kd.id_jadwal', '=', 'kj.id')->whereNull('kd.deleted_at');
                })
                ->join('users as u', 'u.id', '=', 'kd.pegawai_id')
                ->join('referensi_jadwal_users as rju', DB::raw('JSON_CONTAINS(rju.staf, JSON_QUOTE(CAST(kd.pegawai_id AS CHAR)))'), '=', DB::raw('TRUE'))
                ->where('kj.bulan', $bulan)
                ->where('kj.tahun', $tahun)
                ->where('kj.progress', '!=', 0)
                ->whereNull('kj.deleted_at')
                ->select('kd.*', 'u.nip', 'u.nama', 'rju.unit')
                ->get();

            foreach ($jadwal as $row) {
                // Tentukan rentang tanggal yang akan dicek untuk bulan ini
                $startTgl = ((int)$bulan === (int)$dari->format('m') && (int)$tahun === (int)$dari->format('Y'))
                            ? (int) $dari->format('d')
                            : 1;
                $endTgl = ((int)$bulan === (int)$sampai->format('m') && (int)$tahun === (int)$sampai->format('Y'))
                            ? (int) $sampai->format('d')
                            : cal_days_in_month(CAL_GREGORIAN, (int)$bulan, (int)$tahun);

                for ($i = $startTgl; $i <= $endTgl; $i++) {
                    if (!checkdate((int)$bulan, $i, (int)$tahun)) continue;

                    $kode = $row->{'tgl'.$i} ?? null;
                    if (!$kode) continue;

                    $jenisCuti = match($kode) {
                        'C'  => 'Cuti Tahunan',
                        'CM' => 'Cuti Melahirkan',
                        'CU' => 'Cuti Umroh',
                        'CH' => 'Cuti Haji',
                        'CD' => 'Cuti di Luar Tanggungan',
                        default => null
                    };

                    if ($jenisCuti) {
                        $tanggal = Carbon::createFromDate($tahun, $bulan, $i);
                        $data[] = [
                            'nip' => $row->nip,
                            'nama' => $row->nama,
                            'unit' => $row->unit,
                            'tanggal_cuti' => $tanggal->translatedFormat('d F Y'),
                            'jenis_cuti' => $jenisCuti
                        ];
                    }
                }
            }
        }

        return response()->json($data);
    }

    function getMonitoringAbsensiHarian(Request $request)
    {
        $tanggal = Carbon::parse($request->tanggal ?? now())->format('Y-m-d');
        $tglHari = (int)Carbon::parse($tanggal)->format('d');
        $bulan   = Carbon::parse($tanggal)->format('m');
        $tahun   = Carbon::parse($tanggal)->format('Y');
        $unitIds = json_decode($request->input('unit'), true) ?? [];

        $data = [];

        // Ambil semua referensi_jadwal_users (unit dan staf)
        $rjuList = DB::table('referensi_jadwal_users')
            ->whereNull('deleted_at')
            ->when(!empty($unitIds), fn($q) => $q->whereIn('id', $unitIds))
            ->get();

        // Mapping: pegawai_id -> unit & pegawai_induk
        $pegawaiUnitMap = collect();
        $pegawaiIndukMap = collect();
        foreach ($rjuList as $rju) {
            $stafList = json_decode($rju->staf ?? '[]', true);
            foreach ($stafList as $id) {
                $pegawaiUnitMap[$id] = $rju->unit;
                $pegawaiIndukMap[$id] = $rju->pegawai_id;
            }
        }

        // Ambil semua pegawai yang dijadwalkan di tanggal tersebut
        $jadwalList = DB::table('kepegawaian_jadwal as kj')
            ->join('kepegawaian_jadwal_detail as kd', function ($join) {
                $join->on('kd.id_jadwal', '=', 'kj.id')->whereNull('kd.deleted_at');
            })
            ->leftJoin('users as u', 'u.id', '=', 'kd.pegawai_id')
            ->where('kj.bulan', $bulan)
            ->where('kj.tahun', $tahun)
            ->where('kj.progress', '!=', 0)
            ->whereNull('kj.deleted_at')
            ->select('kd.*', 'u.nip', 'u.nama')
            ->get();

        foreach ($jadwalList as $row) {
            if (!isset($pegawaiUnitMap[$row->pegawai_id])) continue;

            $kodeShift = $row->{'tgl'.$tglHari} ?? null;
            if (!$kodeShift) continue;

            $unit = $pegawaiUnitMap[$row->pegawai_id] ?? null;
            $pegawaiInduk = $pegawaiIndukMap[$row->pegawai_id] ?? null;

            $statusDisiplin = '-';
            $statusAbsensi = 'Belum Absen / Alpha';
            $jamBerangkat = '00:00:00';
            $jamPulang = '00:00:00';
            $absenBerangkat = '-';
            $absenPulang = '-';

            // Ambil absensi
            $absen = DB::table('kepegawaian_absensi')
                ->where('pegawai_id', $row->pegawai_id)
                ->whereDate('tgl_in', $tanggal)
                ->whereNull('deleted_at')
                ->orderBy('tgl_in')
                ->first();

            // Ambil shift info
            $shift = null;
            if (!in_array($kodeShift, ['C', 'CM', 'CU', 'CH', 'CD', 'L']) && $pegawaiInduk) {
                $shift = DB::table('referensi_jadwal_shift')
                    ->where('pegawai_id', $pegawaiInduk)
                    ->where('singkat', $kodeShift)
                    ->whereNull('deleted_at')
                    ->first();

                $jamBerangkat = $shift->berangkat ?? '00:00:00';
                $jamPulang = $shift->pulang ?? '00:00:00';
            }

            $labelCuti = match($kodeShift) {
                'C'  => 'Cuti Tahunan',
                'CM' => 'Cuti Melahirkan',
                'CU' => 'Cuti Umroh',
                'CH' => 'Cuti Haji',
                'CD' => 'Cuti di Luar Tanggungan',
                'L'  => 'Libur',
                default => null
            };

            // Status Shift dan Disiplin
            if ($absen && $absen->jenis == 3) {
                $statusDisiplin = 'Toleransi';
                $statusShift = $labelCuti
                    ? $labelCuti . ' (Izin)'
                    : ($shift ? 'Masuk Shift ' . $shift->shift . ' (Izin)' : 'Masuk Shift ' . $kodeShift . ' (Izin)');
                $statusAbsensi = '-'; // Izin dianggap pengecualian
            } elseif ($absen && $absen->jenis == 4) {
                $statusDisiplin = 'Toleransi';
                $statusShift = $labelCuti
                    ? $labelCuti . ' (Dinas Luar)'
                    : ($shift ? 'Masuk Shift ' . $shift->shift . ' (Dinas Luar)' : 'Masuk Shift ' . $kodeShift . ' (Dinas Luar)');
                $statusAbsensi = '-'; // Dinas Luar dianggap pengecualian
            } elseif ($labelCuti) {
                $statusShift = $labelCuti;
                $statusDisiplin = '-';
                $statusAbsensi = '-';
            } else {
                $statusShift = $shift
                    ? 'Masuk Shift ' . $shift->shift
                    : 'Masuk Shift ' . $kodeShift;

                if ($absen) {
                    $jamMasuk = Carbon::parse($absen->tgl_in)->format('H:i:s');
                    $absenBerangkat = $jamMasuk;

                    if (!is_null($absen->tgl_out)) {
                        $absenPulang = Carbon::parse($absen->tgl_out)->format('H:i:s');
                        $statusAbsensi = 'Lengkap';
                    } elseif ($absen->jenis == 1) {
                        $statusAbsensi = 'Absen 1x / Tidak Lengkap';
                    }

                    $toleransiJamBerangkat = Carbon::parse($shift->berangkat)->addMinutes(10)->format('H:i:s');
                    $statusDisiplin = ($jamBerangkat && $jamMasuk > $toleransiJamBerangkat)
                        ? 'Terlambat'
                        : 'Tepat Waktu';
                }

                // JIKA REF SHIFT BERISI 00:00 - 00:00
                if ($shift && $shift->berangkat == '00:00:00' && $shift->pulang == '00:00:00') {
                    $statusShift = '<b class="text-danger">Shift Tidak Valid</b> ( KODE = '.($kodeShift ? $kodeShift : 'NULL').' )';
                    $statusDisiplin = '-';
                    $statusAbsensi = 'Tidak Valid';
                }
            }

            $data[] = [
                'id' => $absen->id ?? null,
                'nip' => $row->nip,
                'nama' => $row->nama,
                'unit' => $unit,
                'kd_shift' => $kodeShift,
                'status_shift' => $statusShift ?? '-',
                'status_disiplin' => $statusDisiplin,
                'status_absensi' => $statusAbsensi,
                'jam_berangkat' => $jamBerangkat,
                'jam_pulang' => $jamPulang,
                'absen_berangkat' => $absenBerangkat,
                'absen_pulang' => $absenPulang,
            ];
        }

        return response()->json($data);
    }

    function getBuktifFotoPegawai(Request $request)
    {
        $unit_ids = json_decode($request->input('unit'), true);
        $jenis = $request->jenis;

        $dari = $request->dari ? Carbon::parse($request->dari)->format('Y-m-d') : now()->format('Y-m-d');
        $sampai = $request->sampai ? Carbon::parse($request->sampai)->format('Y-m-d') : now()->format('Y-m-d');

        $show = DB::table('kepegawaian_absensi as a')
            ->join('users as u', 'u.id', '=', 'a.pegawai_id')
            ->leftJoin('referensi_jadwal_users as rju', function ($join) {
                $join->on(DB::raw('JSON_CONTAINS(rju.staf, JSON_QUOTE(CAST(a.pegawai_id AS CHAR)))'), '=', DB::raw('TRUE'))
                    ->whereNull('rju.deleted_at');
            })
            ->select(
                'a.pegawai_id',
                'a.path_in as foto_berangkat',
                'a.path_out as foto_pulang',
                'u.nama',
                'u.nip',
                'rju.unit',
                DB::raw("DATE(a.tgl_in) as tanggal"),
                DB::raw("TIME(a.tgl_in) as jam_masuk"),
                DB::raw("IF(a.tgl_out IS NOT NULL, TIME(a.tgl_out), NULL) as jam_pulang"),
                DB::raw("IF(a.jenis = 1, IF(a.tgl_out IS NULL, 'Absen 1x', IF(a.terlambat = 1, 'Terlambat', 'Tepat Waktu')), 'Toleransi') as status_keterangan"),
                DB::raw("IF(a.jenis = 3, 1, 0) as is_ijin"),
                DB::raw("IF(a.jenis = 4, 1, 0) as is_dinas_luar"),
                DB::raw("IF(a.jenis = 1, IF(a.tgl_out IS NULL, 1, 0), 0) as is_alpha"),
                DB::raw("IF(a.jenis = 1, IF(a.tgl_out IS NOT NULL AND a.terlambat = 1, 1, 0), 0) as is_terlambat"),
                DB::raw("IF(a.jenis = 1, IF(a.tgl_out IS NOT NULL AND a.terlambat = 0, 1, 0), 0) as is_tidak_terlambat")
            )
            ->when(!empty($unit_ids), function ($query) use ($unit_ids) {
                $query->whereIn('rju.id', $unit_ids);
            })
            ->when($jenis != 0, function ($query) use ($jenis) {
                $query->where('a.jenis', $jenis);
            })
            ->whereBetween('a.tgl_in', [$dari . ' 00:00:00', $sampai . ' 23:59:59'])
            ->whereNull('a.deleted_at')
            ->orderBy('a.pegawai_id')
            ->orderBy('a.tgl_in')
            ->get();

        $data = [
            'show' => $show,
        ];

        return response()->json($data);
    }

    function detail($id)
    {
        $show = absensi::where('id',$id)->first();

        $data = [
            'show' => $show,
        ];

        return response()->json($data);
    }

    function getUbah($id)
    {
        $show = DB::table('kepegawaian_absensi as a')
            ->join('users as u', 'u.id', '=', 'a.pegawai_id')
            ->leftJoin('referensi_jadwal_users as rju', function ($join) {
                $join->on(DB::raw('JSON_CONTAINS(rju.staf, JSON_QUOTE(CAST(a.pegawai_id AS CHAR)))'), '=', DB::raw('TRUE'))
                    ->whereNull('rju.deleted_at');
            })
            ->select('a.*','rju.pegawai_id as id_admin_jadwal','rju.staf','rju.unit')
            ->where('a.id',$id)
            ->whereNull('a.deleted_at')
            ->first();

        $shift = DB::table('referensi_jadwal_shift')
            ->whereIn('pegawai_id', json_decode($show->staf, true))
            ->whereNull('deleted_at')
            ->orderBy('berangkat','asc')
            ->get();

        $data = [
            'show' => $show,
            'shift' => $shift,
        ];

        return response()->json($data);
    }

    function ubah(Request $request)
    {
        $request->validate([
            'id' => ['required'],
            'shift' => ['required'],
            'masuk' => ['required'],
        ]);

        $push = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');
        $now = Carbon::now('Asia/Jakarta');
        $dateMasuk = Carbon::parse($request->masuk)->isoFormat('YYYY/MM/DD');
        $dateMasukTommorow = Carbon::parse($request->masuk)->addDay()->isoFormat('YYYY/MM/DD');
        // $today = $now->toDateString();
        // $tommorow = $now->copy()->addDay()->toDateString();

        // GET SHIFT
        $shift = ref_jadwal_shift::find($request->shift);
        $jam_masuk = Carbon::parse($shift->berangkat);
        $jam_pulang = Carbon::parse($shift->pulang);

        // VALIDASI LEWAT HARI
        if ($jam_pulang->greaterThan($jam_masuk)) {
            $ref_berangkat = Carbon::parse($dateMasuk.' '.$shift->berangkat);
            $ref_pulang = Carbon::parse($dateMasuk.' '.$shift->pulang);
            $lewathari = 1;
        } else {
            $ref_berangkat = Carbon::parse($dateMasuk.' '.$shift->berangkat);
            $ref_pulang = Carbon::parse($dateMasukTommorow.' '.$shift->pulang);
            $lewathari = 0;
        }

        // print_r($ref_berangkat);
        // print_r($ref_pulang);
        // die();
        if ($shift) {
            $data = absensi::find($request->id);
            $data->kd_shift = $shift->singkat;
            $data->nm_shift = $shift->shift;
            $data->ref_jam_masuk = $ref_berangkat;
            $data->ref_jam_pulang = $ref_pulang;

            // BERANGKAT
            if ($request->masuk) {
                $data->tgl_in = Carbon::parse($request->masuk);

                $awalBerangkat = new Carbon($request->masuk);
                $initHarusnyaBerangkat = Carbon::parse($ref_berangkat)->addMinutes(10);
                $harusnyaBerangkat = new Carbon($initHarusnyaBerangkat);

                // SAVE DATA
                if ($awalBerangkat->gt($harusnyaBerangkat)) {
                    $data->keterlambatan = $awalBerangkat->diff($harusnyaBerangkat)->format('%H:%I:%S');
                    $data->terlambat = 1; // TERLAMBAT
                } else {
                    $data->keterlambatan = Carbon::parse('00:00:00')->isoFormat('HH:mm:ss');
                    $data->terlambat = 0; // DISIPLIN
                }
            }

            // PULANG
            if ($request->pulang) {
                // PERHITUNGAN LEMBUR JAM PULANG
                $jam_pulang_seharusnya = new Carbon($ref_pulang);
                $jam_pulang_awal = new Carbon($request->pulang);
                $diffLembur = $jam_pulang_seharusnya->diff($jam_pulang_awal)->format('%H:%I:%S');

                if ($jam_pulang_seharusnya->gt($jam_pulang_awal)) {
                    return Response::json(array(
                        'message' => "Jam Absensi Pulang kurang dari referensi jam shift pulang yang sudah ditetapkan. Silakan periksa Absensi Pulang sekali lagi.",
                        'code' => 404,
                    ));
                }

                // PERHITUNGAN SELISIH JAM SAAT MASUK SAMPAI PULANG
                $jam_berangkat_tercatat = new Carbon($request->masuk ?? $data->tgl_in);
                $diffKerja = $jam_berangkat_tercatat->diff($jam_pulang_awal)->format('%H:%I:%S');

                // SAVE DATA
                $data->lembur = $diffLembur;
                $data->selisih_jam = $diffKerja;
                $data->tgl_out = Carbon::parse($request->pulang);

                if ($data->jenis == 1 && !$data->tgl_out) {
                    $title = uniqid() . '.png';
                    // path asal di public/images
                    $path_original = public_path("images/no-image.jpeg");
                    $path_moved = "public/files/kepegawaian/absensi/ijin/";
                    // simpan ke storage
                    Storage::put(
                        $path_moved . $title,
                        file_get_contents($path_original)
                    );

                    // SAVE DATA
                    $data->lokasi_out     = "-7.677851238136329, 110.83968584828327";
                    $data->foto_out       = $title;
                    $data->path_out       = 'public/files/kepegawaian/absensi/ijin/' . $title;
                }
            }

            $data->lewat_hari = $lewathari;
            $data->edit_user = $request->user;
            $data->edit_tgl = $now;
            // if ($data->jenis == 3 || $data->jenis == 4) {
            //     $data->keterangan = $request->ket;
            // } // SEMENTARA INI UBAH HANYA PADA ABSENSI SHIFT (JENIS = 1)
            $data->save();

            return Response::json(array(
                'message' => $push,
                'code' => 200,
            ));
        } else {
            return Response::json(array(
                'message' => "Shift tidak valid atau tidak ditemukan",
                'code' => 404,
            ));
        }
    }

    function hapus($id, $user)
    {
        $now = Carbon::now();
        $push = $now->isoFormat('dddd, D MMMM Y, HH:mm a');

        // Inisialisasi
        $data = absensi::find($id);
        $data->user_deleted_at = $user;

        // Proses Hapus Lampiran
        Storage::delete(str_replace('public/', '', $data->path_in));
        if ($data->path_out) {
            Storage::delete(str_replace('public/', '', $data->path_out));
        }

        // Save DB
        $data->save();

        // Hapus Record DB
        $data->delete();

        return response()->json($push, 200);
    }
}
