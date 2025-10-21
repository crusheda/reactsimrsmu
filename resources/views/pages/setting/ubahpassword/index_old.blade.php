@extends('layouts.default')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Ubah Password</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <form action="{{ route('auth.change_password') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="alert alert-dark" role="alert">
                            <h5 class="alert-heading fw-bold mb-1">Catatan</h5>
                            <span>
                                <ul>
                                    <li>Jangan berikan <strong>Password</strong> anda kepada orang lain</li>
                                    <li>Password akan diproses melalui metode <i>Bcrypt Hash Password</i> oleh sistem</li>
                                    <li>Apabila anda lupa Password akun Simrsmu, silakan masuk ke laman <b>Lupa Password</b>
                                        pada halaman Login</li>
                                </ul>
                            </span>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-12 col-sm-12 form-password-toggle">
                                <label class="form-label" for="oldPassword">Password Lama</label>
                                <div class="input-group input-group-merge">
                                    <input class="form-control" type="password" id="oldPassword" name="current_password"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                            </div>

                            <div class="mb-3 col-12 col-sm-6 form-password-toggle">
                                <label class="form-label" for="newPassword">New Password</label>
                                <div class="input-group input-group-merge">
                                    <input class="form-control" type="password" id="newPassword" name="new_password"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                            </div>

                            <div class="mb-3 col-12 col-sm-6 form-password-toggle">
                                <label class="form-label" for="confirmPassword">Confirm New Password</label>
                                <div class="input-group input-group-merge">
                                    <input class="form-control" type="password" name="new_password_confirmation"
                                        id="confirmPassword"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                            </div>
                            <div>
                                <button type="submit" value="Submit" class="btn btn-primary me-2"><i
                                        class="fas fa-save"></i>&nbsp;&nbsp;Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {

        })
    </script>
@endsection
