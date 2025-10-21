@extends('layouts.default')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Struktur Organisasi - Tambah</h4>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <button class="btn btn-outline-secondary" onclick="window.location.href='{{ URL::previous() }}'"><i
                        class="bx bx-chevron-left"></i>&nbsp;&nbsp;Kembali</button>
            </h4>
            <hr>

            <form class="form-auth-small" name="formTambah" action="{{ route('strukturorganisasi.simpan') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="form-group mb-4">
                    <label for="userx" class="form-label">Nama User</label>
                    <select id="userx" name="user" class="form-control select2" style="width: 100%" required
                        data-placeholder="">
                        @if (count($list['user']) > 0)
                            @foreach ($list['user'] as $item)
                                <option value="{{ $item->id }}">{{ $item->nama }}</option>
                            @endforeach
                        @endif
                    </select>
                    <sub>Pilih user yang akan mendapatkan akses laporan bawahannya</sub>
                </div>
                <div class="form-group mb-4">
                    <label for="bawahanx" class="form-label">Jabatan Struktural Bawahan</label>
                    <select id="bawahanx" name="bawahan[]" class="select2 form-control select2-multiple"
                        data-bs-auto-close="outside" required multiple="multiple" style="width: 100%">
                        @if (count($list['role']) > 0)
                            @foreach ($list['role'] as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        @endif
                    </select>
                    <sub>Pilih semua Role bawahan</sub>
                </div>
                <button class="btn btn-primary" id="btn-simpan" onclick="saveData()">
                    <i class="fas fa-save fa-md"></i>&nbsp;&nbsp;
                    <span class="align-middle d-sm-inline-block d-none me-sm-1">Simpan</span>
                </button>
            </form>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            // "use strict";
            // $('#name').keypress(function() {
            //     $("#btn-simpan").prop('disabled', true);
            // }).on('keydown', function(e) {
            //     if (e.keyCode == 8)
            //         $("#btn-simpan").prop('disabled', true);
            // });
            // $("#open-password1").on("click", function() {
            //     var x = $("#password1");
            //     if (x[0].type === "password") {
            //         x[0].type = "text";
            //     } else {
            //         x[0].type = "password";
            //     }
            // });
            // $("#open-password2").on("click", function() {
            //     var x = $("#password2");
            //     if (x[0].type === "password") {
            //         x[0].type = "text";
            //     } else {
            //         x[0].type = "password";
            //     }
            // });
            $(".select2").select2({
                placeholder: "",
                allowClear: true
            }).val('').trigger('change');
            // $(".select2").addClass('form-control').select2();
            // $(".select2multiple").select2();
        })

        // FUNCTION
        function saveData() {
            $("#formTambah").one('submit', function() {
                $("#btn-simpan").attr('disabled', 'disabled');
                $("#btn-simpan").find("i").toggleClass("fa-save fa-sync fa-spin");
                return true;
                // if (pas1 == '' && pas2 != '') {
                //     iziToast.error({
                //         title: 'Pesan Galat!',
                //         message: 'Mohon untuk melengkapi pengisian Password',
                //         position: 'topRight'
                //     });
                //     return false;
                // } else {
                //     if (pas1 != '' && pas2 == '') {
                //         iziToast.error({
                //             title: 'Pesan Galat!',
                //             message: 'Mohon untuk melengkapi pengisian Password',
                //             position: 'topRight'
                //         });
                //         return false;
                //     } else {
                //         if (pas1 === pas2) {
                //             $("#btn-simpan").attr('disabled', 'disabled');
                //             $("#btn-simpan").find("i").toggleClass("fa-save fa-sync fa-spin");
                //             return true;
                //         } else {
                //             iziToast.error({
                //                 title: 'Pesan Galat!',
                //                 message: 'Mohon maaf, kombinasi password tidak cocok',
                //                 position: 'topRight'
                //             });
                //             return false;
                //         }
                //     }
                // }
            });
        }
    </script>
@endsection
