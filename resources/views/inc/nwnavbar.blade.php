<nav class="pc-sidebar">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="javascript:void(0);" class="b-brand text-primary">
                <img id="app-logo" src="{{ asset('images/logo/logo_new_simrsmu_black.png') }}" alt="logo" class="img-fluid" width="150px">
                <span class="badge bg-light-primary rounded-pill ms-2 theme-version">v3.1</span>
            </a>
        </div>
        {{-- <script>
            // Pasang logo sesuai theme saat pertama kali load
            document.addEventListener("DOMContentLoaded", function () {
                const savedTheme = localStorage.getItem("theme") || "dark";
                setLogoByTheme(savedTheme);
            });
        </script> --}}
        <div class="navbar-content">
            <div class="card pc-user-card step1">
                <div class="card-body">
                    <?php $foto_profil = \DB::table('users_foto')->where('user_id', Auth::user()->id)->first();
                    $time = \Carbon\Carbon::now()->isoFormat('H');
                    // PENGHITUNGAN WAKTU PAGI / SIANG / SORE / MALAM
                    if ($time < "10") {
                        $waktu = "Pagi";
                    } else {
                        if ($time >= "10" && $time < "15") {
                            $waktu = "Siang";
                        } else {
                            if ($time >= "15" && $time < "19") {
                                $waktu = "Sore";
                            } else {
                                if ($time >= "19") {
                                    $waktu = "Malam";
                                }
                            }
                        }
                    }?>
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            @if (empty($foto_profil->filename))
                                <img src="{{ asset('images/pku/user.png') }}" alt="Header Avatar" class="user-avtar wid-45 rounded-circle" style="width: 45px;height:45px">
                            @else
                                <img src="{{ url('storage/'.substr($foto_profil->filename,7,1000)) }}" alt="Header Avatar" class="user-avtar wid-45 rounded-circle" style="width: 45px;height:45px">
                            @endif
                        </div>
                        <div class="flex-grow-1 ms-3 me-2">
                            <small>Selamat {{ $waktu }},</small>
                            <h6 class="mb-0"><a class="text-primary">{{ Auth::user()->nick?Auth::user()->nick:Auth::user()->name }}</a></h6>
                        </div>
                        <a class="btn btn-icon btn-link-secondary avtar" data-bs-toggle="collapse" href="#pc_sidebar_userlink">
                            <svg class="pc-icon">
                                <use xlink:href="#custom-sort-outline"></use>
                            </svg>
                        </a>
                    </div>
                    <div class="collapse pc-user-links @if(URL::current() == url('/profil')) collapse show @endif" id="pc_sidebar_userlink">
                        <div class="pt-3">
                            <a href="{{ route('profil.index') }}" class="@if(URL::current() == url('/profil')) text-primary @endif step2">
                                <svg  xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-user me-2">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" /><path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                </svg>
                                <span class="step3">Profil Saya</span>
                            </a>
                            {{-- <a href="#!">
                                <i class="ti ti-settings"></i> <span>Settings</span>
                            </a>
                            <a href="#!">
                                <i class="ti ti-lock"></i> <span>Lock Screen</span>
                            </a> --}}
                            <a class="button" href="javascript:void(0);" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                                <i class="ti ti-power"></i> Logout
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @include('inc.nwsidebar')
        </div>
    </div>
</nav>
