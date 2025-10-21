<?php

namespace App\Http\Controllers\HakAkses;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\users;
use App\Models\roles;
use App\Models\permissions;
use App\Models\model_has_roles;
use App\Models\role_has_permissions;
use Redirect;
use Carbon\Carbon;
use Auth;

class AksesJabatanController extends Controller
{
    function index()
    {
        if (Auth::user()->getPermission('akses_jabatan') == true || Auth::user()->getRole('karu-it') == true) {
            $role = roles::where('name', '<>','administrator')->orderBy('updated_at','desc')->get();
            $permissions = permissions::orderBy('updated_at','desc')->get();

            $data = [
                'role' => $role,
                'permissions' => $permissions,
            ];

            return view('pages.hakakses.aksesjabatan.index')->with('list',$data);
        } else {
            return redirect()->back();
        }
    }

    function store(Request $request)
    {
        $tgl = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');

        // Validate
        // foreach ($request->akses as $key => $value) {
        //     if ($request->jabatan == $value) {
        //         return response()->json(['error' => 'Nama Jabatan tidak boleh ikut/sama dengan Nama Akses'], 400);
        //     }
        // }

        // SAVING
        // foreach ($request->akses as $key => $value) {
        //     $role = role::where('id',$request->jabatan)->first();
        //     $role->givePermissionTo($value);
        // }
        $role = role::where('id',$request->jabatan)->first();
        $role->syncPermissions($request->akses);

        return response()->json($tgl, 200);
    }

    function storeAkses(Request $request)
    {
        $tgl = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');
        $data = new permissions;
        $data->name = $request->akses;
        $data->guard_name = 'web';

        $data->save();

        return response()->json($tgl, 200);
    }

    function storeJabatan(Request $request)
    {
        $tgl = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');
        $data = new roles;
        $data->name = $request->jabatan;
        $data->guard_name = 'web';

        $data->save();

        return response()->json($tgl, 200);
    }

    // API
    function tableAksesJabatan()
    {
        $role = roles::where('name', '<>','administrator')->orderBy('updated_at','desc')->get();
        $permission = permissions::orderBy('name','asc')->get();
        $show = role_has_permissions::select('role_id','roles.name')
                ->join('roles','roles.id','=','role_has_permissions.role_id')
                ->groupBy('role_id','roles.name')
                ->orderBy('roles.name')
                ->get();
        $selection = role_has_permissions::join('permissions','permissions.id','=','role_has_permissions.permission_id')
                ->join('roles','roles.id','=','role_has_permissions.role_id')
                ->select('roles.id as id_role','permissions.id as id_permission','permissions.name as name_permission','role_has_permissions.*')
                ->get();

        // print_r($show);
        // die();

        $data = [
            'role' => $role,
            'permission' => $permission,
            'selection' => $selection,
            'show' => $show
        ];

        return response()->json($data, 200);
    }

    function tableAkses()
    {
        $show = permissions::get();

        $data = [
            'show' => $show,
        ];

        return response()->json($data, 200);
    }

    function tableJabatan()
    {
        $show = roles::get();

        $data = [
            'show' => $show,
        ];

        return response()->json($data, 200);
    }

    function hapusAkses($id){
        $tgl = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');

        $data = permissions::where('id', $id)->first();
        $data->delete();

        return response()->json($tgl, 200);
    }

    function hapusJabatan($id){
        $tgl = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');

        $data = roles::where('id', $id)->first();
        $data->delete();

        return response()->json($tgl, 200);
    }

    function destroy($id){
        $tgl = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');

        $data = role_has_permissions::where('role_id', $id)->get();
        $data->delete();

        return response()->json($tgl, 200);
    }

}
