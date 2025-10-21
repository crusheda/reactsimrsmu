import React from "react";

export default function Sidebar({ list }) {
    const waktu = list?.waktu ?? '';
    const user = list?.user ?? {};
    const foto_user = list?.foto_user ?? {};

    return (
        <nav className="pc-sidebar">
            <div className="navbar-wrapper">
                <div className="m-header">
                    <a href="javascript:void(0);" className="b-brand text-primary">
                        <img
                            id="app-logo"
                            src="/images/logo/logo_new_simrsmu_black.png"
                            alt="logo"
                            className="img-fluid"
                            width="150px"
                        />
                        <span className="badge bg-light-primary rounded-pill ms-2 theme-version">v3.1</span>
                    </a>
                </div>

                <div className="navbar-content">
                    <div className="card pc-user-card step1">
                        <div className="card-body">
                            <div className="d-flex align-items-center">
                                <div className="flex-shrink-0">
                                    <img
                                        src={foto_user?.filename ? `/storage/${foto_user.filename.substring(7)}` : '/images/pku/user.png'}
                                        alt="Header Avatar"
                                        className="user-avtar wid-45 rounded-circle"
                                        style={{ width: "45px", height: "45px" }}
                                    />
                                </div>
                                <div className="flex-grow-1 ms-3 me-2">
                                    <small>Selamat {waktu},</small>
                                    <h6 className="mb-0">
                                        <a className="text-primary">{user?.nick ?? user?.name}</a>
                                    </h6>
                                </div>
                                <a className="btn btn-icon btn-link-secondary avtar" data-bs-toggle="collapse" href="#pc_sidebar_userlink">
                                    <svg className="pc-icon">
                                        <use xlinkHref="#custom-sort-outline"></use>
                                    </svg>
                                </a>
                            </div>

                            <div className="collapse pc-user-links" id="pc_sidebar_userlink">
                                <div className="pt-3">
                                    <a href="/profil" className="step2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"
                                            className="icon icon-tabler icons-tabler-outline icon-tabler-user me-2">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                                            <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                        </svg>
                                        <span className="step3">Profil Saya</span>
                                    </a>
                                    <a className="button" href="#" onClick={(e) => { e.preventDefault(); document.getElementById('logoutform').submit(); }}>
                                        <i className="ti ti-power"></i> Logout
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    {/* Jika kamu punya include Blade lain (nwsidebar), buat sebagai component React juga */}
                    {/* <NWSidebar /> */}
                </div>
            </div>
        </nav>
    );
}
