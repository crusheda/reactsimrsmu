<?php

namespace App\Http\Controllers\React\Akun;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\logs;
use App\Models\users;
use App\Models\users_foto;
use App\Models\users_status;
use App\Models\model_has_roles;
use Carbon\Carbon;
use Auth;

class ProfilController extends Controller
{
    function index()
    {
        $id_user = Auth::user()->id;
        $user = users::where('id',$id_user)->first();
        $foto_user = users_foto::where('user_id',$id_user)->first();
        $status_user = users_status::leftjoin('referensi','referensi.id','=','users_status.ref_id')
                                ->select('referensi.deskripsi AS nama_status')
                                ->where('users_status.pegawai_id',$id_user)
                                ->where('users_status.status',1)
                                ->whereNull('users_status.deleted_at')
                                ->where('referensi.status',1)
                                ->whereNull('referensi.deleted_at')
                                ->first();
        $log_user = logs::where('user_id', $id_user)->where('log_type', '=', 'login')->select('log_date')->orderBy('log_date', 'DESC')->first();
        $role = model_has_roles::join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                                ->select('model_has_roles.model_id as id_user','roles.name as nama_role')
                                ->where('model_has_roles.model_id', '=', $id_user)
                                ->get();

        $data = [
            'user' => $user,
            'foto_user' => $foto_user,
            'status_user' => $status_user,
            'log_user' => $log_user,
            'role' => $role,
        ];

        return Inertia::render('Akun/Profil', [
            'list' => $data
        ]);
    }
}
