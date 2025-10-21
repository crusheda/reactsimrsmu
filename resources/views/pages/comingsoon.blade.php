<!doctype html>
<html lang="en" data-layout-width="boxed" data-topbar="dark" data-preloader="disable" data-card-layout="borderless"
    data-bs-theme="light" data-topbar-image="pattern-1">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>

    <meta charset="utf-8" />
    <title>Portal Resmi - SIMRSMU V3</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistem Manajemen Rumah Sakit PKU Muhammadiyah Sukoharjo" />
    <meta name="keywords"
        content="simrs, simrsmu, sim rspkuskh, pkuskh, rspkuskh, sistem pku, sistem informasi majemen rumah sakit">
    <meta name="author" content="Yussuf Faisal" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('images/logo/logo_new_light.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('images/logo/logo_new_light.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('images/logo/logo_new_light.png') }}">
    <!-- Bootstrap Css -->
    <link href="{{ asset('css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <!-- App js -->
    <script src="{{ asset('libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('js/plugin.js') }}"></script>
</head>

<body>
    <div class="home-btn d-none d-sm-block">
        @if (Route::has('login'))
            <div class="hidden fixed top-0 right-0 px-2 py-3 sm:block">
                @auth
                    <a href="{{ route('dashboard') }}" class="text-dark"><i class="fas fa-home h2"></i></a>
                    {{-- <a href="{{ route('dashboard') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Home</a> --}}
                @else
                    <a href="{{ route('login') }}" class="text-sm text-dark underline"><i class="fas fa-sign-in-alt h2"></i></a>

                    {{-- @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="ml-4 text-sm text-dark underline">Register</a>
                    @endif --}}
                @endauth
            </div>
        @endif
    </div>

    <div class="my-5 pt-sm-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center">
                        <a href="{{ route('portal') }}" class="d-block auth-logo">
                            <img src="{{ asset('images/logo/logo_simrsmu_new_kop_31.png') }}" alt="" height="50"
                                class="auth-logo-dark mx-auto">
                        </a>
                        <div class="row justify-content-center mt-5">
                            <div class="col-sm-4">
                                <div class="maintenance-img">
                                    <img src="{{ asset('images/coming-soon.svg') }}" alt=""
                                        class="img-fluid mx-auto d-block">
                                </div>
                            </div>
                        </div>
                        <h4 class="mt-5">Sistem Informasi Rumah sakit PKU Muhammadiyah Sukoharjo</h4>
                        <p class="text-muted">Tahun baru 2024 dengan tampilan dan pengalaman yang baru.</p>
                        @auth
                            <a type="button" class="btn btn-primary" href="{{ route('dashboard') }}"><i class="fas fa-home"></i>&nbsp;&nbsp;Dashboard</a>
                        @else
                            <a type="button" class="btn btn-primary" href="{{ route('login') }}">Login&nbsp;&nbsp;<i class="fas fa-sign-in-alt"></i></a>
                        @endauth
                        <div class="row justify-content-center mt-5">
                            <div class="col-md-8">
                                <div data-countdown="2024/01/01" class="counter-number"></div>
                            </div> <!-- end col-->
                        </div> <!-- end row-->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JAVASCRIPT -->
    <script src="{{ asset('libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('libs/node-waves/waves.min.js') }}"></script>
    <!-- Plugins js-->
    <script src="{{ asset('libs/jquery-countdown/jquery.countdown.min.js') }}"></script>

    <!-- Countdown js -->
    <script src="{{ asset('js/pages/coming-soon.init.js') }}"></script>

    <script src="{{ asset('js/app.js') }}"></script>

</body>

</html>
