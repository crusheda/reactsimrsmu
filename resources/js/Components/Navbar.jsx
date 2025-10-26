import React, { useEffect, useState } from "react";
import { router, usePage } from "@inertiajs/react";
import { Link } from "@inertiajs/react";

export default function Navbar() {
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

    const logout = () => {
        router.post(route("logout"), {
            onSuccess: () => {
                router.visit(route("v4.login"), {
                    replace: true,
                    preserveState: false,
                });
            },
        });
    };

    return (
        <header className="app-header sticky" id="header">
            <div className="main-header-container container-fluid">
                <div className="header-content-left">
                    <div className="header-element">
                        <div className="horizontal-logo">
                            <a role="button" className="header-logo">
                                <img
                                    src="/react/images/logo/onlylogo/logo_light_verysmall.png"
                                    alt="logo"
                                    className="desktop-logo"
                                />
                                <img
                                    src="/react/images/logo/onlylogo/logo_dark_verysmall.png"
                                    alt="logo"
                                    className="toggle-dark"
                                />
                                <img
                                    src="/react/images/logo/onlylogo/logo_dark_verysmall.png"
                                    alt="logo"
                                    className="desktop-dark"
                                />
                                <img
                                    src="/react/images/logo/onlylogo/logo_light_verysmall.png"
                                    alt="logo"
                                    className="toggle-logo"
                                />
                            </a>
                        </div>
                    </div>
                    <div className="header-element mx-lg-0 mx-2">
                        <a
                            aria-label="Hide Sidebar"
                            className="sidemenu-toggle header-link animated-arrow hor-toggle horizontal-navtoggle"
                            role="button"
                            onClick={() => window.toggleSidemenu?.()} // panggil fungsi global dari defaultmenu.js
                        >
                            <span></span>
                        </a>
                    </div>
                    <div className="header-element header-search header-search-content d-md-block d-none">
                        <input
                            type="text"
                            className="header-search-bar form-control bg-white"
                            id="header-search"
                            placeholder="Search"
                            spellCheck="false"
                            autoComplete="off"
                            autoCapitalize="off"
                            disabled={true}
                        />
                        <a
                            role="button"
                            className="header-search-icon border-0"
                        >
                            <i className="bi bi-search fs-12 mb-1"></i>
                        </a>
                    </div>
                </div>

                <ul className="header-content-right">
                    {/* Theme Mode */}
                    <li className="header-element header-theme-mode">
                        <a
                            role="button"
                            className="header-link layout-setting"
                            onClick={toggleTheme}
                        >
                            {/* Tampilkan ikon sesuai theme */}
                            {theme === "light" && (
                                <span className="light-layout">
                                    {/* Light mode SVG */}
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        className="header-link-icon"
                                        viewBox="0 0 256 256"
                                    >
                                        <rect
                                            width="256"
                                            height="256"
                                            fill="none"
                                        />
                                        <path
                                            d="M108.11,28.11A96.09,96.09,0,0,0,227.89,147.89,96,96,0,1,1,108.11,28.11Z"
                                            opacity="0.2"
                                        ></path>
                                        <path
                                            d="M108.11,28.11A96.09,96.09,0,0,0,227.89,147.89,96,96,0,1,1,108.11,28.11Z"
                                            fill="none"
                                            stroke="currentColor"
                                            strokeLinecap="round"
                                            strokeLinejoin="round"
                                            strokeWidth="16"
                                        ></path>
                                    </svg>
                                </span>
                            )}
                            {theme === "dark" && (
                                <span className="dark-layout">
                                    {/* Dark mode SVG */}
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        className="header-link-icon"
                                        viewBox="0 0 256 256"
                                    >
                                        <rect
                                            width="256"
                                            height="256"
                                            fill="none"
                                        />
                                        <circle
                                            cx="128"
                                            cy="128"
                                            r="56"
                                            opacity="0.2"
                                        ></circle>
                                        <line
                                            x1="128"
                                            y1="40"
                                            x2="128"
                                            y2="32"
                                            fill="none"
                                            stroke="currentColor"
                                            strokeLinecap="round"
                                            strokeLinejoin="round"
                                            strokeWidth="16"
                                        ></line>
                                        <circle
                                            cx="128"
                                            cy="128"
                                            r="56"
                                            fill="none"
                                            stroke="currentColor"
                                            strokeLinecap="round"
                                            strokeLinejoin="round"
                                            strokeWidth="16"
                                        ></circle>
                                        {/* ... sisa SVG */}
                                    </svg>
                                </span>
                            )}
                        </a>
                    </li>

                    {/* Notifications */}
                    <li className="header-element notifications-dropdown dropdown d-xl-block d-none">
                        <a
                            role="button"
                            className="header-link dropdown-toggle"
                            data-bs-toggle="dropdown"
                            data-bs-auto-close="outside"
                            aria-expanded="false"
                            id="messageDropdown"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                className="header-link-icon"
                                viewBox="0 0 256 256"
                            >
                                <rect
                                    width="256"
                                    height="256"
                                    fill="none"
                                ></rect>
                                <path
                                    d="M56,104a72,72,0,0,1,144,0c0,35.82,8.3,64.6,14.9,76A8,8,0,0,1,208,192H48a8,8,0,0,1-6.88-12C47.71,168.6,56,139.81,56,104Z"
                                    opacity="0.2"
                                ></path>
                                <path
                                    d="M96,192a32,32,0,0,0,64,0"
                                    fill="none"
                                    stroke="currentColor"
                                    strokeLinecap="round"
                                    strokeLinejoin="round"
                                    strokeWidth="16"
                                ></path>
                                <path
                                    d="M56,104a72,72,0,0,1,144,0c0,35.82,8.3,64.6,14.9,76A8,8,0,0,1,208,192H48a8,8,0,0,1-6.88-12C47.71,168.6,56,139.81,56,104Z"
                                    fill="none"
                                    stroke="currentColor"
                                    strokeLinecap="round"
                                    strokeLinejoin="round"
                                    strokeWidth="16"
                                ></path>
                            </svg>
                            {/* <span className="header-icon-pulse bg-secondary rounded pulse pulse-secondary"></span> */}
                        </a>
                        <div className="main-header-dropdown dropdown-menu dropdown-menu-end" hidden>
                            <div className="p-3 bg-primary text-fixed-white d-flex justify-content-between">
                                <p className="mb-0 fs-16">Notifications</p>
                                <a
                                    role="button"
                                    className="badge bg-light text-default border"
                                >
                                    Clear All
                                </a>
                            </div>
                            <div className="dropdown-divider"></div>
                            <ul className="list-unstyled mb-0">
                                <li className="dropdown-item">
                                    New Message from John
                                </li>
                                <li className="dropdown-item">
                                    Task Reminder: Submit report
                                </li>
                                <li className="dropdown-item">
                                    Friend Request from Jane
                                </li>
                                <li className="dropdown-item">
                                    Event Reminder: Team Meeting
                                </li>
                            </ul>
                        </div>
                    </li>

                    {/* Fullscreen */}
                    <li className="header-element header-fullscreen">
                        <a
                            role="button"
                            className="header-link"
                            onClick={() => {
                                const elem = document.documentElement;
                                if (!document.fullscreenElement)
                                    elem.requestFullscreen();
                                else document.exitFullscreen();
                            }}
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                className="full-screen-open header-link-icon"
                                viewBox="0 0 256 256"
                            >
                                <rect
                                    width="256"
                                    height="256"
                                    fill="none"
                                ></rect>
                                <rect
                                    x="48"
                                    y="48"
                                    width="160"
                                    height="160"
                                    opacity="0.2"
                                ></rect>
                                <polyline
                                    points="168 48 208 48 208 88"
                                    fill="none"
                                    stroke="currentColor"
                                    strokeLinecap="round"
                                    strokeLinejoin="round"
                                    strokeWidth="16"
                                ></polyline>
                                <polyline
                                    points="88 208 48 208 48 168"
                                    fill="none"
                                    stroke="currentColor"
                                    strokeLinecap="round"
                                    strokeLinejoin="round"
                                    strokeWidth="16"
                                ></polyline>
                                <polyline
                                    points="208 168 208 208 168 208"
                                    fill="none"
                                    stroke="currentColor"
                                    strokeLinecap="round"
                                    strokeLinejoin="round"
                                    strokeWidth="16"
                                ></polyline>
                                <polyline
                                    points="48 88 48 48 88 48"
                                    fill="none"
                                    stroke="currentColor"
                                    strokeLinecap="round"
                                    strokeLinejoin="round"
                                    strokeWidth="16"
                                ></polyline>
                            </svg>
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                className="full-screen-close header-link-icon d-none"
                                viewBox="0 0 256 256"
                            >
                                <rect
                                    width="256"
                                    height="256"
                                    fill="none"
                                ></rect>
                                <rect
                                    x="32"
                                    y="32"
                                    width="192"
                                    height="192"
                                    rx="16"
                                    opacity="0.2"
                                ></rect>
                                <polyline
                                    points="160 48 208 48 208 96"
                                    fill="none"
                                    stroke="currentColor"
                                    strokeLinecap="round"
                                    strokeLinejoin="round"
                                    strokeWidth="16"
                                ></polyline>
                                <line
                                    x1="144"
                                    y1="112"
                                    x2="208"
                                    y2="48"
                                    fill="none"
                                    stroke="currentColor"
                                    strokeLinecap="round"
                                    strokeLinejoin="round"
                                    strokeWidth="16"
                                ></line>
                                <polyline
                                    points="96 208 48 208 48 160"
                                    fill="none"
                                    stroke="currentColor"
                                    strokeLinecap="round"
                                    strokeLinejoin="round"
                                    strokeWidth="16"
                                ></polyline>
                                <line
                                    x1="112"
                                    y1="144"
                                    x2="48"
                                    y2="208"
                                    fill="none"
                                    stroke="currentColor"
                                    strokeLinecap="round"
                                    strokeLinejoin="round"
                                    strokeWidth="16"
                                ></line>
                            </svg>
                        </a>
                    </li>

                    {/* Profile */}
                    <li className="header-element dropdown">
                        <a
                            role="button"
                            className="header-link dropdown-toggle"
                            data-bs-toggle="dropdown"
                            // data-bs-auto-close="inside"
                            aria-expanded="false"
                        >
                            <img
                                src={
                                    auth?.user?.foto ||
                                    "/react/images/faces/21.jpg"
                                }
                                alt="Profil"
                                className="header-link-icon"
                            />
                        </a>
                        <div className="main-header-dropdown dropdown-menu dropdown-menu-end">
                            <div className="p-3 bg-primary text-fixed-white">
                                <p className="mb-0 fs-16">Profil Saya</p>
                            </div>
                            <div className="dropdown-divider"></div>
                            <div className="p-3">
                                <div className="d-flex align-items-start gap-2">
                                    <div className="lh-1">
                                        <span className="avatar avatar-sm bg-primary-transparent avatar-rounded">
                                            <img
                                                src={
                                                    auth?.user?.foto ||
                                                    "/react/images/faces/21.jpg"
                                                }
                                                alt="Profil"
                                            />
                                        </span>
                                    </div>
                                    <div>
                                        <span className="d-block fw-semibold lh-1">
                                            {auth?.user?.nama ||
                                                auth?.user?.name}
                                        </span>
                                        <span className="text-muted fs-12">
                                            {auth?.user?.email ||
                                                "Tidak Ada Email"}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div className="dropdown-divider"></div>
                            <ul className="list-unstyled mb-0">
                                <li>
                                    <Link
                                        href={route("v4.profil.index")}
                                        className="dropdown-item"
                                        as="button"
                                    >
                                        Lihat Profil
                                    </Link>
                                </li>
                                <li>
                                    <a
                                        className="dropdown-item"
                                        role="button"
                                        onClick={logout}
                                    >
                                        Log Out
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li className="header-element">
                        <a
                            role="button"
                            className="header-link switcher-icon"
                            data-bs-toggle="offcanvas"
                            data-bs-target="#switcher-canvas"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                className="header-link-icon"
                                viewBox="0 0 256 256"
                            >
                                <rect
                                    width="256"
                                    height="256"
                                    fill="none"
                                ></rect>
                                <path
                                    d="M207.86,123.18l16.78-21a99.14,99.14,0,0,0-10.07-24.29l-26.7-3a81,81,0,0,0-6.81-6.81l-3-26.71a99.43,99.43,0,0,0-24.3-10l-21,16.77a81.59,81.59,0,0,0-9.64,0l-21-16.78A99.14,99.14,0,0,0,77.91,41.43l-3,26.7a81,81,0,0,0-6.81,6.81l-26.71,3a99.43,99.43,0,0,0-10,24.3l16.77,21a81.59,81.59,0,0,0,0,9.64l-16.78,21a99.14,99.14,0,0,0,10.07,24.29l26.7,3a81,81,0,0,0,6.81,6.81l3,26.71a99.43,99.43,0,0,0,24.3,10l21-16.77a81.59,81.59,0,0,0,9.64,0l21,16.78a99.14,99.14,0,0,0,24.29-10.07l3-26.7a81,81,0,0,0,6.81-6.81l26.71-3a99.43,99.43,0,0,0,10-24.3l-16.77-21A81.59,81.59,0,0,0,207.86,123.18ZM128,168a40,40,0,1,1,40-40A40,40,0,0,1,128,168Z"
                                    opacity="0.2"
                                ></path>
                                <circle
                                    cx="128"
                                    cy="128"
                                    r="40"
                                    fill="none"
                                    stroke="currentColor"
                                    strokeLinecap="round"
                                    strokeLinejoin="round"
                                    strokeWidth="16"
                                ></circle>
                                <path
                                    d="M41.43,178.09A99.14,99.14,0,0,1,31.36,153.8l16.78-21a81.59,81.59,0,0,1,0-9.64l-16.77-21a99.43,99.43,0,0,1,10.05-24.3l26.71-3a81,81,0,0,1,6.81-6.81l3-26.7A99.14,99.14,0,0,1,102.2,31.36l21,16.78a81.59,81.59,0,0,1,9.64,0l21-16.77a99.43,99.43,0,0,1,24.3,10.05l3,26.71a81,81,0,0,1,6.81,6.81l26.7,3a99.14,99.14,0,0,1,10.07,24.29l-16.78,21a81.59,81.59,0,0,1,0,9.64l16.77,21a99.43,99.43,0,0,1-10,24.3l-26.71,3a81,81,0,0,1-6.81,6.81l-3,26.7a99.14,99.14,0,0,1-24.29,10.07l-21-16.78a81.59,81.59,0,0,1-9.64,0l-21,16.77a99.43,99.43,0,0,1-24.3-10l-3-26.71a81,81,0,0,1-6.81-6.81Z"
                                    fill="none"
                                    stroke="currentColor"
                                    strokeLinecap="round"
                                    strokeLinejoin="round"
                                    strokeWidth="16"
                                ></path>
                            </svg>
                        </a>
                    </li>
                </ul>
            </div>
        </header>
    );
}
