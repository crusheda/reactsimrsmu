<?php

namespace App\Http\Controllers\React\Akun;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\logs;
use App\Models\users;
use App\Models\users_foto;
use App\Models\users_status;
use App\Models\alamat;
use App\Models\model_has_roles;
use Carbon\Carbon;
use Auth, Storage, DB;

class ProfilController extends Controller
{
    function index()
    {
        $id_user = Auth::user()->id;
        $user = users::where('id',$id_user)->first();
        $foto_user = users_foto::where('user_id',$id_user)->first();
        $status_user = users_status::leftjoin('referensi','referensi.id','=','users_status.ref_id')
                                ->select('referensi.deskripsi AS nama_status')
                                ->where('users_status.pegawai_id',$id_user)
                                ->where('users_status.status',1)
                                ->whereNull('users_status.deleted_at')
                                ->where('referensi.status',1)
                                ->whereNull('referensi.deleted_at')
                                ->first();
        $log_user = logs::where('user_id', $id_user)->where('log_type', '=', 'login')->select('log_date')->orderBy('log_date', 'DESC')->first();
        $role = model_has_roles::join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                                ->select('model_has_roles.model_id as id_user','roles.name as nama_role')
                                ->where('model_has_roles.model_id', '=', $id_user)
                                ->get();
        $provinsi = alamat::select('provinsi')->groupBy('provinsi')->get();
        $kota = alamat::select('nama_kabkota')->groupBy('nama_kabkota')->get();

        $data = [
            'user' => $user,
            'foto_user' => $foto_user,
            'status_user' => $status_user,
            'log_user' => $log_user,
            'role' => $role,
            'provinsi' => $provinsi,
            'kota' => $kota,
        ];

        return Inertia::render('Akun/Profil', [
            'list' => $data
        ]);
    }

    function store(Request $request)
    {
        $user = Auth::user();
        $id = $user->id;
        $tgl = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');

        $data = users::find($id);
        if (!$data) {
            return response()->json(['message' => 'Data pengguna tidak ditemukan'], 404);
        }

        // ====== VALIDASI FILE UPLOAD ======
        $request->validate([
            'upload_sd' => 'nullable|file|mimes:pdf|max:5000',
            'upload_smp' => 'nullable|file|mimes:pdf|max:5000',
            'upload_sma' => 'nullable|file|mimes:pdf|max:5000',
            'upload_d2' => 'nullable|file|mimes:pdf|max:5000',
            'upload_d3' => 'nullable|file|mimes:pdf|max:5000',
            'upload_d4' => 'nullable|file|mimes:pdf|max:5000',
            'upload_s1' => 'nullable|file|mimes:pdf|max:5000',
            'upload_s1_profesi' => 'nullable|file|mimes:pdf|max:5000',
            'upload_s2' => 'nullable|file|mimes:pdf|max:5000',
            'upload_s3' => 'nullable|file|mimes:pdf|max:5000',
        ]);

        // ====== DATA UTAMA ======
        $data->nik = $request->nik;
        // $data->gelar_depan = $request->gelar_depan;
        $data->nama = $request->nama;
        // $data->gelar_belakang = $request->gelar_belakang;
        $data->nick = $request->nick;
        $data->temp_lahir = $request->temp_lahir;
        $data->tgl_lahir = $request->tgl_lahir;
        $data->jns_kelamin = $request->jns_kelamin;
        $data->status_kawin = $request->status_kawin;
        $data->email = $request->email;
        $data->no_hp = $request->no_hp;
        $data->fb = $request->fb;
        $data->ig = $request->ig;
        $data->tt = $request->tt;

        // ====== ALAMAT KTP ======
        $data->alamat_ktp = $request->alamat_ktp;
        $data->ktp_provinsi = $request->ktp_provinsi ?? $data->ktp_provinsi;
        $data->ktp_kabupaten = $request->ktp_kabupaten ?? $data->ktp_kabupaten;
        $data->ktp_kecamatan = $request->ktp_kecamatan ?? $data->ktp_kecamatan;
        $data->ktp_kelurahan = $request->ktp_kelurahan ?? $data->ktp_kelurahan;

        // ====== ALAMAT DOMISILI ======
        if ($request->cek_dom == '0') {
            $data->alamat_dom = null;
            $data->dom_provinsi = null;
            $data->dom_kabupaten = null;
            $data->dom_kecamatan = null;
            $data->dom_kelurahan = null;
        } else {
            $data->alamat_dom = $request->alamat_dom;
            $data->dom_provinsi = $request->dom_provinsi ?? $data->dom_provinsi;
            $data->dom_kabupaten = $request->dom_kabupaten ?? $data->dom_kabupaten;
            $data->dom_kecamatan = $request->dom_kecamatan ?? $data->dom_kecamatan;
            $data->dom_kelurahan = $request->dom_kelurahan ?? $data->dom_kelurahan;
        }

        // ====== PENDIDIKAN ======
        $data->sd = $request->sd;
        $data->smp = $request->smp;
        $data->sma = $request->sma;
        $data->d1 = $request->d1;
        $data->d2 = $request->d2;
        $data->d3 = $request->d3;
        $data->d4 = $request->d4;
        $data->s1 = $request->s1;
        $data->s1_profesi = $request->s1_profesi;
        $data->s2 = $request->s2;
        $data->s3 = $request->s3;

        $data->th_sd = $request->th_sd ?? $data->th_sd;
        $data->th_smp = $request->th_smp ?? $data->th_smp;
        $data->th_sma = $request->th_sma ?? $data->th_sma;
        $data->th_d1 = $request->th_d1 ?? $data->th_d1;
        $data->th_d2 = $request->th_d2 ?? $data->th_d2;
        $data->th_d3 = $request->th_d3 ?? $data->th_d3;
        $data->th_d4 = $request->th_d4 ?? $data->th_d4;
        $data->th_s1 = $request->th_s1 ?? $data->th_s1;
        $data->th_s1_profesi = $request->th_s1_profesi ?? $data->th_s1_profesi;
        $data->th_s2 = $request->th_s2 ?? $data->th_s2;
        $data->th_s3 = $request->th_s3 ?? $data->th_s3;

        // ====== FILE UPLOAD ======
        $uploadFields = [
            'sd', 'smp', 'sma', 'd2', 'd3', 'd4', 's1', 's1_profesi', 's2', 's3'
        ];

        foreach ($uploadFields as $field) {
            $uploadField = "upload_{$field}";
            if ($request->hasFile($uploadField)) {
                $file = $request->file($uploadField);
                if ($file->isValid()) {
                    // hapus file lama
                    if ($data->{"filename_{$field}"} && Storage::exists($data->{"filename_{$field}"})) {
                        Storage::delete($data->{"filename_{$field}"});
                    }
                    // simpan baru
                    $path = $file->store("public/files/profil/ijazah/{$id}");
                    $data->{"filename_{$field}"} = $path;
                }
            }
        }

        // ====== RIWAYAT ======
        $data->pengalaman_kerja = $request->pengalaman_kerja;
        $data->riwayat_penyakit = $request->riwayat_penyakit;
        $data->riwayat_penyakit_keluarga = $request->riwayat_penyakit_keluarga;
        $data->riwayat_operasi = $request->riwayat_operasi;
        $data->riwayat_penggunaan_obat = $request->riwayat_penggunaan_obat;

        $data->save();

        // ====== RESPONSE UNTUK INERTIA ======
        return back()->with('message', "Profil berhasil diperbarui pada {$tgl}");

        // return redirect()
        //     ->route('v4.profil.index')
        //     ->with('message', 'Profil berhasil diperbarui.');
    }

    public function ubahFoto(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpg,jpeg,png|max:3000',
        ]);

        $user = Auth::user();
        $now  = Carbon::now();

        // Simpan file
        $uploadedFile = $request->file('file');
        $path = $uploadedFile->store('public/files/foto_profil');
        $title = $uploadedFile->getClientOriginalName();

        // Ambil role user
        $role = $user->roles()->pluck('name')->toArray();

        // Simpan / update foto profil
        $data = users_foto::where('user_id', $user->id)->first();

        if ($data) {
            $data->name = $user->name;
            $data->unit = json_encode($role);
            $data->title = $title;
            $data->filename = $path;
            $data->updated_at = $now;
            $data->save();
        } else {
            $data = new users_foto;
            $data->user_id = $user->id;
            $data->name = $user->name;
            $data->unit = json_encode($role);
            $data->title = $title;
            $data->filename = $path;
            $data->updated_at = $now;
            $data->save();
        }

        return back()->with('message', 'Foto profil berhasil diperbarui.');
    }

    public function hapusFoto()
    {
        $user = Auth::user();
        $foto = users_foto::where('user_id', $user->id)->first();

        if ($foto) {
            // Hapus file dari storage
            if (Storage::exists($foto->filename)) {
                // Storage::delete($foto->filename);
            }
            // Hapus record
            $foto->delete();
        }

        return back()->with('message', 'Foto profil telah dikembalikan ke default.');
    }

    public function ubahPassword(Request $request)
    {
        $user = Auth::user();

        // ✅ Validasi input
        $validator = Validator::make($request->all(), [
            'current_password' => ['required'],
            'new_password' => [
                'required',
                'string',
                'min:8',
                'regex:/[A-Z]/',        // huruf besar
                'regex:/[a-z]/',        // huruf kecil
                'regex:/[0-9]/',        // angka
                'regex:/[@$!%*?&]/',    // karakter spesial
                'confirmed',            // pastikan sama dengan new_password_confirmation
            ],
        ], [
            'new_password.confirmed' => 'Konfirmasi password baru tidak sesuai.',
            'new_password.regex' => 'Password baru harus mengandung huruf besar, angka, dan karakter spesial.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // ✅ Cek password lama benar
        if (!Hash::check($request->get('current_password'), $user->password)) {
            return redirect()->back()->withErrors([
                'current_password' => 'Password lama tidak sesuai.',
            ]);
        }

        // ✅ Simpan password baru dengan hash
        $user->password = Hash::make($request->get('new_password'));
        $user->last_updated_password = Carbon::now();
        $user->save();

        return redirect()->route('v4.profil.index')
            ->with('message', 'Password berhasil diperbarui!');
    }

    public function apiProvinsi($id)
    {
        $data = DB::table('alamat')
                ->select('nama_kabkota')
                ->where('provinsi', $id)
                ->groupBy('nama_kabkota')
                ->get();

        return response()->json($data, 200);
    }

    public function apiKota($id)
    {
        $data = DB::table('alamat')
                ->select('kecamatan')
                ->where('nama_kabkota', $id)
                ->groupBy('kecamatan')
                ->get();

        return response()->json($data, 200);
    }

    public function apiKecamatan($id)
    {
        $data = DB::table('alamat')
                ->select('desa')
                ->where('kecamatan', $id)
                ->groupBy('desa')
                ->get();

        return response()->json($data, 200);
    }
}
