@extends('layouts.default')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Berkas - Rencana Kerja Anggaran</h4>
            </div>
        </div>
    </div>

    <div class="card">

        <div class="card-body">
            <div class="row">
                <div class="col-lg-4">
                    <div class="d-flex">
                        <div class="flex-grow-1 align-self-center">
                            <div class="text-muted">
                                <button type="button" class="btn btn-outline-primary mt-1" data-bs-toggle="modal"
                                    data-bs-target="#tambah" value="animate__jackInTheBox">
                                    <span class="tf-icon bx bx-upload"></span>&nbsp;&nbsp;Upload Berkas
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 align-self-center">
                    <div class="text-lg-center mt-4 mt-lg-0">
                        <div class="row">
                            <div class="col-4">
                                <div>
                                    <p class="text-muted text-truncate mb-2">Tahun 2022</p>
                                    <h5 class="mb-0">**</h5>
                                </div>
                            </div>
                            <div class="col-4">
                                <div>
                                    <p class="text-muted text-truncate mb-2">Tahun 2023</p>
                                    <h5 class="mb-0">**</h5>
                                </div>
                            </div>
                            <div class="col-4">
                                <div>
                                    <p class="text-muted text-truncate mb-2">Tahun 2024</p>
                                    <h5 class="mb-0">**</h5>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 d-none d-lg-block">
                    <div class="clearfix mt-4 mt-lg-0">
                        <p class="mb-0 float-end">Segera Upload RKA Anda Sebelum<br><b class=" float-end">Senin, 2 Oktober
                                2023</b></p>
                        {{-- <div class="dropdown float-end">
                            <button class="btn btn-primary" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="bx bxs-cog align-middle me-1"></i> Setting
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <a class="dropdown-item" href="#">Something else</a>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card card-body table-responsive text-nowrap">
        <table id="dttable" class="table dt-responsive table-hover nowrap w-100 align-middle">
            <thead>
                <tr>
                    <th class="cell-fit">ID</th>
                    <th>NAMA</th>
                    <th>FILE</th>
                    <th>TGL</th>
                    <th class="cell-fit"></th>
                </tr>
            </thead>&nbsp;
            <tbody id="tampil-tbody">
                <tr>
                    <td colspan="6"><i class="fa fa-spinner fa-spin fa-fw"></i> Memproses data...</td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- MODAL START --}}
    <div class="modal fade animate__animated animate__jackInTheBox" data-bs-backdrop="static" id="tambah" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCenterTitle">Upload Berkas RKA Terbaru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="form-auth-small" id="tambah" name="formTambah" action="{{ route('rka.store') }}"
                    method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <input type="file" name="file" class="form-control mb-2" accept=".xls,.xlsx,.pdf" required>
                        <i class="fa-fw fas fa-caret-right nav-icon"></i> Ukuran maksimal file adalah 50 Mb <br>
                        <i class="fa-fw fas fa-caret-right nav-icon"></i> File yang diupload berformat XLS/XLSX/PDF <br>
                        <i class="fa-fw fas fa-caret-right nav-icon"></i> Tidak dapat mengupload file dengan nama yang sama dengan dokumen sebelumnya
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="btn-simpan" onclick="saveData()"><i
                                class="fa-fw fas fa-upload nav-icon"></i> Upload</button>
                </form>
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><i
                        class="fa-fw fas fa-times nav-icon"></i> Tutup</button>
            </div>
        </div>
    </div>
    </div>
    <br><br><br>
    <p id="tampilkan"></p>

    <div class="modal fade animate__animated animate__bounceInRight" id="hapus" data-bs-backdrop="static" id="hapus"
        tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-simple modal-enable-otp modal-dialog-centered">
            <div class="modal-content p-3 p-md-5">
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <h3 class="mb-3">Hapus Berkas RKA Anda?</h3>
                    </div>
                    <input type="text" id="tampungHapus" hidden>
                    <p align="justify" class="mb-4">File yang sudah anda Upload akan terhapus oleh Sistem. Anda hanya memiliki kesempatan menghapus pada
                        Hari saat Anda mengupload file tersebut.</p>
                    <div class="col-12">
                        <button type="submit" class="btn btn-danger me-sm-3 me-1" onclick="hapus()"><i
                                class="fa-fw fas fa-trash nav-icon"></i> Hapus</button>
                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                            aria-label="Close"><i class="fa-fw fas fa-times nav-icon"></i> Batal</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- MODAL END --}}

    <script>
        $(document).ready(function() {

            $('img').bind('contextmenu', function(e) {
                return false;
            });


            $.ajax({
                url: "/api/rka/table",
                type: 'GET',
                dataType: 'json', // added data type
                success: function(res) {
                    $("#tampil-tbody").empty();
                    var date = getDateTime();
                    var userID = "{{ Auth::user()->id }}";
                    var adminID = "{{ Auth::user()->getPermission('admin_rka') }}";
                    var downloader = "{{ Auth::user()->getManyRole(['it','kabag-perencanaan','kasubag-perencanaan-it']) }}";
                    res.forEach(item => {
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
                        // console.log(item.foto_profil);

                        if (item.foto_profil) {
                            try {
                                var foto = `<img src="/storage/` + item.foto_profil.substr(7,1000) + `" alt="Avatar" class="rounded-circle">`;
                            } catch (e) {
                                var foto =
                                    `<div class="avatar-xs img-fluid rounded-circle"><img src="/images/pku/user.png" alt="" class="member-img img-fluid d-block rounded-circle" /></div>`;
                            }
                        } else {
                            var foto =
                                `<div class="avatar-xs img-fluid rounded-circle"><img src="/images/pku/user.png" alt="" class="member-img img-fluid d-block rounded-circle" /></div>`;
                        }
                        if (item.nama_profil) {
                            var namamu = item.nama_profil;
                        } else {
                            var namamu = '';
                        }
                        var tahunrka = parseInt(item.tahun) + 1;
                        var updet = item.updated_at.substring(0, 10);
                        content = `<tr id="data` + item.id + `">`;
                        content += `<td>` + item.id + `</td>`;
                        content += `<td>
                        <div class="d-flex justify-content-start align-items-center">
                          <div class="avatar me-2">` + foto + `</div>
                          <div class="d-flex flex-column">
                            <h6 class="mb-0 text-truncate">` + namamu +
                            `</h6><small class="text-truncate text-muted">` + un + `</small>
                          </div>
                        </div>
                      </td>`;
                        content += `<td>` + item.title +
                            `&nbsp;&nbsp;<span class="badge bg-dark rounded-pill">RKA ` +
                            tahunrka + `</span></td>`;
                        content += `<td>` + item.updated_at.substring(0, 19).replace('T',' ') + `</td>`;
                        content += `<td>
                        <div class="d-flex align-items-center">
                          <div class="dropdown"><a href="javascript:;" class="btn dropdown-toggle hide-arrow text-body p-0 btn-icon" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></a>
                            <div class="dropdown-menu dropdown-menu-end">`;
                        if (downloader == true) {
                            content += `<a href="./rka/` + item.id +
                                `" class="dropdown-item text-info">Download</a>`;
                            if (item.id_user == userID) {
                                if (updet == date) {
                                    content += `<a href="javascript:;" onclick="showHapus(` +
                                        item.id +
                                        `)" class="dropdown-item text-danger">Hapus</a>`;
                                } else {
                                    content +=
                                        `<a href="javascript:;" class="dropdown-item disabled">Hapus</a>`;
                                }
                            } else {
                                content +=
                                    `<a href="javascript:;" class="dropdown-item disabled">Hapus</a>`;
                            }
                        } else {
                            if (adminID == true) {
                                content += `<a href="./rka/` + item.id + `" class="dropdown-item text-info">Download</a>
                                            <a href="javascript:;" onclick="showHapus(` + item.id +
                                    `)" class="dropdown-item text-danger">Hapus</a>`;
                            } else {
                                if (item.id_user == userID) {
                                    content += `<a href="./rka/` + item.id +
                                        `" class="dropdown-item text-info">Download</a>`;
                                    if (updet == date) {
                                        content +=
                                            `<a href="javascript:;" onclick="showHapus(` + item
                                            .id +
                                            `)" class="dropdown-item text-danger">Hapus</a>`;
                                    } else {
                                        content +=
                                            `<a href="javascript:;" class="dropdown-item disabled">Hapus</a>`;
                                    }
                                } else {
                                    content += `<a href="javascript:;" class="dropdown-item disabled">Download</a>
                                              <a href="javascript:;" class="dropdown-item disabled">Hapus</a>`;
                                }
                            }
                        }
                        content += `</div>
                          </div>
                        </div>
                      </td></tr>`;
                        $('#tampil-tbody').append(content);
                    });

                    var table = $('#dttable').DataTable({
                        order: [
                            [3, "desc"]
                        ],
                        displayLength: 10,
                        lengthChange: true,
                        lengthMenu: [7, 10, 25, 50, 75, 100],
                        buttons: ['copy', 'excel', 'pdf', 'colvis']
                    });

                    table.buttons().container()
                        .appendTo('#dttable_wrapper .col-md-6:eq(0)');
                }
            });
        })

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

        function showHapus(params) {
            $('#tampungHapus').val(params);
            $('#hapus').modal('show');
        }

        function hapus() {
            var idHapus = $('#tampungHapus').val();
            $.ajax({
                url: "/api/rka/hapus/" + idHapus,
                type: 'GET',
                dataType: 'json', // added data type
                success: function(res) {
                    $('#hapus').modal('hide');
                    iziToast.success({
                        title: 'Sukses!',
                        message: 'Hapus Dokumen RKA berhasil pada ' + res,
                        position: 'topRight'
                    });
                    window.location.reload();
                },
                error: function(res) {
                    iziToast.error({
                        title: 'Pesan Galat!',
                        message: 'Mohon maaf, Hapus berkas Gagal!',
                        position: 'topRight'
                    });
                }
            });
        }
    </script>
@endsection
