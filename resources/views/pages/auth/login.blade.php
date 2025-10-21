@extends('layouts.auth')

@section('content')
<div class="auth-main">
    <div class="auth-wrapper v1">
        <div class="auth-form">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center text-muted">
                        <a href="{{ route('portal') }}" class="d-block auth-logo">
                            <img id="app-logo" src="{{ asset('images/logo/logo_simrsmu_new_kop_31.png') }}" alt="" height="50"
                                class="auth-logo-dark mx-auto">
                        </a>
                    </div>
                </div>
            </div>
            <div class="card my-4 shadow">
                <div class="card-body">
                    <h5 class="text-primary">Selamat Datang! 👋</h5>
                    <p class="text-muted">Silakan masuk terlebih dahulu.</p>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-3" data-validate="Username is required">
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="floatingInput" placeholder="Masukkan Username" id="name" name="name" value="{{ old('name') }}" autocomplete="name" autofocus required>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3" data-validate="Password is required">
                            <div class="input-group">
                                <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Masukkan Password" id="password" name="password" autocomplete="current-password" required>
                                <button href="javascript:void(0);" type="button" class="btn btn-outline-primary" id="open-password" style="border-color: #ced4da;border-top-right-radius:8px;border-bottom-right-radius:8px">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="d-flex mt-1 justify-content-between align-items-center">
                            <div class="form-check">
                                <input class="form-check-input input-primary" type="checkbox" name="remember" id="remember {{ old('remember') ? 'checked' : '' }}">
                                <label class="form-check-label text-muted" for="customCheckc1">Ingat Saya</label>
                            </div>
                            <h6 class="text-secondary f-w-400 mb-0"><a href="{{ route('lupa.password.get') }}">Lupa Password?</a></h6>
                        </div>
                        <div class="saprator my-2"><span>Selesaikan Captcha</span></div>
                        <div id="reloadedCaptcha" class="mb-3 text-center"><span>{!! captcha_img('math') !!}</span></div>
                        <div class="input-group">
                            <input type="text"
                                class="form-control"
                                name="captcha"
                                inputmode="numeric"
                                pattern="[0-9]*"
                                maxlength="2"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 2);"
                                placeholder="Tulis hasil penjumlahan dari angka di atas"
                                required>
                            {{-- <input type="number" class="form-control" name="captcha" min="0" max="99" onKeyUp="if(this.value>99){this.value='';alert('Masukkan 2 digit hasil penjumlahan Captcha!')}else if(this.value<0){this.value='0';}" placeholder="Tulis hasil penjumlahan dari angka di atas" required> --}}
                            <button type="button" class="btn btn-outline-primary" id="btn-reload-captcha" style="border-color: #ced4da;border-top-right-radius:8px;border-bottom-right-radius:8px" onclick="reloadCaptcha()" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true"
                            title="1x Refresh Captcha"><i class="fas fa-sync fa-fw nav-icon"></i></button>
                        </div>
                        @error('captcha')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <div class="d-grid mt-3">
                            <button class="btn btn-primary" type="submit">Log in</button>
                        </div>
                    </form>
                    <div class="d-flex justify-content-between align-items-end mt-4">
                        <h6 class="f-w-500 mb-0">Belum memiliki akun?</h6>
                        <a href="javascript: void(0);" onclick="hubungiIT()" class="link-primary"> Hubungi ITRS </a>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <p>
                    <script>
                        document.write(new Date().getFullYear())
                    </script> © Made with  <a class="text-danger" href="{{ url('https://instagram.com/hiyussuf') }}" target="_blank" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true"
                    title="Lihat Profil Developer">&#9829;</a>
                </p>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $("#open-password").on("click", function() {
            var x = $("#password");
            if (x[0].type === "password") {
                x[0].type = "text";
                $('#open-password').find("i").toggleClass("fa-eye fa-eye-slash");
            } else {
                x[0].type = "password";
                $('#open-password').find("i").toggleClass("fa-eye-slash fa-eye");
            }
        });

        // $("#btn-login").on("click", function() {
        //     console.log('masuk');
        // });
    })

    function reloadCaptcha() {
        $.ajax({
            url: "/captcha/api/math",
            type: 'GET',
            dataType: 'json', // added data type
            success: function(res) {
                // $('#reloadedCaptcha span').html('');
                $('#reloadedCaptcha span').html('{!! captcha_img("math") !!}');
                $('#btn-reload-captcha').remove();
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

    function forgotPassword() {
        iziToast.error({
            title: 'Mohon maaf!',
            message: 'Sistem sedang dalam perbaikan fitur, silakan hubungi IT',
            position: 'topRight'
        });
    }

    function hubungiIT() {
        iziToast.warning({
            title: 'Pesan Developer!',
            message: 'Hubungi IT dengan menelepon 102 (No.Telp Internal RS)',
            position: 'topRight'
        });
    }

    // function masuk() {
    //     $("#submitForm").one('submit', function() {
    //         //stop submitting the form to see the disabled button effect
    //         return true;
    //     });
    // }
</script>
@endsection
