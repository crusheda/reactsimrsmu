<?php

namespace App\Http\Controllers\MFK;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use App\Models\model_has_roles;
use App\Models\accident_report;
use App\Models\roles;
use App\Models\User;
use Carbon\Carbon;
use Auth;
use Storage;
use Exception;
use Redirect;

class AccidentReportController extends Controller
{
    public function index()
    {
        // $unit = roles::where('name', '<>','administrator')->orderBy('updated_at','desc')->get();
        // $show = accident_report::get();

        // $data = [
        //     'show' => $show,
        //     'unit' => $unit
        // ];

        // return view('pages.mfk.accidentreport.index')->with('list', $data);
        return view('pages.mfk.accidentreport.index');
    }

    function tambah() {
        $unit = roles::where('name', '<>','administrator')->orderBy('updated_at','desc')->get();
        $user = user::where('nik', '<>',null)->get();

        $data = [
            'user' => $user,
            'unit' => $unit
        ];

        return view('pages.mfk.accidentreport.tambah')->with('list', $data);
    }

    function ubah($id) {
        $unit = roles::where('name', '<>','administrator')->orderBy('updated_at','desc')->get();
        $user = user::where('nik', '<>',null)->get();
        $show = accident_report::join('users','users.id','=','mfk_accident_report.korban')
                ->select('mfk_accident_report.*','users.nama as nama_korban')
                ->where('mfk_accident_report.id',$id)
                ->orderBy('mfk_accident_report.tgl','DESC')
                ->limit('30')
                ->first();

        // print_r($show);
        // die();
        $data = [
            'user' => $user,
            'unit' => $unit,
            'show' => $show
        ];

        return view('pages.mfk.accidentreport.ubah')->with('list', $data);
    }

    function table() {
        $user = user::where('nik', '<>',null)->get();
        $unit = roles::where('name', '<>','administrator')->orderBy('updated_at','desc')->get();
        $show = accident_report::orderBy('tgl','DESC')
                ->limit('30')
                ->get();

        $data = [
            'user' => $user,
            'show' => $show,
            'unit' => $unit
        ];

        return response()->json($data, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // tampung berkas yang sudah diunggah ke variabel baru
        // 'file' merupakan nama input yang ada pada form
        $uploadedFile = $request->file('file');

        // simpan berkas yang diunggah ke sub-direktori 'public/files'
        // direktori 'files' otomatis akan dibuat jika belum ada
        if ($uploadedFile == '') {
            $path = '';
            $title = '';
        }else {
            $path = $uploadedFile->store('public/files/k3/accidentreport');
            $title = $uploadedFile->getClientOriginalName();
        }
        // print_r($path);
        // die();

        $user = Auth::user();
        $id_user = $user->id; //jamhuri$user = Auth::user();
        $name = $user->name; //jamhuri$user = Auth::user();
        // $role = model_has_roles::join('roles', 'model_has_roles.role_id', '=', 'roles.id')->select('roles.name')->where('model_has_roles.model_id', $userId)->get();
        // foreach ($role as $key => $value) {
        //     $unit[] = $value->name;
        // }

        $thn = Carbon::now()->format('Y');
        $parse = Carbon::parse($request->lahir)->format('Y');
        $usia = $thn - $parse;

        $data = new accident_report;
        $data->tgl = $request->tgl;
        $data->lokasi = $request->lokasi;
        $data->jenis = $request->jenis;
        $data->lain1 = $request->lain1;
        $data->kronologi = $request->kronologi;

        $data->kerugian = $request->kerugian;
        if ($request->korban != '') {
            $data->korban = $request->korban;
        } else {
            $data->korban_luar = $request->korban_luar;
        }
        $data->lahir = $request->lahir;
        $data->usia = $usia;
        $data->jk = $request->jk;
        $data->role = $request->role;
        // if ($request->role != '') {
        //     $data->role = $request->role;
        // } else {
        //     $data->role_luar = $request->role_luar;
        // }
        $data->cedera = $request->cedera;
        $data->penanganan = $request->penanganan;
        $data->k_aset = $request->k_aset;
        $data->k_lingkungan = $request->k_lingkungan;

        $data->tta = $request->tta;
        $data->kta = $request->kta;
        $data->f_personal = $request->f_personal;
        $data->f_pekerjaan = $request->f_pekerjaan;
        $data->p_kerja = $request->p_kerja;
        $data->mesin = $request->mesin;
        $data->material = $request->material;
        $data->alat_berat = $request->alat_berat;
        $data->kendaraan = $request->kendaraan;
        $data->benda_bergerak = $request->benda_bergerak;
        $data->bejana_tekan = $request->bejana_tekan;
        $data->alat_listrik = $request->alat_listrik;
        $data->radiasi = $request->radiasi;
        $data->binatang = $request->binatang;
        $data->lain2 = $request->lain2;

        $data->r_tindakan = $request->r_tindakan;
        $data->t_waktu = $request->t_waktu;
        $data->wewenang = $request->wewenang;

        $data->title = $title;
        $data->filename = $path;
        $data->user = $id_user;

        $data->save();

        return redirect()->route('accidentreport.index')->with('message','Tambah Laporan Kecelakaan Kerja Berhasil.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = accident_report::find($id);
        return Storage::download($data->filename, $data->title);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $thn = Carbon::now()->format('Y');
        // $thn = Carbon::now();
        $getlahir = $request->lahir;
        $parse = Carbon::parse($getlahir)->format('Y');
        // $parse = Carbon::parse($getlahir);
        $usia = $thn - $parse;

        $data = accident_report::find($request->id);
        $data->tgl = $request->tgl;
        $data->lokasi = $request->lokasi;
        $data->jenis = $request->jenis;
        $data->lain1 = $request->lain1;
        $data->kronologi = $request->kronologi;

        $data->kerugian = $request->kerugian;
        // if ($request->korban != '') {
        //     $data->korban = $request->korban;
        // } else {
        //     $data->korban_luar = $request->korban_luar;
        // }
        $data->lahir = $request->lahir;
        $data->usia = $usia;
        $data->jk = $request->jk;
        // $data->role = $request->unit;
        $data->cedera = $request->cedera;
        $data->penanganan = $request->penanganan;
        $data->k_aset = $request->k_aset;
        $data->k_lingkungan = $request->k_lingkungan;

        $data->tta = $request->tta;
        $data->kta = $request->kta;
        $data->f_personal = $request->f_personal;
        $data->f_pekerjaan = $request->f_pekerjaan;
        $data->p_kerja = $request->p_kerja;
        $data->mesin = $request->mesin;
        $data->material = $request->material;
        $data->alat_berat = $request->alat_berat;
        $data->kendaraan = $request->kendaraan;
        $data->benda_bergerak = $request->benda_bergerak;
        $data->bejana_tekan = $request->bejana_tekan;
        $data->alat_listrik = $request->alat_listrik;
        $data->radiasi = $request->radiasi;
        $data->binatang = $request->binatang;
        $data->lain2 = $request->lain2;

        $data->r_tindakan = $request->r_tindakan;
        $data->t_waktu = $request->t_waktu;
        $data->wewenang = $request->wewenang;

        // print_r($data);
        // die();
        $data->save();

        return redirect()->route('accidentreport.index')->with('message','Perubahan Laporan Kecelakaan Kerja Berhasil.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Inisialisasi
        $tgl = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');
        $data = accident_report::find($id);

        // Proses Hapus Lampiran
        if ($data->filename != null && $data->filename != '') {
            Storage::delete($data->filename);
        }

        // Proses Hapus Data dari DB
        $data->delete();

        // redirect
        return response()->json($tgl, 200);
        // return Redirect::back()->with('message','Hapus Laporan Berhasil');
    }

    public function download(Request $id)
    {
        $data = accident_report::find($id);
        $data->filename = $filename;
        $path = storage_path($filename);

        return response()->file($pathToFile, $headers);
    }

    public function cetak($id)
    {
        $data = accident_report::where('id',$id)->first();

        $tgl = Carbon::parse($data->tgl)->toDateString();
        $jam = Carbon::parse($data->tgl)->toTimeString();

        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(public_path().'/doc/k3/laporan-kak.docx');

        $user = $data->user;
        $unit = $data->unit;

        // print_r($jam);
        // die();
        $filename = "Laporan Kecelakaan Kerja | ".$user." - ".$unit;

        $jenis1 = '';
        $jenis2 = '';
        $jenis3 = '';
        $jenis4 = '';
        $jenis5 = '';
        $jenis6 = '';
        $jenis7 = '';
        $jenis8 = '';
        $jenis9 = '';
        $jenis10 = '';
        $jenis11 = '';
        $jenis12 = '';
        $jenis13 = '';
        $jenis14 = '';

        if ($data->jenis == 1) {
            $jenis1 = '√';
        }elseif ($data->jenis == 2) {
            $jenis2 = '√';
        }elseif ($data->jenis == 3) {
            $jenis3 = '√';
        }elseif ($data->jenis == 4) {
            $jenis4 = '√';
        }elseif ($data->jenis == 5) {
            $jenis5 = '√';
        }elseif ($data->jenis == 6) {
            $jenis6 = '√';
        }elseif ($data->jenis == 7) {
            $jenis7 = '√';
        }elseif ($data->jenis == 8) {
            $jenis8 = '√';
        }elseif ($data->jenis == 9) {
            $jenis9 = '√';
        }elseif ($data->jenis == 10) {
            $jenis10 = '√';
        }elseif ($data->jenis == 11) {
            $jenis11 = '√';
        }elseif ($data->jenis == 12) {
            $jenis12 = '√';
        }elseif ($data->jenis == 13) {
            $jenis13 = '√';
        }elseif ($data->jenis == 14) {
            $jenis14 = '√';
        }

        $rugi1 = '';
        $rugi2 = '';
        $rugi3 = '';
        $rugi4 = '';
        $rugi5 = '';

        if ($data->kerugian == 1) {
            $rugi1 = '√';
        }elseif ($data->kerugian == 2) {
            $rugi2 = '√';
        }elseif ($data->kerugian == 3) {
            $rugi3 = '√';
        }elseif ($data->kerugian == 4) {
            $rugi4 = '√';
        }elseif ($data->kerugian == 5) {
            $rugi5 = '√';
        }

        // $templateProcessor->setImageValue('img', array('path' => public_path($data->filename), 'width' => 500, 'height' => 500, 'ratio' => true));

        $templateProcessor->setValues([
            'tgl' => $tgl,
            'jam' => $jam,
            'lokasi' => $data->lokasi,

                '1' => $jenis1,
                '2' => $jenis2,
                '3' => $jenis3,
                '4' => $jenis4,
                '5' => $jenis5,
                '6' => $jenis6,
                '7' => $jenis7,
                '8' => $jenis8,
                '9' => $jenis9,
                '10' => $jenis10,
                '11' => $jenis11,
                '12' => $jenis12,
                '13' => $jenis13,
                '14' => $jenis14,

            'lain1' => $data->lain1,
            'kronologi' => $data->kronologi,

                'a' => $rugi1,
                'b' => $rugi2,
                'c' => $rugi3,
                'd' => $rugi4,
                'e' => $rugi5,

            'korban' => $data->korban,
            'lahir' => $data->lahir,
            'usia' => $data->usia,
            'jk' => $data->jk,
            'unit' => $data->unit,
            'cedera' => $data->cedera,
            'penanganan' => $data->penanganan,
            'k_aset' => $data->k_aset,
            'k_lingkungan' => $data->k_lingkungan,
            'tta' => $data->tta,
            'kta' => $data->kta,
            'f_personal' => $data->f_personal,
            'f_pekerjaan' => $data->f_pekerjaan,
            'p_kerja' => $data->p_kerja,
            'mesin' => $data->mesin,
            'material' => $data->material,
            'alat_berat' => $data->alat_berat,
            'kendaraan' => $data->kendaraan,
            'benda_bergerak' => $data->benda_bergerak,
            'bejana_tekan' => $data->bejana_tekan,
            'alat_listrik' => $data->alat_listrik,
            'radiasi' => $data->radiasi,
            'binatang' => $data->binatang,
            'lain2' => $data->lain2,
            'r_tindakan' => $data->r_tindakan,
            't_waktu' => $data->t_waktu,
            'wewenang' => $data->wewenang,
        ]);

        header("Content-Disposition: attachment; filename=$filename.docx");

        $templateProcessor->saveAs('php://output');
    }

    public function verifikasi($id)
    {
        $getclock = Carbon::now();
        $data = accident_report::find($id);
        $data->verifikasi = $getclock;
        $data->save();

        return Redirect::back()->with('message','Laporan berhasil di Verifikasi.');
    }
}
