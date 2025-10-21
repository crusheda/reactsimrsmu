<?php

namespace App\Http\Controllers\Mutu;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Crypt;
use App\Models\mutu_manrisk;
use App\Models\model_has_roles;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Storage;
use Auth;
use Validator,Redirect,Response,File;

class ManriskController extends Controller
{
    function index()
    {
        $show = mutu_manrisk::get();

        $data = [
            'show' => $show,
        ];

        return view('pages.mutu.manrisk.index')->with('list',$data);
    }

    function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:xls,xlsx|max:1000',
            'keterangan' => 'nullable',
        ]);

        $user = Auth::user();
        $user_id = $user->id;

        $file = $request->file('file');
        $find = mutu_manrisk::where('id_user',$user_id)->get();

        foreach ($find as $key => $value) {
            if ($value->title == $file->getClientOriginalName()) {
                return redirect()->back()->withErrors('Maaf, Nama file '.$value->title.' sudah pernah diupload oleh seseorang. Mohon Ganti Nama File yang berbeda. Disarankan untuk menambahkan identitas Unit/Bulan/Tahun untuk membuat nama yang unik pada File Anda.');
            }
        }

        $role = model_has_roles::join('roles', 'model_has_roles.role_id', '=', 'roles.id')->select('roles.name')->where('model_has_roles.model_id', $user_id)->get();

        foreach ($role as $key => $value) {
            $unit[] = $value->name;
        }

        if ($validator->fails()) {
            $arr = json_encode($validator->errors());
            return redirect()->back()->with('error',$arr);
        } else {
            $data = new mutu_manrisk;
            $data->id_user = $user_id;
            $data->unit = json_encode($unit);
            $data->judul = $request->judul;
            $data->bln = $request->bln;
            $data->thn = $request->thn;
            $data->keterangan = $request->keterangan;

            $data->title = $request->title ?? $file->getClientOriginalName();
            $data->filename = $file->store('public/files/mutu/manrisk/'.$user_id.'/'.$request->thn.'/'.$request->bln);

            $data->save();

            return redirect()->back()->with('message','Tambah Mutu Manajemen Risiko Berhasil');
        }
    }

    function table()
    {
        $show = mutu_manrisk::get();

        $data = [
            'show' => $show,
        ];

        return response()->json($data, 200);
    }

    function download($id)
    {
        $data = mutu_manrisk::find($id);
        return Storage::download($data->filename, $data->title);
    }

    public function hapus($id)
    {
        $tgl = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');

        $data = mutu_manrisk::find($id);
        $file = $data->filename;

        Storage::delete($file);
        $data->delete();

        return response()->json($tgl, 200);
    }
}
