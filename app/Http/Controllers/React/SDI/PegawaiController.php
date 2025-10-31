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

class PegawaiController extends Controller
{
    function index()
    {
        return Inertia::render('SDI/Pegawai');
    }
    
    function table()
    {
        $show = users::where('status',null)->orderBy('updated_at','desc')->get();

        $data = [
            'show' => $show
        ];

        return response()->json($data, 200);
    }

    function tableAll()
    {
        $show = users::leftJoin('referensi as rp','rp.id','=','users.ref_profesi')
                ->leftJoin('users_status as us', function($join) {
                    $join->on('us.pegawai_id', '=', 'users.id')
                            ->where('us.status', '=', 1)
                            ->whereNull('us.deleted_at');
                })
                ->leftJoin('referensi as rus', function($join) {
                    $join->on('rus.id', '=', 'us.ref_id')
                            ->where('rus.ref_jenis', '=', 10);
                })
                // ->where('us.deleted_at',null)
                ->where('users.status',null)
                ->select('users.*','rus.deskripsi as profesi','rp.deskripsi as klasifikasi_user','rus.deskripsi as status_pegawai')
                ->orderBy('users.nip','asc')
                ->get();
        $role = model_has_roles::join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                ->select('model_has_roles.model_id as id_user','roles.name as nama_role')
                ->get();

        $data = [
            'show' => $show,
            'role' => $role,
        ];

        return response()->json($data, 200);
    }
}
