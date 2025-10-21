@extends('layouts.index')

@section('content')

    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i></a></li>
                        <li class="breadcrumb-item">Inventaris</li>
                        <li class="breadcrumb-item">Aset</li>
                        <li class="breadcrumb-item" aria-current="page">Ruangan</li>
                    </ul>
                </div>
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h2 class="mb-0">Daftar Ruangan</h2>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- [ breadcrumb ] end -->

    <!-- [ Main Content ] start -->
    <div class="row pt-1">

        <div class="card table-card">

            <div class="card-header">
                <div class="d-flex align-items-center">
                    <h5 class="mb-0 card-title flex-grow-1">
                        <div class="btn-group">
                            <a class="btn btn-outline-secondary" href="{{ route('aset.index') }}" data-bs-toggle="tooltip"
                            data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true"
                            title="Kembali ke Daftar Aset"><i class="fas fa-angle-left me-1"></i> Kembali</a>
                            <button class="btn btn-primary" onclick="tambah()" data-bs-toggle="tooltip"
                            data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true"
                            title="Tambah Ruangan & Lokasi"><i class='ti ti-layout-grid-add me-1'></i> Tambah</button>
                        </div>
                    </h5>
                    <div class="flex-shrink-0">
                        <button class="btn btn-light-warning" onclick="refresh()" data-bs-toggle="tooltip"
                        data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true"
                        title="Refresh Tabel Ruangan"><i class="fas fa-sync me-1"></i> Segarkan</button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="dttable" class="table table-hover dt-responsive align-middle">
                        <thead>
                            <tr>
                                <th class="cell-fit">Aksi</th>
                                <th><span class="badge bg-secondary">Kode</span> Ruangan</th>
                                <th class="cell-fit">Lokasi</th>
                                <th>Unit</th>
                                <th class="cell-fit">Diperbarui</th>
                            </tr>
                        </thead>
                        <tbody id="tampil-tbody">
                            <tr>
                                <td colspan="9" style="font-size:13px">
                                    <center><i class="fa fa-spinner fa-spin fa-fw"></i> Memproses data...</center>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <!-- end table -->
                </div>
                <!-- end table responsive -->
            </div>

        </div>

    </div>

    <!-- MODAL TAMBAH -->
    <div class="modal fade" tabindex="-1" id="modalTambah" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="orderdetailsModalLabel">Tambah Ruangan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <label class="form-label">Kode Inventaris <a class="text-danger">*</a></label>
                                <input type="text" id="kode" class="form-control" placeholder="e.g. 2.2.1.1">
                            </div>
                        </div>
                        <div class="col-md-8 mb-3">
                            <div class="form-group">
                                <label class="form-label">Nama Ruangan <a class="text-danger">*</a></label>
                                <input type="text" id="ruangan" class="form-control" placeholder="e.g. Poliklinik">
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <label class="form-label">Lokasi <a class="text-danger">*</a></label>
                                <input type="text" id="lokasi" class="form-control" placeholder="e.g. Ruang Jaga Perawat">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label class="form-label">Unit Terkait <a class="text-danger">*</a></label>
                                <select class="select2unit form-control" id="unit" style="width: 100%" data-bs-auto-close="outside" required multiple="multiple">
                                    {{-- <option value="">Pilih</option> --}}
                                    @if (count($list['role']) > 0)
                                        @foreach ($list['role'] as $key => $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <small>Unit akan dapat melihat seluruh sarana yang berada di ruangan tersebut</small>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i
                            class="fa fa-times"></i>&nbsp;&nbsp;Batal</button>
                    <button class="btn btn-info" onclick="simpan()" data-bs-toggle="tooltip"
                        data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true"
                        title="Simpan Data Ruangan"><i
                            class="fas fa-save"></i>&nbsp;&nbsp;Submit</button>
                    {{-- <button class="btn btn-primary" onclick="showKeranjang()" data-bs-toggle="tooltip"
                        data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true" title="Lihat Keranjang"><i
                            class="bx bx-cart align-middle"></i>&nbsp;&nbsp;Keranjang</button> --}}
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL UBAH -->
    <div class="modal fade" tabindex="-1" id="modalUbah" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="orderdetailsModalLabel">Ubah Ruangan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="text" id="id_edit" hidden>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <label class="form-label">Kode Inventaris <a class="text-danger">*</a></label>
                                <input type="text" id="kode_edit" class="form-control" placeholder="e.g. 2.2.1.1">
                            </div>
                        </div>
                        <div class="col-md-8 mb-3">
                            <div class="form-group">
                                <label class="form-label">Nama Ruangan <a class="text-danger">*</a></label>
                                <input type="text" id="ruangan_edit" class="form-control" placeholder="e.g. Poliklinik">
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <label class="form-label">Lokasi <a class="text-danger">*</a></label>
                                <input type="text" id="lokasi_edit" class="form-control" placeholder="e.g. Ruang Jaga Perawat">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label class="form-label">Unit Terkait <a class="text-danger">*</a></label>
                                <select class="select2unit form-control" id="unit_edit" style="width: 100%" data-bs-auto-close="outside" required multiple="multiple"></select>
                                <small>Unit akan dapat melihat seluruh sarana yang berada di ruangan tersebut</small>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" id="btn-ubah" onclick="prosesUbah()"><i class="fa-fw fas fa-edit nav-icon"></i> Ubah</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fa-fw fas fa-times nav-icon"></i> Tutup</button>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL HAPUS --}}
    <div class="modal animate__animated animate__rubberBand fade" id="hapus" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-simple modal-add-new-address modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        Form Hapus&nbsp;&nbsp;&nbsp;
                    </h4>
                </div>
                <div class="modal-body">
                    <input type="text" id="id_hapus" hidden>
                    <p style="text-align: justify;">Anda akan menghapus Ruangan tersebut, lakukanlah dengan hati-hati. Ceklis dibawah untuk melanjutkan penghapusan.</p>
                    <label class="switch">
                        <input type="checkbox" class="switch-input" id="setujuhapus">
                        <span class="switch-toggle-slider">
                        <span class="switch-on"></span>
                        <span class="switch-off"></span>
                        </span>
                        <span class="switch-label">Anda siap menerima Risiko</span>
                    </label>
                </div>
                <div class="col-12 text-center mb-4">
                    <button type="submit" id="btn-hapus" class="btn btn-danger me-sm-3 me-1" onclick="prosesHapus()"><i class="fa fa-trash me-1" style="font-size:13px"></i> Hapus</button>
                    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-times me-1" style="font-size:13px"></i> Batal</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {

            $.ajax({
                url: "/api/inventaris/aset/ruangan",
                type: 'GET',
                dataType: 'json', // added data type
                success: function(res) {
                    $("#tampil-tbody").empty();
                    $('#dttable').DataTable().clear().destroy();
                    console.log(res);
                    res.show.forEach(item => {
                        var unit = JSON.parse(item.unit.replace(/"/g,""));
                        content = `<tr><td><div class="d-flex align-items-center">
                                            <div class="dropdown">
                                                <a href="javascript:;" class="btn btn-link-secondary dropdown-toggle hide-arrow text-body p-0 btn-icon" data-bs-toggle="dropdown">` + item.id + `</a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a href="javascript:;" onclick="ubah(` + item.id + `)" class="dropdown-item text-warning"><i class='fas fa-edit me-1'></i> Ubah</a>
                                                    <a href="javascript:;" onclick="hapus(` + item.id + `)" class="dropdown-item text-danger"><i class='fas fa-trash-alt me-1'></i> Hapus</a>
                                                </div>
                                            </div>
                                        </div></td>`;
                        content += `<td><span class="badge bg-secondary">`+item.kode+`</span> <u>`+item.ruangan+`</u>  ${item.id==1?'<span class="badge bg-danger">UTAMA</span>':''}</td>`;
                        content += `<td>`+item.lokasi+`</td><td>`;
                        unit.forEach(val => {
                            res.role.forEach(pus => {
                                if (val == pus.id) {
                                    content += `<span class="badge bg-dark">` + pus.name +
                                        `</span>&nbsp;`;
                                }
                            })
                        })
                        content += `</td><td>`+new Date(item.updated_at).toLocaleString("sv-SE").substring(0, 19)+`</td></tr>`;
                        $('#tampil-tbody').append(content);
                    })
                    var table = $('#dttable').DataTable({
                        order: [
                            [4, "desc"]
                        ],
                        bAutoWidth: false,
                        aoColumns : [
                            { sWidth: '5%' },
                            { sWidth: '20%' },
                            { sWidth: '20%' },
                            { sWidth: '25%' },
                            { sWidth: '10%' },
                        ],
                        displayLength: 7,
                        lengthChange: true,
                        lengthMenu: [7, 10, 25, 50, 75, 100],
                        buttons: ['copy', 'excel', 'pdf', 'colvis']
                    });

                    table.buttons().container()
                        .appendTo('#dttable_wrapper .col-md-6:eq(0)');
                }
            })

            var te = $(".select2unit");
            te.length && te.each(function() {
                var es = $(this);
                es.wrap('<div class="position-relative"></div>').select2({
                    placeholder: "Pilih Unit",
                    dropdownParent: es.parent()
                })
            });

        });

        // FUNCTION AREA ------------------------------------------------------------
        function tambah() {
            $('#modalTambah').modal('show');
        }

        function simpan() {
            var kode = $("#kode").val();
            var ruangan = $("#ruangan").val();
            var lokasi = $("#lokasi").val();
            var unit = $("#unit").val();
            var user = '{{ Auth::user()->id }}';

            if (kode == "" || ruangan == "" || lokasi == "" || unit == "") {
                iziToast.warning({
                    title: 'Pesan Ambigu!',
                    message: 'Pastikan Anda tidak mengosongi semua isian',
                    position: 'topRight'
                });
            } else {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: 'POST',
                    url: '/api/inventaris/aset/ruangan/store',
                    dataType: 'json',
                    data: {
                        kode: kode,
                        ruangan: ruangan,
                        lokasi: lokasi,
                        unit: unit,
                        user: user,
                    },
                    success: function(res) {
                        iziToast.success({
                            title: 'Sukses!',
                            message: 'Tambah Ruangan berhasil pada '+ res,
                            position: 'topRight'
                        });
                        if (res) {
                            $('.modal').modal('hide');
                            refresh();
                        }
                    },
                    error: function (res) {
                        iziToast.error({
                            title: 'Pesan Galat!',
                            message: res.responseJSON.error,
                            position: 'topRight'
                        });
                    }
                });
            }
        }

        function refresh() {
            $('.modal').modal('hide');
            $("#tampil-tbody").empty().append(
                `<tr><td colspan="9"><center><i class="fa fa-spinner fa-spin fa-fw"></i> Memproses data...</center></td></tr>`
            );
            $.ajax({
                url: "/api/inventaris/aset/ruangan",
                type: 'GET',
                dataType: 'json', // added data type
                success: function(res) {
                    $("#tampil-tbody").empty();
                    $('#dttable').DataTable().clear().destroy();
                    res.show.forEach(item => {
                        var unit = JSON.parse(item.unit.replace(/"/g,""));
                        content = `<tr><td><div class="d-flex align-items-center">
                                            <div class="dropdown">
                                                <a href="javascript:;" class="btn btn-link-secondary dropdown-toggle hide-arrow text-body p-0 btn-icon" data-bs-toggle="dropdown">` + item.id + `</a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a href="javascript:;" onclick="ubah(` + item.id + `)" class="dropdown-item text-warning"><i class='fas fa-edit me-1'></i> Ubah</a>
                                                    <a href="javascript:;" onclick="hapus(` + item.id + `)" class="dropdown-item text-danger"><i class='fas fa-trash-alt me-1'></i> Hapus</a>
                                                </div>
                                            </div>
                                        </div></td>`;
                        content += `<td><span class="badge bg-secondary">`+item.kode+`</span> <u>`+item.ruangan+`</u></td>`;
                        content += `<td>`+item.lokasi+`</td><td>`;
                        unit.forEach(val => {
                            res.role.forEach(pus => {
                                if (val == pus.id) {
                                    content += `<span class="badge bg-dark">` + pus.name +
                                        `</span>&nbsp;`;
                                }
                            })
                        })
                        content += `</td><td>`+new Date(item.updated_at).toLocaleString("sv-SE").substring(0, 19)+`</td></tr>`;
                        $('#tampil-tbody').append(content);
                    })
                    var table = $('#dttable').DataTable({
                        order: [
                            [4, "desc"]
                        ],
                        bAutoWidth: false,
                        aoColumns : [
                            { sWidth: '5%' },
                            { sWidth: '20%' },
                            { sWidth: '20%' },
                            { sWidth: '25%' },
                            { sWidth: '10%' },
                        ],
                        displayLength: 7,
                        lengthChange: true,
                        lengthMenu: [7, 10, 25, 50, 75, 100],
                        buttons: ['copy', 'excel', 'pdf', 'colvis']
                    });

                    table.buttons().container()
                        .appendTo('#dttable_wrapper .col-md-6:eq(0)');

                    // Showing Tooltip
                    $('[data-bs-toggle="tooltip"]').tooltip({
                        trigger: 'hover'
                    })
                }
            })
        }

        function ubah(id) {
            $("#id_edit").val("");
            $("#kode_edit").val("");
            $("#ruangan_edit").val("");
            $("#lokasi_edit").val("");
            $("#unit_edit").val("");
            $.ajax(
            {
                url: "/api/inventaris/aset/ruangan/"+id,
                type: 'GET',
                dataType: 'json', // added data type
                success: function(res) {
                    var un = JSON.parse(res.show.unit);
                    // var dt = new Date(res.show.tanggal).toJSON().slice(0,19);
                    var dt = moment(res.show.tgl).format('Y-MM-DD HH:mm');

                    $("#id_edit").val(res.show.id);
                    $("#kode_edit").val(res.show.kode);
                    $("#ruangan_edit").val(res.show.ruangan);
                    $("#lokasi_edit").val(res.show.lokasi);
                    $("#unit_edit").find('option').remove();
                    // var opt = ``;
                    res.role.forEach(poke => {
                        var opt = `<option value="${poke.id}"`;
                        un.forEach(pounch => {
                            if (poke.id == pounch) {
                                opt += `selected`;
                            }
                        });
                        opt += `>${poke.name}</option>`;
                        $("#unit_edit").append(opt);
                    });
                    $('#modalUbah').modal('show');
                }
            });
        }

        function prosesUbah() {
            $("#btn-ubah").prop('disabled', true);
            $("#btn-ubah").find("i").toggleClass("fa-save fa-sync fa-spin");

            var fd = new FormData();
            fd.append('id',$("#id_edit").val());
            fd.append('kode',$("#kode_edit").val());
            fd.append('ruangan',$("#ruangan_edit").val());
            fd.append('lokasi',$("#lokasi_edit").val());
            fd.append('unit',$("#unit_edit").val());
            fd.append('user','{{ Auth::user()->id }}');

            // AJAX request
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('aset_ruangan.ubah') }}",
                method: 'post',
                data: fd,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(res){
                    iziToast.success({
                        title: 'Pesan Sukses! ID : '+fd.get('id'),
                        message: 'Ruangan berhasil diperbarui pada '+res,
                        position: 'topRight'
                    });
                    if (res) {
                        $('#ubah').modal('hide');
                        refresh();
                    }
                },
                error: function(res){
                    console.log("error : " + JSON.stringify(res) );
                }
            });

            $("#btn-ubah").find("i").removeClass("fa-sync fa-spin").addClass("fa-save");
            $("#btn-ubah").prop('disabled', false);
        }

        function hapus(id) {
            $("#id_hapus").val(id);
            var inputs = document.getElementById('setujuhapus');
            inputs.checked = false;
            $('#hapus').modal('show');
        }

        function prosesHapus() {
            // SWITCH BTN HAPUS
            var checkboxHapus = $('#setujuhapus').is(":checked");
            if (checkboxHapus == false) {
                iziToast.error({
                    title: 'Pesan Galat!',
                    message: 'Mohon menyetujui untuk dilakukan penghapusan baris tersebut',
                    position: 'topRight'
                });
            } else {
                // PROSES HAPUS
                var id = $("#id_hapus").val();
                $.ajax({
                    url: "/api/inventaris/aset/ruangan/hapus/"+id,
                    type: 'DELETE',
                    success: function(res) {
                        iziToast.success({
                            title: 'Pesan Sukses!',
                            message: 'Ruangan telah berhasil dihapus pada '+res,
                            position: 'topRight'
                        });
                        $('#hapus').modal('hide');
                        refresh();
                        // window.location.reload();
                    },
                    error: function(res) {
                        iziToast.error({
                            title: 'Pesan Galat!',
                            message: 'Ruangan gagal dihapus',
                            position: 'topRight'
                        });
                    }
                });
            }
        }
    </script>
@endsection
