@extends('layouts.index')

@section('content')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i></a></li>
                        <li class="breadcrumb-item" aria-current="page">Profil Akun</li>
                    </ul>
                </div>
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h2 class="mb-0">Profil Akun</h2>
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
                                <i class="ti ti-user-check me-2"></i>Profil Pengguna
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab"
                                href="#ubah-profil" role="tab" aria-selected="true">
                                <i class="ti ti-file-text me-2"></i>Ubah Profil
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab"
                                href="#upload-dokumen" role="tab" aria-selected="true" onclick="refreshDokumen()">
                                <i class="ti ti-cloud-upload me-2"></i>Dokumen
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab-3" data-bs-toggle="tab"
                                href="#ubah-foto-profil" role="tab" aria-selected="true">
                                <i class="ti ti-id me-2"></i>Ubah Foto Profil
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab-4" data-bs-toggle="tab"
                                href="#ubah-password" role="tab" aria-selected="true">
                                <i class="ti ti-lock-open me-2"></i>Ubah Password
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab-5" data-bs-toggle="tab"
                                href="#spkrkk" role="tab" aria-selected="true" onclick="refreshSpkrkk()">
                                <i class="ti ti-brand-docker me-2"></i>SPK & RKK
                            </a>
                        </li>
                        {{-- <li class="nav-item">
                            <a class="nav-link" id="profile-tab-6" data-bs-toggle="tab"
                                href="#profile-6" role="tab" aria-selected="true">
                                <i class="ti ti-settings me-2"></i><s>Settings</s>
                            </a>
                        </li> --}}
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
                                        <h5 class="mb-1">{{ Auth::user()->nama }}</h5>
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
                                                <small class="text-muted">{{ $list['show']->deleted_at == null? 'Aktif':'Non Aktif' }}</small>
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
                                            <p class="mb-0">{{ $list['show']->nip?$list['show']->nip:'-' }}</p>
                                        </div>
                                        <div class="d-inline-flex align-items-center justify-content-start w-100 mb-3">
                                            <i class="fas fa-address-card me-3"></i>
                                            <p class="mb-0">{{ $list['show']->nik?$list['show']->nik:'-' }}</p>
                                        </div>
                                        <div class="d-inline-flex align-items-center justify-content-start w-100 mb-3">
                                            <i class="fas fa-envelope me-3"></i>
                                            <p class="mb-0"><a href="javascript:void(0);"
                                                    class="text-dark">{{ $list['show']->email }}</a>
                                            </p>
                                        </div>
                                        <div class="d-inline-flex align-items-center justify-content-start w-100">
                                            <i class="fab fa-whatsapp-square me-3"></i>
                                            <p class="mb-0">{{ $list['show']->no_hp?$list['show']->no_hp:'-' }}</p>
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
                                    <h5>Tentang Pengalaman Kerja Saya</h5>
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

                {{-- FORM UBAH PROFIL --}}
                <div class="tab-pane" id="ubah-profil" role="tabpanel" aria-labelledby="profile-tab-2">
                    <form id="formUpdate" class="form-auth-small needs-validation" action="{{ route('profil.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Deskripsi Pengalaman Kerja</h5>
                                    </div>
                                    <div class="card-body">
                                        <textarea class="form-control" name="pengalaman_kerja" rows="5" placeholder="e.g. Saya pernah bekerja pada suatu instansi swasta ternama yang bertempat di Kota X dan berprofesi sebagai X . . ."><?php echo htmlspecialchars($list['show']->pengalaman_kerja); ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Data Sensitif</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-5">
                                                <div class="mb-3">
                                                    <label class="form-label">Nomor Induk Pegawai (NIP) <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" value="{{ $list['show']->nip }}" disabled>
                                                </div>
                                            </div>
                                            <div class="col-sm-7">
                                                <div class="mb-3">
                                                    <label class="form-label">Nomor Induk Kependudukan (NIK) <span class="text-danger">*</span></label>
                                                    <input type="number" class="form-control" name="nik" value="{{ $list['show']->nik }}" minlength="16" maxlength="16" placeholder="Isi dengan kombinasi Angka" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-7">
                                                <div class="mb-3">
                                                    <label class="form-label">Email Aktif <span class="text-danger">*</span></label>
                                                    <input type="email" class="form-control" name="email" value="{{ $list['show']->email }}" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-5">
                                                <div>
                                                    <label class="form-label">No. HP Aktif (Whatsapp +62) <span class="text-danger">*</span></label>
                                                    <input type="number" class="form-control telphone_with_code" name="no_hp" value="{{ $list['show']->no_hp }}" maxlength="13" placeholder="628**********" data-mask="(62) 9999-9999-9999">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Data Diri</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            {{-- <div class="col-sm-12 text-center mb-3">
                                                <div class="user-upload wid-75"><img
                                                        src="../assets/images/user/avatar-4.jpg" alt="img"
                                                        class="img-fluid"> <label for="uplfile"
                                                        class="img-avtar-upload"><i
                                                            class="ti ti-camera f-24 mb-1"></i>
                                                        <span>Upload</span></label> <input type="file" id="uplfile"
                                                        class="d-none"></div>
                                            </div> --}}
                                            <div class="col-sm-8">
                                                <div class="mb-3">
                                                    <label class="form-label">Nama Lengkap, <mark><i>Beserta Gelar</i></mark> <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="nama" value="{{ $list['show']->nama }}"
                                    placeholder="e.g. Sunaryo, S.Kep" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="mb-3">
                                                    <label class="form-label">Nama Panggilan <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="nick" value="{{ $list['show']->nick }}"
                                    placeholder="e.g. Soenaryo" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
                                                    <select class="select2 form-control" id="temp_lahir" name="temp_lahir" required>
                                                        @foreach ($list['kota'] as $item)
                                                            <option value="{{ $item->nama_kabkota }}"
                                                                @if ($list['show']->temp_lahir == $item->nama_kabkota) selected @endif>{{ $item->nama_kabkota }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                                                    <input type="date" class="form-control" name="tgl_lahir"
                                                        value="{{ $list['show']->tgl_lahir }}" placeholder="YYYY-MM-DD" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                                    <select class="select2 form-control" id="jns_kelamin" name="jns_kelamin" required>
                                                        <option value="LAKI-LAKI" @if ($list['show']->jns_kelamin == 'LAKI-LAKI') echo selected @endif>
                                                            Laki-laki</option>
                                                        <option value="PEREMPUAN" @if ($list['show']->jns_kelamin == 'PEREMPUAN') echo selected @endif>
                                                            Perempuan</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="">
                                                    <label class="form-label">Status Kawin <span class="text-danger">*</span></label>
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
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Alamat Sesuai KTP</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="alert alert-light">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                @if (!empty($list['show']->alamat_dom)) value="1" @else value="0" checked @endif
                                                name="cek_dom" id="checkbox_alamat">
                                                <label class="form-check-label" for="checkbox_alamat"><u><b>Alamat Domisili sama dengan KTP</b></u></label>
                                            </div>
                                            <small>Hilangkan centang untuk menampilkan Pilihan Domisili</small>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Provinsi <span class="text-danger">*</span></label>
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
                                            <div class="col-sm-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Kabupaten <span class="text-danger">*</span></label>
                                                    <select class="select2 form-control" name="ktp_kabupaten" id="apikota" style="width: 100%"
                                                        disabled required>
                                                        @if (!empty($list['show']->ktp_kabupaten))
                                                            <option value="{{ $list['show']->ktp_kabupaten }}">
                                                                {{ $list['show']->ktp_kabupaten }}</option>
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Kecamatan <span class="text-danger">*</span></label>
                                                    <select class="select2 form-control" name="ktp_kecamatan" id="apikecamatan"
                                                        style="width: 100%" disabled required>
                                                        @if (!empty($list['show']->ktp_kecamatan))
                                                            <option value="{{ $list['show']->ktp_kecamatan }}">
                                                                {{ $list['show']->ktp_kecamatan }}</option>
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Kelurahan / Desa <span class="text-danger">*</span></label>
                                                    <select class="select2 form-control" name="ktp_kelurahan" id="apidesa"
                                                        style="width: 100%" disabled required>
                                                        @if (!empty($list['show']->ktp_kelurahan))
                                                            <option value="{{ $list['show']->ktp_kelurahan }}">
                                                                {{ $list['show']->ktp_kelurahan }}</option>
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="">
                                                    <label class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                                                    <textarea class="form-control" name="alamat_ktp" required placeholder="Tuliskan alamat lengkap sesuai KTP Anda"><?php echo htmlspecialchars($list['show']->alamat_ktp); ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card" id="hidedom" @if (empty($list['show']->alamat_dom)) style="display: none" @endif>
                                    <div class="card-header">
                                        <h5>Alamat Domisli (Bila Ada)</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-6">
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
                                            <div class="col-sm-6">
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
                                            <div class="col-sm-6">
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
                                            <div class="col-sm-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Kelurahan</label>
                                                    <select class="select2 form-control" name="dom_kelurahan" id="apidesadom"
                                                        style="width: 100%" disabled>
                                                        @if (!empty($list['show']->dom_kelurahan))
                                                            <option value="{{ $list['show']->dom_kelurahan }}">
                                                                {{ $list['show']->dom_kelurahan }}</option>
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="">
                                                    <label class="form-label">Alamat Lengkap</label>
                                                    <textarea class="form-control" name="alamat_dom" id="apialamatdom" placeholder="Tuliskan alamat lengkap domisili Anda"><?php echo htmlspecialchars($list['show']->alamat_dom); ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Data Kesehatan</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Riwayat Penyakit</label>
                                                    <textarea name="riwayat_penyakit" class="form-control" placeholder="Tuliskan bila ada"><?php echo htmlspecialchars($list['show']->riwayat_penyakit); ?></textarea>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Riwayat Penyakit Keluarga</label>
                                                    <textarea name="riwayat_penyakit_keluarga" class="form-control" placeholder="Tuliskan bila ada"><?php echo htmlspecialchars($list['show']->riwayat_penyakit_keluarga); ?></textarea>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Riwayat Operasi</label>
                                                    <textarea name="riwayat_operasi" class="form-control" placeholder="Tuliskan bila ada"><?php echo htmlspecialchars($list['show']->riwayat_operasi); ?></textarea>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="">
                                                    <label class="form-label">Riwayat Penggunaan Obat</label>
                                                    <textarea name="riwayat_penggunaan_obat" class="form-control" placeholder="Tuliskan bila ada"><?php echo htmlspecialchars($list['show']->riwayat_penggunaan_obat); ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Media Sosial</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="input-group mb-3">
                                            <div class="d-flex align-items-center input-group-text">
                                                <div class="flex-shrink-0">
                                                    <div class="avtar avtar-xs btn-light-facebook">
                                                        <i class="fab fa-facebook-f f-16"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h6 class="mb-0">Facebook /</h6>
                                                </div>
                                            </div>
                                            <input type="text" class="form-control" name="fb" value="{{ $list['show']->fb }}" placeholder="Tuliskan Username Facebook Anda">
                                        </div>
                                        <div class="input-group mb-3">
                                            <div class="d-flex align-items-center input-group-text">
                                                <div class="flex-shrink-0">
                                                    <div class="avtar avtar-xs btn-light-instagram">
                                                        <i class="fab fa-instagram f-16"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h6 class="mb-0">Instagram /</h6>
                                                </div>
                                            </div>
                                            <input type="text" class="form-control" name="ig" value="{{ $list['show']->ig }}" placeholder="Tuliskan Username Instagram Anda">
                                        </div>
                                        <div class="input-group">
                                            <div class="d-flex align-items-center input-group-text">
                                                <div class="flex-shrink-0">
                                                    <div class="avtar avtar-xs btn-light-tiktok">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                                            <path d="M448 209.9a210.1 210.1 0 0 1 -122.8-39.3V349.4A162.6 162.6 0 1 1 185 188.3V278.2a74.6 74.6 0 1 0 52.2 71.2V0l88 0a121.2 121.2 0 0 0 1.9 22.2h0A122.2 122.2 0 0 0 381 102.4a121.4 121.4 0 0 0 67 20.1z"/>
                                                        </svg>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h6 class="mb-0">Tiktok / @&nbsp;&nbsp;&nbsp;</h6>
                                                </div>
                                            </div>
                                            <input type="text" class="form-control" name="tt" value="{{ $list['show']->tt }}" placeholder="Tuliskan Username Tiktok Anda">
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Data Pendidikan</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="alert alert-light">
                                                    <h6>Keterangan Pengisian</h6>
                                                    <i class="ti ti-arrow-narrow-right text-primary"></i> Kolom pertama adalah nama sekolah/universitas<br>
                                                    <i class="ti ti-arrow-narrow-right text-primary"></i> Kolom kedua adalah tahun lulus sesuai ijazah<br>
                                                    <i class="ti ti-arrow-narrow-right text-primary"></i> Kolom ketiga adalah upload dokumen Ijazah (Ikon <i class="ti ti-cloud-upload"></i>)<br>
                                                    <i class="ti ti-arrow-narrow-right text-primary"></i> Upload ulang dokumen ijazah untuk memperbarui dokumen baru
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="mb-3">
                                                    <label class="form-label">Sekolah Dasar (SD) atau sederajat <span class="text-danger" id="wajib_sd" hidden>*</span></label>
                                                    <div class="input-group mb-3">
                                                        <input type="text" class="form-control" name="sd" value="{{ $list['show']->sd }}" placeholder="Nama Sekolah">
                                                        <input type="number" class="form-control" name="th_sd" value="{{ $list['show']->th_sd }}" placeholder="Tahun Lulus" maxlength="4">
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <input type="file" class="form-control" id="upload_sd" name="upload_sd" value="{{ $list['show']->filename_sd }}" accept="application/pdf">
                                                        @if ($list['show']->filename_sd)
                                                            <label class="btn btn-outline-secondary" style="padding-top:16" for="upload_sd" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom"
                                                                data-bs-html="true" title="Upload Ijazah"><i class="ti ti-cloud-upload"></i></label>
                                                            <a href="javascript:void(0);" class="btn btn-outline-primary" style="padding-top:16" onclick="window.location='{{ url('storage/' . substr($list['show']->filename_sd, 7, 1000)) }}'" data-bs-toggle="tooltip" data-bs-offset="0,4"
                                                                data-bs-placement="bottom" data-bs-html="true" title="Download Ijazah"><i class="ti ti-cloud-download"></i></a>
                                                        @else
                                                            <label class="btn btn-outline-secondary" style="padding-top:16" for="upload_sd" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom"
                                                                data-bs-html="true" title="Upload Ijazah"><i class="ti ti-cloud-upload"></i></label>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="mb-3">
                                                    <label class="form-label">SMP/SLTP atau sederajat <span class="text-danger" id="wajib_smp" hidden>*</span></label>
                                                    <div class="input-group mb-3">
                                                        <input type="text" class="form-control" name="smp" value="{{ $list['show']->smp }}" placeholder="Nama Sekolah">
                                                        <input type="number" class="form-control" name="th_smp" value="{{ $list['show']->th_smp }}" placeholder="Tahun Lulus" disabled>
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <input type="file" class="form-control" id="upload_smp" name="upload_smp" value="{{ $list['show']->filename_smp }}" accept="application/pdf" disabled>
                                                        @if ($list['show']->filename_smp)
                                                            <label class="btn btn-outline-secondary" style="padding-top:16" for="upload_smp" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom"
                                                                data-bs-html="true" title="Upload Ijazah"><i class="ti ti-cloud-upload"></i></label>
                                                            <a href="javascript:void(0);" class="btn btn-outline-primary" style="padding-top:16" onclick="window.location='{{ url('storage/' . substr($list['show']->filename_smp, 7, 1000)) }}'" data-bs-toggle="tooltip" data-bs-offset="0,4"
                                                                data-bs-placement="bottom" data-bs-html="true" title="Download Ijazah"><i class="ti ti-cloud-download"></i></a>
                                                        @else
                                                            <label class="btn btn-outline-secondary" style="padding-top:16" for="upload_smp" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom"
                                                                data-bs-html="true" title="Upload Ijazah"><i class="ti ti-cloud-upload"></i></label>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="mb-3">
                                                    <label class="form-label">SMA/SMK atau sederajat</label>
                                                    <div class="input-group mb-3">
                                                        <input type="text" class="form-control" name="sma" value="{{ $list['show']->sma }}" placeholder="Nama Sekolah">
                                                        <input type="number" class="form-control" name="th_sma" value="{{ $list['show']->th_sma }}" placeholder="Tahun Lulus" disabled>
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <input type="file" class="form-control" id="upload_sma" name="upload_sma" value="{{ $list['show']->filename_sma }}" accept="application/pdf" disabled>
                                                        @if ($list['show']->filename_sma)
                                                            <label class="btn btn-outline-secondary" style="padding-top:16" for="upload_sma" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom"
                                                                data-bs-html="true" title="Upload Ijazah"><i class="ti ti-cloud-upload"></i></label>
                                                            <a href="javascript:void(0);" class="btn btn-outline-primary" style="padding-top:16" onclick="window.location='{{ url('storage/' . substr($list['show']->filename_sma, 7, 1000)) }}'" data-bs-toggle="tooltip" data-bs-offset="0,4"
                                                                data-bs-placement="bottom" data-bs-html="true" title="Download Ijazah"><i class="ti ti-cloud-download"></i></a>
                                                        @else
                                                            <label class="btn btn-outline-secondary" style="padding-top:16" for="upload_sma" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom"
                                                                data-bs-html="true" title="Upload Ijazah"><i class="ti ti-cloud-upload"></i></label>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="mb-3">
                                                    <label class="form-label">Diploma 2</label>
                                                    <div class="input-group mb-3">
                                                        <input type="text" class="form-control" name="d2" value="{{ $list['show']->d2 }}" placeholder="Nama Universitas">
                                                        <input type="number" class="form-control" name="th_d2" value="{{ $list['show']->th_d2 }}" placeholder ="Tahun Lulus">
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <input type="file" class="form-control" id="upload_d2" name="upload_d2" value="{{ $list['show']->filename_d2 }}" accept="application/pdf">
                                                        @if ($list['show']->filename_d2)
                                                            <label class="btn btn-outline-secondary" style="padding-top:16" for="upload_d2" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom"
                                                                data-bs-html="true" title="Upload Ijazah"><i class="ti ti-cloud-upload"></i></label>
                                                            <a href="javascript:void(0);" class="btn btn-outline-primary" style="padding-top:16" onclick="window.location='{{ url('storage/' . substr($list['show']->filename_d2, 7, 1000)) }}'" data-bs-toggle="tooltip" data-bs-offset="0,4"
                                                                data-bs-placement="bottom" data-bs-html="true" title="Download Ijazah"><i class="ti ti-cloud-download"></i></a>
                                                        @else
                                                            <label class="btn btn-outline-secondary" style="padding-top:16" for="upload_d2" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom"
                                                                data-bs-html="true" title="Upload Ijazah"><i class="ti ti-cloud-upload"></i></label>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="mb-3">
                                                    <label class="form-label">Diploma 3</label>
                                                    <div class="input-group mb-3">
                                                        <input type="text" class="form-control" name="d3" value="{{ $list['show']->d3 }}" placeholder="Nama Universitas">
                                                        <input type="number" class="form-control" name="th_d3" value="{{ $list['show']->th_d3 }}" placeholder ="Tahun Lulus">
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <input type="file" class="form-control" id="upload_d3" name="upload_d3" value="{{ $list['show']->filename_d3 }}" accept="application/pdf">
                                                        @if ($list['show']->filename_d3)
                                                            <label class="btn btn-outline-secondary" style="padding-top:16" for="upload_d3" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom"
                                                                data-bs-html="true" title="Upload Ijazah"><i class="ti ti-cloud-upload"></i></label>
                                                            <a href="javascript:void(0);" class="btn btn-outline-primary" style="padding-top:16" onclick="window.location='{{ url('storage/' . substr($list['show']->filename_d3, 7, 1000)) }}'" data-bs-toggle="tooltip" data-bs-offset="0,4"
                                                                data-bs-placement="bottom" data-bs-html="true" title="Download Ijazah"><i class="ti ti-cloud-download"></i></a>
                                                        @else
                                                            <label class="btn btn-outline-secondary" style="padding-top:16" for="upload_d3" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom"
                                                                data-bs-html="true" title="Upload Ijazah"><i class="ti ti-cloud-upload"></i></label>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="mb-3">
                                                    <label class="form-label">Diploma 4</label>
                                                    <div class="input-group mb-3">
                                                        <input type="text" class="form-control" name="d4" value="{{ $list['show']->d4 }}" placeholder="Nama Universitas">
                                                        <input type="number" class="form-control" name="th_d4" value="{{ $list['show']->th_d4 }}" placeholder ="Tahun Lulus">
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <input type="file" class="form-control" id="upload_d4" name="upload_d4" value="{{ $list['show']->filename_d4 }}" accept="application/pdf">
                                                        @if ($list['show']->filename_d4)
                                                            <label class="btn btn-outline-secondary" style="padding-top:16" for="upload_d4" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom"
                                                                data-bs-html="true" title="Upload Ijazah"><i class="ti ti-cloud-upload"></i></label>
                                                            <a href="javascript:void(0);" class="btn btn-outline-primary" style="padding-top:16" onclick="window.location='{{ url('storage/' . substr($list['show']->filename_d4, 7, 1000)) }}'" data-bs-toggle="tooltip" data-bs-offset="0,4"
                                                                data-bs-placement="bottom" data-bs-html="true" title="Download Ijazah"><i class="ti ti-cloud-download"></i></a>
                                                        @else
                                                            <label class="btn btn-outline-secondary" style="padding-top:16" for="upload_d4" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom"
                                                                data-bs-html="true" title="Upload Ijazah"><i class="ti ti-cloud-upload"></i></label>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="mb-3">
                                                    <label class="form-label">Strata 1</label>
                                                    <div class="input-group mb-3">
                                                        <input type="text" class="form-control" name="s1" value="{{ $list['show']->s1 }}" placeholder="Nama Universitas">
                                                        <input type="number" class="form-control" name="th_s1" value="{{ $list['show']->th_s1 }}" placeholder ="Tahun Lulus">
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <input type="file" class="form-control" id="upload_s1" name="upload_s1" value="{{ $list['show']->filename_s1 }}" accept="application/pdf">
                                                        @if ($list['show']->filename_s1)
                                                            <label class="btn btn-outline-secondary" style="padding-top:16" for="upload_s1" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom"
                                                                data-bs-html="true" title="Upload Ijazah"><i class="ti ti-cloud-upload"></i></label>
                                                            <a href="javascript:void(0);" class="btn btn-outline-primary" style="padding-top:16" onclick="window.location='{{ url('storage/' . substr($list['show']->filename_s1, 7, 1000)) }}'" data-bs-toggle="tooltip" data-bs-offset="0,4"
                                                                data-bs-placement="bottom" data-bs-html="true" title="Download Ijazah"><i class="ti ti-cloud-download"></i></a>
                                                        @else
                                                            <label class="btn btn-outline-secondary" style="padding-top:16" for="upload_s1" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom"
                                                                data-bs-html="true" title="Upload Ijazah"><i class="ti ti-cloud-upload"></i></label>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="mb-3">
                                                    <label class="form-label">Strata 1 <b>Khusus Profesi</b></label>
                                                    <div class="input-group mb-3">
                                                        <input type="text" class="form-control" name="s1_profesi" value="{{ $list['show']->s1_profesi }}" placeholder="Nama Universitas">
                                                        <input type="number" class="form-control" name="th_s1_profesi" value="{{ $list['show']->th_s1_profesi }}" placeholder ="Tahun Lulus">
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <input type="file" class="form-control" id="upload_s1_profesi" name="upload_s1_profesi" value="{{ $list['show']->filename_s1_profesi }}" accept="application/pdf">
                                                        @if ($list['show']->filename_s1_profesi)
                                                            <label class="btn btn-outline-secondary" style="padding-top:16" for="upload_s1_profesi" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom"
                                                                data-bs-html="true" title="Upload Ijazah"><i class="ti ti-cloud-upload"></i></label>
                                                            <a href="javascript:void(0);" class="btn btn-outline-primary" style="padding-top:16" onclick="window.location='{{ url('storage/' . substr($list['show']->filename_s1_profesi, 7, 1000)) }}'" data-bs-toggle="tooltip" data-bs-offset="0,4"
                                                                data-bs-placement="bottom" data-bs-html="true" title="Download Ijazah"><i class="ti ti-cloud-download"></i></a>
                                                        @else
                                                            <label class="btn btn-outline-secondary" style="padding-top:16" for="upload_s1_profesi" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom"
                                                                data-bs-html="true" title="Upload Ijazah"><i class="ti ti-cloud-upload"></i></label>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="mb-3">
                                                    <label class="form-label">Strata 2</label>
                                                    <div class="input-group mb-3">
                                                        <input type="text" class="form-control" name="s2" value="{{ $list['show']->s2 }}" placeholder="Nama Universitas">
                                                        <input type="number" class="form-control" name="th_s2" value="{{ $list['show']->th_s2 }}" placeholder ="Tahun Lulus">
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <input type="file" class="form-control" id="upload_s2" name="upload_s2" value="{{ $list['show']->filename_s2 }}" accept="application/pdf">
                                                        @if ($list['show']->filename_s2)
                                                            <label class="btn btn-outline-secondary" style="padding-top:16" for="upload_s2" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom"
                                                                data-bs-html="true" title="Upload Ijazah"><i class="ti ti-cloud-upload"></i></label>
                                                            <a href="javascript:void(0);" class="btn btn-outline-primary" style="padding-top:16" onclick="window.location='{{ url('storage/' . substr($list['show']->filename_s2, 7, 1000)) }}'" data-bs-toggle="tooltip" data-bs-offset="0,4"
                                                                data-bs-placement="bottom" data-bs-html="true" title="Download Ijazah"><i class="ti ti-cloud-download"></i></a>
                                                        @else
                                                            <label class="btn btn-outline-secondary" style="padding-top:16" for="upload_s2" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom"
                                                                data-bs-html="true" title="Upload Ijazah"><i class="ti ti-cloud-upload"></i></label>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="">
                                                    <label class="form-label">Strata 3</label>
                                                    <div class="input-group mb-3">
                                                        <input type="text" class="form-control" name="s3" value="{{ $list['show']->s3 }}" placeholder="Nama Universitas">
                                                        <input type="number" class="form-control" name="th_s3" value="{{ $list['show']->th_s3 }}" placeholder="Tahun Lulus">
                                                    </div>
                                                    <div class="input-group">
                                                        <input type="file" class="form-control" id="upload_s3" name="upload_s3" value="{{ $list['show']->filename_s3 }}" accept="application/pdf">
                                                        @if ($list['show']->filename_s3)
                                                            <label class="btn btn-outline-secondary" style="padding-top:16" for="upload_s3" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom"
                                                                data-bs-html="true" title="Upload Ijazah"><i class="ti ti-cloud-upload"></i></label>
                                                            <a href="javascript:void(0);" class="btn btn-outline-primary" style="padding-top:16" onclick="window.location='{{ url('storage/' . substr($list['show']->filename_s3, 7, 1000)) }}'" data-bs-toggle="tooltip" data-bs-offset="0,4"
                                                                data-bs-placement="bottom" data-bs-html="true" title="Download Ijazah"><i class="ti ti-cloud-download"></i></a>
                                                        @else
                                                            <label class="btn btn-outline-secondary" style="padding-top:16" for="upload_s3" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom"
                                                                data-bs-html="true" title="Upload Ijazah"><i class="ti ti-cloud-upload"></i></label>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 text-end btn-page">
                                <button type="submit" class="btn btn-primary" id="btn-submit-profil"><i class="ti ti-rocket"></i>&nbsp;&nbsp;Perbarui</button>
                            </div>
                        </div>
                    </form>
                </div>

                {{-- UBAH DOKUMEN --}}
                <div class="tab-pane" id="upload-dokumen" role="tabpanel" aria-labelledby="upload-dokumen-tab-3">
                    <div class="card table-card">
                        <div class="card-header d-flex align-items-center justify-content-between py-3">
                            <h5 class="mb-0 card-title flex-grow-1">Penyimpanan Dokumen</h5>
                            <div class="flex-shrink-0">
                                {{-- <div class="btn-group">
                                    <button type="button" class="btn btn-link-warning" id="btn-refresh"
                                    data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="Refresh Tabel Dokumen" onclick="refreshDokumen()">
                                        <i class="fa-fw fas fa-sync nav-icon me-1"></i>Segarkan</button>
                                </div> --}}
                            </div>
                        </div>
                        <div class="card-body p-b-0 p-3">
                            <div class="d-flex align-items-center justify-content-between">
                                <h4 class="mb-0 flex-grow-1"><a class="text-danger">*</a>/2 <small>dokumen wajib sudah terupload.</small></h4>
                                <div class="flex-shrink-0" id="switch-str" hidden>
                                    <div class="form-check form-switch custom-switch-v1 switch-sm">
                                        <input type="checkbox" class="form-check-input input-primary" id="checkboxseumurhidup">
                                        <label class="form-check-label" for="checkboxseumurhidup">Seumur Hidup ?</label>
                                    </div>
                                </div>
                            </div>
                            <hr class="my-2">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Jenis Surat <span class="text-danger">*</span></label>
                                        <select class="form-control" id="jenis_dokumen">
                                            <option value="" selected hidden>Pilih Jenis Surat</option>
                                            @if (count($list['ref_dokumen']) > 0)
                                                @foreach ($list['ref_dokumen'] as $item)
                                                    <option value="{{ $item->id }}">{{ $item->deskripsi }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Tgl. Mulai Berlaku <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" id="tgl_mulai_dokumen">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Tgl. Berakhir Surat <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" id="tgl_akhir_dokumen">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Nomor Surat <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="no_surat_dokumen">
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Deskripsi</label>
                                        <textarea id="deskripsi_dokumen" class="form-control" placeholder="Tuliskan Keterangan (Optional)" rows="1"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Upload Dokumen <span class="text-danger">*</span></label>
                                        <div class="row">
                                            <div class="col"><input type="file" class="form-control" id="upload_dokumen" accept="application/pdf"></div>
                                            <div class="col-auto"><button class="btn btn-primary" onclick="prosesTambahDokumen()" id="btn-upload-dokumen"><i class="fas fa-upload me-1"></i> Upload</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table mb-0 table-hover" id="dttable-dokumen">
                                    <thead>
                                        <tr>
                                            <th><center>AKSI</center></th>
                                            <th>DOKUMEN SURAT</th>
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

                {{-- UBAH FOTO PROFIL --}}
                <div class="tab-pane" id="ubah-foto-profil" role="tabpanel" aria-labelledby="ubah-foto-profil-tab-4">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Ubah Foto Profil</h5>
                                </div>
                                <div class="card-body">
                                    <div class="container">
                                        <div class="bg-light px-4 py-3 mb-3">
                                            <form id="formUpdateFotoProfil" class="form-auth-small needs-validation" action="{{ route('profil.ubahfoto') }}" method="POST" enctype="multipart/form-data" novalidate>
                                                {{ csrf_field() }}
                                                <h5 class="mb-3">Pilih Foto</h5>
                                                <input type="text" class="form-control" value="{{ $list['show']->id }}" name="id" hidden>
                                                <input type="file" name="file" id="fileInput" accept="image/*" class="form-control mb-3" required/>
                                                <small>
                                                    <i class="fa-fw fas fa-caret-right nav-icon me-1"></i>Silakan upload file foto formal<br>
                                                    <i class="fa-fw fas fa-caret-right nav-icon me-1"></i>File foto tidak boleh melebihi 5 mb<br>
                                                    <i class="fa-fw fas fa-caret-right nav-icon me-1"></i>Foto disarankan berasio 1:1<br>
                                                </small>
                                                <br>
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#pratinjau" class="btn btn-link-danger">Pratinjau</a>
                                                    <button type="submit" id="btn-submit-fotoprofil" class="btn btn-outline-primary">Perbarui</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- START CROPPER COBA-COBA............................................................................................ --}}
                        {{-- <div class="col-md-12 mb-3">
                            <div class="bg-light px-4 py-3 mb-3">
                                <h5>Pilih Foto Profil</h5>
                                <input type="file" id="fileInput" accept="image/*" class="form-control mb-3"/>
                                <small>
                                    <i class="fa-fw fas fa-caret-right nav-icon me-1"></i>Silakan upload file foto formal<br>
                                    <i class="fa-fw fas fa-caret-right nav-icon me-1"></i>File foto tidak boleh melebihi 5 mb<br>
                                </small>
                                <div class="btn-group">
                                    <button type="button" id="btnCrop" value="Crop" class="btn btn-link-warning">Potong</button>
                                    <button type="button" id="btnRestore" value="Restore" class="btn btn-link-danger">Bersihkan</button>
                                    <button type="submit" id="btnSubmit" class="btn btn-link-primary">Perbarui / Simpan</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <center>
                                <div id="result" class="rounded align-middle shadow-lg p-t-40" style="height: 580px;width: 100%">
                                    <h5 class="mb-3">Foto Profil Sekarang</h5>
                                    @if (empty($list['foto']->filename))
                                        <img src="{{ asset('images/pku/user.png') }}" alt="Tidak ada lampiran">
                                    @else
                                        <img src="{{ url('storage/'.substr($list['foto']->filename,7,1000)) }}" alt="" height="500" width="500">
                                    @endif
                                </div>
                            </center>
                        </div>
                        <div class="col-md-6 mb-3">
                            <center>
                                <div id="blah_a" class="rounded align-middle shadow-lg p-t-40" style="height: 580px;width: 100%">
                                    <h5 class="mb-3">Foto Profil Baru</h5>
                                    <img id="blah" src="" alt="Tidak ada lampiran">
                                </div>
                            </center>
                        </div> --}}
                        {{-- END CROPPER COBA-COBA............................................................................................ --}}
                    </div>
                </div>

                {{-- PRATINJAU FOTO PROFIL --}}
                <div class="modal fade " id="pratinjau" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Pratinjau Foto Profl</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <center>
                                    {{-- <a class="image-popup-vertical-fit" id="blah_a" href="">
                                        <img class="card-img-top" id="blah" src="{{ asset('images/no-image.png') }}"
                                            alt="Tidak ada lampiran">
                                    </a> --}}
                                    <div id="blah_a" class="align-middle text-center mb-3">
                                        {{-- {{ asset('images/no-image.png') }} --}}
                                        <img id="blah" src="" alt="Belum ada foto terupload">
                                    </div>
                                    <button type="reset" class="btn btn-link-secondary" data-bs-dismiss="modal" aria-label="Close"><i class="fa-fw fas fa-times nav-icon"></i> Tutup</button>
                                </center>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- UBAH PASSWORD --}}
                <div class="tab-pane" id="ubah-password" role="tabpanel" aria-labelledby="profile-tab-5">
                    <div class="card">
                        <form action="{{ route('auth.change_password') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <div class="card-header">
                                <h5>Ubah Password</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="alert alert-light" role="alert">
                                            <h5 class="alert-heading fw-bold mb-3">Keamanan Password</h5>
                                            <span>
                                                <ul>
                                                    <li class="mb-2">Jangan berikan <strong>Password</strong> anda kepada orang lain</li>
                                                    <li class="mb-2">Password akan diproses melalui metode <i>Bcrypt Hash Password</i> oleh sistem</li>
                                                    <li>Apabila anda lupa Password akun Simrsmu, silakan masuk ke laman <b>Lupa Password</b>
                                                        pada halaman Login</li>
                                                </ul>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label">Password Lama <a class="text-danger">*</a></label>
                                            <input type="password" class="form-control" id="oldPassword" name="current_password"
                                            placeholder="&#xb7;&nbsp;&#xb7;&nbsp;&#xb7;&nbsp;&#xb7;&nbsp;&#xb7;&nbsp;&#xb7;&nbsp;&#xb7;&nbsp;&#xb7;&nbsp;&#xb7;&nbsp;&#xb7;" required>
                                            {{-- <div class="valid-feedback">
                                                Looks good!
                                            </div> --}}
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Password Baru <a class="text-danger">*</a></label>
                                            <input type="password" class="form-control is-invalid" id="newPassword" name="new_password"
                                            placeholder="&#xb7;&nbsp;&#xb7;&nbsp;&#xb7;&nbsp;&#xb7;&nbsp;&#xb7;&nbsp;&#xb7;&nbsp;&#xb7;&nbsp;&#xb7;&nbsp;&#xb7;&nbsp;&#xb7;" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Konfirmasi Password Baru <a class="text-danger">*</a></label>
                                            <input type="password" class="form-control is-invalid" id="confirmPassword" name="new_password_confirmation"
                                            placeholder="&#xb7;&nbsp;&#xb7;&nbsp;&#xb7;&nbsp;&#xb7;&nbsp;&#xb7;&nbsp;&#xb7;&nbsp;&#xb7;&nbsp;&#xb7;&nbsp;&#xb7;&nbsp;&#xb7;" required>
                                            <small>Tuliskan password yang sama untuk konfirmasi password baru Anda </small>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <h5>Password harus memenuhi kriteria</h5>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item requirements">
                                                <i class="ti ti-circle-check text-danger f-16 me-2 leng"></i> Melebihi lebih 8 karakter
                                            </li>
                                            {{-- <li class="list-group-item requirements">
                                                <i class="ti ti-circle-check text-success f-16 me-2"></i> At least 1 lower letter (a-z)
                                            </li> --}}
                                            <li class="list-group-item requirements">
                                                <i class="ti ti-circle-check text-danger f-16 me-2 big-letter"></i> Minimal 1 Huruf Kapital (A-Z)
                                            </li>
                                            <li class="list-group-item requirements">
                                                <i class="ti ti-circle-check text-danger f-16 me-2 num"></i> Minimal 1 Angka (0-9)
                                            </li>
                                            <li class="list-group-item requirements">
                                                <i class="ti ti-circle-check text-danger f-16 me-2 special-char"></i> Minimal 1 Karakter Khusus (!@#$%^&*)
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-end btn-page pb-0 pt-3 pe-2">
                                {{-- <div class="btn btn-outline-secondary">Cancel</div> --}}
                                <button class="btn btn-secondary" type="submit" value="Submit" id="btn-submit-password" disabled><i class="ti ti-rocket"></i>&nbsp;&nbsp;Perbarui</button>
                            </div>
                    </div>
                </div>

                {{-- SPK & RKK --}}
                <div class="tab-pane" id="spkrkk" role="tabpanel" aria-labelledby="spkrkk-tab-3">
                    <div class="card table-card">
                        <div class="card-header d-flex align-items-center justify-content-between py-3">
                            <h5 class="mb-0 card-title flex-grow-1">SPK RKK</h5>
                            <div class="flex-shrink-0">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-link-warning" id="btn-refresh"
                                    data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="Refresh Tabel Dokumen" onclick="refreshSpkrkk()">
                                        <i class="fa-fw fas fa-sync nav-icon me-1"></i>Segarkan</button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
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
                                    <tfoot>
                                        <tr>
                                            <th><center>AKSI</center></th>
                                            <th>RECORD</th>
                                            <th>TGL BERAKHIR</th>
                                            <th>DESKRIPSI</th>
                                            <th class="text-end">TERAKHIR DIUBAH</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        {{-- <div class="card-footer text-end btn-page">
                            <div class="btn btn-link-danger">Cancel</div>
                            <div class="btn btn-primary">Update Profile</div>
                        </div> --}}
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
    {{-- MODAL UBAH --}}
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

    {{-- MODAL HAPUS --}}
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

    <script>
        addEventListener("DOMContentLoaded", (event) => {
            // "use strict";
            const password = document.getElementById("newPassword");
            const cpassword = document.getElementById("confirmPassword");
            const leng = $(".leng");
            const bigLetter = $(".big-letter");
            const num = $(".num");
            const specialChar = $(".special-char");
            var isPasswordValid = null;

            password.addEventListener("input", () => {
                const value = password.value;
                const isLengthValid = value.length >= 8;
                const hasUpperCase = /[A-Z]/.test(value);
                const hasNumber = /\d/.test(value);
                const hasSpecialChar = /[!@#$%^&*()\[\]{}\\|;:'",<.>/?`~]/.test(value);

                // RESET INPUT KONFIRMASI PASSWORD
                cpassword.value = '';
                $('#btn-submit-password').prop('disabled', true);
                $('#btn-submit-password').removeClass("btn-primary");
                $('#btn-submit-password').addClass("btn-secondary");
                cpassword.classList.remove("is-valid");
                cpassword.classList.add("is-invalid");

                isPasswordValid = isLengthValid && hasUpperCase && hasNumber && hasSpecialChar;

                // PANJANG MINIMAL 8 KARAKTER
                if (isLengthValid == true) {
                    leng.removeClass('ti-circle-x text-danger');
                    leng.addClass('ti-circle-check text-success');
                } else {
                    leng.removeClass('ti-circle-check text-success');
                    leng.addClass('ti-circle-x text-danger');
                }
                // MINIMAL 1 HURUF BESAR
                if (hasUpperCase == true) {
                    bigLetter.removeClass('ti-circle-x text-danger');
                    bigLetter.addClass('ti-circle-check text-success');
                } else {
                    bigLetter.removeClass('ti-circle-check text-success');
                    bigLetter.addClass('ti-circle-x text-danger');
                }
                // MINIMAL 1 ANGKA
                if (hasNumber == true) {
                    num.removeClass('ti-circle-x text-danger');
                    num.addClass('ti-circle-check text-success');
                } else {
                    num.removeClass('ti-circle-check text-success');
                    num.addClass('ti-circle-x text-danger');
                }
                // MINIMAL 1 KARAKTER KHUSUS
                if (hasSpecialChar == true) {
                    specialChar.removeClass('ti-circle-x text-danger');
                    specialChar.addClass('ti-circle-check text-success');
                } else {
                    specialChar.removeClass('ti-circle-check text-success');
                    specialChar.addClass('ti-circle-x text-danger');
                }

                // CEKLIS INPUT
                if (isPasswordValid) {
                    password.classList.remove("is-invalid");
                    password.classList.add("is-valid");
                } else {
                    password.classList.remove("is-valid");
                    password.classList.add("is-invalid");
                }
            });

            // VALIDASI KONFIRMASI PASSWORD
            cpassword.addEventListener("input", () => {
                if (password.value == cpassword.value && isPasswordValid) {
                    $('#btn-submit-password').prop('disabled', false);
                    $('#btn-submit-password').removeClass("btn-secondary");
                    $('#btn-submit-password').addClass("btn-primary");
                    cpassword.classList.remove("is-invalid");
                    cpassword.classList.add("is-valid");
                } else {
                    $('#btn-submit-password').prop('disabled', true);
                    $('#btn-submit-password').removeClass("btn-primary");
                    $('#btn-submit-password').addClass("btn-secondary");
                    cpassword.classList.remove("is-valid");
                    cpassword.classList.add("is-invalid");
                }
            });

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

            // IMG CROPPER
            // var canvas  = $("#canvas"),
            //     context = canvas.get(0).getContext("2d"),
            //     $result = $('#result');

            // $('#fileInput').on( 'change', function(){
            //     if (this.files && this.files[0]) {
            //         if ( this.files[0].type.match(/^image\//) ) {
            //             var reader = new FileReader();
            //             reader.onload = function(evt) {
            //                 var img = new Image();
            //                 img.onload = function() {
            //                     context.canvas.height = img.height;
            //                     context.canvas.width  = img.width;
            //                     context.drawImage(img, 0, 0);
            //                     var cropper = canvas.cropper({
            //                         aspectRatio: 1 / 1
            //                     });
            //                     $('#btnCrop').click(function() {
            //                         $result.empty();
            //                         // Get a string base 64 data url
            //                         var croppedImageDataURL = canvas.cropper('getCroppedCanvas').toDataURL("image/png");
            //                         $result.append( $('<img>').attr('src', croppedImageDataURL).height(500).width(500) );
            //                         console.log(croppedImageDataURL);
            //                     });
            //                     $('#btnRestore').click(function() {
            //                         canvas.cropper('reset');
            //                         $result.empty();
            //                     });
            //                     $('#btnSubmit').on('click', function (event) {
            //                         canvas.cropper('getCroppedCanvas').toBlob(function (blob) {
            //                             var formData = new FormData();
            //                             formData.append('croppedImage', blob);
            //                             console.log(blob);

            //                             $.ajax("/api/profil/fotoprofil", {
            //                                 method: "POST",
            //                                 data: formData,
            //                                 processData: false,
            //                                 contentType: false,
            //                                 success: function () {
            //                                     alert('Upload success');
            //                                     // location.reload();
            //                                 },
            //                                 error: function () {
            //                                     alert('Upload error');
            //                                 }
            //                             });
            //                         });
            //                     });
            //                 };
            //                 img.src = evt.target.result;
            //             };
            //             reader.readAsDataURL(this.files[0]);
            //             console.log()
            //         }
            //         else {
            //             alert("Invalid file type! Please select an image file.");
            //         }
            //     }
            //     else {
            //         alert('No file(s) selected.');
            //     }
            // });


            // $("#fileInput").change(function() {
            //     readURL(this);
            // });
            refreshDokumen();

            var divswitchstr    = $("#switch-str");
            var switchstr       = $("#checkboxseumurhidup");
            var jenis           = $("#jenis_dokumen");
            var tgl_mulai       = $("#tgl_mulai_dokumen");
            var tgl_akhir       = $("#tgl_akhir_dokumen");
            var no_surat        = $("#no_surat_dokumen");
            var deskripsi       = $("#deskripsi_dokumen");
            var upload          = $("#upload_dokumen");

            jenis.change(function() {
                // INIT
                switchstr.prop('checked', false);
                tgl_mulai.prop('disabled',false);
                tgl_akhir.prop('disabled',false);
                no_surat.prop('disabled',false);
                deskripsi.prop('disabled',false);
                upload.prop('disabled',false);

                if (jenis.val() == 139) { // STR
                    divswitchstr.prop('hidden',false);
                } else {
                    divswitchstr.prop('hidden',true);
                }

                if (jenis.val() == 141 || jenis.val() == 153) { // BTCLS & ACLS
                    tgl_mulai.prop('disabled',true);
                    no_surat.prop('disabled',true);
                    deskripsi.prop('disabled',true);
                } else {
                    tgl_mulai.prop('disabled',false);
                    no_surat.prop('disabled',false);
                    deskripsi.prop('disabled',false);
                }
            })

            switchstr.change(function() {
                // var validateStr = switchstr.is(":checked");
                if (switchstr.is(":checked")) {
                    tgl_mulai.prop('disabled',true);
                    tgl_akhir.prop('disabled',true);
                    deskripsi.prop('disabled',true);
                    // upload.prop('disabled',true);
                } else {
                    tgl_mulai.prop('disabled',false);
                    tgl_akhir.prop('disabled',false);
                    deskripsi.prop('disabled',false);
                    // upload.prop('disabled',false);
                }
            })

            // VALIDASI DATA PENDIDIKAN
            $("input[name='sd']").on("keyup change", function(e) {
                if ($("input[name='sd']").val().length == 0) { // $("input[name='th_sd']").val() <= 0
                    $("#upload_sd").prop('disabled',true).prop('required',false).val('');
                    $("input[name='th_sd']").prop('disabled',true).val('');
                    $("#wajib_sd").prop('hidden',true);
                } else {
                    $("#upload_sd").prop('disabled',false).prop('required',true);
                    $("input[name='th_sd']").prop('disabled',false);
                    $("#wajib_sd").prop('hidden',false);
                }
            })
            $("input[name='smp']").on("keyup change", function(e) {
                if ($("input[name='smp']").val().length == 0) {
                    $("#upload_smp").prop('disabled',true).prop('required',false).val('');
                    $("input[name='th_smp']").prop('disabled',true).val('');
                    $("#wajib_smp").prop('hidden',true);
                } else {
                    $("#upload_smp").prop('disabled',false).prop('required',true);
                    $("input[name='th_smp']").prop('disabled',false);
                    $("#wajib_smp").prop('hidden',false);
                }
            })
        });

        // FUNCTION
        function prosesTambahDokumen() {
            $("#btn-upload-dokumen").prop('disabled', true);
            $("#btn-upload-dokumen").find("i").toggleClass("fa-upload fa-sync fa-spin");

            var user_id         = "{{ Auth::user()->id }}";
            var jenis           = $("#jenis_dokumen").val();
            var tgl_mulai       = $("#tgl_mulai_dokumen").val();
            var tgl_akhir       = $("#tgl_akhir_dokumen").val();
            var no_surat        = $("#no_surat_dokumen").val();
            var deskripsi       = $("#deskripsi_dokumen").val();
            var filex           = $('#upload_dokumen')[0].files.length;
            var switchstr       = $("#checkboxseumurhidup").is(":checked");
            var validasi        = true;

            // PROSES VALIDASI INPUT DOKUMEN
            if (jenis == '') {
                validasi = false;
            } else {
                if (jenis == 139) { // STR
                    if (switchstr) { // STR SEUMUR HIDUP
                        if (jenis == '' || no_surat == '' || filex == 0) {
                            validasi = false;
                        }
                    } else { // STR BELUM SEUMUR HIDUP
                        if (jenis == '' || tgl_mulai == '' || tgl_akhir == '' || no_surat == '' || filex == 0) {
                            validasi = false;
                        } else {
                            if (tgl_mulai == tgl_akhir) {
                                validasi = false;
                                iziToast.error({
                                    title: 'Pesan Galat!',
                                    message: 'Tanggal Mulai Berlaku tidak diperbolehkan sama dengan Tanggal Berakhir Surat',
                                    position: 'topRight'
                                });
                            }
                        }
                    }
                } else {
                    if (jenis == 141 || jenis == 153) { // BTCLS/ACLS
                        if (jenis == '' || tgl_akhir == '' || filex == 0) {
                            validasi = false;
                        }
                    } else { // INPUT JENIS LAINNYA
                        if (jenis == '' || tgl_mulai == '' || tgl_akhir == '' || no_surat == '' || filex == 0) {
                            validasi = false;
                        } else {
                            if (tgl_mulai == tgl_akhir) {
                                validasi = false;
                                iziToast.error({
                                    title: 'Pesan Galat!',
                                    message: 'Tanggal Mulai Berlaku tidak diperbolehkan sama dengan Tanggal Berakhir Surat',
                                    position: 'topRight'
                                });
                            }
                        }
                    }
                }
            }

            // PROSES SIMPAN DOKUMEN
            if (validasi == false) {
                iziToast.warning({
                    title: 'Pesan Ambigu!',
                    message: 'Mohon lengkapi semua data (<span class="text-danger">*</span>) terlebih dahulu dan pastikan tidak ada yang kosong',
                    position: 'topRight'
                });
            } else {
                var fd = new FormData();

                // Get the selected file
                var files = $('#upload_dokumen')[0].files;

                fd.append('file',files[0]);
                fd.append('user_id',user_id);
                fd.append('jenis',jenis);
                fd.append('tgl_mulai',tgl_mulai);
                fd.append('tgl_akhir',tgl_akhir);
                fd.append('no_surat',no_surat);
                fd.append('deskripsi',deskripsi);

                // AJAX request
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{route('profil.storeDokumen')}}",
                    method: 'post',
                    data: fd,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(res){
                        iziToast.success({
                            title: 'Pesan Sukses!',
                            message: 'Dokumen bernama berhasil ditambahkan pada '+res,
                            position: 'topRight'
                        });
                        if (res) {
                            refreshDokumen();
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

            $("#btn-upload-dokumen").find("i").removeClass("fa-sync fa-spin").addClass("fa-upload");
            $("#btn-upload-dokumen").prop('disabled', false);
        }

        function showUbahDokumen(id) {
            $.ajax(
            {
                url: "/api/profil/dokumen/ubah/"+id,
                type: 'GET',
                dataType: 'json', // added data type
                success: function(res) {
                    $("#id_edit_dokumen").val(id);
                    $("#jenis_dokumen_edit").find('option').remove();
                    res.ref_dokumen.forEach(item => {
                        $("#jenis_dokumen_edit").append(`
                            <option value="${item.id}" ${item.id == res.show.ref_id? "selected":""}>${item.deskripsi}</option>
                        `);
                    });
                    $('#tgl_mulai_dokumen_edit').val(res.show.tgl_mulai);
                    $('#tgl_akhir_dokumen_edit').val(res.show.tgl_akhir);
                    $('#no_surat_dokumen_edit').val(res.show.no_surat);
                    $('#deskripsi_dokumen_edit').val(res.show.deskripsi);
                    $('#lampiran_edit').text(res.show.title);
                    $('#ubahDokumen').modal('show');
                }
            })
        }

        function prosesUbahDokumen()
        {
            $("#btn-ubah-dokumen").prop('disabled', true);
            $("#btn-ubah-dokumen").find("i").toggleClass("fa-edit fa-sync fa-spin");

            var jenis       = $("#jenis_dokumen_edit").val();
            var tgl_mulai   = $("#tgl_mulai_dokumen_edit").val();
            var tgl_akhir   = $("#tgl_akhir_dokumen_edit").val();
            var no_surat    = $("#no_surat_dokumen_edit").val();
            var deskripsi    = $("#deskripsi_dokumen_edit").val();

            if (jenis == "" || tgl_mulai == "" || tgl_akhir == "" || no_surat == "") {
                iziToast.error({
                    title: 'Pesan Galat!',
                    message: 'Mohon lengkapi kolom pengisian wajib *',
                    position: 'topRight'
                });
            } else {
                var fd = new FormData();
                var id_edit = $("#id_edit_dokumen").val();

                // Get the selected file
                // if ($("#verifberkas"+id_edit).val() == 1) {
                //     var files = $('#filex'+id_edit)[0].files;
                //     fd.append('file',files[0]);
                // }

                fd.append('id',id_edit);
                fd.append('jenis',jenis);
                fd.append('tgl_mulai',tgl_mulai);
                fd.append('tgl_akhir',tgl_akhir);
                fd.append('no_surat',no_surat);
                fd.append('deskripsi',deskripsi);

                // AJAX request
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "/api/profil/dokumen/ubah/"+id_edit+"/proses",
                    method: 'post',
                    data: fd,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(res){
                        iziToast.success({
                            title: 'Pesan Sukses!',
                            message: 'Dokumen berhasil diperbarui pada '+res,
                            position: 'topRight'
                        });
                        if (res) {
                            $('#ubahDokumen').modal('hide');
                            refreshDokumen();
                            // window.location.reload();
                        }
                    },
                    error: function(res){
                        console.log("error : " + JSON.stringify(res) );
                    }
                });
            }

            $("#btn-ubah-dokumen").find("i").removeClass("fa-sync fa-spin").addClass("fa-edit");
            $("#btn-ubah-dokumen").prop('disabled', false);
        }

        function showHapusDokumen(id) {
            $("#id_hapus_dokumen").val(id);
            var inputs = document.getElementById('setujuhapusdokumen');
            inputs.checked = false;
            $('#hapusDokumen').modal('show');
        }

        function prosesHapusDokumen() {
            // SWITCH BTN HAPUS
            var checkboxHapusDokumen = $('#setujuhapusdokumen').is(":checked");
            if (checkboxHapusDokumen == false) {
                iziToast.error({
                    title: 'Pesan Galat!',
                    message: 'Mohon menyetujui untuk dilakukan penghapusan berkas',
                    position: 'topRight'
                });
            } else {
                // PROSES HAPUS
                var id = $("#id_hapus_dokumen").val();
                $.ajax({
                    url: "/api/profil/dokumen/hapus/"+id+"/proses",
                    type: 'DELETE',
                    dataType: 'json', // added data type
                    success: function(res) {
                        iziToast.success({
                            title: 'Pesan Sukses!',
                            message: 'Berkas telah berhasil dihapus pada '+res,
                            position: 'topRight'
                        });
                        $('#hapusDokumen').modal('hide');
                        refreshDokumen();
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

        function refreshDokumen() {
            var switchstr       = $("#checkboxseumurhidup");
            var jenis           = $("#jenis_dokumen");
            var tgl_mulai       = $("#tgl_mulai_dokumen");
            var tgl_akhir       = $("#tgl_akhir_dokumen");
            var no_surat        = $("#no_surat_dokumen");
            var deskripsi       = $("#deskripsi_dokumen");
            var upload          = $("#upload_dokumen");

            // INIT
            switchstr.prop('checked', false);
            jenis.val('');
            tgl_mulai.prop('disabled',false).val('');
            tgl_akhir.prop('disabled',false).val('');
            no_surat.prop('disabled',false).val('');
            deskripsi.prop('disabled',false).val('');
            upload.prop('disabled',false).val('');

            // MULAI TABEL
            $("#tampil-tbody-dokumen").empty();
            $("#tampil-tbody-dokumen").empty().append(`<tr><td colspan="9" style="font-size:13px"><center><i class="fa fa-spinner fa-spin fa-fw"></i> Memproses data...</center></td></tr>`);
            $.ajax(
                {
                    url: "/api/profil/dokumen/table/{{ Auth::user()->id }}",
                    type: 'GET',
                    dataType: 'json', // added data type
                    success: function(res) {
                        var adminID = "{{ Auth::user()->getManyRole(['it','kabag-kepegawaian']) }}";
                        var userID = "{{ Auth::user()->id }}";
                        $("#tampil-tbody-dokumen").empty();
                        $('#dttable-dokumen').DataTable().clear().destroy();
                        res.show.forEach(item => {
                            content = "<tr id='data"+ item.id +"'>";
                            content += `<td><center><div class='dropend'><a href='javascript:void(0);' class='btn btn-light btn-sm text-muted font-size-16 rounded' data-bs-toggle='dropdown' aria-haspopup="true"><i class="ti ti-dots"></i></a><div class='dropdown-menu'>`;
                                if (item.title) {
                                    content += `<a href='javascript:void(0);' class='dropdown-item text-primary' onclick="window.open('/profil/dokumen/download/`+item.id+`')"><i class='fas fa-download me-1'></i> Download</a>`;
                                } else {
                                    content += `<a href='javascript:void(0);' class='dropdown-item text-secondary' disabled><i class='fas fa-download me-1'></i> Download</a>`;
                                }
                                if (item.status) {
                                    if (adminID == true) {
                                        content += `<a href='javascript:void(0);' class='dropdown-item text-warning' onclick="showUbahDokumen(`+item.id+`)" value="animate__rubberBand"><i class='fas fa-edit me-1'></i> Ubah</a>`;
                                        content += `<a href='javascript:void(0);' class='dropdown-item text-danger' onclick="showHapusDokumen(`+item.id+`)" value="animate__rubberBand"><i class='fas fa-trash me-1'></i> Hapus</a>`;
                                    } else {
                                        if (item.user_id == userID) {
                                            content += `<a href='javascript:void(0);' class='dropdown-item text-warning' onclick="showUbahDokumen(`+item.id+`)" value="animate__rubberBand"><i class='fas fa-edit me-1'></i> Ubah</a>`;
                                            content += `<a href='javascript:void(0);' class='dropdown-item text-danger' onclick="showHapusDokumen(`+item.id+`)" value="animate__rubberBand"><i class='fas fa-trash me-1'></i> Hapus</a>`;
                                        } else {
                                            content += `<a href='javascript:void(0);' class='dropdown-item text-secondary' value="animate__rubberBand" disabled><i class='fas fa-edit me-1'></i> Ubah</a>`;
                                            content += `<a href='javascript:void(0);' class='dropdown-item text-secondary' value="animate__rubberBand" disabled><i class='fas fa-trash me-1'></i> Hapus</a>`;
                                        }
                                    }
                                } else {
                                    content += `<a href='javascript:void(0);' class='dropdown-item text-secondary' value="animate__rubberBand" disabled><i class='fas fa-edit me-1'></i> Ubah</a>`;
                                    content += `<a href='javascript:void(0);' class='dropdown-item text-secondary' value="animate__rubberBand" disabled><i class='fas fa-trash me-1'></i> Hapus</a>`;
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

        function refreshSpkrkk() {
            // MULAI TABEL
            $("#tampil-tbody-spkrkk").empty();
            $("#tampil-tbody-spkrkk").empty().append(`<tr><td colspan="9" style="font-size:13px"><center><i class="fa fa-spinner fa-spin fa-fw"></i> Memproses data...</center></td></tr>`);
            $.ajax(
                {
                    url: "/api/profil/spkrkk/table/{{ Auth::user()->id }}",
                    type: 'GET',
                    dataType: 'json', // added data type
                    success: function(res) {
                        var adminID = "{{ Auth::user()->getManyRole(['it','kabag-kepegawaian']) }}";
                        var userID = "{{ Auth::user()->id }}";
                        $("#tampil-tbody-spkrkk").empty();
                        $('#dttable-spkrkk').DataTable().clear().destroy();
                        res.show.forEach(item => {
                            content = "<tr id='data"+ item.id +"'>";
                            content += `<td><center>`;
                                if (item.deleted_at == null) {
                                    content += `<a href='javascript:void(0);' class='dropdown-item text-primary' onclick="window.open('/kepegawaian/profilkaryawan/spkrkk/download/`+item.id+`')"><i class='fas fa-download'></i></a>`;
                                } else {
                                    content += `<a href='javascript:void(0);' class='dropdown-item text-secondary'><i class='fas fa-download'></i></a>`;
                                }
                            content += `</center></td>`;
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
                            message: 'SPK & RKK tidak ditemukan.',
                            position: 'topRight'
                        });
                    }
                }
            );
        }

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

        function ubahFotoProfil() {
            $('#fileInput').val();
        }

        $("#fileInput").change(function() {
            readURL(this);
        });

        </script>
@endsection
