@extends('layouts.index')

@section('content')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i></a></li>
                        <li class="breadcrumb-item">Kepegawaian</li>
                        <li class="breadcrumb-item">Rekrutmen</li>
                        <li class="breadcrumb-item" aria-current="page">Registrasi</li>
                    </ul>
                </div>
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h2 class="mb-0">Daftar Peserta</h2>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- [ breadcrumb ] end -->

    <!-- [ Main Content ] start -->
    <div class="row pt-1">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between py-3">
                    <h5 class="mb-0">Filter <b class="text-primary">Data</b></h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group mb-2">
                                <label class="form-label">Pilih Lowongan Pekerjaan</label>
                                <select class="form-control" id="filter_lowongan">
                                    <option value="0">Semua Lowongan Kerja</option>
                                    @if (count($list['pengumuman']) > 0)
                                        @foreach ($list['pengumuman'] as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama }} ({{ \Carbon\Carbon::parse($item->mulai)->translatedFormat('d F Y') . ' - ' . \Carbon\Carbon::parse($item->selesai)->translatedFormat('d F Y') }})</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="text-end btn-page mt-3">
                                <button class="btn btn-link-secondary" id="btn-clear" onclick="clearForm()">Kosongkan</button>
                                <button class="btn btn-primary" id="btn-filter" onclick="filter()"><i class="fas fa-search me-1"></i> Filter Peserta</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row pt-1" id="tablePeserta" hidden>
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between py-3">
                    <h5 class="mb-0">Tabel <b class="text-primary">Peserta</b></h5>
                    <div class="btn-group">
                        <button type="button" class="btn btn-warning" onclick="filter()"><i class="fa-fw fas fa-sync nav-icon"></i></button>
                        <button type="button" class="btn btn-info" onclick="window.location='{{ route('kepegawaian.rekrutmen.indexPengumuman') }}'"><i class="fas fa-file-archive me-1 nav-icon"></i> Lihat Lowongan</button>
                    </div>
                </div>
                <div class="card-body">
                    {{-- <div class="alert alert-secondary mb-3">
                        <small>
                            <i class="fa-fw fas fa-caret-right nav-icon"></i> Hapus Lowongan Kerja digunakan HANYA apabila lowongan salah/dibatalkan <br>
                            <i class="fa-fw fas fa-caret-right nav-icon"></i> Lowongan akan tampil pada Website RS setelah input pada rentang tanggal dibuka sampai ditutup <br>
                        </small>
                    </div> --}}
                    <div class="table-responsive">
                        <table id="dttable" class="table table-hover dt-responsive align-middle">
                            <thead>
                                <tr>
                                    <th rowspan="2" class="text-center cell-fit">AKSI</th>
                                    <th rowspan="2" class="text-center cell-fit">HASIL</th>
                                    <th rowspan="2" class="text-center cell-fit">KEHADIRAN</th>
                                    <th rowspan="2" class="text-center cell-fit">KETERANGAN</th>
                                    <th rowspan="2" class="text-center">NAMA PESERTA</th>
                                    <th rowspan="2" class="text-center cell-fit">TTL</th>
                                    <th rowspan="2" class="text-center">EMAIL</th>
                                    <th rowspan="2" class="text-center cell-fit">NO.HP</th>
                                    <th rowspan="2" class="text-center">ALAMAT</th>
                                    <th rowspan="2" class="text-center">PENDIDIKAN</th>
                                    <th rowspan="2" class="text-center cell-fit">SOSMED</th>
                                    <th colspan="6" class="text-center">DOKUMEN UPLOAD</th>
                                    <th rowspan="2" class="text-center cell-fit">DIPERBARUI</th>
                                </tr>
                                <tr>
                                    <th class="text-center cell-fit">PAS PHOTO</th>
                                    <th class="text-center cell-fit">CV</th>
                                    <th class="text-center cell-fit">IJAZAH</th>
                                    <th class="text-center cell-fit">TRANSKIP</th>
                                    <th class="text-center cell-fit">LAMARAN</th>
                                    <th class="text-center cell-fit">SERTIFIKAT</th>
                                </tr>
                            </thead>
                            <tbody id="tampil-tbody">
                                <tr>
                                    <td colspan="15" style="font-size:13px">
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
    <div id="previewPdf" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="preview">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="preview"><span class="badge text-bg-secondary">Preview</span> | Dokumen : <a id="nama_dokumen" class="text-primary"></a></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-3">
                    <div id="cetak-dokumen"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    <div id="formHasil" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="preview">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Form Penentuan Hasil <span class="badge text-bg-primary" id="id_hasil"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-3">
                    <input type="text" class="form-control" id="inp_hasil_old" hidden>
                    <input type="text" class="form-control" id="inp_peserta_id" hidden>
                    <div class="form-group mb-3">
                        <label class="form-label">Pilihan Hasil Seleksi <b class="text-danger">*</b></label>
                        <select class="form-control" id="inp_hasil"></select>
                    </div>
                    <div class="form-group mb-3 seleksi" hidden>
                        <label class="form-label">Tanggal Seleksi <b class="text-danger">*</b></label>
                        <input type="date" class="form-control" id="tgl_seleksi">
                    </div>
                    <div class="form-group mb-3 seleksi" hidden>
                        <label class="form-label">Ruang Seleksi <b class="text-danger">*</b></label>
                        <input type="text" class="form-control" id="inp_ruang"></input>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Keterangan Hasil Seleksi <b class="text-danger">*</b></label>
                        <textarea class="form-control" id="inp_ket" rows="3" placeholder="Keterangan yang dimasukkan akan dapat dilihat oleh Calon Pegawai melalui halaman Hasil Seleksi di Website RS"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="btn-ubah-hasil" class="btn btn-primary me-sm-1 me-1" onclick="prosesHasil()"><i class="fa fa-save me-1" style="font-size:13px"></i> Tetapkan Hasil</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // $('#filter_lowongan').on('change', function() {
            //     let value = $(this).val();
            // });
        })

        function filter() {
            id = $('#filter_lowongan').val();
            $("#tampil-tbody").empty();
            $("#tampil-tbody").empty().append(`<tr><td colspan="15" style="font-size:13px"><center><i class="fa fa-spinner fa-spin fa-fw"></i> Memproses data...</center></td></tr>`);
            $.ajax(
                {
                    url: "/api/kepegawaian/rekrutmen/registrasi/table/"+id,
                    type: 'GET',
                    dataType: 'json', // added data type
                    success: function(res) {
                        var adminID = "{{ Auth::user()->getPermission('admin_kepegawaian') }}";
                        var kepalaID = "{{ Auth::user()->getPermission('admin_kepegawaian_kepala') }}";
                        // var userID = "{{ Auth::user()->id }}";
                        $("#tampil-tbody").empty();
                        $('#dttable').DataTable().clear().destroy();

                        res.show.forEach(item => {
                            if (item.hasil == 1) {
                                txHasil = 'Terdaftar';
                                clHasil = 'info';
                            } else {
                                if (item.hasil == 2) {
                                    txHasil = 'Lanjut Seleksi';
                                    clHasil = 'primary';
                                } else {
                                    if (item.hasil == 3) {
                                        txHasil = 'Lolos Seleksi';
                                        clHasil = 'success';
                                    } else {
                                        txHasil = 'Tidak Lolos';
                                        clHasil = 'danger';
                                    }
                                }
                            }
                            content = "<tr id='data"+ item.id +"'>";
                            content += `<td><center><div class='dropend'><a href='javascript:void(0);' class='btn btn-${clHasil} btn-sm font-size-16 rounded' data-bs-toggle='dropdown' aria-haspopup="true"><i class="ti ti-dots"></i></a><div class='dropdown-menu'>`;
                            if (item.hasil == 0) {
                                content += `<a href='javascript:void(0);' class='dropdown-item text-secondary'><i class='fas fa-file-invoice me-2'></i> Hasil</a>`;
                            } else {
                                content += `<a href='javascript:void(0);' class='dropdown-item text-${clHasil}' onclick="ubahHasil(${item.id},${item.hasil})"><i class='fas fa-file-invoice me-2'></i> Hasil</a>`;
                            }
                                // if (item.status == 1) {
                                //     if (moment(res.now).format('YYYY-MM-DD') >= moment(item.mulai).format('YYYY-MM-DD')) {
                                //         if (moment(res.now).format('YYYY-MM-DD') <= moment(item.selesai).format('YYYY-MM-DD')) {
                                //             content += `<a href='javascript:void(0);' class='dropdown-item text-warning' onclick="ubah(`+item.id+`)" value="animate__rubberBand"><i class='fas fa-edit me-1'></i> Ubah</a>`;
                                //             content += `<a href='javascript:void(0);' class='dropdown-item text-danger' onclick="nonaktif(`+item.id+`)" value="animate__rubberBand"><i class='fas fa-trash me-1'></i> Non Aktif</a>`;
                                //         } else {
                                //             content += `<a href='javascript:void(0);' class='dropdown-item text-secondary'><i class='fas fa-edit me-1'></i> Ubah</a>`;
                                //             content += `<a href='javascript:void(0);' class='dropdown-item text-secondary'><i class='fas fa-trash me-1'></i> Non Aktif</a>`;
                                //         }
                                //     } else {
                                //         content += `<a href='javascript:void(0);' class='dropdown-item text-secondary'><i class='fas fa-edit me-1'></i> Ubah</a>`;
                                //         content += `<a href='javascript:void(0);' class='dropdown-item text-secondary'><i class='fas fa-trash me-1'></i> Non Aktif</a>`;
                                //     }
                                // } else {
                                //     content += `<a href='javascript:void(0);' class='dropdown-item text-secondary'><i class='fas fa-edit me-1'></i> Ubah</a>`;
                                //     content += `<a href='javascript:void(0);' class='dropdown-item text-secondary'><i class='fas fa-trash me-1'></i> Non Aktif</a>`;
                                // }
                            content += `</div></center></td>`;
                            // content += `<td style='white-space: normal !important;word-wrap: break-word;'>
                            //                 <div class='d-flex justify-content-start align-items-center'>
                            //                     <div class='d-flex flex-column'>

                            //                         <small class='text-truncate text-muted'>Jumlah Kebutuhan : <b class='text-primary'>${item.jumlah}</b> Orang</small>
                            //                         <small class='text-truncate text-muted'>Kuota Pendaftar : ${item.kuota?'<b class="text-danger">'+item.kuota+'</b> Peserta':'<b class="text-danger">∞</b> (Tak Terhingga)'}</small>
                            //                         <small class='text-truncate text-muted'>Batasan Umur : <mark>${item.umur_min?item.umur_min:'x'} - ${item.umur_max?item.umur_max:'x'} Tahun</mark></small>
                            //                     </div>
                            //                 </div>
                            //             </td>`;
                            content += `<td><center><span class="badge rounded-pill text-bg-${clHasil}">${txHasil}</span></center></td>`;
                            if (item.kehadiran != null) {
                                if (item.kehadiran == 0) {
                                    txHadir = 'Tidak Hadir';
                                    clHadir = 'warning';
                                } else {
                                    txHadir = 'Hadir';
                                    clHadir = 'success';
                                }
                            } else {
                                txHadir = 'Belum Ditentukan';
                                clHadir = 'secondary';
                            }
                            content += `<td><center><span class="badge rounded-pill text-bg-${clHadir}">${txHadir}</span></center></td>`;
                            content += `<td>${item.keterangan_lolos?item.keterangan_lolos:'-'}</td>`;
                            content += `<td>${item.nama}</td>`;
                            content += `<td><center>${item.tempat_lahir}, ${moment(item.tgl_lahir).locale('id').format('D MMMM YYYY')}</center></td>`;
                            content += `<td>${item.email}</td>`;
                            content += `<td><center>${item.hp}</center></td>`;
                            content += `<td style='white-space: normal !important;word-wrap: break-word;'>${item.alamat_lengkap}</td>`;
                            content += `<td style='white-space: normal !important;word-wrap: break-word;'>${item.pendidikan}</td>`;
                            content += `<td style='white-space: normal !important;word-wrap: break-word;'>${item.sosmed}</td>`;
                            content += `<td><center><button class="btn btn-light-${clHasil} rounded" id="download1" onclick="showPreviewPdf(1,'${item.encrypted_id}')"><i class="fas fa-download"></i></button></center></td>`;
                            content += `<td><center><button class="btn btn-light-${clHasil} rounded" id="download2" onclick="showPreviewPdf(2,'${item.encrypted_id}')"><i class="fas fa-download"></i></button></center></td>`;
                            content += `<td><center><button class="btn btn-light-${clHasil} rounded" id="download3" onclick="showPreviewPdf(3,'${item.encrypted_id}')"><i class="fas fa-download"></i></button></center></td>`;
                            content += `<td><center><button class="btn btn-light-${clHasil} rounded" id="download4" onclick="showPreviewPdf(4,'${item.encrypted_id}')"><i class="fas fa-download"></i></button></center></td>`;
                            content += `<td><center><button class="btn btn-light-${clHasil} rounded" id="download5" onclick="showPreviewPdf(5,'${item.encrypted_id}')"><i class="fas fa-download"></i></button></center></td>`;
                            if (item.p_sertifikat) {
                                content += `<td><center><button class="btn btn-light-${clHasil} rounded" id="download6" onclick="showPreviewPdf(6,${item.id})"><i class="fas fa-download"></i></button></center></td>`;
                            } else {
                                content += `<td><center><button class="btn btn-secondary rounded" disabled><i class="fas fa-download"></i></button></center></td>`;
                            }
                            content += `<td style='white-space: normal !important;word-wrap: break-word;'>
                                            <div class='d-flex justify-content-start align-items-center'>
                                                <div class='d-flex flex-column'>
                                                    <a class='mb-0'>` + new Date(item.updated_at).toLocaleString("sv-SE") + `</a>
                                                </div>
                                            </div>
                                        </td>`;
                            content += "</tr>";
                            $('#tampil-tbody').append(content);
                        });
                        var table = $('#dttable').DataTable({
                            dom: 'Bfrtip',
                            order: [
                                [17, "desc"]
                            ],
                            // bAutoWidth: false,
                            // aoColumns : [
                            //     { sWidth: '5%' },
                            //     { sWidth: '20%' },
                            //     { sWidth: '5%' },
                            //     { sWidth: '5%' },
                            //     { sWidth: '10%' },
                            //     { sWidth: '10%' },
                            //     { sWidth: '10%' },
                            //     { sWidth: '10%' },
                            //     { sWidth: '10%' },
                            //     { sWidth: '5%' },
                            //     { sWidth: '10%' },
                            // ],
                            columnDefs: [
                                { visible: false, targets: [3] },
                            ],
                            displayLength: 15,
                            // lengthChange: true,
                            // lengthMenu: [ 10, 25, 50, 75, 100, 500, 1000, 5000, 10000],
                            buttons: [
                                // 'copy',
                                'excel',
                                // 'pdf',
                                'colvis']
                        });
                        $('#tablePeserta').prop('hidden',false);
                    },
                    error: function(res) {
                        iziToast.error({
                            title: 'Pesan Galat!',
                            message: 'Record Data tidak ditemukan.',
                            position: 'topRight'
                        });
                    }
                }
            );
        }

        function ubahHasil(id,hasil) {
            $('#inp_peserta_id').val(id);
            $('#inp_hasil_old').val(hasil);
            $('#id_hasil').text('ID#'+id);

            $('#inp_hasil').empty();
            $('#inp_hasil').append(`
                <option value="1">Peserta Berhasil Daftar</option>
                <option value="2">Peserta Lanjut Seleksi</option>
                <option value="3">Peserta Lolos Seleksi</option>
                <option value="0">Peserta Tidak Lolos</option>
            `);
            $('#inp_hasil').val(hasil).trigger('change');

            if (hasil == 1) {
                $('.seleksi').prop('hidden',false);
            } else {
                $('.seleksi').prop('hidden',true);
            }

            $('#formHasil').modal('show');
        }

        function prosesHasil() {
            $("#btn-ubah-hasil").prop('disabled', true);
            $("#btn-ubah-hasil").find("i").removeClass("fa-save").addClass('fa-sync fa-spin');
            // Definisi
            id = $('#inp_peserta_id').val();
            ket = $('#inp_ket').val();
            tgl_seleksi = $('#tgl_seleksi').val();
            ruang_seleksi = $('#inp_ruang').val();
            hasil = $('#inp_hasil').val();
            hasil_old = $('#inp_hasil_old').val();

            if (hasil < hasil_old) {
                if (hasil != 0) {
                    iziToast.warning({
                        title: 'Pesan Ambigu!',
                        message: 'Hasil Seleksi harus berprogress maju, tidak bisa memundurkan tahap seleksi!',
                        position: 'topRight'
                    });
                    $("#btn-ubah-hasil").find("i").removeClass("fa-sync fa-spin").addClass("fa-save");
                    $("#btn-ubah-hasil").prop('disabled', false);
                    return;
                }
            }

            if (hasil_old == 1 && hasil == 3) {
                iziToast.warning({
                    title: 'Pesan Ambigu!',
                    message: 'Hasil Seleksi harus berprogress maju, tidak bisa memundurkan tahap seleksi!',
                    position: 'topRight'
                });
                $("#btn-ubah-hasil").find("i").removeClass("fa-sync fa-spin").addClass("fa-save");
                $("#btn-ubah-hasil").prop('disabled', false);
                return;
            }

            var save = new FormData();
            save.append('id',id);
            save.append('tgl_seleksi',tgl_seleksi);
            save.append('ruang_seleksi',ruang_seleksi);
            save.append('ket',ket);
            save.append('hasil',hasil);
            save.append('pegawai','{{ Auth::user()->id }}');

            if (hasil_old == 1) {
                if (tgl_seleksi == '' || ruang_seleksi == '') {
                    iziToast.warning({
                        title: 'Pesan Ambigu!',
                        message: 'Apabila Hasil diubah ke Lanjut Seleksi, maka wajib memasukkan Tanggal dan Ruang Seleksi. Periksa Perubahan Hasil Seleksi Anda!',
                        position: 'topRight'
                    });
                    $("#btn-ubah-hasil").find("i").removeClass("fa-sync fa-spin").addClass("fa-save");
                    $("#btn-ubah-hasil").prop('disabled', false);
                    return;
                }
            }

            if (hasil == hasil_old) {
                iziToast.warning({
                    title: 'Pesan Ambigu!',
                    message: 'Pilihan Hasil Seleksi tidak diboleh sama dengan sebelumnya. Periksa Hasil Seleksi baru Anda!',
                    position: 'topRight'
                });
                $("#btn-ubah-hasil").find("i").removeClass("fa-sync fa-spin").addClass("fa-save");
                $("#btn-ubah-hasil").prop('disabled', false);
            } else {
                if (ket == '') {
                    iziToast.warning({
                        title: 'Pesan Ambigu!',
                        message: 'Keterangan Hasil Seleksi wajib terisi. Periksa keterangan Hasil Seleksi sekali lagi!',
                        position: 'topRight'
                    });
                    $("#btn-ubah-hasil").find("i").removeClass("fa-sync fa-spin").addClass("fa-save");
                    $("#btn-ubah-hasil").prop('disabled', false);
                } else {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        method: 'POST',
                        url: `/api/kepegawaian/rekrutmen/registrasi/hasil`,
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                        data: save,
                        success: function(res) {
                            if (res.code == 400) {
                                iziToast.error({
                                    title: 'Pesan Galat!',
                                    message: res.message,
                                    position: 'topRight',
                                    buttons: [
                                        [
                                            '<button>Tutup</button>',
                                            function (instance, toast) {
                                                instance.hide({
                                                    transitionOut: 'fadeOutUp'
                                                }, toast);
                                            }
                                        ]
                                    ]
                                });
                            } else {
                                iziToast.success({
                                    title: 'Pesan Sukses!',
                                    message: res.message,
                                    position: 'topRight'
                                });
                                filter();
                                $('#formHasil').modal('hide');
                            }
                            $("#btn-ubah-hasil").find("i").removeClass("fa-sync fa-spin").addClass("fa-save");
                            $("#btn-ubah-hasil").prop('disabled', false);
                        },
                        error: function (res) {
                            iziToast.error({
                                title: 'Pesan Galat!',
                                message: res.responseJSON.error,
                                position: 'topRight'
                            });
                            $("#btn-ubah-hasil").find("i").removeClass("fa-sync fa-spin").addClass("fa-save");
                            $("#btn-ubah-hasil").prop('disabled', false);
                        }
                    });
                }
            }
        }

        function showPreviewPdf(dokumen_id, peserta_id) {
            let nama_dokumen = '';
            switch (dokumen_id) {
                case 1: nama_dokumen = 'Pas Photo'; break;
                case 2: nama_dokumen = 'Curriculum Vitae'; break;
                case 3: nama_dokumen = 'Ijazah'; break;
                case 4: nama_dokumen = 'Transkip Nilai'; break;
                case 5: nama_dokumen = 'Lamaran'; break;
                default: nama_dokumen = 'Sertifikat Tambahan'; break;
            }

            $('#nama_dokumen').text(nama_dokumen);
            $('#download'+dokumen_id).find('i').removeClass('fa-download').addClass('fa-sync fa-spin');

            fetch(`https://rspkusukoharjo.com/api/rekrutmen/registrasi/download/${dokumen_id}/${peserta_id}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Dokumen tidak ditemukan atau gagal diambil.');
                }
                return response.blob();
            })
            .then(blob => {
                const fileURL = URL.createObjectURL(blob);
                const mimeType = blob.type; // <--- cek tipe file

                let htmlContent = '';
                if (mimeType === 'application/pdf') {
                    // Kalau PDF pakai iframe
                    htmlContent = `<iframe src="${fileURL}" style="width:100%; height:80vh;" frameborder="0"></iframe>`;
                } else if (mimeType.startsWith('image/')) {
                    // Kalau gambar pakai <img> + style agar fit
                    htmlContent = `<img src="${fileURL}" alt="Preview" style="max-width:100%; max-height:80vh; object-fit:contain; display:block; margin:auto;">`;
                } else {
                    // Kalau tipe lain (txt, docx, dll)
                    htmlContent = `<p class="text-danger">Format file tidak bisa ditampilkan di sini. <a href="${fileURL}" target="_blank">Download</a></p>`;
                }

                $('#cetak-dokumen').empty().html(htmlContent);
                $('#previewPdf').modal('show');
                $('#download'+dokumen_id).find('i').removeClass('fa-sync fa-spin').addClass('fa-download');
            })
            .catch(error => {
                iziToast.error({
                    title: 'Maaf!',
                    message: 'Dokumen tidak ditemukan atau belum pernah diupload oleh Peserta.',
                    position: 'topRight'
                });
                console.error(error);
                $('#download'+dokumen_id).find('i').removeClass('fa-sync fa-spin').addClass('fa-download');
            });
        }

        function clearForm() {
            $('#filter_lowongan').val(0).change();
            $('#tablePeserta').prop('hidden',true);
        }
    </script>
@endsection
