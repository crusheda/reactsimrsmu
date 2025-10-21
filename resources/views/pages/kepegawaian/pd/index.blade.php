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
                        <li class="breadcrumb-item" aria-current="page">Perjalanan Dinas</li>
                    </ul>
                </div>
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h2 class="mb-0">Surat Perjalanan Dinas</h2>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- [ breadcrumb ] end -->

    <!-- [ Main Content ] start -->
    <div class="row pt-1">
        @if (Auth::user()->getPermission('admin_kepegawaian_kepala'))
            <div class="col-xl-12">
                <div class="accordion accordion-flush" id="accordionFlushExample">
                    <div class="accordion-item">
                        <div class="card">
                            <div class="card-header accordion-header d-flex align-items-center justify-content-between py-3 ">
                                <h5 class="mb-0"><button
                                    class="accordion-button collapsed" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#flush-collapseOne"
                                    aria-expanded="false" aria-controls="flush-collapseOne"><b style="font-size: 1rem">Formulir Tambah</b>&nbsp;&nbsp;</button>
                                </h5>
                            </div>
                            <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">

                                    <div class="row">
                                        <div class="col-xl-12 col-xxl-12">
                                            <div class="alert alert-secondary">
                                                <small>
                                                    {{-- <i class="ti ti-arrow-narrow-right me-1"></i> <br> --}}
                                                    <i class="ti ti-arrow-narrow-right me-1"></i> Isian bertanda (<a class="text-danger">*</a>) berarti wajib diisi
                                                    {{-- <br><i class="ti ti-arrow-narrow-right me-1"></i> Batas ukuran file upload maksimal <b class="text-danger">2 mb</b> --}}
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-9 mb-3">
                                            <div class="form-group">
                                                <label class="form-label">Nama Acara <a class="text-danger">*</a></label>
                                                <input type="text" class="form-control" name="acara" id="acara" placeholder="e.g. Upacara Pengibaran Bendera Merah Putih HUT RI Ke-XX">
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <div class="form-group">
                                                <label class="form-label">Waktu Acara <a class="text-danger">*</a></label>
                                                <input type="datetime-local" class="form-control" name="tgl" id="tgl">
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <div class="form-group">
                                                <label class="form-label">Jenis Perjalanan Dinas <a class="text-danger">*</a></label>
                                                <select class="form-control" name="jenis" id="jenis">
                                                    <option value="">Pilih</option>
                                                    <option value="1">Offline</option>
                                                    <option value="2">Online</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <div class="form-group">
                                                <label class="form-label">Jenis Kendaraan <a class="text-danger">*</a></label>
                                                <select class="form-control" name="kendaraan" id="kendaraan">
                                                    <option value="">Pilih</option>
                                                    <option value="1">[Pribadi] Motor</option>
                                                    <option value="2">[Pribadi] Mobil</option>
                                                    <option value="3">[Rumah Sakit] Mobil</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3" id="showing" hidden>
                                            <div class="form-group">
                                                <label class="form-label">Pemilik Kendaraan Yang Digunakan <a class="text-danger">*</a></label>
                                                <select class="form-select select2" name="kendaraan_pegawai[]" id="kendaraan_pegawai" style="width: 100%" multiple>
                                                    @if (count($list['users']) > 0)
                                                        @foreach ($list['users'] as $item)
                                                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="multiple-inputs">Lama Dinas <a class="text-danger">*</a></label>
                                            <div class="input-group">
                                                <select class="form-control" name="lama1" id="lama1">
                                                    <option value="">Pilih</option>
                                                    <option value="1">< 4 Jam (Kurang dari 4 jam)</option>
                                                    <option value="2">> 4 Jam (Lebih dari 4 jam)</option>
                                                </select>
                                                <input type="text" placeholder="Perkiraan Waktu (Jam)" class="form-control" name="lama2" id="lama2">
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label class="form-label">Lokasi Acara <a class="text-danger">*</a></label>
                                                <input type="text" class="form-control" name="lokasi" id="lokasi" placeholder="e.g. Alun-alun Satya Negara Kabupaten Sukoharjo">
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3" id="slide">
                                            <div class="form-group">
                                                <label class="form-label">Pegawai Pelaksana <a class="text-danger">*</a></label>
                                                <select class="form-select select2" name="pegawai[]" id="pegawai" style="width: 100%" multiple>
                                                    @if (count($list['users']) > 0)
                                                        @foreach ($list['users'] as $item)
                                                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <div class="form-group">
                                                <label class="form-label">Deskripsi Perjalanan (<b>Optional</b>)</label>
                                                <textarea class="form-control" name="deskripsi" id="deskripsi" rows="2" placeholder="Deskripsikan perjalanan dinas Anda"></textarea>
                                            </div>
                                        </div>
                                        {{-- <div class="col-md-3 mb-3">
                                            <div class="form-group">
                                                <label class="form-label">Upload</label>
                                                <input type="file" class="form-control" id="filex" name="filex" accept="application/pdf">
                                            </div>
                                        </div> --}}
                                        <div class="text-end btn-page mt-2">
                                            <button class="btn btn-link-secondary" id="clear_text" onclick="clearInput()">Kosongkan</button>
                                            <button class="btn btn-primary" id="btn-simpan" onclick="simpan()"><i class="fas fa-save me-1"></i> Simpan</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between py-3">
                    <h5 class="mb-0 ms-3"><b style="font-size: 1rem">Riwayat Perjalanan</b></h5>
                    <div class="btn-group">
                        <a href="javascript:void(0);" class="avtar avtar-s btn-link-warning" onclick="showRiwayat()" data-bs-toggle="tooltip"
                        data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="Segarkan Tabel"><i class="ti ti-refresh f-20"></i></a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dttable" class="table table-hover dt-responsive align-middle">
                            <thead>
                                <tr>
                                    <th><center>#ID</center></th>
                                    <th><center>WAKTU</center></th>
                                    <th>ACARA</th>
                                    <th>PEGAWAI PELAKSANA</th>
                                    <th>UPDATE</th>
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
                                    <th><center>WAKTU</center></th>
                                    <th>ACARA</th>
                                    <th>PEGAWAI PELAKSANA</th>
                                    <th>UPDATE</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL START --}}
    <div class="modal fade animate__animated animate__rubberBand" id="modalRincian" role="dialog" aria-labelledby="confirmFormLabel"aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        Rincian Perjalanan
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="text" class="form-control" name="id_rincian" id="id_rincian" hidden>
                    <div class="table-responsive">
                        <table class="table table-hover dt-responsive align-middle table-borderless">
                            <tbody style="font-size:13px" id="tbody-rincian">
                                <tr>
                                    <td colspan="9">
                                        <center><i class="fa fa-spinner fa-spin fa-fw"></i> Memproses data...</center>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer" id="keu-only" hidden>
                    <button type="button" class="btn btn-link-secondary" data-bs-dismiss="modal">Tutup</button>
                    @if (Auth::user()->getPermission('admin_pd_keuangan') == true)
                        <button type="button" class="btn btn-primary" onclick="confirmPaid()" id="btn-confirm" hidden>Confirm Paid</button>
                        <button type="button" class="btn btn-warning" onclick="cancelPaid()" id="btn-cancel" data-bs-toggle="tooltip"
                        data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="Batal Status menjadi <b>UNPAID</b> hanya berlaku <u>hari ini</u> saja!" hidden>Cancel Paid</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade animate__animated animate__rubberBand" id="modalUbah" role="dialog" aria-labelledby="confirmFormLabel"aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        Form Ubah
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="text" id="id_edit" hidden>
                    <div class="row">
                        <div class="col-md-9 mb-3">
                            <div class="form-group">
                                <label class="form-label">Nama Acara <a class="text-danger">*</a></label>
                                <input type="text" class="form-control" name="acara_edit" id="acara_edit" placeholder="e.g. Upacara Pengibaran Bendera Merah Putih HUT RI Ke-XX">
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="form-group">
                                <label class="form-label">Waktu Acara <a class="text-danger">*</a></label>
                                <input type="datetime-local" class="form-control" name="tgl_edit" id="tgl_edit">
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="form-group">
                                <label class="form-label">Jenis Perjalanan Dinas <a class="text-danger">*</a></label>
                                <select class="form-control" name="jenis_edit" id="jenis_edit"></select>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="form-group">
                                <label class="form-label">Jenis Kendaraan <a class="text-danger">*</a></label>
                                <select class="form-control" name="kendaraan_edit" id="kendaraan_edit"></select>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3" id="showing_edit" hidden>
                            <div class="form-group">
                                <label class="form-label">Pemilik Kendaraan Yang Digunakan <a class="text-danger">*</a></label>
                                <select class="form-select select2" name="kendaraan_pegawai_edit[]" id="kendaraan_pegawai_edit" style="width: 100%" multiple>
                                    @if (count($list['users']) > 0)
                                        @foreach ($list['users'] as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="multiple-inputs">Lama Dinas <a class="text-danger">*</a></label>
                            <div class="input-group">
                                <select class="form-control" name="lama1_edit" id="lama1_edit"></select>
                                <input type="text" placeholder="Perkiraan Waktu (Jam)" class="form-control" name="lama2_edit" id="lama2_edit">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label class="form-label">Lokasi Acara <a class="text-danger">*</a></label>
                                <input type="text" class="form-control" name="lokasi_edit" id="lokasi_edit" placeholder="e.g. Alun-alun Satya Negara Kabupaten Sukoharjo">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3" id="slide_edit">
                            <div class="form-group">
                                <label class="form-label">Pegawai Pelaksana <a class="text-danger">*</a></label>
                                <select class="form-select select2" name="pegawai_edit[]" id="pegawai_edit" style="width: 100%" multiple></select>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label class="form-label">Deskripsi Perjalanan (<b>Optional</b>)</label>
                                <textarea class="form-control" name="deskripsi_edit" id="deskripsi_edit" rows="1" placeholder="Deskripsikan perjalanan dinas Anda"></textarea>
                            </div>
                        </div>
                        {{-- <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-label">File Terupload</label>
                                <div id="filex_edit"></div>
                                <small>File yang telah terupload tidak dapat diubah kembali, lakukan penginputan ulang apabila diperlukan</small>
                            </div>
                        </div> --}}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link-secondary" data-bs-dismiss="modal">Batalkan</button>
                    <button class="btn btn-primary" id="btn-ubah" onclick="prosesUbah()"><i class="fa-fw fas fa-save nav-icon"></i> Simpan Perubahan</button>
                </div>
            </div>
        </div>
    </div>
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
                    <p style="text-align: justify;">Anda akan melakukan penghapusan Berkas Perjalanan Dinas, lakukanlah dengan hati-hati. Ceklis dibawah untuk melanjutkan penghapusan.</p>
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
                    <button type="reset" class="btn btn-link-secondary" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-times me-1" style="font-size:13px"></i> Batal</button>
                </div>
            </div>
        </div>
    </div>
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

            $('#kendaraan').change(function () {
                var i = $(this).val();
                if (i == 1 || i == 2) {
                    var o = $("#kendaraan_pegawai");
                    o.length && o.each(function() {
                        var e = $(this);
                        e.wrap('<div class="position-relative"></div>').select2({
                            placeholder: "Pilih",
                            allowClear: true,
                            dropdownParent: e.parent()
                        })
                    });
                    $('#kendaraan_pegawai').val('').change();
                    $('#showing').prop('hidden',false);
                    $('#slide').removeClass('col-md-6').addClass('col-md-12');
                } else {
                    $('#showing').prop('hidden',true);
                    $('#slide').removeClass('col-md-12').addClass('col-md-6');
                }
            });
            // $('.select2Tambah').select2({
            //     dropdownParent: $('#tambah')
            // });

            showRiwayat();
        });

        function showRiwayat() {
            $("#tampil-tbody").empty().append(`<tr style='font-size:13px'><td colspan="9"><center><i class="fa fa-spinner fa-spin fa-fw"></i> Memproses data...</center></td></tr>`);
            $.ajax({
                url: "/api/kepegawaian/pd/table",
                type: 'GET',
                dataType: 'json',
                success: function(res) {
                    $("#tampil-tbody").empty();
                    $('#dttable').DataTable().clear().destroy();
                    res.show.forEach(item => {
                        var updet = new Date(item.updated_at).toLocaleDateString("sv-SE");
                        var paiddate = new Date(item.tgl_paid).toLocaleDateString("sv-SE");
                        var date = new Date().toLocaleDateString("sv-SE");
                        var userID = "{{ Auth::user()->id }}";
                        var adminID = "{{ Auth::user()->getPermission(['admin_kepegawaian']) }}";
                        var superID = "{{ Auth::user()->getPermission('admin_kepegawaian_kepala') }}";
                        var keuID = "{{ Auth::user()->getPermission(['admin_pd_keuangan']) }}";
                        content = "<tr id='data" + item.id + "' style='font-size:13px'>";
                        content += `<td><center><div class='btn-group'>
                                        <button type='button' class='btn btn-sm btn-link text-secondary dropdown-toggle hide-arrow' data-bs-toggle='dropdown' aria-expanded='false'>`+item.id+`</button>
                                        <ul class='dropdown-menu dropdown-menu-right'>`;
                                        if (superID == true || adminID == true || keuID == true) {
                                            content += `<li><a href="javascript:void(0);" class="dropdown-item text-info" onclick="rincian(${item.id})"><i class="fa-fw fas fa-file-signature me-2"></i> Rincian</a></li>`;
                                        }
                                        if (superID == true) {
                                            if (item.paid == 1) {
                                                content += `<li><a href="javascript:void(0);" class="dropdown-item text-secondary"><i class="fa-fw fas fa-edit me-2"></i> Ubah</a></li>`;
                                                content += `<li><a href='javascript:void(0);' class='dropdown-item text-secondary'><i class="fa-fw fas fa-trash nav-icon"></i> Hapus</a></li>`;
                                            } else {
                                                content += `<li><a href="javascript:void(0);" class="dropdown-item text-warning" onclick="ubah(${item.id})"><i class="fa-fw fas fa-edit me-2"></i> Ubah</a></li>`;
                                                content += `<li><a href='javascript:void(0);' class='dropdown-item text-danger' onclick="hapus(` + item.id + `)"><i class="fa-fw fas fa-trash nav-icon"></i> Hapus</a></li>`;
                                            }
                                        } else {
                                            content += `<li><a href="javascript:void(0);" class="dropdown-item text-secondary"><i class="fa-fw fas fa-edit me-2"></i> Ubah</a></li>`;
                                            content += `<li><a href='javascript:void(0);' class='dropdown-item text-secondary'><i class="fa-fw fas fa-trash nav-icon"></i> Hapus</a></li>`;
                                        }
                        content += "</div></center></td>";
                        content += `<td>${new Date(item.tgl).toLocaleString("sv-SE")}</td>`;
                        //  onclick="window.open('/kepegawaian/pd/`+item.id+`/download')"
                        if (item.kendaraan == 1) {
                            kendaraan = '[Pribadi] Motor';
                        } else {
                            if (item.kendaraan == 2) {
                                kendaraan = '[Pribadi] Mobil';
                            } else {
                                kendaraan = '[Rumah Sakit] Mobil';
                            }
                        }
                        kendaraan_pegawai = '';
                        if (item.kendaraan_pegawai) {
                            res.users.forEach(is => {
                                JSON.parse(item.kendaraan_pegawai).forEach(val => {
                                    if (val == is.id) {
                                        kendaraan_pegawai += is.nama + `; `;
                                    }
                                })
                            })
                        }
                        if (item.paid == 0) {
                            statusPaid = `<span class="badge bg-light-danger rounded-pill ms-2">UNPAID</span>`;
                        } else {
                            statusPaid = `<span class="badge bg-light-success rounded-pill ms-2">PAID</span>`;
                        }
                        content += `<td style='white-space: normal !important;word-wrap: break-word;'>
                                        <div class='d-flex justify-content-start align-items-center'>
                                            <div class='d-flex flex-column'>
                                                <h6 class='mb-0'><a href="javascript:void(0);" class="text-dark"><u data-bs-toggle="tooltip"
                                                    data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="Nama Acara">` + item.acara + `</u> ${statusPaid}</a>
                                                </h6>
                                                <small class='text-truncate text-muted'>Bertempat di <b>${item.lokasi}</b> dan Diselenggarakan secara ${item.jenis==1?"<b class='text-danger'>Offline</b>":"<b class='text-success'>Online</b>"} selama ${item.lama1 == 1?'kurang dari 4 jam':'lebih dari 4 jam'}</small>
                                                <small class='text-truncate text-muted'>Menggunakan <u><b>Transportasi ${kendaraan}</b></u> ${item.kendaraan == 3?``:`Milik<br>(<a href='javascript:void(0);'><b class='text-secondary' data-bs-toggle='tooltip' data-bs-placement='bottom' data-bs-html='true' title='Pemilik Kendaraan'>`+kendaraan_pegawai+`</b></a>)`}</small>
                                            </div>
                                        </div>
                                    </td>`;
                        var pegawai = null;
                        content += `<td><small><ul class='list-unstyled mt-2'>`;
                        // console.log(JSON.parse(item.pegawai_id));
                        res.users.forEach(us => {
                            JSON.parse(item.pegawai_id).forEach(val => {
                                if (val == us.id) {
                                    content += `<li><i class="ti ti-arrow-narrow-right me-1"></i>` + us.nama + `</li>`;
                                }
                            })
                        })
                        content += `</small></ul></td>`;
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
            // Showing Tooltip
            $('[data-bs-toggle="tooltip"]').tooltip({
                trigger: 'hover'
            })
                    });
                    var table = $('#dttable').DataTable({
                        dom: 'Bfrtip',
                        order: [
                            [4, "desc"]
                        ],
                        bAutoWidth: false,
                        aoColumns : [
                            { sWidth: '5%' },
                            { sWidth: '10%' },
                            { sWidth: '45%' },
                            { sWidth: '28%' },
                            { sWidth: '12%' },
                        ],
                        columnDefs: [
                            // { visible: false, targets: [7] },
                        ],
                        displayLength: 7,
                        lengthChange: true,
                        lengthMenu: [7, 10, 25, 50, 75, 100],
                        // buttons: ['copy', 'excel', 'pdf', 'colvis']
                    });
                }
            })
        }

        function simpan() {
            $("#btn-simpan").prop('disabled', true);
            $("#btn-simpan").find("i").toggleClass("fa-save fa-sync fa-spin");

            // Definisi
            var save = new FormData();
            // var filesAdded = $('#filex')[0].files;
            save.append('acara',$('#acara').val());
            save.append('tgl',$('#tgl').val());
            save.append('jenis',$('#jenis').val());
            save.append('kendaraan',$('#kendaraan').val());
            save.append('kendaraan_pegawai',JSON.stringify($('#kendaraan_pegawai').val()));
            save.append('lama1',$('#lama1').val());
            save.append('lama2',$('#lama2').val());
            save.append('lokasi',$('#lokasi').val());
            save.append('pegawai',JSON.stringify($('#pegawai').val()));
            save.append('deskripsi',$('#deskripsi').val());
            save.append('user','{{ Auth::user()->id }}');
            // if (filesAdded) {
            //     save.append('file',filesAdded[0]);
            // }
            if (
                save.get('acara') == ""     ||
                save.get('tgl') == ""       ||
                save.get('jenis') == ""     ||
                save.get('kendaraan') == "" ||
                save.get('lama1') == ""     ||
                // save.get('lama2') == ""     ||
                save.get('lokasi') == ""    ||
                $('#pegawai').val() == ""
                // || filesAdded.length == 0 // (Jika Tidak Ada File Yang Diupload)
                ) {
                iziToast.warning({
                    title: 'Pesan Ambigu!',
                    message: 'Pastikan Anda tidak mengosongi semua isian Wajib',
                    position: 'topRight'
                });
            } else {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{route('kepegawaian.pd.tambah')}}",
                    method: 'post',
                    data: save,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(res) {
                        if (res.code == 200) {
                            notifier.show(
                                "Pesan Sukses!", "Submit Berkas berhasil dilakukan pada "+res.message,
                                "success", "{{ asset('images/notification/ok-48.png') }}", 4e3
                            );
                            showRiwayat();
                            clearInput();
                        } else {
                            notifier.show(
                                "Pesan Galat!", res.message,
                                "warning", "{{ asset('images/notification/medium_priority-48.png') }}", 4e3
                            );
                        }
                    },
                    error: function (res) {
                        notifier.show(
                            res.statusText + " (Code " + res.status + ")", res.responseText,
                            "danger", "{{ asset('images/notification/high_priority-48.png') }}", 4e3
                        );
                    }
                });
            }

            $("#btn-simpan").find("i").removeClass("fa-sync fa-spin").addClass("fa-save");
            $("#btn-simpan").prop('disabled', false);
        }

        function rincian(id) {
            $("#tbody-rincian").empty().append(`<tr style='font-size:13px'><td colspan="9"><center><i class="fa fa-spinner fa-spin fa-fw"></i> Memproses data...</center></td></tr>`);
            $.ajax(
            {
                url: "/api/kepegawaian/pd/"+id,
                type: 'GET',
                dataType: 'json',
                success: function(res) {
                    $('#tbody-rincian').empty();
                    if (res.show.kendaraan == 1) {
                        kendaraan = '[Pribadi] Motor';
                    } else {
                        if (res.show.kendaraan == 2) {
                            kendaraan = '[Pribadi] Mobil';
                        } else {
                            kendaraan = '[Rumah Sakit] Mobil';
                        }
                    }
                    kendaraan_pegawai = '';
                    if (res.show.kendaraan_pegawai) {
                        res.users.forEach(is => {
                            JSON.parse(res.show.kendaraan_pegawai).forEach(val => {
                                if (val == is.id) {
                                    kendaraan_pegawai += is.nama + `; `;
                                }
                            })
                        })
                    }
                    pegawai = ``;
                    res.users.forEach(us => {
                        JSON.parse(res.show.pegawai_id).forEach(val => {
                            if (val == us.id) {
                                pegawai += `<li>` + us.nama + `</li>`;
                            }
                        })
                    })
                    $('#tbody-rincian').append(`
                        <tr>
                            <th colspan="2">
                                <div class="shadow-lg p-3 bg-body rounded" role="alert">
                                    <h5 class="alert-heading fw-bold mb-2 text-center">
                                        Status Pembayaran Dari <b class="text-primary">Bagian Keuangan</b>
                                    </h5>
                                    <h6 class="text-center mb-0" style="font-size:20px">${res.show.paid == 0?'<span class="badge bg-light-danger rounded-pill">U N P A I D</span>':'<span class="badge bg-light-success rounded-pill ms-2">P A I D</span>'}</h6>
                                </div>
                            </th>
                        </tr>
                        <tr><th>Nama Acara</th><td>${res.show.acara} (${res.show.jenis})</td></tr>
                        <tr><th>Lokasi Acara</th><td>${res.show.lokasi}</td></tr>
                        <tr><th>Tanggal</th><td>Pada ${res.show.tgl} Selama ${res.show.lama1 == 1?'< 4 Jam':'> 4 Jam'} ${res.show.lama2?'('+res.show.lama2+' Jam)':''}</td></tr>
                        <tr><th>Peserta</th><td>${pegawai}</td></tr>
                        <tr><th>Transportasi</th><td>${kendaraan}</td></tr>
                        ${res.show.kendaraan_pegawai?`<tr><th>Pemilik Kendaraan</th><td>`+kendaraan_pegawai+`</td></tr>`:``}
                        <tr><th>Deskripsi Perjalanan</th><td>${res.show.deskripsi?res.show.deskripsi:''}</td></tr>
                        ${res.show.paid == 1?`<tr><th class="text-danger">Keterangan Pembayaran</th><td>Dibayarkan oleh `+res.show.nama_user_paid+` pada `+res.show.tgl_paid+`</td></tr>`:``}
                    `);
                    var keuID = "{{ Auth::user()->getManyPermission(['admin_pd_keuangan']) }}";
                    var userID = "{{ Auth::user()->id }}";
                    if (keuID == true) {
                        $('#keu-only').prop('hidden',false);
                    } else {
                        $('#keu-only').prop('hidden',true);
                    }
                    $('#id_rincian').val(res.show.id);
                    if (res.show.paid == 0) {
                        $('#btn-confirm').prop('hidden',false);
                        $('#btn-cancel').prop('hidden',true);
                    } else {
                        haripaid = new Date(res.show.tgl_paid).toLocaleDateString("sv-SE");
                        hariini = new Date().toLocaleDateString("sv-SE");
                        if (haripaid == hariini) {
                            $('#btn-confirm').prop('hidden',true);
                            $('#btn-cancel').prop('hidden',false);
                        } else {
                            $('#btn-confirm').prop('hidden',true);
                            $('#btn-cancel').prop('hidden',true);
                        }
                    }
                    $('#modalRincian').modal('show');
                }
            })
        }

        function confirmPaid() {
            // PROSES
            var save = new FormData();
            save.append('id',$("#id_rincian").val());
            save.append('pegawai','{{ Auth::user()->id }}');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('kepegawaian.pd.confirmPaid')}}",
                method: 'post',
                data: save,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(res) {
                    iziToast.success({
                        title: 'Pesan Sukses!',
                        message: 'Rincian Perjalanan Dinas telah berhasil dibayarkan pada '+res,
                        position: 'topRight'
                    });
                    $('#modalRincian').modal('hide');
                    showRiwayat();
                },
                error: function(res) {
                    iziToast.error({
                        title: 'Pesan Galat!',
                        message: 'Rincian Perjalanan Dinas gagal dibayarkan',
                        position: 'topRight'
                    });
                }
            });
        }

        function cancelPaid() {
            // PROSES
            var save = new FormData();
            save.append('id',$("#id_rincian").val());
            save.append('pegawai','{{ Auth::user()->id }}');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('kepegawaian.pd.cancelPaid')}}",
                method: 'post',
                data: save,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(res) {
                    iziToast.success({
                        title: 'Pesan Sukses!',
                        message: 'Rincian Perjalanan Dinas telah berhasil diselesaikan pembayaran pada '+res,
                        position: 'topRight'
                    });
                    $('#modalRincian').modal('hide');
                    showRiwayat();
                },
                error: function(res) {
                    iziToast.error({
                        title: 'Pesan Galat!',
                        message: 'Batal Pembayaran Fee Perjalanan Dinas gagal dilakukan',
                        position: 'topRight'
                    });
                }
            });
        }

        function ubah(id) {
            $.ajax(
            {
                url: "/api/kepegawaian/pd/"+id,
                type: 'GET',
                dataType: 'json',
                success: function(res) {
                    // if (res.show.title) {
                    //     $("#filex_edit").empty().append(`<h6 id="filex_edit" class="text-primary"><a href="javascript:void(0);" onclick="window.open('/kepegawaian/pd/`+res.show.id+`/download')"><u>${res.show.title}</u></a></h6>`);
                    // } else {
                    //     $("#filex_edit").empty().append(`<h6 id="filex_edit" class="text-dark"><a>Tidak ada file terupload</a></h6>`);
                    // }
                    if (res.show.kendaraan == 1 || res.show.kendaraan == 2) {
                        $('#showing_edit').prop('hidden',false);
                        $('#slide_edit').removeClass('col-md-6').addClass('col-md-12');
                    } else {
                        $('#showing_edit').prop('hidden',true);
                        $('#slide_edit').removeClass('col-md-12').addClass('col-md-6');
                    }
                    $('#kendaraan_edit').change(function () {
                        var i = $(this).val();
                        if (i == 1 || i == 2) {
                            var o = $("#kendaraan_pegawai_edit");
                            o.length && o.each(function() {
                                var e = $(this);
                                e.wrap('<div class="position-relative"></div>').select2({
                                    placeholder: "Pilih",
                                    allowClear: true,
                                    dropdownParent: e.parent()
                                })
                            });
                            $('#kendaraan_pegawai_edit').val('').change();
                            $('#showing_edit').prop('hidden',false);
                            $('#slide_edit').removeClass('col-md-6').addClass('col-md-12');
                        } else {
                            $('#showing_edit').prop('hidden',true);
                            $('#slide_edit').removeClass('col-md-12').addClass('col-md-6');
                        }
                    });
                    $('#id_edit').val(res.show.id);
                    $('#acara_edit').val(res.show.acara);
                    $('#tgl_edit').val(res.show.tgl);
                    $('#lokasi_edit').val(res.show.lokasi);
                    $("#jenis_edit").find('option').remove();
                    $("#jenis_edit").append(`
                        <option value="1" ${res.show.jenis==1?"selected":""}>Offline</option>
                        <option value="2" ${res.show.jenis==2?"selected":""}>Online</option>
                    `);
                    $("#kendaraan_edit").find('option').remove();
                    $("#kendaraan_edit").append(`
                        <option value="1" ${res.show.kendaraan==1?"selected":""}>[Pribadi] Motor</option>
                        <option value="2" ${res.show.kendaraan==2?"selected":""}>[Pribadi] Mobil</option>
                        <option value="3" ${res.show.kendaraan==3?"selected":""}>[Rumah Sakit] Mobil</option>
                    `);
                    var up = JSON.parse(res.show.kendaraan_pegawai);
                    $("#kendaraan_pegawai_edit").find('option').remove();
                    res.users.forEach(pouch => {
                        $("#kendaraan_pegawai_edit").append(`
                            <option value="${pouch.id}">${pouch.nama}</option>
                        `);
                    });
                    $("#kendaraan_pegawai_edit").val(up).change();
                    $("#lama1_edit").find('option').remove();
                    $("#lama1_edit").append(`
                        <option value="1" ${res.show.lama1==1?"selected":""}>< 4 Jam (Kurang dari 4 jam)</option>
                        <option value="2" ${res.show.lama1==2?"selected":""}>> 4 Jam (Lebih dari 4 jam)</option>
                    `);
                    $('#lama2_edit').val(res.show.lama2);
                    var un = JSON.parse(res.show.pegawai_id);
                    $("#pegawai_edit").find('option').remove();
                    res.users.forEach(pounch => {
                        $("#pegawai_edit").append(`
                            <option value="${pounch.id}">${pounch.nama}</option>
                        `);
                    });
                    $("#pegawai_edit").val(un).change();
                    $('#deskripsi_edit').val(res.show.deskripsi);
                    $('#modalUbah').modal('show');
                }
            })
        }

        function prosesUbah() {
            $("#btn-ubah").prop('disabled', true);
            $("#btn-ubah").find("i").toggleClass("fa-save fa-sync fa-spin");

            var save = new FormData();
            var id = $('#id_edit').val();
            save.append('id',id);
            save.append('acara',$('#acara_edit').val());
            save.append('tgl',$('#tgl_edit').val());
            save.append('jenis',$('#jenis_edit').val());
            save.append('kendaraan',$('#kendaraan_edit').val());
            save.append('kendaraan_pegawai',JSON.stringify($('#kendaraan_pegawai_edit').val()));
            save.append('lama1',$('#lama1_edit').val());
            save.append('lama2',$('#lama2_edit').val());
            save.append('lokasi',$('#lokasi_edit').val());
            save.append('pegawai',JSON.stringify($('#pegawai_edit').val()));
            save.append('deskripsi',$('#deskripsi_edit').val());

            if (
                save.get('acara') == ""   ||
                save.get('tgl') == ""     ||
                save.get('jenis') == ""   ||
                save.get('kendaraan') == ""   ||
                save.get('lama1') == ""   ||
                // save.get('lama2') == ""   ||
                save.get('lokasi') == ""  ||
                $('#pegawai_edit').val() == ""
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
                    url: "/api/kepegawaian/pd/"+id+"/ubah",
                    method: 'post',
                    data: save,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(res){
                        notifier.show(
                            "Pesan Sukses!", "Perubahan berhasil dilakukan pada "+res.message,
                            "success", "{{ asset('images/notification/ok-48.png') }}", 4e3
                        );
                        if (res) {
                            $('#modalUbah').modal('hide');
                            showRiwayat();
                            clearInput();
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

            $("#btn-ubah").find("i").removeClass("fa-sync fa-spin").addClass("fa-save");
            $("#btn-ubah").prop('disabled', false);
        }

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
                    message: 'Mohon menyetujui untuk dilakukan penghapusan berkas tersebut',
                    position: 'topRight'
                });
            } else {
                // PROSES HAPUS
                var id = $("#id_hapus").val();
                $.ajax({
                    url: "/api/kepegawaian/pd/"+id+"/hapus",
                    type: 'DELETE',
                    success: function(res) {
                        iziToast.success({
                            title: 'Pesan Sukses!',
                            message: 'Berkas perjalanan dinas Anda telah berhasil dihapus pada '+res,
                            position: 'topRight'
                        });
                        $('#modalHapus').modal('hide');
                        showRiwayat();
                        clearInput();
                    },
                    error: function(res) {
                        iziToast.error({
                            title: 'Pesan Galat!',
                            message: 'Berkas perjalanan dinas Anda gagal dihapus',
                            position: 'topRight'
                        });
                    }
                });
            }
        }

        function clearInput() {
            // $('#filex').val('');
            $('#acara').val('');
            $('#tgl').val('');
            $('#kendaraan').val('');
            $('#kendaraan_pegawai').val('').change();
            $('#lama1').val('');
            $('#lama2').val('');
            $('#jenis').val('');
            $('#lokasi').val('');
            $('#pegawai').val('').change();
            $('#deskripsi').val('');
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
    </script>
@endsection
