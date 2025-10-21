<?php

namespace App\Http\Controllers\Kepegawaian;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use App\Models\referensi;
use App\Models\datalogs;
use App\Models\users;
use App\Models\users_doc;
use App\Models\users_foto;
use App\Models\users_status;
use App\Models\users_rotasi;
use App\Models\users_spkrkk;
use App\Models\logs;
use App\Models\alamat;
use App\Models\model_has_roles;
use App\Models\roles;
use Carbon\Carbon;
use Auth;
use Storage;
use Exception;
use Redirect;

class DetailProfilKaryawanController extends Controller
{
    // FUNCTION TABLE
    function table() // Table PROFIL KARYAWAN JS
    {
        $show = users::where('status',null)->orderBy('updated_at','desc')->get();

        $data = [
            'show' => $show
        ];

        return response()->json($data, 200);
    }

    function tablePenetapan($id)
    {
        $show = users_status::withTrashed()
                ->join('referensi','referensi.id','=','users_status.ref_id')
                ->join('users','users.id','=','users_status.user_id')
                ->select('users.nama as nama_kepegawaian','referensi.deskripsi as nama_referensi','users_status.*')
                ->where('users_status.pegawai_id',$id)
                ->orderBy('users_status.updated_at','desc')
                ->get();

        $data = [
            'show' => $show
        ];

        return response()->json($data, 200);
    }

    function tableRotasi($id)
    {
        $show = users_rotasi::withTrashed()
                ->join('referensi','referensi.id','=','users_rotasi.ref_id')
                ->join('users','users.id','=','users_rotasi.user_id')
                ->select('users.nama as nama_kepegawaian','referensi.deskripsi as nama_referensi','users_rotasi.*')
                ->where('users_rotasi.pegawai_id',$id)
                ->orderBy('users_rotasi.updated_at','desc')
                ->get();
        $role = model_has_roles::join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                ->select('model_has_roles.role_id as id_role','roles.name as nama_role','roles.deskripsi as deskripsi_role')
                ->where('model_has_roles.model_id',$id)
                ->get();
        $onlyRole = roles::select('id as id_role','name as nama_role','deskripsi as deskripsi_role')->get();
        $model = model_has_roles::where('model_id', $id)->get();

        $data = [
            'show' => $show,
            'role' => $role,
            'onlyRole' => $onlyRole,
            'model' => $model,
        ];

        return response()->json($data, 200);
    }

    function tableDokumen($id)
    {
        $show = users_doc::join('referensi','referensi.id','=','users_doc.ref_id')
                ->join('users','users.id','=','users_doc.user_id')
                ->select('users.nama as nama_pegawai','referensi.deskripsi as nama_ref','referensi.color','users_doc.*')
                ->where('users_doc.user_id',$id)
                ->orderBy('users_doc.updated_at','desc')
                ->get();

        $data = [
            'show' => $show,
        ];

        return response()->json($data, 200);
    }

    function tableSpkRkk($id)
    {
        $show = users_spkrkk::withTrashed()
                ->join('users as u','u.id','=','users_spkrkk.pegawai_id')
                ->join('users as us','us.id','=','users_spkrkk.user_id')
                ->select('u.nama as nama_pegawai','us.nama as nama_kepegawaian','users_spkrkk.*')
                ->where('users_spkrkk.pegawai_id',$id)
                ->orderBy('users_spkrkk.updated_at','desc')
                ->get();

        $status = users_status::join('referensi','users_status.ref_id','=','referensi.id')->select('referensi.queue','users_status.*')->where('users_status.pegawai_id','=', $id)->where('users_status.status',1)->first();

        $data = [
            'show' => $show,
            'status' => $status,
        ];

        return response()->json($data, 200);
    }

    // FUNCTION TAMBAH
    function tambahPenetapan(Request $request)
    {
        $now = Carbon::now();
        $tgl = $now->isoFormat('dddd, D MMMM Y, HH:mm a');
        $bln = $now->isoFormat('MM');
        $thn = $now->isoFormat('YY');
        // $tgl_berlaku = $now->isoFormat('YYYY-MM-DD');
        $tgl_berlaku = $request->tgl_berlaku;

        // CEK DATA & SAVE LOG
        $cekData = referensi::find($request->ref_id);
        $cekPegawai = users::find($request->pegawai_id);

        // VALIDASI DATA
        $validasi = users_status::where('pegawai_id',$request->pegawai_id)->orderBy('created_at','desc')->first();
        if (!empty($validasi) || $validasi != '') {
            $validasi->status = 0;
            $validasi->save();
            // $validasi->update([
            //     'status'     => false,
            // ]);
        }
        if ($cekData->queue == 3) {
            $data = users::find($request->pegawai_id);
            if ($data->nip == null) {
                $maxNip = users::max('urutan_masuk');
                $masuk_kerja = Carbon::parse($thn.'-'.$bln.'-01')->isoFormat('YYYY-MM-DD');
                if ($maxNip) {
                    $urutan_masuk = sprintf('%03d',$maxNip+1);
                    $nip = $thn.'.'.$bln.'.'.$urutan_masuk;
                    // SAVE NEW NIP
                    $data->nip          = $nip;
                    $data->masuk_kerja  = $masuk_kerja;
                    $data->urutan_masuk = $urutan_masuk;
                    $data->save();
                } else {
                    $urutan_masuk = sprintf('%03d',1);
                    $nip = $thn.'.'.$bln.'.'.$urutan_masuk;
                    // SAVE NEW NIP
                    $data->nip          = $nip;
                    $data->masuk_kerja  = $masuk_kerja;
                    $data->urutan_masuk = $urutan_masuk;
                    $data->save();
                }
            }
        }

        // SAVING DATA
        $data = new users_status;
        $data->ref_id = $request->ref_id;
        $data->user_id = $request->user_id;
        $data->pegawai_id = $request->pegawai_id;
        $data->tgl_berlaku = $tgl_berlaku;
        $data->keterangan = $request->ket;
        $data->status = true;
        $data->save();

        datalogs::record($request->user_id, 'Baru saja melakukan penambahan Status Pegawai '.$cekPegawai->nama.' menjadi '.$cekData->deskripsi, 'Berlaku mulai tanggal '.$tgl_berlaku, null, $data, '["kepala-sumber-daya-insani","staf-sumber-daya-insani"]');

        return response()->json($tgl, 200);
    }

    function tambahRotasi(Request $request)
    {
        $now = Carbon::now();
        $tgl = $now->isoFormat('dddd, D MMMM Y, HH:mm a');
        $tgl_berlaku = $now->isoFormat('YYYY-MM-DD');

        // VALIDASI DATA
        $validasi = users_rotasi::where('pegawai_id',$request->pegawai_id)->orderBy('created_at','desc')->first();
        if (!empty($validasi) || $validasi != '') {
            $validasi->status = 0;
            $validasi->save();
        }

        // CHECKING DATA
        $getRoleBefore = model_has_roles::select('role_id')
            ->where('model_id',$request->pegawai_id)
            ->get();
        foreach ($getRoleBefore as $key => $value) {
            $roleBefore[] = `"`.$value->role_id.`"`;
        }

        // SAVING DATA ROTASI
        $data = new users_rotasi;
        $data->ref_id = $request->ref_id;
        $data->user_id = $request->user_id;
        $data->pegawai_id = $request->pegawai_id;
        $data->before = json_encode($roleBefore); // ["106","109"]
        $data->after = $request->jabatan; // ["105","106","109"]
        $data->keterangan = $request->ket;
        $data->tgl_berlaku = $request->tgl_berlaku;
        $data->status = true;
        $data->save();

        // SAVING DATA MODEL AS ROLES
        model_has_roles::where('model_id', $request->pegawai_id)->delete();
        foreach (json_decode($request->jabatan) as $key => $value) {
            $model = new model_has_roles;
            $model->role_id = $value;
            $model->model_type = 'App\User';
            $model->model_id = $request->pegawai_id;
            $model->save();
        }

        // CEK DATA & SAVE LOG
        $cekData = referensi::find($request->ref_id);
        $cekPegawai = users::find($request->pegawai_id);
        datalogs::record($request->user_id, 'Baru saja melakukan '.$cekData->deskripsi.' pada Rotasi Jabatan Pegawai '.$cekPegawai->nama, 'Berlaku mulai tanggal '.$tgl_berlaku, json_encode($roleBefore), $request->jabatan, '["kepala-sumber-daya-insani","staf-sumber-daya-insani"]');

        return response()->json($tgl, 200);
    }

    function tambahSpkRkk(Request $request)
    {
        $now = Carbon::now();
        $tgl = $now->isoFormat('dddd, D MMMM Y, HH:mm a');
        // VALIDASI DATA
        $request->validate([
            'file' => ['max:3000'], // 'mimes:jpeg,jpg,png'
        ]);
        $validasi = users_spkrkk::where('pegawai_id',$request->pegawai_id)->where('jns_dokumen',$request->jns_dokumen)->orderBy('created_at','desc')->first();
        if (!empty($validasi) || $validasi != '') {
            $validasi->status = 0;
            $validasi->save();
        }
        $getStatusPegawai = users_status::where('pegawai_id',$request->pegawai_id)->where('status',1)->first();

        // SAVING DATA
        $data = new users_spkrkk;
        $data->user_id = $request->user_id;
        $data->pegawai_id = $request->pegawai_id;
        if (!empty($getStatusPegawai) || $getStatusPegawai != '') {
            $data->pegawai_status = $getStatusPegawai->ref_id;
        } else {
            $data->pegawai_status = null;
        }
        $data->tgl_berakhir = $request->tgl_berakhir;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = $file->store('public/files/kepegawaian/spkrkk/'.$request->pegawai_id);
            $title = $file->getClientOriginalName();
            $data->filename = json_encode($filename);
            $data->title = json_encode($title);
        }
        $data->jns_dokumen = $request->jns_dokumen;
        $data->deskripsi = $request->deskripsi;
        $data->status = true;
        $data->save();

        // CEK DATA & SAVE LOG
        $cekPegawai = users::find($request->pegawai_id);
        if ($request->jns_dokumen == 0) {
            $jns = 'SPK & RKK';
        } else {
            $jns = 'Dokumen';
        }
        $berakhir = null;
        if (!empty($request->tgl_berakhir) || $request->tgl_berakhir != '') {
            $berakhir = 'Berakhir pada tanggal '.$request->tgl_berakhir;
        }

        datalogs::record($request->user_id, 'Baru saja melakukan penambahan '.$jns.' pada Data Pegawai '.$cekPegawai->nama, $berakhir, null, $data, '["kepala-sumber-daya-insani","staf-sumber-daya-insani"]');

        return response()->json($tgl, 200);
    }

    // FUNCTION KEPEGAWAIAN
    function showKepegawaian($id)
    {
        $maxNip = sprintf('%03d',users::max('urutan_masuk'));
        $maxNipThl = sprintf('%03d',users::where('nip','LIKE','THL%')->max('urutan_masuk'));
        $show = users::where('id', $id)->first();
        $ref_klasifikasi = referensi::where('ref_jenis',11)->get(); // 11 is Jenis Klasifikasi Pegawai
        $ref_subprofesi = referensi::where('ref_jenis',14)->get(); // 14 is Jenis Profesi / Sub Klasifikasi Pegawai

        $data = [
            'show' => $show,
            'maxNip' => $maxNip,
            'maxNipThl' => $maxNipThl,
            'ref_klasifikasi' => $ref_klasifikasi,
            'ref_subprofesi' => $ref_subprofesi,
        ];

        return response()->json($data, 200);
    }

    function tambahNIP(Request $request)
    {
        $now = Carbon::now()->isoFormat('YYYY-MM-DD HH:mm:ss');

        if ($request->nip) {
            if (substr($request->nip,0,3) == 'THL') {
                $data = users::find($request->pegawai_id);
                $data->nip          = $request->nip;
                $data->masuk_kerja  = null;
                $data->urutan_masuk = substr($request->nip,6,5);
                $data->save();

                // CEK DATA & SAVE LOG
                datalogs::record($request->user_id, 'Baru saja melakukan perubahan NIP Pegawai THL (ID:'.$request->pegawai_id.') menjadi '.$request->nip, $request->nip, null, $data, '["kepala-sumber-daya-insani","staf-sumber-daya-insani"]');
            } else {
                if (ctype_digit(substr($request->nip, 0, 2))) {
                    $getBulan = substr($request->nip,3,2);
                    $getTahun = substr($request->nip,0,2);
                    $urutan_masuk = substr($request->nip,6,5);
                    // $getBulan = substr("19.12.314",3,2);
                    // $getTahun = substr("19.12.314",0,2);
                    // $urutan_masuk = substr("19.12.314",6,5);
                    $masuk_kerja = Carbon::parse($getTahun.'-'.$getBulan.'-01')->isoFormat('YYYY-MM-DD');

                    $data = users::find($request->pegawai_id);
                    $data->nip          = $getTahun.'.'.$getBulan.'.'.sprintf('%03d',$urutan_masuk);;
                    $data->masuk_kerja  = $masuk_kerja;
                    $data->urutan_masuk = $urutan_masuk;
                    $data->save();

                    // CEK DATA & SAVE LOG
                    datalogs::record($request->user_id, 'Baru saja melakukan perubahan NIP Pegawai (ID:'.$request->pegawai_id.') menjadi '.$request->nip, $request->nip, null, $data, '["kepala-sumber-daya-insani","staf-sumber-daya-insani"]');
                } else {
                    return response()->json(['error' => 'Format NIP tidak sesuai. Silahkan gunakan format yang benar sesuai dengan aturan yang sudah tertera!'], 422);
                }
            }
        } else {
            $data = users::find($request->pegawai_id);
            $old = $data;
            $data->nip          = null;
            $data->masuk_kerja  = null;
            $data->urutan_masuk = null;
            $data->save();
            datalogs::record($request->user_id, 'Baru saja melakukan penghapusan NIP Pegawai (ID:'.$old->nama?$old->nama:$old->name.')',$old, null, $data, '["kepala-sumber-daya-insani","staf-sumber-daya-insani"]');
        }

        return response()->json($now, 200);
    }

    function tambahKlasifikasi(Request $request)
    {
        $now = Carbon::now()->isoFormat('YYYY-MM-DD HH:mm:ss');

        $data = users::find($request->pegawai_id);
        $data->ref_profesi   = $request->ref_profesi;
        $data->save();

        // CEK DATA & SAVE LOG
        $cekData = referensi::find($request->ref_profesi); // 11 is Jenis Klasifikasi Pegawai
        datalogs::record($request->user_id, 'Baru saja melakukan perubahan Klasifikasi Pegawai menjadi '.$cekData->deskripsi, $request->ref_profesi, null, $data, '["kepala-sumber-daya-insani","staf-sumber-daya-insani"]');

        return response()->json($now, 200);
    }

    function tambahProfesi(Request $request)
    {
        $now = Carbon::now()->isoFormat('YYYY-MM-DD HH:mm:ss');

        $data = users::find($request->pegawai_id);
        $data->ref_subprofesi = $request->ref_subprofesi;
        $data->save();

        // CEK DATA & SAVE LOG
        $cekData = referensi::find($request->ref_subprofesi); // 11 is Jenis Klasifikasi Pegawai
        datalogs::record($request->user_id, 'Baru saja melakukan perubahan Profesi / Sub Klasifikasi Pegawai menjadi '.$cekData->deskripsi, $request->ref_profesi, null, $data, '["kepala-sumber-daya-insani","staf-sumber-daya-insani"]');

        return response()->json($now, 200);
    }

    function tambahTattmt(Request $request)
    {
        $now = Carbon::now()->isoFormat('YYYY-MM-DD HH:mm:ss');
        $data = users::find($request->pegawai_id);
        $data->tmt   = $request->tmt;
        if ($request->tat || $request->tat != '') {
            $tat = $request->tat;
            $data->tat   = $request->tat;
        } else {
            $tat = '*';
            $data->tat = null;
        }
        $data->save();

        // CEK DATA & SAVE LOG
        datalogs::record($request->user_id, 'Baru saja melakukan perubahan TMT ('.$request->tmt.') & TAT ('.$tat.') Pegawai', null, null, $data, '["kepala-sumber-daya-insani","staf-sumber-daya-insani"]');

        return response()->json($now, 200);
    }

    // FUNCTION SHOW UBAH
    function showUbahPenetapan($id)
    {
        $show = users_status::where('id', $id)->first();
        $ref_penetapan = referensi::where('ref_jenis',10)->orderBy('queue','ASC')->get(); // 10 is Jenis Penetapan Pegawai

        $data = [
            'show' => $show,
            'ref_penetapan' => $ref_penetapan,
        ];

        return response()->json($data, 200);
    }

    function showUbahRotasi($id)
    {
        $show = users_rotasi::where('id', $id)->first();
        $ref_rotasi = referensi::where('ref_jenis',9)->get(); // 10 is Jenis Rotasi Pegawai

        $data = [
            'show' => $show,
            'ref_rotasi' => $ref_rotasi,
        ];

        return response()->json($data, 200);
    }

    function showUbahSpkRkk($id)
    {
        $show = users_spkrkk::where('id', $id)->first();

        $data = [
            'show' => $show,
        ];

        return response()->json($data, 200);
    }

    // FUNCTION UBAH
    function ubahPenetapan(Request $request)
    {
        $now = Carbon::now()->isoFormat('YYYY-MM-DD HH:mm:ss');

        $data = users_status::find($request->id);
        $pushData = $data;
        $pushPegawai = users::where('id',$data->pegawai_id)->first();
        $data->ref_id       = $request->ref_id;
        $data->tgl_berlaku  = $request->tgl_berlaku;
        $data->user_id      = $request->user_id;
        $data->keterangan   = $request->keterangan;
        $data->save();

        // CEK DATA & SAVE LOG
        $cekData = referensi::find($request->ref_id);
        datalogs::record($request->user_id, 'Baru saja melakukan perubahan Status Pegawai '.$pushPegawai->nama.' menjadi '.$cekData->deskripsi.' pada record ID : '.$request->id, $request->keterangan, $pushData, $data, '["kepala-sumber-daya-insani","staf-sumber-daya-insani"]');

        return response()->json($now, 200);
    }

    function ubahSpkRkk(Request $request)
    {
        $now = Carbon::now()->isoFormat('YYYY-MM-DD HH:mm:ss');

        $data = users_spkrkk::find($request->id);
        $pushData = $data;
        $pushPegawai = users::where('id',$data->pegawai_id)->first();
        if ($request->pegawai_status) {
            $data->pegawai_status   = $request->pegawai_status;
        }
        $data->tgl_berakhir   = $request->tgl_berakhir;
        $data->jns_dokumen    = $request->jns_dokumen;
        $data->user_id        = $request->user_id;
        $data->deskripsi      = $request->deskripsi;
        $data->save();

        // CEK DATA & SAVE LOG
        $cekData = referensi::find($request->ref_id);
        datalogs::record($request->user_id, 'Baru saja melakukan perubahan Dokumen SPK RKK Pegawai : '.$pushPegawai->nama.' pada record ID : '.$request->id, null, $pushData, $data, '["kepala-sumber-daya-insani","staf-sumber-daya-insani"]');

        return response()->json($now, 200);
    }

    // FUNCTION HAPUS
    function hapusPenetapan($id)
    {
        $tgl = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');

        // Inisialisasi
        $data = users_status::find($id);
        $pushData = $data;
        $pushPegawai = users::where('id',$data->pegawai_id)->first();

        // Validasi Pengambilan Record Lama
        $cek = users_status::where('pegawai_id',$data->pegawai_id)
                ->where('status',false)
                ->orderBy('created_at','desc')
                ->first();
        if (!empty($cek) || $cek != '') {
            $cek->status = 1;
            $cek->save();
        }

        // Proses Hapus Data dari DB
        $data->status = 0;
        $data->save();
        $data->delete();

        // CEK DATA & SAVE LOG
        $cekData = referensi::find($data->ref_id);
        datalogs::record($data->user_id, 'Baru saja melakukan penghapusan Status Pegawai : '.$pushPegawai->nama, null, $pushData, $data, '["kepala-sumber-daya-insani","staf-sumber-daya-insani"]');

        return response()->json($tgl, 200);
    }

    function hapusRotasi($id)
    {
        $tgl = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');

        // Inisialisasi
        $data = users_rotasi::find($id);
        $pushData = $data;
        $pushPegawai = users::where('id',$data->pegawai_id)->first();

        // SAVING DATA MODEL AS ROLES
        model_has_roles::where('model_id', $data->pegawai_id)->delete();
        foreach (json_decode($data->before) as $key => $value) {
            $model = new model_has_roles;
            $model->role_id = $value;
            $model->model_type = 'App\User';
            $model->model_id = $data->pegawai_id;
            $model->save();
        }

        // Aktifkan Data sebelumnya
        $cek = users_rotasi::where('pegawai_id',$data->pegawai_id)
                ->where('status',false)
                ->where('deleted_at',null)
                ->orderBy('created_at','desc')
                ->first();
        if (!empty($cek) || $cek != '') {
            $cek->status = 1;
            $cek->save();
        }

        // Proses Hapus Data dari DB
        $data->status = 0;
        $data->save();
        $data->delete();

        // CEK DATA & SAVE LOG
        $cekData = referensi::find($data->ref_id);
        datalogs::record($data->user_id, 'Baru saja melakukan penghapusan Rotasi Jabatan Pegawai : '.$pushPegawai->nama, null, $pushData, $data, '["kepala-sumber-daya-insani","staf-sumber-daya-insani"]');

        return response()->json($tgl, 200);
    }

    function hapusSpkRkk($id)
    {
        $tgl = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');

        // Inisialisasi
        $data = users_spkrkk::find($id);
        $pushData = $data;
        $pushPegawai = users::where('id',$data->pegawai_id)->first();

        if ($data->jns_dokumen == 0) {
            $jns = 'SPK';
        } else {
            $jns = 'RKK';
        }

        // Proses Hapus Data dari DB
        $data->status = 0;
        $data->save();
        Storage::delete(json_decode($data->filename));
        $data->delete();

        // CEK DATA & SAVE LOG
        $cekData = referensi::find($data->ref_id);
        datalogs::record($data->user_id, 'Baru saja melakukan penghapusan '.$jns.' Pegawai : '.$pushPegawai->nama, null, $pushData, $data, '["kepala-sumber-daya-insani","staf-sumber-daya-insani"]');

        return response()->json($tgl, 200);
    }

    function downloadDokumen($id)
    {
        $data = users_doc::find($id);
        return Storage::download($data->filename, $data->title);
    }

    function downloadSpkRkk($id)
    {
        $data = users_spkrkk::find($id);
        return Storage::download(json_decode($data->filename), json_decode($data->title));
    }
}
