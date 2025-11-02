/**
 * File: resources/js/bootstrap.js
 * --------------------------------
 * Berisi semua import global CSS & JS dari template Blade lama
 * agar kompatibel dengan setup Vite + React + Inertia
 */

// jQuery
import $ from 'jquery';
window.$ = window.jQuery = $;

// Bootstrap 5
// import 'bootstrap/dist/css/bootstrap.min.css';
// import 'bootstrap/dist/js/bootstrap.bundle.min.js';

// ApexCharts
import ApexCharts from "apexcharts";
window.ApexCharts = ApexCharts;

// Axios
import axios from 'axios';
window.axios = axios;
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// iziToast
import 'izitoast/dist/css/iziToast.min.css';
import iziToast from 'izitoast';
window.iziToast = iziToast;
// import 'izitoast/dist/css/iziToast.min.css';
// import 'izitoast/dist/js/iziToast.min.js';

// MomentJS (Locale Indonesia)
import moment from 'moment';
import 'moment/locale/id';
moment.locale('id');
window.moment = moment;

// Dayjs (Locale Indonesia)
import dayjs from "dayjs";
import "dayjs/locale/id"; // untuk format tanggal Indonesia
dayjs.locale("id");
window.dayjs = dayjs;

// Flatpickr
import 'flatpickr/dist/flatpickr.min.css';
import flatpickr from 'flatpickr';
window.flatpickr = flatpickr;

// SweetAlert2
import Swal from 'sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
window.Swal = Swal;

// DataTables
// import 'datatables.net-bs5';
import "datatables.net-bs5/css/dataTables.bootstrap5.min.css";
import "datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css";
import JSZip from "jszip";
window.JSZip = JSZip;

// CropperJS
import 'cropperjs/dist/cropper.css';
import Cropper from 'cropperjs';
window.Cropper = Cropper;

// Animate.css
import 'animate.css/animate.min.css';

// Feather Icons (optional)
import feather from 'feather-icons';
window.feather = feather;

// Glightbox Gallery
import 'glightbox/dist/css/glightbox.min.css';
import GLightbox from 'glightbox';
window.GLightbox = GLightbox;

// Font Awesome (via npm) Versi terbaru
// import '@fortawesome/fontawesome-free/css/all.min.css';

// Izitoast
// import iziToast from "izitoast";

// Tambahan plugin lainnya (sesuai CSS lama kamu)
// import 'notifier-js/dist/css/notifier.css'; // jika kamu pakai Notifier
// import 'notifier-js'; // pastikan paket ini sudah diinstall

// Jalankan script init global
document.addEventListener('DOMContentLoaded', () => {
    // aktifkan feather icons
    if (feather) feather.replace();
});
