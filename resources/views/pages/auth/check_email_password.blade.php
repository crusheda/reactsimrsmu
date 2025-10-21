@extends('layouts.auth2')

@section('content')
<div class="auth-main">
    <div class="auth-wrapper v1">
        <div class="auth-form">
            <div class="card my-5">
                <div class="card-body">
                    <a href="#"><img src="{{ asset('images/logo/logo_simrsmu_new_kop_31.png') }}" height="50" class="mb-4 img-fluid" alt="img"></a>
                    <div class="mb-4">
                        <h3 class="mb-2"><b>Hai, Periksa E-Mail Anda</b></h3>
                        <p class="text-muted"><mark>Admin</mark> telah mengirimkan email untuk mengembalikan password akun Anda. Langkah recovery password terdapat pada email.</p>
                    </div>
                    <div class="d-grid mt-3"><button type="button" onclick="window.location='{{ route('auth.login') }}'" class="btn btn-primary">Lanjutkan Sign in</button></div>
                    <div class="saprator mt-3"><span>Buka Aplikasi Email</span></div>
                    <div class="row g-2">
                        <div class="col-12">
                            <div class="d-grid"><a href="https://mail.google.com" target="_blank"
                                    class="btn mt-2 btn-light-primary bg-light text-muted"><img
                                        src="{{ asset('images/authentication/google.svg') }}" alt="img"> <span
                                        class="d-none d-sm-inline-block">Google Mail</span></a></div>
                        </div>
                        {{-- <div class="col-4">
                            <div class="d-grid"><button type="button"
                                    class="btn mt-2 btn-light-primary bg-light text-muted"><img
                                        src="{{ asset('images/authentication/twitter.svg') }}" alt="img"> <span
                                        class="d-none d-sm-inline-block">Yahoo</span></button></div>
                        </div>
                        <div class="col-4">
                            <div class="d-grid"><button type="button"
                                    class="btn mt-2 btn-light-primary bg-light text-muted"><img
                                        src="{{ asset('images/authentication/facebook.svg') }}" alt="img"> <span
                                        class="d-none d-sm-inline-block">Outlook</span></button></div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- [ Main Content ] end --><!-- Required Js -->
@endsection
