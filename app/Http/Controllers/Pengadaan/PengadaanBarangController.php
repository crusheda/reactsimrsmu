<?php

namespace App\Http\Controllers\Pengadaan;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use App\Models\users;
use App\Models\pengadaan;
use App\Models\pengadaan_barang;
use App\Models\pengadaan_detail;
use App\Models\pengadaan_ref;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;
use Validator,Redirect,Response,File,Storage;

class PengadaanBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->getPermission('admin_pengadaan') == true) {
            $show = pengadaan_barang::get();
            $ref = pengadaan_ref::get();

            $data = [
                'show' => $show,
                'ref' => $ref
            ];

            return view('pages.pengadaan.barang.index')->with('list', $data);
        } else {
            return redirect()->back()->withErrors(['msg' => 'Mohon maaf, Anda tidak memiliki akses untuk membuka Master Barang!']);
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
        $data = pengadaan_barang::find($id);
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
        //
    }

    // API / AJAX
    public function acBarang(Request $request)
    {
        $getData = pengadaan_barang::select("nama")
                ->where("nama","LIKE","%{$request->nama}%")
                ->groupBy ('nama')
                ->get();

        foreach ($getData as $item)
        {
            $data[] = $item->nama;
        }

        return response()->json($data);
    }

    function table(){
        $data = pengadaan_barang::join('pengadaan_ref','pengadaan_ref.id','=','pengadaan_barang.ref_barang')
                    ->join('users','users.id','=','pengadaan_barang.id_user')
                    ->select('users.nama as nama_user','pengadaan_ref.nama as nama_ref','pengadaan_barang.*')
                    ->get();

        return response()->json($data);
    }

    function download($id)
    {
        $data = pengadaan_barang::find($id);
        return Storage::download($data->filename, $data->title);
    }

    function tambah(Request $request)
    {
        $tgl = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');

        $request->validate([
            'kategori' => ['required'],
            'barang' => ['required'],
            'satuan' => ['required'],
            'harga' => ['required'],
            'harga' => ['required'],
            'file.*' => ['mimes:jpg,png,jpeg','mimetypes:image/jpeg,image/png','max:2000'], // required
        ]);

        $getBarang = pengadaan_barang::where('nama',$request->barang)->first();
        $uploadedFile = $request->file('file');

        if (empty($getBarang)) {
            $data = new pengadaan_barang;
            $data->id_user = $request->user;
            $data->ref_barang = $request->kategori;
            $data->nama = $request->barang;
            $data->satuan = $request->satuan;
            $data->harga = str_replace('.','',str_replace('Rp. ','',$request->harga));
            if ($uploadedFile != '') {
                $path = $uploadedFile->store('public/files/pengadaan/barang');
                $title = $request->title ?? $uploadedFile->getClientOriginalName();
                $data->title = $title;
                $data->filename = $path;
            }
            $data->save();

            return Response::json(array(
                'message' => $tgl,
                'code' => 200,
            ));
        } else {
            return Response::json(array(
                'message' => 'Barang sudah ada/pernah ditambahkan sebelumnya, mohon periksa kembali!',
                'code' => 500,
            ));
        }
    }

    function ubah($id)
    {
        $show = pengadaan_barang::join('pengadaan_ref','pengadaan_ref.id','=','pengadaan_barang.ref_barang')
                    ->join('users','users.id','=','pengadaan_barang.id_user')
                    ->select('users.nama as nama_user','pengadaan_ref.nama as nama_ref','pengadaan_barang.*')
                    ->where('pengadaan_barang.id',$id)
                    ->first();
        $ref = pengadaan_ref::get();
        $total = pengadaan_detail::where('id_barang',$id)->select(\DB::raw('sum(jumlah) as total'))->get();
        // foreach ($total as $key => $value) {
        //     $count[] = $value->name;
        // }
        $data = [
            'show' => $show,
            'ref' => $ref,
            'total' => $total
        ];
        // print_r($data);
        // die();

        return response()->json($data, 200);
    }

    function prosesUbah(Request $request)
    {
        $tgl = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');

        $request->validate([
            'kategori' => ['required'],
            'barang' => ['required'],
            'satuan' => ['required'],
            'harga' => ['required'],
            'harga' => ['required'],
            'file.*' => ['mimes:jpg,png,jpeg','mimetypes:image/jpeg,image/png','max:2000'], // required
        ]);

        $getBarang = pengadaan_barang::where('nama',$request->barang)->count();
        $uploadedFile = $request->file('file');

        if ($getBarang <= 1) {
            $data = pengadaan_barang::find($request->id);
            $data->id_user = $request->user;
            $data->ref_barang = $request->kategori;
            $data->nama = $request->barang;
            $data->satuan = $request->satuan;
            $data->harga = str_replace('.','',str_replace('Rp. ','',$request->harga));
            if ($uploadedFile != '') {
                $path = $uploadedFile->store('public/files/pengadaan/barang');
                $title = $request->title ?? $uploadedFile->getClientOriginalName();
                $data->title = $title;
                $data->filename = $path;
            }
            $data->save();

            return Response::json(array(
                'message' => $tgl,
                'code' => 200,
            ));
        } else {
            return Response::json(array(
                'message' => 'Barang/Nama Barang sudah ada/pernah ditambahkan sebelumnya, mohon periksa kembali!',
                'code' => 500,
            ));
        }
    }

    function hapus($id)
    {
        $tgl = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');

        $data = pengadaan_barang::find($id);
        if ($data->filename != null) {
            Storage::delete($data->filename);
        }
        $data->delete();

        return response()->json($tgl, 200);
    }
}
