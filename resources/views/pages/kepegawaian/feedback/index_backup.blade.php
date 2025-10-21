@extends('layouts.index')

@section('content')

    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i></a></li>
                        <li class="breadcrumb-item">Kepegawaian</li>
                        <li class="breadcrumb-item" aria-current="page">Feedback</li>
                    </ul>
                </div>
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h2 class="mb-0">Masukan / Saran</h2>
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
                    <h6 class="mb-0">Tabel</h6>
                    <div class="btn-group">
                        <button class="btn btn-primary btn-shadow" data-bs-toggle="modal" data-bs-target="#tambah">
                            <i class="fa-fw fas fa-upload nav-icon"></i>&nbsp;&nbsp;Upload Berkas
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dttable" class="table table-hover dt-responsive align-middle">
                            <thead>
                                <tr>
                                    <th class="cell-fit">#ID</th>
                                    <th>NAMA</th>
                                    <th>FILE</th>
                                    <th>TGL</th>
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
                                    <th>NAMA</th>
                                    <th>FILE</th>
                                    <th>TGL</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL START --}}
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

            // $.ajax({
            //     url: "/api/rka/table",
            //     type: 'GET',
            //     dataType: 'json', // added data type
            //     success: function(res) {
            //         $("#tampil-tbody").empty();
            //         var date = getDateTime();
            //         var userID = "{{ Auth::user()->id }}";
            //         var adminID = "{{ Auth::user()->getPermission('admin_rka') }}";
            //         var downloader = "{{ Auth::user()->getManyRole(['it','kabag-perencanaan','kasubag-perencanaan-it']) }}";
            //         res.forEach(item => {
            //             if (item.unit) {
            //                 try {
            //                     var un = JSON.parse(item.unit);
            //                 } catch (e) {
            //                     var un = item.unit;
            //                 }
            //             }
            //             if (un !== null) {
            //                 un = un.toString().replaceAll(',', ', ').replaceAll('-', ' ');
            //             } else {
            //                 un = '';
            //             }
            //             // console.log(item.foto_profil);

            //             if (item.foto_profil) {
            //                 try {
            //                     var foto = `<img src="/storage/` + item.foto_profil.substr(7,1000) + `" alt="Avatar" class="img-radius wid-40 align-top">`;
            //                 } catch (e) {
            //                     var foto = `<img src="/images/pku/user.png" alt="" class="img-radius wid-40 align-top" />`;
            //                 }
            //             } else {
            //                 var foto = `<img src="/images/pku/user.png" alt="" class="img-radius wid-40 align-top" />`;
            //             }
            //             if (item.nama_profil) {
            //                 var namamu = item.nama_profil;
            //             } else {
            //                 var namamu = '';
            //             }
            //             var tahunrka = parseInt(item.tahun) + 1;
            //             var updet = new Date(item.updated_at).toLocaleString("sv-SE").substring(0, 10);
            //             content = `<tr id="data` + item.id + `">`;
            //             content += `<td><div class="d-flex align-items-center"><div class="dropdown">
            //                 <a href="javascript:void(0);" class="btn btn-icon btn-link dropdown-toggle hide-arrow text-primary p-0" data-bs-toggle="dropdown">` + item.id + `</a>
            //                 <div class="dropdown-menu dropdown-menu-right">`;
            //             if (downloader == true) {
            //                 content += `<a href="./rka/` + item.id +
            //                     `" class="dropdown-item text-info"><i class="fa-fw fas fa-download nav-icon me-1"></i> Download</a>`;
            //                 if (item.id_user == userID) {
            //                     if (updet == date) {
            //                         content += `<a href="javascript:void(0);" onclick="showHapus(` + item.id + `)" class="dropdown-item text-danger"><i class="fa-fw fas fa-trash nav-icon me-1"></i> Hapus</a>`;
            //                     } else {
            //                         content += `<a href="javascript:void(0);" class="dropdown-item disabled"><i class="fa-fw fas fa-trash nav-icon me-1"></i> Hapus</a>`;
            //                     }
            //                 } else {
            //                     content +=
            //                         `<a href="javascript:void(0);" class="dropdown-item disabled"><i class="fa-fw fas fa-trash nav-icon me-1"></i> Hapus</a>`;
            //                 }
            //             } else {
            //                 if (adminID == true) {
            //                     content += `<a href="./rka/` + item.id + `" class="dropdown-item text-info"><i class="fa-fw fas fa-download nav-icon me-1"></i> Download</a>
            //                                 <a href="javascript:void(0);" onclick="showHapus(` + item.id + `)" class="dropdown-item text-danger"><i class="fa-fw fas fa-trash nav-icon me-1"></i> Hapus</a>`;
            //                 } else {
            //                     if (item.id_user == userID) {
            //                         content += `<a href="./rka/` + item.id + `" class="dropdown-item text-info"><i class="fa-fw fas fa-download nav-icon me-1"></i> Download</a>`;
            //                         if (updet == date) {
            //                             content +=
            //                                 `<a href="javascript:void(0);" onclick="showHapus(` + item.id + `)" class="dropdown-item text-danger"><i class="fa-fw fas fa-trash nav-icon me-1"></i> Hapus</a>`;
            //                         } else {
            //                             content += `<a href="javascript:void(0);" class="dropdown-item disabled"><i class="fa-fw fas fa-trash nav-icon me-1"></i> Hapus</a>`;
            //                         }
            //                     } else {
            //                         content += `<a href="javascript:void(0);" class="dropdown-item disabled"><i class="fa-fw fas fa-download nav-icon me-1"></i> Download</a>
            //                                 <a href="javascript:void(0);" class="dropdown-item disabled"><i class="fa-fw fas fa-trash nav-icon me-1"></i> Hapus</a>`;
            //                     }
            //                 }
            //             }
            //             content += `</div>
            //                     </div>
            //                 </div>
            //             </td>`;
            //             content += `<td><div class="d-flex justify-content-start align-items-center">
            //                                 <div class="flex-shrink-0">` + foto + `</div>
            //                                 <div class="flex-grow-1 ms-3">
            //                                     <h6 class="mb-0 text-truncate">` + namamu +
            //                                     `</h6><small class="text-truncate text-muted">` + un + `</small>
            //                                 </div>
            //                             </div>
            //                         </td>`;
            //             content += `<td>` + item.title +
            //                 `&nbsp;&nbsp;<span class="badge bg-dark rounded-pill">RKA ` +
            //                 tahunrka + `</span></td>`;
            //             content += `<td>` + new Date(item.updated_at).toLocaleString("sv-SE") + `</td></tr>`;
            //             $('#tampil-tbody').append(content);
            //         });

            //         var table = $('#dttable').DataTable({
            //             order: [
            //                 [3, "desc"]
            //             ],
            //             displayLength: 10,
            //             lengthChange: true,
            //             lengthMenu: [7, 10, 25, 50, 75, 100],
            //             buttons: ['copy', 'excel', 'pdf', 'colvis']
            //         });
            //     }
            // });

        });

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
