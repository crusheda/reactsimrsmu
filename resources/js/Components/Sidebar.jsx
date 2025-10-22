import React, { useEffect, useState } from "react";
import { Link, router, usePage } from "@inertiajs/react";

const Sidebar = () => {
    const [theme, setTheme] = useState("light");
    const { auth } = usePage().props;
    const { url } = usePage();
    const isActive = (path) => url.startsWith(path);

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

    const handleMenuSingle = (routeName) => {
        document.querySelector("html")?.setAttribute("data-toggled", "close");
        document
            .querySelector("#responsive-overlay")
            ?.classList.remove("active");
        window.ResizeMenu?.();
        return route(routeName);
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
                <a role="button" className="header-logo">
                    <img
                        src="/react/images/logo/logo_inline_text_light.png"
                        alt="logo"
                        className="desktop-logo"
                    />
                    <img
                        src="/react/images/logo/onlylogo/logo_light_verysmall.png"
                        alt="logo"
                        className="toggle-dark"
                    />
                    <img
                        src="/react/images/logo/logo_inline_text_dark.png"
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
            {/* End::main-sidebar-header */}

            {/* Start::main-sidebar */}
            <div
                className="main-sidebar simplebar-scrollable-x simplebar-scrollable-y simplebar-mouse-entered"
                id="sidebar-scroll"
                data-simplebar="init"
            >
                <nav className="main-menu-container nav nav-pills flex-column sub-open active open">
                    <div
                        className="slide-left active open d-none"
                        id="slide-left"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="#7b8191"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                        >
                            <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z" />
                        </svg>
                    </div>

                    <ul className="main-menu">
                        <li className="slide__category">
                            <span className="category-name">Publik</span>
                        </li>

                        {/* Example slide menu */}
                        <li
                            className={`slide has-sub ${
                                isActive("/dashboard") || isActive("/feedback")
                                    ? "active open"
                                    : ""
                            }`}
                        >
                            <a
                                role="button"
                                className={`side-menu__item ${
                                    isActive("/dashboard") ||
                                    isActive("/feedback")
                                        ? "active open"
                                        : ""
                                }`}
                            >
                                <i className="fas fa-home fs-5 side-menu__icon"></i>
                                <span className="side-menu__label">Publik</span>
                                <i className="ri-arrow-right-s-line side-menu__angle"></i>
                            </a>

                            <ul
                                className={`slide-menu child1 ${
                                    isActive("/dashboard") ||
                                    isActive("/feedback")
                                        ? "double-menu-active"
                                        : ""
                                }`}
                                style={{
                                    position: "relative",
                                    left: 0,
                                    top: 0,
                                    margin: 0,
                                    display:
                                        isActive("/dashboard") ||
                                        isActive("/feedback")
                                            ? "block"
                                            : "none",
                                    transform: "translate(1px, 128px)",
                                }}
                                data-popper-placement="bottom"
                            >
                                <li className="slide side-menu__label1">
                                    <a role="button">Publik</a>
                                </li>
                                <li className="slide">
                                    <a
                                        role="button"
                                        className="side-menu__item"
                                        hidden
                                    >
                                        Portal
                                    </a>
                                </li>
                                <li
                                    className={`slide ${
                                        isActive("/dashboard")
                                            ? "active open"
                                            : ""
                                    }`}
                                >
                                    <Link
                                        href={route("dashboard")}
                                        className={`side-menu__item ${
                                            isActive("/dashboard")
                                                ? "active"
                                                : ""
                                        }`}
                                    >
                                        Dashboard
                                    </Link>
                                </li>
                                <li
                                    className={`slide ${
                                        isActive("/feedback")
                                            ? "active open"
                                            : ""
                                    }`}
                                >
                                    <Link
                                        href={route("feedback")}
                                        className={`side-menu__item ${
                                            isActive("/feedback")
                                                ? "active"
                                                : ""
                                        }`}
                                    >
                                        Masukan & Saran
                                    </Link>
                                </li>
                            </ul>
                        </li>

                        {/* Contoh kategori Web Apps */}
                        <li className="slide__category">
                            <span className="category-name">SDI</span>
                        </li>

                        <li
                            className={`slide ${
                                isActive("/sdi/pegawai") ? "active open" : ""
                            }`}
                        >
                            <Link
                                href={handleMenuSingle("sdi.pegawai.index")}
                                className={`side-menu__item ${
                                    isActive("/sdi/pegawai") ? "active" : ""
                                }`}
                            >
                                <i className="fas fa-theater-masks fs-5 side-menu__icon"></i>
                                <span className="side-menu__label">
                                    Daftar Pegawai
                                </span>
                            </Link>
                        </li>

                        <li>
                            <ul className="slide-menu child1 doublemenu_slide-menu">
                                <li className="text-center p-3 text-fixed-white">
                                    <div className="doublemenu_slide-menu-background">
                                        <img
                                            src="/react/images/media/backgrounds/13.png"
                                            alt=""
                                        />
                                    </div>
                                    <div className="d-flex flex-column align-items-center justify-content-between h-100">
                                        <div className="fs-15 fw-medium">
                                            Butuh Bantuan?
                                        </div>
                                        <div>
                                            <span className="avatar avatar-lg p-1">
                                                <img
                                                    src="/react/images/media/media-80.png"
                                                    alt=""
                                                />
                                                <span className="top-right"></span>
                                                <span className="bottom-right"></span>
                                            </span>
                                        </div>
                                        <div className="d-grid w-100">
                                            <button className="btn btn-light border-0">
                                                Hubungi Kami
                                            </button>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>

                    <ul className="doublemenu_bottom-menu main-menu mb-0 border-top">
                        <li className="slide">
                            <a
                                role="button"
                                className="side-menu__item layout-setting-doublemenu"
                                onClick={toggleTheme}
                            >
                                {theme === "light" && (
                                    <span className="light-layout">
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            className="side-menu__icon"
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
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            className="side-menu__icon"
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
                                        </svg>
                                    </span>
                                )}
                                <span className="side-menu__label">
                                    Theme Settings
                                </span>
                            </a>
                        </li>

                        <li
                            className={`slide ${
                                isActive("/profil") ? "active open" : ""
                            }`}
                        >
                            <Link
                                href={route("profil.index")}
                                className={`side-menu__item p-1 rounded-circle mb-0 ${
                                    isActive("/profil") ? "active" : ""
                                }`}
                            >
                                <span className="avatar avatar-md avatar-rounded">
                                    <img
                                        src={
                                            auth?.user?.foto ||
                                            "/react/images/faces/21.jpg"
                                        }
                                        alt="Profil"
                                    />
                                </span>
                            </Link>
                        </li>
                    </ul>

                    <div className="slide-right" id="slide-right">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="#7b8191"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                        >
                            <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path>
                        </svg>
                    </div>
                </nav>
            </div>
        </aside>
    );
};

export default Sidebar;
