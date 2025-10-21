(function () {
    "use strict";

    /* page loader */
    function hideLoader() {
        const loader = document.getElementById("loader");
        if (loader) loader.classList.add("d-none");
    }
    window.addEventListener("load", hideLoader);
    /* page loader */

    /* tooltip */
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    const tooltipList = [...tooltipTriggerList].map(
        (tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl)
    );

    /* popover  */
    const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]');
    const popoverList = [...popoverTriggerList].map(
        (popoverTriggerEl) => new bootstrap.Popover(popoverTriggerEl)
    );

    /* breadcrumb date range picker */
    const today = new Date();
    const startDate = today.toISOString().split('T')[0];
    const endDate = new Date(today);
    endDate.setDate(today.getDate() + 30);
    const endDateFormatted = endDate.toISOString().split('T')[0];

    if (document.querySelector("#daterange")) {
        flatpickr("#daterange", {
            mode: "range",
            dateFormat: "Y-m-d",
            defaultDate: [startDate, endDateFormatted],
            onReady: function (selectedDates, dateStr, instance) {
                updateInputDisplay([startDate, endDateFormatted], instance);
            },
            onChange: function (selectedDates, dateStr, instance) {
                updateInputDisplay(selectedDates, instance);
            }
        });
    }

    function updateInputDisplay(dates, instance) {
        if (!instance.input) return;
        if (dates.length === 2) {
            const startDateFormatted = formatDate(dates[0]);
            const endDateFormatted = formatDate(dates[1]);
            instance.input.value = `${startDateFormatted} to ${endDateFormatted}`;
        } else {
            instance.input.value = '';
        }
    }

    function formatDate(dateString) {
        const date = new Date(dateString);
        const day = String(date.getDate()).padStart(2, '0');
        const month = date.toLocaleString('default', {
            month: 'short'
        });
        const year = date.getFullYear();
        return `${day}, ${month} ${year}`;
    }

    /* switcher color pickers */
    const pickrContainerPrimary = document.querySelector(".pickr-container-primary");
    const themeContainerPrimary = document.querySelector(".theme-container-primary");
    const pickrContainerBackground = document.querySelector(".pickr-container-background");
    const themeContainerBackground = document.querySelector(".theme-container-background");

    const nanoThemes = [
        [
            "nano",
            {
                defaultRepresentation: "RGB",
                components: {
                    preview: true,
                    opacity: false,
                    hue: true,
                    interaction: {
                        hex: false,
                        rgba: true,
                        hsva: false,
                        input: true,
                        clear: false,
                        save: false
                    },
                },
            },
        ],
    ];

    /* primary theme */
    const nanoButtons = [];
    let nanoPickr = null;

    if (themeContainerPrimary && pickrContainerPrimary) {
        for (const [theme, config] of nanoThemes) {
            const button = document.createElement("button");
            button.innerHTML = theme;
            nanoButtons.push(button);

            button.addEventListener("click", () => {
                const el = document.createElement("p");
                pickrContainerPrimary.appendChild(el);

                if (nanoPickr) nanoPickr.destroyAndRemove();
                for (const btn of nanoButtons) btn.classList[btn === button ? "add" : "remove"]("active");

                nanoPickr = new Pickr(Object.assign({
                    el,
                    theme,
                    default: "#985ffd"
                }, config));
                nanoPickr.on("changestop", (source, instance) => {
                    const color = instance.getColor().toRGBA();
                    const html = document.querySelector("html");
                    if (html) html.style.setProperty('--primary-rgb', `${Math.floor(color[0])}, ${Math.floor(color[1])}, ${Math.floor(color[2])}`);
                    localStorage.setItem("primaryRGB", `${Math.floor(color[0])}, ${Math.floor(color[1])}, ${Math.floor(color[2])}`);
                });
            });

            themeContainerPrimary.appendChild(button);
        }
        nanoButtons[0].click();
    }

    /* background theme */
    const nanoButtons1 = [];
    let nanoPickr1 = null;

    if (themeContainerBackground && pickrContainerBackground) {
        for (const [theme, config] of nanoThemes) {
            const button = document.createElement("button");
            button.innerHTML = theme;
            nanoButtons1.push(button);

            button.addEventListener("click", () => {
                const el = document.createElement("p");
                pickrContainerBackground.appendChild(el);

                if (nanoPickr1) nanoPickr1.destroyAndRemove();
                for (const btn of nanoButtons1) btn.classList[btn === button ? "add" : "remove"]("active");

                nanoPickr1 = new Pickr(Object.assign({
                    el,
                    theme,
                    default: "#985ffd"
                }, config));
                nanoPickr1.on("changestop", (source, instance) => {
                    const color = instance.getColor().toRGBA();
                    const html = document.querySelector("html");
                    if (!html) return;
                    html.style.setProperty("--body-bg-rgb", `${color[0]}, ${color[1]}, ${color[2]}`);
                    html.style.setProperty("--body-bg-rgb2", `${color[0]+14}, ${color[1]+14}, ${color[2]+14}`);
                    html.style.setProperty("--light-rgb", `${color[0]+14}, ${color[1]+14}, ${color[2]+14}`);
                    html.style.setProperty("--form-control-bg", `rgb(${color[0]+14}, ${color[1]+14}, ${color[2]+14})`);
                    html.style.setProperty("--gray-3", `rgb(${color[0]+14}, ${color[1]+14}, ${color[2]+14})`);
                    localStorage.setItem("bodyBgRGB", `${color[0]}, ${color[1]}, ${color[2]}`);
                    localStorage.setItem("bodylightRGB", `${color[0]+14}, ${color[1]+14}, ${color[2]+14}`);
                    html.setAttribute("data-theme-mode", "dark");
                    html.setAttribute("data-menu-styles", "dark");
                    html.setAttribute("data-header-styles", "dark");

                    ["#switcher-menu-dark", "#switcher-header-dark", "#switcher-dark-theme"].forEach(sel => {
                        const el = document.querySelector(sel);
                        if (el) el.checked = true;
                    });

                    localStorage.removeItem("bgtheme");
                });
            });

            themeContainerBackground.appendChild(button);
        }
        nanoButtons1[0].click();
    }

    /* header theme toggle */
    function toggleTheme() {
        const html = document.querySelector("html");
        if (!html) return;

        const isDark = html.getAttribute("data-theme-mode") === "dark";

        if (isDark) {
            html.setAttribute("data-theme-mode", "light");
            html.setAttribute("data-header-styles", "transparent");
            html.setAttribute("data-menu-styles", "transparent");
            html.removeAttribute("data-bg-theme");

            ["#switcher-light-theme", "#switcher-menu-transparent", "#switcher-header-transparent"].forEach(sel => {
                const el = document.querySelector(sel);
                if (el) el.checked = true;
            });

            html.style.removeProperty("--body-bg-rgb");
            html.style.removeProperty("--body-bg-rgb2");
            html.style.removeProperty("--light-rgb");
            html.style.removeProperty("--form-control-bg");
            html.style.removeProperty("--input-border");

            localStorage.removeItem("vyzordarktheme");
            localStorage.removeItem("vyzorMenu");
            localStorage.removeItem("vyzorHeader");
            localStorage.removeItem("bodylightRGB");
            localStorage.removeItem("bodyBgRGB");
        } else {
            html.setAttribute("data-theme-mode", "dark");
            html.setAttribute("data-header-styles", "transparent");
            html.setAttribute("data-menu-styles", "transparent");

            ["#switcher-dark-theme", "#switcher-menu-transparent", "#switcher-header-transparent"].forEach(sel => {
                const el = document.querySelector(sel);
                if (el) el.checked = true;
            });

            localStorage.setItem("vyzordarktheme", "true");
            localStorage.setItem("vyzorMenu", "transparent");
            localStorage.setItem("vyzorHeader", "transparent");
            localStorage.removeItem("bodylightRGB");
            localStorage.removeItem("bodyBgRGB");
        }
    }

    const layoutSetting = document.querySelector(".layout-setting");
    if (layoutSetting) layoutSetting.addEventListener("click", toggleTheme);

    /* double menu toggle for vertical style */
    const htmlEl = document.querySelector("html");
    if (htmlEl && htmlEl.getAttribute('data-vertical-style') === 'doublemenu') {
        const layoutSetting1 = document.querySelector(".layout-setting-doublemenu");
        if (layoutSetting1) layoutSetting1.addEventListener("click", toggleTheme);
    }

    /* Choices JS */
    document.addEventListener("DOMContentLoaded", function () {
        const genericExamples = document.querySelectorAll("[data-trigger]");
        genericExamples.forEach(el => new Choices(el, {
            allowHTML: true,
            placeholderValue: "This is a placeholder set in the config",
            searchPlaceholderValue: "Search"
        }));
    });

    /* footer year */
    const yearElement = document.getElementById("year");
    if (yearElement) yearElement.innerHTML = new Date().getFullYear();

    /* node waves */
    if (typeof Waves !== "undefined") {
        Waves.attach(".btn-wave", ["waves-light"]);
        Waves.init();
    }

    /* card with close button */
    document.querySelectorAll('[data-bs-toggle="card-remove"]').forEach(ele => {
        ele.addEventListener("click", e => {
            e.preventDefault();
            const card = ele.closest(".card");
            if (card) card.remove();
            return false;
        });
    });

    /* card with fullscreen */
    document.querySelectorAll('[data-bs-toggle="card-fullscreen"]').forEach(ele => {
        ele.addEventListener("click", e => {
            e.preventDefault();
            const card = ele.closest(".card");
            if (card) card.classList.toggle("card-fullscreen");
            card.classList.remove("card-collapsed");
            return false;
        });
    });

    /* count-up */
    let i = 1;
    setInterval(() => {
        document.querySelectorAll(".count-up").forEach(ele => {
            const count = parseInt(ele.getAttribute("data-count"), 10);
            if (!isNaN(count) && count >= i) {
                i += 1;
                ele.innerText = i;
            }
        });
    }, 10);

    /* Progressbar Top */
    window.addEventListener('scroll', () => {
        const scrollTop = document.body.scrollTop || document.documentElement.scrollTop;
        const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        const progress = document.querySelector(".progress-top-bar");
        if (progress) progress.style.width = ((scrollTop / height) * 100) + "%";
    });

    /* back to top */
    const scrollToTop = document.querySelector(".scrollToTop");
    if (scrollToTop) {
        window.addEventListener("scroll", () => {
            scrollToTop.style.display = window.scrollY > 100 ? "flex" : "none";
        });
        scrollToTop.addEventListener("click", () => window.scrollTo({
            top: 0,
            behavior: "smooth"
        }));
    }

    /* header dropdowns scroll */
    const myHeadernotification = document.getElementById("header-notification-scroll");
    if (myHeadernotification) new SimpleBar(myHeadernotification, {
        autoHide: true
    });

    const myHeaderCart = document.getElementById("header-cart-items-scroll");
    if (myHeaderCart) new SimpleBar(myHeaderCart, {
        autoHide: true
    });

    /* autoComplete */
    if (typeof autoComplete !== "undefined") {
        new autoComplete({
            selector: "#header-search",
            data: {
                src: [
                    "How do plants adapt to different environments?",
                    "What makes the ocean's tides rise and fall?",
                    "How do our brains process emotions?",
                    "What factors contribute to the creation of a rainbow?",
                    "Who invented the telephone?",
                    "What role does the moon play in Earth's ecosystem?",
                    "How do animals communicate with each other?",
                    "What causes earthquakes to happen?",
                    "What is the significance of the Great Barrier Reef?",
                    "How do human bones regenerate after an injury?"
                ],
                cache: true,
            },
            resultItem: {
                highlight: true
            },
            events: {
                input: {
                    selection: (event) => {
                        if (event.detail && event.detail.selection) autoCompleteJS.input.value = event.detail.selection.value;
                    }
                }
            }
        });
    }

    /* full screen toggle */
    const elem = document.documentElement;
    window.openFullscreen = function () {
        const openBtn = document.querySelector(".full-screen-open");
        const closeBtn = document.querySelector(".full-screen-close");
        if (!document.fullscreenElement) {
            if (elem.requestFullscreen) elem.requestFullscreen();
            else if (elem.webkitRequestFullscreen) elem.webkitRequestFullscreen();
            else if (elem.msRequestFullscreen) elem.msRequestFullscreen();
            if (closeBtn) {
                closeBtn.classList.add("d-block");
                closeBtn.classList.remove("d-none");
            }
            if (openBtn) {
                openBtn.classList.add("d-none");
            }
        } else {
            if (document.exitFullscreen) document.exitFullscreen();
            else if (document.webkitExitFullscreen) document.webkitExitFullscreen();
            else if (document.msExitFullscreen) document.msExitFullscreen();
            if (closeBtn) {
                closeBtn.classList.remove("d-block");
                closeBtn.classList.add("d-none");
            }
            if (openBtn) {
                openBtn.classList.remove("d-none");
                openBtn.classList.add("d-block");
            }
        }
    };

    /* toggle switches */
    document.querySelectorAll(".toggle").forEach(e => e.addEventListener("click", () => e.classList.toggle("on")));

    /* cart dropdown and quantity */
    const headerbtn = document.querySelectorAll(".dropdown-item-close");
    headerbtn.forEach(button => button.addEventListener("click", (e) => {
        e.preventDefault();
        e.stopPropagation();
        const cartItem = button.closest(".cart-item");
        if (cartItem) cartItem.remove();

        const cartCount = document.querySelectorAll(".dropdown-item-close").length;
        const cartDataEl = document.getElementById("cart-data");
        const cartBadgeEl = document.getElementById("cart-icon-badge");
        if (cartDataEl) cartDataEl.innerText = `${cartCount}`;
        if (cartBadgeEl) cartBadgeEl.innerText = `${cartCount}`;
    }));

})();
