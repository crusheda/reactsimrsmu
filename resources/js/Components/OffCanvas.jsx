import React, { useEffect, useState } from "react";

const OffCanvas = () => {
    const [theme, setTheme] = useState("light");

    // load theme dari localStorage atau default
    useEffect(() => {
        const savedTheme = localStorage.getItem("theme") || "light";
        setTheme(savedTheme);
        updateHtmlAttributes(savedTheme);
    }, []);

    // handler perubahan theme
    const handleThemeChange = (e) => {
        const value = e.target.value;
        setTheme(value);
        localStorage.setItem("theme", value);
        updateHtmlAttributes(value);
    };

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

    return (
        <>
            {/* Start Switcher */}
            <div
                className="offcanvas offcanvas-end"
                tabIndex={-1}
                id="switcher-canvas"
                aria-labelledby="offcanvasRightLabel"
            >
                <div className="offcanvas-header border-bottom d-block p-0">
                    <div className="d-flex align-items-center justify-content-between p-3">
                        <h5 className="offcanvas-title text-default" id="offcanvasRightLabel">
                            Switcher
                        </h5>
                        <button
                            type="button"
                            className="btn-close"
                            data-bs-dismiss="offcanvas"
                            aria-label="Close"
                        ></button>
                    </div>

                    <nav className="border-top border-block-start-dashed">
                        <div
                            className="nav nav-tabs nav-justified"
                            id="switcher-main-tab"
                            role="tablist"
                        >
                            <button
                                className="nav-link active"
                                id="switcher-home-tab"
                                data-bs-toggle="tab"
                                data-bs-target="#switcher-home"
                                type="button"
                                role="tab"
                                aria-controls="switcher-home"
                                aria-selected="true"
                            >
                                Theme Styles
                            </button>
                            <button
                                className="nav-link"
                                id="switcher-profile-tab"
                                data-bs-toggle="tab"
                                data-bs-target="#switcher-profile"
                                type="button"
                                role="tab"
                                aria-controls="switcher-profile"
                                aria-selected="false"
                                tabIndex={-1}
                            >
                                Theme Colors
                            </button>
                        </div>
                    </nav>
                </div>

                <div className="offcanvas-body">
                    <div className="tab-content" id="nav-tabContent">
                        {/* Tab 1: Theme Styles */}
                        <div
                            className="tab-pane fade show active border-0"
                            id="switcher-home"
                            role="tabpanel"
                            aria-labelledby="switcher-home-tab"
                            tabIndex={0}
                        >
                            {/* Theme Color Mode */}
                            <div>
                                <p className="switcher-style-head">Theme Color Mode:</p>
                                <div className="row switcher-style gx-0">
                                    <div className="col-4">
                                        <div className="form-check switch-select">
                                            <input
                                                className="form-check-input"
                                                type="radio"
                                                name="theme-style"
                                                id="switcher-light-theme"
                                                value="light"
                                                checked={theme === "light"}
                                                onChange={handleThemeChange}
                                            />
                                            <label
                                                className="form-check-label"
                                                htmlFor="switcher-light-theme"
                                            >
                                                Light
                                            </label>
                                        </div>
                                    </div>
                                    <div className="col-4">
                                        <div className="form-check switch-select">
                                            <input
                                                className="form-check-input"
                                                type="radio"
                                                name="theme-style"
                                                id="switcher-dark-theme"
                                                value="dark"
                                                checked={theme === "dark"}
                                                onChange={handleThemeChange}
                                            />
                                            <label
                                                className="form-check-label"
                                                htmlFor="switcher-dark-theme"
                                            >
                                                Dark
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {/* Directions */}
                            <div>
                                <p className="switcher-style-head">Directions:</p>
                                <div className="row switcher-style gx-0">
                                    <div className="col-4">
                                        <div className="form-check switch-select">
                                            <input
                                                className="form-check-input"
                                                type="radio"
                                                name="direction"
                                                id="switcher-ltr"
                                                defaultChecked
                                            />
                                            <label className="form-check-label" htmlFor="switcher-ltr">
                                                LTR
                                            </label>
                                        </div>
                                    </div>
                                    <div className="col-4">
                                        <div className="form-check switch-select">
                                            <input
                                                className="form-check-input"
                                                type="radio"
                                                name="direction"
                                                id="switcher-rtl"
                                            />
                                            <label className="form-check-label" htmlFor="switcher-rtl">
                                                RTL
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {/* Navigation Styles */}
                            <div>
                                <p className="switcher-style-head">Navigation Styles:</p>
                                <div className="row switcher-style gx-0">
                                    <div className="col-4">
                                        <div className="form-check switch-select">
                                            <input
                                                className="form-check-input"
                                                type="radio"
                                                name="navigation-style"
                                                id="switcher-vertical"
                                                defaultChecked
                                            />
                                            <label className="form-check-label" htmlFor="switcher-vertical">
                                                Vertical
                                            </label>
                                        </div>
                                    </div>
                                    <div className="col-4">
                                        <div className="form-check switch-select">
                                            <input
                                                className="form-check-input"
                                                type="radio"
                                                name="navigation-style"
                                                id="switcher-horizontal"
                                            />
                                            <label className="form-check-label" htmlFor="switcher-horizontal">
                                                Horizontal
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {/* Navigation Menu Styles */}
                            <div className="navigation-menu-styles">
                                <p className="switcher-style-head">Vertical & Horizontal Menu Styles:</p>
                                <div className="row switcher-style gx-0 pb-2 gy-2">
                                    {['menu-click', 'menu-hover', 'icon-click', 'icon-hover'].map((item, idx) => (
                                        <div className="col-4" key={idx}>
                                            <div className="form-check switch-select">
                                                <input
                                                    className="form-check-input"
                                                    type="radio"
                                                    name="navigation-menu-styles"
                                                    id={`switcher-${item}`}
                                                    defaultChecked={item === 'menu-click'}
                                                />
                                                <label className="form-check-label" htmlFor={`switcher-${item}`}>
                                                    {item.replace('-', ' ').replace(/\b\w/g, l => l.toUpperCase())}
                                                </label>
                                            </div>
                                        </div>
                                    ))}
                                </div>
                            </div>

                            {/* Sidemenu Layout Styles */}
                            <div className="sidemenu-layout-styles">
                                <p className="switcher-style-head">Sidemenu Layout Styles:</p>
                                <div className="row switcher-style gx-0 pb-2 gy-2">
                                    {[
                                        'default-menu',
                                        'closed-menu',
                                        'icontext-menu',
                                        'icon-overlay',
                                        'detached',
                                        'double-menu'
                                    ].map((item, idx) => (
                                        <div className="col-sm-6" key={idx}>
                                            <div className="form-check switch-select">
                                                <input
                                                    className="form-check-input"
                                                    type="radio"
                                                    name="sidemenu-layout-styles"
                                                    id={`switcher-${item}`}
                                                    defaultChecked={item === 'double-menu'}
                                                />
                                                <label className="form-check-label" htmlFor={`switcher-${item}`}>
                                                    {item.replace('-', ' ').replace(/\b\w/g, l => l.toUpperCase())}
                                                </label>
                                            </div>
                                        </div>
                                    ))}
                                </div>
                            </div>

                            {/* Page Styles */}
                            <div>
                                <p className="switcher-style-head">Page Styles:</p>
                                <div className="row switcher-style gx-0">
                                    {['regular', 'classic', 'modern', 'flat'].map((item, idx) => (
                                        <div className="col-xl-3 col-6" key={idx}>
                                            <div className="form-check switch-select">
                                                <input
                                                    className="form-check-input"
                                                    type="radio"
                                                    name="page-styles"
                                                    id={`switcher-${item}`}
                                                    defaultChecked={item === 'flat'}
                                                />
                                                <label className="form-check-label" htmlFor={`switcher-${item}`}>
                                                    {item.charAt(0).toUpperCase() + item.slice(1)}
                                                </label>
                                            </div>
                                        </div>
                                    ))}
                                </div>
                            </div>

                            {/* Layout Width */}
                            <div>
                                <p className="switcher-style-head">Layout Width Styles:</p>
                                <div className="row switcher-style gx-0">
                                    {['default-width', 'full-width', 'boxed'].map((item, idx) => (
                                        <div className={`col-${item === 'full-width' ? '5' : item === 'boxed' ? '3' : '4'}`} key={idx}>
                                            <div className="form-check switch-select">
                                                <input
                                                    className="form-check-input"
                                                    type="radio"
                                                    name="layout-width"
                                                    id={`switcher-${item}`}
                                                    defaultChecked={item === 'full-width'}
                                                />
                                                <label className="form-check-label" htmlFor={`switcher-${item}`}>
                                                    {item.replace('-', ' ').replace(/\b\w/g, l => l.toUpperCase())}
                                                </label>
                                            </div>
                                        </div>
                                    ))}
                                </div>
                            </div>

                            {/* Menu Positions */}
                            <div>
                                <p className="switcher-style-head">Menu Positions:</p>
                                <div className="row switcher-style gx-0">
                                    {['menu-fixed', 'menu-scroll'].map((item, idx) => (
                                        <div className="col-4" key={idx}>
                                            <div className="form-check switch-select">
                                                <input
                                                    className="form-check-input"
                                                    type="radio"
                                                    name="menu-positions"
                                                    id={`switcher-${item}`}
                                                    defaultChecked={item === 'menu-fixed'}
                                                />
                                                <label className="form-check-label" htmlFor={`switcher-${item}`}>
                                                    {item.replace('-', ' ').replace(/\b\w/g, l => l.toUpperCase())}
                                                </label>
                                            </div>
                                        </div>
                                    ))}
                                </div>
                            </div>

                            {/* Header Positions */}
                            <div>
                                <p className="switcher-style-head">Header Positions:</p>
                                <div className="row switcher-style gx-0">
                                    {['header-fixed', 'header-scroll'].map((item, idx) => (
                                        <div className="col-4" key={idx}>
                                            <div className="form-check switch-select">
                                                <input
                                                    className="form-check-input"
                                                    type="radio"
                                                    name="header-positions"
                                                    id={`switcher-${item}`}
                                                    defaultChecked={item === 'header-fixed'}
                                                />
                                                <label className="form-check-label" htmlFor={`switcher-${item}`}>
                                                    {item.replace('-', ' ').replace(/\b\w/g, l => l.toUpperCase())}
                                                </label>
                                            </div>
                                        </div>
                                    ))}
                                </div>
                            </div>

                            {/* Loader */}
                            <div>
                                <p className="switcher-style-head">Loader:</p>
                                <div className="row switcher-style gx-0">
                                    {['loader-enable', 'loader-disable'].map((item, idx) => (
                                        <div className="col-4" key={idx}>
                                            <div className="form-check switch-select">
                                                <input
                                                    className="form-check-input"
                                                    type="radio"
                                                    name="page-loader"
                                                    id={`switcher-${item}`}
                                                    defaultChecked={item === 'loader-disable'}
                                                />
                                                <label className="form-check-label" htmlFor={`switcher-${item}`}>
                                                    {item.replace('loader-', '').replace(/\b\w/g, l => l.toUpperCase())}
                                                </label>
                                            </div>
                                        </div>
                                    ))}
                                </div>
                            </div>
                        </div>

                        {/* Tab 2: Theme Colors */}
                        <div
                            className="tab-pane fade border-0"
                            id="switcher-profile"
                            role="tabpanel"
                            aria-labelledby="switcher-profile-tab"
                            tabIndex={0}
                        >
                            {/* Theme Colors content */}
                            {/* Sama pattern: ganti className, htmlFor, input self-closing */}
                        </div>
                    </div>

                    {/* Footer Buttons */}
                    <div className="d-flex justify-content-between canvas-footer flex-wrap">
                        <a
                            href="https://1.envato.market/zxD4aM"
                            target="_blank"
                            className="btn btn-primary"
                            rel="noopener noreferrer"
                        >
                            Buy Now
                        </a>
                        <a
                            href="https://1.envato.market/MGEaN"
                            target="_blank"
                            className="btn btn-secondary"
                            rel="noopener noreferrer"
                        >
                            Our Portfolio
                        </a>
                        <a href="#" id="reset-all" className="btn btn-danger">
                            Reset
                        </a>
                    </div>
                </div>
            </div>
            {/* End Switcher */}

            {/* Loader */}
            <div id="loader" className="d-none">
                <img src="/react/images/media/loader.svg" alt="" />
            </div>
        </>
    );
};

export default OffCanvas;
