@extends('layouts.default')

@section('content')
    {{-- <style>
        .select2-container {
            width: 100% !important;
        }
    </style> --}}
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Akreditasi MFK - Kecelakaan Kerja - Tambah Data</h4>
            </div>
        </div>
    </div>

    <div class="card" style="overflow: visible;">
        <div class="card-body">
            <h4 classs="card-title">
                <div class="btn-group">
                    <button class="btn btn-soft-dark" onclick="window.location='{{ route('accidentreport.index') }}'"><i
                        class="fas fa-arrow-left"></i>&nbsp;&nbsp;Kembali</button>
                </div>
            </h4>
            <form class="form-auth-small" name="formTambah" action="{{ route('accidentreport.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <hr>
                    <h4 class="mb-3 text-primary">A. Identifikasi Kecelakaan</h4>
                    <hr>
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label>Waktu <a class="text-danger">*</a></label>
                            <input type="datetime-local" class="form-control" name="tgl"
                                placeholder="Pilih Tanggal dan Waktu" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label>Lokasi <a class="text-danger">*</a></label>
                            <input type="text" name="lokasi" id="lokasi" class="form-control"
                                placeholder="" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label>Jenis Kecelakaan <a class="text-danger">*</a></label>
                            <select class="select2 form-select" name="jenis" id="jenis"
                                required>
                                <option value="">Pilih</option>
                                <option value="1">Menabrak</option>
                                <option value="2">Tertabrak</option>
                                <option value="3">Terperangkap</option>
                                <option value="4">Terbentur / Terpukul</option>
                                <option value="5">Tergelincir</option>
                                <option value="6">Terjepit</option>
                                <option value="7">Tersangkut</option>
                                <option value="8">Tertimbun</option>
                                <option value="9">Terhirup</option>
                                <option value="10">Tenggelam</option>
                                <option value="11">Jatuh dari ketinggian yang sama</option>
                                <option value="12">Jatuh dari ketinggian yang berbeda</option>
                                <option value="13">Kontak dengan (Arus Listrik, Suhu Panas, Suhu Dingin, Terpapar
                                    Radiasi, Bahan Kimia Berbahaya)</option>
                                <option value="14">Lain-lain</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div id="lainlain" class="row" hidden>
                            <div class="form-group mb-3">
                                <label>Lain-lain</label>
                                <textarea class="form-control" name="lain1" id="lain1" placeholder="" maxlength="190" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group mb-3">
                            <label>Kronologi Kecelakaan <a class="text-danger">*</a></label>
                            <textarea class="form-control" name="kronologi" id="kronologi1" placeholder="" maxlength="190" rows="3" required></textarea>
                        </div>
                    </div>
                    <hr>
                    <h4 class="mb-3 text-primary">B. Kerugian</h4>
                    <hr>
                    <div class="row">
                        <div class="col">
                            <div class="form-group mb-3">
                                <label>Kerugian Pada Manusia</label><br>
                                <div class="checkbox-group required">
                                    <input class="form-check-input" type="radio" name="kerugian" id="radio-kerugian1" value="1" checked>
                                    <label for="radio-kerugian1"><mark>Tak Cedera</mark> (Tidak ada cedera dan tidak ada hilang hari kerja)</label><br>
                                    <input class="form-check-input" type="radio" name="kerugian" id="radio-kerugian2" value="2">
                                    <label for="radio-kerugian2"><mark>Cedera Ringan</mark> (Mengalami cedera ringan/mendapat P3K tapi tidak ada hilang hari kerja)</label><br>
                                    <input class="form-check-input" type="radio" name="kerugian" id="radio-kerugian3" value="3">
                                    <label for="radio-kerugian3"><mark>Cedera Sedang</mark> (Mengalami cedera yang memerlukan pertolongan medis tapi adanya hilang hari kerja)</label><br>
                                    <input class="form-check-input" type="radio" name="kerugian" id="radio-kerugian4" value="4">
                                    <label for="radio-kerugian4"><mark>Cedera Berat</mark> (Mengalami cedera yang memerlukan pertolongan medis dan atau rujukan medis, cacat sementara dan adanya hilang hari kerja)</label><br>
                                    <input class="form-check-input" type="radio" name="kerugian" id="radio-kerugian5" value="5">
                                    <label for="radio-kerugian5"><mark>Meninggal/Fatal</mark> (Mengalami cacat permanen atau kematian)</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label>Nama Korban <a class="text-danger">*</a><input type="checkbox" class="checkbox_check me-2" style="margin-left: 8px" onclick="validateLuarRs()" id="luarrs">Luar RS ?</label>
                            {{-- <div class="input-group"> --}}
                                <div class="korban1">
                                    <select class="select2 form-select korban1select" name="korban" required>
                                        <option value="">Pilih Karyawan</option>
                                        @foreach($list['user'] as $us => $item)
                                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <input type="text" name="korban_luar" class="form-control korban2" placeholder="Tuliskan Nama Korban dari luar Rumah Sakit" hidden>
                            {{-- </div> --}}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Unit/Jabatan/Jenis <a class="text-danger">*</a></label>
                            <div class="korban1">
                                <select class="select2 form-select korban1select" name="role" id="unit" required>
                                    <option value="">Pilih</option>
                                    @foreach($list['unit'] as $name => $item)
                                        <option value="{{ $item->name }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <input type="text" name="role_luar" class="form-control korban2" placeholder="e.g. Tukang Sampah" hidden>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group mb-3">
                            <label>Tanggal Lahir <a class="text-danger">*</a></label>
                            <input type="date" name="lahir" class="form-control"
                                placeholder="YYYY-MM-DD" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group mb-3">
                            <label>Jenis Kelamin <a class="text-danger">*</a></label>
                                <select id="jk" name="jk" class="select2 form-select" required>
                                    <option value="">Pilih</option>
                                    <option value="laki-laki">Laki-laki</option>
                                    <option value="perempuan">Perempuan</option>
                                </select>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group mb-3">
                            <label>Bila cedera / cacat, anggota tubuh mana yang terkena?</label>
                            <input type="text" name="cedera" id="cedera" class="form-control"
                                placeholder="">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group mb-3">
                            <label>Penanganan <a class="text-danger">*</a></label>
                            <textarea class="form-control" name="penanganan" id="penanganan1" placeholder="" maxlength="190" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Kerugian Aset/Material/Proses</label>
                            <input type="text" name="k_aset" id="k_aset" class="form-control"
                                placeholder="">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Kerugian Lingkungan</label>
                            <input type="text" name="k_lingkungan" id="k_lingkungan" class="form-control"
                                placeholder="">
                        </div>
                    </div>
                    <hr>
                    <h4 class="mb-3 text-primary">C. Investigasi Kecelakaan</h4>
                    <hr>
                    <h5>1. Penyebab Langsung</h5>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Tindakan Tidak Aman <i>(Unsafe Action)</i> <a class="text-danger">*</a></label>
                            <input type="text" name="tta" id="tta" class="form-control"
                                placeholder="" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Kondisi Tidak Aman <i>(Unsafe Condition)</i> <a class="text-danger">*</a></label>
                            <input type="text" name="kta" id="kta" class="form-control"
                                placeholder="" required>
                        </div>
                    </div>
                    <br>
                    <h5>2. Penyebab Dasar</h5>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Faktor Personal <a class="text-danger">*</a></label>
                            <input type="text" name="f_personal" id="f_personal" class="form-control"
                                placeholder="" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Faktor Pekerjaan <a class="text-danger">*</a></label>
                            <input type="text" name="f_pekerjaan" id="f_pekerjaan" class="form-control"
                                placeholder="" required>
                        </div>
                    </div>
                    <br>
                    <h5>3. Alat / Sumber Yang Terlibat Pada Kecelakaan</h5>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Peralatan Kerja <a class="text-danger">*</a></label>
                            <input type="text" name="p_kerja" id="p_kerja" class="form-control"
                                placeholder="" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Benda Bergerak</label>
                            <input type="text" name="benda_bergerak" id="benda_bergerak"
                                class="form-control" placeholder="">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Mesin</label>
                            <input type="text" name="mesin" id="mesin" class="form-control"
                                placeholder="">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Bejana Tekan</label>
                            <input type="text" name="bejana_tekan" id="bejana_tekan" class="form-control"
                                placeholder="">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Material</label>
                            <input type="text" name="material" id="material" class="form-control"
                                placeholder="">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Alat Listrik</label>
                            <input type="text" name="alat_listrik" id="alat_listrik" class="form-control"
                                placeholder="">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Alat Berat</label>
                            <input type="text" name="alat_berat" id="alat_berat" class="form-control"
                                placeholder="">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Radiasi</label>
                            <input type="text" name="radiasi" id="radiasi" class="form-control"
                                placeholder="">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Kendaraan</label>
                            <input type="text" name="kendaraan" id="kendaraan" class="form-control"
                                placeholder="">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Binatang</label>
                            <input type="text" name="binatang" id="binatang" class="form-control"
                                placeholder="">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group mb-3">
                            <label>Lain-lain</label>
                            <textarea class="form-control" name="lain2" id="lain2" placeholder="" maxlength="190" rows="3"></textarea>
                        </div>
                    </div>
                    <hr>
                    <h4 class="mb-3 text-primary">D. Rencana Tindakan Perbaikan</h4>
                    <hr>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Rencana Tindakan <a class="text-danger">*</a></label>
                            <textarea class="form-control" name="r_tindakan" id="r_tindakan" placeholder="" maxlength="190" rows="2" required></textarea>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label>Target Waktu <a class="text-danger">*</a></label>
                            <textarea class="form-control" name="t_waktu" id="t_waktu" placeholder="" maxlength="190" rows="2" required></textarea>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label>Wewenang <a class="text-danger">*</a></label>
                            <textarea class="form-control" name="wewenang" id="wewenang" placeholder="" maxlength="190" rows="2" required></textarea>
                        </div>
                    </div>
                    <hr>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Lampiran</label>
                            <input type="file" name="file" class="form-control">
                        </div>
                    </div>
                </div>
                <hr>
                <center><button class="btn btn-primary" id="btn-simpan" onclick="saveData()"><i class="fa-fw fas fa-save nav-icon"></i> Submit Laporan</button></center>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('div.checkbox-group.required :checkbox:checked').length > 0
            // SELECT2
            var te = $(".select2");
            te.length && te.each(function() {
                var es = $(this);
                es.wrap('<div class="position-relative"></div>').select2({
                    placeholder: "Pilih",
                    dropdownParent: es.parent()
                })
            });

            // DATEPICKER
            const today = new Date();
            var tomorrow = new Date(today);
            tomorrow.setDate(tomorrow.getDate() + 1);
            var next = new Date(today);
            next.setDate(next.getDate() + 999999);
            const l = $('.flatpickr');
            const full = $('.flatpickrfull');
            // const dates = new Date(Date.now());
            // const tomorow = dates.getTime();
            // const m = new Date(Date.now());
            // const c = new Date(Date.now() + 1728e5); // 3 hari kedepan
            var now = moment().locale('id').format('Y-MM-DD HH:mm');
            l.flatpickr({
                enableTime: 0,
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
            })
            full.flatpickr({
                // mode: "range",
                dateFormat: "",
                enableTime: true,
                // dateFormat: "d M y, H:i",
                dateFormat: "Y-m-d H:i",
                time_24hr: true
            })

            // JENIS CHANGE
            $('#jenis').change(function() {
                if ($(this).val() == 14) {
                    $('#lainlain').prop('hidden',false);
                } else {
                    $('#lainlain').prop('hidden',true);
                }
            });
        })

        function saveData() {
            $("#formTambah").one('submit', function() {
                //stop submitting the form to see the disabled button effect
                $("#btn-simpan").attr('disabled','disabled');
                $("#btn-simpan").find("i").toggleClass("fa-save fa-spinner fa-spin");

                return true;
            });
        }

        function validateLuarRs() {
            if ($('input.checkbox_check').is(':checked')) {
                $(".korban1").prop('hidden', true);
                $(".korban2").prop('hidden', false);
                $(".korban1select").prop('required', false);
                $(".korban2").prop('required', true);
                $(".korban1select").val('').trigger('change');
                $(".korban2").val('');
            } else {
                $(".korban1").prop('hidden', false);
                $(".korban2").prop('hidden', true);
                $(".korban1select").prop('required', true);
                $(".korban2").prop('required', false);
                $(".korban1select").val('').trigger('change');
                $(".korban2").val('');
            }
        }
    </script>
@endsection

