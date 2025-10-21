@extends('layouts.index')

@section('content')

    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i></a></li>
                        <li class="breadcrumb-item">Atur Pengguna</li>
                        <li class="breadcrumb-item">Hak Akses</li>
                        <li class="breadcrumb-item"><a href="{{ route('akunpengguna.index') }}">Akun Pengguna</a></li>
                        <li class="breadcrumb-item" aria-current="page">Tambah</li>
                    </ul>
                </div>
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h2 class="mb-0">Tambah Akun Pengguna</h2>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- [ breadcrumb ] end -->
    <!-- [ Main Content ] start -->
    <div class="row pt-1">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between py-3">
                    <button class="btn btn-outline-dark" onclick="window.location.href='{{ URL::previous() }}'"><i class="fas fa-angle-left me-1"></i> Kembali</button>
                    <h5 class="mb-0">Form Tambah</h5>
                </div>
                <div class="card-body pb-2">
                    <form class="form-auth-small" name="formTambah" action="{{ route('akunpengguna.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <h5 class="mb-3 text-center">Dimohon untuk membaca syarat & ketentuan pembuatan Akun Pengguna!</h5>
                            <div class="col-md-12 mb-1">
                                <div class="alert alert-secondary">
                                    <div class="row">
                                        <div class="col">
                                            <i class="ti ti-arrow-narrow-right me-1"></i> Username/Password tidak boleh menggunakan <b>SPASI</b><br>
                                            <i class="ti ti-arrow-narrow-right me-1"></i> Disarankan untuk menggunakan kombinasi Huruf & Angka
                                        </div>
                                        <div class="col">
                                            <i class="ti ti-arrow-narrow-right me-1"></i> Buat password seunik mungkin agar tidak mudah terbaca oleh orang lain<br>
                                            <i class="ti ti-arrow-narrow-right me-1"></i> Password akan dienkripsi menggunakan Laravel Bcrypt Hash
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="form-label">Username</label>
                                    <div class="input-group">
                                        <input type="text" name="name" id="name" class="form-control" placeholder=""
                                            required />
                                        <button class="btn btn-outline-primary" type="button" onclick="verifName()">Check</button>
                                    </div>
                                    <small>Klik Check untuk validasi ketersediaan Username</small>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="defaultFormControlInput" class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" placeholder="" required />
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label for="defaultFormControlInput" class="form-label">Role</label>
                                    <div class="select2-dark">
                                        <select id="role" name="role[]" class="select2 form-control select2-multiple"
                                            data-bs-auto-close="outside" required multiple="multiple"
                                            data-placeholder="Pilih Role ..." style="width: 100%">
                                            @if (count($role) > 0)
                                                @foreach ($role as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="defaultFormControlInput" class="form-label">Password</label>
                                    <div class="input-group">
                                        <input type="password" name="password" class="form-control" id="password1" minlength="8"
                                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                            onpaste="return false" required />
                                        <button class="btn btn-outline-primary" type="button" id="open-password1">
                                            <i class="fas fa-eye-slash" id="icon-password1"></i>
                                        </button>
                                    </div>
                                    <small>Masukkan password minimal 8 karakter</small>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="defaultFormControlInput" class="form-label">Retype Password</label>
                                    <div class="input-group">
                                        <input type="password" name="repassword" class="form-control" id="password2" minlength="8"
                                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                            onpaste="return false" required />
                                        <button class="btn btn-outline-primary" type="button" id="open-password2">
                                            <i class="fas fa-eye-slash" id="icon-password2"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 d-flex justify-content-end">
                                <button class="btn btn-primary" id="btn-simpan" onclick="saveData()" disabled>
                                    <i class="fas fa-save fa-md"></i>&nbsp;&nbsp;
                                    <span class="align-middle d-sm-inline-block d-none me-sm-1">Simpan</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $(".select2").select2();
            $('#open-password1').on('click', function () {
                const input = $('#password1');
                const icon = $('#icon-password1');

                if (input.attr('type') === 'password') {
                    input.attr('type', 'text');
                    icon.removeClass('fa-eye-slash').addClass('fa-eye');
                } else {
                    input.attr('type', 'password');
                    icon.removeClass('fa-eye').addClass('fa-eye-slash');
                }
            });
            $('#open-password2').on('click', function () {
                const input = $('#password2');
                const icon = $('#icon-password2');

                if (input.attr('type') === 'password') {
                    input.attr('type', 'text');
                    icon.removeClass('fa-eye-slash').addClass('fa-eye');
                } else {
                    input.attr('type', 'password');
                    icon.removeClass('fa-eye').addClass('fa-eye-slash');
                }
            });
        })

        // FUNCTION
        function saveData() {
            var pas1 = $("#password1").val();
            var pas2 = $("#password2").val();
            $("#formTambah").one('submit', function() {
                if (pas1 == '' && pas2 != '') {
                    iziToast.error({
                        title: 'Pesan Galat!',
                        message: 'Mohon untuk melengkapi pengisian Password',
                        position: 'topRight'
                    });
                    return false;
                } else {
                    if (pas1 != '' && pas2 == '') {
                        iziToast.error({
                            title: 'Pesan Galat!',
                            message: 'Mohon untuk melengkapi pengisian Password',
                            position: 'topRight'
                        });
                        return false;
                    } else {
                        if (pas1 === pas2) {
                            $("#btn-simpan").attr('disabled', 'disabled');
                            $("#btn-simpan").find("i").toggleClass("fa-save fa-sync fa-spin");
                            return true;
                        } else {
                            iziToast.error({
                                title: 'Pesan Galat!',
                                message: 'Mohon maaf, kombinasi password tidak cocok',
                                position: 'topRight'
                            });
                            return false;
                        }
                    }
                }
            });
        }

        function verifName() {
            var name = $("#name").val();
            $.ajax({
                url: "/api/hakakses/akunpengguna/verif/" + name,
                type: 'GET',
                dataType: 'json', // added data type
                success: function(res) {
                    if (res === 1) {
                        iziToast.error({
                            title: 'Pesan Galat!',
                            message: 'Mohon maaf, username sudah ada, silakan coba lagi dengan username yang berbeda',
                            position: 'topRight'
                        });
                    } else {
                        iziToast.success({
                            title: 'Pesan Sukses!',
                            message: 'Username dapat digunakan',
                            position: 'topRight'
                        });
                        $("#btn-simpan").prop('disabled', false);
                    }
                },
                error: function(res) {
                    iziToast.error({
                        title: 'Pesan Galat!',
                        message: 'Mohon maaf, username sudah ada, silakan coba lagi dengan username yang berbeda',
                        position: 'topRight'
                    });
                }
            });
        }
    </script>
@endsection
