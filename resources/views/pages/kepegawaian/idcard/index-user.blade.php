@extends('layouts.index')

@section('content')

    {{-- FOR DROPDOWN BEHIND CARD --}}
    <style>
        .dropdown {
            /* margin-top: 30%; */
            transform-style: preserve-3d;
            transform: translate3d(0,0,10px) !important;
        }

        /* .dropdown-menu{
            height: auto !important;
            position: relative !important;
            transform: translate3d(0,0,10px) !important;
        } */
    </style>

    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i></a></li>
                        <li class="breadcrumb-item">Kepegawaian</li>
                        <li class="breadcrumb-item">Pengajuan</li>
                        <li class="breadcrumb-item" aria-current="page">ID Card</li>
                    </ul>
                </div>
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h2 class="mb-0">Pengajuan ID Card</h2>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- [ breadcrumb ] end -->

    <!-- [ Main Content ] start -->
    <div class="row pt-1">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-header new-cust-card">
                    <h5>Form Pengajuan</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-12 col-xxl-12">
                            <div class="alert alert-secondary">
                                <small>
                                    <i class="ti ti-arrow-narrow-right me-1"></i> Tidak dapat mengajukan <b>lebih dari 2x</b> apabila masih terdapat pengajuan yang belum Selesai<br>
                                    <i class="ti ti-arrow-narrow-right me-1"></i> Wajib <b>memperbarui/upload</b> Foto Profil terlebih dahulu sebelum mengajukan ID Card<br>
                                    <i class="ti ti-arrow-narrow-right me-1"></i> Mohon mengupload Foto Profil formal untuk kelengkapan proses verifikasi pengajuan, foto yang dimaksud <b>BUKAN</b> berfungsi sebagai foto ID Card<br>
                                    <i class="ti ti-arrow-narrow-right me-1"></i> Proses pengajuan ini terdiri dari 3 tahap yaitu <span class="badge rounded-pill text-bg-primary">Pengajuan</span> ,
                                                                                                                                    <span class="badge rounded-pill text-bg-warning">Dalam Proses</span> ,
                                                                                                                                    <span class="badge rounded-pill text-bg-success">Selesai</span>
                                </small>
                            </div>
                        </div>
                        <div class="col-xl-6 col-xxl-6">
                            <div class="address-check border rounded">
                                <div class="form-check" style="background-image: url(/images/application/img-pay-card-bg.png)">
                                    <input type="radio" name="pengajuan" class="form-check-input input-primary" id="idcard1" value="0">
                                    <label class="form-check-label d-block" for="idcard1">
                                        <span class="card-body p-3 d-block">
                                            <span class="h5 mb-3 d-block">ID Card Baru <a class="text-danger">*</a></span>
                                            <span class="d-flex align-items-center">
                                            <span class="f-12 badge bg-secondary me-3">Rp 0 ,-</span>
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-xxl-6">
                            <div class="address-check border rounded">
                                <div class="form-check" style="background-image: url(/images/application/img-pay-card-bg.png)">
                                    <input type="radio" name="pengajuan" class="form-check-input input-primary" id="idcard2" value="1">
                                    <label class="form-check-label d-block" for="idcard2">
                                        <span class="card-body p-3 d-block">
                                            <span class="h5 mb-3 d-block">Ganti ID Card Lama <a class="text-danger">*</a></span>
                                            <span class="d-flex align-items-center">
                                            <span class="f-12 badge bg-primary me-3">Rp 25.000 ,-</span>
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="divider"><span>Isian Wajib (<a class="text-danger">*</a>)</span></div>
                    <div class="row">
                        <div class="col-12 mt-2">
                            <div class="mb-3 row">
                                <label class="col-lg-4 col-form-label">Nama Lengkap (<mark>+ Gelar</mark>) & Panggilan <a class="text-danger">*</a>
                                    <small class="text-muted d-block">Periksa nama lengkap dan gelar Anda</small>
                                </label>
                                <div class="col-lg-8">
                                    <div class="row">
                                        <div class="col-8">
                                            <input type="text" class="form-control" placeholder="Nama Lengkap" name="nama" value="{{ $list['user']->nama?$list['user']->nama:$list['user']->name }}">
                                        </div>
                                        <div class="col-4">
                                            <input type="text" class="form-control" placeholder="Nama Panggilan" name="panggilan" value="{{ $list['user']->nick }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-lg-4 col-form-label">Nomor Induk Pegawai (<mark>NIP</mark>) <a class="text-danger">*</a>
                                    <small class="text-muted d-block">Konfirmasi kepegawaian apabila nomor <b>NIP</b> kosong</small>
                                </label>
                                <div class="col-lg-8"><input type="text" class="form-control" name="nip" placeholder="Tuliskan NIP" value="{{ $list['user']->nip }}"></div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-lg-4 col-form-label">Jabatan <a class="text-danger">*</a>
                                    <small class="text-muted d-block">Ubah/Sesuaikan Jabatan Anda</small>
                                </label>
                                <div class="col-lg-8"><input type="text" class="form-control" name="jabatan" placeholder="Masukkan Nama Jabatan" value="{{ $list['role']->nama_role2?$list['role']->nama_role2:$list['role']->nama_role }}"></div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-lg-4 col-form-label">Alasan
                                    <small class="text-muted d-block">Tuliskan alasan Anda membuat ID Card</small>
                                </label>
                                <div class="col-lg-8"><textarea class="form-control" id="alasan" name="alasan" rows="2" placeholder="Masukkan Alasan"></textarea></div>
                            </div>
                            <div class="mb-3 row" id="lampiran" hidden>
                                <label class="col-lg-4 col-form-label">Lampiran <a class="text-danger">*</a>
                                    <small class="text-muted d-block">Upload bukti pembayaran (<b>Kwitansi</b>) dari Kasir</small>
                                </label>
                                <div class="col-lg-8"><input type="file" name="filex" id="filex" class="form-control"></div>
                            </div>
                            <div class="text-end btn-page mb-0 mt-4">
                                <button class="btn btn-link-secondary" id="clear_text" onclick="bersihkan()">Kosongkan</button>
                                <button class="btn btn-primary" id="btn-simpan" onclick="ajukan()"><i class="fas fa-stamp me-2"></i> Ajukan Sekarang</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-end mb-3">
                {{-- <button class="btn btn-link-primary"><i class="ti ti-arrow-narrow-left align-text-bottom me-2"></i>Back to Shipping Information</button> --}}
            </div>
        </div>
        <div class="col-xl-4">
            <div class="card">
                <div class="card-header new-cust-card p-3">
                    <div class="d-flex align-items-center">
                        <h5 class="mb-0 card-title flex-grow-1 ms-2">Riwayat Pengajuan</h5>
                        <div class="flex-shrink-0">
                            <a href="javascript:void(0);" class="avtar avtar-s btn-link-warning" onclick="showRiwayat()"><i class="ti ti-refresh f-20"></i></a>
                        </div>
                    </div>
                </div>
                <div data-simplebar style="max-height: 500px;">
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush" id="riwayat_pengajuan">
                            <li class="list-group-item"><center><i class="fa fa-spinner fa-spin fa-fw"></i> Memproses data...</center></li>
                        </ul>
                    </div>
                    <div class="card-footer"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL START --}}
    <div class="modal animate__animated animate__rubberBand fade" id="modalHapus" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-simple modal-add-new-address modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        Form Hapus Pengajuan
                    </h4>
                </div>
                <div class="modal-body">
                    <input type="text" id="id_hapus" hidden>
                    <p style="text-align: justify;">Anda akan menghapus Pengajuan ID Card Saat Ini, lakukanlah dengan hati-hati. Ceklis dibawah untuk melanjutkan penghapusan.</p>
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
    {{-- MODAL END --}}

    <script>
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
            showRiwayat();
            $('input[name="pengajuan"]:radio').change(function () {
                var i = $("input[name='pengajuan']:checked").val();
                if (i != 0) {
                    $('#lampiran').prop('hidden',false);
                } else {
                    $('#lampiran').prop('hidden',true);
                }
            });
        });

        function ajukan() {
            $("#btn-simpan").prop('disabled', true);
            $("#btn-simpan").find("i").toggleClass("fa-stamp fa-sync fa-spin");

            // Definisi
            var save = new FormData();
            save.append('pengajuan',$('input[name="pengajuan"]:checked').val());
            save.append('nama',$('input[name="nama"]').val());
            save.append('panggilan',$('input[name="panggilan"]').val());
            save.append('nip',$('input[name="nip"]').val());
            save.append('jabatan',$('input[name="jabatan"]').val());
            save.append('alasan',$('textarea[name=alasan]').val());
            save.append('pegawai','{{ Auth::user()->id }}');
            if ($('input[name="pengajuan"]:checked').val() == 1) {
                var filesAdded = $('#filex')[0].files;
                save.append('file',filesAdded[0]);
            }

            // console.log(save.get('pengajuan'));
            if (
                $('input[name="pengajuan"]:checked').val() == null ||
                save.get('nama') == "" ||
                save.get('panggilan') == "" ||
                save.get('nip') == "" ||
                save.get('jabatan') == ""
                // || filesAdded.length == 0 // (Jika Tidak Ada File Yang Diupload)
            ) {
                iziToast.warning({
                    title: 'Pesan Ambigu!',
                    message: 'Pastikan Anda tidak mengosongi semua isian Wajib',
                    position: 'topRight'
                });
            } else {
                if ($('input[name="pengajuan"]:checked').val() == 1) {
                    if (filesAdded.length == 0) {
                        iziToast.warning({
                            title: 'Pesan Ambigu!',
                            message: 'Pastikan Anda mengupload kwitansi',
                            position: 'topRight'
                        });
                    } else {
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            method: 'POST',
                            url: '/api/kepegawaian/pengajuan/idcard/tambah',
                            contentType: false,
                            processData: false,
                            dataType: 'json',
                            data: save,
                            success: function(res) {
                                if (res.code == 500) {
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
                                        message: 'Pengajuan ID Card telah berhasil dilakukan pada '+res,
                                        position: 'topRight'
                                    });
                                    bersihkan();
                                    showRiwayat();
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
                } else {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        method: 'POST',
                        url: '/api/kepegawaian/pengajuan/idcard/tambah',
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                        data: save,
                        success: function(res) {
                            if (res.code == 500) {
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
                                    message: 'Pengajuan ID Card telah berhasil dilakukan pada '+res,
                                    position: 'topRight'
                                });
                                bersihkan();
                                showRiwayat();
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

            $("#btn-simpan").find("i").removeClass("fa-sync fa-spin").addClass("fa-stamp");
            $("#btn-simpan").prop('disabled', false);
        }

        function showRiwayat() {
            $("#riwayat_pengajuan").empty().append(
                `<li class="list-group-item"><center><i class="fa fa-spinner fa-spin fa-fw"></i> Memproses data...</center></li>`
            );
            $.ajax({
                url: "/api/kepegawaian/pengajuan/idcard/riwayat/{{ Auth::user()->id }}",
                type: 'GET',
                dataType: 'json',
                success: function(res) {
                    $("#riwayat_pengajuan").empty();
                    if (res.length > 0) {
                        res.forEach(item => {
                            var input = new Date(item.created_at).toLocaleDateString('en-ZA');
                            var date = new Date().toLocaleDateString('en-ZA');
                            if (item.progress == 0) {
                                var status = `<span class="badge rounded-pill text-bg-primary">Pengajuan</span>`;
                            } else {
                                if (item.progress == 1) {
                                    var status = `<span class="badge rounded-pill text-bg-warning">Dalam Proses</span>`;
                                } else {
                                    if (item.progress == 2) {
                                        var status = `<span class="badge rounded-pill text-bg-success">Selesai</span>`;
                                    } else {
                                        var status = `<span class="badge rounded-pill text-bg-danger">Ditolak</span>`;
                                    }
                                }
                            }
                            // DROPDOWN BUTTON
                            if (input == date) {
                                if (item.progress > 0) {
                                    var dropdown = `<a class="dropdown-item text-secondary" href="javascript:void(0);"><i class="fas fa-trash me-2"></i> Hapus</a>`;
                                } else {
                                    var dropdown = `<a class="dropdown-item text-danger" href="javascript:void(0);" onclick="hapus(${item.id})"><i class="fas fa-trash me-2"></i> Hapus</a>`;
                                }
                            } else {
                                var dropdown = `<a class="dropdown-item text-secondary" href="javascript:void(0);"><i class="fas fa-trash me-2"></i> Hapus</a>`;
                            }
                            $('#riwayat_pengajuan').append(`
                                <li class="list-group-item" id="list${item.id}">
                                    <div class="d-flex align-items-start">
                                        <div class="flex-grow-1 mx-2">
                                            <h5 class="mb-1">${item.pengajuan==0?'Pengajuan ID Card Baru':'Penggantian ID Card Lama'} ${status}</h5>
                                            <p class="text-muted text-sm mb-2">${new Date(item.created_at).toLocaleString('en-ZA')}</p>
                                            <h5 class="mb-1">
                                                <b>${item.pengajuan==0?'Rp 0,-':'Rp 25.000,-'}</b>
                                            </h5>
                                        </div>
                                        <a href="javascript:void(0);" class="avtar avtar-s btn-link-secondary dropdown-toggle arrow-none" data-bs-toggle="dropdown" aria-expanded="false"><i class="ti ti-dots-vertical f-20"></i></a>
                                        <ul class="dropdown-menu" style="">${dropdown}</ul>
                                    </div>
                                </li>
                            `);
                        })
                    } else {
                        $("#riwayat_pengajuan").empty().append(
                            `<li class="list-group-item"><center>Belum ada pengajuan</center></li>`
                        );
                    }
                }
            })
        }

        function hapus(id) {
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
                    message: 'Mohon menyetujui untuk dilakukan penghapusan pengajuan tersebut',
                    position: 'topRight'
                });
            } else {
                // PROSES HAPUS
                var id = $("#id_hapus").val();
                $.ajax({
                    url: "/api/kepegawaian/pengajuan/idcard/"+id+"/delete",
                    type: 'DELETE',
                    success: function(res) {
                        iziToast.success({
                            title: 'Pesan Sukses!',
                            message: 'Pengajuan ID Card Anda telah berhasil dihapus pada '+res,
                            position: 'topRight'
                        });
                        $('#modalHapus').modal('hide');
                        showRiwayat();
                    },
                    error: function(res) {
                        iziToast.error({
                            title: 'Pesan Galat!',
                            message: 'Pengajuan ID Card Anda gagal dihapus',
                            position: 'topRight'
                        });
                    }
                });
            }
        }

        function bersihkan() {
            // $('input[name="pengajuan"]').prop('checked', false);
            // $('input[name="nama"]').val('');
            // $('input[name="panggilan"]').val('');
            // $('input[name="nip"]').val('');
            // $('input[name="filex"]').val('');
            // $('textarea[name=alasan]').val('');
            $('#filex').val('');
            $('#alasan').val('');
        }

        // function saveData() {
        //     $("#tambah").one('submit', function() {
        //         $("#btn-simpan").attr('disabled', 'disabled');
        //         $("#btn-simpan").find("i").toggleClass("fa-upload fa-sync fa-spin");
        //         return true;
        //     });
        // }

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
    </script>
@endsection
