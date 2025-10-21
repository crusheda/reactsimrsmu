@extends('layouts.index')

@section('content')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i></a></li>
                        <li class="breadcrumb-item">Inventaris</li>
                        <li class="breadcrumb-item"><a href="{{ route('aset.index') }}">Aset</a></li>
                        <li class="breadcrumb-item" aria-current="page">Detail</li>
                    </ul>
                </div>
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h2 class="mb-0">Detail Aset</h2>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- [ breadcrumb ] end -->

    <!-- [ Main Content ] start -->
    <div class="row pt-1">
        <div class="col-xl-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="fw-semibold text-center">SCAN - <b>QR CODE</b></h5>
                        <center><div class="mb-3" id="qr"><i class="fa fa-spinner fa-spin fa-fw"></i> Memuat..</div></center>
                        {{-- <div class="mb-3">
                            <center>
                                {!! DNS2D::getBarcodeHTML($list['show']->token, 'QRCODE',5,5) !!}
                            </center>
                        </div> --}}
                    {{-- <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th scope="col">Job Title</th>
                                    <td scope="col">Magento Developer</td>
                                </tr>
                                <tr>
                                    <th scope="row">Experience:</th>
                                    <td>0-2 Years</td>
                                </tr>
                                <tr>
                                    <th scope="row">Vacancy</th>
                                    <td>12</td>
                                </tr>
                                <tr>
                                    <th scope="row">Job Type</th>
                                    <td><span class="badge badge-soft-success">Full Time</span></td>
                                </tr>
                                <tr>
                                    <th scope="row">Status</th>
                                    <td><span class="badge badge-soft-info">New</span></td>
                                </tr>
                                <tr>
                                    <th scope="row">Posted Date</th>
                                    <td>25 June, 2022</td>
                                </tr>
                                <tr>
                                    <th scope="row">Close Date</th>
                                    <td>13 April, 2022</td>
                                </tr>
                            </tbody>
                        </table>
                    </div> --}}
                    <div class="hstack gap-2">
                        <button class="btn btn-light-dark w-100" onclick="window.location='{{ route('aset.index') }}'"><i class="ti ti-arrow-back-up"></i>&nbsp;Kembali</button>
                        {{-- <button class="btn btn-light-info w-100" disabled><i class="bx bx-download scaleX-n1-rtl"></i> Download</button> --}}
                        <button class="btn btn-light-warning w-100" onclick="cetak()"><i class="ti ti-printer"></i>&nbsp;Cetak</button>
                        <a class="btn btn-light-success w-100 tombol-menu" href="javascript:void(0);" role="button"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" hidden>
                            <i class="ti ti-caret-down"></i>&nbsp;Menu
                        </a>
                        <div class="dropdown-menu dropdown-menu-end tombol-menu">
                            <a class="dropdown-item menu-pemeliharaan" href="javascript:void(0);" onclick="modalPemeliharaan({{ $list['show']->id }})">Pemeliharaan</a>
                            <a class="dropdown-item menu-mutasi" href="javascript:void(0);" onclick="modalMutasi({{ $list['show']->id }})">Mutasi</a>
                            <a class="dropdown-item menu-peminjaman" href="javascript:void(0);" onclick="modalPeminjaman({{ $list['show']->id }})">Peminjaman</a>
                            <a class="dropdown-item menu-pengembalian" href="javascript:void(0);" onclick="modalPengembalian({{ $list['show']->id }})">Pengembalian</a>
                            <a class="dropdown-item menu-penarikan" href="javascript:void(0);" onclick="modalPenarikan({{ $list['show']->id }})">Penarikan</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="text-center">
                        {{-- <div id="kondisi_aset" class="bg-body p-3 rounded">
                            <div class="text-primary m-1" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div> --}}
                        {{-- @if ($list['show']->kondisi == 1)
                            <div class="avatar-md mx-auto mb-3">
                                <div class="avatar-title bg-light rounded-circle text-primary h1">
                                    <i class="fas fa-check"></i>
                                </div>
                            </div>
                            <p class="text-primary mb-0"><b>Kondisi Baik</b></p>
                        @else
                            @if ($list['show']->kondisi == 2)
                                <div class="avatar-md mx-auto mb-3">
                                    <div class="avatar-title bg-warning rounded-circle text-light h1">
                                        <i class="fas fa-minus"></i>
                                    </div>
                                </div>
                                <p class="text-warning mb-0"><b>Kondisi Cukup</b></p>
                            @else
                                @if ($list['show']->kondisi == 3)
                                    <div class="avatar-md mx-auto mb-3">
                                        <div class="avatar-title bg-danger rounded-circle text-light h1">
                                            <i class="fas fa-times"></i>
                                        </div>
                                    </div>
                                    <p class="text-danger mb-0"><b>Kondisi Buruk</b></p>
                                @else
                                    <div class="avatar-md mx-auto mb-3">
                                        <div class="avatar-title bg-dark rounded-circle text-light h1">
                                            <i class="mdi mdi-email-open"></i>
                                        </div>
                                    </div>
                                    <p class="text-dark mb-0"><b>Kondisi Tidak Terdefinisi</b></p>
                                @endif
                            @endif
                        @endif --}}
                        {{-- <button class="btn btn-warning-outline btn-sm" onclick="showUpdateKondisi({{ $list['show']->kondisi }})" data-bs-toggle="tooltip"
                        data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true"
                        title="Kondisi Sekarang"><i class='bx bx-edit scaleX-n1-rtl'></i> Perbarui Kondisi</button> --}}
                        {{-- <hr> --}}
                        <div class="row text-center">
                            <div class="col-6 border border-top-0 border-bottom-0 border-start-0">
                                <div class="mt-3">
                                    <p class="text-muted mb-1"><b>Status Aset</b></p>
                                    <h3 id="status_aset">
                                        <small class="mt-3"><center><i class="fa fa-spinner fa-spin fa-fw"></i></center></small>
                                    </h3>
                                </div>
                            </div>

                            <div class="col-6 border border-top-0 border-bottom-0 border-end-0">
                                <div class="mt-3">
                                    <p class="text-muted mb-1"><b>Kondisi Aset</b></p>
                                    <h3 id="kondisi_aset">
                                        <small class="mt-3"><center><i class="fa fa-spinner fa-spin fa-fw"></i></center></small>
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- SEDANG DALAM PROSES DEVELOPMENT----------------------------------------------------------------------------------------------------------- --}}
                    {{-- <hr>
                    <div class="bg-transparent mb-3">
                        <ul class="nav nav-tabs nav-tabs-custom" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#post-mutasi" role="tab">
                                    Mutasi
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#post-peminjaman" role="tab">
                                    Peminjaman
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#post-pengembalian" role="tab">
                                    Pengembalian
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content">
                        MUTASI
                        <div class="tab-pane active" id="post-mutasi" role="tabpanel">
                            <div data-simplebar style="max-height: 376px;">
                                <ul class="verti-timeline list-unstyled">
                                    <li class="event-list">
                                        <div class="event-timeline-dot">
                                            <i class="bx bx-right-arrow-circle font-size-18"></i>
                                        </div>
                                        <div class="d-flex">
                                            <div class="flex-shrink-0 me-3">
                                                @if (!empty($list['mutasi']->filename))
                                                    <img src="{{ url('storage/' . substr($list['mutasi']->filename, 7, 1000)) }}" alt="" class="avatar-xs rounded-circle">
                                                @else
                                                @endif
                                                <img class="avatar-xs rounded-circle" alt="" src="{{ url("images/no-image-person.png") }}">
                                            </div>
                                            <div class="flex-grow-1">
                                                <div>
                                                    <b>Charles Brown</b> applied for the job <b>Sr.frontend Developer</b>
                                                    <p class="mb-0 text-muted">3 min ago</p>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        PEMINJAMAN
                        <div class="tab-pane" id="post-peminjaman" role="tabpanel">
                            <div data-simplebar style="max-height: 376px;">
                                <ul class="verti-timeline list-unstyled">
                                    <li class="event-list">
                                        <div class="event-timeline-dot">
                                            <i class="bx bx-right-arrow-circle font-size-18"></i>
                                        </div>
                                        <div class="d-flex">
                                            <div class="flex-shrink-0 me-3">
                                                <img src="assets/images/users/avatar-5.jpg" alt="" class="avatar-xs rounded-circle">
                                            </div>
                                            <div class="flex-grow-1">
                                                <div>
                                                    <b>Cdasdasdwn</b> applcxvxcvcxhe job <b>Sr.fronvcbvcbcvbvcvbvvcend Developer</b>
                                                    <p class="mb-0 text-muted">1 hour ago</p>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        PENGEMBALIAN
                        <div class="tab-pane" id="post-pengembalian" role="tabpanel">
                            <div data-simplebar style="max-height: 376px;">
                                <ul class="verti-timeline list-unstyled">
                                    <li class="event-list">
                                        <div class="event-timeline-dot">
                                            <i class="bx bx-right-arrow-circle font-size-18"></i>
                                        </div>
                                        <div class="d-flex">
                                            <div class="flex-shrink-0 me-3">
                                                <img src="assets/images/users/avatar-5.jpg" alt="" class="avatar-xs rounded-circle">
                                            </div>
                                            <div class="flex-grow-1">
                                                <div>
                                                    <b>Cdasdasdwn</b>
                                                    <p class="mb-0 text-muted">6 hour ago</p>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <ul class="list-unstyled mt-4">
                        <li>
                            <div class="d-flex">
                                <i class="bx bx-phone text-primary fs-4"></i>
                                <div class="ms-3">
                                    <h6 class="fs-14 mb-2">Phone</h6>
                                    <p class="text-muted fs-14 mb-0">+589 560 56555</p>
                                </div>
                            </div>
                        </li>
                        <li class="mt-3">
                            <div class="d-flex">
                                <i class="bx bx-mail-send text-primary fs-4"></i>
                                <div class="ms-3">
                                    <h6 class="fs-14 mb-2">Email</h6>
                                    <p class="text-muted fs-14 mb-0">themesbrand@gmail.com</p>
                                </div>
                            </div>
                        </li>
                        <li class="mt-3">
                            <div class="d-flex">
                                <i class="bx bx-globe text-primary fs-4"></i>
                                <div class="ms-3">
                                    <h6 class="fs-14 mb-2">Website</h6>
                                    <p class="text-muted fs-14 text-break mb-0">www.themesbrand.com</p>
                                </div>
                            </div>
                        </li>
                        <li class="mt-3">
                            <div class="d-flex">
                                <i class="bx bx-map text-primary fs-4"></i>
                                <div class="ms-3">
                                    <h6 class="fs-14 mb-2">Location</h6>
                                    <p class="text-muted fs-14 mb-0">Oakridge Lane Richardson.</p>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <div class="mt-4">
                        <a href="#!" class="btn btn-light-primary btn-hover w-100 rounded"><i class="mdi mdi-eye"></i> Tampilkan Semua Riwayat</a>
                    </div> --}}
                    {{-- SEDANG DALAM PROSES DEVELOPMENT----------------------------------------------------------------------------------------------------------- --}}
                </div>
            </div>
        </div><!--end col-->
        <div class="col-xl-8">
            <div class="card">
                <div class="card-body border-bottom">
                    <div class="d-flex">
                        {{-- <img src="assets/images/companies/wechat.svg" alt="" height="50"> --}}
                        <div class="flex-grow-1">
                            <h5 class="fw-semibold"><kbd>ID : {{ $list['show']->id }}</kbd>&nbsp;&nbsp;
                                <a class="text-dark" href="javascript:void(0);" data-bs-toggle="tooltip"
                                data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="Nama Aset">
                                    {{ $list['show']->sarana }}&nbsp;
                                    @if ($list['show']->jenis == 1)
                                        <a href="javascript: void(0);" class="badge bg-danger font-size-12">
                                            <i class="ti ti-medical-cross text-white me-1"></i> Aset Medis
                                        </a>
                                    @else
                                        <a href="javascript: void(0);" class="badge bg-warning font-size-12">
                                            <i class="ti ti-medical-cross text-white me-1"></i> Aset Non Medis
                                        </a>
                                    @endif
                                </a>
                            </h5>
                            <h6>No. Inventaris : <a href="javascript:void(0);" id="show_no_inventaris">{{ $list['show']->no_inventaris }}</a></h6>
                            <ul class="list-unstyled hstack gap-2 mb-0">
                                <li data-bs-toggle="tooltip"
                                data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="Nomor Seri">
                                    <i class="fas fa-barcode"></i> <span class="text-muted">{{ $list['show']->no_seri }}</span>
                                </li>
                                <li data-bs-toggle="tooltip"
                                data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="Ruangan - Lokasi Sekarang">
                                    <i class="bx bx-map"></i> <span class="text-muted" id="ruangan_aset">{{ $list['show']->ruangan.' - '.$list['show']->lokasi }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @php
                        $lampiran = json_decode($list['show']->filename);
                    @endphp
                    @if (!empty($lampiran))
                        <div id="carouselExampleControls" class="carousel carousel-dark slide mb-1" data-bs-ride="carousel">
                            <div class="carousel-inner" role="listbox">
                                @for ($i = 0; $i < count($lampiran); $i++)
                                    <div class="carousel-item @if ($i == 0) active @endif" data-bs-interval="10000">
                                        <center><img class="d-block img-fluid" style="max-height: 600px" src="{{ url('storage/'.substr($lampiran[$i],7,1000)) }}"></center>
                                    </div>
                                @endfor
                            </div>
                            <br><img src="" alt="" srcset="" id="pdf_preview">
                            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon text-dark" aria-hidden="true"></span>
                                <span class="sr-only">Sebelumnya</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Selanjutnya</span>
                            </a>
                        </div>
                    @endif

                    <div class="text-center mb-3">
                        <div class="row bg-body p-3 rounded">
                            <div class="col-sm-3">
                                <div>
                                    <p class="text-muted mb-2">Tgl. Input Aset</p>
                                    <h5 class="font-size-15">{{ Carbon\Carbon::parse($list['show']->created_at)->isoFormat('D MMM Y, HH.mm A') }}</h5>
                                    <small class="text-success">Oleh {{ $list['user']->nama }}</small>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="mt-4 mt-sm-0">
                                    <p class="text-muted mb-2">Tgl. Perolehan</p>
                                    <h5 class="font-size-15">{{ Carbon\Carbon::parse($list['show']->tgl_perolehan)->isoFormat('D MMM Y') }}</h5>
                                    <small class="text-success">{{ \Illuminate\Support\Carbon::createFromTimeStamp(strtotime($list['show']->tgl_perolehan))->diffInDays(now(), false) }} hari yang lalu</small>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="mt-4 mt-sm-0">
                                    <p class="text-muted mb-2">Tgl. Kalibrasi</p>
                                    @if ($list['show']->tgl_berlaku != null)
                                    <h5 class="font-size-15">
                                            {{ Carbon\Carbon::parse($list['show']->tgl_berlaku)->isoFormat('D MMM Y') }}
                                    </h5>
                                    <small class="text-success">{{ \Illuminate\Support\Carbon::createFromTimeStamp(strtotime($list['show']->tgl_berlaku))->diffInDays(now(), false) }} hari yang lalu</small>
                                    @else
                                    <h5 class="font-size-15">-</h5>
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="mt-4 mt-sm-0">
                                    <p class="text-muted mb-2">Tgl. Beroperasi</p>
                                    <h5 class="font-size-15">{{ Carbon\Carbon::parse($list['show']->tgl_operasi)->isoFormat('D MMM Y') }}</h5>
                                    <small class="text-success">{{ \Illuminate\Support\Carbon::createFromTimeStamp(strtotime($list['show']->tgl_operasi))->diffInDays(now(), false) }} hari yang lalu</small>
                                    {{-- <small class="text-success">{{ Carbon\Carbon::parse($list['show']->tgl_operasi)->diffInDays() }}</small> --}}
                                </div>
                            </div>
                        </div>
                    </div>

                    <h5 class="fw-semibold mb-3"><i class="ph-duotone ph-arrow-bend-down-right"></i>&nbsp;Spesifikasi</h5>
                    {{-- <p class="text-muted mb-4"></p> --}}
                    <div class="table-responsive mb-3" style="border: 0px">
                        <table class="table table-nowrap mb-0" style="width:100%">
                            <tbody>
                                <tr>
                                    <th scope="row" style="width:15%">Merk</th>
                                    <td>:&nbsp;&nbsp;{{ $list['show']->merk }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" style="width:15%">Tipe</th>
                                    <td>:&nbsp;&nbsp;{{ $list['show']->tipe }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" style="width:15%">No. Seri</th>
                                    <td>:&nbsp;&nbsp;{{ $list['show']->no_seri }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" style="width:15%">No. Kalibrasi</th>
                                    <td>:&nbsp;&nbsp;{{ $list['show']->no_kalibrasi }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    @if ($list['show']->keterangan)
                    <h5 class="fw-semibold mb-3"><i class="ph-duotone ph-arrow-bend-down-right"></i>&nbsp;Keterangan</h5>
                    <p class="text-muted">{{ $list['show']->keterangan }}</p>
                    @endif

                    <h5 class="fw-semibold mb-3"><i class="ph-duotone ph-arrow-bend-down-right"></i>&nbsp;Nilai Aset</h5>
                    <div class="text-right">
                        <h4><mark id="show_nilai_perolehan"></mark></h4>
                        <p class="text-muted mt-3">Asal Perolehan <i class="fa-fw fas fa-caret-right nav-icon"></i>
                            @if ($list['show']->asal_perolehan == 1)
                                <b>Beli</b>
                            @else
                                @if ($list['show']->asal_perolehan == 2)
                                    <b>Hibah</b>
                                @else
                                    @if ($list['show']->asal_perolehan == 3)
                                        <b>Wakaf</b>
                                    @else
                                        @if ($list['show']->asal_perolehan == 4)
                                            <b>KSO</b>
                                        @else
                                            <b>-</b>
                                        @endif
                                    @endif
                                @endif
                            @endif
                        </p>
                    </div>

                    {{-- <h5 class="fw-semibold mb-3">Skill & Experience:</h5>
                    <ul class="vstack gap-3 mb-0">
                        <li>
                            Understanding of key Design Principal
                        </li>
                        <li>
                            Proficiency With HTML, CSS, Bootstrap
                        </li>
                        <li>
                            WordPress: 1 year (Required)
                        </li>
                        <li>
                            Experience designing and developing responsive design websites
                        </li>
                        <li>
                            web designing: 1 year (Preferred)
                        </li>
                    </ul> --}}

                    {{-- <div class="mt-4">
                        <span class="badge badge-soft-warning">PHP</span>
                        <span class="badge badge-soft-warning">Magento</span>
                        <span class="badge badge-soft-warning">Marketing</span>
                        <span class="badge badge-soft-warning">WordPress</span>
                        <span class="badge badge-soft-warning">Bootstrap</span>
                    </div> --}}

                    {{-- <div class="mt-4">
                        <ul class="list-inline mb-0">
                            <li class="list-inline-item mt-1">
                                Share this job:
                            </li>
                            <li class="list-inline-item mt-1">
                                <a href="javascript:void(0)" class="btn btn-outline-primary btn-hover"><i class="uil uil-facebook-f"></i> Facebook</a>
                            </li>
                            <li class="list-inline-item mt-1">
                                <a href="javascript:void(0)" class="btn btn-outline-danger btn-hover"><i class="uil uil-google"></i> Google+</a>
                            </li>
                            <li class="list-inline-item mt-1">
                                <a href="javascript:void(0)" class="btn btn-outline-success btn-hover"><i class="uil uil-linkedin-alt"></i> linkedin</a>
                            </li>
                        </ul>
                    </div> --}}
                </div>
            </div>
        </div><!--end col-->
    </div><!--end row-->

    {{----------------------------------------------------------- MODAL ---------------------------------------------------------------}}

    {{-- MODAL PEMELIHARAAN --}}
    <div class="modal fade" id="formPemeliharaan" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        Formulir Pemeliharaan Aset&nbsp;&nbsp;&nbsp;
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label class="form-label">Petugas <a class="text-danger">*</a></label>
                                <div class="select2-dark">
                                    <select class="select2 form-select" id="petugas_pemeliharaan" data-allow-clear="false" data-bs-auto-close="outside" style="width: 100%" required>
                                        <option value="">Pilih</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label class="form-label">Hasil <a class="text-danger">*</a></label>
                                <textarea rows="2" id="hasil_pemeliharaan" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label class="form-label">Rekomendasi <a class="text-danger">*</a></label>
                                <textarea rows="2" id="rekomendasi_pemeliharaan" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 text-center mb-3">
                    <div class="btn-group">
                        <button class="btn btn-light-warning btn-rounded" onclick="refreshModalPemeliharaan({{ $list['show']->id }})" data-bs-toggle="tooltip"
                        data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="Refresh Tabel Riwayat Pemeliharaan"><i class="fa fa-sync"></i>&nbsp;&nbsp;Refresh</button>
                        <button type="reset" class="btn btn-light-secondary btn-rounded" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-times me-1" style="font-size:13px"></i>&nbsp;&nbsp;Tutup</button>
                        <button class="btn btn-light-primary btn-rounded" onclick="prosesPemeliharaan()" data-bs-toggle="tooltip"
                        data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="Tambah Pemeliharaan Aset" id="btn-simpan-pemeliharaan"><i class="fas fa-wrench"></i>&nbsp;&nbsp;Submit</button>
                    </div>
                </div>
                <hr>
                <div class="table-responsive text-nowrap mb-4" style="border: 0px;margin-left:20px;margin-right:20px">
                    <h4 class="card-title">Riwayat Pemeliharaan <mark>{{ $list['show']->sarana }}</mark></h4>
                    <p class="card-title-desc"><footer class="blockquote-footer">No. Inventaris <code>{{ $list['show']->no_inventaris }}</code></footer></p>
                    <p class="card-title-desc"><footer class="blockquote-footer">Penghapusan <strong>HANYA</strong> dapat dilakukan pada hari yang sama</footer></p>
                    <table class="table dt-responsive table-hover nowrap w-100" id="dttable-pemeliharaan">
                        <thead>
                            <tr>
                                <th scope="col"><center>Aksi</center></th>
                                <th scope="col">Petugas</th>
                                <th scope="col">Hasil</th>
                                <th scope="col">Rekomendasi</th>
                                <th scope="col">Ditambahkan</th>
                            </tr>
                        </thead>
                        <tbody id="tampil-tbody-pemeliharaan"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL MUTASI --}}
    <div class="modal fade" id="formMutasi" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-simple modal-add-new-address modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        Formulir Mutasi Aset&nbsp;&nbsp;&nbsp;
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-5 mb-3">
                            <div class="form-group">
                                <label class="form-label">Lokasi Awal</label>
                                <input type="text" id="lokasi_awal" value="" class="form-control" placeholder="" disabled/>
                            </div>
                        </div>
                        <div class="col-md-5 mb-3">
                            <div class="form-group">
                                <label class="form-label">Lokasi Tujuan (<strong>Ruangan - Lokasi</strong>) <a class="text-danger">*</a></label>
                                <div class="select2-dark">
                                    <select class="select2 form-select" id="lokasi_tujuan" data-allow-clear="false" data-bs-auto-close="outside" style="width: 100%" data-bs-toggle="tooltip"
                                    data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="PERHATIAN!! Mutasi Sarana ke berbeda ruangan dapat mengubah NO INVENTARIS yang ada saat ini" required>
                                        <option value="">Pilih</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 mb-3">
                            <div class="form-group">
                                <label class="form-label">Kondisi <a class="text-danger">*</a></label>
                                <select class="form-select" id="kondisi_mutasi" required></select>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label class="form-label">Keterangan</label>
                                <textarea rows="3" id="ket_mutasi" class="form-control" placeholder="Optional"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 text-center mb-3">
                    <div class="btn-group">
                        <button class="btn btn-light-warning btn-rounded" onclick="refreshModalMutasi({{ $list['show']->id }})" data-bs-toggle="tooltip"
                        data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="Refresh Tabel Riwayat Mutasi"><i class="fa fa-sync"></i>&nbsp;&nbsp;Refresh</button>
                        <button type="reset" class="btn btn-light-secondary btn-rounded" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-times me-1" style="font-size:13px"></i>&nbsp;&nbsp;Tutup</button>
                        <button class="btn btn-light-primary btn-rounded" onclick="prosesMutasi({{ $list['show']->id }})" data-bs-toggle="tooltip"
                            data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="Proses Mutasi Sekarang" id="btn-mutasi-aktif"><i class="fas fa-luggage-cart"></i>&nbsp;&nbsp;Mutasi Aset</button>
                        <button class="btn btn-secondary btn-rounded" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true"
                            title="Aset Sedang Dalam peminjaman" id="btn-mutasi-nonaktif" disabled hidden><i class="fas fa-luggage-cart"></i>&nbsp;&nbsp;Mutasi Aset</button>
                    </div>
                </div>
                <hr>
                <div class="table-responsive text-nowrap mb-4" style="border: 0px;margin-left:20px;margin-right:20px">
                    <h4 class="card-title">Riwayat Mutasi <mark>{{ $list['show']->sarana }}</mark></h4>
                    <p class="card-title-desc"><footer class="blockquote-footer"><strong>No. Inventaris akan berubah mengikuti Ruangan yang dipilih saat ini</strong></footer></p>
                    <p class="card-title-desc"><footer class="blockquote-footer">Ruangan Sekarang : <kbd id="ruangan_sekarang_mutasi"></kbd> - <kbd id="lokasi_sekarang_mutasi"></kbd></footer></p>
                    <p class="card-title-desc"><footer class="blockquote-footer">Pembatalan mutasi <strong>HANYA</strong> dapat dilakukan pada hari yang sama</footer></p>
                    <p class="card-title-desc"><footer class="blockquote-footer">Mutasi <mark>lebih dari satu</mark> pada hari yang sama <strong>HANYA</strong> dapat dibatalkan secara berurutan</footer></p>
                    <p class="card-title-desc"><footer class="blockquote-footer">Aset <strong>TIDAK DAPAT</strong> dimutasi apabila sedang dalam peminjaman maupun sudah dilakukan penarikan</footer></p>
                    <table class="table dt-responsive table-hover nowrap w-100" id="dttable-mutasi">
                        <thead>
                            <tr>
                                <th scope="col"><center>Aksi</center></th>
                                <th scope="col">Tgl Mutasi</th>
                                <th scope="col">Awal/Lama</th>
                                <th scope="col">Tujuan/Baru</th>
                                <th scope="col">Keterangan</th>
                                <th scope="col">Kondisi</th>
                            </tr>
                        </thead>
                        <tbody id="tampil-tbody-mutasi"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL PEMINJAMAN --}}
    <div class="modal fade" id="formPeminjaman" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-simple modal-add-new-address modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        Formulir Peminjaman Aset <mark>{{ $list['show']->sarana }}</mark>
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="card-title-desc" style="margin-top: -18px"><footer class="blockquote-footer">No. Inventaris <code>{{ $list['show']->no_inventaris }}</code></footer></p>
                    <p class="card-title-desc"><footer class="blockquote-footer">Ruangan Sekarang : <kbd id="ruangan_sekarang_peminjaman"></kbd> - <kbd id="lokasi_sekarang_peminjaman"></kbd></footer></p>
                    <p class="card-title-desc"><footer class="blockquote-footer">Riwayat penarikan yang sudah ada akan terhapus dan kondisi akan tetap sama dengan yang sebelumnya</p></footer>
                    <hr>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <label class="form-label">Tgl. Peminjaman <a class="text-danger">*</a></label>
                                <input type="text" id="tgl_peminjaman" class="form-control flatpickr" placeholder="YYYY-MM-DD"/>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <label class="form-label">Tgl. Pengembalian</label>
                                <input type="text" id="tgl_pengembalian_pengembalian" class="form-control flatpickrtom" placeholder="YYYY-MM-DD"/>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <label class="form-label">Kondisi <a class="text-danger">*</a></label>
                                <select class="form-select" id="kondisi_peminjaman" required>
                                    <option value="" hidden>Pilih</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label class="form-label">Nama Penanggungjawab <a class="text-danger">*</a></label>
                                <div class="select2-dark">
                                    <select class="select2 form-select" id="pj_peminjaman" data-allow-clear="false" data-bs-auto-close="outside" style="width: 100%" required>
                                        <option value="">Pilih</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label class="form-label">Ruangan - Lokasi <a class="text-danger">*</a></label>
                                <div class="select2-dark">
                                    <select class="select2 form-select" id="lokasi_peminjaman" data-allow-clear="false" data-bs-auto-close="outside" style="width: 100%" data-bs-toggle="tooltip"
                                    data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="Pemilihan ruangan peminjaman tidak akan berpengaruh pada No.Inventaris" required>
                                        <option value="">Pilih</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label class="form-label">Kelengkapan Sarana <a class="text-danger">*</a></label>
                                <textarea rows="2" id="kelengkapan_peminjaman" class="form-control" placeholder="Wajib Diisi"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label class="form-label">Keterangan</label>
                                <textarea rows="2" id="ket_peminjaman" class="form-control" placeholder="Optional"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 text-center mb-4">
                    <button class="btn btn-primary me-sm-3 me-1" id="btn-peminjaman" onclick="prosesPeminjaman()"><i class="fas fa-qrcode"></i>&nbsp;&nbsp;Ajukan</button>
                    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-times me-1" style="font-size:13px"></i>&nbsp;&nbsp;Tutup</button>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL PENGEMBALIAN --}}
    <div class="modal fade" id="formPengembalian" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-simple modal-add-new-address modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        Formulir Pengembalian Aset <mark>{{ $list['show']->sarana }}</mark>
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="card-title-desc" style="margin-top: -18px"><footer class="blockquote-footer">No. Inventaris <code>{{ $list['show']->no_inventaris }}</code></footer></p>
                    <p class="card-title-desc"><footer class="blockquote-footer">Ruangan Sekarang : <kbd id="ruangan_sekarang_pengembalian"></kbd> - <kbd id="lokasi_sekarang_pengembalian"></kbd></footer></p>
                    <p class="card-title-desc"><footer class="blockquote-footer">Aset akan dikembalikan ke Gudang Aset setelah proses pengembalian</p>
                    <hr>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label class="form-label">Kelengkapan Sarana</label>
                                <textarea rows="2" id="kelengkapan_pengembalian" class="form-control" placeholder="" disabled></textarea>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label class="form-label">Keterangan</label>
                                <textarea rows="2" id="ket_pengembalian" class="form-control" placeholder="" disabled></textarea>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label class="form-label">Tgl. Pengembalian <a class="text-danger">*</a></label>
                                <input type="text" id="tgl_pengembalian" class="form-control flatpickr" placeholder="YYYY-MM-DD"/>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label class="form-label">Kondisi <a class="text-danger">*</a></label>
                                <select class="form-select" id="kondisi_pengembalian" required>
                                    <option value="" hidden>Pilih</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label class="form-label">Nama Pengantar Barang <a class="text-danger">*</a></label>
                                <div class="select2-dark">
                                    <select class="select2 form-select" id="pengantar_pengembalian" data-allow-clear="false" data-bs-auto-close="outside" style="width: 100%" required>
                                        <option value="">Pilih</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label class="form-label">Nama Penerima Barang <a class="text-danger">*</a></label>
                                <div class="select2-dark">
                                    <select class="select2 form-select" id="penerima_pengembalian" data-allow-clear="false" data-bs-auto-close="outside" style="width: 100%" required>
                                        <option value="">Pilih</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label class="form-label">Catatan Pengembalian</label>
                                <textarea rows="2" id="catatan_pengembalian" class="form-control" placeholder="Optional"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 text-center mb-4">
                    <button class="btn btn-primary me-sm-3 me-1" id="btn-pengembalian" onclick="prosesPengembalian()"><i class="fas fa-qrcode"></i>&nbsp;&nbsp;Ajukan Pengembalian</button>
                    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-times me-1" style="font-size:13px"></i>&nbsp;&nbsp;Tutup</button>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL PENARIKAN --}}
    <div class="modal fade" id="formPenarikan" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-simple modal-add-new-address modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        Formulir Penarikan Aset <mark>{{ $list['show']->sarana }}</mark>
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="card-title-desc" style="margin-top: -18px"><footer class="blockquote-footer">No. Inventaris <code>{{ $list['show']->no_inventaris }}</code></footer></p>
                    <p class="card-title-desc"><footer class="blockquote-footer">Ruangan Sekarang : <kbd id="ruangan_sekarang_penarikan"></kbd> - <kbd id="lokasi_sekarang_penarikan"></kbd></footer></p>
                    <p class="card-title-desc"><footer class="blockquote-footer">Jika <mark>dimusnahkan</mark>, Aset akan dikunci oleh sistem</footer></p>
                    <hr>
                    <div class="row">
                        <input type="number" class="form-control" id="validasi_ruangan_penarikan" hidden>
                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label class="form-label">Alasan Penarikan <a class="text-danger">*</a></label>
                                <textarea rows="2" id="alasan_penarikan" class="form-control" placeholder="Wajib diisi..."></textarea>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label class="form-label">Kondisi <a class="text-danger">*</a></label>
                                <select class="form-select" id="kondisi_penarikan" required>
                                    <option value="" hidden>Pilih</option>
                                    <option value="1">Baik</option>
                                    <option value="2">Cukup</option>
                                    <option value="3">Buruk</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label class="form-label">Status <a class="text-danger">*</a></label>
                                <select class="form-select" id="status_penarikan" required>
                                    <option value="" hidden>Pilih</option>
                                    <option value="2">Dikembalikan ke Gudang Aset</option>
                                    <option value="3">Dimusnahkan</option>
                                </select>
                            </div>
                        </div>
                        {{-- <hr>
                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label class="form-label">Upload Dokumen (Optional)</label>
                                <input type="file" class="form-control mb-2" id="file_add" disabled>
                                <i class="fa-fw fas fa-caret-right nav-icon"></i> Batas ukuran maksimum setiap File Gambar adalah <strong>5 mb</strong>
                            </div>
                        </div> --}}
                    </div>
                </div>
                <div class="col-12 text-center mb-4">
                    <button class="btn btn-primary me-sm-3 me-1" id="btn-penarikan" onclick="prosesPenarikan()"><i class="fa fa-people-carry"></i>&nbsp;&nbsp;Ajukan Penarikan</button>
                    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-times me-1" style="font-size:13px"></i>&nbsp;&nbsp;Tutup</button>
                </div>
            </div>
        </div>
    </div>

    {{-- UPDATE KONDISI --}}
    <div class="modal fade" id="kondisi" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        Bagaimana Kondisi Sarana Sekarang?
                    </h4>
                    <button type="button" class="btn-close" onclick="closeModal()" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <input type="text" class="form-control" id="id_kondisi" hidden>
                    <label for="" class ="form-label">Pilih Kondisi</label>
                    <select class="form-select" id="pilihan_kondisi" required></select>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" id="btn-simpan-kondisi" onclick="updateKondisi()"><i
                            class="fa-fw fas fa-save nav-icon"></i> Simpan</button>
                    <button type="button" class="btn btn-secondary" onclick="closeModal()" aria-label="Close"><i class="fa-fw fas fa-times nav-icon"></i> Batal</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            if ("{{ $list['show']->nilai_perolehan }}" != '') {
                $('#show_nilai_perolehan').text(formatRupiah("{{ $list['show']->nilai_perolehan }}",'Rp. '));
            } else {
                $('#show_nilai_perolehan').text(formatRupiah("0",'Rp. '));
            }

            // PENENTUAN MENU AKSES
            var aksesAdmin = "{{ Auth::user()->getPermission('admin_aset') }}";
            var aksesElektromedis = "{{ Auth::user()->getPermission('admin_aset_elektromedis') }}";
            var aksesPIC = "{{ Auth::user()->getPermission('admin_aset_pic') }}";
            var aksesIPSRS = "{{ Auth::user()->getPermission('admin_aset_ipsrs') }}";
            var aksesIT = "{{ Auth::user()->getPermission('admin_aset_it') }}";
            // console.log(aksesAdmin+' - '+aksesElektromedis+' - '+aksesIPSRS+' - '+aksesPIC);
            // VALIDASI AKSES
            if (aksesAdmin == true) { // ALL ACCESS
                $(".tombol-menu").prop('hidden', false);
                $(".menu-pemeliharaan").prop('hidden', false);
                $(".menu-mutasi").prop('hidden', false);
                $(".menu-peminjaman").prop('hidden', false);
                $(".menu-pengembalian").prop('hidden', false);
                $(".menu-penarikan").prop('hidden', false);
            } else {
                if (aksesElektromedis == true) {
                    $(".tombol-menu").prop('hidden', false);
                    $(".menu-pemeliharaan").prop('hidden', false);
                    $(".menu-mutasi").prop('hidden', true);
                    $(".menu-peminjaman").prop('hidden', false);
                    $(".menu-pengembalian").prop('hidden', false);
                    $(".menu-penarikan").prop('hidden', false);
                } else {
                    if (aksesPIC == true) {
                        $(".tombol-menu").prop('hidden', false);
                        $(".menu-pemeliharaan").prop('hidden', true);
                        $(".menu-mutasi").prop('hidden', true);
                        $(".menu-peminjaman").prop('hidden', false);
                        $(".menu-pengembalian").prop('hidden', false);
                        $(".menu-penarikan").prop('hidden', true);
                    } else {
                        if (aksesIPSRS == true) {
                            $(".tombol-menu").prop('hidden', false);
                            $(".menu-pemeliharaan").prop('hidden', false);
                            $(".menu-mutasi").prop('hidden', true);
                            $(".menu-peminjaman").prop('hidden', true);
                            $(".menu-pengembalian").prop('hidden', true);
                            $(".menu-penarikan").prop('hidden', true);
                        } else {
                            if (aksesIT == true) {
                                $(".tombol-menu").prop('hidden', false);
                                $(".menu-pemeliharaan").prop('hidden', false);
                                $(".menu-mutasi").prop('hidden', true);
                                $(".menu-peminjaman").prop('hidden', true);
                                $(".menu-pengembalian").prop('hidden', true);
                                $(".menu-penarikan").prop('hidden', true);
                            } else {
                                $(".tombol-menu").prop('hidden', true);
                                $(".menu-pemeliharaan").prop('hidden', true);
                                $(".menu-mutasi").prop('hidden', true);
                                $(".menu-peminjaman").prop('hidden', true);
                                $(".menu-pengembalian").prop('hidden', true);
                                $(".menu-penarikan").prop('hidden', true);
                            }
                        }
                    }
                }
            }


            // SELECT2
            var te = $(".select2");
            te.length && te.each(function() {
                var es = $(this);
                es.wrap('<div class="position-relative"></div>').select2({
                    placeholder: "Pilih",
                    dropdownParent: es.parent()
                })
            });

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
            // const dates = new Date(Date.now());
            // const tomorow = dates.getTime();
            const m = new Date(Date.now());
            // const c = new Date(Date.now() + 1728e5); // 3 hari kedepan
            var now = moment().locale('id').format('YYYY-MM-DD HH:mm');
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

            $('#qr').text('') ;
            var qrcode = new QRCode("qr", {
                text: "{{ $list['qr'] }}",
                width: 300,
                height: 300,
                colorDark : "#000000",
                colorLight : "#ffffff",
                correctLevel : QRCode.CorrectLevel.H
            });
            $("img").on("contextmenu",function(){
                return false;
            });
            fresh();
        })

        // SHOWING MODAL -----------------------------------------------------------------------------------------------------------------------
        function showUpdateKondisi(kondisi) {
            $('#kondisi').modal('show');
            $("#id_kondisi").val({{ $list['show']->id }});
            $("#pilihan_kondisi").find('option').remove();
            $("#pilihan_kondisi").append(`
                <option value="1" ${kondisi == '1' ? "selected":""}>Baik</option>
                <option value="2" ${kondisi == '2' ? "selected":""}>Cukup</option>
                <option value="3" ${kondisi == '3' ? "selected":""}>Buruk</option>
            `);
        }

        // PEMELIHARAAN
        function modalPemeliharaan(aset) {
            $.ajax({
                url: "/api/inventaris/aset/pemeliharaan/"+aset,
                type: 'GET',
                dataType: 'json', // added data type
                success: function(res){
                    if (res.penarikan != null) {
                        if (res.penarikan.status == 3) {
                            iziToast.error({
                                title: 'Pesan Galat!',
                                message: 'Aset telah <i>DIMUSNAHKAN</i>. Silakan melakukan pembatalan penarikan aset apabila diperlukan',
                                position: 'topRight'
                            });
                        } else {
                            if (res.penarikan.status == 2) {
                                iziToast.warning({
                                    title: 'Pesan Ambigu!',
                                    message: 'Aset telah <i>DIKEMBALIKAN KE GUDANG</i>. Silakan melakukan pembatalan penarikan aset apabila diperlukan',
                                    position: 'topRight'
                                });
                            }
                        }
                    } else {
                        // TAMPIL USERS DROPDOWN
                        $("#petugas_pemeliharaan").find('option').remove();
                        $("#petugas_pemeliharaan").append(`<option value="" hidden>Pilih</option>`);
                        res.users.forEach(item => {
                            $("#petugas_pemeliharaan").append(`
                                <option value="${item.id}">${item.nama}</option>
                            `);
                        });

                        // TAMPIL TABEL PEMELIHARAAN
                        var adminID = "{{ Auth::user()->getPermission('admin_aset') }}";
                        $("#tampil-tbody-pemeliharaan").empty();
                        $('#dttable-pemeliharaan').DataTable().clear().destroy();
                        var date = new Date().toLocaleDateString();
                        res.show.forEach(item => {
                            var updet = new Date(item.created_at).toLocaleDateString();
                            content = `<tr id='`+item.id+`'>`;
                                if (adminID == true) {
                                    content += `<td><center><a href='javascript:void(0);' class='btn btn-light-danger btn-sm' onclick="hapusPemeliharaan(${item.id})"><i class='bx bx-trash scaleX-n1-rtl'></i> Hapus</a></center></td>`;
                                } else {
                                    if (updet == date) {
                                        content += `<td><center><a href='javascript:void(0);' class='btn btn-light-danger btn-sm' onclick="hapusPemeliharaan(${item.id})"><i class='bx bx-trash scaleX-n1-rtl'></i> Hapus</a></center></td>`;
                                    } else {
                                        content += `<td><center><a href='javascript:void(0);' class='btn btn-light-secondary btn-sm'><i class='bx bx-trash scaleX-n1-rtl'></i> Hapus</a></center></td>`;
                                    }
                                }
                                content += `<td style='white-space: normal !important;word-wrap: break-word;'>${item.nama_petugas}</td>`;
                                content += `<td style='white-space: normal !important;word-wrap: break-word;'>${item.hasil}</td>`;
                                content += `<td style='white-space: normal !important;word-wrap: break-word;'>${item.rekomendasi}</td>`;
                                content += `<td>${new Date(item.created_at).toLocaleString('sv-SE')}</td>`;
                            content += `</tr>`;
                            $('#tampil-tbody-pemeliharaan').append(content);
                        })
                        var table = $('#dttable-pemeliharaan').DataTable({
                            order: [
                                [4, "desc"]
                            ],
                            bAutoWidth: false,
                            aoColumns : [
                                { sWidth: '10%' },
                                { sWidth: '15%' },
                                { sWidth: '30%' },
                                { sWidth: '30%' },
                                { sWidth: '15%' },
                            ],
                            displayLength: 7,
                            lengthChange: true,
                            lengthMenu: [7, 10, 25, 50, 75, 100],
                            buttons: ['excel', 'pdf']
                        });
                        table.buttons().container().appendTo('#dttable-pemeliharaan_wrapper .col-md-6:eq(0)');
                        $('[data-bs-toggle="tooltip"]').tooltip({
                            trigger: 'hover'
                        })

                        $('#formPemeliharaan').modal('show');
                    }
                },
                error: function(res){
                    console.log("error : " + JSON.stringify(res) );
                    iziToast.error({
                        title: 'Pesan Galat!',
                        message: res.responseJSON.error,
                        position: 'topRight'
                    });
                }
            });
        }

        function prosesPemeliharaan() {
            $("#btn-simpan-pemeliharaan").prop('disabled', true);
            $("#btn-simpan-pemeliharaan").find("i").toggleClass("fa-wrench fa-sync fa-spin");

            var petugas = $("#petugas_pemeliharaan").val();
            var hasil = $("#hasil_pemeliharaan").val();
            var rekomendasi = $("#rekomendasi_pemeliharaan").val();

            if (petugas == "" || hasil == "" || rekomendasi == "") {
                iziToast.warning({
                    title: 'Pesan Ambigu!',
                    message: 'Pastikan Anda tidak mengosongi semua isian wajib (<a class="text-danger">*</a>)',
                    position: 'topRight'
                });
                $("#btn-simpan-pemeliharaan").find("i").removeClass("fa-sync fa-spin").addClass("fa-wrench");
                $("#btn-simpan-pemeliharaan").prop('disabled', false);
            } else {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: 'POST',
                    url: '/api/inventaris/aset/pemeliharaan/store',
                    dataType: 'json',
                    data: {
                        user: "{{ Auth::user()->id }}",
                        petugas: petugas,
                        hasil: hasil,
                        rekomendasi: rekomendasi,
                        aset: "{{ $list['show']->id }}",
                    },
                    success: function(res) {
                        iziToast.success({
                            title: 'Sukses!',
                            message: 'Submit Pemeliharaan berhasil pada '+ res,
                            position: 'topRight'
                        });
                        if (res) {
                            refreshModalPemeliharaan();
                            fresh();
                            $("#btn-simpan-pemeliharaan").find("i").removeClass("fa-sync fa-spin").addClass("fa-wrench");
                            $("#btn-simpan-pemeliharaan").prop('disabled', false);
                        }
                    },
                    error: function (res) {
                        console.log("error : " + JSON.stringify(res) );
                        iziToast.error({
                            title: 'Pesan Galat!',
                            message: res.responseJSON.error,
                            position: 'topRight'
                        });
                        $("#btn-simpan-pemeliharaan").find("i").removeClass("fa-sync fa-spin").addClass("fa-wrench");
                        $("#btn-simpan-pemeliharaan").prop('disabled', false);
                    }
                });
            }
        }

        function hapusPemeliharaan(id) {
            Swal.fire({
                target: document.getElementById('formPemeliharaan'),
                title: 'Apakah anda yakin?',
                text: 'Hapus Pemeliharaan ID : '+id,
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
                        url: "/api/inventaris/aset/pemeliharaan/destroy/" + id,
                        type: 'GET',
                        dataType: 'json', // added data type
                        success: function(res) {
                            iziToast.success({
                                title: 'Sukses!',
                                message: 'Hapus Pemeliharaan berhasil pada ' + res,
                                position: 'topRight'
                            });
                            refreshModalPemeliharaan();
                            fresh();
                        },
                        error: function(res) {
                            console.log("error : " + JSON.stringify(res) );
                            iziToast.error({
                                title: 'Pesan Galat!',
                                message: res.responseJSON.error,
                                position: 'topRight'
                            });
                        }
                    });
                }
            })
        }

        // MUTASI
        function modalMutasi(aset) {
            $.ajax({
                url: "/api/inventaris/aset/mutasi/"+aset,
                type: 'GET',
                dataType: 'json', // added data type
                success: function(res){
                    if (res.penarikan != null) {
                        if (res.penarikan.status == 3) {
                            iziToast.error({
                                title: 'Pesan Galat!',
                                message: 'Aset telah <i>DIMUSNAHKAN</i>. Silakan melakukan pembatalan penarikan aset apabila diperlukan',
                                position: 'topRight'
                            });
                        } else {
                            if (res.penarikan.status == 2) {
                                iziToast.warning({
                                    title: 'Pesan Ambigu!',
                                    message: 'Aset telah <i>DIKEMBALIKAN KE GUDANG</i>. Silakan melakukan pembatalan penarikan aset apabila diperlukan',
                                    position: 'topRight'
                                });
                            }
                        }
                    } else {
                        // DEFINISI
                        $("#lokasi_awal").val(res.aset.ruangan);
                        $("#ruangan_sekarang_mutasi").text(res.aset.ruangan);
                        $("#lokasi_sekarang_mutasi").text(res.aset.lokasi);
                        $("#kondisi_mutasi").find('option').remove();
                        $("#kondisi_mutasi").append(`
                            <option value="1" ${res.aset.kondisi == '1' ? "selected":""}>Baik</option>
                            <option value="2" ${res.aset.kondisi == '2' ? "selected":""}>Cukup</option>
                            <option value="3" ${res.aset.kondisi == '3' ? "selected":""}>Buruk</option>
                        `);

                        $("#lokasi_tujuan").find('option').remove();
                        res.ruangan.forEach(item => {
                            $("#lokasi_tujuan").append(`<option value="" hidden>Pilih</option>`);
                            $("#lokasi_tujuan").append(`
                                <option value="${item.id}" ${res.aset.id_ruangan == item.id ? "selected":""}>${item.ruangan} - ${item.lokasi}</option>
                            `);
                        });

                        if (res.peminjaman != null) {
                            if (res.peminjaman.status == 1) {
                                $("#btn-mutasi-aktif").prop('hidden', true);
                                $("#btn-mutasi-nonaktif").prop('hidden', false);
                            } else {
                                $("#btn-mutasi-aktif").prop('hidden', false);
                                $("#btn-mutasi-nonaktif").prop('hidden', true);
                            }
                        }

                        // TABEL
                        var adminID = "{{ Auth::user()->getPermission('admin_aset') }}";
                        $("#tampil-tbody-mutasi").empty();
                        $('#dttable-mutasi').DataTable().clear().destroy();
                        var date = new Date().toLocaleDateString();
                        res.show.forEach(item => {
                            var updet = new Date(item.created_at).toLocaleDateString();
                            content = `<tr id='`+item.id+`'>`;
                                if (adminID == true) {
                                    content += `<td><center><div class='btn-group'>
                                        <a href='javascript:void(0);' class='btn btn-light-danger btn-sm' onclick="batalMutasi(${item.id})"><i class='bx bx-trash scaleX-n1-rtl'></i> Batal</a>
                                        </div></center></td>`;
                                } else {
                                    if (updet == date) {
                                        if (res.peminjaman != null) {
                                            if (res.peminjaman.status == 1) {
                                                content += `<td><center><div class='btn-group'>
                                                    <a href='javascript:void(0);' class='btn btn-light-secondary btn-sm'><i class='bx bx-trash scaleX-n1-rtl'></i> Batal</a>
                                                    </div></center></td>`;
                                            } else {
                                                content += `<td><center><div class='btn-group'>
                                                    <a href='javascript:void(0);' class='btn btn-light-danger btn-sm' onclick="batalMutasi(${item.id})"><i class='bx bx-trash scaleX-n1-rtl'></i> Batal</a>
                                                    </div></center></td>`;
                                            }
                                        } else {
                                            content += `<td><center><div class='btn-group'>
                                                <a href='javascript:void(0);' class='btn btn-light-secondary btn-sm'><i class='bx bx-trash scaleX-n1-rtl'></i> Batal</a>
                                                </div></center></td>`;
                                        }
                                    } else {
                                        content += `<td><center><div class='btn-group'>
                                            <a href='javascript:void(0);' class='btn btn-light-secondary btn-sm'><i class='bx bx-trash scaleX-n1-rtl'></i> Batal</a>
                                            </div></center></td>`;
                                    }
                                }
                                content += `<td>${new Date(item.created_at).toLocaleString('sv-SE')}</td>`;
                                content += `<td style='white-space: normal !important;word-wrap: break-word;'><div class='d-flex justify-content-start align-items-center'><div class='d-flex flex-column'><h6 class='mb-0'>${item.ruangan_awal_aset}</h6><small class='text-truncate text-muted'>${item.lokasi_awal_aset}</small></div></div></td>`;
                                content += `<td style='white-space: normal !important;word-wrap: break-word;'><div class='d-flex justify-content-start align-items-center'><div class='d-flex flex-column'><h6 class='mb-0'>${item.ruangan_tujuan_aset}</h6><small class='text-truncate text-muted'>${item.lokasi_tujuan_aset}</small></div></div></td>`;
                                content += `<td style='white-space: normal !important;word-wrap: break-word;'>${item.ket?item.ket:''}</td>`;
                                if (item.kondisi == 1) {
                                    content += `<td><kbd class='text-dark' style='background-color:#eaf9f4'>Baik</kbd></td>`;
                                } else {
                                    if (item.kondisi == 2) {
                                        content += `<td><kbd class='text-dark' style='background-color:#fef7ed'>Cukup</kbd></td>`;
                                    } else {
                                        if (item.kondisi == 3) {
                                            content += `<td><kbd class='text-dark' style='background-color:#fef0f0'>Buruk</kbd></td>`;
                                        }
                                    }
                                }
                            content += `</tr>`;
                            $('#tampil-tbody-mutasi').append(content);
                        })
                        var table = $('#dttable-mutasi').DataTable({
                            order: [
                                [1, "desc"]
                            ],
                            bAutoWidth: false,
                            aoColumns : [
                                { sWidth: '10%' },
                                { sWidth: '15%' },
                                { sWidth: '20%' },
                                { sWidth: '20%' },
                                { sWidth: '25%' },
                                { sWidth: '10%' },
                            ],
                            displayLength: 7,
                            lengthChange: true,
                            lengthMenu: [7, 10, 25, 50, 75, 100],
                            buttons: ['excel', 'pdf']
                        });
                        table.buttons().container().appendTo('#dttable-mutasi_wrapper .col-md-6:eq(0)');
                        $('[data-bs-toggle="tooltip"]').tooltip({
                            trigger: 'hover'
                        })

                        $('#formMutasi').modal('show');
                    }
                },
                error: function(res){
                    console.log("error : " + JSON.stringify(res) );
                    iziToast.error({
                        title: 'Pesan Galat!',
                        message: res.responseJSON.error,
                        position: 'topRight'
                    });
                }
            });
        }

        function prosesMutasi() {
            $("#btn-mutasi-aktif").prop('disabled', true);
            $("#btn-mutasi-aktif").find("i").toggleClass("fa-luggage-cart fa-sync fa-spin");
            var lokasi_tujuan = $("#lokasi_tujuan").val();
            var kondisi = $("#kondisi_mutasi").val();
            var ket = $("#ket_mutasi").val();

            if (lokasi_tujuan == "" || kondisi == "") {
                iziToast.warning({
                    title: 'Pesan Ambigu!',
                    message: 'Pastikan Anda tidak mengosongi semua isian wajib (<a class="text-danger">*</a>)',
                    position: 'topRight'
                });
                $("#btn-mutasi-aktif").find("i").removeClass("fa-sync fa-spin").addClass("fa-luggage-cart");
                $("#btn-mutasi-aktif").prop('disabled', false);
            } else {
                if (lokasi_tujuan == "{{ $list['show']->id_ruangan }}") {
                    iziToast.warning({
                        title: 'Pesan Ambigu!',
                        message: 'Pastikan Anda memilih ruangan tujuan mutasi dengan benar / tidak sama dengan ruangan awal',
                        position: 'topRight'
                    });
                    $("#btn-mutasi-aktif").find("i").removeClass("fa-sync fa-spin").addClass("fa-luggage-cart");
                    $("#btn-mutasi-aktif").prop('disabled', false);
                } else {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        method: 'POST',
                        url: '/api/inventaris/aset/mutasi/store',
                        dataType: 'json',
                        data: {
                            user: "{{ Auth::user()->id }}",
                            lokasi_tujuan: lokasi_tujuan,
                            kondisi: kondisi,
                            ket: ket,
                            aset: "{{ $list['show']->id }}",
                        },
                        success: function(res) {
                            iziToast.success({
                                title: 'Sukses!',
                                message: 'Mutasi Aset berhasil pada '+ res,
                                position: 'topRight'
                            });
                            $("#show_no_inventaris").text('<span class="placeholder col-12"></span>');
                            refreshModalMutasi("{{ $list['show']->id }}");
                            // $("#show_no_inventaris").html(`<a onclick="window.location.href = '{{ URL::to('inventaris/aset') }}'"><span class="placeholder col-2 bg-dark" width="10%" data-bs-toggle="tooltip"
                            // data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="Klik disini untuk melihat perubahan No.Inventaris"></span></a>`);
                            fresh();
                            $("#btn-mutasi-aktif").find("i").removeClass("fa-sync fa-spin").addClass("fa-luggage-cart");
                            $("#btn-mutasi-aktif").prop('disabled', false);
                        },
                        error: function (res) {
                            console.log("error : " + JSON.stringify(res) );
                            iziToast.error({
                                title: 'Pesan Galat!',
                                message: res.responseJSON.error,
                                position: 'topRight'
                            });
                            $("#btn-mutasi-aktif").find("i").removeClass("fa-sync fa-spin").addClass("fa-luggage-cart");
                            $("#btn-mutasi-aktif").prop('disabled', false);
                        }
                    });
                }
            }
        }

        function batalMutasi(id) {
            $.ajax({
                url: "/api/inventaris/aset/mutasi/destroy/cariaset/{{ $list['show']->id }}",
                type: 'GET',
                dataType: 'json', // added data type
                success: function(res) {
                    if (res.id != id) {
                        iziToast.error({
                            title: 'Pesan Galat!',
                            message: 'Lakukan pembatalan secara berurutan!',
                            position: 'topRight'
                        });
                    } else {
                        Swal.fire({
                            target: document.getElementById('formMutasi'),
                            title: 'Batal Mutasi Aset ID : '+id+' ?',
                            text: 'Ruangan dan Kondisi aset sekarang akan dikembalikan seperti keadaan semula',
                            icon: 'warning',
                            reverseButtons: false,
                            showDenyButton: false,
                            showCloseButton: false,
                            showCancelButton: true,
                            focusCancel: true,
                            confirmButtonColor: '#FF4845',
                            confirmButtonText: `<i class="fa fa-history"></i> Batalkan Mutasi`,
                            cancelButtonText: `<i class="fa fa-times me-1" style="font-size:13px"></i> Tutup`,
                            backdrop: `rgba(26,27,41,0.8)`,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    url: "/api/inventaris/aset/mutasi/destroy/" + id,
                                    type: 'GET',
                                    dataType: 'json', // added data type
                                    success: function(res) {
                                        iziToast.success({
                                            title: 'Sukses!',
                                            message: 'Pembatalan mutasi aset berhasil pada ' + res,
                                            position: 'topRight'
                                        });
                                        refreshModalMutasi("{{ $list['show']->id }}");
                                        // $("#show_no_inventaris").html(`<a onclick="window.location.href = '{{ URL::to('inventaris/aset') }}'"><span class="placeholder col-2 bg-dark" width="10%" data-bs-toggle="tooltip"
                                        // data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="Klik disini untuk melihat perubahan No.Inventaris"></span></a>`);
                                        // window.location.reload();
                                        fresh();
                                    },
                                    error: function(res) {
                                        console.log("error : " + JSON.stringify(res) );
                                        iziToast.error({
                                            title: 'Pesan Galat!',
                                            message: res.responseJSON.error,
                                            position: 'topRight'
                                        });
                                    }
                                });
                            }
                        })
                    }
                },
                error: function(res) {
                    console.log("error : " + JSON.stringify(res) );
                    iziToast.error({
                        title: 'Pesan Galat!',
                        message: res.responseJSON.error,
                        position: 'topRight'
                    });
                }
            });
        }

        // PEMINJAMAN
        function modalPeminjaman(aset) {
            $.ajax({
                url: "/api/inventaris/aset/peminjaman/"+aset,
                type: 'GET',
                dataType: 'json', // added data type
                success: function(res){
                    if (res.penarikan != null) {
                        if (res.penarikan.status == 3) {
                            iziToast.error({
                                title: 'Pesan Galat!',
                                message: 'Aset telah <i>DIMUSNAHKAN</i>. Silakan melakukan pembatalan penarikan aset apabila diperlukan',
                                position: 'topRight'
                            });
                        } else {
                            if (res.penarikan.status == 2) {
                                iziToast.warning({
                                    title: 'Pesan Ambigu!',
                                    message: 'Aset telah <i>DIKEMBALIKAN KE GUDANG</i>. Silakan melakukan pembatalan penarikan aset apabila diperlukan',
                                    position: 'topRight'
                                });
                            }
                        }
                    } else {
                        if (res.peminjaman != null) {
                            iziToast.error({
                                title: 'Pesan Galat!',
                                message: 'Aset sedang dalam <i>PEMINJAMAN</i>. Silakan melakukan pengembalian aset apabila diperlukan',
                                position: 'topRight'
                            });
                        } else {
                            // DEFINISI
                            $('#ruangan_sekarang_peminjaman').text(res.show.ruangan);
                            $('#lokasi_sekarang_peminjaman').text(res.show.lokasi);
                            $("#kondisi_peminjaman").find('option').remove();
                            $("#kondisi_peminjaman").append(`
                                <option value="1" ${res.show.kondisi == '1' ? "selected":""}>Baik</option>
                                <option value="2" ${res.show.kondisi == '2' ? "selected":""}>Cukup</option>
                                <option value="3" ${res.show.kondisi == '3' ? "selected":""}>Buruk</option>
                            `);
                            $("#pj_peminjaman").find('option').remove();
                            $("#pj_peminjaman").append(`<option value="" hidden>Pilih</option>`);
                            res.users.forEach(item => {
                                $("#pj_peminjaman").append(`
                                    <option value="${item.id}">${item.nama}</option>
                                `);
                            });
                            $("#lokasi_peminjaman").find('option').remove();
                            $("#lokasi_peminjaman").append(`<option value="" hidden>Pilih</option>`);
                            res.ruangan.forEach(item => {
                                $("#lokasi_peminjaman").append(`
                                    <option value="${item.id}" ${res.show.id_ruangan == item.id ? "selected":""}>${item.ruangan} - ${item.lokasi}</option>
                                `);
                            });

                            $('#formPeminjaman').modal('show');
                        }
                    }
                },
                error: function(res){
                    console.log("error : " + JSON.stringify(res) );
                    iziToast.error({
                        title: 'Pesan Galat!',
                        message: res.responseJSON.error,
                        position: 'topRight'
                    });
                }
            });
        }

        function prosesPeminjaman() {
            $("#btn-peminjaman").prop('disabled', true);
            $("#btn-peminjaman").find("i").toggleClass("fa-qrcode fa-sync fa-spin");

            var tgl_peminjaman = $("#tgl_peminjaman").val();
            var tgl_pengembalian = $("#tgl_pengembalian_pengembalian").val();
            var kondisi = $("#kondisi_peminjamann").val();
            var pj = $("#pj_peminjaman").val();
            var lokasi = $("#lokasi_peminjaman").val();
            var kelengkapan = $("#kelengkapan_peminjaman").val();
            var ket = $("#ket_peminjaman").val();

            if (tgl_peminjaman == "" || kondisi == "" || pj == "" || lokasi == "" || kelengkapan == "") {
                iziToast.warning({
                    title: 'Pesan Ambigu!',
                    message: 'Pastikan Anda tidak mengosongi semua isian wajib (<a class="text-danger">*</a>)',
                    position: 'topRight'
                });
                $("#btn-peminjaman").find("i").removeClass("fa-sync fa-spin").addClass("fa-qrcode");
                $("#btn-peminjaman").prop('disabled', false);
            } else {
                if (lokasi == "{{ $list['show']->id_ruangan }}") {
                    iziToast.warning({
                        title: 'Pesan Ambigu!',
                        message: 'Pastikan Anda memilih ruangan tujuan Peminjaman dengan benar / tidak sama dengan ruangan awal. Silakan refresh browser apabila pernyataan ini tidak benar.',
                        position: 'topRight'
                    });
                    $("#btn-peminjaman").find("i").removeClass("fa-sync fa-spin").addClass("fa-qrcode");
                    $("#btn-peminjaman").prop('disabled', false);
                } else {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        method: 'POST',
                        url: '/api/inventaris/aset/peminjaman/store',
                        dataType: 'json',
                        data: {
                            user: "{{ Auth::user()->id }}",
                            tgl_peminjaman: tgl_peminjaman,
                            tgl_pengembalian: tgl_pengembalian,
                            kondisi: kondisi,
                            pj: pj,
                            lokasi: lokasi,
                            kelengkapan: kelengkapan,
                            ket: ket,
                            aset: "{{ $list['show']->id }}",
                        },
                        success: function(res) {
                            iziToast.success({
                                title: 'Sukses!',
                                message: 'Peminjaman Aset berhasil pada '+ res,
                                position: 'topRight'
                            });
                            // refreshModalPeminjaman("{{ $list['show']->id }}");
                            $('#formPeminjaman').modal('hide');
                            fresh();
                            $("#btn-peminjaman").find("i").removeClass("fa-sync fa-spin").addClass("fa-qrcode");
                            $("#btn-peminjaman").prop('disabled', false);
                        },
                        error: function (res) {
                            console.log("error : " + JSON.stringify(res) );
                            iziToast.error({
                                title: 'Pesan Galat!',
                                message: res.responseJSON.error,
                                position: 'topRight'
                            });
                            $("#btn-peminjaman").find("i").removeClass("fa-sync fa-spin").addClass("fa-qrcode");
                            $("#btn-peminjaman").prop('disabled', false);
                        }
                    });
                }
            }
        }

        // function batalPeminjaman(id) {
        //     $.ajax({
        //         url: "/api/inventaris/aset/mutasi/destroy/cariaset/{{ $list['show']->id }}",
        //         type: 'GET',
        //         dataType: 'json', // added data type
        //         success: function(res) {
        //             if (res.id != id) {
        //                 iziToast.error({
        //                     title: 'Pesan Galat!',
        //                     message: 'Lakukan pembatalan secara berurutan!',
        //                     position: 'topRight'
        //                 });
        //             } else {
        //                 Swal.fire({
        //                     title: 'Batal Mutasi Aset ID : '+id+' ?',
        //                     text: 'Ruangan dan Kondisi aset sekarang akan dikembalikan seperti keadaan semula',
        //                     icon: 'warning',
        //                     reverseButtons: false,
        //                     showDenyButton: false,
        //                     showCloseButton: false,
        //                     showCancelButton: true,
        //                     focusCancel: true,
        //                     confirmButtonColor: '#FF4845',
        //                     confirmButtonText: `<i class="fa fa-history"></i> Batalkan Mutasi`,
        //                     cancelButtonText: `<i class="fa fa-times me-1" style="font-size:13px"></i> Tutup`,
        //                     backdrop: `rgba(26,27,41,0.8)`,
        //                 }).then((result) => {
        //                     if (result.isConfirmed) {
        //                         $.ajax({
        //                             url: "/api/inventaris/aset/mutasi/destroy/" + id,
        //                             type: 'GET',
        //                             dataType: 'json', // added data type
        //                             success: function(res) {
        //                                 iziToast.success({
        //                                     title: 'Sukses!',
        //                                     message: 'Pembatalan mutasi aset berhasil pada ' + res,
        //                                     position: 'topRight'
        //                                 });
        //                                 refreshModalMutasi("{{ $list['show']->id }}");
        //                                 fresh();
        //                             },
        //                             error: function(res) {
        //                                 console.log("error : " + JSON.stringify(res) );
        //                                 iziToast.error({
        //                                     title: 'Pesan Galat!',
        //                                     message: res.responseJSON.error,
        //                                     position: 'topRight'
        //                                 });
        //                             }
        //                         });
        //                     }
        //                 })
        //             }
        //         },
        //         error: function(res) {
        //             console.log("error : " + JSON.stringify(res) );
        //             iziToast.error({
        //                 title: 'Pesan Galat!',
        //                 message: res.responseJSON.error,
        //                 position: 'topRight'
        //             });
        //         }
        //     });
        // }

        // PENGEMBALIAN
        function modalPengembalian(aset) {
            $.ajax({
                url: "/api/inventaris/aset/pengembalian/"+aset,
                type: 'GET',
                dataType: 'json', // added data type
                success: function(res){
                    if (res.penarikan != null) {
                        if (res.penarikan.status == 3) {
                            iziToast.error({
                                title: 'Pesan Galat!',
                                message: 'Aset telah <i>DIMUSNAHKAN</i>. Silakan melakukan pembatalan penarikan aset apabila diperlukan',
                                position: 'topRight'
                            });
                        } else {
                            if (res.penarikan.status == 2) {
                                iziToast.warning({
                                    title: 'Pesan Ambigu!',
                                    message: 'Aset telah <i>DIKEMBALIKAN KE GUDANG</i>. Silakan melakukan pembatalan penarikan aset apabila diperlukan',
                                    position: 'topRight'
                                });
                            }
                        }
                    } else {
                        if (res.peminjaman != null) {
                            // DEFINISI
                            $('#ruangan_sekarang_pengembalian').text(res.show.ruangan);
                            $('#lokasi_sekarang_pengembalian').text(res.show.lokasi);
                            $('#kelengkapan_pengembalian').val(res.peminjaman.kelengkapan);
                            $('#ket_pengembalian').val(res.peminjaman.ket);
                            $("#kondisi_pengembalian").find('option').remove();
                            $("#kondisi_pengembalian").append(`
                                <option value="1" ${res.show.kondisi == '1' ? "selected":""}>Baik</option>
                                <option value="2" ${res.show.kondisi == '2' ? "selected":""}>Cukup</option>
                                <option value="3" ${res.show.kondisi == '3' ? "selected":""}>Buruk</option>
                            `);

                            $("#pengantar_pengembalian").find('option').remove();
                            $("#pengantar_pengembalian").append(`<option value="" hidden>Pilih</option>`);
                            res.users.forEach(item => {
                                $("#pengantar_pengembalian").append(`
                                    <option value="${item.id}">${item.nama}</option>
                                `);
                            });

                            $("#penerima_pengembalian").find('option').remove();
                            $("#penerima_pengembalian").append(`<option value="" hidden>Pilih</option>`);
                            res.users.forEach(item => {
                                $("#penerima_pengembalian").append(`
                                    <option value="${item.id}">${item.nama}</option>
                                `);
                            });

                            $('#formPengembalian').modal('show');
                        } else {
                            iziToast.warning({
                                title: 'Pesan Ambigu!',
                                message: 'Aset tidak sedang dalam <i>PEMINJAMAN</i>. Silakan melakukan Peminjaman Aset terlebih dahulu sebelum melakukan proses Pengembalian Aset',
                                position: 'topRight'
                            });
                        }
                    }
                },
                error: function(res){
                    console.log("error : " + JSON.stringify(res) );
                    iziToast.error({
                        title: 'Pesan Galat!',
                        message: res.responseJSON.error,
                        position: 'topRight'
                    });
                }
            });
        }

        function prosesPengembalian() {
            $("#btn-pengembalian").prop('disabled', true);
            $("#btn-pengembalian").find("i").toggleClass("fa-qrcode fa-sync fa-spin");
            var tgl_pengembalian = $("#tgl_pengembalian").val();
            var kondisi = $("#kondisi_pengembalian").val();
            var pengantar = $("#pengantar_pengembalian").val();
            var penerima = $('#penerima_pengembalian').val();
            var ket = $('#catatan_pengembalian').val();

            if (tgl_pengembalian == "" || kondisi == "" || pengantar == "" || penerima == "") {
                iziToast.warning({
                    title: 'Pesan Ambigu!',
                    message: 'Pastikan Anda tidak mengosongi semua isian wajib (<a class="text-danger">*</a>)',
                    position: 'topRight'
                });
                $("#btn-pengembalian").find("i").removeClass("fa-sync fa-spin").addClass("fa-qrcode");
                $("#btn-pengembalian").prop('disabled', false);
            } else {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: 'POST',
                    url: '/api/inventaris/aset/pengembalian/store',
                    dataType: 'json',
                    data: {
                        user: "{{ Auth::user()->id }}",
                        tgl_pengembalian: tgl_pengembalian,
                        kondisi: kondisi,
                        pengantar: pengantar,
                        penerima: penerima,
                        ket: ket,
                        aset: "{{ $list['show']->id }}",
                    },
                    success: function(res) {
                        iziToast.success({
                            title: 'Sukses!',
                            message: 'Pengembalian Aset berhasil pada '+ res,
                            position: 'topRight'
                        });
                        $('#formPengembalian').modal('hide');
                        fresh();
                        $("#btn-pengembalian").find("i").removeClass("fa-sync fa-spin").addClass("fa-qrcode");
                        $("#btn-pengembalian").prop('disabled', false);
                    },
                    error: function (res) {
                        console.log("error : " + JSON.stringify(res) );
                        iziToast.error({
                            title: 'Pesan Galat!',
                            message: res.responseJSON.error,
                            position: 'topRight'
                        });
                        $("#btn-pengembalian").find("i").removeClass("fa-sync fa-spin").addClass("fa-qrcode");
                        $("#btn-pengembalian").prop('disabled', false);
                    }
                });
            }
        }

        // PENARIKAN
        function modalPenarikan(aset) {
            $.ajax({
                url: "/api/inventaris/aset/penarikan/"+aset,
                type: 'GET',
                dataType: 'json', // added data type
                success: function(res){
                    if (res.validasi1) {
                        batalPenarikan(res.validasi1.id);
                    } else {
                        if (res.validasi2) {
                            iziToast.error({
                                title: 'Pesan Galat!',
                                message: 'Aset sedang dalam <i>PEMINJAMAN</i>. Silakan melakukan pengembalian aset apabila diperlukan',
                                position: 'topRight'
                            });
                        } else {
                            $('#validasi_ruangan_penarikan').val(res.show.id_ruangan);
                            $('#ruangan_sekarang_penarikan').text(res.show.ruangan);
                            $('#lokasi_sekarang_penarikan').text(res.show.lokasi);
                            $('#formPenarikan').modal('show');
                        }
                    }
                },
                error: function(res){
                    console.log("error : " + JSON.stringify(res) );
                    iziToast.error({
                        title: 'Pesan Galat!',
                        message: res.responseJSON.error,
                        position: 'topRight'
                    });
                }
            });
        }

        function prosesPenarikan() {
            $("#btn-penarikan").prop('disabled', true);
            $("#btn-penarikan").find("i").toggleClass("fa-people-carry fa-sync fa-spin");
            var alasan = $("#alasan_penarikan").val();
            var kondisi = $("#kondisi_penarikan").val();
            var status = $("#status_penarikan").val();
            var validasi = $('#validasi_ruangan_penarikan').val();
            console.log(validasi);

            if (alasan == "" || kondisi == "" || status == "") {
                iziToast.warning({
                    title: 'Pesan Ambigu!',
                    message: 'Pastikan Anda tidak mengosongi semua isian wajib (<a class="text-danger">*</a>)',
                    position: 'topRight'
                });
                $("#btn-penarikan").find("i").removeClass("fa-sync fa-spin").addClass("fa-people-carry");
                $("#btn-penarikan").prop('disabled', false);
            } else {
                if (validasi == 1 && kondisi == 2) {
                    iziToast.warning({
                        title: 'Pesan Ambigu!',
                        message: 'Ruangan aset sudah berada di Gudang Aset, tidak memerlukan penarikan aset ke Gudang kembali',
                        position: 'topRight'
                    });
                    $("#btn-penarikan").find("i").removeClass("fa-sync fa-spin").addClass("fa-people-carry");
                    $("#btn-penarikan").prop('disabled', false);
                } else {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        method: 'POST',
                        url: '/api/inventaris/aset/penarikan/store',
                        dataType: 'json',
                        data: {
                            user: "{{ Auth::user()->id }}",
                            alasan: alasan,
                            kondisi: kondisi,
                            status: status,
                            aset: "{{ $list['show']->id }}",
                        },
                        success: function(res) {
                            iziToast.success({
                                title: 'Sukses!',
                                message: 'Penarikan Aset berhasil pada '+ res,
                                position: 'topRight'
                            });
                            $('.modal').modal('hide');
                            fresh();
                            $("#btn-penarikan").find("i").removeClass("fa-sync fa-spin").addClass("fa-people-carry");
                            $("#btn-penarikan").prop('disabled', false);
                        },
                        error: function (res) {
                            console.log("error : " + JSON.stringify(res) );
                            iziToast.error({
                                title: 'Pesan Galat!',
                                message: res.responseJSON.error,
                                position: 'topRight'
                            });
                            $("#btn-penarikan").find("i").removeClass("fa-sync fa-spin").addClass("fa-people-carry");
                            $("#btn-penarikan").prop('disabled', false);
                        }
                    });
                }
            }
        }

        function batalPenarikan(id) {
            Swal.fire({
                target: document.getElementById('formPenarikan'),
                title: 'Batal Penarikan Aset ID : '+id+' ?',
                text: 'Status, kondisi, dan ruangan aset yang sudah dilakukan penarikan akan dikembalikan seperti semula',
                icon: 'warning',
                reverseButtons: false,
                showDenyButton: false,
                showCloseButton: false,
                showCancelButton: true,
                focusCancel: true,
                confirmButtonColor: '#FF4845',
                confirmButtonText: `<i class="fa fa-history"></i> Batalkan Penarikan`,
                cancelButtonText: `<i class="fa fa-times me-1" style="font-size:13px"></i> Tutup`,
                backdrop: `rgba(26,27,41,0.8)`,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "/api/inventaris/aset/penarikan/destroy/" + id,
                        type: 'GET',
                        dataType: 'json', // added data type
                        success: function(res) {
                            iziToast.success({
                                title: 'Sukses!',
                                message: 'Pembatalan penarikan aset berhasil pada ' + res,
                                position: 'topRight'
                            });
                            $('.modal').modal('hide');
                            fresh();
                        },
                        error: function(res) {
                            console.log("error : " + JSON.stringify(res) );
                            iziToast.error({
                                title: 'Pesan Galat!',
                                message: res.responseJSON.error,
                                position: 'topRight'
                            });
                        }
                    });
                }
            })
        }

        // REFRESH -----------------------------------------------------------------------------------------------------------------------

        // REFRESH DASHBOARD DETAIL ASET
        function fresh() {
            $.ajax({
                url: "/api/inventaris/aset/{{ $list['show']->id }}/fresh",
                type: 'GET',
                dataType: 'json', // added data type
                success: function(res){
                    if (res) {
                        // FRESH NO.INVENTARIS
                        $('#show_no_inventaris').text(res.show.no_inventaris);

                        // FRESH RUANGAN
                        $('#ruangan_aset').text(res.show.ruangan+" - "+res.show.lokasi);

                        // FRESH STATUS
                        $('#status_aset').empty();
                        if (res.show.status == 0 || res.show.status == null) {
                            $('#status_aset').append(`<div class="badge bg-primary">Tersedia</div>`);
                        } else {
                            if (res.show.status == 1) {
                                $('#status_aset').append(`<div class="badge bg-success">Dalam Peminjaman</div>`);
                            } else {
                                if (res.show.status == 2) {
                                    $('#status_aset').append(`<div class="badge bg-warning">Dikembalikan ke Gudang</div>`);
                                } else {
                                    if (res.show.status == 3) {
                                        $('#status_aset').append(`<div class="badge bg-danger">Dimusnahkan</div>`);
                                    }
                                }
                            }
                        }

                        // FRESH KONDISI
                        $('#kondisi_aset').empty();
                        if (res.show.kondisi == 1) {
                            $('#kondisi_aset').append(`<div class="badge bg-primary">Baik</div>`);
                        } else {
                            if (res.show.kondisi == 2) {
                                $('#kondisi_aset').append(`<div class="badge bg-warning">Cukup</div>`);
                            } else {
                                if (res.show.kondisi == 3) {
                                    $('#kondisi_aset').append(`<div class="badge bg-danger">Buruk</div>`);
                                } else {
                                    $('#kondisi_aset').append(`<div class="badge bg-dark">Kondisi Tidak Terdefinisi</div>`);
                                }
                            }
                        }
                        $('#qr').text('') ;
                        var qrcode = new QRCode("qr", {
                            text: res.qr,
                            width: 300,
                            height: 300,
                            colorDark : "#000000",
                            colorLight : "#ffffff",
                            correctLevel : QRCode.CorrectLevel.H
                        });
                    }
                },
                error: function(res){
                    console.log("error : " + JSON.stringify(res) );
                    iziToast.error({
                        title: 'Pesan Galat!',
                        message: res.responseJSON.error,
                        position: 'topRight'
                    });
                }
            });
        }

        // REFRESH MODAL PEMELHARAAN
        function refreshModalPemeliharaan(aset) {
            $("#tampil-tbody-pemeliharaan").empty().append(`<tr><td colspan="9"><center><i class="fa fa-spinner fa-spin fa-fw"></i> Memuat data...</center></td></tr>`);
            $.ajax({
                url: "/api/inventaris/aset/pemeliharaan/"+aset,
                type: 'GET',
                dataType: 'json', // added data type
                success: function(res){
                    if (res) {
                        $('#hasil_pemeliharaan').val('');
                        $('#rekomendasi_pemeliharaan').val('');

                        // DEFINISI
                        $("#petugas_pemeliharaan").find('option').remove();
                        $("#petugas_pemeliharaan").append(`<option value="" hidden>Pilih</option>`);
                        res.users.forEach(item => {
                            $("#petugas_pemeliharaan").append(`<option value="${item.id}">${item.nama}</option>`);
                        });

                        // TABEL
                        var adminID = "{{ Auth::user()->getPermission('admin_aset') }}";
                        $("#tampil-tbody-pemeliharaan").empty();
                        $('#dttable-pemeliharaan').DataTable().clear().destroy();
                        var date = new Date().toLocaleDateString();
                        res.show.forEach(item => {
                            var updet = new Date(item.created_at).toLocaleDateString();
                            content = `<tr id='`+item.id+`'>`;
                                if (adminID == true) {
                                    content += `<td><center><a href='javascript:void(0);' class='btn btn-light-danger btn-sm' onclick="hapusPemeliharaan(${item.id})"><i class='bx bx-trash scaleX-n1-rtl'></i> Hapus</a></center></td>`;
                                } else {
                                    if (updet == date) {
                                        content += `<td><center><a href='javascript:void(0);' class='btn btn-light-danger btn-sm' onclick="hapusPemeliharaan(${item.id})"><i class='bx bx-trash scaleX-n1-rtl'></i> Hapus</a></center></td>`;
                                    } else {
                                        content += `<td><center><a href='javascript:void(0);' class='btn btn-light-secondary btn-sm'><i class='bx bx-trash scaleX-n1-rtl'></i> Hapus</a></center></td>`;
                                    }
                                }
                                content += `<td style='white-space: normal !important;word-wrap: break-word;'>${item.nama_petugas}</td>`;
                                content += `<td style='white-space: normal !important;word-wrap: break-word;'>${item.hasil}</td>`;
                                content += `<td style='white-space: normal !important;word-wrap: break-word;'>${item.rekomendasi}</td>`;
                                content += `<td>${new Date(item.created_at).toLocaleString('sv-SE')}</td>`;
                            content += `</tr>`;
                            $('#tampil-tbody-pemeliharaan').append(content);
                        })
                        var table = $('#dttable-pemeliharaan').DataTable({
                            order: [
                                [4, "desc"]
                            ],
                            bAutoWidth: false,
                            aoColumns : [
                                { sWidth: '10%' },
                                { sWidth: '15%' },
                                { sWidth: '30%' },
                                { sWidth: '30%' },
                                { sWidth: '15%' },
                            ],
                            displayLength: 7,
                            lengthChange: true,
                            lengthMenu: [7, 10, 25, 50, 75, 100],
                            buttons: ['excel', 'pdf']
                        });
                        table.buttons().container().appendTo('#dttable-pemeliharaan_wrapper .col-md-6:eq(0)');
                        $('[data-bs-toggle="tooltip"]').tooltip({
                            trigger: 'hover'
                        })
                    }
                },
                error: function(res){
                    console.log("error : " + JSON.stringify(res) );
                    iziToast.error({
                        title: 'Pesan Galat!',
                        message: res.responseJSON.error,
                        position: 'topRight'
                    });
                }
            });
        }

        function refreshModalMutasi(aset) {
            $("#tampil-tbody-mutasi").empty().append(`<tr><td colspan="9"><center><i class="fa fa-spinner fa-spin fa-fw"></i> Memuat data...</center></td></tr>`);
            $.ajax({
                url: "/api/inventaris/aset/mutasi/"+aset,
                type: 'GET',
                dataType: 'json', // added data type
                success: function(res){
                    if (res) {
                        // DEFINISI
                        // $("#lokasi_awal").val(res.aset.ruangan);
                        $("#ruangan_sekarang_mutasi").text(res.aset.ruangan);
                        $("#lokasi_sekarang_mutasi").text(res.aset.lokasi);
                        $("#kondisi_mutasi").find('option').remove();
                        $("#kondisi_mutasi").append(`
                            <option value="1" ${res.aset.kondisi == '1' ? "selected":""}>Baik</option>
                            <option value="2" ${res.aset.kondisi == '2' ? "selected":""}>Cukup</option>
                            <option value="3" ${res.aset.kondisi == '3' ? "selected":""}>Buruk</option>
                        `);

                        $("#lokasi_tujuan").find('option').remove();
                        res.ruangan.forEach(item => {
                            $("#lokasi_tujuan").append(`<option value="" hidden>Pilih</option>`);
                            $("#lokasi_tujuan").append(`
                                <option value="${item.id}" ${res.aset.id_ruangan == item.id ? "selected":""}>${item.ruangan} - ${item.lokasi}</option>
                            `);
                        });

                        // TABEL
                        var adminID = "{{ Auth::user()->getPermission('admin_aset') }}";
                        console.log(adminID);
                        $("#tampil-tbody-mutasi").empty();
                        $('#dttable-mutasi').DataTable().clear().destroy();
                        var date = new Date().toLocaleDateString();
                        res.show.forEach(item => {
                            var updet = new Date(item.created_at).toLocaleDateString();
                            content = `<tr id='`+item.id+`'>`;
                                if (adminID == true) {
                                    content += `<td><center><div class='btn-group'>
                                        <a href='javascript:void(0);' class='btn btn-light-danger btn-sm' onclick="batalMutasi(${item.id})"><i class='bx bx-trash scaleX-n1-rtl'></i> Batal</a>
                                        </div></center></td>`;
                                } else {
                                    if (updet == date) {
                                        if (res.peminjaman != null) {
                                            if (res.peminjaman.status == 1) {
                                                content += `<td><center><div class='btn-group'>
                                                    <a href='javascript:void(0);' class='btn btn-light-secondary btn-sm'><i class='bx bx-trash scaleX-n1-rtl'></i> Batal</a>
                                                    </div></center></td>`;
                                            } else {
                                                content += `<td><center><div class='btn-group'>
                                                    <a href='javascript:void(0);' class='btn btn-light-danger btn-sm' onclick="batalMutasi(${item.id})"><i class='bx bx-trash scaleX-n1-rtl'></i> Batal</a>
                                                    </div></center></td>`;
                                            }
                                        } else {
                                            content += `<td><center><div class='btn-group'>
                                                <a href='javascript:void(0);' class='btn btn-light-secondary btn-sm'><i class='bx bx-trash scaleX-n1-rtl'></i> Batal</a>
                                                </div></center></td>`;
                                        }
                                    } else {
                                        content += `<td><center><div class='btn-group'>
                                            <a href='javascript:void(0);' class='btn btn-light-secondary btn-sm'><i class='bx bx-trash scaleX-n1-rtl'></i> Batal</a>
                                            </div></center></td>`;
                                    }
                                }
                                content += `<td>${new Date(item.created_at).toLocaleString('sv-SE')}</td>`;
                                content += `<td style='white-space: normal !important;word-wrap: break-word;'><div class='d-flex justify-content-start align-items-center'><div class='d-flex flex-column'><h6 class='mb-0'>${item.ruangan_awal_aset}</h6><small class='text-truncate text-muted'>${item.lokasi_awal_aset}</small></div></div></td>`;
                                content += `<td style='white-space: normal !important;word-wrap: break-word;'><div class='d-flex justify-content-start align-items-center'><div class='d-flex flex-column'><h6 class='mb-0'>${item.ruangan_tujuan_aset}</h6><small class='text-truncate text-muted'>${item.lokasi_tujuan_aset}</small></div></div></td>`;
                                content += `<td style='white-space: normal !important;word-wrap: break-word;'>${item.ket?item.ket:''}</td>`;
                                if (item.kondisi == 1) {
                                    content += `<td><kbd class='text-dark' style='background-color:#eaf9f4'>Baik</kbd></td>`;
                                } else {
                                    if (item.kondisi == 2) {
                                        content += `<td><kbd class='text-dark' style='background-color:#fef7ed'>Cukup</kbd></td>`;
                                    } else {
                                        if (item.kondisi == 3) {
                                            content += `<td><kbd class='text-dark' style='background-color:#fef0f0'>Buruk</kbd></td>`;
                                        }
                                    }
                                }
                            content += `</tr>`;
                            $('#tampil-tbody-mutasi').append(content);
                        })
                        var table = $('#dttable-mutasi').DataTable({
                            order: [
                                [1, "desc"]
                            ],
                            bAutoWidth: false,
                            aoColumns : [
                                { sWidth: '10%' },
                                { sWidth: '15%' },
                                { sWidth: '20%' },
                                { sWidth: '20%' },
                                { sWidth: '25%' },
                                { sWidth: '10%' },
                            ],
                            displayLength: 7,
                            lengthChange: true,
                            lengthMenu: [7, 10, 25, 50, 75, 100],
                            buttons: ['excel', 'pdf']
                        });
                        table.buttons().container().appendTo('#dttable-mutasi_wrapper .col-md-6:eq(0)');
                        $('[data-bs-toggle="tooltip"]').tooltip({
                            trigger: 'hover'
                        })
                    }
                },
                error: function(res){
                    console.log("error : " + JSON.stringify(res) );
                    iziToast.error({
                        title: 'Pesan Galat!',
                        message: res.responseJSON.error,
                        position: 'topRight'
                    });
                }
            });
        }

        // FUNCTION -----------------------------------------------------------------------------------------------------------------------
        function updateKondisi() {
            var kondisi = $("#pilihan_kondisi").val();

            $.ajax({
                url: "/api/inventaris/aset/{{ $list['show']->token }}/kondisi/"+kondisi,
                type: 'GET',
                dataType: 'json', // added data type
                success: function(res){
                    iziToast.success({
                        title: 'Pesan Sukses!',
                        message: 'Kondisi sarana berhasil diperbarui pada '+res,
                        position: 'topRight'
                    });
                    if (res) {
                        $('#kondisi').modal('hide');
                        fresh();
                        // window.location.reload();
                    }
                },
                error: function(res){
                    console.log("error : " + JSON.stringify(res) );
                }
            });
        }

        function cetak() {
            var pdf = new jsPDF({
                orientation: "portrait",
                unit: "mm",
                format: [120, 120]
            });

            let base64Image = $('#qr img').attr('src');
            pdf.addImage(base64Image, 'png', 10, 10, 100, 100);
            var base64string = pdf.output('bloburl');
            window.open(base64string,'_blank', 'width=500,height=550');
        }

        function getDateTime() {
            var now = new Date();
            now.setHours(now.getHours() + 7);
            var year = now.getFullYear();
            var month = now.getMonth() + 1;
            var day = now.getDate();
            if (month.toString().length == 1) {
                month = '0' + month;
            }
            if (day.toString().length == 1) {
                day = '0' + day;
            }
            var dateTime = year + '-' + month + '-' + day;
            return dateTime;
        }
        function formatRupiah(angka, prefix)
        {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split    = number_string.split(','),
                sisa     = split[0].length % 3,
                rupiah     = split[0].substr(0, sisa),
                ribuan     = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
        }
    </script>
@endsection
