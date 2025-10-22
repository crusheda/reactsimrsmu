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
                        <h5
                            className="offcanvas-title text-default"
                            id="offcanvasRightLabel"
                        >
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
                                <p className="switcher-style-head">
                                    Theme Color Mode:
                                </p>
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
                            <div hidden>
                                <p className="switcher-style-head">
                                    Directions:
                                </p>
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
                                            <label
                                                className="form-check-label"
                                                htmlFor="switcher-ltr"
                                            >
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
                                            <label
                                                className="form-check-label"
                                                htmlFor="switcher-rtl"
                                            >
                                                RTL
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {/* Navigation Styles */}
                            <div hidden>
                                <p className="switcher-style-head">
                                    Navigation Styles:
                                </p>
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
                                            <label
                                                className="form-check-label"
                                                htmlFor="switcher-vertical"
                                            >
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
                                            <label
                                                className="form-check-label"
                                                htmlFor="switcher-horizontal"
                                            >
                                                Horizontal
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {/* Navigation Menu Styles */}
                            <div className="navigation-menu-styles" hidden>
                                <p className="switcher-style-head">
                                    Vertical & Horizontal Menu Styles:
                                </p>
                                <div className="row switcher-style gx-0 pb-2 gy-2">
                                    {[
                                        "menu-click",
                                        "menu-hover",
                                        "icon-click",
                                        "icon-hover",
                                    ].map((item, idx) => (
                                        <div className="col-4" key={idx}>
                                            <div className="form-check switch-select">
                                                <input
                                                    className="form-check-input"
                                                    type="radio"
                                                    name="navigation-menu-styles"
                                                    id={`switcher-${item}`}
                                                    defaultChecked={
                                                        item === "menu-click"
                                                    }
                                                />
                                                <label
                                                    className="form-check-label"
                                                    htmlFor={`switcher-${item}`}
                                                >
                                                    {item
                                                        .replace("-", " ")
                                                        .replace(/\b\w/g, (l) =>
                                                            l.toUpperCase()
                                                        )}
                                                </label>
                                            </div>
                                        </div>
                                    ))}
                                </div>
                            </div>

                            {/* Sidemenu Layout Styles */}
                            <div className="sidemenu-layout-styles" hidden>
                                <p className="switcher-style-head">
                                    Sidemenu Layout Styles:
                                </p>
                                <div className="row switcher-style gx-0 pb-2 gy-2">
                                    {[
                                        "default-menu",
                                        "closed-menu",
                                        "icontext-menu",
                                        "icon-overlay",
                                        "detached",
                                        "double-menu",
                                    ].map((item, idx) => (
                                        <div className="col-sm-6" key={idx}>
                                            <div className="form-check switch-select">
                                                <input
                                                    className="form-check-input"
                                                    type="radio"
                                                    name="sidemenu-layout-styles"
                                                    id={`switcher-${item}`}
                                                    defaultChecked={
                                                        item === "double-menu"
                                                    }
                                                />
                                                <label
                                                    className="form-check-label"
                                                    htmlFor={`switcher-${item}`}
                                                >
                                                    {item
                                                        .replace("-", " ")
                                                        .replace(/\b\w/g, (l) =>
                                                            l.toUpperCase()
                                                        )}
                                                </label>
                                            </div>
                                        </div>
                                    ))}
                                </div>
                            </div>

                            {/* Page Styles */}
                            <div hidden>
                                <p className="switcher-style-head">
                                    Page Styles:
                                </p>
                                <div className="row switcher-style gx-0">
                                    {[
                                        "regular",
                                        "classic",
                                        "modern",
                                        "flat",
                                    ].map((item, idx) => (
                                        <div
                                            className="col-xl-3 col-6"
                                            key={idx}
                                        >
                                            <div className="form-check switch-select">
                                                <input
                                                    className="form-check-input"
                                                    type="radio"
                                                    name="page-styles"
                                                    id={`switcher-${item}`}
                                                    defaultChecked={
                                                        item === "flat"
                                                    }
                                                />
                                                <label
                                                    className="form-check-label"
                                                    htmlFor={`switcher-${item}`}
                                                >
                                                    {item
                                                        .charAt(0)
                                                        .toUpperCase() +
                                                        item.slice(1)}
                                                </label>
                                            </div>
                                        </div>
                                    ))}
                                </div>
                            </div>

                            {/* Layout Width */}
                            <div hidden>
                                <p className="switcher-style-head">
                                    Layout Width Styles:
                                </p>
                                <div className="row switcher-style gx-0">
                                    {[
                                        "default-width",
                                        "full-width",
                                        "boxed",
                                    ].map((item, idx) => (
                                        <div
                                            className={`col-${
                                                item === "full-width"
                                                    ? "5"
                                                    : item === "boxed"
                                                    ? "3"
                                                    : "4"
                                            }`}
                                            key={idx}
                                        >
                                            <div className="form-check switch-select">
                                                <input
                                                    className="form-check-input"
                                                    type="radio"
                                                    name="layout-width"
                                                    id={`switcher-${item}`}
                                                    defaultChecked={
                                                        item === "full-width"
                                                    }
                                                />
                                                <label
                                                    className="form-check-label"
                                                    htmlFor={`switcher-${item}`}
                                                >
                                                    {item
                                                        .replace("-", " ")
                                                        .replace(/\b\w/g, (l) =>
                                                            l.toUpperCase()
                                                        )}
                                                </label>
                                            </div>
                                        </div>
                                    ))}
                                </div>
                            </div>

                            {/* Menu Positions */}
                            <div hidden>
                                <p className="switcher-style-head">
                                    Menu Positions:
                                </p>
                                <div className="row switcher-style gx-0">
                                    {["menu-fixed", "menu-scroll"].map(
                                        (item, idx) => (
                                            <div className="col-4" key={idx}>
                                                <div className="form-check switch-select">
                                                    <input
                                                        className="form-check-input"
                                                        type="radio"
                                                        name="menu-positions"
                                                        id={`switcher-${item}`}
                                                        defaultChecked={
                                                            item ===
                                                            "menu-fixed"
                                                        }
                                                    />
                                                    <label
                                                        className="form-check-label"
                                                        htmlFor={`switcher-${item}`}
                                                    >
                                                        {item
                                                            .replace("-", " ")
                                                            .replace(
                                                                /\b\w/g,
                                                                (l) =>
                                                                    l.toUpperCase()
                                                            )}
                                                    </label>
                                                </div>
                                            </div>
                                        )
                                    )}
                                </div>
                            </div>

                            {/* Header Positions */}
                            <div>
                                <p className="switcher-style-head">
                                    Header Positions:
                                </p>
                                <div className="row switcher-style gx-0">
                                    {["header-fixed", "header-scroll"].map(
                                        (item, idx) => (
                                            <div className="col-4" key={idx}>
                                                <div className="form-check switch-select">
                                                    <input
                                                        className="form-check-input"
                                                        type="radio"
                                                        name="header-positions"
                                                        id={`switcher-${item}`}
                                                        defaultChecked={
                                                            item ===
                                                            "header-fixed"
                                                        }
                                                    />
                                                    <label
                                                        className="form-check-label"
                                                        htmlFor={`switcher-${item}`}
                                                    >
                                                        {item
                                                            .replace("-", " ")
                                                            .replace(
                                                                /\b\w/g,
                                                                (l) =>
                                                                    l.toUpperCase()
                                                            )}
                                                    </label>
                                                </div>
                                            </div>
                                        )
                                    )}
                                </div>
                            </div>

                            {/* Loader */}
                            <div hidden>
                                <p className="switcher-style-head">Loader:</p>
                                <div className="row switcher-style gx-0">
                                    {["loader-enable", "loader-disable"].map(
                                        (item, idx) => (
                                            <div className="col-4" key={idx}>
                                                <div className="form-check switch-select">
                                                    <input
                                                        className="form-check-input"
                                                        type="radio"
                                                        name="page-loader"
                                                        id={`switcher-${item}`}
                                                        defaultChecked={
                                                            item ===
                                                            "loader-disable"
                                                        }
                                                    />
                                                    <label
                                                        className="form-check-label"
                                                        htmlFor={`switcher-${item}`}
                                                    >
                                                        {item
                                                            .replace(
                                                                "loader-",
                                                                ""
                                                            )
                                                            .replace(
                                                                /\b\w/g,
                                                                (l) =>
                                                                    l.toUpperCase()
                                                            )}
                                                    </label>
                                                </div>
                                            </div>
                                        )
                                    )}
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
                            <div>
                                <div className="theme-colors" hidden>
                                    <p className="switcher-style-head">
                                        Menu Colors:
                                    </p>
                                    <div className="d-flex switcher-style pb-2">
                                        <div className="form-check switch-select me-3">
                                            <input
                                                className="form-check-input color-input color-white"
                                                data-bs-toggle="tooltip"
                                                data-bs-placement="top"
                                                type="radio"
                                                name="menu-colors"
                                                id="switcher-menu-light"
                                                aria-label="Light Menu"
                                                title="Light Menu"
                                                defaultChecked
                                            />
                                        </div>
                                        <div className="form-check switch-select me-3">
                                            <input
                                                className="form-check-input color-input color-dark"
                                                data-bs-toggle="tooltip"
                                                data-bs-placement="top"
                                                type="radio"
                                                name="menu-colors"
                                                id="switcher-menu-dark"
                                                aria-label="Dark Menu"
                                                title="Dark Menu"
                                            />
                                        </div>
                                        <div className="form-check switch-select me-3">
                                            <input
                                                className="form-check-input color-input color-primary"
                                                data-bs-toggle="tooltip"
                                                data-bs-placement="top"
                                                type="radio"
                                                name="menu-colors"
                                                id="switcher-menu-primary"
                                                aria-label="Color Menu"
                                                title="Color Menu"
                                            />
                                        </div>
                                        <div className="form-check switch-select me-3">
                                            <input
                                                className="form-check-input color-input color-gradient"
                                                data-bs-toggle="tooltip"
                                                data-bs-placement="top"
                                                type="radio"
                                                name="menu-colors"
                                                id="switcher-menu-gradient"
                                                aria-label="Gradient Menu"
                                                title="Gradient Menu"
                                            />
                                        </div>
                                        <div className="form-check switch-select me-3">
                                            <input
                                                className="form-check-input color-input color-transparent"
                                                data-bs-toggle="tooltip"
                                                data-bs-placement="top"
                                                type="radio"
                                                name="menu-colors"
                                                id="switcher-menu-transparent"
                                                aria-label="Transparent Menu"
                                                title="Transparent Menu"
                                            />
                                        </div>
                                    </div>
                                    <div className="px-4 pb-3 text-muted fs-11">
                                        Note: If you want to change menu color
                                        dynamically, change from below Theme
                                        Primary color picker
                                    </div>
                                </div>

                                <div className="theme-colors">
                                    <p className="switcher-style-head">
                                        Header Colors:
                                    </p>
                                    <div className="d-flex switcher-style pb-2">
                                        <div className="form-check switch-select me-3">
                                            <input
                                                className="form-check-input color-input color-white"
                                                data-bs-toggle="tooltip"
                                                data-bs-placement="top"
                                                type="radio"
                                                name="header-colors"
                                                id="switcher-header-light"
                                                aria-label="Light Header"
                                                title="Light Header"
                                            />
                                        </div>
                                        <div className="form-check switch-select me-3">
                                            <input
                                                className="form-check-input color-input color-dark"
                                                data-bs-toggle="tooltip"
                                                data-bs-placement="top"
                                                type="radio"
                                                name="header-colors"
                                                id="switcher-header-dark"
                                                aria-label="Dark Header"
                                                title="Dark Header"
                                            />
                                        </div>
                                        <div className="form-check switch-select me-3">
                                            <input
                                                className="form-check-input color-input color-primary"
                                                data-bs-toggle="tooltip"
                                                data-bs-placement="top"
                                                type="radio"
                                                name="header-colors"
                                                id="switcher-header-primary"
                                                aria-label="Color Header"
                                                title="Color Header"
                                            />
                                        </div>
                                        <div className="form-check switch-select me-3">
                                            <input
                                                className="form-check-input color-input color-gradient"
                                                data-bs-toggle="tooltip"
                                                data-bs-placement="top"
                                                type="radio"
                                                name="header-colors"
                                                id="switcher-header-gradient"
                                                aria-label="Gradient Header"
                                                title="Gradient Header"
                                            />
                                        </div>
                                        <div className="form-check switch-select me-3">
                                            <input
                                                className="form-check-input color-input color-transparent"
                                                data-bs-toggle="tooltip"
                                                data-bs-placement="top"
                                                type="radio"
                                                name="header-colors"
                                                id="switcher-header-transparent"
                                                aria-label="Transparent Header"
                                                title="Transparent Header"
                                                defaultChecked
                                            />
                                        </div>
                                    </div>
                                    <div className="px-4 pb-3 text-muted fs-11">
                                        Note: If you want to change header color
                                        dynamically, change from below Theme
                                        Primary color picker
                                    </div>
                                </div>

                                <div className="theme-colors">
                                    <p className="switcher-style-head">
                                        Theme Primary:
                                    </p>
                                    <div className="d-flex flex-wrap align-items-center switcher-style">
                                        {[...Array(5)].map((_, i) => (
                                            <div
                                                key={i}
                                                className="form-check switch-select me-3"
                                            >
                                                <input
                                                    className={`form-check-input color-input color-primary-${
                                                        i + 1
                                                    }`}
                                                    type="radio"
                                                    name="theme-primary"
                                                    id={
                                                        i === 0
                                                            ? "switcher-primary"
                                                            : `switcher-primary${i}`
                                                    }
                                                />
                                            </div>
                                        ))}
                                        <div className="form-check switch-select ps-0 mt-1 color-primary-light">
                                            <div className="theme-container-primary"></div>
                                            <div className="pickr-container-primary"></div>
                                        </div>
                                    </div>
                                </div>

                                <div className="theme-colors">
                                    <p className="switcher-style-head">
                                        Theme Background:
                                    </p>
                                    <div className="d-flex flex-wrap align-items-center switcher-style">
                                        {[...Array(5)].map((_, i) => (
                                            <div
                                                key={i}
                                                className="form-check switch-select me-3"
                                            >
                                                <input
                                                    className={`form-check-input color-input color-bg-${
                                                        i + 1
                                                    }`}
                                                    type="radio"
                                                    name="theme-background"
                                                    id={
                                                        i === 0
                                                            ? "switcher-background"
                                                            : `switcher-background${i}`
                                                    }
                                                />
                                            </div>
                                        ))}
                                        <div className="form-check switch-select ps-0 mt-1 tooltip-static-demo color-bg-transparent">
                                            <div className="theme-container-background"></div>
                                            <div className="pickr-container-background"></div>
                                        </div>
                                    </div>
                                </div>

                                <div className="menu-image mb-3" hidden>
                                    <p className="switcher-style-head">
                                        Menu With Background Image:
                                    </p>
                                    <div className="d-flex flex-wrap align-items-center switcher-style">
                                        {[1, 2, 3, 4, 5].map((i, index) => (
                                            <div
                                                key={i}
                                                className="form-check switch-select menu-img-select m-2"
                                            >
                                                <input
                                                    className={`form-check-input bgimage-input bg-img${i}`}
                                                    type="radio"
                                                    name="menu-background"
                                                    id={
                                                        index === 0
                                                            ? "switcher-bg-img"
                                                            : `switcher-bg-img${index}`
                                                    }
                                                />
                                                <div className="bg-img-container">
                                                    <img
                                                        src={`/react/images/menu-bg-images/bg-img${i}.jpg`}
                                                        alt=""
                                                    />
                                                </div>
                                            </div>
                                        ))}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {/* Footer Buttons */}
                    <div className="d-flex justify-content-between canvas-footer flex-wrap">
                        <a
                            href="https://1.envato.market/zxD4aM"
                            target="_blank"
                            className="btn btn-primary"
                            rel="noopener noreferrer"
                            hidden
                        >
                            Buy Now
                        </a>
                        <a
                            href="https://1.envato.market/MGEaN"
                            target="_blank"
                            className="btn btn-secondary"
                            rel="noopener noreferrer"
                            hidden
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
