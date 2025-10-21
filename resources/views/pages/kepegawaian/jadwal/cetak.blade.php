<html>
<head>
    <title>Jadwal Dinas</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
    {{-- <style type="text/css">
		table tr td,
		table tr th{
			font-size: 12pt;
		}
    </style> --}}
    <style type="text/css">
            table th, table td {
            border:1px solid #000;
            padding:0.5em;
			/* font-size: 17pt; */
            font-family:'Times New Roman', Times, serif;
        }
        @media print {
            @page {
                size: 310mm 215mm; /* width height */
                /* size: A4 landscape; */
                margin: 5mm; /* margin atas-kanan-bawah-kiri */
            }

            /* Sembunyikan semua elemen kecuali container cetak */
            body * {
                visibility: hidden;
            }

            #tabelCetakContainer,
            #tabelCetakContainer * {
                visibility: visible;
            }

            /* Hilangkan scroll Bootstrap saat print */
            #tabelCetakContainer .table-responsive {
                overflow: visible !important;
            }

            /* Posisi container cetak */
            #tabelCetakContainer {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                font-size: 8pt; /* pakai satuan */
            }

            #tabelCetakContainer table {
                width: 100% !important;
                padding: 2px;
                table-layout: fixed;
                border-collapse: collapse;
                font-size: 8pt; /* pakai satuan */
            }

            #tabelCetakContainer th,
            #tabelCetakContainer td {
                font-size: 10pt;
                padding: 2px;
                border: 1px solid #000;
                word-wrap: break-word;
            }

            #tabelCetakContainer .titleCetak {
                font-size: 18pt;
                text-align: center;
                margin-bottom: 5px;
            }

            /* Footer shift + keterangan */
            #tabelCetakContainer .row {
                display: flex !important;
                flex-wrap: nowrap !important;
                justify-content: space-between;
                margin: 0 !important;
                padding: 0 !important;
            }

            #tabelCetakContainer .row > .col-md-6 {
                flex: 0 0 49% !important;
                max-width: 49% !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            #tabelCetakContainer .list-group {
                display: block !important;
                margin: 0;
                padding: 0;
            }

            #tabelCetakContainer .list-group label {
                display: block !important;
                padding: 2px 0 !important;
                margin: 0 !important;
            }

            #tabelCetakContainer .footerCetak {
                font-size: 12pt;
                margin-bottom: 5px;
            }
        }
    </style>
    <div class="" style="font-family:'Times New Roman', Times, serif;" id="tampil-jadwal">
        <center><i class="fa fa-spinner fa-spin fa-fw"></i> Memproses data...</center>
    </div>
    <script src="{{ asset('libs/jquery/jquery.min.js') }}"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script>
        $.ajax({
            url: "/api/kepegawaian/jadwaldinas/jadwal/{{ $list['id'] }}",
            type: 'GET',
            dataType: 'json',
            success: function(res) {
                if (res.detail.length === 0) {
                    notifier.show(
                        "Pesan Galat!",
                        "Data isian Jadwal Dinas tidak ditemukan, silakan melengkapi jadwal terlebih dahulu (Klik Ubah)",
                        "warning",
                        "{{ asset('images/notification/medium_priority-48.png') }}",
                        4000
                    );
                    return;
                }

                $("#showUser").text(res.jadwal.nama_pegawai);
                let n = 1;
                let content = `
                    <div id="tabelCetakContainer">
                        <h4 class="text-center mb-2 titleCetak text-uppercase">Jadwal Dinas Unit <b class="">${res.jadwal.unit}</b></h4>
                        <h5 class="text-center mb-4 titleCetak text-uppercase">Bulan <b class="">${res.bulan}</b> Tahun <b class="">${res.jadwal.tahun}</b></h5>
                        <div class="row" id="tabelCetak">
                            <div class="col-md-12 mb-3">
                                <div class="table-responsive p-10 pb-0">
                                    <table class="table table-bordered" style="width: 100%;table-layout: auto">
                                        <thead>
                                            <tr>
                                                <th class="text-center" rowspan="2">NO</th>
                                                <th class="text-center" rowspan="2">NAMA</th>
                                                <th class="text-center" colspan="${res.totalDay}">TANGGAL</th>
                                                <th class="text-center" rowspan="2">JAM KERJA</th>
                                                <th class="text-center" colspan="${res.shift.length + 6}" style="background-color:#eaeeaf;border-top: 3px solid #eaeeaf;border-left: 3px solid #eaeeaf;border-right: 3px solid #eaeeaf;">JML SHIFT</th>
                                            </tr>
                                            <tr>`;

                // Header tanggal
                for (let i = 1; i <= res.totalDay; i++) {
                    let lnItem = res.ln.find(ln => ln.tgl === i);
                    let style = lnItem ? ` style="background-color: ${lnItem.color};"` : '';
                    content += `<th class="p-2 text-center tgl${i}"${style}>${i < 10 ? '0'+i : i}</th>`;
                }

                // Header shift
                res.shift.forEach((s, index) => {
                    content += `<th class="p-2 text-center" ${index===0?"style='border-left: 3px solid #eaeeaf;'":""}>${s.singkat}</th>`;
                });
                ['L','C','CM','CU','CH','CD'].forEach((s, index, arr) => {
                    let border = (s==='CD') ? "style='border-right: 3px solid #eaeeaf;'" : '';
                    content += `<th class="p-2 text-center" ${border}>${s}</th>`;
                });
                content += `</tr></thead><tbody p-2>`;

                // Mapping shift -> jam kerja & inisialisasi shiftCounts
                let shiftDurasi = {};
                let shiftCounts = {};
                res.shift.concat(['L','C','CM','CU','CH','CD']).forEach(s => {
                    shiftDurasi[s.singkat || s] = ['L','C','CM','CU','CH','CD'].includes(s.singkat || s) ? 0 :
                        (function() {
                            let start = new Date(`1970-01-01T${s.berangkat}`);
                            let end = new Date(`1970-01-01T${s.pulang}`);
                            if (end < start) end.setDate(end.getDate()+1);
                            return (end - start)/(1000*60*60);
                        })();
                    shiftCounts[s.singkat || s] = 0;
                });

                // Mapping jumlah per tanggal
                let shifts = res.shift.map(s=>s.singkat).concat(['L','C','CM','CU','CH','CD']);
                let tfootCounts = {};
                for (let i=1;i<=res.totalDay;i++){
                    tfootCounts[i] = {};
                    shifts.forEach(s => tfootCounts[i][s]=0);
                }
                res.detail.forEach(pegawai => {
                    for (let i=1;i<=res.totalDay;i++){
                        let kodeShift = pegawai[`tgl${i}`];
                        if(kodeShift && tfootCounts[i][kodeShift]!==undefined) tfootCounts[i][kodeShift]++;
                    }
                });

                // LOOPING JADWAL DINAS
                res.detail.forEach(pegawai => {
                    let pegawaiShiftCounts = {...shiftCounts};
                    for (let i=1;i<=res.totalDay;i++){
                        let kodeShift = pegawai[`tgl${i}`];
                        if(kodeShift && pegawaiShiftCounts[kodeShift]!==undefined) pegawaiShiftCounts[kodeShift]++;
                    }

                    content += `<tr class="text-start">
                                    <td style="background-color: ${pegawai.color}" class="text-center">${n++}</td>
                                    <td class="text-start" style="background-color: ${pegawai.color}">
                                        <div class='d-flex justify-content-start align-items-center'>
                                            <div class='d-flex flex-column'>
                                                <a class='mb-0 clef'>${pegawai.pegawai_nama}</a>
                                                <a class='text-truncate clef'>${pegawai.jabatan || ''}</a>
                                            </div>
                                        </div>
                                    </td>`;

                    // tanggal
                    for (let i=1;i<=res.totalDay;i++){
                        let kodeShift = pegawai[`tgl${i}`]||'';
                        let lnItem = res.ln.find(ln => ln.tgl==i);
                        let style = lnItem ? ` style="background-color: ${lnItem.color};"` : '';
                        content += `<td class="p-2 text-center tgl${i}"${style}>${kodeShift}</td>`;
                    }

                    // total jam kerja
                    let totalJamKerja = 0;
                    for (let i=1;i<=res.totalDay;i++){
                        let kodeShift = pegawai[`tgl${i}`];
                        if(kodeShift && shiftDurasi[kodeShift]) totalJamKerja += shiftDurasi[kodeShift];
                    }
                    content += `<td class="p-2 text-center">${totalJamKerja}</td>`;

                    // shift counts
                    res.shift.forEach((s,index)=>{
                        content += `<td class="p-2 text-center" ${index==0?"style='border-left: 3px solid #eaeeaf;'":""}>${pegawaiShiftCounts[s.singkat]}</td>`;
                    });
                    ['L','C','CM','CU','CH','CD'].forEach(s=>{
                        let border = (s==='CD') ? "style='border-right: 3px solid #eaeeaf;'" : '';
                        content += `<td class="p-2 text-center" ${border}>${pegawaiShiftCounts[s]}</td>`;
                    });

                    content += `</tr>`;
                });

                // tfoot
                content += `<tfoot style="border:3px solid #eaeeaf;">`;
                shifts.forEach((shift,index)=>{
                    content += `<tr>${index===0 ? `<th rowspan="${shifts.length}" style="writing-mode: vertical-rl; transform: rotate(180deg); text-align:center;background-color:#eaeeaf;">JUMLAH SHIFT</th>` : '' }
                                    <th>${shift}</th>`;
                    for (let i=1;i<=res.totalDay;i++){
                        content += `<td class="text-center">${tfootCounts[i][shift]}</td>`;
                    }
                    content += `</tr>`;
                });
                content += `</tfoot></table></div></div></div>`;

                // Keterangan shift
                content += `<div class="row" id="footerCetak"><div class="col-md-6 footerCetak">
                                <div class="p-10">
                                    <a>Shift Jaga :</a>
                                    <div class="list-group">
                                        <ul>`;
                            res.shift.forEach(item=>{
                                content += `<li><b class="me-1">${item.singkat}</b>(<u>${item.shift}</u>) : ${item.berangkat.substring(0,5)} - ${item.pulang.substring(0,5)} WIB</li>`;
                            });
                            ['L','C','CM','CU','CH','CD'].forEach(s=>{
                                content += `<li><b class="me-1 text-danger">${s}</b>(<u class="text-danger">${s==='L'?'LIBUR':'CUTI'}</u>)</li>`;
                            });
                            content += `</ul>
                                    </div>
                                </div>
                            </div>`;

                // Keterangan warna
                content += `<div class="col-md-6 footerCetak">
                                <div class="p-10">
                                    <a>Keterangan :</a>
                                    <div class="list-group">`;
                            content += `<label class="list-group-item border-0 p-1">
                                            <a class="btn btn-light me-3" style="background-color: #fed8b9" href="javascript:void(0);"></a>&nbsp;&nbsp;Hari Minggu
                                        </label>`;
                        res.ln.forEach(item=>{
                            content += `<label class="list-group-item border-0 p-1">
                                            <a class="btn btn-light me-3" style="background-color: ${item.color}" href="javascript:void(0);"></a>&nbsp;&nbsp;
                                            ${item.deskripsi}${item.keterangan ? ' ('+item.keterangan+')' : ''} ${item.tgl ? ' - Tanggal '+item.tgl : ''}
                                        </label>`;
                        });
                        content += `</div>
                                </div>
                            </div>
                        </div>
                    </div>`;

                $('#tampil-jadwal').empty().append(content);

                // warna hari minggu
                for (let i=0;i<res.totalDay;i++){
                    if(res.dataArray[i]==='Minggu'){
                        $('.tgl'+(i+1)).css('background-color','#fed8b9');
                    }
                }

                autoClosePrintWindow();
                // window.print();
                // window.onafterprint = function() {
                //     window.close();
                // }
            },
            error: function(res) {
                alert('Jadwal Dinas gagal dimuat, silakan coba beberapa saat lagi');
            }
        })

        function autoClosePrintWindow() {
            // Untuk browser modern
            if (window.matchMedia) {
                const mediaQueryList = window.matchMedia('print');
                mediaQueryList.addEventListener('change', function(mql) {
                    if (!mql.matches) {
                        window.close(); // tutup setelah selesai print / cancel
                    }
                });
            }

            // Fallback untuk browser lain
            window.onafterprint = function() {
                window.close();
            };

            window.print();
        }
    </script>
</body>
</html>
