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

class AbsensiDashboardController extends Controller
{
    protected $dari;
    protected $sampai;

    // Function construct
    public function __construct()
    {
        // Gunakan Carbon untuk manipulasi tanggal
        $now = Carbon::now();

        // Tanggal 21 - 20
        $this->dari = $now->copy()->subMonthNoOverflow()->day(21)->format('Y-m-d');
        $this->sampai = $now->copy()->day(20)->format('Y-m-d');

        // Tanggal 1 - 27/30/31
        // $this->dari = $now->copy()->startOfMonth()->format('Y-m-d');
        // $this->sampai = $now->copy()->endOfMonth()->format('Y-m-d');
    }

    function index()
    {
        if (
                Auth::user()->getPermission('admin_kepegawaian') == true ||
                Auth::user()->getPermission('admin_kepegawaian_kepala') == true
            ) {


            $data = [
                // 'users' => $users,
            ];

            return view('pages.kepegawaian.absensi.dashboard')->with('list', $data);
        } else {
            return redirect()->back()->withErrors("Maaf, Anda tidak memiliki akses untuk membuka halaman Dashboard Absensi Karyawan!");
        }
    }

    public function grafik1()
    {
        $dari   = $this->dari;
        $sampai = $this->sampai;

        $kodeLibur = ['C','CM','CU','CH','CD','L'];
        $tahunSekarang = date('Y');

        $periode = collect();
        for ($bulan = 1; $bulan <= 12; $bulan++) {
            $periode->push(sprintf('%04d-%02d', $tahunSekarang, $bulan));
        }

        $result = [
            'labels' => [],
            'pegawai_total' => [],
            'series' => [
                ['name' => 'Disiplin', 'data' => []],
                ['name' => 'Terlambat', 'data' => []],
                ['name' => 'Mangkir', 'data' => []],
            ],
            'debug' => [],
            'periode' => ['dari' => Carbon::parse($dari)->isoFormat('D'), 'sampai' => Carbon::parse($sampai)->isoFormat('D')]
        ];

        foreach ($periode as $bulan) {
            $bulanInt = intval(substr($bulan, 5, 2));
            $tahunInt = intval(substr($bulan, 0, 4));

            $jadwal = DB::table('kepegawaian_jadwal_detail as d')
                ->join('kepegawaian_jadwal as j', function ($join) {
                    $join->on('j.id', '=', 'd.id_jadwal')->whereNull('j.deleted_at');
                })
                ->where('j.bulan', $bulanInt)
                ->where('j.tahun', $tahunInt)
                ->whereNull('d.deleted_at')
                ->get();

            // total kumulatif semua pegawai
            $totalHariKerja = 0;
            $totalDisiplin  = 0;
            $totalTerlambat = 0;
            $totalTidakAbsensi = 0;

            foreach ($jadwal as $row) {
                $pegawai_id = $row->pegawai_id;

                $lastDay = cal_days_in_month(CAL_GREGORIAN, $bulanInt, $tahunInt);
                for ($i = 1; $i <= $lastDay; $i++) {
                    $kolom = 'tgl' . $i;
                    $kodeShift = $row->$kolom;

                    if (empty($kodeShift) || in_array($kodeShift, $kodeLibur)) continue;

                    $totalHariKerja++;
                    $tanggalCek = sprintf('%04d-%02d-%02d', $tahunInt, $bulanInt, $i);

                    $absen = DB::table('kepegawaian_absensi')
                        ->where('jenis',1)
                        ->where('pegawai_id', $pegawai_id)
                        ->whereDate('tgl_in', $tanggalCek)
                        ->whereNull('deleted_at')
                        ->first();

                    if ($absen) {
                        // Terlambat jika tgl_out null atau terlambat = 1
                        $isTerlambat = $absen->terlambat == 1 || is_null($absen->tgl_out);
                        if ($isTerlambat) {
                            $totalTerlambat++;
                        } else {
                            $totalDisiplin++;
                        }
                    } else {
                        $totalTidakAbsensi++;
                    }
                }
            }

            // Hitung persentase berbasis total kumulatif
            $persenDisiplin = $totalHariKerja ? round(($totalDisiplin / $totalHariKerja) * 100, 2) : 0;
            $persenTerlambat = $totalHariKerja ? round(($totalTerlambat / $totalHariKerja) * 100, 2) : 0;
            $persenTidakAbsensi = $totalHariKerja ? round(($totalTidakAbsensi / $totalHariKerja) * 100, 2) : 0;

            $namaBulan = Carbon::create($tahunInt, $bulanInt, 1)->locale('id')->isoFormat('MMM');
            $result['labels'][] = $namaBulan;

            $result['pegawai_total'][] = count($jadwal);

            $result['series'][0]['data'][] = $persenDisiplin;
            $result['series'][1]['data'][] = $persenTerlambat;
            $result['series'][2]['data'][] = $persenTidakAbsensi;

            $result['debug'][$bulan] = [
                'pegawai_total' => count($jadwal),
                'disiplin_%' => $persenDisiplin,
                'terlambat_%' => $persenTerlambat,
                'tidakabsen_%' => $persenTidakAbsensi
            ];
        }

        return response()->json($result);
    }
}
