@extends('layouts.index')

@section('content')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i></a></li>
                        <li class="breadcrumb-item">Kepegawaian</li>
                        <li class="breadcrumb-item"><a href="{{ route('profilkaryawan.index') }}">Profil Karyawan</a></li>
                        <li class="breadcrumb-item" aria-current="page">Detail</li>
                    </ul>
                </div>
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h2 class="mb-0">Profil <a class="text-primary">{{ $list['show']->nama?$list['show']->nama:$list['show']->name }}</a></h2>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- [ breadcrumb ] end -->
    <!-- [ Main Content ] start -->
    <div class="row pt-1"><!-- [ sample-page ] start -->
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body py-0">
                    <ul class="nav nav-tabs profile-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="profile-tab-1" data-bs-toggle="tab"
                                href="#profil-pengguna" role="tab" aria-selected="true">
                                <i class="ti ti-user-check me-2"></i>Profil
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab"
                                href="#kepegawaian" role="tab" aria-selected="true" onclick="showKepegawaian()">
                                <i class="ti ti-sailboat me-2"></i>Kepegawaian
                            </a>
                        </li>
                        @if ($list['show']->deleted_at == null || $list['show']->status == null)
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab"
                                    href="#penetapan" role="tab" aria-selected="true" onclick="refreshPenetapan()">
                                    <i class="ti ti-license me-2"></i>Penetapan
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="profile-tab-3" data-bs-toggle="tab"
                                    href="#rotasi" role="tab" aria-selected="true" onclick="refreshRotasi()">
                                    <i class="ti ti-route me-2"></i>Rotasi
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab"
                                    href="#dokumen" role="tab" aria-selected="true" onclick="refreshDokumen()">
                                    <i class="ti ti-cloud-download me-2"></i>Dokumen
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="profile-tab-4" data-bs-toggle="tab"
                                    href="#spkrkk" role="tab" aria-selected="true" onclick="refreshSpkRkk()">
                                    <i class="ti ti-brand-docker me-2"></i>SPK & RKK
                                </a>
                            </li>
                            {{-- <li class="nav-item">
                                <a class="nav-link" id="profile-tab-5" data-bs-toggle="tab"
                                    href="#surtug" role="tab" aria-selected="true" onclick="refreshSurtug()">
                                    <i class="ti ti-plane me-2"></i>Surat Tugas
                                </a>
                            </li> --}}
                            {{-- <li class="nav-item">
                                <a class="nav-link" id="profile-tab-6" data-bs-toggle="tab"
                                    href="#profile-6" role="tab" aria-selected="true">
                                    <i class="ti ti-settings me-2"></i><s>Settings</s>
                                </a>
                            </li> --}}
                        @endif
                    </ul>
                </div>
            </div>
            <div class="tab-content">
                <div class="tab-pane show active" id="profil-pengguna" role="tabpanel"
                    aria-labelledby="profile-tab-1">
                    <div class="row">
                        <div class="col-lg-4 col-xxl-3">
                            <div class="card">
                                <div class="card-body position-relative">
                                    {{-- <div class="position-absolute end-0 top-0 p-3">
                                        <span class="badge bg-primary">Pro</span>
                                    </div> --}}
                                    <div class="text-center">
                                        <div class="chat-avtar d-inline-flex mx-auto mb-2">
                                            @if (empty($list['foto']->filename))
                                                <img class="rounded-circle img-fluid" src="{{ asset('images/pku/user.png') }}" alt="User image" style="height: 100px;width: auto">
                                                {{-- <a class="image-popup-no-margins" href="{{ asset('images/pku/user.png') }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Tekan untuk memperbesar foto profil">
                                                    <img class="img-fluid avatar-sm rounded-circle img-thumbnail" alt="" src="{{ asset('images/pku/user.png') }}" width="75">
                                                </a> --}}
                                            @else
                                                <a href="{{ url('storage/'.substr($list['foto']->filename,7,1000)) }}" data-toggle="lightbox" class="img-post" data-caption="Nama file foto : {{ $list['foto']->title }}">
                                                    <img class="rounded-circle img-fluid card-img" src="{{ url('storage/'.substr($list['foto']->filename,7,1000)) }}" alt="User image" style="height: 100px;width: auto">
                                                    <div class="card-img-overlay">
                                                        <i class="ti ti-eye"></i>
                                                    </div>
                                                </a>
                                                {{-- <a class="image-popup-no-margins" href="{{ url('storage/'.substr($list['foto']->filename,7,1000)) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Tekan untuk memperbesar foto profil">
                                                    <img class="img-fluid avatar-sm rounded-circle img-thumbnail" alt="" src="{{ url('storage/'.substr($list['foto']->filename,7,1000)) }}" width="75">
                                                </a> --}}
                                            @endif
                                        </div>
                                        <h5 class="mb-1">{{ $list['show']->nama }}</h5>
                                        <p class="text-muted text-sm">
                                            @foreach ($list['role'] as $val)
                                                @if ($list['show']->id == $val->id_user)
                                                    <span class="badge rounded-pill text-bg-secondary">{{ $val->nama_role }}</span>
                                                @endif
                                            @endforeach
                                        </p>
                                        <hr class="my-2 border border-secondary-subtle">
                                        <div class="row">
                                            <div class="col-6 border border-top-0 border-bottom-0 border-start-0">
                                                <h6 class="mb-0">Status Pegawai</h6>
                                                <small class="text-muted">{{ $list['show']->deleted_at == null? 'Aktif':'Non Aktif' }} {{ empty($list['users_status'])? '':'- '.$list['users_status']->nama_referensi }}</small>
                                            </div>
                                            <div class="col-6 border border-top-0 border-bottom-0 border-end-0">
                                                <h6 class="mb-0">Terakhir Login</h6>
                                                <small class="text-muted">@if (!empty($list['showlog'][1])) {{ \Carbon\Carbon::parse($list['showlog'][1]->log_date)->diffForHumans() }} @else - @endif</small>
                                            </div>
                                            {{-- <div class="col-4">
                                                <h5 class="mb-0">...</h5>
                                                <small class="text-muted">x</small>
                                            </div> --}}
                                        </div>
                                        <hr class="my-3 border border-secondary-subtle">
                                        <div class="d-inline-flex align-items-center justify-content-start w-100 mb-3">
                                            <i class="fas fa-id-card-alt me-3"></i>
                                            <p class="mb-0" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="Nomor Induk Pegawai" id="show_nip_after">{{ $list['show']->nip?$list['show']->nip:'-' }}</p>
                                        </div>
                                        <div class="d-inline-flex align-items-center justify-content-start w-100 mb-3">
                                            <i class="fas fa-address-card me-3"></i>
                                            <p class="mb-0" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="Nomor Induk Kependudukan">{{ $list['show']->nik?$list['show']->nik:'-' }}</p>
                                        </div>
                                        <div class="d-inline-flex align-items-center justify-content-start w-100 mb-3">
                                            <i class="fas fa-envelope me-3"></i>
                                            <p class="mb-0" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="Email Aktif">
                                                <a href="javascript:void(0);" class="text-dark">{{ $list['show']->email }}</a>
                                            </p>
                                        </div>
                                        <div class="d-inline-flex align-items-center justify-content-start w-100 mb-3">
                                            <i class="fab fa-whatsapp-square me-3"></i>
                                            <p class="mb-0" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="Nomor Handphone/Whatsapp">{{ $list['show']->no_hp?$list['show']->no_hp:'-' }}</p>
                                        </div>
                                        <div class="d-inline-flex align-items-center justify-content-start w-100">
                                            <i class="fas fa-user-md me-3"></i>
                                            <p class="mb-0" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="Profesi/Klasifikasi Pegawai">
                                                {{ $list['show']->ref_profesi == null?'-':'' }}
                                                {{ $list['show']->ref_profesi == 1?'Nakes':'' }}
                                                {{ $list['show']->ref_profesi == 2?'Nakesla':'' }}
                                                {{ $list['show']->ref_profesi == 3?'Non Nakes':'' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <h5>Media Sosial</h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-2">
                                        <a href="{{ url('https://www.facebook.com/'.$list['show']->fb) }}" class="btn btn-link-secondary d-grid" target="_blank">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <div class="avtar avtar-xs btn-light-facebook">
                                                        <i class="fab fa-facebook-f f-16"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-4 text-start">
                                                    <h6 class="mb-0">Facebook / <mark>{{ $list['show']->fb ? $list['show']->fb : 'xxx' }}</mark></h6>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="mb-2">
                                        <a href="{{ url('https://www.instagram.com/'.$list['show']->ig) }}" class="btn btn-link-secondary d-grid" target="_blank">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <div class="avtar avtar-xs btn-light-instagram">
                                                        <i class="fab fa-instagram f-16"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-4 text-start">
                                                    <h6 class="mb-0">Instagram / <mark>{{ $list['show']->ig ? $list['show']->ig : 'xxx' }}</mark></h6>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="mb-2">
                                        <a href="{{ url('https://www.tiktok.com/@'.$list['show']->tt) }}" class="btn btn-link-secondary d-grid" target="_blank">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <div class="avtar avtar-xs btn-light-tiktok">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                                            <path d="M448 209.9a210.1 210.1 0 0 1 -122.8-39.3V349.4A162.6 162.6 0 1 1 185 188.3V278.2a74.6 74.6 0 1 0 52.2 71.2V0l88 0a121.2 121.2 0 0 0 1.9 22.2h0A122.2 122.2 0 0 0 381 102.4a121.4 121.4 0 0 0 67 20.1z"/>
                                                        </svg>
                                                        {{-- <i class="fab fa-tiktok f-16"></i> --}}
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-4 text-start">
                                                    <h6 class="mb-0">Tiktok / <mark>{{ $list['show']->tt ? $list['show']->tt : 'xxx' }}</mark></h6>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="mb-0">
                                        <a href="{{ url('https://www.youtube.com/@rspkumuhsukoharjo1801') }}" class="btn btn-link-secondary d-grid" target="_blank">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <div class="avtar avtar-xs btn-light-youtube">
                                                        <i class="fab fa-youtube f-16"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-4 text-start">
                                                    <h6 class="mb-0">Youtube / <mark>rspkusukoharjo</mark></h6>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8 col-xxl-9">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Pengalaman Bekerja</h5>
                                </div>
                                <div class="card-body">
                                    <p class="mb-0">{!! $list['show']->pengalaman_kerja?str_replace(array("\r\n", "\r", "\n"),"<br>", $list['show']->pengalaman_kerja):'-' !!}</p>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <h5>Data Diri</h5>
                                </div>
                                <div class="card-body">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item px-0 pt-0">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <p class="mb-1 text-muted">Nama Lengkap</p>
                                                    <p class="mb-0">{{ $list['show']->nama?$list['show']->nama:'-' }}</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p class="mb-1 text-muted">Nama Panggilan</p>
                                                    <p class="mb-0">{{ $list['show']->nick?$list['show']->nick:'-' }}</p>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item px-0">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <p class="mb-1 text-muted">Tempat Lahir</p>
                                                    <p class="mb-0">{{ $list['show']->temp_lahir?$list['show']->temp_lahir:'-' }}</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p class="mb-1 text-muted">Tanggal Lahir</p>
                                                    <p class="mb-0">{{ $list['show']->tgl_lahir?\Carbon\Carbon::parse($list['show']->tgl_lahir)->isoFormat('D MMMM Y'):'-' }}</p>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item px-0">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <p class="mb-1 text-muted">Jenis Kelamin</p>
                                                    <p class="mb-0">{{ $list['show']->jns_kelamin?$list['show']->jns_kelamin:'-' }}</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p class="mb-1 text-muted">Status Kawin</p>
                                                    <p class="mb-0">{{ $list['show']->status_kawin?$list['show']->status_kawin:'-' }}</p>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item px-0">
                                            <p class="mb-1 text-muted">Alamat Lengkap Sesuai KTP</p>
                                            <p class="mb-0">{!! $list['show']->alamat_ktp?str_replace(array("\r\n", "\r", "\n"),"<br>", $list['show']->alamat_ktp):'-' !!}</p>
                                        </li>
                                        <li class="list-group-item px-0 pb-0">
                                            <p class="mb-1 text-muted">Alamat Domisili</p>
                                            <p class="mb-0">{!! $list['show']->alamat_dom?str_replace(array("\r\n", "\r", "\n"),"<br>", $list['show']->alamat_dom):'Sama dengan alamat pada KTP' !!}</p>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            @if (!empty($list['show']->s3) || !empty($list['show']->s2) || !empty($list['show']->s1_profesi) || !empty($list['show']->s1) || !empty($list['show']->d4) || !empty($list['show']->d3) || !empty($list['show']->d2) || !empty($list['show']->sma) || !empty($list['show']->smp) || !empty($list['show']->sd))
                                {{-- CEK APAKAH ADA DATA PENDIDIKAN, JIKA ADA TAMPILKAN --}}
                                <div class="card task-card">
                                    <div class="card-header">
                                        <h5>Data Pendidikan</h5>
                                    </div>
                                    <div class="card-body pb-3">
                                        @if (!empty($list['show']->nik))
                                            <ul class="list-unstyled task-list">
                                                @if (!empty($list['show']->s3))
                                                <li>
                                                    <i class="feather icon-arrow-right f-w-600 task-icon bg-secondary"></i>
                                                    <h5 class="text-muted">S3 - {{ $list['show']->s3 }}</h5>
                                                    <p class="m-b-5">Lulus pada tahun {{ $list['show']->th_s3 }}</p>
                                                </li>
                                                @endif
                                                @if (!empty($list['show']->s2))
                                                <li>
                                                    <i class="feather icon-arrow-right f-w-600 task-icon bg-secondary"></i>
                                                    <h5 class="text-muted">S2 - {{ $list['show']->s2 }}</h5>
                                                    <p class="m-b-5">Lulus pada tahun {{ $list['show']->th_s2 }}</p>
                                                </li>
                                                @endif
                                                @if (!empty($list['show']->s1_profesi))
                                                <li>
                                                    <i class="feather icon-arrow-right f-w-600 task-icon bg-secondary"></i>
                                                    <h5 class="text-muted">S1 <b class="text-primary">Profesi</b> - {{ $list['show']->s1_profesi }}</h5>
                                                    <p class="m-b-5">Lulus pada tahun {{ $list['show']->th_s1_profesi }}</p>
                                                </li>
                                                @endif
                                                @if (!empty($list['show']->s1))
                                                <li>
                                                    <i class="feather icon-arrow-right f-w-600 task-icon bg-secondary"></i>
                                                    <h5 class="text-muted">S1 - {{ $list['show']->s1 }}</h5>
                                                    <p class="m-b-5">Lulus pada tahun {{ $list['show']->th_s1 }}</p>
                                                </li>
                                                @endif
                                                @if (!empty($list['show']->d4))
                                                <li>
                                                    <i class="feather icon-arrow-right f-w-600 task-icon bg-secondary"></i>
                                                    <h5 class="text-muted">D4 - {{ $list['show']->d4 }}</h5>
                                                    <p class="m-b-5">Lulus pada tahun {{ $list['show']->th_d4 }}</p>
                                                </li>
                                                @endif
                                                @if (!empty($list['show']->d3))
                                                <li>
                                                    <i class="feather icon-arrow-right f-w-600 task-icon bg-secondary"></i>
                                                    <h5 class="text-muted">D3 - {{ $list['show']->d3 }}</h5>
                                                    <p class="m-b-5">Lulus pada tahun {{ $list['show']->th_d3 }}</p>
                                                </li>
                                                @endif
                                                @if (!empty($list['show']->d2))
                                                <li>
                                                    <i class="feather icon-arrow-right f-w-600 task-icon bg-secondary"></i>
                                                    <h5 class="text-muted">D2 - {{ $list['show']->d2 }}</h5>
                                                    <p class="m-b-5">Lulus pada tahun {{ $list['show']->th_d2 }}</p>
                                                </li>
                                                @endif
                                                @if (!empty($list['show']->sma))
                                                <li>
                                                    <i class="feather icon-arrow-right f-w-600 task-icon bg-secondary"></i>
                                                    <h5 class="text-muted">{{ $list['show']->sma }}</h5>
                                                    <p class="m-b-5">Lulus pada tahun {{ $list['show']->th_sma }}</p>
                                                </li>
                                                @endif
                                                @if (!empty($list['show']->smp))
                                                <li>
                                                    <i class="feather icon-arrow-right f-w-600 task-icon bg-secondary"></i>
                                                    <h5 class="text-muted">{{ $list['show']->smp }}</h5>
                                                    <p class="m-b-5">Lulus pada tahun {{ $list['show']->th_smp }}</p>
                                                </li>
                                                @endif
                                                @if (!empty($list['show']->sd))
                                                <li>
                                                    <i class="feather icon-arrow-right f-w-600 task-icon bg-secondary"></i>
                                                    <h5 class="text-muted">{{ $list['show']->sd }}</h5>
                                                    <p class="m-b-5">Lulus pada tahun {{ $list['show']->th_sd }}</p>
                                                </li>
                                                @endif
                                            </ul>
                                        @else
                                        -
                                        @endif
                                    </div>
                                </div>
                                {{-- END CEK DATA PENDIDIKAN --}}
                            @endif
                            <div class="card">
                                <div class="card-header">
                                    <h5>Data Kesehatan</h5>
                                </div>
                                <div class="card-body">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item px-0 pt-0">
                                            <p class="mb-1 text-muted">Riwayat Penyakit</p>
                                            <p class="mb-0">{!! $list['show']->riwayat_penyakit?str_replace(array("\r\n", "\r", "\n"),"<br>", $list['show']->riwayat_penyakit):'-' !!}</p>
                                        </li>
                                        <li class="list-group-item px-0">
                                            <p class="mb-1 text-muted">Riwayat Penyakit Keluarga</p>
                                            <p class="mb-0">{!! $list['show']->riwayat_penyakit_keluarga?str_replace(array("\r\n", "\r", "\n"),"<br>", $list['show']->riwayat_penyakit_keluarga):'-' !!}</p>
                                        </li>
                                        <li class="list-group-item px-0">
                                            <p class="mb-1 text-muted">Riwayat Penggunaan Obat</p>
                                            <p class="mb-0">{!! $list['show']->riwayat_penggunaan_obat?str_replace(array("\r\n", "\r", "\n"),"<br>", $list["show"]->riwayat_penggunaan_obat):'-' !!}</p>
                                        </li>
                                        <li class="list-group-item px-0 pb-0">
                                            <p class="mb-1 text-muted">Riwayat Operasi</p>
                                            <p class="mb-0">{!! $list['show']->riwayat_operasi?str_replace(array("\r\n", "\r", "\n"),"<br>", $list['show']->riwayat_operasi):'-' !!}</p>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- FORM KEPEGAWAIAN --}}
                <div class="tab-pane" id="kepegawaian" role="tabpanel" aria-labelledby="profile-tab-2">
                    <div class="card">
                        <div class="card-header d-flex align-items-center justify-content-between py-3">
                            <h5 class="mb-0 card-title flex-grow-1">Kelengkapan Profil Pegawai</h5>
                            <div class="flex-shrink-0">
                                <button type="button" class="btn btn-link-warning" id="btn-refresh-kepegawaian" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true"
                                    title="Segarkan Input Data" onclick="showKepegawaian()">
                                    <i class="fa-fw fas fa-sync nav-icon me-1"></i>Segarkan</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6" @if($list['show']->deleted_at != null) hidden @endif>
                                    <div class="card shadow-none border mb-0 h-100">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1 me-3">
                                                    <h6 class="mb-0">NIP (Nomor Induk Pegawai)</h6>
                                                </div>
                                                <div class="flex-shrink-0">
                                                    <div class="btn-group">
                                                        <button class="btn btn-sm btn-warning" disabled>NIP THL Terakhir : <u id="show_nip_thl_terakhir">000</u></button>
                                                        <button class="btn btn-sm btn-info" disabled>NIP Terakhir : <u id="show_nip_terakhir">000</u></button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3 mt-3">
                                                <div class="alert alert-secondary">
                                                    <i class="ti ti-arrow-narrow-right text-primary me-1"></i> Apabila karyawan baru (Non THL), NIP bersifat otomatis<br>
                                                    <i class="ti ti-arrow-narrow-right text-primary me-1"></i> Format <b>WAJIB</b> NIP <mark><b><u>KHUSUS THL</u></b></mark> adalah <u><b class="text-danger">THL</b></u> . <u><b class="text-warning">Tahun Masuk</b></u> . <u><b class="text-primary">Nomor Urutan</b></u>
                                                                                                                <i class="fas fa-long-arrow-alt-right ms-1 me-2"></i><b><i> (Contoh : THL.25.001)</i></b><br>
                                                    <i class="ti ti-arrow-narrow-right text-primary me-1"></i> Format <b>WAJIB</b> NIP Pegawai adalah <u><b class="text-danger">Tahun Masuk</b></u> . <u><b class="text-warning">Bulan Masuk</b></u> . <u><b class="text-primary">Nomor Urutan</b></u>
                                                                                                                <i class="fas fa-long-arrow-alt-right ms-1 me-2"></i><b><i> (Contoh : 19.12.314)</i></b><br>
                                                    <i class="ti ti-arrow-narrow-right text-primary me-1"></i> Gunakan Titik (.) sebagai pemisah. Tidak Diperbolehkan ada SPASI ' '<br>
                                                    <i class="ti ti-arrow-narrow-right text-primary me-1"></i> Lakukan dengan teliti dan hati-hati dalam pengisian NIP, karena NIP bersifat <b class="text-info">UNIK</b>
                                                </div>
                                                <div class="row">
                                                    <div class="col"><input type="text" class="form-control" id="nip_pgw" maxlength="10" placeholder="Tuliskan NIP Pegawai (Wajib sesuai dengan Format)"></div>
                                                    <div class="col-auto"><button class="btn btn-light-primary" onclick="prosesSimpanNIP()" id="btn-simpan-nip"><i class="fas fa-save me-1"></i> Simpan</button></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6" @if($list['show']->deleted_at != null) hidden @endif>
                                    <div class="card shadow-none border mb-0 h-100">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1 me-3">
                                                    <h6 class="mb-0">Klasifikasi Pegawai</h6>
                                                </div>
                                            </div>
                                            <div class="mb-3 mt-3">
                                                <div class="alert alert-secondary">
                                                    <i class="ti ti-arrow-narrow-right text-primary me-1"></i> Nakes (dokter, perawat, bidan, penata anestesi, dll)<br>
                                                    <i class="ti ti-arrow-narrow-right text-primary me-1"></i> Nakesla (Ahli gizi, Rehab Medik, ATLM, Apoteker, TTK, Radiografer, Rekam Medik)<br>
                                                    <i class="ti ti-arrow-narrow-right text-primary me-1"></i> Non Nakes (Selain Nakes dan Nakesla)
                                                </div>
                                                <div class="row">
                                                    <div class="col"><select class="form-control" id="klasifikasi_pgw"></select></div>
                                                    <div class="col-auto"><button class="btn btn-light-primary" onclick="prosesSimpanKlasifikasiPgw()" id="btn-simpan-klasifikasi"><i class="fas fa-save me-1"></i> Simpan</button></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6" @if($list['show']->deleted_at != null) hidden @endif>
                                    <div class="card shadow-none border mb-0 h-100">
                                        <div class="card-body">
                                            <div class="alert alert-secondary">
                                                <i class="ti ti-arrow-narrow-right text-primary me-1"></i> TMT (Tanggal Mulai Tugas) <span class="text-danger">*</span><br>
                                                <i class="ti ti-arrow-narrow-right text-primary me-1"></i> TAT (Tanggal Akhir Tugas)
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group mb-3">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label class="form-label"><b>TMT</b> <span class="text-danger">*</span></label>
                                                                <input type="date" class="form-control" id="tmt">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label"><b>TAT</b></label>
                                                                <input type="date" class="form-control" id="tat">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-auto"><button class="btn btn-light-primary" onclick="prosesSimpanTattmt()" id="btn-simpan-tattmt"><i class="fas fa-save me-1"></i> Simpan</button></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6" @if($list['show']->deleted_at != null) hidden @endif>
                                    <div class="card shadow-none border mb-0 h-100">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1 me-3">
                                                    <h6 class="mb-0">Profesi Pegawai (<b class="text-info">Sub Klasifikasi</b>)</h6>
                                                </div>
                                            </div>
                                            <div class="mb-3 mt-3">
                                                <div class="alert alert-secondary">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <center><h6>Contoh <mark>Profesi</mark> seperti di bawah ini</h6></center><hr>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <i class="ti ti-arrow-narrow-right text-primary me-1"></i> Dokter<br>
                                                            <i class="ti ti-arrow-narrow-right text-primary me-1"></i> Perawat<br>
                                                            <i class="ti ti-arrow-narrow-right text-primary me-1"></i> Bidan<br>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <i class="ti ti-arrow-narrow-right text-primary me-1"></i> Penata Anestesi<br>
                                                            <i class="ti ti-arrow-narrow-right text-primary me-1"></i> Apoteker<br>
                                                            <i class="ti ti-arrow-narrow-right text-primary me-1"></i> dll
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col"><select class="form-control" id="profesi_pgw"></select></div>
                                                    <div class="col-auto"><button class="btn btn-light-primary" onclick="prosesSimpanProfesiPgw()" id="btn-simpan-profesi"><i class="fas fa-save me-1"></i> Simpan</button></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if ($list['show']->deleted_at != null || $list['show']->status != null)
                                    <div class="col-md-12">
                                        <div class="card shadow-none border mb-0">
                                            <div class="card-body">
                                                <h5 class="mb-0 text-center">Pegawai telah resmi <b class="text-danger">dihapus/dinonaktifkan</b> pada {{ \Carbon\Carbon::parse($list['show']->deleted_at)->isoFormat('dddd, D MMMM Y, HH:mm a') }} Oleh {{ $list['show']->nama_admin }}</h5>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="col-md-12">
                                        <div class="card shadow-none border mb-0">
                                            <div class="card-body">
                                                <h6 class="mb-3">Hapus Akun</h6>
                                                <p class="mb-3">Apakah Anda yakin ingin menghapus akun {{ $list['show']->nama }}?<br>
                                                    Hapus akun dapat mengakibatkan <strong>Pengguna tidak dapat masuk kembali ke dalam sistem</strong> dan berstatus <strong>Non Aktif</strong>.
                                                    Lakukan dengan hati-hati karena data Akun Pengguna/Penghapus akan tercatat sebagai penerima risiko yang ada.
                                                </p>
                                                <button class="btn btn-light-danger" onclick="showHapusPegawai({{ $list['show']->id }})"><i class="fas fa-trash me-1"></i> Hapus Akun</button>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            {{-- <div class="row g-3">
                                <div class="col-md-6 col-xl-4">
                                    <div class="card shadow-none border mb-0">
                                        <div class="card-body">
                                            <h6 class="mb-3 fw-medium">Membership Plan</h6>
                                            <h4 class="mb-3 fw-normal text-muted">Addicted $150</h4><a href="#"
                                                class="link-primary d-flex align-items-center gap-2">See more Plan <i
                                                    class="ti ti-chevron-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xl-4">
                                    <div class="card shadow-none border mb-0">
                                        <div class="card-body">
                                            <h6 class="mb-3 fw-medium">Manage</h6>
                                            <h4 class="mb-3 fw-normal text-muted">Membership</h4><a href="#"
                                                class="link-primary d-flex align-items-center gap-2">Update, Cancel and
                                                more <i class="ti ti-chevron-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-xl-4">
                                    <div class="card shadow-none border mb-0">
                                        <div class="card-body">
                                            <h6 class="mb-3 fw-medium">Renewal Date</h6>
                                            <h4 class="mb-3 fw-normal text-muted">120 November, 2024</h4><a href="#"
                                                class="link-primary d-flex align-items-center gap-2">View payment method
                                                <i class="ti ti-chevron-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>

                {{-- FORM PENETAPAN --}}
                <div class="tab-pane" id="penetapan" role="tabpanel" aria-labelledby="profile-tab-2">
                    <div class="card" @if($list['show']->deleted_at != null) hidden @endif>
                        <div class="card-header d-flex align-items-center justify-content-between py-3">
                            <h5 class="mb-0 card-title flex-grow-1">Penetapan Pegawai</h5>
                            <div class="flex-shrink-0">
                            </div>
                        </div>
                        <div class="card-body p-b-10">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Status Pegawai <span class="text-danger">*</span></label>
                                        <select class="form-control" id="ref_penetapan">
                                            <option value="" selected hidden>Pilih Perubahan Status</option>
                                            @if (count($list['ref_penetapan']) > 0)
                                                @foreach ($list['ref_penetapan'] as $item)
                                                    <option value="{{ $item->id }}">{{ $item->deskripsi }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Tgl. Diberlakukan <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" id="tgl_berlaku_penetapan">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Keterangan</label>
                                        <div class="row">
                                            <div class="col"><textarea id="ket_penetapan" class="form-control" placeholder="Tuliskan Keterangan (Bila Ada)" rows="1"></textarea></div>
                                            <div class="col-auto"><button class="btn btn-primary" onclick="prosesTambahPenetapan()" id="btn-simpan-penetapan"><i class="fas fa-save me-1"></i> Simpan</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card table-card">
                        <div class="card-header d-flex align-items-center justify-content-between py-3">
                            <h5 class="mb-0 card-title flex-grow-1">Tabel Riwayat</h5>
                            <div class="flex-shrink-0">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-link-warning" id="btn-refresh" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true"
                                        title="Refresh Tabel Penetapan Pegawai" onclick="refreshPenetapan()">
                                        <i class="fa-fw fas fa-sync nav-icon me-1"></i>Segarkan</button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-b-0 p-3">
                            <div class="alert alert-secondary">
                                <small>
                                    <i class="ti ti-arrow-narrow-right text-primary me-1"></i> Data record yang dapat di <mark>ubah/hapus</mark> adalah data paling terakhir<br>
                                    <i class="ti ti-arrow-narrow-right text-primary me-1"></i> Penghapusan data akan menonaktifkan data record dan status pegawai akan digantikan oleh data record terakhir apabila terdapat data lebih dari 1
                                </small>
                            </div>
                            <div class="table-responsive">
                                <table id="dttable-penetapan" class="table dt-responsive table-hover w-100 align-middle">
                                    <thead>
                                        <tr>
                                            <th class="cell-fit">#ID</th>
                                            <th class="cell-fit">STATUS</th>
                                            <th class="cell-fit">TGL BERLAKU</th>
                                            <th class="cell-fit">KETERANGAN</th>
                                            <th class="cell-fit">DIPERBARUI</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tampil-tbody-penetapan">
                                        <tr>
                                            <td colspan="10" style="font-size:13px"><center><i class="fa fa-spinner fa-spin fa-fw"></i> Memproses data...</center></td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th class="cell-fit">#ID</th>
                                            <th class="cell-fit">STATUS</th>
                                            <th class="cell-fit">TGL BERLAKU</th>
                                            <th class="cell-fit">KETERANGAN</th>
                                            <th class="cell-fit">DIPERBARUI</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- FORM ROTASI --}}
                <div class="tab-pane" id="rotasi" role="tabpanel" aria-labelledby="profile-tab-2">
                    <div class="card" @if($list['show']->deleted_at != null) hidden @endif>
                        <div class="card-header d-flex align-items-center justify-content-between py-3">
                            <h5 class="mb-0 card-title flex-grow-1">Rotasi Pegawai</h5>
                            <div class="flex-shrink-0">
                            </div>
                        </div>
                        <div class="card-body p-b-10">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Kategori Rotasi <span class="text-danger">*</span></label>
                                        <select class="form-control" id="ref_rotasi">
                                            <option value="" selected hidden>Pilih Kategori Rotasi</option>
                                            @if (count($list['ref_rotasi']) > 0)
                                                @foreach ($list['ref_rotasi'] as $item)
                                                    <option value="{{ $item->id }}">{{ $item->deskripsi }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label for="defaultFormControlInput" class="form-label">Jabatan <span class="text-danger">*</span></label>
                                        <div class="select2-dark mb-2">
                                            <select id="jabatan_rotasi" name="jabatan_rotasi[]" class="select2 form-select" data-bs-auto-close="outside" required multiple="multiple" data-placeholder="Pilih Jabatan ..." style="width: 100%"></select>
                                        </div>
                                        {{-- <sub><i class="ti ti-arrows-up-right text-primary me-1"></i> <u>Refresh Browser</u> apabila jabatan tidak sesuai</sub> --}}
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Tgl. Berlaku <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" id="tgl_berlaku_rotasi">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Keterangan</label>
                                        <div class="row">
                                            <div class="col"><textarea id="ket_rotasi" class="form-control" placeholder="Tuliskan Keterangan (Bila Ada)" rows="1"></textarea></div>
                                            <div class="col-auto"><button class="btn btn-primary" onclick="prosesTambahRotasi()" id="btn-simpan-rotasi"><i class="fas fa-save me-1"></i> Simpan</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card table-card">
                        <div class="card-header d-flex align-items-center justify-content-between py-3">
                            <h5 class="mb-0 card-title flex-grow-1">Tabel Riwayat</h5>
                            <div class="flex-shrink-0">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-link-warning" id="btn-refresh" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true"
                                        title="Refresh Tabel Rotasi Pegawai" onclick="refreshRotasi()">
                                        <i class="fa-fw fas fa-sync nav-icon me-1"></i>Segarkan</button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-b-0 p-3">
                            <div class="alert alert-secondary">
                                <small>
                                    <i class="ti ti-arrow-narrow-right text-primary me-1"></i> Data record yang dapat di <mark>ubah/hapus</mark> adalah data paling terakhir<br>
                                    <i class="ti ti-arrow-narrow-right text-primary me-1"></i> Data terhapus diabaikan dan tidak dapat dikembalikan lagi atau dibatalkan<br>
                                    <i class="ti ti-arrow-narrow-right text-primary me-1"></i> Pembatalan data akan menonaktifkan data record dan rotasi jabatan pegawai pada baris yang dipilih dan akan digantikan oleh data jabatan pada record terakhir apabila terdapat data lebih dari 1
                                </small>
                            </div>
                            <div class="table-responsive">
                                <table id="dttable-rotasi" class="table dt-responsive table-hover w-100 align-middle">
                                    <thead>
                                        <tr>
                                            <th class="cell-fit">#ID</th>
                                            <th class="cell-fit">JENIS ROTASI</th>
                                            <th class="cell-fit">TGL BERLAKU</th>
                                            <th class="cell-fit">SEBELUM</th>
                                            <th class="cell-fit">SESUDAH</th>
                                            <th class="cell-fit">KETERANGAN</th>
                                            <th class="cell-fit">DIPERBARUI</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tampil-tbody-rotasi">
                                        <tr>
                                            <td colspan="10" style="font-size:13px"><center><i class="fa fa-spinner fa-spin fa-fw"></i> Memproses data...</center></td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th class="cell-fit">#ID</th>
                                            <th class="cell-fit">JENIS ROTASI</th>
                                            <th class="cell-fit">TGL BERLAKU</th>
                                            <th class="cell-fit">SEBELUM</th>
                                            <th class="cell-fit">SESUDAH</th>
                                            <th class="cell-fit">KETERANGAN</th>
                                            <th class="cell-fit">DIPERBARUI</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- UBAH DOKUMEN --}}
                <div class="tab-pane" id="dokumen" role="tabpanel" aria-labelledby="dokumen-tab-3">
                    <div class="card table-card">
                        <div class="card-header d-flex align-items-center justify-content-between py-3">
                            <h5 class="mb-0 card-title flex-grow-1">Dokumen Karyawan</h5>
                            <div class="flex-shrink-0">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-link-warning" id="btn-refresh" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true"
                                        title="Refresh Tabel Dokumen" onclick="refreshDokumen()">
                                        <i class="fa-fw fas fa-sync nav-icon me-1"></i>Segarkan</button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table dt-responsive table-hover w-100 align-middle" id="dttable-dokumen">
                                    <thead>
                                        <tr>
                                            <th><center>AKSI</center></th>
                                            <th>DOKUMEN</th>
                                            <th>DESKRIPSI</th>
                                            <th><center>STATUS</center></th>
                                            <th class="text-end">TERAKHIR DIUBAH</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tampil-tbody-dokumen">
                                        <tr>
                                            <td colspan="9" style="font-size:13px">
                                                <center><i class="fa fa-spinner fa-spin fa-fw"></i> Memproses data...</center>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        {{-- <div class="card-footer text-end btn-page">
                            <div class="btn btn-link-danger">Cancel</div>
                            <div class="btn btn-primary">Update Profile</div>
                        </div> --}}
                    </div>
                </div>

                {{-- FORM SPK & RKK --}}
                <div class="tab-pane" id="spkrkk" role="tabpanel" aria-labelledby="profile-tab-2">
                    <div class="card table-card">
                        <div class="card-header d-flex align-items-center justify-content-between py-3">
                            <h5 class="mb-0 card-title flex-grow-1">SPK & RKK</h5>
                            <div class="flex-shrink-0">
                                <button type="button" class="btn btn-link-warning" id="btn-refresh-spkrkk" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true"
                                title="Refresh Tabel SPK & RKK" onclick="refreshSpkRkk()">
                                <i class="fa-fw fas fa-sync nav-icon me-1"></i>Segarkan</button>
                            </div>
                        </div>
                        <div @if($list['show']->deleted_at != null) hidden @endif>
                            <div class="card-body p-b-0 p-3">
                                {{-- <div class="d-flex align-items-center justify-content-between">
                                    <h4 class="mb-0 flex-grow-1"><a class="text-danger">*</a>/2 <small>dokumen wajib sudah terupload.</small></h4>
                                    <div class="flex-shrink-0" id="switch-str" hidden>
                                        <div class="form-check form-switch custom-switch-v1 switch-sm">
                                            <input type="checkbox" class="form-check-input input-primary" id="checkboxseumurhidup">
                                            <label class="form-check-label" for="checkboxseumurhidup">Seumur Hidup ?</label>
                                        </div>
                                    </div>
                                </div>
                                <hr class="my-2"> --}}
                                <div class="row status_true_spkrkk">
                                    <div class="col-md-12">
                                        <div class="alert alert-secondary alert-dismissible fade show mb-3" role="alert">
                                            <center><strong class="mb-0"><i><b class="text-danger">Form ini</b> diisi oleh komite keperawatan, komite nakesla, komite medik, dan Kepegawaian</i></strong></center>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                        <div class="alert alert-secondary alert-dismissible fade show" role="alert">
                                            <small>
                                                <i class="ti ti-arrow-narrow-right text-primary me-1"></i> SPK adalah Surat Penugasan Klinis dan RKK adalah Rincian Kewenangan Klinis<br>
                                                <i class="ti ti-arrow-narrow-right text-primary me-1"></i> Batas maksimum ukuran file yang upload sebesar 3 mb (<b>PDF</b>)<br>
                                                <i class="ti ti-arrow-narrow-right text-primary me-1"></i> SPK / RKK dapat diubah / hapus apabila berstatus <span class="badge rounded-pill text-bg-success p-1">Aktif</span>
                                            </small>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Jenis Dokumen <span class="text-danger">*</span></label>
                                            <select class="form-control" id="jns_spkrkk">
                                                <option value="" selected hidden>Pilih</option>
                                                <option value="0">SPK & RKK</option>
                                                {{-- <option value="1">RKK (Rincian Kewenangan Klinis)</option> --}}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Tgl. Masa Berlaku <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" id="tgl_akhir_spkrkk">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Deskripsi</label>
                                            <textarea id="deskripsi_spkrkk" class="form-control" placeholder="Tuliskan Keterangan (Optional)" rows="1"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Upload Dokumen <span class="text-danger">*</span></label>
                                            <div class="row">
                                                <div class="col"><input type="file" class="form-control" id="upload_spkrkk" accept="application/pdf"></div>
                                                <div class="col-auto"><button class="btn btn-primary" onclick="prosesTambahSpkRkk()" id="btn-upload-spkrkk"><i class="fas fa-upload me-1"></i> Upload</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row status_false_spkrkk" hidden>
                                    <div class="col-md-12">
                                        <div class="alert alert-danger">
                                            <h6 class="text-center mb-0">Dimohon untuk melengkapi Data Status Kepegawaian terlebih dahulu pada <mark>Menu Penetapan</mark> , Silakan <a href="javascript:void(0);" onclick="refreshSpkRkk()"><u>Segarkan</u></a> apabila sudah dilakukan</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body status_true_spkrkk">
                            <div class="table-responsive">
                                <table class="table mb-0 table-hover" id="dttable-spkrkk">
                                    <thead>
                                        <tr>
                                            <th><center>AKSI</center></th>
                                            <th>RECORD</th>
                                            <th>TGL BERAKHIR</th>
                                            <th>DESKRIPSI</th>
                                            <th class="text-end">TERAKHIR DIUBAH</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tampil-tbody-spkrkk">
                                        <tr>
                                            <td colspan="9" style="font-size:13px">
                                                <center><i class="fa fa-spinner fa-spin fa-fw"></i> Memproses data...</center>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- <div class="tab-pane" id="profile-5" role="tabpanel" aria-labelledby="profile-tab-5">
                    <div class="card">
                        <div class="card-header">
                            <h5>Invite Team Members</h5>
                        </div>
                        <div class="card-body">
                            <h4>5/10 <small>members available in your plan.</small></h4>
                            <hr class="my-3">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="mb-3"><label class="form-label">Email Address</label>
                                        <div class="row">
                                            <div class="col"><input type="email" class="form-control"></div>
                                            <div class="col-auto"><button class="btn btn-primary">Send</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body table-card">
                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <thead>
                                        <tr>
                                            <th>MEMBER</th>
                                            <th>ROLE</th>
                                            <th class="text-end">STATUS</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="row">
                                                    <div class="col-auto pe-0"><img
                                                            src="../assets/images/user/avatar-1.jpg"
                                                            alt="user-image" class="wid-40 rounded-circle">
                                                    </div>
                                                    <div class="col">
                                                        <h5 class="mb-0">Addie Bass</h5>
                                                        <p class="text-muted f-12 mb-0"><a
                                                                href="../cdn-cgi/l/email-protection.html"
                                                                class="__cf_email__"
                                                                data-cfemail="1974786b7c6f78597e74787075377a7674">[email&#160;protected]</a>
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><span class="badge bg-primary">Owner</span></td>
                                            <td class="text-end"><span class="badge bg-success">Joined</span>
                                            </td>
                                            <td class="text-end"><a href="javascript:void(0);"
                                                    class="avtar avtar-s btn-link-secondary"><i
                                                        class="ti ti-dots f-18"></i></a></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="row">
                                                    <div class="col-auto pe-0"><img
                                                            src="../assets/images/user/avatar-4.jpg"
                                                            alt="user-image" class="wid-40 rounded-circle">
                                                    </div>
                                                    <div class="col">
                                                        <h5 class="mb-0">Agnes McGee</h5>
                                                        <p class="text-muted f-12 mb-0"><a
                                                                href="../cdn-cgi/l/email-protection.html"
                                                                class="__cf_email__"
                                                                data-cfemail="f59d909794b59298949c99db969a98">[email&#160;protected]</a>
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><span class="badge bg-light-info">Manager</span></td>
                                            <td class="text-end"><a href="javascript:void(0);"
                                                    class="btn btn-link-danger">Resend</a> <span
                                                    class="badge bg-light-success">Invited</span></td>
                                            <td class="text-end"><a href="javascript:void(0);"
                                                    class="avtar avtar-s btn-link-secondary"><i
                                                        class="ti ti-dots f-18"></i></a></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="row">
                                                    <div class="col-auto pe-0"><img
                                                            src="../assets/images/user/avatar-5.jpg"
                                                            alt="user-image" class="wid-40 rounded-circle">
                                                    </div>
                                                    <div class="col">
                                                        <h5 class="mb-0">Agnes McGee</h5>
                                                        <p class="text-muted f-12 mb-0"><a
                                                                href="../cdn-cgi/l/email-protection.html"
                                                                class="__cf_email__"
                                                                data-cfemail="036b66616243646e626a6f2d606c6e">[email&#160;protected]</a>
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><span class="badge bg-light-warning">Staff</span></td>
                                            <td class="text-end"><span class="badge bg-success">Joined</span>
                                            </td>
                                            <td class="text-end"><a href="javascript:void(0);"
                                                    class="avtar avtar-s btn-link-secondary"><i
                                                        class="ti ti-dots f-18"></i></a></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="row">
                                                    <div class="col-auto pe-0"><img
                                                            src="../assets/images/user/avatar-1.jpg"
                                                            alt="user-image" class="wid-40 rounded-circle">
                                                    </div>
                                                    <div class="col">
                                                        <h5 class="mb-0">Addie Bass</h5>
                                                        <p class="text-muted f-12 mb-0"><a
                                                                href="../cdn-cgi/l/email-protection.html"
                                                                class="__cf_email__"
                                                                data-cfemail="6d000c1f081b0c2d0a000c0401430e0200">[email&#160;protected]</a>
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><span class="badge bg-primary">Owner</span></td>
                                            <td class="text-end"><span class="badge bg-success">Joined</span>
                                            </td>
                                            <td class="text-end"><a href="javascript:void(0);"
                                                    class="avtar avtar-s btn-link-secondary"><i
                                                        class="ti ti-dots f-18"></i></a></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="row">
                                                    <div class="col-auto pe-0"><img
                                                            src="../assets/images/user/avatar-4.jpg"
                                                            alt="user-image" class="wid-40 rounded-circle">
                                                    </div>
                                                    <div class="col">
                                                        <h5 class="mb-0">Agnes McGee</h5>
                                                        <p class="text-muted f-12 mb-0"><a
                                                                href="../cdn-cgi/l/email-protection.html"
                                                                class="__cf_email__"
                                                                data-cfemail="ea828f888baa8d878b8386c4898587">[email&#160;protected]</a>
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><span class="badge bg-light-info">Manager</span></td>
                                            <td class="text-end"><a href="javascript:void(0);"
                                                    class="btn btn-link-danger">Resend</a> <span
                                                    class="badge bg-light-success">Invited</span></td>
                                            <td class="text-end"><a href="javascript:void(0);"
                                                    class="avtar avtar-s btn-link-secondary"><i
                                                        class="ti ti-dots f-18"></i></a></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="row">
                                                    <div class="col-auto pe-0"><img
                                                            src="../assets/images/user/avatar-5.jpg"
                                                            alt="user-image" class="wid-40 rounded-circle">
                                                    </div>
                                                    <div class="col">
                                                        <h5 class="mb-0">Agnes McGee</h5>
                                                        <p class="text-muted f-12 mb-0"><a
                                                                href="../cdn-cgi/l/email-protection.html"
                                                                class="__cf_email__"
                                                                data-cfemail="fa929f989bba9d979b9396d4999597">[email&#160;protected]</a>
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><span class="badge bg-light-warning">Staff</span></td>
                                            <td class="text-end"><span class="badge bg-success">Joined</span>
                                            </td>
                                            <td class="text-end"><a href="javascript:void(0);"
                                                    class="avtar avtar-s btn-link-secondary"><i
                                                        class="ti ti-dots f-18"></i></a></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="row">
                                                    <div class="col-auto pe-0"><img
                                                            src="../assets/images/user/avatar-1.jpg"
                                                            alt="user-image" class="wid-40 rounded-circle">
                                                    </div>
                                                    <div class="col">
                                                        <h5 class="mb-0">Addie Bass</h5>
                                                        <p class="text-muted f-12 mb-0"><a
                                                                href="../cdn-cgi/l/email-protection.html"
                                                                class="__cf_email__"
                                                                data-cfemail="7c111d0e190a1d3c1b111d1510521f1311">[email&#160;protected]</a>
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><span class="badge bg-primary">Owner</span></td>
                                            <td class="text-end"><span class="badge bg-success">Joined</span>
                                            </td>
                                            <td class="text-end"><a href="javascript:void(0);"
                                                    class="avtar avtar-s btn-link-secondary"><i
                                                        class="ti ti-dots f-18"></i></a></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="row">
                                                    <div class="col-auto pe-0"><img
                                                            src="../assets/images/user/avatar-4.jpg"
                                                            alt="user-image" class="wid-40 rounded-circle">
                                                    </div>
                                                    <div class="col">
                                                        <h5 class="mb-0">Agnes McGee</h5>
                                                        <p class="text-muted f-12 mb-0"><a
                                                                href="../cdn-cgi/l/email-protection.html"
                                                                class="__cf_email__"
                                                                data-cfemail="cfa7aaadae8fa8a2aea6a3e1aca0a2">[email&#160;protected]</a>
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><span class="badge bg-light-info">Manager</span></td>
                                            <td class="text-end"><a href="javascript:void(0);"
                                                    class="btn btn-link-danger">Resend</a> <span
                                                    class="badge bg-light-success">Invited</span></td>
                                            <td class="text-end"><a href="javascript:void(0);"
                                                    class="avtar avtar-s btn-link-secondary"><i
                                                        class="ti ti-dots f-18"></i></a></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="row">
                                                    <div class="col-auto pe-0"><img
                                                            src="../assets/images/user/avatar-5.jpg"
                                                            alt="user-image" class="wid-40 rounded-circle">
                                                    </div>
                                                    <div class="col">
                                                        <h5 class="mb-0">Agnes McGee</h5>
                                                        <p class="text-muted f-12 mb-0"><a
                                                                href="../cdn-cgi/l/email-protection.html"
                                                                class="__cf_email__"
                                                                data-cfemail="630b06010223040e020a0f4d000c0e">[email&#160;protected]</a>
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><span class="badge bg-light-warning">Staff</span></td>
                                            <td class="text-end"><span class="badge bg-success">Joined</span>
                                            </td>
                                            <td class="text-end"><a href="javascript:void(0);"
                                                    class="avtar avtar-s btn-link-secondary"><i
                                                        class="ti ti-dots f-18"></i></a></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer text-end btn-page">
                            <div class="btn btn-link-danger">Cancel</div>
                            <div class="btn btn-primary">Update Profile</div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="profile-6" role="tabpanel" aria-labelledby="profile-tab-6">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Email Settings</h5>
                                </div>
                                <div class="card-body">
                                    <h6 class="mb-4">Setup Email Notification</h6>
                                    <div class="d-flex align-items-center justify-content-between mb-1">
                                        <div>
                                            <p class="text-muted mb-0">Email Notification</p>
                                        </div>
                                        <div class="form-check form-switch p-0"><input
                                                class="m-0 form-check-input h5 position-relative"
                                                type="checkbox" role="switch" checked=""></div>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between mb-1">
                                        <div>
                                            <p class="text-muted mb-0">Send Copy To Personal Email</p>
                                        </div>
                                        <div class="form-check form-switch p-0"><input
                                                class="m-0 form-check-input h5 position-relative"
                                                type="checkbox" role="switch"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <h5>Updates from System Notification</h5>
                                </div>
                                <div class="card-body">
                                    <h6 class="mb-4">Email you with?</h6>
                                    <div class="d-flex align-items-center justify-content-between mb-1">
                                        <div>
                                            <p class="text-muted mb-0">News about PCT-themes products and
                                                feature updates</p>
                                        </div>
                                        <div class="form-check p-0"><input
                                                class="m-0 form-check-input h5 position-relative"
                                                type="checkbox" role="switch" checked=""></div>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between mb-1">
                                        <div>
                                            <p class="text-muted mb-0">Tips on getting more out of PCT-themes
                                            </p>
                                        </div>
                                        <div class="form-check p-0"><input
                                                class="m-0 form-check-input h5 position-relative"
                                                type="checkbox" role="switch" checked=""></div>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between mb-1">
                                        <div>
                                            <p class="text-muted mb-0">Things you missed since you last logged
                                                into PCT-themes</p>
                                        </div>
                                        <div class="form-check p-0"><input
                                                class="m-0 form-check-input h5 position-relative"
                                                type="checkbox" role="switch"></div>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between mb-1">
                                        <div>
                                            <p class="text-muted mb-0">News about products and other services
                                            </p>
                                        </div>
                                        <div class="form-check p-0"><input
                                                class="m-0 form-check-input h5 position-relative"
                                                type="checkbox" role="switch"></div>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between mb-1">
                                        <div>
                                            <p class="text-muted mb-0">Tips and Document business products</p>
                                        </div>
                                        <div class="form-check p-0"><input
                                                class="m-0 form-check-input h5 position-relative"
                                                type="checkbox" role="switch"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Activity Related Emails</h5>
                                </div>
                                <div class="card-body">
                                    <h6 class="mb-4">When to email?</h6>
                                    <div class="d-flex align-items-center justify-content-between mb-1">
                                        <div>
                                            <p class="text-muted mb-0">Have new notifications</p>
                                        </div>
                                        <div class="form-check form-switch p-0"><input
                                                class="m-0 form-check-input h5 position-relative"
                                                type="checkbox" role="switch" checked=""></div>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between mb-1">
                                        <div>
                                            <p class="text-muted mb-0">You're sent a direct message</p>
                                        </div>
                                        <div class="form-check form-switch p-0"><input
                                                class="m-0 form-check-input h5 position-relative"
                                                type="checkbox" role="switch"></div>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between mb-1">
                                        <div>
                                            <p class="text-muted mb-0">Someone adds you as a connection</p>
                                        </div>
                                        <div class="form-check form-switch p-0"><input
                                                class="m-0 form-check-input h5 position-relative"
                                                type="checkbox" role="switch" checked=""></div>
                                    </div>
                                    <hr class="my-4 border border-secondary-subtle">
                                    <h6 class="mb-4">When to escalate emails?</h6>
                                    <div class="d-flex align-items-center justify-content-between mb-1">
                                        <div>
                                            <p class="text-muted mb-0">Upon new order</p>
                                        </div>
                                        <div class="form-check form-switch p-0"><input
                                                class="m-0 form-check-input h5 position-relative"
                                                type="checkbox" role="switch" checked=""></div>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between mb-1">
                                        <div>
                                            <p class="text-muted mb-0">New membership approval</p>
                                        </div>
                                        <div class="form-check form-switch p-0"><input
                                                class="m-0 form-check-input h5 position-relative"
                                                type="checkbox" role="switch"></div>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between mb-1">
                                        <div>
                                            <p class="text-muted mb-0">Member registration</p>
                                        </div>
                                        <div class="form-check form-switch p-0"><input
                                                class="m-0 form-check-input h5 position-relative"
                                                type="checkbox" role="switch" checked=""></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 text-end btn-page">
                            <div class="btn btn-outline-secondary">Cancel</div>
                            <div class="btn btn-primary">Update Profile</div>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div><!-- [ sample-page ] end -->
    </div><!-- [ Main Content ] end -->

    {{-- MODAL AREA ----------------------------------------------------------------------------------------------------------------------------------------------------- --}}
    {{-- FORM MODAL UBAH --}}
    <div class="modal fade animate__animated animate__rubberBand" id="ubahDokumen" role="dialog" aria-labelledby="confirmFormLabel"aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        Form Ubah Dokumen&nbsp;&nbsp;&nbsp;
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="text" id="id_edit_dokumen" hidden>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label class="form-label">Jenis Surat <span class="text-danger">*</span></label>
                                <select class="form-control" id="jenis_dokumen_edit"></select>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group mb-3">
                                <label class="form-label">Nomor Surat <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="no_surat_dokumen_edit">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Tgl. Mulai Berlaku <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="tgl_mulai_dokumen_edit">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Tgl. Berakhir Surat <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="tgl_akhir_dokumen_edit">
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group mb-3">
                                <label class="form-label">Deskripsi</label>
                                <textarea id="deskripsi_dokumen_edit" class="form-control" placeholder="" rows="1"></textarea>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label">Nama File Dokumen</label>
                            <div class="alert alert-secondary">
                                <a id="lampiran_edit"></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" id="btn-ubah-dokumen" onclick="prosesUbahDokumen()"><i class="fa-fw fas fa-edit nav-icon"></i> Ubah</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fa-fw fas fa-times nav-icon"></i> Tutup</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade animate__animated animate__rubberBand" id="ubahPenetapan" role="dialog" aria-labelledby="confirmFormLabel"aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        Form Ubah Penetapan Pegawai&nbsp;&nbsp;&nbsp;<span class="badge text-bg-primary p-1" id="show_id_penetapan"></span>
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="text" id="id_edit_penetapan" hidden>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label class="form-label">Status Pegawai <span class="text-danger">*</span></label>
                                <select class="form-control" id="ref_penetapan_edit"></select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label class="form-label">Tgl. Diberlakukan <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="tgl_berlaku_penetapan_edit">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Keterangan</label>
                                <div class="row">
                                    <div class="col">
                                        <textarea id="ket_penetapan_edit" class="form-control" placeholder="Tuliskan Keterangan (Bila Ada)" rows="1"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" id="btn-ubah-penetapan" onclick="prosesUbahPenetapan()"><i class="fa-fw fas fa-edit nav-icon"></i> Ubah</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fa-fw fas fa-times nav-icon"></i> Tutup</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade animate__animated animate__rubberBand" id="ubahRotasi" role="dialog" aria-labelledby="confirmFormLabel"aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        Form Ubah Rotasi Jabatan Pegawai&nbsp;&nbsp;&nbsp;<span class="badge text-bg-primary p-1" id="show_id_rotasi"></span>
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="text" id="id_edit_rotasi" hidden>
                    <div class="row"> </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" id="btn-ubah-rotasi" onclick="prosesUbahRotasi()"><i class="fa-fw fas fa-edit nav-icon"></i> Ubah</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fa-fw fas fa-times nav-icon"></i> Tutup</button>
                </div>
            </div>
        </div>
    </div>

    {{-- FORM MODAL HAPUS --}}
    <div class="modal animate__animated animate__rubberBand fade" id="hapusPegawai" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-simple modal-add-new-address modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        Form Hapus Pegawai
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="text" id="id_hapus_pegawai" hidden>
                    <p style="text-align: justify;">
                        Apakah Anda yakin ingin <b>menghapus/menonaktifkan</b> Pegawai dengan <kbd>ID:<a id="show_id_pegawai"></a></kbd> ? <br>
                        Data pegawai yang terlah terhapus masih dapat dilihat pada riwayat pegawai (Tidak berarti terhapus permanen). <br><br>Ceklis dibawah untuk melanjutkan penghapusan.</p>
                    <label class="switch">
                        <input type="checkbox" class="switch-input" id="setujuhapuspegawai">
                        <span class="switch-toggle-slider">
                        <span class="switch-on"></span>
                        <span class="switch-off"></span>
                        </span>
                        <span class="switch-label">Anda siap menerima Risiko</span>
                    </label>
                </div>
                <div class="col-12 text-center mb-4">
                    <button type="submit" id="btn-hapus-pegawai" class="btn btn-danger me-sm-3 me-1" onclick="prosesHapusPegawai()"><i class="fa fa-trash me-1" style="font-size:13px"></i> Hapus</button>
                    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-times me-1" style="font-size:13px"></i> Batal</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal animate__animated animate__rubberBand fade" id="hapusDokumen" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-simple modal-add-new-address modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        Form Hapus&nbsp;&nbsp;&nbsp;
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="text" id="id_hapus_dokumen" hidden>
                    <p style="text-align: justify;">Anda akan menghapus berkas dokumen tersebut. Penghapusan berkas akan menyebabkan hilangnya data/dokumen yang terhapus tersebut pada Storage Sistem.
                        Maka dari itu, lakukanlah dengan hati-hati. Ceklis dibawah untuk melanjutkan penghapusan.</p>
                    <label class="switch">
                        <input type="checkbox" class="switch-input" id="setujuhapusdokumen">
                        <span class="switch-toggle-slider">
                        <span class="switch-on"></span>
                        <span class="switch-off"></span>
                        </span>
                        <span class="switch-label">Anda siap menerima Risiko</span>
                    </label>
                </div>
                <div class="col-12 text-center mb-4">
                    <button type="submit" id="btn-hapus-dokumen" class="btn btn-danger me-sm-3 me-1" onclick="prosesHapusDokumen()"><i class="fa fa-trash me-1" style="font-size:13px"></i> Hapus</button>
                    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-times me-1" style="font-size:13px"></i> Batal</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal animate__animated animate__rubberBand fade" id="hapusPenetapan" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-simple modal-add-new-address modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        Form Hapus Status Pegawai
                    </h4>
                </div>
                <div class="modal-body">
                    <input type="text" id="id_hapus_penetapan" hidden>
                    <p style="text-align: justify;">Anda akan menghapus <strong>Status Pegawai</strong> tersebut.
                        Status pegawai akan diambilkan dari data terakhir yang sudah ada dan apabila baru pertama kali (satu-satunya data) yang dimasukkan akan mengakibatkan
                        status pegawai menjadi kosong. Maka dari itu, lakukanlah dengan hati-hati. Ceklis dibawah untuk melanjutkan penghapusan.</p>
                    <label class="switch">
                        <input type="checkbox" class="switch-input" id="setujuhapuspenetapan">
                        <span class="switch-toggle-slider">
                        <span class="switch-on"></span>
                        <span class="switch-off"></span>
                        </span>
                        <span class="switch-label">Anda siap menerima Risiko</span>
                    </label>
                </div>
                <div class="col-12 text-center mb-4">
                    <button type="submit" id="btn-hapus-penetapan" class="btn btn-danger me-sm-3 me-1" onclick="prosesHapusPenetapan()"><i class="fa fa-trash me-1" style="font-size:13px"></i> Hapus</button>
                    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-times me-1" style="font-size:13px"></i> Batal</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal animate__animated animate__rubberBand fade" id="hapusRotasi" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-simple modal-add-new-address modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        Form Batal Rotasi Pegawai
                    </h4>
                </div>
                <div class="modal-body">
                    <input type="text" id="id_hapus_rotasi" hidden>
                    <p style="text-align: justify;">Anda akan menonaktifkan/membatalkan <strong>Data Rotasi Pegawai</strong> dari database.
                        Pembatalan data akan berpengaruh pada jabatan dan akses pengguna saat ini, apabila data baru pertama kali masuk (satu-satunya data)
                        yang dimasukkan akan mengakibatkan jabatan menjadi kosong pada database. Maka dari itu, lakukanlah dengan hati-hati. Ceklis dibawah untuk melanjutkan penonaktifan.</p>
                    <label class="switch">
                        <input type="checkbox" class="switch-input" id="setujuhapusrotasi">
                        <span class="switch-toggle-slider">
                        <span class="switch-on"></span>
                        <span class="switch-off"></span>
                        </span>
                        <span class="switch-label">Anda siap menerima Risiko</span>
                    </label>
                </div>
                <div class="col-12 text-center mb-4">
                    <button type="submit" id="btn-hapus-rotasi" class="btn btn-danger me-sm-3 me-1" onclick="prosesHapusRotasi()"><i class="ti ti-arrow-back-up me-1" style="font-size:13px"></i> Batalkan</button>
                    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-times me-1" style="font-size:13px"></i> Batal</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal animate__animated animate__rubberBand fade" id="hapusSpkRkk" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-simple modal-add-new-address modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        Form Hapus SPK / RKK Pegawai
                    </h4>
                </div>
                <div class="modal-body">
                    <input type="text" id="id_hapus_spkrkk" hidden>
                    <p style="text-align: justify;">Anda akan menghapus <strong>Data SPK / RKK</strong> <kbd>ID:<a id="show_id_hapusspkrkk"></a></kbd> dari database.
                        Penghapusan data akan menghapus data record pada database dan menghapus file pada storage system. Maka dari itu, lakukanlah dengan hati-hati. Ceklis dibawah untuk melanjutkan penonaktifan.</p>
                    <label class="switch">
                        <input type="checkbox" class="switch-input" id="setujuhapusspkrkk">
                        <span class="switch-toggle-slider">
                        <span class="switch-on"></span>
                        <span class="switch-off"></span>
                        </span>
                        <span class="switch-label">Anda siap menerima Risiko</span>
                    </label>
                </div>
                <div class="col-12 text-center mb-4">
                    <button type="submit" id="btn-hapus-spkrkk" class="btn btn-danger me-sm-3 me-1" onclick="prosesHapusSpkRkk()"><i class="fas fa-trash me-1" style="font-size:13px"></i> Hapus</button>
                    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-times me-1" style="font-size:13px"></i> Batal</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        addEventListener("DOMContentLoaded", (event) => {
            // "use strict";

            // SELECT2
            var t = $(".select2");
            t.length && t.each(function() {
                var e = $(this);
                e.wrap('<div class="position-relative"></div>').select2({
                    placeholder: "Pilih",
                    dropdownParent: e.parent()
                })
            });

            $('#name').on('change', function() {
                $('#btn-simpan-jabatan').prop('disabled',true);
            });

            $('#jns_spkrkk').on('change', function() {
                console.log($('#validasi_tgl_akhir_spkrkk').val());
                if ($(this).val() == 0) {
                    $('#wajib_tgl_akhir_spkrkk').prop('hidden',false);
                    $('#tgl_akhir_spkrkk').prop('disabled',false);
                } else {
                    $('#wajib_tgl_akhir_spkrkk').prop('hidden',true);
                    $('#tgl_akhir_spkrkk').prop('disabled',true);
                }
            });

            // inisialisasi table
                // showKepegawaian();
                // refreshPenetapan();
                // refreshRotasi();
                // refreshDokumen();
                // refreshSpkRkk();
        });

        // ALL FUNCTION AREA
        function verifName() {
            var name = $("#name").val();
            $.ajax({
                url: "/api/hakakses/akunpengguna/verif/" + name,
                type: 'GET',
                dataType: 'json', // added data type
                success: function(res) {
                    if (res === 1) {
                        iziToast.error({
                            title: 'Pesan Galat!',
                            message: 'Mohon maaf, username sudah ada, silakan coba lagi dengan username yang berbeda',
                            position: 'topRight'
                        });
                    } else {
                        iziToast.success({
                            title: 'Pesan Sukses!',
                            message: 'Username dapat digunakan',
                            position: 'topRight'
                        });
                        $("#btn-simpan-jabatan").prop('disabled', false);
                    }
                },
                error: function(res) {
                    iziToast.error({
                        title: 'Pesan Galat!',
                        message: 'Mohon maaf, username sudah ada, silakan coba lagi dengan username yang berbeda',
                        position: 'topRight'
                    });
                }
            });
        }
        function showKepegawaian() {
            $("#nip_pgw").val('');
            $("#klasifikasi_pgw").val('');
            $.ajax({
                url: "/api/profilkaryawan/kepegawaian/{{ $list['show']->id }}",
                type: 'GET',
                dataType: 'json', // added data type
                success: function(res) {
                    $("#show_nip_terakhir").text(res.maxNip);
                    $("#show_nip_thl_terakhir").text(res.maxNipThl);
                    if (res.show) {
                        $("#nip_pgw").val(res.show.nip?res.show.nip:'');
                        $("#show_nip_after").text(res.show.nip? res.show.nip : '-');
                        $("#tmt").val(res.show.tmt);
                        if (res.show.tat) {
                            $("#tat").val(res.show.tat);
                        }
                        $("#klasifikasi_pgw").find('option').remove();
                        res.ref_klasifikasi.forEach(item => {
                            $("#klasifikasi_pgw").append(`<option value="" hidden>Pilih Salah Satu</option>`);
                            $("#klasifikasi_pgw").append(`
                                <option value="${item.id}" ${item.id == res.show.ref_profesi? "selected":""}>${item.deskripsi}</option>
                            `);
                        });
                        $("#profesi_pgw").find('option').remove();
                        res.ref_subprofesi.forEach(item => {
                            $("#profesi_pgw").append(`<option value="" hidden>Pilih Salah Satu</option>`);
                            $("#profesi_pgw").append(`
                                <option value="${item.id}" ${item.id == res.show.ref_subprofesi? "selected":""}>${item.deskripsi}</option>
                            `);
                        });
                    }
                },
                error: function(res) {
                    console.log("error : " + JSON.stringify(res) );
                    iziToast.error({
                        title: 'Pesan Galat!',
                        message: res.responseJSON,
                        position: 'topRight'
                    });
                }
            });
        }
        function prosesSimpanNIP() {
            $("#btn-simpan-nip").prop('disabled', true);
            $("#btn-simpan-nip").find("i").toggleClass("fa-save fa-sync fa-spin");

            var fd = new FormData();

            // ISIAN FORM WAJIB
            var nip = $('#nip_pgw').val();

            if (nip == '') {
                iziToast.warning({
                    title: 'Pesan Ambigu!',
                    message: 'Masukkan NIP terlebih dahulu',
                    position: 'topRight'
                });
            } else {
                if (nip.length < 9) {
                    iziToast.warning({
                        title: 'Pesan Ambigu!',
                        message: 'Format NIP tidak valid, gunakan <strong>Titik (<b class="text-primary">.</b>)</strong> untuk memisahkan Tahun/Bulan Masuk dan No.Urut Pegawai',
                        position: 'topRight'
                    });
                } else {
                    // INISIALISASI
                    fd.append('nip',nip);
                    fd.append('user_id','{{ Auth::user()->id }}');
                    fd.append('pegawai_id','{{ $list["show"]->id }}');

                    // AJAX REQUEST
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: "/api/profilkaryawan/kepegawaian/nip/simpan",
                        method: 'post',
                        data: fd,
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                        success: function(res){
                            iziToast.success({
                                title: 'Pesan Sukses!',
                                message: 'NIP Pegawai berhasil disimpan pada '+res,
                                position: 'topRight'
                            });
                            if (res) {
                                showKepegawaian();
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
            }

            $("#btn-simpan-nip").find("i").removeClass("fa-sync fa-spin").addClass("fa-save");
            $("#btn-simpan-nip").prop('disabled', false);
        }
        function prosesSimpanKlasifikasiPgw() {
            $("#btn-simpan-klasifikasi").prop('disabled', true);
            $("#btn-simpan-klasifikasi").find("i").toggleClass("fa-save fa-sync fa-spin");

            var fd = new FormData();

            // ISIAN FORM WAJIB
            var ref_profesi = $('#klasifikasi_pgw').val();

            if (ref_profesi == '') {
                iziToast.warning({
                    title: 'Pesan Ambigu!',
                    message: 'Pilih klasifikasi pegawai terlebih dahulu',
                    position: 'topRight'
                });
            } else {
                // INISIALISASI
                fd.append('ref_profesi',ref_profesi);
                fd.append('user_id','{{ Auth::user()->id }}');
                fd.append('pegawai_id','{{ $list["show"]->id }}');

                // AJAX REQUEST
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "/api/profilkaryawan/kepegawaian/klasifikasi/simpan",
                    method: 'post',
                    data: fd,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(res){
                        iziToast.success({
                            title: 'Pesan Sukses!',
                            message: 'Klasifikasi pegawai berhasil disimpan pada '+res,
                            position: 'topRight'
                        });
                        if (res) {
                            showKepegawaian();
                        }
                    },
                    error: function(res){
                        console.log("error : " + JSON.stringify(res) );
                        iziToast.error({
                            title: 'Pesan Galat!',
                            message: res.responseJSON,
                            position: 'topRight'
                        });
                    }
                });
            }

            $("#btn-simpan-klasifikasi").find("i").removeClass("fa-sync fa-spin").addClass("fa-save");
            $("#btn-simpan-klasifikasi").prop('disabled', false);
        }
        function prosesSimpanTattmt() {
            $("#btn-simpan-tattmt").prop('disabled', true);
            $("#btn-simpan-tattmt").find("i").toggleClass("fa-save fa-sync fa-spin");

            var fd = new FormData();

            // ISIAN FORM WAJIB
            var tmt = $('#tmt').val();
            var tat = $('#tat').val();

            if (tmt == '') {
                iziToast.warning({
                    title: 'Pesan Ambigu!',
                    message: 'Masukkan Input TMT (Tanggal Mulai Tugas)',
                    position: 'topRight'
                });
            } else {
                // INISIALISASI
                fd.append('tmt',tmt);
                fd.append('tat',tat);
                fd.append('user_id','{{ Auth::user()->id }}');
                fd.append('pegawai_id','{{ $list["show"]->id }}');

                // AJAX REQUEST
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "/api/profilkaryawan/kepegawaian/tattmt/simpan",
                    method: 'post',
                    data: fd,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(res){
                        iziToast.success({
                            title: 'Pesan Sukses!',
                            message: 'TMT / TAT pegawai berhasil disimpan pada '+res,
                            position: 'topRight'
                        });
                        if (res) {
                            showKepegawaian();
                        }
                    },
                    error: function(res){
                        console.log("error : " + JSON.stringify(res) );
                        iziToast.error({
                            title: 'Pesan Galat!',
                            message: res.responseJSON,
                            position: 'topRight'
                        });
                    }
                });
            }

            $("#btn-simpan-tattmt").find("i").removeClass("fa-sync fa-spin").addClass("fa-save");
            $("#btn-simpan-tattmt").prop('disabled', false);
        }
        function prosesSimpanProfesiPgw() {
            $("#btn-simpan-profesi").prop('disabled', true);
            $("#btn-simpan-profesi").find("i").toggleClass("fa-save fa-sync fa-spin");

            var fd = new FormData();

            // ISIAN FORM WAJIB
            var ref_subprofesi = $('#profesi_pgw').val();

            if (ref_subprofesi == '') {
                iziToast.warning({
                    title: 'Pesan Ambigu!',
                    message: 'Pilih Profesi pegawai terlebih dahulu',
                    position: 'topRight'
                });
            } else {
                // INISIALISASI
                fd.append('ref_subprofesi',ref_subprofesi);
                fd.append('user_id','{{ Auth::user()->id }}');
                fd.append('pegawai_id','{{ $list["show"]->id }}');

                // AJAX REQUEST
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "/api/profilkaryawan/kepegawaian/profesi/simpan",
                    method: 'post',
                    data: fd,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(res){
                        iziToast.success({
                            title: 'Pesan Sukses!',
                            message: 'Profesi Pegawai (Sub Klasifikasi) berhasil disimpan pada '+res,
                            position: 'topRight'
                        });
                        if (res) {
                            showKepegawaian();
                        }
                    },
                    error: function(res){
                        console.log("error : " + JSON.stringify(res) );
                        iziToast.error({
                            title: 'Pesan Galat!',
                            message: res.responseJSON,
                            position: 'topRight'
                        });
                    }
                });
            }

            $("#btn-simpan-profesi").find("i").removeClass("fa-sync fa-spin").addClass("fa-save");
            $("#btn-simpan-profesi").prop('disabled', false);
        }

        // FUNCTION TAMBAH
        function prosesTambahPenetapan() {
            $("#btn-simpan-penetapan").prop('disabled', true);
            $("#btn-simpan-penetapan").find("i").toggleClass("fa-save fa-sync fa-spin");

            var fd = new FormData();

            // ISIAN FORM WAJIB
            var ref_id = $('#ref_penetapan').val();
            var tgl_berlaku = $('#tgl_berlaku_penetapan').val();
            var ket = $('#ket_penetapan').val();

            if (ref_id == '' || tgl_berlaku == '') {
                iziToast.warning({
                    title: 'Pesan Ambigu!',
                    message: 'Mohon lengkapi semua data (<span class="text-danger">*</span>) terlebih dahulu dan pastikan tidak ada yang kosong',
                    position: 'topRight'
                });
            } else {
                // INISIALISASI
                fd.append('ref_id',ref_id);
                fd.append('tgl_berlaku',tgl_berlaku);
                fd.append('ket',ket);
                fd.append('user_id','{{ Auth::user()->id }}');
                fd.append('pegawai_id','{{ $list["show"]->id }}');

                // AJAX REQUEST
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "/api/profilkaryawan/penetapan/tambah",
                    method: 'post',
                    data: fd,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(res){
                        iziToast.success({
                            title: 'Pesan Sukses!',
                            message: 'Status Pegawai berhasil ditambahkan pada '+res,
                            position: 'topRight'
                        });
                        if (res) {
                            refreshPenetapan();
                        }
                        // console.log(fd)
                    },
                    error: function(res){
                        console.log("error : " + JSON.stringify(res) );
                        iziToast.error({
                            title: 'Pesan Galat!',
                            message: res.responseJSON,
                            position: 'topRight'
                        });
                    }
                });
            }

            $("#btn-simpan-penetapan").find("i").removeClass("fa-sync fa-spin").addClass("fa-save");
            $("#btn-simpan-penetapan").prop('disabled', false);
        }

        function prosesTambahRotasi() {
            $("#btn-simpan-rotasi").prop('disabled', true);
            $("#btn-simpan-rotasi").find("i").toggleClass("fa-save fa-sync fa-spin");

            var fd = new FormData();

            // ISIAN FORM WAJIB
            var ref_id = $('#ref_rotasi').val();
            var jabatan = $('#jabatan_rotasi').val();
            var tgl_berlaku = $('#tgl_berlaku_rotasi').val();
            var ket = $('#ket_rotasi').val();

            if (ref_id == '' || jabatan == '' || tgl_berlaku == '') {
                iziToast.warning({
                    title: 'Pesan Ambigu!',
                    message: 'Mohon lengkapi semua data (<span class="text-danger">*</span>) terlebih dahulu dan pastikan tidak ada yang kosong',
                    position: 'topRight'
                });
            } else {
                // INISIALISASI
                fd.append('ref_id',ref_id);
                fd.append('jabatan',JSON.stringify(jabatan));
                fd.append('tgl_berlaku',tgl_berlaku);
                fd.append('ket',ket);
                fd.append('user_id','{{ Auth::user()->id }}');
                fd.append('pegawai_id','{{ $list["show"]->id }}');

                // AJAX REQUEST
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "/api/profilkaryawan/rotasi/tambah",
                    method: 'post',
                    data: fd,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(res){
                        iziToast.success({
                            title: 'Pesan Sukses!',
                            message: 'Rotasi Jabatan Pegawai berhasil diperbarui pada '+res,
                            position: 'topRight'
                        });
                        if (res) {
                            refreshRotasi();
                        }
                    },
                    error: function(res){
                        console.log("error : " + JSON.stringify(res) );
                        iziToast.error({
                            title: 'Pesan Galat!',
                            message: res.responseJSON,
                            position: 'topRight'
                        });
                    }
                });
            }

            $("#btn-simpan-rotasi").find("i").removeClass("fa-sync fa-spin").addClass("fa-save");
            $("#btn-simpan-rotasi").prop('disabled', false);
        }

        function prosesTambahSpkRkk() {
            $("#btn-upload-spkrkk").prop('disabled', true);
            $("#btn-upload-spkrkk").find("i").toggleClass("fa-upload fa-sync fa-spin");

            // ISIAN FORM WAJIB
            var jns_spkrkk = $('#jns_spkrkk').val();
            var tgl_akhir_spkrkk = $('#tgl_akhir_spkrkk').val();
            var deskripsi_spkrkk = $('#deskripsi_spkrkk').val();
            var filesAdded = $('#upload_spkrkk')[0].files;

            // EXECUTE
            if (jns_spkrkk == '' || tgl_akhir_spkrkk == '' || filesAdded.length == 0) {
                iziToast.warning({
                    title: 'Pesan Ambigu!',
                    message: 'Mohon lengkapi semua data (<span class="text-danger">*</span>) terlebih dahulu dan pastikan tidak ada yang kosong',
                    position: 'topRight'
                });
            } else {
                // INISIALISASI
                var fd = new FormData();
                fd.append('jns_dokumen',jns_spkrkk);
                fd.append('deskripsi',deskripsi_spkrkk);
                fd.append('tgl_berakhir',tgl_akhir_spkrkk);
                fd.append('user_id','{{ Auth::user()->id }}');
                fd.append('pegawai_id','{{ $list["show"]->id }}');
                fd.append('file',filesAdded[0]);

                // AJAX REQUEST
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "/api/profilkaryawan/spkrkk/tambah",
                    method: 'post',
                    data: fd,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(res){
                        iziToast.success({
                            title: 'Pesan Sukses!',
                            message: 'SPK & RKK Pegawai berhasil diupload pada '+res,
                            position: 'topRight'
                        });
                        if (res) {
                            refreshSpkRkk();
                        }
                    },
                    error: function(res){
                        console.log("error : " + JSON.stringify(res) );
                        iziToast.error({
                            title: 'Pesan Galat!',
                            message: res.responseJSON,
                            position: 'topRight'
                        });
                    }
                });
            }

            $("#btn-upload-spkrkk").find("i").removeClass("fa-sync fa-spin").addClass("fa-upload");
            $("#btn-upload-spkrkk").prop('disabled', false);
        }

        // SHOW UBAH
        function showUbahPenetapan(id) {
            $.ajax(
            {
                url: "/api/profilkaryawan/penetapan/ubah/"+id,
                type: 'GET',
                dataType: 'json', // added data type
                success: function(res) {
                    $("#show_id_penetapan").text('ID : '+id);
                    $("#id_edit_penetapan").val(id);
                    $("#ref_penetapan_edit").find('option').remove();
                    res.ref_penetapan.forEach(item => {
                        $("#ref_penetapan_edit").append(`
                            <option value="${item.id}" ${item.id == res.show.ref_id? "selected":""}>${item.deskripsi}</option>
                        `);
                    });
                    $('#tgl_berlaku_penetapan_edit').val(res.show.tgl_berlaku);
                    $('#ket_penetapan_edit').val(res.show.keterangan);
                    $('#ubahPenetapan').modal('show');
                }
            })
        }

        // PROSES UBAH
        function prosesUbahPenetapan()
        {
            $("#btn-ubah-penetapan").prop('disabled', true);
            $("#btn-ubah-penetapan").find("i").toggleClass("fa-edit fa-sync fa-spin");

            var jenis       = $("#ref_penetapan_edit").val();
            var tgl_berlaku = $("#tgl_berlaku_penetapan_edit").val();
            var keterangan  = $("#ket_penetapan_edit").val();

            if (jenis == "" || tgl_berlaku == "") {
                iziToast.warning({
                    title: 'Pesan Ambigu!',
                    message: 'Mohon lengkapi kolom pengisian wajib *',
                    position: 'topRight'
                });
            } else {
                var fd = new FormData();
                var id_edit = $("#id_edit_penetapan").val();

                fd.append('id',id_edit);
                fd.append('ref_id',jenis);
                fd.append('tgl_berlaku',tgl_berlaku);
                fd.append('keterangan',keterangan);
                fd.append('user_id','{{ Auth::user()->id }}');

                // AJAX request
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "/api/profilkaryawan/penetapan/ubah/"+id_edit+"/proses",
                    method: 'post',
                    data: fd,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(res){
                        iziToast.success({
                            title: 'Pesan Sukses!',
                            message: 'Status pegawai berhasil diperbarui pada '+res,
                            position: 'topRight'
                        });
                        if (res) {
                            $('#ubahPenetapan').modal('hide');
                            refreshPenetapan();
                        }
                    },
                    error: function(res){
                        console.log("error : " + JSON.stringify(res) );
                    }
                });
            }

            $("#btn-ubah-penetapan").find("i").removeClass("fa-sync fa-spin").addClass("fa-edit");
            $("#btn-ubah-penetapan").prop('disabled', false);
        }

        // PROSES REFRESH
        function refreshPenetapan() {
            var ref_id      = $("#ref_penetapan");
            var tgl_berlaku = $("#tgl_berlaku_penetapan");
            var ket         = $("#ket_penetapan");

            // INIT
            ref_id.val('');
            tgl_berlaku.val('');
            ket.val('');

            // MULAI TABEL
            $("#tampil-tbody-penetapan").empty();
            $("#tampil-tbody-penetapan").empty().append(`<tr><td colspan="9" style="font-size:13px"><center><i class="fa fa-spinner fa-spin fa-fw"></i> Memproses data...</center></td></tr>`);
            $.ajax(
                {
                    url: "/api/profilkaryawan/penetapan/table/{{ $list['show']->id }}",
                    type: 'GET',
                    dataType: 'json', // added data type
                    success: function(res) {
                        var adminID = "{{ Auth::user()->getManyRole(['it','kabag-kepegawaian']) }}";
                        var bgHapus = null;
                        // var userID = "{{ Auth::user()->id }}";
                        $("#tampil-tbody-penetapan").empty();
                        $('#dttable-penetapan').DataTable().clear().destroy();
                        res.show.forEach(item => {
                            content = "<tr id='data"+ item.id +"'>";
                            content += `<td><center><div class='dropend'><a href='javascript:void(0);' class='btn ${item.status==0?'btn-light':'btn-light-primary'} btn-sm font-size-16 rounded' data-bs-toggle='dropdown' aria-haspopup="true"><i class="ti ti-dots"></i></a><div class='dropdown-menu'>`;
                                if (item.status == 0) {
                                    content += `<a href='javascript:void(0);' class='dropdown-item text-secondary'><i class='fas fa-edit me-1'></i> Ubah</a>`;
                                    content += `<a href='javascript:void(0);' class='dropdown-item text-secondary'><i class='fas fa-trash me-1'></i> Hapus</a>`;
                                } else {
                                    content += `<a href='javascript:void(0);' class='dropdown-item text-warning' onclick="showUbahPenetapan(`+item.id+`)" value="animate__rubberBand"><i class='fas fa-edit me-1'></i> Ubah</a>`;
                                    content += `<a href='javascript:void(0);' class='dropdown-item text-danger' onclick="showHapusPenetapan(`+item.id+`)" value="animate__rubberBand"><i class='fas fa-trash me-1'></i> Hapus</a>`;
                                }
                            content += `</div></center></td>`;
                            if (item.deleted_at != null) {
                                bgHapus = `<span class="badge rounded-pill text-bg-danger p-1">Terhapus</span>`;
                            } else {
                                bgHapus = ``;
                            }
                            content += "<td style='white-space: normal !important;word-wrap: break-word;'>"
                                        + "<div class='d-flex justify-content-start align-items-center'><div class='d-flex flex-column'>"
                                        + "<h6 class='mb-0'>" + item.nama_referensi + `&nbsp;&nbsp;${item.status != 0?'<span class="badge rounded-pill text-bg-success p-1">Berlaku/Aktif</span>':'<span class="badge rounded-pill text-bg-secondary p-1">Nonaktif</span>'}&nbsp;&nbsp;` + bgHapus + "</h6><small class='text-truncate text-muted'>Oleh " + item.nama_kepegawaian + "</small>"
                                        + "</div></div></td>";
                            content += `<td>` + new Date(item.tgl_berlaku).toLocaleDateString("sv-SE") + `</td>`;
                            content += `<td>${item.keterangan?item.keterangan:'-'}</td>`;
                            content += "<td>" + new Date(item.updated_at).toLocaleString("sv-SE") + "</td></tr>";
                            $('#tampil-tbody-penetapan').append(content);
                        });
                        var table = $('#dttable-penetapan').DataTable({
                            order: [
                                [2, "desc"]
                            ],
                            bAutoWidth: false,
                            aoColumns : [
                                { sWidth: '5%' },
                                { sWidth: '25%' },
                                { sWidth: '10%' },
                                { sWidth: '50%' },
                                { sWidth: '10%' },
                            ],
                            displayLength: 10,
                            lengthChange: true,
                            lengthMenu: [ 10, 25, 50, 75, 100, 500, 1000, 5000, 10000],
                            // buttons: ['copy', 'excel', 'pdf', 'colvis']
                        });
                    },
                    error: function(res) {
                        iziToast.error({
                            title: 'Pesan Galat!',
                            message: 'Record Penetapan Pegawai tidak ditemukan.',
                            position: 'topRight'
                        });
                    }
                }
            );
        }

        function refreshRotasi() {
            var ref_id       = $("#ref_rotasi");
            var tgl_berlaku  = $("#tgl_berlaku_rotasi");
            var ket          = $("#ket_rotasi");

            // INIT
            ref_id.val('');
            tgl_berlaku.val('');
            ket.val('');

            // MULAI TABEL
            $("#tampil-tbody-rotasi").empty();
            $("#tampil-tbody-rotasi").empty().append(`<tr><td colspan="9" style="font-size:13px"><center><i class="fa fa-spinner fa-spin fa-fw"></i> Memproses data...</center></td></tr>`);
            $.ajax(
                {
                    url: "/api/profilkaryawan/rotasi/table/{{ $list['show']->id }}",
                    type: 'GET',
                    dataType: 'json', // added data type
                    success: function(res) {
                        var adminID = "{{ Auth::user()->getManyRole(['it','kabag-kepegawaian']) }}";
                        // var userID = "{{ Auth::user()->id }}";
                        $("#tampil-tbody-rotasi").empty();
                        $('#dttable-rotasi').DataTable().clear().destroy();

                        res.show.forEach(item => {
                            content = "<tr id='data"+ item.id +"'>";
                            content += `<td><center><div class='dropend'><a href='javascript:void(0);' class='btn ${item.status==0?'btn-light':'btn-light-primary'} btn-sm font-size-16 rounded' data-bs-toggle='dropdown' aria-haspopup="true"><i class="ti ti-dots"></i></a><div class='dropdown-menu'>`;
                                if (item.status == 0) {
                                    content += `<a href='javascript:void(0);' class='dropdown-item text-secondary'><i class='ti ti-arrow-back-up me-1'></i> Batalkan Rotasi</a>`;
                                } else {
                                    content += `<a href='javascript:void(0);' class='dropdown-item text-danger' onclick="showHapusRotasi(`+item.id+`)" value="animate__rubberBand"><i class='ti ti-arrow-back-up me-1'></i> Batalkan Rotasi</a>`;
                                }
                            content += `</div></center></td>`;
                            if (item.deleted_at != null) {
                                bgHapus = `<span class="badge rounded-pill text-bg-secondary p-1">Terhapus</span>`;
                            } else {
                                bgHapus = ``;
                            }
                            content += "<td style='white-space: normal !important;word-wrap: break-word;'>"
                                        + "<div class='d-flex justify-content-start align-items-center'><div class='d-flex flex-column'>"
                                        + "<h6 class='mb-0'>" + item.nama_referensi + "&nbsp;&nbsp;" + bgHapus + "</h6><small class='text-truncate text-muted'>Oleh " + item.nama_kepegawaian + "</small>"
                                        + "</div></div></td>";
                            content += `<td>` + new Date(item.tgl_berlaku).toLocaleDateString("sv-SE") + `</td>`;
                            content += `<td>`;
                            if (item.before) {
                                try {
                                    var bef = JSON.parse(item.before);
                                } catch (e) {
                                    var bef = item.before;
                                }
                                bef.forEach(val => {
                                    res.onlyRole.forEach(rl => {
                                        if (val == rl.id_role) {
                                            content += `<span class="badge rounded-pill text-bg-secondary p-1">${rl.deskripsi_role?rl.deskripsi_role:rl.nama_role}</span>&nbsp;`;
                                        }
                                    })
                                })
                            }
                            content += `</td>`;
                            content += `<td>`;
                            if (item.after) {
                                try {
                                    var aft = JSON.parse(item.after);
                                } catch (e) {
                                    var aft = item.after;
                                }
                                aft.forEach(val => {
                                    res.onlyRole.forEach(rl => {
                                        if (val == rl.id_role) {
                                            content += `<span class="badge rounded-pill text-bg-primary p-1">${rl.deskripsi_role?rl.deskripsi_role:rl.nama_role}</span>&nbsp;`;
                                        }
                                    })
                                })
                            }
                            content += `</td>`;
                            content += `<td>${item.keterangan?item.keterangan:'-'}</td>`;
                            content += "<td>" + new Date(item.updated_at).toLocaleString("sv-SE") + "</td></tr>";
                            $('#tampil-tbody-rotasi').append(content);
                        });
                        var table = $('#dttable-rotasi').DataTable({
                            order: [
                                [2, "desc"]
                            ],
                            bAutoWidth: false,
                            aoColumns : [
                                { sWidth: '5%' },
                                { sWidth: '15%' },
                                { sWidth: '10%' },
                                { sWidth: '20%' },
                                { sWidth: '20%' },
                                { sWidth: '15%' },
                                { sWidth: '15%' },
                            ],
                            displayLength: 10,
                            lengthChange: true,
                            lengthMenu: [ 10, 25, 50, 75, 100, 500, 1000, 5000, 10000],
                            // buttons: ['copy', 'excel', 'pdf', 'colvis']
                        });

                        // CHANGE SELECT JABATAN VALUE
                        $("#jabatan_rotasi").find('option').remove();
                        res.onlyRole.forEach(item => {
                            opt = '';
                            opt += `<option value="${item.id_role}"`;
                            res.model.forEach(val => {
                                if (item.id_role == val.role_id) {
                                    opt += `selected`;
                                }
                            })
                            opt += `>${item.deskripsi_role?item.deskripsi_role:item.nama_role}</option>`;
                            $("#jabatan_rotasi").append(opt);
                        });
                    },
                    error: function(res) {
                        iziToast.error({
                            title: 'Pesan Galat!',
                            message: 'Record Rotasi Jabatan Pegawai tidak ditemukan.',
                            position: 'topRight'
                        });
                    }
                }
            );
        }

        function refreshDokumen() {
            $("#tampil-tbody-dokumen").empty();
            $("#tampil-tbody-dokumen").empty().append(`<tr><td colspan="9" style="font-size:13px"><center><i class="fa fa-spinner fa-spin fa-fw"></i> Memproses data...</center></td></tr>`);
            $.ajax(
                {
                    url: "/api/profilkaryawan/dokumen/table/{{ $list['show']->id }}",
                    type: 'GET',
                    dataType: 'json', // added data type
                    success: function(res) {
                        $("#tampil-tbody-dokumen").empty();
                        $('#dttable-dokumen').DataTable().clear().destroy();
                        res.show.forEach(item => {
                            content = "<tr id='data"+ item.id +"'>";
                            content += `<td><center><div class='dropend'><a href='javascript:void(0);' class='btn btn-light btn-sm text-muted font-size-16 rounded' data-bs-toggle='dropdown' aria-haspopup="true"><i class="ti ti-dots"></i></a><div class='dropdown-menu'>`;
                                if (item.title) {
                                    content += `<a href='javascript:void(0);' class='dropdown-item text-primary' onclick="window.open('/kepegawaian/profilkaryawan/dokumen/download/`+item.id+`')"><i class='fas fa-download me-1'></i> Download</a>`;
                                } else {
                                    content += `<a href='javascript:void(0);' class='dropdown-item text-secondary' disabled><i class='fas fa-download me-1'></i> Download</a>`;
                                }
                            content += `</div></center></td>`;
                            content += `<td>
                                            <h5 class="mb-0"><span class="badge me-1" style="font-size: 10px;${item.color?'background-color:'+item.color:''}">${item.nama_ref}</span> ${item.status?item.no_surat:'<s>'+item.no_surat+'</s>'}</h5>`;
                                if (item.tgl_akhir == '' || item.tgl_akhir == null) {
                                    if (item.ref_id == 139) {
                                        content += `<p class="text-muted f-12 mb-0">Masa Berlaku <a class="text-primary">Seumur Hidup</a></p>`;
                                    }
                                } else {
                                    if (item.tgl_mulai == '' || item.tgl_mulai == null) {
                                        content += `<p class="text-muted f-12 mb-0">${item.tgl_akhir}</p>`;
                                    } else {
                                        content += `<p class="text-muted f-12 mb-0">${item.tgl_mulai}&nbsp;<i class="ti ti-arrow-narrow-right text-primary"></i>&nbsp;${item.tgl_akhir}</p>`;
                                    }
                                }
                            content += `</td>
                                        <td style='white-space: normal !important;word-wrap: break-word;'>${item.deskripsi?item.deskripsi:'-'}</td>
                                        <td><center>${item.status?'<span class="badge bg-success">Aktif</span>':'<span class="badge bg-danger">Nonaktif</span>'}</center></td>`;
                            content += "<td>" + new Date(item.updated_at).toLocaleString("sv-SE") + "</td></tr>";
                            $('#tampil-tbody-dokumen').append(content);
                        });
                        var table = $('#dttable-dokumen').DataTable({
                            order: [
                                [4, "desc"]
                            ],
                            bAutoWidth: false,
                            aoColumns : [
                                { sWidth: '5%' },
                                { sWidth: '30%' },
                                { sWidth: '40%' },
                                { sWidth: '10%' },
                                { sWidth: '15%' },
                            ],
                            displayLength: 10,
                            lengthChange: true,
                            lengthMenu: [ 10, 25, 50, 75, 100, 500, 1000, 5000, 10000],
                            // buttons: ['copy', 'excel', 'pdf', 'colvis']
                        });
                    },
                    error: function(res) {
                        iziToast.error({
                            title: 'Pesan Galat!',
                            message: 'Dokumen tidak ditemukan.',
                            position: 'topRight'
                        });
                    }
                }
            );
        }

        function refreshSpkRkk() {
            $("#tampil-tbody-spkrkk").empty();
            $("#tampil-tbody-spkrkk").empty().append(`<tr><td colspan="9" style="font-size:13px"><center><i class="fa fa-spinner fa-spin fa-fw"></i> Memproses data...</center></td></tr>`);
            $.ajax(
                {
                    url: "/api/profilkaryawan/spkrkk/table/{{ $list['show']->id }}",
                    type: 'GET',
                    dataType: 'json', // added data type
                    success: function(res) {
                        // VALIDATION FORM
                        if (res.status) {
                            $('#jns_spkrkk').val('');
                            $('#tgl_akhir_spkrkk').val('');
                            $('#deskripsi_spkrkk').val('');
                            $('#upload_spkrkk').val('');
                            $('.status_true_spkrkk').prop('hidden',false);
                            $('.status_false_spkrkk').prop('hidden',true);
                            // $('#validasi_tgl_akhir_spkrkk').val(res.status.queue);
                            // if (res.status.queue == 2 || res.status.queue == 3) {
                            //     // IF STATUS = THL & KONTRAK
                            //     $('.penetapan_true_spkrkk').prop('hidden',false);
                            //     $('.penetapan_false_spkrkk').prop('hidden',true);
                            // } else {
                            //     $('.penetapan_true_spkrkk').prop('hidden',true);
                            //     $('.penetapan_false_spkrkk').prop('hidden',false);
                            // }
                        } else {
                            $('.status_true_spkrkk').prop('hidden',true);
                            $('.status_false_spkrkk').prop('hidden',false);
                        }
                        // ------------------------------------------------------
                        $("#tampil-tbody-spkrkk").empty();
                        $('#dttable-spkrkk').DataTable().clear().destroy();
                        res.show.forEach(item => {
                            content = "<tr id='data"+ item.id +"'>";
                            content += `<td><center><div class='dropend'><a href='javascript:void(0);' class='btn btn-light btn-sm text-muted font-size-16 rounded' data-bs-toggle='dropdown' aria-haspopup="true"><i class="ti ti-dots"></i></a><div class='dropdown-menu'>`;
                                if (item.deleted_at == null) {
                                    content += `<a href='javascript:void(0);' class='dropdown-item text-primary' onclick="window.open('/kepegawaian/profilkaryawan/spkrkk/download/`+item.id+`')"><i class='fas fa-download me-1'></i> Download</a>`;
                                } else {
                                    content += `<a href='javascript:void(0);' class='dropdown-item text-secondary'><i class='fas fa-download me-1'></i> Download</a>`;
                                }
                                if (item.status == 0) {
                                    content += `<a href='javascript:void(0);' class='dropdown-item text-secondary'><i class='fas fa-edit me-1'></i> Ubah</a>`;
                                    content += `<a href='javascript:void(0);' class='dropdown-item text-secondary'><i class='fas fa-trash me-1'></i> Hapus</a>`;
                                } else {
                                    content += `<a href='javascript:void(0);' class='dropdown-item text-secondary'><i class='fas fa-edit me-1'></i> Ubah</a>`;
                                    // content += `<a href='javascript:void(0);' class='dropdown-item text-warning' onclick="showUbahSpkRkk(`+item.id+`)" value="animate__rubberBand"><i class='fas fa-edit me-1'></i> Ubah</a>`;
                                    content += `<a href='javascript:void(0);' class='dropdown-item text-danger' onclick="showHapusSpkRkk(`+item.id+`)" value="animate__rubberBand"><i class='fas fa-trash me-1'></i> Hapus</a>`;
                                }
                            content += `</div></center></td>`;
                            if (item.deleted_at != null) {
                                bgHapus = `<span class="badge rounded-pill text-bg-danger p-1">Terhapus</span>`;
                            } else {
                                bgHapus = ``;
                            }
                            if (item.status != 0) {
                                bgStatus = `<span class="badge rounded-pill text-bg-success p-1">Aktif</span>`;
                            } else {
                                bgStatus = `<span class="badge rounded-pill text-bg-secondary p-1">Nonaktif</span>`;
                            }
                            content += `<td style='white-space: normal !important;word-wrap: break-word;'>`
                                        + `<div class='d-flex justify-content-start align-items-center'><div class='d-flex flex-column'>`
                                        + `<h6 class='mb-0'><b class="${item.status != 0?'text-primary':'text-secondary'}">${item.jns_dokumen == 0?'SPK & RKK':'Dokumen Lain'}</b>&nbsp;${item.nama_pegawai}&nbsp;&nbsp;` +bgStatus+ `&nbsp;&nbsp;` + bgHapus + `</h6><small class='text-truncate text-muted'>Oleh ` + item.nama_kepegawaian + `</small>`
                                        + `</div></div></td>`;
                            content += `<td>${item.tgl_berakhir?item.tgl_berakhir:'-'}</td>`;
                            content += `<td>${item.deskripsi?item.deskripsi:'-'}</td>`;
                            content += "<td>" + new Date(item.updated_at).toLocaleString("sv-SE") + "</td></tr>";
                            $('#tampil-tbody-spkrkk').append(content);
                        });
                        var table = $('#dttable-spkrkk').DataTable({
                            order: [
                                [4, "desc"]
                            ],
                            bAutoWidth: false,
                            aoColumns : [
                                { sWidth: '5%' },
                                { sWidth: '40%' },
                                { sWidth: '10%' },
                                { sWidth: '30%' },
                                { sWidth: '15%' },
                            ],
                            displayLength: 10,
                            lengthChange: true,
                            lengthMenu: [ 10, 25, 50, 75, 100, 500, 1000, 5000, 10000],
                            // buttons: ['copy', 'excel', 'pdf', 'colvis']
                        });
                    },
                    error: function(res) {
                        iziToast.error({
                            title: 'Pesan Galat!',
                            message: 'Dokumen tidak ditemukan.',
                            position: 'topRight'
                        });
                    }
                }
            );
        }

        // SHOW HAPUS
        function showHapusPegawai(id) {
            $("#id_hapus_pegawai").val(id);
            $("#show_id_pegawai").text(id);
            var inputs = document.getElementById('setujuhapuspegawai');
            inputs.checked = false;
            $('#hapusPegawai').modal('show');
        }

        function showHapusPenetapan(id) {
            $("#id_hapus_penetapan").val(id);
            var inputs = document.getElementById('setujuhapuspenetapan');
            inputs.checked = false;
            $('#hapusPenetapan').modal('show');
        }

        function showHapusRotasi(id) {
            $("#id_hapus_rotasi").val(id);
            var inputs = document.getElementById('setujuhapusrotasi');
            inputs.checked = false;
            $('#hapusRotasi').modal('show');
        }

        function showHapusSpkRkk(id) {
            $("#id_hapus_spkrkk").val(id);
            $("#show_id_hapusspkrkk").text(id);
            var inputs = document.getElementById('setujuhapusspkrkk');
            inputs.checked = false;
            $('#hapusSpkRkk').modal('show');
        }

        function prosesHapusPegawai() {
            // SWITCH BTN HAPUS
            var checkboxHapus = $('#setujuhapuspegawai').is(":checked");
            if (checkboxHapus == false) {
                iziToast.error({
                    title: 'Pesan Galat!',
                    message: 'Mohon menyetujui untuk dilakukan penghapusan (Nonaktif) pegawai',
                    position: 'topRight'
                });
            } else {
                // PROSES HAPUS
                var id = $("#id_hapus_pegawai").val();
                $.ajax({
                    url: "/api/profilkaryawan/{{ Auth::user()->id }}/hapus/"+id+"/proses",
                    type: 'GET',
                    dataType: 'json', // added data type
                    // type: 'DELETE',
                    success: function(res) {
                        iziToast.success({
                            title: 'Pesan Sukses!',
                            message: 'Pegawai telah berhasil dihapus/dinonaktifkan pada '+res,
                            position: 'topRight'
                        });
                        $('#hapusPegawai').modal('hide');
                        // location.reload();
                        // redirect ke route
                        window.location.href = "{{ route('profilkaryawan.index') }}";
                    },
                    error: function(res) {
                        iziToast.error({
                            title: 'Pesan Galat!',
                            message: 'pegawai gagal dihapus',
                            position: 'topRight'
                        });
                    }
                });
            }
        }

        function prosesHapusPenetapan() {
            // SWITCH BTN HAPUS
            var checkboxHapus = $('#setujuhapuspenetapan').is(":checked");
            if (checkboxHapus == false) {
                iziToast.error({
                    title: 'Pesan Galat!',
                    message: 'Mohon menyetujui untuk dilakukan penghapusan status pegawai',
                    position: 'topRight'
                });
            } else {
                // PROSES HAPUS
                var id = $("#id_hapus_penetapan").val();
                $.ajax({
                    url: "/api/profilkaryawan/penetapan/hapus/"+id+"/proses",
                    type: 'DELETE',
                    success: function(res) {
                        iziToast.success({
                            title: 'Pesan Sukses!',
                            message: 'Status Pegawai telah berhasil dihapus pada '+res,
                            position: 'topRight'
                        });
                        $('#hapusPenetapan').modal('hide');
                        refreshPenetapan();
                    },
                    error: function(res) {
                        iziToast.error({
                            title: 'Pesan Galat!',
                            message: 'Status pegawai gagal dihapus',
                            position: 'topRight'
                        });
                    }
                });
            }
        }

        function prosesHapusRotasi() {
            // SWITCH BTN HAPUS
            var checkboxHapus = $('#setujuhapusrotasi').is(":checked");
            if (checkboxHapus == false) {
                iziToast.error({
                    title: 'Pesan Galat!',
                    message: 'Mohon menyetujui untuk dilakukan penghapusan rotasi jabatan pegawai',
                    position: 'topRight'
                });
            } else {
                // PROSES HAPUS
                var id = $("#id_hapus_rotasi").val();
                $.ajax({
                    url: "/api/profilkaryawan/rotasi/hapus/"+id+"/proses",
                    type: 'DELETE',
                    success: function(res) {
                        iziToast.success({
                            title: 'Pesan Sukses!',
                            message: 'Rotasi Jabatan Pegawai telah berhasil dihapus pada '+res,
                            position: 'topRight'
                        });
                        $('#hapusRotasi').modal('hide');
                        refreshRotasi();
                    },
                    error: function(res) {
                        iziToast.error({
                            title: 'Pesan Galat!',
                            message: 'Rotasi Jabatan Pegawai gagal dihapus',
                            position: 'topRight'
                        });
                    }
                });
            }
        }

        function prosesHapusSpkRkk() {
            // SWITCH BTN HAPUS
            var checkboxHapus = $('#setujuhapusspkrkk').is(":checked");
            if (checkboxHapus == false) {
                iziToast.error({
                    title: 'Pesan Galat!',
                    message: 'Mohon menyetujui untuk dilakukan penghapusan data record SPK / RKK tersebut',
                    position: 'topRight'
                });
            } else {
                // PROSES HAPUS
                var id = $("#id_hapus_spkrkk").val();
                $.ajax({
                    url: "/api/profilkaryawan/spkrkk/hapus/"+id+"/proses",
                    type: 'DELETE',
                    success: function(res) {
                        iziToast.success({
                            title: 'Pesan Sukses!',
                            message: 'Data Record Pegawai telah berhasil dihapus pada '+res,
                            position: 'topRight'
                        });
                        $('#hapusSpkRkk').modal('hide');
                        refreshSpkRkk();
                    },
                    error: function(res) {
                        iziToast.error({
                            title: 'Pesan Galat!',
                            message: 'Data Record Pegawai gagal dihapus',
                            position: 'topRight'
                        });
                    }
                });
            }
        }

        // ADD ON
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    // $('#blah_a').attr('href', e.target.result);
                    $('#blah').attr('src', e.target.result).height(400).width(400);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#fileInput").change(function() {
            readURL(this);
        });

        </script>
@endsection
