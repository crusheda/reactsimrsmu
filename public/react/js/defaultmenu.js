"use strict";

const ANIMATION_DURATION = 300;

const sidebar = document.getElementById("sidebar");
// const overlay = document.getElementById('responsive-overlay');
let mainContentDiv = document.querySelector(".main-content");

// Selector diperbaiki agar semua .has-sub termasuk nested
const slideHasSub = document.querySelectorAll(".nav .slide.has-sub");
const firstLevelItems = document.querySelectorAll(".slide.has-sub > a");
const innerLevelItems = document.querySelectorAll(".slide.has-sub a");

/**
 * PopperObject handles dynamic positioning of submenus using Popper.js
 */
class PopperObject {
    instance = null;
    reference = null;
    popperTarget = null;

    constructor(reference, popperTarget) {
        this.init(reference, popperTarget);
    }

    init(reference, popperTarget) {
        this.reference = reference;
        this.popperTarget = popperTarget;

        this.instance = Popper.createPopper(this.reference, this.popperTarget, {
            placement: "bottom-start",
            strategy: "absolute",
            modifiers: [{ name: "computeStyles", options: { adaptive: false } }],
        });

        this.clickListener = (e) => this.clicker(e);
        document.addEventListener("click", this.clickListener, false);
        window.addEventListener("resize", () => this.instance.update());
        window.addEventListener("scroll", () => this.instance.update(), true);
        const ro = new ResizeObserver(() => this.instance.update());
        ro.observe(this.popperTarget);
        ro.observe(this.reference);
    }

    clicker(event) {
        if (
            sidebar.classList.contains("collapsed") &&
            !this.popperTarget.contains(event.target) &&
            !this.reference.contains(event.target)
        ) {
            this.hide();
        }
    }

    show() {
        if (this.popperTarget) {
            this.popperTarget.style.visibility = "visible";
            this.instance.update();
        }
    }

    hide() {
        if (this.popperTarget) this.popperTarget.style.visibility = "hidden";
    }

    destroy() {
        document.removeEventListener("click", this.clickListener);
        if (this.instance) this.instance.destroy();
    }
}

/**
 * Poppers manages all PopperObjects
 */
class Poppers {
    subMenuPoppers = [];

    constructor() {
        this.init();
    }

    init() {
        slideHasSub.forEach((element) => {
            this.subMenuPoppers.push(new PopperObject(element, element.lastElementChild));
        });
        this.closePoppers();
    }

    togglePopper(target) {
        if (!target) return;
        const style = window.getComputedStyle(target);
        target.style.visibility = (style.visibility === "hidden" || style.visibility === undefined) ? "visible" : "hidden";
    }

    updatePoppers() {
        this.subMenuPoppers.forEach((element) => {
            element.instance.state.elements.popper.style.display = "none";
            element.instance.update();
        });
    }

    closePoppers() {
        this.subMenuPoppers.forEach((element) => element.hide());
    }
}

/**
 * Slide Up/Down animations
 */
const slideUp = (target, duration = ANIMATION_DURATION) => {
    if (!target) return;
    const { parentElement } = target;
    parentElement?.classList.remove("open");

    target.style.transitionProperty = "height, margin, padding";
    target.style.transitionDuration = `${duration}ms`;
    target.style.boxSizing = "border-box";
    target.style.height = `${target.offsetHeight}px`;
    target.offsetHeight;

    target.style.overflow = "hidden";
    target.style.height = 0;
    target.style.paddingTop = 0;
    target.style.paddingBottom = 0;
    target.style.marginTop = 0;
    target.style.marginBottom = 0;

    setTimeout(() => {
        target.style.display = "none";
        ["height", "padding-top", "padding-bottom", "margin-top", "margin-bottom", "overflow", "transition-duration", "transition-property"].forEach((prop) => target.style.removeProperty(prop));
    }, duration);

    const listItem = target.closest("li");
    const siblingUL = listItem?.querySelector("ul");
    siblingUL?.classList.remove("force-left");
};

const slideDown = (target, duration = ANIMATION_DURATION) => {
    if (!target) return;
    const { parentElement } = target;
    parentElement?.classList.add("open");

    target.style.removeProperty("display");
    let display = window.getComputedStyle(target).display;
    if (display === "none") display = "block";
    target.style.display = display;

    const height = target.offsetHeight;
    target.style.overflow = "hidden";
    target.style.height = 0;
    target.style.paddingTop = 0;
    target.style.paddingBottom = 0;
    target.style.marginTop = 0;
    target.style.marginBottom = 0;
    target.offsetHeight;

    target.style.boxSizing = "border-box";
    target.style.transitionProperty = "height, margin, padding";
    target.style.transitionDuration = `${duration}ms`;
    target.style.height = `${height}px`;
    target.style.removeProperty("padding-top");
    target.style.removeProperty("padding-bottom");
    target.style.removeProperty("margin-top");
    target.style.removeProperty("margin-bottom");

    setTimeout(() => {
        ["height", "overflow", "transition-property", "transition-duration"].forEach((prop) => target.style.removeProperty(prop));
    }, duration);

    const html = document.documentElement;
    const listItem = target.closest("li");
    if (!listItem) return;

    const dropdownRect = listItem.getBoundingClientRect();
    const dropdownWidth = target.getBoundingClientRect().width;
    const rightEdge = dropdownRect.right + dropdownWidth;
    const leftEdge = dropdownRect.left - dropdownWidth;

    if (html.getAttribute("dir") === "rtl") {
        if (leftEdge < 0 || (listItem.closest('ul')?.classList.contains('force-left') && rightEdge < window.innerWidth)) {
            target.classList.add('force-left');
        } else {
            target.classList.remove('force-left');
        }
    } else {
        if (rightEdge > window.innerWidth || (listItem.closest('ul')?.classList.contains('force-left') && leftEdge > 0)) {
            target.classList.add('force-left');
        } else if (leftEdge < 0) {
            target.classList.remove('force-left');
        } else {
            target.classList.remove('force-left');
        }
    }
};

const slideToggle = (target, duration = ANIMATION_DURATION) => {
    if (!target || target.nodeType === 3) return;

    const html = document.querySelector("html");
    const navStyle = html.getAttribute("data-nav-style");
    const dataToggled = html.getAttribute("data-toggled");

    if (!((navStyle === "menu-hover" && dataToggled === "menu-hover-closed" && window.innerWidth >= 992) ||
        (navStyle === "icon-hover" && dataToggled === "icon-hover-closed" && window.innerWidth >= 992))) {
        if (window.getComputedStyle(target).display === "none") return slideDown(target, duration);
        return slideUp(target, duration);
    }
};

/**
 * Handle responsive sidebar
 */
const handleResponsiveSidebar = () => {
    const html = document.documentElement;
    const width = window.innerWidth;
    const overlayx = document.getElementById('responsive-overlay');

    if (width < 992) {
        if(html.getAttribute('data-toggled') === 'double-menu-open' || html.getAttribute('data-toggled') === 'open'){
            html.setAttribute('data-toggled', 'double-menu-close');
            html.setAttribute('data-toggled', 'close');
            overlayx?.classList.remove('active');
        } else {
            html.setAttribute('data-toggled', 'close');
            overlayx?.classList.remove('active');
        }
    } else {
        if(html.getAttribute('data-toggled') !== 'double-menu-open'){
            html.setAttribute('data-toggled', 'close');
            overlayx?.classList.remove('active');
            html.setAttribute('data-toggled', 'double-menu-open');
        }
    }
};

// Jalankan saat load & resize
window.addEventListener('load', handleResponsiveSidebar);
window.addEventListener('resize', handleResponsiveSidebar);

/**
 * Initialize poppers
 */
const PoppersInstance = new Poppers();
const updatePoppersTimeout = () => setTimeout(() => PoppersInstance.updatePoppers(), ANIMATION_DURATION);

/**
 * Default open menus
 */
document.querySelectorAll(".slide.has-sub.open").forEach((element) => {
    element.lastElementChild.style.display = "block";
});

/**
 * Top level submenu click handler
 */
firstLevelItems.forEach((element) => {
    element.addEventListener("click", (e) => {
        const html = document.querySelector("html");
        if ((html.getAttribute("data-nav-style") !== "menu-hover" && html.getAttribute("data-nav-style") !== "icon-hover") || window.innerWidth < 992 || (!html.getAttribute("data-toggled") && html.getAttribute("data-nav-layout") !== "horizontal")) {

            const parentMenu = element.closest(".nav.sub-open");
            parentMenu?.querySelectorAll(":scope > ul > .slide.has-sub > a").forEach((el) => {
                if (el.nextElementSibling && window.getComputedStyle(el.nextElementSibling).display === "block") {
                    slideUp(el.nextElementSibling);
                }
            });

            slideToggle(element.nextElementSibling);
        }
    });
});

/**
 * Inner submenu click handler
 */
innerLevelItems.forEach((element) => {
    element.addEventListener("click", () => {
        const html = document.querySelector("html");
        if ((html.getAttribute("data-nav-style") !== "menu-hover" && html.getAttribute("data-nav-style") !== "icon-hover") || window.innerWidth < 992 || (!html.getAttribute("data-toggled") && html.getAttribute("data-nav-layout") !== "horizontal")) {

            const innerMenu = element.closest(".slide-menu");
            innerMenu?.querySelectorAll(":scope .slide.has-sub > a").forEach((el) => {
                if (el.nextElementSibling && el.nextElementSibling.style.display === "block") slideUp(el.nextElementSibling);
            });

            slideToggle(element.nextElementSibling);
        }
    });
});

/**
 * Sidebar toggle
 */
window.toggleSidemenu = function() {
    const width = window.innerWidth;
    const html = document.documentElement;
    const overlayc = document.getElementById('responsive-overlay');

    if (width < 992) {
        if(html.getAttribute('data-toggled') === 'open'){
            html.setAttribute('data-toggled','close');
            overlayc?.classList.remove('active');
        } else {
            html.setAttribute('data-toggled','open');
            overlayc?.classList.add('active');

            // Hanya sekali listener, hindari multiple
            if (!overlayc?.dataset.listener) {
                overlayc?.addEventListener('click', () => {
                    if (html.getAttribute('data-toggled') === 'open') {
                        window.toggleSidemenu();
                    }
                });
                overlayc?.setAttribute('data-listener', 'true');
            }
        }
    } else {
        if(html.getAttribute('data-toggled') === 'double-menu-open'){
            html.setAttribute('data-toggled','double-menu-close');
        } else {
            html.setAttribute('data-toggled','double-menu-open');
        }
    }
};
