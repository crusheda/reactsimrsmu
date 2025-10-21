@extends('layouts.default')

@section('content')
    <style>
        #myBtn {
            display: none;
            position: fixed;
            bottom: 20px;
            right: 30px;
            z-index: 99;
            font-size: 18px;
            border: none;
            outline: none;
            border-radius: 50%;
            color: white;
            cursor: pointer;
            /* padding: 15px; */
            border-radius: 4px;
        }
    </style>
    <button onclick="topFunction()" id="myBtn" class="bg-primary" title="Go to top" style="display: none">
        <h6 style="margin-top: 0.3rem;margin-bottom: 0.3rem;"><i class='bx bx-chevron-up align-middle'></i> Gulir ke atas</h6>
    </button>
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Pengadaan</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">
                        <div>
                            <h4 class="card-title mb-3">Digital Pengadaan</h4>
                            <p class="text-muted">Semua data terintegrasi menjadi satu dengan tampilan yang baru hanya di
                                Simrsmu</p>
                            <div class="btn-group">
                                <a href="javascript:void(0);" class="btn btn-primary btn-sm"><i
                                        class='bx bx-info-circle align-middle'></i> Baca Panduan</a>
                                @if (Auth::user()->getPermission('admin_pengadaan'))
                                    <a class="btn btn-dark btn-sm" href="javascript:void(0);" role="button"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Menu&nbsp;&nbsp;<i class='bx bx-caret-down align-middle'></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item" href="javascript:void(0);"><s>Tambah Barang</s></a>
                                        <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                                            data-bs-target="#rekap">Rekap Pengadaan</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div>
                            <img src="{{ asset('images/jobs.png') }}" alt="" height="100">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-4"><i class="bx bx-sort-down"></i> Riwayat Pengadaan</h4>
                        <div class="dropdown ms-2 dropend">
                            <a onclick="refreshRiwayat()" class="text-warning" href="javascript:void(0);"
                                data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true"
                                title="Refresh Data Riwayat Pengadaan"><i class='fa-fw fas fa-sync nav-icon'></i></a>
                            {{-- <a class="text-muted" href="#" role="button" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="mdi mdi-dots-horizontal font-size-18"></i>
                            </a>

                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="#">Lihat Keranjang</a>
                                <a class="dropdown-item" href="#">Hapus Isi Keranjang</a>
                            </div> --}}
                        </div>
                    </div>
                    <div data-simplebar style="max-height: 500px;">
                        <div class="table-responsive" style="border: 0px">
                            <table class="table table-nowrap align-middle table-hover mb-0">
                                <tbody id="tampil-tbody">
                                    <tr>
                                        <td colspan="9">
                                            <center><i class="fa fa-spinner fa-spin fa-fw"></i> Memuat data...</center>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-lg-9">

            <div class="row mb-3">
                <div class="col-xl-4 col-sm-6">
                    <div class="mt-2">
                        <h5><i class="bx bx-menu-alt-left"></i> Pembelanjaan</h5>
                    </div>
                </div>
                <div class="col-lg-8 col-sm-6">
                    <div class="mt-4 mt-sm-0 float-sm-end d-sm-flex align-items-center">
                        <div class="search-box me-2">
                            <div class="position-relative">
                                <input type="text" class="form-control border-0 typeahead" id="caribarang"
                                    autocomplete="off" placeholder="Cari Barang..." data-bs-toggle="tooltip"
                                    data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true"
                                    title="Tekan ENTER untuk Submit">
                                <i class="bx bx-search-alt search-icon"></i>
                            </div>
                        </div>
                        <ul class="nav nav-pills product-view-nav justify-content-end mt-3 mt-sm-0">
                            <li class="nav-item">
                                <button class="nav-link active" onclick="showKeranjang()" data-bs-toggle="tooltip"
                                    data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true"
                                    title="Tampilkan Keranjang"><i class="bx bx-cart align-middle"></i></button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link bg-warning text-white" onclick="refresh()" data-bs-toggle="tooltip"
                                    data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true"
                                    title="Refresh Data Pembelanjaan"><i class="bx bx-sync align-middle"></i></button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row" id="daftar-barang">
                {{-- <div class="col-xl-3 col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="product-img position-relative">
                                <a class="image-popup-no-margins" href="{{ asset('images/no-img.png') }}"
                                    data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom"
                                    data-bs-html="true" title="Lihat Gambar">
                                    <img class="img-fluid mx-auto d-block " alt=""
                                        src="{{ asset('images/no-img.png') }}" width="150">
                                </a>
                            </div>
                            <div class="mt-4 text-center">
                                <h5 class="mb-3 text-truncate"><a href="javascript: void(0);" class="text-dark">Half sleeve
                                        T-shirt </a></h5>
                                <h5 class="my-0 mb-3"><span class="text-muted me-2"><del>$500</del></span> <b>$450</b></h5>
                                <a href="ecommerce-checkout.html" class="btn btn-outline-light btn-sm text-dark">
                                    <i class="mdi mdi-cart-arrow-right me-1"></i> Tambah keranjang </a>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>
            <!-- end row -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center mt-2 mb-5">
                        <a href="javascript:void(0);" class="text-dark" id="ajax-pending" style="display: none"><i
                                class="bx bx-caret-down font-size-18 align-middle me-2"></i> Gulir ke bawah untuk
                            melanjutkan <i class="bx bx-caret-down font-size-18 align-middle me-2"></i> </a>
                        <a href="javascript:void(0);" class="text-dark" id="ajax-loading"><i
                                class="bx bx-loader bx-spin font-size-18 align-middle me-2"></i> Memuat Data...</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--TAMBAH KERANJANG -->
    <div class="modal fade" tabindex="-1" id="addKeranjang" role="dialog" data-bs-backdrop="static"
        aria-labelledby="orderdetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="orderdetailsModalLabel">Tambah ke keranjang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="text" id="get_id_barang" class="form-control" hidden>
                        <div class="col-md-6" id="showBarangKeranjang"></div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label>Jumlah Permintaan <a class="text-danger">*</a></label>
                                <input type="text" id="jml_k" value="0" class="input-quantity form-control"
                                    width="100%">
                            </div>
                            <div class="form-group">
                                <label>Keterangan</label>
                                <textarea class="form-control" id="ket_k" rows="3" width="100%" placeholder="Optional"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i
                            class="fa fa-times"></i>&nbsp;&nbsp;Batal</button>
                    <button class="btn btn-info" onclick="masukKeranjang()" data-bs-toggle="tooltip"
                        data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true"
                        title="Barang akan dimasukkan ke keranjang"><i
                            class="bx bxs-plus-square"></i>&nbsp;&nbsp;Tambah</button>
                    <button class="btn btn-primary" onclick="showKeranjang()" data-bs-toggle="tooltip"
                        data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true" title="Lihat Keranjang"><i
                            class="bx bx-cart align-middle"></i>&nbsp;&nbsp;Keranjang</button>
                </div>
            </div>
        </div>
    </div>

    <!-- TAMPIL KERANJANG -->
    <div class="modal fade" tabindex="-1" id="keranjang" role="dialog" aria-labelledby="orderdetailsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="orderdetailsModalLabel">Keranjang Belanja</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="orderlist-overview">
                        <p class="mb-2">Nama : <span class="list-id text-primary" id="nama_k"></span></p>
                        <p class="mb-4">Diperbarui : <span class="orderlist-customer text-primary"
                                id="tgl_k"></span>
                        </p>

                        <div class="table-responsive" style="border: 0px">
                            <table id="table-keranjang" class="table align-middle table-hover table-nowrap">
                                <thead>
                                    <tr>
                                        <th scope="col">Gambar</th>
                                        <th scope="col">Barang</th>
                                        <th scope="col">Harga</th>
                                        <th scope="col">Jumlah</th>
                                        <th scope="col">Total</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody id="tampil-keranjang">
                                    <tr>
                                        <td colspan="9">
                                            <center><i class="fa fa-spinner fa-spin fa-fw"></i> Memuat data...</center>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="shadow-lg p-3 bg-body rounded" role="alert">
                            <h5 class="alert-heading fw-bold mb-2"><i
                                    class="bx bxs-right-arrow-circle font-size-15 bx-fade-right text-primary"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Perhatian!
                            </h5>
                            <span>
                                <ul>
                                    <li>Selesaikan pengadaan Anda sebelum (Batas Maksimal) tanggal 25 setiap bulannya</li>
                                </ul>
                            </span>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" onclick="checkoutKeranjang()" id="btn-ajukan"
                        data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true"
                        title="Ajukan Barang Pengadaan"><i class="bx bx-check-double"></i>&nbsp;&nbsp;Ajukan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i
                            class="fa fa-times"></i>&nbsp;&nbsp;Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- TAMPIL RIWAYAT PER PENGADAAN -->
    <div class="modal fade" tabindex="-1" id="riwayat" role="dialog" aria-labelledby="orderdetailsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="orderdetailsModalLabel">Riwayat Pengadaan <span class="badge bg-primary"
                            id="show_id"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="orderlist-overview">
                        <p class="mb-2">Nama : <span class="list-id text-primary" id="nama_r"></span></p>
                        <p class="mb-2">Unit : <span class="list-id text-primary" id="unit_r"></span></p>
                        <p class="mb-4">Tanggal : <span class="orderlist-customer text-primary" id="tgl_r"></span>
                        </p>

                        <div class="table-responsive" style="border: 0px">
                            <table class="table align-middle table-hover table-nowrap">
                                <thead>
                                    <tr>
                                        <th scope="col">Gambar</th>
                                        <th scope="col">Barang</th>
                                        <th scope="col">Harga</th>
                                        <th scope="col" class="text-wrap">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody id="tampil-riwayat">
                                    <tr>
                                        <td colspan="9">
                                            <center><i class="fa fa-spinner fa-spin fa-fw"></i> Memuat data...</center>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i
                            class="fa fa-times"></i>&nbsp;&nbsp;Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- TAMPIL FILTER REKAP PENGADAAN -->
    <div class="modal fade" tabindex="-1" id="rekap" role="dialog" aria-labelledby="orderdetailsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="orderdetailsModalLabel">Rekapitulasi Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('pengadaanrekap.index') }}" name="formRekap" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col">
                                <div class="form-group" style="width: 100%">
                                    <select onchange="rekapBtn()" class="form-control" name="bulan" id="bulan_all">
                                        <option hidden>Pilih Bulan</option>
                                        <option value="01"> Januari</option>
                                        <option value="02"> Februari</option>
                                        <option value="03"> Maret</option>
                                        <option value="04"> April</option>
                                        <option value="05"> Mei</option>
                                        <option value="06"> Juni</option>
                                        <option value="07"> Juli</option>
                                        <option value="08"> Agustus</option>
                                        <option value="09"> September</option>
                                        <option value="10"> Oktober</option>
                                        <option value="11"> November</option>
                                        <option value="12"> Desember</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group" style="width: 100%">
                                    <select onchange="rekapBtn()" class="form-control" name="tahun" id="tahun_all">
                                        <option hidden>Pilih Tahun</option>
                                        @php
                                            for ($i = 2022; $i <= \Carbon\Carbon::now()->isoFormat('Y'); $i++) {
                                                echo "<option value=$i> $i </option>";
                                            }
                                        @endphp
                                    </select>
                                </div>
                            </div>
                        </div>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary text-white" id="submit_filterAll" onclick="saveData()" disabled><i
                            class="fa-fw fas fa-filter nav-icon text-white"></i> Submit</button>
                    </form>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i
                            class="fa fa-times"></i>&nbsp;&nbsp;Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // When the user scrolls down 20px from the top of the document, show the button
            window.onscroll = function() {
                scrollFunction()
            };

            $.ajax({
                url: "/api/pengadaan/data/{{ Auth::user()->id }}",
                type: 'GET',
                dataType: 'json', // added data type
                success: function(res) {
                    var date = new Date().toISOString().split('T')[0]; // 2022-05-23
                    var userID = "{{ Auth::user()->id }}";
                    var adminID = "{{ Auth::user()->hasRole('sekretaris-direktur|it') }}";
                    var suID = "{{ Auth::user()->hasRole('it') }}";
                    var tgl = date.substring(8, 10);
                    var bln = date.substring(5, 7);
                    var thn = date.substring(0, 4);
                    // Tampil Result setelah Selesai Laporan
                    $("#tampil-tbody").empty();
                    res.pengadaan.forEach(item => {
                        // var updet = item.updated_at.substring(0, 10);
                        var tglUpload = item.updated_at.substring(8, 10);
                        var blnUpload = item.updated_at.substring(5, 7);
                        var thnUpload = item.updated_at.substring(0, 4);
                        content = `<tr id="pengadaan` + item.id_pengadaan + `">
                                    <td style="width: 50px;">
                                        <span class="badge bg-primary">ID : ` + item.id_pengadaan + `</span>
                                    </td>
                                    <td>
                                        <h5 class="text-truncate font-size-14 mb-1"><a href="javascript: void(0);"
                                                class="text-dark">` + formatRupiah(item.total, 'Rp ') + ` ,-</a></h5>
                                        <p class="text-muted mb-0">` + item.tgl_pengadaan + `</p>
                                    </td>
                                    <td style="width: 90px;">
                                        <div>
                                            <ul class="list-inline mb-0 font-size-16">
                                                <li class="list-inline-item">
                                                    <a href="javascript: void(0);" onclick="showRiwayat(` + item
                            .id_pengadaan + `)" class="text-primary p-1" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true" title="Lihat Riwayat Pengadaan"><i
                                                            class="bx bx-shopping-bag"></i></a>
                                                </li>
                                                <li class="list-inline-item">`;
                        if (adminID) {
                            content += `<a href="javascript: void(0);" onclick="hapusRiwayat(` +
                                item.id_pengadaan +
                                `)" class="text-danger p-1" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="Hapus Pengadaan"><i class="bx bxs-trash"></i></a>`;
                        } else {
                            if (thnUpload == thn) { // TAHUN SAMA
                                if (blnUpload == bln) { // BULAN SAMA
                                    if (tgl >= 1 && tgl <=
                                        25) { // TANGGAL TIDAK BOLEH LEBIH DARI TGL 25 (Tgl 1-25)
                                        content +=
                                            `<a href="javascript: void(0);" onclick="hapusRiwayat(` +
                                            item.id_pengadaan +
                                            `)" class="text-danger p-1" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="Hapus Pengadaan"><i class="bx bxs-trash"></i></a>`;
                                    } else {
                                        content +=
                                            `<a href="javascript: void(0);" class="text-secondary p-1" disabled data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="Riwayat Pengadaan terkunci"><i class="bx bxs-trash"></i></a>`;
                                    }
                                } else {
                                    content +=
                                        `<a href="javascript: void(0);" class="text-secondary p-1" disabled data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="Riwayat Pengadaan terkunci"><i class="bx bxs-trash"></i></a>`;
                                }
                            } else {
                                content +=
                                    `<a href="javascript: void(0);" class="text-secondary p-1" disabled data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="Riwayat Pengadaan terkunci"><i class="bx bxs-trash"></i></a>`;
                            }
                        }
                        content += `</li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>`;
                        $('#tampil-tbody').append(content);

                        // Showing Tooltip
                        $('[data-bs-toggle="tooltip"]').tooltip({
                            trigger: 'hover'
                        })
                    })
                }
            });

            // AUTOCOMPLETE CARI BARANG
            // var path = "{{ route('pengadaan.getacbarang') }}";
            // $('.typeahead').typeahead({
            //     source: function(query, process) {
            //         return $.get(path, {
            //             barang: query
            //         }, function(data) {
            //             return process(data);
            //         });
            //     }
            // });

            // var site_url = "{{ url('/') }}";
            var page = 1;
            var pagecari = 1;

            $('#ajax-loading').show();
            load_more(page);

            // AUTO SHOW CARI BARANG
            $("#caribarang").keyup(function() {
                var val_barang = $("#caribarang").val();
                if (val_barang.length === 0) {
                    page = 1;
                    load_more(page);
                }
            });
            $("#caribarang").on('keypress', function(e) {
                if (e.which == 13) {
                    var val_barang = $("#caribarang").val();
                    $('#ajax-pending').hide();
                    $('#ajax-loading').show();
                    pagecari = 1;
                    load_more_cari(val_barang, pagecari);
                }
            });

            $(window).scroll(function() {
                if ($(window).scrollTop() + $(window).height() >= $(document).height()) {
                    $('#ajax-pending').hide();
                    $('#ajax-loading').show();
                    var val_barang = $("#caribarang").val();
                    if (val_barang.length === 0) {
                        page++;
                        load_more(page);
                    } else {
                        pagecari++;
                        load_more_cari(val_barang, pagecari);
                    }
                }
            });

            $(".input-quantity").TouchSpin({
                verticalbuttons: true
            });
        })

        // FUNCTION AREA
        function refresh() {
            $('.modal').modal('hide');
            load_more(1);
            $("#caribarang").val('');
            // iziToast.success({
            //     title: 'Pesan Sukses!',
            //     message: 'Daftar Barang Pembelanjaan berhasil disegarkan',
            //     position: 'topRight'
            // });
        }

        function refreshRiwayat() {
            $("#tampil-tbody").empty().append(
                `<tr><td colspan="9"><center><i class="fa fa-spinner fa-spin fa-fw"></i> Memproses data...</center></td></tr>`
            );
            $.ajax({
                url: "/api/pengadaan/data/{{ Auth::user()->id }}",
                type: 'GET',
                dataType: 'json', // added data type
                success: function(res) {
                    var date = new Date().toISOString().split('T')[0]; // 2022-05-23
                    var userID = "{{ Auth::user()->id }}";
                    var adminID = "{{ Auth::user()->hasRole('sekretaris-direktur|it') }}";
                    var suID = "{{ Auth::user()->hasRole('it') }}";
                    var tgl = date.substring(8, 10);
                    var bln = date.substring(5, 7);
                    var thn = date.substring(0, 4);
                    // Tampil Result setelah Selesai Laporan
                    $("#tampil-tbody").empty();
                    res.pengadaan.forEach(item => {
                        // var updet = item.updated_at.substring(0, 10);
                        var tglUpload = item.updated_at.substring(8, 10);
                        var blnUpload = item.updated_at.substring(5, 7);
                        var thnUpload = item.updated_at.substring(0, 4);
                        content = `<tr id="pengadaan` + item.id_pengadaan + `">
                                    <td style="width: 50px;">
                                        <span class="badge bg-primary">ID : ` + item.id_pengadaan + `</span>
                                    </td>
                                    <td>
                                        <h5 class="text-truncate font-size-14 mb-1"><a href="javascript: void(0);"
                                                class="text-dark">` + formatRupiah(item.total, 'Rp ') + ` ,-</a></h5>
                                        <p class="text-muted mb-0">` + item.tgl_pengadaan + `</p>
                                    </td>
                                    <td style="width: 90px;">
                                        <div>
                                            <ul class="list-inline mb-0 font-size-16">
                                                <li class="list-inline-item">
                                                    <a href="javascript: void(0);" onclick="showRiwayat(` + item
                            .id_pengadaan + `)" class="text-primary p-1" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true" title="Lihat Riwayat Pengadaan"><i
                                                            class="bx bx-shopping-bag"></i></a>
                                                </li>
                                                <li class="list-inline-item">`;
                        if (adminID) {
                            content += `<a href="javascript: void(0);" onclick="hapusRiwayat(` + item
                                .id_pengadaan +
                                `)" class="text-danger p-1" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="Hapus Pengadaan"><i class="bx bxs-trash"></i></a>`;
                        } else {
                            if (thnUpload == thn) { // TAHUN SAMA
                                if (blnUpload == bln) { // BULAN SAMA
                                    if (tgl >= 1 && tgl <=
                                        25) { // TANGGAL TIDAK BOLEH LEBIH DARI TGL 25 (Tgl 1-25)
                                        content +=
                                            `<a href="javascript: void(0);" onclick="hapusRiwayat(` +
                                            item.id_pengadaan +
                                            `)" class="text-danger p-1" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="Hapus Pengadaan"><i class="bx bxs-trash"></i></a>`;
                                    } else {
                                        content +=
                                            `<a href="javascript: void(0);" class="text-secondary p-1" disabled data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="Riwayat Pengadaan terkunci"><i class="bx bxs-trash"></i></a>`;
                                    }
                                } else {
                                    content +=
                                        `<a href="javascript: void(0);" class="text-secondary p-1" disabled data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="Riwayat Pengadaan terkunci"><i class="bx bxs-trash"></i></a>`;
                                }
                            } else {
                                content +=
                                    `<a href="javascript: void(0);" class="text-secondary p-1" disabled data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="Riwayat Pengadaan terkunci"><i class="bx bxs-trash"></i></a>`;
                            }
                        }
                        content += `</li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>`;
                        $('#tampil-tbody').append(content);

                        // Showing Tooltip
                        $('[data-bs-toggle="tooltip"]').tooltip({
                            trigger: 'hover'
                        })
                    })
                }
            });
        }

        // Menampilkan Modal Lihat Keranjang Saat Ini
        function showKeranjang() {
            // $('.modal').modal('hide');
            $.ajax({
                url: "/api/pengadaan/keranjang/{{ Auth::user()->id }}",
                type: 'GET',
                dataType: 'json', // added data type
                success: function(res) {
                    $("#tampil-keranjang").empty();
                    // console.log(res.keranjang);
                    if (res.keranjang != '') {
                        var tot = 0;
                        var urutan = 1;
                        res.keranjang.forEach(item => {
                            if (item.ket) {
                                ket = item.ket;
                            } else {
                                ket = '';
                            }
                            content = `<tr>
                                            <th scope="row">
                                                <div>
                                                    <img src="{{ asset('images/no-img.png') }}" alt=""
                                                        class="avatar-sm">
                                                </div>
                                            </th>
                                            <td style="word-wrap: break-word" class="text-wrap">
                                                <div>
                                                    <h5 class="text-truncate font-size-14">` + item.nama_barang +
                                `</h5>
                                                    <small><p class="mb-0">Keterangan : <span class="fw-medium text-primary">` + ket + `</span></p></small>
                                                </div>
                                            </td>
                                            <td>` + formatRupiah(item.harga_barang, 'Rp ') + `</td>
                                            <td>
                                                <div class="me-3" style="width: 120px;">
                                                    <input type="text" value="` + item.jml_permintaan +
                                `" id="jml_set` + item.id +
                                `" class="input-quantity form-control idJumlah` + urutan + `" name="demo_vertical">
                                                </div>
                                            </td>
                                            <td id="ttl` + item.id + `">` + formatRupiah(item.total_barang, 'Rp ') +
                                `</td>
                                            <td>
                                                <div class="d-inline-block" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus ` + item.nama_barang + `">
                                                    <a href="javascript: void(0);" onclick="hapusBarangKeranjang(` +
                                item.id + `)" class="action-icon text-danger"> <i class="mdi mdi-trash-can font-size-18"></i></a>
                                                </div>
                                            </td>
                                            <td hidden>
                                                <input type="number" id="totalKeranjang" value="` + item.total_barang + `" class="form-control">
                                                <input type="number" id="urutan" value="` + res.keranjang.length + `" class="form-control">
                                                <input type="number" id="idBarang` + urutan + `" value="` + item
                                .id_barang + `" class="form-control">
                                                <input type="number" id="ket` + urutan + `" value="` + ket + `" class="form-control">

                                                <input type="number" id="hrg` + item.id + `" value="` + item
                                .harga_barang + `" class="form-control">
                                                <input type="number" id="tot` + item.id + `" value="` + item
                                .total_barang + `" class="form-control total` + urutan + `">
                                            </td>
                                        </tr>`;
                            $('#tampil-keranjang').append(content);
                            $("#nama_k").text(res.keranjang[0].nama_user);
                            $("#tgl_k").text(res.keranjang[0].updated_at.substring(0, 19).replace('T',
                                ' '));

                            // Showing Tooltip
                            $('[data-bs-toggle="tooltip"]').tooltip({
                                trigger: 'hover'
                            })

                            $("#jml_set" + item.id).on("keyup change", function(e) {
                                var get_id = e.currentTarget.id.substring(7, 10);
                                var tot_hrg = $("#tot" + get_id).val();
                                var get_hrg = $("#hrg" + get_id).val();
                                var total_seluruh = parseInt($("#ttl_getSeluruh").val());
                                var total_smt = parseInt($("#jml_set" + item.id).val()) *
                                    get_hrg;
                                $("#ttl" + get_id).text(formatRupiah(total_smt, 'Rp '));
                                $("#tot" + get_id).val(total_smt);
                                // console.log(res.keranjang.length);
                                // console.log(total_smt);
                                var jumlah = 0;
                                for (let index = 1; index <= res.keranjang.length; index++) {
                                    jumlah += parseInt($(".total" + index).val());
                                    // console.log($(".total"+index).val());
                                }
                                $("#ttl_seluruh").text(formatRupiah(jumlah, 'Rp '));
                                $("#totalKeranjang").val(jumlah);
                            })

                            tot += item.total_barang;
                            urutan++;
                            $("#jml_set" + item.id).TouchSpin({
                                verticalbuttons: true
                            });
                            $("#jml_set" + item.id).trigger("touchspin.updatesettings", {
                                max: 1000,
                                min: 1
                            });
                        })
                        content2 = `<tr>
                                        <th colspan="4">Total Keseluruhan</th>
                                        <td colspan="2" id="ttl_seluruh">` + formatRupiah(tot, 'Rp ') + `</td>
                                        <td hidden>
                                            <input type="number" id="ttl_getSeluruh" value="` + tot + `" class="form-control" hidden>
                                            <input type="number" id="totalKeranjangAll" value="` + tot + `" class="form-control" hidden>
                                        </td>
                                    </tr>`;
                        $('#tampil-keranjang').append(content2);
                        $('#keranjang').modal('show');
                    } else {
                        iziToast.warning({
                            title: 'Pesan Ambigu!',
                            message: 'Anda belum menambahkan barang ke keranjang',
                            position: 'topRight'
                        });
                    }
                }
            });
        }

        // Menampilkan Modal Tambah Barang Ke Keranjang
        function addKeranjang(id) {
            $("#get_id_barang").val(id);
            $("#jml_k").val(1).trigger("touchspin.updatesettings", {
                max: 1000,
                min: 1
            });
            $("#ket_k").text('');
            $.ajax({
                url: "/api/pengadaan/keranjang/" + id + "/tampil",
                type: 'GET',
                dataType: 'json', // added data type
                success: function(res) {
                    $("#showBarangKeranjang").empty();
                    content = `<div class="product-img position-relative">
                                    <img class="img-fluid mx-auto d-block " alt=""
                                        src="{{ asset('images/no-img.png') }}" width="80">
                                </div>
                                <div class="mt-4 text-center">
                                    <h6 class="mb-3"><a href="javascript: void(0);" class="text-dark">` +
                        res.nama + `</a></h6>
                                    <h5 class="my-0 mb-3"><b class="text-success">` + formatRupiah(res.harga, 'Rp ') +
                        `</b> <span class="text-muted me-2">/ ` + res.satuan + `</span></h5>
                                </div>`;
                    $('#showBarangKeranjang').append(content);
                }
            });
            // Showing Tooltip
            $('[data-bs-toggle="tooltip"]').tooltip({
                trigger: 'hover'
            })
            $('#addKeranjang').modal('show');
        }

        // Memasukkan Barang Ke Keranjang
        function masukKeranjang() {
            var id_barang = $("#get_id_barang").val();
            var jml = $("#jml_k").val();
            var ket = $("#ket_k").val();
            var id_user = '{{ Auth::user()->id }}';

            if (jml == "") {
                iziToast.warning({
                    title: 'Pesan Ambigu!',
                    message: 'Pastikan Anda tidak mengosongi jumlah permintaan',
                    position: 'topRight'
                });
            } else {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: 'POST',
                    url: '/api/pengadaan/keranjang/tambah',
                    dataType: 'json',
                    data: {
                        id_barang: id_barang,
                        jml: jml,
                        ket: ket,
                        id_user: id_user,
                    },
                    success: function(res) {
                        iziToast.success({
                            title: 'Pesan Sukses!',
                            message: 'Tambah barang ke keranjang berhasil pada ' + res,
                            position: 'topRight'
                        });
                        refresh();
                    },
                    error: function(res) {
                        iziToast.error({
                            title: 'Pesan Galat!',
                            message: res.responseJSON.error,
                            position: 'topRight'
                        });
                    }
                });
            }
        }

        // Checkout Keranjang / Ajukan Barang Pengadaan
        function checkoutKeranjang() {
            $('#btn-ajukan').prop('disabled', true);
            $('#btn-ajukan').find('i').removeClass('bx-check-double').addClass('bx-loader bx-spin');
            var urutan = $("#urutan").val();
            var total = $("#totalKeranjangAll").val();
            var id_barang = [];
            var id_jumlah = [];
            var id_ket = [];
            for (let i = 0; i < urutan; i++) {
                id_barang[i] = $("#idBarang" + (i + 1)).val();
                id_jumlah[i] = $(".idJumlah" + (i + 1)).val();
                id_ket[i] = $("#ket" + (i + 1)).val();
            }
            var id_user = '{{ Auth::user()->id }}';

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: 'POST',
                url: '/api/pengadaan/keranjang/checkout',
                dataType: 'json',
                data: {
                    urutan: urutan,
                    id_barang: id_barang,
                    id_jumlah: id_jumlah,
                    id_ket: id_ket,
                    total: total,
                    id_user: id_user,
                },
                success: function(res) {
                    iziToast.success({
                        title: 'Pesan Sukses!',
                        message: 'Pengajuan Pengadaan telah berhasil pada ' + res,
                        position: 'topRight'
                    });
                    refresh();
                    refreshRiwayat();
                },
                error: function(res) {
                    iziToast.error({
                        title: 'Pesan Galat!',
                        message: res.responseJSON.error,
                        position: 'topRight'
                    });
                }
            });
            $('#btn-ajukan').find('i').removeClass('bx-loader bx-spin').addClass('bx-check-double');
            $('#btn-ajukan').prop('disabled', false);
        }

        // Checkout/Ajukan Barang di Keranjang
        // function masukKeranjang() {
        //     var id_barang = $("#get_id_barang").val();
        //     var jml = $("#jml_k").val();
        //     var ket = $("#ket_k").val();
        //     var id_user = '{{ Auth::user()->id }}';

        //     if (jml == "") {
        //         iziToast.warning({
        //             title: 'Pesan Ambigu!',
        //             message: 'Pastikan Anda tidak mengosongi jumlah permintaan',
        //             position: 'topRight'
        //         });
        //     } else {
        //         $.ajax({
        //             headers: {
        //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //             },
        //             method: 'POST',
        //             url: '/api/pengadaan/keranjang/tambah',
        //             dataType: 'json',
        //             data: {
        //                 id_barang: id_barang,
        //                 jml: jml,
        //                 ket: ket,
        //                 id_user: id_user,
        //             },
        //             success: function(res) {
        //                 iziToast.success({
        //                     title: 'Sukses!',
        //                     message: 'Tambah barang ke keranjang berhasil pada '+ res,
        //                     position: 'topRight'
        //                 });
        //                 refresh();
        //             },
        //             error: function (res) {
        //                 iziToast.error({
        //                     title: 'Pesan Galat!',
        //                     message: res.responseJSON.error,
        //                     position: 'topRight'
        //                 });
        //             }
        //         });
        //     }
        // }

        // Hapus Barang di Keranjang
        function hapusBarangKeranjang(id) {
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: 'Hapus Barang ID : ' + id + ' dari keranjang',
                icon: 'warning',
                reverseButtons: false,
                showDenyButton: false,
                showCloseButton: false,
                showCancelButton: true,
                focusCancel: true,
                confirmButtonColor: '#FF4845',
                confirmButtonText: `<i class="fa fa-trash me-1" style="font-size:13px"></i> Hapus`,
                cancelButtonText: `<i class="fa fa-times me-1" style="font-size:13px"></i>  Batal`,
                backdrop: `rgba(26,27,41,0.8)`,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "/api/pengadaan/keranjang/" + id + "/hapus",
                        type: 'DELETE',
                        dataType: 'json', // added data type
                        success: function(res) {
                            $('#keranjang').modal('hide');
                            iziToast.success({
                                title: 'Pesan Sukses!',
                                message: 'Hapus Barang dari keranjang berhasil pada ' + res,
                                position: 'topRight'
                            });
                            // setTimeout(function() {$('.modal').modal('hide')},1000);
                            // showKeranjang();
                        },
                        error: function(res) {
                            iziToast.error({
                                title: 'Pesan Galat!',
                                message: res.responseJSON.error,
                                position: 'topRight'
                            });
                        }
                    });
                }
            })
        }

        function showRiwayat(id) {
            $.ajax({
                url: "/api/pengadaan/riwayat/" + id,
                type: 'GET',
                dataType: 'json', // added data type
                success: function(res) {
                    // Tampil Result setelah Selesai Laporan
                    $("#tampil-riwayat").empty();
                    // $("#total_r").empty();
                    res.detail.forEach(item => {
                        if (item.ket) {
                            ket = item.ket;
                        } else {
                            ket = '';
                        }
                        content = `<tr>
                                        <th scope="row">
                                            <div>
                                                <img src="{{ asset('images/no-img.png') }}" alt=""
                                                    class="avatar-sm">
                                            </div>
                                        </th>
                                        <td>
                                            <div>
                                                <h5 class="text-truncate font-size-14">` + item.nama_barang + `</h5>
                                                <p class="text-muted mb-0">` + formatRupiah(item.harga, 'Rp ') +
                            ` x ` + item.jumlah + `</p>
                                            </div>
                                        </td>
                                        <td>` + formatRupiah(item.total, 'Rp ') + `</td>
                                        <td style="word-wrap: break-word" class="text-wrap">` + ket + `</td>
                                    </tr>`;
                        $('#tampil-riwayat').append(content);
                    })
                    content_total = `<tr>
                                        <td colspan="2">
                                            <h6 class="m-0 text-right">Total Keseluruhan</h6>
                                        </td>
                                        <td colspan="2"><b>` + formatRupiah(res.pengadaan.total, 'Rp ') + `</b></td>
                                    </tr>`;
                    $('#tampil-riwayat').append(content_total);
                    $("#show_id").text("#" + res.pengadaan.id_pengadaan);
                    $("#nama_r").text(res.pengadaan.nama_user);
                    $("#unit_r").text(res.pengadaan.unit.replace('["', '').replace('"]', '').replace('","',
                        ','));
                    $("#tgl_r").text(res.pengadaan.tgl_pengadaan);
                }
            });
            $('#riwayat').modal('show');
        }

        // Hapus Riwayat
        function hapusRiwayat(id) {
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: 'Hapus Riwayat ID : ' + id,
                icon: 'warning',
                reverseButtons: false,
                showDenyButton: false,
                showCloseButton: false,
                showCancelButton: true,
                focusCancel: true,
                confirmButtonColor: '#FF4845',
                confirmButtonText: `<i class="fa fa-trash me-1" style="font-size:13px"></i> Hapus`,
                cancelButtonText: `<i class="fa fa-times me-1" style="font-size:13px"></i>  Batal`,
                backdrop: `rgba(26,27,41,0.8)`,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "/api/pengadaan/riwayat/" + id + "/hapus",
                        type: 'DELETE',
                        dataType: 'json', // added data type
                        success: function(res) {
                            iziToast.success({
                                title: 'Pesan Sukses!',
                                message: 'Hapus Riwayat berhasil pada ' + res,
                                position: 'topRight'
                            });
                            refreshRiwayat();
                        },
                        error: function(res) {
                            iziToast.error({
                                title: 'Pesan Galat!',
                                message: res.responseJSON.error,
                                position: 'topRight'
                            });
                        }
                    });
                }
            })
        }

        function scrollFunction() {
            // Get the button
            if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                $('#myBtn').show();
            } else {
                $('#myBtn').hide();
            }
        }

        // When the user clicks on the button, scroll to the top of the document
        function topFunction() {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        }

        /* Fungsi formatRupiah */
        function formatRupiah(angka, prefix) {
            var number_string = angka.toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            // tambahkan titik jika yang di input sudah menjadi angka ribuan
            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
        }

        function load_more(page) {
            if (page === 1) {
                $("#daftar-barang").empty();
            }
            $.ajax({
                url: "/api/pengadaan/barang?page=" + page,
                type: "get",
                datatype: "html",
                beforeSend: function() {
                    $('#ajax-pending').hide();
                    $('#ajax-loading').show();
                }
            }).done(function(res) {
                if (res.data.length === 0) {
                    $('#ajax-pending').hide();
                    $('#ajax-loading').empty();
                    $('#ajax-loading').append("<center>Seluruh Barang ditampilkan</center>");
                    return;
                } else {
                    res.data.forEach(item => {
                        content =
                            `<div class="col-xl-3 col-sm-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="product-img position-relative">
                                                <img class="img-fluid mx-auto d-block " alt=""
                                                    src="{{ asset('images/no-img.png') }}" width="150">
                                            </div>
                                            <div class="mt-4 text-center">
                                                <h6 class="mb-3"><a href="javascript: void(0);" class="text-dark">` +
                            item.nama + `</a></h6>
                                                <h5 class="my-0 mb-3"><b class="text-success">` + formatRupiah(item
                                .harga, 'Rp ') + `</b> <span class="text-muted me-2">/ ` + item.satuan + `</span></h5>
                                                <a href="javascript:void(0);" onclick="addKeranjang(` + item.id + `)" class="btn btn-outline-light btn-sm text-dark">
                                                    <i class="mdi mdi-cart-arrow-right me-1"></i> Masukkan keranjang </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>`;
                        $("#daftar-barang").append(content);
                    })
                    $('#ajax-pending').show();
                }
                $('#ajax-loading').hide();
            }).fail(function(jqXHR, ajaxOptions, thrownError) {
                alert('No response from server');
            });
        }

        function load_more_cari(barang, page) {
            if (page === 1) {
                $("#daftar-barang").empty();
            }
            setTimeout(function() {
                var val_barang = $("#caribarang").val();
                $.ajax({
                        url: "/api/pengadaan/caribarang?barang=" + val_barang + "&page=" + page,
                        type: "get",
                        datatype: "html",
                        beforeSend: function() {
                            $('#ajax-pending').hide();
                            $('#ajax-loading').show();
                        }
                    })
                    .done(function(res) {
                        if (res.data.length == 0) {
                            $('#ajax-pending').hide();
                            $('#ajax-loading').empty();
                            $('#ajax-loading').append("<center>Seluruh Barang ditampilkan</center>");
                            return;
                        } else {
                            res.data.forEach(item => {
                                content =
                                    `<div class="col-xl-3 col-sm-6">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="product-img position-relative">
                                                        <img class="img-fluid mx-auto d-block " alt=""
                                                            src="{{ asset('images/no-img.png') }}" width="150">
                                                    </div>
                                                    <div class="mt-4 text-center">
                                                        <h6 class="mb-3"><a href="javascript: void(0);" class="text-dark">` +
                                    item.nama + `</a></h6>
                                                        <h5 class="my-0 mb-3"><b class="text-success">` + formatRupiah(
                                        item.harga, 'Rp ') + `</b> <span class="text-muted me-2">/ ` +
                                    item.satuan + `</span></h5>
                                                        <a href="javascript:void(0);" onclick="addKeranjang(` + item
                                    .id + `)" class="btn btn-outline-light btn-sm text-dark">
                                                            <i class="mdi mdi-cart-arrow-right me-1"></i> Masukkan keranjang </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>`;
                                $("#daftar-barang").append(content);
                            })
                            $('#ajax-pending').show();
                        }
                        $('#ajax-loading').hide();
                    })
                    .fail(function(jqXHR, ajaxOptions, thrownError) {
                        alert('No response from server');
                    });
            }, 1000);
        }

        // FUNCTION REKAP
        function rekapBtn() {
            // var unit = $("#unit_cari").val();
            var bulan = $("#bulan_all").val();
            var tahun = $("#tahun_all").val();

            if (bulan != 'Pilih Bulan' && tahun != 'Pilih Tahun') {
                $('#submit_filterAll').prop('disabled', false).removeClass('btn-secondary').addClass('btn-primary');
            }
        }

        function saveData() {
            $("#rekap").one('submit', function() {
                //stop submitting the form to see the disabled button effect
                let x = document.forms["formRekap"]["bulan"].value;
                let y = document.forms["formRekap"]["tahun"].value;
                if (x == "" || y == "") {
                    iziToast.error({
                        title: 'Pesan Galat!',
                        message: 'Mohon isi tanggal rapat',
                        position: 'topRight'
                    });
                    return false;
                } else {
                    $("#submit_filterAll").attr('disabled','disabled');
                    $("#submit_filterAll").find("i").removeClass("fa-filter").addClass("fa-sync fa-spin");
                    return true;
                }
            });
        }

        // $('#btn-ajukan').prop('disabled', true);
        //     $('#btn-ajukan').find('i').removeClass('bx-check-double').addClass('bx-loader bx-spin');

        // function cari() {
        //     var bulan = $("#bulan").val();
        //     var tahun = $("#tahun").val();
        //     $("#tampil-rekap").empty();
        //     $("#tampil-rekap").append(

        //     );
        //     $.ajax({
        //         url: "/api/pengadaan/rekap/bulan/" + bulan + "/tahun/" + tahun,
        //         type: 'GET',
        //         dataType: 'json', // added data type
        //         success: function(res)
        //         {
        //             // TABLE HEAD
        //             contenthead = '<tr>' +
        //                 '<th rowspan="2">IDB</th>' +
        //                 '<th rowspan="2">BARANG</th>' +
        //                 '<th rowspan="2">HARGA</th>' +
        //                 '<th rowspan="2">SATUAN</th>';
        //             res.unit.forEach(key => {
        //                 contenthead += '<th colspan="2">' + JSON.parse(key.unit) + '</th>';
        //             });
        //             contenthead += "</tr><tr>";
        //             res.unit.forEach(key => {
        //                 contenthead += "<th>JML</th><th>NOM</th>";
        //             });
        //             contenthead += "</tr>";
        //             $('#tampil-thead').append(contenthead);
        //             // TABLE BODY
        //             contentbody = "";
        //             res.barang.forEach(item => {
        //                 contentbody += "<tr><td>" +
        //                     item.id_barang + "</td><td>" +
        //                     item.nama_barang + "</td><td>" +
        //                     item.harga_barang + "</td><td>" +
        //                     item.satuan_barang + "</td>";

        //                 res.unit.forEach(key => {
        //                     res.show.forEach(val => {
        //                         if (val.unit == key.unit) {
        //                             // if (item.id_barang == val.id_barang) {
        //                             // if (key.unit == val.unit) {
        //                             if (item.id_barang == val.id_barang) {
        //                                 contentbody += "<td>" + val.jumlah +
        //                                     "</td><td>" + val.total + "</td>";
        //                             }
        //                             // else {
        //                             //   contentbody += '<td></td>';
        //                             // }
        //                         }
        //                     });
        //                 });
        //                 contentbody += "</tr>";
        //             });
        //             $('#tampil-tbody').append(contentbody);

        //         }
        //     });
        // }
    </script>
@endsection
