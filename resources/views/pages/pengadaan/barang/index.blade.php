@extends('layouts.index')

@section('content')

    {{-- FOR DROPDOWN BEHIND CARD --}}
    <style>
        .dropdown {
            transform-style: preserve-3d;
            transform: translate3d(0,0,10px) !important;
        }
    </style>

    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i></a></li>
                        <li class="breadcrumb-item">Administrasi</li>
                        <li class="breadcrumb-item"><a href="{{ route('pengadaan.index') }}">Pengadaan</a></li>
                        <li class="breadcrumb-item" aria-current="page">Barang</li>
                    </ul>
                </div>
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h2 class="mb-0">Master Barang</h2>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- [ breadcrumb ] end -->

    <!-- [ Main Content ] start -->
    <div class="row pt-1">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h5 class="mb-0 card-title flex-grow-1">
                            <div class="btn-group">
                                <a class="btn btn-link-secondary" href="{{ route('pengadaan.index') }}" data-bs-toggle="tooltip"
                                data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true"
                                title="Kembali"><i class="fas fa-angle-left me-1"></i> Kembali</a>
                            </div>
                        </h5>
                        <div class="flex-shrink-0">
                            <h5>Formulir Barang</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-12 col-xxl-12">
                            <div class="alert alert-secondary">
                                <small>
                                    {{-- <i class="ti ti-arrow-narrow-right me-1"></i> <br> --}}
                                    <i class="ti ti-arrow-narrow-right me-1"></i> Isian bertanda (<a class="text-danger">*</a>) berarti wajib diisi<br>
                                    <i class="ti ti-arrow-narrow-right me-1"></i> Batas ukuran file upload maksimal <b class="text-danger">2 mb</b> dan berformat <b>.jpeg/.png/.jpg</b><br>
                                    <i class="ti ti-arrow-narrow-right me-1"></i> Teks otomatis pada kolom isian <b>Nama Barang</b> menunjukkan barang yang sudah ada atau pernah ditambahkan
                                </small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <div class="form-group">
                                <label class="form-label">Kategori Pengadaan <a class="text-danger">*</a></label>
                                <select class="form-control" name="kategori" id="kategori">
                                    @if ($list['ref'])
                                        <option value="">Pilih</option>
                                        @foreach ($list['ref'] as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-7 mb-3">
                            <div class="form-group">
                                <label class="form-label">Nama Barang <a class="text-danger">*</a></label>
                                <input type="text" name="barang" id="barang" class="form-control typeahead" placeholder="e.g. Tinta Spidol / Stempel / Bolpoin, etc" required />
                            </div>
                        </div>
                        <div class="col-md-2 mb-3">
                            <div class="form-group">
                                <label class="form-label">Satuan <a class="text-danger">*</a></label>
                                <input type="text" class="form-control" name="satuan" id="satuan" placeholder="e.g. Pack / Pcs / Box, etc">
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="form-group">
                                <label class="form-label">Harga <a class="text-danger">*</a></label>
                                <input type="text" class="form-control" name="harga" id="harga" onclick="$(this).val('')" placeholder="Rp. xxx.xxx" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="Masukkan Hanya Angka Tanpa Titik (.) / Koma (,) /dsb">
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <label class="form-label">Upload Lampiran (<mark>Optional</mark>)</label>
                                <input type="file" class="form-control" id="filex" name="filex" accept=".jpg,.jpeg,.png">
                            </div>
                        </div>
                        <div class="text-end btn-page mt-2">
                            <button class="btn btn-link-secondary" id="clear_text" onclick="clearInput()">Kosongkan</button>
                            <button class="btn btn-primary" id="btn-simpan" onclick="simpan()"><i class="fas fa-save me-1"></i> Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-end">
                {{-- <button class="btn btn-link-primary"><i class="ti ti-arrow-narrow-left align-text-bottom me-2"></i>Back to Shipping Information</button> --}}
            </div>
        </div>
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Daftar</h5>
                    <div class="btn-group">
                        <a href="javascript:void(0);" class="btn btn-link-warning" onclick="showRiwayat()" data-bs-toggle="tooltip"
                        data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="Segarkan Tabel"><i class="ti ti-refresh f-20 me-2"></i> Refresh</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dttable" class="table table-hover dt-responsive align-middle">
                            <thead>
                                <tr>
                                    <th><center>#ID</center></th>
                                    <th><center>KATEGORI</center></th>
                                    <th>NAMA BARANG (SATUAN)</th>
                                    <th>HARGA</th>
                                    <th>UPDATE</th>
                                </tr>
                            </thead>
                            <tbody id="tampil-tbody">
                                <tr>
                                    <td colspan="9" style="font-size:13px">
                                        <center><i class="fa fa-spinner fa-spin fa-fw"></i> Memproses data...</center>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th><center>#ID</center></th>
                                    <th><center>KATEGORI</center></th>
                                    <th>NAMA BARANG (SATUAN)</th>
                                    <th>HARGA</th>
                                    <th>UPDATE</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL START --}}
    <div class="modal fade animate__animated animate__rubberBand" id="modalUbah" role="dialog" aria-labelledby="confirmFormLabel"aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        Form Ubah ID#<a id="id_edit_show" class="text-primary"></a>
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="text" id="id_edit" hidden>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-secondary">
                                <small>
                                    {{-- <i class="ti ti-arrow-narrow-right me-1"></i> <br> --}}
                                    <i class="ti ti-arrow-narrow-right me-1"></i> Isian bertanda (<a class="text-danger">*</a>) berarti wajib diisi<br>
                                    <i class="ti ti-arrow-narrow-right me-1"></i> Batas ukuran file upload maksimal <b class="text-danger">2 mb</b> dan berformat <b>.jpeg/.png/.jpg</b><br>
                                    <i class="ti ti-arrow-narrow-right me-1"></i> Teks otomatis pada kolom isian <b>Nama Barang</b> menunjukkan barang yang sudah ada atau pernah ditambahkan
                                </small>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="form-group">
                                <label class="form-label">Kategori Pengadaan <a class="text-danger">*</a></label>
                                <select class="form-control" name="kategori_edit" id="kategori_edit"></select>
                            </div>
                        </div>
                        <div class="col-md-7 mb-3">
                            <div class="form-group">
                                <label class="form-label">Nama Barang <a class="text-danger">*</a></label>
                                <input type="text" name="barang_edit" id="barang_edit" class="form-control typeahead" placeholder="e.g. Tinta Spidol / Stempel / Bolpoin, etc" required />
                            </div>
                        </div>
                        <div class="col-md-2 mb-3">
                            <div class="form-group">
                                <label class="form-label">Satuan <a class="text-danger">*</a></label>
                                <input type="text" class="form-control" name="satuan_edit" id="satuan_edit" placeholder="e.g. Pack / Pcs / Box, etc">
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="form-group">
                                <label class="form-label">Harga <a class="text-danger">*</a></label>
                                <input type="text" class="form-control" name="harga_edit" id="harga_edit" onclick="$(this).val('')" placeholder="Rp. xxx.xxx" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="Masukkan Hanya Angka Tanpa Titik (.) / Koma (,) /dsb">
                            </div>
                        </div>
                        <div class="col-md-7 mb-3">
                            <div class="form-group">
                                <label class="form-label">Upload Lampiran Baru</label>
                                <input type="file" class="form-control" id="filex_edit" name="filex_edit" accept=".jpg,.jpeg,.png">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="form-label">File</label>
                                <div id="filex_edit_show"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link-secondary" data-bs-dismiss="modal">Batalkan</button>
                    <button class="btn btn-primary" id="btn-ubah" onclick="prosesUbah()"><i class="fa-fw fas fa-save nav-icon"></i> Simpan Perubahan</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal animate__animated animate__rubberBand fade" id="modalHapus" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-simple modal-add-new-address modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        Form Hapus
                    </h4>
                </div>
                <div class="modal-body">
                    <input type="text" id="id_hapus" hidden>
                    <p style="text-align: justify;">Anda akan melakukan tindakan penghapusan Barang, lakukanlah dengan hati-hati. Ceklis dibawah untuk melanjutkan penghapusan.</p>
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
                    <button type="reset" class="btn btn-link-secondary" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-times me-1" style="font-size:13px"></i> Batal</button>
                </div>
            </div>
        </div>
    </div>
    {{-- MODAL END --}}

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

            // $('.select2Tambah').select2({
            //     dropdownParent: $('#tambah')
            // });

            showRiwayat();

            var pathAcBarang = "{{ route('pengadaan.ac.barang') }}";
            $('.typeahead').typeahead({
                source: function(query, process) {
                    return $.get(pathAcBarang, {
                        barang : query
                    }, function(data) {
                        return process(data);
                    });
                }
            });

            // HARGA ADD
            var rupiah1 = document.getElementById('harga');
            rupiah1.addEventListener('change', function(e){
                // tambahkan 'Rp.' pada saat form di ketik
                // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
                rupiah1.value = formatRupiah(parseInt(this.value), 'Rp. ');
            });
            // HARGA EDIT
            var rupiah2 = document.getElementById('harga_edit');
            rupiah2.addEventListener('change', function(e){
                // tambahkan 'Rp.' pada saat form di ketik
                // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
                rupiah2.value = formatRupiah(parseInt(this.value), 'Rp. ');
            });
        });

        function showRiwayat() {
            $("#tampil-tbody").empty().append(`<tr style='font-size:13px'><td colspan="9"><center><i class="fa fa-spinner fa-spin fa-fw"></i> Memproses data...</center></td></tr>`);
            $.ajax({
                url: "/api/pengadaan/barang/table",
                type: 'GET',
                dataType: 'json',
                success: function(res) {
                    $("#tampil-tbody").empty();
                    $('#dttable').DataTable().clear().destroy();
                    res.forEach(item => {
                        var updet = new Date(item.updated_at).toLocaleDateString("sv-SE");
                        var date = new Date().toLocaleDateString("sv-SE");
                        content = "<tr id='data" + item.id + "' style='font-size:13px'>";
                        content += `<td><center><div class='btn-group'>
                                        <button type='button' class='btn btn-sm btn-link text-secondary dropdown-toggle hide-arrow' data-bs-toggle='dropdown' aria-expanded='false'>`+item.id+`</button>
                                        <ul class='dropdown-menu dropdown-menu-right'>`;
                                        content += `<li><a href="javascript:void(0);" class="dropdown-item text-${item.filename == null?'secondary':'primary'}" onclick="lampiran(${item.filename == null?'':item.id})"><i class="fa-fw fas fa-download me-2"></i> Lampiran</a></li>`;
                                        content += `<li><a href="javascript:void(0);" class="dropdown-item text-warning" onclick="ubah(${item.id})"><i class="fa-fw fas fa-edit me-2"></i> Ubah</a></li>`;
                                        content += `<li><a href='javascript:void(0);' class='dropdown-item text-danger' onclick="hapus(` + item.id + `)"><i class="fa-fw fas fa-trash nav-icon"></i> Hapus</a></li>`;
                        content += "</div></center></td>";
                        content += `<td><center>${item.nama_ref}</center></td>`;
                        if (item.filename == null) {
                            file = `<a href="javascript:void(0);" class="text-dark"><u>` + item.nama + `</u></a>`;
                        } else {
                            file = `<a href="javascript:void(0);" class="text-primary" onclick="window.open('/pengadaan/barang/download/`+item.id+`')" data-bs-toggle="tooltip"
                                    data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="Download (${item.title})"><u>` + item.nama + `</u></a>`;
                        }
                        content += `<td style='white-space: normal !important;word-wrap: break-word;'>
                                        <div class='d-flex justify-content-start align-items-center'>
                                            <div class='d-flex flex-column'>
                                                <h6 class='mb-0'>${file} (<a class="text-danger">${item.satuan}</a>)</h6>
                                            </div>
                                        </div>
                                    </td>`;
                        content += `<td>${formatRupiah(parseInt(item.harga), 'Rp. ')}</td>`;
                        content += `<td style='white-space: normal !important;word-wrap: break-word;'>
                                        <div class='d-flex justify-content-start align-items-center'>
                                            <div class='d-flex flex-column'>
                                                <a class='mb-0'>` + new Date(item.updated_at).toLocaleString("sv-SE") + `</a>
                                                <small class='text-truncate text-muted'>` + item.nama_user + `</small>
                                            </div>
                                        </div>
                                    </td>`;
                        content += "</tr>";
                        $('#tampil-tbody').append(content);
            // Showing Tooltip
            $('[data-bs-toggle="tooltip"]').tooltip({
                trigger: 'hover'
            })
                    });
                    var table = $('#dttable').DataTable({
                        dom: 'Bfrtip',
                        order: [
                            [4, "desc"]
                        ],
                        bAutoWidth: false,
                        aoColumns : [
                            { sWidth: '5%' },
                            { sWidth: '10%' },
                            { sWidth: '55%' },
                            { sWidth: '12%' },
                            { sWidth: '18%' },
                        ],
                        columnDefs: [
                            // { visible: false, targets: [7] },
                        ],
                        displayLength: 7,
                        lengthChange: true,
                        lengthMenu: [7, 10, 25, 50, 75, 100],
                        buttons: ['excel', 'pdf', 'colvis']
                    });
                }
            })
        }

        function simpan() {
            $("#btn-simpan").prop('disabled', true);
            $("#btn-simpan").find("i").toggleClass("fa-save fa-sync fa-spin");

            // Definisi
            var save = new FormData();
            var filesAdded = $('#filex')[0].files;
            save.append('kategori',$('#kategori').val());
            save.append('barang',$('#barang').val());
            save.append('satuan',$('#satuan').val());
            save.append('harga',$('#harga').val());
            save.append('user','{{ Auth::user()->id }}');
            save.append('file',filesAdded[0]);
            if (
                save.get('kategori') == ""     ||
                save.get('barang') == ""       ||
                save.get('satuan') == ""     ||
                save.get('harga') == ""
                ) {
                iziToast.warning({
                    title: 'Pesan Ambigu!',
                    message: 'Pastikan Anda tidak mengosongi semua isian Wajib',
                    position: 'topRight'
                });
            } else {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{route('pengadaan.barang.tambah')}}",
                    method: 'post',
                    data: save,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(res) {
                        if (res.code == 200) {
                            notifier.show(
                                "Pesan Sukses!", "Submit Barang berhasil dilakukan pada "+res.message,
                                "success", "{{ asset('images/notification/ok-48.png') }}", 4e3
                            );
                            showRiwayat();
                            clearInput();
                        } else {
                            notifier.show(
                                "Pesan Galat!", res.message,
                                "warning", "{{ asset('images/notification/medium_priority-48.png') }}", 4e3
                            );
                        }
                    },
                    error: function (res) {
                        notifier.show(
                            res.statusText + " (Code " + res.status + ")", res.responseText,
                            "danger", "{{ asset('images/notification/high_priority-48.png') }}", 4e3
                        );
                    }
                });
            }

            $("#btn-simpan").find("i").removeClass("fa-sync fa-spin").addClass("fa-save");
            $("#btn-simpan").prop('disabled', false);
        }

        function ubah(id) {
            $.ajax(
            {
                url: "/api/pengadaan/barang/ubah/"+id,
                type: 'GET',
                dataType: 'json',
                success: function(res) {
                    if (res.show.filename == null) {
                        $("#filex_edit_show").empty().append(`<h6 class="text-danger">Tidak Ada Lampiran</h6>`);
                    } else {
                        $("#filex_edit_show").empty().append(`<h6 class="text-primary"><a href="javascript:void(0);" onclick="window.open('/pengadaan/barang/download/`+res.show.id+`')"><u>${res.show.title}</u></a></h6>`);
                    }
                    $('#id_edit_show').text(res.show.id);
                    $('#id_edit').val(res.show.id);
                    $('#barang_edit').val(res.show.nama);
                    $('#satuan_edit').val(res.show.satuan);
                    $('#harga_edit').val(formatRupiah(parseInt(res.show.harga), 'Rp. '));
                    $("#kategori_edit").find('option').remove();
                    res.ref.forEach(pounch => {
                        $("#kategori_edit").append(`
                            <option value="${pounch.id}" ${res.show.ref_barang==pounch.id?"selected":""}>${pounch.nama}</option>
                        `);
                    });
                    $('#modalUbah').modal('show');
                }
            })
        }

        // function ubahLampiran(id) {
        //     $("#filex_edit_show").empty().append('<input type="file" class="form-control" id="filex_edit" name="filex_edit" accept="image/*">')
        // }

        function prosesUbah() {
            $("#btn-ubah").prop('disabled', true);
            $("#btn-ubah").find("i").toggleClass("fa-save fa-sync fa-spin");

            var save = new FormData();
            var id = $('#id_edit').val();
            var filesAdded = $('#filex_edit')[0].files;
            console.log(filesAdded);
            save.append('id',id);
            save.append('barang',$('#barang_edit').val());
            save.append('satuan',$('#satuan_edit').val());
            save.append('harga',$('#harga_edit').val());
            save.append('kategori',$('#kategori_edit').val());
            save.append('user','{{ Auth::user()->id }}');
            if (filesAdded.length != 0) {
                save.append('file',filesAdded[0]);
            }

            if (
                save.get('barang') == ""  ||
                save.get('satuan') == ""  ||
                save.get('harga') == ""   ||
                save.get('kategori') == ""
            ) {
                iziToast.warning({
                    title: 'Pesan Ambigu!',
                    message: 'Pastikan Anda tidak mengosongi semua isian Wajib',
                    position: 'topRight'
                });
            } else {
                // AJAX request
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "/api/pengadaan/barang/ubah/proses",
                    method: 'post',
                    data: save,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(res){
                        notifier.show(
                            "Pesan Sukses!", "Perubahan berhasil disimpan pada "+res.message,
                            "success", "{{ asset('images/notification/ok-48.png') }}", 4e3
                        );
                        if (res) {
                            $('#modalUbah').modal('hide');
                            showRiwayat();
                            clearInput();
                        }
                    },
                    error: function(res){
                        console.log("error : " + JSON.stringify(res) );
                        notifier.show(
                            res.statusText + " (Code " + res.status + ")", res.responseText,
                            "danger", "{{ asset('images/notification/high_priority-48.png') }}", 4e3
                        );
                    }
                });
            }

            $("#btn-ubah").find("i").removeClass("fa-sync fa-spin").addClass("fa-save");
            $("#btn-ubah").prop('disabled', false);
        }

        function hapus(id) {
            $("#id_hapus").val(id);
            var inputs = document.getElementById('setujuhapus');
            inputs.checked = false;
            $('#modalHapus').modal('show');
        }

        function prosesHapus() {
            // SWITCH BTN HAPUS
            var checkboxHapus = $('#setujuhapus').is(":checked");
            if (checkboxHapus == false) {
                iziToast.error({
                    title: 'Pesan Galat!',
                    message: 'Mohon menyetujui untuk dilakukan penghapusan berkas tersebut',
                    position: 'topRight'
                });
            } else {
                // PROSES HAPUS
                var id = $("#id_hapus").val();
                $.ajax({
                    url: "/api/pengadaan/barang/"+id+"/hapus",
                    type: 'DELETE',
                    success: function(res) {
                        iziToast.success({
                            title: 'Pesan Sukses!',
                            message: 'Penghapusan Barang telah berhasil dilakukan pada '+res,
                            position: 'topRight'
                        });
                        $('#modalHapus').modal('hide');
                        showRiwayat();
                        clearInput();
                    },
                    error: function(res) {
                        iziToast.error({
                            title: 'Pesan Galat!',
                            message: 'Penghapusan Barang gagal dilakukan',
                            position: 'topRight'
                        });
                    }
                });
            }
        }

        function lampiran(id) {
            if (id) {
                Swal.fire({
                    // title: 'Lampiran ID : '+id,
                    // text: '',
                    imageUrl: '/pengadaan/barang/download/' + id,
                    // imageWidth: 400,
                    heightAuto: true,
                    imageHeight: 275,
                    imageAlt: 'Lampiran',
                    reverseButtons: true,
                    showDenyButton: false,
                    showCloseButton: true,
                    showCancelButton: true,
                    cancelButtonText: `<i class="fa fa-times me-1" style="font-size:13px"></i> Tutup`,
                    confirmButtonText: `<i class="fa fa-download"></i> Download`,
                    backdrop: `rgba(26,27,41,0.8)`,
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "/pengadaan/barang/download/" + id;
                    }
                })
            }
        }

        function clearInput() {
            $('#filex').val('');
            $('#kategori').val('').change();
            $('#barang').val('');
            $('#satuan').val('');
            $('#harga').val('');
        }

        function getDateTime() {
            var now = new Date();
            var year = now.getFullYear();
            var month = now.getMonth() + 1;
            var day = now.getDate();
            if (month.toString().length == 1) {
                month = '0' + month;
            }
            if (day.toString().length == 1) {
                day = '0' + day;
            }
            var dateTime = year + '-' + month + '-' + day;
            return dateTime;
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
    </script>
@endsection
