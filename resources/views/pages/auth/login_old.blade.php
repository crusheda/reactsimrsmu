@extends('layouts.auth_old')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-5">
            <div class="card">
                <div class="card-body ">
                    <div class="w-100">
                        <h5 class="text-primary">Selamat Datang! 👋</h5>
                        <p class="text-muted">Silakan masuk terlebih dahulu.</p>
                        <form method="POST" action="{{ route('login') }}" id="submitForm">
                            @csrf

                            <div class="mb-3" data-validate="Username is required">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" placeholder="Enter username" value="{{ old('name') }}" required
                                    autocomplete="name" autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                {{-- @if ($errors->has('name'))
                                        <span class="">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                @endif --}}
                            </div>

                            <div class="mb-3" data-validate="Password is required">
                                <div class="float-end">
                                    <a href="javascript:void(0);" onclick="forgotPassword()" class="text-muted">Forgot password?</a>
                                </div>
                                {{-- @if (Route::has('password.request'))
                                    <div class="float-end">
                                        <a href="{{ route('password.request') }}" class="text-muted">Forgot password?</a>
                                    </div>
                                @endif --}}
                                <label class="form-label">Password</label>
                                <div class="input-group auth-pass-inputgroup">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        placeholder="Enter password" aria-label="Password" aria-describedby="password-addon"
                                        id="password" name="password" required autocomplete="current-password">
                                    <button class="btn btn-outline-secondary " type="button" id="open-password" style="border-color: #ced4da"><i
                                            class="mdi mdi-eye-outline"></i></button>
                                </div>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember {{ old('remember') ? 'checked' : '' }}">
                                <label class="form-check-label" for="remember-check">
                                    Remember me
                                </label>
                            </div>

                            <hr>

                            <div class="mb-3">
                                <center><label for="" class ="form-label">Selesaikan Captcha</label></center>
                                {{-- {!! Captcha::img('math') !!} --}}
                                <div id="reloadedCaptcha" class="mb-2 text-center"><span>{!! captcha_img('math') !!}</span></div>
                                <div class="input-group auth-pass-inputgroup">
                                    <input type="number" class="form-control" name="captcha" min="0" max="99" onKeyUp="if(this.value>99){this.value='';alert('Masukkan 2 digit hasil penjumlahan Captcha!')}else if(this.value<0){this.value='0';}" placeholder="Tulis hasil penjumlahan dari angka di atas">
                                    <a class="btn btn-outline-secondary" id="btn-reload-captcha" onclick="reloadCaptcha()" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true"
                                    title="1x Refresh Captcha"><i class="fas fa-sync"></i></a>
                                </div>
                                @error('captcha')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mt-3 mb-3">
                                {{-- <center>
                                    <div class="btn-group">
                                        <a class="btn btn-outline-secondary" href="{{ route('portal') }}" data-bs-toggle="tooltip"
                                        data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true"
                                        title="Kembali ke Portal Utama"><i  class="bx bx-chevron-left"></i></a>
                                    </div>
                                </center> --}}
                                <button class="btn btn-primary" style="width:100%;box-sizing: border-box" type="submit">Log In</button>
                            </div>


                            {{-- <div class="mt-4 text-center">
                                <h5 class="font-size-14 mb-3">Sign in with</h5>

                                <ul class="list-inline">
                                    <li class="list-inline-item">
                                        <a href="javascript::void()"
                                            class="social-list-item bg-primary text-white border-primary">
                                            <i class="mdi mdi-facebook"></i>
                                        </a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="javascript::void()"
                                            class="social-list-item bg-info text-white border-info">
                                            <i class="mdi mdi-twitter"></i>
                                        </a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="javascript::void()"
                                            class="social-list-item bg-danger text-white border-danger">
                                            <i class="mdi mdi-google"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div> --}}

                        </form>
                        <div class="text-center">
                            <p>Belum mempunyai akun ? <a href="javascript: void(0);" onclick="hubungiIT()" class="fw-medium text-primary"> Hubungi ITRS </a> </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="text-center">
        <p>
            <script>
                document.write(new Date().getFullYear())
            </script> © Made with <i class="mdi mdi-heart text-danger"></i> by
            <a href="{{ url('https://instagram.com/hiyussuf') }}" target="_blank" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true"
            title="Lihat Profil Developer">Yussuf Faisal</a>
        </p>
    </div>
    <script>
        $(document).ready(function() {
            $("#open-password").on("click", function() {
                var x = $("#password");
                if (x[0].type === "password") {
                    x[0].type = "text";
                } else {
                    x[0].type = "password";
                }
            });
        })

        function reloadCaptcha() {
            $.ajax({
                url: "/captcha/api/math",
                type: 'GET',
                dataType: 'json', // added data type
                success: function(res) {
                    // $('#reloadedCaptcha span').html('');
                    $('#reloadedCaptcha span').html('{!! captcha_img("math") !!}');
                    $('#btn-reload-captcha').prop('hidden',true);
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
    </script>
@endsection
