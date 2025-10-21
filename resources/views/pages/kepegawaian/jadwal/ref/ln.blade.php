@extends('layouts.index')

@section('content')

    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i></a></li>
                        <li class="breadcrumb-item">Kepegawaian</li>
                        <li class="breadcrumb-item"><a href="{{ route('kepegawaian.jadwaldinas.index') }}">Jadwal Dinas</a></li>
                        <li class="breadcrumb-item" aria-current="page">Daftar Libur Nasional</li>
                    </ul>
                </div>
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h2 class="mb-0">Daftar Libur Nasional</h2>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- [ breadcrumb ] end -->

    <!-- [ Main Content ] start -->
    <div class="row pt-1">
        <div class="card table-card">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <h5 class="mb-0 card-title flex-grow-1">
                        <div class="btn-group">
                            <a class="btn btn-outline-secondary" href="{{ route('kepegawaian.jadwaldinas.index') }}" data-bs-toggle="tooltip"
                            data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true"
                            title="Kembali"><i class="fas fa-angle-left me-1"></i> Kembali</a>
                            <button class="btn btn-primary" onclick="tambah()" data-bs-toggle="tooltip"
                            data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true"
                            title="Form Tambah" id="btn-tambah"><i class='ti ti-calendar-plus me-1'></i> Tambah</button>
                        </div>
                    </h5>
                    <div class="flex-shrink-0">
                        <button class="btn btn-link-warning" onclick="refresh()" data-bs-toggle="tooltip"
                        data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true"
                        title="Segarkan Tabel"><i class="fas fa-sync me-1"></i> Segarkan</button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                {{-- <div class="alert alert-light mb-3 mt-2">
                    <h5>Hal-hal yang perlu <b class="text-danger">diperhatikan</b></h5>
                    <small>
                        <i class="ti ti-arrow-narrow-right me-1"></i> Pastikan Data Shift ditambahkan oleh Admin Jadwal (<mark>Setiap Unit/Bagian hanya 1 orang perwakilan</mark>), berkaitan dengan kelengkapan data saat pembuatan Jadwal Dinas <br>
                        <i class="ti ti-arrow-narrow-right me-1"></i> Akses <b>Tambah</b> hanya bisa dilakukan apabila Data Shift Karyawan yang bersangkutan belum didaftarkan/tergabung pada <mark>UNIT</mark> manapun (Belum pernah ditambahkan oleh siapapun) <br>
                        <i class="ti ti-arrow-narrow-right me-1"></i> Akses <b>Ubah</b> maupun <b>Hapus</b> Data Referensi Shift hanya dapat dilakukan oleh Admin Jadwal (User Admin Ref.Shift) <br>
                        <i class="ti ti-arrow-narrow-right me-1"></i> Penambahan Data Shift hanya dilakukan sekali saja dan dapat digunakan untuk seterusnya, terkecuali apabila terdapat perubahan Data Shift <br>
                        <i class="ti ti-arrow-narrow-right me-1"></i> Perlu diperhatikan bahwa penghapusan Data Shift tidak akan menghapus Data Jadwal Dinas yang sudah/pernah diajukan sebelumnya, mohon lakukan dengan hati-hati
                    </small>
                </div> --}}
                <div class="table-responsive text-nowrap" style="border: 0px">
                    <table id="dttable" class="table dt-responsive table-hover nowrap w-100">
                        <thead>
                            <tr>
                                <th class="cell-fit">Aksi</th>
                                <th class="cell-fit">Tanggal</th>
                                <th class="cell-fit">Deskripsi</th>
                                <th class="cell-fit">Keterangan</th>
                                <th class="cell-fit">Diperbarui</th>
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
                                <th class="cell-fit">Aksi</th>
                                <th class="cell-fit">Tanggal</th>
                                <th class="cell-fit">Deskripsi</th>
                                <th class="cell-fit">Keterangan</th>
                                <th class="cell-fit">Diperbarui</th>
                            </tr>
                        </tfoot>
                    </table>
                    <!-- end table -->
                </div>
                <!-- end table responsive -->
            </div>
        </div>
    </div>

    <!-- MODAL TAMBAH -->
    <div class="modal fade" tabindex="-1" id="modalTambah" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="orderdetailsModalLabel">Tambah <b class="text-primary">Hari Libur Nasional</b></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <div class="form-group">
                                <label class="form-label">Tanggal <a class="text-danger">*</a></label>
                                <input type="date" id="tgl_add" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-9 mb-3">
                            <div class="form-group">
                                <label class="form-label">Nama <mark>Hari Libur Nasional</mark> <a class="text-danger">*</a></label>
                                <input type="text" id="deskripsi_add" class="form-control" placeholder="e.g. Maulid Nabi Muhammad SAW / etc">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Keterangan (<b class="text-warning">OPTIONAL</b>)</label>
                                <textarea rows="2" class="form-control" id="keterangan_add" placeholder="Optional"></textarea>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i
                            class="fa fa-times me-1"></i> Batal</button>
                    <button class="btn btn-info" onclick="simpan()" data-bs-toggle="tooltip"
                        data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true"
                        title="Simpan Data"><i
                            class="fas fa-save me-1"></i> Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL UBAH -->
    {{-- <div class="modal fade" tabindex="-1" id="modalUbah" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="orderdetailsModalLabel">Ubah Shift</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="text" id="id_edit" hidden>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="alert alert-secondary">
                                    <small>
                                        <h6><center>Mohon Diperhatikan <b class="text-danger">Panduan Di Bawah</b> Sebelum Melakukan Pengisian!</center></h6>
                                        <i class="fas fa-caret-right text-primary me-1"></i> Perhatikan penulisan Nama Singkat Shift karena kata tersebut akan menjadi pilihan dalam penentuan Jadwal Dinas<br>
                                        <i class="fas fa-caret-right text-primary me-1"></i> Penambahan Jam Berangkat dan Jam Pulang harus sesuai dengan kebijakan yang ada, tidak diperbolehkan membuat jam shift sendiri / <i>OnRequest</i> (Diluar Jam Shift Berangkat & Pulang yang sudah ada) tanpa persetujuan bagian SDI<br>
                                        <i class="fas fa-caret-right text-primary me-1"></i> Penulisan Nama Singkat Shift hanya diperbolehkan <kbd>2 HURUF</kbd><br>
                                        <i class="fas fa-caret-right text-primary me-1"></i> Shift yang akan diubah tidak boleh sama dengan yang sudah ada<br>
                                        <i class="fas fa-caret-right text-primary me-1"></i> Tidak diperbolehkan menambahkan Shift dengan selisih kurang dari 4 Jam, e.g (00:00 - 00:00)<br>
                                        <i class="fas fa-caret-right text-primary me-1"></i> Format Waktu/Jam Shift = <u><b>JAM (24 Jam) : MENIT</b></u><br>
                                        <i class="fas fa-caret-right text-primary me-1"></i> Terkait <kbd>Toleransi Kehadiran (10 Menit)</kbd> sudah otomatis dari sistem<br>
                                        <i class="fas fa-caret-right text-primary me-1"></i> Waktu/Jam Shift Berangkat dan Pulang tidak boleh sama<br>
                                        <i class="fas fa-caret-right text-primary me-1 mb-3"></i> Contoh memasukkan Jam Berangkat & Pulang (Khusus Lewat HARI)<br>
                                        <h6><span class="border border-dark border-top-2">&nbsp;Berangkat <i class="fas fa-long-arrow-alt-right text-danger"></i> Pulang&nbsp;</span>
                                        <i class="fas fa-grip-lines me-1">
                                        </i><span class="border border-dark border-top-2">&nbsp;21:00 <i class="fas fa-long-arrow-alt-right text-danger"></i> 05:00&nbsp;</span></h6>
                                    </small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="form-group">
                                <label class="form-label">Nama <mark>Singkat</mark> Shift <a class="text-danger">*</a></label>
                                <input type="text" id="singkat_edit" class="form-control inputTgl" onkeyup="checkShift($(this))" placeholder="e.g. P / PS / P6 / etc">
                            </div>
                        </div>
                        <div class="col-md-9 mb-3">
                            <div class="form-group">
                                <label class="form-label">Nama <mark>Lengkap</mark> Shift <a class="text-danger">*</a></label>
                                <input type="text" id="shift_edit" class="form-control" placeholder="e.g. PAGI / PAGI SIANG / PAGI JAM 6 / etc">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label class="form-label">Jam Berangkat / <b>Masuk</b> <a class="text-danger">*</a></label>
                                <input type="text" id="berangkat_edit" class="form-control pilihJam" data-provide="timepicker" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="Waktu/Jam Masuk Kerja" placeholder="Format Waktu H:i">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label class="form-label">Jam Pulang / <b>Keluar</b> <a class="text-danger">*</a></label>
                                <input type="text" id="pulang_edit" class="form-control pilihJam" data-provide="timepicker" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="Waktu/Jam Pulang Kerja" placeholder="Format Waktu H:i">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Keterangan</label>
                                <textarea rows="2" class="form-control" id="ket_edit" placeholder="Optional"></textarea>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" id="btn-ubah" onclick="prosesUbah()"><i class="fa-fw fas fa-edit nav-icon"></i> Ubah</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fa-fw fas fa-times nav-icon"></i> Tutup</button>
                </div>
            </div>
        </div>
    </div> --}}

    {{-- MODAL HAPUS --}}
    <div class="modal animate__animated animate__rubberBand fade" id="hapus" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-simple modal-add-new-address modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        Form Hapus&nbsp;&nbsp;&nbsp;
                    </h4>
                </div>
                <div class="modal-body">
                    <input type="text" id="id_hapus" hidden>
                    <p style="text-align: justify;">Anda akan menghapus Hari Libur Nasional tersebut, lakukanlah dengan hati-hati. Ceklis dibawah untuk melanjutkan penghapusan.</p>
                    <label class="switch">
                        <input type="checkbox" class="switch-input" id="setujuhapus">
                        <span class="switch-toggle-slider">
                        <span class="switch-on"></span>
                        <span class="switch-off"></span>
                        </span>
                        <span class="switch-label">Anda siap menerima Risiko</span>
                    </label>
                </div>
                <div class="col-12 text-center mb-4">
                    <button type="submit" id="btn-hapus" class="btn btn-danger me-sm-3 me-1" onclick="prosesHapus()"><i class="fa fa-trash me-1" style="font-size:13px"></i> Hapus</button>
                    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-times me-1" style="font-size:13px"></i> Batal</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            refresh();
        })

        // FUNCTION AREA
        function refresh() {
            $('.modal').modal('hide');
            $("#tampil-tbody").empty().append(
                `<tr style='font-size:13px'><td colspan="9"><center><i class="fa fa-spinner fa-spin fa-fw"></i> Memproses data...</center></td></tr>`
            );
            $.ajax({
                url: "/api/kepegawaian/jadwaldinas/ln/table",
                type: 'GET',
                dataType: 'json', // added data type
                success: function(res) {
                    $("#tampil-tbody").empty();
                    $('#dttable').DataTable().clear().destroy();
                    res.show.forEach(item => {
                        $("#tampil-tbody").append(
                            `<tr style='font-size:13px' id='tr_`+item.id+`'>
                                <td class="cell-fit">
                                    <div class="btn-group rounded">
                                        <button class="btn btn-light-info" onclick="ubah(`+item.id+`)" data-bs-toggle="tooltip"
                                        data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true"
                                        title="Ubah Data"><i class="fas fa-edit"></i></button>
                                        <button class="btn btn-light-danger" onclick="hapus(`+item.id+`)" data-bs-toggle="tooltip"
                                        data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true"
                                        title="Hapus Data"><i class="fas fa-trash"></i></button>
                                    </div>
                                </td>
                                <td class="cell-fit">${formatTanggal(item.tahun,item.bulan,item.tgl)}</td>
                                <td style='white-space: normal !important; word-wrap: break-word;'>${item.deskripsi}</td>
                                <td>${item.keterangan?item.keterangan:'-'}</td>
                                <td class="cell-fit">` + new Date(item.updated_at).toLocaleString("sv-SE") + `</td>
                            </tr>`
                        );
                    });
                    var table = $('#dttable').DataTable({
                        order: [
                            [4, "asc"]
                        ],
                        bAutoWidth: false,
                        aoColumns : [
                            { sWidth: '5%' },
                            { sWidth: '10%' },
                            { sWidth: '35%' },
                            { sWidth: '30%' },
                            { sWidth: '20%' },
                        ],
                        displayLength: 20,
                        lengthChange: true,
                        lengthMenu: [20, 35, 50, 75, 100],
                    });

                    // Showing Tooltip
                    $('[data-bs-toggle="tooltip"]').tooltip({
                        trigger: 'hover'
                    })
                },
                error: function (res) {
                    iziToast.error({
                        title: 'Pesan Galat!',
                        message: 'Tidak ada data Libur Nasional ditemukan',
                        position: 'topRight'
                    });
                    $("#tampil-tbody").empty().append(
                        `<tr style='font-size:13px'><td colspan="9"><center>Tidak ada Data Libur Nasional</center></td></tr>`
                    );
                }
            })
        }

        function formatTanggal(tahun, bulan, tgl) {
            // padding supaya selalu 2 digit
            let mm = bulan.toString().padStart(2, "0");
            let dd = tgl.toString().padStart(2, "0");
            return `${tahun}-${mm}-${dd}`;
        }

        function tambah() {
            $("#tgl_add").val("");
            $("#deskripsi_add").val("");
            $("#keterangan_add").val("");
            $('#modalTambah').modal('show');
        }

        function simpan() {
            var tgl = $("#tgl_add").val();
            var deskripsi = $("#deskripsi_add").val();
            var keterangan = $("#keterangan_add").val();
            var pegawai = "{{ Auth::user()->id }}";

            if (tgl == "" || deskripsi == "") {
                iziToast.warning({
                    title: 'Pesan Ambigu!',
                    message: 'Pastikan Anda tidak mengosongi semua isian wajib',
                    position: 'topRight'
                });
            } else {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: 'POST',
                    url: '/api/kepegawaian/jadwaldinas/ln/tambah',
                    dataType: 'json',
                    data: {
                        tgl: tgl,
                        deskripsi: deskripsi,
                        keterangan: keterangan,
                        pegawai: pegawai,
                    },
                    success: function(res) {
                        if (res) {
                            if (res.status
                             == 200) {
                                $('#modalTambah').modal('hide');
                                iziToast.success({
                                    title: 'Sukses!',
                                    message: 'Tambah Libur Nasional berhasil pada '+ res.message,
                                    position: 'topRight'
                                });
                                refresh();
                            } else {
                                iziToast.error({
                                    title: 'Pesan Galat!',
                                    message: res.message,
                                    position: 'topRight'
                                });
                            }
                        }
                    },
                    error: function (res) {
                        iziToast.error({
                            title: 'Pesan Galat!',
                            message: res.responseJSON.error,
                            position: 'topRight'
                        });
                    }
                });
            }
        }

        function ubah(id) {
            $("#id_edit").val("");
            $("#singkat_edit").val("");
            $("#shift_edit").val("");
            $("#berangkat_edit").val("");
            $("#pulang_edit").val("");
            $("#ket_edit").val("");
            $.ajax(
            {
                url: "/api/kepegawaian/jadwaldinas/shift/"+id,
                type: 'GET',
                dataType: 'json', // added data type
                success: function(res) {
                    $("#id_edit").val(res.show.id);
                    $("#singkat_edit").val(res.show.singkat);
                    $("#shift_edit").val(res.show.shift);
                    $("#berangkat_edit").val(res.show.berangkat.substring(0,5)).change();
                    $("#pulang_edit").val(res.show.pulang.substring(0,5)).change();
                    $("#ket_edit").val(res.show.ket);
                    $('#modalUbah').modal('show');
                }
            });
        }

        function prosesUbah() {
            $("#btn-ubah").prop('disabled', true);
            $("#btn-ubah").find("i").toggleClass("fa-save fa-sync fa-spin");

            var fd = new FormData();
            fd.append('id',$("#id_edit").val());
            fd.append('singkat',$("#singkat_edit").val());
            fd.append('shift',$("#shift_edit").val());
            fd.append('berangkat',$("#berangkat_edit").val());
            fd.append('pulang',$("#pulang_edit").val());
            fd.append('ket',$("#ket_edit").val());
            fd.append('pegawai',"{{ Auth::user()->id }}");

            if (fd.get('singkat') == "" || fd.get('shift') == "" || fd.get('berangkat') == "" || fd.get('pulang') == "") {
                iziToast.warning({
                    title: 'Pesan Ambigu!',
                    message: 'Pastikan Anda tidak mengosongi semua isian wajib',
                    position: 'topRight'
                });
            } else {
                if (fd.get('singkat') == "DL") {
                    iziToast.error({
                        title: 'Maaf!',
                        message: '[DL] Dinas Luar hanya dapat digunakan saat pengajuan saja, tidak dapat ditambahkan ke Referensi Jadwal Dinas secara Manual.',
                        position: 'topRight'
                    });
                    return;
                }
                if (fd.get('singkat') == "L" || fd.get('singkat') == "C" || fd.get('singkat') == "CT" || fd.get('singkat') == "CM" || fd.get('singkat') == "CD" || fd.get('singkat') == "CU" || fd.get('singkat') == "CH") {
                    iziToast.error({
                        title: 'Maaf!',
                        message: 'Referensi Shift ['+fd.get('singkat')+'] sudah ditambahkan oleh Sistem. Tidak diizinkan menambahkan manual.',
                        position: 'topRight'
                    });
                    return;
                }
                // AJAX request
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "/api/kepegawaian/jadwaldinas/shift/"+fd.get('id')+"/ubah",
                    method: 'post',
                    data: fd,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(res){
                        if (res) {
                            if (res.code == 200) {
                                iziToast.success({
                                    title: 'Pesan Sukses! ID : '+fd.get('id'),
                                    message: 'Shift berhasil diperbarui pada '+res.message,
                                    position: 'topRight'
                                });
                                $('#ubah').modal('hide');
                                refresh();
                            } else {
                                iziToast.error({
                                    title: 'Pesan Galat! ID : '+fd.get('id'),
                                    message: 'Shift gagal diperbarui. '+res.message,
                                    position: 'topRight'
                                });
                            }
                        }
                        $("#btn-ubah").find("i").removeClass("fa-sync fa-spin").addClass("fa-save");
                        $("#btn-ubah").prop('disabled', false);
                    },
                    error: function(res){
                        console.log("error : " + JSON.stringify(res) );
                        $("#btn-ubah").find("i").removeClass("fa-sync fa-spin").addClass("fa-save");
                        $("#btn-ubah").prop('disabled', false);
                    }
                });
            }
        }

        function hapus(id) {
            $("#id_hapus").val(id);
            var inputs = document.getElementById('setujuhapus');
            inputs.checked = false;
            $('#hapus').modal('show');
        }

        function prosesHapus() {
            // SWITCH BTN HAPUS
            var checkboxHapus = $('#setujuhapus').is(":checked");
            if (checkboxHapus == false) {
                iziToast.error({
                    title: 'Pesan Galat!',
                    message: 'Mohon menyetujui/ceklis form ini untuk melanjutkan proses penghapusan baris tersebut',
                    position: 'topRight'
                });
            } else {
                // PROSES HAPUS
                var id = $("#id_hapus").val();
                $.ajax({
                    url: "/api/kepegawaian/jadwaldinas/ln/"+id+"/hapus",
                    type: 'DELETE',
                    success: function(res) {
                        iziToast.success({
                            title: 'Pesan Sukses!',
                            message: 'Libur Nasional telah berhasil dihapus pada '+res,
                            position: 'topRight'
                        });
                        $('#hapus').modal('hide');
                        refresh();
                        // window.location.reload();
                    },
                    error: function(res) {
                        iziToast.error({
                            title: 'Pesan Galat!',
                            message: 'Libur Nasional gagal dihapus',
                            position: 'topRight'
                        });
                    }
                });
            }
        }
    </script>
@endsection
