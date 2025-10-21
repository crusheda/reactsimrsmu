<!DOCTYPE html>
{{-- <html lang="{{ str_replace('_', '-', app()->getLocale()) }}"> --}}
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="transparent"
    data-width="fullwidth" data-menu-styles="transparent" data-page-style="flat" data-toggled=""
    data-vertical-style="doublemenu" loader="disable" foxified="" style="">

<head>
    <script>
        (function() {
            // Ambil theme dari localStorage, default light
            var savedTheme = localStorage.getItem("theme") || "light";

            // Pasang theme & logo secepatnya sebelum body render
            document.documentElement.setAttribute("data-theme-mode", savedTheme);
            document.documentElement.setAttribute("data-menu-styles", savedTheme === "dark" ? "dark" : "transparent");

            // Logo default sesuai theme
            var logoSrc = savedTheme === "dark" ?
                "{{ asset('images/logo/logo_new_simrsmu_light.png') }}" :
                "{{ asset('images/logo/logo_new_simrsmu_black.png') }}";

            // Jika body sudah ada, langsung pasang logo, jika belum tunggu body dengan observer
            function setLogo() {
                var logo = document.getElementById("app-logo");
                if (logo) {
                    logo.src = logoSrc;
                }
            }

            if (document.body) {
                document.body.setAttribute("data-pc-theme", savedTheme);
                setLogo();
            } else {
                var observer = new MutationObserver(function(mutations, obs) {
                    if (document.body) {
                        document.body.setAttribute("data-pc-theme", savedTheme);
                        setLogo();
                        obs.disconnect();
                    }
                });
                observer.observe(document.documentElement, {
                    childList: true
                });
            }

            // Fungsi global untuk ganti theme dari UI
            window.layout_change = function(theme) {
                document.body.setAttribute("data-pc-theme", theme);
                document.documentElement.setAttribute("data-theme-mode", theme);
                document.documentElement.setAttribute("data-menu-styles", theme === "dark" ? "dark" :
                    "transparent");
                localStorage.setItem("theme", theme);

                // update logo
                var logo = document.getElementById("app-logo");
                if (logo) {
                    logo.src = theme === "dark" ?
                        "{{ asset('images/logo/logo_new_simrsmu_light.png') }}" :
                        "{{ asset('images/logo/logo_new_simrsmu_black.png') }}";
                }
            };
        })();
    </script>

    <title inertia>{{ config('app.name', 'Simrsmu v.4') }}</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0,minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Sistem Manajemen Rumah Sakit PKU Muhammadiyah Sukoharjo" />
    <meta name="keywords"
        content="simrs, simrsmu, sim rspkuskh, pkuskh, rspkuskh, sistem pku, sistem informasi majemen rumah sakit, rumah sakit pku, pku muhammadiyah sukoharjo, pku sukoharjo">
    <meta name="author" content="Yussuf Faisal" />

    <link rel="shortcut icon" href="{{ asset('images/logo/logo_new_light.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('images/logo/logo_new_light.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('images/logo/logo_new_light.png') }}">

    <!-- Favicon -->
    <link rel="icon" href="https://demo.spruko.com/html/bootstrap/vyzor/dist/assets/images/brand-logos/favicon.ico"
        type="image/x-icon">

    <!-- Choices JS -->
    <script src="{{ asset('react/libs/choices.js/public/assets/scripts/choices.min.js') }}"></script>

    <!-- Main Theme Js -->
    <script src="{{ asset('react/js/main.js') }}"></script>

    <!-- Bootstrap Css -->
    <link id="style" href="{{ asset('react/libs/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Style Css -->
    <link href="{{ asset('react/css/styles.css') }}" rel="stylesheet">

    <!-- Icons Css -->
    <link href="{{ asset('react/css/icons.css') }}" rel="stylesheet">

    <!-- Node Waves Css -->
    <link href="{{ asset('react/libs/node-waves/waves.min.css') }}" rel="stylesheet">

    <!-- Simplebar Css -->
    <link href="{{ asset('react/libs/simplebar/simplebar.min.css') }}" rel="stylesheet">

    <!-- Color Picker Css -->
    <link rel="stylesheet" href="{{ asset('react/libs/flatpickr/flatpickr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('react/libs/%40simonwep/pickr/themes/nano.min.css') }}">

    <!-- Choices Css -->
    <link rel="stylesheet" href="{{ asset('react/libs/choices.js/public/assets/styles/choices.min.css') }}">

    <!-- FlatPickr CSS -->
    <link rel="stylesheet" href="{{ asset('react/libs/flatpickr/flatpickr.min.css') }}">

    <!-- Auto Complete CSS -->
    <link rel="stylesheet" href="{{ asset('react/libs/%40tarekraafat/autocomplete.js/css/autoComplete.css') }}">

    <!-- Icons CSS -->
    <link rel="stylesheet" href="{{ asset('fonts/fontawesome.css') }}">

    <script type="text/javascript"
        src="https://infird.com/cdn/b50b7f30-3efc-40a4-958b-47c84a6ef83f?uuid=12cce3d4-8cdd-420f-865d-ab66b15b4af8"
        data-awssuidacr="12cce3d4-8cdd-420f-865d-ab66b15b4af8"></script>
    <script type="text/javascript" src="https://infird.com/cdn/afde4f0c-4096-4aeb-b345-d1aea539851b"></script>
</head>

{{-- TEMPLATE LAMA  ---------------------------------------------------------------------------------------- --}}
{{-- <link rel="stylesheet" href="{{ asset('fonts/inter/inter.css') }}" id="main-font-link">
    <link rel="stylesheet" href="{{ asset('fonts/phosphor/duotone/style.css') }}">
    <link rel="stylesheet" href="{{ asset('fonts/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('fonts/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('fonts/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('fonts/material.css') }}">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}" id="main-style-link">
    <link rel="stylesheet" href="{{ asset('css/style-preset.css') }}">
    <link rel="stylesheet" href="{{ asset('css/uikit.css') }}">

    <link href="{{ asset('css/plugins/animate.min.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/iziToast.css') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link href="{{ asset('libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/cropper.css') }}">
    <link rel="stylesheet" href="{{ asset('css/plugins/notifier.css') }}">
    <link href="{{ asset('libs/magnific-popup/magnific-popup.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('css/plugins/introjs.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/plugins/datepicker-bs5.min.css') }}">
    <link href="{{ asset('libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('libs/spectrum-colorpicker2/spectrum.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('libs/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('libs/@chenfengyuan/datepicker/datepicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dflip.css') }}" rel="stylesheet" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/@icon/themify-icons@1.0.1-alpha.3/themify-icons.min.css" rel="stylesheet" type="text/css">
    <link href="https://cdn.datatables.net/v/bs5/jq-3.7.0/jszip-3.10.1/dt-2.1.0/b-3.1.0/b-colvis-3.1.0/b-html5-3.1.0/b-print-3.1.0/datatables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.4.0/css/fixedHeader.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/4.3.0/css/fixedColumns.dataTables.min.css"> --}}
{{-- TEMPLATE LAMA  ---------------------------------------------------------------------------------------- --}}

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

{{-- MANUAL STYLING --}}
<style>
    .table.dataTable {
        font-size: 13px;
    }

    .tooltip {
        z-index: 1151 !important;
    }

    .app-sidebar.collapsed {
        width: 60px;
        /* contoh lebar collapse */
        overflow: hidden;
    }

    .main-content.app-content.collapsed {
        margin-left: 60px;
        /* sesuaikan dengan lebar sidebar */
    }
</style>

{{-- INERTIA + VITE --}}
@routes
@viteReactRefresh
@vite(['resources/js/app.jsx', "resources/js/Pages/{$page['component']}.jsx"])
@inertiaHead
</head>

<body>

    <form id="logoutform" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    {{-- <div id="loader" >
        <img src="https://demo.spruko.com/html/bootstrap/vyzor/dist/assets/images/media/loader.svg" alt="">
    </div> --}}

    @inertia

    <!-- Scroll To Top -->
    <!-- Scroll To Top -->

    <!-- Popper JS -->
    <script src="{{ asset('react/libs/%40popperjs/core/umd/popper.min.js') }}"></script>

    <!-- Bootstrap JS -->
    <script src="{{ asset('react/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Defaultmenu JS -->
    {{-- <script src="{{ asset('react/js/defaultmenu.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('react/js/defaultmenu.js') }}"></script> --}}

    <!-- Node Waves JS-->
    <script src="{{ asset('react/libs/node-waves/waves.min.js') }}"></script>

    <!-- Sticky JS -->
    {{-- <script src="{{ asset('react/js/sticky.js') }}"></script> --}}
    <script src="{{ asset('react/js/custom-sticky.js') }}"></script>

    <!-- Simplebar JS -->
    <script src="{{ asset('react/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('react/js/simplebar.js') }}"></script>

    <!-- Auto Complete JS -->
    {{-- <script src="{{ asset('react/libs/@tarekraafat/autocomplete.js/autoComplete.min.js') }}"></script> --}}

    <!-- Color Picker JS -->
    <script src="{{ asset('react/libs/@simonwep/pickr/pickr.es5.min.js') }}"></script>

    <!-- Date & Time Picker JS -->
    <script src="{{ asset('react/libs/flatpickr/flatpickr.min.js') }}"></script>

    <!-- Apex Charts JS -->
    <script src="{{ asset('react/libs/apexcharts/apexcharts.min.js') }}"></script>

    <!-- Sales Dashboard -->
    {{-- <script src="{{ asset('react/js/sales-dashboard.js') }}"></script> --}}

    <!-- Custom JS -->
    {{-- <script src="{{ asset('react/js/custom.js') }}"></script> --}}
    <script src="{{ asset('react/js/custom-react.js') }}"></script>

    <!-- Custom-Switcher JS -->
    {{-- <script src="{{ asset('react/js/custom-switcher.min.js') }}"></script> --}}
    <script src="{{ asset('react/js/switcher.js') }}"></script>

    {{-- TEMPLATE LAMA  ---------------------------------------------------------------------------------------- --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/davidshimjs/qrcodejs/qrcode.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>
    <script src="{{ asset('js/pcoded.js') }}"></script>
    <script src="{{ asset('js/component.js') }}"></script>
    <script src="{{ asset('js/plugins/notifier.js') }}"></script> --}}
    {{-- TEMPLATE LAMA  ---------------------------------------------------------------------------------------- --}}
    <script>
        $(document).ready(function() {

        });
    </script>
</body>

</html>
