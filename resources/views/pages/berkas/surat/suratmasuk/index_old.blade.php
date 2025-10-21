@extends('layouts.default')

@section('content')
{{-- @if (Auth::user()->getPermission('tu')) --}}
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Berkas - Surat Masuk</h4>
            </div>
        </div>
    </div>

    <div class="card card-body table-responsive" style="overflow: visible;">
        <div class="d-flex">
            <h4 classs="card-title flex-grow-1">
                <div class="btn-group">
                    <a class="btn btn-primary text-white" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true"
                    title="<i class='fa-fw fas fa-upload nav-icon'></i> <span>Upload Surat Masuk Baru</span>" onclick="modalTambah()">
                        <i class="bx bx-upload scaleX-n1-rtl"></i>
                        <span class="align-middle">Upload</span>
                    </a>
                    <button type="button" class="btn btn-outline-warning" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true"
                        title="<i class='fa-fw fas fa-sync nav-icon'></i> <span>Tampilkan 100 Data</span>" onclick="refresh()">
                        <i class="fa-fw fas fa-sync nav-icon"></i></button>
                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true"
                        title="<i class='fa-fw fas fa-infinity nav-icon'></i> <span>Tampilkan Semua Data</span>" onclick="showAll()">
                        <i class="fa-fw fas fa-infinity nav-icon"></i></button>
                </div>
            </h4>
            <div class="ms-auto flex-grow-0">
                <div class="float-end">
                    <div class="btn-group">
                        <h6 style="margin-top: 10px">Filter Tgl Diterima</h6>
                        <select class="form-select form-control ms-2" id="kd_bulan" onchange="getSurat()">
                            <option value="0">Pilih Bulan</option>
                            <?php
                                $bulan=array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
                                $jml_bln=count($bulan);
                                for($c=1 ; $c < $jml_bln ; $c+=1){
                                    echo"<option value=$c> $bulan[$c] </option>";
                                }
                            ?>
                        </select>
                        <select class="form-select form-control ms-2" id="kd_tahun" onchange="getSurat()">
                            <option value="0">Pilih Tahun</option>
                            @php
                                for ($i=2023; $i <= $list['year']; $i++) {
                                    echo"<option value=$i> $i </option>";
                                }

                            @endphp
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <small><i class="mdi mdi-arrow-right text-primary me-1"></i> Data default yang ditampilkan dibatasi 100 data surat</small>
        <small><i class="mdi mdi-arrow-right text-primary me-1"></i> Untuk menampilkan semua data, klik tombol berwarna <b class="text-danger">MERAH</b> di atas</small>
        <hr>
        <table id="dttable" class="table dt-responsive table-hover w-100 align-middle">
            <thead>
                <tr>
                    <th class="cell-fit">
                        <center></center>
                    </th>
                    <th class="cell-fit">NO SURAT</th>
                    <th class="cell-fit">TGL SURAT</th>
                    <th class="cell-fit">TGL DITERIMA</th>
                    <th>ASAL/NO.SRT</th>
                    <th>DESKRIPSI</th>
                    <th>TEMPAT/ACARA</th>
                    <th>UPDATE</th>
                    <th class="cell-fit">USER</th>
                </tr>
            </thead>
            <tbody id="tampil-tbody">
                <tr>
                    <td colspan="9">
                        <center><i class="fa fa-spinner fa-spin fa-fw"></i> Memproses data...</center>
                    </td>
                </tr>
            </tbody>
            <tfoot class="bg-whitesmoke">
                <tr>
                    <th class="cell-fit">
                        <center></center>
                    </th>
                    <th class="cell-fit">NO SURAT</th>
                    <th class="cell-fit">TGL SURAT</th>
                    <th class="cell-fit">TGL DITERIMA</th>
                    <th>ASAL/NO.SRT</th>
                    <th>DESKRIPSI</th>
                    <th>TEMPAT/ACARA</th>
                    <th>UPDATE</th>
                    <th class="cell-fit">USER</th>
                </tr>
            </tfoot>
        </table>
    </div>

    {{-- MODAL TAMBAH --}}
    <div class="modal fade animate__animated animate__jackInTheBox" id="tambah" role="dialog" aria-labelledby="confirmFormLabel"aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <form class="form-auth-small" name="formTambah" action="{{ route('suratmasuk.store') }}" method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                    <h4 class="modal-title">
                        Form Upload&nbsp;&nbsp;&nbsp;
                    </h4>
                    <div class="card-title-elements">
                      <select class="form-select form-select-sm" name="user" required>
                        <option value="" hidden>Pilih Petugas</option>
                        <option value="84" selected>Sri Suryani, Amd</option>
                        <option value="293">Zia Nuswantara pahlawan, S.H</option>
                        <option value="88">Siti Dewi Sholikhah</option>
                        <option value="82">Salis Annisa Hafiz, Amd.Kom</option>
                      </select>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                        @csrf
                        <div class="row">
                            <div class="col-md-2 mb-3">
                                <div class="form-group">
                                    <label class="form-label">No. Urut Surat <a class="text-danger">*</a></label>
                                    <input type="text" class="form-control" placeholder="Wajib Diisi" id="no_surat" name="no_surat" data-bs-toggle="tooltip" data-bs-offset="0,4"
                                    data-bs-placement="bottom" data-bs-html="true" title="<span>No. Urut Surat berdasarkan tahun <b>Tgl Diterima</b> surat masuk terakhir diupload</span>"/>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="form-group">
                                    <label class="form-label">Tgl. Surat</label>
                                    <input type="text" class="form-control flatpickr" placeholder="YYYY-MM-DD" name="tgl_surat"/>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="form-group">
                                    <label class="form-label">Tgl. Diterima <a class="text-danger">*</a></label>
                                    <input type="text" class="form-control flatpickrNull" placeholder="YYYY-MM-DD" name="tgl_diterima" required/>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <label class="form-label">Nomor Surat <a class="text-danger">*</a></label>
                                    <input type="text" name="nomor" class="form-control" placeholder=". . . / . . . / . . ." autofocus required/>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label class="form-label">Asal Surat <a class="text-danger">*</a></label>
                                    <input type="text" name="asal" id="cari_asal" class="form-control" placeholder="e.g. Perhimpunan Rumah Sakit Seluruh Indonesia" autocomplete="off" required/>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="form-label">Tempat</label>
                                    <input type="text" name="tempat" id="cari_tempat" class="form-control" placeholder="e.g. Hotel Syariah Surakarta" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="form-label">Acara</label>
                                    <div class="input-group input-group-merge">
                                        <input type="text" class="form-control flatpickrrange" name="waktu" placeholder="YYYY-MM-DD to YYYY-MM-DD"/>
                                        <span class="input-group-text cursor-pointer"><i class="bx bx-help-circle text-muted" data-bs-toggle="tooltip" data-bs-placement="top" title="Klik 2x apabila hanya memilih satu tanggal saja"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label class="form-label">Deskripsi</label>
                                    <textarea rows="3" class="form-control" name="deskripsi" placeholder="Optional"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Upload</label>
                            <input type="file" class="form-control mb-2" name="file" accept="application/pdf">
                            <i class="fa-fw fas fa-caret-right nav-icon"></i> Batas ukuran maksimum dokumen adalah <strong>20 mb</strong><br>
                            <i class="fa-fw fas fa-caret-right nav-icon"></i> File yang diupload berupa Dokumen Scan<br>
                            <i class="fa-fw fas fa-caret-right nav-icon"></i> Dijadikan dalam Satu file <strong>PDF</strong>
                        </div>
                </div>
                <div class="modal-footer">

                    <button class="btn btn-primary" id="btn-simpan" onclick="saveData()"><i class="fa-fw fas fa-upload nav-icon"></i> Upload</button>
                    </form>

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fa-fw fas fa-times nav-icon"></i> Tutup</button>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL UBAH --}}
    <div class="modal fade animate__animated animate__rubberBand" id="ubah" role="dialog" aria-labelledby="confirmFormLabel"aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        Form Ubah&nbsp;&nbsp;&nbsp;
                    </h4>
                    <div class="card-title-elements">
                      <select class="form-select form-select-sm" id="user" required></select>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="text" id="id_edit" hidden>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <div class="form-group">
                                <label class="form-label">Tgl. Surat</label>
                                <input type="text" class="form-control flatpickr" placeholder="YYYY-MM-DD" id="tgl_surat"/>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="form-group">
                                <label class="form-label">Tgl. Diterima <a class="text-danger">*</a></label>
                                <input type="text" class="form-control flatpickrNull" placeholder="YYYY-MM-DD" id="tgl_diterima" required/>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label class="form-label">Nomor Surat <a class="text-danger">*</a></label>
                                <input type="text" id="nomor" class="form-control" placeholder=". . . / . . . / . . ." autofocus required/>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label class="form-label">Asal Surat <a class="text-danger">*</a></label>
                                <input type="text" id="asal" class="form-control" placeholder="e.g. Perhimpunan Rumah Sakit Seluruh Indonesia" required/>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label class="form-label">Tempat</label>
                                <input type="text" id="tempat" class="form-control" placeholder="e.g. Hotel Syariah Surakarta">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label class="form-label">Acara</label>
                                <div class="input-group input-group-merge">
                                    <input type="text" class="form-control flatpickrrange" id="waktu" placeholder="YYYY-MM-DD to YYYY-MM-DD"/>
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-help-circle text-muted" data-bs-toggle="tooltip" data-bs-placement="top" title="Klik 2x apabila hanya memilih satu tanggal saja"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label class="form-label">Deskripsi</label>
                                <textarea rows="3" class="form-control" id="deskripsi" placeholder="Optional"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div id="linksurat"></div>
                        <div id="uploadFileSusulan"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" id="btn-ubah" onclick="ubahAjx()"><i class="fa-fw fas fa-save nav-icon"></i> Simpan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fa-fw fas fa-times nav-icon"></i> Tutup</button>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL HAPUS --}}
    <div class="modal animate__animated animate__rubberBand fade" id="hapus" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-simple modal-add-new-address modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        Form Hapus&nbsp;&nbsp;&nbsp;
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="text" id="id_hapus" hidden>
                    <p style="text-align: justify;">Anda akan menghapus berkas surat masuk tersebut. Penghapusan berkas akan menyebabkan hilangnya data/dokumen yang terhapus tersebut pada Storage Sistem.
                        Maka dari itu, lakukanlah dengan hati-hati. Ceklis dibawah untuk melanjutkan penghapusan.</p>
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

    {{-- MODAL LIHAT DISPOSISI --}}
    <div class="modal animate__animated animate__rubberBand fade" id="disposisi" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-simple modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        Detail Disposisi&nbsp;&nbsp;&nbsp;
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table dt-responsive table-hover table-bordered nowrap w-100 align-middle">
                        <thead>
                            <tr>
                                <th>DITUJUKAN KEPADA</th>
                                <th>TINDAK LANJUT</th>
                                <th>KETERANGAN</th>
                                <th>UPDATE</th>
                            </tr>
                        </thead>
                        <tbody id="tampil-tbody-disposisi">
                            <tr>
                                <td colspan="9">
                                    <center><i class="fa fa-spinner fa-spin fa-fw"></i> Memproses data...</center>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-12 text-center mb-4">
                    <div id="showBtnDownload"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $("body").addClass('sidebar-enable vertical-collpsed');

            // SELECT2
            var t = $(".select2");
            t.length && t.each(function() {
                var e = $(this);
                e.wrap('<div class="position-relative"></div>').select2({
                    placeholder: "Pilih",
                    dropdownParent: e.parent()
                })
            });

            // AUTOCOMPLETE ASAL
            var path_asal = "{{ route('ac.asal.cari') }}";
            $('#cari_asal').typeahead({
                source: function(query, process) {
                    return $.get(path_asal, {
                        cari: query
                    }, function(data) {
                        return process(data);
                    });
                }
            });

            // AUTOCOMPLETE TEMPAT
            var path_tempat = "{{ route('ac.tempat.cari') }}";
            $('#cari_tempat').typeahead({
                source: function(query, process) {
                    return $.get(path_asal, {
                        cari: query
                    }, function(data) {
                        return process(data);
                    });
                }
            });

            // DATEPICKER
                // DATE
                const today = new Date();
                var tomorrow = new Date(today);
                tomorrow.setDate(tomorrow.getDate() + 2);
                var next = new Date(today);
                next.setDate(next.getDate() + 999999);
                const l = $('.flatpickr');
                const ln = $('.flatpickrNull');
                // const dates = new Date(Date.now());
                // const tomorow = dates.getTime();
                // const m = new Date(Date.now());
                // const c = new Date(Date.now() + 1728e5); // 3 hari kedepan
                var now = moment().locale('id').format('Y-MM-DD HH:mm');
                l.flatpickr({
                    enableTime: 0,
                    minuteIncrement: 1,
                    // monthSelectorType: "static",
                    // inline: true,
                    // defaultHour: 12,
                    // defaultMinute: "today",
                    time_24hr: true,
                    // dateFormat: "Y-m-d H:m",
                    disable: [{
                        from: tomorrow.toISOString().split("T")[0],
                        to: next.toISOString().split("T")[0]
                    }]
                })
                ln.flatpickr({
                    enableTime: 0,
                    defaultDate: now,
                    minuteIncrement: 1,
                    time_24hr: true,
                    disable: [{
                        from: tomorrow.toISOString().split("T")[0],
                        to: next.toISOString().split("T")[0]
                    }]
                })

                // DATERANGE
                $('.flatpickrrange').flatpickr({
                    mode: "range"
                });

                // DATETIME
                $('.flatpickrtime').flatpickr({
                    enableTime: !0,
                    dateFormat: "Y-m-d H:i"
                });

            $.ajax(
                {
                    url: "/api/suratmasuk/data",
                    type: 'GET',
                    dataType: 'json', // added data type
                    success: function(res) {
                        var adminID = "{{ Auth::user()->hasRole('administrator') }}";
                        $("#tampil-tbody").empty();
                        res.show.forEach(item => {
                            // var updet = item.updated_at.substring(0, 10);
                            content = "<tr id='data"+ item.id +"'>";
                            content += `<td><center><div class='btn-group'><button type='button' class='btn btn-sm btn-outline-dark btn-icon dropdown-toggle waves-effect waves-light hide-arrow' data-bs-toggle='dropdown' aria-expanded='false'><i class='bx bx-dots-vertical-rounded'></i></button><ul class='dropdown-menu dropdown-menu-right dropend'>`
                                    + `<div class="dropdown-header noti-title"><h5 class="font-size-13 text-muted text-truncate mn-0">Menu Surat Masuk</h5></div><li><a href='javascript:void(0);' class='dropdown-item text-warning' onclick="showUbah(`+item.id+`)" value="animate__rubberBand"><i class='bx bx-edit scaleX-n1-rtl'></i> Ubah</a></li>`;
                                    if (item.filename != null) {
                                        content += `<li><a href='javascript:void(0);' class='dropdown-item text-primary' onclick="window.open('/berkas/suratmasuk/`+item.id+`/download')"><i class='bx bx-download scaleX-n1-rtl'></i> Unduh</a></li>`
                                    }
                                    // if (adminID) {
                                        content += `<li><a href='javascript:void(0);' class='dropdown-item text-danger' onclick="hapus(`+item.id+`)" value="animate__rubberBand"><i class='bx bx-trash scaleX-n1-rtl'></i> Hapus</a></li>`;
                                    // }
                            if (item.verif_disposisi == true) {
                                content += `<div class="dropdown-divider"></div><div class="dropdown-header noti-title"><h5 class="font-size-13 text-muted text-truncate mn-0">Menu Disposisi</h5></div>`;
                                content += `<li><a href='javascript:void(0);' class='dropdown-item text-success' onclick="showDisposisi(`+item.urutan+`)"><i class='bx bx-book-open scaleX-n1-rtl'></i> Lihat</a></li>`
                                content += `<li><a href='javascript:void(0);' class='dropdown-item text-info' onclick="window.open('/berkas/disposisi/`+item.id+`')"><i class='bx bx-download scaleX-n1-rtl'></i> Unduh</a></li>`
                            }
                            content += `</ul></center></td><td>` + item.urutan + `&nbsp;&nbsp;`;
                            if (item.verif_disposisi != null) {
                                content += `<i class="bx bxs-badge-check h5 text-info" data-bs-toggle="tooltip" data-bs-placement="top" title="Sudah Ada Disposisi"></i>`;
                            }
                            content += "</td><td>";
                                        if (item.tgl_surat != null) {
                                            content += item.tgl_surat;
                                        } else {
                                            content += '-';
                                        }
                            content += "</td><td>" + item.tgl_diterima + "</td><td style='white-space: normal !important;word-wrap: break-word;'>"
                                        + "<div class='d-flex justify-content-start align-items-center'><div class='d-flex flex-column'><h6 class='mb-0'>" + item.asal + "</h6><small class='text-truncate text-muted'>" + item.nomor + "</small></div></div></td><td style='white-space: normal !important;word-wrap: break-word;'>";
                                        if (item.deskripsi) {
                                            content += item.deskripsi;
                                        } else {
                                            content += '-';
                                        }
                            content += "</td><td><div class='d-flex justify-content-start align-items-center'><div class='d-flex flex-column'><h6 class='mb-0'>";
                                        if (item.tempat != null) {
                                            content += item.tempat;
                                        } else {
                                            content += '-';
                                        }
                            content += "</h6><small class='text-truncate text-muted'>";
                                        if (item.tglTo == null) {
                                            if (item.tglFrom == null) {
                                                content += '-';
                                            } else {
                                                content += item.tglFrom.substring(0, 10);
                                            }
                                        } else {
                                            content += item.tglFrom.substring(0, 10) + `&nbsp;<i class="mdi mdi-arrow-right text-primary"></i>&nbsp;` + item.tglTo.substring(0, 10);
                                        }
                            content += "</small></div></div></td><td>"
                                        + item.updated_at.substring(0, 19).replace('T',' ') + "</td><td>";
                                        if (item.user == '84') { content += 'Sri Suryani, Amd'; }
                                        if (item.user == '293') { content += 'Zia Nuswantara pahlawan, S.H'; }
                                        if (item.user == '88') { content += 'Siti Dewi Sholikhah'; }
                                        if (item.user == '82') { content += 'Salis Annisa Hafiz, Amd.Kom'; }
                            content += "</td></tr>";
                            $('#tampil-tbody').append(content);
                        });
                        var table = $('#dttable').DataTable({
                            order: [
                                [7, "desc"]
                            ],
                            displayLength: 7,
                            lengthChange: true,
                            lengthMenu: [7, 10, 25, 50, 75, 100],
                            buttons: ['copy', 'excel', 'pdf', 'colvis']
                        });

                        table.buttons().container()
                            .appendTo('#dttable_wrapper .col-md-6:eq(0)');

                        // Showing Tooltip
                        $('[data-bs-toggle="tooltip"]').tooltip({
                            trigger: 'hover'
                        })
                    }
                }
            );
        });

        // FUNCTION-FUNCTION
        function refresh() {
            $("#tampil-tbody").empty().append(`<tr><td colspan="9"><center><i class="fa fa-spinner fa-spin fa-fw"></i> Memproses data...</center></td></tr>`);
            $.ajax(
                {
                    url: "/api/suratmasuk/data",
                    type: 'GET',
                    dataType: 'json', // added data type
                    success: function(res) {
                        var adminID = "{{ Auth::user()->hasRole('administrator') }}";
                        $("#tampil-tbody").empty();
                        $('#dttable').DataTable().clear().destroy();
                        res.show.forEach(item => {
                            // var updet = item.updated_at.substring(0, 10);
                            content = "<tr id='data"+ item.id +"'>";
                            content += `<td><center><div class='btn-group'><button type='button' class='btn btn-sm btn-outline-dark btn-icon dropdown-toggle waves-effect waves-light hide-arrow' data-bs-toggle='dropdown' aria-expanded='false'><i class='bx bx-dots-vertical-rounded'></i></button><ul class='dropdown-menu dropdown-menu-right dropend'>`
                                    + `<div class="dropdown-header noti-title"><h5 class="font-size-13 text-muted text-truncate mn-0">Menu Surat Masuk</h5></div><li><a href='javascript:void(0);' class='dropdown-item text-warning' onclick="showUbah(`+item.id+`)" value="animate__rubberBand"><i class='bx bx-edit scaleX-n1-rtl'></i> Ubah</a></li>`;
                                    if (item.filename != null) {
                                        content += `<li><a href='javascript:void(0);' class='dropdown-item text-primary' onclick="window.open('/berkas/suratmasuk/`+item.id+`/download')"><i class='bx bx-download scaleX-n1-rtl'></i> Unduh</a></li>`
                                    }
                                    // if (adminID) {
                                        content += `<li><a href='javascript:void(0);' class='dropdown-item text-danger' onclick="hapus(`+item.id+`)" value="animate__rubberBand"><i class='bx bx-trash scaleX-n1-rtl'></i> Hapus</a></li>`;
                                    // }
                            if (item.verif_disposisi != null) {
                                content += `<div class="dropdown-divider"></div><div class="dropdown-header noti-title"><h5 class="font-size-13 text-muted text-truncate mn-0">Menu Disposisi</h5></div>`;
                                content += `<li><a href='javascript:void(0);' class='dropdown-item text-success' onclick="showDisposisi(`+item.urutan+`)"><i class='bx bx-book-open scaleX-n1-rtl'></i> Lihat</a></li>`
                                content += `<li><a href='javascript:void(0);' class='dropdown-item text-info' onclick="window.open('/berkas/disposisi/`+item.id+`')"><i class='bx bx-download scaleX-n1-rtl'></i> Unduh</a></li>`
                            }
                            content += `</ul></center></td><td>` + item.urutan + `&nbsp;&nbsp;`;
                            if (item.verif_disposisi != null) {
                                content += `<i class="bx bxs-badge-check h5 text-info" data-bs-toggle="tooltip" data-bs-placement="top" title="Sudah Ada Disposisi"></i>`;
                            }
                            content += "</td><td>";
                                        if (item.tgl_surat != null) {
                                            content += item.tgl_surat;
                                        } else {
                                            content += '-';
                                        }
                            content += "</td><td>" + item.tgl_diterima + "</td><td style='white-space: normal !important;word-wrap: break-word;'>"
                                        + "<div class='d-flex justify-content-start align-items-center'><div class='d-flex flex-column'><h6 class='mb-0'>" + item.asal + "</h6><small class='text-truncate text-muted'>" + item.nomor + "</small></div></div></td><td style='white-space: normal !important;word-wrap: break-word;'>";
                                        if (item.deskripsi) {
                                            content += item.deskripsi;
                                        } else {
                                            content += '-';
                                        }
                            content += "</td><td><div class='d-flex justify-content-start align-items-center'><div class='d-flex flex-column'><h6 class='mb-0'>";
                                        if (item.tempat != null) {
                                            content += item.tempat;
                                        } else {
                                            content += '-';
                                        }
                            content += "</h6><small class='text-truncate text-muted'>";
                                        if (item.tglTo == null) {
                                            if (item.tglFrom == null) {
                                                content += '-';
                                            } else {
                                                content += item.tglFrom.substring(0, 10);
                                            }
                                        } else {
                                            content += item.tglFrom.substring(0, 10) + `&nbsp;<i class="mdi mdi-arrow-right text-primary"></i>&nbsp;` + item.tglTo.substring(0, 10);
                                        }
                            content += "</small></div></div></td><td>"
                                        + item.updated_at.substring(0, 19).replace('T',' ') + "</td><td>";
                                        if (item.user == '84') { content += 'Sri Suryani, Amd'; }
                                        if (item.user == '293') { content += 'Zia Nuswantara pahlawan, S.H'; }
                                        if (item.user == '88') { content += 'Siti Dewi Sholikhah'; }
                                        if (item.user == '82') { content += 'Salis Annisa Hafiz, Amd.Kom'; }
                            content += "</td></tr>";
                            $('#tampil-tbody').append(content);
                        });
                        var table = $('#dttable').DataTable({
                            order: [
                                [7, "desc"]
                            ],
                            displayLength: 7,
                            lengthChange: true,
                            lengthMenu: [7, 10, 25, 50, 75, 100],
                            buttons: ['copy', 'excel', 'pdf', 'colvis']
                        });

                        table.buttons().container()
                            .appendTo('#dttable_wrapper .col-md-6:eq(0)');

                        // Showing Tooltip
                        $('[data-bs-toggle="tooltip"]').tooltip({
                            trigger: 'hover'
                        })
                    }
                }
            );
        }

        function getSurat() {
            $("#tampil-tbody").empty().append(`<tr><td colspan="9"><center><i class="fa fa-spinner fa-spin fa-fw"></i> Memproses data...</center></td></tr>`);
            var bulan = $("#kd_bulan").val();
            var tahun = $("#kd_tahun").val();
            $.ajax(
                {
                    url: "/api/suratmasuk/filter/"+bulan+"/"+tahun,
                    type: 'GET',
                    dataType: 'json', // added data type
                    success: function(res) {
                        var adminID = "{{ Auth::user()->hasRole('administrator') }}";
                        $("#tampil-tbody").empty();
                        $('#dttable').DataTable().clear().destroy();
                        res.show.forEach(item => {
                            // var updet = item.updated_at.substring(0, 10);
                            content = "<tr id='data"+ item.id +"'>";
                            content += `<td><center><div class='btn-group'><button type='button' class='btn btn-sm btn-outline-dark btn-icon dropdown-toggle waves-effect waves-light hide-arrow' data-bs-toggle='dropdown' aria-expanded='false'><i class='bx bx-dots-vertical-rounded'></i></button><ul class='dropdown-menu dropdown-menu-right dropend'>`
                                    + `<div class="dropdown-header noti-title"><h5 class="font-size-13 text-muted text-truncate mn-0">Menu Surat Masuk</h5></div><li><a href='javascript:void(0);' class='dropdown-item text-warning' onclick="showUbah(`+item.id+`)" value="animate__rubberBand"><i class='bx bx-edit scaleX-n1-rtl'></i> Ubah</a></li>`;
                                    if (item.filename != null) {
                                        content += `<li><a href='javascript:void(0);' class='dropdown-item text-primary' onclick="window.open('/berkas/suratmasuk/`+item.id+`/download')"><i class='bx bx-download scaleX-n1-rtl'></i> Unduh</a></li>`
                                    }
                                    // if (adminID) {
                                        content += `<li><a href='javascript:void(0);' class='dropdown-item text-danger' onclick="hapus(`+item.id+`)" value="animate__rubberBand"><i class='bx bx-trash scaleX-n1-rtl'></i> Hapus</a></li>`;
                                    // }
                            if (item.verif_disposisi != null) {
                                content += `<div class="dropdown-divider"></div><div class="dropdown-header noti-title"><h5 class="font-size-13 text-muted text-truncate mn-0">Menu Disposisi</h5></div>`;
                                content += `<li><a href='javascript:void(0);' class='dropdown-item text-success' onclick="showDisposisi(`+item.urutan+`)"><i class='bx bx-book-open scaleX-n1-rtl'></i> Lihat</a></li>`
                                content += `<li><a href='javascript:void(0);' class='dropdown-item text-info' onclick="window.open('/berkas/disposisi/`+item.id+`')"><i class='bx bx-download scaleX-n1-rtl'></i> Unduh</a></li>`
                            }
                            content += `</ul></center></td><td>` + item.urutan + `&nbsp;&nbsp;`;
                            if (item.verif_disposisi != null) {
                                content += `<i class="bx bxs-badge-check h5 text-info" data-bs-toggle="tooltip" data-bs-placement="top" title="Sudah Ada Disposisi"></i>`;
                            }
                            content += "</td><td>";
                                        if (item.tgl_surat != null) {
                                            content += item.tgl_surat;
                                        } else {
                                            content += '-';
                                        }
                            content += "</td><td>" + item.tgl_diterima + "</td><td style='white-space: normal !important;word-wrap: break-word;'>"
                                        + "<div class='d-flex justify-content-start align-items-center'><div class='d-flex flex-column'><h6 class='mb-0'>" + item.asal + "</h6><small class='text-truncate text-muted'>" + item.nomor + "</small></div></div></td><td style='white-space: normal !important;word-wrap: break-word;'>";
                                        if (item.deskripsi) {
                                            content += item.deskripsi;
                                        } else {
                                            content += '-';
                                        }
                            content += "</td><td><div class='d-flex justify-content-start align-items-center'><div class='d-flex flex-column'><h6 class='mb-0'>";
                                        if (item.tempat != null) {
                                            content += item.tempat;
                                        } else {
                                            content += '-';
                                        }
                            content += "</h6><small class='text-truncate text-muted'>";
                                        if (item.tglTo == null) {
                                            if (item.tglFrom == null) {
                                                content += '-';
                                            } else {
                                                content += item.tglFrom.substring(0, 10);
                                            }
                                        } else {
                                            content += item.tglFrom.substring(0, 10) + `&nbsp;<i class="mdi mdi-arrow-right text-primary"></i>&nbsp;` + item.tglTo.substring(0, 10);
                                        }
                            content += "</small></div></div></td><td>"
                                        + item.updated_at.substring(0, 19).replace('T',' ') + "</td><td>";
                                        if (item.user == '84') { content += 'Sri Suryani, Amd'; }
                                        if (item.user == '293') { content += 'Zia Nuswantara pahlawan, S.H'; }
                                        if (item.user == '88') { content += 'Siti Dewi Sholikhah'; }
                                        if (item.user == '82') { content += 'Salis Annisa Hafiz, Amd.Kom'; }
                            content += "</td></tr>";
                            $('#tampil-tbody').append(content);
                        });
                        var table = $('#dttable').DataTable({
                            order: [
                                [7, "desc"]
                            ],
                            displayLength: 7,
                            lengthChange: true,
                            lengthMenu: [7, 10, 25, 50, 75, 100],
                            buttons: ['copy', 'excel', 'pdf', 'colvis']
                        });

                        table.buttons().container()
                            .appendTo('#dttable_wrapper .col-md-6:eq(0)');

                        // Showing Tooltip
                        $('[data-bs-toggle="tooltip"]').tooltip({
                            trigger: 'hover'
                        })
                    }
                }
            );
        }

        function showAll() {
            $("#tampil-tbody").empty().append(`<tr><td colspan="9"><center><i class="fa fa-spinner fa-spin fa-fw"></i> Memproses data...</center></td></tr>`);
            $.ajax(
                {
                    url: "/api/suratmasuk/data/all",
                    type: 'GET',
                    dataType: 'json', // added data type
                    success: function(res) {
                        var adminID = "{{ Auth::user()->hasRole('administrator') }}";
                        $("#tampil-tbody").empty();
                        $('#dttable').DataTable().clear().destroy();
                        res.show.forEach(item => {
                            // var updet = item.updated_at.substring(0, 10);
                            content = "<tr id='data"+ item.id +"'>";
                            content += `<td><center><div class='btn-group'><button type='button' class='btn btn-sm btn-outline-dark btn-icon dropdown-toggle waves-effect waves-light hide-arrow' data-bs-toggle='dropdown' aria-expanded='false'><i class='bx bx-dots-vertical-rounded'></i></button><ul class='dropdown-menu dropdown-menu-right dropend'>`
                                    + `<div class="dropdown-header noti-title"><h5 class="font-size-13 text-muted text-truncate mn-0">Menu Surat Masuk</h5></div><li><a href='javascript:void(0);' class='dropdown-item text-warning' onclick="showUbah(`+item.id+`)" value="animate__rubberBand"><i class='bx bx-edit scaleX-n1-rtl'></i> Ubah</a></li>`;
                                    if (item.filename != null) {
                                        content += `<li><a href='javascript:void(0);' class='dropdown-item text-primary' onclick="window.open('/berkas/suratmasuk/`+item.id+`/download')"><i class='bx bx-download scaleX-n1-rtl'></i> Unduh</a></li>`
                                    }
                                    // if (adminID) {
                                        content += `<li><a href='javascript:void(0);' class='dropdown-item text-danger' onclick="hapus(`+item.id+`)" value="animate__rubberBand"><i class='bx bx-trash scaleX-n1-rtl'></i> Hapus</a></li>`;
                                    // }
                            if (item.verif_disposisi != null) {
                                content += `<div class="dropdown-divider"></div><div class="dropdown-header noti-title"><h5 class="font-size-13 text-muted text-truncate mn-0">Menu Disposisi</h5></div>`;
                                content += `<li><a href='javascript:void(0);' class='dropdown-item text-success' onclick="showDisposisi(`+item.urutan+`)"><i class='bx bx-book-open scaleX-n1-rtl'></i> Lihat</a></li>`
                                content += `<li><a href='javascript:void(0);' class='dropdown-item text-info' onclick="window.open('/berkas/disposisi/`+item.id+`')"><i class='bx bx-download scaleX-n1-rtl'></i> Unduh</a></li>`
                            }
                            content += `</ul></center></td><td>` + item.urutan + `&nbsp;&nbsp;`;
                            if (item.verif_disposisi != null) {
                                content += `<i class="bx bxs-badge-check h5 text-info" data-bs-toggle="tooltip" data-bs-placement="top" title="Sudah Ada Disposisi"></i>`;
                            }
                            content += "</td><td>";
                                        if (item.tgl_surat != null) {
                                            content += item.tgl_surat;
                                        } else {
                                            content += '-';
                                        }
                            content += "</td><td>" + item.tgl_diterima + "</td><td style='white-space: normal !important;word-wrap: break-word;'>"
                                        + "<div class='d-flex justify-content-start align-items-center'><div class='d-flex flex-column'><h6 class='mb-0'>" + item.asal + "</h6><small class='text-truncate text-muted'>" + item.nomor + "</small></div></div></td><td style='white-space: normal !important;word-wrap: break-word;'>";
                                        if (item.deskripsi) {
                                            content += item.deskripsi;
                                        } else {
                                            content += '-';
                                        }
                            content += "</td><td><div class='d-flex justify-content-start align-items-center'><div class='d-flex flex-column'><h6 class='mb-0'>";
                                        if (item.tempat != null) {
                                            content += item.tempat;
                                        } else {
                                            content += '-';
                                        }
                            content += "</h6><small class='text-truncate text-muted'>";
                                        if (item.tglTo == null) {
                                            if (item.tglFrom == null) {
                                                content += '-';
                                            } else {
                                                content += item.tglFrom.substring(0, 10);
                                            }
                                        } else {
                                            content += item.tglFrom.substring(0, 10) + `&nbsp;<i class="mdi mdi-arrow-right text-primary"></i>&nbsp;` + item.tglTo.substring(0, 10);
                                        }
                            content += "</small></div></div></td><td>"
                                        + item.updated_at.substring(0, 19).replace('T',' ') + "</td><td>";
                                        if (item.user == '84') { content += 'Sri Suryani, Amd'; }
                                        if (item.user == '293') { content += 'Zia Nuswantara pahlawan, S.H'; }
                                        if (item.user == '88') { content += 'Siti Dewi Sholikhah'; }
                                        if (item.user == '82') { content += 'Salis Annisa Hafiz, Amd.Kom'; }
                            content += "</td></tr>";
                            $('#tampil-tbody').append(content);
                        });
                        var table = $('#dttable').DataTable({
                            order: [
                                [7, "desc"]
                            ],
                            displayLength: 7,
                            lengthChange: true,
                            lengthMenu: [7, 10, 25, 50, 75, 100],
                            buttons: ['copy', 'excel', 'pdf', 'colvis']
                        });

                        table.buttons().container()
                            .appendTo('#dttable_wrapper .col-md-6:eq(0)');

                        // Showing Tooltip
                        $('[data-bs-toggle="tooltip"]').tooltip({
                            trigger: 'hover'
                        })
                    }
                }
            );
        }

        function modalTambah() {
            $('#tambah').modal('show');

            $.ajax(
            {
                url: "/api/suratmasuk/tambah",
                type: 'GET',
                dataType: 'json', // added data type
                success: function(res) {
                    $('#no_surat').val(res.show);
                }
            })
        }

        function getDateTime() {
            var now     = new Date();
            var year    = now.getFullYear();
            var month   = now.getMonth()+1;
            var day     = now.getDate();
            if(month.toString().length == 1) {
                    month = '0'+month;
            }
            if(day.toString().length == 1) {
                    day = '0'+day;
            }
            var dateTime = year+'-'+month+'-'+day;
            return dateTime;
        }

        function ubahFile(id) {
            $('#linksurat').empty();
            document.getElementById('uploadFileSusulan').innerHTML = `
            <label class='form-label'>Berkas Surat Anda <a class='text-danger'>*</a></label>
            <input type='file' id="filex`+id+`" name='filex`+id+`' class="form-control mb-2" accept="application/pdf">
            <input type="text" class="form-control" id="verifberkas`+id+`" hidden>
            <i class="fa-fw fas fa-caret-right nav-icon"></i> Batas ukuran maksimum dokumen adalah <strong>20 mb</strong><br>
            <i class="fa-fw fas fa-caret-right nav-icon"></i> File yang diupload berupa Dokumen Scan<br>
            <i class="fa-fw fas fa-caret-right nav-icon"></i> Dijadikan dalam Satu file <strong>PDF</strong>`;
            $("#verifberkas"+id).val(1);
        }

        function showUbah(id) {
            $('#uploadFileSusulan').empty();
            $('#linksurat').empty();
            $.ajax(
            {
                url: "/api/suratmasuk/data/"+id,
                type: 'GET',
                dataType: 'json', // added data type
                success: function(res) {
                    $('#ubah').modal('show');
                    // var dt = new Date(res.show.tanggal).toJSON().slice(0,19);
                    var dt = moment(res.show.tanggal).format('Y-MM-DD HH:mm');
                    if (res.show.filename != null) {
                        document.getElementById('linksurat').innerHTML = `
                        <label class='form-label'>Berkas Surat Anda <a class='text-danger'>*</a></label>&nbsp;&nbsp;
                        <button class='btn btn-sm btn-outline-dark' type='button' onclick='ubahFile(`+id+`)'>Ubah File</button>
                        <h6 class='mb-2'><a href='/berkas/suratkeluar/`+res.show.id+`/download'>`+res.show.title+`</a></h6>
                        <input type="text" class="form-control" id="verifberkas`+res.show.id+`" hidden>`;
                        $("#verifberkas"+res.show.id).val(0);
                    } else {
                        document.getElementById('linksurat').innerHTML = `
                        <label class='form-label'>Berkas Surat Anda <a class='text-danger'>*</a></label>
                        <input type='file' id="filex`+res.show.id+`" name='filex`+res.show.id+`' class="form-control mb-2" accept="application/pdf">
                        <input type="text" class="form-control" id="verifberkas`+res.show.id+`" hidden>
                        <i class="fa-fw fas fa-caret-right nav-icon"></i> Batas ukuran maksimum dokumen adalah <strong>20 mb</strong><br>
                        <i class="fa-fw fas fa-caret-right nav-icon"></i> File yang diupload berupa Dokumen Scan<br>
                        <i class="fa-fw fas fa-caret-right nav-icon"></i> Dijadikan dalam Satu file <strong>PDF</strong>`;
                        $("#verifberkas"+res.show.id).val(1);
                    }
                    $("#id_edit").val(res.show.id);

                    // INIT DATE
                    const today = new Date();
                    var tomorrow = new Date(today);
                    tomorrow.setDate(tomorrow.getDate() + 2);
                    var next = new Date(today);
                    next.setDate(next.getDate() + 999999);
                        // TGL SURAT EDIT
                        var a = document.querySelector("#tgl_surat");
                        var b = new Date(Date.now() - 1728e5);
                        a.flatpickr({
                            enableTime: 0,
                            minuteIncrement: 1,
                            defaultDate: res.show.tgl_surat,
                            time_24hr: true,
                            disable: [{
                                from: tomorrow.toISOString().split("T")[0],
                                to: next.toISOString().split("T")[0]
                            }]
                        })
                        // TGL DITERIMA EDIT
                        var a = document.querySelector("#tgl_diterima");
                        var b = new Date(Date.now() - 1728e5);
                        a.flatpickr({
                            enableTime: 0,
                            minuteIncrement: 1,
                            defaultDate: res.show.tgl_diterima,
                            time_24hr: true,
                            disable: [{
                                from: tomorrow.toISOString().split("T")[0],
                                to: next.toISOString().split("T")[0]
                            }]
                        })

                    $("#asal").val(res.show.asal);
                    $("#nomor").val(res.show.nomor);
                    $("#deskripsi").val(res.show.deskripsi);
                    $("#tempat").val(res.show.tempat);
                    $("#waktu").val(res.waktu);
                    $("#user").find('option').remove();
                    $("#user").append(`
                        <option value="84" ${res.show.user == '84' ? "selected":""}>Sri Suryani, Amd</option>
                        <option value="293" ${res.show.user == '293' ? "selected":""}>Zia Nuswantara pahlawan, S.H</option>
                        <option value="88" ${res.show.user == '88' ? "selected":""}>Siti Dewi Sholikhah</option>
                        <option value="82" ${res.show.user == '82' ? "selected":""}>Salis Annisa Hafiz, Amd.Kom</option>
                    `);
                }
            }
            );
        }

        // function ubah() {
        //     $("#btn-ubah").prop('disabled', true);
        //     $("#btn-ubah").find("i").toggleClass("fa-save fa-sync fa-spin");

        //     var id              = $("#id_edit").val();
        //     var tgl_surat       = $("#tgl_surat").val();
        //     var tgl_diterima    = $("#tgl_diterima").val();
        //     var asal            = $("#asal").val();
        //     var nomor           = $("#nomor").val();
        //     var deskripsi       = $("#deskripsi").val();
        //     var tempat          = $("#tempat").val();
        //     var waktu           = $("#waktu").val();
        //     var user            = $("#user").val();

        //     // console.log(file);
        //     if (user == "" || tgl_diterima == "" || nomor == "" || asal == "") {
        //         iziToast.error({
        //             title: 'Pesan Galat!',
        //             message: 'Mohon lengkapi kolom pengisian wajib *',
        //             position: 'topRight'
        //         });
        //     } else {
        //         $.ajax({
        //             headers: {
        //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //             },
        //             method: 'PUT',
        //             url: '/api/suratmasuk/'+id,
        //             // dataType: 'json',
        //             data: {
        //                 id: id,
        //                 tgl_surat: tgl_surat,
        //                 tgl_diterima: tgl_diterima,
        //                 asal: asal,
        //                 nomor: nomor,
        //                 deskripsi: deskripsi,
        //                 tempat: tempat,
        //                 waktu: waktu,
        //                 user: user,
        //             },
        //             // data: formData,
        //             // cache: false,
        //             // processData: false,
        //             // contentType: false,
        //             // enctype: 'multipart/form-data',
        //             success: function(res) {
        //                 iziToast.success({
        //                     title: 'Pesan Sukses!',
        //                     message: 'Surat Masuk berhasil diperbarui pada '+res,
        //                     position: 'topRight'
        //                 });
        //                 if (res) {
        //                     $('#ubah').modal('hide');
        //                     fresh();
        //                     refresh();
        //                     // window.location.reload();
        //                 }
        //             }
        //         });
        //     }
        //     $("#btn-ubah").find("i").removeClass("fa-sync fa-spin").addClass("fa-save");
        //     $("#btn-ubah").prop('disabled', false);
        // }

        function ubahAjx() {
            $("#btn-ubah").prop('disabled', true);
            $("#btn-ubah").find("i").toggleClass("fa-save fa-sync fa-spin");

            if (user == "" || tgl_diterima == "" || nomor == "" || asal == "") {
                iziToast.error({
                    title: 'Pesan Galat!',
                    message: 'Mohon lengkapi kolom pengisian wajib *',
                    position: 'topRight'
                });
            } else {
                var fd = new FormData();
                var id_edit = $("#id_edit").val();

                // Get the selected file
                if ($("#verifberkas"+id_edit).val() == 1) {
                    var files = $('#filex'+id_edit)[0].files;
                    fd.append('file',files[0]);
                }

                fd.append('id_edit',$("#id_edit").val());
                fd.append('tgl_surat',$("#tgl_surat").val());
                fd.append('tgl_diterima',$("#tgl_diterima").val());
                fd.append('asal',$("#asal").val());
                fd.append('nomor',$("#nomor").val());
                fd.append('deskripsi',$("#deskripsi").val());
                fd.append('tempat',$("#tempat").val());
                fd.append('waktu',$("#waktu").val());
                fd.append('user',$("#user").val());

                // if(files.length > 0){

                //     // Append data
                // }else{
                //     iziToast.error({
                //         title: 'Pesan Galat!',
                //         message: 'Mohon upload berkas file Surat Masuk terlebih dahulu sebelum menyimpan.',
                //         position: 'topRight'
                //     });
                // }
                // fd.append('_token',CSRF_TOKEN);

                // Hide alert
                // $('#responseMsg').hide();

                // AJAX request
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{route('suratmasuk.ubah')}}",
                    method: 'post',
                    data: fd,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(res){
                        iziToast.success({
                            title: 'Pesan Sukses!',
                            message: 'Surat Masuk berhasil diperbarui pada '+res,
                            position: 'topRight'
                        });
                        if (res) {
                            $('#ubah').modal('hide');
                            refresh();
                            // window.location.reload();
                        }
                    },
                    error: function(res){
                        console.log("error : " + JSON.stringify(res) );
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
            $('#hapus').modal('show');
        }

        function prosesHapus() {
            // SWITCH BTN HAPUS
            var checkboxHapus = $('#setujuhapus').is(":checked");
            if (checkboxHapus == false) {
                iziToast.error({
                    title: 'Pesan Galat!',
                    message: 'Mohon menyetujui untuk dilakukan penghapusan berkas',
                    position: 'topRight'
                });
            } else {
                // PROSES HAPUS
                var id = $("#id_hapus").val();
                $.ajax({
                    url: "/api/suratmasuk/"+id,
                    type: 'DELETE',
                    success: function(res) {
                        iziToast.success({
                            title: 'Pesan Sukses!',
                            message: 'Berkas telah berhasil dihapus pada '+res,
                            position: 'topRight'
                        });
                        $('#hapus').modal('hide');
                        refresh();
                        // window.location.reload();
                    },
                    error: function(res) {
                        iziToast.error({
                            title: 'Pesan Galat!',
                            message: 'Berkas gagal dihapus',
                            position: 'topRight'
                        });
                    }
                });
            }
        }

        function showDisposisi(id) {
            $('#disposisi').modal('show');
            $("#tampil-tbody-disposisi").empty().append(`<tr><td colspan="9"><center><i class="fa fa-spinner fa-spin fa-fw"></i> Memproses data...</center></td></tr>`);
            $.ajax(
                {
                    url: "/api/suratmasuk/data/disposisi/"+id,
                    type: 'GET',
                    dataType: 'json', // added data type
                    success: function(res) {
                        $("#tampil-tbody-disposisi").empty();
                        res.show.forEach(item => {
                            if (item.filename != null) {
                                $('#showBtnDownload').empty();
                                $('#showBtnDownload').append(`<button class='btn btn-info' onclick="window.open('/berkas/disposisi/`+item.id_surat+`')"><i class='bx bx-download scaleX-n1-rtl'></i> Unduh <span class="badge bg-light">`+item.title+`</span></button>`);
                            }
                            // var updet = item.updated_at.substring(0, 10);
                            content = "<tr id='data"+ item.id +"'><td>";
                            var tujuan = JSON.parse(item.tujuan);
                            tujuan.forEach(tuju => {
                                res.roles.forEach(val => {
                                    if (tuju == val.id) {
                                        content += `<kbd>`+val.name+`</kbd>&nbsp;`;
                                    }
                                })
                            })
                            content += `</td><td>`+item.tindak_lanjut+`</td><td>`;
                            if (item.ket != null) {
                                content += item.ket;
                            }
                            content += `</td><td>`+item.updated_at.substring(0, 19).replace('T',' ')+`</td></tr>`;
                        })
                        $('#tampil-tbody-disposisi').append(content);
                    }
                }
            )
        }

        function saveData() {
            $("#tambah").one('submit', function() {
                //stop submitting the form to see the disabled button effect
                $("#btn-simpan").attr('disabled','disabled');
                $("#btn-simpan").find("i").removeClass("fa-upload").addClass("fa-sync fa-spin");
                // $('#tambah').modal('hide');
                // fresh();
                // refresh();
                return true;
            });
        }
    </script>
{{-- @endif --}}
@endsection
