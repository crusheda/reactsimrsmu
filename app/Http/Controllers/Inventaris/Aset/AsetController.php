<?php

namespace App\Http\Controllers\Inventaris\Aset;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Crypt;
use App\Models\aset;
use App\Models\aset_ruangan;
use App\Models\aset_mutasi;
use App\Models\aset_peminjaman;
use App\Models\aset_pengembalian;
use App\Models\aset_penarikan;
use App\Models\aset_pemeliharaan;
use App\Models\roles;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Storage;
use Auth;
use \PDF;
use Validator,Redirect,Response,File;

class AsetController extends Controller
{
    function index()
    {
        $role = roles::where('name', '<>','administrator')->orderBy('updated_at','desc')->get();
        $month = Carbon::now()->isoFormat('MM');
        $year = Carbon::now()->isoFormat('YYYY');
        $ruangan = aset_ruangan::get();

        $data = [
            'role' => $role,
            'month' => $month,
            'year' => $year,
            'ruangan' => $ruangan,
        ];

        return view('pages.inventaris.aset.index')->with('list',$data);
    }

    function detail($token)
    {
        // print_r($token);
        // die();
        $show = aset::join('aset_ruangan','aset.id_ruangan','=','aset_ruangan.id')
                ->where('aset.token',$token)
                ->select('aset_ruangan.ruangan','aset_ruangan.lokasi','aset.*')
                ->first();

        // print_r($token);
        // die();

        if (empty($show)) { // JIKA DATA TIDAK DITEMUKAN
            $role = roles::where('name', '<>','administrator')->orderBy('updated_at','desc')->get();
            $month = Carbon::now()->isoFormat('MM');
            $year = Carbon::now()->isoFormat('YYYY');
            $ruangan = aset_ruangan::get();

            $data = [
                'role' => $role,
                'month' => $month,
                'year' => $year,
                'ruangan' => $ruangan,
            ];

            return Redirect::to('/inventaris/aset')->with('list',$data);
        } else { // JIKA DATA DITEMUKAN
            $user = User::where('id',$show->id_user)->select('nama')->first(); // whereNotNull('nik')

            if ($show->kondisi == 1) {
                $kondisi = 'Baik';
            } else {
                if ($show->kondisi == 2) {
                    $kondisi = 'Cukup';
                } else {
                    if ($show->kondisi == 3) {
                        $kondisi = 'Buruk';
                    }
                }
            }

            // Menentukan Isi QR-Code
            $qr = $show->sarana.' | '.$show->merk.' | '.$show->tipe.' | '.$show->ruangan.' | '.$kondisi;

            $data = [
                'show' => $show,
                // 'mutasi' => $mutasi,
                // 'peminjaman' => $peminjaman,
                // 'pengembalian' => $pengembalian,
                'qr' => $qr,
                'user' => $user,
            ];

            return view('pages.inventaris.aset.detail')->with('list',$data);
        }

    }

    // function index2() // OLD
    // {
    //     $role = roles::where('name', '<>','administrator')->orderBy('updated_at','desc')->get();
    //     $month = Carbon::now()->isoFormat('MM');
    //     $year = Carbon::now()->isoFormat('YYYY');
    //     $ruangan = aset_ruangan::get();

    //     $data = [
    //         'role' => $role,
    //         'month' => $month,
    //         'year' => $year,
    //         'ruangan' => $ruangan,
    //     ];

    //     return view('pages.inventaris.aset.index2')->with('list',$data);
    // }

    // function detail2($token) // OLD
    // {
    //     // print_r($token);
    //     // die();
    //     $show = aset::join('aset_ruangan','aset.id_ruangan','=','aset_ruangan.id')
    //             ->where('aset.token',$token)
    //             ->select('aset_ruangan.ruangan','aset_ruangan.lokasi','aset.*')
    //             ->first();

    //     // print_r($token);
    //     // die();

    //     if (empty($show)) { // JIKA DATA TIDAK DITEMUKAN
    //         $role = roles::where('name', '<>','administrator')->orderBy('updated_at','desc')->get();
    //         $month = Carbon::now()->isoFormat('MM');
    //         $year = Carbon::now()->isoFormat('YYYY');
    //         $ruangan = aset_ruangan::get();

    //         $data = [
    //             'role' => $role,
    //             'month' => $month,
    //             'year' => $year,
    //             'ruangan' => $ruangan,
    //         ];

    //         return Redirect::to('/inventaris/aset')->with('list',$data);
    //     } else { // JIKA DATA DITEMUKAN
    //         $user = User::where('id',$show->id_user)->select('nama')->first(); // whereNotNull('nik')

    //         if ($show->kondisi == 1) {
    //             $kondisi = 'Baik';
    //         } else {
    //             if ($show->kondisi == 2) {
    //                 $kondisi = 'Cukup';
    //             } else {
    //                 if ($show->kondisi == 3) {
    //                     $kondisi = 'Buruk';
    //                 }
    //             }
    //         }

    //         // Menentukan Isi QR-Code
    //         $qr = $show->sarana.' | '.$show->merk.' | '.$show->tipe.' | '.$show->ruangan.' | '.$kondisi;

    //         $data = [
    //             'show' => $show,
    //             // 'mutasi' => $mutasi,
    //             // 'peminjaman' => $peminjaman,
    //             // 'pengembalian' => $pengembalian,
    //             'qr' => $qr,
    //             'user' => $user,
    //         ];

    //         return view('pages.inventaris.aset.detail2')->with('list',$data);
    //     }

    // }

    function fresh($id){
        $show = aset::join('aset_ruangan','aset.id_ruangan','=','aset_ruangan.id')
                ->where('aset.id',$id)
                ->select('aset_ruangan.ruangan','aset_ruangan.lokasi','aset.*')
                ->first();

        // Menentukan Kondisi
        if ($show->kondisi == 1) {
            $kondisi = 'Baik';
        } else {
            if ($show->kondisi == 2) {
                $kondisi = 'Cukup';
            } else {
                if ($show->kondisi == 3) {
                    $kondisi = 'Buruk';
                }
            }
        }

        // Menentukan Isi QR-Code
        $qr = $show->sarana.' | '.$show->merk.' | '.$show->tipe.' | '.$show->ruangan.' | '.$kondisi;

        $data = [
            'show' => $show,
            'qr' => $qr,
        ];

        return response()->json($data, 200);
    }

    function ubahKondisi($token, $kondisi){
        $data = aset::where('token',$token)->first();
        $data->kondisi = $kondisi;
        $data->save();

        return response()->json($data, 200);
    }

    function getRuangan($id)
    {
        $ruangan = aset_ruangan::where('id', $id)->first();

        $last = aset::orderBy('urutan','desc')->where('id_ruangan',$id)->first();
        // print_r($last->urutan);
        // die();
        if (!empty($last)) {
            $kodeSarana = $last->urutan + 1;
        } else {
            $kodeSarana = '1';
        }

        $data = [
            'kodesarana' => $kodeSarana,
            'ruangan' => $ruangan->kode,
        ];

        return response()->json($data, 200);
    }

    function getKalibrasi($id)
    {
        $data = aset::where('id', $id)->first();

        return response()->json($data, 200);
    }

    // function updateKalibrasi($id, $no_kalibrasi, $tgl_berlaku, $tgl_berakhir)
    function updateKalibrasi(Request $request)
    {
        $tgl = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');

        $data = aset::where('id', $request->id)->first();
        $data->no_kalibrasi     = $request->no_kalibrasi;
        $data->tgl_berlaku      = $request->tgl_berlaku;
        $data->tgl_berakhir     = $request->tgl_berakhir;
        $data->save();

        // DB::table('aset')
        //     ->where('id', $request->id)
        //     ->update(['no_kalibrasi' => $request->no_kalibrasi,'tgl_berlaku' => $request->tgl_berlaku,'tgl_berakhir' => $request->tgl_berakhir]);

        return response()->json($tgl, 200);
    }

    function getTahunBulanPengadaan()
    {
        $month = Carbon::now()->isoFormat('MM');
        $year = Carbon::now()->isoFormat('YYYY');
        // $query = aset::orderBy('created_at','desc')->first();
        // if (!empty($query)) {
        //     $data = $query->urutan + 1;
        // } else {
        //     $data = '1';
        // }

        $data = [
            'month' => $month,
            'year' => $year,
        ];

        return response()->json($data, 200);
    }

    function makeEncrypt($id)
    {
        return response()->json(Crypt::encryptString($id), 200);
    }

    function makeDecrypt($id)
    {
        return response()->json(Crypt::decryptString($id), 200);
    }

    function refreshToken()
    {
        $tgl = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');
        // $getData = aset::get();
        $getCount = aset::count();
        for ($i=1; $i <= $getCount; $i++) {
            $data = aset::find($i);
            $data->token = Crypt::encryptString($data->no_inventaris); // decryptString to Decrypt
            $data->save();
        }
        return response()->json($tgl, 200);
    }

    function store(Request $request)
    {
        $carbon = Carbon::now();
        $tgl = $carbon->isoFormat('dddd, D MMMM Y, HH:mm a');
        if ($request->tgl_perolehan == null) {
            $year = $carbon->isoFormat('YYYY');
        } else {
            $year = substr($request->tgl_perolehan,0,4);
        }

        $validator = Validator::make($request->all(), [
            'file.*' => 'mimes:jpg,png,jpeg|max:5000', // required
        ]);

        if ($validator->fails()) {
            $arr = json_encode($validator->errors());
            return redirect()->back()->with('error',$arr);
        } else {
            $getRuangan = aset_ruangan::where('id',$request->ruangan)->first();
            $getUrutan = aset::where('id_ruangan',$request->ruangan)->orderBy('urutan','desc')->first();
            if (!empty($getUrutan)) {
                $urutan = $getUrutan->urutan + 1;
            } else {
                $urutan = '1';
            }

            if ($request->jenis == 1) {
                $jenis = 'A';
            } else {
                $jenis = 'B';
            }

            $no_inventaris = '00.03.27.'.$getRuangan->kode.'.'.$jenis.'.'.$urutan.'.'.$year;

            $data = new aset;
            $data->token = Crypt::encryptString($no_inventaris); // decryptString to Decrypt
            $data->urutan = $urutan;
            $data->id_user = $request->user;
            $data->id_ruangan = $request->ruangan;
            $data->jenis = $request->jenis;
            // $data->kalibrasi = $request->kalibrasi;

            // OLD
            // $data->no_kalibrasi = $request->no_kalibrasi;
            // $data->tgl_berlaku = $request->tgl_berlaku;
            $data->tgl_perolehan = $request->tgl_perolehan;
            $data->no_inventaris = $no_inventaris;
            $data->sarana = $request->sarana;
            $data->merk = $request->merk;
            $data->tipe = $request->tipe;
            $data->no_seri = $request->no_seri;
            $data->tgl_operasi = $request->tgl_operasi;
            $data->asal_perolehan = $request->asal_perolehan;
            if ($request->nilai_perolehan != null) {
                $data->nilai_perolehan = str_replace('.','',str_replace('Rp. ','',$request->nilai_perolehan));
            }
            $data->keterangan = $request->keterangan;
            $data->kondisi = $request->kondisi;
            $data->golongan = $request->golongan;
            $data->umur = $request->umur;
            $data->tarif = $request->tarif;
            $data->penyusutan = $request->penyusutan;
            $data->tgl_input = $carbon;

            $file_upload = $request->file('file');
            // print_r($file_upload);
            // die();
            if ($request->hasFile('file')) {
                foreach ($file_upload as $getFile) {
                    // $request->validate([
                    //     'file' => ['max:10000','mimes:jpeg,jpg,png'],
                    // ]);
                    // print_r($getFile->getClientOriginalName());
                    $array_filename[] = $getFile->store('public/files/inventaris/aset/sarana/'.$request->ruangan);
                    $array_title[] = $getFile->getClientOriginalName();
                }
                $data->filename = json_encode($array_filename);
                $data->title = json_encode($array_title);
            }
            // die();
            // print_r($array_title);
            // die();

            // $request->validate([
            //     'file' => ['max:10000','mimes:jpg'],
            // ]);
            // if ($request->file('file') && $request->file('file')->isValid()) {
            //     $data->filename = $request->file('file')->store('public/files/inventaris/aset/sarana');
            //     $data->title = $request->file('file')->getClientOriginalName();
            // }
            // print_r($data);
            // die();

            $data->save();

            return response()->json($tgl, 200);
        }
    }

    function filter(Request $request) {
        $initial = aset::query();
        $show = $initial->select('aset.*','aset_ruangan.ruangan','aset_ruangan.lokasi')->join('aset_ruangan','aset_ruangan.id','=','aset.id_ruangan');
        if ($request->filter1) {
            $show = $initial->where('aset.jenis',$request->filter1);
        }
        if ($request->filter2) {
            $show = $initial->where('aset.id_ruangan',$request->filter2);
        }
        if ($request->filter3) {
            $show = $initial->where('aset.tgl_perolehan',$request->filter3);
        }
        if ($request->filter4) {
            // $show = $initial->where( DB::raw('MONTH(tgl_berakhir)'), '=', $request->filter4 )
            $show = $initial->whereMonth('tgl_berakhir', '=', $request->filter4);
        }
        if ($request->filter5) {
            $show = $initial->where( DB::raw('YEAR(tgl_berakhir)'), '=', $request->filter5 );
            // $show = $initial->where('aset.tgl_perolehan',$request->filter5);
        }
        $show = $initial->get();

        // print_r($request->filter3);
        // die();
        $data = [
            'show' => $show,
        ];

        return response()->json($data, 200);
    }

    function hapus($id)
    {
        $tgl = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');

        // Inisialisasi
        $data = aset::find($id);

        // Proses Hapus Lampiran
        $file = $data->filename;
        foreach (json_decode($file) as $key => $value) {
            Storage::delete($value);
        }

        // Proses Hapus Data dari DB
        $data->delete();

        return response()->json($tgl, 200);
    }

    // function qrcode($id)
    // {
    //     $show = aset::where('id',$id)->first();
    //     // $data = str_replace('.','',$show->no_inventaris);
    //     return response()->json($show->token, 200);
    // }

    function getAsetToken($token)
    {
        $show = aset::select('aset.*','aset_ruangan.ruangan','aset_ruangan.lokasi')
                    ->join('aset_ruangan','aset_ruangan.id','=','aset.id_ruangan')
                    ->where('aset.token',$token)
                    ->first();

        $data = [
            'show' => $show,
        ];

        return response()->json($data, 200);
    }

    function getUbahAset($id)
    {
        $show = aset::select('aset.*','aset_ruangan.ruangan','aset_ruangan.lokasi')
                    ->join('aset_ruangan','aset_ruangan.id','=','aset.id_ruangan')
                    ->where('aset.id',$id)
                    ->first();
        $ruangan = aset_ruangan::get();

        $data = [
            'show' => $show,
            'ruangan' => $ruangan,
        ];

        return response()->json($data, 200);
    }

    function update(Request $request)
    {
        $carbon = Carbon::now();
        $tgl = $carbon->isoFormat('dddd, D MMMM Y, HH:mm a');

        $validator = Validator::make($request->all(), [
            'file.*' => 'mimes:jpg,png,jpeg|max:5000',
        ]);

        if ($validator->fails()) {
            $arr = json_encode($validator->errors());
            return redirect()->back()->with('error',$arr);
        } else {
            $data = aset::find($request->id);
            $data->id_user = $request->user;
            // $data->no_kalibrasi = $request->no_kalibrasi;
            // $data->tgl_berlaku = $request->tgl_berlaku;
            $data->sarana = $request->sarana;
            $data->merk = $request->merk;
            $data->tipe = $request->tipe;
            $data->no_seri = $request->no_seri;
            $data->tgl_operasi = $request->tgl_operasi;
            $data->asal_perolehan = $request->asal_perolehan;
            if ($request->nilai_perolehan != null) {
                $data->nilai_perolehan = str_replace('.','',str_replace('Rp. ','',$request->nilai_perolehan));
            } else {
                $data->nilai_perolehan = null;
            }
            $data->keterangan = $request->keterangan;
            $data->kondisi = $request->kondisi;

            $file_upload = $request->file('file');
            if ($request->hasFile('file')) {
                foreach ($file_upload as $getFile) {
                    // $request->validate([
                    //     'file' => ['max:10000','mimes:jpeg,jpg,png'],
                    // ]);
                    // print_r($getFile->getClientOriginalName());
                    $array_filename[] = $getFile->store('public/files/inventaris/aset/sarana/'.$request->ruangan);
                    $array_title[] = $getFile->getClientOriginalName();
                }
                $data->filename = json_encode($array_filename);
                $data->title = json_encode($array_title);
            }

            $data->save();

            return response()->json($tgl, 200);
        }
    }
}
