<html lang="en">
<head>
    <script>
        (function() {
            var savedTheme = localStorage.getItem("theme") || "light"; // default dark

            // pasang theme ke body juga
            // gunakan MutationObserver untuk tunggu body muncul
            var observer = new MutationObserver(function(mutations, me) {
                if (document.body) {
                    document.body.setAttribute("data-pc-theme", savedTheme);
                    setLogoByTheme(savedTheme); // update logo juga
                    me.disconnect(); // stop observer
                }
            });
            observer.observe(document.documentElement, {childList: true});
        })();

        function setLogoByTheme(theme) {
            const logo = document.getElementById("app-logo");
            if (!logo) return;

            if (theme === "dark") {
                logo.src = "{{ asset('images/logo/logo_new_simrsmu_light.png') }}";
            } else {
                logo.src = "{{ asset('images/logo/logo_simrsmu_new_kop_31.png') }}";
            }
        }

        function layout_change(theme) {
            // ubah attribute body
            document.body.setAttribute("data-pc-theme", theme);

            // simpan pilihan ke localStorage agar persist
            localStorage.setItem("theme", theme);
            setLogoByTheme(theme); // update logo juga
        }
    </script>

    <title>Login - Simrsmu v3.1</title><!-- [Meta] -->
    <meta charset="utf-8">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0,minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Sistem Manajemen Rumah Sakit PKU Muhammadiyah Sukoharjo" />
    <meta name="keywords" content="simrs, simrsmu, sim rspkuskh, pkuskh, rspkuskh, sistem pku, sistem informasi majemen rumah sakit, rumah sakit pku, pku muhammadiyah sukoharjo, pku sukoharjo">
    <meta name="author" content="Yussuf Faisal" />
    <link rel="shortcut icon" href="{{ asset('images/logo/logo_new_light.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('images/logo/logo_new_light.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('images/logo/logo_new_light.png') }}">
    <link rel="stylesheet" href="{{ asset('fonts/inter/inter.css') }}" id="main-font-link">
    <!-- [phosphor Icons] https://phosphoricons.com/ -->
    <link rel="stylesheet" href="{{ asset('fonts/phosphor/duotone/style.css') }}">
    <!-- [Tabler Icons] https://tablericons.com -->
    <link rel="stylesheet" href="{{ asset('fonts/tabler-icons.min.css') }}">
    <!-- [Feather Icons] https://feathericons.com -->
    <link rel="stylesheet" href="{{ asset('fonts/feather.css') }}">
    <!-- [Font Awesome Icons] https://fontawesome.com/icons -->
    <link rel="stylesheet" href="{{ asset('fonts/fontawesome.css') }}">
    <!-- [Material Icons] https://fonts.google.com/icons -->
    <link rel="stylesheet" href="{{ asset('fonts/material.css') }}">
    <!-- [Template CSS Files] -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" id="main-style-link">
    <link rel="stylesheet" href="{{ asset('css/style-preset.css') }}">
    <link rel="stylesheet" href="{{ asset('css/iziToast.css') }}" />
    <script src="{{ asset('libs/jquery/jquery.min.js') }}"></script>
</head><!-- [Head] end -->

<!-- [Body] Start -->
<body data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-layout="vertical" data-pc-direction="ltr" data-pc-theme=""> <!-- data-pc-theme_contrast="" data-pc-theme="light" -->
    <!-- [ Pre-loader ] start -->
    <div class="page-loader">
        <div class="bar"></div>
    </div>
    <!-- [ Pre-loader ] End -->

    @yield('content') <!-- ALL CONTENT HERE -->

    <!-- Required Js -->
    <script src="{{ asset('libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('js/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('js/plugins/simplebar.min.js') }}"></script>
    <script src="{{ asset('js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/fonts/custom-font.js') }}"></script>
    <script src="{{ asset('js/pcoded.js') }}"></script>
    <script src="{{ asset('js/plugins/feather.min.js') }}"></script>
    <script src="{{ asset('js/iziToast.js') }}"></script>

</body>
</html>
