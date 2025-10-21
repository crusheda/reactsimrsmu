@extends('layouts.default')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Profil Karyawan</h4>
            </div>
        </div>
    </div>

    <div class="card card-body table-responsive text-nowrap">
        <h4 class="card-title">
            <div class="btn-group">
                <button class="btn btn-danger" onclick="showNonAktif()" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="Menampilkan Daftar Karyawan yang sudah Nonaktif"><i class="fas fa-user-slash"></i>&nbsp;&nbsp;Riwayat
                    Nonaktif</button>
                <button class="btn btn-warning" onclick="showNonLengkap()" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="Menampilkan Daftar Karyawan yang belum lengkap pengisian Profil Karyawan"><i
                        class="fas fa-user-minus"></i>&nbsp;&nbsp;Belum Lengkap <span class="badge bg-light">{{ $list['showmin'] }}</span></button>
            </div>
            <button class="btn btn-outline-dark" onclick="window.location.href='{{ route('akunpengguna.create') }}'"><i
                    class="fas fa-plus"></i>&nbsp;&nbsp;Tambah Pengguna</button>
        </h4>
        <hr>
        <p class="card-title-desc">
            <i class="mdi mdi-arrow-right text-primary"></i> Refresh browser Anda apabila terjadi Error saat pengambilan data karyawan<br>
            <i class="mdi mdi-arrow-right text-primary"></i> Klik pada <u><b>Nama Karyawan</b></u> untuk melihat profil lengkap
        </p>

        <table id="dttable" class="table align-middle dt-responsive table-hover nowrap w-100">
            <thead>
                <tr>
                    <th class="cell-fit">ID</th>
                    <th>NIP</th>
                    <th>NIK</th>
                    <th>NAMA LENGKAP</th>
                    <th>PANGGILAN</th>
                    <th>TMPT/TGL LAHIR</th>
                    <th>JENIS KELAMIN</th>
                    <th>STATUS KAWIN</th>
                    <th>EMAIL</th>
                    <th>HP</th>
                    <th>FB</th>
                    <th>IG</th>
                    <th>KELURAHAN (KTP)</th>
                    <th>KECAMATAN (KTP)</th>
                    <th>KABUPATEN (KTP)</th>
                    <th>PROVINSI (KTP)</th>
                    <th class="cell-fit">ALAMAT (KTP)</th>
                    <th>KELURAHAN (DOM)</th>
                    <th>KECAMATAN (DOM)</th>
                    <th>KABUPATEN (DOM)</th>
                    <th>PROVINSI (DOM)</th>
                    <th class="cell-fit">ALAMAT (DOM)</th>
                    <th>SD</th>
                    <th>SMP</th>
                    <th>SMA</th>
                    <th>D1</th>
                    <th>D2</th>
                    <th>D3</th>
                    <th>D4</th>
                    <th>S1</th>
                    <th>S2</th>
                    <th>S3</th>
                    <th class="cell-fit">PENGALAMAN KERJA</th>
                    <th>RIWAYAT PENYAKIT</th>
                    <th>RIWAYAT PENYAKIT KELUARGA</th>
                    <th>RIWAYAT OPERASI</th>
                    <th>RIWAYAT PENGGUNAAN OBAT</th>
                    <th class="cell-fit">UPDATE</th>
                </tr>
            </thead>
            <tbody>
                @if (count($list['show']) > 0)
                    @foreach ($list['show'] as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->nip }}</td>
                            <td>{{ $item->nik }}</td>
                            <td>
                                <div>
                                    <h5 class="text-truncate font-size-14 mb-1"><a href="javascript: void(0);"
                                            class="text-dark"
                                            onclick="window.location.href='{{ url('profilkaryawan/detail/' . $item->id . '') }}'" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Detail Profil">
                                            <u>{{ $item->nama }}</u>
                                        </a></h5>
                                    <p class="text-muted mb-0">
                                        @foreach ($list['role'] as $val)
                                            @if ($item->id == $val->id_user)
                                                <kbd>{{ $val->nama_role }}</kbd>
                                            @endif
                                        @endforeach
                                    </p>
                                </div>
                            </td>
                            <td>{{ $item->nick }}</td>
                            <td>{{ $item->temp_lahir }}, {{ $item->tgl_lahir }}</td>
                            <td>{{ $item->jns_kelamin }}</td>
                            <td>{{ $item->status_kawin }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->no_hp }}</td>
                            <td>{{ $item->fb }}</td>
                            <td>{{ $item->ig }}</td>
                            <td>{{ $item->ktp_kelurahan }}</td>
                            <td>{{ $item->ktp_kecamatan }}</td>
                            <td>{{ $item->ktp_kabupaten }}</td>
                            <td>{{ $item->ktp_provinsi }}</td>
                            <td>{{ $item->alamat_ktp }}</td>
                            <td>{{ $item->dom_kelurahan }}</td>
                            <td>{{ $item->dom_kecamatan }}</td>
                            <td>{{ $item->dom_kabupaten }}</td>
                            <td>{{ $item->dom_provinsi }}</td>
                            <td>{{ $item->alamat_dom }}</td>
                            <td>{{ $item->sd }} @if ($item->th_sd)
                                    ({{ $item->th_sd }})
                                @endif
                            </td>
                            <td>{{ $item->smp }} @if ($item->th_smp)
                                    ({{ $item->th_smp }})
                                @endif
                            </td>
                            <td>{{ $item->sma }} @if ($item->th_sma)
                                    ({{ $item->th_sma }})
                                @endif
                            </td>
                            <td>{{ $item->d1 }} @if ($item->th_d1)
                                    ({{ $item->th_d1 }})
                                @endif
                            </td>
                            <td>{{ $item->d2 }} @if ($item->th_d2)
                                    ({{ $item->th_d2 }})
                                @endif
                            </td>
                            <td>{{ $item->d3 }} @if ($item->th_d3)
                                    ({{ $item->th_d3 }})
                                @endif
                            </td>
                            <td>{{ $item->d4 }} @if ($item->th_d4)
                                    ({{ $item->th_d4 }})
                                @endif
                            </td>
                            <td>{{ $item->s1 }} @if ($item->th_s1)
                                    ({{ $item->th_s1 }})
                                @endif
                            </td>
                            <td>{{ $item->s2 }} @if ($item->th_s2)
                                    ({{ $item->th_s2 }})
                                @endif
                            </td>
                            <td>{{ $item->s3 }} @if ($item->th_s3)
                                    ({{ $item->th_s3 }})
                                @endif
                            </td>
                            <td>{{ $item->pengalaman_kerja }}</td>
                            <td>{{ $item->riwayat_penyakit }}</td>
                            <td>{{ $item->riwayat_penyakit_keluarga }}</td>
                            <td>{{ $item->riwayat_operasi }}</td>
                            <td>{{ $item->riwayat_penggunaan_obat }}</td>
                            <td>{{ $item->updated_at }}</td>
                            {{-- <td>
                                <center>
                                    <div class='btn-group'>
                                        <button type='button'
                                            class='btn btn-sm btn-primary btn-icon dropdown-toggle hide-arrow'
                                            data-bs-toggle='dropdown' aria-expanded='false'><i
                                                class='bx bx-dots-vertical-rounded'></i></button>
                                        <ul class='dropdown-menu dropdown-menu-end'>
                                            <li><a href='javascript:void(0);' class='dropdown-item text-warning'
                                                    onclick="window.location.href='{{ url('v2/kepegawaian/karyawan/' . $item->id . '') }}'"><i
                                                        class="fa-fw fas fa-search nav-icon"></i> Lihat</a></li>
                                            <li>
                                                <form method="POST" action="/v2/kepegawaian/karyawan/{{ $item->id }}">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}
                                                    <a href='javascript:void(0);' type="submit"
                                                        class='dropdown-item text-danger delete-user'><i
                                                            class="fa-fw fas fa-trash nav-icon"></i>
                                                        Nonaktifkan</a>
                                                </form>
                                            </li>
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
                    <th class="cell-fit">ID</th>
                    <th>NIP</th>
                    <th>NIK</th>
                    <th>NAMA LENGKAP</th>
                    <th>PANGGILAN</th>
                    <th>TMPT/TGL LAHIR</th>
                    <th>JENIS KELAMIN</th>
                    <th>STATUS KAWIN</th>
                    <th>EMAIL</th>
                    <th>HP</th>
                    <th>FB</th>
                    <th>IG</th>
                    <th>KELURAHAN (KTP)</th>
                    <th>KECAMATAN (KTP)</th>
                    <th>KABUPATEN (KTP)</th>
                    <th>PROVINSI (KTP)</th>
                    <th class="cell-fit">ALAMAT (KTP)</th>
                    <th>KELURAHAN (DOM)</th>
                    <th>KECAMATAN (DOM)</th>
                    <th>KABUPATEN (DOM)</th>
                    <th>PROVINSI (DOM)</th>
                    <th class="cell-fit">ALAMAT (DOM)</th>
                    <th>SD</th>
                    <th>SMP</th>
                    <th>SMA</th>
                    <th>D1</th>
                    <th>D2</th>
                    <th>D3</th>
                    <th>D4</th>
                    <th>S1</th>
                    <th>S2</th>
                    <th>S3</th>
                    <th class="cell-fit">PENGALAMAN KERJA</th>
                    <th>RIWAYAT PENYAKIT</th>
                    <th>RIWAYAT PENYAKIT KELUARGA</th>
                    <th>RIWAYAT OPERASI</th>
                    <th>RIWAYAT PENGGUNAAN OBAT</th>
                    <th class="cell-fit">UPDATE</th>
                </tr>
            </tfoot>
        </table>
    </div>

    {{-- NONAKTIF --}}
    <div class="modal fade animate__animated animate__jackInTheBox" id="nonaktif" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        Daftar Karyawan Nonaktif
                    </h4>
                    <button type="button" class="btn-close" onclick="closeModal()" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive text-nowrap" style="border: 0px">
                        <table id="dttable-nonaktif" class="table dt-responsive table-hover nowrap w-100">
                            <thead>
                                <tr>
                                    <th class="cell-fit">ID</th>
                                    <th class="cell-fit">NAME</th>
                                    <th class="cell-fit">NAMA LENGKAP</th>
                                    <th class="cell-fit">TGL NONAKTIF</th>
                                    <th class="cell-fit">
                                        <center>#</center>
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="tampil-tbody-nonaktif">
                                <tr>
                                    <td colspan="9">
                                        <center><i class="fa fa-spinner fa-spin fa-fw"></i> Memproses data...</center>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th class="cell-fit">ID</th>
                                    <th class="cell-fit">NAME</th>
                                    <th class="cell-fit">NAMA LENGKAP</th>
                                    <th class="cell-fit">TGL NONAKTIF</th>
                                    <th class="cell-fit">
                                        <center>#</center>
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="btn-group">
                        <button class="btn btn-warning" onclick="refreshNonAktif()" data-bs-toggle="tooltip"
                            data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true" title="Segarkan"><i
                                class='fa-fw fas fa-sync nav-icon'></i>&nbsp;&nbsp;Segarkan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- TIDAK LENGKAP --}}
    <div class="modal fade animate__animated animate__jackInTheBox" id="nonlengkap" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        Daftar Pengisian Profil Karyawan yang Belum Lengkap
                    </h4>
                    <button type="button" class="btn-close" onclick="closeModal()" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive text-nowrap" style="border: 0px">
                        <table id="dttable-nonlengkap" class="table dt-responsive table-hover nowrap w-100">
                            <thead>
                                <tr>
                                    <th class="cell-fit">ID</th>
                                    <th class="cell-fit">NAME</th>
                                    <th class="cell-fit">DITAMBAHKAN</th>
                                </tr>
                            </thead>
                            <tbody id="tampil-tbody-nonlengkap">
                                <tr>
                                    <td colspan="9">
                                        <center><i class="fa fa-spinner fa-spin fa-fw"></i> Memproses data...</center>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th class="cell-fit">ID</th>
                                    <th class="cell-fit">NAME</th>
                                    <th class="cell-fit">DITAMBAHKAN</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="btn-group">
                        <button class="btn btn-warning" onclick="refreshNonLengkap()" data-bs-toggle="tooltip"
                            data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true" title="Segarkan"><i
                                class='fa-fw fas fa-sync nav-icon'></i>&nbsp;&nbsp;Segarkan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            var table = $('#dttable').DataTable({
                order: [
                    [3, "asc"]
                ],
                displayLength: 10,
                lengthChange: true,
                lengthMenu: [10, 25, 50, 75, 100, ],
                buttons: ['copy', 'excel', 'pdf', 'colvis']
            });

            table.buttons().container()
                .appendTo('#dttable_wrapper .col-md-6:eq(0)');
        })

        function showNonAktif() {
            $('#nonaktif').modal('show');
            $.ajax({
                url: "/api/profilkaryawan/nonaktif",
                type: 'GET',
                dataType: 'json', // added data type
                success: function(res) {
                    $("#tampil-tbody-nonaktif").empty();
                    $('#dttable-nonaktif').DataTable().clear().destroy();
                    res.show.forEach(item => {
                        content = `
                                <tr>
                                    <td>` + item.id + `</td>
                                    <td>` + item.name + `</td>
                                    <td>` + item.nama + `</td>
                                    <td>` + item.deleted_at.substring(0, 19).replace('T', ' ') +
                            `</td>
                                    <td><a href='javascript:void(0);' class='dropdown-item text-primary' onclick="batalNonAktif(` +
                            item.id + `)"><i class='fa-fw fas fa-user-check nav-icon'></i> Aktifkan</a></td>
                                </tr>
                            `;
                        $('#tampil-tbody-nonaktif').append(content);
                    })
                    var table = $('#dttable-nonaktif').DataTable({
                        order: [
                            [3, "desc"]
                        ],
                        displayLength: 7,
                        lengthChange: true,
                        lengthMenu: [7, 10, 25, 50, 75, 100],
                        buttons: ['copy', 'excel', 'pdf', 'colvis']
                    });

                    table.buttons().container()
                        .appendTo('#dttable-nonaktif_wrapper .col-md-6:eq(0)');

                    // Showing Tooltip
                    $('[data-bs-toggle="tooltip"]').tooltip({
                        trigger: 'hover'
                    })
                }
            })
        }

        function showNonLengkap() {
            $('#nonlengkap').modal('show');
            $.ajax({
                url: "/api/profilkaryawan/nonlengkap",
                type: 'GET',
                dataType: 'json', // added data type
                success: function(res) {
                    $("#tampil-tbody-nonlengkap").empty();
                    $('#dttable-nonlengkap').DataTable().clear().destroy();
                    res.show.forEach(item => {
                        content = `<tr>
                                    <td>` + item.id + `</td>
                                    <td>` + item.name + `</td>
                                    <td>` + item.created_at.substring(0, 19).replace('T', ' ') + `</td></tr>`;
                        $('#tampil-tbody-nonlengkap').append(content);
                    })
                    var table = $('#dttable-nonlengkap').DataTable({
                        order: [
                            [2, "desc"]
                        ],
                        displayLength: 7,
                        lengthChange: true,
                        lengthMenu: [7, 10, 25, 50, 75, 100],
                        buttons: ['copy', 'excel', 'pdf', 'colvis']
                    });

                    table.buttons().container()
                        .appendTo('#dttable-nonlengkap_wrapper .col-md-6:eq(0)');

                    // Showing Tooltip
                    $('[data-bs-toggle="tooltip"]').tooltip({
                        trigger: 'hover'
                    })
                }
            })
        }

        function refreshNonAktif() {
            $.ajax({
                url: "/api/profilkaryawan/nonaktif",
                type: 'GET',
                dataType: 'json', // added data type
                success: function(res) {
                    $("#tampil-tbody-nonaktif").empty();
                    $('#dttable-nonaktif').DataTable().clear().destroy();
                    res.show.forEach(item => {
                        content = `
                                <tr>
                                    <td>` + item.id + `</td>
                                    <td>` + item.name + `</td>
                                    <td>` + item.nama + `</td>
                                    <td>` + item.deleted_at.substring(0, 19).replace('T', ' ') +
                            `</td>
                                    <td><a href='javascript:void(0);' class='dropdown-item text-primary' onclick="batalNonAktif(` +
                            item.id + `)"><i class='fa-fw fas fa-user-check nav-icon'></i> Aktifkan</a></td>
                                </tr>
                            `;
                        $('#tampil-tbody-nonaktif').append(content);
                    })
                    var table = $('#dttable-nonaktif').DataTable({
                        order: [
                            [3, "desc"]
                        ],
                        displayLength: 7,
                        lengthChange: true,
                        lengthMenu: [7, 10, 25, 50, 75, 100],
                        buttons: ['copy', 'excel', 'pdf', 'colvis']
                    });

                    table.buttons().container()
                        .appendTo('#dttable-nonaktif_wrapper .col-md-6:eq(0)');

                    // Showing Tooltip
                    $('[data-bs-toggle="tooltip"]').tooltip({
                        trigger: 'hover'
                    })
                }
            })
        }

        function refreshNonLengkap() {
            $.ajax({
                url: "/api/profilkaryawan/nonlengkap",
                type: 'GET',
                dataType: 'json', // added data type
                success: function(res) {
                    $("#tampil-tbody-nonlengkap").empty();
                    $('#dttable-nonlengkap').DataTable().clear().destroy();
                    res.show.forEach(item => {
                        content = `<tr>
                                    <td>` + item.id + `</td>
                                    <td>` + item.name + `</td>
                                    <td>` + item.created_at.substring(0, 19).replace('T', ' ') + `</td></tr>`;
                        $('#tampil-tbody-nonlengkap').append(content);
                    })
                    var table = $('#dttable-nonlengkap').DataTable({
                        order: [
                            [2, "desc"]
                        ],
                        displayLength: 7,
                        lengthChange: true,
                        lengthMenu: [7, 10, 25, 50, 75, 100],
                        buttons: ['copy', 'excel', 'pdf', 'colvis']
                    });

                    table.buttons().container()
                        .appendTo('#dttable-nonlengkap_wrapper .col-md-6:eq(0)');

                    // Showing Tooltip
                    $('[data-bs-toggle="tooltip"]').tooltip({
                        trigger: 'hover'
                    })
                }
            })
        }

        function batalNonAktif(id) {
            $.ajax({
                url: "/api/profilkaryawan/setaktif/"+id,
                type: 'GET',
                dataType: 'json', // added data type
                success: function(res) {
                    iziToast.success({
                        title: 'Sukses!',
                        message: 'User ID : '+id+' sukses di Aktifkan kembali pada '+ res,
                        position: 'topRight'
                    });
                    refreshNonAktif();
                    window.location.reload();
                }
            })
        }
    </script>
@endsection
