<html lang="en">
<head>
    <title>Simrsmu v3.1</title><!-- [Meta] -->
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0,minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Sistem Manajemen Rumah Sakit PKU Muhammadiyah Sukoharjo" />
    <meta name="keywords" content="simrs, simrsmu, sim rspkuskh, pkuskh, rspkuskh, sistem pku, sistem informasi majemen rumah sakit, rumah sakit pku, pku muhammadiyah sukoharjo, pku sukoharjo">
    <meta name="author" content="Yussuf Faisal" />
    <link rel="shortcut icon" href="{{ asset('images/logo/logo_new_light.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('images/logo/logo_new_light.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('images/logo/logo_new_light.png') }}">
    <link href="{{ asset('css/plugins/animate.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" rel="stylesheet">
    <!-- [Page specific CSS] end --><!-- [Font] Family -->
    <link rel="stylesheet" href="{{ asset('fonts/inter/inter.css') }}" id="main-font-link">
    <!-- [phosphor Icons] https://phosphoricons.com/ -->
    <link rel="stylesheet" href="{{ asset('fonts/phosphor/duotone/style.css') }}">
    <!-- [Tabler Icons] https://tablericons.com -->
    <link rel="stylesheet" href="{{ asset('fonts/tabler-icons.min.css') }}"><!-- [Feather Icons] https://feathericons.com -->
    <link rel="stylesheet" href="{{ asset('fonts/feather.css') }}"><!-- [Font Awesome Icons] https://fontawesome.com/icons -->
    <link rel="stylesheet" href="{{ asset('fonts/fontawesome.css') }}"><!-- [Material Icons] https://fonts.google.com/icons -->
    <link rel="stylesheet" href="{{ asset('fonts/material.css') }}"><!-- [Template CSS Files] -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" id="main-style-link">
    <link rel="stylesheet" href="{{ asset('css/style-preset.css') }}">
    <script src="{{ asset('js/tech-stack.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
</head>

<body data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-direction="ltr" data-pc-theme_contrast=""
    data-pc-theme="dark" class="landing-page">
    <div class="page-loader">
        <div class="bar"></div>
    </div>

    <!-- Logout Form -->
    <form id="logoutform" action="{{ route('logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
    </form>

    <header id="home" style="background-image: url('{{ asset('images/landing/img-headerbg.jpg') }}')">
        <nav class="navbar navbar-expand-md navbar-light default">
            <div class="container">
                <div class="d-inline-flex align-items-center">
                    <a class="navbar-brand" href="{{ route('portal') }}">
                        <img src="{{ asset('images/logo/logo_new_simrsmu_light.png') }}" alt="logo" width="150px">
                    </a>
                    {{-- <a href="javascript:void(0);">
                        <div class="badge text-bg-light border-1 border rounded-pill">v3.1</div>
                    </a> --}}
                </div>
                <button class="navbar-toggler rounded" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center">
                        {{-- <li class="nav-item px-1">
                            <a class="nav-link" href="https://phoenixcoded.gitbook.io/able-pro/" target="_blank">Documentation</a>
                        </li>
                        <li class="nav-item px-1">
                            <a class="nav-link" href="dashboard/index.html">Live Preview</a>
                        </li>
                        <li class="nav-item px-1 me-2 mb-2 mb-md-0">
                            <a class="btn btn-icon btn-light-dark" target="_blank" href="https://github.com/phoenixcoded/able-pro-free-admin-dashboard-template">
                                <i class="ti ti-brand-github"></i>
                            </a>
                        </li> --}}

                        <li class="nav-item">
                            @auth
                                <a class="btn btn-light-secondary shadow" href="{{ route('dashboard') }}"><i class="ti ti-home me-1"></i> Dashboard</a>
                            @else
                                <a class="btn btn-light-primary shadow" href="{{ route('login') }}"><i class="ti ti-login me-1"></i> Login</a>
                            @endauth
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10 text-center">
                    <div class="mb-3 wow fadeInUp" data-wow-delay="0.2s">
                        <img src="{{ asset('images/pku/logo_clear_100kb.png') }}" alt="img" class="img-fluid shadow rounded-circle" width="100px">
                    </div>
                    <h3 class="mb-2 wow fadeInUp" data-wow-delay="0.2s"><span class="hero-text-gradient">EST</span>. <span class="hero-text-gradient">2020</span></h3>
                    <h1 class="mb-4 wow fadeInUp" data-wow-delay="0.2s">Sistem Informasi Manajemen RS <span class="hero-text-gradient"><br>PKU Muhammadiyah Sukoharjo</span></h1>
                    <div class="row justify-content-center wow fadeInUp" data-wow-delay="0.3s">
                        <div class="col-md-10">
                            <p class="text-muted f-16 mb-0">Simrsmu berfungsi sebagai platform yang mendukung manajemen data
                                yang efektif dan komunikasi yang lancar antar bagian manajemen. Sistem ini tidak hanya mempermudah
                                proses administrasi, tetapi juga meningkatkan kinerja yang optimal dengan dukungan sistem yang terintegrasi dan interkoneksi.</p>
                        </div>
                    </div>
                    <div class="row g-5 mt-1 mb-2 justify-content-center text-center wow fadeInUp" data-wow-delay="1s">
                        <div class="col-auto">
                            <p class="mb-4 text-muted">- Klik tombol di bawah untuk masuk -</p>
                        </div>
                    </div>
                    <div class="m-b-35 wow fadeInUp" data-wow-delay="0.4s">
                        @auth
                            <div class="dropdown d-inline-block">
                                <a class="btn btn-light-primary dropdown-toggle arrow-none d-inline-flex align-items-center" data-bs-toggle="dropdown" href="#">Menu <i class="ti ti-chevron-down ms-1"></i></a>
                                <div class="dropdown-menu drp-technology drp-tech-scrollble">
                                    <a class="dropdown-item gap-2" href="{{ route('dashboard') }}"><i class="ti ti-home me-1"></i> Dashboard</a>
                                    <a class="dropdown-item gap-2" href="javascript:void(0);" onclick="event.preventDefault(); document.getElementById('logoutform').submit();"><i class="ti ti-logout me-1"></i> Logout</a>
                                </div>
                            </div>
                        @else
                            <a class="btn btn-light-primary shadow" href="{{ route('login') }}"><i class="ti ti-login me-1"></i> Masuk / Login</a>
                        @endauth
                    </div>
                    <div class="row g-5 justify-content-center text-center wow fadeInUp" data-wow-delay="0.5s">
                        <div class="col-auto head-rating-block">
                            <div class="star mb-2"><i class="fas fa-star text-warning"></i> <i
                                    class="fas fa-star text-warning"></i> <i class="fas fa-star text-warning"></i> <i
                                    class="fas fa-star text-warning"></i> <i
                                    class="fas fa-star-half-alt text-warning"></i></div>
                            <h4 class="mb-0">4.9/5 <small class="text-muted f-w-400">Baik</small></h4>
                        </div>
                        <div class="col-auto">
                            <h5 class="mb-2 p-t-5"><small class="text-muted f-w-400">Pengguna</small></h5>
                            <h4 class="mb-0">300+</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="technology-block">
            <ul class="list-inline mb-0">
                <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-placement="top" title="Support by RS PKU Muhammadiyah Sukoharjo">
                    <a href="https://rspkusukoharjo.com/" target="_blank">
                        <img src="{{ asset('images/pku/logo_admin_white.png') }}" alt="img" class="img-fluid" width="100px">
                    </a>
                </li>
                {{-- <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-placement="top"
                    title="Click to Preview React MUI"><a href="react/index.html" target="_blank"><img
                            src="{{ asset('images/landing/tech-react.svg') }}" alt="img" class="img-fluid"></a></li>
                <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-placement="top"
                    title="Click to Preview Angular Material UI"><a href="angular/default/index.html"
                        target="_blank"><img src="{{ asset('images/landing/tech-angular.svg') }}" alt="img"
                            class="img-fluid"></a></li>
                <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-placement="top"
                    title="Click to Preview CodeIgniter"><a href="codeigniter/default/public/index.html"
                        target="_blank"><img src="{{ asset('images/landing/tech-codeigniter.svg') }}" alt="img"
                            class="img-fluid"></a></li>
                <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-placement="top"
                    title="Click to Preview ASP.net"><a href="https://able-pro.azurewebsites.net/" target="_blank"><img
                            src="{{ asset('images/landing/tech-net.svg') }}" alt="img" class="img-fluid"></a></li>
                <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-placement="top"
                    title="Figma Design System"><a
                        href="https://www.figma.com/file/6XqmRhRmkr33w0EFD49acY/Able-Pro--v9.0-Figma-Preview?type=design&amp;node-id=46-226114&amp;mode=design&amp;t=4FS2Lw6WxsmJ3RLm-0"
                        target="_blank"><img src="{{ asset('images/landing/tech-figma.svg') }}" alt="img" class="img-fluid"></a>
                </li>
                <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-placement="top"
                    title="Click to Preview Next js"><a href="https://able-pro-material-next-ts-navy.vercel.app/"><img
                            src="{{ asset('images/landing/tech-nextjs.svg') }}" alt="img" class="img-fluid"></a></li>
                <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-placement="top"
                    title="Click to Preview Vue"><a href="vue/index.html"><img
                            src="{{ asset('images/landing/tech-vuetify.svg') }}" alt="img" class="img-fluid"></a></li> --}}
            </ul>
        </div>
    </header>

    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script><!-- Required Js -->
    <script src="{{ asset('js/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('js/plugins/simplebar.min.js') }}"></script>
    <script src="{{ asset('js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/fonts/custom-font.js') }}"></script>
    <script src="{{ asset('js/pcoded.js') }}"></script>
    <script src="{{ asset('js/plugins/feather.min.js') }}"></script>
    <script src="{{ asset('js/plugins/wow.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/jquery.marquee/1.4.0/jquery.marquee.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="{{ asset('js/plugins/Jarallax.js') }}"></script>
    <script>
        // Start [ Menu hide/show on scroll ]
        let ost = 0;
        document.addEventListener('scroll', function () {
            let cOst = document.documentElement.scrollTop;
            if (cOst == 0) {
                document.querySelector('.navbar').classList.add('top-nav-collapse');
            } else if (cOst > ost) {
                document.querySelector('.navbar').classList.add('top-nav-collapse');
                document.querySelector('.navbar').classList.remove('default');
            } else {
                document.querySelector('.navbar').classList.add('default');
                document.querySelector('.navbar').classList.remove('top-nav-collapse');
            }
            ost = cOst;
        });
        // End [ Menu hide/show on scroll ]
        var wow = new WOW({
            animateClass: 'animated'
        });
        wow.init();

        // slider start
        $('.screen-slide').owlCarousel({
            loop: true,
            margin: 30,
            center: true,
            nav: false,
            dotsContainer: '.app_dotsContainer',
            URLhashListener: true,
            items: 1
        });
        $('.workspace-slider').owlCarousel({
            loop: true,
            margin: 30,
            center: true,
            nav: false,
            dotsContainer: '.workspace-card-block',
            URLhashListener: true,
            items: 1.5
        });
        // slider end
        // marquee start
        $('.marquee').marquee({
            duration: 500000,
            pauseOnHover: true,
            startVisible: true,
            duplicated: true
        });
        $('.marquee-1').marquee({
            duration: 500000,
            pauseOnHover: true,
            startVisible: true,
            duplicated: true,
            direction: 'right'
        });
    </script>
</body>
</html>
