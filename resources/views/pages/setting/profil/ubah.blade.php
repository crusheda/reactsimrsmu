@extends('layouts.default')

@section('content')
    <!-- Loader -->
    <div id="preloader">
        <div id="status">
            <div class="spinner-chase">
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
            </div>
        </div>
    </div>
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Profil User - Ubah</h4>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h6 class="mb-2">Mohon lengkapi semua isian yang wajib bertanda (<a class="text-danger">*</a>), silakan tekan tombol Selanjutnya untuk beralih ke isian berikutnya atau tekan tombol Sebelumnya untuk kembali.</h6>

            <form id="formUpdate" class="form-auth-small" action="{{ route('profil.store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <!-- Seller Details -->
                <h3>Biodata</h3>
                <section>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Nama Lengkap <a class="text-danger">*</a></label>
                                <input type="text" class="form-control" name="nama" value="{{ $list['show']->nama }}"
                                    placeholder="e.g. Sunaryo, S.Kep" required>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="mb-3">
                                <label class="form-label">Nama Panggilan <a class="text-danger">*</a></label>
                                <input type="text" class="form-control" name="nick" value="{{ $list['show']->nick }}"
                                    placeholder="e.g. Soenaryo" required>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">Nomor Induk Kependudukan (NIK) <a class="text-danger">*</a></label>
                                <input type="text" class="form-control" name="nik" value="{{ $list['show']->nik }}"
                                    minlength="16" maxlength="16" placeholder="Isi dengan kombinasi Angka" required>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="mb-3">
                                <label class="form-label">Tempat Lahir <a class="text-danger">*</a></label>
                                <select class="select2 form-control" id="temp_lahir" name="temp_lahir" required>
                                    @foreach ($list['kota'] as $item)
                                        <option value="{{ $item->nama_kabkota }}"
                                            @if ($list['show']->temp_lahir == $item->nama_kabkota) selected @endif>{{ $item->nama_kabkota }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="mb-3">
                                <label class="form-label">Tanggal Lahir <a class="text-danger">*</a></label>
                                <input type="date" class="form-control" name="tgl_lahir"
                                    value="{{ $list['show']->tgl_lahir }}" placeholder="YYYY-MM-DD" required>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="mb-3">
                                <label class="form-label">Jenis Kelamin <a class="text-danger">*</a></label>
                                <select class="select2 form-control" id="jns_kelamin" name="jns_kelamin" required>
                                    <option value="LAKI-LAKI" @if ($list['show']->jns_kelamin == 'LAKI-LAKI') echo selected @endif>
                                        Laki-laki</option>
                                    <option value="PEREMPUAN" @if ($list['show']->jns_kelamin == 'PEREMPUAN') echo selected @endif>
                                        Perempuan</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="mb-3">
                                <label class="form-label">Status Kawin <a class="text-danger">*</a></label>
                                <select class="select2 form-control" name="status_kawin" required>
                                    <option value="BELUM" @if ($list['show']->status_kawin == 'BELUM') echo selected @endif>Belum
                                    </option>
                                    <option value="SUDAH" @if ($list['show']->status_kawin == 'SUDAH') echo selected @endif>Sudah
                                    </option>
                                    <option value="CERAI" @if ($list['show']->status_kawin == 'CERAI') echo selected @endif>Cerai
                                    </option>
                                    <option value="RAHASIA" @if ($list['show']->status_kawin == 'RAHASIA') echo selected @endif>Tidak
                                        ingin memberi tahu</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Company Document -->
                <h3>Tempat Tinggal</h3>
                <section>
                    <h5><b>Alamat Sesuai KTP</b></h5>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Provinsi <a class="text-danger">*</a></label>
                                <select class="select2 form-control" name="ktp_provinsi" id="apiprovinsi"
                                    style="width: 100%" required>
                                    @foreach ($list['provinsi'] as $item)
                                        <option value="{{ $item->provinsi }}"
                                            @if ($item->provinsi == $list['show']->ktp_provinsi) echo selected @endif>{{ $item->provinsi }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Kabupaten <a class="text-danger">*</a></label>
                                <select class="select2 form-control" name="ktp_kabupaten" id="apikota" style="width: 100%"
                                    disabled required>
                                    @if (!empty($list['show']->ktp_kabupaten))
                                        <option value="{{ $list['show']->ktp_kabupaten }}">
                                            {{ $list['show']->ktp_kabupaten }}</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Kecamatan <a class="text-danger">*</a></label>
                                <select class="select2 form-control" name="ktp_kecamatan" id="apikecamatan"
                                    style="width: 100%" disabled required>
                                    @if (!empty($list['show']->ktp_kecamatan))
                                        <option value="{{ $list['show']->ktp_kecamatan }}">
                                            {{ $list['show']->ktp_kecamatan }}</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Kelurahan / Desa <a class="text-danger">*</a></label>
                                <select class="select2 form-control" name="ktp_kelurahan" id="apidesa"
                                    style="width: 100%" disabled required>
                                    @if (!empty($list['show']->ktp_kelurahan))
                                        <option value="{{ $list['show']->ktp_kelurahan }}">
                                            {{ $list['show']->ktp_kelurahan }}</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label">Alamat Lengkap <a class="text-danger">*</a></label>
                                <textarea class="form-control" name="alamat_ktp" required placeholder="Tuliskan alamat lengkap sesuai KTP Anda"><?php echo htmlspecialchars($list['show']->alamat_ktp); ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input form-check-success"
                            @if (!empty($list['show']->alamat_dom)) value="1" @else value="0" checked @endif
                            name="cek_dom" id="checkbox_alamat" data-bs-toggle="tooltip" data-bs-placement="top"
                            title="Hilangkan centang untuk menampilkan Pilihan Domisili">
                        <label class="form-label">Alamat domisili sesuai dengan KTP</label>
                    </div>
                    <div id="hidedom" @if (empty($list['show']->alamat_dom)) style="display: none" @endif>
                        <hr>
                        <h5><b>Alamat Domisili</b></h5>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Provinsi</label>
                                    <select class="select2 form-control" name="dom_provinsi" id="apiprovinsidom"
                                        style="width: 100%">
                                        @foreach ($list['provinsi'] as $item)
                                            <option value="{{ $item->provinsi }}"
                                                @if ($item->provinsi == $list['show']->dom_provinsi) echo selected @endif>
                                                {{ $item->provinsi }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Kabupaten</label>
                                    <select class="select2 form-control" name="dom_kabupaten" id="apikotadom"
                                        style="width: 100%" disabled>
                                        @if (!empty($list['show']->dom_kabupaten))
                                            <option value="{{ $list['show']->dom_kabupaten }}">
                                                {{ $list['show']->dom_kabupaten }}</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Kecamatan</label>
                                    <select class="select2 form-control" name="dom_kecamatan" id="apikecamatandom"
                                        style="width: 100%" disabled>
                                        @if (!empty($list['show']->dom_kecamatan))
                                            <option value="{{ $list['show']->dom_kecamatan }}">
                                                {{ $list['show']->dom_kecamatan }}</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Kelurahan / Desa</label>
                                    <select class="select2 form-control" name="dom_kelurahan" id="apidesadom"
                                        style="width: 100%" disabled>
                                        @if (!empty($list['show']->dom_kelurahan))
                                            <option value="{{ $list['show']->dom_kelurahan }}">
                                                {{ $list['show']->dom_kelurahan }}</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="form-label">Alamat Lengkap</label>
                                    <textarea class="form-control" name="alamat_dom" id="apialamatdom" placeholder="Tuliskan alamat lengkap domisili Anda"><?php echo htmlspecialchars($list['show']->alamat_dom); ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- KONTAK -->
                <h3>Kontak</h3>
                <section>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">No. HP Aktif (Whatsapp) <a class="text-danger">*</a></label>
                                <input type="text" class="form-control" name="no_hp"
                                    value="{{ $list['show']->no_hp }}" maxlength="13" placeholder="628**********"
                                    required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Instagram</label>
                                <input type="text" class="form-control" name="ig"
                                    value="{{ $list['show']->ig }}" placeholder="">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Facebook</label>
                                <input type="text" class="form-control" name="fb"
                                    value="{{ $list['show']->fb }}" placeholder="">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">E-mail Aktif <a class="text-danger">*</a></label>
                                <input type="email" class="form-control" name="email"
                                    value="{{ $list['show']->email }}" placeholder="" required>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- RIWAYAT -->
                <h3>Riwayat</h3>
                <section>
                    <h5><b>Pendidikan</b></h5>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Sekolah Dasar</label>
                                <div class="input-group">
                                    <input type="text" name="sd" value="{{ $list['show']->sd }}"
                                        class="form-control" placeholder="Nama Sekolah Dasar">
                                    <input type="text" name="th_sd" value="{{ $list['show']->th_sd }}"
                                        class="form-control phone" maxlength="4" placeholder="Tahun Lulus">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">SMP/MTS</label>
                                <div class="input-group">
                                    <input type="text" name="smp" value="{{ $list['show']->smp }}"
                                        class="form-control" placeholder="Nama Sekolah Menengah Pertama">
                                    <input type="text" name="th_smp" value="{{ $list['show']->th_smp }}"
                                        class="form-control" placeholder="Tahun Lulus">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">SMA/SMK</label>
                                <div class="input-group">
                                    <input type="text" name="sma" value="{{ $list['show']->sma }}"
                                        class="form-control" placeholder="Nama Sekolah Menengah Atas">
                                    <input type="text" name="th_sma" value="{{ $list['show']->th_sma }}"
                                        class="form-control" placeholder="Tahun Lulus">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">D1</label>
                                <div class="input-group">
                                    <input type="text" name="d1" value="{{ $list['show']->d1 }}"
                                        class="form-control" placeholder="Nama Universitas">
                                    <input type="text" name="th_d1" value="{{ $list['show']->th_d1 }}"
                                        class="form-control" placeholder="Tahun Lulus">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">D3</label>
                                <div class="input-group">
                                    <input type="text" name="d3" value="{{ $list['show']->d3 }}"
                                        class="form-control" placeholder="Nama Universitas">
                                    <input type="text" name="th_d3" value="{{ $list['show']->th_d3 }}"
                                        class="form-control" placeholder="Tahun Lulus">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">S1/D4</label>
                                <div class="input-group">
                                    <input type="text" name="s1" value="{{ $list['show']->s1 }}"
                                        class="form-control" placeholder="Nama Universitas">
                                    <input type="text" name="th_s1" value="{{ $list['show']->th_s1 }}"
                                        class="form-control" placeholder="Tahun Lulus">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">S2</label>
                                <div class="input-group">
                                    <input type="text" name="s2" value="{{ $list['show']->s2 }}"
                                        class="form-control" placeholder="Nama Universitas">
                                    <input type="text" name="th_s2" value="{{ $list['show']->th_s2 }}"
                                        class="form-control" placeholder="Tahun Lulus">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="">
                                <label class="form-label">S3</label>
                                <div class="input-group">
                                    <input type="text" name="s3" value="{{ $list['show']->s3 }}"
                                        class="form-control" placeholder="Nama Universitas">
                                    <input type="text" name="th_s3" value="{{ $list['show']->th_s3 }}"
                                        class="form-control" placeholder="Tahun Lulus">
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <h5><b>Pekerjaan</b></h5>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="">
                                <label class="form-label">Pengalaman Kerja</label>
                                <textarea name="pengalaman_kerja" class="form-control" placeholder="Tuliskan pengalaman kerja Anda"><?php echo htmlspecialchars($list['show']->pengalaman_kerja); ?></textarea>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <h5><b>Medis</b></h5>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Riwayat Penyakit</label>
                                <textarea name="riwayat_penyakit" class="form-control"><?php echo htmlspecialchars($list['show']->riwayat_penyakit); ?></textarea>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Riwayat Penyakit Keluarga</label>
                                <textarea name="riwayat_penyakit_keluarga" class="form-control"><?php echo htmlspecialchars($list['show']->riwayat_penyakit_keluarga); ?></textarea>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Riwayat Operasi</label>
                                <textarea name="riwayat_operasi" class="form-control"><?php echo htmlspecialchars($list['show']->riwayat_operasi); ?></textarea>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Riwayat Penggunaan Obat</label>
                                <textarea name="riwayat_penggunaan_obat" class="form-control"><?php echo htmlspecialchars($list['show']->riwayat_penggunaan_obat); ?></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 d-flex justify-content-between">
                        <a class="align-middle text-dark">
                            <i class="mdi mdi-arrow-right text-primary"></i> Periksa data Anda sekali lagi sebelum menyimpan <br>
                            <i class="mdi mdi-arrow-right text-primary"></i> Masukkan data yang sebenarnya untuk keperluan bagian Kepegawaian</a>
                        <button class="btn btn-success btn-submit" onclick="saveData()" type="submit" id="btn-simpan">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                    </div>
                    <hr>
                </section>
            </form>
        </div>
        <div class="align-middle card-footer">
            <button class="btn btn-secondary" type="button" onclick="window.location='{{ route('profil.index') }}'">
                <i class="fas fa-chevron-left"></i> Kembali
            </button>&nbsp;&nbsp;Kembali ke Halaman Profil
        </div>

    </div>
    <!-- end card body -->
    </div>
    <script>
        $(document).ready(function() {
            // Init Steps
            $("#formUpdate").steps({
                headerTag: "h3",
                bodyTag: "section",
                transitionEffect: "slide"
            });
            $("#step-finish").hide();

            // Init Select2
            // $("#temp_lahir").select2();
            // $("#jns_kelamin").select2();
            $(".select2").select2({
                placeholder: "Pilih",
            });

            // ALAMAT KTP
            $('#apiprovinsi').change(function() {

                $.ajax({
                    url: "/api/provinsi/" + this.value,
                    type: 'GET',
                    dataType: 'json', // added data type
                    success: function(res) {
                        // console.log(this.value);
                        // var valprovinsi = $("#apiprovinsi").val();
                        $("#apikota").val("").find('option').remove();
                        $("#apikecamatan").val("").find('option').remove();
                        $("#apidesa").val("").find('option').remove();
                        $("#apikota").attr('disabled', false);
                        $("#apikecamatan").attr('disabled', true);
                        $("#apidesa").attr('disabled', true);
                        $("#apikota").append('<option value="">Pilih</option>');
                        // res.forEach(item => {
                        //     $("#apikota").val(item.nama_kabkota);
                        // });
                        // var ary = res.;
                        var len = res.length;
                        var sel = document.getElementById('apikota');
                        for (var i = 0; i < len; i++) {
                            var opt = document.createElement('option');
                            opt.innerHTML = res[i]['nama_kabkota'];
                            opt.value = res[i]['nama_kabkota'];
                            sel.appendChild(opt);
                            // $("#sel_user").append("<option value='"+id+"'>"+name+"</option>");
                        }
                    }
                });
            });

            $('#apikota').change(function() {

                $.ajax({
                    url: "/api/kota/" + this.value,
                    type: 'GET',
                    dataType: 'json', // added data type
                    success: function(res) {
                        $("#apikecamatan").val("").find('option').remove();
                        $("#apidesa").val("").find('option').remove();
                        $("#apikecamatan").attr('disabled', false);
                        $("#apidesa").attr('disabled', true);
                        $("#apikecamatan").append('<option value="">Pilih</option>');
                        // res.forEach(item => {
                        //     $("#apikota").val(item.nama_kabkota);
                        // });
                        // var ary = res.;
                        var len = res.length;
                        var sel = document.getElementById('apikecamatan');
                        for (var i = 0; i < len; i++) {
                            var opt = document.createElement('option');
                            opt.innerHTML = res[i]['kecamatan'];
                            opt.value = res[i]['kecamatan'];
                            sel.appendChild(opt);
                            // $("#sel_user").append("<option value='"+id+"'>"+name+"</option>");
                        }
                    }
                });
            });

            $('#apikecamatan').change(function() {

                $.ajax({
                    url: "/api/kecamatan/" + this.value,
                    type: 'GET',
                    dataType: 'json', // added data type
                    success: function(res) {
                        $("#apidesa").val("").find('option').remove();
                        $("#apidesa").attr('disabled', false);
                        $("#apidesa").append('<option value="">Pilih</option>');
                        // res.forEach(item => {
                        //     $("#apikota").val(item.nama_kabkota);
                        // });
                        // var ary = res.;
                        var len = res.length;
                        var sel = document.getElementById('apidesa');
                        for (var i = 0; i < len; i++) {
                            var opt = document.createElement('option');
                            opt.innerHTML = res[i]['desa'];
                            opt.value = res[i]['desa'];
                            sel.appendChild(opt);
                            // $("#sel_user").append("<option value='"+id+"'>"+name+"</option>");
                        }
                    }
                });
            });

            // ALAMAT DOMISILI
            $('#apiprovinsidom').change(function() {

                $.ajax({
                    url: "/api/provinsi/" + this.value,
                    type: 'GET',
                    dataType: 'json', // added data type
                    success: function(res) {
                        // var valprovinsi = $("#apiprovinsi").val();
                        $("#apikotadom").val("").find('option').remove();
                        $("#apikecamatandom").val("").find('option').remove();
                        $("#apidesadom").val("").find('option').remove();
                        $("#apikotadom").attr('disabled', false);
                        $("#apikecamatandom").attr('disabled', true);
                        $("#apidesadom").attr('disabled', true);
                        $("#apikotadom").append('<option value="">Pilih</option>');
                        // res.forEach(item => {
                        //     $("#apikota").val(item.nama_kabkota);
                        // });
                        // var ary = res.;
                        var len = res.length;
                        var sel = document.getElementById('apikotadom');
                        for (var i = 0; i < len; i++) {
                            var opt = document.createElement('option');
                            opt.innerHTML = res[i]['nama_kabkota'];
                            opt.value = res[i]['nama_kabkota'];
                            sel.appendChild(opt);
                            // $("#sel_user").append("<option value='"+id+"'>"+name+"</option>");
                        }
                    }
                });
            });

            $('#apikotadom').change(function() {

                $.ajax({
                    url: "/api/kota/" + this.value,
                    type: 'GET',
                    dataType: 'json', // added data type
                    success: function(res) {
                        $("#apikecamatandom").val("").find('option').remove();
                        $("#apidesadom").val("").find('option').remove();
                        $("#apikecamatandom").attr('disabled', false);
                        $("#apidesadom").attr('disabled', true);
                        $("#apikecamatandom").append('<option value="">Pilih</option>');
                        // res.forEach(item => {
                        //     $("#apikota").val(item.nama_kabkota);
                        // });
                        // var ary = res.;
                        var len = res.length;
                        var sel = document.getElementById('apikecamatandom');
                        for (var i = 0; i < len; i++) {
                            var opt = document.createElement('option');
                            opt.innerHTML = res[i]['kecamatan'];
                            opt.value = res[i]['kecamatan'];
                            sel.appendChild(opt);
                            // $("#sel_user").append("<option value='"+id+"'>"+name+"</option>");
                        }
                    }
                });
            });

            $('#apikecamatandom').change(function() {

                $.ajax({
                    url: "/api/kecamatan/" + this.value,
                    type: 'GET',
                    dataType: 'json', // added data type
                    success: function(res) {
                        $("#apidesadom").val("").find('option').remove();
                        $("#apidesadom").attr('disabled', false);
                        $("#apidesadom").append('<option value="">Pilih</option>');
                        // res.forEach(item => {
                        //     $("#apikota").val(item.nama_kabkota);
                        // });
                        // var ary = res.;
                        var len = res.length;
                        var sel = document.getElementById('apidesadom');
                        for (var i = 0; i < len; i++) {
                            var opt = document.createElement('option');
                            opt.innerHTML = res[i]['desa'];
                            opt.value = res[i]['desa'];
                            sel.appendChild(opt);
                            // $("#sel_user").append("<option value='"+id+"'>"+name+"</option>");
                        }
                    }
                });
            });

            // VALIDASI CHECKBOX ALAMAT
            $("#checkbox_alamat").on('change', function() {
                if ($(this).is(':checked')) {
                    $("#apiprovinsidom").val("").trigger('change').find('selected').remove();
                    $("#apikotadom").val("").trigger('change').find('selected').remove();
                    $("#apikecamatandom").val("").trigger('change').find('selected').remove();
                    $("#apidesadom").val("").trigger('change').find('selected').remove();
                    $("#apialamatdom").val("").text("").trigger('change');
                    // $('#apiprovinsidom').prop('disabled', true);
                    // $('#apikotadom').prop('disabled', true);
                    // $('#apikecamatandom').prop('disabled', true);
                    // $('#apidesadom').prop('disabled', true);
                    // $('#alamat_dom').prop('disabled', true);
                    $("#hidedom").removeClass('show').hide();
                    $(this).val("0");
                } else {
                    // $('#alamatdomisili').prop('hidden', false);
                    $('#apiprovinsidom').prop('disabled', false);
                    $('#apikotadom').prop('disabled', true);
                    $('#apikecamatandom').prop('disabled', true);
                    $('#apidesadom').prop('disabled', true);
                    $("#hidedom").addClass('show').show();
                    $(this).val("1");
                }
            });

            $("#step-finish").on("click", function() {
                let nik = document.forms["formUpdate"]["nik"].value;
                let nama = document.forms["formUpdate"]["nama"].value;
                let nick = document.forms["formUpdate"]["nick"].value;
                let temp_lahir = document.forms["formUpdate"]["temp_lahir"].value;
                let tgl_lahir = document.forms["formUpdate"]["tgl_lahir"].value;
                let jns_kelamin = document.forms["formUpdate"]["jns_kelamin"].value;
                let status_kawin = document.forms["formUpdate"]["status_kawin"].value;
                let ktp_provinsi = document.forms["formUpdate"]["ktp_provinsi"].value;
                let alamat_ktp = document.forms["formUpdate"]["alamat_ktp"].value;
                let no_hp = document.forms["formUpdate"]["no_hp"].value;
                let email = document.forms["formUpdate"]["email"].value;
                if (nik == "" || nama == "" || nick == "" || temp_lahir == "" || tgl_lahir == "" ||
                    jns_kelamin == "" ||
                    status_kawin == "" || ktp_provinsi == "" || alamat_ktp == "" || no_hp == "" || email ==
                    "") {
                    if (nik == "") {
                        iziToast.error({
                            title: 'Pesan Gagal!',
                            message: 'NIK wajib diisi',
                            position: 'topRight'
                        });
                    }
                    if (nama == "") {
                        iziToast.error({
                            title: 'Pesan Gagal!',
                            message: 'Nama Lengkap dan Gelar wajib diisi',
                            position: 'topRight'
                        });
                    }
                    if (nick == "") {
                        iziToast.error({
                            title: 'Pesan Gagal!',
                            message: 'Nama Panggilan wajib diisi',
                            position: 'topRight'
                        });
                    }
                    if (temp_lahir == "") {
                        iziToast.error({
                            title: 'Pesan Gagal!',
                            message: 'Tempat Lahir wajib diisi',
                            position: 'topRight'
                        });
                    }
                    if (tgl_lahir == "") {
                        iziToast.error({
                            title: 'Pesan Gagal!',
                            message: 'Tanggal Lahir wajib diisi',
                            position: 'topRight'
                        });
                    }
                    if (jns_kelamin == "") {
                        iziToast.error({
                            title: 'Pesan Gagal!',
                            message: 'Jenis Kelamin wajib diisi',
                            position: 'topRight'
                        });
                    }
                    if (status_kawin == "") {
                        iziToast.error({
                            title: 'Pesan Gagal!',
                            message: 'Status Kawin wajib diisi',
                            position: 'topRight'
                        });
                    }
                    if (ktp_provinsi == "") {
                        iziToast.error({
                            title: 'Pesan Gagal!',
                            message: 'Lengkapi Data Alamat',
                            position: 'topRight'
                        });
                    }
                    if (alamat_ktp == "") {
                        iziToast.error({
                            title: 'Pesan Gagal!',
                            message: 'Alamat Lengkap wajib diisi',
                            position: 'topRight'
                        });
                    }
                    if (no_hp == "") {
                        iziToast.error({
                            title: 'Pesan Gagal!',
                            message: 'No HP wajib diisi',
                            position: 'topRight'
                        });
                    }
                    if (email == "") {
                        iziToast.error({
                            title: 'Pesan Gagal!',
                            message: 'Email wajib diisi',
                            position: 'topRight'
                        });
                    }
                    return false;
                } else {
                    $("#formUpdate").one('submit', function() {
                        //stop submitting the form to see the disabled button effect
                        $("#btn-simpan").attr('disabled', 'disabled');
                        $("#btn-simpan").find("i").toggleClass("fa-save fa-sync fa-spin");

                        return true;
                    });
                }
            });

        })

        // FUNCTION-FUNCTION
    </script>
@endsection
