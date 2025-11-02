<?php

namespace App\Http\Controllers\React\SDI;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use App\Models\referensi;
use App\Models\datalogs;
use App\Models\users;
use App\Models\users_foto;
use App\Models\users_doc;
use App\Models\users_rotasi;
use App\Models\users_status;
use App\Models\users_spkrkk;
use App\Models\logs;
use App\Models\alamat;
use App\Models\model_has_roles;
use App\Models\roles;
use Carbon\Carbon;
use Inertia\Inertia;
use Auth;
use Storage;
use Exception;
use Redirect;

class ProfilPegawaiController extends Controller
{
    function index($id)
    {
        $user = users::where('id',$id)->first();
        $foto_user = users_foto::where('user_id',$id)->first();
        $status_user = users_status::leftjoin('referensi','referensi.id','=','users_status.ref_id')
                                ->select('referensi.deskripsi AS nama_status')
                                ->where('users_status.pegawai_id',$id)
                                ->where('users_status.status',1)
                                ->whereNull('users_status.deleted_at')
                                ->where('referensi.status',1)
                                ->whereNull('referensi.deleted_at')
                                ->first();
        $log_user = logs::where('user_id', $id)->where('log_type', '=', 'login')->select('log_date')->orderBy('log_date', 'DESC')->first();
        $role = model_has_roles::join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                                ->select('model_has_roles.model_id as id_user','roles.name as nama_role')
                                ->where('model_has_roles.model_id', '=', $id)
                                ->get();
        $ref_dokumen = referensi::where('ref_jenis',8)->get(); // 8 is Jenis Dokumen User

        $data = [
            'user' => $user,
            'foto_user' => $foto_user,
            'status_user' => $status_user,
            'log_user' => $log_user,
            'role' => $role,
            'ref_dokumen' => $ref_dokumen,
        ];

        return Inertia::render('SDI/ProfilPegawai', [
            'list' => $data
        ]);
    }
}
