@extends('layouts.index')

@section('content')
    <style>
        #calendar {
            /* max-width: 900px; */
            margin: 0 auto;
            background: #fff;
            border-radius: 10px;
            padding: 10px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
    </style>

    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i></a></li>
                        <li class="breadcrumb-item" aria-current="page">Kalender Digital</li>
                    </ul>
                </div>
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h2 class="mb-0">Kalender <b class="text-primary">Manajemen</b></h2>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- [ breadcrumb ] end -->

    <!-- [ Main Content ] start -->
    <div class="row pt-1">
        <div class="col-xl-12">
            <div class="card mb-3">
                <div class="card-header d-flex align-items-center justify-content-between py-2 px-2">
                    <button type="button" class="btn btn-info rounded" onclick="refresh()"><i class="fa-fw fas fa-sort-amount-down nav-icon me-1"></i> Riwayat</button>
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary rounded" data-bs-toggle="modal" data-bs-target="#tambah"><i class="fa-fw fas fa-plus-square nav-icon me-1"></i> Tambah</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-12">
            <div id="calendar" class="calendar"><center><i class="fa-fw fas fa-spinner fa-spin nav-icon me-1"></i> Memuat Kalender...</center></div>
        </div>
    </div>

    <div class="modal fade" id="calendar-modal" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="calendar-modal-title f-w-600 text-truncate">Modal title</h3><a href="#"
                        class="avtar avtar-s btn-link-danger btn-pc-default ms-auto" data-bs-dismiss="modal"><i
                            class="ti ti-x f-20"></i></a>
                </div>
                <div class="modal-body">
                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            <div class="avtar avtar-xs bg-light-secondary"><i class="ti ti-heading f-20"></i></div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="mb-1"><b>Title</b></h5>
                            <p class="pc-event-title text-muted"></p>
                        </div>
                    </div>
                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            <div class="avtar avtar-xs bg-light-warning"><i class="ti ti-map-pin f-20"></i></div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="mb-1"><b>Venue</b></h5>
                            <p class="pc-event-venue text-muted"></p>
                        </div>
                    </div>
                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            <div class="avtar avtar-xs bg-light-danger"><i class="ti ti-calendar-event f-20"></i></div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="mb-1"><b>Date</b></h5>
                            <p class="pc-event-date text-muted"></p>
                        </div>
                    </div>
                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            <div class="avtar avtar-xs bg-light-primary"><i class="ti ti-file-text f-20"></i></div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="mb-1"><b>Description</b></h5>
                            <p class="pc-event-description text-muted"></p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <ul class="list-inline me-auto mb-0">
                        <li class="list-inline-item align-bottom"><a href="#" id="pc_event_remove"
                                class="avtar avtar-s btn-link-danger btn-pc-default w-sm-auto" data-bs-toggle="tooltip"
                                title="Delete"><i class="ti ti-trash f-18"></i></a></li>
                        <li class="list-inline-item align-bottom"><a href="#" id="pc_event_edit"
                                class="avtar avtar-s btn-link-success btn-pc-default" data-bs-toggle="tooltip"
                                title="Edit"><i class="ti ti-edit-circle f-18"></i></a></li>
                    </ul>
                    <div class="flex-grow-1 text-end"><button type="button" class="btn btn-primary"
                            data-bs-dismiss="modal">Close</button></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            loadCalendar();

            // 🔹 Contoh: reload kalender saat dropdown berubah
            $('#filter-unit').on('change', function() {
                let selected = $(this).val();
                loadCalendar(selected);
            });
        });

        function loadCalendar(filterUnit = null) {
            // Hapus kalender lama jika sudah ada
            $('#calendar').html('');

            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                height: 'auto',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: "dayGridMonth,timeGridWeek,timeGridDay,listMonth"
                },
                themeSystem: "bootstrap",
                selectable: true,
                editable: true,
                selectMirror: !0,
                dayMaxEvents: !0,
                handleWindowResize: !0,

                // 🔹 Kirim parameter filter ke route Laravel (jika ada)
                events: {
                    url: '/api/kalender/data',
                    method: 'GET',
                    extraParams: {
                        unit: filterUnit // bisa null, atau isi dari dropdown
                    },
                    failure: function() {
                        alert('Gagal memuat data event!');
                    }
                },

                dateClick: function(info) {
                    alert('Tanggal diklik: ' + info.dateStr);
                },

                eventClick: function(info) {
                    alert('Event: ' + info.event.title);
                }
            });

            calendar.render();
        }
    </script>
@endsection
