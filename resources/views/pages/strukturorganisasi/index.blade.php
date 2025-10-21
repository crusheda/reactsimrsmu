@extends('layouts.default')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Struktur Organisasi</h4>
            </div>
        </div>
    </div>

    @if (Auth::user()->getPermission(['struktur_organisasi']) == true)
    <div class="card card-body table-responsive text-nowrap">
        <h4 classs="card-title">
            <button class="btn btn-outline-primary"
                onclick="window.location.href='{{ route('strukturorganisasi.tambah') }}'"><i
                    class="fas fa-plus"></i>&nbsp;&nbsp;Tambah Struktur</button>
        </h4>
        <hr>
        <table id="dttable" class="table dt-responsive table-hover nowrap w-100">
            <thead>
                <tr>
                    <th class="cell-fit">ID DB</th>
                    <th class="cell-fit">ID USER</th>
                    <th>NAMA USER</th>
                    <th>ROLE USER</th>
                    <th class="cell-fit">ROLE BAWAHAN</th>
                    <th class="cell-fit">UPDATE</th>
                    <th class="cell-fit">#</th>
                </tr>
            </thead>
            <tbody>
                @if (count($list['struktur_organisasi']) > 0)
                    @foreach ($list['struktur_organisasi'] as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->id_user }}</td>
                            <td>{{ $item->nama_user }}</td>
                            <td>
                                @foreach (json_decode($item->role) as $val)
                                    @foreach ($list['roles'] as $key)
                                        @if ($val == $key->id)
                                            <kbd>{{ $key->name }}</kbd>
                                        @endif
                                    @endforeach
                                @endforeach
                            </td>
                            <td>
                                @foreach (json_decode($item->bawahan) as $val)
                                    @foreach ($list['roles'] as $key)
                                        @if ($val == $key->id)
                                            <kbd>{{ $key->name }}</kbd>
                                        @endif
                                    @endforeach
                                @endforeach
                            </td>
                            <td>{{ $item->updated_at }}</td>
                            <td>
                                <center>
                                    <div class='btn-group'>
                                        <button type='button'
                                            class='btn btn-sm btn-outline-dark btn-icon dropdown-toggle hide-arrow'
                                            data-bs-toggle='dropdown' aria-expanded='false'><i
                                                class='bx bx-dots-vertical-rounded'></i></button>
                                        <ul class='dropdown-menu dropdown-menu-end'>
                                            <li><a href='javascript:void(0);' class='dropdown-item text-warning'
                                                    onclick="window.location.href='{{ url('kepegawaian/strukturorganisasi/' . $item->id . '/ubah') }}'"><i
                                                        class="fa-fw fas fa-edit nav-icon"></i> Ubah</a></li>
                                            <li><a href='javascript:void(0);' class='dropdown-item text-danger'
                                                    onclick="hapus({{ $item->id }})"><i
                                                        class="fa-fw fas fa-trash nav-icon"></i> Hapus</a></li>
                                        </ul>
                                    </div>
                                </center>
                            </td>
                            {{-- <td></td> --}}
                            {{-- <td>
                                @foreach ($list['role'] as $val)
                                    @if ($item->id == $val->id_user)
                                        <kbd>{{ $val->nama_role }}</kbd>
                                    @endif
                                @endforeach
                            </td> --}}
                            {{-- <td>
                                <center>
                                    <div class='btn-group'>
                                        <button type='button'
                                            class='btn btn-sm btn-primary btn-icon dropdown-toggle hide-arrow'
                                            data-bs-toggle='dropdown' aria-expanded='false'><i
                                                class='bx bx-dots-vertical-rounded'></i></button>
                                        <ul class='dropdown-menu dropdown-menu-end'>
                                            <li><a href='javascript:void(0);' class='dropdown-item text-warning'
                                                    onclick="window.location.href='{{ url('hakakses/datakaryawan/' . $item->id . '') }}'"><i
                                                        class="fa-fw fas fa-edit nav-icon"></i> Ubah</a></li>
                                            <li><a href='javascript:void(0);' class='dropdown-item text-danger'
                                                    onclick="hapus({{ $item->id }})"><i
                                                        class="fa-fw fas fa-trash nav-icon"></i> Hapus</a></li>
                                        </ul>
                                    </div>
                                </center>
                            </td> --}}
                        </tr>
                    @endforeach
                @endif
            </tbody>
            <tfoot>
                <tr>
                    <th class="cell-fit">ID DB</th>
                    <th class="cell-fit">ID USER</th>
                    <th>NAMA USER</th>
                    <th>ROLE USER</th>
                    <th class="cell-fit">ROLE BAWAHAN</th>
                    <th class="cell-fit">UPDATE</th>
                    <th class="cell-fit">#</th>
                </tr>
            </tfoot>
        </table>
    </div>
    @else
    @endif
    <script>
        $(document).ready(function() {
            var table = $('#dttable').DataTable({
                order: [
                    [5, "desc"]
                ],
                displayLength: 7,
                lengthChange: true,
                lengthMenu: [7, 10, 25, 50, 75, 100],
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
                        url: "/api/strukturorganisasi/hapus/" + id,
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
