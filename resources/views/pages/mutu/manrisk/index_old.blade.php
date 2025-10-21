@extends('layouts.default')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Mutu - Manajemen Risiko</h4>
            </div>
        </div>
    </div>

    <div class="card card-body table-responsive" style="overflow: visible;">
        <h4 classs="card-title">
            <div class="btn-group">
                <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#tambah"><i
                        class="mdi mdi-microsoft-excel"></i>&nbsp;&nbsp;Upload Berkas Excel</button>
                <button type="button" class="btn btn-outline-warning" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true"
                    title="<i class='fa-fw fas fa-sync nav-icon'></i> <span>Segarkan Tabel</span>" onclick="refresh()">
                    <i class="fa-fw fas fa-sync nav-icon"></i></button>
            </div>
        </h4>
        <hr>
        <table id="dttable" class="table dt-responsive table-hover w-100 align-middle">
            <thead>
                <tr>
                    <th class="cell-fit"></th>
                    <th class="cell-fit">ID</th>
                    <th>JUDUL</th>
                    <th>BULAN</th>
                    <th>TAHUN</th>
                    <th>KETERANGAN</th>
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
                    <th class="cell-fit">ID</th>
                    <th>JUDUL</th>
                    <th>BULAN</th>
                    <th>TAHUN</th>
                    <th>KETERANGAN</th>
                    <th>UPDATE</th>
                </tr>
            </tfoot>
        </table>
    </div>

    {{-- MODAL START --}}
    <div class="modal fade bd-example-modal-lg" id="tambah" role="dialog" aria-labelledby="confirmFormLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        <i class="mdi mdi-microsoft-excel"></i> Form Upload
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="form-auth-small" name="formTambah" action="{{ route('manrisk.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label class="mb-2">Judul <a class="text-danger">*</a></label>
                                    <input type="text" name="judul" id="judul" class="form-control"
                                        placeholder="e.g. Manajemen Risiko Unit Bangsal X" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label>Bulan <a class="text-danger">*</a></label>
                                    <select class="select2 form-control" name="bln" id="bln-tambah" style="width: 100%" required>
                                        <option value="" hidden> Pilih Bulan</option>
                                        <?php
                                        $tahun = \Carbon\Carbon::now()->isoFormat('YYYY');
                                        $bulan = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                                        $jml_bln = count($bulan);
                                        for ($c = 1; $c < $jml_bln; $c += 1) {
                                            echo "<option value=$c> $bulan[$c] </option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label>Tahun <a class="text-danger">*</a></label>
                                    <select class="select2 form-control" name="thn" id="thn-tambah" style="width: 100%" required>
                                        <option value="" hidden>Pilih Tahun</option>
                                        @php
                                            for ($i = 2023; $i <= $tahun; $i++) {
                                                echo "<option value=$i> $i </option>";
                                            }
                                        @endphp
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label class="mb-2">Keterangan</label>
                            <textarea maxlength="200" rows="2" placeholder="Keterangan terbatas hanya 200 karakter." class="form-control"
                                name="keterangan" id="keterangan" placeholder="Optional"></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label>Upload Berkas Excel <a class="text-danger">*</a></label>
                            <input type="file" name="file" class="form-control mb-2" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" required>
                            {{-- <input type="file" name="file" class="form-control mb-2" required> --}}
                            <i class="fa-fw fas fa-caret-right nav-icon"></i> File yang diupload berupa Dokumen Excel (Berformat <strong>.xlsx</strong>)<br>
                            <i class="fa-fw fas fa-caret-right nav-icon"></i> Batas ukuran maksimum dokumen adalah
                            <strong>1 mb</strong>
                        </div>
                </div>
                <div class="modal-footer">

                    <button class="btn btn-primary" id="btn-simpan" onclick="saveData()"><i
                            class="fa-fw fas fa-save nav-icon"></i> Upload</button>
                    </form>

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i
                            class="fa-fw fas fa-times nav-icon"></i> Tutup</button>
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="modal fade bd-example-modal-lg" id="ubah" role="dialog" aria-labelledby="confirmFormLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        Form Ubah Berkas&nbsp;<kbd><a id="show_edit"></a></kbd>
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="text" id="id_edit" class="form-control" hidden>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label>Judul</label>
                                <input type="text" id="judul_edit" class="form-control"
                                    placeholder="Laporan Bulanan Unit X" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label>Bulan</label>
                                <select class="select2 form-control" id="bln_edit" style="width: 100%" required></select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label>Tahun</label>
                                <select class="select2 form-control" id="thn_edit" style="width: 100%" required></select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label class="mb-2">Keterangan :</label>
                                <textarea  maxlength="200" rows="3" placeholder="Keterangan terbatas hanya 200 karakter." class="form-control" id="keterangan_edit" ></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            Dokumen Upload
                            <div id="file_edit"></div>
                        </div>
                    </div>
                    <sub><i class="fa-fw fas fa-caret-right nav-icon"></i> Waktu pengubahan berkas rapat hanya berlaku pada
                        hari saat anda mengupload</sub><br>
                    <sub><i class="fa-fw fas fa-caret-right nav-icon"></i> Periksa ulang lampiran berkas anda, apabila
                        terdapat kesalahan upload dokumen mohon hapus dan upload ulang</sub>

                </div>
                <div class="modal-footer">
                    Ditambahkan oleh&nbsp;<a id="user_edit"></a>
                    <button class="btn btn-primary" id="submit_edit" onclick="ubah()"><i
                            class="fa-fw fas fa-save nav-icon"></i> Simpan</button>
                    </form>

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i
                            class="fa-fw fas fa-times nav-icon"></i> Tutup</button>
                </div>
            </div>
        </div>
    </div> --}}

    <script>
        $(document).ready(function() {

            $.ajax({
                url: "/api/manrisk/data",
                type: 'GET',
                dataType: 'json', // added data type
                success: function(res) {
                    $("#tampil-tbody").empty();
                    var userID = "{{ Auth::user()->id }}";
                    var adminID = "{{ Auth::user()->getManyRole(['k3','it']) }}";
                    var date = new Date().toLocaleDateString();
                    res.show.forEach(item => {
                        if (item.unit) {
                            try {
                                var un = JSON.parse(item.unit);
                            } catch (e) {
                                var un = item.unit;
                            }
                        }
                        if (un !== null) {
                            un = un.toString().replaceAll(',', ', ').replaceAll('-', ' ');
                        } else {
                            un = '';
                        }
                        var updet = new Date(item.updated_at).toLocaleDateString();

                        content = "<tr id='data" + item.id + "'>";

                        content += `<td><center><div class='btn-group'>
                                        <button type='button' class='btn btn-sm btn-primary btn-icon dropdown-toggle hide-arrow' data-bs-toggle='dropdown' aria-expanded='false'><i class='bx bx-dots-vertical-rounded'></i></button>
                                        <ul class='dropdown-menu dropdown-menu-right dropend'>`;
                        if (adminID == true) {
                            content +=
                                `<li><a href="javascript:void(0);" class='dropdown-item text-success' onclick="window.open('/mutu/manrisk/`+item.id+`/download')"><i class="fa-fw fas fa-download nav-icon"></i> Download</a></li>
                                <li><a href='javascript:void(0);' class='dropdown-item text-danger' onclick="hapus(` + item.id + `)"><i class="fa-fw fas fa-trash nav-icon"></i> Hapus</a></li>`;
                        } else {
                            if (item.id_user == userID) {
                                if (updet == date) {
                                    content +=
                                        `<li><a href="javascript:void(0);" class='dropdown-item text-success' onclick="window.open('/mutu/manrisk/`+item.id+`/download')"><i class="fa-fw fas fa-download nav-icon"></i> Download</a></li>
                                        <li><a href='javascript:void(0);' class='dropdown-item text-danger' onclick="hapus(` + item.id + `)"><i class="fa-fw fas fa-trash nav-icon"></i> Hapus</a></li>`;
                                } else {
                                    content +=
                                        `<li><a href="javascript:void(0);" class='dropdown-item text-success' onclick="window.open('/mutu/manrisk/`+item.id+`/download')"><i class="fa-fw fas fa-download nav-icon"></i> Download</a></li>
                                        <li><a href='javascript:void(0);' class='dropdown-item text-secondary'><i class="fa-fw fas fa-trash nav-icon"></i> Hapus</a></li>`;
                                }
                            } else {
                                content +=
                                    `<li><a href="javascript:void(0);" class='dropdown-item text-secondary'><i class="fa-fw fas fa-download nav-icon"></i> Download</a></li>
                                    <li><a href='javascript:void(0);' class='dropdown-item text-secondary'><i class="fa-fw fas fa-trash nav-icon"></i> Hapus</a></li>`;
                            }
                        }
                        content += "</div></center></td><td>" +
                            item.id +
                            "</td><td style='white-space: normal !important;word-wrap: break-word;'>" +
                            "<div class='d-flex justify-content-start align-items-center'><div class='d-flex flex-column'><h6 class='mb-0'>" + item.judul + "</h6><small class='text-truncate text-muted'>" + un + "</small></div></div>" +
                            "</td><td>" +
                            item.bln + "</td><td>" +
                            item.thn + "</td><td style='white-space: normal !important;word-wrap: break-word;'>";
                        if (item.keterangan != null) {
                            content += item.keterangan;
                        }
                        content += '</td><td>' +
                            new Date(item.updated_at).toLocaleString('sv-SE') + '</td>';
                        content += "</tr>";
                        $('#tampil-tbody').append(content);
                    });
                    var table = $('#dttable').DataTable({
                        order: [
                            [6, "desc"]
                        ],
                        bAutoWidth: false,
                        aoColumns : [
                            { sWidth: '5%' },
                            { sWidth: '5%' },
                            { sWidth: '32%' },
                            { sWidth: '8%' },
                            { sWidth: '8%' },
                            { sWidth: '32%' },
                            { sWidth: '10%' },
                        ],
                        displayLength: 7,
                        lengthChange: true,
                        lengthMenu: [7, 10, 25, 50, 75, 100],
                        buttons: ['copy', 'excel', 'pdf', 'colvis']
                    });
                }
            });
        })

        function refresh() {
            $("#tampil-tbody").empty().append(`<tr><td colspan="9"><center><i class="fa fa-spinner fa-spin fa-fw"></i> Memproses data...</center></td></tr>`);

            $.ajax({
                url: "/api/manrisk/data",
                type: 'GET',
                dataType: 'json', // added data type
                success: function(res) {
                    $("#tampil-tbody").empty();
                    $('#dttable').DataTable().clear().destroy();
                    var userID = "{{ Auth::user()->id }}";
                    var adminID = "{{ Auth::user()->getManyRole(['k3','it']) }}";
                    var date = new Date().toLocaleDateString();
                    res.show.forEach(item => {
                        if (item.unit) {
                            try {
                                var un = JSON.parse(item.unit);
                            } catch (e) {
                                var un = item.unit;
                            }
                        }
                        if (un !== null) {
                            un = un.toString().replaceAll(',', ', ').replaceAll('-', ' ');
                        } else {
                            un = '';
                        }
                        var updet = new Date(item.updated_at).toLocaleDateString();

                        content = "<tr id='data" + item.id + "'>";

                        content += `<td><center><div class='btn-group'>
                                        <button type='button' class='btn btn-sm btn-primary btn-icon dropdown-toggle hide-arrow' data-bs-toggle='dropdown' aria-expanded='false'><i class='bx bx-dots-vertical-rounded'></i></button>
                                        <ul class='dropdown-menu dropdown-menu-right dropend'>`;
                        if (adminID == true) {
                            content +=
                                `<li><a href="javascript:void(0);" class='dropdown-item text-success' onclick="window.open('/mutu/manrisk/`+item.id+`/download')"><i class="fa-fw fas fa-download nav-icon"></i> Download</a></li>
                                <li><a href='javascript:void(0);' class='dropdown-item text-danger' onclick="hapus(` + item.id + `)"><i class="fa-fw fas fa-trash nav-icon"></i> Hapus</a></li>`;
                        } else {
                            if (item.id_user == userID) {
                                if (updet == date) {
                                    content +=
                                        `<li><a href="javascript:void(0);" class='dropdown-item text-success' onclick="window.open('/mutu/manrisk/`+item.id+`/download')"><i class="fa-fw fas fa-download nav-icon"></i> Download</a></li>
                                        <li><a href='javascript:void(0);' class='dropdown-item text-danger' onclick="hapus(` + item.id + `)"><i class="fa-fw fas fa-trash nav-icon"></i> Hapus</a></li>`;
                                } else {
                                    content +=
                                        `<li><a href="javascript:void(0);" class='dropdown-item text-success' onclick="window.open('/mutu/manrisk/`+item.id+`/download')"><i class="fa-fw fas fa-download nav-icon"></i> Download</a></li>
                                        <li><a href='javascript:void(0);' class='dropdown-item text-secondary'><i class="fa-fw fas fa-trash nav-icon"></i> Hapus</a></li>`;
                                }
                            } else {
                                content +=
                                    `<li><a href="javascript:void(0);" class='dropdown-item text-secondary'><i class="fa-fw fas fa-download nav-icon"></i> Download</a></li>
                                    <li><a href='javascript:void(0);' class='dropdown-item text-secondary'><i class="fa-fw fas fa-trash nav-icon"></i> Hapus</a></li>`;
                            }
                        }
                        content += "</div></center></td><td>" +
                            item.id +
                            "</td><td style='white-space: normal !important;word-wrap: break-word;'>" +
                            "<div class='d-flex justify-content-start align-items-center'><div class='d-flex flex-column'><h6 class='mb-0'>" + item.judul + "</h6><small class='text-truncate text-muted'>" + un + "</small></div></div>" +
                            "</td><td>" +
                            item.bln + "</td><td>" +
                            item.thn + "</td><td style='white-space: normal !important;word-wrap: break-word;'>";
                        if (item.keterangan != null) {
                            content += item.keterangan;
                        }
                        content += '</td><td>' +
                            new Date(item.updated_at).toLocaleString('sv-SE') + '</td>';
                        content += "</tr>";
                        $('#tampil-tbody').append(content);
                    });
                    var table = $('#dttable').DataTable({
                        order: [
                            [6, "desc"]
                        ],
                        displayLength: 7,
                        lengthChange: true,
                        lengthMenu: [7, 10, 25, 50, 75, 100],
                        buttons: ['copy', 'excel', 'pdf', 'colvis']
                    });
                }
            });
        }

        function saveData() {
            $("#tambah").one('submit', function() {
                $("#btn-simpan").attr('disabled', 'disabled');
                $("#btn-simpan").find("i").toggleClass("fa-save fa-spinner fa-spin");
                return true;
            });
        }

        function hapus(id) {
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: 'Ingin menghapus Berkas Mutu ID : ' + id,
                icon: 'warning',
                reverseButtons: false,
                showDenyButton: false,
                showCloseButton: false,
                showCancelButton: true,
                focusCancel: true,
                confirmButtonColor: '#FF4845',
                confirmButtonText: `<i class="fa fa-trash me-1" style="font-size:13px"></i> Hapus`,
                cancelButtonText: `<i class="fa fa-times me-1" style="font-size:13px"></i> Batal`,
                backdrop: `rgba(26,27,41,0.8)`,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "/api/manrisk/hapus/" + id,
                        type: 'GET',
                        dataType: 'json', // added data type
                        success: function(res) {
                            iziToast.success({
                                title: 'Pesan Sukses!',
                                message: 'Berkas telah berhasil dihapus',
                                position: 'topRight'
                            });
                            refresh();
                            // window.location.reload();
                        },
                        error: function(res) {
                            iziToast.error({
                                title: 'Pesan Galat!',
                                message: 'Berkas gagal diupload',
                                position: 'topRight'
                            });
                        }
                    });
                }
            })
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
