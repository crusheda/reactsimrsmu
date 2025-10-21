<?php

namespace App\Http\Controllers\HakAkses;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\users;
use App\Models\roles;
use App\Models\model_has_roles;
use Carbon\Carbon;
use Auth, Redirect;

class DataKaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->getPermission('akun_pengguna') == true || Auth::user()->getRole('karu-it') == true) {
            $user = users::select('id','name','nama','updated_at')
            ->where('name', '<>','admin')
            ->where('name', '<>','it')
            ->where('name', '<>','demo')
            ->whereNull('deleted_at')
            ->whereNull('status')
            ->orderBy('nama', 'asc')
            ->get();
            $role = model_has_roles::join('roles', 'model_has_roles.role_id', '=', 'roles.id')->select('model_has_roles.model_id as id_user','roles.name as nama_role')->get();

            $data = [
                'user' => $user,
                'role' => $role,
            ];

            return view('pages.hakakses.akunpengguna.index')->with('list', $data);
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
        $role = roles::where('name', '<>','administrator')->get();

        return view('pages.hakakses.akunpengguna.tambah')->with('role', $role);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cekUser = users::where('name', $request->name)->whereNull('status')->whereNull('deleted_at')->first();

        if ($cekUser) {
            return Redirect::back()->withErrors(['msg' => 'Username '.$request->name.' sudah terdaftar! Silakan ganti Username Lainnya.'])->withInput();
        }

        $data = new users;
        $data->name = $request->name;
        $data->email = $request->email;
        $data->password = bcrypt($request->password);
        $data->save();

        foreach ($request->role as $key => $value) {
            $model = new model_has_roles;
            $model->role_id = $value;
            $model->model_type = 'App\Models\User';
            $model->model_id = $data->id;
            // print_r($model);
            // die();
            $model->save();
        }

        return redirect()->route('akunpengguna.index')->with('message','Tambah Akun '.$data->name.' Berhasil');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = users::find($id);
        $model = model_has_roles::where('model_id', $id)->get();
        $role = roles::get();

        // print_r($model);
        // die();

        $data = [
            'user' => $user,
            'model' => $model,
            'role' => $role,
        ];

        return view('pages.hakakses.akunpengguna.ubah')->with('list', $data);
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
        $data = users::find($id);
        $data->name = $request->name;
        $data->email = $request->email;
        if (!empty($request->password)) {
            $data->password = bcrypt($request->password);
        }
        $data->save();

        model_has_roles::where('model_id', $id)->delete();

        foreach ($request->role as $key => $value) {
            $model = new model_has_roles;
            $model->role_id = $value;
            $model->model_type = 'App\Models\User';
            $model->model_id = $id;
            // print_r($model);
            // die();
            $model->save();
        }

        return redirect()->route('akunpengguna.index')->with('message','Ubah Akun '.$data->name.' Berhasil');
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
    public function verifName($name)
    {
        $data = users::where('name',$name)->first();
        if (!empty($data)) {
            $retur = 1;
        } else {
            $retur = 0;
        }

        return response()->json($retur, 200);
    }

    public function hapus($id)
    {
        $tgl = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');

        $data = users::find($id);
        $data->status = 1;
        $data->user_hapus = Auth::user()->id;
        $data->save();

        $data->delete();
        model_has_roles::where('model_id', $id)->delete();

        return response()->json($tgl, 200);
    }
}
