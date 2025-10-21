<?php

namespace App\Http\Controllers\Pengadaan;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use App\Models\users;
use App\Models\pengadaan;
use App\Models\pengadaan_keranjang;
use App\Models\pengadaan_barang;
use App\Models\pengadaan_detail;
use App\Models\pengadaan_ref;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;
use \PDF;

class PengadaanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $show = pengadaan::get();
        $ref = pengadaan_ref::get();

        $data = [
            'show' => $show,
            'ref' => $ref
        ];

        return view('pages.pengadaan.index')->with('list', $data);
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
        //
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
        //
    }

    // API
    function dataPengadaan($id)
    {
        $pengadaan = pengadaan::where('id_user', $id)->orderBy('tgl_pengadaan','desc')->get();
        // $detail_pengadaan = pengadaan::join('pengadaan_detail','pengadaan_detail.id_pengadaan','=','pengadaan.id_pengadaan')
        //                     ->where('id_user', $id)
        //                     ->select('pengadaan.id_user','pengadaan_detail.*')
        //                     ->get();

        $data = [
            'pengadaan' => $pengadaan,
            // 'detail_pengadaan' => $detail_pengadaan
        ];

        return response()->json($data, 200);
    }

    function riwayatPengadaan($id)
    {
        $pengadaan = pengadaan::join('users','users.id','=','pengadaan.id_user')
                                ->where('pengadaan.id_pengadaan', $id)
                                ->select('pengadaan.*','users.nama as nama_user')
                                ->first();
        $detail = pengadaan_detail::join('pengadaan_barang','pengadaan_barang.id','=','pengadaan_detail.id_barang')
                                ->where('pengadaan_detail.id_pengadaan', $id)
                                ->select('pengadaan_detail.*','pengadaan_barang.nama as nama_barang','pengadaan_barang.satuan','pengadaan_barang.harga')
                                ->get();

        $data = [
            'pengadaan' => $pengadaan,
            'detail' => $detail
        ];

        return response()->json($data, 200);
    }

    function hapusRiwayatPengadaan($id)
    {
        $tgl = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');

        pengadaan::where('id_pengadaan', $id)->delete();
        pengadaan_detail::where('id_pengadaan', $id)->delete();

        return response()->json($tgl, 200);
    }

    function tampilTambahKeranjang($id)
    {
        $barang = pengadaan_barang::where('id',$id)->first();

        return response()->json($barang, 200);
    }

    function tampilKeranjang($id)
    {
        $keranjang = pengadaan_keranjang::join('users','users.id','=','pengadaan_keranjang.id_user')
                                        ->join('pengadaan_barang','pengadaan_barang.id','=','pengadaan_keranjang.id_barang')
                                        ->where('pengadaan_keranjang.id_user', $id)
                                        ->select('pengadaan_keranjang.*','users.nama as nama_user','pengadaan_barang.nama as nama_barang','pengadaan_barang.satuan','pengadaan_barang.harga','pengadaan_barang.filename')
                                        ->orderBy('pengadaan_keranjang.updated_at','desc')
                                        ->get();

        $data = [
            'keranjang' => $keranjang,
        ];

        return response()->json($data, 200);
    }

    function tambahKeranjang(Request $request)
    {
        $tgl = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');

        $getBarang = pengadaan_barang::where('id',$request->id_barang)->first();

        $data = new pengadaan_keranjang;
        $data->id_user = $request->id_user;
        $data->id_barang = $request->id_barang;
        $data->jml_permintaan = $request->jml;
        $data->harga_barang = $getBarang->harga;
        $data->total_barang = $request->jml * $getBarang->harga;
        $data->ket = $request->ket;
        $data->save();

        return response()->json($tgl, 200);
    }

    function checkoutKeranjang(Request $request)
    {
        if (Carbon::now()->isoFormat('DD') > 20) {
            return response()->json([
                'success' => false,
                'message' => 'Pengadaan telah ditutup per Tanggal 20 '.Carbon::now()->isoFormat('MMM YYYY'),
            ], 400); // status code 400 Bad Request
        } else {

            $getRoles = users::Join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                                ->Join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                                ->select('roles.name')
                                ->where('users.id',$request->id_user)
                                ->get();

            foreach ($getRoles as $key => $value) {
                $unitArr[] = $value->name;
            }

            $tgl = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');

            $queue = pengadaan::orderBy('id_pengadaan','DESC')->first();

            if (empty($queue)) {
                $getQueue = 1;
            } else {
                $getQueue = $queue->id_pengadaan + 1;
            }

            pengadaan_keranjang::where('id_user',$request->id_user)->delete();

            for ($i=0; $i < $request->urutan; $i++) {
                $data = new pengadaan_detail;
                $data->id_pengadaan = $getQueue;
                $data->id_barang = $request->id_barang[$i];
                $data->jumlah = $request->id_jumlah[$i];
                // Get Data Barang
                $getBarang = pengadaan_barang::where('id',$request->id_barang[$i])->first();
                $data->harga = $getBarang->harga;
                $data->satuan = $getBarang->satuan;
                $data->total = $request->id_jumlah[$i] * $getBarang->harga;
                $data->ket = $request->id_ket[$i];
                $data->save();
            }

            $save = new pengadaan;
            $save->id_pengadaan = $getQueue;
            $save->id_user = $request->id_user;
            $save->unit = json_encode($unitArr);
            $save->total = $request->total;
            $save->tgl_pengadaan = Carbon::now();
            $save->save();

            return response()->json([
                'success' => true,
                'message' => 'Pengajuan Pengadaan telah berhasil dilakukan pada '.$tgl,
            ], 200); // status code 400 Bad Request

        }

    }

    function hapusKeranjang($id)
    {
        $tgl = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');

        $data = pengadaan_keranjang::find($id);
        $data->delete();

        return response()->json($tgl, 200);
    }

    function dataBarang()
    {
        $barang = pengadaan_barang::orderBy('nama','asc')->whereNull('deleted_at')->get();

        $data = [
            'barang' => $barang,
        ];

        return response()->json($data, 200);
    }

    function loadMore()
    {
        $barang = pengadaan_barang::orderBy('nama','asc')->paginate(40);

        // print_r($barang);
        // die();

        return response()->json($barang, 200);
		// return view('pages.pengadaan.index',compact('barang'));
    }

    // function acbarang(Request $request)
    // {
    //     $getData = pengadaan_barang::select("nama")
    //             ->where("nama","LIKE","%{$request->caribarang}%")
    //             ->groupBy ('nama')
    //             ->get();

    //     foreach ($getData as $item)
    //     {
    //         $data[] = $item->nama;
    //     }

    //     return response()->json($data);
    // }

    function getacbarang(Request $request)
    {
        $barang = pengadaan_barang::where("nama","LIKE","%{$request->barang}%")->orderBy('nama','asc')->paginate(12);

        // print_r($barang);
        // die();

        return response()->json($barang, 200);
		// return view('pages.pengadaan.index',compact('barang'));
    }
}
