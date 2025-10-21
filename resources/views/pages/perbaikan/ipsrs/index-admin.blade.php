@extends('layouts.index')

@section('content')
    {{-- Sistem Tracking --}}
    <link href="{{ asset('css/tracking.css') }}" rel="stylesheet" />

    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i></a></li>
                        <li class="breadcrumb-item">Pengaduan</li>
                        <li class="breadcrumb-item">Perbaikan</li>
                        <li class="breadcrumb-item" aria-current="page">IPSRS <span class="badge rounded-pill text-bg-primary ms-1">Admin</span></li>
                    </ul>
                </div>
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h2 class="mb-0">Perbaikan IPSRS</h2>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- [ breadcrumb ] end -->

    <!-- [ Main Content ] start -->
    <div class="row pt-1">
        {{-- BARIS 1 --}}
        <div class="col-lg-2 col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-1">{{ $list['total'] }}</h3>
                            <p class="text-muted mb-0">Total</p>
                        </div>
                        <div class="col-4 text-end"><i class="ti ti-license text-secondary f-36"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-1">{{ $list['totalmasukpengaduan'] }}</h3>
                            <p class="text-muted mb-0">Diverifikasi</p>
                        </div>
                        <div class="col-4 text-end"><i class="ti ti-checks f-36" style="color: rebeccapurple"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-1">{{ $list['totaldiverifikasi'] }}</h3>
                            <p class="text-muted mb-0">Diterima</p>
                        </div>
                        <div class="col-4 text-end"><i class="ti ti-phone-incoming f-36" style="color: salmon"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-1">{{ $list['totaldikerjakan'] }}</h3>
                            <p class="text-muted mb-0">Dikerjakan</p>
                        </div>
                        <div class="col-4 text-end"><i class="ti ti-clock f-36" style="color: orange"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-1">{{ $list['totalselesai'] }}</h3>
                            <p class="text-muted mb-0">Diselesaikan</p>
                        </div>
                        <div class="col-4 text-end"><i class="ti ti-clipboard-check f-36" style="color: turquoise"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-1">{{ $list['totalditolak'] }}</h3>
                            <p class="text-muted mb-0">Ditolak</p>
                        </div>
                        <div class="col-4 text-end"><i class="ti ti-file-shredder f-36" style="color: red"></i></div>
                    </div>
                </div>
            </div>
        </div>
        {{-- BARIS 2 --}}
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="flex-grow-1">
                            <h5 class="mb-0">Diagram Pengaduan <a id="show_tahun" class="text-primary">Tahun {{ $list['tahun'] }}</a></h5>
                        </div>
                        <div class="flex-shrink-0 ms-3">
                            <div class="dropdown">
                                <a class="btn btn-link-secondary dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-haspopup="true">
                                    Tahun Lainnya
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    @php
                                        for ($i=2023; $i <= $list['tahun']; $i++) {
                                            if ($i == $list['tahun']) {
                                                echo"<button class='dropdown-item' onclick='diagram($i)'>Tahun $i (<a class='text-primary'>Saat Ini</a>)</button>";
                                            } else {
                                                echo"<button class='dropdown-item' onclick='diagram($i)'>Tahun $i</button>";
                                            }
                                        }
                                    @endphp
                                    {{-- <a class="dropdown-item" href="#">Today</a>
                                    <a class="dropdown-item" href="#">Weekly</a>
                                    <a class="dropdown-item" href="#">Monthly</a> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <h5 class="text-end my-2">5.44% <span class="badge bg-success">+2.6%</span></h5> --}}
                    <div id="diagram">
                        <div class="d-flex justify-content-center align-items-center"><span class="spinner-border spinner-border-sm text-primary me-2" role="status"></span>Loading...</div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between py-3">
                    <h5 class="mb-0">Tabel Pengaduan</h5>
                    <div class="btn-group">
                        <button type="button" class="btn btn-light-warning" id="btn-refresh" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true"
                                title="Segarkan Tabel Pengaduan (100 Data Terakhir)" onclick="refresh()">
                                <i class="fa-fw fas fa-sync nav-icon me-1"></i> 100 Data Aktif Terakhir</button>
                        {{-- <button type="button" class="btn btn-light-info" id="btn-refresh" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true"
                                title="Tampilkan 100 Data Terakhir" onclick="showHalf()">
                                <i class="fa-fw fas fa-history nav-icon"></i></button> --}}
                        <button type="button" class="btn btn-light-danger" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true"
                            title="Tampilkan Seluruh Data" onclick="showAll()">
                            <i class="fa-fw fas fa-infinity nav-icon me-1"></i> Seluruh Data</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive" id="table">
                        <div class="alert alert-secondary">
                            <small>
                                <i class="ti ti-arrow-narrow-right text-primary me-1"></i> Data pengaduan yang ditampilkan di bawah adalah <mark><b>100 Data</b> Pengaduan yang masih Aktif</mark> <br>
                            </small>
                        </div>
                        <table id="dttable" class="table table-hover dt-responsive align-middle">
                            <thead>
                                <tr>
                                    <th>#ID</th>
                                    <th><center>STATUS</center></th>
                                    <th>NAMA</th>
                                    <th>UNIT</th>
                                    <th>LOKASI</th>
                                    <th>TGL PENGADUAN</th>
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
                                    <th>#ID</th>
                                    <th><center>STATUS</center></th>
                                    <th>NAMA</th>
                                    <th>UNIT</th>
                                    <th>LOKASI</th>
                                    <th>TGL PENGADUAN</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="table-responsive" id="tableAll" hidden>
                        <div class="alert alert-secondary">
                            <small>
                                <i class="ti ti-arrow-narrow-right text-primary me-1"></i> Export Data <mark>EXCEL/PDF</mark> dapat melalui tombol pada tabel di bawah ini <br>
                                <i class="ti ti-arrow-narrow-right text-primary me-1"></i> Untuk menampilkan semua kolom, silakan <mark>CENTANG</mark> pilihan kolom pada tombol "<b>Column Visibility</b>" di bawah ini <br>
                                <i class="ti ti-arrow-narrow-right text-primary me-1"></i> Silakan melakukan pencarian / filtering data melalui kolom isian <mark>Search : .....</mark>
                            </small>
                        </div>
                        <table id="dttableAll" class="table table-hover dt-responsive align-middle">
                            <thead>
                                <tr>
                                    <th>#ID</th>
                                    <th><center>STATUS</center></th>
                                    <th>NAMA</th>
                                    <th>UNIT</th>
                                    <th>LOKASI</th>
                                    <th>TGL PENGADUAN</th>
                                    <th>KETERANGAN PENGADUAN</th>
                                    <th>TGL DITERIMA</th>
                                    <th>KETERANGAN DITERIMA</th>
                                    <th>TGL DIKERJAKAN</th>
                                    <th>KETERANGAN DIKERJAKAN</th>
                                    <th>TGL SELESAI</th>
                                    <th>KETERANGAN SELESAI</th>
                                    <th>KETERANGAN PENOLAKAN</th>
                                </tr>
                            </thead>
                            <tbody id="tampil-tbody-all">
                                <tr>
                                    <td colspan="9" style="font-size:13px">
                                        <center><i class="fa fa-spinner fa-spin fa-fw"></i> Memproses data...</center>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>#ID</th>
                                    <th><center>STATUS</center></th>
                                    <th>NAMA</th>
                                    <th>UNIT</th>
                                    <th>LOKASI</th>
                                    <th>TGL PENGADUAN</th>
                                    <th>KETERANGAN PENGADUAN</th>
                                    <th>TGL DITERIMA</th>
                                    <th>KETERANGAN DITERIMA</th>
                                    <th>TGL DIKERJAKAN</th>
                                    <th>KETERANGAN DIKERJAKAN</th>
                                    <th>TGL SELESAI</th>
                                    <th>KETERANGAN SELESAI</th>
                                    <th>KETERANGAN PENOLAKAN</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalLampiran" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-simple modal-add-new-address modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        Lampiran Pengaduan
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="imgPush"></div>
                    <h6 id="titleImgPush" class="text-center"></h6>
                </div>
                <div class="col-12 text-center mb-4">
                    <button type="reset" class="btn btn-link-secondary" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-times me-1" style="font-size:13px"></i> Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let chart;
        $(document).ready(function() {
            refresh();
            diagram(new Date().getFullYear());
        });

        // FUNCTION
        function refresh() {
            $("#table").prop('hidden',false);
            $("#tableAll").prop('hidden',true);
            $("#tampil-tbody").empty().append(
                `<tr><td colspan="20" style="font-size: 13px"><center><i class="fa fa-spinner fa-spin fa-fw"></i> Memproses data...</center></td></tr>`
            );
            $.ajax({
                url: "/api/perbaikan/ipsrs/admin/table",
                type: 'GET',
                dataType: 'json',
                success: function(res) {
                    $("#tampil-tbody").empty();
                    $('#dttable').DataTable().clear().destroy();
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
                        var status = '';
                        if (item.tgl_selesai != null && item.ket_penolakan == null) {
                            status = '<td><center><kbd style="background-color: turquoise">Selesai</kbd></center></td>';
                        } else {
                            if (item.ket_penolakan != null) {
                                status = '<td><center><kbd style="background-color: red">Ditolak</kbd></center></td>';
                            } else {
                                if (item.tgl_diterima == null) {
                                    status = '<td><center><kbd style="background-color: rebeccapurple">Diverifikasi</kbd></center></td>';
                                } else {
                                    if (item.tgl_dikerjakan == null) {
                                        status = '<td><center><kbd style="background-color: salmon">Diterima</kbd></center></td>';
                                    } else {
                                        if (item.tgl_selesai == null) {
                                            status = '<td><center><kbd style="background-color: orange">Dikerjakan</kbd></center></td>';
                                        } else {
                                            status = '<td><center><kbd style="background-color: dark">Tidak Ditemukan</kbd></center></td>';
                                        }
                                    }
                                }
                            }
                        }

                        content = `<tr><td><div class="d-flex align-items-center">
                                        <div class="dropdown">
                                            <a href="javascript:;" class="btn btn-sm btn-link dropdown-toggle hide-arrow" data-bs-toggle="dropdown">${item.id}</a>
                                            <div class="dropdown-menu dropdown-menu-right">`;
                                                if (item.filename_pengaduan != null && item.filename_pengaduan != '') {
                                                    content += `<a href="javascript:;" onclick="showLampiran(${item.id})" class="dropdown-item text-info"><i class='fas fa-image me-2'></i> Lampiran</a>`;
                                                } else {
                                                    content += `<a href="javascript:;" class="dropdown-item text-secondary disabled" disabled><i class='fas fa-image me-2'></i> Lampiran</a>`;
                                                }
                                                content += `<a href="/perbaikan/ipsrs/detail/${item.id}" class="dropdown-item text-primary"><i class='fa fa-wrench me-2'></i> Lihat Pengaduan</a>`;
                        content += `</div></div></div></td>`;
                        // LANJUT CONTENT
                        content += status;
                        content += `<td>${item.nama?item.nama:'<s class="text-danger">Nama Tidak Valid</s>'}</td>`;
                        content += `<td>`+un+`</td>`;
                        content += `<td>${item.lokasi}</td>`;
                        content += `<td>`+new Date(item.tgl_pengaduan).toLocaleString("sv-SE")+`</td></tr>`;
                        $('#tampil-tbody').append(content);
                    })

                    var table = $('#dttable').DataTable({
                        // dom: 'Bfrtip',
                        order: [
                            [5, "desc"]
                        ],
                        bAutoWidth: false,
                        aoColumns : [
                            { sWidth: '8%' },
                            { sWidth: '8%' },
                            { sWidth: '20%' },
                            { sWidth: '24%' },
                            { sWidth: '30%' },
                            { sWidth: '10%' },
                        ],
                        // columnDefs: [
                        //     { visible: false, targets: [7] },
                        // ],
                        displayLength: 20,
                        lengthChange: true,
                        lengthMenu: [20, 50, 75, 100, 300, 500],
                        // buttons: ['copy', 'excel', 'pdf', 'colvis']
                    });
                }
            })
        }

        function showAll() {
            $("#table").prop('hidden',true);
            $("#tableAll").prop('hidden',false);
            $("#tampil-tbody-all").empty().append(
                `<tr><td colspan="20" style="font-size: 13px"><center><i class="fa fa-spinner fa-spin fa-fw"></i> Memproses seluruh data...</center></td></tr>`
            );
            $.ajax({
                url: "/api/perbaikan/ipsrs/admin/tableAll",
                type: 'GET',
                dataType: 'json',
                success: function(res) {
                    $("#tampil-tbody-all").empty();
                    $('#dttableAll').DataTable().clear().destroy();
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
                        var status = '';
                        if (item.tgl_selesai != null && item.ket_penolakan == null) {
                            status = '<td><center><kbd style="background-color: turquoise">Selesai</kbd></center></td>';
                        } else {
                            if (item.ket_penolakan != null) {
                                status = '<td><center><kbd style="background-color: red">Ditolak</kbd></center></td>';
                            } else {
                                if (item.tgl_diterima == null) {
                                    status = '<td><center><kbd style="background-color: rebeccapurple">Diverifikasi</kbd></center></td>';
                                } else {
                                    if (item.tgl_dikerjakan == null) {
                                        status = '<td><center><kbd style="background-color: salmon">Diterima</kbd></center></td>';
                                    } else {
                                        if (item.tgl_selesai == null) {
                                            status = '<td><center><kbd style="background-color: orange">Dikerjakan</kbd></center></td>';
                                        } else {
                                            status = '<td><center><kbd style="background-color: dark">Tidak Ditemukan</kbd></center></td>';
                                        }
                                    }
                                }
                            }
                        }

                        content = `<tr><td><div class="d-flex align-items-center">
                                        <div class="dropdown">
                                            <a href="javascript:;" class="btn btn-sm btn-link dropdown-toggle hide-arrow" data-bs-toggle="dropdown">${item.id}</a>
                                            <div class="dropdown-menu dropdown-menu-right">`;
                                                if (item.filename_pengaduan != null && item.filename_pengaduan != '') {
                                                    content += `<a href="javascript:;" onclick="showLampiran(${item.id})" class="dropdown-item text-info"><i class='fas fa-image me-2'></i> Lampiran</a>`;
                                                } else {
                                                    content += `<a href="javascript:;" class="dropdown-item text-secondary disabled" disabled><i class='fas fa-image me-2'></i> Lampiran</a>`;
                                                }
                                                content += `<a href="/perbaikan/ipsrs/detail/${item.id}" class="dropdown-item text-primary"><i class='fa fa-wrench me-2'></i> Lihat Pengaduan</a>`;
                        content += `</div></div></div></td>`;
                        // LANJUT CONTENT
                        content += status;
                        content += `<td>${item.nama?item.nama:'<s class="text-danger">Nama Tidak Valid</s>'}</td>`;
                        content += `<td>`+un+`</td>`;
                        content += `<td>${item.lokasi}</td>`;
                        content += `<td>`+new Date(item.tgl_pengaduan).toLocaleString("sv-SE")+`</td>`;
                        content += `<td>${item.ket_pengaduan?item.ket_pengaduan:'-'}</td>`;
                        content += `<td>`+new Date(item.tgl_diterima).toLocaleString("sv-SE")+`</td>`;
                        content += `<td>${item.ket_diterima?item.ket_diterima:'-'}</td>`;
                        content += `<td>`+new Date(item.tgl_dikerjakan).toLocaleString("sv-SE")+`</td>`;
                        content += `<td>${item.ket_dikerjakan?item.ket_dikerjakan:'-'}</td>`;
                        content += `<td>`+new Date(item.tgl_selesai).toLocaleString("sv-SE")+`</td>`;
                        content += `<td>${item.ket_selesai?item.ket_selesai:'-'}</td>`;
                        content += `<td>${item.ket_penolakan?item.ket_penolakan:'-'}</td></tr>`;
                        $('#tampil-tbody-all').append(content);
                    })

                    var table = $('#dttableAll').DataTable({
                        dom: 'Bfrtip',
                        order: [
                            [5, "desc"]
                        ],
                        // bAutoWidth: false,
                        // aoColumns : [
                        //     { sWidth: '8%' },
                        //     { sWidth: '8%' },
                        //     { sWidth: '20%' },
                        //     { sWidth: '24%' },
                        //     { sWidth: '30%' },
                        //     { sWidth: '10%' },
                        // ],
                        columnDefs: [
                            { visible: false, targets: [6] },
                            { visible: false, targets: [7] },
                            { visible: false, targets: [8] },
                            { visible: false, targets: [9] },
                            { visible: false, targets: [10] },
                            { visible: false, targets: [11] },
                            { visible: false, targets: [12] },
                            { visible: false, targets: [13] },
                        ],
                        displayLength: 100,
                        lengthChange: true,
                        lengthMenu: [100, 300, 500, 1000, 5000, 10000],
                        buttons: ['excel', 'pdf', 'colvis']
                    });
                }
            })
        }

        function showLampiran(id) {
            $.ajax({
                url: "/api/perbaikan/ipsrs/admin/lampiran/"+id,
                type: 'GET',
                dataType: 'json',
                success: function(res) {
                    $('#imgPush').empty();
                    $('#titleImgPush').text(res.title_pengaduan);
                    $('#imgPush').append(`<center><img src="/storage/`+res.filename_pengaduan.substring(7,1000)+`" class="img-fluid" alt=""></center>`);
                    $('#modalLampiran').modal('show');
                }
            })
        }

        function diagram(tahun) {
            $('#diagram').empty();
            $('#diagram').append(`<div class="d-flex justify-content-center align-items-center"><span class="spinner-border spinner-border-sm text-primary me-2" role="status"></span>Loading...</div>`);
            $.ajax({
                url: "/api/perbaikan/ipsrs/admin/diagram/"+tahun,
                type: 'GET',
                dataType: 'json',
                success: function(res) {
                    // console.log(res);
                    $('#diagram').empty();
                    $('#show_tahun').text('Tahun '+tahun);
                    new ApexCharts(document.querySelector("#diagram"), {
                        chart: {
                            type: "area",
                            height: 300,
                            toolbar: {
                                show: !1
                            }
                        },
                        colors: ["#0d6efd","#F80F30"],
                        fill: {
                            type: "gradient",
                            gradient: {
                                shadeIntensity: 1,
                                type: "vertical",
                                inverseColors: !1,
                                opacityFrom: .5,
                                opacityTo: 0
                            }
                        },
                        dataLabels: {
                            enabled: !1
                        },
                        stroke: {
                            width: 1
                        },
                        plotOptions: {
                            bar: {
                                columnWidth: "45%",
                                borderRadius: 4
                            }
                        },
                        grid: {
                            strokeDashArray: 4
                        },
                        series: [
                            {
                                name: 'Pengaduan Selesai',
                                data: res.selesai
                            },
                            {
                                name: 'Pengaduan Ditolak',
                                // data: [30, 60, 40, 70, 50, 90, 50, 55, 45, 60, 50, 65]
                                data: res.ditolak
                            }
                        ],
                        xaxis: {
                            categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                            axisBorder: {
                                show: !1
                            },
                            axisTicks: {
                                show: !1
                            }
                        }
                    }).render();
                }
            })
        }
    </script>
@endsection
