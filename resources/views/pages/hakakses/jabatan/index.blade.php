@extends('layouts.default')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Hak Akses - Jabatan</h4>
            </div>
        </div>
    </div>

    <div class="card card-body text-nowrap">
        <h4 class="card-title">
            <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#formTambah"><i
                    class="fas fa-plus"></i>&nbsp;&nbsp;Tambah Jabatan</button>
        </h4>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card card-body table-responsive text-nowrap">
                <table id="dttable" class="table dt-responsive table-hover nowrap w-100">
                    <thead>
                        <tr>
                            <th class="cell-fit">ID</th>
                            <th class="cell-fit">NAME</th>
                            <th class="cell-fit">UPDATE</th>
                            <th class="cell-fit"><center>#</center></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($list['show']) > 0)
                            @foreach ($list['show'] as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->updated_at }}</td>
                                    <td>
                                        <center>
                                            {{-- <div class='btn-group'>
                                                <button type='button'
                                                    class='btn btn-sm btn-primary btn-icon dropdown-toggle hide-arrow'
                                                    data-bs-toggle='dropdown' aria-expanded='false'><i
                                                        class='bx bx-dots-vertical-rounded'></i></button>
                                                <ul class='dropdown-menu dropdown-menu-end'>
                                                    <li><a href='javascript:void(0);' class='dropdown-item text-warning'
                                                            onclick="window.location.href='{{ url('hakakses/jabatan/' . $item->id . '') }}'"><i
                                                                class="fa-fw fas fa-edit nav-icon"></i> Ubah</a></li>
                                                    <li><a href='javascript:void(0);' class='dropdown-item text-danger'
                                                            onclick="hapus({{ $item->id }})"><i
                                                                class="fa-fw fas fa-trash nav-icon"></i> Hapus</a></li>
                                                </ul>
                                            </div> --}}
                                            <button class='btn btn-danger btn-sm'
                                            onclick="hapus({{ $item->id }})"><i
                                                class="fa-fw fas fa-trash nav-icon"></i></button>
                                        </center>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                    <tfoot>
                        <tr>
                            <th class="cell-fit">ID</th>
                            <th class="cell-fit">NAME</th>
                            <th class="cell-fit">UPDATE</th>
                            <th class="cell-fit"><center>#</center></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    {{-- MODAL --}}
    <div class="modal fade animate__animated animate__jackInTheBox" id="formTambah" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal" role="document">
            <div class="modal-content">
                <form id="tambah" action="{{ route('jabatan.store') }}" method="post">
                    @csrf
                    <div class="modal-header">
                    <h4 class="modal-title">
                        Tambah Jabatan
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <label for="" class ="form-label">Jabatan</label>
                        <input type="text" name="name" class="form-control" placeholder="Masukkan nama jabatan" required>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" id="btn-simpan" onclick="tambah()"><i class="fa-fw fas fa-save nav-icon"></i> Tambah</button>
                        <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close"><i class="fa-fw fas fa-times nav-icon"></i> Tutup</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            var table = $('#dttable').DataTable({
                order: [
                    [2, "desc"]
                ],
                displayLength: 7,
                lengthChange: true,
                lengthMenu: [7, 10, 25, 50, 75, 100],
                buttons: ['copy', 'excel', 'pdf', 'colvis']
            });

            table.buttons().container()
                .appendTo('#dttable_wrapper .col-md-6:eq(0)');
        })

        function tambah() {
            $("#tambah").one('submit', function() {
                $("#btn-simpan").attr('disabled', 'disabled');
                $("#btn-simpan").find("i").toggleClass("fa-save fa-sync fa-spin");
                return true;
            });
        }

        function hapus(id) {
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: 'Hapus Permanen Jabatan ID : ' + id,
                icon: 'warning',
                reverseButtons: false,
                showDenyButton: false,
                showCloseButton: false,
                showCancelButton: true,
                focusCancel: true,
                confirmButtonColor: '#FF4845',
                confirmButtonText: `<i class="fa fa-trash me-1" style="font-size:13px"></i> Hapus`,
                cancelButtonText: `<i class="fa fa-times me-1" style="font-size:13px"></i>  Batal`,
                backdrop: `rgba(26,27,41,0.8)`,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "/api/hakakses/jabatan/hapus/" + id,
                        type: 'GET',
                        dataType: 'json', // added data type
                        success: function(res) {
                            iziToast.success({
                                title: 'Sukses!',
                                message: 'Hapus Jabatan berhasil pada ' + res,
                                position: 'topRight'
                            });
                            window.location.reload();
                        },
                        error: function(res) {
                            Swal.fire({
                                title: `Gagal di hapus!`,
                                text: 'Pada ' + res,
                                icon: `error`,
                                showConfirmButton: false,
                                showCancelButton: false,
                                allowOutsideClick: true,
                                allowEscapeKey: true,
                                timer: 3000,
                                timerProgressBar: true,
                                backdrop: `rgba(26,27,41,0.8)`,
                            });
                        }
                    });
                }
            })
        }
    </script>
@endsection
