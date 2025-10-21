"use strict";

let mainContent;
(function () {
    const html = document.querySelector('html');
    mainContent = document.querySelector('.main-content');
    localStorageBackup2();
    switcherClick();
    checkOptions();
    setTimeout(() => checkOptions(), 1000);
})();

function switcherClick() {
    const html = document.querySelector('html');

    // 🔹 Button elements
    const selectors = [
        'switcher-light-theme','switcher-dark-theme',
        'switcher-ltr','switcher-rtl',
        'switcher-vertical','switcher-horizontal',
        'switcher-default-width','switcher-boxed','switcher-full-width',
        'switcher-menu-fixed','switcher-menu-scroll',
        'switcher-header-fixed','switcher-header-scroll',
        'switcher-header-light','switcher-header-dark','switcher-header-primary','switcher-header-gradient','switcher-header-transparent',
        'switcher-menu-light','switcher-menu-dark','switcher-menu-primary','switcher-menu-gradient','switcher-menu-transparent',
        'switcher-regular','switcher-classic','switcher-modern','switcher-flat',
        'switcher-default-menu','switcher-closed-menu','switcher-icontext-menu','switcher-detached','switcher-icon-overlay','switcher-double-menu',
        'switcher-menu-click','switcher-menu-hover','switcher-icon-click','switcher-icon-hover',
        'switcher-primary','switcher-primary1','switcher-primary2','switcher-primary3','switcher-primary4',
        'switcher-background','switcher-background1','switcher-background2','switcher-background3','switcher-background4',
        'switcher-bg-img','switcher-bg-img1','switcher-bg-img2','switcher-bg-img3','switcher-bg-img4',
        'reset-all','switcher-loader-enable','switcher-loader-disable'
    ];

    const btns = {};
    selectors.forEach(id => btns[id] = document.querySelector(`#${id}`));

    /* ================= Primary Colors ================= */
    const primaryColors = [
        {btn: btns['switcher-primary'], rgb: "42,16,164"},
        {btn: btns['switcher-primary1'], rgb: "125,0,189"},
        {btn: btns['switcher-primary2'], rgb: "4,118,141"},
        {btn: btns['switcher-primary3'], rgb: "138,0,32"},
        {btn: btns['switcher-primary4'], rgb: "9,124,103"}
    ];

    primaryColors.forEach((color, idx) => {
        if(color.btn) {
            const varName = `primaryColor${idx+1}Var`;
            window[varName] = color.btn.addEventListener('click', () => {
                localStorage.setItem("primaryRGB", color.rgb);
                html.style.setProperty('--primary-rgb', color.rgb);
            });
        }
    });

    /* ================= Background Colors ================= */
    const bgColors = [
        {btn: btns['switcher-background'], body: "0,8,52", light: "14,22,66"},
        {btn: btns['switcher-background1'], body: "58,0,109", light: "72,14,123"},
        {btn: btns['switcher-background2'], body: "0,59,70", light: "14,73,84"},
        {btn: btns['switcher-background3'], body: "65,0,0", light: "79,14,14"},
        {btn: btns['switcher-background4'], body: "1,77,46", light: "15,91,60"}
    ];

    bgColors.forEach((bg, idx) => {
        if(bg.btn) {
            const varName = `backgroundColor${idx+1}Var`;
            window[varName] = bg.btn.addEventListener('click', () => {
                localStorage.setItem('bodyBgRGB', bg.body);
                localStorage.setItem('bodylightRGB', bg.light);
                html.setAttribute('data-theme-mode', 'dark');
                html.setAttribute('data-menu-styles', 'dark');
                html.setAttribute('data-header-styles', 'dark');
                html.style.setProperty('--body-bg-rgb', localStorage.bodyBgRGB);
                html.style.setProperty('--body-bg-rgb2', localStorage.bodylightRGB);
                html.style.setProperty('--light-rgb', bg.light);
                html.style.setProperty('--form-control-bg', `rgb(${bg.light})`);
                html.style.setProperty('--input-border', "rgba(255,255,255,0.1)");
                html.style.setProperty('--gray-3', "rgba(255,255,255,0.1)");
                btns['switcher-light-theme'] && (btns['switcher-light-theme'].checked = true);
                btns['switcher-menu-dark'] && (btns['switcher-menu-dark'].checked = true);
                btns['switcher-header-dark'] && (btns['switcher-header-dark'].checked = true);
                localStorage.setItem("vyzorMenu", "dark");
                localStorage.setItem("vyzorHeader", "dark");
            });
        }
    });

    /* ================= Background Images ================= */
    const bgImages = [
        {btn: btns['switcher-bg-img'], img: 'bgimg1'},
        {btn: btns['switcher-bg-img1'], img: 'bgimg2'},
        {btn: btns['switcher-bg-img2'], img: 'bgimg3'},
        {btn: btns['switcher-bg-img3'], img: 'bgimg4'},
        {btn: btns['switcher-bg-img4'], img: 'bgimg5'}
    ];

    bgImages.forEach((bg, idx) => {
        if(bg.btn) {
            const varName = `bgImg${idx+1}Var`;
            window[varName] = bg.btn.addEventListener('click', () => {
                html.setAttribute('data-bg-img', bg.img);
                localStorage.setItem("bgimg", bg.img);
            });
        }
    });

    /* ================= Theme Functions ================= */
    btns['switcher-light-theme']?.addEventListener('click', () => {
        lightFn();
        localStorage.setItem("vyzorHeader", 'light');
        localStorage.removeItem("bodylightRGB");
        localStorage.removeItem("bodyBgRGB");
        localStorage.removeItem("vyzorMenu");
        if(html.getAttribute('data-nav-layout') === 'horizontal') html.setAttribute('data-header-styles', 'transparent');
    });

    btns['switcher-dark-theme']?.addEventListener('click', () => {
        darkFn();
        localStorage.setItem("vyzorMenu", 'dark');
        localStorage.setItem("vyzorHeader", 'transparent');
        if(html.getAttribute('data-nav-layout') === 'horizontal') html.setAttribute('data-header-styles', 'dark');
    });

    /* ================= Menu Styles ================= */
    const menuStyles = [
        {btn: btns['switcher-menu-light'], style: 'light'},
        {btn: btns['switcher-menu-dark'], style: 'dark'},
        {btn: btns['switcher-menu-primary'], style: 'color'},
        {btn: btns['switcher-menu-gradient'], style: 'gradient'},
        {btn: btns['switcher-menu-transparent'], style: 'transparent'}
    ];

    menuStyles.forEach(m => {
        m.btn?.addEventListener('click', () => {
            html.setAttribute('data-menu-styles', m.style);
            localStorage.setItem("vyzorMenu", m.style);
        });
    });

    /* ================= Header Styles ================= */
    const headerStyles = [
        {btn: btns['switcher-header-light'], style: 'light'},
        {btn: btns['switcher-header-dark'], style: 'dark'},
        {btn: btns['switcher-header-primary'], style: 'color'},
        {btn: btns['switcher-header-gradient'], style: 'gradient'},
        {btn: btns['switcher-header-transparent'], style: 'transparent'}
    ];

    headerStyles.forEach(h => {
        h.btn?.addEventListener('click', () => {
            html.setAttribute('data-header-styles', h.style);
            localStorage.setItem("vyzorHeader", h.style);
        });
    });

    /* ================= Layout Styles ================= */
    const layoutBtns = [
        {btn: btns['switcher-default-width'], width: 'default', remove: ['vyzorboxed','vyzorfullwidth'], set: 'vyzordefaultwidth'},
        {btn: btns['switcher-boxed'], width: 'boxed', remove: ['vyzorfullwidth','vyzordefaultwidth'], set: 'vyzorboxed'}, // , extraFn: checkHoriMenu
        {btn: btns['switcher-full-width'], width: 'fullwidth', remove: ['vyzorboxed','vyzordefaultwidth'], set: 'vyzorfullwidth'}
    ];

    layoutBtns.forEach(l => {
        l.btn?.addEventListener('click', () => {
            html.classList.remove(...l.remove);
            html.classList.add(l.set);
            l.extraFn?.();
        });
    });

    /* ================= Reset All ================= */
    btns['reset-all']?.addEventListener('click', () => {
        ResetAllFn();
    });
}

// ================= Helper Functions =================
function lightFn() {
    const html = document.querySelector('html');
    html.setAttribute('data-theme-mode','light');
    html.setAttribute('data-menu-styles','light');
    html.setAttribute('data-header-styles','light');
    localStorage.setItem("vyzorlighttheme", true);
    localStorage.removeItem("vyzordarktheme");
}

function darkFn() {
    const html = document.querySelector('html');
    html.setAttribute('data-theme-mode','dark');
    html.setAttribute('data-menu-styles','dark');
    html.setAttribute('data-header-styles','dark');
    localStorage.setItem("vyzordarktheme", true);
    localStorage.removeItem("vyzorlighttheme");
}

function localStorageBackup2() {
    const html = document.querySelector('html');
    if (localStorage.vyzorMenu) html.setAttribute('data-menu-styles', localStorage.vyzorMenu);
    if (localStorage.vyzorHeader) html.setAttribute('data-header-styles', localStorage.vyzorHeader);
    if (localStorage.primaryRGB) html.style.setProperty('--primary-rgb', localStorage.primaryRGB);
}

function checkOptions() {
    const html = document.querySelector('html');
    if (!html.getAttribute('data-theme-mode')) lightFn();
}

function ResetAllFn() {
    const html = document.querySelector('html');
    localStorage.clear();
    html.removeAttribute('data-theme-mode');
    html.removeAttribute('data-menu-styles');
    html.removeAttribute('data-header-styles');
    html.classList.remove('vyzorboxed','vyzorfullwidth','vyzordefaultwidth');
}
