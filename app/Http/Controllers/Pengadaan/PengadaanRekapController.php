<?php

namespace App\Http\Controllers\pengadaan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\users;
use App\Models\pengadaan;
use App\Models\pengadaan_keranjang;
use App\Models\pengadaan_barang;
use App\Models\pengadaan_detail;
use App\Models\pengadaan_ref;
use Carbon\Carbon;
use Auth, DB;

class PengadaanRekapController extends Controller
{
    function index(Request $request)
    {
        if (Auth::user()->getPermission('admin_pengadaan') == true) {

            if ($request->kategori == 1) {
                $nama_kategori = 'ATK';
            } else {
                if ($request->kategori == 2) {
                    $nama_kategori = 'Cetak';
                } else {
                    $nama_kategori = 'BHP';
                }
            }
            $ref = pengadaan_ref::get();


            $data = [
                'bln' => $request->bulan,
                'thn' => $request->tahun,
                'nama_kategori' => $nama_kategori,
                'kategori' => $request->kategori,
                'ref' => $ref
            ];

            return view('pages.pengadaan.rekap')->with('list', $data);
        } else {
            return redirect()->back();
        }
    }

    function table($bln, $thn, $kategori)
    {
        $data = DB::table('pengadaan_detail as d')
            ->join('pengadaan as p', function($join) {
                $join->on('d.id_pengadaan', '=', 'p.id_pengadaan')
                    ->whereNull('p.deleted_at');
            })
            ->join('pengadaan_barang as b', function($join) {
                $join->on('d.id_barang', '=', 'b.id');
                    // ->whereNull('b.deleted_at');
            })
            ->where('b.ref_barang', '=', $kategori)
            ->whereMonth('p.tgl_pengadaan', (int) $bln)
            ->whereYear('p.tgl_pengadaan', $thn)
            ->select(
                'b.id as barang_id',
                'b.nama as barang_nama',
                'p.id_pengadaan',
                'p.unit as unit_json',
                'p.tgl_pengadaan',
                'd.jumlah',
                'd.total',
                'd.ket as keterangan'
            )
            ->whereNull('d.deleted_at')
            ->orderBy('p.tgl_pengadaan')
            ->get();

        $grouped = [];
        $allUnits = [];

        foreach ($data as $row) {
            $unitsArray = json_decode($row->unit_json, true) ?? [];
            $unit_nama = implode(', ', $unitsArray);
            // $tgl_pengadaan = Carbon::parse($row->tgl_pengadaan)->format('j M');
            $tgl_pengadaan = $row->tgl_pengadaan;

            $unitKey = $unit_nama . '|' . $tgl_pengadaan;

            // Pastikan hanya jika ada barang_id (berarti ada detail)
            if ($row->barang_id) {
                $grouped[$row->barang_id]['id'] = $row->barang_id;
                $grouped[$row->barang_id]['nama'] = $row->barang_nama;
                $grouped[$row->barang_id]['units'][$unitKey] = [
                    'jumlah' => $row->jumlah,
                    'total' => $row->total,
                    'keterangan' => $row->keterangan,
                    'tgl_pengadaan' => $tgl_pengadaan
                ];
            }

            // Tetap masukkan ke allUnits meskipun detailnya kosong
            if (!isset($allUnits[$unitKey])) {
                $allUnits[$unitKey] = [
                    'unit' => $unit_nama,
                    'tgl_pengadaan' => $tgl_pengadaan
                ];
            }
        }

        return response()->json([
            'data' => array_values($grouped),
            'units' => array_values($allUnits)
        ]);
    }
}
