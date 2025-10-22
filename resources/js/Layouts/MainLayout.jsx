// resources/js/Layouts/MainLayout.jsx
import { useEffect } from "react";
import Navbar from "../Components/Navbar";
import Sidebar from "../Components/Sidebar";
import Footer from "../Components/Footer";
import OffCanvas from "../Components/OffCanvas";

export default function MainLayout({ children }) {
    useEffect(() => {
        Promise.all([
            import("../../../public/react/js/defaultmenu.min.js"),
            import(
                "../../../public/react/libs/@tarekraafat/autocomplete.js/autoComplete.min.js"
            ),
            import("../../../public/react/js/custom-switcher.min.js"),
            import("../../../public/react/js/custom.js"),
        ]).then(() => {
            window.menuReady = true;
            if (window.initMenu) window.initMenu();
        });
    }, []);

    return (
        <>
            {/* Top progress bar */}
            <div className="progress-top-bar"></div>

            {/* OffCanvas Switcher */}
            <OffCanvas />

            <div className="page">
                <Navbar />
                <Sidebar />
                <div className="main-content app-content">
                    <main>{children}</main>
                </div>
                <Footer />
            </div>

            <div className="scrollToTop">
                <span className="arrow lh-1">
                    <i className="ti ti-arrow-big-up fs-18"></i>
                </span>
            </div>
            <div id="responsive-overlay"></div>
        </>
    );
}
