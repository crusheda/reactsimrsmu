@extends('layouts.index')

@section('content')

    {{-- FOR DROPDOWN BEHIND CARD --}}
    <style>
        .dropdown {
            transform-style: preserve-3d;
            transform: translate3d(0,0,10px) !important;
        }
    </style>

    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i></a></li>
                        <li class="breadcrumb-item">Kepegawaian</li>
                        <li class="breadcrumb-item" aria-current="page">Absensi</li>
                    </ul>
                </div>
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h2 class="mb-0"><b class="text-primary">Absensi</b> Karyawan</h2>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- [ breadcrumb ] end -->

    <!-- [ Main Content ] start -->
    <div class="row pt-1" id="formAbsensiManual">
        @if (Auth::user()->getPermission('admin_kepegawaian_kepala') || Auth::user()->getPermission('admin_kepegawaian'))
            <div class="col-xl-12">
                <div class="accordion accordion-flush" id="accordionFlushExample">
                    <div class="accordion-item">
                        <div class="card">
                            <div class="card-header accordion-header d-flex align-items-center justify-content-between px-3 py-2">
                                <h5 class="mb-0"><button
                                    class="accordion-button text-dark collapsed" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#flush-collapseOne"
                                    aria-expanded="false" aria-controls="flush-collapseOne"><b style="font-size: 1rem">Form Absensi <a class="text-primary">Ijin Manual</a></b>&nbsp;&nbsp;</button>
                                </h5>
                            </div>
                            <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body" id="filterTampil">

                                    <div class="row" id="formAbsensiManual">
                                        <div class="col-md-3 mb-3">
                                            <div class="form-group">
                                                <label class="form-label">Pilih Bulan dan Tahun Jadwal <a class="text-danger">*</a></label>
                                                <input type="month" class="form-control" value="" onchange="checkBulanIjin(this.value)" id="bulan_ijin" />
                                            </div>
                                        </div>
                                        <div class="col-md-9 mb-3">
                                            <div class="form-group">
                                                <label class="form-label">Pilih Jadwal Dinas <a class="text-danger">*</a></label>
                                                <select class="form-control selectFilter" onchange="checkJadwalIjin(this.value)" id="jadwal_ijin" style="width: 100%" data-allow-clear="false" data-bs-auto-close="outside" disabled></select>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <div class="form-group">
                                                <label class="form-label">Pilih Nama Pegawai <a class="text-danger">*</a></label>
                                                <select class="form-control selectFilter" onchange="checkPegawaiIjin(this.value)" id="pegawai_ijin" style="width: 100%" data-allow-clear="false" data-bs-auto-close="outside" disabled></select>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-3" id="showInfoIjin" hidden></div>
                                        <div class="col-md-12 mb-3" data-bs-toggle="tooltip"
                                            data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true"
                                            title="Pilih Rentang Tanggal Ijin" id="pilih_tgl_ijin" hidden>
                                            <div class="form-group">
                                                <label class="form-label">Rentang Ijin <span class="text-danger">*</span></label>
                                                <div class="input-daterange input-group" id="tgl_ijin">
                                                    <span class="input-group-text">Tanggal Mulai</span>
                                                    <input type="text" class="form-control text-end" placeholder="Masukkan Tanggal" name="range-start" id="ijin_dari">
                                                    <span class="input-group-text">Tanggal Selesai</span>
                                                    <input type="text" class="form-control text-end" placeholder="Masukkan Tanggal" name="range-end" id="ijin_sampai">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-3" id="pilih_ket_ijin" hidden>
                                            <div class="form-group">
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <label class="form-label mb-0">Keterangan Ijin <span class="text-danger">*</span></label>
                                                    <label class="switch mb-0">
                                                        <input type="checkbox" class="switch-input" id="switch_ketmanual_ijin">
                                                        <span class="switch-toggle-slider">
                                                            <span class="switch-on"></span>
                                                            <span class="switch-off"></span>
                                                        </span>
                                                        <span class="switch-label">Tulis Keterangan Manual</span>
                                                    </label>
                                                </div>
                                                <select class="form-control" id="ket_ijin">
                                                    <option value="">Pilih</option>
                                                    <option value="1">Izin menikah (Aturan 3 hari)</option>
                                                    <option value="2">Izin menikahkan anak kandung (Aturan 3 hari)</option>
                                                    <option value="3">Izin istri melahirkan (Aturan 2 hari)</option>
                                                    <option value="4">Izin mengkhitankan anak kandung (Aturan 2 hari)</option>
                                                    <option value="5">Izin menunggu anak kandung/istri/suami rawat inap (Aturan 3 hari)</option>
                                                    <option value="6">Izin karena suami/istri, orang tua/mertua, anak kandung, menantu meninggal dunia (Aturan 3 hari)</option>
                                                    <option value="7">Izin khusus atas persetujuan Direktur Utama</option>
                                                </select>
                                                <textarea class="form-control" id="ketmanual_ijin" rows="3" hidden></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-3" id="upload_ijin" hidden>
                                            <div class="form-group">
                                                <label class="form-label">Upload Berkas Ijin</label>
                                                <input type="file" name="filex" id="filex" class="form-control" accept="image/png, image/jpeg">
                                            </div>
                                        </div>
                                        <div class="text-end btn-page mt-2">
                                            <button class="btn btn-link-secondary" id="clear_input_ijin" onclick="clearInputIjin()">Kosongkan</button>
                                            <button class="btn btn-primary" id="btn-simpan-ijin" onclick="simpanIjin()" disabled><i class="fas fa-save me-1"></i> Buat Ijin</button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="col-xl-12" id="show_filter" hidden>
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between px-3">
                    <h5 class="mb-0 ms-3">Filter <b class="text-primary">Riwayat</b></h5>
                    {{-- @if (Auth::user()->getPermission('admin_surket') == true) --}}
                        <div class="btn-group">
                            <a href="javascript:void(0);" class="avtar avtar-s btn-link-secondary dropdown-toggle arrow-none"
                                id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"><i class="ti ti-dots-vertical f-18"></i></a>
                            {{-- <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="showKategori()">Daftar Kategori</a>
                                </li>
                            </ul> --}}
                        </div>
                    {{-- @endif --}}
                </div>
                <div class="card-body p-b-10">
                    <div class="alert alert-secondary alert-dismissible fade show" role="alert">
                        <small>
                            <i class="ti ti-arrow-narrow-right text-primary me-1"></i> Kosongi filter isian untuk mendapatkan seluruh data (Kecuali isian Wajib <a class="text-danger">*</a>)
                            {{-- <i class="ti ti-arrow-narrow-right text-primary me-1"></i>  <br> --}}
                        </small>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label class="form-label">Pilihan Filter <a class="text-danger">*</a></label>
                                <select class="form-select select2" id="filter_pilihan" onchange="filterPilihan()" data-allow-clear="false" data-bs-auto-close="outside" style="width: 100%" required>
                                    <option value="1" selected hidden>Monitoring Absensi</option>
                                    <option value="2">Absensi Karyawan Lengkap</option>
                                    <option value="3">Rekap Absensi Final</option>
                                    <option value="4">Rekap Absensi (Per Tanggal)</option>
                                    <option value="5">Rekap Cuti</option>
                                    <option value="6">Monitoring Harian Pegawai</option>
                                    <option value="10">Bukti Foto Absensi</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <label class="form-label">Pilihan Unit</label>
                                <select class="form-select select2" name="filter_unit[]" id="filter_unit" style="width: 100%" multiple>
                                    @if (!empty($list['jabatan']))
                                        @foreach ($list['jabatan'] as $item)
                                            <option value="{{ $item->id }}">{{ $item->unit }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2 mb-3">
                            <div class="form-group">
                                <label class="form-label">Jenis Absensi</label>
                                <select class="form-select" name="filter_jenis" id="filter_jenis" style="width: 100%">
                                    <option value="0" selected>Semua Jenis</option>
                                    <option value="1">Shift/Masuk</option>
                                    {{-- <option value="2"><s>Cuti</s></option> --}}
                                    <option value="3">Ijin/TIdak Masuk</option>
                                    <option value="4">Dinas Luar</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3" data-bs-toggle="tooltip"
                            data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true"
                            title="Pilih Rentang Tanggal" id="tgl_range">
                            <div class="form-group">
                                <label class="form-label">Rentang Tanggal <span class="text-danger">*</span></label>
                                <div class="input-daterange input-group" id="pc-datepicker-5">
                                    <span class="input-group-text">Dari</span>
                                    <input type="text" class="form-control text-end" placeholder="Masukkan Tanggal" name="range-start" id="filter_dari">
                                    <span class="input-group-text">Sampai</span>
                                    <input type="text" class="form-control text-end" placeholder="Masukkan Tanggal" name="range-end" id="filter_sampai">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3" data-bs-toggle="tooltip"
                            data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true"
                            title="Pilih Tanggal" id="tgl_harian" hidden>
                            <div class="form-group">
                                <label class="form-label">Masukkan Tanggal (Harian) <span class="text-danger">*</span></label>
                                <input type="text" class="form-control text-center" placeholder="Masukkan Tanggal" id="filter_tanggal">
                            </div>
                        </div>
                        {{-- <div class="col-md-3" data-bs-toggle="tooltip"
                            data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true"
                            title="Pilih Jenis Sarana">
                            <select class="selectFilter form-select" id="filterJenis" data-allow-clear="false" data-bs-auto-close="outside" style="width: 100%" required>
                                <option value="" selected hidden>Pilih Jenis</option>
                                <option value="1">Medis</option>
                                <option value="2">Non Medis</option>
                            </select>
                        </div> --}}
                    </div>
                </div>
                <div class="card-footer p-3">
                    <div class="text-end btn-page mb-0">
                        <button type="button" class="btn btn-link-secondary" id="clear_text" onclick="clearInput()">Kosongkan</button>
                        <button type="button" class="btn btn-shadow btn-primary" onclick="filter()" data-bs-toggle="tooltip"
                        data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true"
                        title="Menampilkan Daftar/Filter Absensi" id="tombol-tampilkan"><i class="fas fa-filter align-middle me-2"></i> Tampilkan</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-12" id="table" hidden>
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between px-3">
                    <h5 class="mb-0 ms-3"><b style="font-size: 1rem">Tabel <a class="text-primary">Riwayat</a></b></h5>
                    {{-- <div class="btn-group">
                        <a href="javascript:void(0);" class="avtar avtar-s btn-link-warning" onclick="showRiwayat()" data-bs-toggle="tooltip"
                        data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="Segarkan Tabel"><i class="ti ti-refresh f-20"></i></a>
                    </div> --}}
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dttable" class="table table-hover dt-responsive align-middle" style="width: 100%">
                            <thead id="tampil-thead"></thead>
                            <tbody id="tampil-tbody">
                                <tr>
                                    <td colspan="20" style="font-size:13px">
                                        <center><i class="fa fa-spinner fa-spin fa-fw"></i> Memproses data...</center>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-12" id="foto" hidden>
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between px-3">
                    <h5 class="mb-0 ms-3"><b style="font-size: 1rem">Bukti <a class="text-primary">Foto Absensi</a></b></h5>
                    {{-- <div class="btn-group">
                        <a href="javascript:void(0);" class="avtar avtar-s btn-link-warning" onclick="showRiwayat()" data-bs-toggle="tooltip"
                        data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="Segarkan Tabel"><i class="ti ti-refresh f-20"></i></a>
                    </div> --}}
                </div>
                <div class="card-body" id="tampil-bukti-foto"></div>
            </div>
        </div>
    </div>

    {{-- MODAL START --}}
    <div class="modal fade" id="fotoModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalFotoTitle"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-3 text-center">
                    <img id="modalImage" src="" alt="Preview Foto" class="img-fluid rounded-3 shadow-sm">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link-secondary" data-bs-dismiss="modal">Tutup <i class="fas fa-arrow-right ms-1"></i></button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade animate__animated animate__rubberBand" id="modalDetail" role="dialog" aria-labelledby="confirmFormLabel"aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        Detail Absensi <span class="badge p-1" id="show_jenis_detail"></span> <span class="badge text-bg-info ms-1 p-1" id="show_id_detail"></span>
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" style="width: 100%">
                            <thead class="text-center align-middle">
                                <tr>
                                    <th>&nbsp;</th>
                                    <th>Berangkat</th>
                                    <th>Pulang</th>
                                </tr>
                            </thead>
                            <tbody id="tampil-tbody-detail" class="text-center align-middle"></tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link-secondary" data-bs-dismiss="modal">Tutup <i class="fas fa-arrow-right ms-1"></i></button>
                    {{-- <button class="btn btn-primary" id="btn-ubah" onclick="prosesUbah()"><i class="fa-fw fas fa-save nav-icon"></i> Simpan Perubahan</button> --}}
                </div>
            </div>
        </div>
    </div>
    {{-- MODAL HAPUS --}}
    <div class="modal animate__animated animate__rubberBand fade" id="modalUbah" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-simple modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        Form <b class="text-warning">Ubah Absensi</b>&nbsp;<kbd id="tx_ubah_absensi"></kbd>
                    </h4>
                </div>
                <div class="modal-body">
                    <input type="text" id="id_ubah_absensi" hidden>
                    <div class="row">
                        <div class="alert alert-secondary">
                            <small>
                                <i class="ti ti-arrow-narrow-right me-1"></i> Silakan memperbaiki data absensi dan shift <mark><b>HANYA YANG PERLU DIUBAH SAJA</b></mark><br>
                                <i class="ti ti-arrow-narrow-right me-1"></i> Form Ubah Absensi ini diperlukan jika pegawai menginginkan perubahan/perbaikan shift dengan kondisi pegawai tersebut telah melakukan/menyelesaikan absensi
                            </small>
                        </div>
                        <h5>DATA <b class="text-primary">SHIFT</b></h5>
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label class="form-label">Pilih Perbaikan Shift <a class="text-danger">*</a></label>
                                <select class="form-control" id="shift_ubah">
                                    <option value="" hidden>Pilih</option>
                                </select>
                            </div>
                        </div>
                        <h5>DATA <b class="text-primary">ABSENSI</b></h5>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Absensi Masuk <a class="text-danger">*</a></label>
                                <input type="datetime-local" class="form-control" id="masuk_ubah">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <div class=" d-flex align-items-center justify-content-between">
                                    <label class="form-label">Absensi Pulang</label>
                                    <div class="form-check">
                                        <label class="form-check-label" for="cek_pulang">Isi Absen Pulang?</label>
                                        <input class="form-check-input" type="checkbox" id="cek_pulang">
                                    </div>
                                </div>
                                <input type="datetime-local" class="form-control" id="pulang_ubah" disabled>
                            </div>
                        </div>
                        <div class="col-md-12" hidden>
                            <div class="form-group">
                                <label class="form-label">Keterangan</label>
                                <textarea class="form-control" id="ket_ubah" rows="3" placeholder="Terisi apabila pegawai telah melakukan Absensi Ijin / Dinas Luar saja"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="btn-ubah-absensi" class="btn btn-warning me-sm-3 me-1" onclick="prosesUbah()"><i class="fa fa-edit me-1" style="font-size:13px"></i> Ubah</button>
                    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-times me-1" style="font-size:13px"></i> Batal</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal animate__animated animate__rubberBand fade" id="modalHapus" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-simple modal-add-new-address modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        Form Hapus&nbsp;<kbd id="tx_hapus_absensi"></kbd>
                    </h4>
                </div>
                <div class="modal-body">
                    <input type="text" id="id_hapus_absensi" hidden>
                    <p style="text-align: justify;">Anda akan melakukan penghapusan Record Absensi tersebut, lakukanlah dengan hati-hati. Ceklis dibawah untuk melanjutkan penghapusan.</p>
                    <label class="switch">
                        <input type="checkbox" class="switch-input" id="setujuhapusabsensi">
                        <span class="switch-toggle-slider">
                        <span class="switch-on"></span>
                        <span class="switch-off"></span>
                        </span>
                        <span class="switch-label">Anda siap menerima Risiko</span>
                    </label>
                </div>
                <div class="col-12 text-center mb-4">
                    <button type="submit" id="btn-hapus-absensi" class="btn btn-danger me-sm-3 me-1" onclick="prosesHapus()"><i class="fa fa-trash me-1" style="font-size:13px"></i> Hapus</button>
                    <button type="reset" class="btn btn-link-secondary" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-times me-1" style="font-size:13px"></i> Batal</button>
                </div>
            </div>
        </div>
    </div>
    {{-- MODAL END --}}

    <script>
        let datepicker_range;
        let datepicker_range_ijin;
        let datepickerd;
        let dariDate;
        let sampaiDate;
        let dariDateIjin;
        let sampaiDateIjin;
        $(document).ready(function() {
            // ubah('1034');
            // ------------------------------------------------------------------------------------- START DATERANGEPICKER
            datepicker_range = new DateRangePicker(document.querySelector('#pc-datepicker-5'), {
                buttonClass: 'btn',
                todayBtn: true,
                clearBtn: true,
                format: 'yyyy-mm-dd'
            });
            datepicker_range_ijin = new DateRangePicker(document.querySelector('#tgl_ijin'), {
                buttonClass: 'btn',
                todayBtn: true,
                clearBtn: false,
                format: 'yyyy-mm-dd'
            });
            datepickerd = new Datepicker(document.querySelector('#filter_tanggal'), {
                buttonClass: 'btn',
                todayBtn: true,
                clearBtn: true,
                format: 'yyyy-mm-dd'
            });
            // Set tanggal default
            const today = new Date();
            let tahun = today.getFullYear();
            let bulan = today.getMonth();

            let bulanLalu = bulan - 1;
            let tahunLalu = tahun;
            if (bulanLalu < 0) {
                bulanLalu = 11;
                tahunLalu -= 1;
            }

            dariDate = new Date(tahunLalu, bulanLalu, 21);
            sampaiDate = new Date(tahun, bulan, 20);
            dariDateIjin = new Date(today);
            sampaiDateIjin = new Date(today);

            // Format ke yyyy-mm-dd string
            const formatDate = (d) => `${d.getFullYear()}-${String(d.getMonth() + 1).padStart(2, '0')}-${String(d.getDate()).padStart(2, '0')}`;

            // Set ke input
            $('#filter_dari').val(formatDate(dariDate));
            $('#filter_sampai').val(formatDate(sampaiDate));

            // 🔥 Set nilai ke datepicker RANGE (bukan ke input langsung)
            datepicker_range_ijin.setDates(dariDateIjin, sampaiDateIjin);
            datepicker_range.setDates(dariDate, sampaiDate);
            datepickerd.setDate(new Date());
            // ------------------------------------------------------------------------------------- END DATERANGEPICKER
            // SELECT2
            var t = $(".select2");
            t.length && t.each(function() {
                var e = $(this);
                e.wrap('<div class="position-relative"></div>').select2({
                    placeholder: "Pilih",
                    allowClear: true,
                    dropdownParent: e.parent()
                })
            });
            $('.selectFilter').select2({
                placeholder: "Pilih",
                dropdownParent: $('#filterTampil')
            });

            // $('#kendaraan').change(function () {
            //     var i = $(this).val();
            //     if (i == 1 || i == 2) {
            //         var o = $("#kendaraan_pegawai");
            //         o.length && o.each(function() {
            //             var e = $(this);
            //             e.wrap('<div class="position-relative"></div>').select2({
            //                 placeholder: "Pilih",
            //                 allowClear: true,
            //                 dropdownParent: e.parent()
            //             })
            //         });
            //         $('#kendaraan_pegawai').val('').change();
            //         $('#showing').prop('hidden',false);
            //         $('#slide').removeClass('col-md-6').addClass('col-md-12');
            //     } else {
            //         $('#showing').prop('hidden',true);
            //         $('#slide').removeClass('col-md-12').addClass('col-md-6');
            //     }
            // });

            // SWITCH KET MANUAL IJIN
            $("#switch_ketmanual_ijin").on("change", function() {
                if ($(this).is(":checked")) {
                    $("#ket_ijin").prop('hidden',true);
                    $("#ketmanual_ijin").prop('hidden',false);
                } else {
                    $("#ket_ijin").prop('hidden',false);
                    $("#ketmanual_ijin").prop('hidden',true);
                }
            });

            $('#show_filter').prop('hidden',false);
            filterPilihan();
        });

        function filterPilihan() {
            $('#tgl_harian').prop('hidden',true);
            $('#tgl_range').prop('hidden',false);
            pilihan = $('#filter_pilihan').val();
            datepicker_range.setDates(dariDate, sampaiDate);
            if (pilihan == 1) {
                datepicker_range.setDates(dariDateIjin, sampaiDateIjin);
                $('#filter_jenis').prop('disabled',false);
            } else {
                if (pilihan == 2) {
                    $('#filter_jenis').prop('disabled',false);
                } else {
                    if (pilihan == 3) {
                        $('#filter_jenis').val(0).prop('disabled',true);
                    } else {
                        if (pilihan == 4) {
                            $('#filter_jenis').val(0).prop('disabled',true);
                        } else {
                            if (pilihan == 5) {
                                $('#filter_jenis').val(0).prop('disabled',true);
                            } else {
                                if (pilihan == 6) {
                                    $('#filter_jenis').val(0).prop('disabled',true);
                                    $('#tgl_range').prop('hidden',true);
                                    $('#tgl_harian').prop('hidden',false);
                                } else {
                                    if (pilihan == 10) {
                                        datepicker_range.setDates(dariDateIjin, sampaiDateIjin);
                                        $('#filter_jenis').prop('disabled',false);
                                    } else {
                                        $('#filter_jenis').prop('disabled',false);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        function filter() {
            pilihan = $('#filter_pilihan').val();
            // jenis = $('#filter_jenis').val();
            // unit = $('#filter_unit').val();
            // dari = $('#filter_dari').val();
            // sampai = $('#filter_sampai').val();

            if (pilihan == 1) {
                showMonitoring();
            } else {
                if (pilihan == 2) {
                    showRiwayatLengkap();
                } else {
                    if (pilihan == 3) {
                        showRekapAbsensiLinda();
                    } else {
                        if (pilihan == 4) {
                            showRekapAbsensiLindaDetail();
                        } else {
                            if (pilihan == 5) {
                                showRekapCuti();
                            } else {
                                if (pilihan == 6) {
                                    showMonitoringAbsensiHarian();
                                } else {
                                    if (pilihan == 10) {
                                        showBuktiFotoAbsensi();
                                    } else {
                                        $('#table').prop('hidden',true);
                                        Swal.fire({
                                            title: `Ahh Maaf!`,
                                            text: 'Fitur ini sedang tahap development. Mohon Ditunggu yaa 😊. Tetap Semangat..',
                                            icon: `success`,
                                            showConfirmButton: false,
                                            showCancelButton: false,
                                            allowOutsideClick: true,
                                            allowEscapeKey: true,
                                            timer: 3000,
                                            timerProgressBar: true,
                                            backdrop: `rgba(26,27,41,0.8)`,
                                        });
                                        // PILIHAN LAIN LAGI APABILA ADA
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        function checkBulanIjin(bulan) {
            $.ajax({
                url: "/api/kepegawaian/absensi/ijin/checkBulan/"+bulan,
                type: 'GET',
                dataType: 'json',
                success: function(res) {
                    $("#jadwal_ijin").empty();
                    res.forEach(item => {
                        $("#jadwal_ijin").append(`
                            <option value="${item.id}">Jadwal Unit ${item.unit} Oleh ${item.nama_pegawai}</option>
                        `);
                    });
                    $("#jadwal_ijin").val(null).trigger('change').prop('disabled',false);
                    $('#pegawai_ijin').val(null).trigger('change').prop('disabled',true);
                    $('#showInfoIjin').prop('hidden',true);
                    $('#pilih_tgl_ijin').prop('hidden',true);
                    $('#pilih_ket_ijin').prop('hidden',true);
                    $('#upload_ijin').val("").prop('hidden',true);
                    $('#btn-simpan-ijin').prop('disabled',true);
                }
            })
        }

        function checkJadwalIjin(id_jadwal) {
            $.ajax({
                url: "/api/kepegawaian/absensi/ijin/checkJadwal/"+id_jadwal,
                type: 'GET',
                dataType: 'json',
                success: function(res) {
                    $("#pegawai_ijin").empty();
                    res.forEach(item => {
                        $("#pegawai_ijin").append(`
                            <option value="${item.id}">${item.nama_pegawai} (${item.jabatan})</option>
                        `);
                    });
                    $("#pegawai_ijin").val(null).trigger('change').prop('disabled',false);
                    $('#showInfoIjin').prop('hidden',true);
                    $('#pilih_tgl_ijin').prop('hidden',true);
                    $('#pilih_ket_ijin').prop('hidden',true);
                    $('#upload_ijin').val("").prop('hidden',true);
                    $('#btn-simpan-ijin').prop('disabled',true);
                }
            })
        }

        function checkPegawaiIjin(id_jadwal) {
            $.ajax({
                url: "/api/kepegawaian/absensi/ijin/checkPegawai/" + id_jadwal,
                type: 'GET',
                dataType: 'json',
                success: function(res) {
                    $('#showInfoIjin').empty();

                    let td1 = '';
                    let td2 = '';
                    let totalDay = parseInt(res.totalDay);

                    for (let count = 1; count <= totalDay; count++) {
                        let kol = 'tgl' + count;

                        // bikin objek tanggal (misalnya bulan & tahun diambil dari res)
                        let currentDate = new Date(res.tahun, res.bulan - 1, count);
                        let isSunday = currentDate.getDay() === 0; // 0 = Minggu

                        console.log(isSunday);
                        if (isSunday) {
                            td1 += `<th class="p-2 text-center" style="background-color: #fed8b9">${count}</th>`;
                            td2 += `<th class="p-2 text-center" style="background-color: #fed8b9">${res.show[kol] ?? ''}</th>`;
                        } else {
                            td1 += `<td class="text-center">${count}</td>`;
                            td2 += `<td class="text-center">${res.show[kol] ?? ''}</td>`;
                        }
                    }

                    $('#showInfoIjin').append(`
                        <div class="table-responsive p-10 pb-0">
                            <table id="table_ijin_manual" class="table table-bordered" style="width: 100%;table-layout: auto">
                                <tbody>
                                    <tr>
                                        <th class="text-center">TANGGAL</th>
                                        ${td1}
                                    </tr>
                                    <tr>
                                        <th class="text-center">JADWAL</th>
                                        ${td2}
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    `).prop('hidden',false);
                    $('#pilih_tgl_ijin').prop('hidden',false);
                    $('#pilih_ket_ijin').val("").prop('hidden',false);
                    $('#upload_ijin').val("").prop('hidden',false);
                    $('#btn-simpan-ijin').prop('disabled',false);
                }
            })
        }

        function simpanIjin() {
            var save = new FormData();
            save.append('bulan',$('#bulan_ijin').val());
            save.append('jadwal',$('#pegawai_ijin').val());
            save.append('dari',$('#ijin_dari').val());
            save.append('sampai',$('#ijin_sampai').val());
            save.append('switch',$('#switch_ketmanual_ijin').is(":checked"));
            save.append('user',"{{ Auth::user()->id }}");

            var filesAdded = $('#filex')[0].files;
            if (filesAdded.length > 0) {
                save.append('file', filesAdded[0]);
            }
            var checkbox = $('#switch_ketmanual_ijin').is(":checked");
            if (checkbox == false) {
                if ($('#ket_ijin').val() == '') {
                    iziToast.error({
                        title: 'Pesan Galat!',
                        message: 'Keterangan Ijin Wajib Diisi.',
                        position: 'topRight'
                    });
                    return;
                } else {
                    save.append('ket',$('#ket_ijin').val());
                }
            } else {
                if ($('#ketmanual_ijin').val() == '') {
                    iziToast.error({
                        title: 'Pesan Galat!',
                        message: 'Keterangan Ijin Wajib Diisi.',
                        position: 'topRight'
                    });
                    return;
                } else {
                    save.append('ket',$('#ketmanual_ijin').val());
                }
            }

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: `/api/kepegawaian/absensi/ijin/push`,
                method: 'post',
                data: save,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(res) {
                    iziToast.success({
                        title: 'Pesan Sukses!',
                        message: 'Penambahan Manual Absensi Ijin telah berhasil dilakukan pada '+res+'. Silakan cek pada riwayat Data Absensi.',
                        position: 'topRight'
                    });
                    clearInputIjin();
                },
                error: function(res) {
                    iziToast.error({
                        title: 'Pesan Galat!',
                        message: res.responseJSON?.message || 'Penambahan Manual Absensi Ijin gagal dilakukan',
                        position: 'topRight'
                    });
                }
            })
        }

        function clearInputIjin() {
            // Reset input bulan jadwal
            $('#bulan_ijin').val('');

            // Reset select jadwal dinas
            $('#jadwal_ijin').val('').trigger('change').prop('disabled', true);

            // Reset select pegawai
            $('#pegawai_ijin').val('').trigger('change').prop('disabled', true);

            // Kosongkan tabel info ijin dan sembunyikan
            $('#showInfoIjin').empty().prop('hidden', true);

            // Kosongkan date range
            $('#ijin_dari').val('');
            $('#ijin_sampai').val('');
            $('#pilih_tgl_ijin').prop('hidden', true);

            // Reset select keterangan ijin
            $('#ket_ijin').val('');
            $('#pilih_ket_ijin').prop('hidden', true);

            // Reset upload ijin
            $('#upload_ijin').val('');
            $('#upload_ijin').prop('hidden', true);

            // Disable tombol simpan
            $('#btn-simpan-ijin').prop('disabled', true);
        }

        function showMonitoring() {
            $("#tampil-thead").empty().append(`
                <tr>
                    <th><center>#ID</center></th>
                    <th>PEGAWAI</th>
                    <th>STATUS</th>
                    <th>BERANGKAT <i class="ti ti-arrow-narrow-right text-primary"></i> PULANG</th>
                    <th>TGL ABSEN</th>
                </tr>
            `);
            $("#tampil-tbody").empty().append(`<tr style='font-size:13px'><td colspan="20"><center><i class="fa fa-spinner fa-spin fa-fw"></i> Memproses data...</center></td></tr>`);
            $('#foto').prop('hidden',true);
            $('#table').prop('hidden',false);
            // INITIALIZIE
            var save = new FormData();
            save.append('jenis',$('#filter_jenis').val());
            save.append('unit',JSON.stringify($('#filter_unit').val()));
            save.append('dari',$('#filter_dari').val());
            save.append('sampai',$('#filter_sampai').val());
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: `/api/kepegawaian/absensi/table/monitoring`,
                method: 'post',
                data: save,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(res) {
                    $("#tampil-tbody").empty();
                    $('#dttable').DataTable().clear().destroy();
                    res.show.forEach(item => {
                        var updet = new Date(item.updated_at).toLocaleDateString("sv-SE");
                        var date = new Date().toLocaleDateString("sv-SE");
                        var devID = "{{ Auth::user()->getPermission(['administrator']) }}";
                        var adminID = "{{ Auth::user()->getPermission(['admin_kepegawaian']) }}";
                        var superID = "{{ Auth::user()->getPermission('admin_kepegawaian_kepala') }}";
                        content = "<tr id='data" + item.id + "' style='font-size:13px'>";
                        content += `<td><center><div class='btn-group'>
                                        <button type='button' class='btn btn-sm ${item.jenis == 1?'btn-light-info':'btn-light-warning'} dropdown-toggle hide-arrow' data-bs-toggle='dropdown' aria-expanded='false'>`+item.id+`</button>
                                        <ul class='dropdown-menu dropdown-menu-right'>`;
                                        if (adminID == true) {
                                            content += `<li><a href="javascript:void(0);" class="dropdown-item text-info" onclick="detail(${item.id})"><i class="fas fa-calendar-alt me-2"></i> Detail</a></li>`;
                                            content += `<li><a href="javascript:void(0);" class="dropdown-item text-warning" onclick="ubah(${item.id})"><i class="fa-fw fas fa-edit me-2"></i> Ubah</a></li>`;
                                            if (superID == true || devID == true) {
                                                content += `<li><a href='javascript:void(0);' class='dropdown-item text-danger' onclick="hapus(${item.id})"><i class="fa-fw fas fa-trash nav-icon"></i> Hapus</a></li>`;
                                            }
                                        } else {
                                            content += `<li><a href="javascript:void(0);" class="dropdown-item text-secondary"><i class="fas fa-calendar-alt me-2"></i> Detail</a></li>`;
                                        }
                        content += "</div></center></td>";
                        role = '';
                        res.role.forEach(us => {
                            if (us.id_user == item.pegawai_id) {
                                role += `<span class="badge bg-light-secondary me-1">${us.nama_role}</span>`;
                            }
                        })
                        content += `<td>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0"><img
                                                    src="${item.foto_user?`/storage/`+item.foto_user.substring(7,10000):'/images/pku/user.png'}" alt="user image"
                                                    class="img-radius wid-40 hei-40 align-top m-r-15"></div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="mb-1">${item.nama_pegawai}</h6>
                                                <small class='text-truncate text-muted'>${role}</small>
                                            </div>
                                        </div>
                                    </td>`;
                        jenis = '';
                        if (item.jenis == 1) {
                            jenis = `<h6>Masuk <b class="text-primary">Shift</b></h6>`;
                        } else {
                            if (item.jenis == 3) {
                                jenis = `<h6>Tidak Masuk/<b class="text-warning">Ijin</b></h6>`;
                            } else {
                                if (item.jenis == 4) {
                                    jenis = `<h6>Masuk <b class="text-info">Dinas Luar</b></h6>`;
                                } else {
                                    jenis = `<h6>Tidak <b class="text-danger">Terdefinisi</b></h6>`;
                                }
                            }
                        }
                        content += `<td>${jenis}</td>`;
                        if (item.terlambat == 1) {
                            colorTglIn = 'text-bg-primary';
                            terlambat = '<span class="badge text-bg-danger" style="padding:3px">Terlambat</span>';
                        } else {
                            if (item.terlambat == 0) {
                                colorTglIn = 'text-bg-primary';
                                terlambat = '<span class="badge text-bg-success" style="padding:3px">Disiplin</span>';
                            } else {
                                if (item.jenis == 3) {
                                    colorTglIn = 'text-bg-warning';
                                    terlambat = '';
                                } else {
                                    if (item.jenis == 4) {
                                        colorTglIn = 'text-bg-info';
                                        terlambat = '';
                                    } else {
                                        colorTglIn = 'text-bg-secondary';
                                        terlambat = '<span class="badge text-bg-danger" style="padding:3px">Tidak Terdefinisi</span>';
                                    }
                                }
                            }
                        }
                        if (item.tgl_out) {
                            tgl_out = '<i class="ti ti-arrows-right text-primary"></i> <span class="badge text-bg-secondary">'+new Date(item.tgl_out).toLocaleString("sv-SE")+'</span>';
                        } else {
                            if (item.jenis != 3) {
                                tgl_out = '<i class="ti ti-arrows-right text-dark"></i> <span class="badge text-bg-info">Belum/Tidak Absen Pulang</span>';
                            } else {
                                tgl_out = '';
                            }
                        }
                        content += `<td style='white-space: normal !important;word-wrap: break-word;'>
                                        <div class='d-flex justify-content-start align-items-center'>
                                            <div class='d-flex flex-column'>
                                                <h6 class='mb-1'><a href="javascript:void(0);" class="text-dark" data-bs-toggle="tooltip"
                                                    data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="Berangkat Sampai Pulang">
                                                    <span class="badge ${colorTglIn}">${new Date(item.tgl_in).toLocaleString("sv-SE")}</span> ${tgl_out}</a>
                                                </h6>
                                                <small class='text-truncate text-muted'>Keterlambatan : <b>${item.keterlambatan?item.keterlambatan:'-'} ${terlambat}</b></small>
                                                <small class='text-truncate text-muted'>Lembur : <b>${item.lembur?item.lembur:'-'}</b></small>
                                            </div>
                                        </div>
                                    </td>`;
                        content += `<td style='white-space: normal !important;word-wrap: break-word;'>
                                        <div class='d-flex justify-content-start align-items-center'>
                                            <div class='d-flex flex-column'>
                                                <a class='mb-0'>` + moment(item.ref_jam_masuk).format('YYYY-MM-DD') + `</a>
                                                ${item.selisih_jam?`<small class='text-truncate text-muted'>Bekerja selama : `+item.selisih_jam+`</small>`:''}
                                            </div>
                                        </div>
                                    </td>`;
                        content += "</tr>";
                        $('#tampil-tbody').append(content);
                        // Showing Tooltip
                        $('[data-bs-toggle="tooltip"]').tooltip({
                            trigger: 'hover'
                        })
                    });
                    var table = $('#dttable').DataTable({
                        // dom: 'Bfrtip',
                        order: [
                            [4, "desc"]
                        ],
                        bAutoWidth: false,
                        aoColumns : [
                            { sWidth: '10%' },
                            { sWidth: '40%' },
                            { sWidth: '10%' },
                            { sWidth: '30%' },
                            { sWidth: '10%' },
                        ],
                        columnDefs: [
                            // { visible: false, targets: [7] },
                        ],
                        displayLength: 100,
                        lengthChange: true,
                        lengthMenu: [100, 300, 500, 1000, 3000, 5000, 10000, 30000, 50000],
                        // buttons: ['copy', 'excel', 'pdf', 'colvis']
                    });
                    iziToast.success({
                        title: 'System Message!',
                        message: 'Berhasil menampilkan data Monitoring Absensi',
                        position: 'topRight'
                    });
                }
            })
        }

        function showRiwayatLengkap() {
            $("#tampil-thead").empty().append(`
                <tr>
                    <th><center>#ID</center></th>
                    <th>TGL ABSEN</th>
                    <th>ID PEGAWAI</th>
                    <th>NIP PEGAWAI</th>
                    <th>NAMA PEGAWAI</th>
                    <th>UNIT</th>
                    <th>STATUS</th>
                    <th>SHIFT</th>
                    <th>JAM MASUK - PULANG</th>
                    <th>ABSEN BERANGKAT</th>
                    <th>ABSEN PULANG</th>
                    <th>TERLAMBAT</th>
                    <th>LEMBUR</th>
                    <th>TOTAL BEKERJA</th>
                </tr>
            `);
            $("#tampil-tbody").empty().append(`<tr style='font-size:13px'><td colspan="20"><center><i class="fa fa-spinner fa-spin fa-fw"></i> Memproses data...</center></td></tr>`);
            $('#foto').prop('hidden',true);
            $('#table').prop('hidden',false);
            // INITIALIZIE
            var save = new FormData();
            save.append('jenis',$('#filter_jenis').val());
            save.append('unit',JSON.stringify($('#filter_unit').val()));
            save.append('dari',$('#filter_dari').val());
            save.append('sampai',$('#filter_sampai').val());
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: `/api/kepegawaian/absensi/table/all`,
                method: 'post',
                data: save,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(res) {
                    $("#tampil-tbody").empty();
                    $('#dttable').DataTable().clear().destroy();
                    res.show.forEach(item => {
                        var updet = new Date(item.updated_at).toLocaleDateString("sv-SE");
                        var date = new Date().toLocaleDateString("sv-SE");
                        var devID = "{{ Auth::user()->getPermission(['administrator']) }}";
                        var adminID = "{{ Auth::user()->getPermission(['admin_kepegawaian']) }}";
                        var superID = "{{ Auth::user()->getPermission('admin_kepegawaian_kepala') }}";
                        content = "<tr id='data" + item.id + "' style='font-size:13px'>";
                        content += `<td><center><div class='btn-group'>
                                        <button type='button' class='btn btn-sm btn-light-secondary dropdown-toggle hide-arrow' data-bs-toggle='dropdown' aria-expanded='false'>`+item.id+`</button>
                                        <ul class='dropdown-menu dropdown-menu-right'>`;
                                        if (adminID == true) {
                                            content += `<li><a href="javascript:void(0);" class="dropdown-item text-info" onclick="detail(${item.id})"><i class="fas fa-calendar-alt me-2"></i> Detail</a></li>`;
                                            content += `<li><a href="javascript:void(0);" class="dropdown-item text-warning" onclick="ubah(${item.id})"><i class="fa-fw fas fa-edit me-2"></i> Ubah</a></li>`;
                                            if (superID == true || devID == true) {
                                                content += `<li><a href='javascript:void(0);' class='dropdown-item text-danger' onclick="hapus(${item.id})"><i class="fa-fw fas fa-trash nav-icon"></i> Hapus</a></li>`;
                                            }
                                        } else {
                                            content += `<li><a href="javascript:void(0);" class="dropdown-item text-secondary"><i class="fas fa-calendar-alt me-2"></i> Detail</a></li>`;
                                        }
                        content += "</div></center></td>";
                        content += `<td>${moment(item.ref_jam_masuk).format('YYYY-MM-DD')}</td>`;
                        content += `<td>${item.id_pegawai}</td>`;
                        content += `<td class="text-end">${item.nip_pegawai?item.nip_pegawai:'-'}</td>`;
                        content += `<td>${item.nama_pegawai}</td>`;
                        role = '';
                        res.role.forEach(us => {
                            if (us.id_user == item.pegawai_id) {
                                role += `<span class="badge bg-light-secondary me-1">${us.nama_role}</span>`;
                            }
                        })
                        content += `<td>${role}</td>`;
                        jenis = '';
                        if (item.jenis == 1) {
                            jenis = `<h6>Masuk <b class="text-primary">Shift</b></h6>`;
                        } else {
                            if (item.jenis == 3) {
                                jenis = `<h6>Tidak Masuk/<b class="text-warning">Ijin</b></h6>`;
                            } else {
                                if (item.jenis == 4) {
                                    jenis = `<h6>Masuk <b class="text-info">Dinas Luar</b></h6>`;
                                } else {
                                    jenis = `<h6>Tidak <b class="text-danger">Terdefinisi</b></h6>`;
                                }
                            }
                        }
                        content += `<td>${jenis}</td>`;
                        content += `<td>${item.nm_shift} (${item.kd_shift})</td>`;
                        content += `<td>${moment(item.ref_jam_masuk).format('HH:mm') +" - "+ moment(item.ref_jam_pulang).format('HH:mm')}</td>`;
                        if (item.terlambat == 1) {
                            colorTglIn = 'text-bg-danger';
                        } else {
                            if (item.terlambat == 0) {
                                colorTglIn = 'text-bg-primary';
                            } else {
                                if (item.jenis == 3) {
                                    colorTglIn = 'text-bg-warning';
                                } else {
                                    if (item.jenis == 4) {
                                        colorTglIn = 'text-bg-info';
                                    } else {
                                        colorTglIn = 'text-bg-secondary';
                                    }
                                }
                            }
                        }
                        content += `<td><span class="badge ${colorTglIn}">${new Date(item.tgl_in).toLocaleString("sv-SE")}</span></td>`;
                        if (item.tgl_out) {
                            tgl_out = '<span class="badge text-bg-secondary">'+new Date(item.tgl_out).toLocaleString("sv-SE")+'</span>';
                        } else {
                            if (item.jenis != 3 && item.jenis != 4) {
                                tgl_out = '<span class="badge text-bg-danger">Belum/Tidak Absen Pulang</span>';
                            } else {
                                tgl_out = '-';
                            }
                        }
                        content += `<td>${tgl_out}</td>`;
                        content += `<td class="text-end">${item.keterlambatan?toTime(item.keterlambatan):'-'}</td>`;
                        content += `<td class="text-end">${item.lembur?toTime(item.lembur):'-'}</td>`;
                        content += `<td class="text-end">${item.selisih_jam?toTime(item.selisih_jam):'-'}</td>`;
                        content += "</tr>";
                        $('#tampil-tbody').append(content);
                        // Showing Tooltip
                        $('[data-bs-toggle="tooltip"]').tooltip({
                            trigger: 'hover'
                        })
                    });
                    var table = $('#dttable').DataTable({
                        dom: 'Bfrtip',
                        scrollX: true, // Tambahkan ini untuk memungkinkan scroll horizontal
                        scrollCollapse: true,
                        // fixedColumns: {
                        //     leftColumns: 5 // Jumlah kolom kiri yang ingin dibekukan (NIP, PEGAWAI, UNIT)
                        // },
                        order: [
                            // [1, "desc"],
                            [4, "asc"],
                        ],
                        // bAutoWidth: false,
                        // aoColumns : [
                        //     { sWidth: '5%' },
                        //     { sWidth: '10%' },
                        //     { sWidth: '30%' },
                        //     { sWidth: '10%' },
                        //     { sWidth: '10%' },
                        //     { sWidth: '10%' },
                        //     { sWidth: '10%' },
                        //     { sWidth: '5%' },
                        //     { sWidth: '5%' },
                        //     { sWidth: '5%' },
                        // ],
                        columnDefs: [
                            { visible: false, targets: [2] },
                        ],
                        displayLength: 100,
                        lengthChange: true,
                        lengthMenu: [100, 300, 500, 1000, 3000, 5000, 10000, 30000, 50000],
                        buttons: [
                            {
                                extend: 'excel',
                                text: 'Export Excel',
                                orientation: 'landscape',
                                pageSize: 'A4',
                                exportOptions: {
                                    columns: [1,2,3,4,5,6,7,8,9,10,11,12,13] // hanya kolom tertentu
                                },
                                className: 'btn btn-success'
                            },
                            {
                                extend: 'pdf',
                                text: 'Export PDF',
                                orientation: 'landscape',
                                pageSize: 'A4',  // F4 dalam milimeter
                                exportOptions: {
                                    columns: [1,2,3,4,5,6,7,8,9,10,11,12,13] // hanya kolom tertentu
                                },
                                className: 'btn btn-danger',
                                customize: function (doc) {
                                    // Menambahkan judul di atas tabel
                                    doc.content.unshift({
                                        text: 'Laporan Data Absensi Pegawai',  // Judul yang ingin ditambahkan
                                        fontSize: 18,   // Ukuran font
                                        bold: true,     // Menebalkan teks
                                        alignment: 'center', // Menyelaraskan teks ke tengah
                                        margin: [0, 0, 0, 10]  // Margin bawah (untuk memberi jarak antara judul dan tabel)
                                    });

                                    // Pastikan header tabel tetap disembunyikan jika diinginkan
                                    if (doc.content && doc.content[1] && doc.content[1].table) {
                                        doc.content[1].table.headerRows = 0;
                                    }
                                }
                            },
                            {
                                extend: 'print',
                                text: 'Cetak',
                                orientation: 'landscape',
                                pageSize: 'A4',  // F4 dalam milimeter
                                className: 'btn btn-warning',
                                customize: function (win) {
                                    // Sembunyikan semua selain tabel
                                    $(win.document.body).find('*').not('table, table *').hide();

                                    $(win.document.body).find('table')
                                        .addClass('compact')
                                        .css('font-size', 'inherit');
                                },
                                exportOptions: {
                                    columns: [1,2,3,4,5,6,7,8,9,10,11,12,13] // hanya kolom tertentu
                                },
                            },
                            {
                                extend: 'colvis',
                                text: 'Sembunyikan Kolom',
                                className: 'btn btn-dark',
                            }
                        ],
                    });
                    iziToast.success({
                        title: 'System Message!',
                        message: 'Berhasil menampilkan data Absensi keseluruhan',
                        position: 'topRight'
                    });
                }
            })
        }

        function showRekapAbsensiLinda() {
            Swal.fire({
                title: `Mohon Perhatian!`,
                text: 'Isikan NIP Seluruh Pegawai dengan Lengkap pada Halaman Profil Kepegawaian guna kelancaran rekap data Absensi',
                icon: `warning`,
                showConfirmButton: false,
                showCancelButton: false,
                allowOutsideClick: true,
                allowEscapeKey: true,
                timer: 5000,
                timerProgressBar: true,
                backdrop: `rgba(26,27,41,0.8)`,
            });
            $("#tampil-thead").empty().append(`
                <tr>
                    <th rowspan="2" class="text-center"><center>NIP</center></th>
                    <th rowspan="2" class="text-center">PEGAWAI</th>
                    <th rowspan="2" class="text-center">UNIT</th>
                    <th colspan="7" class="text-center">TOTAL (JADWAL DINAS)</th>
                    <th colspan="7" class="text-center">TOTAL (ABSENSI)</th>
                    <th rowspan="2" class="text-center">KETERANGAN</th>
                </tr>
                <tr>
                    <th class="text-end" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="Total Shift Sesuai Jadwal Dinas">S</th>
                    <th class="text-end" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="Total Libur Sesuai Jadwal Dinas">L</th>
                    <th class="text-end" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="Total Cuti Tahunan Sesuai Jadwal Dinas">C</th>
                    <th class="text-end" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="Total Cuti Menikah Sesuai Jadwal Dinas">CM</th>
                    <th class="text-end" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="Total Cuti Umroh Sesuai Jadwal Dinas">CU</th>
                    <th class="text-end" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="Total Cuti Haji Sesuai Jadwal Dinas">CH</th>
                    <th class="text-end" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="Total Cuti Diluar Tanggungan Sesuai Jadwal Dinas">CD</th>
                    <th class="text-end" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="Total Datang Tepat Waktu Dari Data Absensi">TEPAT WAKTU</th>
                    <th class="text-end" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="Total Terlambat Dari Data Absensi">TERLAMBAT</th>
                    <th class="text-end" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="Total Absen Hanya 1 Kali Dari Data Absensi">ABSEN 1X</th>
                    <th class="text-end" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="Total Ijin Dari Data Absensi">IJIN</th>
                    <th class="text-end" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="Total Dinas Luar Dari Data Absensi">DINAS LUAR</th>
                    <th class="text-end bg-danger text-white" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="Total Mangkir Dari Data Absensi">MANGKIR</th>
                    <th class="text-end bg-success text-white" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="Total Seluruh Absen Dari Data Absensi">ABSENSI TOTAL</th>
                </tr>
            `);
            $("#tampil-tbody").empty().append(`<tr style='font-size:13px'><td colspan="20"><center><i class="fa fa-spinner fa-spin fa-fw"></i> Memproses data...</center></td></tr>`);
            $('#foto').prop('hidden',true);
            $('#table').prop('hidden',false);
            // INITIALIZIE
            var save = new FormData();
            save.append('jenis',$('#filter_jenis').val());
            save.append('unit',JSON.stringify($('#filter_unit').val()));
            save.append('dari',$('#filter_dari').val());
            save.append('sampai',$('#filter_sampai').val());
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: `/api/kepegawaian/absensi/table/rekapLinda`,
                method: 'post',
                data: save,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(res) {
                    $("#tampil-tbody").empty();
                    $('#dttable').DataTable().clear().destroy();
                    res.show.forEach(item => {
                        var updet = new Date(item.updated_at).toLocaleDateString("sv-SE");
                        var date = new Date().toLocaleDateString("sv-SE");
                        var adminID = "{{ Auth::user()->getPermission(['admin_kepegawaian']) }}";
                        var superID = "{{ Auth::user()->getPermission('admin_kepegawaian_kepala') }}";
                        content = "<tr id='data" + item.pegawai_id + "' style='font-size:13px'>";
                        content += `<td class="text-center">${item.nip?item.nip:'-'}</td>`;
                        content += `<td>${item.nama}</td>`;
                        content += `<td>${item.unit?item.unit:'-'}</td>`;
                        content += `<td class="text-end">${item.total_masuk_shift}</td>`;
                        content += `<td class="text-end">${item.total_L}</td>`;
                        content += `<td class="text-end">${item.total_C}</td>`;
                        content += `<td class="text-end">${item.total_CM}</td>`;
                        content += `<td class="text-end">${item.total_CU}</td>`;
                        content += `<td class="text-end">${item.total_CH}</td>`;
                        content += `<td class="text-end">${item.total_CD}</td>`;
                        content += `<td class="text-end">${item.total_tidak_terlambat}</td>`;
                        content += `<td class="text-end">${item.total_terlambat}</td>`;
                        content += `<td class="text-end">${item.total_alpha}</td>`;
                        content += `<td class="text-end">${item.total_ijin}</td>`;
                        content += `<td class="text-end">${item.total_dinas_luar}</td>`;
                        content += `<td class="text-end">${item.total_mangkir}</td>`;
                        content += `<td class="text-end">${item.total_absensi}</td>`;
                        content += `<td class="text-end text-capitalize">${item.status}</td>`;
                        content += "</tr>";
                        $('#tampil-tbody').append(content);
                        // Showing Tooltip
                        $('[data-bs-toggle="tooltip"]').tooltip({
                            trigger: 'hover'
                        })
                    });
                    var table = $('#dttable').DataTable({
                        dom: 'Bfrtip',
                        scrollX: true, // Tambahkan ini untuk memungkinkan scroll horizontal
                        scrollCollapse: true,
                        fixedColumns: {
                            leftColumns: 3 // Jumlah kolom kiri yang ingin dibekukan (NIP, PEGAWAI, UNIT)
                        },
                        order: [
                            [2, "asc"],
                            [1, "asc"]
                        ],
                        displayLength: 100,
                        lengthChange: true,
                        lengthMenu: [100, 300, 500, 1000, 3000, 5000, 10000, 30000, 50000],
                        buttons: [
                            {
                                extend: 'excel',
                                text: 'Export Excel',
                                orientation: 'landscape',
                                pageSize: 'A4',
                                exportOptions: {
                                    columns: [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17] // hanya kolom tertentu
                                },
                                className: 'btn btn-success'
                            },
                            {
                                extend: 'pdf',
                                text: 'Export PDF',
                                orientation: 'landscape',
                                pageSize: 'A4',  // F4 dalam milimeter
                                exportOptions: {
                                    columns: [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17] // hanya kolom tertentu
                                },
                                className: 'btn btn-danger',
                                customize: function (doc) {
                                    // Menambahkan judul di atas tabel
                                    doc.content.unshift({
                                        text: 'Laporan Data Absensi Pegawai',  // Judul yang ingin ditambahkan
                                        fontSize: 18,   // Ukuran font
                                        bold: true,     // Menebalkan teks
                                        alignment: 'center', // Menyelaraskan teks ke tengah
                                        margin: [0, 0, 0, 10]  // Margin bawah (untuk memberi jarak antara judul dan tabel)
                                    });

                                    // Pastikan header tabel tetap disembunyikan jika diinginkan
                                    if (doc.content && doc.content[1] && doc.content[1].table) {
                                        doc.content[1].table.headerRows = 0;
                                    }
                                }
                            },
                            {
                                extend: 'print',
                                text: 'Cetak',
                                orientation: 'landscape',
                                pageSize: 'A4',  // F4 dalam milimeter
                                className: 'btn btn-warning',
                                customize: function (win) {
                                    // Sembunyikan semua selain tabel
                                    $(win.document.body).find('*').not('table, table *').hide();

                                    $(win.document.body).find('table')
                                        .addClass('compact')
                                        .css('font-size', 'inherit');
                                },
                                exportOptions: {
                                    columns: [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17] // hanya kolom tertentu
                                },
                            },
                            {
                                extend: 'colvis',
                                text: 'Sembunyikan Kolom',
                                className: 'btn btn-dark',
                            }
                        ],
                    });
                    iziToast.success({
                        title: 'System Message!',
                        message: 'Berhasil menampilkan data Rekapitulasi Absensi berdasarkan masing-masing Pegawai dan Per Unit',
                        position: 'topRight'
                    });
                }
            })
        }

        function showRekapAbsensiLindaDetail() {
            Swal.fire({
                title: `Mohon Perhatian!`,
                text: 'Isikan NIP Seluruh Pegawai dengan Lengkap pada Halaman Profil Kepegawaian guna kelancaran rekap data Absensi',
                icon: `warning`,
                showConfirmButton: false,
                showCancelButton: false,
                allowOutsideClick: true,
                allowEscapeKey: true,
                timer: 5000,
                timerProgressBar: true,
                backdrop: `rgba(26,27,41,0.8)`,
            });
            $("#tampil-thead").empty().append(`
                <tr>
                    <th class="text-center"><center>NIP</center></th>
                    <th class="text-center">PEGAWAI</th>
                    <th class="text-center">UNIT</th>
                    <th class="text-center">TANGGAL</th>
                    <th class="text-center">ABSENSI BERANGKAT</th>
                    <th class="text-center">ABSENSI PULANG</th>
                    <th class="text-center">TERLAMBAT</th>
                    <th class="text-center">TEPAT WAKTU</th>
                    <th class="text-center">ABSEN 1X</th>
                    <th class="text-center">IJIN</th>
                    <th class="text-center">DINAS LUAR</th>
                    <th class="text-center">KETERANGAN</th>
                </tr>
            `);
            $("#tampil-tbody").empty().append(`<tr style='font-size:13px'><td colspan="20"><center><i class="fa fa-spinner fa-spin fa-fw"></i> Memproses data...</center></td></tr>`);
            $('#foto').prop('hidden',true);
            $('#table').prop('hidden',false);
            // INITIALIZIE
            var save = new FormData();
            save.append('jenis',$('#filter_jenis').val());
            save.append('unit',JSON.stringify($('#filter_unit').val()));
            save.append('dari',$('#filter_dari').val());
            save.append('sampai',$('#filter_sampai').val());
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: `/api/kepegawaian/absensi/table/rekapLindaDetail`,
                method: 'post',
                data: save,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(res) {
                    $("#tampil-tbody").empty();
                    $('#dttable').DataTable().clear().destroy();
                    res.show.forEach(item => {
                        var updet = new Date(item.updated_at).toLocaleDateString("sv-SE");
                        var date = new Date().toLocaleDateString("sv-SE");
                        var adminID = "{{ Auth::user()->getPermission(['admin_kepegawaian']) }}";
                        var superID = "{{ Auth::user()->getPermission('admin_kepegawaian_kepala') }}";
                        content = "<tr id='data" + item.pegawai_id + "' style='font-size:13px'>";
                        content += `<td class="text-center">${item.nip?item.nip:'-'}</td>`;
                        content += `<td>${item.nama}</td>`;
                        content += `<td>${item.unit?item.unit:'-'}</td>`;
                        content += `<td class="text-center">${item.tanggal}</td>`;
                        content += `<td class="text-center">${item.is_terlambat==1?'<b class="text-danger">'+item.jam_masuk+'</b>':item.jam_masuk}</td>`;
                        content += `<td class="text-center">${item.jam_pulang?item.jam_pulang:'-'}</td>`;
                        content += `<td class="text-center">${item.is_terlambat==1?'<i class="ti ti-mood-sad text-danger" style="font-size: 20px;"></i>':' '}</td>`;
                        content += `<td class="text-center">${item.is_tidak_terlambat==1?'<i class="ti ti-mood-smile text-success" style="font-size: 20px;"></i>':' '}</td>`;
                        content += `<td class="text-center">${item.is_alpha==1?'<i class="ti ti-mood-neutral text-warning" style="font-size: 20px;"></i>':' '}</td>`;
                        content += `<td class="text-center">${item.is_ijin==1?'<i class="ti ti-mood-crazy-happy text-info" style="font-size: 20px;"></i>':' '}</td>`;
                        content += `<td class="text-center">${item.is_dinas_luar==1?'<i class="ti ti-mood-happy text-dark" style="font-size: 20px;"></i>':' '}</td>`;
                        content += `<td class="text-end">${item.status_keterangan}</td>`;
                        content += "</tr>";
                        $('#tampil-tbody').append(content);
                        // Showing Tooltip
                        $('[data-bs-toggle="tooltip"]').tooltip({
                            trigger: 'hover'
                        })
                    });
                    var table = $('#dttable').DataTable({
                        dom: 'Bfrtip',
                        order: [
                            [1, "asc"], // Kolom PEGAWAI (kolom ke-3, index 2)
                            [3, "asc"]   // Kolom TANGGAL (kolom ke-4, index 3)
                        ],
                        // bAutoWidth: false,
                        // aoColumns : [
                        //     { sWidth: '5%' },
                        //     { sWidth: '10%' },
                        //     { sWidth: '30%' },
                        //     { sWidth: '10%' },
                        //     { sWidth: '10%' },
                        //     { sWidth: '10%' },
                        //     { sWidth: '10%' },
                        //     { sWidth: '5%' },
                        //     { sWidth: '5%' },
                        //     { sWidth: '5%' },
                        // ],
                        displayLength: 100,
                        lengthChange: true,
                        lengthMenu: [100, 300, 500, 1000, 3000, 5000, 10000, 30000, 50000],
                        buttons: [
                            {
                                extend: 'excel',
                                text: 'Export Excel',
                                orientation: 'landscape',
                                pageSize: 'A4',
                                exportOptions: {
                                    columns: [0,1,2,3,4,5,6,7,8,9,10,11] // hanya kolom tertentu
                                },
                                className: 'btn btn-success'
                            },
                            {
                                extend: 'pdf',
                                text: 'Export PDF',
                                orientation: 'landscape',
                                pageSize: 'A4',  // F4 dalam milimeter
                                exportOptions: {
                                    columns: [0,1,2,3,4,5,6,7,8,9,10,11] // hanya kolom tertentu
                                },
                                className: 'btn btn-danger',
                                customize: function (doc) {
                                    // Menambahkan judul di atas tabel
                                    doc.content.unshift({
                                        text: 'Laporan Data Absensi Pegawai',  // Judul yang ingin ditambahkan
                                        fontSize: 18,   // Ukuran font
                                        bold: true,     // Menebalkan teks
                                        alignment: 'center', // Menyelaraskan teks ke tengah
                                        margin: [0, 0, 0, 10]  // Margin bawah (untuk memberi jarak antara judul dan tabel)
                                    });

                                    // Pastikan header tabel tetap disembunyikan jika diinginkan
                                    if (doc.content && doc.content[1] && doc.content[1].table) {
                                        doc.content[1].table.headerRows = 0;
                                    }
                                }
                            },
                            {
                                extend: 'print',
                                text: 'Cetak',
                                orientation: 'landscape',
                                pageSize: 'A4',  // F4 dalam milimeter
                                className: 'btn btn-warning',
                                customize: function (win) {
                                    // Sembunyikan semua selain tabel
                                    $(win.document.body).find('*').not('table, table *').hide();

                                    $(win.document.body).find('table')
                                        .addClass('compact')
                                        .css('font-size', 'inherit');
                                },
                                exportOptions: {
                                    columns: [0,1,2,3,4,5,6,7,8,9,10,11] // hanya kolom tertentu
                                },
                            },
                            {
                                extend: 'colvis',
                                text: 'Sembunyikan Kolom',
                                className: 'btn btn-dark',
                            }
                        ],
                    });
                    iziToast.success({
                        title: 'System Message!',
                        message: 'Berhasil menampilkan data Rekapitulasi Absensi berdasarkan masing-masing Pegawai dan Per Tanggal',
                        position: 'topRight'
                    });
                }
            })
        }

        function showRekapCuti() {
            // Swal.fire({
            //     title: `Mohon Perhatian!`,
            //     text: 'Isikan NIP Seluruh Pegawai dengan Lengkap pada Halaman Profil Kepegawaian guna kelancaran rekap data Absensi',
            //     icon: `warning`,
            //     showConfirmButton: false,
            //     showCancelButton: false,
            //     allowOutsideClick: true,
            //     allowEscapeKey: true,
            //     timer: 5000,
            //     timerProgressBar: true,
            //     backdrop: `rgba(26,27,41,0.8)`,
            // });
            $("#tampil-thead").empty().append(`
                <tr>
                    <th class="text-center"><center>NIP</center></th>
                    <th class="text-center">PEGAWAI</th>
                    <th class="text-center">UNIT</th>
                    <th class="text-center">TGL CUTI</th>
                    <th class="text-center">KETERANGAN</th>
                </tr>
            `);
            $("#tampil-tbody").empty().append(`<tr style='font-size:13px'><td colspan="20"><center><i class="fa fa-spinner fa-spin fa-fw"></i> Memproses data...</center></td></tr>`);
            $('#foto').prop('hidden',true);
            $('#table').prop('hidden',false);
            // INITIALIZIE
            var save = new FormData();
            save.append('jenis',$('#filter_jenis').val());
            save.append('unit',JSON.stringify($('#filter_unit').val()));
            save.append('dari',$('#filter_dari').val());
            save.append('sampai',$('#filter_sampai').val());
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: `/api/kepegawaian/absensi/table/getCutiPegawai`,
                method: 'post',
                data: save,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(res) {
                    $("#tampil-tbody").empty();
                    $('#dttable').DataTable().clear().destroy();
                    res.forEach(item => {
                        var updet = new Date(item.updated_at).toLocaleDateString("sv-SE");
                        var date = new Date().toLocaleDateString("sv-SE");
                        var adminID = "{{ Auth::user()->getPermission(['admin_kepegawaian']) }}";
                        var superID = "{{ Auth::user()->getPermission('admin_kepegawaian_kepala') }}";
                        content = "<tr id='data" + item.pegawai_id + "' style='font-size:13px'>";
                        content += `<td class="text-center">${item.nip?item.nip:'-'}</td>`;
                        content += `<td>${item.nama}</td>`;
                        content += `<td class="text-center">${item.unit?item.unit:'-'}</td>`;
                        content += `<td class="text-center">${item.tanggal_cuti}</td>`;
                        content += `<td class="text-center">${item.jenis_cuti}</td>`;
                        content += "</tr>";
                        $('#tampil-tbody').append(content);
                        // Showing Tooltip
                        $('[data-bs-toggle="tooltip"]').tooltip({
                            trigger: 'hover'
                        })
                    });
                    var table = $('#dttable').DataTable({
                        dom: 'Bfrtip',
                        order: [
                            [2, "asc"] // Kolom PEGAWAI (kolom ke-3, index 2)
                        ],
                        displayLength: 100,
                        lengthChange: true,
                        lengthMenu: [100, 300, 500, 1000, 3000, 5000, 10000, 30000, 50000],
                        buttons: [
                            {
                                extend: 'excel',
                                text: 'Export Excel',
                                orientation: 'landscape',
                                pageSize: 'A4',
                                exportOptions: {
                                    columns: [0,1,2,3,4] // hanya kolom tertentu
                                },
                                className: 'btn btn-success'
                            },
                            {
                                extend: 'pdf',
                                text: 'Export PDF',
                                orientation: 'landscape',
                                pageSize: 'A4',  // F4 dalam milimeter
                                exportOptions: {
                                    columns: [0,1,2,3,4] // hanya kolom tertentu
                                },
                                className: 'btn btn-danger',
                                customize: function (doc) {
                                    // Menambahkan judul di atas tabel
                                    doc.content.unshift({
                                        text: 'Laporan Data Absensi Pegawai',  // Judul yang ingin ditambahkan
                                        fontSize: 18,   // Ukuran font
                                        bold: true,     // Menebalkan teks
                                        alignment: 'center', // Menyelaraskan teks ke tengah
                                        margin: [0, 0, 0, 10]  // Margin bawah (untuk memberi jarak antara judul dan tabel)
                                    });

                                    // Pastikan header tabel tetap disembunyikan jika diinginkan
                                    if (doc.content && doc.content[1] && doc.content[1].table) {
                                        doc.content[1].table.headerRows = 0;
                                    }
                                }
                            },
                            {
                                extend: 'print',
                                text: 'Cetak',
                                orientation: 'landscape',
                                pageSize: 'A4',  // F4 dalam milimeter
                                className: 'btn btn-warning',
                                customize: function (win) {
                                    // Sembunyikan semua selain tabel
                                    $(win.document.body).find('*').not('table, table *').hide();

                                    $(win.document.body).find('table')
                                        .addClass('compact')
                                        .css('font-size', 'inherit');
                                },
                                exportOptions: {
                                    columns: [0,1,2,3,4] // hanya kolom tertentu
                                },
                            },
                            {
                                extend: 'colvis',
                                text: 'Sembunyikan Kolom',
                                className: 'btn btn-dark',
                            }
                        ],
                    });
                    iziToast.success({
                        title: 'System Message!',
                        message: 'Berhasil menampilkan data Rekapitulasi Cuti berdasarkan masing-masing Pegawai dan Per Tanggal',
                        position: 'topRight'
                    });
                }
            })
        }

        function showMonitoringAbsensiHarian() {
            // Swal.fire({
            //     title: `Mohon Perhatian!`,
            //     text: 'Isikan NIP Seluruh Pegawai dengan Lengkap pada Halaman Profil Kepegawaian guna kelancaran rekap data Absensi',
            //     icon: `warning`,
            //     showConfirmButton: false,
            //     showCancelButton: false,
            //     allowOutsideClick: true,
            //     allowEscapeKey: true,
            //     timer: 5000,
            //     timerProgressBar: true,
            //     backdrop: `rgba(26,27,41,0.8)`,
            // });
            $("#tampil-thead").empty().append(`
                <tr>
                    <th class="text-center"><center>#ID</center></th>
                    <th class="text-center"><center>NIP</center></th>
                    <th class="text-center">PEGAWAI</th>
                    <th class="text-center">UNIT</th>
                    <th class="text-center" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="Shift Di Hari Itu">STATUS SHIFT</th>
                    <th class="text-center" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="Jam Berangkat Menurut Referensi Shift">SHIFT BERANGKAT</th>
                    <th class="text-center" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="Jam Pulang Menurut Referensi Shift">SHIFT PULANG</th>
                    <th class="text-center" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="Jam Absensi Berangkat Oleh Karyawan">ABSEN BERANGKAT</th>
                    <th class="text-center" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="Jam Absensi Pulang Oleh Karyawan">ABSEN PULANG</th>
                    <th class="text-center">KEDISIPLINAN</th>
                    <th class="text-center">ABSENSI</th>
                </tr>
            `);
            $("#tampil-tbody").empty().append(`<tr style='font-size:13px'><td colspan="20"><center><i class="fa fa-spinner fa-spin fa-fw"></i> Memproses data...</center></td></tr>`);
            $('#foto').prop('hidden',true);
            $('#table').prop('hidden',false);
            // INITIALIZIE
            var save = new FormData();
            save.append('unit',JSON.stringify($('#filter_unit').val()));
            save.append('tanggal',$('#filter_tanggal').val());
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: `/api/kepegawaian/absensi/table/getMonitoringAbsensiHarian`,
                method: 'post',
                data: save,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(res) {
                    $("#tampil-tbody").empty();
                    $('#dttable').DataTable().clear().destroy();
                    res.forEach(item => {
                        var updet = new Date(item.updated_at).toLocaleDateString("sv-SE");
                        var date = new Date().toLocaleDateString("sv-SE");
                        var devID = "{{ Auth::user()->getPermission(['administrator']) }}";
                        var adminID = "{{ Auth::user()->getPermission(['admin_kepegawaian']) }}";
                        var superID = "{{ Auth::user()->getPermission('admin_kepegawaian_kepala') }}";
                        content = "<tr id='data" + item.pegawai_id + "' style='font-size:13px'>";
                        if (item.id) {
                            content += `<td><center><div class='btn-group'>
                                            <button type='button' class='btn btn-sm btn-light-primary dropdown-toggle hide-arrow' data-bs-toggle='dropdown' aria-expanded='false'>`+item.id+`</button>
                                            <ul class='dropdown-menu dropdown-menu-right'>`;
                                            if (adminID == true) {
                                                content += `<li><a href="javascript:void(0);" class="dropdown-item text-info" onclick="detail(${item.id})"><i class="fas fa-calendar-alt me-2"></i> Detail</a></li>`;
                                                content += `<li><a href="javascript:void(0);" class="dropdown-item text-warning" onclick="ubah(${item.id})"><i class="fa-fw fas fa-edit me-2"></i> Ubah</a></li>`;
                                                if (superID == true || devID == true) {
                                                    content += `<li><a href='javascript:void(0);' class='dropdown-item text-danger' onclick="hapus(${item.id})"><i class="fa-fw fas fa-trash nav-icon"></i> Hapus</a></li>`;
                                                }
                                            } else {
                                                content += `<li><a href="javascript:void(0);" class="dropdown-item text-secondary"><i class="fas fa-calendar-alt me-2"></i> Detail</a></li>`;
                                            }
                            content += "</div></center></td>";
                        } else {
                            content += `<td><center><span class="badge bg-light-secondary">-</span></center></td>`;
                        }
                        content += `<td class="text-center">${item.nip?item.nip:'-'}</td>`;
                        content += `<td>${item.nama}</td>`;
                        content += `<td class="text-center">${item.unit?item.unit:'-'}</td>`;
                        content += `<td class="text-center text-capitalize">${item.status_shift}</td>`;
                        if (!['C', 'CM', 'CU', 'CH', 'CD', 'L'].includes(item.kd_shift ?? '')) {
                            content += `<td class="text-center">${item.jam_berangkat ?? '-'}</td>`;
                            content += `<td class="text-center">${item.jam_pulang ?? '-'}</td>`;
                        } else {
                            content += `<td class="text-center">-</td>`;
                            content += `<td class="text-center">-</td>`;
                        }
                        content += `<td class="text-center">${item.absen_berangkat}</td>`;
                        content += `<td class="text-center">${item.absen_pulang}</td>`;
                        if (item.status_disiplin == 'Tepat Waktu') {
                            status_disiplin = `<span class="badge bg-light-success">${item.status_disiplin}</span>`;
                        } else {
                            if (item.status_disiplin == 'Toleransi') {
                                status_disiplin = `<span class="badge bg-light-warning">${item.status_disiplin}</span>`;
                            } else {
                                if (item.status_disiplin == 'Terlambat') {
                                    status_disiplin = `<span class="badge bg-light-danger">${item.status_disiplin}</span>`;
                                } else {
                                    status_disiplin = `<span class="badge bg-light-secondary">-</span>`;
                                }
                            }
                        }
                        content += `<td class="text-center">${status_disiplin}</td>`;
                        if (item.status_absensi == 'Lengkap') {
                            status_absensi = `<span class="badge bg-light-success">${item.status_absensi}</span>`;
                        } else {
                            if (item.status_absensi == 'Absen 1x / Tidak Lengkap') {
                                status_absensi = `<span class="badge bg-light-warning">${item.status_absensi}</span>`;
                            } else {
                                if (item.status_absensi == 'Belum Absen / Alpha') {
                                    status_absensi = `<span class="badge bg-light-danger">${item.status_absensi}</span>`;
                                } else {
                                    if (item.status_absensi == 'Tidak Valid') {
                                        status_absensi = `<span class="badge bg-danger">Jam Shift Tidak Valid</span>`;
                                    } else {
                                        status_absensi = `<span class="badge bg-light-secondary">-</span>`;
                                    }
                                }
                            }
                        }
                        content += `<td class="text-center">${status_absensi}</td>`;
                        content += "</tr>";
                        $('#tampil-tbody').append(content);
                        // Showing Tooltip
                        $('[data-bs-toggle="tooltip"]').tooltip({
                            trigger: 'hover'
                        })
                    });
                    var table = $('#dttable').DataTable({
                        dom: 'Bfrtip',
                        order: [
                            [5, "asc"], // Kolom PEGAWAI (kolom ke-3, index 2)
                            [3, "asc"], // Kolom PEGAWAI (kolom ke-3, index 2)
                            [2, "asc"] // Kolom PEGAWAI (kolom ke-3, index 2)
                        ],
                        displayLength: 100,
                        lengthChange: true,
                        lengthMenu: [100, 300, 500, 1000, 3000, 5000, 10000, 30000, 50000],
                        buttons: [
                            {
                                extend: 'excel',
                                text: 'Export Excel',
                                orientation: 'landscape',
                                pageSize: 'A4',
                                exportOptions: {
                                    // columns: [2,3,4,5,6,7,8,9,10] // hanya kolom tertentu
                                },
                                className: 'btn btn-success'
                            },
                            {
                                extend: 'pdf',
                                text: 'Export PDF',
                                orientation: 'landscape',
                                pageSize: 'A4',  // F4 dalam milimeter
                                exportOptions: {
                                    // columns: [2,3,4,5,6,7,8,9,10] // hanya kolom tertentu
                                },
                                className: 'btn btn-danger',
                                customize: function (doc) {
                                    // Menambahkan judul di atas tabel
                                    doc.content.unshift({
                                        text: 'Laporan Data Absensi Pegawai',  // Judul yang ingin ditambahkan
                                        fontSize: 18,   // Ukuran font
                                        bold: true,     // Menebalkan teks
                                        alignment: 'center', // Menyelaraskan teks ke tengah
                                        margin: [0, 0, 0, 10]  // Margin bawah (untuk memberi jarak antara judul dan tabel)
                                    });

                                    // Pastikan header tabel tetap disembunyikan jika diinginkan
                                    if (doc.content && doc.content[1] && doc.content[1].table) {
                                        doc.content[1].table.headerRows = 0;
                                    }
                                }
                            },
                            {
                                extend: 'print',
                                text: 'Cetak',
                                orientation: 'landscape',
                                pageSize: 'A4',  // F4 dalam milimeter
                                className: 'btn btn-warning',
                                customize: function (win) {
                                    // Sembunyikan semua selain tabel
                                    $(win.document.body).find('*').not('table, table *').hide();

                                    $(win.document.body).find('table')
                                        .addClass('compact')
                                        .css('font-size', 'inherit');
                                },
                                exportOptions: {
                                    // columns: [2,3,4,5,6,7,8,9,10] // hanya kolom tertentu
                                },
                            },
                            {
                                extend: 'colvis',
                                text: 'Sembunyikan Kolom',
                                className: 'btn btn-dark',
                            }
                        ],
                    });
                    iziToast.success({
                        title: 'System Message!',
                        message: 'Berhasil menampilkan data Monitoring Harian Absensi berdasarkan Jadwal Shift Per Tanggal',
                        position: 'topRight'
                    });
                }
            })
        }

        function showBuktiFotoAbsensi() {
            $("#tampil-bukti-foto").empty().append(`<center><i class="fa fa-spinner fa-spin fa-fw"></i> Memproses data...</center>`);
            $('#foto').prop('hidden',false);
            $('#table').prop('hidden',true);
            // INITIALIZIE
            var save = new FormData();
            save.append('jenis',$('#filter_jenis').val());
            save.append('unit',JSON.stringify($('#filter_unit').val()));
            save.append('dari',$('#filter_dari').val());
            save.append('sampai',$('#filter_sampai').val());
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: `/api/kepegawaian/absensi/table/getBuktifFotoPegawai`,
                method: 'post',
                data: save,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(res) {
                    $("#tampil-bukti-foto").empty();
                    console.log(res);
                    ct = `<div class="row g-3">`;
                    res.show.forEach(item => {
                        let imgPath = 'https://absensi.simrsmu.com/storage/' + item.foto_berangkat.replace('public/', '');
                        ct += `<div class="col-md-1">
                                    <div class="foto-wrapper" style="width: 100%;aspect-ratio: 1 / 1;overflow: hidden;border-radius: 0.5rem;">
                                        <img src="${imgPath}" class="img-fluid rounded-3 shadow-sm img-thumb" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true"
                                            title="${item.nama+' ('+item.unit+') - Berangkat Pukul '+item.jam_masuk+' ('+item.status_keterangan+')'}" data-absen="${item.nama+' ('+item.unit+') - '+item.status_keterangan}" data-full="${imgPath}" data-absen="${item.nama+' ('+item.unit+') - '+item.status_keterangan}" alt="Foto Absensi Berangkat" style="width: 100%;height: 100%;object-fit: cover;">
                                    </div>
                                </div>`;
                        if (item.foto_pulang) {
                            let imgPathP = 'https://absensi.simrsmu.com/storage/' + item.foto_pulang.replace('public/', '');
                            ct += `<div class="col-md-1">
                                        <div class="foto-wrapper" style="width: 100%;aspect-ratio: 1 / 1;overflow: hidden;border-radius: 0.5rem;">
                                            <img src="${imgPathP}" class="img-fluid rounded-3 shadow-sm img-thumb" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true"
                                                title="${item.nama+' ('+item.unit+') - Pulang Pukul '+item.jam_pulang+' (Status : '+item.status_keterangan+')'}" data-absen="${item.nama+' ('+item.unit+') - '+item.status_keterangan}" data-full="${imgPathP}" data-absen="${item.nama+' ('+item.unit+') - '+item.status_keterangan}" alt="Foto Absensi Pulang" style="width: 100%;height: 100%;object-fit: cover;">
                                        </div>
                                    </div>`;
                        }
                    });
                    ct += `</div>`;
                    $("#tampil-bukti-foto").append(ct);
                    iziToast.success({
                        title: 'System Message!',
                        message: 'Berhasil menampilkan Rekapitulasi Bukti Foto Absensi Filter Tanggal',
                        position: 'topRight'
                    });
                    // Showing Tooltip
                    $('[data-bs-toggle="tooltip"]').tooltip({
                        trigger: 'hover'
                    })
                    $(".img-thumb").on("click", function(){
                        let fullUrl = $(this).data("full");
                        let absen = $(this).data("absen");
                        let modalImg = $("#modalImage");

                        modalImg.attr("src", fullUrl);
                        $('#modalFotoTitle').text('Absensi '+absen);
                        modalImg.css({
                            "height": "800px",
                            "width": "auto"
                        });

                        $("#fotoModal").modal("show");
                    });
                }
            })
        }

        // FUNCTION FITURE
        function detail(id) {
            $("#tampil-tbody-detail").empty().append(`<tr style='font-size:13px'><td colspan="20"><center><i class="fa fa-spinner fa-spin fa-fw"></i> Memproses data...</center></td></tr>`);
            $.ajax({
                url: `/api/kepegawaian/absensi/${id}/detail`,
                type: 'GET',
                dataType: 'json',
                success: function(res) {
                    if (res.show) {
                        $('#show_id_detail').text('ID#'+id);
                        // INIT HEADER
                        if (res.show.jenis == 1) {
                            tx = 'Shift '+res.show.nm_shift;
                            clr = 'primary';
                            if (res.show.terlambat == 0) {
                                stt = '<span class="badge text-bg-success p-1">TEPAT WAKTU</span>';
                            } else {
                                stt = '<span class="badge text-bg-danger p-1">TERLAMBAT</span>';
                            }
                        } else {
                            stt = '<span class="badge text-bg-warning p-1">TOLERANSI</span>';
                            if (res.show.jenis == 3) {
                                tx = 'Ijin';
                                clr = 'warning';
                            } else {
                                if (res.show.jenis == 4) {
                                    tx = 'Dinas Luar';
                                    clr = 'info';
                                } else {
                                    tx = 'OnCall';
                                    clr = 'danger';
                                }
                            }
                        }
                        $('#show_jenis_detail').addClass(`text-bg-${clr}`).text(tx);
                        // INIT CONTENT
                        var parts_in = res.show.tgl_in.split(' '); // pisah berdasarkan spasi
                        date_in = parts_in[0]; // "2025-04-04"
                        time_in = parts_in[1]; // "20:00:00"
                        if (res.show.tgl_out) {
                            var parts_out = res.show.tgl_out.split(' ');
                            date_out = parts_out[0]; // "2025-04-04"
                            time_out = parts_out[1]; // "20:00:00"
                        } else {
                            date_out = '-';
                            time_out = '-';
                        }
                        $('#tampil-tbody-detail').empty().append(`
                            <tr>
                                <th class="text-start">Bukti Foto</th>
                                <td>
                                    <a href="https://absensi.simrsmu.com/api/kepegawaian/detail/foto/${res.show.id}/1" data-lightbox="gallery" data-title="Bukti Foto Absensi (${res.show.foto_in?res.show.foto_in:'-'})" style="width:500px;height:500px">
                                        <img src="https://absensi.simrsmu.com/api/kepegawaian/detail/foto/${res.show.id}/1" class="img-fluid m-b-10" alt="" style="width:500px;height:500px">
                                    </a>
                                </td>
                                <td>
                                    <a href="https://absensi.simrsmu.com/api/kepegawaian/detail/foto/${res.show.id}/0" data-lightbox="gallery" data-title="Bukti Foto Absensi (${res.show.foto_out?res.show.foto_out:'-'})" style="width:500px;height:500px">
                                        <img src="https://absensi.simrsmu.com/api/kepegawaian/detail/foto/${res.show.id}/0" class="img-fluid m-b-10" alt="" style="width:500px;height:500px">
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-start">Lokasi</th>
                                <td><a href="https://www.google.com/maps?q=${res.show.lokasi_in}" target="_blank" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true"
                                    title="Klik disini untuk melihat Lokasi Berangkat">${res.show.lokasi_in}</a></td>
                                <td>${res.show.lokasi_out?`<a href="https://www.google.com/maps?q=${res.show.lokasi_out}" target="_blank" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true"
                                    title="Klik disini untuk melihat Lokasi Pulang">`+res.show.lokasi_out+'</a>':'-'}</td>
                            </tr>
                            <tr>
                                <th class="text-start">Tanggal Absen</th>
                                <td>${moment(date_in).format('dddd, D MMMM YYYY')}</td>
                                <td>${res.show.tgl_out?moment(date_out).format('dddd, D MMMM YYYY'):'-'}</td>
                            </tr>
                            <tr>
                                <th class="text-start">Waktu/Jam Absen</th>
                                <td data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true"
                                    title="Referensi Berangkat Pukul ${moment(res.show.ref_jam_masuk).format('HH:mm:ss')}">${time_in}</td>
                                <td data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true"
                                    title="Referensi Pulang Pukul ${moment(res.show.ref_jam_pulang).format('HH:mm:ss')}">${time_out}</td>
                            </tr>
                            <tr>
                                <th class="text-start">Total Waktu Bekerja</th>
                                <td colspan="2">${res.show.selisih_jam?res.show.selisih_jam:'-'}</td>
                            </tr>
                            <tr>
                                <th class="text-start">Keterlambatan</th>
                                <td colspan="2" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true"
                                    title="Toleransi Keterlambatan 10 Menit">${res.show.keterlambatan?res.show.keterlambatan:''} ${stt}</td>
                            </tr>
                            <tr>
                                <th class="text-start">Lembur</th>
                                <td colspan="2">${res.show.lembur?res.show.lembur:'-'}</td>
                            </tr>
                            <tr>
                                <th class="text-start">Keterangan</th>
                                <td colspan="2">${res.show.keterangan?res.show.keterangan:'Tidak Ada.'}</td>
                            </tr>
                        `);
                        // INIT MAP
                        // tampilMapIn(res.show.lokasi_in);
                        // if (res.show.lokasi_out) {
                        //     tampilMapOut(res.show.lokasi_out);
                        // }
                        $('[data-bs-toggle="tooltip"]').tooltip({
                            trigger: 'hover'
                        })
                        $('#modalDetail').modal('show');
                    } else {
                        iziToast.error({
                            title: 'Pesan Galat!',
                            message: 'Data Absensi Tidak Valid. Hubungi Administrator!',
                            position: 'topRight'
                        });
                    }
                },
                error: function(res) {
                    if (res.responseJSON && res.responseJSON.message) {
                        iziToast.error({
                            title: 'Pesan Galat!',
                            message: res.responseJSON.message,
                            position: 'topRight'
                        });
                    } else {
                        alert('Terjadi kesalahan.');
                    }
                }
            })
        }

        function ubah(id) {
            $("#tx_ubah_absensi").text('ID # '+id);
            $("#id_ubah_absensi").val(id);
            $.ajax(
            {
                url: "/api/kepegawaian/absensi/"+id+"/ubah",
                type: 'GET',
                dataType: 'json',
                success: function(res) {
                    if (res.show.jenis == 1) {
                        $("#id_ubah_absensi").val(id);
                        $("#shift_ubah").find('option').remove();
                        $("#shift_ubah").append('<option value="" hidden>Pilih</option>');
                        res.shift.forEach(item => {
                            $("#shift_ubah").append(`
                                <option value="${item.id}" ${res.show.kd_shift==item.singkat?"selected":""}>${item.shift} (${item.singkat}) = ${item.berangkat} - ${item.pulang}</option>
                            `);
                        })
                        $("#shift_ubah").append(`
                            <option value="L">LIBUR (L)</option>
                            <option value="C">CUTI TAHUNAN (C)</option>
                            <option value="CM">CUTI MELAHIRKAN (CM)</option>
                            <option value="CU">CUTI UMROH (CU)</option>
                            <option value="CH">CUTI HAJI (CH)</option>
                            <option value="CD">CUTI DILUAR TANGGUNGAN (CD)</option>
                        `);
                        $('#masuk_ubah').val(res.show.tgl_in);
                        if (res.show.tgl_out) {
                            $('#pulang_ubah').val(res.show.tgl_out).prop('disabled',false);
                            $('#cek_pulang').prop('disabled',true);
                        } else {
                            $('#pulang_ubah').val('').prop('disabled',true);
                            $('#cek_pulang').prop('disabled',false);
                        }
                        if (res.show.keterangan) {
                            $('#ket_ubah').val(res.show.keterangan).prop('disabled',false);
                        } else {
                            $('#ket_ubah').val('').prop('disabled',true);
                        }
                        $('#modalUbah').modal('show');

                        // JIKA INGIN ISI JAM ABSEN PULANG
                        $('#cek_pulang').on('change', function() {
                            if ($(this).is(':checked')) {
                                // Checkbox dicentang
                                $('#pulang_ubah').val('').prop('disabled',false);
                            } else {
                                // Checkbox tidak dicentang
                                $('#pulang_ubah').val('').prop('disabled',true);
                            }
                        });
                    } else {
                        iziToast.warning({
                            title: 'Pesan Ambigu!',
                            message: 'Perubahan data absensi berlaku hanya jika Pegawai tsb Absensi Jaga Shift saja. Khusus Ijin / Dinas Luar hanya bisa dilakukan Penghapusan oleh Kepala SDI.',
                            position: 'topRight'
                        });
                    }
                },
                error: function(res) {
                    iziToast.error({
                        title: 'Pesan Galat!',
                        message: 'Pengambilan Data Absensi (ID#'+id+') gagal dilakukan. Coba lagi.',
                        position: 'topRight'
                    });
                }
            })
        }

        function prosesUbah() {
            $("#btn-ubah-absensi").prop('disabled', true);
            $("#btn-ubah-absensi").find("i").removeClass("fa-edit").addClass("fa-sync fa-spin");

            var save = new FormData();
            var id = $('#id_ubah_absensi').val();
            save.append('id',id);
            save.append('shift',$('#shift_ubah').val());
            save.append('masuk',$('#masuk_ubah').val());
            save.append('pulang',$('#pulang_ubah').val());
            save.append('ket',$('#ket_ubah').val());
            save.append('user',"{{ Auth::user()->id }}");

            if (
                save.get('shift') == ""   ||
                save.get('masuk') == ""
            ) {
                iziToast.warning({
                    title: 'Pesan Ambigu!',
                    message: 'Pastikan Anda tidak mengosongi semua isian Wajib',
                    position: 'topRight'
                });
            } else {
                // AJAX request
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "/api/kepegawaian/absensi/"+id+"/ubah/proses",
                    method: 'post',
                    data: save,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(res){
                        if (res.code == 200) {
                            notifier.show(
                                "Pesan Sukses!", "Perubahan Data Absensi berhasil dilakukan pada "+res.message,
                                "success", "{{ asset('images/notification/ok-48.png') }}", 4e3
                            );
                            $('#modalUbah').modal('hide');
                            filter();
                        } else {
                            notifier.show(
                                "Warning Code " + res.code, res.message,
                                "warning", "{{ asset('images/notification/medium_priority-48.png') }}", 4e3
                            );
                        }
                    },
                    error: function(res){
                        console.log("error : " + JSON.stringify(res) );
                        notifier.show(
                            res.statusText + " (Code " + res.status + ")", res.responseText,
                            "danger", "{{ asset('images/notification/high_priority-48.png') }}", 4e3
                        );
                    }
                });
            }

            $("#btn-ubah-absensi").find("i").removeClass("fa-sync fa-spin").addClass("fa-edit");
            $("#btn-ubah-absensi").prop('disabled', false);
        }

        function hapus(id) {
            $("#id_hapus_absensi").val(id);
            $("#tx_hapus_absensi").text(id);
            var inputs = document.getElementById('setujuhapusabsensi');
            inputs.checked = false;
            $('#modalHapus').modal('show');
        }

        function prosesHapus() {
            var id = $("#id_hapus_absensi").val();
            // SWITCH BTN
            var checkbox = $('#setujuhapusabsensi').is(":checked");
            if (checkbox == false) {
                iziToast.error({
                    title: 'Pesan Galat!',
                    message: 'Mohon menyetujui (Check) untuk dilakukan proses penghapusan Data Record Absensi ID#'+id+' tersebut',
                    position: 'topRight'
                });
            } else {
                // PROSES
                $.ajax({
                    url: "/api/kepegawaian/absensi/"+id+"/hapus/{{ Auth::user()->id }}",
                    type: 'GET',
                    dataType: 'json',
                    success: function(res) {
                        iziToast.success({
                            title: 'Pesan Sukses!',
                            message: 'Penghapusan Data Absensi ID#'+id+' telah berhasil pada '+res,
                            position: 'topRight'
                        });
                        $('#modalHapus').modal('hide');
                        filter();
                    },
                    error: function(res) {
                        iziToast.error({
                            title: 'Pesan Galat!',
                            message: 'Penghapusan Data Absensi gagal dilakukan. Coba lagi.',
                            position: 'topRight'
                        });
                    }
                });
            }
        }

        function tampilMapIn(lokasi) {
            // Tampil MAP
            if (map_in) {
                map_in.remove();
            }
            var lat,long;// Creating a promise out of the function
            var arr = lokasi.split(", ");
            console.log(arr);
            lat = arr[0];
            long = arr[1];
            map_in = L.map('map_in',{
                keyboard: false,
                zoomControl: false,
                boxZoom: false,
                doubleClickZoom: false,
                tap: false,
                touchZoom: false,
                enableHighAccuracy: true,
                scrollWheelZoom: false,
                dragging: false,
                doubleClickZoom: false,
            }).setView([lat, long], 18);

            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxNativeZoom:16,
                minZoom:16,
                maxZoom:16
                // attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map_in);

            var marker = new L.Marker([lat, long]);
            // marker.addTo(map_in).bindPopup("<center>Titik Lokasi Anda<br><b class='text-danger'>"+lokasi+"</b></center>").openPopup();
            marker.addTo(map_in).openPopup();
        }

        function tampilMapOut(lokasi) {
            if (map_out) {
                map_out.remove(); // beda instance!
            }
            var arr = lokasi.split(", ");
            var lat = arr[0];
            var long = arr[1];

            map_out = L.map('map_out', {
                keyboard: false,
                zoomControl: false,
                boxZoom: false,
                doubleClickZoom: false,
                tap: false,
                touchZoom: false,
                enableHighAccuracy: true,
                scrollWheelZoom: false,
                dragging: false
            }).setView([lat, long], 18);

            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxNativeZoom:16,
                minZoom:16,
                maxZoom:16
            }).addTo(map_out);

            var marker = L.marker([lat, long]);
            marker.addTo(map_out).openPopup();
        }

        function clearInput() {
            // $('#filter_pilihan').val('').change();
            $('#filter_unit').val('').change();
            $('#filter_jenis').val('0');
            $('#filter_dari').val('').change();
            $('#filter_sampai').val('').change();
        }

        function getDateTime() {
            var now = new Date();
            var year = now.getFullYear();
            var month = now.getMonth() + 1;
            var day = now.getDate();
            if (month.toString().length == 1) {
                month = '0' + month;
            }
            if (day.toString().length == 1) {
                day = '0' + day;
            }
            var dateTime = year + '-' + month + '-' + day;
            return dateTime;
        }

        function toTime(waktu) {
            if (waktu == "00:00:00") {
                var hasil = '-';
            } else {
                var parts = waktu.split(':'); // pisah jadi array ['07','04','20']

                var hasil = parseInt(parts[0]) + 'j ' + parseInt(parts[1]) + 'm ' + parseInt(parts[2]) + 'd';
            }

            return hasil; // Output: "7j 4m 20d"
        }
    </script>
@endsection
