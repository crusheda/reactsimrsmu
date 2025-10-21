<?php

namespace App\Http\Controllers\Pelayanan\Kebidanan;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\skl;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Exception;
use Auth;
use \PDF;

class sklController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->getPermission('skl') == true) {
            // $show = skl::limit(100)->orderBy('no_surat', 'DESC')->get();

            $query = skl::orderBy('no_surat', 'DESC')->first();
            if ($query != null) {
                $nomer = $query->no_surat + 1;
            } else {
                $nomer = 1;
            }

            $data = [
                // 'show' => $show,
                'nomer' => $nomer
            ];

            // print_r($data);
            // die();

            // return view('pages.kebidanan.skl')->with('list', $data);
            // return view('pages.new.kebidanan.skl')->with('list', $data);
            return view('pages.pelayanan.kebidanan.skl.index')->with('list', $data);
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
        $name = $user->name;
        $tgl = Carbon::parse($request->tgl);

        $query = skl::where('no_surat', $request->no_surat)->first();
        if ($query != null) {
            return redirect()->back()->withErrors('Maaf, Nomor Surat sudah ada / digunakan.');
        } else {
            $data = new skl;
            $data->no_surat = $request->no_surat;
            $data->tgl = $tgl;
            $data->hari = $tgl->isoFormat('dddd');
            $data->nik_ibu = $request->nik_ibu;
            $data->nik_ayah = $request->nik_ayah;
            $data->ibu = 'NY. '.$request->ibu;
            $data->ayah = 'TN. '.$request->ayah;
            $data->anak = $request->anak;
            $data->kelamin = $request->kelamin;
            $data->bb = $request->bb;
            $data->tb = $request->tb;
            $data->alamat = $request->alamat;
            $data->dr = $request->dr;
            $data->user = $name;
            $data->save();
        }

        // $query = skl::orderBy('no_surat', 'DESC')->first();
        // if ($query != null) {
        //     $nomer = $query->no_surat + 1;
        // } else {
        //     $nomer = 1;
        // }

        // ex : $user->created_at->isoFormat('dddd, D MMMM Y');      "Minggu, 28 Juni 2020"
        // ex : $post->updated_at->diffForHumans();                  "2 hari yang lalu"

        // print_r($nomer);
        // die();

        return redirect()->back()->with('message','Tambah SKL Berhasil, silakan melakukan Cetak/Download.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = skl::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = skl::find($id);
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
        $data = skl::find($id);
        $tgl = Carbon::parse($request->tgl);

        $data->tgl = $tgl;
        $data->hari = $tgl->isoFormat('dddd');
        $data->nik_ibu = $request->nik_ibu;
        $data->nik_ayah = $request->nik_ayah;
        $data->ibu = $request->ibu;
        $data->ayah = $request->ayah;
        $data->anak = $request->anak;
        $data->kelamin = $request->kelamin;
        $data->bb = $request->bb;
        $data->tb = $request->tb;
        $data->alamat = $request->alamat;
        $data->dr = $request->dr;

        $data->save();

        return redirect()->back()->with('message','Perubahan Identitas Bayi Berhasil');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = skl::find($id);
        $data->delete();

        // redirect
        return redirect()->back()->with('message','Hapus Identitas Bayi Berhasil');
    }

    //API
    public function apiGet()
    {
        $show = skl::orderBy('no_surat','DESC')
                ->limit('30')
                ->get();

        $data = [
            'show' => $show,
        ];

        return response()->json($data, 200);
    }

    public function filterIbu($namaIbu)
    {
        $show = skl::orderBy('tgl','DESC')
                ->where('ibu',$namaIbu)
                ->orWhere('ibu', 'like', '%' . $namaIbu . '%')
                ->get();

        $data = [
            'show' => $show,
        ];

        return response()->json($data, 200);
    }

    public function getubah($id)
    {
        $show = skl::where('id', $id)->first();

        $tgl = Carbon::parse($show->tgl)->isoFormat('YYYY-MM-DD');
        $waktu = Carbon::parse($show->tgl)->isoFormat('HH:mm:ss');

        $data = [
            'id' => $id,
            'tgl' => $tgl,
            'waktu' => $waktu,
            'show' => $show,
        ];

        return response()->json($data, 200);
    }

    public function ubah(Request $request)
    {
        // print_r($request->all());
        // die();
        $tgl = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');

        $ubahFormatTgl = Carbon::parse($request->tgl_edit);

        $data = skl::find($request->id_edit);
        $data->no_surat = $request->no_surat_edit;
        $data->tgl = $ubahFormatTgl;
        $data->hari = $ubahFormatTgl->isoFormat('dddd');
        $data->nik_ibu = $request->nik_ibu_edit;
        $data->nik_ayah = $request->nik_ayah_edit;
        $data->ibu = 'NY. '.$request->ibu_edit;
        $data->ayah = 'TN. '.$request->ayah_edit;
        $data->anak = $request->anak_edit;
        $data->alamat = $request->alamat_edit;
        $data->kelamin = $request->kelamin_edit;
        $data->bb = $request->bb_edit;
        $data->tb = $request->tb_edit;
        $data->user = $request->user_edit;
        $data->dr = $request->dr_edit;

        $data->save();

        return response()->json($tgl, 200);
    }

    public function showAll()
    {
        return view('pages.pelayanan.kebidanan.skl.skl-all');
    }

    public function apiAll()
    {
        $show = skl::orderBy('no_surat', 'DESC')->get();

        $data = [
            'show' => $show,
        ];

        return response()->json($data, 200);
    }

    public function cetak($id)
    {
        $data = skl::where('id',$id)->first();

        // 1 = dr. Gede Sri Dhyana, Sp.OG
        // 2 = dr. H. Ahmad Sutamat, Sp.OG

        $tgl = Carbon::parse($data->tgl)->isoFormat('D MMMM Y');
        $thn = Carbon::parse($data->tgl)->isoFormat('Y');
        $jam = Carbon::parse($data->tgl)->toTimeString();

        if ($data->dr == 1) {
            $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(public_path().'/images/pku/kebidanan/skl-gede.docx');
        }elseif ($data->dr == 2) {
            $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(public_path().'/images/pku/kebidanan/skl-ahmad.docx');
        }elseif ($data->dr == 3) {
            $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(public_path().'/images/pku/kebidanan/skl-febrian.docx');
        }elseif ($data->dr == null) {
            return redirect('/pelayanan/kebidanan/skl')->with('message','Maaf, Input Dokter Belum Terisi');
        }

        $filename = "SKL ";
        // .$data->no_surat." - ".$data->ibu

        if ($data->kelamin == 'unknown') {
            $kelamin = '';
        } else {
            $kelamin = $data->kelamin.' ';
        }

        $templateProcessor->setValues([
            'no_surat' => $data->no_surat,
            'hari' => $data->hari,
            'tgl' => $tgl,
            'thn' => $thn,
            'jam' => $jam,
            'kelamin' => $kelamin,
            'nik_ibu' => $data->nik_ibu,
            'nik_ayah' => $data->nik_ayah,
            'ibu' => $data->ibu,
            'ayah' => $data->ayah,
            'alamat' => $data->alamat,
            'anak' => $data->anak,
            'bb' => $data->bb,
            'tb' => $data->tb,
        ]);

        header("Content-Disposition: attachment; filename=$filename.docx");

        $templateProcessor->saveAs('php://output');
    }

    public function print($id)
    {
        $show = skl::where('id',$id)->first();

        $tgl = Carbon::parse($show->tgl)->isoFormat('D MMMM Y');
        $thn = Carbon::parse($show->tgl)->isoFormat('Y');
        $jam = Carbon::parse($show->tgl)->toTimeString();

        $data = [
            'show' => $show,
            'tgl' => $tgl,
            'thn' => $thn,
            'jam' => $jam,
        ];

        // print_r($data);
        // die();
        return view('pages.pelayanan.kebidanan.skl.cetak-skl')->with('list', $data);
    }

    public function hapus($id)
    {
        $tgl = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');

        $show = skl::where('id',$id)->first();
        $show->delete();

        return response()->json($tgl, 200);
    }
}
