@extends('layouts.default')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Profil User</h4>

                @if (Auth::user()->getPermission('admin_profil_karyawan') == true)
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            @if ($list['show']->deleted_at == null)
                                <button class="btn btn-danger btn-sm" onclick="nonaktif({{ $list['show']->id }})"><i class='fa-fw fas fa-user-slash nav-icon'></i>&nbsp;&nbsp;Nonaktifkan User</button>
                            @else
                                <button class="btn btn-primary btn-sm" onclick="batalNonAktif({{ $list['show']->id }})"><i class='fa-fw fas fa-user-check nav-icon'></i>&nbsp;&nbsp;Aktifkan User</button>
                            @endif
                        </li>
                    </ol>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-shrink-0 me-3">
                            @if (empty($list['foto']->filename))
                            <a class="image-popup-no-margins" href="{{ asset('images/pku/user.png') }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Tekan untuk memperbesar foto profil">
                                <img class="img-fluid avatar-sm rounded-circle img-thumbnail" alt="" src="{{ asset('images/pku/user.png') }}" width="75">
                            </a>
                            @else
                            <a class="image-popup-no-margins" href="{{ url('storage/'.substr($list['foto']->filename,7,1000)) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Tekan untuk memperbesar foto profil">
                                <img class="img-fluid avatar-sm rounded-circle img-thumbnail" alt="" src="{{ url('storage/'.substr($list['foto']->filename,7,1000)) }}" width="75">
                            </a>
                            @endif
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <div class="text-muted">
                                        <h5 class="mb-1">{{ $list['show']->name }}</h5>
                                        <p class="mb-0">NIP. @if (!empty($list['show']->nip)) {{ $list['show']->nip }} @else - @endif</p>
                                    </div>
                                </div>

                                <div class="flex-shrink-0 dropdown ms-2">
                                    @if (Auth::user()->id == $list['show']->id)
                                        <button class="btn btn-light btn-sm" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="bx bx-caret-down align-middle me-1"></i> Menu
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item" href="{{ url('profil/'.$list['show']->id.'/edit') }}">Ubah Biodata</a>
                                            <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                                            data-bs-target="#ubahfoto">Ubah Foto Profil</a>
                                            <a class="dropdown-item" href="{{ route('profil.ubahpassword') }}">Ubah Password</a>
                                        </div>
                                    @else
                                    <a href="{{ route('profilkaryawan.index') }}" class="btn btn-dark btn-sm" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="Kembali ke Profil Karyawan">
                                        <i class="bx bx-caret-left align-middle me-1"></i> Kembali
                                    </a>
                                    @endif
                                </div>
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col-4">
                                    <div>
                                        <p class="text-muted text-truncate mb-2">#</p>
                                        <h5 class="mb-0">...</h5>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div>
                                        <p class="text-muted text-truncate mb-2">#</p>
                                        <h5 class="mb-0">...</h5>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>

                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Biodata</h4>

                    <p class="text-muted mb-2"><i class="mdi mdi-arrow-right text-primary"></i> Data Sensitif</p>
                    <div class="table-responsive" style="border: 0px">
                        <table class="table table-nowrap mb-0">
                            <tbody>
                                <tr>
                                    <th scope="row">NIK :</th>
                                    <td>{{ $list['show']->nik }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">E-mail :</th>
                                    <td>{{ $list['show']->email }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">No. HP :</th>
                                    <td>{{ $list['show']->no_hp }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <p class="text-muted mb-4"><i class="mdi mdi-arrow-right text-primary"></i> Data Umum</p>
                    <div class="table-responsive">
                        <table class="table table-nowrap table-hover mb-0">
                            <tbody>
                                <tr>
                                    <th scope="row">Nama Lengkap :</th>
                                    <td>{{ $list['show']->nama }} <i class="bx bxs-badge-check h5 text-info" data-bs-toggle="tooltip" data-bs-placement="top" title="Verified"></i></td>
                                </tr>
                                <tr>
                                    <th scope="row">Panggilan :</th>
                                    <td>{{ $list['show']->nick }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Tempat, Tgl Lahir :</th>
                                    <td>{{ $list['show']->temp_lahir }}, {{ \Carbon\Carbon::parse($list['show']->tgl_lahir)->isoFormat('D MMMM Y') }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Jenis Kelamin :</th>
                                    <td>{{ ucwords($list['show']->jns_kelamin) }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Status Kawin :</th>
                                    <td>{{ ucwords($list['show']->status_kawin) }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Jabatan :</th>
                                    <td>
                                        @foreach ($list['role'] as $val)
                                            @if ($list['show']->id == $val->id_user)
                                                <kbd>{{ $val->nama_role }}</kbd>
                                            @endif
                                        @endforeach
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <p class="text-muted mb-4"><i class="mdi mdi-arrow-right text-primary"></i> Kesehatan</p>
                    <div class="table-responsive">
                        <table class="table table-nowrap table-hover mb-0">
                            <tbody>
                                <tr>
                                    <th scope="row">Riwayat Penyakit :</th>
                                    <td>{{ $list['show']->riwayat_penyakit }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Riwayat Penyakit Keluarga :</th>
                                    <td>{{ $list['show']->riwayat_penyakit_keluarga }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Riwayat Penggunaan Obat :</th>
                                    <td>{{ $list['show']->riwayat_penggunaan_obat }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Riwayat Operasi :</th>
                                    <td>{{ $list['show']->riwayat_operasi }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @if (!empty($list['show']->pengalaman_kerja))
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Pengalaman Kerja</h4>
                        <p>{{ $list['show']->pengalaman_kerja }}</p>
                    </div>
                </div>
            @endif
            <!-- end card -->
        </div>

        <div class="col-xl-8">

            <div class="row">
                <div class="col-md-4">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-muted fw-medium mb-2">Status Pegawai</p>
                                    <h4 class="mb-0">{{ $list['show']->deleted_at == null? 'Aktif':'Non Aktif' }}</h4>
                                </div>

                                <div class="flex-shrink-0 align-self-center">
                                    @if ($list['show']->deleted_at == null)
                                        <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                            <span class="avatar-title">
                                                <i class="bx bx-check-circle font-size-24"></i>
                                            </span>
                                        </div>
                                    @else
                                        <div class="mini-stat-icon avatar-sm rounded-circle bg-danger">
                                            <span class="avatar-title bg-danger">
                                                <i class="bx bx-block font-size-24"></i>
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-muted fw-medium mb-2">Terakhir Login</p>
                                    <h4 class="mb-0">@if (!empty($list['showlog'][1])) {{ \Carbon\Carbon::parse($list['showlog'][1]->log_date)->diffForHumans() }} @else - @endif</h4>
                                </div>

                                <div class="flex-shrink-0 align-self-center">
                                    <div class="avatar-sm mini-stat-icon rounded-circle bg-primary">
                                        <span class="avatar-title">
                                            <i class="bx bx-hourglass font-size-24"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-muted fw-medium mb-2">Terakhir Perbarui Profil</p>
                                    <h4 class="mb-0">{{ \Carbon\Carbon::parse($list['show']->updated_at)->diffForHumans() }}</h4>
                                </div>

                                <div class="flex-shrink-0 align-self-center">
                                    <div class="avatar-sm mini-stat-icon rounded-circle bg-primary">
                                        <span class="avatar-title">
                                            <i class="bx bx-user-check font-size-24"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card" style="">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Sosial Media</h4>
                            <div class="text-center">
                                <div class="avatar-sm mx-auto mb-4">
                                    <span class="avatar-title rounded-circle font-size-24" style="background-color: #ff0000">
                                            <i class="mdi mdi-youtube text-light"></i>
                                        </span>
                                </div>
                                <p class="font-16 text-muted mb-2"></p>
                                <h5><a href="javascript: void(0);" class="text-dark">YT Channel - <span class="text-muted font-16">RSPKU Muh Sukoharjo</span> </a></h5>
                                <p class="text-muted">Follow akun resmi sosial media Rumah Sakit <b>@rspkusukoharjo</b></p>
                                <a href="{{ url('https://www.youtube.com/@rspkumuhsukoharjo1801') }}" target="_blank" class="text-primary font-16">Follow sekarang <i class="mdi mdi-chevron-right"></i></a>
                            </div>
                            <hr>
                            <div class="row mt-2">
                                <div class="col-6">
                                    <div class="social-source text-center mt-3">
                                        <div class="avatar-xs mx-auto mb-3">
                                            <span class="avatar-title rounded-circle bg-primary font-size-16">
                                                    <i class="mdi mdi-facebook text-white"></i>
                                                </span>
                                        </div>
                                        <h5 class="font-size-15">Facebook</h5>
                                        <p class="text-muted mb-0"><a href="{{ url('https://www.facebook.com/'.$list['show']->fb) }}" target="_blank">{{ $list['show']->fb }}</a></p>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="social-source text-center mt-3">
                                        <div class="avatar-xs mx-auto mb-3">
                                            <span class="avatar-title rounded-circle bg-pink font-size-16">
                                                    <i class="mdi mdi-instagram text-white"></i>
                                                </span>
                                        </div>
                                        <h5 class="font-size-15">Instagram</h5>
                                        <p class="text-muted mb-0"><a href="{{ url('https://www.instagram.com/'.$list['show']->ig) }}" target="_blank">{{ $list['show']->ig }}</a></p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-5">Riwayat Pendidikan</h4>
                            <div class="">
                                <ul class="verti-timeline list-unstyled">
                                    @if (!empty($list['show']->s3))
                                        <li class="event-list">
                                            <div class="event-timeline-dot">
                                                <i class="bx bx-right-arrow-circle"></i>
                                            </div>
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <i class="bx bxs-school h4 text-primary"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div>
                                                        <h5 class="font-size-15"><a href="javascript: void(0);" class="text-dark">{{ $list['show']->s3 }}</a></h5>
                                                        <span class="text-primary">Tahun Lulus : {{ $list['show']->th_s3 }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endif
                                    @if (!empty($list['show']->s2))
                                        <li class="event-list">
                                            <div class="event-timeline-dot">
                                                <i class="bx bx-right-arrow-circle"></i>
                                            </div>
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <i class="bx bxs-school h4 text-primary"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div>
                                                        <h5 class="font-size-15"><a href="javascript: void(0);" class="text-dark">{{ $list['show']->s2 }}</a></h5>
                                                        <span class="text-primary">Tahun Lulus : {{ $list['show']->th_s2 }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endif
                                    @if (!empty($list['show']->s1))
                                        <li class="event-list">
                                            <div class="event-timeline-dot">
                                                <i class="bx bx-right-arrow-circle"></i>
                                            </div>
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <i class="bx bxs-school h4 text-primary"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div>
                                                        <h5 class="font-size-15"><a href="javascript: void(0);" class="text-dark">{{ $list['show']->s1 }}</a></h5>
                                                        <span class="text-primary">Tahun Lulus : {{ $list['show']->th_s1 }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endif
                                    @if (!empty($list['show']->d4))
                                        <li class="event-list">
                                            <div class="event-timeline-dot">
                                                <i class="bx bx-right-arrow-circle"></i>
                                            </div>
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <i class="bx bxs-school h4 text-primary"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div>
                                                        <h5 class="font-size-15"><a href="javascript: void(0);" class="text-dark">{{ $list['show']->d4 }}</a></h5>
                                                        <span class="text-primary">Tahun Lulus : {{ $list['show']->th_d4 }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endif
                                    @if (!empty($list['show']->d3))
                                        <li class="event-list">
                                            <div class="event-timeline-dot">
                                                <i class="bx bx-right-arrow-circle"></i>
                                            </div>
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <i class="bx bxs-school h4 text-primary"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div>
                                                        <h5 class="font-size-15"><a href="javascript: void(0);" class="text-dark">{{ $list['show']->d3 }}</a></h5>
                                                        <span class="text-primary">Tahun Lulus : {{ $list['show']->th_d3 }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endif
                                    @if (!empty($list['show']->d2))
                                        <li class="event-list">
                                            <div class="event-timeline-dot">
                                                <i class="bx bx-right-arrow-circle"></i>
                                            </div>
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <i class="bx bxs-school h4 text-primary"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div>
                                                        <h5 class="font-size-15"><a href="javascript: void(0);" class="text-dark">{{ $list['show']->d2 }}</a></h5>
                                                        <span class="text-primary">Tahun Lulus : {{ $list['show']->th_d2 }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endif
                                    @if (!empty($list['show']->sma))
                                        <li class="event-list">
                                            <div class="event-timeline-dot">
                                                <i class="bx bx-right-arrow-circle"></i>
                                            </div>
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <i class="bx bxs-buildings h4 text-primary"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div>
                                                        <h5 class="font-size-15"><a href="javascript: void(0);" class="text-dark">{{ $list['show']->sma }}</a></h5>
                                                        <span class="text-primary">Tahun Lulus : {{ $list['show']->th_sma }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endif
                                    @if (!empty($list['show']->smp))
                                        <li class="event-list">
                                            <div class="event-timeline-dot">
                                                <i class="bx bx-right-arrow-circle"></i>
                                            </div>
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <i class="bx bxs-buildings h4 text-primary"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div>
                                                        <h5 class="font-size-15"><a href="javascript: void(0);" class="text-dark">{{ $list['show']->smp }}</a></h5>
                                                        <span class="text-primary">Tahun Lulus : {{ $list['show']->th_smp }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endif
                                    @if (!empty($list['show']->sd))
                                        <li class="event-list">
                                            <div class="event-timeline-dot">
                                                <i class="bx bx-right-arrow-circle"></i>
                                            </div>
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <i class="bx bxs-buildings h4 text-primary"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div>
                                                        <h5 class="font-size-15"><a href="javascript: void(0);" class="text-dark">{{ $list['show']->sd }}</a></h5>
                                                        <span class="text-primary">Tahun Lulus : {{ $list['show']->th_sd }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Alamat Sesuai KTP</h4>
                            <div class="table-responsive" style="border: 0px">
                                <table class="table table-nowrap mb-0">
                                    <tbody>
                                        <tr>
                                            <th scope="row">Kelurahan :</th>
                                            <td>{{ $list['show']->ktp_kelurahan }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Kecamatan :</th>
                                            <td>{{ $list['show']->ktp_kecamatan }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Kabupaten :</th>
                                            <td>{{ $list['show']->ktp_kabupaten }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Provinsi :</th>
                                            <td>{{ $list['show']->ktp_provinsi }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <p><b>Alamat Lengkap :</b></p>
                            <p>{{ $list['show']->alamat_ktp }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Alamat Domisili Saat Ini</h4>
                            <div class="table-responsive" style="border: 0px">
                                <table class="table table-nowrap mb-0">
                                    <tbody>
                                        <tr>
                                            <th scope="row">Kelurahan :</th>
                                            <td>{{ $list['show']->dom_kelurahan ? $list['show']->dom_kelurahan : '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Kecamatan :</th>
                                            <td>{{ $list['show']->dom_kecamatan ? $list['show']->dom_kecamatan : '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Kabupaten :</th>
                                            <td>{{ $list['show']->dom_kabupaten ? $list['show']->dom_kabupaten : '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Provinsi :</th>
                                            <td>{{ $list['show']->dom_provinsi ? $list['show']->dom_provinsi : '-' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <p><b>Alamat Lengkap :</b></p>
                            <p>{{ $list['show']->alamat_dom ? $list['show']->alamat_dom : 'Tidak ada' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- START MODAL --}}
    <div class="modal fade" tabindex="-1" id="ubahfoto" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ubah Foto Profil Anda</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{ Form::model($list['show'], ['route' => ['profil.ubahfoto', $list['show']->id], 'method' => 'PUT', 'id' => 'formUbah', 'files' => true]) }}
                    {{-- <form class="form-auth-small" name="formTambah" action="{{ route('profil.ubahfoto') }}" method="POST" enctype="multipart/form-data"> --}}
                        @csrf
                        <input name="file" type="file" class="form-control mb-1">
                        <small><i class="fa-fw fas fa-caret-right nav-icon"></i> File foto tidak boleh melebihi ukuran <kbd>50 Mb</kbd></small>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" id="btn-simpan" onclick="saveData()">
                        <i class="fas fa-upload"></i>&nbsp;&nbsp;
                        <span class="align-middle d-sm-inline-block d-none me-sm-1">Upload</span>
                    </button>
                    {{-- </form> --}}
                    {!! Form::close() !!}
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fa-fw fas fa-times nav-icon"></i> Tutup</button>
                </div>
            </div>
        </div>
    </div>
    {{-- END MODAL --}}

    <script>
        $(document).ready(function() {

        })

        // FUNCTION
        function saveData() {
            $("#formUbah").one('submit', function() {
                $("#btn-simpan").attr('disabled', 'disabled');
                $("#btn-simpan").find("i").toggleClass("fa-save fa-sync fa-spin");
                return true;
            });
        }

        function nonaktif(id) {
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: 'Ingin menonaktifkan User ID : ' + id,
                icon: 'warning',
                reverseButtons: false,
                showDenyButton: false,
                showCloseButton: false,
                showCancelButton: true,
                focusCancel: true,
                confirmButtonColor: '#FF4845',
                confirmButtonText: `<i class="fa fa-user-slash"></i> Nonaktifkan`,
                cancelButtonText: `<i class="fa fa-times me-1" style="font-size:13px"></i>  Batal`,
                backdrop: `rgba(26,27,41,0.8)`,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "/api/profilkaryawan/setnonaktif/" + id,
                        type: 'GET',
                        dataType: 'json', // added data type
                        success: function(res) {
                            iziToast.success({
                                title: 'Sukses!',
                                message: 'Karyawan berhasil dinonaktifkan pada ' + res,
                                position: 'topRight'
                            });
                            window.location.href = '/profilkaryawan';
                            // window.location.reload();
                        },
                        error: function(res) {
                            Swal.fire({
                                title: `Gagal di Nonaktifkan!`,
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

        function batalNonAktif(id) {
            $.ajax({
                url: "/api/profilkaryawan/setaktif/"+id,
                type: 'GET',
                dataType: 'json', // added data type
                success: function(res) {
                    iziToast.success({
                        title: 'Sukses!',
                        message: 'User ID : '+id+' sukses di Aktifkan kembali pada '+ res,
                        position: 'topRight'
                    });
                    window.location.reload();
                }
            })
        }
    </script>
@endsection
