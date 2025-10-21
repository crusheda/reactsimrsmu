@extends('layouts.index')

@section('content')

    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i></a></li>
                        <li class="breadcrumb-item">Administrasi</li>
                        <li class="breadcrumb-item">E-Ruang</li>
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
                            <a class="btn btn-outline-secondary" href="{{ route('eruang.index') }}" data-bs-toggle="tooltip"
                            data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true"
                            title="Kembali"><i class="fas fa-angle-left me-1"></i> Kembali</a>
                            <button class="btn btn-primary" onclick="tambah()" data-bs-toggle="tooltip"
                            data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true"
                            title="Tambah Ruangan"><i class='ti ti-layout-grid-add me-1'></i> Tambah</button>
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
                <div class="table-responsive text-nowrap" style="border: 0px">
                    <table id="dttable" class="table dt-responsive table-hover nowrap w-100">
                        <thead>
                            <tr>
                                <th class="cell-fit">Aksi</th>
                                <th>Nama Ruangan</th>
                                <th>Deskripsi</th>
                                <th class="cell-fit">Kapasitas</th>
                                <th>Fasilitas</th>
                                <th>Hak Akses</th>
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
                        <div class="col-md-8 mb-3">
                            <div class="form-group">
                                <label class="form-label">Nama Ruangan <a class="text-danger">*</a></label>
                                <input type="text" id="ruangan" class="form-control" placeholder="e.g. Ruang Direksi">
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <label class="form-label">Kapasitas <a class="text-danger">*</a></label>
                                <input type="number" id="kapasitas" class="form-control" placeholder="50xxxx">
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <div class="alert alert-secondary">
                                    <small>
                                        <i class="fas fa-caret-right text-primary me-1"></i> Kosongi isian <mark>Hak Akses</mark> di atas untuk membuka akses Ruangan ke semua karyawan<br>
                                        <i class="fas fa-caret-right text-primary me-1"></i> Isian Hak Akses adalah sebagai acuan untuk karyawan yang diberikan akses khusus terhadap ruangan
                                    </small>
                                </div>
                                <label class="form-label">Hak Akses</label>
                                <select class="select2unit form-control" id="akses" style="width: 100%" data-bs-auto-close="outside" required multiple="multiple">
                                    {{-- <option value="">Pilih</option> --}}
                                    @if (count($list['role']) > 0)
                                        @foreach ($list['role'] as $key => $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label>Deskripsi</label>
                                <textarea rows="2" class="form-control" id="deskripsi" placeholder="Optional"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label>Fasilitas</label>
                                <textarea rows="2" class="form-control" id="fasilitas" placeholder="Optional"></textarea>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i
                            class="fa fa-times me-1"></i> Batal</button>
                    <button class="btn btn-info" onclick="simpan()" data-bs-toggle="tooltip"
                        data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true"
                        title="Simpan Data Ruangan"><i
                            class="fas fa-save me-1"></i> Submit</button>
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
                        <div class="col-md-8 mb-3">
                            <div class="form-group">
                                <label class="form-label">Nama Ruangan <a class="text-danger">*</a></label>
                                <input type="text" id="ruangan_edit" class="form-control" placeholder="e.g. Ruang Direksi">
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <label class="form-label">Kapasitas <a class="text-danger">*</a></label>
                                <input type="number" id="kapasitas_edit" class="form-control" placeholder="50xxxx">
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <div class="alert alert-secondary">
                                    <small>
                                        <i class="fas fa-caret-right text-primary me-1"></i> Kosongi isian <mark>Hak Akses</mark> di atas untuk membuka akses Ruangan ke semua karyawan<br>
                                        <i class="fas fa-caret-right text-primary me-1"></i> Isian Hak Akses adalah sebagai acuan untuk karyawan yang diberikan akses khusus terhadap ruangan
                                    </small>
                                </div>
                                <label class="form-label">Hak Akses</label>
                                <select class="select2unit form-control" id="akses_edit" style="width: 100%" data-bs-auto-close="outside" required multiple="multiple"></select>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label>Deskripsi</label>
                                <textarea rows="2" class="form-control" id="deskripsi_edit" placeholder="Optional"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label>Fasilitas</label>
                                <textarea rows="2" class="form-control" id="fasilitas_edit" placeholder="Optional"></textarea>
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
                url: "/api/eruang/ruangan",
                type: 'GET',
                dataType: 'json', // added data type
                success: function(res) {
                    $("#tampil-tbody").empty();
                    $('#dttable').DataTable().clear().destroy();
                    // console.log(res);
                    res.show.forEach(item => {
                        if (item.akses) {
                            var unit = JSON.parse(item.akses.replace(/"/g,""));
                        } else {
                            var unit = null;
                        }
                        content = `<tr><td><div class="d-flex align-items-center">
                                            <div class="dropdown">
                                                <a href="javascript:;" class="btn btn-link-secondary dropdown-toggle hide-arrow text-body p-0 btn-icon" data-bs-toggle="dropdown">` + item.id + `</a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a href="javascript:;" onclick="ubah(` + item.id + `)" class="dropdown-item text-warning"><i class='fas fa-edit me-1'></i> Ubah</a>
                                                    <a href="javascript:;" onclick="hapus(` + item.id + `)" class="dropdown-item text-danger"><i class='fas fa-trash-alt me-1'></i> Hapus</a>
                                                </div>
                                            </div>
                                        </div></td>`;
                        content += `<td><u><b class='text-primary'>`+item.nama+`</b></u></td>`;
                        content += `<td>${item.deskripsi?item.deskripsi:'-'}</td>`;
                        content += `<td>`+item.kapasitas+`</td>`;
                        content += `<td>${item.fasilitas?item.fasilitas:'-'}</td><td>`;
                        if (unit != null) {
                            unit.forEach(val => {
                                res.role.forEach(pus => {
                                    if (val == pus.id) {
                                        content += `<span class="badge bg-primary">` + pus.name + `</span>&nbsp;`;
                                    }
                                })
                            })
                        } else {
                            content += `<span class="badge bg-dark">Semua Karyawan</span>`;
                        }
                        content += `</td><td>`;
                            if(item.updated_at)
                            {
                                content += new Date(item.updated_at).toLocaleString("sv-SE");
                            } else { content += `-`; }
                        content += `</td></tr>`;
                        $('#tampil-tbody').append(content);
                    })
                    var table = $('#dttable').DataTable({
                        order: [
                            [6, "desc"]
                        ],
                        bAutoWidth: false,
                        aoColumns : [
                            { sWidth: '5%' },
                            { sWidth: '20%' },
                            { sWidth: '20%' },
                            { sWidth: '10%' },
                            { sWidth: '15%' },
                            { sWidth: '20%' },
                            { sWidth: '10%' },
                        ],
                        displayLength: 7,
                        lengthChange: true,
                        lengthMenu: [7, 10, 25, 50, 75, 100],
                        buttons: ['copy', 'excel', 'pdf', 'colvis']
                    });
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

            // $(".select2").select2({
            //     placeholder: "",
            //     allowClear: true
            // }).val('').trigger('change');
        })

        // FUNCTION AREA
        function tambah() {
            $('#modalTambah').modal('show');
        }

        function simpan() {
            var ruangan = $("#ruangan").val();
            var kapasitas = $("#kapasitas").val();
            var akses = $("#akses").val();
            var deskripsi = $("#deskripsi").val();
            var fasilitas = $("#fasilitas").val();

            if (ruangan == "" || kapasitas == "") {
                iziToast.warning({
                    title: 'Pesan Ambigu!',
                    message: 'Pastikan Anda tidak mengosongi semua isian wajib',
                    position: 'topRight'
                });
            } else {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: 'POST',
                    url: '/api/eruang/ruangan/store',
                    dataType: 'json',
                    data: {
                        ruangan: ruangan,
                        kapasitas: kapasitas,
                        akses: akses,
                        deskripsi: deskripsi,
                        fasilitas: fasilitas,
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
                url: "/api/eruang/ruangan",
                type: 'GET',
                dataType: 'json', // added data type
                success: function(res) {
                    $("#tampil-tbody").empty();
                    $('#dttable').DataTable().clear().destroy();
                    res.show.forEach(item => {
                        if (item.akses) {
                            var unit = JSON.parse(item.akses.replace(/"/g,""));
                        } else {
                            var unit = null;
                        }
                        content = `<tr><td><div class="d-flex align-items-center">
                                            <div class="dropdown">
                                                <a href="javascript:;" class="btn btn-link-secondary dropdown-toggle hide-arrow text-body p-0 btn-icon" data-bs-toggle="dropdown">` + item.id + `</a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a href="javascript:;" onclick="ubah(` + item.id + `)" class="dropdown-item text-warning"><i class='fas fa-edit me-1'></i> Ubah</a>
                                                    <a href="javascript:;" onclick="hapus(` + item.id + `)" class="dropdown-item text-danger"><i class='fas fa-trash-alt me-1'></i> Hapus</a>
                                                </div>
                                            </div>
                                        </div></td>`;
                        content += `<td><u><b class='text-primary'>`+item.nama+`</b></u></td>`;
                        content += `<td>${item.deskripsi?item.deskripsi:'-'}</td>`;
                        content += `<td>`+item.kapasitas+`</td>`;
                        content += `<td>${item.fasilitas?item.fasilitas:'-'}</td><td>`;
                        if (unit != null) {
                            unit.forEach(val => {
                                res.role.forEach(pus => {
                                    if (val == pus.id) {
                                        content += `<span class="badge bg-primary">` + pus.name + `</span>&nbsp;`;
                                    }
                                })
                            })
                        } else {
                            content += `<span class="badge bg-dark">Semua Karyawan</span>`;
                        }
                        content += `</td><td>`;
                            if(item.updated_at)
                            {
                                content += new Date(item.updated_at).toLocaleString("sv-SE");
                            } else { content += `-`; }
                        content += `</td></tr>`;
                        $('#tampil-tbody').append(content);
                    })
                    var table = $('#dttable').DataTable({
                        order: [
                            [6, "desc"]
                        ],
                        bAutoWidth: false,
                        aoColumns : [
                            { sWidth: '5%' },
                            { sWidth: '20%' },
                            { sWidth: '20%' },
                            { sWidth: '10%' },
                            { sWidth: '15%' },
                            { sWidth: '20%' },
                            { sWidth: '10%' },
                        ],
                        displayLength: 7,
                        lengthChange: true,
                        lengthMenu: [7, 10, 25, 50, 75, 100],
                        buttons: ['copy', 'excel', 'pdf', 'colvis']
                    });

                    // Showing Tooltip
                    $('[data-bs-toggle="tooltip"]').tooltip({
                        trigger: 'hover'
                    })
                }
            })
        }

        function ubah(id) {
            $("#id_edit").val("");
            $("#ruangan_edit").val("");
            $("#kapasitas_edit").val("");
            $("#deskripsi_edit").val("");
            $("#fasilitas_edit").val("");
            $.ajax(
            {
                url: "/api/eruang/ruangan/ubah/"+id,
                type: 'GET',
                dataType: 'json', // added data type
                success: function(res) {
                    var un = JSON.parse(res.show.akses);
                    // var dt = new Date(res.show.tanggal).toJSON().slice(0,19);
                    // var dt = moment(res.show.tgl).format('Y-MM-DD HH:mm');

                    $("#id_edit").val(res.show.id);
                    $("#ruangan_edit").val(res.show.nama);
                    $("#deskripsi_edit").val(res.show.deskripsi);
                    $("#kapasitas_edit").val(res.show.kapasitas);
                    $("#fasilitas_edit").val(res.show.fasilitas);
                    $("#akses_edit").find('option').remove();
                    var opt = '';
                    if (res.show.akses != null) {
                        res.role.forEach(poke => {
                            opt = `<option value="${poke.id}"`;
                            un.forEach(pounch => {
                                if (poke.id == pounch) {
                                    opt += `selected`;
                                }
                            });
                            opt += `>${poke.name}</option>`;
                            $("#akses_edit").append(opt);
                        });
                    } else {
                        // opt = `<option value=''>Pilih</option>`;
                        res.role.forEach(poke => {
                            opt = `<option value="${poke.id}">${poke.name}</option>`;
                            $("#akses_edit").append(opt);
                        });
                    }
                    $('#modalUbah').modal('show');
                }
            });
        }

        function prosesUbah() {
            $("#btn-ubah").prop('disabled', true);
            $("#btn-ubah").find("i").toggleClass("fa-save fa-sync fa-spin");

            var fd = new FormData();
            fd.append('id',$("#id_edit").val());
            fd.append('ruangan',$("#ruangan_edit").val());
            fd.append('deskripsi',$("#deskripsi_edit").val());
            fd.append('kapasitas',$("#kapasitas_edit").val());
            fd.append('fasilitas',$("#fasilitas_edit").val());
            fd.append('akses',$("#akses_edit").val());

            // AJAX request
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "/api/eruang/ruangan/ubah/proses",
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
                    message: 'Mohon menyetujui/ceklis form ini untuk melanjutkan proses penghapusan baris tersebut',
                    position: 'topRight'
                });
            } else {
                // PROSES HAPUS
                var id = $("#id_hapus").val();
                $.ajax({
                    url: "/api/eruang/ruangan/hapus/"+id,
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
