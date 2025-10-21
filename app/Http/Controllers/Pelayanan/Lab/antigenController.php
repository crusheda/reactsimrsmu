<?php

namespace App\Http\Controllers\Pelayanan\Lab;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use App\Models\antigen;
use App\Models\dokter;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Exception;
use Redirect;
use Storage;
use Auth;
use \PDF;

class antigenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->getPermission('antigen') == true) {
            $now = Carbon::now()->isoFormat('YYYY-MM-DD HH:mm:ss');
            $tgl = Carbon::now()->isoFormat('DD');
            $bln = Carbon::now()->isoFormat('MM');
            $thn = Carbon::now()->isoFormat('YYYY');

            $dokter = dokter::get();

            // $query_string1 = "SELECT hasil,count(hasil) as jumlah FROM antigen WHERE YEAR(tgl) = $thn AND MONTH(tgl) = $bln AND DAY(tgl) = $tgl AND hasil = 'POSITIF' AND deleted_at IS NULL GROUP BY hasil";
            // $getpos = DB::select($query_string1);

            // $query_string2 = "SELECT hasil,count(hasil) as jumlah FROM antigen WHERE YEAR(tgl) = $thn AND MONTH(tgl) = $bln AND DAY(tgl) = $tgl AND hasil = 'NEGATIF' AND deleted_at IS NULL GROUP BY hasil";
            // $getneg = DB::select($query_string2);

            // $query_string3 = "SELECT count(hasil) as jumlah FROM antigen WHERE YEAR(tgl) = $thn AND MONTH(tgl) = $bln AND DAY(tgl) = $tgl AND deleted_at IS NULL";
            // $gettoday = DB::select($query_string3);

            // $query_string4 = "SELECT count(hasil) as jumlah FROM antigen WHERE YEAR(tgl) = $thn AND MONTH(tgl) = $bln AND deleted_at IS NULL";
            // $getmont = DB::select($query_string4);

            $data = [
                'now' => $now,
                'dokter' => $dokter,
                // 'getpos' => $getpos,
                // 'getneg' => $getneg,
                // 'gettoday' => $gettoday,
                // 'getmont' => $getmont
            ];

            // return view('pages.new.lab.antigen')->with('list', $data);
            return view('pages.pelayanan.lab.antigen.index')->with('list', $data);
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
        $user = Auth::user();
        $user_id = $user->id;

        $pj = 'dr. Endang Tri Peterani, Sp.PK';

        // print_r($request->rm);
        // die();

        $data = new antigen;
        $data->dr_pengirim  = $request->dr_pengirim;
        $data->pemeriksa  = $request->pemeriksa;
        if ($request->nama == '') {
            return redirect::back()->withErrors('Nomor RM yang anda masukkan Tidak Valid, mohon ulangi sekali lagi.');
        }
        // if (strlen((string)$request->rm) == 5) {
        //     $rm = '000'.$request->rm;
        // } else {
        //     $rm = '00'.$request->rm;
        // }
        $data->rm           = $request->rm;
        $data->nama         = $request->nama;
        $data->jns_kelamin  = $request->jns_kelamin;
        $data->umur         = $request->umur;
        $data->alamat       = $request->alamat.', '.strtoupper($request->kec).', '.strtoupper($request->kab);
        $data->tgl          = $request->tgl;
        $data->hasil        = $request->hasil;
        $data->pj           = $pj;
        $data->user_id      = $user_id;

        $data->desa         = $request->des;
        $data->kecamatan    = $request->kec;
        $data->kabupaten    = $request->kab;

        $data->save();
        return redirect::back()->with('message','Hasil Antigen Berhasil Ditambahkan a/n '.$request->nama);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $data = antigen::find($id);

        $data->dr_pengirim  = $request->dr_pengirim;
        $data->pemeriksa  = $request->pemeriksa;
        // $data->rm           = $request->rm;
        // $data->nama         = $request->nama;
        // $data->jns_kelamin  = $request->jns_kelamin;
        // $data->umur         = $request->umur;
        // $data->alamat       = $request->alamat;
        $data->tgl          = $request->tgl;
        $data->hasil        = $request->hasil;

        $data->save();
        return redirect::back()->with('message','Ubah Hasil Antigen Berhasil');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = antigen::find($id);
        $data->delete();

        return redirect::back()->with('message','Hapus Hasil Antigen Berhasil');
    }

    public function cetak($id)
    {
        $data = antigen::where('id',$id)->first();

        // 1 = dr. Gede Sri Dhyana, Sp.OG
        // 2 = dr. H. Ahmad Sutamat, Sp.OG
        $nama = $data->nama;
        $tgl = Carbon::parse($data->tgl)->isoFormat('DD/MM/YYYY HH:mm');
        // print_r($tgl);
        // die();

        if ($data->hasil == 'POSITIF') {
            $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(public_path().'/doc/lab/antigen/antigen-positif.docx');
        }elseif ($data->hasil == 'NEGATIF') {
            $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(public_path().'/doc/lab/antigen/antigen-negatif.docx');
        }else {
            return redirect()->route('antigen.index')->withErrors('Gagal Unduh Laporan');
        }
        $tgl_name = Carbon::parse($data->tgl)->isoFormat('DD MMM YYYY');
        $file_name = 'Antigen '.$nama.' '.$tgl_name;
        // $filename = 'Antigen RSPKUSKH';
        $filename = str_replace(array('"', "'", ' ', ','), '_', $file_name);;

        $dokter = dokter::where('id',(int)$data->dr_pengirim)->first();
        // print_r($dokter);
        // die();
        $templateProcessor->setValues([
            'dr_pengirim' => $dokter->nama,
            'pemeriksa' => $data->pemeriksa,
            'rm' => $data->rm,
            'nama' => $nama,
            'jns_kelamin' => $data->jns_kelamin,
            'umur' => $data->umur,
            'alamat' => $data->alamat,
            'tgl' => $tgl,
        ]);

        header("Content-Disposition: attachment; filename=$filename.docx");

        $templateProcessor->saveAs('php://output');
    }

    public function print($id)
    {
        $show = DB::table('antigen')
                ->join('dokter', 'dokter.id', '=', 'antigen.dr_pengirim')
                ->where('antigen.deleted_at',null)
                ->where('antigen.id',$id)
                ->select('dokter.id as dr_id','dokter.nama as dr_nama','dokter.jabatan as dr_jabatan','antigen.*')
                ->first();

        // $dokter = dokter::where('id',(int)$show->dr_pengirim)->first();
        $tgl = Carbon::parse($show->tgl)->isoFormat('DD/MM/YYYY HH:mm');

        $data = [
            'show' => $show,
            // 'dokter' => $dokter,
            'tgl' => $tgl
        ];

        // print_r($data);
        // die();
        return view('pages.pelayanan.lab.antigen.cetak')->with('list', $data);
    }

    public function showAll()
    {
        $now = Carbon::now()->isoFormat('YYYY-MM-DD HH:mm:ss');
        $tgl = Carbon::now()->isoFormat('DD');
        $bln = Carbon::now()->isoFormat('MM');
        $thn = Carbon::now()->isoFormat('YYYY');

        $query_string1 = "SELECT hasil,count(hasil) as jumlah FROM antigen WHERE YEAR(tgl) = $thn AND MONTH(tgl) = $bln AND hasil = 'POSITIF' AND deleted_at IS NULL GROUP BY hasil";
        $getpos = DB::select($query_string1);

        $query_string2 = "SELECT hasil,count(hasil) as jumlah FROM antigen WHERE YEAR(tgl) = $thn AND MONTH(tgl) = $bln AND hasil = 'NEGATIF' AND deleted_at IS NULL GROUP BY hasil";
        $getneg = DB::select($query_string2);

        $query_string3 = "SELECT hasil,count(hasil) as jumlah FROM antigen WHERE YEAR(tgl) = $thn AND hasil = 'POSITIF' AND deleted_at IS NULL GROUP BY hasil";
        $getposyear = DB::select($query_string3);

        $query_string4 = "SELECT hasil,count(hasil) as jumlah FROM antigen WHERE YEAR(tgl) = $thn AND hasil = 'NEGATIF' AND deleted_at IS NULL GROUP BY hasil";
        $getnegyear = DB::select($query_string4);

        $query_string5 = "SELECT count(hasil) as jumlah FROM antigen WHERE YEAR(tgl) = $thn AND MONTH(tgl) = $bln AND deleted_at IS NULL";
        $getmont = DB::select($query_string5);

        $query_string6 = "SELECT count(hasil) as jumlah FROM antigen WHERE YEAR(tgl) = $thn AND deleted_at IS NULL";
        $getyear = DB::select($query_string6);

        $data = [
            'now' => $now,
            'getpos' => $getpos,
            'getneg' => $getneg,
            'getposyear' => $getposyear,
            'getnegyear' => $getnegyear,
            'getmont' => $getmont,
            'getyear' => $getyear,
        ];

        return view('pages.pelayanan.lab.antigen.all')->with('list', $data);
    }

    public function apiShowAll()
    {
        $now = Carbon::now()->isoFormat('YYYY-MM-DD HH:mm:ss');
        $tgl = Carbon::now()->isoFormat('DD');
        $bln = Carbon::now()->isoFormat('MM');
        $thn = Carbon::now()->isoFormat('YYYY');

        $dokter = dokter::get();
        $show = DB::table('antigen')
                ->join('dokter', 'dokter.id', '=', 'antigen.dr_pengirim')
                ->where('antigen.deleted_at',null)
                ->select('dokter.id as dr_id','dokter.nama as dr_nama','dokter.jabatan as dr_jabatan','antigen.*')
                ->orderBy('tgl','DESC')
                ->get();

        $query_string1 = "SELECT hasil,count(hasil) as jumlah FROM antigen WHERE YEAR(tgl) = $thn AND MONTH(tgl) = $bln AND hasil = 'POSITIF' AND deleted_at IS NULL GROUP BY hasil";
        $getpos = DB::select($query_string1);

        $query_string2 = "SELECT hasil,count(hasil) as jumlah FROM antigen WHERE YEAR(tgl) = $thn AND MONTH(tgl) = $bln AND hasil = 'NEGATIF' AND deleted_at IS NULL GROUP BY hasil";
        $getneg = DB::select($query_string2);

        $query_string3 = "SELECT hasil,count(hasil) as jumlah FROM antigen WHERE YEAR(tgl) = $thn AND hasil = 'POSITIF' AND deleted_at IS NULL GROUP BY hasil";
        $getposyear = DB::select($query_string3);

        $query_string4 = "SELECT hasil,count(hasil) as jumlah FROM antigen WHERE YEAR(tgl) = $thn AND hasil = 'NEGATIF' AND deleted_at IS NULL GROUP BY hasil";
        $getnegyear = DB::select($query_string4);

        $query_string5 = "SELECT count(hasil) as jumlah FROM antigen WHERE YEAR(tgl) = $thn AND MONTH(tgl) = $bln AND deleted_at IS NULL";
        $getmont = DB::select($query_string5);

        $query_string6 = "SELECT count(hasil) as jumlah FROM antigen WHERE YEAR(tgl) = $thn AND deleted_at IS NULL";
        $getyear = DB::select($query_string6);

        $data = [
            'show' => $show,
            'now' => $now,
            'dokter' => $dokter,
            'getpos' => $getpos,
            'getneg' => $getneg,
            'getposyear' => $getposyear,
            'getnegyear' => $getnegyear,
            'getmont' => $getmont,
            'getyear' => $getyear,
        ];

        // print_r($data);
        // die();

        return response()->json($data, 200);
    }

    public function apiGet()
    {
        $show = DB::table('antigen')
                ->join('dokter', 'dokter.id', '=', 'antigen.dr_pengirim')
                ->where('antigen.deleted_at',null)
                ->select('dokter.id as dr_id','dokter.nama as dr_nama','dokter.jabatan as dr_jabatan','antigen.*')
                ->orderBy('tgl','DESC')
                ->limit('30')
                ->get();

        $data = [
            'show' => $show,
        ];

        return response()->json($data, 200);
    }

    public function getubah($id)
    {
        $show = antigen::where('id', $id)->first();

        $tgl = Carbon::parse($show->tgl)->isoFormat('YYYY-MM-DD');
        $waktu = Carbon::parse($show->tgl)->isoFormat('HH:mm:ss');

        $dokter = dokter::get();

        $data = [
            'id' => $id,
            'tgl' => $tgl,
            'waktu' => $waktu,
            'show' => $show,
            'dokter' => $dokter,
        ];

        return response()->json($data, 200);
    }

    public function ubah(Request $request)
    {
        $tgl = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');

        $data = antigen::find($request->id);
        $data->pemeriksa    = $request->pemeriksa;
        $data->tgl          = $request->tgl;
        $data->dr_pengirim  = $request->dr_pengirim;
        $data->hasil        = $request->hasil;
        $data->save();

        return response()->json($tgl, 200);
    }

    public function hapus($id)
    {
        $tgl = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');

        antigen::where('id', $id)->delete();

        return response()->json($tgl, 200);
    }

    public function filter()
    {
        return view('pages.pelayanan.lab.antigen.filter');
    }

    public function apiFilter(Request $request)
    {
        // $request->filter //=> 09/14/2022 - 09/14/2022
        // $from = date('2018-01-01');
        // $to = date('2018-05-02');
        // Reservation::whereBetween('reservation_from', [$from, $to])->get();
        // substr("Hello world",1,6); // ello w
        $from = date(Carbon::parse(substr($request->filter,0,10))->isoFormat('YYYY-MM-DD'));
        $to = date(Carbon::parse(substr($request->filter,13,10))->isoFormat('YYYY-MM-DD'));

        $data = DB::table('antigen')
                    ->join('dokter', 'dokter.id', '=', 'antigen.dr_pengirim')
                    ->select('antigen.*','dokter.nama as dr_nama')
                    ->orderBy('antigen.tgl','ASC')
                    ->where('antigen.deleted_at', null)
                    ->whereBetween('antigen.tgl', [$from, $to])
                    // ->whereMonth('antigen.tgl', $bulan)
                    // ->whereYear('antigen.tgl', $tahun)
                    ->get();

        return response()->json($data, 200);

    }

    /// PUSH API
    public function getPasien($rm)
    {
        $client = new Client();
        // $res = $client->request('GET', 'http://192.168.1.3:8000/api/jadwaldokter/');
        // $res = $client->request('GET', 'http://192.168.1.3:8000/api/all/'.$rm);
        // $res = $client->request('GET', 'http://103.155.246.25:8000/api/all/'.$rm); // yg ini

        // NEW IP PUBLIC
        $res = $client->request('GET', 'http://103.210.117.106:8000/api/all/'.$rm);
        $data = json_decode($res->getBody());
        // dd($data);

        return response()->json($data, 200);
    }
}
