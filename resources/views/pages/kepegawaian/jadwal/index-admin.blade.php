@extends('layouts.index')

@section('content')

    {{-- FOR DROPDOWN BEHIND CARD --}}
    <style>
        /* .dropdown {
            transform-style: preserve-3d;
            transform: translate3d(0,0,10px) !important;
        } */
        .table-wrapper {
            overflow-x: auto;
            overflow-y: hidden;
            position: relative;
        }

        .table-wrapper table {
            width: max-content; /* agar scroll aktif jika table lebar */
        }
    </style>

    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i></a></li>
                        <li class="breadcrumb-item">Kepegawaian</li>
                        <li class="breadcrumb-item" aria-current="page">Jadwal Dinas</li>
                    </ul>
                </div>
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h2 class="mb-0">Daftar <b class="text-primary">Jadwal Dinas</b></h2>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- [ breadcrumb ] end -->
    <!-- [ Main Content ] start -->
    <div class="row pt-1">
        <div class="col-xl-12">
            <div class="card table-card">
                <div class="card-header d-flex align-items-center justify-content-between px-3 gap-2">
                    <h5 class="mb-0">Tabel Riwayat</h5>
                    <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                        <div class="input-group">
                            <input type="month" class="form-control" value="" placeholder="Pilih Bulan & Tahun" id="filterBulan" data-bs-toggle="tooltip"
                                data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true"
                                title="Pilih Bulan & Tahun"/>
                            <button class="btn btn-outline-primary" onclick="showRiwayat($('#filterBulan').val())" id="btn-cari" data-bs-toggle="tooltip"
                                data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true"
                                title="Filter Jadwal Dinas Berdasarkan Bulan & Tahun" disabled><i class="fas fa-search"></i></button>
                            <button class="btn btn-outline-warning" onclick="showRiwayat()" id="btn-refresh" data-bs-toggle="tooltip"
                                data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true"
                                title="Tampilkan Seluruh Jadwal Dinas"><i class="fas fa-sync"></i></button>
                            <button class="btn btn-outline-info dropdown-toggle" id="tombolMenu" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-sync fa-spin me-2"></i>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="tombolMenu">
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="dokumentasi()">Lihat Dokumentasi</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="tambah()">Tambah Jadwal Dinas</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{ route('kepegawaian.jadwaldinas.indexStaf') }}">Referensi Staf</a>
                                    <a class="dropdown-item" href="{{ route('kepegawaian.jadwaldinas.indexShift') }}">Referensi Jaga Shift</a>
                                    <a class="dropdown-item" href="{{ route('kepegawaian.jadwaldinas.indexLN') }}">Referensi Libur Nasional</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{ route('kepegawaian.jadwaldinas.indexBawahan') }}">
                                        Verifikasi Bawahan <span class="badge bg-danger ms-2" id="count-bawahan">0</span>
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <!-- Dropdown -->
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dttable" class="table table-hover dt-responsive align-middle">
                            <thead>
                                <tr>
                                    <th><center>#ID</center></th>
                                    <th>BLN / THN</th>
                                    <th>UNIT / STAF</th>
                                    <th>KETERANGAN</th>
                                    <th>STATUS</th>
                                    <th>DIPERBARUI</th>
                                </tr>
                            </thead>
                            <tbody id="tampil-tbody">
                                <tr>
                                    <td colspan="9" style="font-size:13px">
                                        <center><i class="fa fa-spinner fa-spin fa-fw"></i> Memproses data...</center>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th><center>#ID</center></th>
                                    <th>BLN / THN</th>
                                    <th>UNIT / STAF</th>
                                    <th>KETERANGAN</th>
                                    <th>STATUS</th>
                                    <th>DIPERBARUI</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                {{-- <div class="card-footer">

                </div> --}}
            </div>
        </div>
    </div>

    {{-- MODAL START --}}
    <div class="modal fade animate__animated animate__rubberBand" id="modalTambah" role="dialog" aria-labelledby="confirmFormLabel"aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        Form Tambah
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-secondary mb-3">
                        <small>
                            {{-- <i class="ti ti-arrow-narrow-right me-1"></i> <br> --}}
                            <i class="ti ti-arrow-narrow-right me-1"></i> Isian bertanda (<a class="text-danger">*</a>) berarti wajib diisi<br>
                            <i class="ti ti-arrow-narrow-right me-1"></i> Jadwal Dinas akan berstatus <span class="badge rounded-pill text-bg-warning">Pending</span> setelah pengajuan ini, maka dari itu segera lengkapi data jadwal dinas <br>
                            <i class="ti ti-arrow-narrow-right me-1"></i> Apabila pengajuan masih dalam status <b class="text-success">Verifikasi</b> masih dapat diubah namun Anda sudah tidak dapat menghapusnya (Konfirmasi atasan apabila diperlukan)<br>
                            <i class="ti ti-arrow-narrow-right me-1"></i> Pengajuan Jadwal Dinas yang telah di <b class="text-primary">Validasi</b> sudah tidak dapat diubah / hapus di kemudian waktu (Konfirmasi Kepegawaian apabila diperlukan)
                        </small>
                    </div>
                    <div class="position-relative mb-3">
                        <label class="form-label">Pilih Bulan dan Tahun <a class="text-danger">*</a></label>
                        <input type="month" class="form-control" value="" placeholder="" id="tgl" />
                    </div>
                    <div class="position-relative">
                        <label class="form-label">Keterangan</label>
                        <textarea class="form-control" id="ket" cols="30" rows="2" placeholder="Optional"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link-secondary" data-bs-dismiss="modal">Batalkan</button>
                    <button class="btn btn-primary" id="btn-tambah" onclick="prosesTambah()">Lanjutkan &nbsp;<i class="fa-fw fas fa-chevron-right nav-icon"></i></button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalLihat" role="dialog" aria-labelledby="confirmFormLabel"aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        Ditambahkan oleh <a class="text-primary" id="showUser"></a>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="tampil-jadwal">
                    <center><i class="fa fa-spinner fa-spin fa-fw"></i> Memproses data...</center>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btn-cetak" class="btn btn-link-primary me-sm-3 me-1"><i class="fa fa-print me-1" style="font-size:13px"></i> Cetak</button>
                    <button type="submit" id="btn-refresh-lihat" class="btn btn-link-warning me-sm-2"><i class="fa fa-sync me-1" style="font-size:13px"></i> Segarkan</button>
                    <button type="button" class="btn btn-link-secondary" data-bs-dismiss="modal">Tutup &nbsp;<i class="fa-fw fas fa-chevron-right nav-icon" style="font-size:13px"></i></button>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="modal fade animate__animated animate__rubberBand" id="modalDinasLuar" role="dialog" aria-labelledby="confirmFormLabel"aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        Form Pengajuan Dinas Luar
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                </div>
                <div class="col-12 text-center mb-4">
                    <button type="submit" id="btn-hapus" class="btn btn-danger me-sm-3 me-1" onclick="prosesHapus()"><i class="fa fa-trash me-1" style="font-size:13px"></i> Hapus</button>
                    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-times me-1" style="font-size:13px"></i> Batal</button>
                </div>
            </div>
        </div>
    </div> --}}
    {{-- FORM VERIF & BATAL VERIF --}}
    <div class="modal animate__animated animate__rubberBand fade" id="modalVerif" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-simple modal-add-new-address modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        Form Verif
                    </h4>
                </div>
                <div class="modal-body">
                    <input type="text" id="id_verif" hidden>
                    <p style="text-align: justify;">Anda akan melakukan verifikasi Jadwal Dinas tersebut, status akan berubah ke <kbd>DIVERIFIKASI</kbd>. Lakukanlah dengan hati-hati. Ceklis dibawah untuk melanjutkan pemrosesan data.</p>
                    <label class="switch">
                        <input type="checkbox" class="switch-input" id="setujuverif">
                        <span class="switch-toggle-slider">
                        <span class="switch-on"></span>
                        <span class="switch-off"></span>
                        </span>
                        <span class="switch-label">Anda siap menerima Risiko</span>
                    </label>
                </div>
                <div class="col-12 text-center mb-4">
                    <button type="submit" id="btn-verif" class="btn btn-success me-sm-3 me-1" onclick="prosesVerif()"><i class="fa fa-calendar-check me-1" style="font-size:13px"></i> Verifikasi</button>
                    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-times me-1" style="font-size:13px"></i> Batal</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal animate__animated animate__rubberBand fade" id="modalBatalVerif" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-simple modal-add-new-address modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        Form Batal Verif
                    </h4>
                </div>
                <div class="modal-body">
                    <input type="text" id="id_batal_verif" hidden>
                    <p style="text-align: justify;">Anda akan melakukan pembatalan verifikasi Jadwal Dinas tersebut, status akan berubah ke <kbd>PENDING</kbd>. Lakukanlah dengan hati-hati. Ceklis dibawah untuk melanjutkan pemrosesan data.</p>
                    <label class="switch">
                        <input type="checkbox" class="switch-input" id="setujubatalverif">
                        <span class="switch-toggle-slider">
                        <span class="switch-on"></span>
                        <span class="switch-off"></span>
                        </span>
                        <span class="switch-label">Anda siap menerima Risiko</span>
                    </label>
                </div>
                <div class="col-12 text-center mb-4">
                    <button type="submit" id="btn-batal-verif" class="btn btn-warning me-sm-3 me-1" onclick="prosesBatalVerif()"><i class="fa fa-calendar-check me-1" style="font-size:13px"></i> Batalkan Verifikasi</button>
                    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-times me-1" style="font-size:13px"></i> Batal</button>
                </div>
            </div>
        </div>
    </div>
    {{-- FORM VERIF & BATAL VALIDASI --}}
    <div class="modal animate__animated animate__rubberBand fade" id="modalValidasi" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-simple modal-add-new-address modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        Form Validasi
                    </h4>
                </div>
                <div class="modal-body">
                    <input type="text" id="id_validasi" hidden>
                    <p style="text-align: justify;">Anda akan melakukan validasi Jadwal Dinas tersebut, status akan berubah ke <kbd>DIVALIDASI</kbd>. Lakukanlah dengan hati-hati. Ceklis dibawah untuk melanjutkan pemrosesan data.</p>
                    <label class="switch">
                        <input type="checkbox" class="switch-input" id="setujuvalidasi">
                        <span class="switch-toggle-slider">
                        <span class="switch-on"></span>
                        <span class="switch-off"></span>
                        </span>
                        <span class="switch-label">Anda siap menerima Risiko</span>
                    </label>
                </div>
                <div class="col-12 text-center mb-4">
                    <button type="submit" id="btn-validasi" class="btn btn-primary me-sm-3 me-1" onclick="prosesValidasi()"><i class="fa fa-calendar-check me-1" style="font-size:13px"></i> Validasi</button>
                    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-times me-1" style="font-size:13px"></i> Batal</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal animate__animated animate__rubberBand fade" id="modalBatalValidasi" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-simple modal-add-new-address modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        Form Batal Validasi
                    </h4>
                </div>
                <div class="modal-body">
                    <input type="text" id="id_batal_validasi" hidden>
                    <p style="text-align: justify;">Anda akan melakukan pembatalan validasi Jadwal Dinas tersebut, status akan berubah ke <kbd>DIVERIFIKASI</kbd>. Lakukanlah dengan hati-hati. Ceklis dibawah untuk melanjutkan pemrosesan data.</p>
                    <label class="switch">
                        <input type="checkbox" class="switch-input" id="setujubatalvalidasi">
                        <span class="switch-toggle-slider">
                        <span class="switch-on"></span>
                        <span class="switch-off"></span>
                        </span>
                        <span class="switch-label">Anda siap menerima Risiko</span>
                    </label>
                </div>
                <div class="col-12 text-center mb-4">
                    <button type="submit" id="btn-batal-validasi" class="btn btn-warning me-sm-3 me-1" onclick="prosesBatalValidasi()"><i class="fa fa-calendar-check me-1" style="font-size:13px"></i> Batalkan Validasi</button>
                    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-times me-1" style="font-size:13px"></i> Batal</button>
                </div>
            </div>
        </div>
    </div>
    {{-- FORM HAPUS --}}
    <div class="modal animate__animated animate__rubberBand fade" id="modalHapus" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-simple modal-add-new-address modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        Form Hapus
                    </h4>
                </div>
                <div class="modal-body">
                    <input type="text" id="id_hapus" hidden>
                    <p style="text-align: justify;">Anda akan menghapus Jadwal Dinas tersebut, lakukanlah dengan hati-hati. Ceklis dibawah untuk melanjutkan penghapusan.</p>
                    <label class="switch">
                        <input type="checkbox" class="switch-input" id="setujuhapus">
                        <span class="switch-toggle-slider">
                        <span class="switch-on"></span>
                        <span class="switch-off"></span>
                        </span>
                        <span class="switch-label">Anda siap menerima Risiko</span>
                    </label>
                </div>
                <div class="col-12 text-center mb-4">
                    <button type="submit" id="btn-hapus" class="btn btn-danger me-sm-3 me-1" onclick="prosesHapus()"><i class="fa fa-trash me-1" style="font-size:13px"></i> Hapus</button>
                    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-times me-1" style="font-size:13px"></i> Batal</button>
                </div>
            </div>
        </div>
    </div>
    <div id="dokumentasi" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="dokumentasiLabel">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="dokumentasiLabel">Dokumentasi E-Absensi <span class="badge text-bg-info">Versi 3.1.0</span> | Diperbarui pada 26 Agustus 2025</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-3">
                    <div id="file-dokumentasi"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-success"
                        onclick="window.location.href='{{ url('/api/kepegawaian/dokumentasi/eabsensi/download') }}'">
                        Download
                    </button>

                </div>
            </div>
        </div>
    </div>
    {{-- FORM TOLAK & BATAL TOLAK --}}
    {{-- <div class="modal animate__animated animate__rubberBand fade" id="modalTolak" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-simple modal-add-new-address modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        Form Penolakan
                    </h4>
                </div>
                <div class="modal-body">
                    <input type="text" id="id_tolak" hidden>
                    <p style="text-align: justify;">Anda akan melakukan penolakan Jadwal Dinas tersebut, status akan berubah ke <kbd>DITOLAK</kbd>. Lakukanlah dengan hati-hati. Ceklis dibawah untuk melanjutkan pemrosesan data.</p>
                    <label class="switch">
                        <input type="checkbox" class="switch-input" id="setujutolak">
                        <span class="switch-toggle-slider">
                        <span class="switch-on"></span>
                        <span class="switch-off"></span>
                        </span>
                        <span class="switch-label">Anda siap menerima Risiko</span>
                    </label>
                </div>
                <div class="col-12 text-center mb-4">
                    <button type="submit" id="btn-tolak" class="btn btn-danger me-sm-3 me-1" onclick="prosesTolak()"><i class="fa fa-calendar-times me-1" style="font-size:13px"></i> Tolak</button>
                    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-times me-1" style="font-size:13px"></i> Tutup</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal animate__animated animate__rubberBand fade" id="modalBatalTolak" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-simple modal-add-new-address modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        Form Batal Penolakan
                    </h4>
                </div>
                <div class="modal-body">
                    <input type="text" id="id_batal_tolak" hidden>
                    <p style="text-align: justify;">Anda akan melakukan pembatalan penolakan Jadwal Dinas tersebut, status akan berubah ke <kbd>PENDING</kbd>. Lakukanlah dengan hati-hati. Ceklis dibawah untuk melanjutkan pemrosesan data.</p>
                    <label class="switch">
                        <input type="checkbox" class="switch-input" id="setujubataltolak">
                        <span class="switch-toggle-slider">
                        <span class="switch-on"></span>
                        <span class="switch-off"></span>
                        </span>
                        <span class="switch-label">Anda siap menerima Risiko</span>
                    </label>
                </div>
                <div class="col-12 text-center mb-4">
                    <button type="submit" id="btn-batal-verif" class="btn btn-danger me-sm-3 me-1" onclick="prosesBatalTolak()"><i class="fa fa-calendar-times me-1" style="font-size:13px"></i> Batalkan Penolakan</button>
                    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-times me-1" style="font-size:13px"></i> Tutup</button>
                </div>
            </div>
        </div>
    </div> --}}
    {{-- MODAL END --}}

    <script>
        $(document).ready(function() {
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

            $('#filterBulan').on('change', function() {
                if ($(this).val()) {
                    $('#btn-cari').prop('disabled', false); // aktifkan
                } else {
                    $('#btn-cari').prop('disabled', true); // nonaktifkan
                }
            });

            // $('.select2Tambah').select2({
            //     dropdownParent: $('#tambah')
            // });
            count();
            showRiwayat($('#filterBulan').val());
        });

        function count() {
            $.ajax({
                url: "/api/kepegawaian/jadwaldinas/bawahan/count/{{ Auth::user()->id }}",
                type: 'GET',
                dataType: 'json',
                success: function(res) {
                    if (res.jabatan) {
                        if (res.show) {
                            $('#tombolMenu').empty().html(`
                                Pilihan Menu
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill text-bg-danger">
                                    ${res.show} Data<span class="visually-hidden">unread messages</span>
                                </span>
                            `);
                            $('#count-bawahan').text(res.show+" Data");
                        } else {
                            $('#tombolMenu').empty().html(`
                                Pilihan Menu
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill text-bg-danger">
                                    0 Data<span class="visually-hidden">unread messages</span>
                                </span>
                            `);
                            $('#count-bawahan').text('0 Data');
                        }
                    } else {
                        $('#tombolMenu').empty().html(`Pilihan Menu`);
                        $('#count-bawahan').text('0 Data').prop('hidden',true);
                        $('#tombol-verif-bawahan').attr('href', 'javascript:void(0);').html('<s>Verifikasi Bawahan</s>'); // .removeAttr('href')
                    }
                }
            })
        }

        function tambah() {
            $('#modalTambah').modal('show');
        }

        function ubah(id) {
            $.ajax({
                url: "/api/kepegawaian/jadwaldinas/jadwal/"+id,
                type: 'GET',
                dataType: 'json',
                success: function(res) {
                    console.log(res.detail);
                    if(res.detail.length == 0) {
                        window.location.href = '/kepegawaian/jadwaldinas/tambah/'+res.jadwal.id;
                    } else {
                        window.location.href = '/kepegawaian/jadwaldinas/ubah/'+id;
                    }
                }
            })

        }

        function prosesTambah() {
            $("#btn-tambah").prop('disabled', true);
            $("#btn-tambah").find("i").toggleClass("fa-chevron-right fa-sync fa-spin");
            var regexBulan = /^\d{4}-(0[1-9]|1[0-2])$/;
            var tgl = $('#tgl').val();

            // Definisi
            var save = new FormData();
            save.append('tgl',$('#tgl').val());
            save.append('keterangan',$('#ket').val());
            save.append('pegawai','{{ Auth::user()->id }}');

            if (!tgl || !regexBulan.test(tgl)) {
                iziToast.warning({
                    title: 'Pesan Ambigu!',
                    message: 'Pastikan Anda memilih bulan dan tahun dengan benar (format = YYYY-MM)',
                    position: 'topRight'
                });
                $("#btn-tambah").find("i").removeClass("fa-sync fa-spin").addClass("fa-chevron-right");
                $("#btn-tambah").prop('disabled', false);
                return;
            } else {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{route('kepegawaian.jadwaldinas.storePengajuan')}}",
                    method: 'post',
                    data: save,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(res) {
                        if (res.code == 200) {
                            window.location.href = '/kepegawaian/jadwaldinas/tambah/'+res.message.id;
                        } else {
                            notifier.show(
                                "Pesan Galat!", res.message,
                                "warning", "{{ asset('images/notification/medium_priority-48.png') }}", 4e3
                            );
                        }
                        $("#btn-tambah").find("i").removeClass("fa-sync fa-spin").addClass("fa-chevron-right");
                        $("#btn-tambah").prop('disabled', false);
                    },
                    error: function (res) {
                        notifier.show(
                            res.statusText + " (Code " + res.status + ")", res.responseText,
                            "danger", "{{ asset('images/notification/high_priority-48.png') }}", 4e3
                        );
                        $("#btn-tambah").find("i").removeClass("fa-sync fa-spin").addClass("fa-chevron-right");
                        $("#btn-tambah").prop('disabled', false);
                    }
                });
            }
        }

        function showRiwayat(month) {
            $("#tampil-tbody").empty().append(`<tr style='font-size:13px'><td colspan="9"><center><i class="fa fa-spinner fa-spin fa-fw"></i> Memproses data...</center></td></tr>`);
            var regexBulan = /^\d{4}-(0[1-9]|1[0-2])$/;
            if (!regexBulan.test(month)) {
                url = "/api/kepegawaian/jadwaldinas/table";
                $('#filterBulan').val('');
            } else {
                url = "/api/kepegawaian/jadwaldinas/table/admin/"+month;
            }
            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                success: function(res) {
                    $("#tampil-tbody").empty();
                    $('#dttable').DataTable().clear().destroy();
                    res.show.forEach(item => {
                        // console.log(item);
                        var updet = new Date(item.updated_at).toLocaleDateString("sv-SE");
                        var date = new Date().toLocaleDateString("sv-SE");
                        var bulan = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                        if (item.progress == 0) {
                            var colButton = 'btn-light-dark';
                            var status = `<span class="badge rounded-pill text-bg-danger">Ditolak</span>`;
                        } else {
                            if (item.progress == 1) {
                                var colButton = 'btn-light-warning';
                                var status = `<span class="badge rounded-pill text-bg-warning">Pending</span>`;
                            } else {
                                if (item.progress == 2) {
                                    var colButton = 'btn-light-success';
                                    var status = `<span class="badge rounded-pill text-bg-success">Diverifikasi</span>`;
                                } else {
                                    if (item.progress == 3) {
                                        var colButton = 'btn-light-primary';
                                        var status = `<span class="badge rounded-pill text-bg-primary">Divalidasi</span>`;
                                    } else {
                                        var colButton = 'btn-light-dark';
                                        var status = `<span class="badge rounded-pill text-bg-info">Tidak Valid</span>`;
                                    }
                                }
                            }
                        }
                        content = "<tr id='data" + item.id + "' style='font-size:13px'>";
                        content += `<td><center><div class='btn-group'>
                                        <button type='button' class='btn btn-sm ${colButton} dropdown-toggle hide-arrow' data-bs-toggle='dropdown' aria-expanded='false' id='btnoptshow${item.id}'>`+item.id+`</button>
                                        <ul class='dropdown-menu dropdown-menu-right'>`;
                                            content += `<li><a href="javascript:void(0);" class="dropdown-item text-info" onclick="lihat(${item.id})"><i class="fa-fw fas fa-list-ol me-2"></i> Lihat</a></li>`;
                                            if (item.progress == 3) { // BELUM DIVERIFIKASI ATASAN
                                                content += `<li><a href="javascript:void(0);" class="dropdown-item" style="color: #cd26d9" onclick="printJadwal(${item.id})"><i class="fa fa-print me-2" style="font-size:13px"></i> Cetak</a></li>`;
                                            } else {
                                                content += `<li><a href="javascript:void(0);" class="dropdown-item text-secondary"><i class="fa fa-print me-2" style="font-size:13px"></i> Cetak</a></li>`;
                                            }
                                            if (item.progress == 1) { // BELUM DIVERIFIKASI ATASAN
                                                content += `<li><a href="javascript:void(0);" class="dropdown-item text-success" onclick="verif(${item.id})"><i class="fa-fw fas fa-calendar-check me-2"></i> Verif</a></li>`;
                                            } else {
                                                content += `<li><a href="javascript:void(0);" class="dropdown-item text-warning" onclick="batalVerif(${item.id})"><i class="fa-fw fas fa-calendar-times me-2"></i> Batal Verif</a></li>`;
                                            }
                                            if (item.progress == 2) { // SEBELUM VALIDASI / SUDAH DIVERIFIKASI ATASAN
                                                content += `<li><a href="javascript:void(0);" class="dropdown-item text-primary" onclick="validasi(${item.id})"><i class="fa-fw fas fa-calendar-check me-2"></i> Validasi</a></li>`;
                                                // content += `<li><a href="javascript:void(0);" class="dropdown-item text-danger" onclick="tolak(${item.id})"><i class="fa-fw fas fa-calendar-times me-2"></i> Tolak</a></li>`;
                                            } else { // SETELAH DIVALIDASI
                                                if (item.progress == 3) {
                                                    content += `<li><a href="javascript:void(0);" class="dropdown-item text-warning" onclick="batalValidasi(${item.id})"><i class="fa-fw fas fa-calendar-times me-2"></i> Batal Validasi</a></li>`;
                                                    // content += `<li><a href="javascript:void(0);" class="dropdown-item text-secondary"><i class="fa-fw fas fa-calendar-times me-2"></i> Tolak</a></li>`;
                                                } else { // BELUM DIVERIFIKASI OLEH ATASAN LANGSUNG
                                                    content += `<li><a href="javascript:void(0);" class="dropdown-item text-secondary"><i class="fa-fw fas fa-calendar-check me-2"></i> Validasi</a></li>`;
                                                    // content += `<li><a href="javascript:void(0);" class="dropdown-item text-warning" onclick="batalTolak(${item.id})"><i class="fa-fw fas fa-calendar-times me-2"></i> Batal Tolak</a></li>`;
                                                }
                                            }
                                            if ("{{ Auth::user()->id }}" == item.pegawai_id) {
                                                content += `<li><a href="javascript:void(0);" class="dropdown-item text-warning" onclick="ubah(${item.id})"><i class="fa-fw fas fa-calendar-alt me-2"></i> Ubah</a></li>`;
                                                content += `<li><a href='javascript:void(0);' class='dropdown-item text-danger' onclick="hapus(${item.id})"><i class="fa-fw fas fa-trash nav-icon"></i> Hapus</a></li>`;
                                            }
                        content += "</ul></div></center></td>";
                        for (let i = 1; i <= bulan.length; i++) {
                            if (i == item.bulan) {
                                content += `<td>${bulan[i]} ${item.tahun}</td>`;
                            }
                        }
                        // parse sekali aja
                        let staf = JSON.parse(item.staf);
                        let totalStaf = staf.length;

                        // ambil nama verifikator
                        let nama_verif = res.users.find(us => us.id == item.verif)?.nama ?? null;

                        // ambil daftar nama staf sesuai ID
                        let stafNames = res.users
                            .filter(us => staf.includes(us.id.toString())) // pastikan id ke string
                            .map(us => us.nama ?? `<b class="text-danger">${us.name}</b>`)
                            .join('; ');

                        // buat konten
                        content += `
                            <td style='white-space: normal !important; word-wrap: break-word;'>
                                <div class='d-flex justify-content-start align-items-center'>
                                    <div class='d-flex flex-column'>
                                        <h6 class='mb-0'>
                                            Unit ${item.unit ? `<b class="text-primary">${item.unit}</b>` : `<s class="text-danger">Tidak Valid</s>`}
                                            (<b class="text-danger">${totalStaf}</b> Pegawai)
                                        </h6>
                                        <small class='text-muted'>${stafNames}</small>
                                    </div>
                                </div>
                            </td>
                        `;
                        content += `<td style='white-space: normal !important;word-wrap: break-word;'>${item.keterangan?item.keterangan:''}</td>`;
                        content += `<td>${status}</td>`;
                        content += `<td style='white-space: normal !important;word-wrap: break-word;'>
                                        <div class='d-flex justify-content-start align-items-center'>
                                            <div class='d-flex flex-column'>
                                                <a class='mb-0'>` + new Date(item.updated_at).toLocaleString("sv-SE") + `</a>
                                                <small class='text-truncate text-muted'><b class='text-warning'>Ditambahkan</b> Oleh ` + item.nama_pegawai + `</small>
                                                ${item.nama_verif!=null?'<small class="text-truncate text-muted"><b class="text-success">Diverifikasi</b> Oleh '+item.nama_verif+'</small>':''}
                                                ${item.nama_valid!=null?'<small class="text-truncate text-muted"><b class="text-primary">Divalidasi</b> Oleh '+item.nama_valid+'</small>':''}
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
                            [5, "desc"]
                        ],
                        bAutoWidth: false,
                        aoColumns : [
                            { sWidth: '5%' },
                            { sWidth: '10%' },
                            { sWidth: '35%' },
                            { sWidth: '20%' },
                            { sWidth: '10%' },
                            { sWidth: '20%' },
                        ],
                        columnDefs: [
                            // { visible: false, targets: [7] },
                        ],
                        displayLength: 20,
                        lengthChange: true,
                        lengthMenu: [20, 35, 50, 75, 100, 300, 500, 1000],
                        // buttons: ['copy', 'excel', 'pdf', 'colvis']
                    });
                }
            })
        }

        function lihat(id) {
            $('#btnoptshow'+id).empty().append(`<i class="fa fa-spinner fa-spin fa-fw"></i>`);
            $("#tampil-jadwal").empty().append(`<center><i class="fa fa-spinner fa-spin fa-fw"></i> Memproses data...</center>`);
            $.ajax({
                url: "/api/kepegawaian/jadwaldinas/jadwal/"+id,
                type: 'GET',
                dataType: 'json',
                success: function(res) {
                    if (res.detail.length === 0) {
                        notifier.show(
                            "Pesan Galat!",
                            "Data isian Jadwal Dinas tidak ditemukan, silakan melengkapi jadwal terlebih dahulu (Klik Ubah)",
                            "warning",
                            "{{ asset('images/notification/medium_priority-48.png') }}",
                            4000
                        );
                        return;
                    }

                    $("#showUser").text(res.jadwal.nama_pegawai);
                    let n = 1;
                    let content = `
                        <h4 class="text-center mb-2">Jadwal Dinas Unit <b class="text-primary">${res.jadwal.unit}</b></h4>
                        <h5 class="text-center mb-2">Bulan <b class="text-primary">${res.bulan}</b> Tahun <b class="text-primary">${res.jadwal.tahun}</b></h5>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive p-10 pb-0">
                                    <table id="dttable" class="table table-bordered" style="width: 100%;table-layout: auto">
                                        <thead>
                                            <tr>
                                                <th class="text-center" rowspan="2">NO</th>
                                                <th class="text-center" rowspan="2">NAMA</th>
                                                <th class="text-center" colspan="${res.totalDay}">TANGGAL</th>
                                                <th class="text-center" rowspan="2">JAM KERJA (JAM)</th>
                                                <th class="text-center" colspan="${res.shift.length + 6}" style="background-color:#eaeeaf;border-top: 3px solid #eaeeaf;border-left: 3px solid #eaeeaf;border-right: 3px solid #eaeeaf;">JUMLAH SHIFT</th>
                                            </tr>
                                            <tr>`;

                    // Header tanggal
                    for (let i = 1; i <= res.totalDay; i++) {
                        let lnItem = res.ln.find(ln => ln.tgl === i);
                        let style = lnItem ? ` style="background-color: ${lnItem.color};"` : '';
                        content += `<th class="p-2 text-center tgl${i}"${style}>${i < 10 ? '0'+i : i}</th>`;
                    }

                    // Header shift
                    res.shift.forEach((s, index) => {
                        content += `<th class="p-2 text-center" ${index===0?"style='border-left: 3px solid #eaeeaf;'":""}>${s.singkat}</th>`;
                    });
                    ['L','C','CM','CU','CH','CD'].forEach((s, index, arr) => {
                        let border = (s==='CD') ? "style='border-right: 3px solid #eaeeaf;'" : '';
                        content += `<th class="p-2 text-center" ${border}>${s}</th>`;
                    });
                    content += `</tr></thead><tbody>`;

                    // Mapping shift -> jam kerja & inisialisasi shiftCounts
                    let shiftDurasi = {};
                    let shiftCounts = {};
                    res.shift.concat(['L','C','CM','CU','CH','CD']).forEach(s => {
                        shiftDurasi[s.singkat || s] = ['L','C','CM','CU','CH','CD'].includes(s.singkat || s) ? 0 :
                            (function() {
                                let start = new Date(`1970-01-01T${s.berangkat}`);
                                let end = new Date(`1970-01-01T${s.pulang}`);
                                if (end < start) end.setDate(end.getDate()+1);
                                return (end - start)/(1000*60*60);
                            })();
                        shiftCounts[s.singkat || s] = 0;
                    });

                    // Mapping jumlah per tanggal
                    let shifts = res.shift.map(s=>s.singkat).concat(['L','C','CM','CU','CH','CD']);
                    let tfootCounts = {};
                    for (let i=1;i<=res.totalDay;i++){
                        tfootCounts[i] = {};
                        shifts.forEach(s => tfootCounts[i][s]=0);
                    }
                    res.detail.forEach(pegawai => {
                        for (let i=1;i<=res.totalDay;i++){
                            let kodeShift = pegawai[`tgl${i}`];
                            if(kodeShift && tfootCounts[i][kodeShift]!==undefined) tfootCounts[i][kodeShift]++;
                        }
                    });

                    // LOOPING JADWAL DINAS
                    res.detail.forEach(pegawai => {
                        let pegawaiShiftCounts = {...shiftCounts};
                        for (let i=1;i<=res.totalDay;i++){
                            let kodeShift = pegawai[`tgl${i}`];
                            if(kodeShift && pegawaiShiftCounts[kodeShift]!==undefined) pegawaiShiftCounts[kodeShift]++;
                        }

                        content += `<tr class="text-center">
                                        <td style="background-color: ${pegawai.color}">${n++}</td>
                                        <td class="text-start" style="background-color: ${pegawai.color}">
                                            <div class='d-flex justify-content-start align-items-center'>
                                                <div class='d-flex flex-column'>
                                                    <h6 class='mb-0 clef'>${pegawai.pegawai_nama}</h6>
                                                    <small class='text-truncate text-muted clef'>${pegawai.jabatan || ''}</small>
                                                </div>
                                            </div>
                                        </td>`;

                        // tanggal
                        for (let i=1;i<=res.totalDay;i++){
                            let kodeShift = pegawai[`tgl${i}`]||'';
                            let lnItem = res.ln.find(ln => ln.tgl==i);
                            let style = lnItem ? ` style="background-color: ${lnItem.color};"` : '';
                            content += `<td class="p-2 tgl${i}"${style}>${kodeShift}</td>`;
                        }

                        // total jam kerja
                        let totalJamKerja = 0;
                        for (let i=1;i<=res.totalDay;i++){
                            let kodeShift = pegawai[`tgl${i}`];
                            if(kodeShift && shiftDurasi[kodeShift]) totalJamKerja += shiftDurasi[kodeShift];
                        }
                        content += `<td class="p-2">${totalJamKerja}</td>`;

                        // shift counts
                        res.shift.forEach((s,index)=>{
                            content += `<td class="p-2 text-center" ${index==0?"style='border-left: 3px solid #eaeeaf;'":""}>${pegawaiShiftCounts[s.singkat]}</td>`;
                        });
                        ['L','C','CM','CU','CH','CD'].forEach(s=>{
                            let border = (s==='CD') ? "style='border-right: 3px solid #eaeeaf;'" : '';
                            content += `<td class="p-2 text-center" ${border}>${pegawaiShiftCounts[s]}</td>`;
                        });

                        content += `</tr>`;
                    });

                    // tfoot
                    content += `<tfoot style="border:3px solid #eaeeaf;">`;
                    shifts.forEach((shift,index)=>{
                        content += `<tr>${index===0 ? `<th rowspan="${shifts.length}" style="writing-mode: vertical-rl; transform: rotate(180deg); text-align:center;background-color:#eaeeaf;">JUMLAH SHIFT</th>` : '' }
                                        <th>${shift}</th>`;
                        for (let i=1;i<=res.totalDay;i++){
                            content += `<td class="text-center">${tfootCounts[i][shift]}</td>`;
                        }
                        content += `</tr>`;
                    });
                    content += `</tfoot></table></div></div>`;

                    // Keterangan shift
                    content += `<div class="col-md-6"><div class="p-10"><h5>Shift Jaga :</h5><div class="list-group"><label class="list-group-item border-0 p-2"><ul>`;
                    res.shift.forEach(item=>{
                        content += `<li><b class="me-1">${item.singkat}</b>(<u>${item.shift}</u>) : ${item.berangkat.substring(0,5)} - ${item.pulang.substring(0,5)} WIB</li>`;
                    });
                    ['L','C','CM','CU','CH','CD'].forEach(s=>{
                        content += `<li><b class="me-1 text-danger">${s}</b>(<u class="text-danger">${s==='L'?'LIBUR':'CUTI'}</u>)</li>`;
                    });
                    content += `</ul></label></div></div></div>`;

                    // Keterangan warna
                    content += `<div class="col-md-6"><div class="p-10"><h5>Keterangan :</h5><div class="list-group">`;
                    content += `<label class="list-group-item border-0 p-1">
                                    <a class="btn btn-light me-2" style="background-color: #fed8b9" href="javascript:void(0);"></a>Hari Minggu
                                </label>`;
                    res.ln.forEach(item=>{
                        content += `<label class="list-group-item border-0 p-1">
                                        <a class="btn btn-light me-2" style="background-color: ${item.color}" href="javascript:void(0);"></a>
                                        ${item.deskripsi}${item.keterangan ? ' ('+item.keterangan+')' : ''} ${item.tgl ? ' - Tanggal '+item.tgl : ''}
                                    </label>`;
                    });
                    content += `</div></div></div>`;

                    $('#tampil-jadwal').empty().append(content);

                    // warna hari minggu
                    for (let i=0;i<res.totalDay;i++){
                        if(res.dataArray[i]==='Minggu'){
                            $('.tgl'+(i+1)).css('background-color','#fed8b9');
                        }
                    }

                    $('#btn-refresh-lihat').attr('onClick', `lihat(${id});`);
                    $('#btn-cetak').attr('onClick', `printJadwal(${id});`);
                    $('#modalLihat').modal('show');
                    $('#btnoptshow'+id).empty().text(id);
                },
                error: function(res) {
                    iziToast.error({
                        title: 'Pesan Galat!',
                        message: 'Jadwal Dinas gagal dimuat, silakan coba beberapa saat lagi',
                        position: 'topRight'
                    });
                }
            })
        }

        function printJadwal(id) {
            // Generate URL route Laravel
            const url = `/kepegawaian/jadwaldinas/${id}/cetak`;

            // Buka popup dengan ukuran 800x600, tanpa toolbar, scrollable
            const width = 800;
            const height = 600;
            const left = (screen.width/2) - (width/2); // posisi tengah layar
            const top = (screen.height/2) - (height/2);

            window.open(
                url,
                '_blank',
                `width=${width},height=${height},top=${top},left=${left},resizable=yes,scrollbars=yes`
            );
        }

        // SHOW DOKUMENTASI E-ABSENSI
        function dokumentasi() {
            fetch("/api/kepegawaian/dokumentasi/eabsensi")
            .then(response => {
                if (!response.ok) {
                    throw new Error('File dokumentasi tidak ditemukan atau gagal diambil.');
                }
                return response.blob();
            })
            .then(blob => {
                // Buat object URL dari blob
                const fileURL = URL.createObjectURL(blob);

                // Tampilkan ke iframe dalam modal
                $('#file-dokumentasi').empty().html(`<iframe src="${fileURL}" width="100%" height="500px" frameborder="0"></iframe>`);
                $('#dokumentasi').modal('show');
            })
            .catch(error => {
                iziToast.error({
                    title: 'Maaf!',
                    message: 'File Dokumentasi tidak ditemukan atau belum dipublikasi.',
                    position: 'topRight'
                });
                console.error(error);
            });
        }

        // VERIFIKASI
        function validasi(id) {
            $("#id_validasi").val(id);
            var inputs = document.getElementById('setujuvalidasi');
            inputs.checked = false;
            $('#modalValidasi').modal('show');
        }
        function batalValidasi(id) {
            $("#id_batal_validasi").val(id);
            var inputs = document.getElementById('setujubatalvalidasi');
            inputs.checked = false;
            $('#modalBatalValidasi').modal('show');
        }
        function verif(id) {
            $("#id_verif").val(id);
            var inputs = document.getElementById('setujuverif');
            inputs.checked = false;
            $('#modalVerif').modal('show');
        }
        function batalVerif(id) {
            $("#id_batal_verif").val(id);
            var inputs = document.getElementById('setujubatalverif');
            inputs.checked = false;
            $('#modalBatalVerif').modal('show');
        }

        function prosesValidasi() {
            // SWITCH BTN
            var checkbox = $('#setujuvalidasi').is(":checked");
            if (checkbox == false) {
                iziToast.error({
                    title: 'Pesan Galat!',
                    message: 'Mohon menyetujui untuk dilakukan validasi jadwal dinas tersebut',
                    position: 'topRight'
                });
            } else {
                // PROSES
                var id = $("#id_validasi").val();
                $.ajax({
                    url: "/api/kepegawaian/jadwaldinas/"+id+"/verif/{{ Auth::user()->id }}",
                    type: 'GET',
                    dataType: 'json',
                    success: function(res) {
                        iziToast.success({
                            title: 'Pesan Sukses!',
                            message: 'Jadwal Dinas telah berhasil divalidasi pada '+res,
                            position: 'topRight'
                        });
                        $('#modalValidasi').modal('hide');
                        showRiwayat($('#filterBulan').val());
                    },
                    error: function(res) {
                        iziToast.error({
                            title: 'Pesan Galat!',
                            message: 'Jadwal Dinas gagal divalidasi',
                            position: 'topRight'
                        });
                    }
                });
            }
        }
        function prosesBatalValidasi() {
            // SWITCH BTN
            var checkbox = $('#setujubatalvalidasi').is(":checked");
            if (checkbox == false) {
                iziToast.error({
                    title: 'Pesan Galat!',
                    message: 'Mohon menyetujui untuk dilakukan pembatalan validasi jadwal dinas tersebut',
                    position: 'topRight'
                });
            } else {
                // PROSES
                var id = $("#id_batal_validasi").val();
                $.ajax({
                    url: "/api/kepegawaian/jadwaldinas/"+id+"/batalverif/{{ Auth::user()->id }}",
                    type: 'GET',
                    dataType: 'json',
                    success: function(res) {
                        iziToast.success({
                            title: 'Pesan Sukses!',
                            message: 'Jadwal Dinas telah berhasil dibatalkan validasi pada '+res,
                            position: 'topRight'
                        });
                        $('#modalBatalValidasi').modal('hide');
                        showRiwayat($('#filterBulan').val());
                    },
                    error: function(res) {
                        iziToast.error({
                            title: 'Pesan Galat!',
                            message: 'Jadwal Dinas gagal batal validasi',
                            position: 'topRight'
                        });
                    }
                });
            }
        }
        function prosesVerif() {
            // SWITCH BTN
            var checkbox = $('#setujuverif').is(":checked");
            if (checkbox == false) {
                iziToast.error({
                    title: 'Pesan Galat!',
                    message: 'Mohon menyetujui untuk dilakukan verifikasi jadwal dinas tersebut',
                    position: 'topRight'
                });
            } else {
                // PROSES
                var id = $("#id_verif").val();
                $.ajax({
                    url: "/api/kepegawaian/jadwaldinas/bawahan/"+id+"/verif/{{ Auth::user()->id }}",
                    type: 'GET',
                    dataType: 'json',
                    success: function(res) {
                        iziToast.success({
                            title: 'Pesan Sukses!',
                            message: 'Jadwal Dinas telah berhasil diverifikasi pada '+res,
                            position: 'topRight'
                        });
                        $('#modalVerif').modal('hide');
                        showRiwayat($('#filterBulan').val());
                    },
                    error: function(xhr) {
                        // xhr.responseJSON berisi data JSON dari Laravel
                        iziToast.error({
                            title: 'Pesan Galat!',
                            message: xhr.responseJSON.message,
                            position: 'topRight'
                        });
                    }
                });
            }
        }
        function prosesBatalVerif() {
            // SWITCH BTN
            var checkbox = $('#setujubatalverif').is(":checked");
            if (checkbox == false) {
                iziToast.error({
                    title: 'Pesan Galat!',
                    message: 'Mohon menyetujui untuk dilakukan pembatalan verifikasi jadwal dinas tersebut',
                    position: 'topRight'
                });
            } else {
                // PROSES
                var id = $("#id_batal_verif").val();
                $.ajax({
                    url: "/api/kepegawaian/jadwaldinas/bawahan/"+id+"/batalverif/{{ Auth::user()->id }}",
                    type: 'GET',
                    dataType: 'json',
                    success: function(res) {
                        iziToast.success({
                            title: 'Pesan Sukses!',
                            message: 'Jadwal Dinas telah berhasil dibatalkan verifikasi pada '+res,
                            position: 'topRight'
                        });
                        $('#modalBatalVerif').modal('hide');
                        showRiwayat($('#filterBulan').val());
                    },
                    error: function(res) {
                        iziToast.error({
                            title: 'Pesan Galat!',
                            message: 'Jadwal Dinas gagal batal verifikasi',
                            position: 'topRight'
                        });
                    }
                });
            }
        }

        // PENOLAKAN
        // function tolak(id) {
        //     $("#id_tolak").val(id);
        //     var inputs = document.getElementById('setujutolak');
        //     inputs.checked = false;
        //     $('#modalTolak').modal('show');
        // }
        // function batalTolak(id) {
        //     $("#id_batal_tolak").val(id);
        //     var inputs = document.getElementById('setujubataltolak');
        //     inputs.checked = false;
        //     $('#modalBatalTolak').modal('show');
        // }

        // function prosesTolak() {
        //     // SWITCH BTN
        //     var checkbox = $('#setujutolak').is(":checked");
        //     if (checkbox == false) {
        //         iziToast.error({
        //             title: 'Pesan Galat!',
        //             message: 'Mohon menyetujui untuk dilakukan penolakan jadwal dinas tersebut',
        //             position: 'topRight'
        //         });
        //     } else {
        //         // PROSES
        //         var id = $("#id_tolak").val();
        //         $.ajax({
        //             url: "/api/kepegawaian/jadwaldinas/"+id+"/tolak/{{ Auth::user()->id }}",
        //             type: 'GET',
        //             dataType: 'json',
        //             success: function(res) {
        //                 iziToast.success({
        //                     title: 'Pesan Sukses!',
        //                     message: 'Jadwal Dinas telah berhasil ditolak pada '+res,
        //                     position: 'topRight'
        //                 });
        //                 $('#modalTolak').modal('hide');
        //                 showRiwayat();
        //             },
        //             error: function(res) {
        //                 iziToast.error({
        //                     title: 'Pesan Galat!',
        //                     message: 'Jadwal Dinas gagal ditolak',
        //                     position: 'topRight'
        //                 });
        //             }
        //         });
        //     }
        // }
        // function prosesBatalTolak() {
        //     // SWITCH BTN
        //     var checkbox = $('#setujubataltolak').is(":checked");
        //     if (checkbox == false) {
        //         iziToast.error({
        //             title: 'Pesan Galat!',
        //             message: 'Mohon menyetujui untuk dilakukan pembatalan penolakan jadwal dinas tersebut',
        //             position: 'topRight'
        //         });
        //     } else {
        //         // PROSES
        //         var id = $("#id_batal_tolak").val();
        //         $.ajax({
        //             url: "/api/kepegawaian/jadwaldinas/"+id+"/bataltolak/{{ Auth::user()->id }}",
        //             type: 'GET',
        //             dataType: 'json',
        //             success: function(res) {
        //                 iziToast.success({
        //                     title: 'Pesan Sukses!',
        //                     message: 'Jadwal Dinas telah berhasil dibatal tolak pada '+res,
        //                     position: 'topRight'
        //                 });
        //                 $('#modalBatalTolak').modal('hide');
        //                 showRiwayat();
        //             },
        //             error: function(res) {
        //                 iziToast.error({
        //                     title: 'Pesan Galat!',
        //                     message: 'Jadwal Dinas gagal dibatal tolak',
        //                     position: 'topRight'
        //                 });
        //             }
        //         });
        //     }
        // }

        function hapus(id) {
            $("#id_hapus").val(id);
            var inputs = document.getElementById('setujuhapus');
            inputs.checked = false;
            $('#modalHapus').modal('show');
        }

        function prosesHapus() {
            // SWITCH BTN HAPUS
            var checkboxHapus = $('#setujuhapus').is(":checked");
            if (checkboxHapus == false) {
                iziToast.error({
                    title: 'Pesan Galat!',
                    message: 'Mohon menyetujui untuk dilakukan penghapusan jadwal dinas tersebut',
                    position: 'topRight'
                });
            } else {
                // PROSES HAPUS
                var id = $("#id_hapus").val();
                $.ajax({
                    url: "/api/kepegawaian/jadwaldinas/"+id+"/hapus",
                    type: 'DELETE',
                    success: function(res) {
                        iziToast.success({
                            title: 'Pesan Sukses!',
                            message: 'Jadwal Dinas Anda telah berhasil dihapus pada '+res,
                            position: 'topRight'
                        });
                        $('#modalHapus').modal('hide');
                        showRiwayat($('#filterBulan').val());
                    },
                    error: function(res) {
                        iziToast.error({
                            title: 'Pesan Galat!',
                            message: 'Jadwal Dinas Anda gagal dihapus',
                            position: 'topRight'
                        });
                    }
                });
            }
        }
    </script>
@endsection
