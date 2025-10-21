@extends('layouts.index')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card welcome-banner bg-blue-300 shadow">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="p-4">
                                <h5 class="text-white">Halo, Selamat {{ $list['waktu'] }}</h5>
                                <h2 class="text-white">{{ $list['user']->nama ? $list['kelamin'].' '.$list['user']->nama : $list['kelamin'].' '.$list['user']->name }}</h2>
                                <p class="text-white">Sudahkan Anda Membaca <kbd><b>Peraturan Kepegawaian</b></kbd> ?</p>
                                <footer class="blockquote-footer font-size-12 text-white">
                                    Ditetapkan mulai <cite title="Source Title"><strong>1 Juli 2023</strong></cite>
                                </footer>
                                <a href="#" class="btn btn-light btn-shadow" data-bs-toggle="modal"
                                data-bs-target="#peraturan-kepegawaian">Baca Selengkapnya</a>
                            </div>
                        </div>
                        <div class="col-sm-4 text-center">
                            <div class="img-welcome-banner">
                                <img src="{{ asset('images/widget/welcome-banner.png') }}" alt="img" class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="peraturan-kepegawaian" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Peraturan Kepegawaian</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="_df_book" source="{{ asset('doc/073_PR_PERATURAN_PERUSAHAAN_2024.pdf') }}"></div>
                    </div>
                    {{-- <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // console.log("{{ $list['user']->nik }}");
            if ("{{ $list['user']->nik }}" == '') {
                $('#pc_sidebar_userlink').addClass('show');
                $('.pc-sidebar').addClass('mob-sidebar-active');
                introJs().setOptions({
                    showProgress: true,
                    steps: [{
                        intro: "<h6>Mohon mengikuti langkah berikut ini...</h6>"
                    }, {
                        element: document.querySelector(".step1"),
                        intro: "Silakan melengkapi<br><b class='text-primary'>Biodata Profil Karyawan</b>"
                    }, {
                        element: document.querySelector(".step2"),
                        intro: "Klik tombol di atas (<u>Profil Saya</u>) untuk membuka halaman <b>Profil Karyawan</b>"
                    }, {
                        element: document.querySelector(".step3"),
                        intro: "Yang ini ya tombol nya :)</b>"
                    }]
                }).onbeforeexit(function () {
                    return confirm("Apakah Anda sudah siap?")
                }).start();
            }
        });
    </script>
@endsection
