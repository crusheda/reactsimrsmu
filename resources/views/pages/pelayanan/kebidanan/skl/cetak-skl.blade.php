<html>
<head>
    <title>{{ $list['show']->ibu }} - {{ $list['tgl'] }}</title>

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('img/pku_ico.png') }}">
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
			font-size: 17pt;
            font-family:'Times New Roman', Times, serif;
        }
        @media print
        {
            @page {
            size: F4;
            margin:0;
            /* size: 210mm 297mm;  */
            /* Chrome sets own margins, we change these printer settings */
            margin: 3mm 0mm 0mm 3mm;
            }
        }
    </style>
    <center>
        {{-- <h4>Dokumen Kepegawaian</h4>
        <p>Update: {{ $user[0]->updated_at }}</p> --}}
        {{-- <img src="{{ public_path().'/img/kop.png' }}" height="100"> --}}
        <img src="{{ asset('images/pku/kop.png') }}" width="100%">
    </center>
    <div class="container" style="font-family:'Times New Roman', Times, serif;">

        <p class="text-center" style="margin-top: -30px;font-size: 20pt;"><b><u>SURAT KETERANGAN</u></b></p>
        <p class="text-center" style="margin-top: -20px;font-size: 17pt;"><b>Nomor : {{ $list['show']->no_surat }}/KET/IKP/III.6.AU/PKUSKH/{{ $list['thn'] }}</b></p>
        <br>

        <div class="row" style="font-size: 17pt;">
            <div class="col-md-12">
                Telah Lahir Pada
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-3">
                Hari<br>
                Tanggal<br>
                Waktu
            </div>
            <div class="col-md-8">
                : {{ $list['show']->hari }}<br>
                : {{ $list['tgl'] }}<br>
                : {{ $list['jam'] }}
            </div>
            <div class="col-md-12">
                Di Rumah Sakit PKU Muhammadiyah Sukoharjo seorang bayi @if($list['show']->kelamin != 'unknown') {{ $list['show']->kelamin }} @endif hidup.
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-3">
                NIK Ibu<br>
                Nama Ibu<br>
                NIK Ayah<br>
                Nama Ayah<br>
                Alamat
            </div>
            <div class="col-md-8">
                : {{ $list['show']->nik_ibu }}<br>
                : {{ $list['show']->ibu }}<br>
                : {{ $list['show']->nik_ayah }}<br>
                : {{ $list['show']->ayah }}<br>
                : {{ $list['show']->alamat }}<br>
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-3">
                Nama Anak<br>
                Berat Badan<br>
                Panjang Badan
            </div>
            <div class="col-md-8">
                : {{ $list['show']->anak }}<br>
                : {{ $list['show']->bb }} gram<br>
                : {{ $list['show']->tb }} cm<br>
            </div>
        </div>

        <br>
        <div class="row" style="font-size: 17pt;">
            <div class="col-md-8"></div>
            <div class="col-md-4">
                <p class="text-center">Sukoharjo, {{ $list['tgl'] }}</p>
                <p class="text-center" style="margin-top: -20px">Dokter</p>
                <p class="text-center">
                    @if ($list['show']->dr == 1)
                        <br><br>
                        <b>dr. Gede Sri Dhyana M. A., Sp.OG</b>
                    @elseif ($list['show']->dr == 2)
                        <img src="{{ asset('images/pku/kebidanan/ttd-ahmad.png') }}" width="65%"><br>
                        <b>dr. H. Ahmad Sutamat, Sp.OG</b>
                    @elseif ($list['show']->dr == 3)
                        <img src="{{ asset('images/pku/kebidanan/ttd-febrian.png') }}" width="45%"><br>
                        <b>dr. Febrian Andhika A.,Sp.OG</b>
                    @endif
                </p>
            </div>
        </div>
    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script>
        window.print();
        window.onafterprint = function() {
            window.close();
        }
        // window.onload = window.print;
        // document_focus = true;
        // win = window.open();
        // Now our event handlers.
        // setInterval(function() { if (document_focus === true) { window.close(); }  }, 300);
    </script>
</body>
</html>
