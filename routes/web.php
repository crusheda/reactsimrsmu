<?php

// use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// DAFTAR CONTROLLER REACT
use App\Http\Controllers\Dashboard\DefaultController;
use App\Http\Controllers\React\Publik\DashboardController;
use App\Http\Controllers\React\Publik\FeedbackController;
use App\Http\Controllers\React\Akun\ProfilController;
use App\Http\Controllers\React\SDI\PegawaiController;
// use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Services\WhatsappService;

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

// ---------------------------------------------- SIMRSMU V.4 ROUTES ---------------------------------------------- //
Route::get('v4/', function () { return redirect()->route('v4.dashboard'); });

Route::group(['middleware' => ['auth'], 'prefix' => 'v4', 'as' => ''], function () {

    // AKUN
    Route::get('profil', [ProfilController::class, 'index'])->name('v4.profil.index');
    Route::post('profil/store', [ProfilController::class, 'store'])->name('v4.profil.store');
    Route::post('profil/ubahfoto', [ProfilController::class, 'ubahFoto'])->name('v4.profil.ubahFoto');
    Route::delete('profil/hapusfoto', [ProfilController::class, 'hapusFoto'])->name('v4.profil.hapusFoto');
    Route::patch('profil/ubahpassword', [ProfilController::class, 'ubahPassword'])->name('v4.profil.ubahPassword');
    Route::get('profil/dokumen/download/{id}', [ProfilController::class, 'downloadDokumen'])->name('v4.profil.downloadDokumen');

    // PUBLIK
    Route::get('dashboard', [DashboardController::class, 'index'])->name('v4.dashboard');
    Route::get('feedback', [FeedbackController::class, 'index'])->name('v4.feedback');

    // SDI
    Route::get('sdi/pegawai', [PegawaiController::class, 'index'])->name('v4.sdi.pegawai.index');

    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});






















// ---------------------------------------------- SIMRSMU V.3.1 ROUTES ---------------------------------------------- //
Auth::routes(['register' => false]);
Route::get('v3/', function () { return redirect()->route('v3.dashboard'); });

Route::get('/', function () {
    return view('pages.index');
})->name('portal');

Route::get('v3/masuk', [App\Http\Controllers\LoginController::class, 'index'])->name('v3.login');
Route::get('v3/lupapassword', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('v3.lupapassword.get');
Route::post('v3/lupapassword', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('v3.lupapassword.post');
Route::get('v3/resetpassword/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('v3.resetpassword.get');
Route::post('v3/resetpassword', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('v3.resetpassword.post');

Route::group(['middleware' => ['auth'], 'prefix' => 'v3', 'as' => ''], function () {
    Route::get('dashboard', [App\Http\Controllers\Dashboard\DefaultController::class, 'index'])->name('v3.dashboard');
    Route::get('clear-cache', [App\Http\Controllers\Dashboard\DefaultController::class, 'clearCache'])->name('v3.clearcache');

    // PROFIL
    Route::get('profil/ubahpassword', [App\Http\Controllers\Setting\UbahPassword\UbahPasswordController::class, 'showChangePasswordForm'])->name('v3.profil.ubahpassword');
    Route::patch('profil/ubahpassword', [App\Http\Controllers\Setting\UbahPassword\UbahPasswordController::class, 'changePassword'])->name('v3.auth.change_password');
    Route::resource('profil', '\App\Http\Controllers\Setting\Profil\ProfilController');
    Route::post('profil/ubahfoto', [App\Http\Controllers\Setting\Profil\ProfilController::class, 'storeImg'])->name('v3.profil.ubahfoto');
    Route::get('profil/dokumen/download/{id}', '\App\Http\Controllers\Setting\Profil\ProfilController@downloadDokumen');
});

// HAK AKSES
Route::group(['middleware' => ['auth'], 'prefix' => 'hakakses', 'as' => ''], function () {
    // AKSES JABATAN
    Route::get('aksesjabatan', '\App\Http\Controllers\HakAkses\AksesJabatanController@index')->name('aksesjabatan.index');
    // Route::post('aksesjabatan/storeAkses', '\App\Http\Controllers\HakAkses\AksesJabatanController@storeAkses')->name('akses.store');
    // Route::post('aksesjabatan/storeJabatan', '\App\Http\Controllers\HakAkses\AksesJabatanController@storeJabatan')->name('jabatan.store');
    Route::delete('akses', '\App\Http\Controllers\HakAkses\AksesJabatanController@hapusAkses')->name('akses.destroy');
    Route::delete('jabatan', '\App\Http\Controllers\HakAkses\AksesJabatanController@hapusJabatan')->name('jabatan.destroy');
    // AKUN PENGGUNA
    Route::resource('akunpengguna', '\App\Http\Controllers\HakAkses\DataKaryawanController');
});

// KEPEGAWAIAN
Route::group(['middleware' => ['auth'], 'prefix' => 'kepegawaian', 'as' => ''], function () {
    // STRUKTUR ORGANISASI
    Route::get('strukturorganisasi', [App\Http\Controllers\StrukturOrganisasiController::class, 'index'])->name('strukturorganisasi.index');
    Route::get('strukturorganisasi/tambah', [App\Http\Controllers\StrukturOrganisasiController::class, 'create'])->name('strukturorganisasi.tambah');
    Route::post('strukturorganisasi', [App\Http\Controllers\StrukturOrganisasiController::class, 'store'])->name('strukturorganisasi.simpan');
    Route::get('strukturorganisasi/{id}/ubah', [App\Http\Controllers\StrukturOrganisasiController::class, 'edit'])->name('strukturorganisasi.ubah');
    Route::put('strukturorganisasi/{id}', [App\Http\Controllers\StrukturOrganisasiController::class, 'update'])->name('strukturorganisasi.update');

    // PROFIL KARYAWAN
    Route::get('profilkaryawan', [App\Http\Controllers\Kepegawaian\ProfilKaryawanController::class, 'index'])->name('profilkaryawan.index');
    Route::get('profilkaryawan/{id}', [App\Http\Controllers\Kepegawaian\ProfilKaryawanController::class, 'show'])->name('profilkaryawan.show.profilkaryawan');
    Route::get('profilkaryawan/detail/{id}', [App\Http\Controllers\Setting\Profil\ProfilController::class, 'indexKepegawaian'])->name('profilkaryawan.kepegawaian');
    Route::get('profilkaryawan/dokumen/download/{id}', [App\Http\Controllers\Kepegawaian\DetailProfilKaryawanController::class,'downloadDokumen'])->name('profilkaryawan.downloadDokumen');
    Route::get('profilkaryawan/spkrkk/download/{id}', [App\Http\Controllers\Kepegawaian\DetailProfilKaryawanController::class,'downloadSpkRkk'])->name('profilkaryawan.downloadSpkRkk');
    Route::delete('profilkaryawan/{id}/nonaktif', [App\Http\Controllers\Kepegawaian\ProfilKaryawanController::class, 'destroy'])->name('profilkaryawan.hapus');
    Route::resource('profilkaryawan', '\App\Http\Controllers\Kepegawaian\ProfilKaryawanController');

    // PENGAJUAN
        // SURAT KETERANGAN (SURKET)
        Route::get('pengajuan/surket', [App\Http\Controllers\Kepegawaian\SurketController::class, 'index'])->name('kepegawaian.surket.index');
        Route::get('pengajuan/surket/{id}/download', [\App\Http\Controllers\Kepegawaian\SurketController::class, 'download'])->name('kepegawaian.surket.download');
        Route::get('pengajuan/surket/{id}/generate', [App\Http\Controllers\Kepegawaian\SurketController::class, 'generateFile'])->name('kepegawaian.surket.generate');

        // IDCARD
        Route::get('pengajuan/idcard', [App\Http\Controllers\Kepegawaian\IDCardController::class, 'index'])->name('kepegawaian.idcard.index');

    // PERJALANAN DINAS
    Route::get('pd/{id}/download', [\App\Http\Controllers\Kepegawaian\PDController::class, 'download'])->name('kepegawaian.pd.download');
    Route::get('pd', [App\Http\Controllers\Kepegawaian\PDController::class, 'index'])->name('kepegawaian.pd.index');

    // MASUKAN / SARAN
    Route::get('feedback', [App\Http\Controllers\Kepegawaian\SaranController::class, 'index'])->name('kepegawaian.feedback.index');
    Route::post('feedback/store', [App\Http\Controllers\Kepegawaian\SaranController::class, 'store'])->name('kepegawaian.feedback.store');

    // JADWAL DINAS
    Route::get('jadwaldinas', [App\Http\Controllers\Kepegawaian\JadwalController::class, 'index'])->name('kepegawaian.jadwaldinas.index');
    Route::get('jadwaldinas/{id}/cetak',[App\Http\Controllers\Kepegawaian\JadwalController::class, 'cetak'])->name('kepegawaian.jadwaldinas.cetak');
    Route::get('jadwaldinas/tambah/{id}', [App\Http\Controllers\Kepegawaian\JadwalController::class, 'formTambah'])->name('kepegawaian.jadwaldinas.formTambah');
    Route::get('jadwaldinas/ubah/{id}', [App\Http\Controllers\Kepegawaian\JadwalController::class, 'formUbah'])->name('kepegawaian.jadwaldinas.formUbah');
    // Route::post('jadwaldinas/simpan/proses', [App\Http\Controllers\Kepegawaian\JadwalController::class, 'prosesSimpan'])->name('kepegawaian.jadwaldinas.prosesSimpan');
    Route::post('jadwaldinas/tambah/proses', [App\Http\Controllers\Kepegawaian\JadwalController::class, 'prosesTambah'])->name('kepegawaian.jadwaldinas.prosesTambah');
    Route::post('jadwaldinas/ubah/proses', [App\Http\Controllers\Kepegawaian\JadwalController::class, 'prosesUbah'])->name('kepegawaian.jadwaldinas.prosesUbah');
        // VERIFIKASI JADWAL BAWAHAN
        Route::get('jadwaldinas/bawahan', [App\Http\Controllers\Kepegawaian\JadwalController::class, 'indexBawahan'])->name('kepegawaian.jadwaldinas.indexBawahan');
        // REF SHIFT
        Route::get('jadwaldinas/shift', [App\Http\Controllers\Kepegawaian\JadwalController::class, 'indexShift'])->name('kepegawaian.jadwaldinas.indexShift');
        // REF STAFF
        Route::get('jadwaldinas/staf', [App\Http\Controllers\Kepegawaian\JadwalController::class, 'indexStaf'])->name('kepegawaian.jadwaldinas.indexStaf');
        // REF HARI LIBUR NASIONAL
        Route::get('jadwaldinas/ln', [App\Http\Controllers\Kepegawaian\JadwalController::class, 'indexLN'])->name('kepegawaian.jadwaldinas.indexLN');

    // SURAT TUGAS
    Route::get('surtug', [App\Http\Controllers\Kepegawaian\SurtugController::class, 'index'])->name('kepegawaian.surtug.index');
    Route::get('surtug/{id}/download', [App\Http\Controllers\Kepegawaian\SurtugController::class, 'download'])->name('kepegawaian.surtug.download');

    // ABSENSI
    Route::get('absensi', [App\Http\Controllers\Kepegawaian\AbsensiController::class, 'index'])->name('kepegawaian.absensi.index');
    Route::get('absensi/dashboard', [App\Http\Controllers\Kepegawaian\AbsensiDashboardController::class, 'index'])->name('kepegawaian.absensi.dashboard.index');
    Route::get('absensi/device', [App\Http\Controllers\Kepegawaian\AbsensiDeviceController::class, 'index'])->name('kepegawaian.absensi.device.index');

    // SPK RKK
    Route::get('spkrkk', [App\Http\Controllers\Kepegawaian\SpkRkkController::class, 'index'])->name('kepegawaian.spkrkk.index');

    // REKRUTMEN
        // PENGUMUMAN
        Route::get('rekrutmen/pengumuman', [App\Http\Controllers\Kepegawaian\Rekrutmen\PengumumanController::class, 'index'])->name('kepegawaian.rekrutmen.indexPengumuman');
        // REGISTRASI PESERTA
        Route::get('rekrutmen/registrasi', [App\Http\Controllers\Kepegawaian\Rekrutmen\RegistrasiController::class, 'index'])->name('kepegawaian.rekrutmen.indexRegistrasi');
});

// BERKAS
Route::group(['middleware' => ['auth'], 'prefix' => 'berkas', 'as' => ''], function () {
    // RKA
        // Route::get('rka/final/download', [App\Http\Controllers\Berkas\RkaController::class, 'downloadFinalRKA'])->name('rka.final');
        Route::post('rka/fileupload', [App\Http\Controllers\Berkas\RkaController::class, 'fileupload'])->name('rka.upload');
        Route::resource('rka', '\App\Http\Controllers\Berkas\RkaController');
    // RAPAT
        // Route::post('rapat/fileupload', [App\Http\Controllers\Berkas\RkaController::class, 'fileupload'])->name('rka.upload');
        Route::resource('rapat', '\App\Http\Controllers\Berkas\RapatController');
    // REGULASI
        Route::get('regulasi', '\App\Http\Controllers\Berkas\RegulasiController@index')->name('regulasi.index');
        Route::get('regulasi/{id}/download', '\App\Http\Controllers\Berkas\RegulasiController@download')->name('regulasi.download');
    // LAPORAN BULANAN
        Route::get('laporan/bulanan/verif', '\App\Http\Controllers\Berkas\LaporanBulananController@showVerif')->name('bulanan.verif');
        Route::resource('laporan/bulanan', '\App\Http\Controllers\Berkas\LaporanBulananController');
    // SURAT
        // DISPOSISI
            Route::get('disposisi', '\App\Http\Controllers\Berkas\Surat\DisposisiController@index')->name('disposisi.index');
            Route::get('disposisi/{id}', '\App\Http\Controllers\Berkas\Surat\DisposisiController@show')->name('disposisi.show');
        // SURAT MASUK
            Route::get('suratmasuk', '\App\Http\Controllers\Berkas\Surat\SuratMasukController@index')->name('suratmasuk.index');
            Route::get('suratmasuk/{id}/download', '\App\Http\Controllers\Berkas\Surat\SuratMasukController@download');
            Route::post('suratmasuk', '\App\Http\Controllers\Berkas\Surat\SuratMasukController@store')->name('suratmasuk.store');
        // SURAT KELUAR
            Route::get('suratkeluar', '\App\Http\Controllers\Berkas\Surat\SuratKeluarController@index')->name('suratkeluar.index');
            Route::get('suratkeluar/{id}/download', '\App\Http\Controllers\Berkas\Surat\SuratKeluarController@download');
            Route::post('suratkeluar', '\App\Http\Controllers\Berkas\Surat\SuratKeluarController@store')->name('suratkeluar.store');
});

Route::get('kalender', '\App\Http\Controllers\Kalender\KalenderController@index')->name('kalender.index');

// PENGADAAN
Route::group(['middleware' => ['auth'], 'prefix' => 'pengadaan', 'as' => ''], function () {
    Route::post('rekap', '\App\Http\Controllers\Pengadaan\PengadaanRekapController@index')->name('pengadaanrekap.index');
    Route::get('/', '\App\Http\Controllers\Pengadaan\PengadaanController@index')->name('pengadaan.index');
    // BARANG
        Route::get('barang', '\App\Http\Controllers\Pengadaan\PengadaanBarangController@index')->name('pengadaan.barang.index');
        Route::get('barang/download/{id}', '\App\Http\Controllers\Pengadaan\PengadaanBarangController@download')->name('pengadaan.barang.download');

    // OLD
    // Route::get('pengadaan/api/data', 'publik\pengadaan\pengadaanController@getPengadaan')->name('pengadaan.api.data');
    // Route::get('pengadaan/api/data/{id}', 'publik\pengadaan\pengadaanController@detailPengadaan')->name('pengadaan.api.detailData');
    // Route::get('pengadaan/api/data/hapus/{id}', 'publik\pengadaan\pengadaanController@hapusPengadaan')->name('pengadaan.api.hapus');
    // Route::get('pengadaan/tambah/api/barang/detail/{id}', 'publik\pengadaan\pengadaanController@getBarangDetail')->name('pengadaan.api.barangDetail');
    // Route::get('pengadaan/tambah/api/barang/{id}', 'publik\pengadaan\pengadaanController@getBarang')->name('pengadaan.api.barang');
    // Route::post('pengadaan/tambah', 'publik\pengadaan\pengadaanController@create')->name('pengadaan.create');
    // Route::post('pengadaan', 'publik\pengadaan\pengadaanController@store')->name('pengadaan.store');
    // Route::get('pengadaan/api/barang', 'publik\pengadaan\barangPengadaanController@apiGet')->name('barang.api.get');
    // Route::get('pengadaan/api/barang/hapus/{id}', 'publik\pengadaan\barangPengadaanController@apiHapus')->name('barang.api.hapus');
    // Route::resource('pengadaan/barang', 'publik\pengadaan\barangPengadaanController');

    //     // Rekap Pengadaan
    //     Route::get('pengadaan/rekap', 'publik\pengadaan\pengadaanController@indexRekap')->name('rekap.index');
    //     Route::get('pengadaan/rekap/all', 'publik\pengadaan\pengadaanController@RekapAll')->name('rekapAll.index');
    //     Route::get('pengadaan/rekap/api/data/bulan/{bulan}/tahun/{tahun}', 'publik\pengadaan\pengadaanController@getRekap')->name('rekap.api.data');
    //     Route::get('pengadaan/rekap/api/data/barang/addfield/{barang}', 'publik\pengadaan\pengadaanController@addField')->name('rekap.api.dataBarangAddField');
});

// PENGADUAN
Route::group(['middleware' => ['auth'], 'prefix' => 'perbaikan', 'as' => ''], function () {
    // IPSRS
        Route::post('ipsrs/catatan', '\App\Http\Controllers\Perbaikan\ipsrsController@catatan')->name('ipsrs.catatan');
        Route::get('ipsrs/catatan/{id}', '\App\Http\Controllers\Perbaikan\ipsrsController@downloadCatatan')->name('ipsrs.downloadcatatan');
        Route::post('ipsrs/catatan/ubah', '\App\Http\Controllers\Perbaikan\ipsrsController@ubahCatatan')->name('ipsrs.ubahCatatan');
        Route::get('ipsrs/detail/{id}', '\App\Http\Controllers\Perbaikan\ipsrsController@detail')->name('ipsrs.detail');
        Route::get('ipsrs/riwayat', '\App\Http\Controllers\Perbaikan\ipsrsController@riwayat')->name('ipsrs.riwayat');
        Route::resource('ipsrs', '\App\Http\Controllers\Perbaikan\ipsrsController');
        // Route::post('ipsrs/selesai', '\App\Http\Controllers\Perbaikan\ipsrsController@selesai')->name('pengaduan.ipsrs.selesai');
        // Route::post('ipsrs/tambahketerangan', '\App\Http\Controllers\Perbaikan\ipsrsController@tambahketerangan')->name('pengaduan.ipsrs.tambahketerangan');
        // Route::post('ipsrs/kerjakan', '\App\Http\Controllers\Perbaikan\ipsrsController@kerjakan')->name('pengaduan.ipsrs.kerjakan');
        // Route::post('ipsrs/kerjakan/ubah', '\App\Http\Controllers\Perbaikan\ipsrsController@ubahKerjakan')->name('pengaduan.ipsrs.ubah.kerjakan');
        // Route::post('ipsrs/terima', '\App\Http\Controllers\Perbaikan\ipsrsController@terima')->name('pengaduan.ipsrs.terima');
        // Route::post('ipsrs/terima/ubah', '\App\Http\Controllers\Perbaikan\ipsrsController@ubahTerima')->name('pengaduan.ipsrs.ubah.terima');
        // Route::post('ipsrs/tolak', '\App\Http\Controllers\Perbaikan\ipsrsController@tolak')->name('pengaduan.ipsrs.tolak');
        // Route::get('ipsrs/history', '\App\Http\Controllers\Perbaikan\ipsrsController@history')->name('ipsrs.history');
});

// E-RUANG
Route::group(['middleware' => ['auth'], 'prefix' => 'eruang', 'as' => ''], function () {
    // Accident Report - Kecelakan Kerja
        Route::get('/', [App\Http\Controllers\ERuang\ERuangController::class, 'index'])->name('eruang.index');
        Route::get('/ruangan', [App\Http\Controllers\ERuang\ERuangController::class, 'indexRuangan'])->name('eruang.ruangan');
});

// INVENTARIS
Route::group(['middleware' => ['auth'], 'prefix' => 'inventaris', 'as' => ''], function () {
    // ASET RUANGAN
    Route::get('aset/ruangan','\App\Http\Controllers\Inventaris\Aset\AsetRuanganController@index')->name('aset_ruangan.index');

    // ASET
    Route::get('aset','\App\Http\Controllers\Inventaris\Aset\AsetController@index')->name('aset.index');
    Route::get('aset/{token}','\App\Http\Controllers\Inventaris\Aset\AsetController@detail')->name('aset.detail');
});

// PELAYANAN
Route::group(['middleware' => ['auth'], 'prefix' => 'pelayanan', 'as' => ''], function () {
    // Kebidanan
        Route::get('kebidanan/skl/all','\App\Http\Controllers\Pelayanan\Kebidanan\sklController@showAll')->name('skl.all');
        Route::get('kebidanan/skl/{id}/cetak','\App\Http\Controllers\Pelayanan\Kebidanan\sklController@cetak')->name('skl.cetak');
        Route::get('kebidanan/skl/{id}/print','\App\Http\Controllers\Pelayanan\Kebidanan\sklController@print')->name('skl.print');
        Route::resource('kebidanan/skl', '\App\Http\Controllers\Pelayanan\Kebidanan\sklController');

    // Lab
        // Route::get('lab/antigen/all','lab\antigenController@showAll')->name('antigen.all');
        Route::get('lab/antigen/filter','\App\Http\Controllers\Pelayanan\Lab\antigenController@filter')->name('antigen.filter');
        Route::get('lab/antigen/{id}/cetak','\App\Http\Controllers\Pelayanan\Lab\antigenController@cetak')->name('antigen.cetak');
        Route::get('lab/antigen/{id}/print','\App\Http\Controllers\Pelayanan\Lab\antigenController@print')->name('antigen.print');
        Route::resource('/lab/antigen', '\App\Http\Controllers\Pelayanan\Lab\antigenController');
});

// K3
    // MFK
    Route::group(['middleware' => ['auth'], 'prefix' => 'mfk', 'as' => ''], function () {
        // Accident Report - Kecelakan Kerja
            Route::get('kecelakaankerja','\App\Http\Controllers\MFK\AccidentReportController@index')->name('accidentreport.index');
            Route::get('kecelakaankerja/tambah','\App\Http\Controllers\MFK\AccidentReportController@tambah')->name('accidentreport.tambah');
            Route::post('kecelakaankerja/simpan','\App\Http\Controllers\MFK\AccidentReportController@store')->name('accidentreport.store');
            Route::get('kecelakaankerja/ubah/{id}','\App\Http\Controllers\MFK\AccidentReportController@ubah')->name('accidentreport.showupdate');
            Route::put('kecelakaankerja/ubah','\App\Http\Controllers\MFK\AccidentReportController@update')->name('accidentreport.update');
    });

// Mutu
Route::group(['middleware' => ['auth'], 'prefix' => 'mutu', 'as' => ''], function () {
    // Manajemen Risiko
        Route::get('manrisk','\App\Http\Controllers\Mutu\ManriskController@index')->name('manrisk.index');
        Route::post('manrisk', [App\Http\Controllers\Mutu\ManriskController::class, 'store'])->name('manrisk.store');
        Route::get('manrisk/{id}/download', '\App\Http\Controllers\Mutu\ManriskController@download');
});

// WHATSAPP TEST ROUTE
Route::get('/wa-test', function (WhatsappService $wa) {
    $response = $wa->sendMessage('6281232545545', 'Halo, ini pesan tes dari Laravel Simrsmu!');
    return $response;
});

// FALLBACK ROUTE
Route::fallback(function () {
    return response()->view('pages.page404', [], 404);
});

require __DIR__.'/auth.php';
