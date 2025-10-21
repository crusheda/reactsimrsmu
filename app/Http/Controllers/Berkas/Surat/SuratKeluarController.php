<?php

namespace App\Http\Controllers\Berkas\Surat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use App\Models\kode_surat_keluar;
use App\Models\surat_keluar;
use App\Models\User;
use Carbon\Carbon;
use Validator,Redirect,Response,File;
use Exception;
use Storage;
use Auth;

class SuratKeluarController extends Controller
{
    public function index()
    {
        if (Auth::user()->getPermission('surat_keluar') == true) {
            $user = User::role('staf-sekretariatan')->select('id','nama')->get();
            $users = user::whereNotNull('nik')->where('status',null)->orderBy('nama','ASC')->get();
            $kode = kode_surat_keluar::orderBy('nama','ASC')->get();
            $year = Carbon::now()->isoFormat('YYYY');
            $lastyear = Carbon::now()->subYear()->isoFormat('YYYY');

            $checkData = surat_keluar::get();

            if (empty($checkData)) {
                // $urutan = 1;
                $urutan = sprintf("%03d", 1);
                $urutanLastYear = sprintf("%03d", 1);
            } else {
                $getUrutan = surat_keluar::where( DB::raw('YEAR(tgl)'), '=', $year )->orderBy('urutan','DESC')->first();
                $getUrutanLast = surat_keluar::where( DB::raw('YEAR(tgl)'), '=', $lastyear )->orderBy('urutan','DESC')->first();
                if (empty($getUrutan->urutan)) {
                    $urutan = sprintf("%03d", 1);
                } else {
                    $urutan = sprintf("%03d", $getUrutan->urutan + 1);
                }
                if (empty($getUrutanLast->urutan)) {
                    $urutanLastYear = sprintf("%03d", 1);
                } else {
                    $urutanLastYear = sprintf("%03d", $getUrutanLast->urutan + 1);
                }
                // if (Carbon::parse($getUrutan->tgl)->isoFormat('YYYY') !== $year) {
                //     $urutan = sprintf("%03d", 1);
                // } else {
                //     $urutan = sprintf("%03d", $getUrutan->urutan + 1);
                // }
                // $query_string = "SELECT * FROM berkas_surat_keluar WHERE YEAR(tgl) = $lastyear AND deleted_at IS NULL ORDER BY urutan DESC";
                // $urutanLastYear = sprintf("%03d", ((DB::select($query_string))[0]->urutan + 1));
            }
            // print_r(DB::select($query_string));
            // die();

            $data = [
                'user' => $user,
                'users' => $users,
                'kode' => $kode,
                'urutan' => $urutan,
                'urutanlastyear' => $urutanLastYear,
                'year' => $year,
                'lastyear' => $lastyear,
            ];

            return view('pages.berkas.surat.suratkeluar.index')->with('list', $data);
        } else {
            return redirect()->back();
        }
    }

    public function apiKode($id)
    {
        $data = kode_surat_keluar::find($id);

        return response()->json($data->kode, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => ['max:5000','mimes:pdf'],
            'kode' => 'required',
            'tgl' => 'required',
            // 'tujuan' => 'required',
            'user' => 'required'
        ]);

        $tahunNow = Carbon::now()->isoFormat('YYYY');
        $lastyear = Carbon::now()->subYear()->isoFormat('YYYY');
        $getJenis = kode_surat_keluar::where('id',$request->kode)->first();
        $checkData = surat_keluar::get();
        $checkTgl = Carbon::parse($request->tgl)->isoFormat('YYYY');

        if (empty($checkData)) {
            $urutan = 1;
            if ($request->tahunlalu == '1') {
                $tahun = $lastyear;
            } else {
                $tahun = $tahunNow;
            }
        } else {
            if ($request->tahunlalu == '1') {
                if ($checkTgl != $lastyear) {
                    return redirect()->back()->withErrors('Maaf, tanggal yang Anda masukkan tidak cocok. Mohon sesuaikan tanggal dan tahun Surat');
                } else {
                    // $query_string = "SELECT * FROM berkas_surat_keluar WHERE YEAR(tgl) = $lastyear AND deleted_at IS NULL ORDER BY urutan DESC";
                    // $getUrutan = DB::select($query_string);
                    // $urutan = $getUrutan[0]->urutan + 1;
                    $getUrutan = surat_keluar::where( DB::raw('YEAR(tgl)'), '=', $lastyear )->orderBy('urutan','DESC')->first();
                    if (empty($getUrutan)) {
                        $urutan = 1;
                    } else {
                        $urutan = $getUrutan->urutan + 1;
                    }
                    $tahun = $lastyear;
                }
            } else {
                if ($checkTgl != $tahunNow) {
                    return redirect()->back()->withErrors('Maaf, tanggal yang Anda masukkan tidak cocok. Mohon sesuaikan tanggal dan tahun Surat');
                } else {
                    $getUrutan = surat_keluar::where( DB::raw('YEAR(tgl)'), '=', $tahunNow )->orderBy('urutan','DESC')->first();
                    if (empty($getUrutan)) {
                        $urutan = 1;
                    } else {
                        $urutan = $getUrutan->urutan + 1;
                    }
                    $tahun = $tahunNow;
                }
            }
        }

        $getFile = $request->file('file');
        if ($getFile == null) {
            $path = null;
            $title = null;
        } else {
            // simpan berkas yang diunggah ke sub-direktori $path
            // direktori 'files' otomatis akan dibuat jika belum ada
            $find = surat_keluar::where('title',$getFile->getClientOriginalName())->first();
            if ($find == null) {
                $path = $getFile->store('public/files/tu/suratkeluar');
                $title = $getFile->getClientOriginalName();
            } else {
                return redirect()->back()->withErrors('Maaf, Nama file '.$getFile->getClientOriginalName().' sudah pernah diupload. Mohon Ganti Nama File yang berbeda. Disarankan untuk menambahkan kode yang unik pada File Anda.');
            }
        }

        $data               = new surat_keluar;
        $data->urutan       = $urutan;
        $data->kode         = $request->kode;
        $data->tgl          = $request->tgl;
        if ($request->tujuan2 != null) {
            $data->tujuan2  = $request->tujuan2;
        } else {
            $data->tujuan   = json_encode($request->tujuan);
        }
        $data->nomor        = sprintf("%03d", $urutan)."/".$getJenis->kode."/DIR/III.6.AU/PKUSKH/".$tahun;
        $data->jenis        = $getJenis->nama;
        $data->isi          = $request->isi;
        $data->pembuat      = $request->pembuat;
        $data->sesuai       = $request->sesuai;
        $data->title        = $title;
        $data->filename     = $path;
        $data->user         = $request->user;

        $data->save();
        return redirect::back()->with('message','Tambah Berkas Surat Keluar Berhasil!');
    }

    // API
    public function apiGet()
    {
        $user = User::get();
        $show = surat_keluar::join('berkas_surat_keluar_kode','berkas_surat_keluar_kode.id','=','berkas_surat_keluar.kode')
                            ->select('berkas_surat_keluar_kode.kode as kode_jenis','berkas_surat_keluar.*')
                            ->orderBy('berkas_surat_keluar.created_at','DESC')
                            ->limit(100)
                            ->get();
        $getUser = user::select('id','nama')->get();
        $users = json_encode($getUser);

        $data = [
            'show' => $show,
            'user' => $user,
            'users' => $users,
        ];

        return response()->json($data, 200);
    }

    public function apiGetAll()
    {
        $user = User::get();
        $show = surat_keluar::join('berkas_surat_keluar_kode','berkas_surat_keluar_kode.id','=','berkas_surat_keluar.kode')
                            ->select('berkas_surat_keluar_kode.kode as kode_jenis','berkas_surat_keluar.*')
                            ->orderBy('berkas_surat_keluar.created_at','DESC')
                            ->get();
        $getUser = user::select('id','nama')->get();
        $users = json_encode($getUser);

        $data = [
            'show' => $show,
            'user' => $user,
            'users' => $users,
        ];

        return response()->json($data, 200);
    }

    function getFilterSurat($surat,$bulan,$tahun)
    {
        $user = User::get();
        $show = surat_keluar::join('berkas_surat_keluar_kode','berkas_surat_keluar_kode.id','=','berkas_surat_keluar.kode')
                ->select('berkas_surat_keluar_kode.kode as kode_jenis','berkas_surat_keluar.*');
                If($surat != "0"){
                    $show->where('berkas_surat_keluar.kode',$surat);
                }
                If($bulan != "0"){
                    $show->whereMonth('tgl', '=', $bulan);
                }
                If($tahun != "0"){
                    $show->whereYear('tgl', '=', $tahun);
                }
        $show = $show->get();

        $getUser = user::select('id','nama')->get();
        $users = json_encode($getUser);

        $data = [
            'show' => $show,
            'user' => $user,
            'users' => $users,
        ];

        return response()->json($data, 200);
    }

    public function download($id)
    {
        $data = surat_keluar::find($id);
        return Storage::download($data->filename, $data->title);
    }

    public function showChange($id)
    {
        $user = User::role('staf-sekretariatan')->select('id','nama')->get();
        $users = user::whereNotNull('nik')->where('status',null)->orderBy('nama','ASC')->get();
        $show = surat_keluar::find($id);
        $getKode = kode_surat_keluar::where('id',$show->kode)->first();
        $refKode = kode_surat_keluar::get();

        $kode = $getKode->kode;
        $year = substr($show->nomor,-4);
        $urutan = sprintf("%03d", $show->urutan);

        $data = [
            'user' => $user,
            'users' => $users,
            'show' => $show,
            'refkode' => $refKode,
            'kode' => $kode,
            'year' => $year,
            'urutan' => $urutan,
        ];

        return response()->json($data, 200);
    }

    public function ubah(Request $request)
    {
        $data = array();

        $now = Carbon::now()->isoFormat('YYYY-MM-DD HH:mm:ss');

        $getJenis = kode_surat_keluar::where('id', $request->kode)->first();

        $data           = surat_keluar::find($request->id_edit);
        $data->nomor    = sprintf("%03d", $data->urutan)."/".$getJenis->kode."/DIR/III.6.AU/PKUSKH/".substr($data->nomor,-4);
        $data->kode     = $request->kode;
        $data->tgl      = $request->tgl;
        if ($request->tujuan2 != null) {
            if ($request->tujuan != null) {
                return redirect()->route('suratkeluar.index')->withErrors('Gagal proses ubah, silakan ulangi sekali lagi.');
            } else {
                $data->tujuan2  = $request->tujuan2;
            }
        } else {
            $data->tujuan   = "[".str_replace(',','","',json_encode($request->tujuan))."]";
        }
        $data->jenis    = $getJenis->nama;
        $data->isi      = $request->isi;
        $data->pembuat  = $request->pembuat;
        $data->sesuai   = $request->sesuai;
        $data->user     = $request->user;

        if ($data->filename == null) {
            if ($request->file('file') && $request->file('file')->isValid()) {
                $data->filename = $request->file('file')->store('public/files/tu/suratkeluar');
                $data->title = $request->file('file')->getClientOriginalName();
            }
        } else {
            $request->validate([
                'file' => ['max:20000','mimes:pdf'],
            ]);
            $fileDeleted = $data->filename;
            Storage::delete($fileDeleted);
            if ($request->file('file') && $request->file('file')->isValid()) {
                $data->filename = $request->file('file')->store('public/files/tu/suratkeluar');
                $data->title = $request->file('file')->getClientOriginalName();
            }
        }

        $data->save();

        return response()->json($now, 200);
    }

    public function hapus($id)
    {
        $tgl = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');

        // Inisialisasi
        $hapusData = surat_keluar::find($id);

        // Proses Hapus
        $file = $hapusData->filename;
        $hapusData->delete();

        return response()->json($tgl, 200);
    }
}
