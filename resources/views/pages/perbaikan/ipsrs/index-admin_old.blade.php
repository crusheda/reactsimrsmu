@extends('layouts.default')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Pengaduan - Admin Perbaikan IPSRS</h4>
            </div>
        </div>
    </div>

    @if (session('message'))
        <div class="alert alert-primary alert-dismissible" role="alert">
            <h6 class="alert-heading d-flex align-items-center fw-bold mb-1">Proses Berhasil!</h6>
            <p class="mb-0">{{ session('message') }}</p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
            </button>
        </div>
    @endif
    @if ($errors->count() > 0)
        <div class="alert alert-danger alert-dismissible" role="alert">
            <h6 class="alert-heading d-flex align-items-center fw-bold mb-1">Proses Gagal!</h6>
            <p class="mb-0">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            </p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
            </button>
        </div>
    @endif

    <div class="card card-action mb-4">
        <div class="d-flex justify-content-around flex-wrap my-4 mb-5">
            <div class="d-flex align-items-start me-4 mt-3 gap-3">
                <span class="badge bg-primary p-2 rounded"><i class='bx bx-check-double bx-sm'></i></span>
                <div>
                    <span>Total</span>
                    <h5 class="mb-0">{{ $list['total'] }}</h5>
                </div>
            </div>
            <div class="d-flex align-items-start mt-3 gap-3">
                <span class="badge p-2 rounded" style="background-color: rebeccapurple"><i
                        class='bx bx-list-check bx-sm'></i></span>
                <div>
                    <span>Diverifikasi</span>
                    <h5 class="mb-0">{{ $list['totalmasukpengaduan'] }}</h5>
                </div>
            </div>
            <div class="d-flex align-items-start mt-3 gap-3">
                <span class="badge p-2 rounded" style="background-color: salmon"><i
                        class='bx bx-calendar-check bx-sm'></i></span>
                <div>
                    <span>Diterima</span>
                    <h5 class="mb-0">{{ $list['totaldiverifikasi'] }}</h5>
                </div>
            </div>
            <div class="d-flex align-items-start mt-3 gap-3">
                <span class="badge p-2 rounded" style="background-color: orange"><i class='bx bx-wrench bx-sm'></i></span>
                <div>
                    <span>Dikerjakan</span>
                    <h5 class="mb-0">{{ $list['totaldikerjakan'] }}</h5>
                </div>
            </div>
            <div class="d-flex align-items-start mt-3 gap-3">
                <span class="badge p-2 rounded" style="background-color: turquoise"><i
                        class='bx bx-coffee bx-sm'></i></span>
                <div>
                    <span>Selesai</span>
                    <h5 class="mb-0">{{ $list['totalselesai'] }}</h5>
                </div>
            </div>
            <div class="d-flex align-items-start mt-3 gap-3">
                <span class="badge p-2 rounded" style="background-color: red"><i class='bx bx-calendar-x bx-sm'></i></span>
                <div>
                    <span>Ditolak</span>
                    <h5 class="mb-0">{{ $list['totalditolak'] }}</h5>
                </div>
            </div>
        </div>
    </div>
    <div class="card text-nowrap" style="overflow: visible;">
        <div class="card-header bg-transparent border-bottom">
            <div class="d-flex flex-wrap align-items-start">
                <div class="me-2">
                    <h5 class="card-title mt-1 mb-0">Daftar Pengaduan</h5>
                </div>
                <div class="hstack gap-3 ms-auto">
                    <div class="btn-group"> {{-- {{ route('ipsrs.riwayat') }} --}}
                        <a class="btn btn-outline-primary btn-sm" href="javascript:void(0);" data-bs-toggle="tooltip"
                            data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true"
                            title="Menampilkan Semua Data Pengaduan IPSRS">
                            <i class="bx bx-history scaleX-n1-rtl"></i>
                            <span class="align-middle">Riwayat Pengaduan</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table id="dttable" class="table dt-responsive table-hover nowrap w-100 align-middle">
                <thead>
                    <tr>
                        <th>
                            <center>#</center>
                        </th>
                        <th>NAMA</th>
                        <th>UNIT</th>
                        <th>LOKASI</th>
                        <th>STATUS</th>
                        <th>TGL PENGADUAN</th>
                    </tr>
                </thead>
                <tbody style="text-transform: capitalize">
                    @if (count($list['show']) > 0)
                        @foreach ($list['show'] as $item)
                            <tr>
                                <td>
                                    <center>
                                        <div class="btn-group" role="group">
                                            {{-- <button type="button" class="btn btn-primary text-white btn-sm" data-toggle="modal" data-target="#track{{ $item->id }}" data-toggle="tooltip" data-placement="bottom" title="TRACKING"><i class="fa fa-search"></i></button> --}}
                                            @if (empty($item->filename_pengaduan))
                                                <button type="button"
                                                    class="btn btn-secondary btn-sm text-white disabled"><i
                                                        class="fa-fw fas fa-image nav-icon"></i></button>
                                            @else
                                                <a class="btn btn-sm btn-info image-popup-vertical-fit" href="{{ url('storage/' . substr($item->filename_pengaduan, 7, 1000)) }}">
                                                    <i class="fa-fw fas fa-image nav-icon"></i>
                                                    <img class="img-fluid" alt="" src="{{ url('storage/' . substr($item->filename_pengaduan, 7, 1000)) }}" style="width:6.5rem" hidden>
                                                </a>
                                                {{-- <button type="button" class="btn btn-warning btn-sm text-white"
                                                    onclick="showLampiran({{ $item->id }})"><i
                                                        class="fa-fw fas fa-image nav-icon"></i></button> --}}
                                            @endif
                                            <button
                                                onclick="window.location.href='{{ url('perbaikan/ipsrs/detail/' . $item->id) }}'"
                                                type="button" class="btn btn-danger btn-sm"><i
                                                    class="fa fa-wrench"></i></button>
                                        </div>
                                    </center>
                                </td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ str_replace(str_split('[]"'), ' ', $item->unit) }}</td>
                                <td>{{ $item->lokasi }}</td>

                                @if (!empty($item->tgl_selesai) && empty($item->ket_penolakan))
                                    <td><kbd style="background-color: turquoise">Selesai</kbd></td>
                                @elseif (!empty($item->ket_penolakan))
                                    <td><kbd style="background-color: red">Ditolak</kbd></td>
                                @elseif (empty($item->tgl_diterima))
                                    <td><kbd style="background-color: rebeccapurple">Diverifikasi</kbd></td>
                                @elseif (empty($item->tgl_dikerjakan))
                                    <td><kbd style="background-color: salmon">Diterima</kbd></td>
                                @elseif (empty($item->tgl_selesai))
                                    <td><kbd style="background-color: orange">Dikerjakan</kbd></td>
                                @endif

                                <td>{{ $item->tgl_pengaduan }}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    {{-- MODAL START --}}
    {{-- MODAL END --}}
    <script>
        $(document).ready(function() {
            // $("body").addClass('sidebar-enable vertical-collpsed');

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
        });

        // FUNCTION
        function showLampiran(id) {
            Swal.fire({
                // title: 'Lampiran ID : '+id,
                // text: '',
                imageUrl: '/v2/laporan/pengaduan/ipsrs/' + id,
                // imageWidth: 400,
                imageHeight: 275,
                imageAlt: 'Lampiran',
                reverseButtons: true,
                showDenyButton: false,
                showCloseButton: true,
                showCancelButton: true,
                cancelButtonText: `<i class="fa fa-times me-1" style="font-size:13px"></i> Tutup`,
                confirmButtonText: `<i class="fa fa-download"></i> Download`,
                backdrop: `rgba(26,27,41,0.8)`,
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "/v2/laporan/pengaduan/ipsrs/" + id;
                }
            })
        }
    </script>
@endsection
