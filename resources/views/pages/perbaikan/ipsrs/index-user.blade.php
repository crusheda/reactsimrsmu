@extends('layouts.index')

@section('content')
    {{-- Sistem Tracking --}}
    <link href="{{ asset('css/tracking.css') }}" rel="stylesheet" />

    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i></a></li>
                        <li class="breadcrumb-item">Pengaduan</li>
                        <li class="breadcrumb-item">Perbaikan</li>
                        <li class="breadcrumb-item" aria-current="page">IPSRS</li>
                    </ul>
                </div>
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h2 class="mb-0">Perbaikan IPSRS</h2>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- [ breadcrumb ] end -->

    <!-- [ Main Content ] start -->
    <div class="row pt-1">
        {{-- BARIS 1 --}}
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-1">{{ $list['total'] }}</h3>
                            <p class="text-muted mb-0">Total Pengaduan <b class="text-primary">Anda</b></p>
                        </div>
                        <div class="col-4 text-end"><i class="ti ti-license text-secondary f-36"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-1">-</h3>
                            <p class="text-muted mb-0">Total Dikerjakan</p>
                        </div>
                        <div class="col-4 text-end"><i class="ti ti-clock text-primary f-36"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-1">{{ $list['totalselesai'] }}</h3>
                            <p class="text-muted mb-0">Total Diselesaikan</p>
                        </div>
                        <div class="col-4 text-end"><i class="ti ti-clipboard-check text-success f-36"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-1">{{ $list['totalditolak'] }}</h3>
                            <p class="text-muted mb-0">Total Ditolak</p>
                        </div>
                        <div class="col-4 text-end"><i class="ti ti-file-shredder text-danger f-36"></i></div>
                    </div>
                </div>
            </div>
        </div>
        {{-- BARIS 2 --}}
        <div class="col-md-4">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between py-3">
                    <h5 class="mb-0 card-title flex-grow-1">Form Tambah</h5>
                </div>
                <div class="card-body">
                    <form method="POST" id="formTambah" action="{{ route('ipsrs.store') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="text" name="user_id" value="{{ Auth::user()->id }}" hidden>
                        <div class="form-group mb-3">
                            <label for="defaultFormControlInput" class="form-label">Lokasi <a class="text-danger">*</a></label>
                            <input type="text" name="lokasi" id="clr_lokasi"
                                class="form-control typeahead" placeholder="Teks Otomatis"
                                required />
                        </div>
                        <div class="form-group mb-3">
                            <label for="defaultFormControlInput" class="form-label">Pengaduan <a class="text-danger">*</a></label>
                            <div class="form-group">
                                <textarea rows="3" class="autosize1 form-control" name="pengaduan" id="clr_pengaduan"
                                    placeholder="Deskripsi Pengaduan Anda" required></textarea>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="defaultFormControlInput" class="form-label">Lampiran (<strong>Optional</strong>) : </label>
                            <input type="file" name="file" id="imgInp" class="form-control mb-3">
                            <div class="alert alert-secondary">
                                <small>
                                    <i class="fa-fw fas fa-caret-right nav-icon"></i> Disarankan untuk menyertakan lampiran foto <br>
                                    <i class="fa-fw fas fa-caret-right nav-icon"></i> Pastikan upload Foto/Gambar bukan Video, berformat <b>jpg,png,jpeg</b>
                                </small>
                            </div>
                            <center>
                                <div class="card" style="width: 18rem;margin-top:20px">
                                    <a class="image-popup-vertical-fit" id="blah_a" href="">
                                        <img class="card-img-top" id="blah" src="{{ asset('images/no-image.png') }}"
                                            alt="Tidak ada lampiran">
                                    </a>
                                </div>
                            </center>
                        </div>
                        <div class="d-flex justify-content-center" style="margin-bottom:-15px">
                            <div class="btn-group">
                                <button class="btn btn-primary" onclick="simpan()" id="btn-simpan" type="submit">
                                    <i class="fa-fw fas fa-save nav-icon"></i> Submit
                                </button>
                    </form>
                                <button class="btn btn-outline-warning" onclick="clearInp()" type="button">
                                    <i class="fa-fw fas fa-eraser nav-icon"></i>
                                </button>
                            </div>
                        </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            @if (count($list['recent']) > 0)
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between py-3">
                        <h5 class="mb-0 card-title flex-grow-1">Pengaduan Berjalan <span class="badge bg-secondary text-light">{{ count($list['recent']) }}</span></h5>
                    </div>
                    <div class="card-body"> {{-- data-simplebar style="max-height: 295px;" --}}
                        <div class="row" style="margin-bottom:-15px">
                            @if (empty($list['recent']))
                                <h6 class="text-center">Tidak ada</h6>
                            @else
                                @for ($i = 0; $i < count($list['recent']); $i++)
                                    <div class="col-12 mb-3">
                                        <div class="card shadow border mb-0">
                                            <div class="card-body p-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                        @if (!empty($list['recent'][$i]->filename_pengaduan))
                                                            <a class="image-popup-no-margins" href="{{ url('storage/' . substr($list['recent'][$i]->filename_pengaduan, 7, 1000)) }}" data-bs-toggle="tooltip" data-bs-offset="0,4"
                                                                data-bs-placement="bottom" data-bs-html="true" title="Klik untuk lihat lampiran">
                                                                <img class="img-fluid" alt="" src="{{ url('storage/' . substr($list['recent'][$i]->filename_pengaduan, 7, 1000)) }}" style="max-height: 1000px;width:3.5rem">
                                                            </a>
                                                        @else
                                                            <img class="img-fluid" alt="" src="{{ url("images/no-image.png") }}" style="width:3.5rem">
                                                        @endif
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <h6 class="mb-0">
                                                            {{ $list['recent'][$i]->lokasi }}&nbsp;
                                                            @if (!empty($list['recent'][$i]->tgl_selesai) && empty($list['recent'][$i]->ket_penolakan))
                                                                <span class="badge" style="background-color: turquoise">Selesai</span>
                                                            @elseif (!empty($list['recent'][$i]->ket_penolakan))
                                                                <span class="badge" style="background-color: red">Ditolak</span>
                                                            @elseif (empty($list['recent'][$i]->tgl_diterima))
                                                                <span class="badge" style="background-color: rebeccapurple">Diverifikasi</span>
                                                            @elseif (empty($list['recent'][$i]->tgl_dikerjakan))
                                                                <span class="badge" style="background-color: salmon">Diterima</span>
                                                            @elseif (empty($list['recent'][$i]->tgl_selesai))
                                                                <span class="badge" style="background-color: orange">Dikerjakan</span>
                                                            @endif
                                                        </h6>
                                                        <p class="mb-0">
                                                            <small>{{ $list['recent'][$i]->ket_pengaduan }} <br>
                                                            {{ \Carbon\Carbon::parse($list['recent'][$i]->tgl_pengaduan)->isoFormat('dddd, D MMMM Y, HH:mm a') }}</small>
                                                        </p>
                                                    </div>
                                                    <div class="flex-shrink-0">
                                                        <button class="btn btn-primary btn-sm align-middle" onclick="track({{ $list['recent'][$i]->id }})">
                                                            Lihat&nbsp;&nbsp;<span class="badge bg-light text-dark align-middle">ID : {{ $list['recent'][$i]->id }}</span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endfor
                            @endif
                        </div>
                    </div>
                </div>
            @endif
            <div class="card table-card">
                <div class="card-header d-flex align-items-center justify-content-between py-3">
                    <h5 class="mb-0 card-title flex-grow-1">Riwayat Pengaduan <a class="text-primary">IPSRS</a></h5>
                    <div class="flex-shrink-0">
                        <div class="btn-group">
                            <button type="button" class="btn btn-light-warning" id="btn-refresh" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true"
                                title="Refresh Tabel Riwayat Pengaduan IPSRS" onclick="refresh()">
                                <i class="fa-fw fas fa-sync nav-icon me-1"></i> Refresh</button>
                            <button type="button" class="btn btn-light-danger border-0" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true"
                                title="Tampilkan Semua Data" onclick="showAll()" disabled>
                                <i class="fa-fw fas fa-infinity nav-icon me-1"></i> All</button>
                            {{-- <button type="button" class="btn btn-outline-secondary" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true"
                                title="Informasi Sistem Disposisi" disabled>
                                <i class="fa-fw fas fa-info nav-icon me-1"></i><s>Informasi</s></button> --}}
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="alert alert-secondary m-2">
                        <small>
                            <i class="ti ti-arrow-narrow-right text-primary me-1"></i> Data default yang ditampilkan dibatasi <b>100 data</b> pengaduan terakhir saja <br>
                            <i class="ti ti-arrow-narrow-right text-primary me-1"></i> Untuk menampilkan semua data, klik tombol <i class="fa-fw fas fa-infinity nav-icon text-danger"></i> di atas <br>
                            <i class="ti ti-arrow-narrow-right text-primary me-1"></i> Untuk sementara waktu, hak akses untuk <mark><b>Monitoring Pengaduan Per Unit/Bagian</b></mark> hanya dapat dilakukan oleh Atasan Langsung
                        </small>
                    </div>
                    <div class="table-responsive">
                        <table id="dttable" class="table dt-responsive table-hover nowrap w-100 align-middle">
                            <thead>
                                <tr>
                                    <th>#ID</th>
                                    <th>LOKASI</th>
                                    <th><center>STATUS</center></th>
                                    <th>TGL PENGADUAN</th>
                                </tr>
                            </thead>
                            <tbody id="tampil-tbody">
                                <tr>
                                    <td colspan="5" style="font-size:13px"><center><i class="fa fa-spinner fa-spin fa-fw"></i> Memproses data...</center></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>#ID</th>
                                    <th>LOKASI</th>
                                    <th><center>STATUS</center></th>
                                    <th>TGL PENGADUAN</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL START --}}
    <div class="modal fade" id="modalUbah" data-bs-backdrop="static" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ubah Data <kbd>ID : <a id="show_id"></a></kbd></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <input type="text" id="id_edit" hidden>
                    <div class="alert alert-secondary">
                        <small>
                            Apabila laporan sudah berada pada status <kbd style="background-color: salmon">DITERIMA</kbd> oleh IPSRS,
                            anda tidak dapat lagi mengubah ataupun menghapus laporan ini.
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <label for="defaultFormControlInput" class="form-label">Lokasi <a class="text-danger">*</a></label>
                        <input type="text" id="lokasi_edit" class="form-control typeahead"
                            placeholder="Masukkan Lokasi" autocomplete="off" required />
                    </div>
                    <div class="form-group mb-3">
                        <label for="defaultFormControlInput" class="form-label">Pengaduan <a class="text-danger">*</a></label>
                        <div class="form-group">
                            <textarea rows="3" class="autosize1 form-control" id="pengaduan_edit" placeholder="Deskripsi Pengaduan Anda" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary pull-right" onclick="prosesUbah()"><i
                            class="fa-fw fas fa-save nav-icon"></i> Simpan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i
                            class="fa-fw fas fa-times nav-icon"></i> Tutup</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal animate__animated animate__rubberBand fade" id="modalHapus" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-simple modal-add-new-address modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        Hapus Pengaduan&nbsp;&nbsp;&nbsp;
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="text" id="id_hapus" hidden>
                    <p style="text-align: justify;">Anda akan menghapus pengaduan <kbd>ID:<strong><a id="show_id_hapus"></a></strong></kbd> tersebut. Lakukanlah dengan hati-hati. Ceklis dibawah untuk melanjutkan penghapusan.</p>
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
    <div class="modal fade" id="modalTrack" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tracking <kbd>ID : <a id="show_id_track"></a></kbd></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="bg-white p-2 border rounded px-3">
                                <div class="justify-content-between align-items-center">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 mb-2">
                                            <i class="ti ti-corner-up-right text-primary me-1"></i> <b>Pengaduan oleh <a id="track_oleh" class="text-primary"></a></b>
                                        </div>
                                        <div class="flex-grow-1">
                                            <span class="float-end">Pada tgl. <b><a id="track_tgl_pengaduan" class="text-warning"></a></b></span>
                                        </div>
                                    </div>
                                </div>
                                <div id="track_dot"></div>
                                <hr>
                                <p id="track_pengaduan"></p>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped display">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>TGL</th>
                                    <th>KETERANGAN</th>
                                </tr>
                            </thead>
                            <tbody style="text-transform: capitalize" id="tampil-tbody-track">
                                <tr>
                                    <td colspan="5" style="font-size:13px"><center><i class="fa fa-spinner fa-spin fa-fw"></i> Memproses data...</center></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="alert alert-secondary">
                        <small><b># Klik tombol Status <kbd class="bg-primary text-light">DIKERJAKAN</kbd> untuk melihat detail Status Pengerjaan</b></small>
                    </div>
                    <div class="collapse" id="showDikerjakan">
                        <div class="card table-card">
                            <div class="card-header d-flex align-items-center justify-content-between py-3">
                                <h5 class="mb-0 card-title flex-grow-1"><i class="fa-fw fas fa-caret-right nav-icon me-1"></i> Tabel Status <a class="text-primary">Dikerjakan</a></h5>
                            </div>
                            <div class="card-body p-b-0">
                                <div class="table-responsive">
                                    <table class="table table-striped display">
                                        <thead>
                                            <tr>
                                                <th>TGL</th>
                                                <th>KETERANGAN</th>
                                                <th>
                                                    <center>LAMPIRAN</center>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody style="font-size:13px" id="tampil-tbody-catatan">
                                            <tr>
                                                <td colspan="5" style="font-size:13px"><center><i class="fa fa-spinner fa-spin fa-fw"></i> Memproses data...</center></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><i
                            class="fa-fw fas fa-times nav-icon"></i> Tutup</button>
                </div>
            </div>
        </div>
    </div>
    {{-- MODAL END --}}

    {{-- <script src="https://twitter.github.io/typeahead.js/releases/latest/typeahead.bundle.js"></script> --}}
    <script>
        $(document).ready(function() {
            // AUTOCOMPLETE LOKASI
            var path = "{{ route('ipsrs.ac.lokasi') }}";
            $('.typeahead').typeahead({
                source: function(query, process) {
                    return $.get(path, {
                        lokasi: query
                    }, function(data) {
                        return process(data);
                    });
                }
            });

            // SELECT PICKER
            var t = $(".select2");
            t.length && t.each(function() {
                var e = $(this);
                e.wrap('<div class="position-relative"></div>').select2({
                    placeholder: "Pilih",
                    dropdownParent: e.parent()
                })
            })

            // initialize
            refresh();
        });

        // FUNCTION
        function refresh() {
            $("#tampil-tbody").empty().append(
                `<tr><td colspan="20" style="font-size: 13px"><center><i class="fa fa-spinner fa-spin fa-fw"></i> Memproses data...</center></td></tr>`
            );
            $.ajax({
                url: "/api/perbaikan/ipsrs/user/table/{{ Auth::user()->id }}",
                type: 'GET',
                dataType: 'json',
                success: function(res) {
                    $("#tampil-tbody").empty();
                    $('#dttable').DataTable().clear().destroy();
                    var date = new Date().toLocaleDateString('en-ZA');
                    res.show.forEach(item => {
                        var updet = new Date(item.updated_at).toLocaleDateString('en-ZA');
                        var status = '';
                        if (item.tgl_selesai != null && item.ket_penolakan == null) {
                            status = '<td><center><kbd style="background-color: turquoise">Selesai</kbd></center></td>';
                        } else {
                            if (item.ket_penolakan != null) {
                                status = '<td><center><kbd style="background-color: red">Ditolak</kbd></center></td>';
                            } else {
                                if (item.tgl_diterima == null) {
                                    status = '<td><center><kbd style="background-color: rebeccapurple">Diverifikasi</kbd></center></td>';
                                } else {
                                    if (item.tgl_dikerjakan == null) {
                                        status = '<td><center><kbd style="background-color: salmon">Diterima</kbd></center></td>';
                                    } else {
                                        if (item.tgl_selesai == null) {
                                            status = '<td><center><kbd style="background-color: orange">Dikerjakan</kbd></center></td>';
                                        } else {
                                            status = '<td><center><kbd style="background-color: dark">Tidak Ditemukan</kbd></center></td>';
                                        }
                                    }
                                }
                            }
                        }

                        content = `<tr><td><div class="d-flex align-items-center">
                                        <div class="dropdown">
                                            <a href="javascript:;" class="btn btn-sm btn-link dropdown-toggle hide-arrow" data-bs-toggle="dropdown">${item.id}</a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a href="javascript:;" onclick="track(${item.id})" class="dropdown-item text-primary"><i class='fas fa-search me-1'></i> Track</a>`;
                        if (item.tgl_selesai == null) {
                            if (item.tgl_diterima != null) {
                                content += `<a href="javascript:;" class="dropdown-item text-secondary disabled"><i class='fas fa-edit me-1'></i> Ubah</a>`;
                                if (item.filename_pengaduan != null || item.filename_pengaduan != '') {
                                    content += `<a href="javascript:;" onclick="showLampiran(${item.id})" class="dropdown-item text-info"><i class='fas fa-image me-1'></i> Lampiran</a>`;
                                } else {
                                    content += `<a href="javascript:;" class="dropdown-item text-secondary disabled"><i class='fas fa-image me-1'></i> Lampiran</a>`;
                                }
                                content += `<a href="javascript:;" class="dropdown-item text-secondary disabled"><i class='fas fa-trash-alt me-1'></i> Hapus</a>`;
                            } else {
                                content += `<a href="javascript:;" onclick="ubah(${item.id})" class="dropdown-item text-warning"><i class='fas fa-edit me-1'></i> Ubah</a>`;
                                if (item.filename_pengaduan != null || item.filename_pengaduan != '') {
                                    content += `<a href="javascript:;" onclick="showLampiran(${item.id})" class="dropdown-item text-info"><i class='fas fa-image me-1'></i> Lampiran</a>`;
                                } else {
                                    content += `<a href="javascript:;" class="dropdown-item text-secondary disabled"><i class='fas fa-image me-1'></i> Lampiran</a>`;
                                }
                                content += `<a href="javascript:;" onclick="hapus(${item.id})" class="dropdown-item text-danger"><i class='fas fa-trash-alt me-1'></i> Hapus</a>`;
                            }
                        } else {
                            content += `<a href="javascript:;" class="dropdown-item text-secondary disabled"><i class='fas fa-edit me-1'></i> Ubah</a>`;
                            if (item.filename_pengaduan != null || item.filename_pengaduan != '') {
                                content += `<a href="javascript:;" onclick="showLampiran(${item.id})" class="dropdown-item text-info"><i class='fas fa-image me-1'></i> Lampiran</a>`;
                            } else {
                                content += `<a href="javascript:;" class="dropdown-item text-secondary disabled"><i class='fas fa-image me-1'></i> Lampiran</a>`;
                            }
                            content += `<a href="javascript:;" class="dropdown-item text-secondary disabled"><i class='fas fa-trash-alt me-1'></i> Hapus</a>`;
                        }
                        content += `</div></div></div></td>`;
                        // LANJUT CONTENT
                        content += `<td style='white-space: normal !important;word-wrap: break-word;'>
                                        <div class='d-flex justify-content-start align-items-center'>
                                            <div class='d-flex flex-column'>
                                                <h6 class='mb-0'><a href="javascript:void(0);" class="text-dark"><u data-bs-toggle="tooltip"
                                                    data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="Lokasi Perbaikan">${item.lokasi}</u></a>
                                                </h6>
                                                <small class='text-truncate text-muted'>Oleh ${item.nama_pegawai}</small>
                                            </div>
                                        </div>
                                    </td>`;
                        // content += `<td>${item.lokasi}</td>`;
                        content += status;
                        content += `<td>`+new Date(item.tgl_pengaduan).toLocaleString("sv-SE")+`</td></tr>`;
                        $('#tampil-tbody').append(content);
                    })

                    var table = $('#dttable').DataTable({
                        // dom: 'Bfrtip',
                        order: [
                            [3, "desc"]
                        ],
                        bAutoWidth: false,
                        aoColumns : [
                            { sWidth: '10%' },
                            { sWidth: '50%' },
                            { sWidth: '20%' },
                            { sWidth: '20%' },
                        ],
                        // columnDefs: [
                        //     { visible: false, targets: [7] },
                        // ],
                        displayLength: 10,
                        lengthChange: true,
                        lengthMenu: [10, 25, 50, 75, 100],
                        buttons: ['copy', 'excel', 'pdf', 'colvis']
                    });

                    // Showing Tooltip
                    $('[data-bs-toggle="tooltip"]').tooltip({
                        trigger: 'hover'
                    })
                }
            })
        }

        function track(id) {
            $('#show_id_track').text(id);
            $.ajax(
            {
                url: "/api/perbaikan/ipsrs/user/track/"+id,
                type: 'GET',
                dataType: 'json', // added data type
                success: function(res) {
                    $('#track_pengaduan').empty().append(`<a class="text-primary"><u>Keterangan</u></a> : `+res.show.ket_pengaduan);
                    $('#track_oleh').text(res.show.nama);
                    $('#track_tgl_pengaduan').text(new Date(res.show.tgl_pengaduan).toLocaleString('fr-FR'));
                    var content = '';
                    var content2 = '';
                    var content3 = '';
                    $('#track_dot').empty();
                    if (res.show.tgl_selesai != null && res.show.ket_penolakan == null) { // Selesai
                        content = `<div class="d-flex flex-row justify-content-between align-items-center align-content-center">
                                        <span class="dot"></span>
                                        <hr class="flex-fill track-line"><span class="dot"></span>
                                        <hr class="flex-fill track-line"><span class="dot"></span>
                                        <hr class="flex-fill track-line"><span class="d-flex justify-content-center align-items-center big-dot dot"><i class="fa fa-check text-white"></i></span>
                                    </div>
                                    <div class="d-flex flex-row justify-content-between align-items-center">
                                        <div class="d-flex flex-column align-items-start">
                                            <span>${res.show.tgl_pengaduan?new Date(res.show.tgl_pengaduan).toLocaleDateString('en-ZA'):''}</span><span>Pengaduan</span>
                                        </div>
                                        <div class="d-flex flex-column justify-content-center">
                                            <span>${res.show.tgl_diterima?new Date(res.show.tgl_diterima).toLocaleDateString('en-ZA'):''}</span><span>Diterima</span>
                                        </div>
                                        <div class="d-flex flex-column justify-content-center align-items-center">
                                            <span>${res.show.tgl_dikerjakan?new Date(res.show.tgl_dikerjakan).toLocaleDateString('en-ZA'):''}</span><span>Dikerjakan</span>
                                        </div>
                                        <div class="d-flex flex-column align-items-center">
                                            <span>${res.show.tgl_selesai?new Date(res.show.tgl_selesai).toLocaleDateString('en-ZA'):''}</span><span>Selesai</span>
                                        </div>
                                    </div>`;
                    } else {
                        if (res.show.ket_penolakan != null) { // Ditolak
                            content = `<div class="d-flex flex-row justify-content-between align-items-center align-content-center">
                                            <span class="dot-ditolak"></span>
                                            <hr class="flex-fill track-line-ditolak"><span class="dot-ditolak"></span>
                                            <hr class="flex-fill track-line-ditolak"><span class="dot-ditolak"></span>
                                            <hr class="flex-fill track-line-ditolak"><span class="d-flex justify-content-center align-items-center big-dot-ditolak dot-ditolak"><i class="fa fa-times text-white"></i></span>
                                        </div>
                                        <div class="d-flex flex-row justify-content-between align-items-center">
                                            <div class="d-flex flex-column align-items-start"></div>
                                            <div class="d-flex flex-column justify-content-center"></div>
                                            <div class="d-flex flex-column justify-content-center align-items-center">
                                            </div>
                                            <div class="d-flex flex-column align-items-center">
                                                <span>${res.show.tgl_selesai?new Date(res.show.tgl_selesai).toLocaleDateString('en-ZA'):''}</span><span>Ditolak</span>
                                            </div>
                                        </div>`;
                        } else {
                            if (res.show.tgl_diterima == null) { // Diverifikasi
                                content = `<div class="d-flex flex-row justify-content-between align-items-center align-content-center">
                                                <span class="d-flex justify-content-center align-items-center big-dot dot"><i class="fa fa-check text-white"></i></span>
                                                <hr class="flex-fill"><span class="dot"></span>
                                                <hr class="flex-fill"><span class="dot"></span>
                                                <hr class="flex-fill"><span class="dot"></span>
                                            </div>
                                            <div class="d-flex flex-row justify-content-between align-items-center">
                                                <div class="d-flex flex-column align-items-start">
                                                    <span>${res.show.tgl_pengaduan?new Date(res.show.tgl_pengaduan).toLocaleDateString('en-ZA'):''}</span><span>Pengaduan</span>
                                                </div>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <span>-</span><span>Diterima</span>
                                                </div>
                                                <div class="d-flex flex-column justify-content-center align-items-center">
                                                    <span>-</span><span>Dikerjakan</span>
                                                </div>
                                                <div class="d-flex flex-column align-items-center">
                                                    <span>-</span><span>Selesai</span>
                                                </div>
                                            </div>`;
                            } else {
                                if (res.show.tgl_dikerjakan == null) { // Diterima
                                    content = `<div class="d-flex flex-row justify-content-between align-items-center align-content-center">
                                                    <span class="dot"></span>
                                                    <hr class="flex-fill track-line"><span class="d-flex justify-content-center align-items-center big-dot dot"><i class="fa fa-check text-white"></i></span>
                                                    <hr class="flex-fill"><span class="dot"></span>
                                                    <hr class="flex-fill"><span class="dot"></span>
                                                </div>
                                                <div class="d-flex flex-row justify-content-between align-items-center">
                                                    <div class="d-flex flex-column align-items-start">
                                                        <span>${res.show.tgl_pengaduan?new Date(res.show.tgl_pengaduan).toLocaleDateString('en-ZA'):''}</span><span>Pengaduan</span>
                                                    </div>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <span>${res.show.tgl_diterima?new Date(res.show.tgl_diterima).toLocaleDateString('en-ZA'):''}</span><span>Diterima</span>
                                                    </div>
                                                    <div class="d-flex flex-column justify-content-center align-items-center">
                                                        <span>-</span><span>Dikerjakan</span>
                                                    </div>
                                                    <div class="d-flex flex-column align-items-center">
                                                        <span>-</span><span>Selesai</span>
                                                    </div>
                                                </div>`;
                                } else {
                                    if (res.show.tgl_selesai == null) { // Dikerjakan
                                        content = `<div class="d-flex flex-row justify-content-between align-items-center align-content-center">
                                                        <span class="dot"></span>
                                                        <hr class="flex-fill track-line"><span class="dot"></span>
                                                        <hr class="flex-fill track-line"><span class="d-flex justify-content-center align-items-center big-dot dot"><i class="fa fa-check text-white"></i></span>
                                                        <hr class="flex-fill"><span class="dot"></span>
                                                    </div>
                                                    <div class="d-flex flex-row justify-content-between align-items-center">
                                                        <div class="d-flex flex-column align-items-start">
                                                            <span>${res.show.tgl_pengaduan?new Date(res.show.tgl_pengaduan).toLocaleDateString('en-ZA'):''}</span><span>Pengaduan</span>
                                                        </div>
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <span>${res.show.tgl_diterima?new Date(res.show.tgl_diterima).toLocaleDateString('en-ZA'):''}</span><span>Diterima</span>
                                                        </div>
                                                        <div class="d-flex flex-column justify-content-center align-items-center">
                                                            <span>${res.show.tgl_dikerjakan?new Date(res.show.tgl_dikerjakan).toLocaleDateString('en-ZA'):''}</span><span>Dikerjakan</span>
                                                        </div>
                                                        <div class="d-flex flex-column align-items-center">
                                                            <span>-</span><span>Selesai</span>
                                                        </div>
                                                    </div>`;
                                    } else {
                                        alert('Tracking Tidak Ditemukan!!');
                                    }
                                }
                            }
                        }
                    }
                    $('#track_dot').append(content);
                    $('#tampil-tbody-track').empty();
                    if (res.show.ket_penolakan == null) {
                        content2 = `<tr style="font-size: 13px">
                                        <th><i class="fa-fw fas fa-caret-right nav-icon me-1"></i> STATUS DITERIMA</th>
                                        <td>
                                            ${res.show.tgl_diterima?new Date(res.show.tgl_diterima).toLocaleDateString('en-ZA'):''}
                                        </td>
                                        <td>${res.show.ket_diterima?res.show.ket_diterima:''}</td>
                                    </tr>
                                    <tr style="font-size: 13px">
                                        <th>
                                            <button class="btn btn-link btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#showDikerjakan">
                                                <i class="fa-fw fas fa-caret-right nav-icon me-1"></i> <b>STATUS PENGERJAAN</b>
                                            </button>
                                        </th>
                                        <td>
                                            ${res.show.tgl_dikerjakan?new Date(res.show.tgl_dikerjakan).toLocaleDateString('en-ZA'):''}
                                        </td>
                                        <td>${res.show.ket_dikerjakan?res.show.ket_dikerjakan:''}</td>
                                    </tr>
                                    <tr style="font-size: 13px">
                                        <th><i class="fa-fw fas fa-caret-right nav-icon me-1"></i> STATUS SELESAI</th>
                                        <td>
                                            ${res.show.tgl_selesai?new Date(res.show.tgl_selesai).toLocaleDateString('en-ZA'):''}
                                        </td>
                                        <td>${res.show.ket_selesai?res.show.ket_selesai:''}</td>
                                    </tr>`;
                    } else {
                        content2 = `<tr style="font-size: 13px">
                                        <th class="text-danger"><i class="fa-fw fas fa-caret-right nav-icon me-1"></i> STATUS DITOLAK</th>
                                        <td>
                                            ${res.show.tgl_selesai?new Date(res.show.tgl_selesai).toLocaleDateString('en-ZA'):''}
                                        </td>
                                        <td>${res.show.ket_penolakan?res.show.ket_penolakan:''}</td>
                                    </tr>`;
                    }
                    $('#tampil-tbody-track').append(content2);
                    $('#tampil-tbody-catatan').empty();
                    if (res.catatan != null && res.catatan != '') {
                        res.catatan.forEach(val => {
                            content3 = `<tr style="font-size: 13px">
                                            <td>${val.created_at?val.created_at:''}</td>
                                            <td>${val.keterangan?val.keterangan:''}</td>
                                            <td>
                                                <center>
                                                        <button class="btn btn-success btn-sm" onclick="${val.title?"window.location.href='perbaikan/ipsrs/lampiran/catatan/"+val.id+"'":''}" ${val.title?'':'disabled'}>
                                                            <i class="fa-fw fas fa-download nav-icon"></i>
                                                        </button>
                                                </center>
                                            </td>
                                        </tr>`;
                            $('#tampil-tbody-catatan').append(content3);
                        });
                    } else {
                        content3 = `<tr style="font-size: 13px">
                                        <td colspan="3"><center>Belum ada catatan pengerjaan</center></td>
                                    </tr>`;
                        $('#tampil-tbody-catatan').append(content3);
                    }
                }
            })
            $('#modalTrack').modal('show');
        }

        function ubah(id) {
            $('#show_id').text(id);
            $('#id_edit').val(id);
            $.ajax(
            {
                url: "/api/perbaikan/ipsrs/user/ubah/"+id,
                type: 'GET',
                dataType: 'json', // added data type
                success: function(res) {
                    $('#lokasi_edit').val(res.show.lokasi);
                    $('#pengaduan_edit').val(res.show.ket_pengaduan);
                    $('#modalUbah').modal('show');
                }
            })
        }

        function prosesUbah() {
            var fd = new FormData();
            fd.append('id',$("#id_edit").val());
            fd.append('lokasi',$("#lokasi_edit").val());
            fd.append('pengaduan',$("#pengaduan_edit").val());
            fd.append('user','{{ Auth::user()->id }}');

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: 'POST',
                url: "{{ route('ipsrs.user.prosesUbah') }}",
                data: fd,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(res) {
                    iziToast.success({
                        title: 'Sukses!',
                        message: 'Ubah Pengaduan berhasil pada '+ res,
                        position: 'topRight'
                    });
                    if (res) {
                        $('#modalUbah').modal('hide');
                        refresh();
                    }
                },
                error: function (res) {
                    iziToast.error({
                        title: 'Pesan Galat!',
                        message: res.responseJSON.error,
                        position: 'topRight'
                    });
                }
            });
        }

        function hapus(id) {
            $('#show_id_hapus').text(id);
            $("#id_hapus").val(id);
            $('#modalHapus').modal('show');
        }

        function prosesHapus() {
            // SWITCH BTN HAPUS
            var checkboxHapus = $('#setujuhapus').is(":checked");
            if (checkboxHapus == false) {
                iziToast.error({
                    title: 'Pesan Galat!',
                    message: 'Mohon menyetujui untuk dilakukan penghapusan Pengaduan',
                    position: 'topRight'
                });
            } else {
                // PROSES HAPUS
                var id = $("#id_hapus").val();
                $.ajax({
                    url: "/api/perbaikan/ipsrs/user/hapus/"+id,
                    type: 'DELETE',
                    success: function(res) {
                        iziToast.success({
                            title: 'Pesan Sukses!',
                            message: 'Pengaduan telah berhasil dihapus pada '+res,
                            position: 'topRight'
                        });
                        $('#modalHapus').modal('hide');
                        refresh();
                        // window.location.reload();
                    },
                    error: function(res) {
                        iziToast.error({
                            title: 'Pesan Galat!',
                            message: 'Aset gagal dihapus',
                            position: 'topRight'
                        });
                    }
                });
            }
        }

        function showLampiran(id) {
            Swal.fire({
                // title: 'Lampiran ID : '+id,
                // text: '',
                imageUrl: '/perbaikan/ipsrs/' + id,
                // imageWidth: 400,
                heightAuto: true,
                imageHeight: 275,
                imageAlt: 'Lampiran',
                reverseButtons: true,
                showDenyButton: false,
                showCloseButton: true,
                showCancelButton: true,
                cancelButtonText: `<i class="fa fa-times me-1" style="font-size:13px"></i> Tutup`,
                confirmButtonText: `<i class="fa fa-download"></i> Download`,
                backdrop: `rgba(26,27,41,0.8)`,
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "/perbaikan/ipsrs/" + id;
                }
            })
        }

        function simpan() {
            $("#formTambah").one('submit', function() {
                //stop submitting the form to see the disabled button effect
                $("#btn-simpan").attr('disabled', 'disabled');
                $("#btn-simpan").find("i").toggleClass("fa-save fa-spinner fa-spin");

                return true;
            });
        }

        function clearInp() {
            $("#clr_lokasi").val('');
            $("#clr_pengaduan").val('');
            $("#imgInp").val('');
            $('#blah_a').attr('href', '');
            document.getElementById("blah").src = '{{ url("images/no-image.png") }}';
            iziToast.success({
                title: 'Yeayy!',
                message: 'Form Tambah berhasil dibersihkan',
                position: 'topRight'
            });
        }

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#blah_a').attr('href', e.target.result);
                    $('#blah').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#imgInp").change(function() {
            readURL(this);
        });

        // function riwayat() {
        //     window.location.href = "/v2/laporan/pengaduan/ipsrs/riwayat";
        // }
    </script>
@endsection
