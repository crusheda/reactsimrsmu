<?php

namespace App\Http\Controllers\Berkas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Storage;
use Redirect;
use Auth;
use File;
use Validator;
use ZipArchive;
use Carbon\Carbon;
use App\Models\berkas_rapat;
use App\Models\users;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;

class RapatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = users::whereNotNull('nik')->where('status',null)->orderBy('nama','ASC')->get();
        // print_r($users);
        // die();
        $tgl = Carbon::now();
        $today = Carbon::now()->isoFormat('YYYY/MM/DD');

        $data = [
            'users' => $users,
            'tgl' => $tgl,
            'today' => $today,
        ];

        return view('pages.berkas.rapat.index')->with('list', $data);
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
        $validator = Validator::make($request->all(), [
            'file2.*' => 'required|mimes:doc,docx,xls,xlsx,ppt,pptx,pdf,jpg,gif,png,jpeg|max:5000',
            'keterangan' => 'nullable',
        ]);

        if ($validator->fails()) {
            $arr = json_encode($validator->errors());
            return redirect()->back()->with('error',$arr);
        } else {
            $user = Auth::user();
            $user_id = $user->id;
            $user_nama = $user->nama;

            $uploadedFile2 = $request->file('file2');

            $data = new berkas_rapat;
            $data->id_user = $user_id;
            $data->nama_user = $user_nama;
            $data->nama = $request->nama;
            $data->kepala = $request->kepala;
            $data->tanggal = $request->tanggal;
            $data->lokasi = $request->lokasi;

                if ($request->hasFile('file2')) {
                    foreach ($uploadedFile2 as $file) {
                        $array_filename2[] = $file->store('public/files/rapat/'.$user_id);
                        $array_title2[] = $file->getClientOriginalName();
                    }
                }
                $data->title2 = json_encode($array_title2);
                $data->filename2 = json_encode($array_filename2);

            $data->keterangan = $request->keterangan;
            $data->user_id = $user_id;
            // print_r($id);
            // die();

            $data->save();

            return redirect()->back()->with('message','Tambah Berkas Rapat Berhasil');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = berkas_rapat::find($id);
        return Storage::download($data->filename1, $data->title1);
    }

    public function showAll($id)
    {
        $data = berkas_rapat::where('id', $id)->first();

        $name = $data->nama_user;
        $tgl = Carbon::parse($data->created_at)->isoFormat('D MMM Y');

        // Text from DB Convert into Array First with JsonDECODE
        $files_mentah = json_decode($data->filename2);
        $filename_mentah = json_decode($data->title2);

        // Define Where ZIP will be Saved and Named
        $zip_path = storage_path().'/app/public/files/rapat/'.$data->id_user.'/zip'.'/'.$name.' - '.$tgl.'.zip'; // Folder dibuat manual dulu
        $zip_name = $name.' - '.$tgl.'.zip';

        // Check if Folder exist
        $path_folder_zip = storage_path().'/app/public/files/rapat/'.$data->id_user.'/zip';
        if(!File::exists($path_folder_zip)) {
            // Make Directory for ZIP
            File::makeDirectory($path_folder_zip);
        }

        // Making ZIP ARCHIVE
        $zip = new ZipArchive();
        if ($zip->open($zip_path, ZIPARCHIVE::CREATE | ZIPARCHIVE::OVERWRITE) !== TRUE) {
            die ("ERROR: Saat proses pembuatan ZIP, silakan hubungi IT");
        }

        // Looping with Foreach
        foreach ($files_mentah as $key => $file) {

            // Change DIR File from Array into String with JsonENCODE
            $files = json_encode($file);
            $filename_mentah2 = json_encode($filename_mentah[$key]);
            $filename = str_replace('"','',$filename_mentah2);     // Remove Quotes "" from Encoding Json

            // Adding Path into String Each File From DB
            $path = storage_path().'/app/'.$file;
            $filepath = $path;

            // Checking File and Adding File
            if (file_exists($filepath)) {
                // $filepath = direktori file yang akan dimasukkan
                // $filename = nama file yang digunakan untuk mengganti nama file dari $filepath
                $zip->addFile($filepath, $filename) or die ("ERROR: Tidak bisa menambahkan file $filename");
            } else {
                die("File $filename di Direktori $filepath tidak ditemukan");
            }
        }

        $zip->close();

        // Konten apa saja yang terkandung dalam ZIP (Contoh : PDF, Application, etc)
        $headers = ["Content-Type"=>"pdf/zip"];

        return response()->download($zip_path,$zip_name,$headers);
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
        $this->validate($request,[
            'nama' => 'required',
            'kepala' => 'nullable',
            'tanggal' => 'nullable',
            'lokasi' => 'nullable',
            'keterangan' => 'nullable',
            ]);

        $data = berkas_rapat::find($id);
        $data->nama = $request->nama;
        $data->kepala = $request->kepala;
        $data->tanggal = $request->tanggal;
        $data->lokasi = $request->lokasi;
        $data->keterangan = $request->keterangan;

        $data->save();
        return Redirect::back()->with('message','Perubahan Berkas Rapat Berhasil');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = berkas_rapat::find($id);
        $data->delete();

        // redirect
        return Redirect::back()->with('message','Hapus Berkas Rapat Berhasil');
    }

    // API

    public function download(Request $id)
    {
        $data = berkas_rapat::find($id);
        $data->filename = $filename;
        $path = storage_path($filename);

        return response()->file($pathToFile, $headers);
    }

    public function apifile()
    {
        $show = berkas_rapat::all();

        $data = [
            // 'count' => $total,
            'show' => $show
        ];

        return response()->json($show, 200);
    }

    public function getRapat()
    {
        // $users = Auth::user();
        $show = berkas_rapat::join('users','berkas_rapat.kepala','=','users.id')
                        ->select('users.nama as nama_kepala','berkas_rapat.*')
                        // ->where('users.status',null)
                        ->get();
        $tgl = Carbon::now();
        $today = Carbon::now()->isoFormat('YYYY/MM/DD');

        $data = [
            'show' => $show,
            'tgl' => $tgl,
            'today' => $today,
        ];

        return response()->json($data, 200);
    }

    public function detailRapat($id)
    {
        $show = berkas_rapat::join('users','berkas_rapat.user_id','=','users.id')->select('users.nama as user_nama','berkas_rapat.*')->where('berkas_rapat.id',$id)->first();
        $kepala = users::whereNotNull('nik')->where('status',null)->orderBy('nama','ASC')->get();

        $data = [
            'show' => $show,
            'kepala' => $kepala,
        ];

        return response()->json($data, 200);
    }

    public function ubah(Request $request)
    {
        $tgl = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');

        $data = berkas_rapat::find($request->id);
        $data->nama = $request->nama;
        $data->kepala = $request->kepala;
        $data->tanggal = $request->tanggal;
        $data->lokasi = $request->lokasi;
        $data->keterangan = $request->keterangan;
        $data->save();

        return response()->json($tgl, 200);
    }

    public function hapusRapat($id)
    {
        $tgl = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');

        berkas_rapat::where('id', $id)->delete();

        return response()->json($tgl, 200);
    }

    public function getFile($id)
    {
        $show = berkas_rapat::find($id);

        if ($show->title2 != null) {
            foreach (json_decode($show->title2) as $key => $value) {
                $arrNama [] = $value;
            }
        } else {
            $arrNama [] = "";
        }

        if ($show->filename2 != null) {
            foreach (json_decode($show->filename2) as $key => $value) {
                // for ($i=0; $i < $key ; $i++) {
                //     $namaFile = $arrNama[$i];
                // }
                $sizeFile = number_format(Storage::size($value) / 1048576,2);
                $file [] = array(
                    'nama' => $arrNama[$key],
                    'size' => $sizeFile
                );
            }
        }
        // print_r($file);
        // die();

        $tgl_upload = Carbon::parse($show->tanggal)->diffForHumans();

        $data = [
            'id' => $show->id,
            // 'namaFile' => $namaFile,
            // 'sizeFile' => $sizeFile,
            'file' => $file,
            'tgl_upload' => $tgl_upload,
        ];

        return response()->json($data, 200);
    }
}
