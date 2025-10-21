@extends('layouts.index')

@section('content')

    {{-- FOR DROPDOWN BEHIND CARD --}}
    <style>
        .dropdown {
            transform-style: preserve-3d;
            transform: translate3d(0,0,10px) !important;
        }
    </style>

    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i></a></li>
                        <li class="breadcrumb-item">Kepegawaian</li>
                        <li class="breadcrumb-item" aria-current="page">Surat Tugas</li>
                    </ul>
                </div>
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h2 class="mb-0">Surat Tugas</h2>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- [ breadcrumb ] end -->

    <!-- [ Main Content ] start -->
    <div class="row pt-1">
        <div class="col-xl-12">
            @if (Auth::user()->getPermission(['admin_kepegawaian']) == true)
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between py-3">
                        <h5 class="mb-0">Form Tambah</h5>
                        {{-- @if (Auth::user()->getPermission('admin_surket') == true) --}}
                            <div class="btn-group">
                                {{-- <a href="javascript:void(0);" class="avtar avtar-s btn-link-secondary dropdown-toggle arrow-none" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"><i class="ti ti-dots-vertical f-18"></i></a> --}}
                                {{-- <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0);" onclick="showKategori()">Daftar Kategori</a>
                                    </li>
                                </ul> --}}
                            </div>
                        {{-- @endif --}}
                    </div>
                    <div class="card-body p-b-10">
                        <div class="alert alert-secondary alert-dismissible fade show" role="alert">
                            <small>
                                <i class="ti ti-arrow-narrow-right text-primary me-1"></i> Batas maksimal upload dokumen <b><u>3 mb</u></b> dan hanya berformat <b>PDF</b> <br>
                                <i class="ti ti-arrow-narrow-right text-primary me-1"></i> Pegawai yang ada dalam pilihan di bawah adalah pegawai yang telah selesai melengkapi Profil / Biodata Pegawai <br>
                                <i class="ti ti-arrow-narrow-right text-primary me-1"></i> Pegawai-pegawai yang sudah ditambahkan akan mendapatkan akses download dokumen Surat Tugas tersebut pada masing-masing halaman surat tugas pegawai beserta notifikasi
                                {{-- <i class="ti ti-arrow-narrow-right text-primary me-1"></i>  --}}
                            </small>
                        </div>
                        <div class="row">
                            <div class="col-md-7">
                                <div class="form-group mb-3">
                                    <label class="form-label">Daftar Pegawai <span class="text-danger">*</span></label>
                                    <select class="form-select select2" name="pegawai[]" id="pegawai" style="width: 100%" multiple>
                                        @if (count($list['users']) > 0)
                                            @foreach ($list['users'] as $item)
                                                <option value="{{ $item->id }}">{{ $item->nama?$item->nama:$item->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group mb-3">
                                    <label class="form-label">Upload Dokumen <span class="text-danger">*</span></label>
                                    <div class="row">
                                        <div class="col"><input type="file" class="form-control" id="filex" accept="application/pdf"></div>
                                        <div class="col-auto"><button class="btn btn-primary" onclick="prosesSimpan()" id="btn-simpan"><i class="fas fa-upload me-1"></i> Upload & Share</button></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="card table-card">
                <div class="card-header d-flex align-items-center justify-content-between py-3">
                    <h5 class="mb-0">Riwayat</h5>
                    <div class="btn-group">
                        @if (Auth::user()->getPermission(['admin_kepegawaian']) == true)
                            <a href="javascript:void(0);" class="avtar avtar-s btn-link-warning" onclick="showRiwayatAdmin()"><i class="ti ti-refresh f-20"></i></a>
                        @else
                            <a href="javascript:void(0);" class="avtar avtar-s btn-link-warning" onclick="showRiwayatUser()"><i class="ti ti-refresh f-20"></i></a>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dttable" class="table table-hover dt-responsive align-middle">
                            <thead>
                                <tr>
                                    <th class="cell-fit">#ID</th>
                                    <th class="cell-fit">TANGGAL</th>
                                    <th class="cell-fit">PEGAWAI</th>
                                    <th class="cell-fit">DIPERBARUI</th>
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
                                    <th class="cell-fit">#ID</th>
                                    <th class="cell-fit">TANGGAL</th>
                                    <th class="cell-fit">PEGAWAI</th>
                                    <th class="cell-fit">DIPERBARUI</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL START --}}
    <div class="modal fade animate__animated animate__rubberBand" id="modalUbah" role="dialog" aria-labelledby="confirmFormLabel"aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        Form Ubah
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="text" id="id_edit" hidden>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label class="form-label">Daftar Pegawai <span class="text-danger">*</span></label>
                                <select class="form-select select2" name="pegawai_edit[]" id="pegawai_edit" style="width: 100%" multiple></select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="alert alert-secondary">
                                <div class="form-group mb-3">
                                    <label class="form-label">Nama Dokumen Sebelumnya</label>
                                    <p class="text-primary"><u><a id="show_title"></a></u></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label class="form-label">Upload Dokumen Baru (Apabila Ada / Optional) <span class="text-danger">*</span></label>
                                <input type="file" class="form-control" id="filex_edit" accept="application/pdf">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" onclick="prosesUbah()" id="btn-ubah"><i class="fas fa-upload me-1"></i> Ubah</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal animate__animated animate__rubberBand fade" id="modalHapus" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-simple modal-add-new-address modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        Form Hapus
                    </h4>
                </div>
                <div class="modal-body">
                    <input type="text" id="id_hapus" hidden>
                    <p style="text-align: justify;">Anda akan melakukan penghapusan Berkas Surat Tugas tersebut, lakukanlah dengan hati-hati. Ceklis dibawah untuk melanjutkan penghapusan.</p>
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
                    <button type="reset" class="btn btn-link-secondary" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-times me-1" style="font-size:13px"></i> Batal</button>
                </div>
            </div>
        </div>
    </div>
    {{-- MODAL END --}}

    <script>
        const adminID = "{{ Auth::user()->getPermission(['admin_kepegawaian']) }}";
        $(document).ready(function() {
            // SELECT2
            var t = $(".select2");
            t.length && t.each(function() {
                var e = $(this);
                e.wrap('<div class="position-relative"></div>').select2({
                    placeholder: "Pilih",
                    allowClear: true,
                    dropdownParent: e.parent()
                })
            });

            // $('.select2Tambah').select2({
            //     dropdownParent: $('#tambah')
            // });

            if (adminID) {
                showRiwayatAdmin();
            } else {
                showRiwayatUser();
            }
        });

        function showRiwayatAdmin() {
            $("#tampil-tbody").empty().append(`<tr style='font-size:13px'><td colspan="9"><center><i class="fa fa-spinner fa-spin fa-fw"></i> Memproses data...</center></td></tr>`);
            $.ajax({
                url: "/api/kepegawaian/surtug/table",
                type: 'GET',
                dataType: 'json',
                success: function(res) {
                    // VALIDATION FORM
                    // ------------------------------------------------------
                    $("#tampil-tbody").empty();
                    $('#dttable').DataTable().clear().destroy();
                    res.show.forEach(item => {
                        content = "<tr id='data"+ item.id +"'>";
                        content += `<td><center><div class='dropend'><a href='javascript:void(0);' class='btn btn-light btn-sm text-muted font-size-16 rounded' data-bs-toggle='dropdown' aria-haspopup="true"><i class="ti ti-dots"></i></a><div class='dropdown-menu'>`;
                            if (item.deleted_at == null) {
                                content += `<a href='javascript:void(0);' class='dropdown-item text-primary' onclick="window.open('/kepegawaian/surtug/`+item.id+`/download')"><i class='fas fa-download me-1'></i> Download</a>`;
                                content += `<a href='javascript:void(0);' class='dropdown-item text-warning' onclick="showUbahSurtug(`+item.id+`)" value="animate__rubberBand"><i class='fas fa-trash me-1'></i> Ubah</a>`;
                                content += `<a href='javascript:void(0);' class='dropdown-item text-danger' onclick="showHapusSurtug(`+item.id+`)" value="animate__rubberBand"><i class='fas fa-trash me-1'></i> Hapus</a>`;
                            } else {
                                content += `<a href='javascript:void(0);' class='dropdown-item text-secondary'><i class='fas fa-download me-1'></i> Download</a>`;
                                content += `<a href='javascript:void(0);' class='dropdown-item text-secondary'><i class='fas fa-trash me-1'></i> Hapus</a>`;
                            }
                        content += `</div></center></td>`;
                        content += `<td>${item.tgl}</td>`;
                        content += `<td><small><ul class='list-unstyled mt-2'>`;
                        res.users.forEach(us => {
                            JSON.parse(item.pegawai_id).forEach(val => {
                                if (val == us.id) {
                                    content += `<li><i class="ti ti-arrow-narrow-right me-1"></i>` + us.nama + `</li>`;
                                }
                            })
                        })
                        content += `</small></ul></td>`;
                        // content += `<td>${item.keterangan?item.keterangan:''}</td>`;
                        content += `<td style='white-space: normal !important;word-wrap: break-word;'>
                                        <div class='d-flex justify-content-start align-items-center'>
                                            <div class='d-flex flex-column'>
                                                <a class='mb-0'>` + new Date(item.updated_at).toLocaleString("sv-SE") + `</a>
                                                <small class='text-truncate text-muted'>` + item.nama_user + `</small>
                                            </div>
                                        </div>
                                    </td>`;
                        content += "</tr>";
                        $('#tampil-tbody').append(content);
                    });
                    var table = $('#dttable').DataTable({
                        // dom: 'Bfrtip',
                        order: [
                            [3, "desc"]
                        ],
                        bAutoWidth: false,
                        aoColumns : [
                            { sWidth: '5%' },
                            { sWidth: '7%' },
                            { sWidth: '68%' },
                            { sWidth: '20%' },
                        ],
                        displayLength: 7,
                        lengthChange: true,
                        lengthMenu: [7, 10, 25, 50, 75, 100],
                        // buttons: ['copy', 'excel', 'pdf', 'colvis']
                    });
                }
            })
        }

        function showRiwayatUser() {
            $("#tampil-tbody").empty().append(`<tr style='font-size:13px'><td colspan="9"><center><i class="fa fa-spinner fa-spin fa-fw"></i> Memproses data...</center></td></tr>`);
            $.ajax({
                url: "/api/kepegawaian/surtug/table/{{ Auth::user()->id }}",
                type: 'GET',
                dataType: 'json',
                success: function(res) {
                    // VALIDATION FORM
                    // ------------------------------------------------------
                    $("#tampil-tbody").empty();
                    $('#dttable').DataTable().clear().destroy();
                    res.show.forEach(item => {
                        content = "<tr id='data"+ item.id +"'>";
                        content += `<td><center><div class='dropend'><a href='javascript:void(0);' class='btn btn-light btn-sm text-muted font-size-16 rounded' data-bs-toggle='dropdown' aria-haspopup="true"><i class="ti ti-dots"></i></a><div class='dropdown-menu'>`;
                        content += `<a href='javascript:void(0);' class='dropdown-item text-primary' onclick="window.open('/kepegawaian/surtug/`+item.id+`/download')"><i class='fas fa-download me-1'></i> Download</a>`;
                        content += `</div></center></td>`;
                        content += `<td>${item.tgl}</td>`;
                        content += `<td><small><ul class='list-unstyled mt-2'>`;
                        res.users.forEach(us => {
                            JSON.parse(item.pegawai_id).forEach(val => {
                                if (val == us.id) {
                                    content += `<li><i class="ti ti-arrow-narrow-right me-1"></i>` + us.nama + `</li>`;
                                }
                            })
                        })
                        content += `</small></ul></td>`;
                        // content += `<td>${item.keterangan?item.keterangan:''}</td>`;
                        content += `<td style='white-space: normal !important;word-wrap: break-word;'>
                                        <div class='d-flex justify-content-start align-items-center'>
                                            <div class='d-flex flex-column'>
                                                <a class='mb-0'>` + new Date(item.updated_at).toLocaleString("sv-SE") + `</a>
                                                <small class='text-truncate text-muted'>` + item.nama_user + `</small>
                                            </div>
                                        </div>
                                    </td>`;
                        content += "</tr>";
                        $('#tampil-tbody').append(content);
                    });
                    var table = $('#dttable').DataTable({
                        // dom: 'Bfrtip',
                        order: [
                            [3, "desc"]
                        ],
                        displayLength: 7,
                        lengthChange: true,
                        lengthMenu: [7, 10, 25, 50, 75, 100],
                        // buttons: ['copy', 'excel', 'pdf', 'colvis']
                    });
                }
            })
        }

        function prosesSimpan() {
            $("#btn-simpan").prop('disabled', true);
            $("#btn-simpan").find("i").toggleClass("fa-upload fa-sync fa-spin");

            // Definisi
            var save = new FormData();
            var filesAdded = $('#filex')[0].files;
            save.append('pegawai',JSON.stringify($('#pegawai').val()));
            save.append('user','{{ Auth::user()->id }}');
            if (filesAdded) {
                save.append('file',filesAdded[0]);
            }
            if ($('#pegawai').val() == "" || filesAdded.length == 0 // (Jika Tidak Ada File Yang Diupload)
                ) {
                iziToast.warning({
                    title: 'Pesan Ambigu!',
                    message: 'Pastikan Anda tidak mengosongi semua isian Wajib',
                    position: 'topRight'
                });
            } else {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{route('kepegawaian.surtug.simpan')}}",
                    method: 'post',
                    data: save,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(res) {
                        if (res.code == 200) {
                            notifier.show(
                                "Pesan Sukses!", "Submit Berkas berhasil dilakukan pada "+res.message,
                                "success", "{{ asset('images/notification/ok-48.png') }}", 4e3
                            );
                            if (adminID) {
                                showRiwayatAdmin();
                            } else {
                                showRiwayatUser();
                            }
                            clearInput();
                        } else {
                            notifier.show(
                                "Pesan Galat!", res.message,
                                "warning", "{{ asset('images/notification/medium_priority-48.png') }}", 4e3
                            );
                        }
                    },
                    error: function (res) {
                        notifier.show(
                            res.statusText + " (Code " + res.status + ")", res.responseText,
                            "danger", "{{ asset('images/notification/high_priority-48.png') }}", 4e3
                        );
                    }
                });
            }

            $("#btn-simpan").find("i").removeClass("fa-sync fa-spin").addClass("fa-upload");
            $("#btn-simpan").prop('disabled', false);
        }

        function showUbahSurtug(id) {
            $.ajax(
            {
                url: "/api/kepegawaian/surtug/"+id+"/ubah",
                type: 'GET',
                dataType: 'json',
                success: function(res) {
                    $('#id_edit').val(res.show.id);
                    $('#show_title').text(res.show.title);
                    $("#pegawai_edit").find('option').remove();
                    var un = JSON.parse(res.show.pegawai_id);
                    $("#pegawai_edit").find('option').remove();
                    res.users.forEach(pouch => {
                        selected = '';
                        un.forEach(val => {
                            if (val == pouch.id) {
                                selected = 'selected';
                            }
                        });
                        $("#pegawai_edit").append(`
                            <option value="${pouch.id}" ${selected}>${pouch.nama}</option>
                        `);
                    });
                    $('#modalUbah').modal('show');
                }
            })
        }

        function prosesUbah() {
            $("#btn-ubah").prop('disabled', true);
            $("#btn-ubah").find("i").toggleClass("fa-edit fa-sync fa-spin");

            var save = new FormData();
            var id = $('#id_edit').val();
            var filesAdded = $('#filex_edit')[0].files;
            save.append('id',id);
            save.append('pegawai',JSON.stringify($('#pegawai_edit').val()));
            save.append('user','{{ Auth::user()->id }}');
            if (filesAdded.length > 0) {
                save.append('file', filesAdded[0]);
            }

            if (
                $('#pegawai_edit').val() == ""
            ) {
                iziToast.warning({
                    title: 'Pesan Ambigu!',
                    message: 'Pastikan Anda tidak mengosongi semua isian Wajib',
                    position: 'topRight'
                });
            } else {
                // AJAX request
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "/api/kepegawaian/surtug/"+id+"/prosesubah",
                    method: 'post',
                    data: save,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(res){
                        if (res) {
                            if (res.code == 200) {
                                notifier.show(
                                    "Pesan Sukses!", "Perubahan berhasil dilakukan pada "+res.message,
                                    "success", "{{ asset('images/notification/ok-48.png') }}", 4e3
                                );
                                $('#modalUbah').modal('hide');
                                showRiwayatAdmin();
                                clearInput();
                            } else {
                                notifier.show(
                                    "Pesan Gagal! (Code " + res.code + ")", res.message,
                                    "danger", "{{ asset('images/notification/high_priority-48.png') }}", 4e3
                                );
                            }
                        }
                    },
                    error: function(res){
                        console.log("error : " + JSON.stringify(res) );
                        notifier.show(
                            res.statusText + " (Code " + res.status + ")", res.responseText,
                            "danger", "{{ asset('images/notification/high_priority-48.png') }}", 4e3
                        );
                    }
                });
            }

            $("#btn-ubah").find("i").removeClass("fa-sync fa-spin").addClass("fa-edit");
            $("#btn-ubah").prop('disabled', false);
        }

        function showHapusSurtug(id) {
            $("#id_hapus").val(id);
            var inputs = document.getElementById('setujuhapus');
            inputs.checked = false;
            $('#modalHapus').modal('show');
        }

        function prosesHapus() {
            // SWITCH BTN HAPUS
            var checkboxHapus = $('#setujuhapus').is(":checked");
            if (checkboxHapus == false) {
                iziToast.error({
                    title: 'Pesan Galat!',
                    message: 'Mohon menyetujui untuk dilakukan penghapusan berkas tersebut',
                    position: 'topRight'
                });
            } else {
                // PROSES HAPUS
                var id = $("#id_hapus").val();
                $.ajax({
                    url: "/api/kepegawaian/surtug/"+id+"/hapus",
                    type: 'DELETE',
                    success: function(res) {
                        iziToast.success({
                            title: 'Pesan Sukses!',
                            message: 'Surat Tugas telah berhasil dihapus pada '+res,
                            position: 'topRight'
                        });
                        $('#modalHapus').modal('hide');
                        if (adminID) {
                            showRiwayatAdmin();
                        } else {
                            showRiwayatUser();
                        }
                        clearInput();
                    },
                    error: function(res) {
                        iziToast.error({
                            title: 'Pesan Galat!',
                            message: 'Surat Tugas gagal dihapus',
                            position: 'topRight'
                        });
                    }
                });
            }
        }

        function clearInput() {
            $('#pegawai').val('').change();
            $('#filex').val('');
        }

        // function getDateTime() {
        //     var now = new Date();
        //     var year = now.getFullYear();
        //     var month = now.getMonth() + 1;
        //     var day = now.getDate();
        //     if (month.toString().length == 1) {
        //         month = '0' + month;
        //     }
        //     if (day.toString().length == 1) {
        //         day = '0' + day;
        //     }
        //     var dateTime = year + '-' + month + '-' + day;
        //     return dateTime;
        // }

        // function zeroPad(nr,base){ // 1 => 001 (1,100)
        //     var  len = (String(base).length - String(nr).length)+1;
        //     return len > 0? new Array(len).join('0')+nr : nr;
        // }
    </script>
@endsection
