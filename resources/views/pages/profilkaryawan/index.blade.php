@extends('layouts.index')

@section('content')
    <style>
        #grafik-show {
            width: 100%;
            aspect-ratio: 1/1;
            max-height: 500px;
        }
    </style>

    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i></a></li>
                        <li class="breadcrumb-item">Kepegawaian</li>
                        <li class="breadcrumb-item" aria-current="page">Profil Kepegawaian</li>
                    </ul>
                </div>
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h2 class="mb-0">Profil Kepegawaian</h2>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- [ breadcrumb ] end -->

    <!-- [ Main Content ] start -->
    <div class="row pt-1">
        <div class="col-sm-12" id="show-card-grafik" hidden>
            <div class="card">
                <div class="card-body p-4 pb-1">
                    <div class="d-flex align-items-center mb-2">
                        <div class="flex-grow-1">
                            <h5 class="mb-0"><i class="ph-duotone ph-database me-1"></i> Grafik Interaktif Pegawai</h5>
                        </div>
                        <div class="flex-shrink-0 ms-3">
                            <div class="dropdown">
                                <a class="btn btn-light-secondary dropdown-toggle arrow-none" href="#"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="ti ti-grid-dots f-18 me-1"></i> Pilihan Grafik
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="showGrafikJenisPegawai()">Jenis Pegawai</a>
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="showGrafikJenisKelamin()">Jenis Kelamin</a>
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="showGrafikPendidikan()">Pendidikan</a>
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="showGrafikProfesi()">Profesi</a>
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="showGrafikStatusPegawai()">Status Pegawai</a>
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="showGrafikStatusKawin()">Status Perkawinan</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-7 border-end">
                        <ul class="list-group list-group-flush" id="list-grafik"></ul>
                    </div>
                    <div class="col-md-5 align-items-center">
                        <h5 class="text-center my-2" id="show-name-grafik"></h5>
                        <div id="grafik-show" style="width:100%; min-height:400px; height:100%;"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between py-3">
                    <div class="btn-group shadow">
                        <button class="btn btn-light-primary" onclick="window.location.href='{{ route('akunpengguna.index') }}'" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="Pengaturan Akun Pengguna (Tambah/Ubah/Hapus Akun Karyawan)">
                            <i class="fas fa-users-cog me-1"></i> Pengaturan Akun</button>
                        <button class="btn btn-light-warning" id="btn-tabel-simpel" onclick="refresh()" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="Menampilkan Data Simpel Profil Karyawan">
                            <i class="fas fa-sync me-1"></i> Tabel Simpel</button>
                        <button type="button" class="btn btn-light-danger" id="btn-tabel-lengkap" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="Menampilkan Seluruh Data Profil Karyawan" onclick="showAll()">
                            <i class="fa-fw fas fa-infinity nav-icon me-1"></i> Tabel Lengkap</button>
                        {{-- <button class="btn btn-light-info" onclick="" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="Menampilkan Seluruh Data Profil Karyawan">
                            <i class="fas fa-history me-1"></i></button> --}}
                    </div>
                    <div class="btn-group">
                        <a href="javascript:void(0);" class="avtar avtar-s btn-light-secondary dropdown-toggle arrow-none" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"><i class="ti ti-dots-vertical f-18"></i></a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <li>
                                <a class="dropdown-item" href="javascript:void(0);" onclick="showNonLengkap()">Profil Belum Lengkap</a>
                                <a class="dropdown-item" href="javascript:void(0);" onclick="showNonAktif()">Karyawan Nonaktif</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-body p-3">
                    <div class="alert alert-secondary">
                        <small><i class="fa-fw fas fa-caret-right nav-icon me-1"></i> Refresh browser Anda apabila terjadi Error saat pengambilan data karyawan</small><br>
                        <small><i class="fa-fw fas fa-caret-right nav-icon me-1"></i> Klik pada <u class="text-primary"><b>#ID Karyawan</b></u> untuk melihat Profil</small>
                    </div>
                    <div class="table-responsive" id="table1">
                        <table id="dttable" class="table align-middle dt-responsive table-hover nowrap w-100">
                            <thead>
                                <tr>
                                    <th class="cell-fit"><center>#ID</center></th>
                                    <th class="cell-fit">AKUN / USERNAME</th>
                                    <th class="cell-fit">NAMA LENGKAP</th>
                                    <th class="cell-fit">TERAKHIR DIPERBARUI</th>
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
                                <th class="cell-fit"><center>#ID</center></th>
                                <th class="cell-fit">AKUN / USERNAME</th>
                                <th class="cell-fit">NAMA LENGKAP</th>
                                <th class="cell-fit">TERAKHIR DIPERBARUI</th>
                            </tfoot>
                        </table>
                    </div>
                    <div class="table-responsive" id="table2" hidden>
                        <table id="dttable-all" class="table align-middle dt-responsive table-hover nowrap w-100">
                            <thead>
                                <tr>
                                    <th class="cell-fit">ID</th> {{-- 0 --}}
                                    <th>NIP</th>
                                    <th>NIK</th>
                                    <th>USERNAME</th>
                                    <th>NAMA LENGKAP</th>
                                    <th>PANGGILAN</th>
                                    <th>TMPT/TGL LAHIR</th>
                                    <th>JENIS KELAMIN</th>
                                    <th>STATUS KAWIN</th>
                                    <th>STATUS PEGAWAI</th>
                                    <th>JABATAN</th> {{-- 10 --}}
                                    <th>KLASIFIKASI</th>
                                    <th>MASUK KERJA</th>
                                    <th>URUTAN MASUK</th>
                                    <th>TMT</th>
                                    <th>TAT</th> {{-- 15 --}}
                                    <th>NO.HP</th>
                                    <th>EMAIL</th>
                                    <th>FB</th>
                                    <th>IG</th>
                                    <th>TT</th> {{-- 20 --}}
                                    <th>KELURAHAN (KTP)</th>
                                    <th>KECAMATAN (KTP)</th>
                                    <th>KABUPATEN (KTP)</th>
                                    <th>PROVINSI (KTP)</th>
                                    <th class="cell-fit">ALAMAT (KTP)</th> {{-- 25 --}}
                                    <th>KELURAHAN (DOM)</th>
                                    <th>KECAMATAN (DOM)</th>
                                    <th>KABUPATEN (DOM)</th>
                                    <th>PROVINSI (DOM)</th>
                                    <th class="cell-fit">ALAMAT (DOM)</th> {{-- 30 --}}
                                    <th>SD</th>
                                    <th>SMP</th>
                                    <th>SMA</th>
                                    <th>D1</th>
                                    <th>D2</th> {{-- 35 --}}
                                    <th>D3</th>
                                    <th>D4</th>
                                    <th>S1</th>
                                    <th>S1 PROFESI</th>
                                    <th>S2</th> {{-- 40 --}}
                                    <th>S3</th>
                                    <th class="cell-fit">PENGALAMAN KERJA</th>
                                    <th>RIWAYAT PENYAKIT</th>
                                    <th>RIWAYAT PENYAKIT KELUARGA</th>
                                    <th>RIWAYAT OPERASI</th> {{-- 45 --}}
                                    <th>RIWAYAT PENGGUNAAN OBAT</th>
                                    <th class="cell-fit">UPDATE</th>
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
                                    <th class="cell-fit">ID</th>
                                    <th>NIP</th>
                                    <th>NIK</th>
                                    <th>USERNAME</th>
                                    <th>NAMA LENGKAP</th>
                                    <th>PANGGILAN</th>
                                    <th>TMPT/TGL LAHIR</th>
                                    <th>JENIS KELAMIN</th>
                                    <th>STATUS KAWIN</th>
                                    <th>STATUS PEGAWAI</th>
                                    <th>JABATAN</th>
                                    <th>KLASIFIKASI</th>
                                    <th>MASUK KERJA</th>
                                    <th>URUTAN MASUK</th>
                                    <th>TMT</th>
                                    <th>TAT</th>
                                    <th>NO.HP</th>
                                    <th>EMAIL</th>
                                    <th>FB</th>
                                    <th>IG</th>
                                    <th>TT</th>
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
                                    <th>S1 PROFESI</th>
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
                </div>
            </div>
        </div>
    </div>

    {{-- NONAKTIF --}}
    <div class="modal fade animate__animated animate__jackInTheBox" id="nonaktif" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        Daftar Karyawan Nonaktif
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-1">
                    <div class="table-responsive text-nowrap table-card">
                        <table id="dttable-nonaktif" class="table dt-responsive table-hover nowrap w-100">
                            <thead>
                                <tr>
                                    <th class="cell-fit"><center>ID</center></th>
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
                                    <td colspan="9" style="font-size:13px">
                                        <center><i class="fa fa-spinner fa-spin fa-fw"></i> Memproses data...</center>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th class="cell-fit"><center>ID</center></th>
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
                    <a class="btn btn-label-secondary" href="javascript:void(0);" data-bs-dismiss="modal"><i
                        class="fas fa-chevron-left"></i>&nbsp;&nbsp;Tutup</a>
                    <div class="btn-group">
                        <button class="btn btn-warning" onclick="refreshNonAktif()"><i class='fa-fw fas fa-sync nav-icon'></i>&nbsp;&nbsp;Segarkan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- TIDAK LENGKAP --}}
    <div class="modal fade animate__animated animate__jackInTheBox" id="nonlengkap" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        Daftar Profil Karyawan Belum Lengkap
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-1">
                    <div class="table-responsive text-nowrap" style="border: 0px">
                        <table id="dttable-nonlengkap" class="table dt-responsive table-hover nowrap w-100">
                            <thead>
                                <tr>
                                    <th class="cell-fit"><center>ID</center></th>
                                    <th class="cell-fit">NAME</th>
                                    <th class="cell-fit">DITAMBAHKAN</th>
                                </tr>
                            </thead>
                            <tbody id="tampil-tbody-nonlengkap">
                                <tr>
                                    <td colspan="9" style="font-size:13px">
                                        <center><i class="fa fa-spinner fa-spin fa-fw"></i> Memproses data...</center>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th class="cell-fit"><center>ID</center></th>
                                    <th class="cell-fit">NAME</th>
                                    <th class="cell-fit">DITAMBAHKAN</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-label-secondary" href="javascript:void(0);" data-bs-dismiss="modal"><i
                        class="fas fa-chevron-left"></i>&nbsp;&nbsp;Tutup</a>
                    <div class="btn-group">
                        <button class="btn btn-warning" onclick="refreshNonLengkap()"><i class='fa-fw fas fa-sync nav-icon'></i>&nbsp;&nbsp;Segarkan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal animate__animated animate__rubberBand fade" id="aktifKaryawan" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-simple modal-add-new-address modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        Apakah Anda sudah Yakin?
                    </h4>
                </div>
                <div class="modal-body">
                    <input type="text" id="id_aktif_karyawan" hidden>
                    <p style="text-align: justify;">Anda akan mengaktifkan kembali karyawan dengan <kbd>ID : <a id="show_id_aktif_karyawan"></a></kbd> dan/apabila melanjutkan proses Submit, data Anda akan tercatat dalam database.</p>
                    <label class="switch">
                        <input type="checkbox" class="switch-input" id="setujuaktifkaryawan">
                        <span class="switch-toggle-slider">
                        <span class="switch-on"></span>
                        <span class="switch-off"></span>
                        </span>
                        <span class="switch-label">Saya Setuju</span>
                    </label>
                </div>
                <div class="col-12 text-center mb-4">
                    <button type="submit" id="btn-aktif-karyawan" class="btn btn-danger me-sm-3 me-1" onclick="batalNonAktif()"><i class="ti ti-checkbox me-1" style="font-size:13px"></i> Submit</button>
                    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close" onclick="hideAktifKaryawan()"><i class="fa fa-times me-1" style="font-size:13px"></i> Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let grafik = null; // INITIALIZE GRAPH
        $(document).ready(function() {
            showGrafikStatusPegawai();
            // TABEL PROFIL KARYAWAN INIT
            refresh();
            // $.ajax({
            //     url: "/api/profilkaryawan/table",
            //     type: 'GET',
            //     dataType: 'json', // added data type
            //     success: function(res) {
            //         $("#tampil-tbody").empty();
            //         res.show.forEach(item => {
            //             content = "<tr id='data" + item.id + "'>";
            //             content += `<td><center><div class='btn-group'>
            //                             <button type='button' class='btn btn-sm btn-link dropdown-toggle hide-arrow ${item.nik?'text-primary':'text-danger'}' data-bs-toggle='dropdown' aria-expanded='false'>`+item.id+`</button>
            //                             <ul class='dropdown-menu dropdown-menu-right'>`;
            //                 content += `<li><a href="/kepegawaian/profilkaryawan/${item.id}" class='dropdown-item text-primary'><i class="fa-fw fas fa-search nav-icon me-1"></i> Lihat Profil</a></li>
            //                             <li><a href='javascript:void(0);' class='dropdown-item text-danger' onclick="nonaktif(` + item.id + `)"><i class="fa-fw fas fa-trash nav-icon me-1"></i> Nonaktif</a></li>`;
            //             content += `</div></center></td>`;
            //             content += `<td>${item.name}</td>`;
            //             content += `<td>${item.nama?item.nama:'<b class="text-danger">Data Tidak Valid</b>'}</td>`;
            //             content += '<td>' + new Date(item.updated_at).toLocaleString("sv-SE") + '</td>';
            //             content += `</tr>`;
            //             $('#tampil-tbody').append(content);
            //         });
            //         var table = $('#dttable').DataTable({
            //             order: [
            //                 [3, "desc"]
            //             ],
            //             bAutoWidth: false,
            //             aoColumns : [
            //                 { sWidth: '10%' },
            //                 { sWidth: '20%' },
            //                 { sWidth: '55%' },
            //                 { sWidth: '15%' },
            //             ],
            //             displayLength: 10,
            //             lengthChange: true,
            //             lengthMenu: [10, 25, 50, 75, 100],
            //         });
            //     }
            // });
        });

        // FUNCTION-FUNCTION
        function refresh() {
            $('#btn-tabel-simpel').find('i').addClass('fa-spin');
            $("#tampil-tbody").empty().append(
                `<tr><td colspan="9" style="font-size:13px"><center><i class="fa fa-spinner fa-spin fa-fw"></i> Memproses data...</center></td></tr>`
            );
            $.ajax({
                url: "/api/profilkaryawan/table",
                type: 'GET',
                dataType: 'json', // added data type
                success: function(res) {
                    $("#tampil-tbody").empty();
                    $('#dttable').DataTable().clear().destroy();
                    res.show.forEach(item => {
                        content = "<tr id='data" + item.id + "'>";
                        content += `<td><center><div class='btn-group'>
                                        <button type='button' class='btn btn-sm btn-link dropdown-toggle hide-arrow ${item.nik?'text-primary':'text-danger'}' data-bs-toggle='dropdown' aria-expanded='false'>`+item.id+`</button>
                                        <ul class='dropdown-menu dropdown-menu-right'>`;
                            content += `<li><a href="/kepegawaian/profilkaryawan/${item.id}" class='dropdown-item text-primary'><i class="fa-fw fas fa-search nav-icon me-1"></i> Lihat Profil</a></li>`;
                            // content += `<li><a href='javascript:void(0);' class='dropdown-item text-danger' onclick="nonaktif(` + item.id + `)"><i class="fa-fw fas fa-trash nav-icon me-1"></i> Nonaktif</a></li>`;
                        content += `</div></center></td>`;
                        content += `<td>${item.name}</td>`;
                        content += `<td>${item.nama?item.nama:'<b class="text-danger">Data Tidak Valid</b>'}</td>`;
                        content += '<td>' + new Date(item.updated_at).toLocaleString("sv-SE") + '</td>';
                        content += `</tr>`;
                        $('#tampil-tbody').append(content);
                    });
                    var table = $('#dttable').DataTable({
                        order: [
                            [3, "desc"]
                        ],
                        bAutoWidth: false,
                        aoColumns : [
                            { sWidth: '10%' },
                            { sWidth: '20%' },
                            { sWidth: '55%' },
                            { sWidth: '15%' },
                        ],
                        displayLength: 10,
                        lengthChange: true,
                        lengthMenu: [10, 25, 50, 75, 100],
                    });

                    // Set True / False Table
                    $("#table1").prop('hidden',false);
                    $("#table2").prop('hidden',true);
                    $('#btn-tabel-simpel').find('i').removeClass('fa-spin');
                },
                error: function(res) {
                    iziToast.error({
                        title: 'Pesan Galat!',
                        message: 'Proses memuat Data Gagal!',
                        position: 'topRight'
                    });
                    $('#btn-tabel-simpel').find('i').removeClass('fa-spin');
                }
            });
        }

        function showAll() {
            $('#btn-tabel-lengkap').find('i').removeClass('fa-infinity').addClass('fa-sync fa-spin');
            $("#tampil-tbody-all").empty().append(
                `<tr><td colspan="20" style="font-size:13px"><center><i class="fa fa-spinner fa-spin fa-fw"></i> Memproses data...</center></td></tr>`
            );
            $.ajax({
                url: "/api/profilkaryawan/tableall",
                type: 'GET',
                dataType: 'json', // added data type
                success: function(res) {
                    $("#tampil-tbody-all").empty();
                    $('#dttable-all').DataTable().clear().destroy();
                    res.show.forEach(item => {
                        // var us = JSON.parse(res.user);
                        content = "<tr id='data" + item.id + "' style='font-size:13px'>";
                        content += `<td><center><div class='btn-group'>
                                        <button type='button' class='btn btn-sm btn-link dropdown-toggle hide-arrow ${item.nik?'text-primary':'text-danger'}' data-bs-toggle='dropdown' aria-expanded='false'>`+item.id+`</button>
                                        <ul class='dropdown-menu dropdown-menu-right'>`;
                            content += `<li><a href="/kepegawaian/profilkaryawan/${item.id}" class='dropdown-item text-primary'><i class="fa-fw fas fa-search nav-icon me-1"></i> Lihat Profil</a></li>`;
                        content += `</div></center></td>`;
                        content += `<td>${item.nip?item.nip:'-'}</td>`;
                        content += `<td>${item.nik?item.nik:'-'}</td>`;
                        content += `<td>${item.name}</td>`;
                        if (item.nama_lengkap) {
                            pNama = item.nama_lengkap;
                        } else {
                            if (item.nama) {
                                pNama = item.nama;
                            } else {
                                pNama = '-';
                            }
                        }
                        content += `<td>${pNama}</td>`;
                        content += `<td>${item.nick?item.nick:'-'}</td>`;
                        content += `<td>${item.temp_lahir?item.temp_lahir:'-'}${item.tgl_lahir?', '+item.tgl_lahir:''}</td>`;
                        content += `<td>${item.jns_kelamin?item.jns_kelamin:'-'}</td>`;
                        content += `<td>${item.status_kawin?item.status_kawin:'-'}</td>`;
                        content += `<td>${item.status_pegawai?item.status_pegawai:'-'}</td>`;
                        content += `<td>`;
                        res.role.forEach(val => {
                            if (item.id == val.id_user) {
                                content += "<span class='badge bg-light-secondary'>" + val.nama_role + "</span>";
                            }
                        })
                        content += `</td>`;
                        content += `<td>${item.klasifikasi_user?item.klasifikasi_user:'-'}</td>`;
                        content += `<td>${item.masuk_kerja?item.masuk_kerja:'-'}</td>`;
                        content += `<td>${item.urutan_masuk?item.urutan_masuk:'-'}</td>`;
                        content += `<td>${item.tmt?item.tmt:'-'}</td>`;
                        content += `<td>${item.tat?item.tat:'-'}</td>`;
                        content += `<td>${item.no_hp?item.no_hp:'-'}</td>`;
                        content += `<td>${item.email?item.email:'-'}</td>`;
                        content += `<td>${item.fb?item.fb:'-'}</td>`;
                        content += `<td>${item.ig?item.ig:'-'}</td>`;
                        content += `<td>${item.tt?item.tt:'-'}</td>`;
                        content += `<td>${item.ktp_kelurahan?item.ktp_kelurahan:'-'}</td>`;
                        content += `<td>${item.ktp_kecamatan?item.ktp_kecamatan:'-'}</td>`;
                        content += `<td>${item.ktp_kabupaten?item.ktp_kabupaten:'-'}</td>`;
                        content += `<td>${item.ktp_provinsi?item.ktp_provinsi:'-'}</td>`;
                        content += `<td>${item.alamat_ktp?item.alamat_ktp:'-'}</td>`;
                        content += `<td>${item.dom_kelurahan?item.dom_kelurahan:'-'}</td>`;
                        content += `<td>${item.dom_kecamatan?item.dom_kecamatan:'-'}</td>`;
                        content += `<td>${item.dom_kabupaten?item.dom_kabupaten:'-'}</td>`;
                        content += `<td>${item.dom_provinsi?item.dom_provinsi:'-'}</td>`;
                        content += `<td>${item.alamat_dom?item.alamat_dom:'-'}</td>`;
                        content += `<td>${item.sd?item.sd:'-'} ${item.th_sd?' ('+item.th_sd+')':''}</td>`;
                        content += `<td>${item.smp?item.smp:'-'} ${item.th_smp?' ('+item.th_smp+')':''}</td>`;
                        content += `<td>${item.sma?item.sma:'-'} ${item.th_sma?' ('+item.th_sma+')':''}</td>`;
                        content += `<td>${item.d1?item.d1:'-'} ${item.th_d1?' ('+item.th_d1+')':''}</td>`;
                        content += `<td>${item.d2?item.d2:'-'} ${item.th_d2?' ('+item.th_d2+')':''}</td>`;
                        content += `<td>${item.d3?item.d3:'-'} ${item.th_d3?' ('+item.th_d3+')':''}</td>`;
                        content += `<td>${item.d4?item.d4:'-'} ${item.th_d4?' ('+item.th_d4+')':''}</td>`;
                        content += `<td>${item.s1?item.s1:'-'} ${item.th_s1?' ('+item.th_s1+')':''}</td>`;
                        content += `<td>${item.s1_profesi?item.s1_profesi:'-'} ${item.th_s1_profesi?' ('+item.th_s1_profesi+')':''}</td>`;
                        content += `<td>${item.s2?item.s2:'-'} ${item.th_s2?' ('+item.th_s2+')':''}</td>`;
                        content += `<td>${item.s3?item.s3:'-'} ${item.th_s3?' ('+item.th_s3+')':''}</td>`;
                        content += `<td>${item.pengalaman_kerja?item.pengalaman_kerja:'-'}</td>`;
                        content += `<td>${item.riwayat_penyakit?item.riwayat_penyakit:'-'}</td>`;
                        content += `<td>${item.riwayat_penyakit_keluarga?item.riwayat_penyakit_keluarga:'-'}</td>`;
                        content += `<td>${item.riwayat_operasi?item.riwayat_operasi:'-'}</td>`;
                        content += `<td>${item.riwayat_penggunaan_obat?item.riwayat_penggunaan_obat:'-'}</td>`;
                        content += '<td>' + new Date(item.updated_at).toLocaleString("sv-SE") + '</td>';
                        content += `</tr>`;
                        $('#tampil-tbody-all').append(content);
                    });
                    var table = $('#dttable-all').DataTable({
                        dom: 'Bfrtip',
                        order: [
                            [47, "desc"]
                        ],
                        // bAutoWidth: false,
                        // aoColumns : [
                        //     { sWidth: '10%' },
                        //     { sWidth: '20%' },
                        //     { sWidth: '55%' },
                        //     { sWidth: '15%' },
                        // ],
                        columnDefs: [
                            { visible: false, targets: [5] },
                            { visible: false, targets: [7] },
                            { visible: false, targets: [8] },
                            { visible: false, targets: [11] },
                            { visible: false, targets: [12] },
                            { visible: false, targets: [13] },
                            { visible: false, targets: [14] },
                            { visible: false, targets: [15] },
                            { visible: false, targets: [17] },
                            { visible: false, targets: [18] },
                            { visible: false, targets: [19] },
                            { visible: false, targets: [20] },
                            { visible: false, targets: [21] },
                            { visible: false, targets: [22] },
                            { visible: false, targets: [23] },
                            { visible: false, targets: [24] },
                            { visible: false, targets: [26] },
                            { visible: false, targets: [27] },
                            { visible: false, targets: [28] },
                            { visible: false, targets: [29] },
                            { visible: false, targets: [30] },
                            { visible: false, targets: [31] },
                            { visible: false, targets: [32] },
                            { visible: false, targets: [33] },
                            { visible: false, targets: [34] },
                            { visible: false, targets: [35] },
                            { visible: false, targets: [36] },
                            { visible: false, targets: [37] },
                            { visible: false, targets: [38] },
                            { visible: false, targets: [39] },
                            { visible: false, targets: [40] },
                            { visible: false, targets: [41] },
                            { visible: false, targets: [42] },
                            { visible: false, targets: [43] },
                            { visible: false, targets: [44] },
                            { visible: false, targets: [45] },
                            { visible: false, targets: [46] },
                        ],
                        displayLength: 20,
                        lengthChange: true,
                        lengthMenu: [20, 50, 75, 100, 300, 500],
                        buttons: [
                            // { extend: 'copy', className: 'btn btn-primary' },
                            // { extend: 'csv', className: 'btn btn-primary' },
                            { extend: 'excel', className: 'btn btn-success', text: 'Export Excell' },
                            { extend: 'pdf', className: 'btn btn-primary', text: 'Export PDF' },
                            // { extend: 'print', className: 'btn btn-primary' },
                            { extend: 'colvis', className: 'btn btn-dark', text: 'Filter Kolom' },
                        ]
                    });

                    // Set True / False Table
                    $("#table1").prop('hidden',true);
                    $("#table2").prop('hidden',false);
                    $('#btn-tabel-lengkap').find('i').removeClass('fa-sync fa-spin').addClass('fa-infinity');
                },
                error: function(res) {
                    iziToast.error({
                        title: 'Pesan Galat!',
                        message: 'Proses memuat Data Gagal!',
                        position: 'topRight'
                    });
                    $('#btn-tabel-lengkap').find('i').removeClass('fa-sync fa-spin').addClass('fa-infinity');
                }
            });
        }

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
                        let urlShow = `/kepegawaian/profilkaryawan/${item.id}`;
                        let content = `
                            <tr>
                                <td><center>${item.id}</center></td>
                                <td>${item.name}</td>
                                <td>${item.nama ? item.nama : '-'}</td>
                                <td>${new Date(item.deleted_at).toLocaleString("sv-SE")}</td>
                                <td>
                                    <center>
                                        <div class='btn-group'>
                                            <a href="${urlShow}" class='btn btn-sm btn-light-info'>
                                                <i class='fa-fw fas fa-file-archive nav-icon'></i> Lihat Profil
                                            </a>
                                            <a href='javascript:void(0);' class='btn btn-sm btn-light-success' onclick="showAktifKaryawan(${item.id})">
                                                <i class='fa-fw fas fa-user-check nav-icon'></i> Aktifkan
                                            </a>
                                        </div>
                                    </center>
                                </td>
                            </tr>
                        `;
                        $('#tampil-tbody-nonaktif').append(content);
                    });
                    var table = $('#dttable-nonaktif').DataTable({
                        order: [
                            [3, "desc"]
                        ],
                        displayLength: 7,
                        lengthChange: true,
                        lengthMenu: [7, 10, 25, 50, 75, 100],
                        buttons: ['copy', 'excel', 'pdf', 'colvis']
                    });

                    // Showing Tooltip
                    $('[data-bs-toggle="tooltip"]').tooltip({
                        trigger: 'hover'
                    })
                },
                error: function(res) {
                    iziToast.error({
                        title: 'Pesan Galat!',
                        message: 'Proses memuat Data Gagal!',
                        position: 'topRight'
                    });
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
                                    <td><center>` + item.id + `</center></td>
                                    <td>` + item.name + `</td>
                                    <td>` + new Date(item.created_at).toLocaleString("sv-SE") + `</td></tr>`;
                        $('#tampil-tbody-nonlengkap').append(content);
                    })
                    var table = $('#dttable-nonlengkap').DataTable({
                        order: [
                            [2, "desc"]
                        ],
                        bAutoWidth: false,
                        aoColumns : [
                            { sWidth: '15%' },
                            { sWidth: '60%' },
                            { sWidth: '25%' },
                        ],
                        displayLength: 7,
                        lengthChange: true,
                        lengthMenu: [7, 10, 25, 50, 75, 100],
                        buttons: ['copy', 'excel', 'pdf', 'colvis']
                    });

                    // Showing Tooltip
                    $('[data-bs-toggle="tooltip"]').tooltip({
                        trigger: 'hover'
                    })
                },
                error: function(res) {
                    iziToast.error({
                        title: 'Pesan Galat!',
                        message: 'Proses memuat Data Gagal!',
                        position: 'topRight'
                    });
                }
            })
        }

        function refreshNonAktif() {
            $("#tampil-tbody-nonaktif").empty().append(
                `<tr><td colspan="10" style="font-size:13px"><center><i class="fa fa-spinner fa-spin fa-fw"></i> Memproses data...</center></td></tr>`
            );
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
                                    <td><center>` + item.id + `</center></td>
                                    <td>` + item.name + `</td>
                                    <td>` + item.nama + `</td>
                                    <td>` + new Date(item.deleted_at).toLocaleString("sv-SE") +
                            `</td>
                                    <td><center><a href='javascript:void(0);' class='btn btn-sm btn-link-primary' onclick="showAktifKaryawan(` +
                            item.id + `)"><i class='fa-fw fas fa-user-check nav-icon'></i> Aktifkan</a></center></td>
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

                    // Showing Tooltip
                    $('[data-bs-toggle="tooltip"]').tooltip({
                        trigger: 'hover'
                    })
                },
                error: function(res) {
                    iziToast.error({
                        title: 'Pesan Galat!',
                        message: 'Proses memuat Data Gagal!',
                        position: 'topRight'
                    });
                }
            })
        }

        function refreshNonLengkap() {
            $("#tampil-tbody-nonlengkap").empty().append(
                `<tr><td colspan="10" style="font-size:13px"><center><i class="fa fa-spinner fa-spin fa-fw"></i> Memproses data...</center></td></tr>`
            );
            $.ajax({
                url: "/api/profilkaryawan/nonlengkap",
                type: 'GET',
                dataType: 'json', // added data type
                success: function(res) {
                    $("#tampil-tbody-nonlengkap").empty();
                    $('#dttable-nonlengkap').DataTable().clear().destroy();
                    res.show.forEach(item => {
                        content = `<tr>
                                    <td><center>` + item.id + `</center></td>
                                    <td>` + item.name + `</td>
                                    <td>` + new Date(item.created_at).toLocaleString("sv-SE") + `</td></tr>`;
                        $('#tampil-tbody-nonlengkap').append(content);
                    })
                    var table = $('#dttable-nonlengkap').DataTable({
                        order: [
                            [2, "desc"]
                        ],
                        bAutoWidth: false,
                        aoColumns : [
                            { sWidth: '15%' },
                            { sWidth: '60%' },
                            { sWidth: '25%' },
                        ],
                        displayLength: 7,
                        lengthChange: true,
                        lengthMenu: [7, 10, 25, 50, 75, 100],
                        buttons: ['copy', 'excel', 'pdf', 'colvis']
                    });

                    // Showing Tooltip
                    $('[data-bs-toggle="tooltip"]').tooltip({
                        trigger: 'hover'
                    })
                },
                error: function(res) {
                    iziToast.error({
                        title: 'Pesan Galat!',
                        message: 'Proses memuat Data Gagal!',
                        position: 'topRight'
                    });
                }
            })
        }

        function showAktifKaryawan(id) {
            $("#id_aktif_karyawan").val(id);
            $("#show_id_aktif_karyawan").text(id);
            var inputs = document.getElementById('setujuaktifkaryawan');
            inputs.checked = false;
            $('#nonaktif').modal('hide');
            $('#aktifKaryawan').modal('show');
        }

        function hideAktifKaryawan() {
            $('#nonaktif').modal('show');
            $('#aktifKaryawan').modal('hide');
        }

        function batalNonAktif() {
            // SWITCH BTN HAPUS
            var checkboxHapus = $('#setujuaktifkaryawan').is(":checked");
            if (checkboxHapus == false) {
                iziToast.error({
                    title: 'Pesan Galat!',
                    message: 'Mohon menyetujui untuk melakukan pengaktifan karyawan kembali',
                    position: 'topRight'
                });
            } else {
                // PROSES HAPUS
                var id = $("#id_aktif_karyawan").val();
                $.ajax({
                    url: "/api/profilkaryawan/{{ Auth::user()->id }}/setaktif/"+id,
                    type: 'GET',
                    dataType: 'json', // added data type
                    success: function(res) {
                        iziToast.success({
                            title: 'Sukses!',
                            message: 'User ID : '+id+' sukses di Aktifkan kembali pada '+ res,
                            position: 'topRight'
                        });
                        $('#aktifKaryawan').modal('hide');
                        refreshNonAktif();
                        refresh();
                        $('#nonaktif').modal('show');
                    },
                    error: function(res) {
                        iziToast.error({
                            title: 'Pesan Galat!',
                            message: 'Gagal mengaktifkan Pegawai!',
                            position: 'topRight'
                        });
                    }
                })
            }
        }

        // -----------------------   GRAFIK  ------------------------
        function loadGrafik(id, title) {
            $.ajax({
                url: "/api/profilkaryawan/grafik/" + id,
                type: "GET",
                dataType: "json",
                success: function(res) {
                    $('#show-card-grafik').prop('hidden', false);

                    var options = {
                        chart: {
                            type: "pie",
                            width: "100%",
                            // height: 700 // kasih tinggi fix, tapi tetap responsive
                        },
                        labels: res.labels,
                        series: res.series,
                        colors: ["#4680FF", "#FFB946", "#4BC0C0", "#FF6384", "#9966FF", "#212529", "#FF8BF2", "#3EFF73"],
                        legend: { show: true, position: 'bottom' },
                        dataLabels: {
                            enabled: true,
                            formatter: function (val, opts) {
                                return val.toFixed(1) + "%" // tampilkan persentase
                            },
                            dropShadow: {
                                enabled: false
                            }
                        },
                        responsive: [
                            {
                                breakpoint: 992, // tablet
                                options: {
                                    chart: { height: 400 },
                                    legend: { position: 'bottom' }
                                }
                            },
                            {
                                breakpoint: 575, // HP
                                options: {
                                    chart: { height: 250 },
                                    dataLabels: { enabled: false },
                                    legend: { show: true, position: 'bottom' }
                                }
                            }
                        ],
                        animations: {
                            enabled: true,
                            easing: 'easeinout',
                            speed: 800
                        },
                        plotOptions: {
                            pie: {
                                donut: {
                                    size: "65%",   // bikin donat, lebih enak dibaca
                                    labels: {
                                        show: true,
                                        total: {
                                            show: true,
                                            label: 'Total',
                                            fontSize: '16px',
                                            color: '#373d3f',
                                            formatter: function (w) {
                                                return w.globals.seriesTotals.reduce((a, b) => a + b, 0)
                                            }
                                        }
                                    }
                                }
                            }
                        },
                        stroke: {
                            show: true,
                            width: 1,
                            colors: ['#fff'] // kasih border biar potongan jelas
                        },
                    };

                    if (grafik) grafik.destroy();

                    $('#show-name-grafik').html(
                        `${title} ${res.belumMasuk != 0
                            ? '<b class="text-danger">(' + res.belumMasuk + ' pegawai belum diinput)</b>'
                            : '<b class="text-success">(Data Seluruh Pegawai)</b>'}`
                    );

                    grafik = new ApexCharts($("#grafik-show")[0], options);
                    grafik.render().then(() => {
                        // ambil warna setelah render
                        let chartColors = grafik.w.config.colors;

                        var total = res.series.reduce((a, b) => a + b, 0);
                        var listHTML = "";
                        res.labels.forEach(function(label, i) {
                            var jumlah = res.series[i];
                            var persen = total > 0 ? ((jumlah / total) * 100).toFixed(1) : 0;

                            listHTML += `
                                <li class="list-group-item">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div class="avtar avtar-s">
                                                <i class="ti ti-player-record f-40" style="color: ${chartColors[i]}"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <div class="row g-1">
                                                <div class="col-6">
                                                    <h6 class="text-dark mb-1">${label}</h6>
                                                    <a class="text-muted"><i>REFID # ${res.refid[i]}</i></a>
                                                </div>
                                                <div class="col-6 text-end">
                                                    <h6 class="mb-1"><b class="text-${jumlah==0?'dark':'danger'}">${jumlah}</b> Pegawai</h6>
                                                    <a class="text-success mb-0">${persen}%</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            `;
                        });

                        $("#list-grafik").html(listHTML);
                        // grafik.updateOptions({
                        //     chart: {
                        //         width: "100%",
                        //         height: "100%"
                        //     }
                        // });
                    });
                }
            });
        }

        function showGrafikJenisPegawai() { loadGrafik(1, "Berdasarkan Jenis Pegawai"); }
        function showGrafikJenisKelamin() { loadGrafik(2, "Berdasarkan Jenis Kelamin"); }
        function showGrafikPendidikan()   { loadGrafik(3, "Berdasarkan Pendidikan"); }
        function showGrafikProfesi()      { loadGrafik(4, "Berdasarkan Profesi"); }
        function showGrafikStatusPegawai(){ loadGrafik(5, "Berdasarkan Status Pegawai"); }
        function showGrafikStatusKawin()  { loadGrafik(6, "Berdasarkan Status Perkawinan"); }

        // function showGrafikJenisPegawai() {

        // }

        // function showGrafikJenisKelamin() {

        // }

        // function showGrafikPendidikan() {

        // }

        // function showGrafikProfesi() {

        // }

        // function showGrafikStatusPegawai() {
        //     $.ajax({
        //         url: "/api/profilkaryawan/grafik/5",
        //         type: 'GET',
        //         dataType: 'json', // added data type
        //         success: function(res) {
        //             $('#show-card-grafik').prop('hidden',false);
        //             var options = {
        //                 chart: {
        //                     type: "pie",
        //                     width: "100%",
        //                     height: "100%"
        //                 },
        //                 labels: res.labels, // dari API
        //                 series: res.series, // dari API
        //                 colors: ["#4680FF", "#FFB946", "#4BC0C0", "#FF6384", "#9966FF", "#212529", "#FF8BF2", "#3EFF73"],
        //                 fill: {
        //                     opacity: [1, .8, .6, .8, 1, .5]
        //                 },
        //                 legend: {
        //                     show: true,
        //                     position: 'bottom'
        //                 },
        //                 dataLabels: {
        //                     enabled: true
        //                 },
        //                 responsive: [{
        //                     breakpoint: 575,
        //                     options: {
        //                         chart: {
        //                             height: 250
        //                         },
        //                         dataLabels: {
        //                             enabled: false
        //                         }
        //                     }
        //                 }]
        //             };

        //             // Hapus grafik lama jika ada
        //             if (grafik) {
        //                 grafik.destroy();
        //             }

        //             $('#show-name-grafik').empty().html(`Berdasarkan Status Pegawai ${res.belumMasuk!=0?'<b class="text-danger">('+res.belumMasuk+' pegawai belum diinput)</b>':'<b class="text-success">(Data Seluruh Pegawai)</b>'}`)
        //             grafik = new ApexCharts($("#grafik-show")[0], options);
        //             grafik.render().then(() => {
        //                 grafik.updateOptions({
        //                     chart: {
        //                         width: "100%",
        //                         height: "100%"
        //                     }
        //                 });
        //             });

        //             // Ambil warna dari grafik
        //             let chartColors = grafik.w.config.colors;

        //             // === Generate list kiri ===
        //             var total = res.series.reduce((a, b) => a + b, 0);
        //             var listHTML = "";
        //             res.labels.forEach(function(label, i) {
        //                 var jumlah = res.series[i];
        //                 var persen = total > 0 ? ((jumlah / total) * 100).toFixed(1) : 0;

        //                 listHTML += `
        //                     <li class="list-group-item">
        //                         <div class="d-flex align-items-center">
        //                             <div class="flex-shrink-0">
        //                                 <div class="avtar avtar-s"><i class="ti ti-player-record f-40" style="color: ${chartColors[i]}"></i></div>
        //                             </div>
        //                             <div class="flex-grow-1 ms-3">
        //                                 <div class="row g-1">
        //                                     <div class="col-6">
        //                                         <h6 class="text-dark mb-1">${label}</h6>
        //                                         <a class="text-muted"><i>REFID # ${res.refid[i]}</i></a>
        //                                     </div>
        //                                     <div class="col-6 text-end">
        //                                         <h6 class="mb-1"><b class="text-${jumlah==0?'dark':'danger'}">${jumlah}</b> Pegawai</h6>
        //                                         <a class="text-success mb-0">${persen}%</a>
        //                                     </div>
        //                                 </div>
        //                             </div>
        //                         </div>
        //                     </li>
        //                 `;
        //             });

        //             // render ke UL
        //             $("#list-grafik").html(listHTML);
        //         }
        //     })
        // }

        // function showGrafikStatusKawin() {

        // }
    </script>
@endsection
