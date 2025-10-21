@extends('layouts.index')

@section('content')

    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i></a></li>
                        <li class="breadcrumb-item">Kepegawaian</li>
                        <li class="breadcrumb-item">Pengajuan</li>
                        <li class="breadcrumb-item" aria-current="page">ID Card</li>
                    </ul>
                </div>
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h2 class="mb-0">Pengajuan ID Card</h2>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- [ breadcrumb ] end -->

    <!-- [ Main Content ] start -->
    <div class="row pt-1">
        <div class="">
            <div class="card table-card">
                <div class="card-header d-flex align-items-center justify-content-between py-3">
                    <h6 class="mb-0">Dafar Pengajuan</h6>
                    <div class="btn-group">

                        <a href="javascript:void(0);" class="avtar avtar-s btn-link-secondary dropdown-toggle arrow-none" data-bs-toggle="dropdown" aria-expanded="false"><i class="ti ti-dots-vertical f-20"></i></a>
                        <ul class="dropdown-menu">
                            <a href="javascript:void(0);" class="dropdown-item">Informasi</a>
                            <a href="javascript:void(0);" class="dropdown-item" onclick="refresh()">Segarkan</a>
                        </ul>
                        {{-- <button class="btn btn-primary btn-shadow" data-bs-toggle="modal" data-bs-target="#tambah">
                            <i class="fa-fw fas fa-upload nav-icon"></i>&nbsp;&nbsp;Upload Berkas
                        </button> --}}
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dttable" class="table table-hover dt-responsive align-middle">
                            <thead>
                                <tr>
                                    <th class="cell-fit">#ID</th>
                                    <th class="cell-fit">NIP</th>
                                    <th>NAMA</th>
                                    <th>JABATAN</th>
                                    <th><center>PROGRESS</center></th>
                                    <th>ESTIMASI</th>
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
                                    <th class="cell-fit">#ID</th>
                                    <th class="cell-fit">NIP</th>
                                    <th>NAMA</th>
                                    <th>JABATAN</th>
                                    <th><center>PROGRESS</center></th>
                                    <th>ESTIMASI</th>
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
    <div class="modal fade" id="modalUbahStatus" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="text-center">
                        <h3>Ubah Status</h3>
                    </div>
                </div>
                <div class="modal-body">
                    <input class="form-control" type="text" id="id_status" hidden>
                    <div class="alert alert-secondary">
                        <small>
                            Mohon diperhatikan, apabila status telah dinyatakan ditolak, maka pengajuan <b>tidak dapat</b> dikembalikan lagi seperti semula. Lakukanlah dengan hati-hati
                        </small>
                    </div>
                    <div class="mb-2">
                        <div class="form-group mb-3">
                            <label class="form-label">Sesuaikan Status <a class="text-danger">*</a></label>
                            <select class="form-control" name="status" id="status"></select>
                        </div>
                        <div class="form-group" id="hideEstimasi">
                            <label class="form-label">Estimasi Waktu Penyelesaian <a class="text-danger">*</a></label>
                            <input class="form-control" type="date" name="estimasi" id="estimasi">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" onclick="prosesUbahStatus()" id="btn-submit" disabled><i class="fa-fw fas fa-rocket nav-icon me-1"></i> Submit</button>
                    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close"><i class="fa-fw fas fa-times nav-icon me-1"></i> Batal</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalHapus" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="text-center">
                        <h3>Hapus Berkas Anda?</h3>
                    </div>
                </div>
                <div class="modal-body">
                    <input type="text" id="tampungHapus" hidden>
                    <p>File yang sudah anda Upload akan terhapus oleh Sistem. Anda hanya memiliki kesempatan menghapus pada
                        Hari saat Anda mengupload file tersebut.</p>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger" onclick="hapus()"><i class="fa-fw fas fa-trash nav-icon me-1"></i> Hapus</button>
                    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close"><i class="fa-fw fas fa-times nav-icon me-1"></i> Batal</button>
                </div>
            </div>
        </div>
    </div>
    {{-- MODAL END --}}

    <script>
        $(document).ready(function() {

            refresh();

        });

        function refresh() {
            $("#tampil-tbody").empty();
            $("#tampil-tbody").empty().append(`<tr><td colspan="9" style="font-size:13px"><center><i class="fa fa-spinner fa-spin fa-fw"></i> Memproses data...</center></td></tr>`);
            $.ajax(
                {
                    url: "/api/kepegawaian/pengajuan/idcard/table",
                    type: 'GET',
                    dataType: 'json', // added data type
                    success: function(res) {
                        var adminID = "{{ Auth::user()->getPermission('admin_kepegawaian_kepala') }}";
                        // var userID = "{{ Auth::user()->id }}";
                        $("#tampil-tbody").empty();
                        $('#dttable').DataTable().clear().destroy();

                        res.show.forEach(item => {
                            content = "<tr id='data"+ item.id +"'>";
                            content += `<td><center><div class='dropend'><a href='javascript:void(0);' class='btn ${item.progress==2 || item.progress==3?'btn-light':'btn-light-primary'} btn-sm font-size-16 rounded' data-bs-toggle='dropdown' aria-haspopup="true"><i class="ti ti-dots"></i></a><div class='dropdown-menu'>`;
                                if (item.progress == 3 || item.progress == 2) {
                                    content += `<a href='javascript:void(0);' class='dropdown-item text-secondary'><i class='ti ti-edit me-1'></i> Ubah Status</a>`;
                                } else {
                                    content += `<a href='javascript:void(0);' class='dropdown-item text-warning' onclick="showUbahStatus(`+item.id+`,`+item.progress+`)" value="animate__rubberBand"><i class='ti ti-edit me-1'></i> Ubah Status</a>`;
                                }
                                    // content += `<a href='javascript:void(0);' class='dropdown-item text-danger' onclick="showHapus(`+item.id+`)" value="animate__rubberBand"><i class='ti ti-trash me-1'></i> Hapus</a>`;
                            content += `</div></center></td>`;
                            if (item.pengajuan == 0) {
                                stt = `<small><span class="badge rounded-pill text-bg-success p-1">Baru</span></small>`;
                            } else {
                                stt = `<small><span class="badge rounded-pill text-bg-primary p-1">Ganti</span></small>`;
                            }
                            content += `<td>${item.pegawai_nip?item.pegawai_nip:'-'}</td>`;
                            content += "<td style='white-space: normal !important;word-wrap: break-word;'>"
                                    + "<div class='d-flex justify-content-start align-items-center'><div class='d-flex flex-column'>"
                                        + "<h6 class='mb-0'>" + item.pegawai_panggilan + "&nbsp;&nbsp;" + stt + "</h6><small class='text-truncate text-muted'>Oleh " + item.pegawai_nama + "</small>"
                                    + "</div></div></td>";
                            content += `<td>${item.pegawai_jabatan?item.pegawai_jabatan:'-'}</td>`;
                            if (item.progress == 0) {
                                pg = `<center><span class="badge text-bg-primary p-1">Pengajuan</span></center>`;
                            } else {
                                if (item.progress == 1) {
                                    pg = `<center><span class="badge text-bg-warning p-1">Sedang Diproses</span></center>`;
                                } else {
                                    if (item.progress == 2) {
                                        pg = `<center><span class="badge text-bg-success p-1">Selesai</span></center>`;
                                    } else {
                                        pg = `<center><span class="badge text-bg-danger p-1">Ditolak</span></center>`;
                                    }
                                }
                            }
                            content += `<td>${pg}</td>`;
                            content += `<td>${item.estimasi?item.estimasi:'Belum Ditentukan'}</td>`;
                            content += `<td>` + new Date(item.updated_at).toLocaleString("sv-SE") + `</td>`;
                            $('#tampil-tbody').append(content);
                        });
                        var table = $('#dttable').DataTable({
                            order: [
                                [6, "desc"]
                            ],
                            bAutoWidth: false,
                            aoColumns : [
                                { sWidth: '5%' },
                                { sWidth: '10%' },
                                { sWidth: '20%' },
                                { sWidth: '20%' },
                                { sWidth: '15%' },
                                { sWidth: '15%' },
                                { sWidth: '15%' },
                            ],
                            displayLength: 10,
                            lengthChange: true,
                            lengthMenu: [ 10, 25, 50, 75, 100, 500, 1000, 5000, 10000],
                            // buttons: ['copy', 'excel', 'pdf', 'colvis']
                        });

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

        function showUbahStatus(id,progress) {
            $("#id_status").val(id);
            $('#status').find('option').remove();
            if (progress == 0) {
                $('#status').append(`
                    <option value="" selected>Pilih</option>
                    <option value="1">Terima</option>
                    <option value="3">Tolak</option>
                `);
            } else {
                if (progress == 1) {
                    $('#status').append(`
                        <option value="1" selected>Sedang Diproses</option>
                        <option value="2">Proses Selesai</option>
                        <option value="3">Tolak Pengajuan</option>
                    `);
                    $('input[name="estimasi"]').prop('disabled',true);
                } else {
                    iziToast.error({
                        title: 'Pesan Galat!',
                        message: 'Status Pengajuan tidak ditemukan.',
                        position: 'topRight'
                    });
                }
            }
            $('#status').on('change', function() {
                if ($(this).val() == "3") {
                    $('#hideEstimasi').prop('hidden',true);
                } else {
                    $('#hideEstimasi').prop('hidden',false);
                }

                if ($(this).val() == "") {
                    $('#btn-submit').prop('disabled',true);
                } else {
                    $('#btn-submit').prop('disabled',false);
                }
            })
            $('#modalUbahStatus').modal('show');
        }

        function prosesUbahStatus() {
            // INIT
            var save = new FormData();
            save.append('id',$("#id_status").val());
            save.append('progress',$('#status').val());
            save.append('estimasi',$('#estimasi').val());

            if (save.get('progress') == "1" && save.get('estimasi') == "") {
                iziToast.warning({
                    title: 'Pesan Ambigu!',
                    message: 'Pastikan Anda tidak mengosongi semua isian Wajib',
                    position: 'topRight'
                });
            } else {
                // PROCESS
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: 'POST',
                    url: '/api/kepegawaian/pengajuan/idcard/status',
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    data: save,
                    success: function(res) {
                        iziToast.success({
                            title: 'Pesan Sukses!',
                            message: 'Status Pengajuan ID Card telah berhasil diubah pada '+res,
                            position: 'topRight'
                        });
                        $('#modalUbahStatus').modal('hide');
                        refresh();
                    },
                    error: function (res) {
                        iziToast.error({
                            title: 'Pesan Galat!',
                            message: res.responseJSON.error,
                            position: 'topRight'
                        });
                    }
                })
            }
        }

        function saveData() {
            $("#tambah").one('submit', function() {
                $("#btn-simpan").attr('disabled', 'disabled');
                $("#btn-simpan").find("i").toggleClass("fa-upload fa-sync fa-spin");
                return true;
            });
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
