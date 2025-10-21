import React, { useEffect, useState } from "react";
import { router, usePage  } from '@inertiajs/react';

const Sidebar = () => {
    const [theme, setTheme] = useState("light");
    const { auth } = usePage().props;

    // Load theme dari localStorage saat mount
    useEffect(() => {
        const savedTheme = localStorage.getItem("theme") || "light";
        setTheme(savedTheme);
        updateHtmlAttributes(savedTheme);
    }, []);

    const updateHtmlAttributes = (theme) => {
        const html = document.documentElement;
        if (theme === "dark") {
            html.setAttribute("data-theme-mode", "dark");
            html.setAttribute("data-menu-styles", "dark");
        } else {
            html.setAttribute("data-theme-mode", "light");
            html.setAttribute("data-menu-styles", "transparent");
        }
    };

    const toggleTheme = () => {
        const newTheme = theme === "light" ? "dark" : "light";
        setTheme(newTheme);
        localStorage.setItem("theme", newTheme);
        updateHtmlAttributes(newTheme);
    };

    return (
        <aside className="app-sidebar sticky sticky-pin" id="sidebar">
            {/* Start::main-sidebar-header */}
            <div className="main-sidebar-header">
                <a href="index.html" className="header-logo">
                    <img src="/react/images/brand-logos/desktop-logo.png" alt="logo" className="desktop-logo" />
                    <img src="/react/images/brand-logos/toggle-dark.png" alt="logo" className="toggle-dark" />
                    <img src="/react/images/brand-logos/desktop-dark.png" alt="logo" className="desktop-dark" />
                    <img src="/react/images/brand-logos/toggle-logo.png" alt="logo" className="toggle-logo" />
                </a>
            </div>
            {/* End::main-sidebar-header */}

            {/* Start::main-sidebar */}
            <div className="main-sidebar simplebar-scrollable-x simplebar-scrollable-y simplebar-mouse-entered" id="sidebar-scroll" data-simplebar="init">
                <nav className="main-menu-container nav nav-pills flex-column sub-open active open">
                    <div className="slide-left active open d-none" id="slide-left">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
                            <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z" />
                        </svg>
                    </div>

                    <ul className="main-menu">
                        <li className="slide__category">
                            <span className="category-name">Main</span>
                        </li>

                        {/* Example slide menu */}
                        <li className="slide has-sub active open">
                            <a role='button' className="side-menu__item active open">
                                <svg xmlns="http://www.w3.org/2000/svg" className="side-menu__icon" viewBox="0 0 256 256">
                                    <rect width="256" height="256" fill="none" />
                                    <path d="M133.66,34.34a8,8,0,0,0-11.32,0L40,116.69V216h64V152h48v64h64V116.69Z" opacity="0.2" />
                                    <line x1="16" y1="216" x2="240" y2="216" fill="none" stroke="currentColor" strokeLinecap="round" strokeLinejoin="round" strokeWidth="16" />
                                    <polyline points="152 216 152 152 104 152 104 216" fill="none" stroke="currentColor" strokeLinecap="round" strokeLinejoin="round" strokeWidth="16" />
                                    <line x1="40" y1="116.69" x2="40" y2="216" fill="none" stroke="currentColor" strokeLinecap="round" strokeLinejoin="round" strokeWidth="16" />
                                    <line x1="216" y1="216" x2="216" y2="116.69" fill="none" stroke="currentColor" strokeLinecap="round" strokeLinejoin="round" strokeWidth="16" />
                                    <path d="M24,132.69l98.34-98.35a8,8,0,0,1,11.32,0L232,132.69" fill="none" stroke="currentColor" strokeLinecap="round" strokeLinejoin="round" strokeWidth="16" />
                                </svg>
                                <span className="side-menu__label">Dashboard</span>
                                <i className="ri-arrow-right-s-line side-menu__angle"></i>
                            </a>

                            <ul
                                className="slide-menu child1 double-menu-active"
                                style={{ position: "relative", left: 0, top: 0, margin: 0, display: "block", transform: "translate(1px, 128px)" }}
                                data-popper-placement="bottom" data-popper-reference-hidden="" data-popper-escaped=""
                            >
                                <li className="slide side-menu__label1">
                                    <a role='button'>Dashboard</a>
                                </li>
                                <li className="slide active open">
                                    <a href="" className="side-menu__item active">
                                        Sales
                                    </a>
                                </li>
                                <li className="slide">
                                    <a href="index-12.html" className="side-menu__item">
                                        POS System
                                    </a>
                                </li>
                            </ul>
                        </li>

                        {/* Contoh kategori Web Apps */}
                        <li className="slide__category">
                            <span className="category-name">Web Apps</span>
                        </li>
                        <li>
                            <ul className="slide-menu child1 doublemenu_slide-menu">
                                <li className="text-center p-3 text-fixed-white">
                                    <div className="doublemenu_slide-menu-background">
                                        <img src="/react/images/media/backgrounds/13.png" alt="" />
                                    </div>
                                    <div className="d-flex flex-column align-items-center justify-content-between h-100">
                                        <div className="fs-15 fw-medium">Dashboard AI Helper</div>
                                        <div>
                                            <span className="avatar avatar-lg p-1">
                                                <img src="/react/images/media/media-80.png" alt="" />
                                                <span className="top-right"></span>
                                                <span className="bottom-right"></span>
                                            </span>
                                        </div>
                                        <div className="d-grid w-100">
                                            <button className="btn btn-light border-0">Try Now</button>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <ul className="doublemenu_bottom-menu main-menu mb-0 border-top">
                        {/* Start::slide */}
                        <li className="slide">
                            <a
                                role="button"
                                className="side-menu__item layout-setting-doublemenu"
                                onClick={toggleTheme}
                            >
                                {/* Tampilkan ikon sesuai theme */}
                                {theme === "light" && (
                                    <span className="light-layout">
                                        {/* Light mode SVG */}
                                        <svg xmlns="http://www.w3.org/2000/svg" className="side-menu__icon" viewBox="0 0 256 256">
                                            <rect width="256" height="256" fill="none" />
                                            <path d="M108.11,28.11A96.09,96.09,0,0,0,227.89,147.89,96,96,0,1,1,108.11,28.11Z" opacity="0.2"></path>
                                            <path d="M108.11,28.11A96.09,96.09,0,0,0,227.89,147.89,96,96,0,1,1,108.11,28.11Z" fill="none" stroke="currentColor" strokeLinecap="round" strokeLinejoin="round" strokeWidth="16"></path>
                                        </svg>
                                    </span>
                                )}
                                {theme === "dark" && (
                                    <span className="dark-layout">
                                        {/* Dark mode SVG */}
                                        <svg xmlns="http://www.w3.org/2000/svg" className="side-menu__icon" viewBox="0 0 256 256">
                                            <rect width="256" height="256" fill="none" />
                                            <circle cx="128" cy="128" r="56" opacity="0.2"></circle>
                                            <line x1="128" y1="40" x2="128" y2="32" fill="none" stroke="currentColor" strokeLinecap="round" strokeLinejoin="round" strokeWidth="16"></line>
                                            <circle cx="128" cy="128" r="56" fill="none" stroke="currentColor" strokeLinecap="round" strokeLinejoin="round" strokeWidth="16"></circle>
                                            {/* ... sisa SVG */}
                                        </svg>
                                    </span>
                                )}
                                <span className="side-menu__label">Theme Settings</span>
                            </a>
                        </li>

                        {/* Start::slide */}
                        {/* <li className="slide">
                            <a href="sign-in-cover.html" className="side-menu__item">
                                <svg xmlns="http://www.w3.org/2000/svg" className="side-menu__icon" viewBox="0 0 256 256">
                                    <rect width="256" height="256" fill="none"></rect>
                                    <path d="M48,40H208a16,16,0,0,1,16,16V200a16,16,0,0,1-16,16H48a0,0,0,0,1,0,0V40A0,0,0,0,1,48,40Z" opacity="0.2"></path>
                                    <polyline points="112 40 48 40 48 216 112 216" fill="none" stroke="currentColor" strokeLinecap="round" strokeLinejoin="round" strokeWidth="16"></polyline>
                                    <line x1="112" y1="128" x2="224" y2="128" fill="none" stroke="currentColor" strokeLinecap="round" strokeLinejoin="round" strokeWidth="16"></line>
                                    <polyline points="184 88 224 128 184 168" fill="none" stroke="currentColor" strokeLinecap="round" strokeLinejoin="round" strokeWidth="16"></polyline>
                                </svg>
                                <span className="side-menu__label">Logout</span>
                            </a>
                        </li> */}

                        {/* Start::slide */}
                        {/* <li className="slide">
                            <a href="profile-settings.html" className="side-menu__item">
                                <svg xmlns="http://www.w3.org/2000/svg" className="side-menu__icon" viewBox="0 0 256 256">
                                    <rect width="256" height="256" fill="none"></rect>
                                    <path d="M205.31,71.08a16,16,0,0,1-20.39-20.39A96,96,0,0,0,63.8,199.38h0A72,72,0,0,1,128,160a40,40,0,1,1,40-40,40,40,0,0,1-40,40,72,72,0,0,1,64.2,39.37A96,96,0,0,0,205.31,71.08Z" opacity="0.2"></path>
                                    <line x1="200" y1="40" x2="200" y2="28" fill="none" stroke="currentColor" strokeLinecap="round" strokeLinejoin="round" strokeWidth="16"></line>
                                    <circle cx="200" cy="56" r="16" fill="none" stroke="currentColor" strokeLinecap="round" strokeLinejoin="round" strokeWidth="16"></circle>
                                    <line x1="186.14" y1="48" x2="175.75" y2="42" fill="none" stroke="currentColor" strokeLinecap="round" strokeLinejoin="round" strokeWidth="16"></line>
                                    <line x1="186.14" y1="64" x2="175.75" y2="70" fill="none" stroke="currentColor" strokeLinecap="round" strokeLinejoin="round" strokeWidth="16"></line>
                                    <line x1="200" y1="72" x2="200" y2="84" fill="none" stroke="currentColor" strokeLinecap="round" strokeLinejoin="round" strokeWidth="16"></line>
                                    <line x1="213.86" y1="64" x2="224.25" y2="70" fill="none" stroke="currentColor" strokeLinecap="round" strokeLinejoin="round" strokeWidth="16"></line>
                                    <line x1="213.86" y1="48" x2="224.25" y2="42" fill="none" stroke="currentColor" strokeLinecap="round" strokeLinejoin="round" strokeWidth="16"></line>
                                    <circle cx="128" cy="120" r="40" fill="none" stroke="currentColor" strokeLinecap="round" strokeLinejoin="round" strokeWidth="16"></circle>
                                    <path d="M63.8,199.37a72,72,0,0,1,128.4,0" fill="none" stroke="currentColor" strokeLinecap="round" strokeLinejoin="round" strokeWidth="16"></path>
                                    <path d="M222.67,112A95.92,95.92,0,1,1,144,33.33" fill="none" stroke="currentColor" strokeLinecap="round" strokeLinejoin="round" strokeWidth="16"></path>
                                </svg>
                                <span className="side-menu__label">Profile Settings</span>
                            </a>
                        </li> */}

                        {/* Start::slide */}
                        <li className="slide">
                            <a href="profile.html" className="side-menu__item p-1 rounded-circle mb-0">
                                <span className="avatar avatar-md avatar-rounded">
                                    <img
                                        src={auth?.user?.foto || '/react/images/faces/21.jpg'}
                                        alt="Profil"
                                    />
                                </span>
                            </a>
                        </li>
                    </ul>

                    <div className="slide-right" id="slide-right">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
                            <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path>
                        </svg>
                    </div>
                </nav>
            </div>
        </aside>
    );
};

export default Sidebar;
