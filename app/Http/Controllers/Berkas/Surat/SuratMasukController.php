<?php

namespace App\Http\Controllers\Berkas\Surat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use App\Models\roles;
use App\Models\surat_masuk;
use App\Models\disposisi;
use App\Models\User;
use Carbon\Carbon;
use Validator,Redirect,Response,File;
use Exception;
use Storage;
use Auth;

class SuratMasukController extends Controller
{
    public function index()
    {
        if (Auth::user()->getPermission('surat_masuk') == true) {
            $user = User::role('staf-sekretariatan')->select('id','nama')->get();
            $year = Carbon::now()->isoFormat('YYYY');

            $data = [
                'user' => $user,
                'year' => $year,
            ];
            return view('pages.berkas.surat.suratmasuk.index')->with('list', $data); //
        } else {
            return redirect()->back();
        }
    }

    function changeModelTypeUser()
    {
        DB::table('model_has_roles')
            ->where('model_type', 'App\User')
            ->update(['model_type' => 'App\Models\User']);
        print_r('berhasil.');
        die();
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => ['max:5000','mimes:pdf'],
            'tgl_diterima' => 'required',
            'no_surat' => 'required',
            'asal' => 'required',
            'nomor' => 'required',
            'user' => 'required'
        ]);

        if ($request->waktu == null) {
            $tglFrom    = null;
            $tglTo      = null;
        } else {
            if (strlen($request->waktu) == 10) {
                $tglFrom    = $request->waktu;
                $tglTo      = null;
            } else {
                $dates = explode(' to ', $request->waktu);

                $tglFrom = Carbon::parse($dates[0]);
                $tglTo = Carbon::parse($dates[1]);
            }
        }

        $getFile = $request->file('file');
        if ($getFile == null) {
            $path = null;
            $title = null;
        } else {
            $find = surat_masuk::where('title',$getFile->getClientOriginalName())->first();
            // simpan berkas yang diunggah ke sub-direktori $path
            // direktori 'files' otomatis akan dibuat jika belum ada
            if ($find == null) {
                $path = $getFile->store('public/files/tu/suratmasuk');
                $title = $getFile->getClientOriginalName();
            } else {
                return redirect()->back()->withErrors('Maaf, Nama file '.$getFile->getClientOriginalName().' sudah pernah diupload. Mohon Ganti Nama File yang berbeda. Disarankan untuk menambahkan kode yang unik pada File Anda.');
            }
        }

        $getUrutan = surat_masuk::orderBy('urutan','DESC')->first();
        if (empty($getUrutan->urutan)) {
            $urutan = 1;
        } else {
            $urutan = $getUrutan->urutan + 1;
        }

        $data               = new surat_masuk;
        $data->urutan       = $request->no_surat;
        $data->tgl_surat    = $request->tgl_surat;
        $data->tgl_diterima = $request->tgl_diterima;
        $data->asal         = $request->asal;
        $data->nomor        = $request->nomor;
        $data->deskripsi    = $request->deskripsi;
        $data->tempat       = $request->tempat;
        $data->tglFrom      = $tglFrom;
        $data->tglTo        = $tglTo;
        $data->title        = $title;
        $data->filename     = $path;
        $data->user         = $request->user;

        $data->save();
        return redirect::back()->with('message','Tambah Berkas Surat Masuk Berhasil!');
    }

    // API
    public function apiGet()
    {
        $show = surat_masuk::orderBy('created_at','DESC')->limit(100)->get();
        $user = User::get();

        $data = [
            'user' => $user,
            'show' => $show,
        ];

        return response()->json($data, 200);
    }

    public function formTambah()
    {
        $tahun = Carbon::now()->isoFormat('YYYY');
        $show = surat_masuk::orderBy('urutan','DESC')->whereYear('tgl_diterima', '=', $tahun)->first();

        if ($show == null) {
            $show = 1;
        } else {
            $show = $show->urutan + 1;
        }

        $data = [
            'show' => $show,
        ];

        return response()->json($data, 200);
    }

    function getFilterSurat($bulan, $tahun)
    {
        $show = surat_masuk::orderBy('tgl_diterima','DESC');
                If($bulan != "0"){
                    $show->whereMonth('tgl_diterima', '=', $bulan);
                }
                If($tahun != "0"){
                    $show->whereYear('tgl_diterima', '=', $tahun);
                }
        $show = $show->get();

        $data = [
            'show' => $show,
        ];

        return response()->json($data, 200);
    }

    public function apiGetAll()
    {
        $show = surat_masuk::orderBy('created_at','DESC')->get();
        $user = User::get();

        $data = [
            'user' => $user,
            'show' => $show,
        ];

        return response()->json($data, 200);
    }

    public function apiGetDisposisi($id)
    {
        $show = disposisi::where('id_surat',$id)->get();
        $user = User::get();
        $roles = roles::orderBy('name','ASC')->get();

        $data = [
            'show' => $show,
            'user' => $user,
            'roles' => $roles,
        ];

        return response()->json($data, 200);
    }

    public function download($id)
    {
        $data = surat_masuk::find($id);
        return Storage::download($data->filename, $data->title);
    }

    public function showChange($id)
    {
        $show = surat_masuk::find($id);
        $user = User::role('staf-sekretariatan')->select('id','nama')->get();

        if ($show->tglTo == null) {
            $tglFrom = Carbon::parse($show->tglFrom)->isoFormat('YYYY-MM-DD');
            $waktu = $tglFrom;
        } else {
            $tglFrom = Carbon::parse($show->tglFrom)->isoFormat('YYYY-MM-DD');
            $tglTo = Carbon::parse($show->tglTo)->isoFormat('YYYY-MM-DD');
            $waktu = $tglFrom.' to '.$tglTo;
        }

        $data = [
            'user' => $user,
            'show' => $show,
            'waktu' => $waktu,
        ];

        return response()->json($data, 200);
    }

    // public function update(Request $request, $id)
    // {
    //     // $getFile = $request->file('file');
    //     // print_r($getFile->getClientOriginalName());
    //     // die();
    //     $now = Carbon::now()->isoFormat('YYYY-MM-DD HH:mm:ss');

    //     $data = surat_masuk::find($id);
    //     $data->tgl_surat    = $request->tgl_surat;
    //     $data->tgl_diterima = $request->tgl_diterima;
    //     $data->asal         = $request->asal;
    //     $data->nomor        = $request->nomor;
    //     $data->deskripsi    = $request->deskripsi;
    //     $data->tempat       = $request->tempat;
    //     $data->user         = $request->user;

    //     if ($request->waktu == null) {
    //         $tglFrom    = null;
    //         $tglTo      = null;
    //     } else {
    //         if (strlen($request->waktu) == 10) {
    //             $tglFrom    = $request->waktu;
    //             $tglTo      = null;
    //         } else {
    //             $dates = explode(' to ', $request->waktu);

    //             $tglFrom = Carbon::parse($dates[0]);
    //             $tglTo = Carbon::parse($dates[1]);
    //         }
    //     }

    //     $data->tglFrom      = $tglFrom;
    //     $data->tglTo        = $tglTo;

    //     if ($data->filename == null) {
    //         if ($request->file('file')) {
    //             $path = $getFile->store('public/files/tu/suratmasuk');
    //             $title = $getFile->getClientOriginalName();
    //         } else {
    //             $path = null;
    //             $title = null;
    //         }
    //     }

    //     $data->save();

    //     return response()->json($now, 200);
    // }

    public function ubah(Request $request)
    {
        // $data = array();

        // $validator = Validator::make($request->all(), [
        //    'file' => 'required'
        // ]);

        // if ($validator->fails()) {

        //    $data['success'] = 0;
        //    $data['error'] = $validator->errors()->first('file');// Error response

        // }else{

        // }

        $now = Carbon::now()->isoFormat('YYYY-MM-DD HH:mm:ss');

        $data = surat_masuk::find($request->id_edit);
        $data->tgl_surat    = $request->tgl_surat;
        $data->tgl_diterima = $request->tgl_diterima;
        $data->asal         = $request->asal;
        $data->nomor        = $request->nomor;
        $data->deskripsi    = $request->deskripsi;
        $data->tempat       = $request->tempat;
        $data->user         = $request->user;

        if ($request->waktu == null) {
            $tglFrom    = null;
            $tglTo      = null;
        } else {
            if (strlen($request->waktu) == 10) {
                $tglFrom    = $request->waktu;
                $tglTo      = null;
            } else {
                $dates = explode(' to ', $request->waktu);

                $tglFrom = Carbon::parse($dates[0]);
                $tglTo = Carbon::parse($dates[1]);
            }
        }

        $data->tglFrom      = $tglFrom;
        $data->tglTo        = $tglTo;

        if ($data->filename == null) {
            if ($request->file('file') && $request->file('file')->isValid()) {
                $data->filename = $request->file('file')->store('public/files/tu/suratmasuk');
                $data->title = $request->file('file')->getClientOriginalName();
            }
        } else {
            $request->validate([
                'file' => ['max:20000','mimes:pdf'],
            ]);
            $fileDeleted = $data->filename;
            Storage::delete($fileDeleted);
            if ($request->file('file') && $request->file('file')->isValid()) {
                $data->filename = $request->file('file')->store('public/files/tu/suratmasuk');
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
        $hapusData = surat_masuk::find($id);

        // Proses Hapus
        $file = $hapusData->filename;
        // Storage::delete($file);
        $hapusData->delete();

        return response()->json($tgl, 200);
    }

    // AUTOCOMPLETE
    public function acAsal(Request $request)
    {
        $getData = surat_masuk::select("asal")
                        ->where("asal","LIKE","%{$request->cari}%")
                        ->groupBy ('asal')
                        ->get();

        $data = [];
        foreach ($getData as $item)
        {
            array_push($data, $item->asal);
        }

        return response()->json($data);
    }

    // AUTOCOMPLETE
    public function acTempat(Request $request)
    {
        $getData = surat_masuk::select("tempat")
                        ->where("tempat","LIKE","%{$request->cari}%")
                        ->groupBy ('tempat')
                        ->get();

        $data = [];
        foreach ($getData as $item)
        {
            array_push($data, $item->tempat);
        }

        return response()->json($data);
    }
}
