<header class="pc-header">
    <div class="header-wrapper"><!-- [Mobile Media Block] start -->
        <div class="me-auto pc-mob-drp">
            <ul class="list-unstyled"><!-- ======= Menu collapse Icon ===== -->
                <li class="pc-h-item pc-sidebar-collapse"><a href="javascript:void(0);" class="pc-head-link ms-0" id="sidebar-hide"><i
                            class="ti ti-menu-2"></i></a></li>
                <li class="pc-h-item pc-sidebar-popup"><a href="javascript:void(0);" class="pc-head-link ms-0"
                        id="mobile-collapse"><i class="ti ti-menu-2"></i></a></li>
                <li class="pc-h-item d-none d-md-inline-flex" style="margin-left:10px">
                    <form class="form-search">
                        <i class="search-icon mt-4">
                            <svg class="pc-icon">
                                <use xlink:href="#custom-search-normal-1"></use>
                            </svg>
                        </i>
                        <input type="search" class="form-control mt-3" placeholder="Ctrl + K" disabled>
                    </form>
                </li>
            </ul>
        </div><!-- [Mobile Media Block end] -->
        <div class="ms-auto">
            <ul class="list-unstyled">
                <li class="dropdown pc-h-item">
                    <a class="pc-head-link dropdown-toggle arrow-none me-0"
                        data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false"
                        aria-expanded="false" data-bs-toggle="tooltip"
                        data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true"
                        title="Pilih Tema Sistem">
                        <svg class="pc-icon">
                            <use xlink:href="#custom-sun-1"></use>
                        </svg>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end pc-h-dropdown">
                        <a href="javascript:void(0);" class="dropdown-item" onclick="layout_change('dark')">
                            <svg class="pc-icon">
                                <use xlink:href="#custom-moon"></use>
                            </svg> <span>Gelap</span>
                        </a>
                        <a href="javascript:void(0);" class="dropdown-item" onclick="layout_change('light')">
                            <svg class="pc-icon">
                                <use xlink:href="#custom-sun-1"></use>
                            </svg> <span>Terang</span>
                        </a>
                    </div>
                </li>
                {{-- <li class="dropdown pc-h-item"><a class="pc-head-link dropdown-toggle arrow-none me-0"
                        data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false"
                        aria-expanded="false" disabled><svg class="pc-icon">
                            <use xlink:href="#custom-setting-2"></use>
                        </svg></a>
                    <div class="dropdown-menu dropdown-menu-end pc-h-dropdown"><a href="#!"
                            class="dropdown-item"><i class="ti ti-user"></i> <span>My Account</span> </a><a
                            href="#!" class="dropdown-item"><i class="ti ti-settings"></i>
                            <span>Settings</span> </a><a href="#!" class="dropdown-item"><i
                                class="ti ti-headset"></i> <span>Support</span>
                        </a><a href="#!" class="dropdown-item"><i class="ti ti-lock"></i> <span>Lock
                                Screen</span>
                        </a><a href="#!" class="dropdown-item"><i class="ti ti-power"></i>
                            <span>Logout</span></a>
                    </div>
                </li>
                <li class="pc-h-item"><a href="#" class="pc-head-link me-0" data-bs-toggle="offcanvas"
                        data-bs-target="#announcement" aria-controls="announcement" disabled><svg class="pc-icon">
                            <use xlink:href="#custom-flash"></use>
                        </svg></a></li> --}}
                <li class="dropdown pc-h-item">
                    <a class="pc-head-link dropdown-toggle arrow-none me-0 waves-effect" data-bs-toggle="fullscreen" href="javascript:void(0);" onclick="toggle_fullscreen()" id="fullscreen-btn">
                        <i class="fas fa-expand" style="font-size:22px"></i>
                    </a>
                    <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="javascript:void(0);" role="button" aria-haspopup="false" aria-expanded="false">
                        <svg class="pc-icon">
                            <use xlink:href="#custom-notification"></use>
                        </svg> <span class="badge bg-info pc-h-badge">*</span>
                    </a>
                    <div class="dropdown-menu dropdown-notification dropdown-menu-end pc-h-dropdown">
                        <div class="dropdown-header d-flex align-items-center justify-content-between">
                            <h5 class="m-0">Pemberitahuan Terbaru</h5><a href="javascript:void(0);" class="text-muted text-sm">Diperbarui {{ \Carbon\Carbon::now()->isoFormat('DD/MM/YYYY') }}</a>
                        </div>
                        <div class="dropdown-body text-wrap header-notification-scroll position-relative"
                            style="max-height: calc(100vh - 215px)">
                            @if (Auth::user()->getManyPermission(["admin_kepegawaian","admin_kepegawaian_kepala"]) == true)
                                @foreach ($logs as $item)
                                    <div class="card mb-2">
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-2">
                                                    <h4><i class="ti ti-refresh-alert text-primary"></i></h4>
                                                </div>
                                                <div class="flex-grow-1 text-wrap">
                                                    <span class="float-end text-sm text-muted">{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</span>
                                                    <h5 class="text-body mb-1">Log Sistem (#<b class="text-muted">{{ $item->id }}</b>)</h5>
                                                    <p class="mb-1">{{ $item->event }}</p>
                                                    <small class="text-sm text-muted">Oleh {{ $item->nama }}</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="card mb-2">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0"><svg class="pc-icon text-primary">
                                                <use xlink:href="#custom-layer"></use>
                                            </svg></div>
                                            <div class="flex-grow-1 ms-3"><span class="float-end text-sm text-muted">∞</span>
                                                <h5 class="text-body mb-2">Update System v3.1</h5>
                                                <p class="mb-0">Selamat Beraktivitas..</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            {{-- <div class="card mb-2">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0"><svg class="pc-icon text-primary">
                                                <use xlink:href="#custom-sms"></use>
                                            </svg></div>
                                        <div class="flex-grow-1 ms-3"><span class="float-end text-sm text-muted">1
                                                hour ago</span>
                                            <h5 class="text-body mb-2">Message</h5>
                                            <p class="mb-0">Lorem Ipsum has been the industry's standard dummy text
                                                ever since the 1500.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <p class="text-span">Yesterday</p>
                            <div class="card mb-2">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0"><svg class="pc-icon text-primary">
                                                <use xlink:href="#custom-document-text"></use>
                                            </svg></div>
                                        <div class="flex-grow-1 ms-3"><span class="float-end text-sm text-muted">2
                                                hour ago</span>
                                            <h5 class="text-body mb-2">Forms</h5>
                                            <p class="mb-0">Lorem Ipsum has been the industry's standard dummy text
                                                ever since the 1500s, when an unknown printer took a galley of type
                                                and scrambled it to make a type</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-2">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0"><svg class="pc-icon text-primary">
                                                <use xlink:href="#custom-user-bold"></use>
                                            </svg></div>
                                        <div class="flex-grow-1 ms-3"><span class="float-end text-sm text-muted">12
                                                hour ago</span>
                                            <h5 class="text-body mb-2">Challenge invitation</h5>
                                            <p class="mb-2"><span class="text-dark">Jonny aber</span> invites to
                                                join the challenge</p><button
                                                class="btn btn-sm btn-outline-secondary me-2">Decline</button>
                                            <button class="btn btn-sm btn-primary">Accept</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-2">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0"><svg class="pc-icon text-primary">
                                                <use xlink:href="#custom-security-safe"></use>
                                            </svg></div>
                                        <div class="flex-grow-1 ms-3"><span class="float-end text-sm text-muted">5
                                                hour ago</span>
                                            <h5 class="text-body mb-2">Security</h5>
                                            <p class="mb-0">Lorem Ipsum has been the industry's standard dummy text
                                                ever since the 1500s, when an unknown printer took a galley of type
                                                and scrambled it to make a type</p>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                        <div class="text-center py-2"><a href="javascript:void(0);" class="link-primary">Lihat Semua Notifikasi ({{ $countLogs }})</a></div>
                    </div>
                </li>
                <li class="dropdown pc-h-item header-user-profile">
                    <?php $foto_profil = \DB::table('users_foto')->where('user_id', Auth::user()->id)->first(); ?>
                    <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#"
                        role="button" aria-haspopup="false" data-bs-auto-close="outside" aria-expanded="false">
                        @if (empty($foto_profil->filename))
                            <img src="{{ asset('images/pku/user.png') }}" alt="Header Avatar" class="user-avtar" style="width: 30px;height:30px;margin-left: 5px">
                        @else
                            <img src="{{ url('storage/'.substr($foto_profil->filename,7,1000)) }}" alt="Header Avatar" class="user-avtar" style="width: 30px;height:30px;margin-left: 5px">
                        @endif
                    </a>
                    <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
                        <div class="dropdown-header d-flex align-items-center justify-content-between">
                            <h5 class="m-0">Pengaturan</h5>
                        </div>
                        <div class="dropdown-body">
                            <div class="profile-notification-scroll position-relative"
                                style="max-height: calc(100vh - 225px)">
                                <div class="d-flex mb-1">
                                    <div class="flex-shrink-0">
                                        @if (empty($foto_profil->filename))
                                            <img src="{{ asset('images/pku/user.png') }}" alt="Header Avatar" class="user-avtar wid-40" style="width: 40px;height:40px">
                                        @else
                                            <img src="{{ url('storage/'.substr($foto_profil->filename,7,1000)) }}" alt="Header Avatar" class="user-avtar wid-40" style="width: 40px;height:40px">
                                        @endif
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1">Halo, {{ Auth::user()->name }} 🖖</h6>
                                        <span>
                                            <a href="javascript:void(0);" class="text-dark">{{ Auth::user()->email }}</a>
                                        </span>
                                    </div>
                                </div>
                                <hr class="border-secondary border-opacity-50">
                                {{-- <div class="card">
                                    <div class="card-body py-3">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <h5 class="mb-0 d-inline-flex align-items-center"><svg
                                                    class="pc-icon text-muted me-2">
                                                    <use xlink:href="#custom-notification-outline"></use>
                                                </svg>Notification</h5>
                                            <div class="form-check form-switch form-check-reverse m-0"><input
                                                    class="form-check-input f-18" type="checkbox" role="switch">
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                                {{-- <p class="text-span">Pengaturan</p> --}}
                                <a href="{{ route('profil.index') }}" class="dropdown-item">
                                    <span>
                                        <svg  xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-user">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" /><path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                        </svg>
                                        <span>Profil Saya</span>
                                    </span>
                                </a>
                                {{-- <a href="#" class="dropdown-item">
                                    <span>
                                        <svg class="pc-icon text-muted me-2">
                                            <use xlink:href="#custom-share-bold"></use>
                                        </svg> <span>Share</span>
                                    </span>
                                </a> --}}
                                {{-- <a href="#" class="dropdown-item">
                                    <span>
                                        <svg class="pc-icon text-muted me-2">
                                            <use xlink:href="#custom-lock-outline"></use>
                                        </svg> <span>Ubah Password</span>
                                    </span>
                                </a> --}}
                                {{-- <hr class="border-secondary border-opacity-50">
                                <p class="text-span">Team</p><a href="#" class="dropdown-item"><span><svg
                                            class="pc-icon text-muted me-2">
                                            <use xlink:href="#custom-profile-2user-outline"></use>
                                        </svg> <span>UI Design team</span></span>
                                    <div class="user-group"><img src="{{ asset('images/user/avatar-1.jpg') }}"
                                            alt="user-image" class="avtar"> <span
                                            class="avtar bg-danger text-white">K</span> <span
                                            class="avtar bg-success text-white"><svg class="pc-icon m-0">
                                                <use xlink:href="#custom-user"></use>
                                            </svg> </span><span class="avtar bg-light-primary text-primary">+2</span>
                                    </div>
                                </a><a href="#" class="dropdown-item"><span><svg
                                            class="pc-icon text-muted me-2">
                                            <use xlink:href="#custom-profile-2user-outline"></use>
                                        </svg> <span>Friends Groups</span></span>
                                    <div class="user-group"><img src="{{ asset('images/user/avatar-1.jpg') }}"
                                            alt="user-image" class="avtar"> <span
                                            class="avtar bg-danger text-white">K</span> <span
                                            class="avtar bg-success text-white"><svg class="pc-icon m-0">
                                                <use xlink:href="#custom-user"></use>
                                            </svg></span></div>
                                </a><a href="#" class="dropdown-item"><span><svg
                                            class="pc-icon text-muted me-2">
                                            <use xlink:href="#custom-add-outline"></use>
                                        </svg> <span>Add new</span></span>
                                    <div class="user-group"><span class="avtar bg-primary text-white"><svg
                                                class="pc-icon m-0">
                                                <use xlink:href="#custom-add-outline"></use>
                                            </svg></span></div>
                                </a> --}}
                                <hr class="border-secondary border-opacity-50">
                                <div class="d-grid mb-3">
                                    <a type="button" class="btn btn-primary text-white" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                                        <svg class="pc-icon me-2">
                                            <use xlink:href="#custom-logout-1-outline"></use>
                                        </svg>Logout
                                    </a>
                                </div>
                                {{-- <div class="card border-0 shadow-none drp-upgrade-card mb-0"
                                    style="background-image: {{ asset('images/layout/img-profile-card.jpg') }}">
                                    <div class="card-body">
                                        <div class="user-group"><img src="{{ asset('images/user/avatar-1.jpg') }}"
                                                alt="user-image" class="avtar"> <img
                                                src="{{ asset('images/user/avatar-2.jpg') }}" alt="user-image"
                                                class="avtar"> <img src="{{ asset('images/user/avatar-3.jpg') }}"
                                                alt="user-image" class="avtar"> <img
                                                src="{{ asset('images/user/avatar-4.jpg') }}" alt="user-image"
                                                class="avtar"> <img src="{{ asset('images/user/avatar-5.jpg') }}"
                                                alt="user-image" class="avtar"> <span
                                                class="avtar bg-light-primary text-primary">+20</span></div>
                                        <h3 class="my-3 text-dark">245.3k <small class="text-muted">Followers</small>
                                        </h3>
                                        <div class="btn btn btn-warning"><svg class="pc-icon me-2">
                                                <use xlink:href="#custom-logout-1-outline"></use>
                                            </svg> Upgrade to Business</div>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</header>
<div class="offcanvas pc-announcement-offcanvas offcanvas-end" tabindex="-1" id="announcement"
    aria-labelledby="announcementLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="announcementLabel">What's new announcement?</h5><button type="button"
            class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <p class="text-span">Today</p>
        <div class="card mb-3">
            <div class="card-body">
                <div class="align-items-center d-flex flex-wrap gap-2 mb-3">
                    <div class="badge bg-light-success f-12">Big News</div>
                    <p class="mb-0 text-muted">2 min ago</p><span class="badge dot bg-warning"></span>
                </div>
                <h5 class="mb-3">Able Pro is Redesigned</h5>
                <p class="text-muted">Able Pro is completely renowed with high aesthetics User Interface.</p><img
                    src="{{ asset('images/layout/img-announcement-1.png') }}" alt="img" class="img-fluid mb-3">
                <div class="row">
                    <div class="col-12">
                        <div class="d-grid"><a class="btn btn-outline-secondary"
                                href="https://1.envato.market/zNkqj6" target="_blank">Check Now</a></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-body">
                <div class="align-items-center d-flex flex-wrap gap-2 mb-3">
                    <div class="badge bg-light-warning f-12">Offer</div>
                    <p class="mb-0 text-muted">2 hour ago</p><span class="badge dot bg-warning"></span>
                </div>
                <h5 class="mb-3">Able Pro is in best offer price</h5>
                <p class="text-muted">Download Able Pro exclusive on themeforest with best price.</p><a
                    href="https://1.envato.market/zNkqj6" target="_blank"><img
                        src="{{ asset('images/layout/img-announcement-2.png') }}" alt="img"
                        class="img-fluid"></a>
            </div>
        </div>
        <p class="text-span mt-4">Yesterday</p>
        <div class="card mb-3">
            <div class="card-body">
                <div class="align-items-center d-flex flex-wrap gap-2 mb-3">
                    <div class="badge bg-light-primary f-12">Blog</div>
                    <p class="mb-0 text-muted">12 hour ago</p><span class="badge dot bg-warning"></span>
                </div>
                <h5 class="mb-3">Featured Dashboard Template</h5>
                <p class="text-muted">Do you know Able Pro is one of the featured dashboard template selected by
                    Themeforest team.?</p><img src="{{ asset('images/layout/img-announcement-3.png') }}"
                    alt="img" class="img-fluid">
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-body">
                <div class="align-items-center d-flex flex-wrap gap-2 mb-3">
                    <div class="badge bg-light-primary f-12">Announcement</div>
                    <p class="mb-0 text-muted">12 hour ago</p><span class="badge dot bg-warning"></span>
                </div>
                <h5 class="mb-3">Buy Once - Get Free Updated lifetime</h5>
                <p class="text-muted">Get the lifetime free updates once you purchase the Able Pro.</p><img
                    src="{{ asset('images/layout/img-announcement-4.png') }}" alt="img" class="img-fluid">
            </div>
        </div>
    </div>
</div>

<script>
    function toggle_fullscreen() {
        if(document.fullscreen) {
            $('#fullscreen-btn').find('i').toggleClass('fa-expand fa-compress');
			document.exitFullscreen();
		} else if(document.webkitFullscreenElement) {
			document.webkitCancelFullScreen()
		} else if(document.documentElement.requestFullscreen) {
            $('#fullscreen-btn').find('i').toggleClass('fa-compress fa-expand');
			document.documentElement.requestFullscreen();
		} else {
			document.documentElement.webkitRequestFullScreen();
		}
    }
</script>
