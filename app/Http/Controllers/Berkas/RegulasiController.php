<?php

namespace App\Http\Controllers\Berkas;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
// use App\Models\regulasi\spo;
// use App\Models\regulasi\pedoman;
// use App\Models\regulasi\panduan;
// use App\Models\regulasi\program;
// use App\Models\regulasi\kebijakan;
use App\Models\berkas_regulasi;
use App\Models\unit;
use Carbon\Carbon;
use Redirect;
use Storage;
use Auth;
use Response;
use Exception;

class RegulasiController extends Controller
{
    public function index()
    {
        // print_r(Auth::user()->hasRole('it|sekretaris-direktur|administrator'));
        // die();
        // print_r(Auth::user()->id);
        // die();
        $unit = unit::orderBy('nama','asc')->get();

        $data = [
            'unit' => $unit,
        ];

        return view('pages.berkas.regulasi.index')->with('list', $data);
    }

    public function download($id)
    {
        $data = berkas_regulasi::where('id', $id)->first();
        $filename = $data->filename;
        $title = $data->title;
        return Storage::download($filename, $title);
    }

    // API
    public function baca($id)
    {
        $show = berkas_regulasi::find($id);
        // print_r($get);
        // die();

        return response()->json($show, 200);
    }

    public function cetak($id)
    {
        $show = berkas_regulasi::find($id);
        $path = storage_path()."/app/".$show->filename;
        return response()->file($path,[
            'Content-Type' => 'application/pdf',
        ]);
    }

    public function showTambah()
    {
        $unit = unit::orderBy('nama','asc')->get();

        return response()->json($unit, 200);
    }

    public function showUbah($id)
    {
        $show = berkas_regulasi::find($id);
        $unit = unit::orderBy('nama','asc')->get();

        $data = [
            'show' => $show,
            'unit' => $unit,
        ];

        return response()->json($data, 200);
    }

    public function tambah(Request $request)
    {
        $tgl = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');

        if (
            $request->jns_regulasi == 7 ||
            $request->jns_regulasi == 8 ||
            $request->jns_regulasi == 9 ||
            $request->jns_regulasi == 10 ||
            $request->jns_regulasi == 11 ||
            $request->jns_regulasi == 12
            ) {
            $request->validate([
                'file' => ['max:5000','mimes:pdf'],
            ]);
        } else {
            $request->validate([
                'file' => ['max:2000','mimes:pdf'],
            ]);
        }

        // tampung berkas yang sudah diunggah ke variabel baru
        // 'file' merupakan nama input yang ada pada form
        $uploadedFile = $request->file('file');

        $title = $uploadedFile->getClientOriginalName();
        $validasiFile = berkas_regulasi::where('title',$title)->first();
        if (empty($validasiFile)) {
            // simpan berkas yang diunggah ke sub-direktori 'public/files'
            // direktori 'files' otomatis akan dibuat jika belum ada
            if ($request->jns_regulasi == 1) {
                $path = $uploadedFile->store('public/files/regulasi/kebijakan');
            } elseif ($request->jns_regulasi == 2) {
                $path = $uploadedFile->store('public/files/regulasi/panduan');
            } elseif ($request->jns_regulasi == 3) {
                $path = $uploadedFile->store('public/files/regulasi/pedoman');
            } elseif ($request->jns_regulasi == 4) {
                $path = $uploadedFile->store('public/files/regulasi/program');
            } elseif ($request->jns_regulasi == 5) {
                $path = $uploadedFile->store('public/files/regulasi/spo');
            } elseif ($request->jns_regulasi == 6) {
                $path = $uploadedFile->store('public/files/regulasi/ppk');
            } elseif ($request->jns_regulasi == 7) {
                $path = $uploadedFile->store('public/files/regulasi/uu');
            } elseif ($request->jns_regulasi == 8) {
                $path = $uploadedFile->store('public/files/regulasi/perpu');
            } elseif ($request->jns_regulasi == 9) {
                $path = $uploadedFile->store('public/files/regulasi/pp');
            } elseif ($request->jns_regulasi == 10) {
                $path = $uploadedFile->store('public/files/regulasi/perpres');
            } elseif ($request->jns_regulasi == 11) {
                $path = $uploadedFile->store('public/files/regulasi/perment');
            } elseif ($request->jns_regulasi == 12) {
                $path = $uploadedFile->store('public/files/regulasi/perda');
            }

            $data = new berkas_regulasi;
            $data->id_user = $request->user_id;
            $data->jns_regulasi = $request->jns_regulasi;
            $data->judul = $request->judul;
            if (
                $request->jns_regulasi != '7'  ||
                $request->jns_regulasi != '8'  ||
                $request->jns_regulasi != '9'  ||
                $request->jns_regulasi != '10' ||
                $request->jns_regulasi != '11' ||
                $request->jns_regulasi != '12'
                )
            {
                $data->sah = $request->tgl;
                $data->pembuat = $request->pembuat;
                $data->unit = $request->unit;
            }

            $data->title = $title;
            $data->filename = $path;

            $data->save();

            return response()->json($tgl, 200);
        } else {
            $error = 'File sudah ada/pernah diupload sebelumnya!';
            return response()->json($error, 400);
        }
    }

    public function ubah(Request $request)
    {
        $tgl = Carbon::now()->isoFormat('YYYY-MM-DD HH:mm:ss');
        $uploadedFile = $request->file('file');

        if (
            $request->jns_regulasi == 7 ||
            $request->jns_regulasi == 8 ||
            $request->jns_regulasi == 9 ||
            $request->jns_regulasi == 10 ||
            $request->jns_regulasi == 11 ||
            $request->jns_regulasi == 12
            ) {
            if ($uploadedFile != null) {
                $request->validate([
                    'file' => ['max:10000','mimes:pdf'],
                ]);
            }
        } else {
            if ($uploadedFile != null) {
                $request->validate([
                    'file' => ['max:2000','mimes:pdf'],
                ]);
            }
        }

        if ($uploadedFile == null) {
            $data = berkas_regulasi::find($request->id_edit);
            $data->id_user = $request->user_id;
            $data->jns_regulasi = $request->jns_regulasi;
            $data->judul = $request->judul;
            if (
                $request->jns_regulasi != '7'  ||
                $request->jns_regulasi != '8'  ||
                $request->jns_regulasi != '9'  ||
                $request->jns_regulasi != '10' ||
                $request->jns_regulasi != '11' ||
                $request->jns_regulasi != '12'
                )
            {
                $data->sah = $request->tgl;
                $data->pembuat = $request->pembuat;
                $data->unit = $request->unit;
            }

            $data->save();
            return response()->json($tgl, 200);
        } else {
            $title = $uploadedFile->getClientOriginalName();
            $validasiFile = berkas_regulasi::where('title',$title)->first();
            if (empty($validasiFile)) {

                // Cari Berkas Lama
                $fileLama = $validasiFile->filename;
                // Hapus Berkas Lama
                Storage::delete($fileLama);

                // simpan berkas yang diunggah ke sub-direktori 'public/files'
                // direktori 'files' otomatis akan dibuat jika belum ada
                if ($request->jns_regulasi == 1) {
                    $path = $uploadedFile->store('public/files/regulasi/kebijakan');
                } elseif ($request->jns_regulasi == 2) {
                    $path = $uploadedFile->store('public/files/regulasi/panduan');
                } elseif ($request->jns_regulasi == 3) {
                    $path = $uploadedFile->store('public/files/regulasi/pedoman');
                } elseif ($request->jns_regulasi == 4) {
                    $path = $uploadedFile->store('public/files/regulasi/program');
                } elseif ($request->jns_regulasi == 5) {
                    $path = $uploadedFile->store('public/files/regulasi/spo');
                } elseif ($request->jns_regulasi == 6) {
                    $path = $uploadedFile->store('public/files/regulasi/ppk');
                } elseif ($request->jns_regulasi == 7) {
                    $path = $uploadedFile->store('public/files/regulasi/uu');
                } elseif ($request->jns_regulasi == 8) {
                    $path = $uploadedFile->store('public/files/regulasi/perpu');
                } elseif ($request->jns_regulasi == 9) {
                    $path = $uploadedFile->store('public/files/regulasi/pp');
                } elseif ($request->jns_regulasi == 10) {
                    $path = $uploadedFile->store('public/files/regulasi/perpres');
                } elseif ($request->jns_regulasi == 11) {
                    $path = $uploadedFile->store('public/files/regulasi/perment');
                } elseif ($request->jns_regulasi == 12) {
                    $path = $uploadedFile->store('public/files/regulasi/perda');
                }

                $data = berkas_regulasi::find($request->id_edit);
                $data->id_user = $request->user_id;
                $data->jns_regulasi = $request->jns_regulasi;
                $data->judul = $request->judul;
                if (
                    $request->jns_regulasi != '7'  ||
                    $request->jns_regulasi != '8'  ||
                    $request->jns_regulasi != '9'  ||
                    $request->jns_regulasi != '10' ||
                    $request->jns_regulasi != '11' ||
                    $request->jns_regulasi != '12'
                    )
                {
                    $data->sah = $request->tgl;
                    $data->pembuat = $request->pembuat;
                    $data->unit = $request->unit;
                }

                $data->title = $title;
                $data->filename = $path;

                $data->save();
                return response()->json($tgl, 200);
            } else {
                $error = 'File sudah ada/pernah diupload sebelumnya!';
                return response()->json($error, 400);
            }
        }


        return response()->json($now, 200);
    }

    public function hapus($id)
    {
        $tgl = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');

        // Inisialisasi
        $data = berkas_regulasi::find($id);
        $file = $data->filename;

        // Proses Hapus
        Storage::delete($file);
        $data->delete();

        return response()->json($tgl, 200);
    }

    public function cariRegulasi(Request $request)
    {
        $unit = unit::orderBy('nama','asc')->get();

        if ($request->regulasi != null) {
            if ($request->waktu != null) {
                $month = Carbon::parse($request->waktu)->isoFormat('MM');
                $year = Carbon::parse($request->waktu)->isoFormat('YYYY');
                if ($request->pembuat != null) {
                    $query_string = "SELECT * FROM berkas_regulasi WHERE MONTH(sah) = $month AND YEAR(sah) = $year AND jns_regulasi = $request->regulasi AND pembuat = $request->pembuat AND deleted_at IS NULL ORDER BY updated_at DESC";
                    $show = DB::select($query_string);
                } else {
                    $query_string = "SELECT * FROM berkas_regulasi WHERE MONTH(sah) = $month AND YEAR(sah) = $year AND jns_regulasi = $request->regulasi AND deleted_at IS NULL ORDER BY updated_at DESC";
                    $show = DB::select($query_string);
                }
            } else {
                if ($request->pembuat != null) {
                    $query_string = "SELECT * FROM berkas_regulasi WHERE jns_regulasi = $request->regulasi AND pembuat = $request->pembuat AND deleted_at IS NULL ORDER BY updated_at DESC";
                    $show = DB::select($query_string);
                } else {
                    $query_string = "SELECT * FROM berkas_regulasi WHERE jns_regulasi = $request->regulasi AND deleted_at IS NULL ORDER BY updated_at DESC";
                    $show = DB::select($query_string);
                }
            }
        } else {
            if ($request->waktu != null) {
                $month = Carbon::parse($request->waktu)->isoFormat('MM');
                $year = Carbon::parse($request->waktu)->isoFormat('YYYY');
                if ($request->pembuat != null) {
                    $query_string = "SELECT * FROM berkas_regulasi WHERE MONTH(sah) = $month AND YEAR(sah) = $year AND pembuat = $request->pembuat AND deleted_at IS NULL ORDER BY updated_at DESC";
                    $show = DB::select($query_string);
                } else {
                    $query_string = "SELECT * FROM berkas_regulasi WHERE MONTH(sah) = $month AND YEAR(sah) = $year AND deleted_at IS NULL ORDER BY updated_at DESC";
                    $show = DB::select($query_string);
                }
            } else {
                if ($request->pembuat != null) {
                    $query_string = "SELECT * FROM berkas_regulasi WHERE pembuat = $request->pembuat AND deleted_at IS NULL ORDER BY updated_at DESC";
                    $show = DB::select($query_string);
                } else {
                    $query_string = "SELECT * FROM berkas_regulasi WHERE deleted_at IS NULL ORDER BY updated_at DESC";
                    $show = DB::select($query_string);
                }
            }
        }

        $data = [
            'show' => $show,
            'unit' => $unit,
            'count' => count($show),
        ];

        return response()->json($data, 200);
    }
    public function apiTotalRegulasi()
    {
        $totKebijakan   = berkas_regulasi::where('jns_regulasi',1)->count();
        $totPanduan     = berkas_regulasi::where('jns_regulasi',2)->count();
        $totPedoman     = berkas_regulasi::where('jns_regulasi',3)->count();
        $totProgram     = berkas_regulasi::where('jns_regulasi',4)->count();
        $totSpo         = berkas_regulasi::where('jns_regulasi',5)->count();
        $totPpk         = berkas_regulasi::where('jns_regulasi',6)->count();
        $totUU          = berkas_regulasi::where('jns_regulasi',7)->count();
        $totPerPu       = berkas_regulasi::where('jns_regulasi',8)->count();
        $totPP          = berkas_regulasi::where('jns_regulasi',9)->count();
        $totPerPres     = berkas_regulasi::where('jns_regulasi',10)->count();
        $totPerMent     = berkas_regulasi::where('jns_regulasi',11)->count();
        $totPerDa       = berkas_regulasi::where('jns_regulasi',12)->count();

        $total = $totKebijakan + $totPedoman + $totPanduan + $totProgram + $totSpo + $totPpk + $totUU + $totPerPu + $totPP + $totPerPres + $totPerMent + $totPerDa;
        // print_r($total);
        // die();

        $data = [
            'total' => $total,
            'totkebijakan' => $totKebijakan,
            'totpedoman' => $totPedoman,
            'totpanduan' => $totPanduan,
            'totprogram' => $totProgram,
            'totspo' => $totSpo,
            'totppk' => $totPpk,
            'totuu' => $totUU,
            'totperpu' => $totPerPu,
            'totpp' => $totPP,
            'totperpres' => $totPerPres,
            'totperment' => $totPerMent,
            'totperda' => $totPerDa,
        ];

        return response()->json($data, 200);
    }
}
