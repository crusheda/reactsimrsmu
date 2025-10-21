@extends('layouts.index')

@section('content')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i></a></li>
                        <li class="breadcrumb-item">Kepegawaian</li>
                        <li class="breadcrumb-item">Rekrutmen</li>
                        <li class="breadcrumb-item" aria-current="page">Pengumuman</li>
                    </ul>
                </div>
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h2 class="mb-0">Daftar Lowongan Kerja</h2>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- [ breadcrumb ] end -->

    <!-- [ Main Content ] start -->
    <div class="row pt-1">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between py-3">
                    <h5 class="mb-0">Table</h5>
                    <div class="btn-group">
                        <button type="button" class="btn btn-warning" onclick="refresh()"><i class="fa-fw fas fa-sync nav-icon"></i></button>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambah"><i class="fa-fw fas fa-plus-square nav-icon"></i>&nbsp;&nbsp;Tambah Loker</button>
                        <button type="button" class="btn btn-info" onclick="window.location='{{ route('kepegawaian.rekrutmen.indexRegistrasi') }}'"><i class="fa-fw fas fa-users nav-icon"></i>&nbsp;&nbsp;Lihat Peserta</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="alert alert-secondary mb-3">
                        <small>
                            <i class="fa-fw fas fa-caret-right nav-icon"></i> Hapus Lowongan Kerja digunakan HANYA apabila lowongan salah/dibatalkan <br>
                            <i class="fa-fw fas fa-caret-right nav-icon"></i> Lowongan akan tampil pada Website RS setelah input pada rentang tanggal dibuka sampai ditutup <br>
                        </small>
                    </div>
                    <div class="table-responsive">
                        <table id="dttable" class="table table-hover dt-responsive align-middle">
                            <thead>
                                <tr>
                                    <th class="cell-fit">AKSI</th>
                                    <th class="cell-fit">LOWONGAN KERJA</th>
                                    <th class="cell-fit">DIBUKA</th>
                                    <th class="cell-fit">DITUTUP</th>
                                    <th class="cell-fit">KUALIFIKASI</th>
                                    <th class="cell-fit">JML PENDAFTAR</th>
                                    <th class="cell-fit">PERSYARATAN</th>
                                    <th class="cell-fit">TUGAS</th>
                                    <th class="cell-fit">KEAHLIAN</th>
                                    <th class="cell-fit">KETERANGAN</th>
                                    <th class="cell-fit">STATUS</th>
                                    <th class="cell-fit">DIPERBARUI</th>
                                </tr>
                            </thead>
                            <tbody id="tampil-tbody">
                                <tr>
                                    <td colspan="15" style="font-size:13px">
                                        <center><i class="fa fa-spinner fa-spin fa-fw"></i> Memproses data...</center>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th class="cell-fit">AKSI</th>
                                    <th class="cell-fit">LOWONGAN KERJA</th>
                                    <th class="cell-fit">DIBUKA</th>
                                    <th class="cell-fit">DITUTUP</th>
                                    <th class="cell-fit">KUALIFIKASI</th>
                                    <th class="cell-fit">JML PENDAFTAR</th>
                                    <th class="cell-fit">PERSYARATAN</th>
                                    <th class="cell-fit">TUGAS</th>
                                    <th class="cell-fit">KEAHLIAN</th>
                                    <th class="cell-fit">KETERANGAN</th>
                                    <th class="cell-fit">STATUS</th>
                                    <th class="cell-fit">DIPERBARUI</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL START --}}
    <div class="modal fade bd-example-modal-lg" id="tambah" role="dialog" aria-labelledby="confirmFormLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        Tambah Lowongan Pekerjaan
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <div class="alert alert-secondary">
                                <small>
                                    <i class="fa-fw fas fa-caret-right nav-icon"></i> Tanda <a class="text-danger">*</a> berarti isian <b>Wajib</b> diisi<br>
                                    <i class="fa-fw fas fa-caret-right nav-icon"></i> Pastikan <b>Tgl Buka Lowongan</b> tidak lebih dari <b>Tgl Tutup Lowongan</b><br>
                                    <i class="fa-fw fas fa-caret-right nav-icon"></i> Disarankan untuk menggunakan <b>Huruf Besar/Capital/Uppercase</b> saat pengisian
                                </small>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="form-group">
                                <label class="form-label">Buka Lowongan <a class="text-danger">*</a></label>
                                <input type="date" id="mulai" value="" class="form-control notnull">
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="form-group">
                                <label class="form-label">Tutup Lowongan <a class="text-danger">*</a></label>
                                <input type="date" id="selesai" value="" class="form-control notnull">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label class="form-label">Penempatan / Unit Kerja</label>
                                <input type="text" id="unit" value="" class="form-control" placeholder="e.g. IT">
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label class="form-label">Nama Kebutuhan <a class="text-danger">*</a></label>
                                <input type="text" id="nama" value="" class="form-control notnull" placeholder="e.g. IT Support">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label class="form-label">Umur Minimal <a class="text-danger">*</a></label>
                                <input type="number" id="umur_min" value="" class="form-control notnull" placeholder="e.g. 20">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label class="form-label">Umur Maksimal <a class="text-danger">*</a></label>
                                <input type="number" id="umur_max" value="" class="form-control notnull" placeholder="e.g. 35">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label class="form-label">Jumlah Kebutuhan <a class="text-danger">*</a></label>
                                <input type="number" id="jumlah" value="" class="form-control notnull" placeholder="e.g. 5">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label class="form-label">Maksimal Kuota Pendaftar</label>
                                <input type="number" id="kuota" value="" class="form-control" placeholder="e.g. 100">
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label class="form-label">Jenjang Pendidikan <a class="text-danger">*</a></label>
                                <select class="select-multiple form-select notnull" name="pendidikan[]" id="pendidikan" data-allow-clear="true" data-bs-auto-close="outside" style="width: 100%" required multiple>
                                    {{-- <option value="" selected>Pilih</option> --}}
                                    @if(count($list['pendidikan']) > 0)
                                        @foreach($list['pendidikan'] as $item)
                                            <option value="{{ $item->id }}">{{ "[".$item->kategori."] ".$item->nama }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label class="form-label">Uraian Tugas <a class="text-danger">*</a></label>
                                <textarea id="tugas" rows="4" class="form-control notnull" placeholder="e.g. Pengelolaan infrastruktur teknologi, keamanan data pasien, pemeliharaan sistem informasi rumah sakit, serta memberikan dukungan teknis dan integrasi antar sistem untuk mendukung pelayanan medis yang efisien."></textarea>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label class="form-label">Keahlian <a class="text-danger">*</a></label>
                                <textarea id="keahlian" rows="4" class="form-control notnull" placeholder="e.g. keamanan siber untuk melindungi data pasien, manajemen jaringan untuk memastikan konektivitas yang stabil, serta pemrograman untuk pengembangan dan pemeliharaan perangkat lunak. Selain itu, kemampuan dalam memberikan support teknis, manajemen sistem informasi rumah sakit, dan analisis data juga penting untuk mendukung kelancaran operasional dan meningkatkan kualitas layanan medis."></textarea>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label class="form-label">Persyaratan <a class="text-danger">*</a></label>
                                <textarea id="persyaratan" rows="4" class="form-control notnull" placeholder="e.g. Muslim (Laki-laki), usia max 30th, memiliki sertifikat ahli K3 umum/K3RS, manajemen resiko, mampu berkomunikasi dengan baik, sehat jasmani & rohani, mampu bekerjasama dalam tim, menguasai analisa/pengolahan/penyajian data dalam komputer"></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Keterangan</label>
                                <textarea id="keterangan" rows="2" class="form-control notnull" placeholder="Optional"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="prosesSimpan()" id="btn-simpan"><i class="fa-fw fas fa-save nav-icon"></i> Submit</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i
                            class="fa-fw fas fa-times nav-icon"></i> Tutup</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade bd-example-modal-lg" id="ubah" role="dialog" aria-labelledby="confirmFormLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        Ubah Lowongan Pekerjaan <span class="badge badge-bg-secondary">ID#<b id="show_id_edit"></b></span>
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="text" class="form-control" id="id_edit" hidden>
                        <div class="col-md-12">
                            <div class="alert alert-secondary">
                                <small>
                                    <i class="fa-fw fas fa-caret-right nav-icon"></i> Tanda <a class="text-danger">*</a> berarti isian <b>Wajib</b> diisi<br>
                                    <i class="fa-fw fas fa-caret-right nav-icon"></i> Pastikan <b>Tgl Buka Lowongan</b> tidak lebih dari <b>Tgl Tutup Lowongan</b><br>
                                    <i class="fa-fw fas fa-caret-right nav-icon"></i> Disarankan untuk menggunakan <b>Huruf Besar/Capital/Uppercase</b> saat pengisian
                                </small>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label class="form-label">Token</label>
                                <textarea type="text" class="form-control" id="token_edit" rows="2" disabled></textarea>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="form-group">
                                <label class="form-label">Buka Lowongan <a class="text-danger">*</a></label>
                                <input type="date" id="mulai_edit" value="" class="form-control notnull_edit">
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="form-group">
                                <label class="form-label">Tutup Lowongan <a class="text-danger">*</a></label>
                                <input type="date" id="selesai_edit" value="" class="form-control notnull_edit">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label class="form-label">Penempatan / Unit Kerja</label>
                                <input type="text" id="unit_edit" value="" class="form-control" placeholder="e.g. IT">
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label class="form-label">Nama Kebutuhan <a class="text-danger">*</a></label>
                                <input type="text" id="nama_edit" value="" class="form-control notnull_edit" placeholder="e.g. IT Support">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label class="form-label">Umur Minimal <a class="text-danger">*</a></label>
                                <input type="number" id="umur_min_edit" value="" class="form-control notnull_edit" placeholder="e.g. 20">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label class="form-label">Umur Maksimal <a class="text-danger">*</a></label>
                                <input type="number" id="umur_max_edit" value="" class="form-control notnull_edit" placeholder="e.g. 35">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label class="form-label">Jumlah Kebutuhan <a class="text-danger">*</a></label>
                                <input type="number" id="jumlah_edit" value="" class="form-control notnull_edit" placeholder="e.g. 5">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label class="form-label">Maksimal Kuota Pendaftar</label>
                                <input type="number" id="kuota_edit" value="" class="form-control" placeholder="e.g. 100">
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label class="form-label">Jenjang Pendidikan <a class="text-danger">*</a></label>
                                <select class="select-multiple form-select notnull_edit" name="pendidikan_edit[]" id="pendidikan_edit" data-allow-clear="true" data-bs-auto-close="outside" style="width: 100%" required multiple></select>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label class="form-label">Uraian Tugas <a class="text-danger">*</a></label>
                                <textarea id="tugas_edit" rows="4" class="form-control notnull_edit" placeholder="e.g. Pengelolaan infrastruktur teknologi, keamanan data pasien, pemeliharaan sistem informasi rumah sakit, serta memberikan dukungan teknis dan integrasi antar sistem untuk mendukung pelayanan medis yang efisien."></textarea>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label class="form-label">Keahlian <a class="text-danger">*</a></label>
                                <textarea id="keahlian_edit" rows="4" class="form-control notnull_edit" placeholder="e.g. keamanan siber untuk melindungi data pasien, manajemen jaringan untuk memastikan konektivitas yang stabil, serta pemrograman untuk pengembangan dan pemeliharaan perangkat lunak. Selain itu, kemampuan dalam memberikan support teknis, manajemen sistem informasi rumah sakit, dan analisis data juga penting untuk mendukung kelancaran operasional dan meningkatkan kualitas layanan medis."></textarea>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label class="form-label">Persyaratan <a class="text-danger">*</a></label>
                                <textarea id="persyaratan_edit" rows="4" class="form-control notnull_edit" placeholder="e.g. Muslim (Laki-laki), usia max 30th, memiliki sertifikat ahli K3 umum/K3RS, manajemen resiko, mampu berkomunikasi dengan baik, sehat jasmani & rohani, mampu bekerjasama dalam tim, menguasai analisa/pengolahan/penyajian data dalam komputer"></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Keterangan</label>
                                <textarea id="keterangan_edit" rows="2" class="form-control notnull_edit" placeholder="Optional"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" onclick="prosesUbah()" id="btn-ubah"><i class="fa-fw fas fa-edit nav-icon me-1"></i> Ubah</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fa-fw fas fa-times nav-icon me-1"></i> Tutup</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal animate__animated animate__rubberBand fade" id="modalNonAKtif" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-simple modal-add-new-address modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        Form Non Aktif Lowongan Kerja
                    </h4>
                </div>
                <div class="modal-body">
                    <input type="text" id="id_nonaktif" hidden>
                    <p style="text-align: justify;">Anda akan menonaktifkan Lowongan Pekerjaan tersebut, lakukanlah dengan hati-hati. Ceklis dibawah untuk melanjutkan penonaktifan.</p>
                    <label class="switch">
                        <input type="checkbox" class="switch-input" id="setujunonaktif">
                        <span class="switch-toggle-slider">
                        <span class="switch-on"></span>
                        <span class="switch-off"></span>
                        </span>
                        <span class="switch-label">Anda siap menerima Risiko</span>
                    </label>
                </div>
                <div class="col-12 text-center mb-4">
                    <button type="submit" id="btn-hapus" class="btn btn-danger me-sm-3 me-1" onclick="prosesNonAktif()"><i class="fa fa-trash me-1" style="font-size:13px"></i> Nonaktifkan</button>
                    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-times me-1" style="font-size:13px"></i> Batal</button>
                </div>
            </div>
        </div>
    </div>
    {{-- MODAL END --}}

    <script>
        $(document).ready(function() {
            var te = $(".select-multiple");
            te.length && te.each(function() {
                var es = $(this);
                es.wrap('<div class="position-relative"></div>').select2({
                    placeholder: "Pilih",
                    dropdownParent: es.parent()
                })
            });

            refresh();
        })

        function refresh() {
            $("#tampil-tbody").empty();
            $("#tampil-tbody").empty().append(`<tr><td colspan="15" style="font-size:13px"><center><i class="fa fa-spinner fa-spin fa-fw"></i> Memproses data...</center></td></tr>`);
            $.ajax(
                {
                    url: "/api/kepegawaian/rekrutmen/pengumuman/table",
                    type: 'GET',
                    dataType: 'json', // added data type
                    success: function(res) {
                        var adminID = "{{ Auth::user()->getPermission('admin_kepegawaian') }}";
                        var kepalaID = "{{ Auth::user()->getPermission('admin_kepegawaian_kepala') }}";
                        // var userID = "{{ Auth::user()->id }}";
                        $("#tampil-tbody").empty();
                        $('#dttable').DataTable().clear().destroy();

                        res.show.forEach(item => {
                            content = "<tr id='data"+ item.id +"'>";
                            content += `<td><center><div class='dropend'><a href='javascript:void(0);' class='btn btn-light btn-sm text-muted font-size-16 rounded' data-bs-toggle='dropdown' aria-haspopup="true"><i class="ti ti-dots"></i></a><div class='dropdown-menu'>`;
                                content += `<a href='javascript:void(0);' class='dropdown-item text-info' onclick="lihat(`+item.id+`)"><i class='fas fa-file-invoice me-2'></i> Lihat</a>`;
                                if (item.status == 1) {
                                    if (moment(res.now).format('YYYY-MM-DD') >= moment(item.mulai).format('YYYY-MM-DD')) {
                                        if (moment(res.now).format('YYYY-MM-DD') <= moment(item.selesai).format('YYYY-MM-DD')) {
                                            content += `<a href='javascript:void(0);' class='dropdown-item text-warning' onclick="ubah(`+item.id+`)" value="animate__rubberBand"><i class='fas fa-edit me-1'></i> Ubah</a>`;
                                            content += `<a href='javascript:void(0);' class='dropdown-item text-danger' onclick="nonaktif(`+item.id+`)" value="animate__rubberBand"><i class='fas fa-trash me-1'></i> Non Aktif</a>`;
                                        } else {
                                            content += `<a href='javascript:void(0);' class='dropdown-item text-secondary'><i class='fas fa-edit me-1'></i> Ubah</a>`;
                                            content += `<a href='javascript:void(0);' class='dropdown-item text-secondary'><i class='fas fa-trash me-1'></i> Non Aktif</a>`;
                                        }
                                    } else {
                                        content += `<a href='javascript:void(0);' class='dropdown-item text-secondary'><i class='fas fa-edit me-1'></i> Ubah</a>`;
                                        content += `<a href='javascript:void(0);' class='dropdown-item text-secondary'><i class='fas fa-trash me-1'></i> Non Aktif</a>`;
                                    }
                                } else {
                                    content += `<a href='javascript:void(0);' class='dropdown-item text-secondary'><i class='fas fa-edit me-1'></i> Ubah</a>`;
                                    content += `<a href='javascript:void(0);' class='dropdown-item text-secondary'><i class='fas fa-trash me-1'></i> Non Aktif</a>`;
                                }
                            content += `</div></center></td>`;
                            content += `<td style='white-space: normal !important;word-wrap: break-word;'>
                                            <div class='d-flex justify-content-start align-items-center'>
                                                <div class='d-flex flex-column'>
                                                    <a class='mb-0'>${item.nama} ${item.unit?'('+item.unit+')':''}</a>
                                                    <small class='text-truncate text-muted'>Jumlah Kebutuhan : <b class='text-primary'>${item.jumlah}</b> Orang</small>
                                                    <small class='text-truncate text-muted'>Kuota Pendaftar : ${item.kuota?'<b class="text-danger">'+item.kuota+'</b> Peserta':'<b class="text-danger">∞</b> (Tak Terhingga)'}</small>
                                                    <small class='text-truncate text-muted'>Batasan Umur : <mark>${item.umur_min?item.umur_min:'x'} - ${item.umur_max?item.umur_max:'x'} Tahun</mark></small>
                                                </div>
                                            </div>
                                        </td>`;
                            content += `<td>≥ ${moment(item.mulai).locale('id').format('D MMMM YYYY')}</td>`;
                            content += `<td>≤ ${moment(item.selesai).locale('id').format('D MMMM YYYY')}</td>`;
                            content += `<td>${item.kualifikasi_nama}</td>`;
                            content += `<td>${item.total_pendaftar} Peserta</td>`;
                            content += `<td>${item.tugas}</td>`;
                            content += `<td>${item.keahlian}</td>`;
                            content += `<td>${item.persyaratan}</td>`;
                            content += `<td>${item.keterangan?item.keterangan:'-'}</td>`;
                            if (item.status == 1) {
                                if (moment(res.now).format('YYYY-MM-DD') >= moment(item.mulai).format('YYYY-MM-DD')) {
                                    if (moment(res.now).format('YYYY-MM-DD') <= moment(item.selesai).format('YYYY-MM-DD')) {
                                        content += `<td><span class="badge rounded-pill text-bg-primary">Aktif</span></td>`;
                                    } else {
                                        content += `<td><span class="badge rounded-pill text-bg-success">Selesai</span></td>`;
                                    }
                                } else {
                                    content += `<td><span class="badge rounded-pill text-bg-warning">Segera Dimulai</span></td>`;
                                }
                            } else {
                                content += `<td><span class="badge rounded-pill text-bg-danger">Nonaktif</span></td>`;
                            }
                            content += `<td style='white-space: normal !important;word-wrap: break-word;'>
                                            <div class='d-flex justify-content-start align-items-center'>
                                                <div class='d-flex flex-column'>
                                                    <a class='mb-0'>` + new Date(item.updated_at).toLocaleString("sv-SE") + `</a>
                                                    <small class='text-truncate text-muted'>` + item.nama_user + `</small>
                                                </div>
                                            </div>
                                        </td>`;
                            content += "</tr>";
                            $('#tampil-tbody').append(content);
                        });
                        var table = $('#dttable').DataTable({
                            dom: 'Bfrtip',
                            order: [
                                [10, "desc"]
                            ],
                            // bAutoWidth: false,
                            // aoColumns : [
                            //     { sWidth: '5%' },
                            //     { sWidth: '20%' },
                            //     { sWidth: '5%' },
                            //     { sWidth: '5%' },
                            //     { sWidth: '10%' },
                            //     { sWidth: '10%' },
                            //     { sWidth: '10%' },
                            //     { sWidth: '10%' },
                            //     { sWidth: '10%' },
                            //     { sWidth: '5%' },
                            //     { sWidth: '10%' },
                            // ],
                            columnDefs: [
                                { visible: false, targets: [6,7,8,9] },
                            ],
                            displayLength: 15,
                            // lengthChange: true,
                            // lengthMenu: [ 10, 25, 50, 75, 100, 500, 1000, 5000, 10000],
                            buttons: [
                                // 'copy',
                                'excel',
                                // 'pdf',
                                'colvis']
                        });
                        clearText();
                    },
                    error: function(res) {
                        iziToast.error({
                            title: 'Pesan Galat!',
                            message: 'Record Data tidak ditemukan.',
                            position: 'topRight'
                        });
                    }
                }
            );
        }

        function ubah(id) {
            $.ajax(
                {
                    url: `/api/kepegawaian/rekrutmen/pengumuman/${id}/show`,
                    type: 'GET',
                    dataType: 'json', // added data type
                    success: function(res) {
                        $('#show_id_edit').text(id);
                        $('#id_edit').val(id);
                        $('#token_edit').val(res.show.token);
                        $('#mulai_edit').val(res.show.mulai.split(' ')[0]);
                        $('#selesai_edit').val(res.show.selesai.split(' ')[0]);
                        $('#unit_edit').val(res.show.unit);
                        $('#nama_edit').val(res.show.nama);
                        $('#umur_min_edit').val(res.show.umur_min);
                        $('#umur_max_edit').val(res.show.umur_max);
                        $('#jumlah_edit').val(res.show.jumlah);
                        $('#kuota_edit').val(res.show.kuota);

                            const inp_edit = $('#pendidikan_edit');
                            const options = res.pendidikan || [];
                            const selected = JSON.parse(res.show.kualifikasi); // hasil: ["55", "77"]
                            // Isi <option> dari API
                            inp_edit.empty();
                            options.forEach(opt => {
                                inp_edit.append(`<option value="${opt.id}">[${opt.kategori}] ${opt.nama}</option>`);
                            });
                            inp_edit.val(selected).trigger('change');
                            // selectedPendidikan.forEach(val => {
                            //     if (!$('#pendidikan_edit option[value="' + val + '"]').length) {
                            //         $('#pendidikan_edit').append(`<option value="${val}">${val}</option>`); // atau label yang sesuai
                            //     }
                            // });
                            // $('#pendidikan_edit').val(selectedPendidikan).change();

                        $('#tugas_edit').val(res.show.tugas);
                        $('#keahlian_edit').val(res.show.keahlian);
                        $('#persyaratan_edit').val(res.show.persyaratan);
                        $('#keterangan_edit').val(res.show.keterangan);
                        $('#ubah').modal('show');
                    }
                }
            )
        }

        function prosesUbah() {

            // Definisi
            var save = new FormData();
            save.append('id',$('#id_edit').val());
            save.append('mulai',$('#mulai_edit').val());
            save.append('selesai',$('#selesai_edit').val());
            save.append('unit',$('#unit_edit').val());
            save.append('nama',$('#nama_edit').val());
            save.append('umur_min',$('#umur_min_edit').val());
            save.append('umur_max',$('#umur_max_edit').val());
            save.append('jumlah',$('#jumlah_edit').val());
            save.append('kuota',$('#kuota_edit').val());
            save.append('kualifikasi',JSON.stringify($('#pendidikan_edit').val()));
            save.append('tugas',$('#tugas_edit').val());
            save.append('keahlian',$('#keahlian_edit').val());
            save.append('persyaratan',$('#persyaratan_edit').val());
            save.append('keterangan',$('#keterangan_edit').val());
            save.append('pegawai','{{ Auth::user()->id }}');

            if ($('.notnull_edit').val() == "") {
                iziToast.warning({
                    title: 'Pesan Ambigu!',
                    message: 'Pastikan Anda tidak mengosongi semua isian Wajib',
                    position: 'topRight'
                });
            } else {
                if ($('#selesai_edit').val() < $('#mulai_edit').val()) {
                    iziToast.warning({
                        title: 'Pesan Ambigu!',
                        message: 'Tgl Tutup Lowongan harus lebih dari Tgl Buka Lowongan',
                        position: 'topRight'
                    });
                } else {
                    $("#btn-ubah").prop('disabled', true);
                    $("#btn-ubah").find("i").removeClass("fa-edit").addClass('fa-sync fa-spin');
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        method: 'POST',
                        url: '/api/kepegawaian/rekrutmen/pengumuman/ubah',
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                        data: save,
                        success: function(res) {
                            if (res.code == 400) {
                                iziToast.error({
                                    title: 'Pesan Galat!',
                                    message: res.message,
                                    position: 'topRight',
                                    buttons: [
                                        [
                                            '<button>Tutup</button>',
                                            function (instance, toast) {
                                                instance.hide({
                                                    transitionOut: 'fadeOutUp'
                                                }, toast);
                                            }
                                        ]
                                    ]
                                });
                            } else {
                                iziToast.success({
                                    title: 'Pesan Sukses!',
                                    message: 'Perubahan Lowongan Pekerjaan berhasil pada '+res,
                                    position: 'topRight'
                                });
                                refresh();
                                $('#ubah').modal('hide');
                            }
                            $("#btn-ubah").find("i").removeClass("fa-sync fa-spin").addClass("fa-edit");
                            $("#btn-ubah").prop('disabled', false);
                        },
                        error: function (res) {
                            iziToast.error({
                                title: 'Pesan Galat!',
                                message: res.responseJSON.error,
                                position: 'topRight'
                            });
                            $("#btn-ubah").find("i").removeClass("fa-sync fa-spin").addClass("fa-edit");
                            $("#btn-ubah").prop('disabled', false);
                        }
                    });
                }
            }
        }

        function prosesSimpan() {

            // Definisi
            var save = new FormData();
            save.append('mulai',$('#mulai').val());
            save.append('selesai',$('#selesai').val());
            save.append('unit',$('#unit').val());
            save.append('nama',$('#nama').val());
            save.append('umur_min',$('#umur_min').val());
            save.append('umur_max',$('#umur_max').val());
            save.append('jumlah',$('#jumlah').val());
            save.append('kuota',$('#kuota').val());
            save.append('kualifikasi',JSON.stringify($('#pendidikan').val()));
            save.append('tugas',$('#tugas').val());
            save.append('keahlian',$('#keahlian').val());
            save.append('persyaratan',$('#persyaratan').val());
            save.append('keterangan',$('#keterangan').val());
            save.append('pegawai','{{ Auth::user()->id }}');

            if ($('.notnull').val() == "") {
                iziToast.warning({
                    title: 'Pesan Ambigu!',
                    message: 'Pastikan Anda tidak mengosongi semua isian Wajib',
                    position: 'topRight'
                });
            } else {
                if ($('#selesai').val() < $('#mulai').val()) {
                    iziToast.warning({
                        title: 'Pesan Ambigu!',
                        message: 'Tgl Tutup Lowongan harus lebih dari Tgl Buka Lowongan',
                        position: 'topRight'
                    });
                } else {
                    $("#btn-simpan").prop('disabled', true);
                    $("#btn-simpan").find("i").removeClass("fa-stamp").addClass('fa-sync fa-spin');
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        method: 'POST',
                        url: '/api/kepegawaian/rekrutmen/pengumuman/simpan',
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                        data: save,
                        success: function(res) {
                            if (res.code == 400) {
                                iziToast.error({
                                    title: 'Pesan Galat!',
                                    message: res.message,
                                    position: 'topRight',
                                    buttons: [
                                        [
                                            '<button>Tutup</button>',
                                            function (instance, toast) {
                                                instance.hide({
                                                    transitionOut: 'fadeOutUp'
                                                }, toast);
                                            }
                                        ]
                                    ]
                                });
                            } else {
                                iziToast.success({
                                    title: 'Pesan Sukses!',
                                    message: 'Penambahan Lowongan Pekerjaan berhasil pada '+res,
                                    position: 'topRight'
                                });
                                refresh();
                                $('#tambah').modal('hide');
                            }
                            $("#btn-simpan").find("i").removeClass("fa-sync fa-spin").addClass("fa-stamp");
                            $("#btn-simpan").prop('disabled', false);
                        },
                        error: function (res) {
                            iziToast.error({
                                title: 'Pesan Galat!',
                                message: res.responseJSON.error,
                                position: 'topRight'
                            });
                            $("#btn-simpan").find("i").removeClass("fa-sync fa-spin").addClass("fa-stamp");
                            $("#btn-simpan").prop('disabled', false);
                        }
                    });
                }
            }
        }

        function nonaktif(id) {
            $("#id_nonaktif").val(id);
            var inputs = document.getElementById('setujunonaktif');
            inputs.checked = false;
            $('#modalNonAKtif').modal('show');
        }

        function prosesNonAktif() {
            // SWITCH BTN HAPUS
            var checkboxHapus = $('#setujunonaktif').is(":checked");
            if (checkboxHapus == false) {
                iziToast.error({
                    title: 'Pesan Galat!',
                    message: 'Mohon menyetujui untuk dilakukan penghapusan lowongan kerja tersebut',
                    position: 'topRight'
                });
            } else {
                // PROSES HAPUS
                var id = $("#id_nonaktif").val();
                $.ajax({
                    url: "/api/kepegawaian/rekrutmen/pengumuman/{{ Auth::user()->id }}/nonaktif/"+id+"",
                    type: 'DELETE',
                    success: function(res) {
                        iziToast.success({
                            title: 'Pesan Sukses!',
                            message: 'Lowongan Pekerjaan telah berhasil dihapus pada '+res,
                            position: 'topRight'
                        });
                        $('#modalNonAKtif').modal('hide');
                        refresh();
                    },
                    error: function(res) {
                        iziToast.error({
                            title: 'Pesan Galat!',
                            message: 'Lowongan Pekerjaan gagal dihapus',
                            position: 'topRight'
                        });
                    }
                });
            }
        }

        function clearText() {
            $('#mulai').val('');
            $('#selesai').val('');
            $('#unit').val('');
            $('#nama').val('');
            $('#umur_min').val('');
            $('#umur_max').val('');
            $('#jumlah').val('');
            $('#kuota').val('');
            $('#pendidikan').val('').change();
            $('#tugas').val('');
            $('#keahlian').val('');
            $('#persyaratan').val('');
        }

    </script>
@endsection
