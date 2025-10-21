@extends('layouts.index')

@section('content')

    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i></a></li>
                        <li class="breadcrumb-item">Administrasi</li>
                        <li class="breadcrumb-item">Berkas</li>
                        <li class="breadcrumb-item" aria-current="page">Regulasi Digital</li>
                    </ul>
                </div>
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h2 class="mb-0">Digital <b class="text-primary">Regulasi</b></h2>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- [ breadcrumb ] end -->

    <!-- [ Main Content ] start -->
    <div class="pt-1">
        <div class="card job-filter">
            <div class="card-body p-3" id="filterTampil">
                <div class="row g-3">
                    <div class="col-xxl-3 col-lg-4">
                        <div class="position-relative">
                            <label class="form-label">Jenis Regulasi</label>
                            <i class="bx bx-help-circle text-muted" data-bs-toggle="tooltip" data-bs-placement="top" title="Anda dapat memilih satu dari tiga pilihan filter dibawah, lalu klik Submit"></i>
                                <select class="form-select selectFilter" id="search_regulasi" style="width: 100%" data-allow-clear="false" data-bs-auto-close="outside">
                                    <option value="">Pilih</option>
                                    <option value="1">Kebijakan</option>
                                    <option value="2">Panduan</option>
                                    <option value="3">Pedoman</option>
                                    <option value="4">Program</option>
                                    <option value="5">SPO</option>
                                    <option value="6">PPK</option>
                                    <option value="7">Undang-undang</option>
                                    <option value="8">PERPU</option>
                                    <option value="9">Peraturan Pemerintah</option>
                                    <option value="10">Peraturan Presiden</option>
                                    <option value="11">Peraturan Menteri</option>
                                    <option value="12">Peraturan Daerah</option>
                                </select>
                        </div>
                    </div>
                    <!--end col-->
                    <div class="col-xxl-2 col-lg-4">
                        <div class="position-relative">
                            <label class="form-label">Waktu Pengesahan</label>
                            <input type="month" class="form-control" value="" placeholder="Tgl" id="search_waktu" />
                        </div>
                    </div>
                    <!--end col-->
                    <div class="col-xxl-4 col-lg-4">
                        <div class="position-relative">
                            <label class="form-label">Unit Pembuat</label>
                            <select class="form-select selectFilter" id="search_pembuat" style="width: 100%" data-allow-clear="false" data-bs-auto-close="outside">
                                <option value="">Pilih</option>
                                @foreach($list['unit'] as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-xxl-3 col-lg-4">
                        <label class="form-label">Klik <a class="text-primary">Filter</a> untuk menampilkan data</label>
                        <div class="position-relative btn-group w-100 h-80 m-t-5">
                            <button type="button" class="btn btn-primary" id="btn-cari-show" onclick="cari()" disabled><i class="fa-fw fas fa-sync fa-spin me-1 nav-icon"></i> Filter</button>
                            <button type="button" class="btn btn-warning" onclick="bersih()"><i class="fa-fw fas fa-eraser me-1 nav-icon"></i> Reset</button>
                            <div class="dropdown">
                                <button type="button" class="btn btn-dark text-light" role="button" data-bs-toggle="dropdown" aria-haspopup="true" style="border-top-left-radius:0px;border-bottom-left-radius:0px">
                                    <i class="ti ti-brand-asana me-1"></i> Menu
                                </button>

                                <div class="dropdown-menu dropdown-menu-left">
                                    @if (Auth::user()->getPermission('admin_regulasi'))
                                        <a class="dropdown-item" href="javascript:void(0);" onclick="tambah()">Tambah Regulasi</a>
                                        <div class="dropdown-divider"></div>
                                    @endif
                                    <a class="dropdown-item disabled" href="javascript:void(0);" {{--  onclick="tataCara()" --}} ><s>Tata Cara</s></a>
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="showTotal()">Total Regulasi</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>

    <div class="card table-card" id="show_table" hidden>
        <div class="card-body text-nowrap">
            <div class="table-responsive">
                <table id="dttable" class="table dt-responsive table-hover nowrap w-100 align-middle">
                    <thead>
                        <tr>
                            <th style="width: 50px" class="text-center">#</th>
                            <th style="width: 50px" class="text-center">ID</th>
                            <th style="width: 90px">DISAHKAN</th>
                            <th>JUDUL - UNIT TERKAIT</th>
                            <th class="cell-fit">UNIT PEMBUAT</th>
                            <th style="width: 170px">UPDATE</th>
                        </tr>
                    </thead>
                    <tbody id="tampil-tbody">
                        <tr>
                            <td colspan="9" style="font-size:13px">
                                <center><i class="fa fa-spinner fa-spin fa-fw"></i> Memproses data...</center>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th style="width: 50px" class="text-center">#</th>
                            <th style="width: 50px" class="text-center">ID</th>
                            <th style="width: 90px">DISAHKAN</th>
                            <th>JUDUL - UNIT TERKAIT</th>
                            <th class="cell-fit">UNIT PEMBUAT</th>
                            <th style="width: 170px">UPDATE</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <div class="row justify-content-center mt-lg-4" id="show_iklan">
        <div class="col-xl-5 col-sm-8">
            <div class="card">
                <div class="card-body">
                    <div class="text-center">
                        <div class="row justify-content-center">
                            <div class="col-lg-10">
                                <h4 class="mt-4 fw-semibold">Berkas Regulasi</h4>
                                <p class="text-muted mt-3">Akses Regulasi dimanapun dan kapanpun Anda butuhkan.</p>
                            </div>
                        </div>

                        <div class="row justify-content-center mt-5 mb-2">
                            <div class="col-sm-6 col-8">
                                <div>
                                    <img src="{{ asset('images/verification-img.png') }}" alt="" class="img-fluid">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL TAMBAH --}}
    <div class="modal fade animate__animated animate__jackInTheBox" id="tambah" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h4 class="modal-title">
                    Tambah Regulasi
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <div class="form-group">
                                <label class="form-label">Jenis Regulasi <a class="text-danger">*</a></label>
                                <select class="form-select" id="jns_regulasi" style="width: 100%">
                                    <option value="" hidden>Pilih</option>
                                    <option value="1">Kebijakan</option>
                                    <option value="2">Panduan</option>
                                    <option value="3">Pedoman</option>
                                    <option value="4">Program</option>
                                    <option value="5">SPO</option>
                                    <option value="6">PPK</option>
                                    <option value="7">Undang-undang</option>
                                    <option value="8">PERPU</option>
                                    <option value="9">Peraturan Pemerintah</option>
                                    <option value="10">Peraturan Presiden</option>
                                    <option value="11">Peraturan Menteri</option>
                                    <option value="12">Peraturan Daerah</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="form-group">
                                <label class="form-label">Tgl. Pengesahan <a class="text-danger">*</a></label>
                                <input type="date" class="form-control" placeholder="YYYY-MM-DD" id="tgl"/>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label class="form-label">Unit Pembuat <a class="text-danger">*</a></label>
                                <select class="form-select selectFilter2" id="pembuat" style="width: 100%">
                                    <option value="" hidden>Pilih</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label class="form-label">Judul Dokumen <a class="text-danger">*</a></label>
                                <input type="text" id="judul" class="form-control" placeholder="e.g. PROSEDUR PERMINTAAN DARAH KEADAAN KHUSUS/CITO"/>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label class="form-label">Unit Terkait <a class="text-danger">*</a></label>
                                <input type="text" id="unit" class="form-control" placeholder="e.g. BDRS, RAWAT INAP, KEBIDANAN, ICU, IBS"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Upload <a class="text-danger">*</a></label>
                        <input type="file" class="form-control mb-2" id="filex" name="filex" accept="application/pdf">
                        <div class="alert alert-secondary">
                            <small>
                                @if (Auth::user()->getPermission('admin_regulasi_humas'))
                                    <i class="fa-fw fas fa-caret-right nav-icon"></i> Batas ukuran maksimum dokumen adalah <strong>5 mb</strong><br>
                                @else
                                    <i class="fa-fw fas fa-caret-right nav-icon"></i> Batas ukuran maksimum dokumen adalah <strong>2 mb</strong><br>
                                @endif
                                <i class="fa-fw fas fa-caret-right nav-icon"></i> File yang diupload berupa Dokumen Scan (PDF)
                            </small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" id="btn-upload" onclick="prosesTambah()"><i class="fa-fw fas fa-upload nav-icon"></i> Upload</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fa-fw fas fa-times nav-icon"></i> Tutup</button>
                </div>
            </div>
        </div>
    </div>
    {{-- MODAL UBAH --}}
    <div class="modal fade animate__animated animate__rubberBand" id="ubah" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        Ubah Regulasi
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <input type="text" id="id_edit" hidden>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <div class="form-group">
                                <label class="form-label">Jenis Regulasi <a class="text-danger">*</a></label>
                                <select class="form-control" id="jns_regulasi_edit" style="width: 100%">
                                    <option value="" hidden>Pilih</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="form-group">
                                <label class="form-label">Tgl. Pengesahan <a class="text-danger">*</a></label>
                                <input type="date" class="form-control" placeholder="YYYY-MM-DD" id="tgl_edit"/>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label class="form-label">Unit Pembuat <a class="text-danger">*</a></label>
                                <select class="form-control selectFilter3" id="pembuat_edit" style="width: 100%">
                                    <option value="" hidden>Pilih</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label class="form-label">Judul Dokumen <a class="text-danger">*</a></label>
                                <input type="text" id="judul_edit" class="form-control" placeholder="e.g. PROSEDUR PERMINTAAN DARAH KEADAAN KHUSUS/CITO"/>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label class="form-label">Unit Terkait <a class="text-danger">*</a></label>
                                <input type="text" id="unit_edit" class="form-control" placeholder="e.g. BDRS, RAWAT INAP, KEBIDANAN, ICU, IBS"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Upload Ulang Berkas? <a class="text-danger">*</a></label>
                        <div class="mb-3" id="upload_ulang"></div>
                        <div class="alert alert-secondary">
                            <small>
                                <i class="fa-fw fas fa-caret-right nav-icon"></i> Apabila terdapat kesalahan File Upload, Anda dapat melakukan <b>Input Dokumen Ulang</b> di bawah ini<br>
                                <i class="fa-fw fas fa-caret-right nav-icon"></i> Hubungi Admin untuk melakukan penghapusan berkas<br>
                                @if (Auth::user()->getPermission('admin_regulasi_humas'))
                                    <i class="fa-fw fas fa-caret-right nav-icon"></i> Batas ukuran maksimum dokumen adalah <strong>10 mb</strong><br>
                                @else
                                    <i class="fa-fw fas fa-caret-right nav-icon"></i> Batas ukuran maksimum dokumen adalah <strong>2 mb</strong><br>
                                @endif
                                <i class="fa-fw fas fa-caret-right nav-icon"></i> File yang diupload berupa Dokumen Scan (<b>PDF</b>)
                            </small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Berkas Regulasi Terupload</label>
                        <div id="berkas_regulasi"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" id="btn-ubah" onclick="prosesUbah()"><i class="fa-fw fas fa-upload nav-icon"></i> Upload</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fa-fw fas fa-times nav-icon"></i> Tutup</button>
                </div>
            </div>
        </div>
    </div>
    {{-- MODAL HAPUS --}}
    <div class="modal animate__animated animate__rubberBand fade" id="hapus" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-simple modal-add-new-address modal-dialog-centered">
            <div class="modal-content p-3 p-md-5">
                <div class="row">
                    <h4 class="modal-title text-center mb-3">
                        Hapus Regulasi ID : <a id="show_id_hapus"></a>
                    </h4>
                    <div class="col-12 mb-3">
                        <input type="text" id="id_hapus" hidden>
                        <p style="text-align: justify;">Anda akan menghapus berkas Regulasi tersebut. Penghapusan Regulasi akan menyebabkan hilangnya data/dokumen yang terhapus tersebut pada Storage Sistem.
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
                    <div class="col-12 text-center">
                        <button type="submit" id="btn-hapus" class="btn btn-danger me-sm-3 me-1" onclick="prosesHapus()"><i class="fa fa-trash me-1" style="font-size:13px"></i> Hapus</button>
                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-times me-1" style="font-size:13px"></i> Batal</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade animate__animated animate__jackInTheBox" id="tutor" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h4 class="modal-title">
                    Tata Cara Regulasi
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="col-md mb-4 mb-md-0">
                        <div class="accordion accordion-popout mt-3" id="accordionPopout">
                            <div class="card accordion-item">
                                <h2 class="accordion-header" id="headingPopoutOne">
                                    <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accordionPopoutOne" aria-expanded="true" aria-controls="accordionPopoutOne">
                                        Bagaimana melakukan Pencarian Dokumen Regulasi?
                                    </button>
                                </h2>

                                <div id="accordionPopoutOne" class="accordion-collapse collapse" aria-labelledby="headingPopoutOne" data-bs-parent="#accordionPopout">
                                    <div class="accordion-body">
                                        <p>
                                            Pencarian dokumen dilakukan dengan 3 pilihan pencarian yang tersedia yakni
                                            <ul>
                                                <li>Jenis Regulasi <b>(Nomor 1)</b></li>
                                                <li>Waktu Pengesahan <b>(Nomor 2)</b></li>
                                                <li>Unit Pembuat <b>(Nomor 3)</b></li>
                                            </ul>
                                            Anda dapat mengisi salah satu/dua dari tiga pilihan di atas, atau mengosongi semua pilihan untuk menampilkan data regulasi keseluruhan
                                        </p>
                                        <img src="{{ asset('img/tutorial/regulasi/1.png') }}" class="img-fluid mb-3" alt="">
                                        <p>
                                            Klik tombol Submit untuk mulai melakukan pencarian dokumen regulasi atau tombol Clear untuk mereset pilihan pencarian <b>(Nomor 4)</b>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="card accordion-item">
                                <h2 class="accordion-header" id="headingPopoutTwo">
                                    <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accordionPopoutTwo" aria-expanded="false" aria-controls="accordionPopoutTwo">
                                        Bagaimana langkah untuk mendownload dokumen?
                                    </button>
                                </h2>
                                <div id="accordionPopoutTwo" class="accordion-collapse collapse" aria-labelledby="headingPopoutTwo" data-bs-parent="#accordionPopout">
                                    <div class="accordion-body">
                                        <p>Lakukan pencarian pada kolom pencarian <b>(Nomor 5)</b> lalu silakan klik tombol pada kolom tabel judul atau dapat melalui tombol menu di setiap baris <b>(Nomor 6)</b></p>
                                        <img src="{{ asset('img/tutorial/regulasi/2.png') }}" class="img-fluid" alt="">
                                    </div>
                                </div>
                            </div>
                            <div class="card accordion-item">
                                <h2 class="accordion-header" id="headingPopoutThree">
                                    <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accordionPopoutThree" aria-expanded="false" aria-controls="accordionPopoutThree">
                                        Bagaimana cara melihat dokumen Regulasi tanpa mendownload?
                                    </button>
                                </h2>
                                <div id="accordionPopoutThree" class="accordion-collapse collapse" aria-labelledby="headingPopoutThree" data-bs-parent="#accordionPopout">
                                    <div class="accordion-body">
                                        <p>Terdapat 2 cara untuk melihat dokumen regulasi (PDF) tanpa mendownload. Apabila anda menggunakan browser Firefox, silakan abaikan semua langkah di bawah.</p>
                                        <div class="divider text-end">
                                            <div class="divider-text">Plugin PDF Viewer</div>
                                        </div>
                                        <p>
                                            <h6>1. Instal plugin untuk Google Chrome dengan membuka Link <a target="_blank" href="https://chrome.google.com/webstore/detail/pdf-viewer/oemmndcbldboiebfnladdacbdfmadadm?hl=in"><u>Disini</u></a></h6>
                                            <h6>2. Klik <strong>Tambahkan ke Chrome</strong></h6>
                                            <img src="{{ asset('img/pdf-viewer/1.jpg') }}" class="img-fluid" alt="">
                                            <h6>3. Klik <strong>Add extension</strong></h6>
                                            <img src="{{ asset('img/pdf-viewer/2.jpg') }}" class="img-fluid" alt="">
                                        </p>
                                        <div class="divider text-end">
                                            <div class="divider-text">Mode Incognito (Private Browser)</div>
                                        </div>
                                        <p>
                                            <h6>1. Masuk ke Menu Chrome dengan cara klik tombol Titik Tiga di Pojok Kanan Atas</h6>
                                            <img src="{{ asset('img/pdf-viewer/3.jpg') }}" class="img-fluid mb-3" alt="">
                                            <h6>2. Klik tombol <strong>New Incognito Window</strong> atau dengan menekan kombinasi tombol <strong>Ctrl+Shift+N</strong></h6>
                                            <h6>3. Masuk/Login <strong>Simrsmu</strong> kembali pada Mode Incognito tersebut dan anda sudah bisa melihat dokumen Regulasi tanpa harus mendownloadnya terlebih dahulu</h6>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fa-fw fas fa-times nav-icon"></i> Tutup</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade animate__animated animate__jackInTheBox" id="info" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h4 class="modal-title">
                    Total Regulasi
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table border-top table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-primary">JENIS REGULASI</th>
                                    <th class="text-primary">TOTAL</th>
                                </tr>
                            </thead>
                            <tbody id="tampil-tbody">
                                <tr>
                                    <th><h6>Kebijakan</h6></th>
                                    <td id="count_kebijakan"></td>
                                </tr>
                                <tr>
                                    <th><h6>Panduan</h6></th>
                                    <td id="count_panduan"></td>
                                </tr>
                                <tr>
                                    <th><h6>Pedoman</h6></th>
                                    <td id="count_pedoman"></td>
                                </tr>
                                <tr>
                                    <th><h6>Program</h6></th>
                                    <td id="count_program"></td>
                                </tr>
                                <tr>
                                    <th><h6>SPO</h6></th>
                                    <td id="count_spo"></td>
                                </tr>
                                <tr>
                                    <th><h6>PPK</h6></th>
                                    <td id="count_ppk"></td>
                                </tr>
                                <tr>
                                    <th><h6>Undang-Undang</h6></th>
                                    <td id="count_uu"></td>
                                </tr>
                                <tr>
                                    <th><h6>Peraturan Pemerintah Pengganti Undang-Undang (PERPU)</h6></th>
                                    <td id="count_perpu"></td>
                                </tr>
                                <tr>
                                    <th><h6>Peraturan Pemerintah</h6></th>
                                    <td id="count_pp"></td>
                                </tr>
                                <tr>
                                    <th><h6>Peraturan Presiden</h6></th>
                                    <td id="count_perpres"></td>
                                </tr>
                                <tr>
                                    <th><h6>Peraturan Menteri</h6></th>
                                    <td id="count_perment"></td>
                                </tr>
                                <tr>
                                    <th><h6>Peraturan Daerah</h6></th>
                                    <td id="count_perda"></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th class="text-primary">TOTAL KESELURUHAN</th>
                                    <td id="count_total"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fa-fw fas fa-times nav-icon"></i> Tutup</button>
                </div>
            </div>
        </div>
    </div>

    {{-- BACA REGULASI --}}
    <div id="bacaregulasi" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Regulasi <kbd>ID : <a href="javascript:void(0);" class="text-light" id="show_id_regulasi"></a></kbd></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="pushregulasi"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    {{-- Cetak Regulasi --}}
    <div id="modalCetak" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="dokumentasiLabel">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="dokumentasiLabel">Cetak Regulasi <kbd><a href="txIDCetak"></a></kbd></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-3">
                    <div id="file-cetak"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

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

            // DATE
            const l = $('.flatpickr');
            var now = moment().locale('id').format('Y-MM-DD HH:mm');
            l.flatpickr({
                enableTime: 0,
                minuteIncrement: 1,
                // defaultDate: now,
                time_24hr: true,
            })

            $('.selectFilter').select2({
                // dropdownAutoWidth: true,
                // width: '100%',
                dropdownParent: $('#filterTampil')
            });

            $('.selectFilter2').select2({
                dropdownParent: $('#tambah')
            });

            $('.selectFilter3').select2({
                dropdownParent: $('#ubah')
            });

            $('#search_regulasi').on('change', function() {
                if ($(this).val() == '7' || $(this).val() == '8' || $(this).val() == '9' || $(this).val() == '10' || $(this).val() == '11' || $(this).val() == '12') {
                    $('#search_waktu').prop('disabled',true);
                    $('#search_pembuat').prop('disabled',true);
                    $('#search_waktu').val('');
                    $('#search_pembuat').val('').change();
                } else {
                    $('#search_waktu').prop('disabled',false);
                    $('#search_pembuat').prop('disabled',false);
                }
            });

            $('#jns_regulasi').on('change', function() {
                if ($(this).val() == '7' || $(this).val() == '8' || $(this).val() == '9' || $(this).val() == '10' || $(this).val() == '11' || $(this).val() == '12') {
                    $('#tgl').prop('disabled',true);
                    $('#pembuat').prop('disabled',true);
                    $('#unit').prop('disabled',true);
                    $('#tgl').val('');
                    $('#pembuat').val('').change();
                    $('#unit').val('');
                } else {
                    $('#tgl').prop('disabled',false);
                    $('#pembuat').prop('disabled',false);
                    $('#unit').prop('disabled',false);
                }
            });

            // OPEN FOR SEARCHING
            $('#btn-cari-show').prop('disabled',false).find('i').removeClass('fa-sync fa-spin').addClass('fa-search');
        });

        function cari() {
            // $("#btn-cari").append('&nbsp;&nbsp;<span class="spinner-border" role="status" aria-hidden="true"></span>');
            $("#tampil-tbody").empty();
            $("#show_iklan").prop('hidden', true);
            $("#show_table").prop('hidden', false);
            $("#tampil-tbody").empty().append(`<tr><td colspan="9" style="font-size:13px"><center><i class="fa fa-spinner fa-spin fa-fw"></i> Memproses data...</center></td></tr>`);
            var regulasi    = $("#search_regulasi").val();
            var waktu       = $("#search_waktu").val();
            var pembuat     = $("#search_pembuat").val();
            $.ajax(
                {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "/api/regulasi/filter",
                    type: 'POST',
                    dataType: 'json', // added data type
                    data: {
                        regulasi: regulasi,
                        waktu: waktu,
                        pembuat: pembuat,
                    },
                    success: function(res) {
                        // var editorID = "{{ Auth::user()->getManyRole(['karu-it','sekretaris-direktur','administrator']) }}";
                        var adminID = "{{ Auth::user()->getPermission('admin_regulasi') }}";
                        iziToast.success({
                            title: 'Pesan Sukses!',
                            message: res.count+' data pencarian ditemukan',
                            position: 'topRight'
                        });
                        $("#tampil-tbody").empty();
                        $('#dttable').DataTable().clear().destroy();
                        res.show.forEach(item => {
                            // VALIDASI TUJUAN FROM JSON
                            // var us = JSON.parse(res.user);
                            // var updet = item.updated_at.substring(0, 10);
                            content = "<tr id='data"+ item.id +"'>";
                            content += `<td><center><div class='btn-group dropend'><a href='javascript:void(0);' class='text-dark font-size-16' data-bs-toggle='dropdown' aria-haspopup="true"><i class="ti ti-dots"></i></a><div class='dropdown-menu'>`
                                    + `<a href='javascript:void(0);' class='dropdown-item text-success' onclick="bacaRegulasi(`+item.id+`)"><i class='fas fa-book-open scaleX-n1-rtl'></i> Baca</a>`
                                    + `<a href='javascript:void(0);' class='dropdown-item text-info' onclick="cetak(`+item.id+`)"><i class='fas fa-print scaleX-n1-rtl'></i> Cetak</a>`
                                    + `<a href='javascript:void(0);' class='dropdown-item text-primary' onclick="window.open('/berkas/regulasi/`+item.id+`/download')"><i class='fas fa-download scaleX-n1-rtl'></i> Download</a>`;
                                    if (adminID == true) {
                                        content += `<a href='javascript:void(0);' class='dropdown-item text-warning' onclick="showUbah(`+item.id+`)" value="animate__rubberBand"><i class='fas fa-edit scaleX-n1-rtl'></i> Ubah</a>`
                                                + `<a href='javascript:void(0);' class='dropdown-item text-danger' onclick="hapus(`+item.id+`)" value="animate__rubberBand"><i class='fas fa-trash scaleX-n1-rtl'></i> Hapus</a>`;
                                    }
                            content += `</div></center></td><td class="text-center">`;
                            content += item.id + `</td><td>${item.sah?item.sah:'-'}</td><td style='white-space: normal !important;word-wrap: break-word;'>`
                                        + `<div class='d-flex justify-content-start align-items-center'><div class='d-flex flex-column'><h6 class='mb-0 text-primary'><u><a href='javascript:void(0);' onclick='cetak(` + item.id + `)'>` + item.judul + `</a></u></h6><small class='text-truncate text-muted' style='white-space: normal !important;word-wrap: break-word;'>`
                                        if (item.unit) {
                                            content += item.unit;
                                        } else {
                                            content += '-';
                                        }
                            content += "</small></div></div></td><td>";
                                        if (item.pembuat) {
                                            for(i = 0; i < res.unit.length; i++){
                                                if (res.unit[i].id == item.pembuat) {
                                                    content += res.unit[i].nama;
                                                }
                                            }
                                        } else {
                                            content += `-`;
                                        }
                            content += "</td><td>" + new Date(item.updated_at).toLocaleString("sv-SE") + "</td></tr>";
                            $('#tampil-tbody').append(content);
                        });
                        var table = $('#dttable').DataTable({
                            order: [
                                [5, "desc"]
                            ],
                            bAutoWidth: false,
                            aoColumns : [
                                { sWidth: '5%' },
                                { sWidth: '5%' },
                                { sWidth: '5%' },
                                { sWidth: '57%' },
                                { sWidth: '20%' },
                                { sWidth: '8%' },
                            ],
                            columnDefs: [
                                // { visible: false, targets: [7] },
                            ],
                            displayLength: 20,
                            lengthChange: true,
                            lengthMenu: [ 20, 35, 50, 75, 100, 500, 1000, 5000, 10000],
                            // buttons: ['copy', 'excel', 'pdf', 'colvis']
                        });
                    },
                    error: function(res) {
                        iziToast.error({
                            title: 'Pesan Galat!',
                            message: 'Data pencarian tidak ditemukan, ulangi sekali lagi.',
                            position: 'topRight'
                        });
                        $("#tampil-tbody").append(`<tr><td colspan="7" style="font-size:13px"><center>No data available in table</center></td></tr>`);
                    }
                }
            );
        }

        function bacaRegulasi(id) {
            $.ajax(
            {
                url: "/api/regulasi/baca/"+id,
                type: 'GET',
                dataType: 'json', // added data type
                success: function(res) {
                    $('#show_id_regulasi').text(res.id);
                    $('#pushregulasi').empty().append(`<div class="_df_book" id="fbook" source="/storage/`+res.filename.substring(7,1000)+`"></div>`);
                    // var flipbook = jQuery("#fbook").flipBook();
                    // flipbook.dispose();
                    flipbook = jQuery("#fbook").flipBook();
                    $('#bacaregulasi').modal('show');
                }
            });
        }

        // SHOW DOKUMENTASI E-ABSENSI
        function cetak(id) {
            fetch("/api/regulasi/cetak/"+id)
            .then(response => {
                if (!response.ok) {
                    throw new Error('File dokumentasi tidak ditemukan atau gagal diambil.');
                }
                return response.blob();
            })
            .then(blob => {
                // Buat object URL dari blob
                const fileURL = URL.createObjectURL(blob);

                $('#txIDCetak').text(id);
                // Tampilkan ke iframe dalam modal
                $('#file-cetak').empty().html(`<iframe src="${fileURL}" width="100%" height="500px" frameborder="0"></iframe>`);
                $('#modalCetak').modal('show');
            })
            .catch(error => {
                iziToast.error({
                    title: 'Maaf!',
                    message: 'File Dokumentasi tidak ditemukan atau belum dipublikasi.',
                    position: 'topRight'
                });
                console.error(error);
            });
        }

        function tambah() {
            $('jns_regulasi').val('').select2().change();
            $("#tgl").val('');
            $('pembuat').val('').select2().change();
            $("#judul").val('');
            $("#unit").val('');
            $("#filex").val('');
            $.ajax(
            {
                url: "/api/regulasi/showtambah",
                type: 'GET',
                dataType: 'json', // added data type
                success: function(res) {
                    res.forEach(item => {
                        $("#pembuat").append(`
                            <option value="${item.id}">${item.nama}</option>
                        `);
                    });
                }
            });
            $('#tambah').modal('show');
        }

        function prosesTambah() {
            $("#btn-upload").prop('disabled', true);
            $("#btn-upload").find("i").toggleClass("fa-save fa-sync fa-spin");

            var user_id         = "{{ Auth::user()->id }}";
            var jns_regulasi    = $("#jns_regulasi").val();
            var tgl             = $("#tgl").val();
            var pembuat         = $("#pembuat").val();
            var judul           = $("#judul").val();
            var unit            = $("#unit").val();
            var filex           = $('#filex')[0].files.length;

            if (jns_regulasi == "" || judul == "" || filex == 0) {
                iziToast.error({
                    title: 'Pesan Galat!',
                    message: 'Mohon lengkapi semua data terlebih dahulu dan pastikan tidak ada yang kosong',
                    position: 'topRight'
                });
            } else {
                if (jns_regulasi == '7' || jns_regulasi == '8' || jns_regulasi == '9' || jns_regulasi == '10' || jns_regulasi == '11' || jns_regulasi == '12') {
                    var fd = new FormData();

                    // Get the selected file
                    var files = $('#filex')[0].files;
                    var judul = $("#judul").val();
                    fd.append('file',files[0]);
                    fd.append('user_id',user_id);
                    fd.append('jns_regulasi',$("#jns_regulasi").val());
                    fd.append('judul',judul);
                    // console.log('sampe sini');
                    // AJAX request
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: "{{route('regulasi.tambah')}}",
                        method: 'post',
                        data: fd,
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                        success: function(res){
                            iziToast.success({
                                title: 'Pesan Sukses!',
                                message: 'REGULASI - '+judul+' berhasil ditambah',
                                position: 'topRight'
                            });
                            if (res) {
                                $('#tambah').modal('hide');
                                cari();
                            }
                        },
                        error: function(res){
                            console.log("error : " + JSON.stringify(res) );
                            iziToast.error({
                                title: 'Error '+res.status+' - '+res.statusText+'!',
                                message: res.responseJSON,
                                position: 'topRight'
                            });
                        }
                    });
                } else {
                    if (tgl == "" || pembuat == "" || unit == "") {
                        iziToast.error({
                            title: 'Pesan Galat!',
                            message: 'Mohon lengkapi semua data terlebih dahulu dan pastikan tidak ada yang kosong',
                            position: 'topRight'
                        });
                    } else {
                        var fd = new FormData();

                        // Get the selected file
                        var files = $('#filex')[0].files;
                        var judul = $("#judul").val();
                        fd.append('file',files[0]);

                        fd.append('user_id',user_id);
                        fd.append('jns_regulasi',$("#jns_regulasi").val());
                        fd.append('tgl',$("#tgl").val());
                        fd.append('pembuat',$("#pembuat").val());
                        fd.append('judul',judul);
                        fd.append('unit',$("#unit").val());

                        // AJAX request
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url: "{{route('regulasi.tambah')}}",
                            method: 'post',
                            data: fd,
                            contentType: false,
                            processData: false,
                            dataType: 'json',
                            success: function(res){
                                iziToast.success({
                                    title: 'Pesan Sukses!',
                                    message: 'REGULASI - '+judul+' berhasil ditambah',
                                    position: 'topRight'
                                });
                                if (res) {
                                    $('#tambah').modal('hide');
                                    cari();
                                }
                            },
                            error: function(res){
                                console.log("error : " + JSON.stringify(res) );
                                iziToast.error({
                                    title: 'Error '+res.status+' - '+res.statusText+'!',
                                    message: res.responseJSON,
                                    position: 'topRight'
                                });
                            }
                        });
                    }
                }
            }

            $("#btn-upload").find("i").removeClass("fa-sync fa-spin").addClass("fa-save");
            $("#btn-upload").prop('disabled', false);
        }

        function showUbah(id) {
            $.ajax(
            {
                url: "/api/regulasi/showubah/"+id,
                type: 'GET',
                dataType: 'json', // added data type
                success: function(res) {
                    // var dt = new Date(res.show.tanggal).toJSON().slice(0,19);
                    var sah = moment(res.show.sah).format('Y-MM-DD');
                    document.getElementById('berkas_regulasi').innerHTML = "<h6><a href='/berkas/regulasi/"+res.show.id+"/download' target='_blank'>"+res.show.title+"</a></h6>";
                    document.getElementById('upload_ulang').innerHTML = `<input type='file' id="filex_edit" name='filex_edit' class="form-control" accept="application/pdf">`;
                    $("#id_edit").val(res.show.id);

                    // INIT DATE EDIT
                    var a = document.querySelector("#tgl_edit");
                    // var tgl_push = moment(res.show.sah).format('Y-MM-DD');
                    // a.flatpickr({
                    //     enableTime: 0,
                    //     minuteIncrement: 1,
                    //     defaultDate: res.show.sah,
                    //     time_24hr: true,
                    // })

                    $("#judul_edit").val(res.show.judul);
                    $("#unit_edit").val(res.show.unit);
                    $("#tgl_edit").val(res.show.sah);
                    $("#jns_regulasi_edit").find('option').remove();
                    $("#jns_regulasi_edit").append(`
                        <option value="1" ${res.show.jns_regulasi == 1 ? "selected":""}>Kebijakan</option>
                        <option value="2" ${res.show.jns_regulasi == 2 ? "selected":""}>Panduan</option>
                        <option value="3" ${res.show.jns_regulasi == 3 ? "selected":""}>Pedoman</option>
                        <option value="4" ${res.show.jns_regulasi == 4 ? "selected":""}>Program</option>
                        <option value="5" ${res.show.jns_regulasi == 5 ? "selected":""}>SPO</option>
                        <option value="6" ${res.show.jns_regulasi == 6 ? "selected":""}>PPK</option>
                        <option value="7" ${res.show.jns_regulasi == 7 ? "selected":""}>Undang-undang</option>
                        <option value="8" ${res.show.jns_regulasi == 8 ? "selected":""}>PERPU</option>
                        <option value="9" ${res.show.jns_regulasi == 9 ? "selected":""}>Peraturan Pemerintah</option>
                        <option value="10" ${res.show.jns_regulasi == 10 ? "selected":""}>Peraturan Presiden</option>
                        <option value="11" ${res.show.jns_regulasi == 11 ? "selected":""}>Peraturan Menteri</option>
                        <option value="12" ${res.show.jns_regulasi == 12 ? "selected":""}>Peraturan Daerah</option>
                    `);
                    if ($("#jns_regulasi_edit").val() == '7' || $("#jns_regulasi_edit").val() == '8' || $("#jns_regulasi_edit").val() == '9' || $("#jns_regulasi_edit").val() == '10' || $("#jns_regulasi_edit").val() == '11' || $("#jns_regulasi_edit").val() == '12') {
                        $('#tgl_edit').prop('disabled',true);
                        $('#pembuat_edit').prop('disabled',true);
                        $('#unit_edit').prop('disabled',true);
                        $('#tgl_edit').val('');
                        $('#pembuat_edit').val('').change();
                        $('#unit_edit').val('');
                    } else {
                        $('#tgl_edit').prop('disabled',false);
                        $('#pembuat_edit').prop('disabled',false);
                        $('#unit_edit').prop('disabled',false);
                    }
                    $("#pembuat_edit").find('option').remove();
                    res.unit.forEach(pounch => {
                        $("#pembuat_edit").append(`
                            <option value="" hidden>Pilih</option>
                            <option value="${pounch.id}" ${res.show.pembuat == pounch.id ? "selected":""}>${pounch.nama}</option>
                        `);
                    });
                    $('#ubah').modal('show');
                }
            });
            $('#jns_regulasi_edit').on('change', function() {
                if ($(this).val() == '7' || $(this).val() == '8' || $(this).val() == '9' || $(this).val() == '10' || $(this).val() == '11' || $(this).val() == '12') {
                    $('#tgl_edit').prop('disabled',true);
                    $('#pembuat_edit').prop('disabled',true);
                    $('#unit_edit').prop('disabled',true);
                    $('#tgl_edit').val('');
                    $('#pembuat_edit').val('').change();
                    $('#unit_edit').val('');
                } else {
                    $('#tgl_edit').prop('disabled',false);
                    $('#pembuat_edit').prop('disabled',false);
                    $('#unit_edit').prop('disabled',false);
                }
            });
        }

        function prosesUbah() {
            $("#btn-ubah").prop('disabled', true);
            $("#btn-ubah").find("i").toggleClass("fa-save fa-sync fa-spin");

            var user_id         = "{{ Auth::user()->id }}";
            var id_edit         = $("#id_edit").val();
            var jns_regulasi    = $("#jns_regulasi_edit").val();
            var tgl             = $("#tgl_edit").val();
            var pembuat         = $("#pembuat_edit").val();
            var judul           = $("#judul_edit").val();
            var unit            = $("#unit_edit").val();
            var filex           = $('#filex_edit')[0].files.length;

            if (jns_regulasi == "" || tgl == "" || pembuat == "" || judul == "" || unit == "") {
                iziToast.error({
                    title: 'Pesan Galat!',
                    message: 'Mohon lengkapi kolom pengisian wajib *',
                    position: 'topRight'
                });
            } else {
                var fd = new FormData();

                if (filex == 0) {
                    fd.append('file',null);
                } else {
                    // Get the selected file
                    var files = $('#filex_edit')[0].files;
                    console.log(files);
                    var judul = $("#judul_edit").val();
                    fd.append('file',files[0]);
                }

                fd.append('user_id',user_id);
                fd.append('id_edit',$("#id_edit").val());
                fd.append('jns_regulasi',$("#jns_regulasi_edit").val());
                fd.append('tgl',$("#tgl_edit").val());
                fd.append('pembuat',$("#pembuat_edit").val());
                fd.append('judul',judul);
                fd.append('unit',$("#unit_edit").val());

                // AJAX request
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ route('regulasi.ubah') }}",
                    method: 'post',
                    data: fd,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(res){
                        iziToast.success({
                            title: 'Pesan Sukses!',
                            message: 'REGULASI ' + judul + ' berhasil diperbarui pada '+res,
                            position: 'topRight'
                        });
                        if (res) {
                            $('#ubah').modal('hide');
                            cari();
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
            $("#show_id_hapus").text(id);
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
                    url: "/api/regulasi/"+id,
                    type: 'DELETE',
                    success: function(res) {
                        iziToast.success({
                            title: 'Pesan Sukses!',
                            message: 'Berkas telah berhasil dihapus pada '+res,
                            position: 'topRight'
                        });
                        $('#hapus').modal('hide');
                        cari();
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

        function bersih() {
            $('#search_regulasi').val('').trigger('change');
            $('#search_waktu').val('');
            $('#search_pembuat').val('').trigger('change');
            $("#show_table").prop('hidden', true);
            $("#show_iklan").prop('hidden', false);
        }

        function showTotal() {
            $('#info').modal('show');
            $.ajax(
                {
                url: "/api/regulasi/totalregulasi",
                type: 'GET',
                dataType: 'json', // added data type
                success: function(res) {
                    $("#count_kebijakan").text(res.totkebijakan);
                    $("#count_panduan").text(res.totpanduan);
                    $("#count_pedoman").text(res.totpedoman);
                    $("#count_program").text(res.totprogram);
                    $("#count_spo").text(res.totspo);
                    $("#count_ppk").text(res.totppk);
                    $("#count_uu").text(res.totuu);
                    $("#count_perpu").text(res.totperpu);
                    $("#count_pp").text(res.totpp);
                    $("#count_perpres").text(res.totperpres);
                    $("#count_perment").text(res.totperment);
                    $("#count_perda").text(res.totperda);
                    $("#count_total").text(res.total);
                }
                }
            );
        }

        function tataCara() {
            $('#tutor').modal('show');
        }
    </script>
@endsection
