<?php

namespace App\Http\Controllers\Berkas\Surat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use App\Models\disposisi;
use App\Models\surat_masuk;
use App\Models\User;
use App\Models\roles;
use Carbon\Carbon;
use Validator,Redirect,Response,File;
use Exception;
use Storage;
use Auth;

class DisposisiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->getPermission('disposisi') == true) {
            // $users = user::whereNotNull('nik')->where('status',null)->orderBy('nama','ASC')->get();
            $roles = roles::orderBy('name','ASC')->get();

            $data = [
                'roles' => $roles,
            ];

            return view('pages.berkas.surat.disposisi.index')->with('list', $data);
        } else {
            return redirect()->back();
        }
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
        $request->validate([
            'file' => ['max:5000'],
        ]);

        $uploadedFile = $request->file('file');

        $title = $uploadedFile->getClientOriginalName();
        $validasiFile = disposisi::where('title',$title)->first();
        if (empty($validasiFile)) {
            // simpan berkas yang diunggah ke sub-direktori 'public/files'
            // direktori 'files' otomatis akan dibuat jika belum ada
            $path = $uploadedFile->store('public/files/tu/disposisi');
            $tujuan[] = $request->tujuan;

            $data1 = new disposisi;
            $data1->id_surat = $request->id_surat;
            $data1->tujuan = json_encode($tujuan);
            $data1->tindak_lanjut = $request->tindak_lanjut;
            $data1->ket = $request->ket;
            $data1->title = $title;
            $data1->filename = $path;
            $data1->user = $request->user;
            $data1->save();

            $data2 = surat_masuk::find($request->id_surat);
            $data2->verif_disposisi = true;
            $data2->save();
            return response()->json($data2->asal, 200);

        } else {
            $error = 'File sudah ada/pernah diupload sebelumnya!';
            return response()->json($error, 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = disposisi::where('id_surat',$id)->first();
        if (!empty($data)) {
            return Storage::download($data->filename, $data->title);
        } else {
            return redirect()->back()->with('message','Berkas Disposisi tidak ditemukan!');
        }
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

    // API
    public function apiGet()
    {
        $user = User::get();
        $show = surat_masuk::orderBy('created_at','DESC')->limit(100)->get();
        $disposisi = disposisi::get();

        $data = [
            'user' => $user,
            'show' => $show,
            'disposisi' => $disposisi,
        ];

        return response()->json($data, 200);
    }

    public function apiGetAll()
    {
        $user = User::get();
        $show = surat_masuk::get();
        $disposisi = disposisi::get();

        $data = [
            'user' => $user,
            'show' => $show,
            'disposisi' => $disposisi,
        ];

        return response()->json($data, 200);
    }

    public function apiGetDisposisi($id)
    {
        $user = User::get();
        $show = disposisi::where('id_surat',$id)->get();
        $roles = roles::orderBy('name','ASC')->get();

        $data = [
            'user' => $user,
            'show' => $show,
            'roles' => $roles,
        ];

        return response()->json($data, 200);
    }

    public function hapus($id)
    {
        $tgl = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');

        // Inisialisasi
        $hapusData1 = disposisi::where('id_surat',$id)->first();
        $hapusData2 = surat_masuk::find($id);

        // Proses Hapus
        $file = $hapusData1->filename;
        Storage::delete($file);
        $hapusData1->delete();

        // Proses Null pada kolom Verif Disposisi di tabel Surat Masuk
        $hapusData2->verif_disposisi = null;
        $hapusData2->save();

        return response()->json($tgl, 200);
    }
}
