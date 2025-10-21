<ul class="pc-navbar">
    <li class="pc-item">
        <a href="{{ route('portal') }}" class="pc-link">
            <span class="pc-micon">
                {{-- <svg class="pc-icon">
                    <use xlink:href="#custom-notification-status"></use>
                </svg> --}}
                <i class="fas fa-tachometer-alt"></i>
            </span>
            <span class="pc-mtext">Portal</span>
        </a>
    </li>
    <li class="pc-item">
        <a href="{{ route('dashboard') }}" class="pc-link">
            <span class="pc-micon">
                {{-- <svg class="pc-icon">
                    <use xlink:href="#custom-notification-status"></use>
                </svg> --}}
                <i class="fas fa-home"></i>
            </span>
            <span class="pc-mtext">Dashboard</span>
        </a>
    </li>
    <li class="pc-item">
        <a href="{{ route('kepegawaian.feedback.index') }}" class="pc-link">
            <span class="pc-micon">
                <i class="fas fa-theater-masks"></i>
            </span>
            <span class="pc-mtext">Masukan / Saran</span>
        </a>
    </li>
    <li class="pc-item pc-caption"><label>Kepegawaian</label></li>
    @if (Auth::user()->getPermission(['admin_kepegawaian']) == true || Auth::user()->getRole('admin_kepegawaian_kepala') == true)
        <li class="pc-item">
            <a href="{{ route('profilkaryawan.index') }}" class="pc-link">
                <span class="pc-micon">
                    <i class="fas fa-id-card-alt"></i>
                </span>
                <span class="pc-mtext">Profil Kepegawaian</span>
            </a>
        </li>
    @endif
    {{-- Auth::user()->getPermission('struktur_organisasi') == true --}}
    @if (Auth::user()->getPermission(['struktur_organisasi']) == true)
        <li class="pc-item">
            <a href="{{ route('strukturorganisasi.index') }}" class="pc-link">
                <span class="pc-micon">
                    <i class="fas fa-sitemap"></i>
                </span>
                <span class="pc-mtext">Struktur Organisasi</span>
            </a>
        </li>
    @endif
    <li class="pc-item">
        <a href="{{ route('kepegawaian.jadwaldinas.index') }}" class="pc-link">
            <span class="pc-micon">
                <i class="fas fa-calendar-alt"></i>
            </span>
            <span class="pc-mtext">Jadwal Dinas</span>
        </a>
    </li>
    <li class="pc-item pc-hasmenu">
        <a href="javascript: void(0);" class="pc-link">
            <span class="pc-micon">
                <i class="fas fa-puzzle-piece"></i>
            </span>
            <span class="pc-mtext">Pengajuan</span>
            <span class="pc-arrow mt-1">
                <i data-feather="chevron-right"></i>
            </span>
        </a>
        <ul class="pc-submenu">
            <li class="pc-item"><a class="pc-link" href="{{ route('kepegawaian.surket.index') }}">Surat Keterangan</a></li>
            {{-- <li class="pc-item"><a class="pc-link" href="javascript: void(0);"><s>Surat Ijin</s></a></li> --}}
            {{-- <li class="pc-item"><a class="pc-link" href="javascript: void(0);"><s>Cuti</s></a></li> --}}
            <li class="pc-item"><a class="pc-link" href="{{ route('kepegawaian.idcard.index') }}">ID Card</a></li>
        </ul>
    </li>
    @if (
        Auth::user()->getPermission('admin_kepegawaian_kepala') == true ||
        Auth::user()->getPermission('admin_kepegawaian') == true ||
        Auth::user()->getPermission('admin_pd_keuangan') == true ||
        Auth::user()->getRole('karu-it') == true
    )
    <li class="pc-item">
        <a href="{{ route('kepegawaian.pd.index') }}" class="pc-link">
            <span class="pc-micon">
                <i class="fas fa-shuttle-van"></i>
            </span>
            <span class="pc-mtext">Perjalanan Dinas</span>
        </a>
    </li>
    @endif
    <li class="pc-item">
        <a href="{{ route('kepegawaian.surtug.index') }}" class="pc-link">
            <span class="pc-micon">
                <i class="ti ti-plane"></i>
            </span>
            <span class="pc-mtext">Surat Tugas</span>
        </a>
    </li>
    @if (Auth::user()->getPermission('admin_spkrkk') == true)
    <li class="pc-item">
        <a href="{{ route('kepegawaian.spkrkk.index') }}" class="pc-link">
            <span class="pc-micon">
                <i class="ti ti-brand-docker"></i>
            </span>
            <span class="pc-mtext">SPK & RKK</span>
        </a>
    </li>
    @endif
    @if (Auth::user()->getPermission('admin_kepegawaian') == true || Auth::user()->getPermission('admin_kepegawaian_kepala') == true)
        <li class="pc-item pc-hasmenu">
            <a href="javascript: void(0);" class="pc-link">
                <span class="pc-micon">
                    <i class="fas fa-user-clock"></i>
                </span>
                <span class="pc-mtext">Absensi Karyawan</span>
                <span class="pc-arrow mt-1">
                    <i data-feather="chevron-right"></i>
                </span>
            </a>
            <ul class="pc-submenu">
                <li class="pc-item"><a class="pc-link" href="{{ route('kepegawaian.absensi.device.index') }}">Perizinan Perangkat</a></li>
                <li class="pc-item"><a class="pc-link" href="{{ route('kepegawaian.absensi.dashboard.index') }}">Dashboard Interaktif</a></li>
                <li class="pc-item"><a class="pc-link" href="{{ route('kepegawaian.absensi.index') }}">Rekapitulasi</a></li>
            </ul>
        </li>
    @endif
    @if (Auth::user()->getPermission('admin_kepegawaian') == true || Auth::user()->getRole('admin_kepegawaian_kepala') == true)
        <li class="pc-item pc-hasmenu">
            <a href="javascript: void(0);" class="pc-link">
                <span class="pc-micon">
                    <i class="fas fa-puzzle-piece"></i>
                </span>
                <span class="pc-mtext">Rekrutmen</span>
                <span class="pc-arrow mt-1">
                    <i data-feather="chevron-right"></i>
                </span>
            </a>
            <ul class="pc-submenu">
                <li class="pc-item"><a class="pc-link" href="{{ route('kepegawaian.rekrutmen.indexPengumuman') }}">Lowongan Kerja</a></li>
                <li class="pc-item"><a class="pc-link" href="{{ route('kepegawaian.rekrutmen.indexRegistrasi') }}">Daftar Peserta</a></li>
                {{-- {{ route('kepegawaian.rekrutmen.indexRegistrasi') }} --}}
            </ul>
        </li>
    @endif
    @if (
            Auth::user()->getPermission('akses_jabatan') == true ||
            Auth::user()->getPermission('akun_pengguna') == true
        )
        <li class="pc-item pc-caption"><label>Atur Pengguna</label></li>
        @if (Auth::user()->getPermission('akses_jabatan') == true || Auth::user()->getPermission('akun_pengguna') == true)
            <li class="pc-item pc-hasmenu">
                <a href="javascript: void(0);" class="pc-link">
                    <span class="pc-micon">
                        <i class="fas fa-users-cog"></i>
                    </span>
                    <span class="pc-mtext">Hak Akses</span>
                    <span class="pc-arrow mt-1">
                        <i data-feather="chevron-right"></i>
                    </span>
                </a>
                <ul class="pc-submenu">
                    @if (Auth::user()->getPermission('akses_jabatan') == true)
                        <li class="pc-item"><a class="pc-link" href="{{ route('aksesjabatan.index') }}">Akses Jabatan</a></li>
                    @endif
                    @if (Auth::user()->getPermission('akun_pengguna') == true)
                        <li class="pc-item"><a class="pc-link" href="{{ route('akunpengguna.index') }}">Akun Pengguna</a></li>
                    @endif
                </ul>
            </li>
        @endif
    @endif
    <li class="pc-item pc-caption"><label>Administrasi</label></li>
    <li class="pc-item pc-hasmenu">
        <a href="javascript: void(0);" class="pc-link">
            <span class="pc-micon">
                {{-- <svg class="pc-icon">
                    <use xlink:href="#custom-status-up"></use>
                </svg> --}}
                <i class="fas fa-archive"></i>
            </span>
            <span class="pc-mtext">Berkas</span>
            <span class="pc-arrow mt-1">
                <i data-feather="chevron-right"></i>
            </span>
            {{-- <span class="pc-badge">2</span> --}}
        </a>
        <ul class="pc-submenu">
            <li class="pc-item"><a class="pc-link" href="{{ route('bulanan.index') }}">Laporan Rutin</a></li>
            <li class="pc-item"><a class="pc-link" href="{{ route('rapat.index') }}">Rapat</a></li>
            <li class="pc-item"><a class="pc-link" href="{{ route('rka.index') }}">RKA</a></li>
            <li class="pc-item"><a class="pc-link" href="{{ route('regulasi.index') }}">Regulasi</a></li>
            @if (
                    Auth::user()->getPermission('disposisi') == true ||
                    Auth::user()->getPermission('surat_masuk') == true ||
                    Auth::user()->getPermission('surat_keluar') == true
                )
                <li class="pc-item pc-hasmenu">
                    <a href="#!" class="pc-link">Surat<span class="pc-arrow"><i data-feather="chevron-right"></i></span></a>
                    <ul class="pc-submenu">
                        @if (Auth::user()->getPermission('disposisi') == true)
                            <li class="pc-item"><a class="pc-link" href="{{ route('disposisi.index') }}">Disposisi</a></li>
                        @endif
                        @if (Auth::user()->getPermission('surat_masuk') == true)
                            <li class="pc-item"><a class="pc-link" href="{{ route('suratmasuk.index') }}">Surat Masuk</a></li>
                        @endif
                        @if (Auth::user()->getPermission('surat_keluar') == true)
                            <li class="pc-item"><a class="pc-link" href="{{ route('suratkeluar.index') }}">Surat Keluar</a></li>
                        @endif
                    </ul>
                </li>
            @endif
        </ul>
    </li>
    <li class="pc-item pc-hasmenu">
        <a href="javascript: void(0);" class="pc-link">
            <span class="pc-micon">
                {{-- <svg class="pc-icon">
                    <use xlink:href="#custom-status-up"></use>
                </svg> --}}
                <i class="fas fa-dolly-flatbed"></i>
            </span>
            <span class="pc-mtext">Inventaris</span>
            <span class="pc-arrow mt-1">
                <i data-feather="chevron-right"></i>
            </span>
            {{-- <span class="pc-badge">2</span> --}}
        </a>
        <ul class="pc-submenu">
            <li class="pc-item"><a class="pc-link" href="{{ route('aset.index') }}">Aset</a></li>
        </ul>
    </li>
    <li class="pc-item">
        <a href="{{ route('pengadaan.index') }}" class="pc-link">
            <span class="pc-micon">
                <i class="fas fa-shopping-cart"></i>
            </span>
            <span class="pc-mtext">E-Pengadaan</span>
        </a>
    </li>
    <li class="pc-item">
        <a href="{{ route('eruang.index') }}" class="pc-link">
            <span class="pc-micon">
                {{-- <svg class="pc-icon">
                    <use xlink:href="#custom-notification-status"></use>
                </svg> --}}
                <i class="fas fa-key"></i>
            </span>
            <span class="pc-mtext">E-Ruang</span>
        </a>
    </li>
    <li class="pc-item pc-caption"><label>Pengaduan</label></li>
    <li class="pc-item pc-hasmenu">
        @php
            $pengaduanMasuk = \App\Models\perbaikan_ipsrs::whereNotNull('tgl_pengaduan')->where('tgl_diterima', null)->where('tgl_dikerjakan', null)->where('tgl_selesai', null)->where('ket_penolakan', null)->count();
        @endphp
        <a href="javascript: void(0);" class="pc-link">
            <span class="pc-micon">
                <i class="fas fa-wrench"></i>
            </span>
            <span class="pc-mtext">Perbaikan</span>
            <span class="pc-arrow mt-1">
                <i data-feather="chevron-right"></i>
            </span>
            @if (Auth::user()->getPermission('admin_perbaikan_ipsrs') == true)
                @if ($pengaduanMasuk > 0)
                    <span class="pc-badge"><i class="fas fa-bell"></i></span>
                @endif
            @endif
        </a>
        <ul class="pc-submenu">
            <li class="pc-item">
                <a class="pc-link" href="{{ route('ipsrs.index') }}">IPSRS @if (Auth::user()->getPermission('admin_perbaikan_ipsrs') == true) @if ($pengaduanMasuk > 0)<span class="pc-badge">{{ $pengaduanMasuk }}</span>@endif @endif</a></li>
        </ul>
    </li>
    @if (Auth::user()->getPermission('skl') == true)
    <li class="pc-item pc-caption"><label>Pelayanan</label></li>
    <li class="pc-item">
        <a href="{{ route('skl.index') }}" class="pc-link">
            <span class="pc-micon">
                <i class="fas fa-baby"></i>
            </span>
            <span class="pc-mtext">Surat Keterangan Lahir</span>
        </a>
    </li>
    @endif
    <li class="pc-item pc-caption"><label>Akreditasi</label></li>
    <li class="pc-item">
        <a href="{{ route('accidentreport.index') }}" class="pc-link">
            <span class="pc-micon">
                <i class="fas fa-running"></i>
            </span>
            <span class="pc-mtext">Kecelakaan Kerja</span>
        </a>
    </li>
    <li class="pc-item pc-caption"><label>Mutu</label></li>
    <li class="pc-item">
        <a href="{{ route('manrisk.index') }}" class="pc-link">
            <span class="pc-micon">
                <i class="fas fa-briefcase-medical"></i>
            </span>
            <span class="pc-mtext">Manajemen Risiko</span>
        </a>
    </li>
</ul>
