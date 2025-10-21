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
                        <li class="breadcrumb-item" aria-current="page">Ubah</li>
                    </ul>
                </div>
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h2 class="mb-0">Form Ubah Jadwal Dinas</h2>
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
                        <h6>Perubahan Jadwal ID : <a class="text-primary">{{ $list["jadwal"]->id }}</a></h6>
                        <h6 class="mb-0">Diajukan Oleh : <a class="text-danger">{{ $list["jadwal"]->nama?$list["jadwal"]->nama:$list["jadwal"]->name }}</a></h6>
                    </div>
                </div>
                <div class="text-center mt-4 mb-3" id="show-loading">
                    <h5><i class="fas fa-sync fa-spin fa-1x me-1"></i> Memproses <b class="text-primary">Jadwal Dinas</b></h5>
                </div>
                <div id="show-jadwal" hidden>
                    <form action="{{ route('kepegawaian.jadwaldinas.prosesUbah') }}" id="formUbah" class="needs-validation mb-0" method="POST" enctype="multipart/form-data" novalidate>
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
                                        {{-- @foreach (json_decode($list['ref_users']->staf) as $item) --}}
                                        @foreach ($list['detail'] as $item)
                                            <tr style="background-color: @if($item->color) {{ $item->color }} @endif">
                                                <td>{{ $n++ }}</td>
                                                <td>
                                                    <input type="text" class="form-control" name="id_staf[]" value="{{ $item->pegawai_id }}" hidden>
                                                    <input type="text" class="form-control" name="nama_staf[]" value="{{ $item->pegawai_nama }}" hidden>
                                                    <input type="text" class="form-control" name="jabatan_staf[]" value="{{ $item->jabatan?$item->jabatan:'' }}" hidden>
                                                    <input type="text" class="form-control" name="color_staf[]" value="{{ $item->color?$item->color:'' }}" hidden>
                                                    <div class='d-flex justify-content-start align-items-center'><div class='d-flex flex-column'><h6 class='mb-0'>{{ $item->nick != null?$item->nick:$item->name }}</h6><small class='text-truncate text-muted'>{{ $item->jabatan?$item->jabatan:'' }}</small></div></div>
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
                                                        $hit = 'tgl'.$i;
                                                    @endphp

                                                    @if ($lnItemb)
                                                        <td class="p-2" style="background-color: {{ $lnItemb->color }}">
                                                    @elseif ($dayb == 'Minggu')
                                                        <td class="p-2" style="background-color: #fed8b9">
                                                    @else
                                                        <td class="p-2">
                                                    @endif
                                                            <input type="text" class="form-control inputTgl text-center clearTxt" maxlength="2" name="tgl{{ $i }}[]" id="{{ $n-1 }}tgl{{ $i }}" value="{{ $item->$hit?$item->$hit:'' }}" placeholder="......." style="padding: 0;border-radius: 0" required>
                                                        </td>
                                                @endfor
                                            </tr>
                                            {{-- @foreach ($list['ref_jabatan'] as $jab)
                                                @if ($jab->id_staf == $item->pegawai_id)
                                                    <tr style="background-color: @if($jab->color) {{ $jab->color }} @endif">
                                                        <td>{{ $n++ }}</td>
                                                        <td>
                                                            <input type="text" class="form-control" name="id_staf[]" value="{{ $item->pegawai_id }}" hidden>
                                                            <input type="text" class="form-control" name="nama_staf[]" value="{{ $item->pegawai_nama }}" hidden>
                                                            <input type="text" class="form-control" name="jabatan_staf[]" value="{{ $item->jabatan?$item->jabatan:'' }}" hidden>
                                                            <input type="text" class="form-control" name="color_staf[]" value="{{ $item->color?$item->color:'' }}" hidden>
                                                            <div class='d-flex justify-content-start align-items-center'><div class='d-flex flex-column'><h6 class='mb-0'>{{ $item->nick != null?$item->nick:$item->name }}</h6><small class='text-truncate text-muted'>{{ $jab->jabatan?$jab->jabatan:'' }}</small></div></div>
                                                        </td>
                                                        @for ($i = 1; $i <= $totalDay; $i++)
                                                            @php
                                                                $dayb = \Carbon\Carbon::create($list['jadwal']->tahun, $list['jadwal']->bulan, $i)->dayName;
                                                                $hit = 'tgl'.$i;
                                                            @endphp
                                                            @if ($dayb == 'Minggu')
                                                                <td class="p-2" style="background-color: #fed8b9">
                                                            @else
                                                                <td class="p-2">
                                                            @endif
                                                                    <input type="text" class="form-control inputTgl text-center clearTxt" maxlength="2" name="tgl{{ $i }}[]" id="{{ $n-1 }}tgl{{ $i }}" value="{{ $item->$hit?$item->$hit:'' }}" placeholder="......." style="padding: 0;border-radius: 0" required>
                                                                </td>
                                                        @endfor
                                                    </tr>
                                                @endif
                                            @endforeach --}}
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="row p-10">
                                <div class="col-md-7">
                                    <div class="alert alert-light">
                                        <h5>Hal-hal yang perlu <b class="text-danger">diperhatikan</b></h5>
                                        <small>
                                            <i class="ti ti-arrow-narrow-right me-1"></i> Apabila terdapat data gagal saat memproses Jadwal, silakan Refresh Browser <br>
                                            <i class="ti ti-arrow-narrow-right me-1"></i> Disarankan melakukan pengisian jadwal dinas menggunakan <b>Device Komputer</b> dan <b>Browser Google Chrome</b> <br>
                                            <i class="ti ti-arrow-narrow-right me-1"></i> Pengisian jadwal wajib menggunakan Kode Shift (e.g. P / S / P6 / etc) menyesuaikan kode shift pada referensi yang sudah ada <br>
                                            <i class="ti ti-arrow-narrow-right me-1"></i> Khusus untuk pengisian <b class="text-success">DL (Dinas Luar)</b> hanya dapat dilakukan saat Absen Dinas Luar pada aplikasi absensi / melalui pengajuan ke bagian SDI<br>
                                            <i class="ti ti-arrow-narrow-right me-1"></i> Penulisan Huruf pada kolom isian Shift Jaga <i><b>Auto Capslock</b></i> meskipun sudah disimpan sekalipun <br>
                                            <i class="ti ti-arrow-narrow-right me-1"></i> Jadwal Dinas akan berpengaruh pada waktu <b>Absensi</b> dikemudian hari, maka dari itu silakan Cek Jadwal kembali sebelum submit<br>
                                            <i class="ti ti-arrow-narrow-right me-1"></i> Apabila terdapat anggota unit yang sudah ditambahkan pada referensi namun belum masuk ke tabel di atas, silakan melengkapi Jabatan dan Urutan pada masing-masing karyawan tersebut <br>
                                            <i class="ti ti-arrow-narrow-right me-1"></i> Pengubahan shift pada jadwal dinas diluar per tanggal 1 sampai dengan sebelum hari ini (Kemarin) akan terkunci oleh Sistem (Tidak dapat diubah lagi)
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
                                <div class="col-md-2">
                                    <h5>Keterangan :</h5>
                                    <div class="list-group">
                                        <label class="list-group-item border-0 p-2">
                                            <a class="btn btn-light me-2" style="background-color: #fed8b9" href="javascript:void(0);"></a>
                                            Hari Minggu
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer p-2">
                            <div class="text-end btn-page mt-2">
                                {{-- <a class="btn btn-link-secondary" id="clear_text" href="javascript:void(0);" onclick="clearInput()">Kosongkan</a> --}}
                                <div class="btn-group">
                                    <a class="btn btn-primary" id="btn-simpan" href="javascript:void(0);" onclick="simpan()"><i class="fas fa-save me-1"></i> Simpan</a>
                                    <a class="btn btn-danger" id="btn-ajukan" href="javascript:void(0);" onclick="ajukan()"><i class="fas fa-stamp me-1"></i> Ajukan</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
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
    {{-- MODAL END --}}

    <script>
        $(document).ready(function() {
            $(".pc-sidebar").addClass("pc-sidebar-hide"); // HIDE NAVBAR

            const today = new Date();
            const currentDate = today.getDate();
            const currentMonth = today.getMonth() + 1; // getMonth() hasilnya 0-11
            const activeMonth = parseInt("{{ $list['jadwal']->bulan }}", 10); // ini variabel dari backend, contoh: 6 untuk Juni
            const totalDay = {{ $totalDay }};
            const currentRowCount = {{ count($list['detail']) }};
            console.log({{ $totalDay }});
            for (let row = 1; row <= currentRowCount; row++) {
                for (let day = 1; day <= totalDay; day++) {
                    const id = `#${row}tgl${day}`;
                    const input = $(id);
                    if (input.length) {
                        // readonly hanya jika bulan aktif adalah bulan sekarang atau sebelumnya
                        if (activeMonth <= currentMonth && day < currentDate && activeMonth === currentMonth) {
                            input.prop('readonly', true).addClass('bg-light text-muted');
                        } else if (activeMonth < currentMonth) {
                            input.prop('readonly', true).addClass('bg-light text-muted');
                        }
                    }
                }
            }

            // SETELAH VALIDASI DI ATAS SELESAI, MEMUNCULKAN INPUT JADWAL
            $('#show-loading').prop('hidden',true);
            $('#show-jadwal').prop('hidden',false);
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
                    $('#formUbah').removeAttr('novalidate');
                    res.detail.forEach(item => { // LOOPING STAF
                        var cuti = 0;
                        for (let i = 1; i <= res.totalDay; i++) { // LOOPING TANGGAL
                            num = $("#"+t+"tgl"+i);
                            if (num.length != 0) {
                                up = num.val();
                                console.log(num);
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
                    $("#formUbah").submit();
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
                    $('.inputTgl').removeAttr('required');
                    $('#formUbah').removeAttr('novalidate');
                    // res.staf.forEach(item => { // LOOPING STAF DARI REF STAF
                    res.detail.forEach(item => { // LOOPING STAF DARI TABLE KEPEGAWAIAN_JADWAL_DETAIL
                        var cuti = 0;
                        for (let i = 1; i <= res.totalDay; i++) { // LOOPING TANGGAL
                            num = $("#"+t+"tgl"+i);
                            // console.log(item.nama_pegawai+' - '+num.val()+' - '+i);
                            if (num.length != 0) {
                                up = num.val();
                                upper = up.toString().toUpperCase();
                                const shiftTambahan = ['L', 'C', 'CM', 'CU', 'CH', 'CD'];
                                const allValidShift = res.shiftArr.concat(shiftTambahan);
                                // console.log(up);
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
                        // console.log(res.detail);
                        console.log('berhasil mengajukan');
                        $("#formUbah").submit();
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

        function backup_of_simpan() {
            $.ajax({
                url: "/api/kepegawaian/jadwaldinas/{{ $list['jadwal']->id }}/shift/user/{{ Auth::user()->id }}",
                type: 'GET',
                dataType: 'json',
                success: function(res) {
                    var adminID = "{{ Auth::user()->getPermission('admin-kepegawaian') }}";
                    var valid = 1;
                    var par = JSON.parse(res.jadwal.staf);
                    var pur = par.toString().split(',');
                    for (let t = 1; t <= par.length; t++) { // LOOPING STAF
                        var cuti = 0;
                        for (let i = 1; i <= res.totalDay; i++) { // LOOPING TANGGAL
                            num = $("#"+t+"tgl"+i);
                            up = num.val();
                            upper = up.toString().toUpperCase();
                            console.log(up+' - '+up);
                            if (res.shiftArr.includes(upper) == 0) {
                                if (upper == 'L' || upper == 'C' || upper == 'CM' || upper == 'CU' || upper == 'CH' || upper == 'CD') {
                                    num.removeClass('is-invalid').addClass('is-valid');
                                } else {
                                    valid = 0;
                                    num.removeClass('is-valid').addClass('is-invalid');
                                }
                            } else {
                                num.removeClass('is-invalid').addClass('is-valid');
                            }
                            if (upper == 'C') {
                                cuti++;
                            }
                        }
                        // VALIDASI CUTI LEBIH DARI 4x DALAM 1 BULAN
                        if (cuti > 4) {
                            res.users.forEach(us => {
                                if (us.id == pur[t-1]) {
                                    notifier.show(
                                        "Pesan Larangan!", "Terdapat Cuti pada karyawan "+us.nama+" yang melebihi 4x dalam sebulan",
                                        "danger", "{{ asset('images/notification/high_priority-48.png') }}", 4e3
                                    );
                                    console.log(us.nama);
                                }
                            })
                            valid = 0;
                        }
                    }
                    // PROSES SUBMIT JADWAL
                    if (valid == 1) {
                        console.log('berhasil');
                        $("#btn-simpan").find("i").toggleClass("fa-save fa-sync fa-spin");
                        $("#btn-simpan").prop('disabled', true);
                        $("#formUbah").submit();
                    } else {
                        console.log('gagal');
                        notifier.show(
                            "Pesan Galat!", "Terdapat beberapa isian yang tidak valid. Mohon cek kembali penulisan Shift Jaga pada setiap isian",
                            "warning", "{{ asset('images/notification/medium_priority-48.png') }}", 4e3
                        );
                    }
                },
                error: function (res) { }
            })
        }

        function clearInput() {
            var jml = parseInt("{{ $list['jml_tgl'] }}",10);
            for (let i = 0; i <= jml; i++) {
                $(".clearTxt").val("");
            }
        }
    </script>
@endsection
