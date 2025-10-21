@extends('layouts.default')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Akreditasi MFK - Kecelakaan Kerja</h4>
            </div>
        </div>
    </div>

    <div class="card card-body table-responsive" style="overflow: visible;">
        <h4 classs="card-title">
            <div class="btn-group">
                <button class="btn btn-primary" onclick="window.location='{{ route('accidentreport.tambah') }}'"><i
                        class="fas fa-feather-alt"></i>&nbsp;&nbsp;Tambah Data</button>
                <button type="button" class="btn btn-warning" data-bs-toggle="tooltip" data-bs-offset="0,4"
                    data-bs-placement="bottom" data-bs-html="true"
                    title="Segarkan Tabel" onclick="refresh()" id="btn-refresh">
                    <i class="fa-fw fas fa-sync nav-icon"></i></button>
                <button type="button" class="btn btn-info" data-bs-toggle="tooltip" data-bs-offset="0,4"
                    data-bs-placement="bottom" data-bs-html="true"
                    title="Tampilkan Semua Data" onclick="showAll()" id="btn-show-all">
                    <i class="fa-fw fas fa-infinity nav-icon"></i></button>
            </div>
        </h4>
        <hr>
        <table id="dttable" class="table dt-responsive table-hover w-100 align-middle">
            <thead>
                <tr>
                    <th><center>AKSI</center></th>
                    <th>KORBAN</th>
                    <th>UNIT</th>
                    <th>LOKASI</th>
                    <th>TGL</th>
                </tr>
            </thead>
            <tbody id="tampil-tbody">
                <tr>
                    <td colspan="10"><center><i class="fa fa-spinner fa-spin fa-fw"></i> Memproses data...</center></td>
                </tr>
            </tbody>
            <tfoot class="bg-whitesmoke">
                <tr>
                    <th><center>AKSI</center></th>
                    <th>KORBAN</th>
                    <th>UNIT</th>
                    <th>LOKASI</th>
                    <th>TGL</th>
                </tr>
            </tfoot>
        </table>
        <table id="dttable2" class="table dt-responsive table-hover w-100 align-middle" hidden>
            <thead>
                <tr>
                    <th><center>ID</center></th>
                    <th>KORBAN</th>
                    <th>UNIT</th>
                    <th>LOKASI</th>
                    <th>TGL</th>
                    <th>JENIS KECELAKAAN</th>
                    <th>KRONOLOGI KECELAKAAN</th>
                    <th>KERUGIAN PADA MANUSIA</th>
                    <th>TANGGAL LAHIR / USIA</th>
                    <th>JENIS KELAMIN</th>
                    <th>ANGGOTA TUBUH CEDERA</th>
                    <th>PENANGANAN</th>
                    <th>KERUGIAN ASET</th>
                    <th>KERUGIAN LINGKUNGAN</th>
                    <th>1. TINDAKAN TIDAK AMAN</th>
                    <th>1. KONDISI TIDAK AMAN</th>
                    <th>2. FAKTOR PERSONAL</th>
                    <th>2. FAKTOR PEKERJAAN</th>
                    <th>3. PERALATAN KERJA</th>
                    <th>3. BENDA BERGERAK</th>
                    <th>3. MESIN</th>
                    <th>3. BEJANA TEKAN</th>
                    <th>3. MATERIAL</th>
                    <th>3. ALAT LISTRIK</th>
                    <th>3. ALAT BERAT</th>
                    <th>3. RADIASI</th>
                    <th>3. KENDARAAN</th>
                    <th>3. BINATANG</th>
                    <th>3. LAIN-LAIN</th>
                    <th>RENCANA TINDAKAN</th>
                    <th>TARGET WAKTU</th>
                    <th>WEWENANG</th>
                    <th>TERAKHIR DIUPDATE</th>
                </tr>
            </thead>
            <tbody id="tampil-tbody2">
                <tr>
                    <td colspan="40"><center><i class="fa fa-spinner fa-spin fa-fw"></i> Memproses data...</center></td>
                </tr>
            </tbody>
            <tfoot class="bg-whitesmoke">
                <tr>
                    <th><center>ID</center></th>
                    <th>KORBAN</th>
                    <th>UNIT</th>
                    <th>LOKASI</th>
                    <th>TGL</th>
                    <th>JENIS KECELAKAAN</th>
                    <th>KRONOLOGI KECELAKAAN</th>
                    <th>KERUGIAN PADA MANUSIA</th>
                    <th>TANGGAL LAHIR / USIA</th>
                    <th>JENIS KELAMIN</th>
                    <th>ANGGOTA TUBUH CEDERA</th>
                    <th>PENANGANAN</th>
                    <th>KERUGIAN ASET</th>
                    <th>KERUGIAN LINGKUNGAN</th>
                    <th>1. TINDAKAN TIDAK AMAN</th>
                    <th>1. KONDISI TIDAK AMAN</th>
                    <th>2. FAKTOR PERSONAL</th>
                    <th>2. FAKTOR PEKERJAAN</th>
                    <th>3. PERALATAN KERJA</th>
                    <th>3. BENDA BERGERAK</th>
                    <th>3. MESIN</th>
                    <th>3. BEJANA TEKAN</th>
                    <th>3. MATERIAL</th>
                    <th>3. ALAT LISTRIK</th>
                    <th>3. ALAT BERAT</th>
                    <th>3. RADIASI</th>
                    <th>3. KENDARAAN</th>
                    <th>3. BINATANG</th>
                    <th>3. LAIN-LAIN</th>
                    <th>RENCANA TINDAKAN</th>
                    <th>TARGET WAKTU</th>
                    <th>WEWENANG</th>
                    <th>TERAKHIR DIUPDATE</th>
                </tr>
            </tfoot>
        </table>
    </div>

    {{-- MODAL START --}}
    <div class="modal fade animate__animated animate__jackInTheBox fade" id="tampil" aria-hidden="true"
        aria-labelledby="modalToggleLabel2" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Kecelakaan Kerja</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ini isinya
                </div>
            </div>
        </div>
    </div>
    {{-- MODAL END --}}

    <script>
        $(document).ready(function() {

            // AJAX TABLE GET
            $.ajax({
                url: "/api/mfk/kecelakaankerja/data",
                type: 'GET',
                dataType: 'json', // added data type
                success: function(res) {
                    $("#tampil-tbody").empty();
                    res.show.forEach(item => {
                        // var updet = item.updated_at.substring(0, 10);
                        content = `<tr id='data"+ item.id +"'>`;
                        content +=
                            `<td><center><div class='btn-group'><button type='button' class='btn btn-sm btn-primary btn-icon dropdown-toggle hide-arrow' data-bs-toggle='dropdown' aria-expanded='false' value="animate__rubberBand"><i class='bx bx-dots-vertical-rounded'></i></button><ul class='dropdown-menu dropdown-menu-right'>` +
                            `<li><a href='/mfk/kecelakaankerja/ubah/`+item.id+`' class='dropdown-item text-warning'><i class='bx bx-edit scaleX-n1-rtl'></i> Ubah</a></li>` +
                            `<li><a href='javascript:void(0);' class='dropdown-item text-danger' onclick="hapus(` +
                            item.id +
                            `)"><i class='bx bx-trash scaleX-n1-rtl'></i> Hapus</a></li>` +
                            `</ul></center></td><td>`;
                        if (item.korban != null) {
                            res.user.forEach(key => {
                                if (item.korban == key.id) {
                                    content += key.nama;
                                }
                            })
                        } else {
                            content += item.korban_luar;
                        }
                        content += "</td><td>" + item.role + "</td><td>" + item.lokasi + "</td><td>" + item.tgl + "</td>";
                        content += `</tr>`;
                        $('#tampil-tbody').append(content);
                    });
                    var table = $('#dttable').DataTable({
                        order: [
                            [4, "desc"]
                        ],
                        bAutoWidth: false,
                        aoColumns : [
                            { sWidth: '8%' },
                            { sWidth: '32%' },
                            { sWidth: '25%' },
                            { sWidth: '20%' },
                            { sWidth: '15%' },
                        ],
                        displayLength: 7,
                        lengthChange: true,
                        lengthMenu: [7, 10, 25, 50, 75, 100],
                        buttons: ['excel', 'pdf']
                    });

                    table.buttons().container()
                        .appendTo('#dttable_wrapper .col-md-6:eq(0)');

                    // SELECT PICKER
                    var t = $(".select2");
                    t.length && t.each(function() {
                        var e = $(this);
                        e.wrap('<div class="position-relative"></div>').select2({
                            placeholder: "Pilih",
                            dropdownParent: e.parent()
                        })
                    })

                }
            });

        })

        function refresh() {
            $("#btn-refresh").find("i").toggleClass("fa-sync fa-spinner fa-spin");
            $("#tampil-tbody2").empty();
            $('#dttable2').DataTable().clear().destroy();
            $("#dttable2").prop('hidden',true);
            $("#dttable").prop('hidden',false);
            $("#tampil-tbody").empty().append(
                `<tr><td colspan="40"><center><i class="fa fa-spinner fa-spin fa-fw"></i> Memproses data...</center></td></tr>`
            );

            // AJAX TABLE GET
            $.ajax({
                url: "/api/mfk/kecelakaankerja/data",
                type: 'GET',
                dataType: 'json', // added data type
                success: function(res) {
                    $("#tampil-tbody").empty();
                    $('#dttable').DataTable().clear().destroy();
                    res.show.forEach(item => {
                        // var updet = item.updated_at.substring(0, 10);
                        content = `<tr id='data"+ item.id +"'>`;
                        content +=
                            `<td><center><div class='btn-group'><button type='button' class='btn btn-sm btn-primary btn-icon dropdown-toggle hide-arrow' data-bs-toggle='dropdown' aria-expanded='false' value="animate__rubberBand"><i class='bx bx-dots-vertical-rounded'></i></button><ul class='dropdown-menu dropdown-menu-right'>` +
                            `<li><a href='/mfk/kecelakaankerja/ubah/`+item.id+`' class='dropdown-item text-warning'><i class='bx bx-edit scaleX-n1-rtl'></i> Ubah</a></li>` +
                            `<li><a href='javascript:void(0);' class='dropdown-item text-danger' onclick="hapus(` +
                            item.id +
                            `)"><i class='bx bx-trash scaleX-n1-rtl'></i> Hapus</a></li>` +
                            `</ul></center></td><td>`;
                        if (item.korban != null) {
                            res.user.forEach(key => {
                                if (item.korban == key.id) {
                                    content += key.nama;
                                }
                            })
                        } else {
                            content += item.korban_luar;
                        }
                        content += "</td><td>" + item.role + "</td><td>" + item.lokasi + "</td><td>" + item.tgl + "</td>";
                        content += `</tr>`;
                        $('#tampil-tbody').append(content);
                    });
                    var table = $('#dttable').DataTable({
                        order: [
                            [4, "desc"]
                        ],
                        bAutoWidth: false,
                        aoColumns : [
                            { sWidth: '8%' },
                            { sWidth: '32%' },
                            { sWidth: '25%' },
                            { sWidth: '20%' },
                            { sWidth: '15%' },
                        ],
                        displayLength: 7,
                        lengthChange: true,
                        lengthMenu: [7, 10, 25, 50, 75, 100],
                        buttons: ['excel', 'pdf']
                    });

                    table.buttons().container()
                        .appendTo('#dttable_wrapper .col-md-6:eq(0)');

                    // SELECT PICKER
                    var t = $(".select2");
                    t.length && t.each(function() {
                        var e = $(this);
                        e.wrap('<div class="position-relative"></div>').select2({
                            placeholder: "Pilih",
                            dropdownParent: e.parent()
                        })
                    })

                    iziToast.success({
                        title: 'Pesan Refresh!',
                        message: 'Berhasil menampilkan semua data dengan kolom terbatas',
                        position: 'topRight'
                    });

                }
            });
            $("#btn-refresh").find("i").toggleClass("fa-spinner fa-spin fa-sync");
        }
        function showAll() {
            $("#btn-show-all").find("i").toggleClass("fa-infinity fa-spinner fa-spin");
            $("#tampil-tbody").empty();
            $('#dttable').DataTable().clear().destroy();
            $("#tampil-tbody2").empty().append(
                `<tr><td colspan="40"><center><i class="fa fa-spinner fa-spin fa-fw"></i> Memproses data...</center></td></tr>`
            );

            // AJAX TABLE GET
            $.ajax({
                url: "/api/mfk/kecelakaankerja/data",
                type: 'GET',
                dataType: 'json', // added data type
                success: function(res) {
                    $("#tampil-tbody2").empty();
                    $('#dttable2').DataTable().clear().destroy();
                    res.show.forEach(item => {
                        // var updet = item.updated_at.substring(0, 10);
                        content = `<tr id='data`+item.id+`'>`;
                        content += `<td><center>`+item.id+`</center></td><td>`;
                        if (item.korban != null) {
                            res.user.forEach(key => {
                                if (item.korban == key.id) {
                                    content += key.nama;
                                }
                            })
                        } else {
                            content += item.korban_luar;
                        }
                        content += "</td><td>" + item.role + "</td><td>" + item.lokasi + "</td><td>" + item.tgl + "</td>";
                        // GET JENIS KECELAKAAN
                        var jenis = null;
                        if (item.jenis == 1) { jenis = 'Menabrak'; }
                        if (item.jenis == 2) { jenis = 'Tertabrak'; }
                        if (item.jenis == 3) { jenis = 'Terperangkap'; }
                        if (item.jenis == 4) { jenis = 'Terbentur / Terpukul'; }
                        if (item.jenis == 5) { jenis = 'Tergelincir'; }
                        if (item.jenis == 6) { jenis = 'Terjepit'; }
                        if (item.jenis == 7) { jenis = 'Tersangkut'; }
                        if (item.jenis == 8) { jenis = 'Tertimbun'; }
                        if (item.jenis == 9) { jenis = 'Terhirup'; }
                        if (item.jenis == 10) { jenis = 'Tenggelam'; }
                        if (item.jenis == 11) { jenis = 'Jatuh dari ketinggian yang sama'; }
                        if (item.jenis == 12) { jenis = 'Jatuh dari ketinggian yang berbeda'; }
                        if (item.jenis == 13) { jenis = 'Kontak dengan (Arus Listrik, Suhu Panas, Suhu Dingin, Terpapar Radiasi, Bahan Kimia Berbahaya)'; }
                        if (item.jenis == 14) { jenis = item.lain1; }
                        content += `<td>${jenis != null? jenis:'-'}</td>`;
                        content += `<td>`+ item.kronologi +`</td>`;
                        // GET KERUGIAN MANUSIA
                        var kerugian = null;
                        if (item.kerugian == 1) {
                            kerugian = 'Tak Cedera';
                        }
                        if (item.kerugian == 2) {
                            kerugian = 'Cedera Ringan';
                        }
                        if (item.kerugian == 3) {
                            kerugian = 'Cedera Sedang';
                        }
                        if (item.kerugian == 4) {
                            kerugian = 'Cedera Berat';
                        }
                        if (item.kerugian == 5) {
                            kerugian = 'Meninggal/Fatal';
                        }
                        content += `<td>${kerugian != null? kerugian:'-'}</td>`;
                        content += `<td>`+ item.lahir +` / `+ item.usia +`</td>`;
                        content += `<td>`+ item.jk +`</td>`;
                        content += `<td>`+ item.cedera +`</td>`;
                        content += `<td>`+ item.penanganan +`</td>`;
                        content += `<td>`+ item.k_aset +`</td>`;
                        content += `<td>`+ item.k_lingkungan +`</td>`;
                        content += `<td>`+ item.tta +`</td>`;
                        content += `<td>`+ item.kta +`</td>`;
                        content += `<td>`+ item.f_personal +`</td>`;
                        content += `<td>`+ item.f_pekerjan +`</td>`;
                        content += `<td>`+ item.p_kerja +`</td>`;
                        content += `<td>`+ item.mesin +`</td>`;
                        content += `<td>`+ item.material +`</td>`;
                        content += `<td>`+ item.alat_berat +`</td>`;
                        content += `<td>`+ item.kendaraan +`</td>`;
                        content += `<td>`+ item.benda_bergerak +`</td>`;
                        content += `<td>`+ item.bejana_tekan +`</td>`;
                        content += `<td>`+ item.alat_listrik +`</td>`;
                        content += `<td>`+ item.radiasi +`</td>`;
                        content += `<td>`+ item.binatang +`</td>`;
                        content += `<td>`+ item.lain2 +`</td>`;
                        content += `<td>`+ item.r_tindakan +`</td>`;
                        content += `<td>`+ item.t_waktu +`</td>`;
                        content += `<td>`+ item.wewenang +`</td>`;
                        content += `<td>`+ item.updated_at +`</td>`;
                        content += `</tr>`;
                        $('#tampil-tbody2').append(content);
                    });
                    var table = $('#dttable2').DataTable({
                        order: [
                            [4, "desc"]
                        ],
                        // bAutoWidth: false,
                        // aoColumns : [
                        //     { sWidth: '8%' },
                        //     { sWidth: '32%' },
                        //     { sWidth: '25%' },
                        //     { sWidth: '20%' },
                        //     { sWidth: '15%' },
                        // ],
                        columnDefs: [
                            { visible: false, targets: [5] },
                            { visible: false, targets: [6] },
                            { visible: false, targets: [7] },
                            { visible: false, targets: [8] },
                            { visible: false, targets: [9] },
                            { visible: false, targets: [10] },
                            { visible: false, targets: [11] },
                            { visible: false, targets: [12] },
                            { visible: false, targets: [13] },
                            { visible: false, targets: [14] },
                            { visible: false, targets: [15] },
                            { visible: false, targets: [16] },
                            { visible: false, targets: [17] },
                            { visible: false, targets: [18] },
                            { visible: false, targets: [19] },
                            { visible: false, targets: [20] },
                            { visible: false, targets: [21] },
                            { visible: false, targets: [22] },
                            { visible: false, targets: [23] },
                            { visible: false, targets: [24] },
                            { visible: false, targets: [25] },
                            { visible: false, targets: [26] },
                            { visible: false, targets: [27] },
                            { visible: false, targets: [28] },
                            { visible: false, targets: [29] },
                            { visible: false, targets: [30] },
                            { visible: false, targets: [31] },
                        ],
                        displayLength: 7,
                        lengthChange: true,
                        lengthMenu: [7, 10, 25, 50, 75, 100],
                        buttons: ['excel', 'colvis']
                    });

                    table.buttons().container()
                        .appendTo('#dttable2_wrapper .col-md-6:eq(0)');

                    iziToast.warning({
                        title: 'Pesan Tambahan!',
                        message: 'Tombol Column Visibility untuk menampilkan kolom terpilih pada tabel',
                        position: 'topRight'
                    });
                    iziToast.success({
                        title: 'Pesan Sukses!',
                        message: 'Silakan klik tombol Excel untuk mengekspor semua data ke Excel',
                        position: 'topRight'
                    });
                    $("#dttable").prop('hidden',true);
                    $("#dttable2").prop('hidden',false);
                }
            });
            $("#btn-show-all").find("i").toggleClass("fa-spinner fa-spin fa-infinity");
        }

        function hapus(id) {
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: 'Ingin menghapus Laporan ID : ' + id,
                icon: 'warning',
                reverseButtons: false,
                showDenyButton: false,
                showCloseButton: false,
                showCancelButton: true,
                focusCancel: true,
                confirmButtonColor: '#FF4845',
                confirmButtonText: `<i class="fa fa-trash me-1" style="font-size:13px"></i> Hapus`,
                cancelButtonText: `<i class="fa fa-times me-1" style="font-size:13px"></i> Batal`,
                backdrop: `rgba(26,27,41,0.8)`,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "/api/mfk/kecelakaankerja/" + id + "/hapus",
                        type: 'GET',
                        dataType: 'json', // added data type
                        success: function(res) {
                            iziToast.success({
                                title: 'Pesan Sukses!',
                                message: 'Laporan telah berhasil dihapus',
                                position: 'topRight'
                            });
                            // fresh();
                            window.location.reload();
                        },
                        error: function(res) {
                            iziToast.error({
                                title: 'Pesan Galat!',
                                message: 'Laporan gagal dihapus',
                                position: 'topRight'
                            });
                        }
                    });
                }
            })
        }
    </script>
@endsection
