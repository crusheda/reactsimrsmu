@extends('layouts.index')

@section('content')

    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i></a></li>
                        <li class="breadcrumb-item">Pelayanan</li>
                        <li class="breadcrumb-item" aria-current="page">Surat Keterangan Lahir</li>
                    </ul>
                </div>
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h2 class="mb-0">SKL (Surat Keterangan Lahir)</h2>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- [ breadcrumb ] end -->

    <!-- [ Main Content ] start -->
    <div class="row pt-1">
        <div class="col-md-12">
            <div class="card table-card">
                <div class="card-header align-items-center justify-content-between py-3">
                    <div class="d-flex">
                        <h5 class="mb-0 card-title flex-grow-1">
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary" onclick="tambah()" data-bs-toggle="tooltip" data-bs-offset="0,4"
                                    data-bs-placement="bottom" data-bs-html="true" title="<span>Tambah Data SKL</span>"
                                    value="animate__jackInTheBox">
                                    <i class="material-icons-two-tone me-1 text-light">add_box</i>
                                    <span class="align-middle">Tambah</span>
                                </button>
                                <button type="button" class="btn btn-outline-warning" data-bs-toggle="tooltip" data-bs-offset="0,4"
                                    data-bs-placement="bottom" data-bs-html="true" title="<span>Tampilkan 30 Data SKL Terbaru</span>" onclick="refresh()">
                                    <i class="fa-fw fas fa-sync nav-icon"></i></button>
                                <button type="button" class="btn btn-outline-danger" data-bs-toggle="tooltip" data-bs-offset="0,4"
                                    data-bs-placement="bottom" id="btn-showall" data-bs-html="true" title="<span>Tampilkan Semua Data SKL</span>" onclick="showAll()">
                                    <i class="fa-fw fas fa-history"></i>&nbsp;&nbsp;Riwayat</button>
                            </div>
                        </h5>
                        <div class="flex-shrink-0">
                            <div class="dropdown">
                                <button type="button" class="btn btn-info" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="mdi mdi-information-outline me-1"></i> <span class="d-none d-sm-inline-block"><i class="fas fa-caret-down me-1"></i> Filter</span></button>
                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-md" style="width: 300px">
                                    <div class="dropdown-item-text">
                                        <div>
                                            <h6 class="mb-0 text-center">Pencarian Berdasarkan Nama Ibu</h6>
                                        </div>
                                    </div>
                                    <div class="dropdown-divider"></div>
                                    <div class="form-group mb-3 m-r-10 m-l-10">
                                        <div class="input-group">
                                            <div class="input-group-text">NY.</div>
                                            <input type="text" class="form-control" id="cari_ibu" placeholder="Tulis Nama Ibu" width="300">
                                        </div>
                                    </div>
                                    <center>
                                        <button type="button" id="btn-filter" class="btn btn-link-info mb-2 btn-block w-100" data-bs-toggle="tooltip" data-bs-offset="0,4"
                                            data-bs-placement="bottom" data-bs-html="true" title="<span>Filter Data Berdasarkan Nama Ibu</span>" onclick="filter()">
                                            <i class="fas fa-filter fa-sm scaleX-n1-rtl"></i>
                                            <span class="align-middle">Filter</span>
                                        </button>
                                    </center>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    {{-- <div class="alert alert-secondary m-2">
                        <small>
                            <i class="ti ti-arrow-narrow-right text-primary me-1"></i> Data default yang ditampilkan dibatasi 100 data surat <br>
                            <i class="ti ti-arrow-narrow-right text-primary me-1"></i> Untuk menampilkan semua data, klik tombol berwarna <b class="text-danger">MERAH</b> di atas
                        </small>
                    </div> --}}
                    <div class="table-responsive">
                        <table id="dttable" class="table dt-responsive table-hover w-100 align-middle">
                            <thead>
                                <tr>
                                    <th class="cell-fit">#ID</th>
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
                                    <td colspan="10" style="font-size:13px"><center><i class="fa fa-spinner fa-spin fa-fw"></i> Memproses data...</center></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th class="cell-fit">#ID</th>
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
                </div>
            </div>
        </div>
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
                            <div class="alert alert-secondary">
                                <small>
                                    <i class="fa-fw fas fa-caret-right nav-icon"></i> Pastikan <b>Nomor Surat</b> sudah sesuai sebelum disimpan<br>
                                    <i class="fa-fw fas fa-caret-right nav-icon"></i> Tanda <a class="text-danger">*</a> berarti isian <b>Wajib</b> diisi<br>
                                    <i class="fa-fw fas fa-caret-right nav-icon"></i> Disarankan untuk menggunakan <b>Huruf Besar/Capital/Uppercase</b> saat pengisian
                                </small>
                            </div>
                            <div class="col-md-4 mb-3">
                                {{-- <div class="form-group">
                                        <label class="form-label">No Surat : </label>
                                        <input type="number" name="no_surat" value="{{ $list['nomer'] }}" class="form-control"
                                            placeholder="" disabled>
                                        <input type="number" name="no_surat" value="{{ $list['nomer'] }}" class="form-control"
                                            placeholder="" hidden>
                                    </div> --}}
                                <div class="form-group">
                                    <label class="form-label">No Surat <a class="text-danger">*</a></label>
                                    <div class="input-group">
                                        <button class="btn btn-outline-dark" type="button" id="button_ubah_no_surat"
                                            onclick="ubahNoSurat()" style="border-top-left-radius:8px;border-bottom-left-radius:8px">Ubah</button>
                                        <input type="text" class="form-control" id="tampil_no_surat"
                                            value="{{ $list['nomer'] }}" style="border-top-right-radius:8px;border-bottom-right-radius:8px" disabled>
                                        <input type="number" name="no_surat" id="save_no_surat"
                                            value="{{ $list['nomer'] }}" class="form-control" placeholder="" style="border-radius:8px" hidden
                                            required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8 mb-3">
                                <div class="form-group">
                                    <label class="form-label">Waktu <a class="text-danger">*</a></label>
                                    <input type="datetime-local" name="tgl" id="tgl_add" class="form-control"
                                        placeholder="" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="form-label">NIK Ibu <a class="text-danger">*</a></label>
                                    <div class="input-group input-group-merge">
                                        <input type="number" class="form-control" name="nik_ibu" id="basic-url3" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                            aria-describedby="basic-addon34" maxlength="16" placeholder="Nomor Induk Kependudukan Ibu" required />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="form-label">NIK Ayah <a class="text-danger">*</a></label>
                                    <div class="input-group input-group-merge">
                                        <input type="number" class="form-control" name="nik_ayah" id="basic-url3" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                            aria-describedby="basic-addon34" maxlength="16" placeholder="Nomor Induk Kependudukan Ayah" required />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="form-label">Nama Ibu <a class="text-danger">*</a></label>
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text" id="basic-addon34">NY.</span>
                                        <input type="text" class="form-control" name="ibu" id="basic-url3"
                                            aria-describedby="basic-addon34" placeholder="Nama Lengkap Ibu" required />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="form-label">Nama Ayah <a class="text-danger">*</a></label>
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text" id="basic-addon34">TN.</span>
                                        <input type="text" class="form-control" name="ayah" id="basic-url3"
                                            aria-describedby="basic-addon34" placeholder="Nama Lengkap Ayah" required />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="form-label">Nama Anak (Optional)</label>
                                    <input type="text" class="form-control" name="anak" id="basic-url3"
                                        aria-describedby="basic-addon34" placeholder="Nama Lengkap Anak (Bila Ada)" />
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="form-label">Nama Dokter <a class="text-danger">*</a></label>
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
                                    <label class="form-label">Berat Badan <a class="text-danger">*</a></label>
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
                                    <label class="form-label">Tinggi Badan <a class="text-danger">*</a></label>
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
                                    <label class="form-label">Jenis Kelamin <a class="text-danger">*</a></label>
                                    <select name="kelamin" class="form-control" style="width: 100%" required>
                                        <option selected="selected" value="" hidden>Pilih</option>
                                        <option value="unknown">Belum Diketahui</option>
                                        <option value="laki-laki">Laki-laki (L)</option>
                                        <option value="perempuan">Perempuan (P)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label class="form-label">Alamat <a class="text-danger">*</a></label>
                                    <textarea class="form-control" name="alamat" placeholder="Masukkan Alamat Lengkap" required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer p-b-0">
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
                                    <label class="form-label">No Surat : </label>
                                    <input type="number" name="no_surat" value="{{ $list['nomer'] }}" class="form-control"
                                        placeholder="" disabled>
                                    <input type="number" name="no_surat" value="{{ $list['nomer'] }}" class="form-control"
                                        placeholder="" hidden>
                                </div> --}}
                            <div class="form-group">
                                <label class="form-label">No Surat <a class="text-danger">*</a></label>
                                <input type="text" class="form-control" id="no_surat_edit"
                                    value="" disabled>
                            </div>
                        </div>
                        <div class="col-md-8 mb-3">
                            <div class="form-group">
                                <label class="form-label">Waktu <a class="text-danger">*</a></label>
                                <input type="datetime-local" id="tgl_edit" class="form-control" placeholder="" required>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label class="form-label">NIK Ibu <a class="text-danger">*</a></label>
                                <div class="input-group input-group-merge">
                                    <input type="number" class="form-control" name="nik_ibu_edit" id="nik_ibu_edit" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                        aria-describedby="basic-addon34" maxlength="16" placeholder="Nomor Induk Kependudukan Ibu" required />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label class="form-label">NIK Ayah <a class="text-danger">*</a></label>
                                <div class="input-group input-group-merge">
                                    <input type="number" class="form-control" name="nik_ayah_edit" id="nik_ayah_edit" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                        aria-describedby="basic-addon34" maxlength="16" placeholder="Nomor Induk Kependudukan Ayah" required />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label class="form-label">Nama Ibu <a class="text-danger">*</a></label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text" id="basic-addon34">NY.</span>
                                    <input type="text" class="form-control" id="ibu_edit"
                                        aria-describedby="basic-addon34" placeholder="Nama Lengkap Ibu" required/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label class="form-label">Nama Ayah <a class="text-danger">*</a></label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text" id="basic-addon34">TN.</span>
                                    <input type="text" class="form-control" id="ayah_edit"
                                        aria-describedby="basic-addon34" placeholder="Nama Lengkap Ayah" required/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label class="form-label">Nama Anak (Optional)</label>
                                <div class="input-group input-group-merge">
                                    {{-- <span class="input-group-text" id="basic-addon34">BY.</span> --}}
                                    <input type="text" class="form-control" id="anak_edit"
                                        aria-describedby="basic-addon34" placeholder="Nama Lengkap Anak (Bila Ada)" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label class="form-label">Nama Dokter <a class="text-danger">*</a></label>
                                <select class="form-control" id="dr_edit" style="width: 100%;" required></select>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="form-group">
                                <label class="form-label">Berat Badan <a class="text-danger">*</a></label>
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
                                <label class="form-label">Tinggi Badan <a class="text-danger">*</a></label>
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
                                <label class="form-label">Jenis Kelamin <a class="text-danger">*</a></label>
                                <select class="form-control select2" id="kelamin_edit" style="width: 100%;z-index: 9999!important;" required></select>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label class="form-label">Alamat <a class="text-danger">*</a></label>
                                <textarea class="form-control" id="alamat_edit" placeholder="Masukkan Alamat Lengkap" required></textarea>
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
    {{-- <div class="modal fade animate__animated animate__lightSpeedIn" id="maintenance" tabindex="-1" aria-hidden="true">
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
    </div> --}}
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
                            `<td><center><div class='btn-group'><button type='button' class='btn btn-sm btn-link dropdown-toggle hide-arrow' data-bs-toggle='dropdown' aria-expanded='false' value="animate__rubberBand">`+item.id+`</button><ul class='dropdown-menu dropdown-menu-right'>` +
                            `<li><a href='javascript:void(0);' class='dropdown-item text-warning' onclick="showUbah(` +
                            item.id +
                            `)"><i class='fas fa-edit'></i> Ubah</a></li>` +
                            `<li><a href='javascript:void(0);' class='dropdown-item text-info' onclick="window.open('/pelayanan/kebidanan/skl/` +
                            item.id +
                            `/print','id','width=900,height=600')"><i class='fas fa-print'></i> Cetak</a></li>` +
                            `<li><a href='javascript:void(0);' class='dropdown-item text-primary' onclick="window.open('/pelayanan/kebidanan/skl/` +
                            item.id +
                            `/cetak')"><i class='fas fa-download'></i> Download</a></li>` +
                            `<li><a href='javascript:void(0);' class='dropdown-item text-danger' onclick="hapus(` +
                            item.id +
                            `)"><i class='fas fa-trash'></i> Hapus</a></li>` +
                            `</ul></center></td><td>`;
                        content += item.no_surat + "</td><td>" + item.tgl + "</td>";
                        if (item.nik_ibu) {
                            nik_ibu = 'NIK - ' + item.nik_ibu;
                        } else {
                            nik_ibu = '';
                        }
                        if (item.nik_ayah) {
                            nik_ayah = 'NIK - ' + item.nik_ayah;
                        } else {
                            nik_ayah = '';
                        }
                        content += "<td><div class='d-flex justify-content-start align-items-center'><div class='d-flex flex-column'><h6 class='mb-0 text-truncate text-primary'><a href='javascript:void(0);' data-bs-toggle='tooltip' data-bs-placement='top' data-bs-html='true' class='text-dark'><u>" + item.ibu + "</u></a></h6><small class='text-truncate text-muted'>" + nik_ibu + "</small></div></div></td>";
                        content += "<td><div class='d-flex justify-content-start align-items-center'><div class='d-flex flex-column'><h6 class='mb-0 text-truncate text-primary'><a href='javascript:void(0);' data-bs-toggle='tooltip' data-bs-placement='top' data-bs-html='true' class='text-dark'><u>" + item.ayah + "</u></a></h6><small class='text-truncate text-muted'>" + nik_ayah + "</small></div></div></td>";
                        content += "<td>";
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
                        bAutoWidth: false,
                        aoColumns : [
                            { sWidth: '6%' },
                            { sWidth: '7%' },
                            { sWidth: '12%' },
                            { sWidth: '15%' },
                            { sWidth: '15%' },
                            { sWidth: '15%' },
                            { sWidth: '10%' },
                            { sWidth: '20%' },
                        ],
                        displayLength: 10,
                        lengthChange: true,
                        lengthMenu: [10, 25, 50, 75, 100],
                        buttons: ['copy', 'excel', 'pdf', 'colvis']
                    });

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
        });

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
                                `<td><center><div class='btn-group'><button type='button' class='btn btn-sm btn-link btn-icon dropdown-toggle hide-arrow' data-bs-toggle='dropdown' aria-expanded='false' value="animate__rubberBand">`+item.id+`</button><ul class='dropdown-menu dropdown-menu-right'>` +
                                `<li><a href='javascript:void(0);' class='dropdown-item text-warning' onclick="showUbah(` +
                                item.id +
                                `)"><i class='fas fa-edit'></i> Ubah</a></li>` +
                                `<li><a href='javascript:void(0);' class='dropdown-item text-info' onclick="window.open('/pelayanan/kebidanan/skl/` +
                                item.id +
                                `/print','id','width=900,height=600')"><i class='fas fa-print'></i> Cetak</a></li>` +
                                `<li><a href='javascript:void(0);' class='dropdown-item text-primary' onclick="window.open('/pelayanan/kebidanan/skl/` +
                                item.id +
                                `/cetak')"><i class='fas fa-download'></i> Download</a></li>` +
                                `<li><a href='javascript:void(0);' class='dropdown-item text-danger' onclick="hapus(` +
                                item.id +
                                `)"><i class='fas fa-trash'></i> Hapus</a></li>` +
                                `</ul></center></td><td>`;
                            content += item.no_surat + "</td><td>" + item.tgl + "</td>";
                            if (item.nik_ibu) {
                                nik_ibu = 'NIK - ' + item.nik_ibu;
                            } else {
                                nik_ibu = '';
                            }
                            if (item.nik_ayah) {
                                nik_ayah = 'NIK - ' + item.nik_ayah;
                            } else {
                                nik_ayah = '';
                            }
                            content += "<td><div class='d-flex justify-content-start align-items-center'><div class='d-flex flex-column'><h6 class='mb-0 text-truncate text-primary'><a href='javascript:void(0);' data-bs-toggle='tooltip' data-bs-placement='top' data-bs-html='true' class='text-dark'><u>" + item.ibu + "</u></a></h6><small class='text-truncate text-muted'>" + nik_ibu + "</small></div></div></td>";
                            content += "<td><div class='d-flex justify-content-start align-items-center'><div class='d-flex flex-column'><h6 class='mb-0 text-truncate text-primary'><a href='javascript:void(0);' data-bs-toggle='tooltip' data-bs-placement='top' data-bs-html='true' class='text-dark'><u>" + item.ayah + "</u></a></h6><small class='text-truncate text-muted'>" + nik_ayah + "</small></div></div></td>";
                            content += "<td>";
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
                            bAutoWidth: false,
                            aoColumns : [
                                { sWidth: '6%' },
                                { sWidth: '7%' },
                                { sWidth: '12%' },
                                { sWidth: '15%' },
                                { sWidth: '15%' },
                                { sWidth: '15%' },
                                { sWidth: '10%' },
                                { sWidth: '20%' },
                            ],
                            displayLength: 10,
                            lengthChange: true,
                            lengthMenu: [10, 25, 50, 75, 100],
                            buttons: ['copy', 'excel', 'pdf', 'colvis']
                        });

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
            $("#cari_ibu").val('');
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
                            `<td><center><div class='btn-group'><button type='button' class='btn btn-sm btn-link btn-icon dropdown-toggle hide-arrow' data-bs-toggle='dropdown' aria-expanded='false' value="animate__rubberBand">`+item.id+`</button><ul class='dropdown-menu dropdown-menu-right'>` +
                            `<li><a href='javascript:void(0);' class='dropdown-item text-warning' onclick="showUbah(` +
                            item.id +
                            `)"><i class='fas fa-edit'></i> Ubah</a></li>` +
                            `<li><a href='javascript:void(0);' class='dropdown-item text-info' onclick="window.open('/pelayanan/kebidanan/skl/` +
                            item.id +
                            `/print','id','width=900,height=600')"><i class='fas fa-print'></i> Cetak</a></li>` +
                            `<li><a href='javascript:void(0);' class='dropdown-item text-primary' onclick="window.open('/pelayanan/kebidanan/skl/` +
                            item.id +
                            `/cetak')"><i class='fas fa-download'></i> Download</a></li>` +
                            `<li><a href='javascript:void(0);' class='dropdown-item text-danger' onclick="hapus(` +
                            item.id +
                            `)"><i class='fas fa-trash'></i> Hapus</a></li>` +
                            `</ul></center></td><td>`;
                        content += item.no_surat + "</td><td>" + item.tgl + "</td>";
                        if (item.nik_ibu) {
                            nik_ibu = 'NIK - ' + item.nik_ibu;
                        } else {
                            nik_ibu = '';
                        }
                        if (item.nik_ayah) {
                            nik_ayah = 'NIK - ' + item.nik_ayah;
                        } else {
                            nik_ayah = '';
                        }
                        content += "<td><div class='d-flex justify-content-start align-items-center'><div class='d-flex flex-column'><h6 class='mb-0 text-truncate text-primary'><a href='javascript:void(0);' data-bs-toggle='tooltip' data-bs-placement='top' data-bs-html='true' class='text-dark'><u>" + item.ibu + "</u></a></h6><small class='text-truncate text-muted'>" + nik_ibu + "</small></div></div></td>";
                        content += "<td><div class='d-flex justify-content-start align-items-center'><div class='d-flex flex-column'><h6 class='mb-0 text-truncate text-primary'><a href='javascript:void(0);' data-bs-toggle='tooltip' data-bs-placement='top' data-bs-html='true' class='text-dark'><u>" + item.ayah + "</u></a></h6><small class='text-truncate text-muted'>" + nik_ayah + "</small></div></div></td>";
                        content += "<td>";
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
                        bAutoWidth: false,
                        aoColumns : [
                            { sWidth: '6%' },
                            { sWidth: '7%' },
                            { sWidth: '12%' },
                            { sWidth: '15%' },
                            { sWidth: '15%' },
                            { sWidth: '15%' },
                            { sWidth: '10%' },
                            { sWidth: '20%' },
                        ],
                        displayLength: 10,
                        lengthChange: true,
                        lengthMenu: [10, 25, 50, 75, 100],
                        buttons: ['copy', 'excel', 'pdf', 'colvis']
                    });

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
            $("#cari_ibu").val('');
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
                            `<td><center><div class='btn-group'><button type='button' class='btn btn-sm btn-link btn-icon dropdown-toggle hide-arrow' data-bs-toggle='dropdown' aria-expanded='false' value="animate__rubberBand">`+item.id+`</button><ul class='dropdown-menu dropdown-menu-right'>` +
                            `<li><a href='javascript:void(0);' class='dropdown-item text-warning' onclick="showUbah(` +
                            item.id +
                            `)"><i class='fas fa-edit'></i> Ubah</a></li>` +
                            `<li><a href='javascript:void(0);' class='dropdown-item text-info' onclick="window.open('/pelayanan/kebidanan/skl/` +
                            item.id +
                            `/print','id','width=900,height=600')"><i class='fas fa-print'></i> Cetak</a></li>` +
                            `<li><a href='javascript:void(0);' class='dropdown-item text-primary' onclick="window.open('/pelayanan/kebidanan/skl/` +
                            item.id +
                            `/cetak')"><i class='fas fa-download'></i> Download</a></li>` +
                            `<li><a href='javascript:void(0);' class='dropdown-item text-danger' onclick="hapus(` +
                            item.id +
                            `)"><i class='fas fa-trash'></i> Hapus</a></li>` +
                            `</ul></center></td><td>`;
                        content += item.no_surat + "</td><td>" + item.tgl + "</td>";
                        if (item.nik_ibu) {
                            nik_ibu = 'NIK - ' + item.nik_ibu;
                        } else {
                            nik_ibu = '';
                        }
                        if (item.nik_ayah) {
                            nik_ayah = 'NIK - ' + item.nik_ayah;
                        } else {
                            nik_ayah = '';
                        }
                        content += "<td><div class='d-flex justify-content-start align-items-center'><div class='d-flex flex-column'><h6 class='mb-0 text-truncate text-primary'><a href='javascript:void(0);' data-bs-toggle='tooltip' data-bs-placement='top' data-bs-html='true' class='text-dark'><u>" + item.ibu + "</u></a></h6><small class='text-truncate text-muted'>" + nik_ibu + "</small></div></div></td>";
                        content += "<td><div class='d-flex justify-content-start align-items-center'><div class='d-flex flex-column'><h6 class='mb-0 text-truncate text-primary'><a href='javascript:void(0);' data-bs-toggle='tooltip' data-bs-placement='top' data-bs-html='true' class='text-dark'><u>" + item.ayah + "</u></a></h6><small class='text-truncate text-muted'>" + nik_ayah + "</small></div></div></td>";
                        content += "<td>";
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
                        bAutoWidth: false,
                        aoColumns : [
                            { sWidth: '6%' },
                            { sWidth: '7%' },
                            { sWidth: '12%' },
                            { sWidth: '15%' },
                            { sWidth: '15%' },
                            { sWidth: '15%' },
                            { sWidth: '10%' },
                            { sWidth: '20%' },
                        ],
                        displayLength: 10,
                        lengthChange: true,
                        lengthMenu: [10, 25, 50, 75, 100],
                        buttons: ['copy', 'excel', 'pdf', 'colvis']
                    });

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
                    if (res.show.nik_ibu) {
                        $("#nik_ibu_edit").val(res.show.nik_ibu);
                    }
                    if (res.show.nik_ayah) {
                        $("#nik_ayah_edit").val(res.show.nik_ayah);
                    }
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
            var nik_ibu_edit = $("#nik_ibu_edit").val();
            var nik_ayah_edit = $("#nik_ayah_edit").val();
            var ibu_edit = $("#ibu_edit").val();
            var ayah_edit = $("#ayah_edit").val();
            var anak_edit = $("#anak_edit").val();
            var dr_edit = $("#dr_edit").val();
            var bb_edit = $("#bb_edit").val();
            var tb_edit = $("#tb_edit").val();
            var kelamin_edit = $("#kelamin_edit").val();
            var alamat_edit = $("#alamat_edit").val();

            // console.log(tgl_edit+' - '+ibu_edit+' - '+ayah_edit+' - '+anak_edit+' - '+dr_edit+' - '+bb_edit+' - '+tb_edit+' - '+kelamin_edit+' - '+alamat_edit);
            if (no_surat_edit == "" || tgl_edit == "" || nik_ibu_edit == "" || nik_ayah_edit == "" || ibu_edit == "" || ayah_edit == "" || dr_edit == "" || bb_edit == "" || tb_edit == "" || kelamin_edit  == "" || alamat_edit == "") {
                iziToast.error({
                    title: 'Pesan Galat!',
                    message: 'Mohon lengkapi semua data terlebih dahulu',
                    position: 'topRight'
                });
                // Swal.fire({
                //     title: 'Pesan Galat!',
                //     text: 'Mohon lengkapi semua data terlebih dahulu',
                //     icon: 'error',
                //     showConfirmButton: false,
                //     showCancelButton: false,
                //     allowOutsideClick: true,
                //     allowEscapeKey: true,
                //     timer: 3000,
                //     timerProgressBar: true,
                //     backdrop: `rgba(26,27,41,0.8)`,
                // });
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
                        nik_ibu_edit: nik_ibu_edit,
                        nik_ayah_edit: nik_ayah_edit,
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
                                title: 'Pesan Sukses!',
                                message: 'Hapus Data SKL berhasil pada ' + res,
                                position: 'topRight'
                            });
                            // iziToast.success({
                            //     title: 'Sukses!',
                            //     message: 'Hapus Data SKL berhasil pada ' + res,
                            //     position: 'topRight'
                            // });
                            refresh();
                        },
                        error: function(res) {
                            iziToast.error({
                                title: 'Pesan Galat!',
                                message: 'Gagal di hapus pada ' + res,
                                position: 'topRight'
                            });
                            // Swal.fire({
                            //     title: `Gagal di hapus!`,
                            //     text: 'Pada ' + res,
                            //     icon: `error`,
                            //     showConfirmButton: false,
                            //     showCancelButton: false,
                            //     allowOutsideClick: true,
                            //     allowEscapeKey: true,
                            //     timer: 3000,
                            //     timerProgressBar: true,
                            //     backdrop: `rgba(26,27,41,0.8)`,
                            // });
                        }
                    });
                }
            })
        }
    </script>
@endsection
