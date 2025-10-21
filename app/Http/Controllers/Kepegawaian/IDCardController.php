<?php

namespace App\Http\Controllers\Kepegawaian;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\referensi;
use App\Models\datalogs;
use App\Models\users;
use App\Models\users_foto;
use App\Models\kepegawaian\idcard;
use Carbon\Carbon;
use Auth;
use Validator,Redirect,Response,File;

class IDCardController extends Controller
{
    // BOTH
    function index()
    {
        if (Auth::user()->getPermission('admin_kepegawaian') == true) {
            return view('pages.kepegawaian.idcard.index-admin');
        } else {
            $id_user = Auth::user()->id;
            $user  = users::where('id',$id_user)->first();

            $role = users::Join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                ->Join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                ->select('roles.name as nama_role','roles.deskripsi as nama_role2', 'users.id as id_user')
                ->where('users.id',$id_user)
                ->first();

            $data = [
                'user' => $user,
                'role' => $role,
            ];

            return view('pages.kepegawaian.idcard.index-user')->with('list', $data);
        }
    }

    // function indexAdmin()
    // {
    //     $show  = idcard::get();

    //     $data = [
    //         'show' => $show,
    //     ];

    //     return response()->json($data, 200);
    // }

    // USER
    function riwayat($id)
    {
        $data = idcard::where('pegawai_id',$id)->orderBy('updated_at','desc')->get();
        return response()->json($data);
    }

    function tambahPengajuan(Request $request)
    {
        $push = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');
        $fotouser  = users_foto::where('user_id',$request->pegawai)->first();

        if (empty($fotouser)) {
            return Response::json(array(
                'message' => 'Foto profil belum diupload/diganti!',
                'code' => 500,
            ));
        } else {
            // Verifikasi Duplikat Pengajuan
            $verif = idcard::where('pegawai_id',$request->pegawai)->whereIn('progress',['0','1'])->first();
            if (empty($verif)) {
                // Verifikasi Upload File Kwitansi
                $uploadedFile = $request->file('file');
                if ($uploadedFile) { // JIKA ADA FILE UPLOAD
                    $title = $uploadedFile->getClientOriginalName();
                    $validasiFile = idcard::where('title',$title)->first();
                    // simpan berkas yang diunggah ke sub-direktori 'public/files'
                    // direktori 'files' otomatis akan dibuat jika belum ad
                    $path = $uploadedFile->store('public/files/kepegawaian/idcard/kwitansi/'.$request->user);

                    $data = new idcard;
                    $data->pegawai_id           = $request->pegawai;
                    $data->pegawai_nip          = $request->nip;
                    $data->pegawai_nama         = $request->nama;
                    $data->pegawai_panggilan    = $request->panggilan;
                    $data->pegawai_jabatan      = $request->jabatan;
                    $data->progress             = 0;
                    $data->pengajuan            = $request->pengajuan;
                    $data->alasan               = $request->alasan;
                    $data->title                = $fotouser->title; // fotouser
                    $data->filename             = $fotouser->filename; // fotouser
                    $data->kwitansi_title       = $title; // kwitansi
                    $data->kwitansi_filename    = $path; // kwitansi
                    $data->save();

                    return response()->json($push);
                } else { // Jika tidak ada file upload kwitansi
                    $data = new idcard;
                    $data->pegawai_id           = $request->pegawai;
                    $data->pegawai_nip          = $request->nip;
                    $data->pegawai_nama         = $request->nama;
                    $data->pegawai_panggilan    = $request->panggilan;
                    $data->pegawai_jabatan      = $request->jabatan;
                    $data->progress             = 0;
                    $data->pengajuan            = $request->pengajuan;
                    $data->alasan               = $request->alasan;
                    $data->title                = $fotouser->title; // fotouser
                    $data->filename             = $fotouser->filename; // fotouser
                    $data->save();

                    return response()->json($push);
                }
            } else {
                return Response::json(array(
                    'message' => 'Terdapat pengajuan ID Card yang masih Aktif/Belum Diselesaikan!',
                    'code' => 500,
                ));
            }
        }
    }

    function hapusPengajuan($id)
    {
        $tgl = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');

        // Inisialisasi
        $data = idcard::find($id);
        $data->delete();

        return response()->json($tgl, 200);
    }

    // ADMIN
    function table()
    {
        $show  = idcard::get();

        $data = [
            'show' => $show,
        ];

        return response()->json($data, 200);
    }

    function ubahStatus(Request $request)
    {
        // print_r($request->estimasi);
        // die();
        $tgl = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');

        $data = idcard::find($request->id);
        if ($request->progress != 3) {
            $data->progress = $request->progress;
            if (!empty($request->estimasi)) {
                $data->estimasi = $request->estimasi;
            }
            $data->save();
        } else {
            $data->progress = 3;
            $data->estimasi = null;
            $data->save();
        }

        return response()->json($tgl, 200);
    }
}
