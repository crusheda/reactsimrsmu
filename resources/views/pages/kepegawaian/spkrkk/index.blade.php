@extends('layouts.index')

@section('content')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i></a></li>
                        <li class="breadcrumb-item">Kepegawaian</li>
                        <li class="breadcrumb-item"><a href="{{ route('profilkaryawan.index') }}">Profil Karyawan</a></li>
                        <li class="breadcrumb-item" aria-current="page">Detail</li>
                    </ul>
                </div>
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h2 class="mb-0">Form <a class="text-primary">SPK <b class="text-dark">&</b> RKK</a></h2>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- [ breadcrumb ] end -->
    <!-- [ Main Content ] start -->
    <div class="row pt-1">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between py-3">
                    <h5 class="mb-0 card-title flex-grow-1">Upload Dokumen</h5>
                    {{-- <div class="flex-shrink-0">
                        <button type="button" class="btn btn-link-warning" id="btn-refresh-spkrkk" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true"
                        title="Refresh Tabel SPK & RKK" onclick="refreshSpkRkk()">
                        <i class="fa-fw fas fa-sync nav-icon me-1"></i>Segarkan</button>
                    </div> --}}
                </div>
                <div class="card-body p-b-0 p-3">
                    {{-- <div class="d-flex align-items-center justify-content-between">
                        <h4 class="mb-0 flex-grow-1"><a class="text-danger">*</a>/2 <small>dokumen wajib sudah terupload.</small></h4>
                        <div class="flex-shrink-0" id="switch-str" hidden>
                            <div class="form-check form-switch custom-switch-v1 switch-sm">
                                <input type="checkbox" class="form-check-input input-primary" id="checkboxseumurhidup">
                                <label class="form-check-label" for="checkboxseumurhidup">Seumur Hidup ?</label>
                            </div>
                        </div>
                    </div>
                    <hr class="my-2"> --}}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-secondary alert-dismissible fade show mb-3" role="alert">
                                <center><strong class="mb-0"><i>Form ini <b class="text-danger">HANYA BISA</b> diisi oleh komite keperawatan, komite nakesla, komite medik, dan Kepegawaian</i></strong></center>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            <div class="alert alert-secondary alert-dismissible fade show" role="alert">
                                <small>
                                    <i class="ti ti-arrow-narrow-right text-primary me-1"></i> SPK adalah <u>Surat Penugasan Klinis</u> dan RKK adalah <u>Rincian Kewenangan Klinis</u><br>
                                    <i class="ti ti-arrow-narrow-right text-primary me-1"></i> Batas maksimum ukuran file yang upload sebesar 3 mb (<b>PDF</b>)<br>
                                    <i class="ti ti-arrow-narrow-right text-primary me-1"></i> SPK & RKK dapat diubah ataupun hapus apabila berstatus <span class="badge rounded-pill text-bg-success p-1">Aktif</span>
                                </small>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group mb-3">
                                <label class="form-label">Nama Pegawai <span class="text-danger">*</span></label>
                                <select class="form-select select2" id="pegawai" data-allow-clear="false" data-bs-auto-close="outside" style="width: 100%" required>

                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label class="form-label">Jenis Dokumen <span class="text-danger">*</span></label>
                                <select class="form-control" id="jenis">
                                    <option value="" selected hidden>Pilih</option>
                                    <option value="0">SPK & RKK</option>
                                    {{-- <option value="1">RKK (Rincian Kewenangan Klinis)</option> --}}
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group mb-3">
                                <label class="form-label">Tgl. Masa Berlaku <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="tgl_akhir">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group mb-3">
                                <label class="form-label">Deskripsi</label>
                                <textarea id="deskripsi" class="form-control" placeholder="Tuliskan Keterangan (Optional)" rows="1"></textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label class="form-label">Upload Dokumen <span class="text-danger">*</span></label>
                                <div class="row">
                                    <div class="col"><input type="file" class="form-control" id="upload" accept="application/pdf"></div>
                                    <div class="col-auto"><button class="btn btn-primary" onclick="prosesTambahSpkRkk()" id="btn-upload-spkrkk"><i class="fas fa-upload me-1"></i> Upload</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card table-card">
                <div class="card-header d-flex align-items-center justify-content-between py-3">
                    <h5 class="mb-0 card-title flex-grow-1">Tabel</h5>
                    <div class="flex-shrink-0">
                        <button type="button" class="btn btn-link-warning" id="btn-refresh-spkrkk" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true"
                        title="Refresh Tabel SPK & RKK" onclick="refreshSpkRkk()">
                        <i class="fa-fw fas fa-sync nav-icon me-1"></i>Segarkan</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table mb-0 table-hover" id="dttable-spkrkk">
                            <thead>
                                <tr>
                                    <th><center>AKSI</center></th>
                                    <th>RECORD</th>
                                    <th>TGL BERAKHIR</th>
                                    <th>DESKRIPSI</th>
                                    <th class="text-end">TERAKHIR DIUBAH</th>
                                </tr>
                            </thead>
                            <tbody id="tampil-tbody-spkrkk">
                                <tr>
                                    <td colspan="9" style="font-size:13px">
                                        <center><i class="fa fa-spinner fa-spin fa-fw"></i> Memproses data...</center>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal animate__animated animate__rubberBand fade" id="hapusSpkRkk" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-simple modal-add-new-address modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        Form Hapus SPK / RKK Pegawai
                    </h4>
                </div>
                <div class="modal-body">
                    <input type="text" id="id_hapus_spkrkk" hidden>
                    <p style="text-align: justify;">Anda akan menghapus <strong>Data SPK / RKK</strong> <kbd>ID:<a id="show_id_hapusspkrkk"></a></kbd> dari database.
                        Penghapusan data akan menghapus data record pada database dan menghapus file pada storage system. Maka dari itu, lakukanlah dengan hati-hati. Ceklis dibawah untuk melanjutkan penonaktifan.</p>
                    <label class="switch">
                        <input type="checkbox" class="switch-input" id="setujuhapusspkrkk">
                        <span class="switch-toggle-slider">
                        <span class="switch-on"></span>
                        <span class="switch-off"></span>
                        </span>
                        <span class="switch-label">Anda siap menerima Risiko</span>
                    </label>
                </div>
                <div class="col-12 text-center mb-4">
                    <button type="submit" id="btn-hapus-spkrkk" class="btn btn-danger me-sm-3 me-1" onclick="prosesHapusSpkRkk()"><i class="fas fa-trash me-1" style="font-size:13px"></i> Hapus</button>
                    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-times me-1" style="font-size:13px"></i> Batal</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            refreshSpkRkk();
            $('#jns_spkrkk').on('change', function() {
                console.log($('#validasi_tgl_akhir_spkrkk').val());
                if ($(this).val() == 0) {
                    $('#wajib_tgl_akhir_spkrkk').prop('hidden',false);
                    $('#tgl_akhir_spkrkk').prop('disabled',false);
                } else {
                    $('#wajib_tgl_akhir_spkrkk').prop('hidden',true);
                    $('#tgl_akhir_spkrkk').prop('disabled',true);
                }
            });
        })

        function prosesTambahSpkRkk() {
            $("#btn-upload-spkrkk").prop('disabled', true);
            $("#btn-upload-spkrkk").find("i").toggleClass("fa-upload fa-sync fa-spin");

            // ISIAN FORM WAJIB
            var id_pegawai = $('#id_pegawai').val();
            var jenis = $('#jenisjns').val();
            var tgl_akhir = $('#tgl_akhir').val();
            var deskripsi = $('#deskripsi').val();
            var filesAdded = $('#upload')[0].files;

            // EXECUTE
            if (id_pegawai == '' || jenis == '' || tgl_akhir == '' || filesAdded.length == 0) {
                iziToast.warning({
                    title: 'Pesan Ambigu!',
                    message: 'Mohon lengkapi semua data (<span class="text-danger">*</span>) terlebih dahulu dan pastikan tidak ada yang kosong',
                    position: 'topRight'
                });
            } else {
                // INISIALISASI
                var fd = new FormData();
                fd.append('jns_dokumen',jenis);
                fd.append('deskripsi',deskripsi);
                fd.append('tgl_berakhir',tgl_akhir);
                fd.append('user_id',"{{ Auth::user()->id }}");
                fd.append('pegawai_id',id_pegawai);
                fd.append('file',filesAdded[0]);

                // AJAX REQUEST
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "/api/kepegawaian/spkrkk/tambah",
                    method: 'post',
                    data: fd,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(res){
                        iziToast.success({
                            title: 'Pesan Sukses!',
                            message: 'SPK & RKK Pegawai berhasil diupload pada '+res,
                            position: 'topRight'
                        });
                        if (res) {
                            refreshSpkRkk();
                        }
                    },
                    error: function(res){
                        console.log("error : " + JSON.stringify(res) );
                        iziToast.error({
                            title: 'Pesan Galat!',
                            message: res.responseJSON,
                            position: 'topRight'
                        });
                    }
                });
            }

            $("#btn-upload-spkrkk").find("i").removeClass("fa-sync fa-spin").addClass("fa-upload");
            $("#btn-upload-spkrkk").prop('disabled', false);
        }

        function refreshSpkRkk() {
            $("#tampil-tbody-spkrkk").empty();
            $("#tampil-tbody-spkrkk").empty().append(`<tr><td colspan="9" style="font-size:13px"><center><i class="fa fa-spinner fa-spin fa-fw"></i> Memproses data...</center></td></tr>`);
            $.ajax(
                {
                    url: "/api/kepegawaian/spkrkk/table",
                    type: 'GET',
                    dataType: 'json', // added data type
                    success: function(res) {
                        // VALIDATION FORM
                        $('#jns_spkrkk').val('');
                        $('#tgl_akhir_spkrkk').val('');
                        $('#deskripsi_spkrkk').val('');
                        $('#upload_spkrkk').val('');
                        // ------------------------------------------------------
                        $("#tampil-tbody-spkrkk").empty();
                        $('#dttable-spkrkk').DataTable().clear().destroy();
                        res.show.forEach(item => {
                            content = "<tr id='data"+ item.id +"'>";
                            content += `<td><center><div class='dropend'><a href='javascript:void(0);' class='btn btn-light btn-sm text-muted font-size-16 rounded' data-bs-toggle='dropdown' aria-haspopup="true"><i class="ti ti-dots"></i></a><div class='dropdown-menu'>`;
                                if (item.deleted_at == null) {
                                    content += `<a href='javascript:void(0);' class='dropdown-item text-primary' onclick="window.open('/kepegawaian/kepegawaian/spkrkk/download/`+item.id+`')"><i class='fas fa-download me-1'></i> Download</a>`;
                                } else {
                                    content += `<a href='javascript:void(0);' class='dropdown-item text-secondary'><i class='fas fa-download me-1'></i> Download</a>`;
                                }
                                if (item.status == 0) {
                                    content += `<a href='javascript:void(0);' class='dropdown-item text-secondary'><i class='fas fa-edit me-1'></i> Ubah</a>`;
                                    content += `<a href='javascript:void(0);' class='dropdown-item text-secondary'><i class='fas fa-trash me-1'></i> Hapus</a>`;
                                } else {
                                    content += `<a href='javascript:void(0);' class='dropdown-item text-secondary'><i class='fas fa-edit me-1'></i> Ubah</a>`;
                                    // content += `<a href='javascript:void(0);' class='dropdown-item text-warning' onclick="showUbahSpkRkk(`+item.id+`)" value="animate__rubberBand"><i class='fas fa-edit me-1'></i> Ubah</a>`;
                                    content += `<a href='javascript:void(0);' class='dropdown-item text-danger' onclick="showHapusSpkRkk(`+item.id+`)" value="animate__rubberBand"><i class='fas fa-trash me-1'></i> Hapus</a>`;
                                }
                            content += `</div></center></td>`;
                            if (item.deleted_at != null) {
                                bgHapus = `<span class="badge rounded-pill text-bg-danger p-1">Terhapus</span>`;
                            } else {
                                bgHapus = ``;
                            }
                            if (item.status != 0) {
                                bgStatus = `<span class="badge rounded-pill text-bg-success p-1">Aktif</span>`;
                            } else {
                                bgStatus = `<span class="badge rounded-pill text-bg-secondary p-1">Nonaktif</span>`;
                            }
                            content += `<td style='white-space: normal !important;word-wrap: break-word;'>`
                                        + `<div class='d-flex justify-content-start align-items-center'><div class='d-flex flex-column'>`
                                        + `<h6 class='mb-0'><b class="${item.status != 0?'text-primary':'text-secondary'}">${item.jns_dokumen == 0?'SPK & RKK':'Dokumen Lain'}</b>&nbsp;${item.nama_pegawai}&nbsp;&nbsp;` +bgStatus+ `&nbsp;&nbsp;` + bgHapus + `</h6><small class='text-truncate text-muted'>Oleh ` + item.nama_kepegawaian + `</small>`
                                        + `</div></div></td>`;
                            content += `<td>${item.tgl_berakhir?item.tgl_berakhir:'-'}</td>`;
                            content += `<td>${item.deskripsi?item.deskripsi:'-'}</td>`;
                            content += "<td>" + new Date(item.updated_at).toLocaleString("sv-SE") + "</td></tr>";
                            $('#tampil-tbody-spkrkk').append(content);
                        });
                        var table = $('#dttable-spkrkk').DataTable({
                            order: [
                                [4, "desc"]
                            ],
                            bAutoWidth: false,
                            aoColumns : [
                                { sWidth: '5%' },
                                { sWidth: '40%' },
                                { sWidth: '10%' },
                                { sWidth: '30%' },
                                { sWidth: '15%' },
                            ],
                            displayLength: 10,
                            lengthChange: true,
                            lengthMenu: [ 10, 25, 50, 75, 100, 500, 1000, 5000, 10000],
                            // buttons: ['copy', 'excel', 'pdf', 'colvis']
                        });
                    },
                    error: function(res) {
                        iziToast.error({
                            title: 'Pesan Galat!',
                            message: 'Dokumen tidak ditemukan.',
                            position: 'topRight'
                        });
                    }
                }
            );
        }

        function showHapusSpkRkk(id) {
            $("#id_hapus_spkrkk").val(id);
            $("#show_id_hapusspkrkk").text(id);
            var inputs = document.getElementById('setujuhapusspkrkk');
            inputs.checked = false;
            $('#hapusSpkRkk').modal('show');
        }

        function prosesHapusSpkRkk() {
            // SWITCH BTN HAPUS
            var checkboxHapus = $('#setujuhapusspkrkk').is(":checked");
            if (checkboxHapus == false) {
                iziToast.error({
                    title: 'Pesan Galat!',
                    message: 'Mohon menyetujui untuk dilakukan penghapusan data record SPK / RKK tersebut',
                    position: 'topRight'
                });
            } else {
                // PROSES HAPUS
                var id = $("#id_hapus_spkrkk").val();
                $.ajax({
                    url: "/api/kepegawaian/spkrkk/hapus/"+id+"/proses",
                    type: 'DELETE',
                    success: function(res) {
                        iziToast.success({
                            title: 'Pesan Sukses!',
                            message: 'Data Record Pegawai telah berhasil dihapus pada '+res,
                            position: 'topRight'
                        });
                        $('#hapusSpkRkk').modal('hide');
                        refreshSpkRkk();
                    },
                    error: function(res) {
                        iziToast.error({
                            title: 'Pesan Galat!',
                            message: 'Data Record Pegawai gagal dihapus',
                            position: 'topRight'
                        });
                    }
                });
            }
        }
    </script>
@endsection
