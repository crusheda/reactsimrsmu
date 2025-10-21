<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\users;
use App\Models\roles;
use App\Models\model_has_roles;
use App\Models\struktur_organisasi;
use Carbon\Carbon;
use Auth;
use Storage;
use Exception;
use Redirect;

class StrukturOrganisasiController extends Controller
{
    function index()
    {
        if (Auth::user()->getPermission('struktur_organisasi') == true || Auth::user()->getRole('karu-it') == true) {
            $user  = users::where('status',null)->get();
            $roles  = roles::get();
            $struktur_organisasi  = struktur_organisasi::orderBy('updated_at','desc')->get();

            $data = [
                'user' => $user,
                'roles' => $roles,
                'struktur_organisasi' => $struktur_organisasi,
            ];

            return view('pages.strukturorganisasi.index')->with('list', $data);
        } else {
            return redirect()->back();
        }
    }

    function create()
    {
        $user  = users::where('status',null)->get();
        $role  = roles::get();

        $data = [
            'user' => $user,
            'role' => $role,
        ];

        return view('pages.strukturorganisasi.tambah')->with('list', $data);
    }

    function store(Request $request)
    {
        $getUser  = users::where('id',$request->user)->first();
        $getRoleUser  = model_has_roles::where('model_id',$getUser->id)->get();

        foreach ($getRoleUser as $key => $value) {
            $roleUser[] = strval($value->role_id);
        }

        $verifikasi = struktur_organisasi::where('id_user',$request->user)->first();
        if (!empty($verifikasi)) {
            return redirect()->back()->with('message','Struktur Organisasi '.$getUser->nama.' sudah ada.');
        }

        $data = new struktur_organisasi;
        $data->id_user = $getUser->id;
        $data->nama_user = $getUser->nama.' ('.$getUser->name.')';
        $data->role = json_encode($roleUser);
        // $data->bawahan = $request->bawahan;
        $data->bawahan = json_encode($request->bawahan);
        // dd($data);
        // print_r($data);
        // die();
        $data->save();

        return redirect()->route('strukturorganisasi.index')->with('message','Tambah Bawahan Struktur '.$getUser->nama.' Berhasil');
    }

    function edit($id)
    {
        $user  = users::where('status',null)->get();
        $role  = roles::get();
        $struktur_organisasi  = struktur_organisasi::where('id',$id)->first();

        $data = [
            'id' => $struktur_organisasi->id,
            'id_user' => $struktur_organisasi->id_user,
            'bawahan' => json_decode($struktur_organisasi->bawahan),
            'user' => $user,
            'role' => $role,
        ];

        return view('pages.strukturorganisasi.ubah')->with('list', $data);
    }

    function update(Request $request, $id)
    {
        $getUser  = users::where('id',$request->user)->first();
        $getRoleUser  = model_has_roles::where('model_id',$getUser->id)->get();

        foreach ($getRoleUser as $key => $value) {
            $roleUser[] = strval($value->role_id);
        }

        $verifikasi = struktur_organisasi::where('id_user',$request->user)->first();
        if (!empty($verifikasi)) {
            struktur_organisasi::find($verifikasi->id)->delete();
        }

        $data = new struktur_organisasi;
        $data->id_user = $getUser->id;
        $data->nama_user = $getUser->nama.' ('.$getUser->name.')';
        $data->role = json_encode($roleUser);
        // $data->bawahan = $request->bawahan;
        $data->bawahan = json_encode($request->bawahan);
        // dd($data);
        // print_r($data);
        // die();
        $data->save();

        return redirect()->route('strukturorganisasi.index')->with('message','Tambah Bawahan Struktur '.$getUser->nama.' Berhasil');
    }

    public function destroy($id)
    {
        $tgl = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');

        $data = struktur_organisasi::find($id);
        $data->delete();

        return response()->json($tgl, 200);
    }
}
