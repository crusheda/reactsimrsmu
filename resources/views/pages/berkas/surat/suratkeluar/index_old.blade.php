@extends('layouts.default')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Berkas - Surat Keluar</h4>
            </div>
        </div>
    </div>

    <div class="card card-body table-responsive" style="overflow: visible;">
        <div class="d-flex">
            <h4 classs="card-title flex-grow-1">
                <div class="btn-group">
                    <a class="btn btn-primary text-white" data-bs-toggle="modal" data-bs-target="#tambah" value="animate__jackInTheBox">
                        <i class="bx bx-upload scaleX-n1-rtl"></i>
                        <span class="align-middle">Upload</span>
                    </a>
                    <button type="button" class="btn btn-outline-warning" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true"
                        title="<i class='fa-fw fas fa-sync nav-icon'></i> <span>Segarkan</span>" onclick="refresh()">
                        <i class="fa-fw fas fa-sync nav-icon"></i></button>
                </div>
            </h4>
            <div class="ms-auto flex-grow-0">
                <div class="btn-group">
                    <h6 style="margin-top: 10px">Filter</h6>
                    <select class="form-select form-control ms-2" id="kd_bulan" onchange="getSurat()">
                        <option value="0">Pilih Bulan</option>
                        <?php
                            $bulan=array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
                            $jml_bln=count($bulan);
                            for($c=1 ; $c < $jml_bln ; $c+=1){
                                echo"<option value=$c> $bulan[$c] </option>";
                            }
                        ?>
                    </select>
                    <select class="form-select form-control ms-2" id="kd_tahun" onchange="getSurat()">
                        <option value="0">Pilih Tahun</option>
                        @php
                            for ($i=2023; $i <= $list['year']; $i++) {
                                echo"<option value=$i> $i </option>";
                            }

                        @endphp
                    </select>
                </div>
                <div class="float-end ms-2" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="Filter Jenis Surat">
                    <select class="form-control select2" id="kd_surat" onchange="getSurat()">
                        <option value="0" selected>Pilih</option>
                        @if(count($list['kode']) > 0)
                            @foreach($list['kode'] as $item)
                                <option value="{{ $item->id }}"><b>{{ $item->nama }}</b></option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
        </div>
        <hr>
        <table id="dttable" class="table dt-responsive table-hover w-100 align-middle">
            <thead>
                <tr>
                    <th class="cell-fit">
                        <center></center>
                    </th>
                    <th class="cell-fit">NO</th>
                    <th>TGL</th>
                    <th>NO. SURAT</th>
                    <th>ISI RINGKASAN</th>
                    <th>DITUJUKAN KEPADA</th>
                    <th>PEMBUAT SURAT</th>
                    <th>KESESUAIAN</th>
                    <th>UPDATE</th>
                    <th>USER</th>
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
                    <th class="cell-fit">
                        <center></center>
                    </th>
                    <th class="cell-fit">NO</th>
                    <th>TGL</th>
                    <th>NO. SURAT</th>
                    <th>ISI RINGKASAN</th>
                    <th>DITUJUKAN KEPADA</th>
                    <th>PEMBUAT SURAT</th>
                    <th>KES ESUAIAN</th>
                    <th>UPDATE</th>
                    <th>USER</th>
                </tr>
            </tfoot>
        </table>
    </div>

    {{-- MODAL TAMBAH --}}
    <div class="modal fade animate__animated animate__jackInTheBox" id="tambah" role="dialog" aria-labelledby="confirmFormLabel"aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <form class="form-auth-small" name="formTambah" action="{{ route('suratkeluar.store') }}" method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                    <h4 class="modal-title">
                        Form Upload&nbsp;&nbsp;&nbsp;
                    </h4>
                    <div class="card-title-elements">
                      <select class="form-select form-select-sm" name="user" autofocus required>
                        <option value="" hidden>Pilih Petugas</option>
                        <option value="84" selected>Sri Suryani, Amd</option>
                        <option value="293">Zia Nuswantara pahlawan, S.H</option>
                        <option value="88">Siti Dewi Sholikhah</option>
                        <option value="82">Salis Annisa Hafiz, Amd.Kom</option>
                      </select>
                    </div>
                    <div class="card-title-elements" style="margin-left: 10px">
                      <select class="form-select form-select-sm" name="sesuai" required>
                        <option value="" hidden>Pilih Kesesuaian</option>
                        <option value="0">Tidak Sesuai</option>
                        <option value="1">Sesuai</option>
                      </select>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                        @csrf
                        <input type="text" class="form-control" id="tahunlalu" name="tahunlalu" value="0" hidden>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label class="form-label mb-2">Nomor Surat</label>
                                    {{-- <input type="text" class="form-control" placeholder="YYYY-MM-DD" name="tgl_surat" readonly/> --}}
                                    <h5 class="mb-1"><a href="javascript:void(0);" id="urutanNow">{{ $list['urutan'] }}</a><a href="javascript:void(0);" id="urutanLast" hidden>{{ $list['urutanlastyear'] }}</a>/<a id="kd_get" class="text-danger"> . . . </a>/DIR/III.6.AU/PKUSKH/<a href="javascript:void(0);" id="yearNow">{{ $list['year'] }}</a><a href="javascript:void(0);" id="yearLast" hidden>{{ $list['lastyear'] }}</a></h5>
                                    <small>Apabila nomor surat tidak sesuai, silakan klik <a href="javascript:void(0);" onclick="reloadBrowser()"><kbd>REFRESH</kbd></a></small><br>
                                    <small id="btnGantiTahun">Klik <a href="javascript:void(0);" onclick="gantiTahun()"><kbd style="color: white;background-color: darkred">DISINI</kbd></a> untuk mengganti ke tahun sebelumnya</small>
                                </div>
                            </div>
                            <hr>
                            <div class="col-md-8 mb-3">
                                <label class="form-label">Kode/Jenis <a class="text-danger">*</a></label>
                                <select class="form-control select2" name="kode" id="kd_push" style="width: 100%" required>
                                    <option value="">Pilih</option>
                                    @if(count($list['kode']) > 0)
                                        @foreach($list['kode'] as $item)
                                            <option value="{{ $item->id }}"><b>{{ $item->nama }}</b></option>
                                        @endforeach
                                    @endif
                                </select>
                                {{-- <div class="form-group">
                                    <label class="form-label">Kode Surat <a class="text-danger">*</a></label>
                                    <input type="text" name="nomor" class="form-control" placeholder=". . . / . . . / . . ." autofocus required/>
                                </div> --}}
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <label class="form-label">Tanggal <a class="text-danger">*</a></label>
                                    <input type="text" class="form-control flatpickr" placeholder="YYYY-MM-DD" id="tglinp" name="tgl" required/>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label for="select2Dark" class="form-label">Ditujukan Kepada <a class="text-danger">*</a></label>
                                    <button class="btn btn-sm btn-outline-dark" type="button" onclick="ubahTujuan1()" id="btn-manual1">Tulis Manual</button>
                                    <button class="btn btn-sm btn-outline-dark" type="button" onclick="ubahTujuan2()" id="btn-manual2" hidden>Pilihan Karyawan</button>
                                    <div class="select2-dark" id="tujuan1_add">
                                        <select class="select2users form-select" name="tujuan[]" id="tujuan1_add_req" data-allow-clear="true" data-bs-auto-close="outside" style="width: 100%" required multiple>
                                            {{-- <option value="all">Seluruh Karyawan</option> --}}
                                            @if(count($list['users']) > 0)
                                                @foreach($list['users'] as $item)
                                                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <input type="text" name="tujuan2" id="tujuan2_add" class="form-control" placeholder="e.g. Universitas Islam Negeri Sunan Kalijaga Yogyakarta" hidden>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label class="form-label">Pembuat Surat <a class="text-danger">*</a></label>
                                    <input type="text" name="pembuat" id="pembuat_add" class="form-control" placeholder="e.g. Tn. Wat Sit To Yaa" required>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label class="form-label">Isi Surat</label>
                                    <textarea rows="3" class="form-control" name="isi" placeholder="Optional"></textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Upload Berkas Surat (Optional)</label>
                                    <input type="file" class="form-control mb-2" name="file" accept="application/pdf">
                                    <i class="fa-fw fas fa-caret-right nav-icon"></i> Batas ukuran maksimum dokumen adalah <strong>20 mb</strong><br>
                                    <i class="fa-fw fas fa-caret-right nav-icon"></i> File yang diupload berupa Dokumen Scan<br>
                                    <i class="fa-fw fas fa-caret-right nav-icon"></i> Dijadikan dalam Satu file <strong>PDF</strong>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">

                    <button class="btn btn-primary" id="btn-simpan" onclick="saveData()"><i class="fa-fw fas fa-upload nav-icon"></i> Upload</button>
                    </form>

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fa-fw fas fa-times nav-icon"></i> Tutup</button>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL UBAH --}}
    <div class="modal fade animate__animated animate__rubberBand" id="ubah" role="dialog" aria-labelledby="confirmFormLabel"aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        Form&nbsp;&nbsp;&nbsp;
                    </h4>
                    <div class="card-title-elements">
                      <select class="form-select form-select-sm" id="user" required></select>
                    </div>
                    <div class="card-title-elements" style="margin-left: 10px">
                      <select class="form-select form-select-sm" id="sesuai" required></select>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="text" id="id_edit" hidden>
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <div class="form-group">
                                <label class="form-label">Nomor Surat</label>
                                {{-- <input type="text" class="form-control" placeholder="YYYY-MM-DD" name="tgl_surat" readonly/> --}}
                                <h5><a id="push_urutan"></a>/<a id="push_kode" class="text-danger"> . . . </a>/DIR/III.6.AU/PKUSKH/<a id="push_year"></a></h5>
                            </div>
                        </div>
                        <hr>
                        <div class="col-md-8 mb-3">
                            <label class="form-label">Kode/Jenis <a class="text-danger">*</a></label>
                            <select class="form-control select2" id="kode_edit" style="width: 100%" required></select>
                            {{-- <div class="form-group">
                                <label class="form-label">Kode Surat <a class="text-danger">*</a></label>
                                <input type="text" name="nomor" class="form-control" placeholder=". . . / . . . / . . ." autofocus required/>
                            </div> --}}
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <label class="form-label">Tanggal <a class="text-danger">*</a></label>
                                <input type="text" class="form-control flatpickr" placeholder="YYYY-MM-DD" id="tgl_edit" required/>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label for="select2Dark" class="form-label">Ditujukan Kepada <a class="text-danger">*</a></label>
                                <div class="select2-dark" id="tujuan1_edit">
                                    <select class="select2users form-select" id="tujuan1_editselect" data-allow-clear="true" data-bs-auto-close="outside" style="width: 100%" required multiple></select>
                                </div>
                                <input type="text" name="tujuan2" id="tujuan2_edit" class="form-control" placeholder="e.g. Universitas Islam Negeri Sunan Kalijaga Yogyakarta" hidden required>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label class="form-label">Pembuat Surat <a class="text-danger">*</a></label>
                                <input type="text" name="pembuat" id="pembuat_edit" class="form-control" placeholder="e.g. Tn. Wat Sit To Yaa" required>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label class="form-label">Isi Surat</label>
                                <textarea rows="3" class="form-control" id="isi_edit" placeholder="Optional"></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <div id="linksurat"></div>
                                <div id="uploadFileSusulan"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" id="btn-ubah" onclick="ubahAjx()"><i class="fa-fw fas fa-save nav-icon"></i> Simpan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fa-fw fas fa-times nav-icon"></i> Tutup</button>
                </div>
            </div>
        </div>
    </div>

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
                    <p style="text-align: justify;">Anda akan menghapus berkas surat masuk tersebut. Penghapusan berkas akan menyebabkan hilangnya data/dokumen yang terhapus tersebut pada Storage Sistem.
                        Maka dari itu, lakukanlah dengan hati-hati. Ceklis dibawah untuk melanjutkan penghapusan.</p>
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
            $("body").addClass('sidebar-enable vertical-collpsed');

            // SELECT2
            var t = $(".select2");
            t.length && t.each(function() {
                var e = $(this);
                e.wrap('<div class="position-relative"></div>').select2({
                    placeholder: "Pilih",
                    dropdownParent: e.parent()
                })
            });

            // SELECT2 USERS
            var te = $(".select2users");
            te.length && te.each(function() {
                var es = $(this);
                es.wrap('<div class="position-relative"></div>').select2({
                    placeholder: "Pilih Karyawan",
                    dropdownParent: es.parent()
                })
            });

            // DATEPICKER
                // DATE
                const l = $('.flatpickr');
                var now = moment().locale('id').format('Y-MM-DD HH:mm');
                l.flatpickr({
                    enableTime: 0,
                    minuteIncrement: 1,
                    defaultDate: now,
                    time_24hr: true,
                })

            // KODE SURAT
            $('#kd_push').change(function() {
                $.ajax(
                {
                    url: "/api/suratkeluar/getkode/"+$(this).val(),
                    type: 'GET',
                    dataType: 'json', // added data type
                    success: function(res) {
                        $('#kd_get').text(res);
                    }
                })
            });

            $.ajax(
                {
                    url: "/api/suratkeluar/data",
                    type: 'GET',
                    dataType: 'json', // added data type
                    success: function(res) {
                        var adminID = "{{ Auth::user()->hasRole('administrator') }}";
                        $("#tampil-tbody").empty();
                        res.show.forEach(item => {
                            // VALIDASI TUJUAN FROM JSON
                            var us = JSON.parse(res.user);
                            // var updet = item.updated_at.substring(0, 10);
                            // WARNA BUTTON
                            if (item.sesuai == '0') {
                                btnColor = 'btn-outline-danger';
                            } else {
                                if (item.sesuai == '1') {
                                    btnColor = 'btn-outline-primary';
                                } else {
                                    btnColor = 'btn-outline-dark';
                                }
                            }
                            content = "<tr id='data"+ item.id +"'>";
                            content += `<td><center><div class='btn-group'><button type='button' class='btn btn-sm `+btnColor+` btn-icon dropdown-toggle waves-effect waves-light hide-arrow' data-bs-toggle='dropdown' aria-expanded='false'><i class='bx bx-dots-vertical-rounded'></i></button><ul class='dropdown-menu dropdown-menu-right'>`
                                    + `<li><a href='javascript:void(0);' class='dropdown-item text-warning' onclick="showUbah(`+item.id+`)" value="animate__rubberBand"><i class='bx bx-edit scaleX-n1-rtl'></i> Ubah</a></li>`;
                                    if (item.filename != null) {
                                        content += `<li><a href='javascript:void(0);' class='dropdown-item text-primary' onclick="window.open('/berkas/suratkeluar/`+item.id+`/download')"><i class='bx bx-download scaleX-n1-rtl'></i> Download</a></li>`
                                    }
                                    // if (adminID) {
                                        content += `<li><a href='javascript:void(0);' class='dropdown-item text-danger' onclick="hapus(`+item.id+`)" value="animate__rubberBand"><i class='bx bx-trash scaleX-n1-rtl'></i> Hapus</a></li>`;
                                    // }
                            content += `</ul></center></td><td>`;
                                        if (item.pembuat) {
                                            pembuat = item.pembuat;
                                        } else {
                                            pembuat = '-';
                                        }
                            content += item.urutan + "</td><td>"
                                        + item.tgl + "</td><td>"
                                        + "<div class='d-flex justify-content-start align-items-center'><div class='d-flex flex-column'><h6 class='mb-0 text-truncate text-primary'><a href='/berkas/suratkeluar/" + item.id + "/download' data-bs-toggle='tooltip' data-bs-placement='top' data-bs-html='true' title='Unduh Surat'><u>" + item.nomor + "</u></a></h6><small class='text-truncate text-muted'><strong>" + item.kode_jenis + "</strong>&nbsp;-&nbsp;" + item.jenis + "</small><small class='text-truncate text-muted'>Pembuat&nbsp;:&nbsp;" + pembuat + "</small></div></div></td><td>";
                                        if (item.isi) {
                                            content += item.isi;
                                        } else {
                                            content += '-';
                                        }
                            content += "</td><td><ul class='list-unstyled mt-2'>";
                                        if (item.tujuan2 != null) {
                                            content += "<li>" + item.tujuan2 + "</li>";
                                        } else {
                                            var un = JSON.parse(item.tujuan);
                                            for(i = 0; i < un.length; i++){
                                                for(u = 0; u < us.length; u++){
                                                    if (un[i] == us[u].id) {
                                                        content += "<li>- " + us[u].nama + "</li>";
                                                    }
                                                }
                                            }
                                        }
                            content += "</ul></td><td>";
                                if (item.pembuat) {
                                    content += item.pembuat;
                                } else {
                                    content += "-";
                                }
                            content += "</td><td>";
                                if (item.sesuai == 1) {
                                    content += "Sesuai";
                                } else {
                                    if (item.sesuai == 0) {
                                        content += "Tidak Sesuai";
                                    } else {
                                        content += "-";
                                    }
                                }
                            content += "</td><td>" + item.updated_at.substring(0, 19).replace('T',' ') + "</td><td>";
                                        if (item.user == '84') { content += 'Sri Suryani, Amd'; }
                                        if (item.user == '293') { content += 'Zia Nuswantara pahlawan, S.H'; }
                                        if (item.user == '88') { content += 'Siti Dewi Sholikhah'; }
                                        if (item.user == '82') { content += 'Salis Annisa Hafiz, Amd.Kom'; }
                            content += "</td></tr>";
                            $('#tampil-tbody').append(content);
                        });
                        var table = $('#dttable').DataTable({
                            order: [
                                [8, "desc"]
                            ],
                            columnDefs: [
                                { width: "8%", targets: 2 },
                                { width: "40%", targets: 4 },
                                { width: "20%", targets: 5 },
                                { visible: false, targets: [6,7] },
                            ],
                            displayLength: 7,
                            lengthChange: true,
                            lengthMenu: [7, 10, 25, 50, 75, 100],
                            buttons: ['copy', 'excel', 'pdf', 'colvis']
                        });

                        table.buttons().container()
                            .appendTo('#dttable_wrapper .col-md-6:eq(0)');

                        // Showing Tooltip
                        $('[data-bs-toggle="tooltip"]').tooltip({
                            trigger : 'hover'
                        })
                    }
                }
            );
        });

        // FUNCTION-FUNCTION
        function gantiTahun() {
            $("#urutanNow").prop('hidden', true);
            $("#urutanLast").prop('hidden', false);
            $("#yearNow").prop('hidden', true);
            $("#yearLast").prop('hidden', false);
            $("#btnGantiTahun").prop('hidden', true);
            $("#tahunlalu").val(1);
            $("#tglinp").flatpickr().clear();
            $("#tglinp").flatpickr().open();
        }

        function ubahTujuan1() {
            $("#btn-manual1").prop('hidden', true);
            $("#btn-manual2").prop('hidden', false);
            $("#tujuan1_add").prop('hidden', true);
            $("#tujuan1_add_req").prop('required', false);
            $("#tujuan2_add").prop('hidden', false);
            $("#tujuan2_add").prop('required',true);
        }

        function ubahTujuan2() {
            $("#btn-manual1").prop('hidden', false);
            $("#btn-manual2").prop('hidden', true);
            $("#tujuan1_add").prop('hidden', false);
            $("#tujuan1_add_req").prop('required', true);
            $("#tujuan2_add").prop('hidden', true);
            $("#tujuan2_add").prop('required',false);
        }

        function refresh() {
            // $("#kd_surat").val("0").change();
            // $("#kd_bulan").val("0").change();
            // $("#kd_tahun").val("0").change();
            $("#tujuan2_edit").val("");
            $("#tujuan1_editselect").val("");
            $("#isi_edit").val("");
            $("#kode_edit").val("");
            $("#tgl_edit").val("");
            $("#id_edit").val("");
            $("#user").val("");
            // fresh();
            $("#tampil-tbody").empty().append(`<tr><td colspan="9"><center><i class="fa fa-spinner fa-spin fa-fw"></i> Memproses data...</center></td></tr>`);
            $.ajax(
                {
                    url: "/api/suratkeluar/data",
                    type: 'GET',
                    dataType: 'json', // added data type
                    success: function(res) {
                        var adminID = "{{ Auth::user()->hasRole('administrator') }}";
                        $("#tampil-tbody").empty();
                        $('#dttable').DataTable().clear().destroy();
                        res.show.forEach(item => {
                            var us = JSON.parse(res.user);
                            // var updet = item.updated_at.substring(0, 10);
                            // WARNA BUTTON
                            if (item.sesuai == '0') {
                                btnColor = 'btn-outline-danger';
                            } else {
                                if (item.sesuai == '1') {
                                    btnColor = 'btn-outline-primary';
                                } else {
                                    btnColor = 'btn-outline-dark';
                                }
                            }
                            content = "<tr id='data"+ item.id +"'>";
                            content += `<td><center><div class='btn-group'><button type='button' class='btn btn-sm `+btnColor+` btn-icon dropdown-toggle waves-effect waves-light hide-arrow' data-bs-toggle='dropdown' aria-expanded='false'><i class='bx bx-dots-vertical-rounded'></i></button><ul class='dropdown-menu dropdown-menu-right'>`
                                    + `<li><a href='javascript:void(0);' class='dropdown-item text-warning' onclick="showUbah(`+item.id+`)" value="animate__rubberBand"><i class='bx bx-edit scaleX-n1-rtl'></i> Ubah</a></li>`;
                                    if (item.filename != null) {
                                        content += `<li><a href='javascript:void(0);' class='dropdown-item text-primary' onclick="window.open('/berkas/suratkeluar/`+item.id+`/download')"><i class='bx bx-download scaleX-n1-rtl'></i> Download</a></li>`
                                    }
                                    // if (adminID) {
                                        content += `<li><a href='javascript:void(0);' class='dropdown-item text-danger' onclick="hapus(`+item.id+`)" value="animate__rubberBand"><i class='bx bx-trash scaleX-n1-rtl'></i> Hapus</a></li>`;
                                    // }
                            content += `</ul></center></td><td>`;
                                        if (item.pembuat) {
                                            pembuat = item.pembuat;
                                        } else {
                                            pembuat = '-';
                                        }
                            content += item.urutan + "</td><td>"
                                        + item.tgl + "</td><td>"
                                        + "<div class='d-flex justify-content-start align-items-center'><div class='d-flex flex-column'><h6 class='mb-0 text-truncate text-primary'><a href='/berkas/suratkeluar/" + item.id + "/download' data-bs-toggle='tooltip' data-bs-placement='top' data-bs-html='true' title='Unduh Surat'><u>" + item.nomor + "</u></a></h6><small class='text-truncate text-muted'><strong>" + item.kode_jenis + "</strong>&nbsp;-&nbsp;" + item.jenis + "</small><small class='text-truncate text-muted'>Pembuat&nbsp;:&nbsp;" + pembuat + "</small></div></div></td><td>";
                                        if (item.isi) {
                                            content += item.isi;
                                        } else {
                                            content += '-';
                                        }
                            content += "</td><td><ul class='list-unstyled mt-2'>";
                                        if (item.tujuan2 != null) {
                                            content += "<li>" + item.tujuan2 + "</li>";
                                        } else {
                                            var un = JSON.parse(item.tujuan);
                                            for(i = 0; i < un.length; i++){
                                                for(u = 0; u < us.length; u++){
                                                    if (un[i] == us[u].id) {
                                                        content += "<li>- " + us[u].nama + "</li>";
                                                    }
                                                }
                                            }
                                        }
                            content += "</ul></td><td>";
                                if (item.pembuat) {
                                    content += item.pembuat;
                                } else {
                                    content += "-";
                                }
                            content += "</td><td>";
                                if (item.sesuai == 1) {
                                    content += "Sesuai";
                                } else {
                                    if (item.sesuai == 0) {
                                        content += "Tidak Sesuai";
                                    } else {
                                        content += "-";
                                    }
                                }
                            content += "</td><td>" + item.updated_at.substring(0, 19).replace('T',' ') + "</td><td>";
                                        if (item.user == '84') { content += 'Sri Suryani, Amd'; }
                                        if (item.user == '293') { content += 'Zia Nuswantara pahlawan, S.H'; }
                                        if (item.user == '88') { content += 'Siti Dewi Sholikhah'; }
                                        if (item.user == '82') { content += 'Salis Annisa Hafiz, Amd.Kom'; }
                            content += "</td></tr>";
                            $('#tampil-tbody').append(content);
                        });
                        var table = $('#dttable').DataTable({
                            order: [
                                [8, "desc"]
                            ],
                            columnDefs: [
                                { width: "8%", targets: 2 },
                                { width: "40%", targets: 4 },
                                { width: "20%", targets: 5 },
                                { visible: false, targets: [6,7] },
                            ],
                            displayLength: 7,
                            lengthChange: true,
                            lengthMenu: [7, 10, 25, 50, 75, 100],
                            buttons: ['copy', 'excel', 'pdf', 'colvis']
                        });

                        table.buttons().container()
                        .appendTo('#dttable_wrapper .col-md-6:eq(0)');

                        // Showing Tooltip
                        $('[data-bs-toggle="tooltip"]').tooltip({
                            trigger : 'hover'
                        })
                    }
                }
            );
            $('[data-bs-toggle="tooltip"]').tooltip('hide'); // Remove tooltip after this process have done
        }

        function getSurat() {
            $('[data-bs-toggle="tooltip"]').tooltip('hide');
            $("#tampil-tbody").empty().append(`<tr><td colspan="9"><center><i class="fa fa-spinner fa-spin fa-fw"></i> Memproses data...</center></td></tr>`);
            var surat = $("#kd_surat").val();
            var bulan = $("#kd_bulan").val();
            var tahun = $("#kd_tahun").val();
            $.ajax(
                {
                    url: "/api/suratkeluar/filter/"+surat+"/"+bulan+"/"+tahun,
                    type: 'GET',
                    dataType: 'json', // added data type
                    success: function(res) {
                        var adminID = "{{ Auth::user()->hasRole('administrator') }}";
                        $("#tampil-tbody").empty();
                        $('#dttable').DataTable().clear().destroy();
                        res.show.forEach(item => {
                            // VALIDASI TUJUAN FROM JSON
                            var us = JSON.parse(res.user);
                            // var updet = item.updated_at.substring(0, 10);
                            content = "<tr id='data"+ item.id +"'>";
                            content += `<td><center><div class='btn-group'><button type='button' class='btn btn-sm btn-outline-dark btn-icon dropdown-toggle waves-effect waves-light hide-arrow' data-bs-toggle='dropdown' aria-expanded='false'><i class='bx bx-dots-vertical-rounded'></i></button><ul class='dropdown-menu dropdown-menu-right'>`
                                    + `<li><a href='javascript:void(0);' class='dropdown-item text-warning' onclick="showUbah(`+item.id+`)" value="animate__rubberBand"><i class='bx bx-edit scaleX-n1-rtl'></i> Ubah</a></li>`;
                                    if (item.filename != null) {
                                        content += `<li><a href='javascript:void(0);' class='dropdown-item text-primary' onclick="window.open('/berkas/suratkeluar/`+item.id+`/download')"><i class='bx bx-download scaleX-n1-rtl'></i> Download</a></li>`
                                    }
                                    // if (adminID) {
                                        content += `<li><a href='javascript:void(0);' class='dropdown-item text-danger' onclick="hapus(`+item.id+`)" value="animate__rubberBand"><i class='bx bx-trash scaleX-n1-rtl'></i> Hapus</a></li>`;
                                    // }
                            content += `</ul></center></td><td>`;
                            content += item.urutan + "</td><td>"
                                        + item.tgl + "</td><td>"
                                        + "<div class='d-flex justify-content-start align-items-center'><div class='d-flex flex-column'><h6 class='mb-0 text-truncate text-primary'><a href='/berkas/suratkeluar/" + item.id + "/download' data-bs-toggle='tooltip' data-bs-placement='top' data-bs-html='true' title='Unduh Surat'><u>" + item.nomor + "</u></a></h6><small class='text-truncate text-muted'>" + item.kode_jenis + "&nbsp;-&nbsp;" + item.jenis + "</small></div></div></td><td>";
                                        if (item.isi) {
                                            content += item.isi;
                                        } else {
                                            content += '-';
                                        }
                            content += "</td><td><ul class='list-unstyled mt-2'>";
                                        if (item.tujuan2 != null) {
                                            content += "<li>" + item.tujuan2 + "</li>";
                                        } else {
                                            var un = JSON.parse(item.tujuan);
                                            for(i = 0; i < un.length; i++){
                                                for(u = 0; u < us.length; u++){
                                                    if (un[i] == us[u].id) {
                                                        content += "<li>- " + us[u].nama + "</li>";
                                                    }
                                                }
                                            }
                                        }
                            content += "</ul></td><td>";
                                if (item.pembuat) {
                                    content += item.pembuat;
                                } else {
                                    content += "-";
                                }
                            content += "</td><td>";
                                if (item.sesuai == 1) {
                                    content += "Sesuai";
                                } else {
                                    if (item.sesuai == 0) {
                                        content += "Tidak Sesuai";
                                    } else {
                                        content += "-";
                                    }
                                }
                            content += "</td><td>" + item.updated_at.substring(0, 19).replace('T',' ') + "</td><td>";
                                        if (item.user == '84') { content += 'Sri Suryani, Amd'; }
                                        if (item.user == '293') { content += 'Zia Nuswantara pahlawan, S.H'; }
                                        if (item.user == '88') { content += 'Siti Dewi Sholikhah'; }
                                        if (item.user == '82') { content += 'Salis Annisa Hafiz, Amd.Kom'; }
                            content += "</td></tr>";
                            $('#tampil-tbody').append(content);
                        });
                        var table = $('#dttable').DataTable({
                            order: [
                                [8, "desc"]
                            ],
                            columnDefs: [
                                { width: "8%", targets: 2 },
                                { width: "40%", targets: 4 },
                                { width: "20%", targets: 5 },
                                { visible: false, targets: [6,7] },
                            ],
                            displayLength: 7,
                            lengthChange: true,
                            lengthMenu: [7, 10, 25, 50, 75, 100],
                            buttons: ['copy', 'excel', 'pdf', 'colvis']
                        });

                        table.buttons().container()
                        .appendTo('#dttable_wrapper .col-md-6:eq(0)');

                        // Showing Tooltip
                        $('[data-bs-toggle="tooltip"]').tooltip({
                            trigger : 'hover'
                        })
                    }
                }
            );
            $('[data-bs-toggle="tooltip"]').tooltip('hide');
        }

        function getDateTime() {
            var now     = new Date();
            var year    = now.getFullYear();
            var month   = now.getMonth()+1;
            var day     = now.getDate();
            if(month.toString().length == 1) {
                    month = '0'+month;
            }
            if(day.toString().length == 1) {
                    day = '0'+day;
            }
            var dateTime = year+'-'+month+'-'+day;
            return dateTime;
        }

        function ubahFile(id) {
            $('#linksurat').empty();
            document.getElementById('uploadFileSusulan').innerHTML = `
            <label class='form-label'>Berkas Surat Anda</label>
            <input type='file' id="filex`+id+`" name='filex`+id+`' class="form-control mb-2" accept="application/pdf">
            <input type="text" class="form-control" id="verifberkas`+id+`" hidden>
            <i class="fa-fw fas fa-caret-right nav-icon"></i> Batas ukuran maksimum dokumen adalah <strong>20 mb</strong><br>
            <i class="fa-fw fas fa-caret-right nav-icon"></i> Perubahan file surat akan <strong>mengapus/menimpa</strong> file yang sebelumnya<br>
            <i class="fa-fw fas fa-caret-right nav-icon"></i> File yang diupload berupa Dokumen Scan<br>
            <i class="fa-fw fas fa-caret-right nav-icon"></i> Dijadikan dalam Satu file <strong>PDF</strong>`;
            $("#verifberkas"+id).val(1);
        }

        function showUbah(id) {
            $("#tujuan2_edit").val("");
            $("#tujuan1_editselect").val("");
            $("#pembuat_edit").val("");
            $("#isi_edit").val("");
            $("#kode_edit").val("");
            $("#tgl_edit").val("");
            $("#id_edit").val("");
            $("#user").val("");
            //
            $('#uploadFileSusulan').empty();
            $('#linksurat').empty();
            $.ajax(
            {
                url: "/api/suratkeluar/data/"+id,
                type: 'GET',
                dataType: 'json', // added data type
                success: function(res) {
                    $('#ubah').modal('show');
                    var un = JSON.parse(res.show.tujuan);
                    // var dt = new Date(res.show.tanggal).toJSON().slice(0,19);
                    var dt = moment(res.show.tgl).format('Y-MM-DD HH:mm');
                    if (res.show.filename != null) {
                        document.getElementById('linksurat').innerHTML = `
                        <label class='form-label'>Berkas Surat Anda <a class='text-danger'>*</a></label>&nbsp;&nbsp;
                        <button class='btn btn-sm btn-outline-dark' type='button' onclick='ubahFile(`+id+`)'>Ubah File</button>
                        <h6 class='mb-2'><a href='/berkas/suratkeluar/`+res.show.id+`/download'>`+res.show.title+`</a></h6>
                        <input type="text" class="form-control" id="verifberkas`+res.show.id+`" hidden>`;
                        $("#verifberkas"+res.show.id).val(0);
                    } else {
                        document.getElementById('linksurat').innerHTML = `
                        <label class='form-label'>Berkas Surat Anda</label>
                        <input type='file' id="filex`+res.show.id+`" name='filex`+res.show.id+`' class="form-control mb-2" accept="application/pdf">
                        <input type="text" class="form-control" id="verifberkas`+res.show.id+`" hidden>
                        <i class="fa-fw fas fa-caret-right nav-icon"></i> Batas ukuran maksimum dokumen adalah <strong>20 mb</strong><br>
                        <i class="fa-fw fas fa-caret-right nav-icon"></i> File yang diupload berupa Dokumen Scan<br>
                        <i class="fa-fw fas fa-caret-right nav-icon"></i> Dijadikan dalam Satu file <strong>PDF</strong>`;
                        $("#verifberkas"+res.show.id).val(1);
                    }
                    $("#id_edit").val(res.show.id);

                    // INIT DATE
                        // TGL SURAT EDIT
                        var a = document.querySelector("#tgl_edit");
                        a.flatpickr({
                            enableTime: 0,
                            minuteIncrement: 1,
                            time_24hr: true,
                            defaultDate: res.show.tgl,
                        })

                    $("#push_urutan").text(res.urutan);
                    $("#push_kode").text(res.kode);
                    $("#push_year").text(res.year);
                    if (res.show.tujuan2 !== null) {
                        $("#tujuan1_edit").prop('hidden', true);
                        $("#tujuan2_edit").prop('hidden', false);
                        $("#tujuan2_edit").val(res.show.tujuan2);
                    } else {
                        $("#tujuan1_editselect").find('option').remove();
                        $("#tujuan1_edit").prop('hidden', false);
                        $("#tujuan2_edit").prop('hidden', true);
                        res.users.forEach(pounch => {
                            $("#tujuan1_editselect").append(`
                                <option value="${pounch.id}">${pounch.nama}</option>
                            `);
                        });
                        $("#tujuan1_editselect").val(un).change();
                    }
                    $("#pembuat_edit").val(res.show.pembuat);
                    $("#isi_edit").val(res.show.isi);
                    $("#kode_edit").find('option').remove();
                    res.refkode.forEach(item => {
                        $("#kode_edit").append(`
                            <option value="${item.id}" ${item.id == res.show.kode? "selected":""}>${item.nama}</option>
                        `);
                    });
                    $('#kode_edit').change(function() {
                        $.ajax(
                        {
                            url: "/api/suratkeluar/getkode/"+$(this).val(),
                            type: 'GET',
                            dataType: 'json', // added data type
                            success: function(bowl) {
                                $('#push_kode').text(bowl);
                            }
                        })
                    });
                    $("#user").find('option').remove();
                    $("#user").append(`
                        <option value="84" ${res.show.user == '84' ? "selected":""}>Sri Suryani, Amd</option>
                        <option value="293" ${res.show.user == '293' ? "selected":""}>Zia Nuswantara pahlawan, S.H</option>
                        <option value="88" ${res.show.user == '88' ? "selected":""}>Siti Dewi Sholikhah</option>
                        <option value="82" ${res.show.user == '82' ? "selected":""}>Salis Annisa Hafiz, Amd.Kom</option>
                    `);
                    $("#sesuai").find('option').remove();
                    $("#sesuai").append(`
                        <option value="" ${res.show.sesuai == null ? "selected":""} hidden>Pilih Kesesuaian</option>
                        <option value="0" ${res.show.sesuai == '0' ? "selected":""}>Tidak Sesuai</option>
                        <option value="1" ${res.show.sesuai == '1' ? "selected":""}>Sesuai</option>
                    `);
                }
            }
            );
        }

        function ubahAjx() {
            $("#btn-ubah").prop('disabled', true);
            $("#btn-ubah").find("i").toggleClass("fa-save fa-sync fa-spin");

            var fd = new FormData();
            var id_edit = $("#id_edit").val();

            // Get the selected file
            if ($("#verifberkas"+id_edit).val() == 1) {
                var files = $('#filex'+id_edit)[0].files;
                fd.append('file',files[0]);
            }

            fd.append('id_edit',$("#id_edit").val());
            fd.append('kode',$("#kode_edit").val());
            fd.append('tujuan2',$("#tujuan2_edit").val());
            fd.append('tujuan',$("#tujuan1_editselect").val());
            fd.append('pembuat',$("#pembuat_edit").val());
            fd.append('sesuai',$("#sesuai").val());
            // if ($("#tujuan2_edit").val() != null) {
            // } else {
            // }
            fd.append('tgl',$("#tgl_edit").val());
            fd.append('isi',$("#isi_edit").val());
            fd.append('user',$("#user").val());

            // AJAX request
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('suratkeluar.ubah')}}",
                method: 'post',
                data: fd,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(res){
                    iziToast.success({
                        title: 'Pesan Sukses! ID : '+id_edit,
                        message: 'Surat Keluar berhasil diperbarui pada '+res,
                        position: 'topRight'
                    });
                    if (res) {
                        $('#ubah').modal('hide');
                        refresh();
                    }
                },
                error: function(res){
                    console.log("error : " + JSON.stringify(res) );
                }
            });

            $("#btn-ubah").find("i").removeClass("fa-sync fa-spin").addClass("fa-save");
            $("#btn-ubah").prop('disabled', false);
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
                    message: 'Mohon menyetujui untuk dilakukan penghapusan berkas',
                    position: 'topRight'
                });
            } else {
                // PROSES HAPUS
                var id = $("#id_hapus").val();
                $.ajax({
                    url: "/api/suratkeluar/"+id,
                    type: 'DELETE',
                    success: function(res) {
                        iziToast.success({
                            title: 'Pesan Sukses!',
                            message: 'Berkas telah berhasil dihapus pada '+res,
                            position: 'topRight'
                        });
                        $('#hapus').modal('hide');
                        refresh();
                        // window.location.reload();
                    },
                    error: function(res) {
                        iziToast.error({
                            title: 'Pesan Galat!',
                            message: 'Berkas gagal dihapus',
                            position: 'topRight'
                        });
                    }
                });
            }
        }

        function saveData() {
            $("#tambah").one('submit', function() {
                //stop submitting the form to see the disabled button effect
                $("#btn-simpan").attr('disabled','disabled');
                $("#btn-simpan").find("i").removeClass("fa-upload").addClass("fa-sync fa-spin");
                // $('#tambah').modal('hide');
                // fresh();
                // refresh();
                return true;
            });
        }

        function reloadBrowser() {
            $('.modal').modal('hide');
            window.location.reload();
        }
    </script>
@endsection
