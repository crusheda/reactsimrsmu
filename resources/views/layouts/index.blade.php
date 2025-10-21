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
                logo.src = "{{ asset('images/logo/logo_new_simrsmu_black.png') }}";
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

    <title>Simrsmu v3.1 - {{ Auth::user()->name }}</title><!-- [Meta] -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0,minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Sistem Manajemen Rumah Sakit PKU Muhammadiyah Sukoharjo" />
    <meta name="keywords" content="simrs, simrsmu, sim rspkuskh, pkuskh, rspkuskh, sistem pku, sistem informasi majemen rumah sakit, rumah sakit pku, pku muhammadiyah sukoharjo, pku sukoharjo">
    <meta name="author" content="Yussuf Faisal" />
    <link rel="shortcut icon" href="{{ asset('images/logo/logo_new_light.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('images/logo/logo_new_light.png') }}">
    <link rel="icon" type="image/png" sizes="96
    x96" href="{{ asset('images/logo/logo_new_light.png') }}">
    <link rel="stylesheet" href="{{ asset('fonts/inter/inter.css') }}" id="main-font-link">
    <!-- [phosphor Icons] https://phosphoricons.com/ -->
    <link rel="stylesheet" href="{{ asset('fonts/phosphor/duotone/style.css') }}">
    <!-- [Tabler Icons] https://tablericons.com -->
    <link rel="stylesheet" href="{{ asset('fonts/tabler-icons.min.css') }}"><!-- [Feather Icons] https://feathericons.com -->
    <link rel="stylesheet" href="{{ asset('fonts/feather.css') }}">
    <!-- [Font Awesome Icons] https://fontawesome.com/icons -->
    <link rel="stylesheet" href="{{ asset('fonts/fontawesome.css') }}">
    <!-- [Material Icons] https://fonts.google.com/icons -->
    <link rel="stylesheet" href="{{ asset('fonts/material.css') }}"><!-- [Template CSS Files] -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" id="main-style-link">
    <link rel="stylesheet" href="{{ asset('css/style-preset.css') }}">
    <link rel="stylesheet" href="{{ asset('css/uikit.css') }}">
    {{-- PLUGIN CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet" />
    <link href="{{ asset('css/plugins/animate.min.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/iziToast.css') }}" />
    <!-- Flat Pickr css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <!-- Sweet Alert-->
    <link href="{{ asset('libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Initialize js -->
    <script src="{{ asset('libs/jquery/jquery.min.js') }}"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> --}}
    {{-- <link href="{{ asset('libs/select2/css/select2.css') }}" rel="stylesheet" type="text/css" /> --}}
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" type="text/css" /> {{-- YANG DIPAKAI INI --}}
    <!-- typeahead css -->
    {{-- <script src="{{ asset('js/plugins/type-ahead.min.js') }}"></script> --}}
    {{-- <link rel="stylesheet" href="{{ asset('libs/typeahead-js/typeahead.css') }}" /> --}}
    <!-- cropper css -->
    {{-- <link rel="stylesheet" href="{{ asset('css/plugins/croppr.min.css') }}"> --}}
    {{-- LIGHTBOX --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/cropper.css') }}">
    <link rel="stylesheet" href="{{ asset('css/plugins/notifier.css') }}">
    <link href="{{ asset('libs/magnific-popup/magnific-popup.css') }}" rel="stylesheet" type="text/css" />
    {{-- INTRO JS --}}
    <link rel="stylesheet" href="{{ asset('css/plugins/introjs.min.css') }}">
    {{-- DATEPICKER (RANGE PICKER) --}}
    <link rel="stylesheet" href="{{ asset('css/plugins/datepicker-bs5.min.css') }}">
    {{-- DATEPICKER --}}
    <link href="{{ asset('libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('libs/spectrum-colorpicker2/spectrum.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('libs/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('libs/@chenfengyuan/datepicker/datepicker.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    {{-- DEARFLIP / 3D FLIPBOOK --}}
    {{-- <link href="https://cdn.jsdelivr.net/npm/@dearhive/dearflip-jquery-flipbook@1.7.3/dflip/css/dflip.min.css" rel="stylesheet"> --}}
    <link href="{{ asset('css/dflip.css') }}" rel="stylesheet" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/@icon/themify-icons@1.0.1-alpha.3/themify-icons.min.css" rel="stylesheet" type="text/css">
    {{-- DATA TABLES --}}
    <link href="https://cdn.datatables.net/v/bs5/jq-3.7.0/jszip-3.10.1/dt-2.1.0/b-3.1.0/b-colvis-3.1.0/b-html5-3.1.0/b-print-3.1.0/datatables.min.css" rel="stylesheet">
    {{-- <link href="https://cdn.datatables.net/fixedcolumns/5.0.1/css/fixedColumns.dataTables.css" rel="stylesheet"> --}}
    {{-- <link rel="stylesheet" href="{{ asset('css/plugins/fixedColumns.bootstrap5.min.css') }}">
    <script src="{{ asset('js/plugins/dataTables.fixedColumns.min.js') }}"></script> --}}
    {{-- <script src="https://cdn.datatables.net/fixedcolumns/5.0.1/js/dataTables.fixedColumns.js"></script>
    <script src="https://cdn.datatables.net/fixedcolumns/5.0.1/js/fixedColumns.dataTables.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/v/bs5/jq-3.7.0/jszip-3.10.1/dt-2.1.0/b-3.1.0/b-colvis-3.1.0/b-html5-3.1.0/b-print-3.1.0/datatables.min.js"></script>

    {{-- FIXED DATATABLE --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.4.0/css/fixedHeader.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/4.3.0/css/fixedColumns.dataTables.min.css">
    {{-- <link rel="stylesheet" href="{{ asset('css/plugins/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/plugins/buttons.bootstrap5.min.css') }}">
    <link href="{{ asset('libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" /> --}}

    {{-- MANUAL STYLING --}}
    <style>
        .table.dataTable  {
            font-size: 13px;
        }
        .tooltip{
            z-index: 1151 !important;
        }
    </style>
</head>

<body data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-layout="vertical" data-pc-direction="ltr" data-pc-theme=""><!-- data-pc-theme_contrast="" data-pc-theme="light" -->


    <!-- Logout Form -->
    <form id="logoutform" action="{{ route('logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
    </form>

    <div class="page-loader">
        <div class="bar"></div>
    </div><!-- [ Pre-loader ] End --><!-- [ Sidebar Menu ] start -->

    @include('inc.nwnavbar')
    @include('inc.nwheader')

    <div class="pc-container">
        <div class="pc-content">

            {{-- START MESSAGE SUCCESS --}}
            @if(session('message'))
            <div class="alert alert-success alert-dismissible fade show">
                <strong>Pesan Sukses!</strong> {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            {{-- END MESSAGE SUCCESS --}}

            {{-- START MESSAGE ERROR --}}
            @if($errors->count() > 0)
            <div class="alert alert-danger alert-dismissible fade show">
                <strong>Pesan Galat!</strong>
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            {{-- END MESSAGE ERROR --}}

            @yield('content') <!-- ALL CONTENT HERE -->
        </div>
    </div>

    @include('inc.nwfooter')

    <script data-cfasync="false" src="{{ asset('cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js') }}"></script>
    <script src="{{ asset('js/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('js/plugins/simplebar.min.js') }}"></script>
    <script src="{{ asset('js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/fonts/custom-font.js') }}"></script>
    <script src="{{ asset('js/pcoded.js') }}"></script>
    <script src="{{ asset('js/plugins/feather.min.js') }}"></script>

    {{-- PLUGIN JS --}}
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
    {{-- <script src="{{ asset('js/plugins/index.global.min.js') }}"></script> --}}
    <script src="{{ asset('js/plugins/apexcharts.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/gh/davidshimjs/qrcodejs/qrcode.min.js"></script>
    <script src="{{ asset('libs/select2/js/select2.min.js') }}"></script> {{-- YANG DIPAKAI INI --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/locale/id.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="{{ asset('js/lightbox-bootstrap5.bundle.min.js') }}"></script>
    <script src="{{ asset('js/plugins/highlight.min.js') }}"></script>
    <script src="{{ asset('js/plugins/clipboard.min.js') }}"></script>
    <script src="{{ asset('js/component.js') }}"></script>

    {{-- DATEPICKER --}}
    <script src="{{ asset('libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('libs/spectrum-colorpicker2/spectrum.min.js') }}"></script>
    <script src="{{ asset('libs/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>
    <script src="{{ asset('libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js') }}"></script>
    <script src="{{ asset('libs/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>
    <script src="{{ asset('libs/@chenfengyuan/datepicker/datepicker.min.js') }}"></script>

    {{-- FIXED DATATABLE --}}
    <script src="https://cdn.datatables.net/fixedheader/3.4.0/js/dataTables.fixedHeader.min.js"></script>
    <script src="https://cdn.datatables.net/fixedcolumns/4.3.0/js/dataTables.fixedColumns.min.js"></script>

    <!-- Magnific Popup-->
    <script src="{{ asset('libs/magnific-popup/jquery.magnific-popup.min.js') }}"></script>

    <!-- lightbox init js-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
    {{-- <script src="{{ asset('js/pages/lightbox.init.js') }}"></script> --}}

    <!-- Flat Pickr js -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <!-- Sweet Alerts js -->
    <script src="{{ asset('libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('js/pages/sweet-alerts.init.js') }}"></script>

    <!-- Notif js -->
    <script src="{{ asset('js/iziToast.js') }}"></script>

    {{-- INTRO JS --}}
    <script src="{{ asset('js/plugins/intro.min.js') }}"></script>

    <!-- DatePicker js -->
    <script src="{{ asset('js/plugins/datepicker-full.min.js') }}"></script>

    {{-- DEARFLIP / 3D FLIPBOOK --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/@dearhive/dearflip-jquery-flipbook@1.7.3/dflip/js/dflip.min.js"></script> --}}
    <script src="{{ asset('js/dflip.js') }}"></script>

    {{-- Cropped IMG JS --}}
    {{-- <script src="{{ asset('js/plugins/croppr.min.js') }}"></script> --}}
    <script src="{{ asset('js/cropper.js') }}"></script>
    <script src="{{ asset('js/plugins/notifier.js') }}"></script>
    {{-- <script src="{{ asset('js/pages/ac-notification.js') }}"></script> --}}

    <!-- BLOB js -->
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/davidshimjs/qrcodejs/qrcode.min.js"></script>

    <!-- Typeahead -->
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js" integrity="sha512-qOBWNAMfkz+vXXgbh0Wz7qYSLZp6c14R0bZeVX2TdQxWpuKr6yHjBIM69fcF8Ve4GUX6B6AKRQJqiiAmwvmUmQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>

    {{-- DATA TABLES --}}
    {{-- <script src="{{ asset('libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>

    <script src="{{ asset('libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('libs/pdfmake/build/pdfmake.min.js') }}"></script>
    <script src="{{ asset('libs/pdfmake/build/vfs_fonts.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script>

    <script src="{{ asset('js/pages/datatables.init.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('libs/admin-resources/rwd-table/rwd-table.min.js') }}"></script> --}}
    {{-- ================================================================================================================= --}}

    {{-- <script src="{{ asset('js/plugins/dataTables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('js/plugins/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('js/plugins/buttons.print.min.js') }}"></script>
    <script src="{{ asset('js/plugins/pdfmake.min.js') }}"></script>
    <script src="{{ asset('js/plugins/jszip.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('js/plugins/vfs_fonts.js') }}"></script>
    <script src="{{ asset('js/plugins/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('js/plugins/buttons.bootstrap5.min.js') }}"></script> --}}
    {{-- ================================================================================================================= --}}

    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/tooltip.js/1.3.1/tooltip.min.js"></script> --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/bs5-lightbox@1.8.3/dist/index.bundle.min.js"></script> --}}
    {{-- <script>layout_change('light');</script>
    <script>change_box_container('false');</script>
    <script>layout_caption_change('true');</script>
    <script>layout_rtl_change('false');</script>
    <script>preset_change('preset-1');</script>
    <script>main_layout_change('vertical');</script> --}}

    <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function () {
        'use strict'

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.querySelectorAll('.needs-validation')

        // Loop over them and prevent submission
        Array.prototype.slice.call(forms).forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
                }

                form.classList.add('was-validated')
            }, false)
            })
        })()
    </script>
</body>

</html>
