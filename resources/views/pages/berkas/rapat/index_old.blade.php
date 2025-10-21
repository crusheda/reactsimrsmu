@extends('layouts.default')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Berkas - Rapat</h4>
            </div>
        </div>
    </div>

    <div class="card card-body table-responsive">
        <h4 classs="card-title">
            <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#tambah"><i
                    class="tf-icon bx bx-upload"></i>&nbsp;&nbsp;Upload Berkas</button>
        </h4>
        <hr>
        <table id="dttable" class="table dt-responsive table-hover w-100 align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>KEGIATAN</th>
                    <th>KETUA</th>
                    <th>WAKTU</th>
                    <th>LOKASI</th>
                    <th>KET</th>
                    <th>UPDATE</th>
                    <th>USER</th>
                    <th>
                        <center>#</center>
                    </th>
                </tr>
            </thead>
            <tbody id="tampil-tbody">
                <tr>
                    <td colspan="9">
                        <center><i class="fa fa-spinner fa-spin fa-fw"></i> Memproses data...</center>
                    </td>
                </tr>
            </tbody>
            <tfoot class="bg-whitesmoke">
                <tr>
                    <th>ID</th>
                    <th>KEGIATAN</th>
                    <th>KETUA</th>
                    <th>WAKTU</th>
                    <th>LOKASI</th>
                    <th>KET</th>
                    <th>UPDATE</th>
                    <th>USER</th>
                    <th>
                        <center>#</center>
                    </th>
                </tr>
            </tfoot>
        </table>
    </div>

    {{-- MODAL START --}}
    <div class="modal fade bd-example-modal-lg" id="tambah" role="dialog" aria-labelledby="confirmFormLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        Form Upload
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="form-auth-small" name="formTambah" action="{{ route('rapat.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="mb-2">Kegiatan</label>
                                    <input type="text" name="nama" id="nama" class="form-control"
                                        placeholder="e.g. Rapat Unit IT" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="mb-2">Ketua Rapat</label>
                                    <select class="select2 form-control" name="kepala" style="width: 100%" required>
                                        <option value="">Pilih</option>
                                        @foreach ($list['users'] as $key => $item)
                                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="mb-2">Tanggal</label>
                                    <input class="form-control flatpickr" name="tanggal" type="text">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="mb-2">Lokasi Rapat</label>
                                    <input type="text" name="lokasi" id="lokasi" class="form-control"
                                        placeholder="e.g. Ruang IT" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label class="mb-2">Keterangan</label>
                            <textarea maxlength="200" rows="3" placeholder="Keterangan terbatas hanya 200 karakter." class="form-control"
                                name="keterangan" id="keterangan" placeholder="Optional"></textarea>
                        </div>
                        <div class="form-group">
                            <label class="mb-2">Upload</label>
                            <input type="file" class="form-control mb-2" name="file2[]" id="file2" multiple required>
                            <i class="fa-fw fas fa-caret-right nav-icon"></i> File yang diupload berupa Dokumen dan bisa
                            lebih dari satu file<br>
                            <i class="fa-fw fas fa-caret-right nav-icon"></i> Batas ukuran maksimum setiap file adalah
                            <strong>5 mb</strong>
                        </div>
                </div>
                <div class="modal-footer">

                    <button class="btn btn-primary" id="btn-simpan" onclick="saveData()"><i
                            class="fa-fw fas fa-upload nav-icon"></i> Upload</button>
                    </form>

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i
                            class="fa-fw fas fa-times nav-icon"></i> Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bd-example-modal-lg" id="ubah" role="dialog" aria-labelledby="confirmFormLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        Form Ubah Berkas&nbsp;<kbd><a id="show_edit"></a></kbd>
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="text" id="id_edit" class="form-control" hidden>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="mb-2">Kegiatan :</label>
                                <input type="text" id="nama_edit" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="mb-2">Ketua Rapat : </label><br>
                                <select class="form-control select2" id="kepala_edit" style="width: 100%"
                                    required></select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="mb-2">Tanggal :</label>
                                <input type="text" id="tanggal_edit" class="form-control flatpickr"
                                    placeholder="Tanggal Rapat" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="mb-2">Lokasi Rapat :</label>
                                <input type="text" id="lokasi_edit" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="mb-2">Keterangan :</label>
                        <textarea  maxlength="200" rows="3" placeholder="Keterangan terbatas hanya 200 karakter." class="form-control" id="keterangan_edit" ></textarea>
                    </div>
                    <sub><i class="fa-fw fas fa-caret-right nav-icon"></i> Waktu pengubahan berkas rapat hanya berlaku pada
                        hari saat anda mengupload</sub><br>
                    <sub><i class="fa-fw fas fa-caret-right nav-icon"></i> Periksa ulang lampiran berkas anda, apabila
                        terdapat kesalahan upload dokumen mohon hapus dan upload ulang</sub>

                </div>
                <div class="modal-footer">
                    Ditambahkan oleh&nbsp;<a id="user_edit"></a>
                    <button class="btn btn-primary" id="submit_edit" onclick="ubah()"><i
                            class="fa-fw fas fa-save nav-icon"></i> Simpan</button>
                    </form>

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i
                            class="fa-fw fas fa-times nav-icon"></i> Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" id="download" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">File Berkas Rapat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered align-middle">
                            <thead>
                                <tr>
                                    <th><i class="fa-fw fas fa-sort-numeric-down nav-icon"></i> Nama File</th>
                                    <th>Perkiraan Ukuran</th>
                                </tr>
                            </thead>
                            <tbody id="tampil-tbody-file">
                                <tr>
                                    <td colspan="2">
                                        <center><i class="fa fa-spinner fa-spin fa-fw"></i> Memproses data...</center>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <sub><i class="fa-fw fas fa-caret-right nav-icon"></i> File download akan digabungkan dan dikonversikan
                        dalam bentuk <kbd>ZIP FILE</kbd></sub>
                </div>
                <div class="modal-footer">
                    Diupload&nbsp;<a id="tgl_upload"></a>
                    <a type="button" class="btn btn-primary text-white" id="download_btn"><i
                            class="fa fa-download"></i> Download</a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i
                            class="fa-fw fas fa-times nav-icon"></i> Tutup</button>
                </div>
            </div>
        </div>
    </div>
    {{-- MODAL END --}}

    <script>
        $(document).ready(function() {
            // SELECT2
            var t = $(".select2");
            t.length && t.each(function() {
                var e = $(this);
                e.wrap('<div class="position-relative"></div>').select2({
                    placeholder: "Pilih",
                    dropdownParent: e.parent()
                })
            });
            // DATEPICKER
            // DATE
            const today = new Date();
            const tomorrow = new Date(today);
            tomorrow.setDate(tomorrow.getDate() + 1);
            const next = new Date(today);
            next.setDate(next.getDate() + 999999);
            const l = $('.flatpickr');
            // const dates = new Date(Date.now());
            // const tomorow = dates.getTime();
            // const m = new Date(Date.now());
            // const c = new Date(Date.now() + 1728e5); // 3 hari kedepan
            var now = moment().locale('id').format('Y-MM-DD HH:mm');
            l.flatpickr({
                enableTime: !0,
                defaultDate: now,
                minuteIncrement: 1,
                // monthSelectorType: "static",
                // inline: true,
                // defaultHour: 12,
                // defaultMinute: "today",
                time_24hr: true,
                // dateFormat: "Y-m-d H:m",
                disable: [{
                    from: tomorrow.toISOString().split("T")[0],
                    to: next.toISOString().split("T")[0]
                }]
                // ,
                // onChange: function(rawdate, altdate, FPOBJ) {
                //     FPOBJ.close(); // Close datepicker on date select
                //     FPOBJ._input.blur(); // Blur input field on date select
                // }
            })

            // DATETIME
            $('.flatpickrtime').flatpickr({
                enableTime: !0,
                dateFormat: "Y-m-d H:i"
            });

            $.ajax({
                url: "/api/berkas/rapat/data",
                type: 'GET',
                dataType: 'json', // added data type
                success: function(res) {
                    $("#tampil-tbody").empty();
                    var date = new Date().toISOString().split('T')[0];
                    var userID = "{{ Auth::user()->id }}";
                    var adminID = "{{ Auth::user()->getPermission('admin_rapat') }}";
                    var date = getDateTime();
                    res.show.forEach(item => {
                        var updet = item.updated_at.substring(0, 10);
                        content = "<tr id='data" + item.id + "'><td>" +
                            item.id + "</td><td>" +
                            item.nama + "</td><td>" +
                            item.nama_kepala + "</td><td>" +
                            item.tanggal + "</td><td>" +
                            item.lokasi + "</td><td>";
                        if (item.keterangan != null) {
                            content += item.keterangan;
                        }
                        content += '</td><td>' +
                            item.updated_at.substring(0, 19).replace('T',' ') + '</td><td>' +
                            item.nama_user + '</td>';
                        content += `<td><center><div class='btn-group'>
                                        <button type='button' class='btn btn-sm btn-primary btn-icon dropdown-toggle hide-arrow' data-bs-toggle='dropdown' aria-expanded='false'><i class='bx bx-dots-vertical-rounded'></i></button>
                                        <ul class='dropdown-menu dropdown-menu-end'>`;
                        if (adminID == true) {
                            content +=
                                `<li><a href="javascript:void(0);" class='dropdown-item text-success' onclick="showDownload(` +
                                item.id +
                                `)"><i class="fa-fw fas fa-download nav-icon"></i> Download</a></li>
                                                            <li><a href="javascript:void(0);" class='dropdown-item text-warning' onclick="showUbah(` +
                                item.id +
                                `)"><i class="fa-fw fas fa-edit nav-icon"></i> Ubah</a></li>
                                                            <li><a href='javascript:void(0);' class='dropdown-item text-danger' onclick="hapus(` +
                                item.id +
                                `)"><i class="fa-fw fas fa-trash nav-icon"></i> Hapus</a></li>`;
                        } else {
                            if (item.user_id == userID) {
                                if (updet == date) {
                                    content +=
                                        `<li><a href="javascript:void(0);" class='dropdown-item text-success' onclick="showDownload(` +
                                        item.id +
                                        `)"><i class="fa-fw fas fa-download nav-icon"></i> Download</a></li>
                                                                    <li><a href="javascript:void(0);" class='dropdown-item text-warning' onclick="showUbah(` +
                                        item.id +
                                        `)"><i class="fa-fw fas fa-edit nav-icon"></i> Ubah</a></li>
                                                                    <li><a href='javascript:void(0);' class='dropdown-item text-danger' onclick="hapus(` +
                                        item.id +
                                        `)"><i class="fa-fw fas fa-trash nav-icon"></i> Hapus</a></li>`;
                                } else {
                                    content +=
                                        `<li><a href="javascript:void(0);" class='dropdown-item text-success' onclick="showDownload(` +
                                        item.id +
                                        `)"><i class="fa-fw fas fa-download nav-icon"></i> Download</a></li>
                                                                    <li><a href="javascript:void(0);" class='dropdown-item text-secondary'><i class="fa-fw fas fa-edit nav-icon"></i> Ubah</a></li>
                                                                    <li><a href='javascript:void(0);' class='dropdown-item text-secondary'><i class="fa-fw fas fa-trash nav-icon"></i> Hapus</a></li>`;
                                }
                            } else {
                                content +=
                                    `<li><a href="javascript:void(0);" class='dropdown-item text-success' onclick="showDownload(` +
                                    item.id +
                                    `)"><i class="fa-fw fas fa-download nav-icon"></i> Download</a></li>
                                                                <li><a href="javascript:void(0);" class='dropdown-item text-secondary'><i class="fa-fw fas fa-edit nav-icon"></i> Ubah</a></li>
                                                                <li><a href='javascript:void(0);' class='dropdown-item text-secondary'><i class="fa-fw fas fa-trash nav-icon"></i> Hapus</a></li>`;
                            }
                        }
                        content += "</div></center></td></tr>";
                        $('#tampil-tbody').append(content);
                    });
                    var table = $('#dttable').DataTable({
                        order: [
                            [0, "desc"]
                        ],
                        displayLength: 7,
                        lengthChange: true,
                        lengthMenu: [7, 10, 25, 50, 75, 100],
                        buttons: ['copy', 'excel', 'pdf', 'colvis']
                    });

                    table.buttons().container()
                        .appendTo('#dttable_wrapper .col-md-6:eq(0)');
                }
            });
        });

        function getDateTime() {
            var now = new Date();
            var year = now.getFullYear();
            var month = now.getMonth() + 1;
            var day = now.getDate();
            if (month.toString().length == 1) {
                month = '0' + month;
            }
            if (day.toString().length == 1) {
                day = '0' + day;
            }
            var dateTime = year + '-' + month + '-' + day;
            return dateTime;
        }

        function showUbah(id) {
            $("#ubah" + id).prop('disabled', true);
            $("#ubah" + id).find("i").toggleClass("fa-edit fa-sync fa-spin");
            $.ajax({
                url: "/api/berkas/rapat/data/" + id,
                type: 'GET',
                dataType: 'json', // added data type
                success: function(res) {
                    $('#ubah').modal('show');
                    // var dt = new Date(res.show.tanggal).toJSON().slice(0,19);
                    console.log(res.show.tanggal);
                    var dt = moment(res.show.tanggal).format('Y-MM-DD HH:mm');
                    document.getElementById('show_edit').innerHTML = "ID : " + res.show.id;
                    document.getElementById('user_edit').innerHTML = res.show.user_nama;
                    $("#id_edit").val(res.show.id);
                    $("#nama_edit").val(res.show.nama);
                    $("#tanggal_edit").val(dt);
                    $("#lokasi_edit").val(res.show.lokasi);
                    $("#keterangan_edit").val(res.show.keterangan);
                    $("#kepala_edit").find('option').remove();
                    res.kepala.forEach(item => {
                        $("#kepala_edit").append(`
                            <option value="${item.id}" ${item.id == res.show.kepala? "selected":""}>${item.nama}</option>
                        `);
                    });
                    $("#ubah" + id).find("i").removeClass("fa-sync fa-spin").addClass("fa-edit");
                    $("#ubah" + id).prop('disabled', false);
                }
            });
        }

        function ubah() {
            $("#submit_edit").prop('disabled', true);
            $("#submit_edit").find("i").toggleClass("fa-save fa-sync fa-spin");
            var id = $("#id_edit").val();
            var nama = $("#nama_edit").val();
            var kepala = $("#kepala_edit").val();
            var tanggal = $("#tanggal_edit").val();
            var lokasi = $("#lokasi_edit").val();
            var keterangan = $("#keterangan_edit").val();

            if (nama == "" || kepala == "" || tanggal == "") {
                iziToast.error({
                    title: 'Pesan Galat!',
                    message: 'Mohon lengkapi form pengisian',
                    position: 'topRight'
                });
            } else {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: 'POST',
                    url: '/api/berkas/rapat/data/' + id + '/ubah',
                    dataType: 'json',
                    data: {
                        id: id,
                        nama: nama,
                        kepala: kepala,
                        tanggal: tanggal,
                        lokasi: lokasi,
                        keterangan: keterangan,
                    },
                    success: function(res) {
                        if (res) {
                            $('#ubah').modal('hide');
                            // fresh();
                            // $("#tampil-tbody").empty();
                            // content += `<tr><td colspan="9"><center><i class="fa fa-spinner fa-spin fa-fw"></i> Memproses data...</center></td></tr>`;
                            // $('#tampil-tbody').append(content);
                            window.location.reload();
                        }
                        iziToast.success({
                            title: 'Pesan Sukses!',
                            message: 'Berkas Rapat berhasil diubah pada ' + res,
                            position: 'topRight'
                        });
                    }
                });
            }
            $("#submit_edit").find("i").removeClass("fa-sync fa-spin").addClass("fa-save");
            $("#submit_edit").prop('disabled', false);
        }

        function showDownload(id) {
            // $("#ubah"+id).prop('disabled', true);
            // $("#ubah"+id).find("i").toggleClass("fa-edit fa-sync fa-spin");
            $('#download').modal('show');
            $.ajax({
                url: "/api/berkas/rapat/data/" + id + "/download",
                type: 'GET',
                dataType: 'json', // added data type
                success: function(res) {
                    $("#tampil-tbody-file").empty();
                    document.getElementById('tgl_upload').innerHTML = res.tgl_upload;
                    document.getElementById('download_btn').href = "/api/berkas/rapat/data/" + res.id + "/zip";
                    content = "";
                    res.file.forEach(item => {
                        content += "<tr>";
                        content += "<td>" + item.nama + "</td>";
                        content += "<td>" + item.size + " Mb</td>";
                        content += "</tr>";
                    });
                    $('#tampil-tbody-file').append(content);
                }
            });
        }

        function hapus(id) {
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: 'Ingin menghapus Berkas Rapat ID : ' + id,
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
                        url: "/api/berkas/rapat/data/" + id + "/hapus",
                        type: 'GET',
                        dataType: 'json', // added data type
                        success: function(res) {
                            iziToast.success({
                                title: 'Pesan Sukses!',
                                message: 'Berkas telah berhasil dihapus',
                                position: 'topRight'
                            });
                            // fresh();
                            window.location.reload();
                        },
                        error: function(res) {
                            iziToast.error({
                                title: 'Pesan Galat!',
                                message: 'Berkas gagal diupload',
                                position: 'topRight'
                            });
                        }
                    });
                }
            })
        }

        function saveData() {
            $("#tambah").one('submit', function() {
                //stop submitting the form to see the disabled button effect
                let x = document.forms["formTambah"]["tanggal"].value;
                if (x == "") {
                    iziToast.error({
                        title: 'Pesan Galat!',
                        message: 'Mohon isi tanggal rapat',
                        position: 'topRight'
                    });
                    return false;
                } else {
                    $("#btn-simpan").attr('disabled', 'disabled');
                    $("#btn-simpan").find("i").removeClass("fa-upload").addClass("fa-sync fa-spin");
                    return true;
                }
            });
        }
    </script>
@endsection
