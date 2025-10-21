<?php

namespace App\Http\Controllers\Berkas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\model_has_roles;
use App\Models\berkas_rka;
use App\Models\User;
use Carbon\Carbon;
use Redirect;
use Storage;
use Response;
use Auth;

class RkaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $show = berkas_rka::get();
        $user = Auth::user();
        $nama = $user->nama;
        $bln = Carbon::now()->isoFormat('MM');

        $users = DB::table('users')->get();

        $data = [
            'show' => $show,
            'bln' => $bln,
        ];

        return view('pages.berkas.rka.index')->with('list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'file' => ['mimes:xls,xlsx,pdf','max:50000'],
        ]);

        $now = Carbon::now();
        $verifikasi = berkas_rka::get();
        $tahun = Carbon::now()->isoFormat('YYYY');
        $tgl = $now->isoFormat('dddd, D MMMM Y, HH:mm:ss a');
        // print_r($now);
        // die();

        $uploadedFile = $request->file('file');

        $title = $uploadedFile->getClientOriginalName();
        foreach ($verifikasi as $key => $value) {
            if ($value->title == $title) {
                return redirect()->back()->withErrors('File yang Anda Upload sudah Ada, mohon Rename file dan silakan Upload ulang.');
                // return response()->json($value->title, 500);
            }
        }
        $path = $uploadedFile->storeAs("public/files/rka/", $title);

        $user = Auth::user();
        $id_user = $user->id;
        $nama = $user->nama;
        $role = model_has_roles::join('roles', 'model_has_roles.role_id', '=', 'roles.id')->select('roles.name')->where('model_has_roles.model_id', $id_user)->get();

        foreach ($role as $key => $value) {
            $unit[] = $value->name;
        }

        $data = new berkas_rka;
        $data->id_user = $id_user;
        $data->nama = $nama;
        $data->tahun = $tahun;
        $data->unit = json_encode($unit);
        $data->tgl = $now;
        $data->title = $title;
        $data->filename = $path;
        $data->save();

        return redirect()->back()->with('message','Upload Berkas Berhasil');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = berkas_rka::find($id);
        return Storage::download($data->filename, $data->title);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $tgl = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');
        // $now = Carbon::now();

        // $data = berkas_rka::where('id', $id)->first();
        // $file = $data->filename;

        // Storage::delete($file);
        // $data->delete();

        // return response()->json($tgl, 200);
    }

    // API
    function table()
    {
        $data = berkas_rka::leftJoin('users_foto', 'users_foto.user_id', '=', 'berkas_rka.id_user')
            ->join('users', 'users.id', '=', 'berkas_rka.id_user')
            ->select('users_foto.filename as users_foto', 'users.nama as nama_profil', 'berkas_rka.*')
            ->orderBy('berkas_rka.tgl', 'desc')
            ->get();

        return response()->json($data, 200);
    }

    public function upload(Request $request)
    {
        $now = Carbon::now();
        $verifikasi = berkas_rka::get();
        $tahun = Carbon::now()->isoFormat('YYYY');
        $tgl = $now->isoFormat('dddd, D MMMM Y, HH:mm:ss a');

        $uploadedFile = $request->file('fileToUpload');

        $title = $uploadedFile->getClientOriginalName();
        foreach ($verifikasi as $key => $value) {
            if ($value->title == $title) {
                return response()->json($value->title, 500);
            }
        }
        $path = $uploadedFile->storeAs("public/files/perencanaan/rka/", $title);

        $user = Auth::user();
        $id_user = $user->id;
        $nama = $user->nama;
        $role = $user->roles;

        foreach ($role as $key => $value) {
            $unit[] = $value->name;
        }

        $data = new berkas_rka;
        $data->id_user = $id_user;
        $data->nama = $nama;
        $data->tahun = $tahun;
        $data->unit = json_encode($unit);
        $data->tgl = $now;
        $data->title = $title;
        $data->filename = $path;
        $data->save();

        return response()->json($tgl, 200);
    }

    public function fileupload(Request $request)
    {
        $tahun = Carbon::now()->isoFormat('YYYY');
        $image = $request->file('file');
        // dd($image);
        $fileInfo = $image->getClientOriginalName();
        $filename = pathinfo($fileInfo, PATHINFO_FILENAME);
        $extension = pathinfo($fileInfo, PATHINFO_EXTENSION);
        $file_name= $filename.'-'.time().'.'.$extension;
        $image->move(public_path('gallery'),$file_name);

        return response()->json(['success'=>$file_name]);

        // $imageUpload = new Gallery;
        // $imageUpload->original_filename = $fileInfo;
        // $imageUpload->filename = $file_name;
        // $imageUpload->save();
        // print_r()

        // if ($request->hasFile('file')) {

        //     // Upload path
        //     $destinationPath = 'public/files/rka/'.$tahun.'/';

        //     // Get file extension
        //     $extension = $request->file('file')->getClientOriginalExtension();

        //     // Valid extensions
        //     $validextensions = array("xls", "xlsx", "pdf");

        //     // Check extension
        //     if (in_array(strtolower($extension), $validextensions)) {

        //         // Rename file
        //         $fileName = $request->file('file')->getClientOriginalName() . time() . '.' . $extension;
        //         // Uploading file to given path
        //         $request->file('file')->move($destinationPath, $fileName);
        //     }
        // }
        // return view('pages.profil.index');
    }

    public function hapus($id)
    {
        $tgl = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');
        $now = Carbon::now();

        $data = berkas_rka::where('id', $id)->first();
        $file = $data->filename;

        Storage::delete($file);
        $data->delete();

        return response()->json($tgl, 200);
    }
}
