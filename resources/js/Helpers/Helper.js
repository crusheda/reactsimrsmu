import $ from "jquery";
import "datatables.net-bs5";
import "datatables.net-buttons-bs5";
import "datatables.net-buttons/js/buttons.html5.js";
import "datatables.net-buttons/js/buttons.print.js";
import "datatables.net-buttons/js/buttons.colVis.js";

import pdfMake from "pdfmake/build/pdfmake";
import pdfFonts from "pdfmake/build/vfs_fonts";

// fix VFS
pdfMake.vfs = pdfFonts.pdfMake ? pdfFonts.pdfMake.vfs : pdfFonts.vfs;


// ----------------------------------------------------------
// DataTable Helper Functions
// ----------------------------------------------------------
export const initDataTable = (
    selector, {
        orderCol = 0,
        sort = "desc",
        displayLength = 10,
        columnDefs = [],
        enableExport = false,
    } = {}
) => {
    if ($.fn.DataTable.isDataTable(selector)) {
        $(selector).DataTable().clear().destroy();
    }

    // 🔧 Hapus class default 'btn-secondary' dari tombol export bawaan DataTables
    $.extend(true, $.fn.dataTable.Buttons.defaults, {
        dom: {
            button: {
                className: '' // kosong agar class kita sendiri yang dipakai
            }
        }
    });

    const dtOptions = {
        order: [
            [orderCol, sort]
        ],
        pageLength: displayLength,
        lengthChange: true,
        lengthMenu: [10, 25, 50, 75, 100, 300, 500, 1000, 3000, 5000, 10000],
        columnDefs,
        responsive: true,
        retrieve: true,
        // Tambahkan mt-3 ke search box setelah render
        initComplete: function () {
            $(this.api().table().container())
                .find('.dt-search')
                .addClass('mb-3');
        }
    };

    if (enableExport) {
        dtOptions.dom = 'Bfrtip';
        dtOptions.buttons = [
            {
                extend: 'copyHtml5',
                text: '<i class="fas fa-copy me-1"></i> Copy',
                className: 'btn btn-secondary-light btn-sm'
            },
            {
                extend: 'excelHtml5',
                text: '<i class="fas fa-file-excel me-1"></i> Excel',
                className: 'btn btn-success-light btn-sm'
            },
            // {
            //     extend: 'csvHtml5',
            //     text: '<i class="fas fa-file-csv me-1"></i> CSV',
            //     className: 'btn btn-light-info btn-sm'
            // },
            {
                extend: 'pdfHtml5',
                text: '<i class="fas fa-file-pdf me-1"></i> PDF',
                className: 'btn btn-danger-light btn-sm'
            },
            {
                extend: 'print',
                text: '<i class="fas fa-print me-1"></i> Print',
                className: 'btn btn-info-light btn-sm'
            }
        ];
    }

    return $(selector).DataTable(dtOptions);
};

// -----------------------------------------------------------
// Loading Helper Function
// -----------------------------------------------------------
export const showLoading = (tbodyId, colspan) => {
    $(tbodyId)
        .empty()
        .append(
            `<tr><td colspan="${colspan}" style="font-size:13px"><center><i class="fa fa-spinner fa-spin fa-fw"></i> Memproses data...</center></td></tr>`
        );
};

// -----------------------------------------------------------
// Tooltip Helper Function
// -----------------------------------------------------------
export const initTooltips = (parent = document) => {
    if (!parent || !parent.querySelectorAll) return; // <-- safety check
    const tooltipTriggerList = [].slice.call(
        parent.querySelectorAll('[data-bs-toggle="tooltip"]')
    );
    tooltipTriggerList.forEach(el => {
        const existing = bootstrap.Tooltip.getInstance(el);
        if (existing) existing.dispose();
        new bootstrap.Tooltip(el);
    });
};

// export const initDropdowns = () => {
//     const dropdownTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="dropdown"]'));
//     dropdownTriggerList.forEach((el) => {
//         const existing = bootstrap.Dropdown.getInstance(el);
//         if (existing) existing.dispose();
//         new bootstrap.Dropdown(el);
//     });
// };
// export const reinitBootstrapComponents = () => {
//     initTooltips();
//     initDropdowns();
// };
