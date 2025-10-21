@extends('layouts.auth2')

@section('content')
<div class="auth-main">
    <div class="auth-wrapper v1">
        <div class="auth-form">
            <div class="card my-5">
                <div class="card-body">
                    <a href="javascript: void(0);"><img src="{{ asset('images/logo/logo_simrsmu_new_kop_31.png') }}" height="50" class="mb-4" alt="img"></a>
                    <form method="POST" action="{{ route('reset.password.post') }}" novalidate>
                        {{ csrf_field() }}
                        <input name="token" value="{{ $token }}" type="hidden">
                        <div class="mb-4">
                            <h3 class="mb-2"><b>Form Reset Password</b></h3>
                            <p class="text-muted">Masukkan password <mark><b>BARU</b></mark> Anda. Password akan diproses melalui metode Encryption dari <i>Bcrypt Hash Password</i> oleh sistem.</p>
                        </div>
                        {{-- <div class="mb-3"><label class="form-label">Email Anda</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Tuliskan E-Mail Aktif Anda" required autofocus>
                        </div> --}}
                        <div class="mb-3"><label class="form-label">Password Baru</label>
                            <input type="password" class="form-control is-invalid" id="newPassword" name="password" placeholder="&#xb7;&nbsp;&#xb7;&nbsp;&#xb7;&nbsp;&#xb7;&nbsp;&#xb7;&nbsp;&#xb7;&nbsp;&#xb7;&nbsp;&#xb7;&nbsp;&#xb7;&nbsp;&#xb7;" onpaste="return false" required>
                        </div>
                        @if($errors->has('password'))
                            <em class="invalid-feedback">
                                {{ $errors->first('password') }}
                            </em>
                        @endif
                        <div class="mb-3"><label class="form-label">Konfirmasi Password Baru</label>
                            <input type="password" class="form-control is-invalid" id="confirmPassword" name="password_confirmation" placeholder="&#xb7;&nbsp;&#xb7;&nbsp;&#xb7;&nbsp;&#xb7;&nbsp;&#xb7;&nbsp;&#xb7;&nbsp;&#xb7;&nbsp;&#xb7;&nbsp;&#xb7;&nbsp;&#xb7;" onpaste="return false" required>
                        </div>
                        @if($errors->has('password_confirmation'))
                            <em class="invalid-feedback">
                                {{ $errors->first('password_confirmation') }}
                            </em>
                        @endif
                        <div class="mb-3">
                            <h6>Password baru harus memenuhi kriteria :</h6>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item requirements">
                                    <i class="ti ti-circle-check text-danger f-16 me-2 leng"></i> Melebihi lebih 8 karakter
                                </li>
                                {{-- <li class="list-group-item requirements">
                                    <i class="ti ti-circle-check text-success f-16 me-2"></i> At least 1 lower letter (a-z)
                                </li> --}}
                                <li class="list-group-item requirements">
                                    <i class="ti ti-circle-check text-danger f-16 me-2 big-letter"></i> Minimal 1 Huruf Kapital (A-Z)
                                </li>
                                <li class="list-group-item requirements">
                                    <i class="ti ti-circle-check text-danger f-16 me-2 num"></i> Minimal 1 Angka (0-9)
                                </li>
                                <li class="list-group-item requirements">
                                    <i class="ti ti-circle-check text-danger f-16 me-2 special-char"></i> Minimal 1 Karakter Khusus (!@#$%^&*)
                                </li>
                            </ul>
                        </div>
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-secondary" id="btn-submit-password" disabled>Reset Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div><!-- [ Main Content ] end --><!-- Required Js -->
<script>
    addEventListener("DOMContentLoaded", (event) => {
        // "use strict";
        const password = document.getElementById("newPassword");
        const cpassword = document.getElementById("confirmPassword");
        const leng = $(".leng");
        const bigLetter = $(".big-letter");
        const num = $(".num");
        const specialChar = $(".special-char");
        var isPasswordValid = null;

        password.addEventListener("input", () => {
            const value = password.value;
            const isLengthValid = value.length >= 8;
            const hasUpperCase = /[A-Z]/.test(value);
            const hasNumber = /\d/.test(value);
            const hasSpecialChar = /[!@#$%^&*()\[\]{}\\|;:'",<.>/?`~]/.test(value);

            // RESET INPUT KONFIRMASI PASSWORD
            cpassword.value = '';
            $('#btn-submit-password').prop('disabled', true);
            $('#btn-submit-password').removeClass("btn-primary");
            $('#btn-submit-password').addClass("btn-secondary");
            cpassword.classList.remove("is-valid");
            cpassword.classList.add("is-invalid");

            isPasswordValid = isLengthValid && hasUpperCase && hasNumber && hasSpecialChar;

            // PANJANG MINIMAL 8 KARAKTER
            if (isLengthValid == true) {
                leng.removeClass('ti-circle-x text-danger');
                leng.addClass('ti-circle-check text-success');
            } else {
                leng.removeClass('ti-circle-check text-success');
                leng.addClass('ti-circle-x text-danger');
            }
            // MINIMAL 1 HURUF BESAR
            if (hasUpperCase == true) {
                bigLetter.removeClass('ti-circle-x text-danger');
                bigLetter.addClass('ti-circle-check text-success');
            } else {
                bigLetter.removeClass('ti-circle-check text-success');
                bigLetter.addClass('ti-circle-x text-danger');
            }
            // MINIMAL 1 ANGKA
            if (hasNumber == true) {
                num.removeClass('ti-circle-x text-danger');
                num.addClass('ti-circle-check text-success');
            } else {
                num.removeClass('ti-circle-check text-success');
                num.addClass('ti-circle-x text-danger');
            }
            // MINIMAL 1 KARAKTER KHUSUS
            if (hasSpecialChar == true) {
                specialChar.removeClass('ti-circle-x text-danger');
                specialChar.addClass('ti-circle-check text-success');
            } else {
                specialChar.removeClass('ti-circle-check text-success');
                specialChar.addClass('ti-circle-x text-danger');
            }

            // CEKLIS INPUT
            if (isPasswordValid) {
                password.classList.remove("is-invalid");
                password.classList.add("is-valid");
            } else {
                password.classList.remove("is-valid");
                password.classList.add("is-invalid");
            }
        });

        // VALIDASI KONFIRMASI PASSWORD
        cpassword.addEventListener("input", () => {
            if (password.value == cpassword.value && isPasswordValid) {
                $('#btn-submit-password').prop('disabled', false);
                $('#btn-submit-password').removeClass("btn-secondary");
                $('#btn-submit-password').addClass("btn-primary");
                cpassword.classList.remove("is-invalid");
                cpassword.classList.add("is-valid");
            } else {
                $('#btn-submit-password').prop('disabled', true);
                $('#btn-submit-password').removeClass("btn-primary");
                $('#btn-submit-password').addClass("btn-secondary");
                cpassword.classList.remove("is-valid");
                cpassword.classList.add("is-invalid");
            }
        });
    })
</script>
@endsection
