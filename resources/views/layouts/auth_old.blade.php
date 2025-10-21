<!doctype html>
<html lang="en" data-layout-width="boxed" data-topbar="dark" data-preloader="disable" data-card-layout="borderless"
    data-bs-theme="light" data-topbar-image="pattern-1">

<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
    <meta charset="utf-8" />
    <title>Form Login - SIMRSMU V3</title>
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
    <link rel="stylesheet" href="{{ asset('css/iziToast.css') }}" />
    <link href="{{ asset('css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <!-- App js -->
    <script src="{{ asset('libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('js/plugin.js') }}"></script>
</head>

<body>
    <div class="account-pages pt-sm-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center mb-4 text-muted mt-5">
                        <a href="{{ route('portal') }}" class="d-block auth-logo">
                            <img src="{{ asset('images/logo/logo_simrsmu_new_kop.png') }}" alt="" height="50"
                                class="auth-logo-dark mx-auto">
                        </a>
                    </div>
                </div>
            </div>
            <!-- end row -->

            @yield('content')

        </div>
    </div>

    <!-- JAVASCRIPT -->
    <script src="{{ asset('libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('libs/node-waves/waves.min.js') }}"></script>
    <!-- App js -->
    <script src="{{ asset('js/iziToast.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>
