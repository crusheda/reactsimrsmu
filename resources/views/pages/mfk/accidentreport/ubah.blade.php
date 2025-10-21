@extends('layouts.index')

@section('content')

    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i></a></li>
                        <li class="breadcrumb-item">Akreditasi</li>
                        <li class="breadcrumb-item">MFK</li>
                        <li class="breadcrumb-item">Kecelakaan Kerja</li>
                        <li class="breadcrumb-item" aria-current="page">Ubah</li>
                    </ul>
                </div>
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h2 class="mb-0">Form Ubah Kecelakaan Kerja</h2>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- [ breadcrumb ] end -->

    <!-- [ Main Content ] start -->
    <div class="row pt-1">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between py-3">
                    <div class="btn-group flex-grow-0">
                        <button class="btn btn-link-dark" onclick="window.location='{{ route('accidentreport.index') }}'"><i
                            class="fas fa-arrow-left"></i>&nbsp;&nbsp;Kembali</button>
                    </div>
                    <div class="flex-shrink-1">
                        <h6>Tanda <a class="text-danger">*</a> Wajib Disi</h6>
                    </div>
                </div>
                <div class="card-body">
                    {{-- {{ Form::model($list['show'], array('route' => array('accidentreport.update', $list['show']->id), 'method' => 'PUT', 'class'=>'')) }} --}}
                    {{ Form::open(['route' => array('accidentreport.update','id='.$list['show']->id), 'method' => 'PUT', 'class'=>'']) }}
                        @csrf
                        <div class="row">
                            <div class="col-md-12"><div class="alert alert-secondary p-3"><h4 class="mb-0 text-primary">A. Identifikasi Kecelakaan</h4></div></div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label">Waktu <a class="text-danger">*</a></label>
                                    <input type="datetime-local" class="form-control" name="tgl"
                                    placeholder="Pilih Tanggal dan Waktu" value="{{ $list['show']->tgl }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label">Lokasi <a class="text-danger">*</a></label>
                                    <input type="text" name="lokasi" id="lokasi" value="{{ $list['show']->lokasi }}" class="form-control"
                                        placeholder="">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label">Jenis Kecelakaan <a class="text-danger">*</a></label>
                                    <select class="select2 form-select" name="jenis" id="jenis"
                                        required>
                                        <option value="1" @if ($list['show']->jenis == '1') echo selected @endif>Menabrak</option>
                                        <option value="2" @if ($list['show']->jenis == '2') echo selected @endif>Tertabrak</option>
                                        <option value="3" @if ($list['show']->jenis == '3') echo selected @endif>Terperangkap</option>
                                        <option value="4" @if ($list['show']->jenis == '4') echo selected @endif>Terbentur / Terpukul</option>
                                        <option value="5" @if ($list['show']->jenis == '5') echo selected @endif>Tergelincir</option>
                                        <option value="6" @if ($list['show']->jenis == '6') echo selected @endif>Terjepit</option>
                                        <option value="7" @if ($list['show']->jenis == '7') echo selected @endif>Tersangkut</option>
                                        <option value="8" @if ($list['show']->jenis == '8') echo selected @endif>Tertimbun</option>
                                        <option value="9" @if ($list['show']->jenis == '9') echo selected @endif>Terhirup</option>
                                        <option value="10" @if ($list['show']->jenis == '10') echo selected @endif>Tenggelam</option>
                                        <option value="11" @if ($list['show']->jenis == '11') echo selected @endif>Jatuh dari ketinggian yang sama</option>
                                        <option value="12" @if ($list['show']->jenis == '12') echo selected @endif>Jatuh dari ketinggian yang berbeda</option>
                                        <option value="13" @if ($list['show']->jenis == '13') echo selected @endif>Kontak dengan (Arus Listrik, Suhu Panas, Suhu Dingin, Terpapar Radiasi, Bahan Kimia Berbahaya)</option>
                                        <option value="14" @if ($list['show']->jenis == '14') echo selected @endif>Lain-lain</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div id="lainlain" class="row" @if ($list['show']->jenis != '14') echo hidden @endif>
                                    <div class="form-group mb-3">
                                        <label class="form-label">Lain-lain</label>
                                        <textarea class="form-control" name="lain1" id="lain1" placeholder="" maxlength="190" rows="2"><?php echo htmlspecialchars($list['show']->lain1); ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label class="form-label">Kronologi Kecelakaan <a class="text-danger">*</a></label>
                                    <textarea class="form-control" name="kronologi" id="kronologi1" placeholder="" maxlength="190" rows="2" required><?php echo htmlspecialchars($list['show']->kronologi); ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-12"><div class="alert alert-secondary p-3"><h4 class="mb-0 text-primary text-center">B. Kerugian</h4></div></div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Kerugian Pada Manusia</label><br>
                                        <div class="checkbox-group required">
                                            <input class="form-check-input mb-2" type="radio" name="kerugian" id="radio-kerugian1" value="1" @if ($list['show']->kerugian == '1') echo checked @endif>
                                            <label for="radio-kerugian1"><mark>Tak Cedera</mark> (Tidak ada cedera dan tidak ada hilang hari kerja)</label><br>
                                            <input class="form-check-input mb-2" type="radio" name="kerugian" id="radio-kerugian2" value="2" @if ($list['show']->kerugian == '2') echo checked @endif>
                                            <label for="radio-kerugian2"><mark>Cedera Ringan</mark> (Mengalami cedera ringan/mendapat P3K tapi tidak ada hilang hari kerja)</label><br>
                                            <input class="form-check-input mb-2" type="radio" name="kerugian" id="radio-kerugian3" value="3" @if ($list['show']->kerugian == '3') echo checked @endif>
                                            <label for="radio-kerugian3"><mark>Cedera Sedang</mark> (Mengalami cedera yang memerlukan pertolongan medis tapi adanya hilang hari kerja)</label><br>
                                            <input class="form-check-input mb-2" type="radio" name="kerugian" id="radio-kerugian4" value="4" @if ($list['show']->kerugian == '4') echo checked @endif>
                                            <label for="radio-kerugian4"><mark>Cedera Berat</mark> (Mengalami cedera yang memerlukan pertolongan medis dan atau rujukan medis, cacat sementara dan adanya hilang hari kerja)</label><br>
                                            <input class="form-check-input mb-2" type="radio" name="kerugian" id="radio-kerugian5" value="5" @if ($list['show']->kerugian == '5') echo checked @endif>
                                            <label for="radio-kerugian5"><mark>Meninggal/Fatal</mark> (Mengalami cacat permanen atau kematian)</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Nama Korban <a class="text-danger">*</a></label>
                                    <input type="text" name="korban" id="korban" value="{{ $list['show']->korban }}" class="form-control"
                                        placeholder="" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Unit <a class="text-danger">*</a></label>
                                    <select class="form-select" name="unit" id="unit" required>
                                        @foreach($list['unit'] as $name => $key)
                                            <option value="{{ $name }}" @if ($list['show']->unit == $name) echo selected @endif>{{ $name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> --}}
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Nama Korban <a class="text-danger">*</a></label>
                                    <input type="text" value="{{ $list['show']->nama_korban }}{{ $list['show']->korban_luar }}" class="form-control" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Unit/Jabatan/Jenis <a class="text-danger">*</a></label>
                                    <input type="text" value="{{ $list['show']->role }}" class="form-control" disabled>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group mb-3">
                                    <label class="form-label">Tanggal Lahir <a class="text-danger">*</a></label>
                                    <input type="date" name="lahir" value="{{ $list['show']->lahir }}" class="form-control"
                                        placeholder="YYYY-MM-DD" required>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group mb-3">
                                    <label class="form-label">Jenis Kelamin <a class="text-danger">*</a></label>
                                    <select id="jk" name="jk" class="select2 form-select" required>
                                        <option value="">Pilih</option>
                                        <option value="laki-laki" @if ($list['show']->jk == 'laki-laki') echo selected @endif>Laki-laki</option>
                                        <option value="perempuan" @if ($list['show']->jk == 'perempuan') echo selected @endif>Perempuan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group mb-3">
                                    <label class="form-label">Bila cedera / cacat, anggota tubuh mana yang terkena? </label>
                                    <input type="text" name="cedera" id="cedera" value="{{ $list['show']->cedera }}" class="form-control"
                                        placeholder="">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label class="form-label">Penanganan <a class="text-danger">*</a></label>
                                    <textarea class="form-control" name="penanganan" id="penanganan1" placeholder="" maxlength="190" rows="2" required><?php echo htmlspecialchars($list['show']->penanganan); ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Kerugian Aset/Material/Proses</label>
                                    <input type="text" name="k_aset" id="k_aset" value="{{ $list['show']->k_aset }}" class="form-control"
                                        placeholder="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Kerugian Lingkungan</label>
                                    <input type="text" name="k_lingkungan" id="k_lingkungan" value="{{ $list['show']->k_lingkungan }}" class="form-control"
                                        placeholder="">
                                </div>
                            </div>
                            <div class="col-md-12"><div class="alert alert-secondary p-3"><h4 class="mb-0 text-primary text-center">C. Investigasi Kecelakaan</h4></div></div>
                            <h5>1. Penyebab Langsung</h5>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Tindakan Tidak Aman <i>(Unsafe Action)</i> <a class="text-danger">*</a></label>
                                    <input type="text" name="tta" id="tta" value="{{ $list['show']->tta }}" class="form-control"
                                        placeholder="" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Kondisi Tidak Aman <i>(Unsafe Condition)</i> <a class="text-danger">*</a></label>
                                    <input type="text" name="kta" id="kta" value="{{ $list['show']->kta }}" class="form-control"
                                        placeholder="" required>
                                </div>
                            </div>
                            <br>
                            <h5>2. Penyebab Dasar</h5>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Faktor Personal <a class="text-danger">*</a></label>
                                    <input type="text" name="f_personal" id="f_personal" value="{{ $list['show']->f_personal }}" class="form-control"
                                        placeholder="" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Faktor Pekerjaan <a class="text-danger">*</a></label>
                                    <input type="text" name="f_pekerjaan" id="f_pekerjaan" value="{{ $list['show']->f_pekerjaan }}" class="form-control"
                                        placeholder="" required>
                                </div>
                            </div>
                            <br>
                            <h5>3. Alat / Sumber Yang Terlibat Pada Kecelakaan</h5>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Peralatan Kerja <a class="text-danger">*</a></label>
                                    <input type="text" name="p_kerja" id="p_kerja" value="{{ $list['show']->p_kerja }}" class="form-control"
                                        placeholder="" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Benda Bergerak</label>
                                    <input type="text" name="benda_bergerak" id="benda_bergerak" value="{{ $list['show']->benda_bergerak }}"
                                        class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Mesin</label>
                                    <input type="text" name="mesin" id="mesin" value="{{ $list['show']->mesin }}" class="form-control"
                                        placeholder="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Bejana Tekan</label>
                                    <input type="text" name="bejana_tekan" id="bejana_tekan" value="{{ $list['show']->bejana_tekan }}" class="form-control"
                                        placeholder="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Material</label>
                                    <input type="text" name="material" id="material" value="{{ $list['show']->material }}" class="form-control"
                                        placeholder="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Alat Listrik</label>
                                    <input type="text" name="alat_listrik" id="alat_listrik" value="{{ $list['show']->alat_listrik }}" class="form-control"
                                        placeholder="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Alat Berat</label>
                                    <input type="text" name="alat_berat" id="alat_berat" value="{{ $list['show']->alat_berat }}" class="form-control"
                                        placeholder="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Radiasi</label>
                                    <input type="text" name="radiasi" id="radiasi" value="{{ $list['show']->radiasi }}" class="form-control"
                                        placeholder="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Kendaraan</label>
                                    <input type="text" name="kendaraan" id="kendaraan" value="{{ $list['show']->kendaraan }}" class="form-control"
                                        placeholder="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Binatang</label>
                                    <input type="text" name="binatang" id="binatang" value="{{ $list['show']->binatang }}" class="form-control"
                                        placeholder="">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label class="form-label">Lain-lain</label>
                                    <textarea class="form-control" name="lain2" id="lain2" placeholder="" maxlength="190" rows="2"><?php echo htmlspecialchars($list['show']->lain2); ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-12"><div class="alert alert-secondary p-3"><h4 class="mb-0 text-primary text-center">D. Rencana Tindakan Perbaikan</h4></div></div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Rencana Tindakan <a class="text-danger">*</a></label>
                                    <textarea class="form-control" name="r_tindakan" id="r_tindakan" placeholder="" maxlength="190" rows="2" required><?php echo htmlspecialchars($list['show']->r_tindakan); ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="form-label">Target Waktu <a class="text-danger">*</a></label>
                                    <textarea class="form-control" name="t_waktu" id="t_waktu" placeholder="" maxlength="190" rows="2" required><?php echo htmlspecialchars($list['show']->t_waktu); ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="form-label">Wewenang <a class="text-danger">*</a></label>
                                    <textarea class="form-control" name="wewenang" id="wewenang" placeholder="" maxlength="190" rows="2" required><?php echo htmlspecialchars($list['show']->wewenang); ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label class="form-label">Detail Lampiran</label><br>
                                    @if ($list['show']->filename == '')
                                        Tidak ada lampiran terupload.
                                    @else
                                        <b>{{ $list['show']->title }}</b> ({{Storage::size($list['show']->filename)}} bytes)
                                    @endif
                                </div>
                            </div>
                        </div>
                        <center><button class="btn btn-warning" id="btn-simpan" onclick="saveData()"><i class="fa-fw fas fa-edit nav-icon"></i> Ubah Laporan</button></center>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // SELECT2
            var te = $(".select2");
            te.length && te.each(function() {
                var es = $(this);
                es.wrap('<div class="position-relative"></div>').select2({
                    placeholder: "Pilih",
                    dropdownParent: es.parent()
                })
            });

            // JENIS CHANGE
            $('#jenis').change(function() {
                if ($(this).val() == 14) {
                    $('#lainlain').prop('hidden',false);
                } else {
                    $('#lainlain').prop('hidden',true);
                }
            });
        });
    </script>
@endsection
