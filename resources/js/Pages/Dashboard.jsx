import { useEffect } from 'react';
import { Head } from '@inertiajs/react';
import introJs from 'intro.js';
import 'intro.js/introjs.css';

export default function Dashboard({ list }) {
    useEffect(() => {
        if (!list.user.nik) {
            // buka sidebar kalau perlu
            const sidebar = document.querySelector('.pc-sidebar');
            const sidebarUserLink = document.querySelector('#pc_sidebar_userlink');
            if (sidebar && sidebarUserLink) {
                sidebarUserLink.classList.add('show');
                sidebar.classList.add('mob-sidebar-active');
            }

            introJs()
                .setOptions({
                    showProgress: true,
                    steps: [
                        { intro: "<h6>Mohon mengikuti langkah berikut ini...</h6>" },
                        {
                            element: document.querySelector(".step1"),
                            intro: "Silakan melengkapi<br><b class='text-primary'>Biodata Profil Karyawan</b>"
                        },
                        {
                            element: document.querySelector(".step2"),
                            intro: "Klik tombol di atas (<u>Profil Saya</u>) untuk membuka halaman <b>Profil Karyawan</b>"
                        },
                        {
                            element: document.querySelector(".step3"),
                            intro: "Yang ini ya tombol nya :)"
                        }
                    ]
                })
                .onbeforeexit(() => confirm("Apakah Anda sudah siap?"))
                .start();
        }
    }, []);

    return (
        <>
            <Head title="Dashboard" />

            <div class="pc-container">
                <div class="pc-content">
                    <div className="row">
                        <div className="col-12">
                            <div className="card welcome-banner bg-blue-300 shadow">
                                <div className="card-body">
                                    <div className="row">
                                        <div className="col-sm-8">
                                            <div className="p-4">
                                                <h5 className="text-white">Halo, Selamat {list?.waktu}</h5>
                                                <h2 className="text-white">
                                                    {list?.user?.nama ? `${list.kelamin} ${list.user.nama}` : `${list.kelamin} ${list.user?.name}`}
                                                </h2>
                                                <p className="text-white">
                                                    Sudahkan Anda Membaca <kbd><b>Peraturan Kepegawaian</b></kbd> ?
                                                </p>
                                                <footer className="blockquote-footer font-size-12 text-white">
                                                    Ditetapkan mulai <cite title="Source Title"><strong>1 Juli 2023</strong></cite>
                                                </footer>
                                                <button
                                                    className="btn btn-light btn-shadow"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#peraturan-kepegawaian"
                                                >
                                                    Baca Selengkapnya
                                                </button>
                                            </div>
                                        </div>
                                        <div className="col-sm-4 text-center">
                                            <div className="img-welcome-banner">
                                                <img
                                                    src="/images/widget/welcome-banner.png"
                                                    alt="img"
                                                    className="img-fluid"
                                                />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {/* Modal */}
                        <div
                            id="peraturan-kepegawaian"
                            className="modal fade"
                            tabIndex="-1"
                            aria-labelledby="exampleModalCenterTitle"
                            aria-hidden="true"
                        >
                            <div className="modal-dialog modal-dialog-centered modal-xl">
                                <div className="modal-content">
                                    <div className="modal-header">
                                        <h5 className="modal-title" id="exampleModalCenterTitle">Peraturan Kepegawaian</h5>
                                        <button type="button" className="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div className="modal-body">
                                        <div className="_df_book" data-source="/doc/073_PR_PERATURAN_PERUSAHAAN_2024.pdf"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
}
