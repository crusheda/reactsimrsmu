@extends('layouts.default')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Pelayanan - Surat Keterangan Lahir</h4>
            </div>
        </div>
    </div>

    <div class="card card-body table-responsive text-nowrap" style="overflow: visible;">
        <div classs="card-title">
            <div class="d-flex">
                <div class="btn-group">
                    <button type="button" class="btn btn-primary" onclick="tambah()" data-bs-toggle="tooltip" data-bs-offset="0,4"
                        data-bs-placement="bottom" data-bs-html="true" title="<span>Tambah Data SKL</span>"
                        value="animate__jackInTheBox">
                        <i class="bx bx-plus scaleX-n1-rtl"></i>
                        <span class="align-middle">Tambah</span>
                    </button>
                    <button type="button" class="btn btn-warning" data-bs-toggle="tooltip" data-bs-offset="0,4"
                        data-bs-placement="bottom" data-bs-html="true" title="<span>Refresh Tabel</span>" onclick="refresh()">
                        <i class="fa-fw fas fa-sync nav-icon"></i></button>
                    <button type="button" class="btn btn-danger" data-bs-toggle="tooltip" data-bs-offset="0,4"
                        data-bs-placement="bottom" id="btn-showall" data-bs-html="true" title="<span>Tampilkan Semua Data SKL</span>" onclick="showAll()">
                        <i class="fa-fw fas fa-history"></i>&nbsp;&nbsp;Riwayat</button>
                </div>
                <div class="hstack gap-3 ms-auto">
                    <div class="btn-group">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-text">NY.</div>
                                <input type="text" class="form-control" id="cari_ibu" placeholder="Tulis Nama Ibu">
                            </div>
                        </div>
                        <button type="button" id="btn-filter" class="btn btn-outline-dark" data-bs-toggle="tooltip" data-bs-offset="0,4"
                            data-bs-placement="bottom" data-bs-html="true" title="<span>Filter Data Berdasarkan Nama Ibu</span>" onclick="filter()">
                            <i class="fas fa-filter fa-sm scaleX-n1-rtl"></i>
                            <span class="align-middle">Filter</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <table id="dttable" class="table dt-responsive table-hover nowrap w-100 align-middle">
            <thead>
                <tr>
                    <th class="cell-fit"></th>
                    <th class="cell-fit">NO SURAT</th>
                    <th class="cell-fit">TGL</th>
                    <th class="cell-fit">IBU</th>
                    <th class="cell-fit">AYAH</th>
                    <th class="cell-fit">ANAK</th>
                    <th class="cell-fit">JK / BB / TB</th>
                    <th class="cell-fit">ALAMAT</th>
                </tr>
            </thead>
            <tbody id="tampil-tbody">
                <tr>
                    <td colspan="10"><center><i class="fa fa-spinner fa-spin fa-fw"></i> Memproses data...</center></td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <th class="cell-fit"></th>
                    <th class="cell-fit">NO SURAT</th>
                    <th class="cell-fit">TGL</th>
                    <th class="cell-fit">IBU</th>
                    <th class="cell-fit">AYAH</th>
                    <th class="cell-fit">ANAK</th>
                    <th class="cell-fit">JK / BB / TB</th>
                    <th class="cell-fit">ALAMAT</th>
                </tr>
            </tfoot>
        </table>
    </div>

    {{-- MODAL START --}}
    <div class="modal fade animate__animated animate__jackInTheBox fade" id="tambah" aria-hidden="true"
        aria-labelledby="modalToggleLabel2" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="form-auth-small" action="{{ route('skl.store') }}" method="POST"
                    enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                {{-- <div class="form-group">
                                        <label>No Surat : </label>
                                        <input type="number" name="no_surat" value="{{ $list['nomer'] }}" class="form-control"
                                            placeholder="" disabled>
                                        <input type="number" name="no_surat" value="{{ $list['nomer'] }}" class="form-control"
                                            placeholder="" hidden>
                                    </div> --}}
                                <div class="form-group">
                                    <label>No Surat : </label>
                                    <div class="input-group">
                                        <button class="btn btn-outline-dark" type="button" id="button_ubah_no_surat"
                                            onclick="ubahNoSurat()">Ubah</button>
                                        <input type="text" class="form-control" id="tampil_no_surat"
                                            value="{{ $list['nomer'] }}" disabled>
                                        <input type="number" name="no_surat" id="save_no_surat"
                                            value="{{ $list['nomer'] }}" class="form-control" placeholder="" hidden
                                            required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8 mb-3">
                                <div class="form-group">
                                    <label>Waktu :</label>
                                    <input type="datetime-local" name="tgl" id="tgl_add" class="form-control"
                                        placeholder="" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label>Nama Ibu : </label>
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text" id="basic-addon34">NY.</span>
                                        <input type="text" class="form-control" name="ibu" id="basic-url3"
                                            aria-describedby="basic-addon34" placeholder="Nama Lengkap Ibu" required />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label>Nama Ayah : </label>
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text" id="basic-addon34">TN.</span>
                                        <input type="text" class="form-control" name="ayah" id="basic-url3"
                                            aria-describedby="basic-addon34" placeholder="Nama Lengkap Ayah" required />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label>Nama Anak : </label>
                                    <input type="text" class="form-control" name="anak" id="basic-url3"
                                        aria-describedby="basic-addon34" placeholder="Nama Lengkap Anak (Bila Ada)" />
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label>Nama Dokter : </label>
                                    <select class="form-control" name="dr" style="width: 100%" required>
                                        <option selected="selected" value="" hidden>Pilih</option>
                                        <option value="1">dr. Gede Sri Dhyana M. A., Sp.OG</option>
                                        <option value="2">dr. H. Ahmad Sutamat, Sp.OG</option>
                                        <option value="3">dr. Febrian Andhika Adiyana, Sp.OG</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="form-group">
                                    <label>Berat Badan : </label>
                                    <div class="input-group input-group-merge">
                                        <input type="number" name="bb"
                                            oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                            maxlength="4" class="form-control" placeholder="..." required>
                                        <span class="input-group-text" id="basic-addon34">gram</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="form-group">
                                    <label>Tinggi Badan : </label>
                                    <div class="input-group input-group-merge">
                                        <input type="number" name="tb"
                                            oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                            maxlength="2" class="form-control" placeholder="..." required>
                                        <span class="input-group-text" id="basic-addon34">cm</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label>Jenis Kelamin</label>
                                    <select name="kelamin" class="form-control select2" style="width: 100%" required>
                                        <option selected="selected" value="" hidden>Pilih</option>
                                        <option value="unknown">Belum Diketahui</option>
                                        <option value="laki-laki">Laki-laki (L)</option>
                                        <option value="perempuan">Perempuan (P)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label>Alamat :</label>
                                    <textarea class="form-control" name="alamat" placeholder="Masukkan Alamat Lengkap" required></textarea>
                                </div>
                            </div>
                        </div>
                        <a><i class="fa-fw fas fa-caret-right nav-icon"></i> Pastikan <b>Nomor Surat</b> sudah sesuai
                            sebelum disimpan</a><br>
                        <a><i class="fa-fw fas fa-caret-right nav-icon"></i> Disarankan untuk menggunakan <b>Huruf
                                Besar/Capital/Uppercase</b> saat pengisian</a>
                    </div>
                    <div class="modal-footer">
                        <a class="btn btn-label-secondary" href="javascript:void(0);" data-bs-dismiss="modal"><i
                                class="fas fa-chevron-left"></i>&nbsp;&nbsp;Tutup</a>
                        <button class="btn btn-primary" id="btn-simpan" onclick="saveData()"><i
                                class="fa fa-save"></i>&nbsp;&nbsp;Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade animate__animated animate__rubberBand fade" id="ubah" data-bs-backdrop="static"
        aria-hidden="true" aria-labelledby="modalToggleLabel2" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ubah Data <small><kbd>ID : <a id="show_id"></a></kbd></small></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="overflow-y:visible;">
                    <input type="text" id="id_edit" hidden>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            {{-- <div class="form-group">
                                    <label>No Surat : </label>
                                    <input type="number" name="no_surat" value="{{ $list['nomer'] }}" class="form-control"
                                        placeholder="" disabled>
                                    <input type="number" name="no_surat" value="{{ $list['nomer'] }}" class="form-control"
                                        placeholder="" hidden>
                                </div> --}}
                            <div class="form-group">
                                <label>No Surat : </label>
                                <input type="text" class="form-control" id="no_surat_edit"
                                    value="" disabled>
                            </div>
                        </div>
                        <div class="col-md-8 mb-3">
                            <div class="form-group">
                                <label>Waktu :</label>
                                <input type="datetime-local" id="tgl_edit" class="form-control" placeholder="">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label>Nama Ibu : </label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text" id="basic-addon34">NY.</span>
                                    <input type="text" class="form-control" id="ibu_edit"
                                        aria-describedby="basic-addon34" placeholder="Nama Lengkap Ibu" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label>Nama Ayah : </label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text" id="basic-addon34">TN.</span>
                                    <input type="text" class="form-control" id="ayah_edit"
                                        aria-describedby="basic-addon34" placeholder="Nama Lengkap Ayah" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label>Nama Anak : </label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text" id="basic-addon34">BY.</span>
                                    <input type="text" class="form-control" id="anak_edit"
                                        aria-describedby="basic-addon34" placeholder="Nama Lengkap Anak (Bila Ada)" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label>Nama Dokter : </label>
                                <select class="form-control" id="dr_edit" style="width: 100%;"
                                    required></select>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="form-group">
                                <label>Berat Badan : </label>
                                <div class="input-group input-group-merge">
                                    <input type="number" id="bb_edit"
                                        oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                        maxlength="4" class="form-control" placeholder="..." required>
                                    <span class="input-group-text" id="basic-addon34">gram</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="form-group">
                                <label>Tinggi Badan : </label>
                                <div class="input-group input-group-merge">
                                    <input type="number" id="tb_edit"
                                        oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                        maxlength="2" class="form-control" placeholder="..." required>
                                    <span class="input-group-text" id="basic-addon34">cm</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label>Jenis Kelamin</label>
                                <select class="form-control select2" id="kelamin_edit" style="width: 100%;z-index: 9999!important;"></select>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label>Alamat :</label>
                                <textarea class="form-control" id="alamat_edit" placeholder="Masukkan Alamat Lengkap"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-label-secondary" href="javascript:void(0);" data-bs-dismiss="modal"><i
                            class="fas fa-chevron-left"></i>&nbsp;&nbsp;Tutup</a>
                    <button class="btn btn-primary" type="submit" id="submit_edit" onclick="ubah()"><i
                            class="fa fa-save"></i>&nbsp;&nbsp;Simpan</button>
                </div>
            </div>
        </div>
    </div>
    {{-- MAINTENANCE --}}
    <div class="modal fade animate__animated animate__lightSpeedIn" id="maintenance" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-simple modal-enable-otp modal-dialog-centered">
            <div class="modal-content p-3 p-md-5">
                <div class="modal-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="text-center">
                        <h3 class="mb-4">Ubah Identitas Bayi</h3>
                    </div>
                    <center>
                        <h6>Kami sedang dalam perbaikan Sistem SKL</h6>
                        <h6>Tunggu beberapa saat lagi...</h6>
                        <hr>
                        <p>Untuk sementara, perubahan identitas bayi dapat dilakukan dengan cara penghapusan data lalu input
                            ulang.</p>
                    </center>
                </div>
            </div>
        </div>
    </div>
    {{-- MODAL END --}}

    <script>
        $(document).ready(function() {

            // TGL ADD
            const l = document.querySelector("#tgl_add");
            const c = new Date(Date.now() + 1728e5),
                m = new Date(Date.now());
            var today = moment().locale('id').format('Y-MM-DD HH:mm');
            console.log(today);
            l.flatpickr({
                enableTime: !0,
                defaultDate: today,
                minuteIncrement: 1,
                // inline: true,
                // defaultHour: 12,
                // defaultMinute: "today",
                time_24hr: true,
                // dateFormat: "Y-m-d H:m",
                disable: [{
                    from: c.toISOString().split("T")[0],
                    to: "3000-01-01"
                }]
            })

            // AJAX TABLE GET
            $.ajax({
                url: "/api/kebidanan/skl/get",
                type: 'GET',
                dataType: 'json', // added data type
                success: function(res) {
                    $("#tampil-tbody").empty();
                    res.show.forEach(item => {
                        // var updet = item.updated_at.substring(0, 10);
                        content = `<tr id='data"+ item.id +"'>`;
                        content +=
                            `<td><center><div class='btn-group'><button type='button' class='btn btn-sm btn-primary btn-icon dropdown-toggle hide-arrow' data-bs-toggle='dropdown' aria-expanded='false' value="animate__rubberBand"><i class='bx bx-dots-vertical-rounded'></i></button><ul class='dropdown-menu dropdown-menu-right'>` +
                            `<li><a href='javascript:void(0);' class='dropdown-item text-warning' onclick="showUbah(` +
                            item.id +
                            `)"><i class='bx bx-edit scaleX-n1-rtl'></i> Ubah</a></li>` +
                            `<li><a href='javascript:void(0);' class='dropdown-item text-info' onclick="window.open('/pelayanan/kebidanan/skl/` +
                            item.id +
                            `/print','id','width=900,height=600')"><i class='bx bx-printer scaleX-n1-rtl'></i> Cetak</a></li>` +
                            `<li><a href='javascript:void(0);' class='dropdown-item text-primary' onclick="window.open('/pelayanan/kebidanan/skl/` +
                            item.id +
                            `/cetak')"><i class='bx bx-download scaleX-n1-rtl'></i> Download</a></li>` +
                            `<li><a href='javascript:void(0);' class='dropdown-item text-danger' onclick="hapus(` +
                            item.id +
                            `)"><i class='bx bx-trash scaleX-n1-rtl'></i> Hapus</a></li>` +
                            `</ul></center></td><td>`;
                        content += item.no_surat + "</td><td>" +
                            item.tgl + "</td><td>" +
                            item.ibu + "</td><td>" +
                            item.ayah + "</td><td>";
                        if (item.anak == null)
                            content += "";
                        else
                            content += item.anak;
                        content += "</td><td>";
                        if (item.kelamin == "unknown")
                            content += "<kbd style='background-color: #000000'>-</kbd>&nbsp;";
                        if (item.kelamin == "laki-laki")
                            content += "<kbd style='background-color: #3298FF'>L</kbd>&nbsp;";
                        if (item.kelamin == "perempuan")
                            content += "<kbd style='background-color: #00898E'>P</kbd>&nbsp;";
                        content +=  " / " + item.bb + " / " + item.tb + "</td><td>" +
                            item.alamat + "</td>";
                        content += `</tr>`;
                        $('#tampil-tbody').append(content);
                    });
                    var table = $('#dttable').DataTable({
                        order: [
                            [1, "desc"]
                        ],
                        displayLength: 7,
                        lengthChange: true,
                        lengthMenu: [7, 10, 25, 50, 75, 100],
                        buttons: ['copy', 'excel', 'pdf', 'colvis']
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

            // VALIDASI INPUT NUMBER
            $('input[type=number][max]:not([max=""])').on('input', function(ev) {
                var $this = $(this);
                var maxlength = $this.attr('max').length;
                var value = $this.val();
                if (value && value.length >= maxlength) {
                    $this.val(value.substr(0, maxlength));
                }
            });
            $('#rm').change(function() {
                if (this.value == '') {
                    $("#nama1").val("");
                    $("#nama2").val("");
                    $("#jns_kelamin1").val("");
                    $("#jns_kelamin2").val("");
                    $("#umur2").val("");
                    $("#umur1").val("");
                    $("#alamat1").val("");
                    $("#alamat2").val("");
                    $("#des").val("");
                    $("#kec").val("");
                    $("#kab").val("");
                } else {
                    if (this.value.length == 4) {
                        this.value = '0000' + this.value;
                    }
                    if (this.value.length == 5) {
                        this.value = '000' + this.value;
                    }
                    if (this.value.length == 6) {
                        this.value = '00' + this.value;
                    }
                    if (this.value.length < 4) {
                        this.value = this.value;
                    }
                    $.ajax({
                        // url: "http://192.168.1.3:8000/api/all/"+this.value,
                        url: "/api/antigen/getpasien/" + this.value,
                        type: 'GET',
                        dataType: 'json', // added data type
                        success: function(res) {
                            // console.log(res);
                            $("#nama1").val(res.NAMAPASIEN);
                            $("#nama2").val(res.NAMAPASIEN);
                            $("#jns_kelamin1").val(res.JNSKELAMIN);
                            $("#jns_kelamin2").val(res.JNSKELAMIN);
                            $("#umur1").val(res.UMUR);
                            $("#umur2").val(res.UMUR);
                            $("#alamat1").val(res.ALAMAT);
                            $("#alamat2").val(res.ALAMAT);

                            $("#des").val(res.DESA);
                            $("#kec").val(res.KECAMATAN);
                            $("#kab").val(res.NAMA_KABKOTA);
                            // $('#jumlah20').attr('required', true);
                        }
                    });
                }
            });

        })

        // FUNCTION
        function filter() {
            var kunci = $("#cari_ibu").val();
            if (kunci == '') {
                iziToast.warning({
                    title: 'Pesan Ambigu!',
                    message: 'Filter Nama Ibu belum diisi',
                    position: 'topRight'
                });
                $('#btn-filter').tooltip('hide');
            } else {
                $("#tampil-tbody").empty().append(
                    `<tr><td colspan="10"><center><i class="fa fa-spinner fa-spin fa-fw"></i> Memproses data...</center></td></tr>`);
                $.ajax({
                    url: "/api/kebidanan/skl/cari/"+kunci,
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
                                `<li><a href='javascript:void(0);' class='dropdown-item text-warning' onclick="showUbah(` +
                                item.id +
                                `)"><i class='bx bx-edit scaleX-n1-rtl'></i> Ubah</a></li>` +
                                `<li><a href='javascript:void(0);' class='dropdown-item text-info' onclick="window.open('/pelayanan/kebidanan/skl/` +
                                item.id +
                                `/print','id','width=900,height=600')"><i class='bx bx-printer scaleX-n1-rtl'></i> Cetak</a></li>` +
                                `<li><a href='javascript:void(0);' class='dropdown-item text-primary' onclick="window.open('/pelayanan/kebidanan/skl/` +
                                item.id +
                                `/cetak')"><i class='bx bx-download scaleX-n1-rtl'></i> Download</a></li>` +
                                `<li><a href='javascript:void(0);' class='dropdown-item text-danger' onclick="hapus(` +
                                item.id +
                                `)"><i class='bx bx-trash scaleX-n1-rtl'></i> Hapus</a></li>` +
                                `</ul></center></td><td>`;
                            content += item.no_surat + "</td><td>" +
                                item.tgl + "</td><td>" +
                                item.ibu + "</td><td>" +
                                item.ayah + "</td><td>";
                            if (item.anak == null)
                                content += "";
                            else
                                content += item.anak;
                            content += "</td><td>";
                            if (item.kelamin == "unknown")
                                content += "<kbd style='background-color: #000000'>-</kbd>&nbsp;";
                            if (item.kelamin == "laki-laki")
                                content += "<kbd style='background-color: #3298FF'>L</kbd>&nbsp;";
                            if (item.kelamin == "perempuan")
                                content += "<kbd style='background-color: #00898E'>P</kbd>&nbsp;";
                            content +=  " / " + item.bb + " / " + item.tb + "</td><td>" +
                                item.alamat + "</td>";
                            content += `</tr>`;
                            $('#tampil-tbody').append(content);
                        });
                        var table = $('#dttable').DataTable({
                            order: [
                                [1, "desc"]
                            ],
                            displayLength: 7,
                            lengthChange: true,
                            lengthMenu: [7, 10, 25, 50, 75, 100],
                            buttons: ['copy', 'excel', 'pdf', 'colvis']
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
                $('#btn-filter').tooltip('hide');
            }
        }

        function showAll() {
            $("#btn-showall").prop('disabled', true);
            $("#btn-showall").find("i").toggleClass("fa-history fa-spinner fa-spin");
            $("#tampil-tbody").empty().append(
                `<tr><td colspan="10"><center><i class="fa fa-spinner fa-spin fa-fw"></i> Memproses data...</center></td></tr>`);
            $.ajax({
                url: "/api/kebidanan/skl/all/",
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
                            `<li><a href='javascript:void(0);' class='dropdown-item text-warning' onclick="showUbah(` +
                            item.id +
                            `)"><i class='bx bx-edit scaleX-n1-rtl'></i> Ubah</a></li>` +
                            `<li><a href='javascript:void(0);' class='dropdown-item text-info' onclick="window.open('/pelayanan/kebidanan/skl/` +
                            item.id +
                            `/print','id','width=900,height=600')"><i class='bx bx-printer scaleX-n1-rtl'></i> Cetak</a></li>` +
                            `<li><a href='javascript:void(0);' class='dropdown-item text-primary' onclick="window.open('/pelayanan/kebidanan/skl/` +
                            item.id +
                            `/cetak')"><i class='bx bx-download scaleX-n1-rtl'></i> Download</a></li>` +
                            `<li><a href='javascript:void(0);' class='dropdown-item text-danger' onclick="hapus(` +
                            item.id +
                            `)"><i class='bx bx-trash scaleX-n1-rtl'></i> Hapus</a></li>` +
                            `</ul></center></td><td>`;
                        content += item.no_surat + "</td><td>" +
                            item.tgl + "</td><td>" +
                            item.ibu + "</td><td>" +
                            item.ayah + "</td><td>";
                        if (item.anak == null)
                            content += "";
                        else
                            content += item.anak;
                        content += "</td><td>";
                        if (item.kelamin == "unknown")
                            content += "<kbd style='background-color: #000000'>-</kbd>&nbsp;";
                        if (item.kelamin == "laki-laki")
                            content += "<kbd style='background-color: #3298FF'>L</kbd>&nbsp;";
                        if (item.kelamin == "perempuan")
                            content += "<kbd style='background-color: #00898E'>P</kbd>&nbsp;";
                        content +=  " / " + item.bb + " / " + item.tb + "</td><td>" +
                            item.alamat + "</td>";
                        content += `</tr>`;
                        $('#tampil-tbody').append(content);
                    });
                    var table = $('#dttable').DataTable({
                        order: [
                            [1, "desc"]
                        ],
                        displayLength: 7,
                        lengthChange: true,
                        lengthMenu: [7, 10, 25, 50, 75, 100],
                        buttons: ['copy', 'excel', 'pdf', 'colvis']
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
            $("#btn-showall").prop('disabled', false);
            $("#btn-showall").find("i").removeClass("fa-spinner fa-spin").addClass("fa-history");
        }

        function tambah() {
            $('#tambah').modal('show');
        }

        function saveData() {
        $("#tambah").one('submit', function() {
            $("#btn-simpan").attr('disabled','disabled');
            $("#btn-simpan").find("i").toggleClass("fa-save fa-spinner fa-spin");
            return true;
        });
        }

        function refresh() {
            $("#tampil-tbody").empty().append(
                `<tr><td colspan="10"><center><i class="fa fa-spinner fa-spin fa-fw"></i> Memproses data...</center></td></tr>`);
            $.ajax({
                url: "/api/kebidanan/skl/get",
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
                            `<li><a href='javascript:void(0);' class='dropdown-item text-warning' onclick="showUbah(` +
                            item.id +
                            `)"><i class='bx bx-edit scaleX-n1-rtl'></i> Ubah</a></li>` +
                            `<li><a href='javascript:void(0);' class='dropdown-item text-info' onclick="window.open('/pelayanan/kebidanan/skl/` +
                            item.id +
                            `/print','id','width=900,height=600')"><i class='bx bx-printer scaleX-n1-rtl'></i> Cetak</a></li>` +
                            `<li><a href='javascript:void(0);' class='dropdown-item text-primary' onclick="window.open('/pelayanan/kebidanan/skl/` +
                            item.id +
                            `/cetak')"><i class='bx bx-download scaleX-n1-rtl'></i> Download</a></li>` +
                            `<li><a href='javascript:void(0);' class='dropdown-item text-danger' onclick="hapus(` +
                            item.id +
                            `)"><i class='bx bx-trash scaleX-n1-rtl'></i> Hapus</a></li>` +
                            `</ul></center></td><td>`;
                        content += item.no_surat + "</td><td>" +
                            item.tgl + "</td><td>" +
                            item.ibu + "</td><td>" +
                            item.ayah + "</td><td>";
                        if (item.anak == null)
                            content += "";
                        else
                            content += item.anak;
                        content += "</td><td>";
                        if (item.kelamin == "unknown")
                            content += "<kbd style='background-color: #000000'>-</kbd>&nbsp;";
                        if (item.kelamin == "laki-laki")
                            content += "<kbd style='background-color: #3298FF'>L</kbd>&nbsp;";
                        if (item.kelamin == "perempuan")
                            content += "<kbd style='background-color: #00898E'>P</kbd>&nbsp;";
                        content +=  " / " + item.bb + " / " + item.tb + "</td><td>" +
                            item.alamat + "</td>";
                        content += `</tr>`;
                        $('#tampil-tbody').append(content);
                    });
                    var table = $('#dttable').DataTable({
                        order: [
                            [1, "desc"]
                        ],
                        displayLength: 7,
                        lengthChange: true,
                        lengthMenu: [7, 10, 25, 50, 75, 100],
                        buttons: ['copy', 'excel', 'pdf', 'colvis']
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
        }

        // Button UBAH
        function ubahNoSurat() {
            document.getElementById("button_ubah_no_surat").hidden = true;
            document.getElementById("tampil_no_surat").hidden = true;
            document.getElementById("save_no_surat").hidden = false;
        }

        function showUbah(id) {
            // $('#maintenance').modal('show');
            $('#ubah').modal('show');
            $.ajax({
                url: "/api/kebidanan/skl/getubah/" + id,
                type: 'GET',
                dataType: 'json', // added data type
                success: function(res) {
                    // $("#tgl_edit").val(tgl); // yyyy-MM-ddThh:mm
                    // var tgl = res.tgl + ' ' + res.waktu;
                    var finalTgl = moment(res.show.tgl).format('Y-MM-DD HH:mm');
                    // TGL EDIT
                    var a = document.querySelector("#tgl_edit");
                    var b = new Date(Date.now() - 1728e5);
                    a.flatpickr({
                        enableTime: !0,
                        minuteIncrement: 1,
                        defaultDate: finalTgl,
                        time_24hr: true,
                        // disable: [{
                        //   from: "2000-01-01",
                        //   to: b.toISOString().split("T")[0]
                        // }]
                    })
                    document.getElementById('show_id').innerHTML = res.show.id;
                    $("#id_edit").val(res.show.id);
                    $("#no_surat_edit").val(res.show.no_surat);
                    $("#ibu_edit").val(res.show.ibu.slice(4, 199));
                    $("#ayah_edit").val(res.show.ayah.slice(4, 199));
                    $("#anak_edit").val(res.show.anak);
                    $("#bb_edit").val(res.show.bb);
                    $("#tb_edit").val(res.show.tb);
                    $("#alamat_edit").val(res.show.alamat);
                    $("#kelamin_edit").find('option').remove();
                    $("#kelamin_edit").append(`
                        <option value="unknown" ${res.show.kelamin == 'unknown'? "selected":""}>Belum Diketahui</option>
                        <option value="laki-laki" ${res.show.kelamin == 'laki-laki'? "selected":""}>Laki-laki</option>
                        <option value="perempuan" ${res.show.kelamin == 'perempuan'? "selected":""}>Perempuan</option>
                    `);
                    $("#dr_edit").find('option').remove();
                    $("#dr_edit").append(`
                        <option value="1" ${res.show.dr == '1'? "selected":""}>dr. Gede Sri Dhyana M. A., Sp.OG</option>
                        <option value="2" ${res.show.dr == '2'? "selected":""}>dr. H. Ahmad Sutamat, Sp.OG</option>
                        <option value="3" ${res.show.dr == '3'? "selected":""}>dr. Febrian Andhika Adiyana, Sp.OG</option>
                    `);
                }
            });
        }

        function ubah() {
            var user_edit = '{{ Auth::user()->name }}';
            var id_edit = $("#id_edit").val();
            var no_surat_edit = $("#no_surat_edit").val();
            var tgl_edit = $("#tgl_edit").val();
            var ibu_edit = $("#ibu_edit").val();
            var ayah_edit = $("#ayah_edit").val();
            var anak_edit = $("#anak_edit").val();
            var dr_edit = $("#dr_edit").val();
            var bb_edit = $("#bb_edit").val();
            var tb_edit = $("#tb_edit").val();
            var kelamin_edit = $("#kelamin_edit").val();
            var alamat_edit = $("#alamat_edit").val();

            // console.log(tgl_edit+' - '+ibu_edit+' - '+ayah_edit+' - '+anak_edit+' - '+dr_edit+' - '+bb_edit+' - '+tb_edit+' - '+kelamin_edit+' - '+alamat_edit);
            if (no_surat_edit == "" || tgl_edit == "" || ibu_edit == "" || ayah_edit == "" || dr_edit == "" || bb_edit == "" || tb_edit == "" || kelamin_edit  == "" || alamat_edit == "") {
                Swal.fire({
                    title: 'Pesan Galat!',
                    text: 'Mohon lengkapi semua data terlebih dahulu',
                    icon: 'error',
                    showConfirmButton: false,
                    showCancelButton: false,
                    allowOutsideClick: true,
                    allowEscapeKey: true,
                    timer: 3000,
                    timerProgressBar: true,
                    backdrop: `rgba(26,27,41,0.8)`,
                });
            } else {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: 'POST',
                    url: '/api/kebidanan/skl/ubah/' + id_edit,
                    dataType: 'json',
                    data: {
                        user_edit: user_edit,
                        id_edit: id_edit,
                        no_surat_edit: no_surat_edit,
                        tgl_edit: tgl_edit,
                        ibu_edit: ibu_edit,
                        ayah_edit: ayah_edit,
                        anak_edit: anak_edit,
                        dr_edit: dr_edit,
                        bb_edit: bb_edit,
                        tb_edit: tb_edit,
                        kelamin_edit: kelamin_edit,
                        alamat_edit: alamat_edit,
                    },
                    success: function(res) {
                        iziToast.success({
                            title: 'Sukses!',
                            message: 'Ubah Surat Keterangan Lahir Bayi NY.'+ibu_edit+' berhasil pada ' + res,
                            position: 'topRight'
                        });
                        if (res) {
                            $('#ubah').modal('hide');
                            refresh();
                        }
                    }
                });
            }
        }

        function hapus(id) {
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: 'Data SKL ID : ' + id,
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
                        url: "/api/kebidanan/skl/hapus/" + id,
                        type: 'GET',
                        dataType: 'json', // added data type
                        success: function(res) {
                            iziToast.success({
                                title: 'Sukses!',
                                message: 'Hapus Data SKL berhasil pada ' + res,
                                position: 'topRight'
                            });
                            refresh();
                        },
                        error: function(res) {
                            Swal.fire({
                                title: `Gagal di hapus!`,
                                text: 'Pada ' + res,
                                icon: `error`,
                                showConfirmButton: false,
                                showCancelButton: false,
                                allowOutsideClick: true,
                                allowEscapeKey: true,
                                timer: 3000,
                                timerProgressBar: true,
                                backdrop: `rgba(26,27,41,0.8)`,
                            });
                        }
                    });
                }
            })
        }
    </script>
@endsection
