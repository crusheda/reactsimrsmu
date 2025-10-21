<?php

namespace App\Http\Controllers\Kepegawaian;

use App\Http\Controllers\Controller;
use App\Models\referensi;
use App\Models\datalogs;
use App\Models\users;
use App\Models\kepegawaian\saran;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Validator, Auth;

class SaranController extends Controller
{
    function index()
    {
        $users  = users::where('nik','!=',null)->orderBy('nama', 'asc')->get();
        $kategori = referensi::where('ref_jenis',12)->get();
        $show  = saran::Join('referensi', 'referensi.id', '=', 'kepegawaian_saran.ref_kategori')->select('referensi.deskripsi as kategori','kepegawaian_saran.*')->orderBy('kepegawaian_saran.updated_at','desc')->get();

        // $role = users::Join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
        //     ->Join('roles', 'model_has_roles.role_id', '=', 'roles.id')
        //     ->select('roles.name as nama_role', 'users.id as id_user')
        //     ->get();

        $data = [
            'users' => $users,
            'kategori' => $kategori,
            // 'role' => $role,
            'show' => $show,
        ];

        return view('pages.kepegawaian.feedback.index-user')->with('list', $data);;
        // return view('pages.profilkaryawan.index')->with('list', $data);
    }

    function store(Request $request)
    {
        $push = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');

        $request->validate([
            'judul' => ['required'],
            'kategori' => ['required'],
            'saran' => ['required'],
        ]);

        $user = Auth::user();
        $user_id = $user->id;

        $data = new saran;
        $data->pegawai_id = $user_id;
        $data->judul = $request->judul;
        $data->ref_kategori = $request->kategori;
        $data->saran = $request->saran;

        $data->save();

        return redirect()->back()->with('message','Submit Masukan telah Berhasil dilakukan pada '.$push);
    }
}
