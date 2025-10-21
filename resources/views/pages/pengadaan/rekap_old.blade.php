@extends('layouts.default')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Pengadaan - Rekapitulasi Bulanan (<b class="text-danger">{{ $list['ref']->nama }}</b>)</h4>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="btn-group">
                <button type="button" class="btn btn-secondary" data-toggle="tooltip" data-placement="bottom"
                    title="KEMBALI" onclick="window.location='{{ route('pengadaan.index') }}'"><i
                        class="fa-fw fas fa-angle-left nav-icon text-white"></i>&nbsp;&nbsp;Kembali</button>
                {{-- <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#rekapAll"
                    title="REKAP KESELURUHAN"><i class="fa-fw fas fa-database nav-icon text-white"></i> Rekap
                    Keseluruhan</button> --}}
            </div>
            <hr>
            <div class="table-responsive" style="border: 0px">
                <table id="dttable" class="table table-bordered display"
                    style="font-size: 13px;width: 100%;/* white-space: nowrap;word-break: break-word; */">
                    <thead>
                        <tr>
                            <th rowspan="2">IDB</th>
                            <th rowspan="2">BARANG</th>
                            <th rowspan="2">HARGA</th>
                            <th rowspan="2">SATUAN</th>
                            @foreach ($list['unit'] as $item)
                                <th colspan="3" style="text-transform:uppercase">
                                    {{ str_replace('","', ' , ', str_replace('-', ' ', str_replace(['["', '"]'], '', $item->unit))) }}<br>(<a class="text-danger" data-bs-toggle="tooltip"
                                    data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true"
                                    title="Tanggal Pengadaan">{{ \Carbon\Carbon::parse($item->tgl_pengadaan)->isoFormat('D MMM Y') }}</a>)
                                </th>
                            @endforeach
                        </tr>
                        <tr>
                            @foreach ($list['unit'] as $item)
                                <th>JML</th>
                                <th>NOM</th>
                                <th>KET</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($list['barang'] as $item)
                            <tr>
                                <td>{{ $item->id_barang }}</td>
                                <td>{{ $item->nama_barang }}</td>
                                <td>{{ $item->harga_barang }}</td>
                                <td>{{ $item->satuan_barang }}</td>
                                @foreach ($list['unit'] as $val1)
                                    @php
                                        $jumlah = App\Models\pengadaan_detail::join('pengadaan', 'pengadaan_detail.id_pengadaan', '=', 'pengadaan.id_pengadaan')
                                            ->select('pengadaan_detail.jumlah')
                                            ->where('pengadaan_detail.id_pengadaan', $val1->id_pengadaan)
                                            ->where('pengadaan_detail.id_barang', $item->id_barang)
                                            ->first();
                                        $total = App\Models\pengadaan_detail::join('pengadaan', 'pengadaan_detail.id_pengadaan', '=', 'pengadaan.id_pengadaan')
                                            ->select('pengadaan_detail.total')
                                            ->where('pengadaan_detail.id_pengadaan', $val1->id_pengadaan)
                                            ->where('pengadaan_detail.id_barang', $item->id_barang)
                                            ->first();
                                        $ket = App\Models\pengadaan_detail::join('pengadaan', 'pengadaan_detail.id_pengadaan', '=', 'pengadaan.id_pengadaan')
                                            ->select('pengadaan_detail.ket')
                                            ->where('pengadaan_detail.id_pengadaan', $val1->id_pengadaan)
                                            ->where('pengadaan_detail.id_barang', $item->id_barang)
                                            ->first();
                                        // $totalAll[] = $total->total;
                                    @endphp
                                    <td>
                                        @if (!empty($jumlah))
                                            {{ str_replace(['{"jumlah":', '}'], '', $jumlah) }}
                                        @endif
                                    </td>
                                    <td style="white-space: nowrap;">
                                        @if (!empty($total))
                                            Rp.
                                            {{ number_format((int) str_replace(['{"total":', '}'], '', $total), 2, ',', '.') }}
                                        @endif
                                    </td>
                                    <td style="white-space: normal !important;word-wrap: break-word;">
                                        @if (!empty($ket))
                                            {{  str_replace(['{"ket":', '}'], '', $ket)=='null'?'':str_replace(['{"ket":"', '"}'], '', $ket) }}
                                        @endif
                                    </td>

                                    {{-- <td>{{ $totalAll }}</td> --}}
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                    {{-- <tfoot>
                        <th colspan="4"><kbd>TOTAL</kbd></th>
                        @foreach ($list['total'] as $item)
                            <th colspan="2">
                                @if (!empty($item))
                                    Rp. {{ number_format((int) str_replace(['{"total":', '}'], '', $item), 2, ',', '.') }}
                                @endif
                            </th>
                        @endforeach
                    </tfoot> --}}
                </table>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            var table = $('#dttable').DataTable({
                order: [
                    [1, "asc"]
                ],
                displayLength: 75,
                lengthChange: true,
                lengthMenu: [75, 100, 200, 500],
                buttons: ['copy', 'excel', 'pdf', 'colvis']
            });

            table.buttons().container()
                .appendTo('#dttable_wrapper .col-md-6:eq(0)');
        })
    </script>
@endsection
