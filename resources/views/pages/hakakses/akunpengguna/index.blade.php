@extends('layouts.index')

@section('content')

    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i></a></li>
                        <li class="breadcrumb-item">Atur Pengguna</li>
                        <li class="breadcrumb-item">Hak Akses</li>
                        <li class="breadcrumb-item" aria-current="page">Akun Pengguna</li>
                    </ul>
                </div>
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h2 class="mb-0">Pengaturan Akun Pengguna</h2>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- [ breadcrumb ] end -->
    <!-- [ Main Content ] start -->
    <div class="row pt-1">
        <div class="col-xl-12">
            <div class="card table-card">
                <div class="card-header d-flex align-items-center justify-content-between py-3">
                    <h5 class="mb-0">Tabel Pengguna</h5>
                    <button class="btn btn-primary" onclick="window.location.href='{{ route('akunpengguna.create') }}'"><i class="fas fa-plus"></i>&nbsp;&nbsp;Tambah Pengguna</button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dttable" class="table dt-responsive table-hover nowrap w-100" style="font-size:13px">
                            <thead>
                                <tr>
                                    <th class="cell-fit text-center">ID</th>
                                    <th class="cell-fit">USERNAME</th>
                                    <th>NAMA</th>
                                    <th>ROLE</th>
                                    <th class="cell-fit">UPDATE</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($list['user']) > 0)
                                    @foreach ($list['user'] as $item)
                                        <tr>
                                            <td>
                                                <center>
                                                    <div class='btn-group'>
                                                        <a href="javascript:void(0);" class='dropdown-toggle hide-arrow'
                                                            data-bs-toggle='dropdown' aria-expanded='false'><i class='bx bx-dots-vertical-rounded me-2'></i>{{ $item->id }}
                                                        </a>
                                                        <ul class='dropdown-menu dropdown-menu-end'>
                                                            <li>
                                                                <a href='javascript:void(0);' class='dropdown-item text-warning' onclick="window.location.href='{{ url('hakakses/akunpengguna/' . $item->id . '') }}'">
                                                                    <i class="fa-fw fas fa-edit nav-icon"></i> Ubah
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href='javascript:void(0);' class='dropdown-item text-danger' onclick="hapus({{ $item->id }})">
                                                                    <i class="fa-fw fas fa-trash nav-icon"></i> Hapus
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </center>
                                            </td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->nama }}</td>
                                            <td>
                                                @foreach ($list['role'] as $val)
                                                    @if ($item->id == $val->id_user)
                                                        <kbd>{{ $val->nama_role }}</kbd>
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>{{ $item->updated_at }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th class="cell-fit text-center">ID</th>
                                    <th class="cell-fit">USERNAME</th>
                                    <th>NAMA</th>
                                    <th>ROLE</th>
                                    <th class="cell-fit">UPDATE</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            var table = $('#dttable').DataTable({
                order: [[4, "desc"]],
                displayLength: 20,
                lengthChange: true,
                lengthMenu: [20, 35, 50, 75, 100, 500, 1000],
                buttons: ['copy', 'excel', 'pdf', 'colvis']
            });

            table.buttons().container()
                .appendTo('#dttable_wrapper .col-md-6:eq(0)');
        })

        function hapus(id) {
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: 'Hapus Permanen Akun Pengguna ID : ' + id,
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
                        url: "/api/hakakses/akunpengguna/hapus/" + id,
                        type: 'GET',
                        dataType: 'json', // added data type
                        success: function(res) {
                            iziToast.success({
                                title: 'Sukses!',
                                message: 'Hapus Akun berhasil pada ' + res,
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
