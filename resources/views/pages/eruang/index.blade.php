@extends('layouts.index')

@section('content')

    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i></a></li>
                        <li class="breadcrumb-item">Administrasi</li>
                        <li class="breadcrumb-item" aria-current="page">E-Ruang</li>
                    </ul>
                </div>
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h2 class="mb-0">Pemesanan Ruangan</h2>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- [ breadcrumb ] end -->

    <!-- [ Main Content ] start -->
    <div class="row pt-1">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body" style="overflow: visible;">
                    <div class="float-end" id="btn_link_pengajuan">
                        <div class="dropdown">
                            <button type="button" class="btn btn-primary" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-info-circle"></i> <span class="d-none d-sm-inline-block"><i class="fas fa-caret-down ms-1 me-1"></i> Informasi</span></button>
                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-md">
                                <div class="dropdown-item-text">
                                    <div>
                                        <h6 class="mb-0 text-center"><mark>Pengajuan</mark></h6>
                                    </div>
                                </div>

                                <div class="dropdown-divider"></div>

                                <a class="dropdown-item" href="javascript:;">
                                    Disetujui : <span class="float-end ms-1">♾️</span>
                                </a>
                                <a class="dropdown-item" href="javascript:;">
                                    Diverifikasi : <span class="float-end ms-1">♾️</span>
                                </a>
                                <a class="dropdown-item" href="javascript:;">
                                    Ditolak : <span class="float-end ms-1">♾️</span>
                                </a>

                                <div class="dropdown-divider"></div>

                                @if (Auth::user()->getPermission('admin_eruang'))
                                    <a class="dropdown-item text-primary text-center" href="javascript:;" onclick="window.location='{{ route('eruang.ruangan') }}'">
                                        Lihat Daftar Ruangan
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="float-end" id="btn_link_riwayat" hidden>
                        <div class="input-daterange input-group bg-light rounded">
                            <input type="text" name="filter_tgl" class="form-control bg-transparent border-0 flatpickrunl" placeholder="Filter Tanggal Acara" aria-label="" aria-describedby="button-addon2" disabled>

                            <button class="btn btn-primary" type="button" id="button-addon2" data-bs-toggle="tooltip"
                            data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true"
                            title="Cari data berdasarkan tanggal acara" disabled><i class="fas fa-search align-middle"></i> </button>
                            <button type="button" class="btn btn-warning" onclick="riwayat()" data-bs-toggle="tooltip"
                            data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true"
                            title="Refresh Tabel Pemesanan Ruangan" id="btn-refresh-table"><i class="fas fa-sync fa-fw nav-icon me-1"></i>Segarkan</button>
                        </div>
                    </div>
                    <div class="float-end" id="btn_link_display" hidden>
                        <h5 href="#" id="detik"></h5>
                    </div>
                    <h4 class="card-title mb-4">E-Ruang</h4>
                    <div class="crypto-buy-sell-nav">
                        <ul class="nav nav-tabs nav-tabs-custom" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link text-dark active" id="link_pengajuan" data-bs-toggle="tab" href="#pengajuan" role="tab">
                                    Pengajuan
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-dark" id="link_riwayat" data-bs-toggle="tab" href="#riwayat" role="tab">
                                    Daftar Riwayat
                                </a>
                            </li>
                            @if (Auth::user()->getPermission('admin_eruang_gizi'))
                            <li class="nav-item">
                                <a class="nav-link text-dark" id="link_display" data-bs-toggle="tab" href="#display" role="tab">
                                    Display Gizi
                                </a>
                            </li>
                            @endif
                        </ul>

                        <div class="tab-content crypto-buy-sell-nav-content p-2">
                            <div class="tab-pane active" id="pengajuan" role="tabpanel">
                                <form>
                                    <div class="mb-3">
                                        <div class="row alert alert-secondary">
                                            {{-- <label class="form-label"><i class="ti ti-info-circle me-1"></i><mark>Ketentuan</mark></label><br> --}}
                                            <div class="col-md-6">
                                                <small><i class="ti ti-arrow-narrow-right me-1"></i> Peminjaman ruangan dapat dilakukan apabila ruangan tersebut tersedia/tidak terpakai dan pemilihan Jam & Menit tidak boleh sama</small><br>
                                                <small><i class="ti ti-arrow-narrow-right me-1"></i> Perubahan dan penghapusan data hanya dapat dilakukan sampai H-1 Acara & maksimal kurang dari Jam 12:00 WIB, tidak dalam kondisi ditolak oleh Admin, dan apabila sudah diverifikasi oleh bagian Gizi</small><br>
                                                <small><i class="ti ti-arrow-narrow-right me-1"></i> Permintaan khusus pada pesanan gizi dapat dilakukan dengan cara mengubah data setelah pengajuan</small>
                                            </div>
                                            <div class="col-md-6">
                                                <small><i class="ti ti-arrow-narrow-right me-1"></i> Apabila sudah diverifikasi oleh bagian Gizi, maka peminjaman ruangan tidak dapat dihapus, akan tetapi Anda masih dapat mengubahnya dengan sepengetahuan bagian Gizi (Konfirmasi terlebih dahulu)</small><br>
                                                <small><i class="ti ti-arrow-narrow-right me-1"></i> Admin memiliki kuasa sepenuhnya untuk melakukan penolakan maupun penghapusan pengajuan apabila pada tgl dan jam tersebut bertepatan dengan acara yang lebih dipentingkan</small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="">
                                        <label class="form-label">Pilih salah satu ruangan di bawah ini <a class="text-danger">*</a></label>

                                        <div class="row">

                                            @if (!empty($list['ruangan']))
                                                @foreach ($list['ruangan'] as $item)
                                                    @if ($item->akses != null)
                                                        @foreach (json_decode($item->akses) as $val)
                                                            @foreach ($list['role'] as $rol)
                                                                @if ($rol->id == $val)
                                                                    @if (Auth::user()->getRole($rol->name) == true)
                                                                        <div class="col-xl-2 col-sm-4">
                                                                            <div class="border card p-3" style="margin-bottom: 14px">
                                                                                <div class="form-check">
                                                                                    <input type="radio" name="ruangan" class="form-check-input input-primary" id="ruangan{{ $item->id }}" value="{{ $item->id }}">
                                                                                    <label class="form-check-label d-block" for="ruangan{{ $item->id }}">
                                                                                        <span>
                                                                                            <span class="h5 d-block">
                                                                                                <strong class="float-end">
                                                                                                    <span class="badge bg-light-primary">{{ $item->kapasitas }} P</span>
                                                                                                </strong>{{ $item->nama }}
                                                                                            </span>
                                                                                            <span class="f-12 text-muted">Fasilitas : {{ $item->fasilitas?$item->fasilitas:'-' }}</span>
                                                                                        </span>
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                @endif
                                                            @endforeach
                                                        @endforeach
                                                    @else
                                                        <div class="col-xl-3 col-sm-4">
                                                            <div class="border card p-3" style="margin-bottom: 14px">
                                                                <div class="form-check">
                                                                    <input type="radio" name="ruangan" class="form-check-input input-primary" id="ruangan{{ $item->id }}" value="{{ $item->id }}">
                                                                    <label class="form-check-label d-block" for="ruangan{{ $item->id }}">
                                                                        <span>
                                                                            <span class="h5 d-block">
                                                                                <strong class="float-end">
                                                                                    <span class="badge bg-light-primary">{{ $item->kapasitas }} P</span>
                                                                                </strong>{{ $item->nama }}
                                                                            </span>
                                                                            <span class="f-12 text-muted">Fasilitas : {{ $item->fasilitas?$item->fasilitas:'-' }}</span>
                                                                        </span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            @endif

                                        </div>
                                    </div>

                                    <div>
                                        <div class="row">
                                            <div class="col-sm-6 mb-3">
                                                <label class="form-label">Agenda Acara <a class="text-danger">*</a></label>
                                                <input type="text" id="agenda" class="form-control validasiTgl" placeholder="e.g. Rapat Paripurna Bagian **" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="Tuliskan nama acara"/>
                                            </div>
                                            <div class="col-sm-6 mb-3">
                                                <label class="form-label">Pilih Tanggal Acara <a class="text-danger">*</a></label>
                                                <div class="input-daterange input-group">
                                                    <input type="text" id="tgl" class="form-control flatpickrunl" onchange="verifSnackGiziTgl(this.value)" placeholder="yyyy-mm-dd" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="Tanggal acara"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <label class="form-label">Pilih Waktu Acara (<mark>Format 24h</mark>) <a class="text-danger">*</a></label>

                                        <div class="row" style="text-align: center">
                                            {{-- <div class="input-daterange input-group" id="datepicker6" data-date-format="dd-mm-yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'> --}}
                                                <div class="col-sm-6 mb-3">
                                                    <div class="input-daterange input-group clock-value">
                                                        <span class="input-group-text">Mulai</span>
                                                        <input id="jam_mulai" type="text" class="form-control {{-- flatpickrtime --}} pilihJam validasiTgl" data-provide="timepicker" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="Waktu/Jam mulai acara">
                                                    </div>
                                                </div>

                                                <div class="col-sm-6 mb-3">
                                                    <div class="input-daterange input-group">
                                                        <input id="jam_selesai" type="text" class="form-control {{-- flatpickrtimenext --}} pilihJam validasiTgl" data-provide="timepicker" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="Waktu/Jam selesai acara">
                                                        <span class="input-group-text">Selesai</span>
                                                    </div>
                                                </div>
                                            {{-- </div> --}}
                                        </div>
                                    </div>

                                    <div>
                                        <div class="row">
                                            <div class="col-sm-6 mb-3">
                                                <label class="form-label">Keterangan Acara</label>
                                                <textarea rows="1" class="form-control validasiTgl" id="ket" placeholder="Optional"></textarea>
                                            </div>
                                            <div class="col-sm-6 mb-3">
                                                <label class="form-label">Pesan Tambahan Untuk Bagian Gizi (<mark>isi nilai 0 apabila tidak diperlukan</mark>)</label>
                                                <div class="input-daterange input-group" id="show_gizi1">
                                                    <span class="input-group-text">Snack</span>
                                                    <input type="number" class="form-control" disabled>
                                                    <span class="input-group-text">Makan</span>
                                                    <input type="number" class="form-control" disabled>
                                                    <span class="input-group-text">Minum</span>
                                                    <input type="number" class="form-control" disabled>
                                                </div>
                                                <div class="input-daterange input-group" id="show_gizi2" hidden>
                                                    <span class="input-group-text pilih_snack">Snack</span>
                                                    <input id="snack" type="number" class="form-control pilih_snack" value="0" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="Jumlah Permintaan Snack">
                                                    <span class="input-group-text">Makan</span>
                                                    <input id="makan" type="number" class="form-control" value="0" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="Jumlah Permintaan Makanan">
                                                    <span class="input-group-text">Minum</span>
                                                    <input id="minum" type="number" class="form-control" value="0" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="Jumlah Permintaan Minuman">
                                                </div>
                                                {{-- <textarea rows="2" class="form-control" id="gizi" placeholder="e.g. Tolong siapkan snack untuk 10 peserta pelatihan terima kasih" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="Pesan ini akan tersampaikan ke bagian Gizi"></textarea> --}}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-center mt-4">
                                        <button type="button" class="btn btn-success validasiTgl" id="btn-simpan" onclick="prosesSimpan()" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="Ajukan untuk melanjutkan proses Verifikasi Jadwal"><i class="fas fa-stamp"></i>&nbsp;&nbsp;Ajukan Sekarang</button>
                                    </div>
                                </form>
                            </div>

                            <div class="tab-pane table-responsive" id="riwayat" role="tabpanel">
                                <table class="table align-middle dt-responsive w-100 table-check table-hover nowrap" id="dttable" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th scope="col"><center>Aksi</center></th>
                                            <th scope="col">Nama Ruangan</th>
                                            <th scope="col">Peminjam</th>
                                            <th scope="col">Tanggal Acara</th>
                                            <th scope="col">Waktu Acara</th>
                                            <th scope="col">Keterangan</th>
                                            <th scope="col">Pesanan Gizi</th>
                                            <th scope="col">Alasan Penolakan</th>
                                            <th scope="col">Diperbarui</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tampil-tbody"></tbody>
                                </table>
                            </div>

                            <div class="tab-pane" id="display" role="tabpanel" style="height:auto">

                                <div class="row g-3 mb-4">
                                    <div class="col-xxl-12 alert alert-secondary m-b-0">
                                        <small><i class="ti ti-arrow-narrow-right me-1"></i> Pengajuan Peminjaman Ruangan dapat diverifikasi oleh Bagian Gizi Mulai dari <kbd>H-1 Acara setelah Pukul 12:00 WIB</kbd> sampai <kbd>Hari H Acara Pukul 23:59 WIB</kbd></small><br>
                                        <small><i class="ti ti-arrow-narrow-right me-1"></i> Data yang ditampilkan diurutkan berdasarkan <mark>Tanggal Terdekat</mark> lalu berdasarkan <strong>Jam dari yang paling Awal</strong></small><br>
                                        <small><i class="ti ti-arrow-narrow-right me-1"></i> Display diperbarui secara otomatis per 5 menit sekali dengan tampilan yang dibatasi (<strong>5 Antrean</strong>)</small>
                                    </div>
                                    <div class="col-xxl-5 col-lg-4">
                                        <div class="position-relative">
                                            <select class="select2 form-control validasiTgl" id="tampil_gizi_ruangan" style="width: 100%" data-bs-auto-close="outside" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="Pilih salah satu/Kosongi untuk menampilkan semua Ruangan">
                                                <option value="" selected hidden>Pilih Ruangan</option>
                                                @if (!empty($list['ruangan']))
                                                    @foreach ($list['ruangan'] as $item)
                                                        <option value="{{ $item->id }}">{{ $item->nama }} ({{ $item->kapasitas }} Peserta)</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xxl-2 col-lg-6">
                                        <div class="position-relative">
                                            <div id="datepicker1">
                                                <input type="text" class="form-control" id="tampil_gizi_tgl" placeholder="Pilih Tanggal" data-date-format="yyyy-mm-dd" data-date-container='#datepicker1' data-date-autoclose="true" data-provide="datepicker" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xxl-3 col-lg-6">
                                        <div class="position-relative">
                                            <select class="select2 form-control" id="tampil_gizi_status" style="width: 100%" data-bs-auto-close="outside" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="Pilih Status Verifikasi">
                                                <option value="0" hidden>Semua Data</option>
                                                <option value="1" selected>Belum Diverifikasi</option>
                                                <option value="2">Sudah Diverifikasi</option>
                                                <option value="3">Ditolak</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xxl-2 col-lg-6" id="start-display">
                                        <div class="position-relative h-100 hstack gap-3">
                                            <button type="submit" class="btn btn-primary h-100 w-100" id="btn-tampil-gizi" onclick="showDisplay()"><i class="fas fa-tv align-middle me-1"></i> Tampilkan Display</button>
                                        </div>
                                    </div>
                                    <div class="col-xxl-2 col-lg-6" id="stop-display" hidden>
                                        <div class="position-relative h-100 hstack gap-3">
                                            <button type="submit" class="btn btn-danger h-100 w-100" id="btn-tampil-gizi" onclick="stopDisplay()"><i class="fas fa-times align-middle me-1"></i> Berhenti</button>
                                        </div>
                                    </div>
                                </div>

                                {{-- START DISPLAY --}}
                                <div class="row" id="show_tampil_display">
                                    <div class="row justify-content-center mt-lg-5">
                                        <div class="col-xl-5 col-sm-8">
                                            <div class="text-center">
                                                <div class="row justify-content-center mt-2 mb-2">
                                                    <div class="col-sm-6 col-8">
                                                        <img src="{{ asset('images/verification-img.png') }}" alt="" class="img-fluid">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- END DISPLAY -->

                            </div>

                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <!-- MODAL UBAH -->
    <div class="modal fade" tabindex="-1" id="modalUbah" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="orderdetailsModalLabel">Ubah Data Peminjaman <kbd>ID : <b id="id_show_edit"></b></kbd></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="text" id="id_edit" hidden>
                    <div class="row">
                        <div class="col-md-5 mb-3">
                            <div class="form-group">
                                <label class="form-label">Ruangan <a class="text-danger">*</a></label>
                                <input type="text" class="form-control" id="show_ruangan_edit" disabled>
                                {{-- <select class="select2 form-control" id="ruangan_edit" style="width: 100%" data-bs-auto-close="outside" hidden></select> --}}
                                <input type="text" class="form-control" id="ruangan_edit" hidden>
                            </div>
                        </div>
                        <div class="col-md-5 mb-3">
                            <div class="form-group">
                                <label class="form-label">Agenda Acara <a class="text-danger">*</a></label>
                                <input type="text" id="agenda_edit" class="form-control" placeholder="e.g. Rapat Rutin Bagian **">
                            </div>
                        </div>
                        <div class="col-md-2 mb-3">
                            <div class="form-group">
                                <label class="form-label">Tanggal Acara <a class="text-danger">*</a></label>
                                <input type="text" id="show_tgl_edit" class="form-control" placeholder="YYYY-MM-DD" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="Tanggal acara" disabled/>
                                <input type="text" id="tgl_edit" class="form-control" placeholder="YYYY-MM-DD" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="Tanggal acara" hidden/>
                            </div>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label class="form-label">Keterangan</label>
                            <textarea rows="4" class="form-control" id="ket_edit" placeholder="Optional"></textarea>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label">Pesan Tambahan Untuk Bagian Gizi</label>
                            <textarea rows="4" class="form-control" id="gizi_edit" placeholder="e.g. Tolong siapkan snack untuk 10 peserta pelatihan terima kasih"></textarea>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" id="btn-ubah" onclick="prosesUbah()"><i class="fa-fw fas fa-edit nav-icon me-1" style="font-size:13px"></i> Ubah</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fa-fw fas fa-times nav-icon me-1" style="font-size:13px"></i> Tutup</button>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL HAPUS --}}
    <div class="modal animate__animated animate__rubberBand fade" id="modalHapus" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-simple modal-add-new-address modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        Form Hapus Peminjaman Ruangan
                    </h4>
                </div>
                <div class="modal-body">
                    <input type="text" id="id_hapus" hidden>
                    <p style="text-align: justify;">Anda akan menghapus Pengajuan Peminjaman Ruangan tersebut, lakukanlah dengan hati-hati. Ceklis dibawah untuk melanjutkan penghapusan.</p>
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

    {{-- MODAL TOLAK --}}
    <div class="modal animate__animated animate__rubberBand fade" id="modalTolak" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-simple modal-add-new-address modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        Form Penolakan Peminjaman Ruangan
                    </h4>
                </div>
                <div class="modal-body">
                    <input type="text" id="id_tolak" hidden>
                    <div class="form-group">
                        <label for="" class ="form-label">Tuliskan Alasan Penolakan <a class="text-danger">*</a></label>
                        <textarea rows="2" class="form-control" id="alasan_penolakan" placeholder="e.g. Pada Tanggal dan Jam tersebut Ruangan akan direnovasi"></textarea>
                    </div>
                    <small><i class="mdi mdi-arrow-right text-primary me-1"></i> Penolakan akan gagal apabila sudah diverifikasi oleh bagian Gizi</small>
                </div>
                <div class="col-12 text-center mb-4">
                    <button type="submit" id="btn-hapus" class="btn btn-dark me-sm-3 me-1" onclick="prosesTolak()"><i class="fas fa-calendar-times me-1" style="font-size:13px"></i> Tolak</button>
                    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-times me-1" style="font-size:13px"></i> Batal</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal animate__animated animate__rubberBand fade" id="modalAlasanPenolakan" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-simple modal-add-new-address modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        Alasan Penolakan
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <textarea rows="4" class="form-control" id="show_alasan_penolakan" disabled></textarea>
                    </div>
                </div>
                <div class="col-12 text-center mb-4">
                    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-times me-1" style="font-size:13px"></i> Tutup</button>
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

            // DATEPICKER
            // $('#tgl').datepicker({
            //     autoclose: true,format:'yyyy-mm-dd',
            // }).datepicker("setDate",'now');

            // DATE
            const today = new Date();
            var tomorrow = new Date(today);
            tomorrow.setDate(tomorrow.getDate() + 1);
            var next = new Date(today);
            next.setDate(next.getDate() + 999999);
            const l = $('.flatpickr');
            const ln = $('.flatpickrnow');
            const lun = $('.flatpickrunl');
            const ltom = $('.flatpickrtom');
            const rang = $('.flatpickrrange');
            const time = $('.flatpickrtime');
            const timenext = $('.flatpickrtimenext');
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
            ln.flatpickr({
                enableTime: 0,
                defaultDate: now,
                minuteIncrement: 1,
                time_24hr: true,
                defaultMinute: "today",
                disable: [{
                    from: tomorrow.toISOString().split("T")[0],
                    to: next.toISOString().split("T")[0]
                }]
            })
            lun.flatpickr({
                enableTime: 0,
                minuteIncrement: 1,
                time_24hr: true,
                // defaultMinute: "today",
                // disable: [{
                //     from: tomorrow.toISOString().split("T")[0],
                //     to: next.toISOString().split("T")[0]
                // }]
            })
            ltom.flatpickr({
                enableTime: 0,
                minuteIncrement: 1,
                time_24hr: true,
                // defaultMinute: "today",
                minDate: "today",
                maxDate: "01.01.3000"
                // disable: [{
                //     from: tomorrow.toISOString().split("T")[0],
                //     to: today
                // }]
            })
            rang.flatpickr({
                mode: "range",
                minDate: "today",
                dateFormat: "",
                disable: [
                    // function(date) {
                        // disable every multiple of 8
                    //     return !(date.getDate() % 8);
                    // }
                ],
                enableTime: true,
                dateFormat: "d M y, H:i",
                // dateFormat: "Y-MM-DD HH:mm",
                time_24hr: true
            })
            time.flatpickr({
                defaultDate: "08:00", // now
                enableTime: true,
                noCalendar: true,
                time_24hr: true,
                dateFormat: "H:i",
            })
            timenext.flatpickr({
                // defaultDate: now,
                enableTime: true,
                noCalendar: true,
                time_24hr: true,
                dateFormat: "H:i",
            })

            // $('#jam_mulai').timepicker({
            //     showMeridian: false,
            //     icons: {
            //         up: 'mdi mdi-chevron-up',
            //         down: 'mdi mdi-chevron-down'
            //     },
            //     appendWidgetTo: "#timepicker-input-group1"
            // });
            // $('#jam_selesai').timepicker({
            //     showMeridian: false,
            //     icons: {
            //         up: 'mdi mdi-chevron-up',
            //         down: 'mdi mdi-chevron-down'
            //     },
            //     // defaultTime: add(30, 'minutes'),
            //     appendWidgetTo: "#timepicker-input-group2"
            // });
            $('.nav-link').on('click', function() {
                if ($(this).attr('id') == 'link_pengajuan') {
                    $("#btn_link_pengajuan").prop('hidden', false);
                    $("#btn_link_riwayat").prop('hidden', true);
                    $("#btn_link_display").prop('hidden', true);
                } else {
                    if ($(this).attr('id') == 'link_riwayat') {
                        $("#btn_link_pengajuan").prop('hidden', true);
                        $("#btn_link_riwayat").prop('hidden', false);
                        $("#btn_link_display").prop('hidden', true);
                    } else {
                        if ($(this).attr('id') == 'link_display') {
                            $("#btn_link_pengajuan").prop('hidden', true);
                            $("#btn_link_riwayat").prop('hidden', true);
                            $("#btn_link_display").prop('hidden', false);
                        } else {
                            alert('Sistem gagal memuat halaman, silakan refresh browser');
                        }
                    }
                }
            });

            // <th scope="col"><center>Aksi</center></th>
            // <th scope="col">Nama Ruangan</th>
            // <th scope="col">Peminjam</th>
            // <th scope="col">Tanggal Acara</th>
            // <th scope="col">Waktu Acara</th>
            // <th scope="col">Keterangan</th>
            // <th scope="col">Diperbarui</th>

            // INITIALIZE PAGE
            riwayat();
            // display();
            $('.pilihJam').timepicker({ showInputs: false, showMeridian: false,timeFormat: 'H:i' });
        });

        // FUNCTION-FUNCTION
        // ----------------------------------------------------------------------------------------
        function refreshWithOpenRiwayat() {
            // reload table
            riwayat();
            // change active menu
            $("#link_pengajuan").removeClass("active");
            $("#link_display").removeClass("active");
            $("#link_riwayat").removeClass("active").addClass("active");
            // change nav page
            $("#pengajuan").removeClass("active");
            $("#display").removeClass("active");
            $("#riwayat").removeClass("active").addClass("active");
        }

        function riwayat() {
            $('#btn-refresh-table').find('i').addClass('fa-spin');
            $("#tampil-tbody").empty().append(
                `<tr style='font-size:13px'><td colspan="20"><center><i class="fa fa-spinner fa-spin fa-fw"></i> Memproses data...</center></td></tr>`
            );
            $.ajax({
                url: "/api/eruang",
                type: 'GET',
                dataType: 'json',
                success: function(res) {
                    $("#tampil-tbody").empty();
                    $('#dttable').DataTable().clear().destroy();
                    var userID = "{{ Auth::user()->id }}";
                    var adminID = "{{ Auth::user()->getPermission('admin_eruang') }}";
                    var date = new Date().toLocaleDateString('en-ZA');
                    // console.log('ini tgl sekarang : '+date);
                    res.show.forEach(item => {
                        var input = new Date(item.tgl).toLocaleDateString('en-ZA');
                        var updet = new Date(item.created_at).toLocaleDateString('en-ZA');

                        // console.log('ini tgl input : '+input);

                        // JIKA ADMIN
                        if (adminID == true) {
                            if (item.gizi_verif == null) {
                                if (item.status_penolakan == null) {
                                    content = `<tr><center><td><div class="d-flex align-items-center">
                                                    <div class="dropdown">
                                                        <a href="javascript:;" class="btn btn-link-light btn-sm text-body p-0 btn-icon" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a href="javascript:;" onclick="verifTolakTgl(` + item.id + `)" class="dropdown-item text-info"><i class='fas fa-calendar-times me-1'></i> Tolak</a>
                                                            <a href="javascript:;" onclick="verifEditTgl(` + item.id + `)" class="dropdown-item text-warning"><i class='fas fa-edit me-1'></i> Ubah</a>
                                                            <a href="javascript:;" onclick="verifHapusTgl(` + item.id + `)" class="dropdown-item text-danger"><i class='fas fa-trash-alt me-1'></i> Hapus</a>
                                                        </div>
                                                    </div>
                                                </div></td></center>`;
                                } else {
                                    content = `<tr><center><td><div class="d-flex align-items-center">
                                                    <div class="dropdown">
                                                        <a href="javascript:;" class="btn btn-link-light btn-sm text-body p-0 btn-icon" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a href="javascript:;" onclick="lihatPenolakan(` + item.id + `)" class="dropdown-item text-primary"><i class='fas fa-calendar-times me-1'></i> Alasan Penolakan</a>
                                                            <a href="javascript:;" onclick="verifEditTgl(` + item.id + `)" class="dropdown-item text-warning"><i class='fas fa-edit me-1'></i> Ubah</a>
                                                            <a href="javascript:;" onclick="verifHapusTgl(` + item.id + `)" class="dropdown-item text-danger"><i class='fas fa-trash-alt me-1'></i> Hapus</a>
                                                        </div>
                                                    </div>
                                                </div></td></center>`;
                                }
                            } else {
                                if (item.status_penolakan == null) {
                                    content = `<tr><center><td><div class="d-flex align-items-center">
                                                    <div class="dropdown">
                                                        <a href="javascript:;" class="btn btn-link-light btn-sm text-body p-0 btn-icon" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a href="javascript:;" class="dropdown-item text-secondary"><i class='fas fa-calendar-times me-1'></i> <s>Tolak</s></a>
                                                            <a href="javascript:;" onclick="verifEditTgl(` + item.id + `)" class="dropdown-item text-warning"><i class='fas fa-edit me-1'></i> Ubah</a>
                                                            <a href="javascript:;" onclick="verifHapusTgl(` + item.id + `)" class="dropdown-item text-danger"><i class='fas fa-trash-alt me-1'></i> Hapus</a>
                                                        </div>
                                                    </div>
                                                </div></td></center>`;
                                } else {
                                    content = `<tr><center><td><div class="d-flex align-items-center">
                                                    <div class="dropdown">
                                                        <a href="javascript:;" class="btn btn-link-light btn-sm text-body p-0 btn-icon" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a href="javascript:;" onclick="lihatPenolakan(` + item.id + `)" class="dropdown-item text-primary"><i class='fas fa-calendar-times me-1'></i> Alasan Penolakan</a>
                                                            <a href="javascript:;" onclick="verifEditTgl(` + item.id + `)" class="dropdown-item text-warning"><i class='fas fa-edit me-1'></i> Ubah</a>
                                                            <a href="javascript:;" onclick="verifHapusTgl(` + item.id + `)" class="dropdown-item text-danger"><i class='fas fa-trash-alt me-1'></i> Hapus</a>
                                                        </div>
                                                    </div>
                                                </div></td></center>`;
                                }
                            }
                        // JIKA USER
                        } else {
                            if (userID == item.id_user) {
                                // if (updet == date) {
                                if (item.gizi_verif == null) {
                                    if (item.status_penolakan == null) {
                                        content = `<tr><center><td><div class="d-flex align-items-center">
                                                        <div class="dropdown">
                                                            <a href="javascript:;" class="btn btn-link-light btn-sm text-body p-0 btn-icon" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></a>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <a href="javascript:;" onclick="verifEditTgl(` + item.id + `)" class="dropdown-item text-warning"><i class='fas fa-edit me-1'></i> Ubah</a>
                                                                <a href="javascript:;" onclick="verifHapusTgl(` + item.id + `)" class="dropdown-item text-danger"><i class='fas fa-trash-alt me-1'></i> Hapus</a>
                                                            </div>
                                                        </div>
                                                    </div></td></center>`;
                                    } else {
                                        content = `<tr><center><td><div class="d-flex align-items-center">
                                                        <div class="dropdown">
                                                            <a href="javascript:;" class="btn btn-link-light btn-sm text-body p-0 btn-icon" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></a>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <a href="javascript:;" onclick="lihatPenolakan(` + item.id + `)" class="dropdown-item text-primary"><i class='fas fa-calendar-times me-1'></i> Alasan Penolakan</a>
                                                                <a href="javascript:;" class="dropdown-item text-secondary" disabled><i class='fas fa-edit me-1'></i> Ubah</a>
                                                                <a href="javascript:;" class="dropdown-item text-secondary" disabled><i class='fas fa-trash-alt me-1'></i> Hapus</a>
                                                            </div>
                                                        </div>
                                                    </div></td></center>`;
                                    }
                                } else {
                                    content = `<tr><center><td><div class="d-flex align-items-center">
                                                    <div class="dropdown">
                                                        <a href="javascript:;" class="btn btn-link-light btn-sm text-body p-0 btn-icon" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a href="javascript:;" class="dropdown-item text-secondary" disabled><i class='fas fa-edit me-1'></i> Ubah</a>
                                                            <a href="javascript:;" class="dropdown-item text-secondary" disabled><i class='fas fa-trash-alt me-1'></i> Hapus</a>
                                                        </div>
                                                    </div>
                                                </div></td></center>`;
                                }
                            } else {
                                content = `<tr><center><td><div class="d-flex align-items-center">
                                                <div class="dropdown">
                                                    <a href="javascript:;" class="btn btn-link-light btn-sm text-body p-0 btn-icon" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a href="javascript:;" class="dropdown-item text-secondary" disabled><i class='fas fa-edit me-1'></i> Ubah</a>
                                                        <a href="javascript:;" class="dropdown-item text-secondary" disabled><i class='fas fa-trash-alt me-1'></i> Hapus</a>
                                                    </div>
                                                </div>
                                            </div></td></center>`;
                            }
                        }
                        // LANJUT CONTENT
                        // WARNA NAMA RUANGAN
                        var namar = null;
                        if (item.status_penolakan) {
                            namar = `<u><s class='text-danger'>`+item.nama_ruangan+`</s></u>`;
                        } else {
                            if (item.gizi_verif) {
                                namar = `<u class='text-dark'>`+item.nama_ruangan+`</u>`;
                            } else {
                                namar = `<u class='text-primary'>`+item.nama_ruangan+`</u>`;
                            }
                        }
                        content += `<td style='white-space: normal !important;word-wrap: break-word;'>
                                        <div class='d-flex justify-content-start align-items-center'>
                                            <div class='d-flex flex-column'>
                                                <h6 class='mb-0'><span class="badge text-bg-secondary" style="font-size:10px;padding:3">`+item.kapasitas+` P</span> `+namar+` ${item.gizi_verif?'<i class="ti ti-checkbox text-info" title="Telah Diverifikasi oleh Gizi"></i>':''}</h6>
                                                <h6 class='mb-0'><small class='text-truncate text-muted'>`+item.agenda+`</small></h6>
                                            </div>
                                        </div>
                                    </td>`;
                        content += `<td style='white-space: normal !important;word-wrap: break-word;'>
                                        <div class='d-flex justify-content-start align-items-center'>
                                            <div class='d-flex flex-column'>
                                                <h6 class='mb-0'>`+item.nama_user+`</h6>
                                                <h6 class='mb-0'><small class='text-truncate text-muted'>${item.no_hp?item.no_hp:''}</small></h6>
                                            </div>
                                        </div>
                                    </td>`;
                        content += `<td><center>`+item.tgl+`</center></td>`;
                        content += `<td>`+item.jam_mulai.substring(0, 5)+` - `+item.jam_selesai.substring(0, 5)+` WIB</td>`;
                        content += `<td>${item.ket?item.ket:''}</td>`;
                        content += `<td style="white-space: pre-line">${item.gizi?item.gizi:''}</td>`;
                        content += `<td>${item.alasan_penolakan?item.alasan_penolakan:''}</td>`;
                        // unit.forEach(val => {
                        //     res.role.forEach(pus => {
                        //         if (val == pus.id) {
                        //             content += `<span class="badge bg-dark">` + pus.name +
                        //                 `</span>&nbsp;`;
                        //         }
                        //     })
                        // })
                        // content += `<td>`+item.updated_at.substring(0, 19).replace('T',' ')+`</td></tr>`;
                        content += `<td>`+new Date(item.updated_at).toLocaleString("sv-SE")+`</td></tr>`;
                        $('#tampil-tbody').append(content);
                    })

                    var table = $('#dttable').DataTable({
                        dom: 'Bfrtip',
                        order: [
                            [8, "desc"]
                        ],
                        bAutoWidth: false,
                        aoColumns : [
                            { sWidth: '5%' },
                            { sWidth: '17%' },
                            { sWidth: '13%' },
                            { sWidth: '10%' },
                            { sWidth: '10%' },
                            { sWidth: '14%' },
                            { sWidth: '10%' },
                            { sWidth: '13%' },
                            { sWidth: '8%' },
                        ],
                        columnDefs: [
                            { visible: false, targets: [7] },
                        ],
                        displayLength: 7,
                        lengthChange: true,
                        lengthMenu: [7, 10, 25, 50, 75, 100],
                        buttons: ['copy', 'excel', 'pdf', 'colvis']
                    });

                    // Showing Tooltip
                    $('[data-bs-toggle="tooltip"]').tooltip({
                        trigger: 'hover'
                    })
                    $('#btn-refresh-table').find('i').removeClass('fa-spin');
                }
            })
        }

        function prosesSimpan() {
            // $("#btn-simpan").prop('disabled', true);
            $("#btn-simpan").find("i").toggleClass("fa-stamp fa-sync fa-spin");

            // Definisi
            var save = new FormData();
            save.append('agenda',$("#agenda").val());
            save.append('ruangan',$('input[name="ruangan"]:checked').val());
            save.append('tgl',$("#tgl").val());
            save.append('jam_mulai',$("#jam_mulai").val());
            save.append('jam_selesai',$("#jam_selesai").val());
            save.append('ket',$("#ket").val());
            // save.append('gizi',$("#gizi").val());
            save.append('snack',$("#snack").val());
            save.append('makan',$("#makan").val());
            save.append('minum',$("#minum").val());
            save.append('user','{{ Auth::user()->id }}');

            console.log(save.get('ruangan'));
            if (
                $('input[name="ruangan"]:checked').val() == null ||
                save.get('agenda') == "" ||
                save.get('tgl') == "" ||
                save.get('jam_mulai') == "" ||
                save.get('jam_selesai') == ""
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
                    method: 'POST',
                    url: '/api/eruang/store',
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    data: save,
                    success: function(res) {
                        if (res.code == 400) {
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
                            iziToast.success(
                            {
                                icon: 'fa fa-check',
                                title: 'Pesan Sukses',
                                message: res.message,
                                position: 'topRight', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                                progressBarColor: 'rgb(0,0,0)',
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
                            refreshWithOpenRiwayat();
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

            $("#btn-simpan").find("i").removeClass("fa-sync fa-spin").addClass("fa-stamp");
            $("#btn-simpan").prop('disabled', false);
        }

        function ubah(id) {
            $("#id_edit").val("");
            $("#ruangan_edit").val("");
            $("#show_ruangan_edit").val("");
            $("#agenda_edit").val("");
            $("#tgl_edit").val("");
            $("#show_tgl_edit").val("");
            $("#ket_edit").val("");
            $("#gizi_edit").val("");

            $.ajax(
            {
                url: "/api/eruang/ubah/"+id,
                type: 'GET',
                dataType: 'json', // added data type
                success: function(res) {
                    $("#show_tgl_edit").val(res.show.tgl);
                    var a = document.querySelector("#tgl_edit");
                    a.flatpickr({
                        enableTime: 0,
                        minuteIncrement: 1,
                        time_24hr: true,
                        defaultDate: res.show.tgl,
                    })
                    $("#id_show_edit").text(res.show.id);
                    $("#id_edit").val(res.show.id);
                    $("#agenda_edit").val(res.show.agenda);
                    // $("#tgl_edit").val(res.show.tgl);
                    $("#ket_edit").val(res.show.ket);
                    $("#gizi_edit").val(res.show.gizi);
                    $("#show_ruangan_edit").find('option').remove();
                    res.ruangan.forEach(item => {
                        // if ('{{ Auth::user()->id == 82 || Auth::user()->id == 294 || Auth::user()->id == 2 }}') {
                        //     if (item.id == res.show.id_ruangan_ref) {
                        //         $("#show_ruangan_edit").val(item.nama+' ('+item.kapasitas+' Peserta)');
                        //         $("#ruangan_edit").val(item.id);
                        //     }
                        // } else {
                        // }
                        if (item.id == res.show.id_ruangan_ref) {
                            $("#show_ruangan_edit").val(item.nama+' ('+item.kapasitas+' Peserta)');
                            $("#ruangan_edit").val(item.id);
                        }
                    });
                    // BACKUP RUANGAN ASLI ------------------------
                    // $("#ruangan_edit").find('option').remove();
                    // res.ruangan.forEach(item => {
                    //     $("#ruangan_edit").append(`
                    //         <option value="${item.id}" ${item.id == res.show.id_ruangan_ref? "selected":""}>${item.nama} (${item.kapasitas} Peserta)</option>
                    //     `);
                    // });
                    $('#modalUbah').modal('show');
                }
            });
        }

        function prosesUbah() {
            $("#btn-ubah").prop('disabled', true);
            $("#btn-ubah").find("i").toggleClass("fa-save fa-sync fa-spin");

            var save = new FormData();
            save.append('id',$("#id_edit").val());
            save.append('ruangan',$("#ruangan_edit").val());
            save.append('agenda',$("#agenda_edit").val());
            save.append('tgl',$("#tgl_edit").val());
            save.append('ket',$("#ket_edit").val());
            save.append('gizi',$("#gizi_edit").val());
            save.append('user','{{ Auth::user()->id }}');

            if (
                save.get('ruangan') == "" ||
                save.get('agenda') == "" ||
                save.get('tgl') == ""
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
                    url: "/api/eruang/ubah/"+save.get('id')+"/proses",
                    method: 'post',
                    data: save,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(res){
                        iziToast.success({
                            title: 'Pesan Sukses! ID : '+save.get('id'),
                            message: 'Pengajuan Peminjaman Ruangan berhasil diperbarui pada '+res,
                            position: 'topRight'
                        });
                        if (res) {
                            $('#modalUbah').modal('hide');
                            refreshWithOpenRiwayat();
                        }
                    },
                    error: function(res){
                        console.log("error : " + JSON.stringify(res) );
                    }
                });
            }

            $("#btn-ubah").find("i").removeClass("fa-sync fa-spin").addClass("fa-save");
            $("#btn-ubah").prop('disabled', false);
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
                    message: 'Mohon menyetujui untuk dilakukan penghapusan baris tersebut',
                    position: 'topRight'
                });
            } else {
                // PROSES HAPUS
                var id = $("#id_hapus").val();
                $.ajax({
                    url: "/api/eruang/hapus/"+id,
                    type: 'DELETE',
                    success: function(res) {
                        iziToast.success({
                            title: 'Pesan Sukses!',
                            message: 'Pengajuan Peminjaman Ruangan telah berhasil dihapus pada '+res,
                            position: 'topRight'
                        });
                        $('#modalHapus').modal('hide');
                        refreshWithOpenRiwayat();
                    },
                    error: function(res) {
                        iziToast.error({
                            title: 'Pesan Galat!',
                            message: 'Pengajuan Peminjaman Ruangan gagal dihapus',
                            position: 'topRight'
                        });
                    }
                });
            }
        }

        function tolak(id) {
            $("#id_tolak").val(id);
            $('#modalTolak').modal('show');
        }

        function prosesTolak() {
            var id = $("#id_tolak").val();
            var alasan = $("#alasan_penolakan").val();
            if (alasan == "") {
                iziToast.error({
                    title: 'Pesan Galat!',
                    message: 'Alasan Penolakan wajib diisi',
                    position: 'topRight'
                });
            } else {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "/api/eruang/tolak/"+id,
                    method: 'POST',
                    dataType: 'json',
                    data: {
                        id: id,
                        alasan: alasan,
                    },
                    success: function(res) {
                        iziToast.success({
                            title: 'Pesan Sukses!',
                            message: 'Penolakan Peminjaman Ruangan telah berhasil pada '+res,
                            position: 'topRight'
                        });
                        $('#modalTolak').modal('hide');
                        refreshWithOpenRiwayat();
                    },
                    error: function(res) {
                        iziToast.error({
                            title: 'Pesan Galat!',
                            message: res.responseJSON.error,
                            position: 'topRight'
                        });
                    }
                });
            }
        }

        function lihatPenolakan(id) {
                $.ajax({
                    url: "/api/eruang/gizi/verif/edithapus/"+id,
                    type: 'get',
                    success: function(res) {
                        $('#show_alasan_penolakan').val(res.alasan_penolakan);
                        $('#modalAlasanPenolakan').modal('show');
                    },
                    error: function(res) {
                        iziToast.error({
                            title: 'Pesan Galat!',
                            message: res.responseJSON.error,
                            position: 'topRight'
                        });
                    }
                });
        }

        // VERIFIKASI GIZI ====================================================================================================================
        function verifSnackGiziTgl(val) {
            var date = new Date();
            var tgl = new Date(val);
            tgl.setDate(tgl.getDate()-1);
            var hmin1 = tgl.toLocaleDateString("sv-SE");
            var harih = new Date(val).toLocaleDateString("sv-SE");
            var hariini = new Date().toLocaleDateString("sv-SE");
            var jamSekarang = date.getHours();

            // console.log(hariini);
            // console.log(hmin1);
            // console.log(jamSekarang);
            // console.log(jamMulai);
            if (hmin1 > hariini) {
                $("#show_gizi1").prop('hidden',true);
                $("#show_gizi2").prop('hidden',false);
                $(".pilih_snack").prop('hidden',false);
                $(".validasiTgl").prop('disabled',false);
                iziToast.warning({
                    title: 'Pesan Admin!',
                    message: 'Silakan menyesuaikan Jam Mulai dan Selesai',
                    position: 'topRight'
                });
            } else {
                if (hmin1 == hariini) {
                    $("#show_gizi1").prop('hidden',true);
                    $("#show_gizi2").prop('hidden',false);
                    $(".validasiTgl").prop('disabled',false);
                    if (jamSekarang < 12) {
                        $(".pilih_snack").prop('hidden',false);
                        iziToast.warning({
                            title: 'Pesan Admin!',
                            message: 'Silakan menyesuaikan Jam Mulai dan Selesai',
                            position: 'topRight'
                        });
                    } else {
                        $(".pilih_snack").prop('hidden',true);
                        iziToast.warning({
                            title: 'Pesan Admin!',
                            message: 'Silakan menyesuaikan Jam Mulai dan Selesai. Tidak bisa menambahkan Snack karena sudah melebihi Pukul 12:00 WIB',
                            position: 'topRight'
                        });
                    }
                } else {
                    $("#show_gizi1").prop('hidden',false);
                    $("#show_gizi2").prop('hidden',true);
                    $(".pilih_snack").prop('hidden',true);
                    if (harih == hariini) {
                        $(".validasiTgl").prop('disabled',false);
                        iziToast.warning({
                            title: 'Pesan Admin!',
                            message: 'Pengajuan masih berlaku tetapi tidak bisa memesan Snack/Makan/Minum ke bagian Gizi',
                            position: 'topRight'
                        });
                    } else {
                        $(".validasiTgl").prop('disabled',true);
                        iziToast.error({
                            title: 'Pesan Galat!',
                            message: 'Silakan memilih tanggal yang valid (Harus lebih dari hari ini)',
                            position: 'topRight'
                        });
                    }
                }
            }
        }

        function verifTolakTgl(id) {
            $.ajax({
                url: "/api/eruang/gizi/verif/edithapus/"+id,
                type: 'get',
                success: function(res) {
                    var val = res.tgl;
                    var date = new Date();
                    var tgl = new Date(val);
                    tgl.setDate(tgl.getDate()-1);
                    var hmin1 = tgl.toLocaleDateString("sv-SE");
                    var harih = new Date(val).toLocaleDateString("sv-SE");
                    var hariini = new Date().toLocaleDateString("sv-SE");
                    var jamSekarang = date.getHours();
                    var adminID = "{{ Auth::user()->getPermission('admin_eruang') }}";

                    if (adminID) {
                        tolak(res.id);
                    } else {
                        if (hmin1 > hariini) {
                            tolak(res.id);
                        } else {
                            if (hmin1 == hariini) {
                                if (jamSekarang < 12) {
                                    tolak(res.id);
                                } else {
                                    iziToast.error({
                                        title: 'Pesan Galat!',
                                        message: 'Penolakan pengajuan sudah melewati batas waktu yang telah ditentukan',
                                        position: 'topRight'
                                    });
                                }
                            } else {
                                iziToast.error({
                                    title: 'Pesan Galat!',
                                    message: 'Penolakan pengajuan sudah melewati batas waktu yang telah ditentukan',
                                    position: 'topRight'
                                });
                                // if (harih == hariini) {

                                // } else {
                                //     iziToast.error({
                                //         title: 'Pesan Galat!',
                                //         message: 'Silakan memilih tanggal yang valid (Harus lebih dari hari ini)',
                                //         position: 'topRight'
                                //     });
                                // }
                            }
                        }
                    }
                },
                error: function(res) {
                    iziToast.error({
                        title: 'Pesan Galat!',
                        message: 'Verifikasi gagal dilakukan',
                        position: 'topRight'
                    });
                }
            });
        }

        function verifEditTgl(id) {
            $.ajax({
                url: "/api/eruang/gizi/verif/edithapus/"+id,
                type: 'get',
                success: function(res) {
                    var val = res.tgl;
                    var date = new Date();
                    var tgl = new Date(val);
                    tgl.setDate(tgl.getDate()-1);
                    var hmin1 = tgl.toLocaleDateString("sv-SE");
                    var harih = new Date(val).toLocaleDateString("sv-SE");
                    var hariini = new Date().toLocaleDateString("sv-SE");
                    var jamSekarang = date.getHours();
                    var adminID = "{{ Auth::user()->getPermission('admin_eruang') }}";

                    if (adminID) {
                        ubah(res.id);
                    } else {
                        if (hmin1 > hariini) {
                            ubah(res.id);
                        } else {
                            if (hmin1 == hariini) {
                                if (jamSekarang < 12) {
                                    ubah(res.id);
                                } else {
                                    iziToast.error({
                                        title: 'Pesan Galat!',
                                        message: 'Perubahan data sudah melewati batas waktu yang telah ditentukan',
                                        position: 'topRight'
                                    });
                                }
                            } else {
                                iziToast.error({
                                    title: 'Pesan Galat!',
                                    message: 'Perubahan data sudah melewati batas waktu yang telah ditentukan',
                                    position: 'topRight'
                                });
                                // if (harih == hariini) {

                                // } else {
                                //     iziToast.error({
                                //         title: 'Pesan Galat!',
                                //         message: 'Silakan memilih tanggal yang valid (Harus lebih dari hari ini)',
                                //         position: 'topRight'
                                //     });
                                // }
                            }
                        }
                    }
                },
                error: function(res) {
                    iziToast.error({
                        title: 'Pesan Galat!',
                        message: 'Verifikasi gagal dilakukan',
                        position: 'topRight'
                    });
                }
            });
        }

        function verifHapusTgl(id) {
            $.ajax({
                url: "/api/eruang/gizi/verif/edithapus/"+id,
                type: 'get',
                success: function(res) {
                    var val = res.tgl;
                    var date = new Date();
                    var tgl = new Date(val);
                    tgl.setDate(tgl.getDate()-1);
                    var hmin1 = tgl.toLocaleDateString("sv-SE");
                    var harih = new Date(val).toLocaleDateString("sv-SE");
                    var hariini = new Date().toLocaleDateString("sv-SE");
                    var jamSekarang = date.getHours();
                    var adminID = "{{ Auth::user()->getPermission('admin_eruang') }}";

                    if (adminID) {
                        hapus(res.id);
                    } else {
                        if (hmin1 > hariini) {
                            hapus(res.id);
                        } else {
                            if (hmin1 == hariini) {
                                if (jamSekarang < 12) {
                                    hapus(res.id);
                                } else {
                                    iziToast.error({
                                        title: 'Pesan Galat!',
                                        message: 'Penghapusan data sudah melewati batas waktu yang telah ditentukan',
                                        position: 'topRight'
                                    });
                                }
                            } else {
                                iziToast.error({
                                    title: 'Pesan Galat!',
                                    message: 'Penghapusan data sudah melewati batas waktu yang telah ditentukan',
                                    position: 'topRight'
                                });
                                // if (harih == hariini) {

                                // } else {
                                //     iziToast.error({
                                //         title: 'Pesan Galat!',
                                //         message: 'Silakan memilih tanggal yang valid (Harus lebih dari hari ini)',
                                //         position: 'topRight'
                                //     });
                                // }
                            }
                        }
                    }
                },
                error: function(res) {
                    iziToast.error({
                        title: 'Pesan Galat!',
                        message: 'Verifikasi gagal dilakukan',
                        position: 'topRight'
                    });
                }
            });
        }

        // function verifGiziTgl(id) {
        //     $.ajax({
        //         url: "/api/eruang/gizi/verif/edithapus/"+id,
        //         type: 'get',
        //         success: function(res) {
        //             var val = res.tgl;
        //             var date = new Date();
        //             var tgl = new Date(val);
        //             tgl.setDate(tgl.getDate()-1);
        //             var hmin1 = tgl.toLocaleDateString("sv-SE");
        //             var harih = new Date(val).toLocaleDateString("sv-SE");
        //             var hariini = new Date().toLocaleDateString("sv-SE");
        //             var jamSekarang = date.getHours();

        //             if (hmin1 == hariini) {
        //                 if (jamSekarang >= 12) {
        //                     return true;
        //                 } else {
        //                     return false;
        //                 }
        //             } else {
        //                 if (harih == hariini) {
        //                     return true;
        //                 } else {
        //                     return false;
        //                 }
        //             }
        //         },
        //         error: function(res) {
        //             iziToast.error({
        //                 title: 'Pesan Galat!',
        //                 message: 'Verifikasi gagal dilakukan',
        //                 position: 'topRight'
        //             });
        //         }
        //     });
        // }

        // TAMPILAN GIZI =====================================================================================================
        function showDisplay() {
            // clearInterval(interval);
            display();
            setInterval(function() {
                display();
            }, 300000); // 1000 = 1 detik
            $("#tampil_gizi_ruangan").prop('disabled', true);
            $("#tampil_gizi_tgl").prop('disabled', true);
            $("#tampil_gizi_status").prop('disabled', true);
            $("#btn-tampil-gizi").prop('disabled', true);
            $("#stop-display").prop('hidden', false);
            $("#start-display").prop('hidden', true);
            // setInterval(function() {
            //     display();
            // }, 8000);
            // setTimeout(display(), 10000);
        }

        function stopDisplay() {
            clearInterval();
            $('#show_tampil_display').empty();
            $('#show_tampil_display').append(`
                <div class="row justify-content-center mt-lg-5">
                    <div class="col-xl-5 col-sm-8">
                        <div class="text-center">
                            <div class="row justify-content-center mt-2 mb-2">
                                <div class="col-sm-6 col-8">
                                    <img src="{{ asset('images/verification-img.png') }}" alt="" class="img-fluid">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `);
            $("#detik").empty();
            $("#tampil_gizi_ruangan").prop('disabled', false);
            $("#tampil_gizi_tgl").prop('disabled', false);
            $("#tampil_gizi_status").prop('disabled', false);
            $("#btn-tampil-gizi").prop('disabled', false);
            $("#stop-display").prop('hidden', true);
            $("#start-display").prop('hidden', false);
        }

        function verifGizi(id) {
            $.ajax({
                url: "/api/eruang/gizi/verif/"+id,
                type: 'get',
                success: function(res) {
                    iziToast.success({
                        title: 'Pesan Sukses!',
                        message: 'Status Gizi dengan ID : '+id+' Berhasil di verifikasi',
                        position: 'topRight'
                    });
                    stopDisplay();
                    showDisplay();
                },
                error: function(res) {
                    iziToast.error({
                        title: 'Pesan Galat!',
                        message: 'Verifikasi gagal dilakukan',
                        position: 'topRight'
                    });
                }
            });
        }

        function display() {
            console.log(new Date().getHours());
            $("#show_tampil_display").empty().append(
                `<center><i class="fa fa-spinner fa-spin fa-fw"></i> Memproses data...</center>`
            );
            var getInputRuangan = $("#tampil_gizi_ruangan").val();
            var getInputTgl = $("#tampil_gizi_tgl").val();
            var getInputStatus = $("#tampil_gizi_status").val();
            $.ajax({
                url: "/api/eruang/display?ruangan="+getInputRuangan+"&tgl="+getInputTgl+"&status="+getInputStatus,
                type: 'GET',
                dataType: 'json',
                success: function(res) {
                    $("#show_tampil_display").empty();
                    if (res.show == '') {
                        $('#show_tampil_display').append(`<br><center><h5>Data Peminjaman Ruangan Tidak Ada Pada Tanggal <mark>`+getInputTgl+`</mark></h5></center>`);
                    } else {
                        res.show.forEach(item => {
                            var val = item.tgl;
                            var date = new Date();
                            var tgl = new Date(val);
                            tgl.setDate(tgl.getDate()-1);
                            var hmin1 = tgl.toLocaleDateString("sv-SE");
                            var harih = new Date(val).toLocaleDateString("sv-SE");
                            var hariini = new Date().toLocaleDateString("sv-SE");
                            var jamSekarang = date.getHours();

                            var valid = 0;
                            if (hmin1 == hariini) {
                                if (jamSekarang >= 12) {
                                    valid = 1;
                                }
                            } else {
                                if (harih == hariini) {
                                    valid = 1;
                                }
                            }

                            content = ``;
                            content += `<div class="col-xl-4 col-sm-6 d-flex align-items-stretch">`;
                                        if (item.status_penolakan == null) {
                                            if (item.gizi_verif == null) {
                                                if (harih < hariini) {
                                                    content += `<div class="card border border-5 border-secondary" style="width:100%">`;
                                                } else {
                                                    if (valid == 1) {
                                                        content += `<div class="card border border-5 border-primary" style="width:100%">`;
                                                    } else {
                                                        content += `<div class="card border border-5 border-warning" style="width:100%">`;
                                                    }
                                                }
                                            } else {
                                                content += `<div class="card border border-5 border-success" style="width:100%">`;
                                            }
                                        } else {
                                            content += `<div class="card border border-5 border-danger" style="width:100%">`;
                                        }
                                    content += `<div class="card-body">
                                                    <div class="d-flex">
                                                        <div class="flex-shrink-0 me-4">
                                                            <img src="${item.foto_profil?'/storage/'+item.foto_profil.substr(7,1000):'/images/pku/user.png'}" class="user-avtar wid-60 rounded-circle" alt="Avatar" style="width: 60px;height:60px">
                                                        </div>
                                                        <div class="flex-grow-1 overflow-hidden">
                                                            <h4 class="text-truncate font-size-20"><a href="javascript: void(0);" class="text-dark"><mark>${item.status_penolakan?'<s>'+item.nama_ruangan+'</s>':item.nama_ruangan}</mark></a></h4>
                                                            <p class="text-muted mb-0 mt-1">
                                                                <i class="ti ti-arrow-narrow-right text-primary me-1"></i> <b>Agenda :</b> ${item.agenda}<br>
                                                                <i class="ti ti-arrow-narrow-right text-primary me-1"></i> <b>User :</b> ${item.nama_user?item.nama_user:'Tidak Ada Nama'} (${item.no_hp?item.no_hp:'-'})<br>
                                                                <i class="ti ti-arrow-narrow-right text-primary me-1"></i> <b>Pesanan Gizi :</b>
                                                                <p style="white-space: pre-line">${item.gizi?item.gizi:''}</p>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="px-3 py-2 border-top">
                                                    <ul class="list-inline mb-0">
                                                        <li class="list-inline-item me-3 mt-1">
                                                            <i class= "ti ti-calendar-plus me-1"></i> ${item.tgl}
                                                        </li>
                                                        <li class="list-inline-item me-3 mt-1">
                                                            <i class= "ti ti-clock me-1"></i> ${item.jam_mulai.substring(0,5)} - ${item.jam_selesai.substring(0,5)} WIB
                                                        </li>
                                                        <div class="float-end">`;
                                                        if (item.status_penolakan == null) {
                                                            if (item.gizi_verif == null) {
                                                                if (harih < hariini) {
                                                                    content += `<button class="btn btn-secondary avtar-s mb-0 btn-icon" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="Gagal Verifikasi"><i class="ti ti-check"></i></button>`;
                                                                } else {
                                                                    if (valid == 1) {
                                                                        content += `<button class="btn btn-primary avtar-s mb-0 btn-sm" onclick="verifGizi(${item.id})" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="Verifikasi Sekarang"><i class="ti ti-check me-1"></i> Verifikasi</button>`;
                                                                    } else {
                                                                        content += `<button class="btn btn-warning avtar-s mb-0 btn-icon" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="Verifikasi Belum Dapat Dilakukan"><i class="ti ti-check"></i></button>`;
                                                                    }
                                                                }
                                                            } else {
                                                                content += `<button class="btn btn-success avtar-s mb-0 btn-icon" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="Sudah Terverifikasi"><i class="ti ti-checks"></i></button>`;
                                                            }
                                                        } else {
                                                            content += `<button class="btn btn-danger avtar-s mb-0 btn-icon" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="Pengajuan Ditolak"><i class="ti ti-x"></i></button>`;
                                                        }

                                            content += `</div>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>`;
                            $('#show_tampil_display').append(content);
                        })
                    }

                    // Showing Tooltip
                    $('[data-bs-toggle="tooltip"]').tooltip({
                        trigger: 'hover'
                    })

                    // UPDATED
                    $("#detik").html('Pukul <mark>'+res.now+'</mark> (Per 5 Menit)');
                }
            })
        }

        // function startTimer(duration, display) {
        //     var timer = duration, minutes, seconds;
        //     setInterval(function () {
        //         minutes = parseInt(timer / 60, 10);
        //         seconds = parseInt(timer % 60, 10);

        //         minutes = minutes < 10 ? "0" + minutes : minutes;
        //         seconds = seconds < 10 ? "0" + seconds : seconds;

        //         display.textContent = minutes + ":" + seconds;

        //         if (--timer < 0) {
        //             timer = duration;
        //         }
        //     }, 1000);
        // }
    </script>
@endsection
