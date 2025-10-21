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
                        <li class="breadcrumb-item"><a href="{{ route('kepegawaian.jadwaldinas.index') }}">Jadwal Dinas</a></li>
                        <li class="breadcrumb-item" aria-current="page">Tambah</li>
                    </ul>
                </div>
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h2 class="mb-0">Form Tambah Jadwal Dinas</h2>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- [ breadcrumb ] end -->

    <!-- [ Main Content ] start -->
    <div class="row pt-1">
        <div class="col-xl-12">
            <div class="card table-card mb-0">
                <div class="card-header d-flex align-items-center justify-content-between py-3">
                    <h5 class="mb-0"><button class="btn btn-link-dark" onclick="window.location='{{ route('kepegawaian.jadwaldinas.index') }}'"><i class="fas fa-chevron-left me-2"></i>Kembali</button></h5>
                    <div class="text-end">
                        <h6>Penambahan Jadwal ID : <a class="text-primary">{{ $list["jadwal"]->id }}</a></h6>
                        <h6 class="mb-0">Diajukan Oleh : <a class="text-danger">{{ $list["jadwal"]->nama?$list["jadwal"]->nama:$list["jadwal"]->name }}</a></h6>
                    </div>
                    {{-- <div class="btn-group">
                        <a href="javascript:void(0);" class="avtar avtar-s btn-link-secondary dropdown-toggle arrow-none" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"><i class="ti ti-dots-vertical f-18"></i></a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <li>
                                <a class="dropdown-item" href="javascript:void(0);" onclick="">#</a>
                                <div class="divider pb-1"></div>
                                <a class="dropdown-item" href="javascript:void(0);" onclick="">#</a>
                                <a class="dropdown-item" href="javascript:void(0);" onclick="">#</a>
                            </li>
                        </ul>
                    </div> --}}
                </div>
                <form action="{{ route('kepegawaian.jadwaldinas.prosesTambah') }}" id="formTambah" class="needs-validation mb-0" method="POST" enctype="multipart/form-data" novalidate>
                    @csrf
                    <input type="text" class="form-control" name="id_jadwal" value="{{ $list["jadwal"]->id }}" hidden>
                    <div class="card-body pb-0">
                        @php
                            $bulan = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                            $totalDay = \Carbon\Carbon::create($list['jadwal']->tahun, $list['jadwal']->bulan)->format('t');
                            $n = 1;
                        @endphp
                        <h4 class="text-center p-10 mb-0 mt-2">Bulan
                            @foreach ($bulan as $key => $value)
                                @if ($key == $list['jadwal']->bulan)
                                    <b class="text-primary">{{ $value }}</b>
                                @endif
                            @endforeach Tahun <b class="text-primary">{{ $list['jadwal']->tahun }}</b>
                        </h4>
                        <div class="table-responsive p-10 pb-0">
                            <table id="dttable" class="table table-bordered" style="width: 100%;table-layout: auto">
                                <thead>
                                    <tr>
                                        <th class="text-center" rowspan="2">NO</th>
                                        <th class="text-center" rowspan="2">NAMA</th>
                                        <th class="text-center" colspan="{{ $totalDay }}">TANGGAL</th>
                                    </tr>
                                    <tr>
                                        @for ($i = 1; $i <= $totalDay; $i++)
                                            @php
                                                $dayh = \Carbon\Carbon::create($list['jadwal']->tahun, $list['jadwal']->bulan, $i)->dayName;
                                                $lnItem = null;
                                                if ($list['ref_ln'] && count($list['ref_ln']) > 0) {
                                                    foreach ($list['ref_ln'] as $itemlnh) {
                                                        if ($itemlnh->tgl == $i) {
                                                            $lnItem = $itemlnh;
                                                            break;
                                                        }
                                                    }
                                                }
                                            @endphp

                                            @if ($lnItem)
                                                <th class="p-2 text-center" style="background-color: {{ $lnItem->color }}">{{ sprintf("%02d", $i) }}</th>
                                            @elseif ($dayh == 'Minggu')
                                                <th class="p-2 text-center" style="background-color: #fed8b9">{{ sprintf("%02d", $i) }}</th>
                                            @else
                                                <th class="p-2 text-center">{{ sprintf("%02d", $i) }}</th>
                                            @endif
                                        @endfor
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($list['ref_users'])
                                        @if ($list['ref_jabatan'])
                                            @foreach ($list['ref_jabatan'] as $item)
                                                <tr style="background-color: @if($item->color) {{ $item->color }} @endif">
                                                    <td>{{ $n++ }}</td>
                                                    <td style='white-space: normal !important;word-wrap: break-word;'>
                                                        @foreach ($list['users'] as $val)
                                                            @if ($item->id_staf == $val->id)
                                                                <input type="text" class="form-control" name="id_staf[]" value="{{ $val->id }}" hidden>
                                                                <input type="text" class="form-control" name="nama_staf[]" value="{{ $val->nick != null?$val->nick:$val->name }}" hidden>
                                                                <input type="text" class="form-control" name="jabatan_staf[]" value="{{ $item->jabatan?$item->jabatan:'' }}" hidden>
                                                                <input type="text" class="form-control" name="color_staf[]" value="{{ $item->color?$item->color:'' }}" hidden>
                                                                <div class='d-flex justify-content-start align-items-center'><div class='d-flex flex-column'><h6 class='mb-0'>{{ $val->nick != null?$val->nick:$val->name }}</h6><small class='text-truncate text-muted'>{{ $item->jabatan?$item->jabatan:'' }}</small></div></div>
                                                            @endif
                                                        @endforeach
                                                    </td>
                                                    @for ($i = 1; $i <= $totalDay; $i++)
                                                        @php
                                                            $dayb = \Carbon\Carbon::create($list['jadwal']->tahun, $list['jadwal']->bulan, $i)->dayName;
                                                            $lnItemb = null;
                                                            if ($list['ref_ln'] && count($list['ref_ln']) > 0) {
                                                                foreach ($list['ref_ln'] as $itemlnb) {
                                                                    if ($itemlnb->tgl == $i) {
                                                                        $lnItemb = $itemlnb;
                                                                        break;
                                                                    }
                                                                }
                                                            }
                                                        @endphp

                                                        @if ($lnItemb)
                                                            <td class="p-2 text-center" style="background-color: {{ $lnItemb->color }}">
                                                        @elseif ($dayb == 'Minggu')
                                                            <td class="p-2 text-center" style="background-color: #fed8b9">
                                                        @else
                                                            <td class="p-2 text-center">
                                                        @endif
                                                                <input type="text" class="form-control inputTgl text-center clearTxt" maxlength="2" name="tgl{{ $i }}[]" id="{{ $n-1 }}tgl{{ $i }}" value="" placeholder="......." style="padding: 0;border-radius: 0" required>
                                                            </td>
                                                    @endfor
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="35"><center>Mohon lengkapi Data <b>Jabatan & Urutan</b> Staf pada halaman Referensi Staf terlebih dahulu</center></td>
                                            </tr>
                                        @endif
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="row p-10">
                            <div class="col-md-6">
                                <div class="alert alert-light">
                                    <h5>Hal-hal yang perlu <b class="text-danger">diperhatikan</b></h5>
                                    <small>
                                        <i class="ti ti-arrow-narrow-right me-1"></i> Apabila terdapat data gagal saat memproses Jadwal, silakan Refresh Browser <br>
                                        <i class="ti ti-arrow-narrow-right me-1"></i> Disarankan melakukan pengisian jadwal dinas menggunakan <b>Device Komputer</b> dan <b>Browser Google Chrome</b> <br>
                                        <i class="ti ti-arrow-narrow-right me-1"></i> Pengisian jadwal wajib menggunakan Kode Shift (e.g. P / S / P6 / etc) menyesuaikan kode shift pada referensi yang sudah ada <br>
                                        <i class="ti ti-arrow-narrow-right me-1"></i> Khusus untuk pengisian <b class="text-success">DL (Dinas Luar)</b> hanya dapat dilakukan saat Absen Dinas Luar pada aplikasi absensi / melalui pengajuan ke bagian SDI<br>
                                        <i class="ti ti-arrow-narrow-right me-1"></i> Penulisan Huruf pada kolom isian Shift Jaga <i><b>Auto Capslock</b></i> meskipun sudah disimpan sekalipun <br>
                                        <i class="ti ti-arrow-narrow-right me-1"></i> Jadwal Dinas akan berpengaruh pada waktu <b>Absensi</b> dikemudian hari, maka dari itu silakan Cek Jadwal kembali sebelum submit<br>
                                        <i class="ti ti-arrow-narrow-right me-1"></i> Apabila terdapat anggota unit yang sudah ditambahkan pada referensi namun belum masuk ke tabel di atas, silakan melengkapi Jabatan dan Urutan pada masing-masing karyawan tersebut pada halaman Referensi Staf <a href="{{ route('kepegawaian.jadwaldinas.indexStaf') }}"><u><b>(Klik Disini)</b></u></a>
                                    </small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <h5>Shift Jaga :</h5>
                                <div class="list-group">
                                    <label class="list-group-item border-0 p-2" id="kode-shift">
                                        <ul>
                                            @foreach ($list['ref_shift'] as $item)
                                                <li><b class="me-1">{{ $item->singkat }}</b>(<u>{{ $item->shift }}</u>) : {{ \Carbon\Carbon::parse($item->berangkat)->isoFormat('HH:mm') }} - {{ \Carbon\Carbon::parse($item->pulang)->isoFormat('HH:mm') }} WIB</li>
                                            @endforeach
                                            <li><b class="me-1 text-danger">L</b>(<u class="text-danger">LIBUR</u>)</li>
                                            <li><b class="me-1 text-danger">C</b>(<u class="text-danger">CUTI TAHUNAN</u>)</li>
                                            <li><b class="me-1 text-danger">CM</b>(<u class="text-danger">CUTI MELAHIRKAN</u>)</li>
                                            <li><b class="me-1 text-danger">CU</b>(<u class="text-danger">CUTI UMROH</u>)</li>
                                            <li><b class="me-1 text-danger">CH</b>(<u class="text-danger">CUTI HAJI</u>)</li>
                                            <li><b class="me-1 text-danger">CD</b>(<u class="text-danger">CUTI DILUAR TANGGUNGAN</u>)</li>
                                        </ul>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <h5>Keterangan :</h5>
                                <div class="list-group">
                                    <label class="list-group-item border-0 p-2">
                                        <a class="btn btn-light me-1" style="background-color: #fed8b9" href="javascript:void(0);"></a>
                                        Hari Minggu
                                    </label>
                                    @if ($list['ref_ln'] && count($list['ref_ln']) > 0)
                                        @foreach ($list['ref_ln'] as $item)
                                            <label class="list-group-item border-0 p-2">
                                                <a class="btn btn-light me-1" style="background-color: {{ $item->color }}" href="javascript:void(0);"></a>
                                                {{ $item->deskripsi }} {{ $item->keterangan?'('.$item->keterangan.')':'' }} - Tanggal {{ $item->tgl }}
                                            </label>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer p-3">
                        <div class="text-end btn-page">
                            <a class="btn btn-link-secondary" id="clear_text" href="javascript:void(0);" onclick="clearInput()">Kosongkan</a>
                            <div class="btn-group">
                                <a class="btn btn-dark" id="btn-hapus-jadwal" href="javascript:void(0);" onclick="hapus({{ $list['jadwal']->id }})"><i class="fas fa-trash me-1"></i> Hapus</a>
                                <a class="btn btn-primary" id="btn-simpan" href="javascript:void(0);" onclick="simpan()"><i class="fas fa-save me-1"></i> Simpan</a>
                                <a class="btn btn-danger" id="btn-ajukan" href="javascript:void(0);" onclick="ajukan()"><i class="fas fa-stamp me-1"></i> Ajukan</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- MODAL START --}}
    <div class="modal fade animate__animated animate__rubberBand" id="modalTambah" role="dialog" aria-labelledby="confirmFormLabel"aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        Form Tambah
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-secondary mb-3">
                        <small>
                            {{-- <i class="ti ti-arrow-narrow-right me-1"></i> <br> --}}
                            <i class="ti ti-arrow-narrow-right me-1"></i> Isian bertanda (<a class="text-danger">*</a>) berarti wajib diisi<br>
                            <i class="ti ti-arrow-narrow-right me-1"></i> Batas ukuran file upload maksimal <b class="text-danger">2 mb</b>
                        </small>
                    </div>
                    <div class="position-relative">
                        <label class="form-label">Pilih Bulan dan Tahun</label>
                        <input type="month" class="form-control" value="" placeholder="" id="tgl" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link-secondary" data-bs-dismiss="modal">Batalkan</button>
                    <button class="btn btn-primary" id="btn-tambah" onclick="prosesTambah()"><i class="fa-fw fas fa-chevron-right nav-icon"></i> Lanjutkan</button>
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
                    <p style="text-align: justify;">Anda akan menghapus Jadwal Dinas tersebut, lakukanlah dengan hati-hati. Ceklis dibawah untuk melanjutkan penghapusan.</p>
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
            $(".pc-sidebar").addClass("pc-sidebar-hide"); // HIDE NAVBAR

            // SELECT2
            // var t = $(".select2");
            // t.length && t.each(function() {
            //     var e = $(this);
            //     e.wrap('<div class="position-relative"></div>').select2({
            //         placeholder: "Pilih",
            //         allowClear: true,
            //         dropdownParent: e.parent()
            //     })
            // });

            // $('.select2Tambah').select2({
            //     dropdownParent: $('#tambah')
            // });
            // $('.inputTgl').bind('keypress', onlyInput);
            $('.inputTgl').keypress(function(e) {
                console.log(e.which);
                if(e.which === 47 || e.which === 92 || e.which === 96) {
                    // alert(e.which);
                    // console.log($(this).clear());
                    $(this).val('');
                } else {
                    let input = $(this).val();
                    let cleanedInput = cleanInput(input);
                    $(this).val(cleanedInput);
                }
            });
        });

        function cleanInput(input) {
            // let tests = [/[a-z]/i, /[a-z]/i, /\d/, /\d/, /\d/, /\d/, /\d/, /\d/];
            let tests = [/[a-z]/i, /\d/];
            // let tests2 = [/[a-z]/i, /[a-z]/i];
            for (let i = 0; i < tests.length; i++) {
                console.log(tests[i]);
                if (input[i] == undefined || !tests[i].test(input[i])) {
                    return input.substring(0, i);
                }
            }

            return input.substring(0, tests.length);
        }

        // function checkShift(t) {
        //     if (t.val().length <= 2 ) {
        //         $.ajax({
        //             url: "/api/kepegawaian/jadwaldinas/shift/"+t.val().toUpperCase()+"/user/{{ Auth::user()->id }}",
        //             type: 'GET',
        //             dataType: 'json',
        //             success: function(res) {
        //                 if (res.code == 200) {
        //                     t.val(t.val().toUpperCase());
        //                 } else {
        //                     t.val('');
        //                     notifier.show(
        //                         "Pesan Galat!", res.message,
        //                         "warning", "{{ asset('images/notification/medium_priority-48.png') }}", 4e3
        //                     );
        //                 }
        //             },
        //             error: function (res) { }
        //         });
        //     } else {
        //         t.val('');
        //     }
        // }

        // function onlyInput(event) {
        //     var value = String.fromCharCode(event.which);
        //     var pattern = new RegExp(/[a-zåäö ]/i);
        //     return pattern.test(value);
        // }

        // function tambah() {
        //     $('#modalTambah').modal('show');
        // }

        function simpan() {
            $("#btn-simpan").find("i").removeClass("fa-save").addClass('fa-sync fa-spin');
            $("#btn-simpan").prop('disabled', true);
            $.ajax({
                url: "/api/kepegawaian/jadwaldinas/{{ $list['jadwal']->id }}/shift/user/{{ Auth::user()->id }}",
                type: 'GET',
                dataType: 'json',
                success: function(res) {
                    var adminID = "{{ Auth::user()->getPermission('admin-kepegawaian') }}";
                    var valid = 1;
                    t=1;
                    $('.inputTgl').removeAttr('required');
                    $('#formTambah').removeAttr('novalidate');
                    res.staf.forEach(item => { // LOOPING STAF
                        var cuti = 0;
                        for (let i = 1; i <= res.totalDay; i++) { // LOOPING TANGGAL
                            num = $("#"+t+"tgl"+i);
                            up = num.val();
                            upper = up.toString().toUpperCase();
                            const shiftTambahan = ['L', 'C', 'CM', 'CU', 'CH', 'CD'];
                            const allValidShift = res.shiftArr.concat(shiftTambahan);
                            console.log(up);
                            if (!allValidShift.includes(upper)) {
                                notifier.show(
                                    "Pesan Galat!", "Isian pada karyawan "+item.nama_pegawai+" tanggal "+i+" tidak valid. Mohon cek kembali penulisan Shift Jaga pada isian tersebut",
                                    "warning", "{{ asset('images/notification/medium_priority-48.png') }}", 4e3
                                );
                                valid = 0;
                                num.removeClass('is-valid').addClass('is-invalid');
                            } else if (upper == "DL") {
                                notifier.show(
                                    "Pesan Larangan!", "Terdapat shift [DL] Dinas Luar pada karyawan "+item.nama_pegawai+" di tanggal "+i+", Dinas Luar tidak diizinkan untuk penambahan pada Jadwal Dinas.",
                                    "danger", "{{ asset('images/notification/high_priority-48.png') }}", 4e3
                                );
                                valid = 0;
                                num.removeClass('is-valid').addClass('is-invalid');
                            } else {
                                num.removeClass('is-invalid').addClass('is-valid');
                            }
                            if (upper == 'C') {
                                cuti++;
                            }
                        }
                        // VALIDASI CUTI LEBIH DARI 4x DALAM 1 BULAN
                        if (cuti > 4) {
                            notifier.show(
                                "Pesan Larangan!", "Terdapat Cuti pada karyawan "+item.nama_pegawai+" yang melebihi 4x dalam sebulan",
                                "danger", "{{ asset('images/notification/high_priority-48.png') }}", 4e3
                            );
                            valid = 0;
                        }
                        t++;
                    })
                    $("#formTambah").submit();
                    if (valid != 1) {
                        notifier.show(
                            "Pesan Galat!", "Terdapat beberapa isian yang tidak valid. Mohon cek kembali penulisan Shift Jaga pada setiap isian",
                            "warning", "{{ asset('images/notification/medium_priority-48.png') }}", 4e3
                        );
                    }
                },
                error: function (res) {
                    $("#btn-simpan").find("i").removeClass("fa-sync fa-spin").addClass('fa-save');
                    $("#btn-simpan").prop('disabled', false);
                }
            })
        }

        function ajukan() {
            $("#btn-ajukan").find("i").removeClass("fa-stamp").addClass('fa-sync fa-spin');
            $("#btn-ajukan").prop('disabled', true);
            $.ajax({
                url: "/api/kepegawaian/jadwaldinas/{{ $list['jadwal']->id }}/shift/user/{{ Auth::user()->id }}",
                type: 'GET',
                dataType: 'json',
                success: function(res) {
                    var adminID = "{{ Auth::user()->getPermission('admin-kepegawaian') }}";
                    var valid = 1;
                    t=1;
                    $('.inputTgl').attr('required', true);
                    $('#formTambah').attr('novalidate', true);
                    res.staf.forEach(item => { // LOOPING STAF
                        var cuti = 0;
                        for (let i = 1; i <= res.totalDay; i++) { // LOOPING TANGGAL
                            num = $("#"+t+"tgl"+i);
                            up = num.val();
                            upper = up.toString().toUpperCase();
                            const shiftTambahan = ['L', 'C', 'CM', 'CU', 'CH', 'CD'];
                            const allValidShift = res.shiftArr.concat(shiftTambahan);
                            console.log(up);
                            if (!allValidShift.includes(upper)) {
                                notifier.show(
                                    "Pesan Galat!", "Isian pada karyawan "+item.nama_pegawai+" tanggal "+i+" tidak valid. Mohon cek kembali penulisan Shift Jaga pada isian tersebut",
                                    "warning", "{{ asset('images/notification/medium_priority-48.png') }}", 4e3
                                );
                                valid = 0;
                                num.removeClass('is-valid').addClass('is-invalid');
                            } else if (upper == "DL") {
                                notifier.show(
                                    "Pesan Larangan!", "Terdapat shift [DL] Dinas Luar pada karyawan "+item.nama_pegawai+" di tanggal "+i+", Dinas Luar tidak diizinkan untuk penambahan pada Jadwal Dinas.",
                                    "danger", "{{ asset('images/notification/high_priority-48.png') }}", 4e3
                                );
                                valid = 0;
                                num.removeClass('is-valid').addClass('is-invalid');
                            } else {
                                num.removeClass('is-invalid').addClass('is-valid');
                            }
                            if (upper == 'C') {
                                cuti++;
                            }
                        }
                        // VALIDASI CUTI LEBIH DARI 4x DALAM 1 BULAN
                        if (cuti > 4) {
                            notifier.show(
                                "Pesan Larangan!", "Terdapat Cuti pada karyawan "+item.nama_pegawai+" yang melebihi 4x dalam sebulan",
                                "danger", "{{ asset('images/notification/high_priority-48.png') }}", 4e3
                            );
                            valid = 0;
                        }
                        t++;
                    })
                    if (valid == 1) {
                        console.log('berhasil mengajukan');
                        $("#formTambah").submit();
                    } else {
                        console.log('gagal mengajukan');
                        // notifier.show(
                        //     "Pesan Galat!", "Terdapat beberapa isian yang tidak valid. Mohon cek kembali penulisan Shift Jaga pada setiap isian",
                        //     "warning", "{{ asset('images/notification/medium_priority-48.png') }}", 4e3
                        // );
                        $("#btn-ajukan").find("i").removeClass("fa-sync fa-spin").addClass('fa-stamp');
                        $("#btn-ajukan").prop('disabled', false);
                    }
                },
                error: function (res) {
                    $("#btn-ajukan").find("i").removeClass("fa-sync fa-spin").addClass('fa-stamp');
                    $("#btn-ajukan").prop('disabled', false);
                }
            })
        }

        function clearInput() {
            var jml = parseInt("{{ $list['jml_tgl'] }}",10);
            for (let i = 0; i <= jml; i++) {
                $(".clearTxt").val("");
            }
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
                    message: 'Mohon menyetujui untuk dilakukan penghapusan jadwal dinas tersebut',
                    position: 'topRight'
                });
            } else {
                // PROSES HAPUS
                var id = $("#id_hapus").val();
                $.ajax({
                    url: "/api/kepegawaian/jadwaldinas/"+id+"/hapus",
                    type: 'DELETE',
                    success: function(res) {
                        iziToast.success({
                            title: 'Pesan Sukses!',
                            message: 'Jadwal Dinas Anda telah berhasil dihapus pada '+res,
                            position: 'topRight'
                        });
                        $('#modalHapus').modal('hide');
                        // Redirect setelah delay (misal: 1 detik)
                        setTimeout(function() {
                            window.location.href = "/kepegawaian/jadwaldinas"; // ganti sesuai URL tujuan
                        }, 1000);
                    },
                    error: function(res) {
                        iziToast.error({
                            title: 'Pesan Galat!',
                            message: 'Jadwal Dinas Anda gagal dihapus',
                            position: 'topRight'
                        });
                    }
                });
            }
        }
    </script>
@endsection
