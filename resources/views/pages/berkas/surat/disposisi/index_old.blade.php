@extends('layouts.default')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Berkas - Disposisi</h4>
            </div>
        </div>
    </div>

    <div class="card card-body table-responsive" style="overflow: visible;">
        <h4 classs="card-title">
            <div class="btn-group">
                <button type="button" class="btn btn-outline-warning" id="btn-refresh" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true"
                    title="Tabel Disposisi Surat Masuk akan disegarkan" onclick="refresh()">
                    <i class="fa-fw fas fa-sync nav-icon"></i>&nbsp;&nbsp;Segarkan</button>
                <button type="button" class="btn btn-outline-danger" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true"
                    title="<i class='fa-fw fas fa-infinity nav-icon'></i> <span>Tampilkan Semua Data</span>" onclick="showAll()">
                    <i class="fa-fw fas fa-infinity nav-icon"></i></button>
                <button type="button" class="btn btn-outline-secondary" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true"
                    title="Informasi Sistem Disposisi" disabled>
                    <i class="fa-fw fas fa-info nav-icon"></i>&nbsp;&nbsp;Informasi</button>
            </div>
        </h4>
        <small><i class="mdi mdi-arrow-right text-primary me-1"></i> Data default yang ditampilkan dibatasi 100 data surat</small>
        <small><i class="mdi mdi-arrow-right text-primary me-1"></i> Untuk menampilkan semua data, klik tombol berwarna <b class="text-danger">MERAH</b> di atas</small>
        <hr>
        <table id="dttable" class="table dt-responsive table-hover w-100 align-middle">
            <thead>
                <tr>
                    <th class="cell-fit"></th>
                    <th class="cell-fit">NO.SURAT</th>
                    <th class="cell-fit">TGL SURAT</th>
                    <th>ASAL/NO.SRT</th>
                    <th>DESKRIPSI</th>
                    <th>TEMPAT/ACARA</th>
                    <th>UPDATE</th>
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
                    <th class="cell-fit"></th>
                    <th class="cell-fit">NO.SURAT</th>
                    <th class="cell-fit">TGL SURAT</th>
                    <th>ASAL/NO.SRT</th>
                    <th>DESKRIPSI</th>
                    <th>TEMPAT/ACARA</th>
                    <th>UPDATE</th>
                </tr>
            </tfoot>
        </table>
    </div>

    {{-- MODAL TAMBAH --}}
    <div class="modal fade animate__animated animate__jackInTheBox" id="tambah" role="dialog" aria-labelledby="confirmFormLabel"aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        Form Upload Disposisi&nbsp;&nbsp;&nbsp;
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                        <input type="text" id="id_surat_add" class="form-control" hidden>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label for="select2Dark" class="form-label">Ditujukan Kepada <a class="text-danger">*</a></label>
                                    <div class="select2-dark">
                                        <select class="select2 form-select" name="tujuan[]" id="tujuan_add" data-allow-clear="true" data-bs-auto-close="outside" style="width: 100%" required multiple>
                                            {{-- <option value="all">Seluruh Karyawan</option> --}}
                                            @if(count($list['roles']) > 0)
                                                @foreach($list['roles'] as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label class="form-label">Tindak Lanjut <a class="text-danger">*</a></label>
                                    <textarea rows="3" class="form-control" id="tindak_lanjut_add" placeholder="..."></textarea>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label class="form-label">Deskripsi</label>
                                    <textarea rows="3" class="form-control" id="ket_add" placeholder="Optional"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Upload <a class="text-danger">*</a></label>
                            <input type="file" class="form-control mb-2" id="file_add" accept="application/pdf">
                            <i class="fa-fw fas fa-caret-right nav-icon"></i> Batas ukuran maksimum dokumen adalah <strong>20 mb</strong><br>
                            <i class="fa-fw fas fa-caret-right nav-icon"></i> File yang diupload berupa Dokumen Scan<br>
                            <i class="fa-fw fas fa-caret-right nav-icon"></i> Dijadikan dalam Satu file <strong>PDF</strong>
                        </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" id="btn-simpan" onclick="simpan()"><i class="fa-fw fas fa-upload nav-icon"></i> Upload</button>
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
                </div>
                <div class="modal-body">
                    <input type="text" id="id_hapus" hidden>
                    <p style="text-align: justify;">Anda akan menghapus <strong>Disposisi</strong> dari berkas surat masuk tersebut.
                        Penghapusan disposisi tidak akan berpengaruh pada surat masuk, tetapi isian dokumen disposisi yang sudah diupload akan ikut terhapus pada Storage Sistem.
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



            $.ajax(
                {
                    url: "/api/disposisi/data",
                    type: 'GET',
                    dataType: 'json', // added data type
                    success: function(res) {
                        $("#tampil-tbody").empty();
                        res.show.forEach(item => {
                            // var updet = item.updated_at.substring(0, 10);
                            content = "<tr id='data"+ item.id +"'>";
                            content += `<td><center><div class='btn-group'><button type='button' class='btn btn-sm btn-outline-dark btn-icon dropdown-toggle waves-effect waves-light hide-arrow' data-bs-toggle='dropdown' aria-expanded='false'><i class='bx bx-dots-vertical-rounded'></i></button><ul class='dropdown-menu dropdown-menu-right'><div class="dropdown-header noti-title"><h5 class="font-size-13 text-muted text-truncate mn-0">Menu Disposisi</h5></div>`;
                                    if (item.verif_disposisi == null) {
                                        content += `<li><a href='javascript:void(0);' class='dropdown-item text-primary' onclick="tambahDisposisi(`+item.id+`)"><i class='bx bx-plus scaleX-n1-rtl'></i> Tambah</a></li>`;
                                    } else {
                                        content += `<li><a href='javascript:void(0);' class='dropdown-item text-success' onclick="showDisposisi(`+item.id+`)"><i class='bx bx-book-open scaleX-n1-rtl'></i> Lihat</a></li>`;
                                    }
                                    // if (item.filename != null) {
                                    //     content += `<li><a href='javascript:void(0);' class='dropdown-item text-info' onclick="window.open('/berkas/disposisi/`+item.id+`')"><i class='bx bx-download scaleX-n1-rtl'></i> Unduh</a></li>`
                                    // }
                                    // if (adminID) {
                                        content += `<li><a href='javascript:void(0);' class='dropdown-item text-danger' onclick="hapus(`+item.id+`)"><i class='bx bx-trash scaleX-n1-rtl'></i> Hapus</a></li>`;
                                    // }
                            content += "</ul></center></td><td>" + item.urutan + "&nbsp;&nbsp;";
                            res.disposisi.forEach(val => {
                                if (item.id == val.id_surat) {
                                    content += '<i class="bx bxs-badge-check h5 text-info" data-bs-toggle="tooltip" data-bs-placement="top" title="Sudah Ditindak Lanjuti"></i>';
                                }
                            });
                            content += "</td><td>";
                                        if (item.tgl_surat != null) {
                                            content += item.tgl_surat;
                                        } else {
                                            content += '-';
                                        }
                            content += "</td><td style='white-space: normal !important;word-wrap: break-word;'>"
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
                            content += "</small></div></div></td><td><div class='d-flex justify-content-start align-items-center'><div class='d-flex flex-column'><h6 class='mb-0'>"
                                        + item.updated_at.substring(0, 19).replace('T',' ') + "</h6><small class='text-truncate text-muted'>";
                                        if (item.user == '84') { content += 'Sri Suryani, Amd'; }
                                        if (item.user == '293') { content += 'Zia Nuswantara pahlawan, S.H'; }
                                        if (item.user == '88') { content += 'Siti Dewi Sholikhah'; }
                                        if (item.user == '82') { content += 'Salis Annisa Hafiz, Amd.Kom'; }
                            content += "</small></div></div></td></td></tr>";
                            $('#tampil-tbody').append(content);
                        });
                        var table = $('#dttable').DataTable({
                            order: [
                                [6, "desc"]
                            ],
                            bAutoWidth: false,
                            aoColumns : [
                                { sWidth: '5%' },
                                { sWidth: '8%' },
                                { sWidth: '10%' },
                                { sWidth: '20%' },
                                { sWidth: '32%' },
                                { sWidth: '15%' },
                                { sWidth: '10%' },
                            ],
                            displayLength: 10,
                            lengthChange: true,
                            lengthMenu: [10, 25, 50, 75, 100],
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
        })

        function refresh() {
            $("#btn-refresh").prop('disabled', true);
            $("#btn-refresh").find("i").toggleClass("fa-spin");
            $("#tampil-tbody").empty().append(`<tr><td colspan="9"><center><i class="fa fa-spinner fa-spin fa-fw"></i> Memproses data...</center></td></tr>`);

            $.ajax(
                {
                    url: "/api/disposisi/data",
                    type: 'GET',
                    dataType: 'json', // added data type
                    success: function(res) {
                        $("#tampil-tbody").empty();
                        $('#dttable').DataTable().clear().destroy();
                        res.show.forEach(item => {
                            // var updet = item.updated_at.substring(0, 10);
                            content = "<tr id='data"+ item.id +"'>";
                            content += `<td><center><div class='btn-group'><button type='button' class='btn btn-sm btn-outline-dark btn-icon dropdown-toggle waves-effect waves-light hide-arrow' data-bs-toggle='dropdown' aria-expanded='false'><i class='bx bx-dots-vertical-rounded'></i></button><ul class='dropdown-menu dropdown-menu-right'><div class="dropdown-header noti-title"><h5 class="font-size-13 text-muted text-truncate mn-0">Menu Disposisi</h5></div>`;
                                    if (item.verif_disposisi == null) {
                                        content += `<li><a href='javascript:void(0);' class='dropdown-item text-primary' onclick="tambahDisposisi(`+item.id+`)"><i class='bx bx-plus scaleX-n1-rtl'></i> Tambah</a></li>`;
                                    } else {
                                        content += `<li><a href='javascript:void(0);' class='dropdown-item text-success' onclick="showDisposisi(`+item.id+`)"><i class='bx bx-book-open scaleX-n1-rtl'></i> Lihat</a></li>`;
                                    }
                                    // if (item.filename != null) {
                                    //     content += `<li><a href='javascript:void(0);' class='dropdown-item text-info' onclick="window.open('/berkas/disposisi/`+item.id+`')"><i class='bx bx-download scaleX-n1-rtl'></i> Unduh</a></li>`
                                    // }
                                    // if (adminID) {
                                        content += `<li><a href='javascript:void(0);' class='dropdown-item text-danger' onclick="hapus(`+item.id+`)"><i class='bx bx-trash scaleX-n1-rtl'></i> Hapus</a></li>`;
                                    // }
                            content += "</ul></center></td><td>" + item.urutan + "&nbsp;&nbsp;";
                            res.disposisi.forEach(val => {
                                if (item.id == val.id_surat) {
                                    content += '<i class="bx bxs-badge-check h5 text-info" data-bs-toggle="tooltip" data-bs-placement="top" title="Sudah Ditindak Lanjuti"></i>';
                                }
                            });
                            content += "</td><td>";
                                        if (item.tgl_surat != null) {
                                            content += item.tgl_surat;
                                        } else {
                                            content += '-';
                                        }
                            content += "</td><td style='white-space: normal !important;word-wrap: break-word;'>"
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
                            content += "</small></div></div></td><td><div class='d-flex justify-content-start align-items-center'><div class='d-flex flex-column'><h6 class='mb-0'>"
                                        + item.updated_at.substring(0, 19).replace('T',' ') + "</h6><small class='text-truncate text-muted'>";
                                        if (item.user == '84') { content += 'Sri Suryani, Amd'; }
                                        if (item.user == '293') { content += 'Zia Nuswantara pahlawan, S.H'; }
                                        if (item.user == '88') { content += 'Siti Dewi Sholikhah'; }
                                        if (item.user == '82') { content += 'Salis Annisa Hafiz, Amd.Kom'; }
                            content += "</small></div></div></td></td></tr>";
                            $('#tampil-tbody').append(content);
                        });
                        var table = $('#dttable').DataTable({
                            order: [
                                [6, "desc"]
                            ],
                            bAutoWidth: false,
                            aoColumns : [
                                { sWidth: '5%' },
                                { sWidth: '8%' },
                                { sWidth: '10%' },
                                { sWidth: '20%' },
                                { sWidth: '32%' },
                                { sWidth: '15%' },
                                { sWidth: '10%' },
                            ],
                            displayLength: 10,
                            lengthChange: true,
                            lengthMenu: [10, 25, 50, 75, 100],
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
            $("#btn-refresh").prop('disabled', false);
            $("#btn-refresh").find("i").removeClass("fa-spin");
        }

        function showAll() {
            $("#btn-refresh").prop('disabled', true);
            $("#btn-refresh").find("i").toggleClass("fa-spin");
            $("#tampil-tbody").empty().append(`<tr><td colspan="9"><center><i class="fa fa-spinner fa-spin fa-fw"></i> Memproses data...</center></td></tr>`);

            $.ajax(
                {
                    url: "/api/disposisi/data/all",
                    type: 'GET',
                    dataType: 'json', // added data type
                    success: function(res) {
                        $("#tampil-tbody").empty();
                        $('#dttable').DataTable().clear().destroy();
                        res.show.forEach(item => {
                            // var updet = item.updated_at.substring(0, 10);
                            content = "<tr id='data"+ item.id +"'>";
                            content += `<td><center><div class='btn-group'><button type='button' class='btn btn-sm btn-outline-dark btn-icon dropdown-toggle waves-effect waves-light hide-arrow' data-bs-toggle='dropdown' aria-expanded='false'><i class='bx bx-dots-vertical-rounded'></i></button><ul class='dropdown-menu dropdown-menu-right'><div class="dropdown-header noti-title"><h5 class="font-size-13 text-muted text-truncate mn-0">Menu Disposisi</h5></div>`;
                                    if (item.verif_disposisi == null) {
                                        content += `<li><a href='javascript:void(0);' class='dropdown-item text-primary' onclick="tambahDisposisi(`+item.id+`)"><i class='bx bx-plus scaleX-n1-rtl'></i> Tambah</a></li>`;
                                    } else {
                                        content += `<li><a href='javascript:void(0);' class='dropdown-item text-success' onclick="showDisposisi(`+item.id+`)"><i class='bx bx-book-open scaleX-n1-rtl'></i> Lihat</a></li>`;
                                    }
                                    // if (item.filename != null) {
                                    //     content += `<li><a href='javascript:void(0);' class='dropdown-item text-info' onclick="window.open('/berkas/disposisi/`+item.id+`')"><i class='bx bx-download scaleX-n1-rtl'></i> Unduh</a></li>`
                                    // }
                                    // if (adminID) {
                                        content += `<li><a href='javascript:void(0);' class='dropdown-item text-danger' onclick="hapus(`+item.id+`)"><i class='bx bx-trash scaleX-n1-rtl'></i> Hapus</a></li>`;
                                    // }
                            content += "</ul></center></td><td>" + item.urutan + "&nbsp;&nbsp;";
                            res.disposisi.forEach(val => {
                                if (item.id == val.id_surat) {
                                    content += '<i class="bx bxs-badge-check h5 text-info" data-bs-toggle="tooltip" data-bs-placement="top" title="Sudah Ditindak Lanjuti"></i>';
                                }
                            });
                            content += "</td><td>";
                                        if (item.tgl_surat != null) {
                                            content += item.tgl_surat;
                                        } else {
                                            content += '-';
                                        }
                            content += "</td><td style='white-space: normal !important;word-wrap: break-word;'>"
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
                            content += "</small></div></div></td><td><div class='d-flex justify-content-start align-items-center'><div class='d-flex flex-column'><h6 class='mb-0'>"
                                        + item.updated_at.substring(0, 19).replace('T',' ') + "</h6><small class='text-truncate text-muted'>";
                                        if (item.user == '84') { content += 'Sri Suryani, Amd'; }
                                        if (item.user == '293') { content += 'Zia Nuswantara pahlawan, S.H'; }
                                        if (item.user == '88') { content += 'Siti Dewi Sholikhah'; }
                                        if (item.user == '82') { content += 'Salis Annisa Hafiz, Amd.Kom'; }
                            content += "</small></div></div></td></td></tr>";
                            $('#tampil-tbody').append(content);
                        });
                        var table = $('#dttable').DataTable({
                            order: [
                                [6, "desc"]
                            ],
                            displayLength: 10,
                            lengthChange: true,
                            lengthMenu: [10, 25, 50, 75, 100],
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
            $("#btn-refresh").prop('disabled', false);
            $("#btn-refresh").find("i").removeClass("fa-spin");
        }

        function tambahDisposisi(id) {
            $("#id_surat_add").val(id);
            $("#tujuan_add").val("").change();
            $("#tindak_lanjut_add").val("");
            $("#ket_add").val("");
            $("#file_add").val("");
            $('#tambah').modal('show');
        }

        function simpan() {
            $("#btn-simpan").prop('disabled', true);
            $("#btn-simpan").find("i").toggleClass("fa-save fa-sync fa-spin");

            var user            = "{{ Auth::user()->id }}";
            var id_surat        = $("#id_surat_add").val();
            var tujuan          = $("#tujuan_add").val();
            var tindak_lanjut   = $("#tindak_lanjut_add").val();
            var ket             = $("#ket_add").val();
            var filex           = $('#file_add')[0].files.length;

            if (tujuan == "" || tindak_lanjut == "" || filex == 0) {
                iziToast.error({
                    title: 'Pesan Galat!',
                    message: 'Mohon lengkapi semua data terlebih dahulu dan pastikan tidak ada yang kosong',
                    position: 'topRight'
                });
            } else {
                var fd = new FormData();

                // Get the selected file
                var files = $('#file_add')[0].files;
                // console.log(files);
                fd.append('file',files[0]);

                fd.append('id_surat',id_surat);
                fd.append('user',user);
                fd.append('tujuan',tujuan);
                fd.append('tindak_lanjut',tindak_lanjut);
                fd.append('ket',ket);

                // AJAX request
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{route('disposisi.simpan')}}",
                    method: 'post',
                    data: fd,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(res){
                        iziToast.success({
                            title: 'Pesan Sukses!',
                            message: 'Disposisi Surat '+res+' berhasil ditambah',
                            position: 'topRight'
                        });
                        if (res) {
                            $('#tambah').modal('hide');
                            refresh();
                        }
                    },
                    error: function(res){
                        iziToast.error({
                            title: 'Error '+res.status+' - '+res.statusText+'!',
                            message: res.responseJSON,
                            position: 'topRight'
                        });
                        // iziToast.error({
                        //     title: 'Pesan Galat!',
                        //     message: 'Proses simpan gagal, mohon periksa kembali disposisi Anda',
                        //     position: 'topRight'
                        // });
                    }
                });
            }

            $("#btn-simpan").find("i").removeClass("fa-sync fa-spin").addClass("fa-save");
            $("#btn-simpan").prop('disabled', false);
        }

        function showDisposisi(id) {
            $('#disposisi').modal('show');
            $("#tampil-tbody-disposisi").empty().append(`<tr><td colspan="9"><center><i class="fa fa-spinner fa-spin fa-fw"></i> Memproses data...</center></td></tr>`);
            $.ajax(
                {
                    url: "/api/disposisi/data/"+id,
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
                    url: "/api/disposisi/"+id,
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
    </script>
@endsection
