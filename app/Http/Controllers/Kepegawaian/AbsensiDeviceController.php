<?php

namespace App\Http\Controllers\Kepegawaian;

use App\Http\Controllers\Controller;
use App\Models\referensi;
use App\Models\datalogs;
use App\Models\users;
use App\Models\users_foto;
use App\Models\kepegawaian\fcm_tokens;
use App\Models\kepegawaian\device;
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
use Auth, DB;
use Validator,Redirect,Response,File,Storage;

class AbsensiDeviceController extends Controller
{
    function index()
    {
        if (
                Auth::user()->getPermission('admin_kepegawaian') == true ||
                Auth::user()->getPermission('admin_kepegawaian_kepala') == true
            ) {
            $data = [

            ];

            return view('pages.kepegawaian.absensi.perangkat')->with('list', $data);
        } else {
            return redirect()->back()->withErrors("Maaf, Anda tidak memiliki akses untuk membuka halaman Daftar Perangkat Absensi!");
        }
    }

    function table()
    {
        $show = fcm_tokens::whereNull('deleted_at')
                ->orderBy('id', 'desc')
                ->get()
                ->map(function($token) {
                    // Ambil semua kolom fcm_tokens
                    $data = $token->toArray();

                    // Tambahkan kolom nama_user dari relasi
                    $data['nama_user'] = $token->user->nama ?? null;
                    $data['nama_admin'] = $token->admin->nama ?? null;

                    // Tambahkan kolom android_model
                    $data['nama_brand']   = $token->androidModel->brand ?? null;
                    $data['nama_android'] = $token->androidModel->nama ?? null;
                    $data['nama_device']  = $token->androidModel->device ?? null;

                    return $data;
                });

        $data = [
            'show' => $show,
        ];

        return response()->json($data);
    }

    function approve($id,$user)
    {
        $now = Carbon::now();
        $push = $now->isoFormat('dddd, D MMMM Y, HH:mm a');

        $data = fcm_tokens::find($id);
        $data->accepted = 1;
        $data->accepted_user = $user;
        $data->accepted_date = $now;
        $data->save();

        return response()->json($push, 200);
    }

    function reject($id,$user)
    {
        $now = Carbon::now();
        $push = $now->isoFormat('dddd, D MMMM Y, HH:mm a');

        $data = fcm_tokens::find($id);
        $data->accepted = 0;
        $data->accepted_user = $user;
        $data->accepted_date = $now;
        $data->save();

        return response()->json($push, 200);
    }

    function aktif($id,$user)
    {
        $now = Carbon::now();
        $push = $now->isoFormat('dddd, D MMMM Y, HH:mm a');

        $data = fcm_tokens::find($id);
        $data->status = 1;
        $data->accepted_user = $user;
        $data->accepted_date = null;
        $data->save();

        return response()->json($push, 200);
    }

    function blokir($id,$user)
    {
        $now = Carbon::now();
        $push = $now->isoFormat('dddd, D MMMM Y, HH:mm a');

        $data = fcm_tokens::find($id);
        $data->status = 0;
        $data->accepted = 0;
        $data->accepted_user = $user;
        $data->accepted_date = $now;
        $data->save();

        return response()->json($push, 200);
    }
}
