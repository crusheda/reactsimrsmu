@extends('layouts.index')

@section('content')

    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i></a></li>
                        <li class="breadcrumb-item">Kepegawaian</li>
                        <li class="breadcrumb-item">Absensi</li>
                        <li class="breadcrumb-item" aria-current="page">Dashboard</li>
                    </ul>
                </div>
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h2 class="mb-0">Dashboard <b class="text-primary">Interaktif</b> Absensi</h2>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- [ breadcrumb ] end -->

    <!-- [ Main Content ] start -->
    <div class="row pt-1">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between p-3">
                    <h5 class="mb-0 ms-3"><b style="font-size: 1rem"><b class="text-dark">Periode Tanggal </b> : <a id="periode-grafik1" data-bs-toggle="tooltip"
                        data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="Perubahan Rentang Tanggal bisa menghubungi Developer :)"><i class="fas fa-spinner fa-spin"></i></a></h5>
                    <div class="btn-group">
                        <button class="btn btn-warning rounded btn-sm" onclick="refresh()" id="btn-refresh-grafik1" data-bs-toggle="tooltip"
                        data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="Segarkan Tabel"><i class="fas fa-sync f-20 me-2"></i> Refresh Grafik</button>
                    </div>
                </div>
                <div class="card-body">
                    <div id="chartAbsensi">
                        <div class="text-center p-3 text-muted">
                            <i class="fas fa-spinner fa-spin"></i> Memuat Grafik Interaktif...
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // SELECT2
            var t = $(".select2");
            t.length && t.each(function() {
                var e = $(this);
                e.wrap('<div class="position-relative"></div>').select2({
                    placeholder: "Pilih",
                    allowClear: true,
                    dropdownParent: e.parent()
                })
            });
            loadGrafik1();
        })

        function refresh() {
            loadGrafik1();
        }

        function loadGrafik1() {
            $('#btn-refresh-grafik1').prop('disabled',true).find('i').addClass('fa-spin');
            $("#periode-grafik1").empty().append(`<i class="fas fa-spinner fa-spin"></i>`);
            $("#chartAbsensi").empty().append(`<div class="text-center p-3 text-muted"><i class="fas fa-spinner fa-spin"></i> Memuat Grafik Interaktif...</div>`);
            $.ajax({
                url: "{{ route('kepegawaian.absensi.dashboard.grafik1') }}",
                type: 'GET',
                dataType: 'json',
                success: function (res) {
                    var colors = ["#008FFB", "#FEB019", "#FF4560"]; // urutan series sesuai chart

                    var options = {
                        chart: {
                            type: "area",
                            height: 300,
                            toolbar: { show: false }
                        },
                        colors: colors,
                        fill: {
                            type: "gradient",
                            gradient: {
                                shadeIntensity: 1,
                                type: "vertical",
                                inverseColors: false,
                                opacityFrom: 0.5,
                                opacityTo: 0
                            }
                        },
                        dataLabels: { enabled: true, formatter: val => val.toFixed(1) + '%' },
                        stroke: { width: 2 },
                        grid: { strokeDashArray: 4 },
                        series: res.series,
                        xaxis: {
                            categories: res.labels,
                            axisBorder: { show: false },
                            axisTicks: { show: false }
                        },
                        yaxis: {
                            title: { text: "Persentase (%)" },
                            max: 100,
                            min: 0
                        },
                        legend: { position: "top" },
                        tooltip: {
                            shared: true,
                            custom: function({ series, dataPointIndex, w }) {
                                // Ambil nama bulan dari label chart (Jan, Feb, Mar, dst)
                                const bulanLabel = res.labels[dataPointIndex];

                                // Ambil key bulan asli dari debug (format: 2025-01, 2025-02, ...)
                                // dataPointIndex sesuai urutan labels
                                const tahunSekarang = new Date().getFullYear();
                                const keyBulan = `${tahunSekarang}-${String(dataPointIndex+1).padStart(2,'0')}`;

                                // Ambil data debug
                                const debug = res.debug[keyBulan] || {};
                                const totalPegawai = debug.pegawai_total || 0;

                                let html = `<div style="padding:10px; background:#fff; border-radius:8px; box-shadow:0 2px 10px rgba(0,0,0,0.15); font-family:sans-serif;">`;
                                html += `<div style="font-weight:bold; font-size:14px; margin-bottom:6px;">${bulanLabel}</div>`;
                                html += `<div style="font-size:13px; margin-bottom:6px;">Pegawai Total: <strong>${totalPegawai}</strong></div>`;

                                // Loop series
                                w.config.series.forEach((s, i) => {
                                    const value = s.data[dataPointIndex].toFixed(2);
                                    html += `
                                        <div style="display:flex; align-items:center; margin-bottom:4px;">
                                            <span style="width:12px; height:12px; display:inline-block; background:${w.config.colors[i]}; border-radius:50%; margin-right:6px;"></span>
                                            <span style="font-size:13px;">${s.name}: <strong>${value}%</strong></span>
                                        </div>
                                    `;
                                });

                                html += `</div>`;
                                return html;
                            }
                        }
                    };

                    // Hapus chart lama sebelum render ulang
                    $("#chartAbsensi").empty();
                    $("#periode-grafik1").empty().append(`<b class="text-danger">${res.periode.dari}</b> - <b class="text-danger">${res.periode.sampai}</b>`);
                    var chart = new ApexCharts(document.querySelector("#chartAbsensi"), options);
                    chart.render();
                    $('#btn-refresh-grafik1').prop('disabled', false).find('i').removeClass('fa-spin');
                }
            });
        }

    </script>
@endsection
