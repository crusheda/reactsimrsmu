{{-- @include('inc.simrsmuv2.sidebar') --}}
<!doctype html>
<html lang="en" data-layout-width="boxed" data-topbar="dark" data-preloader="disable" data-card-layout="borderless"
    data-bs-theme="light" data-topbar-image="pattern-1">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
    <meta charset="utf-8" />
    <title>SIMRSMU V3 - {{ Auth::user()->name }}</title>
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
    <script src="{{ asset('js/plugin.js') }}"></script>
    <!-- Initialize js -->
    <script src="{{ asset('libs/jquery/jquery.min.js') }}"></script>
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js" type="text/javascript"></script> --}}

    <!-- Start Addon css -->
    <!-- Flat Pickr css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <!-- Sweet Alert-->
    <link href="{{ asset('libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- DataTables -->
    <link href="{{ asset('libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />

    <!-- Form Advanced examples -->
    {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> --}}
    <link href="{{ asset('libs/select2/css/select2.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet"
        type="text/css">
    <link href="{{ asset('libs/spectrum-colorpicker2/spectrum.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('libs/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet"
        type="text/css">
    <link href="{{ asset('libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('libs/@chenfengyuan/datepicker/datepicker.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <!-- Responsive datatable examples -->
    <link href="{{ asset('libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('libs/admin-resources/rwd-table/rwd-table.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Notif examples -->
    <link rel="stylesheet" href="{{ asset('css/iziToast.css') }}" />

    <!-- Lightbox css -->
    <link href="{{ asset('libs/magnific-popup/magnific-popup.css') }}" rel="stylesheet" type="text/css" />
    <!-- Plugins css -->
    <link href="{{ asset('libs/dropzone/dropzone.css') }}" rel="stylesheet" type="text/css" />

    <!-- typeahead css -->
    <link rel="stylesheet" href="{{ asset('libs/typeahead-js/typeahead.css') }}" />

    <!-- ION Slider -->
    <link href="{{ asset('libs/ion-rangeslider/css/ion.rangeSlider.min.css') }}" rel="stylesheet" type="text/css"/>

    <link href="{{ asset('libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css') }}" rel="stylesheet" />

    <!-- BLOB js -->
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/davidshimjs/qrcodejs/qrcode.min.js"></script>
    <!-- End Addon css -->

</head>

<body data-sidebar="dark">
    <div id="layout-wrapper">

        <!-- Dropdown Select2 appear behind Modal Ajx -->
        {{-- <style>
            .select2-container{
                z-index:auto;
            }
        </style> --}}
        {{-- SUDAH DI SET AUTO DI CSS NYA, \PATH_PROJECT\public\libs\select2\css\select2.min.css --}}

        @include('inc.header')

        @include('inc.sidebar')

        <!-- Start main Content -->
        <div class="main-content">

            <!-- Page-content -->
            <div class="page-content">
                <!-- container-fluid -->
                <div class="container-fluid">

                    <!-- start toart notification -->
                    {{-- IF HAS MESSAGE SUCCESS --}}
                    <div class="d-flex flex-wrap gap-2">
                        <div class="position-fixed top-0 end-0 p-3" style="z-index: 1005">
                            <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                                <div class="toast-header">
                                    <img src="{{ asset('images/logo.svg') }}" alt="" class="me-2" height="18">
                                    <strong class="me-auto">Pesan dari Sistem</strong>
                                    <small>Baru saja</small>
                                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                                </div>
                                <div class="toast-body">
                                    <p id="message"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if(session('message'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="mdi mdi-check-all me-2"></i>
                        {{ session('message') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                    {{-- IF HAS MESSAGE ERRORS --}}
                    <div class="d-flex flex-wrap gap-2">
                        <div class="position-fixed top-0 end-0 p-3" style="z-index: 1005">
                            <div id="liveToastError" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                                <div class="toast-header">
                                    <img src="{{ asset('images/logo.svg') }}" alt="" class="me-2" height="18">
                                    <strong class="me-auto">Pesan Error dari Sistem</strong>
                                    <small>Baru saja</small>
                                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                                </div>
                                <div class="toast-body">
                                    <p id="errorMessage"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if($errors->count() > 0)
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                    <!-- end toart notification -->

                    @yield('content') <!-- ALL CONTENT HERE -->

                </div>
                <!-- End container-fluid -->
            </div>
            <!-- End Page-content -->

            @include('inc.modal')

            @include('inc.footer')

        </div>
        <!-- end main Content-->

    </div>
    <!-- END layout-wrapper -->

    @include('inc.floatmenu')

    <!-- Logout Form -->
    <form id="logoutform" action="{{ route('logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
    </form>

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>
    <!-- JAVASCRIPT -->
    {{-- <script src="{{ asset('libs/jquery/jquery.min.js') }}"></script> --}}
    <script src="{{ asset('libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('libs/node-waves/waves.min.js') }}"></script>
    <!-- apexcharts -->
    <script src="{{ asset('libs/apexcharts/apexcharts.min.js') }}"></script>

    <!-- dashboard init -->
    {{-- <script src="{{ asset('js/pages/dashboard.init.js') }}"></script> --}}

    <!-- App js -->
    <script src="{{ asset('js/app.js') }}"></script>

    <!-- Start Addon js -->
    <!-- Required datatable js -->
    <script src="{{ asset('libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Buttons DT examples -->
    <script src="{{ asset('libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('libs/pdfmake/build/pdfmake.min.js') }}"></script>
    <script src="{{ asset('libs/pdfmake/build/vfs_fonts.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script>

    <!-- Form Advanced examples -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}
    <script src="{{ asset('libs/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('libs/spectrum-colorpicker2/spectrum.min.js') }}"></script>
    <script src="{{ asset('libs/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>
    <script src="{{ asset('libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js') }}"></script>
    <script src="{{ asset('libs/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>
    <script src="{{ asset('libs/@chenfengyuan/datepicker/datepicker.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <!-- Responsive examples -->
    <script src="{{ asset('libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('libs/admin-resources/rwd-table/rwd-table.min.js') }}"></script>

    <!-- Datatable init js -->
    <script src="{{ asset('js/pages/datatables.init.js') }}"></script>

    <!-- Flat Pickr js -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <!-- Sweet Alerts js -->
    <script src="{{ asset('libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('js/pages/sweet-alerts.init.js') }}"></script>

    <!-- Notif js -->
    <script src="{{ asset('js/iziToast.js') }}"></script>

    <!-- Magnific Popup-->
    <script src="{{ asset('libs/magnific-popup/jquery.magnific-popup.min.js') }}"></script>

    <!-- lightbox init js-->
    <script src="{{ asset('js/pages/lightbox.init.js') }}"></script>

    <!-- Plugins js -->
    <script src="{{ asset('libs/dropzone/dropzone-min.js') }}"></script>
    <!-- jquery step -->
    <script src="{{ asset('libs/jquery-steps/build/jquery.steps.min.js') }}"></script>

    <!-- Typeahead -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>

    <!-- ION Slider -->
    <script src="{{ asset('libs/ion-rangeslider/js/ion.rangeSlider.min.js') }}"></script>

    <!-- Touchspin js -->
    <script src="{{ asset('libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js') }}"></script>

    <!-- End Addon js -->

    {{-- JS INIT --}}
    <script>
        $(document).ready(function() {
            if ("{{ session('message') }}") {
                message("{{ session('message') }}");
            }
            if ("{{ session('error') }}") {
                error("{{ session('error') }}");
            }
        })

        // ALL FUNCTION BELOW
        function message(message) {
            //  Bootstrap Toast Message
            var toastme = document.getElementById('liveToast');
            $('#message').text(message);
            var toast = new bootstrap.Toast(toastme);

            toast.show();
        }

        function error(error) {
            //  Bootstrap Toast Message
            var toastme = document.getElementById('liveToastError');
            // for (let index = 0; index < error.length; index++) {
            //     $('#errorMessage').append(error[index]);
            // }
            $('#errorMessage').html(error);
            var toast = new bootstrap.Toast(toastme);

            toast.show();
        }

        function closeModal() {
            $('.modal').modal('hide');
        }
    </script>
</body>

</html>
