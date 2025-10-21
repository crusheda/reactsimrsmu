"use strict";

// Global initialization functions
const navbar = document.getElementById("sidebar");
const navbar1 = document.getElementById("header");

// Pastikan elemen ada sebelum mengambil offsetTop
const sticky = navbar ? navbar.offsetTop : 0;
const sticky1 = navbar1 ? navbar1.offsetTop : 0;

// Function untuk membuat sticky
function stickyFn() {
  if (navbar) {
    if (window.scrollY >= sticky) {
      navbar.classList.add("sticky-pin");
    } else {
      navbar.classList.remove("sticky-pin");
    }
  }

  if (navbar1) {
    if (window.scrollY >= sticky1) {
      navbar1.classList.add("sticky-pin");
    } else {
      navbar1.classList.remove("sticky-pin");
    }
  }
}

// IIFE untuk binding event
(() => {
  if (typeof window !== "undefined") {
    window.addEventListener('scroll', stickyFn);
    window.addEventListener('DOMContentLoaded', stickyFn);
  }
})();
