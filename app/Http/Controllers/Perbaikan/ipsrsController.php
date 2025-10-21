<?php

namespace App\Http\Controllers\Perbaikan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use App\Models\perbaikan_ipsrs;
use App\Models\perbaikan_ipsrs_catatan;
use App\Models\role_has_permissions;
use App\Models\struktur_organisasi;
use App\Models\unit;
use App\Models\users;
use App\Models\users_foto;
// use App\Models\datalogs;
use Carbon\Carbon;
use Auth;
use Storage;
use Exception;
use Redirect;

class ipsrsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // datalogs::record(Auth::user(), 'Seseorang baru saja mengakses Halaman Perbaikan IPSRS', '', 'ini before', 'ini after', 'ini user target');
        $user = Auth::user();
        $user_id = $user->id;
        // if (Auth::user()->getManyRole(['ipsrs','it','sekretaris-direktur'])) {
        if (Auth::user()->getPermission('admin_perbaikan_ipsrs') == true) {
            // $show = perbaikan_ipsrs::where('tgl_selesai', null)->orderBy('tgl_pengaduan','DESC')->get();
            // $fotouser = users_foto::where('id',$user_id)->first();
            $total = perbaikan_ipsrs::count();
            $totalMasukPengaduan = perbaikan_ipsrs::whereNotNull('tgl_pengaduan')->where('tgl_diterima', null)->where('tgl_dikerjakan', null)->where('tgl_selesai', null)->where('ket_penolakan', null)->count();
            $totalDiverifikasi = perbaikan_ipsrs::whereNotNull('tgl_diterima')->where('tgl_dikerjakan', null)->where('tgl_selesai', null)->where('ket_penolakan', null)->count();
            $totalDikerjakan = perbaikan_ipsrs::whereNotNull('tgl_dikerjakan')->where('tgl_selesai', null)->where('ket_penolakan', null)->count();
            $totalSelesai = perbaikan_ipsrs::whereNotNull('tgl_selesai')->where('ket_penolakan', null)->count();
            $totalDitolak = perbaikan_ipsrs::whereNotNull('ket_penolakan')->count();
            $tahun = Carbon::now()->isoFormat('YYYY');

            $data = [
                // 'show' => $show,
                // 'fotouser' => $fotouser,
                'total' => $total,
                'totalmasukpengaduan' => $totalMasukPengaduan,
                'totaldiverifikasi' => $totalDiverifikasi,
                'totaldikerjakan' => $totalDikerjakan,
                'totalselesai' => $totalSelesai,
                'totalditolak' => $totalDitolak,
                'tahun' => $tahun
            ];

            return view('pages.perbaikan.ipsrs.index-admin')->with('list', $data);
        }else {
            // $show = perbaikan_ipsrs::where('user_id', $user_id)->get();
            $recent = perbaikan_ipsrs::where('user_id', $user_id)->where('tgl_selesai', null)->orderBy('tgl_pengaduan','DESC')->limit(10)->get();
            $total = perbaikan_ipsrs::where('user_id', $user_id)->count();
            $totalSelesai = perbaikan_ipsrs::where('user_id', $user_id)->where('tgl_selesai', '!=', null)->where('ket_penolakan', null)->count();
            $totalDitolak = perbaikan_ipsrs::where('user_id', $user_id)->where('ket_penolakan', '!=', null)->count();
            // $tambahketerangan = perbaikan_ipsrs_catatan::get();

            $data = [
                'recent' => $recent,
                'total' => $total,
                'totalselesai' => $totalSelesai,
                'totalditolak' => $totalDitolak,
            ];

            return view('pages.perbaikan.ipsrs.index-user')->with('list', $data);
        }
    }

    function tableUser($id)
    {
        $validation = struktur_organisasi::where('id_user',$id)->first();
        $show = perbaikan_ipsrs::join('users','users.id','=','perbaikan_ipsrs.user_id')
                ->Join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id');
                if ($validation) {
                    $show->whereIn('model_has_roles.role_id',json_decode($validation->bawahan));
                } else {
                    $show->where('perbaikan_ipsrs.user_id', $id);
                }
        $show = $show->select('perbaikan_ipsrs.*','users.nama as nama_pegawai')
                ->orderBy('perbaikan_ipsrs.tgl_pengaduan','DESC')
                ->get();

        $catatan = perbaikan_ipsrs_catatan::get();

        $data = [
            'show' => $show,
            'catatan' => $catatan,
        ];

        return response()->json($data);
    }

    function tableAdmin()
    {
        $show = perbaikan_ipsrs::where('tgl_selesai',null)->limit(100)->orderBy('tgl_pengaduan','DESC')->get();
        $catatan = perbaikan_ipsrs_catatan::get();

        $data = [
            'show' => $show,
            'catatan' => $catatan,
        ];

        return response()->json($data);
    }

    function tableAdminAll()
    {
        $show = perbaikan_ipsrs::orderBy('tgl_pengaduan','DESC')->get();
        $catatan = perbaikan_ipsrs_catatan::get();

        $data = [
            'show' => $show,
            'catatan' => $catatan,
        ];

        return response()->json($data);
    }

    function diagram($tahun)
    {
        // $show = [];
        for ($i=1; $i<=12 ; $i++) {
            $selesai[] = perbaikan_ipsrs::whereMonth('tgl_pengaduan',$i)->whereYear('tgl_pengaduan',$tahun)->where('ket_penolakan',"=",null)->count();
        }
        for ($i=1; $i<=12 ; $i++) {
            $ditolak[] = perbaikan_ipsrs::whereMonth('tgl_pengaduan',$i)->whereYear('tgl_pengaduan',$tahun)->where('ket_penolakan',"!=",null)->count();
        }

        $data = [
            'selesai' => $selesai,
            'ditolak' => $ditolak,
        ];

        return response()->json($data);
    }

    function lampiranAdmin($id)
    {
        $show = perbaikan_ipsrs::where('id',$id)->first();
        return response()->json($show);
    }

    function track($id)
    {
        $show = perbaikan_ipsrs::where('id', $id)->first();
        $catatan = perbaikan_ipsrs_catatan::where('pengaduan_id',$id)->get();

        $data = [
            'show' => $show,
            'catatan' => $catatan,
        ];

        return response()->json($data);
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
        // tampung berkas yang sudah diunggah ke variabel baru
        // 'file' merupakan nama input yang ada pada form
        $request->validate([
            'file' => ['image','mimes:jpg,png,jpeg,gif','max:50000'],
        ]);

        $uploadedFile = $request->file('file');

        // simpan berkas yang diunggah ke sub-direktori 'public/files'
        // direktori 'files' otomatis akan dibuat jika belum ada
        if ($uploadedFile == '') {
            $path = '';
            $title = '';
        }else {
            $path = $uploadedFile->store('public/files/ipsrs/pengaduan');
            $title = $uploadedFile->getClientOriginalName();
        }

        $getRoles = users::Join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->Join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->select('roles.name')
            ->where('users.id',$request->user_id)
            ->get();

        $getUser = users::where('id',$request->user_id)->first();

        foreach ($getRoles as $key => $value) {
            $unitArr[] = $value->name;
        }
        $now = Carbon::now();

        $data = new perbaikan_ipsrs;
        $data->nama = $getUser->nama;
        $data->unit = json_encode($unitArr);
        $data->lokasi = $request->lokasi;
        $data->tgl_pengaduan = $now;
        $data->ket_pengaduan = $request->pengaduan;

            $data->title_pengaduan = $title;
            $data->filename_pengaduan = $path;

        $data->user_id = $request->user_id;

        $data->save();

        return redirect()->route('ipsrs.index')->with('message','Tambah Laporan Pengaduan Berhasil oleh '.$getUser->nama);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = perbaikan_ipsrs::find($id);
        return Storage::download($data->filename_pengaduan, $data->title_pengaduan);
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
        $now = Carbon::now()->isoFormat('YYYY-MM-D');;

        $gettgl = perbaikan_ipsrs::where('id',$request->id)->first();
        $tgl = Carbon::parse($gettgl->tgl_pengaduan)->isoFormat('YYYY-MM-D');

        // print_r($gettgl->tgl_pengaduan);
        // die();
        if ($tgl == $now) {
            if (empty($gettgl->tgl_diterima)) {
                $data = perbaikan_ipsrs::find($id);
                $data->lokasi = $request->lokasi;
                $data->ket_pengaduan = $request->pengaduan;

                $data->save();

                return Redirect::back()->with('message','Ubah Laporan Pengaduan Berhasil');
            } else {
                return Redirect::back()->withErrors('Gagal mengubah Laporan, Laporan sudah diverifikasi oleh Unit IPSRS. Silakan Konfirmasi kembali ke Unit IPSRS');
            }
        } else {
            if (!empty($gettgl->tgl_selesai)) {
                return Redirect::back()->withErrors('Gagal mengubah Laporan, Laporan sudah diselesaikan');
            } else {
                return Redirect::back()->withErrors('Tanggal Ubah Laporan Tidak Valid. Pastikan anda mengubah laporan di hari yang sama');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $now = Carbon::now()->isoFormat('YYYY-MM-D');

        $gettgl = perbaikan_ipsrs::where('id',$id)->first();
        $tgl = Carbon::parse($gettgl->tgl_pengaduan)->isoFormat('YYYY-MM-D');

        if ($tgl == $now) {
            if (empty($gettgl->tgl_diterima)) {
                $data = perbaikan_ipsrs::find($id);
                $data->delete();

                return Redirect::back()->with('message','Hapus Laporan Pengaduan Berhasil');
            } else {
                return Redirect::back()->withErrors('Gagal menghapus Laporan, Laporan sudah diverifikasi oleh Unit IPSRS. Silakan Konfirmasi kembali ke Unit IPSRS');
            }
        } else {
            if (!empty($gettgl->tgl_selesai)) {
                return Redirect::back()->withErrors('Gagal menghapus Laporan, Laporan sudah diselesaikan');
            } else {
                return Redirect::back()->withErrors('Tanggal Hapus Laporan Tidak Valid. Pastikan anda menghapus laporan di hari yang sama');
            }
        }
    }

    // USER
    function getUbah($id)
    {
        $show = perbaikan_ipsrs::where('id', $id)->first();

        $data = [
            'show' => $show,
        ];

        return response()->json($data);
    }

    function prosesUbah(Request $request)
    {
        $tgl = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');

        $data = perbaikan_ipsrs::find($request->id);
        $data->lokasi = $request->lokasi;
        $data->ket_pengaduan = $request->pengaduan;
        $data->user_id = $request->user;
        $data->save();

        return response()->json($tgl);
    }

    function prosesHapus($id)
    {
        $tgl = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');

        // Inisialisasi
        $hapusData = perbaikan_ipsrs::find($id);
        if ($hapusData->filename != null && $hapusData->filename != '') {
            Storage::delete($hapusData->filename);
        }
        $hapusData->delete();

        return response()->json($tgl, 200);
    }

    public function detail($id)
    {
        $show = perbaikan_ipsrs::where('id',$id)->first();

        // $dikerjakan = DB::table('pengaduan_ipsrs_catatan')
        //         ->where('pengaduan_id',$id)
        //         ->get();

        $catatan = perbaikan_ipsrs_catatan::where('pengaduan_id',$id)->orderBy('created_at','ASC')->get();

        $data = [
            'show' => $show,
            'catatan' => $catatan
        ];
        // print_r($cari);
        // die();

        return view('pages.perbaikan.ipsrs.detail-admin')->with('list', $data);
        // return view('pages.new.laporan.ipsrs.detail-pengaduan')->with('list', $data);
    }

    public function verif(Request $request)
    {
        $now = Carbon::now();
        $nowpush = Carbon::now()->isoFormat('YYYY-MM-D');

        $data = perbaikan_ipsrs::find($request->id);
        $data->verifikator_id = $request->user_id;
        $data->tgl_diterima = $now;
        $data->ket_diterima = $request->ket;
        $data->save();

        return response()->json($nowpush);
    }

    public function unverif(Request $request)
    {
        $now = Carbon::now();

        $data = perbaikan_ipsrs::find($request->id);
        $data->verifikator_id = $request->user_id;
        $data->tgl_selesai = $now;
        $data->ket_penolakan = $request->ket;
        $data->save();

        $arr = [
            'name' => $name,
            'tolak' => $request->ket,
        ];

        return response()->json($arr);
    }

    public function process(Request $request)
    {
        $now = Carbon::now();
        $nowpush = Carbon::now()->isoFormat('YYYY-MM-D');

        $data = perbaikan_ipsrs::find($request->id);
        $data->tgl_dikerjakan = $now;
        $data->ket_dikerjakan = $request->ket_pengerjaan;
        if ($request->estimasi != null) {
            $data->estimasi = $request->estimasi;
        }
        $data->save();

        return response()->json($nowpush);
    }

    public function finish(Request $request)
    {
        $now = Carbon::now();

        $data = perbaikan_ipsrs::where('id',$request->id)->first();
        $data->tgl_selesai = $now;
        $data->ket_selesai = $request->ket_selesai;
        $data->save();

        $catatan = perbaikan_ipsrs_catatan::where('pengaduan_id',$request->id)->get();
        $dataNew = perbaikan_ipsrs::where('id',$request->id)->get();

        $arr = [
            'name' => $name,
            'show' => $dataNew,
            'catatan' => $catatan
        ];

        return response()->json($arr);
    }

    public function result($id)
    {
        $show = perbaikan_ipsrs::where('id',$id)->get();
        $catatan = perbaikan_ipsrs_catatan::where('pengaduan_id',$id)->get();

        $data = [
            'show' => $show,
            'catatan' => $catatan
        ];

        return response()->json($data);
    }

    public function downloadCatatan($id)
    {
        $data = perbaikan_ipsrs_catatan::where('id',$id)->first();
        return Storage::download($data->filename, $data->title);
    }

    public function catatan(Request $request)
    {
        // tampung berkas yang sudah diunggah ke variabel baru
        // 'file' merupakan nama input yang ada pada form
        $request->validate([
            'catatan' => ['image','mimes:jpg,png,jpeg,gif'],
        ]);

        $uploadedFile = $request->file('file');

        // simpan berkas yang diunggah ke sub-direktori 'public/files'
        // direktori 'files' otomatis akan dibuat jika belum ada
        if ($uploadedFile == '') {
            $path = '';
            $title = '';
        }else {
            $path = $uploadedFile->store('public/files/ipsrs/pengaduan/catatan');
            $title = $request->title ?? $uploadedFile->getClientOriginalName();
        }

        $data = new perbaikan_ipsrs_catatan;
        $data->pengaduan_id = $request->id_pengaduan;
        $data->keterangan = $request->ket_catatan;
        $data->title = $title;
        $data->filename = $path;
        $data->save();

        return Redirect::back()->with('message','Tambah Catatan Pengerjaan Laporan Berhasil');
    }

    public function ubahCatatan(Request $request)
    {
        // tampung berkas yang sudah diunggah ke variabel baru
        // 'file' merupakan nama input yang ada pada form
        $uploadedFile = $request->file('file');

        // simpan berkas yang diunggah ke sub-direktori 'public/files'
        // direktori 'files' otomatis akan dibuat jika belum ada
        $data = perbaikan_ipsrs_catatan::find($request->id_catatan);

        if ($uploadedFile != '') {
            $path = $uploadedFile->store('public/files/ipsrs/pengaduan/catatan');
            $title = $request->title ?? $uploadedFile->getClientOriginalName();
            $data->title = $title;
            $data->filename = $path;
        }

        $data->keterangan = $request->ket_catatan;
        $data->save();

        return Redirect::back()->with('message','Ubah Catatan Pengerjaan Laporan Berhasil');
    }

    public function autocompleteLokasi(Request $request)
    {
        $getData = perbaikan_ipsrs::select("lokasi")
                ->where("lokasi","LIKE","%{$request->lokasi}%")
                ->groupBy ('lokasi')
                ->get();

        foreach ($getData as $item)
        {
            $data[] = $item->lokasi;
        }

        return response()->json($data);
    }

    public function riwayat()
    {
        return view('pages.perbaikan.ipsrs.riwayat');
    }

    public function filter(Request $request)
    {
        $from = date(Carbon::parse(substr($request->filter,0,10))->isoFormat('YYYY-MM-DD'));
        $to = date(Carbon::parse(substr($request->filter,13,10))->isoFormat('YYYY-MM-DD'));

        $user = Auth::user();
        $user_id = $user->id;

        if (Auth::user()->hasRole(['ipsrs','it'])) {
            $data = DB::table('perbaikan_ipsrs')
                        // ->join('dokter', 'dokter.id', '=', 'antigen.dr_pengirim')
                        // ->select('antigen.*','dokter.nama as dr_nama')
                        ->orderBy('tgl_pengaduan','ASC')
                        ->where('deleted_at', null)
                        ->whereBetween('tgl_pengaduan', [$from, $to])
                        // ->whereMonth('antigen.tgl', $bulan)
                        // ->whereYear('antigen.tgl', $tahun)
                        ->get();
        } else {
            $data = DB::table('perbaikan_ipsrs')
                        // ->join('dokter', 'dokter.id', '=', 'antigen.dr_pengirim')
                        // ->select('antigen.*','dokter.nama as dr_nama')
                        ->orderBy('tgl_pengaduan','ASC')
                        ->where('user_id', $user_id)
                        ->where('deleted_at', null)
                        ->whereBetween('tgl_pengaduan', [$from, $to])
                        // ->whereMonth('antigen.tgl', $bulan)
                        // ->whereYear('antigen.tgl', $tahun)
                        ->get();
        }

        return response()->json($data, 200);
    }
}
