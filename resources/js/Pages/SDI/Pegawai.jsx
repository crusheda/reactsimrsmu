import React, { useEffect, useRef, useState } from "react";
import { Head, router } from "@inertiajs/react";
import MainLayout from "@/Layouts/MainLayout";
import { initDataTable, initTooltips, showLoading } from "@/Helpers/Helper";

const Pegawai = () => {
    // Modal state
    // const [showNonAktif, setShowNonAktif] = useState(false);
    // const [showNonLengkap, setShowNonLengkap] = useState(false);
    // const [showAktifKaryawan, setShowAktifKaryawan] = useState(false);

    // Loading state
    const [loadingTabelSimpel, setLoadingTabelSimpel] = useState(false);
    const [loadingTabelLengkap, setLoadingTabelLengkap] = useState(false);
    const [loadingTableNonLengkap, setLoadingTableNonLengkap] = useState(false);
    const [loadingTableNonAktif, setLoadingTableNonAktif] = useState(false);
    const [loadingAktifkanKaryawan, setLoadingAktifkanKaryawan] =
        useState(false);

    // Ref untuk grafik
    const grafikRef = useRef(null);
    const [grafik, setGrafik] = useState(null);
    const [grafikTitle, setGrafikTitle] = useState("");

    // ============ AJAX FUNCTIONS ==============
    const refresh = () => {
        $("#table2").attr("hidden", true);
        $("#table1").removeAttr("hidden");
        // Table simpel
        setLoadingTabelSimpel(true);
        showLoading("#tampil-tbody", 9);
        $.ajax({
            url: "/api/v4/sdi/pegawai/table",
            type: "GET",
            dataType: "json",
            success: (res) => {
                if ($.fn.DataTable.isDataTable("#dttable")) {
                    $("#dttable").DataTable().clear().destroy();
                }
                $("#tampil-tbody").empty();
                let content = "";
                res.show.forEach((item) => {
                    content += "<tr id='data" + item.id + "'>";
                    content += `<td class="text-center align-middle">
                                    <div class="btn-group">
                                        <button class="btn btn-sm btn-outline-light btn-wave dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                            data-bs-auto-close="true" aria-expanded="false">
                                            ${item.id}
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="defaultDropdown">
                                            <li><a href="javascript:void(0);" class="dropdown-item btn-profil-pegawai" data-id="${item.id}"><i class="fa-fw fas fa-search nav-icon me-1"></i> Lihat Profil</a></li>
                                        </ul>
                                    </div>
                                </td>`;
                    content += `<td>${item.name}</td>`;
                    content += `<td>${
                        item.nama
                            ? item.nama
                            : '<b class="text-danger">Data Tidak Valid</b>'
                    }</td>`;
                    content +=
                        "<td>" +
                        new Date(item.updated_at).toLocaleString("sv-SE") +
                        "</td>";
                    content += `</tr>`;
                });
                $("#tampil-tbody").append(content);
                $(".btn-profil-pegawai")
                    .off("click")
                    .on("click", function () {
                        router.visit(
                            route(
                                "v4.sdi.pegawai.profil.index",
                                $(this).data("id")
                            )
                        );
                    });
                // initDataTable("#dttable", { orderCol: 3, enableExport: true });
                initDataTable("#dttable", {
                    orderCol: 3,
                    sort: "desc",
                    displayLength: 20,
                    columnDefs: [
                        { width: "10%", targets: 0 },
                        { width: "20%", targets: 1 },
                        { width: "55%", targets: 2 },
                        { width: "15%", targets: 3 },
                    ],
                    enableExport: false,
                });
                initTooltips(document.querySelector("#tampil-tbody"));
            },
            error: () => {
                iziToast.error({
                    title: "Pesan Galat!",
                    message: "Proses memuat Data Gagal!",
                    position: "topRight",
                });
                setLoadingTabelSimpel(false);
            },
            complete: () => {
                setLoadingTabelSimpel(false);
            },
        });
    };

    const showAll = () => {
        $("#table1").attr("hidden", true);
        $("#table2").removeAttr("hidden");
        // Table lengkap
        setLoadingTabelLengkap(true);
        showLoading("#tampil-tbody-all", 20);
        $.ajax({
            url: "/api/v4/sdi/pegawai/tableall",
            type: "GET",
            dataType: "json",
            success: (res) => {
                if ($.fn.DataTable.isDataTable("#dttable-all")) {
                    $("#dttable-all").DataTable().clear().destroy();
                }
                $("#tampil-tbody-all").empty();
                let content = "";
                let pNama = "";
                res.show.forEach((item) => {
                    content += "<tr id='data" + item.id + "'>";
                    content += `<td><center><div class='btn-group'>
                                        <button class="btn btn-sm btn-outline-light btn-wave dropdown-toggle ${
                                            item.nik
                                                ? "text-primary"
                                                : "text-danger"
                                        }" type="button" data-bs-toggle="dropdown"
                                            data-bs-auto-close="true" aria-expanded="false">${
                                                item.id
                                            }</button>
                                    <ul class='dropdown-menu dropdown-menu-right'>`;
                    content += `<li><a href="/v4/sdi/pegawai/${item.id}" class='dropdown-item text-primary'><i class="fa-fw fas fa-search nav-icon me-1"></i> Lihat Profil</a></li>`;
                    content += `</div></center></td>`;
                    content += `<td>${item.nip ? item.nip : "-"}</td>`;
                    content += `<td>${item.nik ? item.nik : "-"}</td>`;
                    content += `<td>${item.name}</td>`;
                    if (item.nama_lengkap) {
                        pNama = item.nama_lengkap;
                    } else {
                        if (item.nama) {
                            pNama = item.nama;
                        } else {
                            pNama = "-";
                        }
                    }
                    content += `<td>${pNama}</td>`;
                    content += `<td>${item.nick ? item.nick : "-"}</td>`;
                    content += `<td>${item.temp_lahir ? item.temp_lahir : "-"}${
                        item.tgl_lahir ? ", " + item.tgl_lahir : ""
                    }</td>`;
                    content += `<td>${
                        item.jns_kelamin ? item.jns_kelamin : "-"
                    }</td>`;
                    content += `<td>${
                        item.status_kawin ? item.status_kawin : "-"
                    }</td>`;
                    content += `<td>${
                        item.status_pegawai ? item.status_pegawai : "-"
                    }</td>`;
                    content += `<td>`;
                    res.role.forEach((val) => {
                        if (item.id == val.id_user) {
                            content +=
                                "<span class='badge bg-primary-transparent me-1'>" +
                                val.nama_role +
                                "</span>";
                        }
                    });
                    content += `</td>`;
                    content += `<td>${
                        item.klasifikasi_user ? item.klasifikasi_user : "-"
                    }</td>`;
                    content += `<td>${
                        item.masuk_kerja ? item.masuk_kerja : "-"
                    }</td>`;
                    content += `<td>${
                        item.urutan_masuk ? item.urutan_masuk : "-"
                    }</td>`;
                    content += `<td>${item.tmt ? item.tmt : "-"}</td>`;
                    content += `<td>${item.tat ? item.tat : "-"}</td>`;
                    content += `<td>${item.no_hp ? item.no_hp : "-"}</td>`;
                    content += `<td>${item.email ? item.email : "-"}</td>`;
                    content += `<td>${item.fb ? item.fb : "-"}</td>`;
                    content += `<td>${item.ig ? item.ig : "-"}</td>`;
                    content += `<td>${item.tt ? item.tt : "-"}</td>`;
                    content += `<td>${
                        item.ktp_kelurahan ? item.ktp_kelurahan : "-"
                    }</td>`;
                    content += `<td>${
                        item.ktp_kecamatan ? item.ktp_kecamatan : "-"
                    }</td>`;
                    content += `<td>${
                        item.ktp_kabupaten ? item.ktp_kabupaten : "-"
                    }</td>`;
                    content += `<td>${
                        item.ktp_provinsi ? item.ktp_provinsi : "-"
                    }</td>`;
                    content += `<td>${
                        item.alamat_ktp ? item.alamat_ktp : "-"
                    }</td>`;
                    content += `<td>${
                        item.dom_kelurahan ? item.dom_kelurahan : "-"
                    }</td>`;
                    content += `<td>${
                        item.dom_kecamatan ? item.dom_kecamatan : "-"
                    }</td>`;
                    content += `<td>${
                        item.dom_kabupaten ? item.dom_kabupaten : "-"
                    }</td>`;
                    content += `<td>${
                        item.dom_provinsi ? item.dom_provinsi : "-"
                    }</td>`;
                    content += `<td>${
                        item.alamat_dom ? item.alamat_dom : "-"
                    }</td>`;
                    content += `<td>${item.sd ? item.sd : "-"} ${
                        item.th_sd ? " (" + item.th_sd + ")" : ""
                    }</td>`;
                    content += `<td>${item.smp ? item.smp : "-"} ${
                        item.th_smp ? " (" + item.th_smp + ")" : ""
                    }</td>`;
                    content += `<td>${item.sma ? item.sma : "-"} ${
                        item.th_sma ? " (" + item.th_sma + ")" : ""
                    }</td>`;
                    content += `<td>${item.d1 ? item.d1 : "-"} ${
                        item.th_d1 ? " (" + item.th_d1 + ")" : ""
                    }</td>`;
                    content += `<td>${item.d2 ? item.d2 : "-"} ${
                        item.th_d2 ? " (" + item.th_d2 + ")" : ""
                    }</td>`;
                    content += `<td>${item.d3 ? item.d3 : "-"} ${
                        item.th_d3 ? " (" + item.th_d3 + ")" : ""
                    }</td>`;
                    content += `<td>${item.d4 ? item.d4 : "-"} ${
                        item.th_d4 ? " (" + item.th_d4 + ")" : ""
                    }</td>`;
                    content += `<td>${item.s1 ? item.s1 : "-"} ${
                        item.th_s1 ? " (" + item.th_s1 + ")" : ""
                    }</td>`;
                    content += `<td>${
                        item.s1_profesi ? item.s1_profesi : "-"
                    } ${
                        item.th_s1_profesi
                            ? " (" + item.th_s1_profesi + ")"
                            : ""
                    }</td>`;
                    content += `<td>${item.s2 ? item.s2 : "-"} ${
                        item.th_s2 ? " (" + item.th_s2 + ")" : ""
                    }</td>`;
                    content += `<td>${item.s3 ? item.s3 : "-"} ${
                        item.th_s3 ? " (" + item.th_s3 + ")" : ""
                    }</td>`;
                    content += `<td>${
                        item.pengalaman_kerja ? item.pengalaman_kerja : "-"
                    }</td>`;
                    content += `<td>${
                        item.riwayat_penyakit ? item.riwayat_penyakit : "-"
                    }</td>`;
                    content += `<td>${
                        item.riwayat_penyakit_keluarga
                            ? item.riwayat_penyakit_keluarga
                            : "-"
                    }</td>`;
                    content += `<td>${
                        item.riwayat_operasi ? item.riwayat_operasi : "-"
                    }</td>`;
                    content += `<td>${
                        item.riwayat_penggunaan_obat
                            ? item.riwayat_penggunaan_obat
                            : "-"
                    }</td>`;
                    content +=
                        "<td>" +
                        new Date(item.updated_at).toLocaleString("sv-SE") +
                        "</td>";
                    content += `</tr>`;
                });
                $("#tampil-tbody-all").append(content);
                initDataTable("#dttable-all", {
                    orderCol: 47,
                    sort: "desc",
                    displayLength: 20,
                    columnDefs: [
                        { visible: false, targets: [5] },
                        { visible: false, targets: [7] },
                        { visible: false, targets: [8] },
                        { visible: false, targets: [11] },
                        { visible: false, targets: [12] },
                        { visible: false, targets: [13] },
                        { visible: false, targets: [14] },
                        { visible: false, targets: [15] },
                        { visible: false, targets: [17] },
                        { visible: false, targets: [18] },
                        { visible: false, targets: [19] },
                        { visible: false, targets: [20] },
                        { visible: false, targets: [21] },
                        { visible: false, targets: [22] },
                        { visible: false, targets: [23] },
                        { visible: false, targets: [24] },
                        { visible: false, targets: [26] },
                        { visible: false, targets: [27] },
                        { visible: false, targets: [28] },
                        { visible: false, targets: [29] },
                        { visible: false, targets: [30] },
                        { visible: false, targets: [31] },
                        { visible: false, targets: [32] },
                        { visible: false, targets: [33] },
                        { visible: false, targets: [34] },
                        { visible: false, targets: [35] },
                        { visible: false, targets: [36] },
                        { visible: false, targets: [37] },
                        { visible: false, targets: [38] },
                        { visible: false, targets: [39] },
                        { visible: false, targets: [40] },
                        { visible: false, targets: [41] },
                        { visible: false, targets: [42] },
                        { visible: false, targets: [43] },
                        { visible: false, targets: [44] },
                        { visible: false, targets: [45] },
                        { visible: false, targets: [46] },
                    ],
                    enableExport: true,
                });
                initTooltips(document.querySelector("#tampil-tbody-all"));
            },
            error: () => {
                iziToast.error({
                    title: "Pesan Galat!",
                    message: "Proses memuat Data Lengkap Gagal!",
                    position: "topRight",
                });
            },
            complete: () => {
                setLoadingTabelLengkap(false);
            },
        });
    };

    const showGrafik = () => {
        // Tampilkan card grafik
        $("#show-card-grafik").prop("hidden", false);

        // Sembunyikan tombol
        $("#btn-show-grafik").prop("hidden", true);

        // Jalankan fungsi loadGrafik
        loadGrafik(5, "Berdasarkan Status Pegawai");
    };

    const hideGrafik = () => {
        $("#show-card-grafik").prop("hidden", true);
        $("#btn-show-grafik").prop("hidden", false);
    };

    const [isCheckedAktifKaryawan, setIsCheckedAktifKaryawan] = useState(false);
    const [idAktifKaryawan, setIdAktifKaryawan] = useState("");

    const refreshNonAktif = () => {
        setLoadingTableNonAktif(true);
        showLoading("#tampil-tbody-nonaktif", 9);
        $.ajax({
            url: "/api/profilkaryawan/nonaktif",
            type: "GET",
            dataType: "json",
            success: (res) => {
                if ($.fn.DataTable.isDataTable("#dttable-nonaktif")) {
                    $("#dttable-nonaktif").DataTable().clear().destroy();
                }
                $("#tampil-tbody-nonaktif").empty();
                res.show.forEach((item) => {
                    let urlShow = `/kepegawaian/profilkaryawan/${item.id}`;
                    let pNama = "";
                    if (item.nama_lengkap) {
                        pNama = item.nama_lengkap;
                    } else {
                        if (item.nama) {
                            pNama = item.nama;
                        } else {
                            pNama = "-";
                        }
                    }
                    $("#tampil-tbody-nonaktif").append(`
                        <tr>
                            <td><center>${item.id}</center></td>
                            <td>${item.name}</td>
                            <td>${pNama}</td>
                            <td>${new Date(item.deleted_at).toLocaleString(
                                "sv-SE"
                            )}</td>
                            <td>
                                <center>
                                    <div class='btn-group'>
                                        <a href="${urlShow}" class='btn btn-sm btn-info-light'>
                                            <i class='fa-fw fas fa-file-archive nav-icon me-1'></i> Lihat Profil
                                        </a>
                                        <a href='javascript:void(0);' class='btn btn-sm btn-success-light btn-aktifkan-karyawan' data-id='${
                                            item.id
                                        }'>
                                            <i class='fas fa-user-check me-1'></i> Aktifkan
                                        </a>
                                    </div>
                                </center>
                            </td>
                        </tr>
                    `);
                });

                $(".btn-aktifkan-karyawan")
                    .off("click")
                    .on("click", function () {
                        modalAktifkanKaryawan($(this).data("id"));
                    });

                initDataTable("#dttable-nonaktif", {
                    orderCol: 3,
                    sort: "desc",
                    displayLength: 10,
                    columnDefs: [],
                    enableExport: false,
                });
            },
            error: () => {
                iziToast.error({
                    title: "Pesan Galat!",
                    message: "Proses memuat Data Pegawai Nonaktif Gagal!",
                    position: "topRight",
                });
                setLoadingTableNonAktif(false);
            },
            complete: () => {
                setLoadingTableNonAktif(false);
            },
        });
    };

    const modalAktifkanKaryawan = (id) => {
        setIdAktifKaryawan(id);
        setIsCheckedAktifKaryawan(false);

        // $(".modal.show").each(function () {
        //     const modalInstance = bootstrap.Modal.getInstance(this);
        //     if (modalInstance) modalInstance.hide();
        // });

        const modalNonAktif = bootstrap.Modal.getInstance(
            document.getElementById("karyawanNonAktif")
        );
        if (modalNonAktif) modalNonAktif.hide();

        const modalAktif = new bootstrap.Modal(
            document.getElementById("aktifkanKaryawan")
        );
        modalAktif.show();
    };

    const batalNonAktif = async () => {
        if (!isCheckedAktifKaryawan) {
            iziToast.error({
                title: "Pesan Galat!",
                message:
                    "Mohon menyetujui untuk melakukan pengaktifan karyawan kembali",
                position: "topRight",
            });
            return;
        }

        setLoadingAktifkanKaryawan(true);
        $.ajax({
            url: `/api/v4/sdi/pegawai/setaktif/${idAktifKaryawan}`,
            type: "GET",
            dataType: "json",
            beforeSend: function () {
                // Bisa tambahkan indikator loading jika mau
                console.log("Mengaktifkan karyawan...");
            },
            success: function (res) {
                iziToast.success({
                    title: "Sukses!",
                    message: `User ID: ${idAktifKaryawan} sukses diaktifkan kembali pada ${res}`,
                    position: "topRight",
                });

                // Tutup modal Bootstrap
                const modalEl = document.getElementById("aktifkanKaryawan");
                const modal = bootstrap.Modal.getInstance(modalEl);
                if (modal) modal.hide();

                // Refresh tabel / data
                refreshNonAktif();
                refresh();
            },
            error: function (xhr, status, error) {
                console.error("Error:", status, error);
                iziToast.error({
                    title: "Pesan Galat!",
                    message: "Gagal mengaktifkan Pegawai!",
                    position: "topRight",
                });
                setLoadingAktifkanKaryawan(false);
            },
            complete: function () {
                setLoadingAktifkanKaryawan(false);
            },
        });
    };

    const refreshNonLengkap = () => {
        setLoadingTableNonLengkap(true);
        showLoading("#tampil-tbody-nonlengkap", 9);
        $.ajax({
            url: "/api/profilkaryawan/nonlengkap",
            type: "GET",
            dataType: "json",
            success: (res) => {
                if ($.fn.DataTable.isDataTable("#dttable-nonlengkap")) {
                    $("#dttable-nonlengkap").DataTable().clear().destroy();
                }
                $("#tampil-tbody-nonlengkap").empty();
                res.show.forEach((item) => {
                    $("#tampil-tbody-nonlengkap").append(`
                        <tr>
                            <td><center>${item.id}</center></td>
                            <td>${item.name}</td>
                            <td>${new Date(item.created_at).toLocaleString(
                                "sv-SE"
                            )}</td>
                        </tr>
                    `);
                });
                initDataTable("#dttable-nonlengkap", {
                    orderCol: 2,
                    sort: "desc",
                    displayLength: 10,
                    columnDefs: [],
                    enableExport: false,
                });
            },
            error: () => {
                iziToast.error({
                    title: "Pesan Galat!",
                    message:
                        "Proses memuat Data Profil Pegawai Yang Tidak lengkap Gagal!",
                    position: "topRight",
                });
                setLoadingTableNonLengkap(fales);
            },
            complete: () => {
                setLoadingTableNonLengkap(false);
            },
        });
    };

    // ============ GRAFIK ==============
    const loadGrafik = (id, title) => {
        $.ajax({
            url: `/api/v4/sdi/pegawai/grafik/${id}`,
            type: "GET",
            dataType: "json",
            success: (res) => {
                setGrafikTitle({
                    title,
                    belumMasuk: res.belumMasuk,
                });

                if (grafik) {
                    grafik.destroy();
                    setGrafik(null);
                }

                const options = {
                    chart: { type: "pie", width: "100%" },
                    labels: res.labels,
                    series: res.series,
                    colors: [
                        "#4680FF",
                        "#FFB946",
                        "#4BC0C0",
                        "#FF6384",
                        "#9966FF",
                        "#212529",
                        "#FF8BF2",
                        "#3EFF73",
                    ],
                    legend: { show: true, position: "bottom" },
                    dataLabels: {
                        enabled: true,
                        formatter: (val) => val.toFixed(1) + "%",
                    },
                    plotOptions: {
                        pie: {
                            donut: {
                                size: "65%",
                                labels: {
                                    show: true,
                                    total: {
                                        show: true,
                                        label: "Total",
                                        formatter: (w) =>
                                            w.globals.seriesTotals.reduce(
                                                (a, b) => a + b,
                                                0
                                            ),
                                    },
                                },
                            },
                        },
                    },
                    stroke: { show: true, width: 1, colors: ["#fff"] },
                };

                // Render chart ke elemen
                const grafikInstance = new ApexCharts(
                    $("#grafik-show")[0],
                    options
                );
                grafikInstance.render().then(() => {
                    // Ambil warna chart
                    let chartColors = grafikInstance.w.config.colors;

                    // Hitung total
                    var total = res.series.reduce((a, b) => a + b, 0);
                    var listHTML = "";

                    res.labels.forEach(function (label, i) {
                        var jumlah = res.series[i];
                        var persen =
                            total > 0 ? ((jumlah / total) * 100).toFixed(1) : 0;

                        listHTML += `
                        <li class="list-group-item">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="avtar avtar-s">
                                        <i class="ti ti-player-record f-40" style="color: ${
                                            chartColors[i]
                                        }"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <div class="row g-1">
                                        <div class="col-6">
                                            <h6 class="text-dark mb-1">${label}</h6>
                                            <a class="text-muted"><i>REFID # ${
                                                res.refid[i]
                                            }</i></a>
                                        </div>
                                        <div class="col-6 text-end">
                                            <h6 class="mb-1"><b class="text-${
                                                jumlah == 0 ? "dark" : "danger"
                                            }">${jumlah}</b> Pegawai</h6>
                                            <a class="text-success mb-0">${persen}%</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    `;
                    });

                    $("#list-grafik").html(listHTML);
                });

                setGrafik(grafikInstance);
            },
            error: () => {
                iziToast.error({
                    title: "Pesan Galat!",
                    message: "Gagal memuat grafik!",
                    position: "topRight",
                });
            },
        });
    };

    // ============ INITIALIZE ==============
    useEffect(() => {
        refresh();
        initTooltips();
        // refreshNonAktif();
        // refreshNonLengkap();
        // showGrafikStatusPegawai();
    }, []);

    return (
        <>
            <Head>
                <title>Daftar Pegawai RS</title>
            </Head>

            <div className="container-fluid page-container main-body-container">
                {/* Style */}
                <style>
                    {`
                        #grafik-show {
                            width: 100%;
                            aspect-ratio: 1/1;
                            max-height: 500px;
                        }
                    `}
                </style>

                <div className="page-header-breadcrumb mb-3">
                    <div className="d-flex align-center justify-content-between flex-wrap">
                        <h1 className="page-title fw-medium fs-18 mb-0">
                            Table Pegawai <b className="text-primary">RS</b>
                        </h1>
                        <ol className="breadcrumb mb-0">
                            <li className="breadcrumb-item">
                                <a role="button">SDI</a>
                            </li>
                            <li
                                className="breadcrumb-item active"
                                aria-current="page"
                            >
                                Daftar Pegawai
                            </li>
                        </ol>
                    </div>
                </div>

                {/* Main Content */}
                <div className="row pt-1">
                    {/* Grafik Card */}
                    <div className="col-sm-12" id="show-card-grafik" hidden>
                        <div className="card">
                            <div className="card-body p-4 pb-1">
                                <div className="d-flex align-items-center mb-2">
                                    <div className="flex-grow-1">
                                        <h5 className="mb-0">
                                            <i className="ph-duotone ph-database me-1"></i>{" "}
                                            Grafik Interaktif Pegawai
                                            <button
                                                className="btn btn-sm btn-icon btn-danger-light ms-2 rounded-pill btn-wave"
                                                id="btn-hide-grafik"
                                                onClick={() => hideGrafik()}
                                                data-bs-toggle="tooltip"
                                                data-bs-offset="0,4"
                                                data-bs-placement="bottom"
                                                data-bs-html="true"
                                                title="Sembunyikan Grafik"
                                            >
                                                <i className="fa fa-times"></i>
                                            </button>
                                        </h5>
                                    </div>
                                    <div className="flex-shrink-0 ms-3">
                                        <div className="dropdown">
                                            <a
                                                className="btn btn-light-secondary dropdown-toggle arrow-none"
                                                href="#"
                                                data-bs-toggle="dropdown"
                                            >
                                                <i className="ti ti-grid-dots f-18 me-1"></i>{" "}
                                                Pilihan Grafik
                                            </a>
                                            <div className="dropdown-menu dropdown-menu-end">
                                                <a
                                                    className="dropdown-item"
                                                    href="#"
                                                    onClick={() =>
                                                        loadGrafik(
                                                            1,
                                                            "Berdasarkan Jenis Pegawai"
                                                        )
                                                    }
                                                >
                                                    Jenis Pegawai
                                                </a>
                                                <a
                                                    className="dropdown-item"
                                                    href="#"
                                                    onClick={() =>
                                                        loadGrafik(
                                                            2,
                                                            "Berdasarkan Jenis Kelamin Pegawai"
                                                        )
                                                    }
                                                >
                                                    Jenis Kelamin
                                                </a>
                                                <a
                                                    className="dropdown-item"
                                                    href="#"
                                                    onClick={() =>
                                                        loadGrafik(
                                                            3,
                                                            "Berdasarkan Pendidikan Pegawai"
                                                        )
                                                    }
                                                >
                                                    Pendidikan
                                                </a>
                                                <a
                                                    className="dropdown-item"
                                                    href="#"
                                                    onClick={() =>
                                                        loadGrafik(
                                                            4,
                                                            "Berdasarkan Profesi Pegawai"
                                                        )
                                                    }
                                                >
                                                    Profesi
                                                </a>
                                                <a
                                                    className="dropdown-item"
                                                    href="#"
                                                    onClick={() =>
                                                        loadGrafik(
                                                            5,
                                                            "Berdasarkan Status Pegawai"
                                                        )
                                                    }
                                                >
                                                    Status Pegawai
                                                </a>
                                                <a
                                                    className="dropdown-item"
                                                    href="#"
                                                    onClick={() =>
                                                        loadGrafik(
                                                            6,
                                                            "Berdasarkan Status Perkawinan Pegawai"
                                                        )
                                                    }
                                                >
                                                    Status Perkawinan
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div className="row mb-3">
                                <div className="col-md-7 border-end">
                                    <ul
                                        className="list-group list-group-flush"
                                        id="list-grafik"
                                    ></ul>
                                </div>
                                <div className="col-md-5 align-items-center">
                                    <h5 className="text-center my-2">
                                        {grafikTitle.title}{" "}
                                        {grafikTitle.belumMasuk ? (
                                            <b className="text-danger">
                                                ({grafikTitle.belumMasuk}{" "}
                                                pegawai belum lengkap)
                                            </b>
                                        ) : (
                                            ''
                                        )}
                                    </h5>
                                    <div
                                        id="grafik-show"
                                        ref={grafikRef}
                                        style={{
                                            width: "100%",
                                            minHeight: "400px",
                                            height: "100%",
                                        }}
                                    ></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {/* Pegawai Card */}
                    <div className="col-sm-12">
                        <div className="card">
                            <div className="card-header d-flex align-items-center justify-content-between py-3">
                                <div className="btn-group shadow">
                                    <button
                                        className="btn btn-primary btn-wave"
                                        onClick={() =>
                                            (window.location.href =
                                                "/akunpengguna")
                                        }
                                        data-bs-toggle="tooltip"
                                        data-bs-offset="0,4"
                                        data-bs-placement="bottom"
                                        data-bs-html="true"
                                        title="Pengaturan Akun Pegawai"
                                        disabled={true}
                                    >
                                        <i className="fas fa-users-cog me-1"></i>{" "}
                                        Pengaturan Akun
                                    </button>

                                    <button
                                        className="btn btn-warning-light btn-wave"
                                        id="btn-tabel-simpel"
                                        onClick={() => refresh()}
                                        data-bs-toggle="tooltip"
                                        data-bs-offset="0,4"
                                        data-bs-placement="bottom"
                                        data-bs-html="true"
                                        title="Menampilkan Data Simpel Pegawai"
                                    >
                                        <i
                                            className={`fas me-1 ${
                                                loadingTabelSimpel
                                                    ? "fa-sync fa-spin"
                                                    : "ri-table-line"
                                            }`}
                                        ></i>
                                        Tabel Simpel
                                    </button>

                                    <button
                                        className="btn btn-danger-light btn-wave"
                                        id="btn-tabel-lengkap"
                                        onClick={() => showAll()}
                                        data-bs-toggle="tooltip"
                                        data-bs-offset="0,4"
                                        data-bs-placement="bottom"
                                        data-bs-html="true"
                                        title="Menampilkan Seluruh Data Profil Pegawai"
                                    >
                                        <i
                                            className={`fas me-1 ${
                                                loadingTabelLengkap
                                                    ? "fa-sync fa-spin"
                                                    : "ri-infinity-line"
                                            }`}
                                        ></i>
                                        Tabel Lengkap
                                    </button>

                                    <button
                                        className="btn btn-info-light btn-wave"
                                        id="btn-show-grafik"
                                        onClick={() => showGrafik()}
                                        data-bs-toggle="tooltip"
                                        data-bs-offset="0,4"
                                        data-bs-placement="bottom"
                                        data-bs-html="true"
                                        title="Menampilkan Grafik Data Pegawai"
                                    >
                                        <i class="ri-pie-chart-2-line me-1"></i>
                                        Tampilkan Grafik
                                    </button>
                                </div>

                                <div className="">
                                    <button
                                        className="btn btn-sm btn-outline-primary shadow-sm btn-wave"
                                        data-bs-toggle="dropdown"
                                        data-bs-auto-close="true"
                                        type="button"
                                        onClick={() => {}}
                                    >
                                        <i
                                            className="ti ti-dots-vertical f-18"
                                            data-bs-toggle="tooltip"
                                            data-bs-offset="0,4"
                                            data-bs-placement="left"
                                            data-bs-html="true"
                                            title="Pilihan Menu Lainnya"
                                        ></i>
                                    </button>
                                    <ul className="dropdown-menu">
                                        <li>
                                            <button
                                                className="dropdown-item"
                                                onClick={() => {
                                                    const modal =
                                                        new bootstrap.Modal(
                                                            document.getElementById(
                                                                "profilNonLengkap"
                                                            )
                                                        );
                                                    modal.show();
                                                    refreshNonLengkap();
                                                }}
                                            >
                                                Profil Belum Lengkap
                                            </button>
                                            <button
                                                className="dropdown-item"
                                                onClick={() => {
                                                    const modal =
                                                        new bootstrap.Modal(
                                                            document.getElementById(
                                                                "karyawanNonAktif"
                                                            )
                                                        );
                                                    modal.show();
                                                    refreshNonAktif();
                                                }}
                                            >
                                                Karyawan Nonaktif
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div className="card-body p-3">
                                <div className="alert alert-light shadow-sm">
                                    <small>
                                        <i className="fa-fw fas fa-caret-right nav-icon me-1"></i>{" "}
                                        Refresh browser Anda apabila terjadi
                                        Error saat pengambilan data karyawan
                                    </small>
                                    <br />
                                    <small>
                                        <i className="fa-fw fas fa-caret-right nav-icon me-1"></i>{" "}
                                        Klik pada{" "}
                                        <u className="text-primary">
                                            <b>#ID Karyawan</b>
                                        </u>{" "}
                                        untuk melihat Profil
                                    </small>
                                </div>

                                {/* Table Simpel */}
                                <div className="table-responsive" id="table1">
                                    <table
                                        id="dttable"
                                        className="table table-hover text-nowrap w-100 dataTable no-footer"
                                    >
                                        <thead>
                                            <tr>
                                                <th className="cell-fit">
                                                    <center>#ID</center>
                                                </th>
                                                <th className="cell-fit">
                                                    AKUN / USERNAME
                                                </th>
                                                <th className="cell-fit">
                                                    NAMA LENGKAP
                                                </th>
                                                <th className="cell-fit">
                                                    TERAKHIR DIPERBARUI
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody id="tampil-tbody">
                                            <tr>
                                                <td
                                                    colSpan="9"
                                                    style={{ fontSize: "13px" }}
                                                >
                                                    <center>
                                                        <i className="fa fa-spinner fa-spin fa-fw"></i>{" "}
                                                        Memproses data...
                                                    </center>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                {/* Table Lengkap */}
                                <div
                                    className="table-responsive"
                                    id="table2"
                                    hidden
                                >
                                    <table
                                        id="dttable-all"
                                        className="table align-middle dt-responsive table-hover nowrap w-100"
                                    >
                                        <thead>
                                            <tr>
                                                <th className="cell-fit">ID</th>
                                                <th>NIP</th>
                                                <th>NIK</th>
                                                <th>USERNAME</th>
                                                <th>NAMA LENGKAP</th>
                                                <th>PANGGILAN</th>
                                                <th>TMPT/TGL LAHIR</th>
                                                <th>JENIS KELAMIN</th>
                                                <th>STATUS KAWIN</th>
                                                <th>STATUS PEGAWAI</th>
                                                <th>JABATAN</th>
                                                <th>KLASIFIKASI</th>
                                                <th>MASUK KERJA</th>
                                                <th>URUTAN MASUK</th>
                                                <th>TMT</th>
                                                <th>TAT</th>
                                                <th>NO.HP</th>
                                                <th>EMAIL</th>
                                                <th>FB</th>
                                                <th>IG</th>
                                                <th>TT</th>
                                                <th>KELURAHAN (KTP)</th>
                                                <th>KECAMATAN (KTP)</th>
                                                <th>KABUPATEN (KTP)</th>
                                                <th>PROVINSI (KTP)</th>
                                                <th className="cell-fit">
                                                    ALAMAT (KTP)
                                                </th>
                                                <th>KELURAHAN (DOM)</th>
                                                <th>KECAMATAN (DOM)</th>
                                                <th>KABUPATEN (DOM)</th>
                                                <th>PROVINSI (DOM)</th>
                                                <th className="cell-fit">
                                                    ALAMAT (DOM)
                                                </th>
                                                <th>SD</th>
                                                <th>SMP</th>
                                                <th>SMA</th>
                                                <th>D1</th>
                                                <th>D2</th>
                                                <th>D3</th>
                                                <th>D4</th>
                                                <th>S1</th>
                                                <th>S1 PROFESI</th>
                                                <th>S2</th>
                                                <th>S3</th>
                                                <th className="cell-fit">
                                                    PENGALAMAN KERJA
                                                </th>
                                                <th>RIWAYAT PENYAKIT</th>
                                                <th>
                                                    RIWAYAT PENYAKIT KELUARGA
                                                </th>
                                                <th>RIWAYAT OPERASI</th>
                                                <th>RIWAYAT PENGGUNAAN OBAT</th>
                                                <th className="cell-fit">
                                                    UPDATE
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody id="tampil-tbody-all">
                                            <tr>
                                                <td colSpan="9">
                                                    <center>
                                                        <i className="fa fa-spinner fa-spin fa-fw"></i>{" "}
                                                        Memproses data...
                                                    </center>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th className="cell-fit">ID</th>
                                                <th>NIP</th>
                                                <th>NIK</th>
                                                <th>USERNAME</th>
                                                <th>NAMA LENGKAP</th>
                                                <th>PANGGILAN</th>
                                                <th>TMPT/TGL LAHIR</th>
                                                <th>JENIS KELAMIN</th>
                                                <th>STATUS KAWIN</th>
                                                <th>STATUS PEGAWAI</th>
                                                <th>JABATAN</th>
                                                <th>KLASIFIKASI</th>
                                                <th>MASUK KERJA</th>
                                                <th>URUTAN MASUK</th>
                                                <th>TMT</th>
                                                <th>TAT</th>
                                                <th>NO.HP</th>
                                                <th>EMAIL</th>
                                                <th>FB</th>
                                                <th>IG</th>
                                                <th>TT</th>
                                                <th>KELURAHAN (KTP)</th>
                                                <th>KECAMATAN (KTP)</th>
                                                <th>KABUPATEN (KTP)</th>
                                                <th>PROVINSI (KTP)</th>
                                                <th className="cell-fit">
                                                    ALAMAT (KTP)
                                                </th>
                                                <th>KELURAHAN (DOM)</th>
                                                <th>KECAMATAN (DOM)</th>
                                                <th>KABUPATEN (DOM)</th>
                                                <th>PROVINSI (DOM)</th>
                                                <th className="cell-fit">
                                                    ALAMAT (DOM)
                                                </th>
                                                <th>SD</th>
                                                <th>SMP</th>
                                                <th>SMA</th>
                                                <th>D1</th>
                                                <th>D2</th>
                                                <th>D3</th>
                                                <th>D4</th>
                                                <th>S1</th>
                                                <th>S1 PROFESI</th>
                                                <th>S2</th>
                                                <th>S3</th>
                                                <th className="cell-fit">
                                                    PENGALAMAN KERJA
                                                </th>
                                                <th>RIWAYAT PENYAKIT</th>
                                                <th>
                                                    RIWAYAT PENYAKIT KELUARGA
                                                </th>
                                                <th>RIWAYAT OPERASI</th>
                                                <th>RIWAYAT PENGGUNAAN OBAT</th>
                                                <th className="cell-fit">
                                                    UPDATE
                                                </th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {/* Modal Nonlengkap */}
                <div
                    className="modal fade"
                    tabIndex="-1"
                    role="dialog"
                    id="profilNonLengkap"
                    aria-hidden="true"
                >
                    <div
                        className="modal-dialog modal-dialog-centered modal-lg"
                        role="document"
                    >
                        <div className="modal-content">
                            <div className="modal-header">
                                <h4 className="modal-title">
                                    Daftar Profil Karyawan{" "}
                                    <b className="text-secondary">
                                        Belum Lengkap
                                    </b>
                                </h4>
                                <button
                                    type="button"
                                    className="btn-close"
                                    data-bs-dismiss="modal"
                                ></button>
                            </div>
                            <div className="modal-body p-1">
                                <div
                                    className="table-responsive text-nowrap"
                                    style={{ border: 0 }}
                                >
                                    <table
                                        id="dttable-nonlengkap"
                                        className="table dt-responsive table-hover nowrap w-100"
                                    >
                                        <thead>
                                            <tr>
                                                <th className="cell-fit">
                                                    <center>ID</center>
                                                </th>
                                                <th className="cell-fit">
                                                    NAME
                                                </th>
                                                <th className="cell-fit">
                                                    DITAMBAHKAN
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody id="tampil-tbody-nonlengkap">
                                            <tr>
                                                <td
                                                    colSpan="9"
                                                    style={{
                                                        fontSize: "13px",
                                                    }}
                                                >
                                                    <center>
                                                        <i className="fa fa-spinner fa-spin fa-fw"></i>{" "}
                                                        Memproses data...
                                                    </center>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div className="modal-footer">
                                <button
                                    className="btn btn-outline-light"
                                    data-bs-dismiss="modal"
                                >
                                    <i className="fas fa-chevron-left"></i>
                                    &nbsp;&nbsp;Tutup
                                </button>
                                <button
                                    className="btn btn-warning"
                                    onClick={() => refreshNonLengkap()}
                                >
                                    <i
                                        className={`fas me-1 fa-sync ${
                                            loadingTableNonLengkap
                                                ? "fa-spin"
                                                : ""
                                        }`}
                                    ></i>
                                    &nbsp;&nbsp;Segarkan
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {/* Modal Nonaktif */}
                <div
                    className="modal fade"
                    tabIndex="-1"
                    role="dialog"
                    id="karyawanNonAktif"
                    aria-hidden="true"
                >
                    <div
                        className="modal-dialog modal-dialog-centered modal-xl"
                        role="document"
                    >
                        <div className="modal-content">
                            <div className="modal-header">
                                <h4 className="modal-title">
                                    Daftar Karyawan{" "}
                                    <b className="text-danger">Nonaktif</b>
                                </h4>
                                <button
                                    type="button"
                                    className="btn-close"
                                    data-bs-dismiss="modal"
                                ></button>
                            </div>
                            <div className="modal-body p-1">
                                <div className="table-responsive text-nowrap table-card">
                                    <table
                                        id="dttable-nonaktif"
                                        className="table dt-responsive table-hover nowrap w-100"
                                    >
                                        <thead>
                                            <tr>
                                                <th className="cell-fit">
                                                    <center>ID</center>
                                                </th>
                                                <th className="cell-fit">
                                                    NAME
                                                </th>
                                                <th className="cell-fit">
                                                    NAMA LENGKAP
                                                </th>
                                                <th className="cell-fit">
                                                    TGL NONAKTIF
                                                </th>
                                                <th className="cell-fit">
                                                    <center>#</center>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody id="tampil-tbody-nonaktif">
                                            <tr>
                                                <td
                                                    colSpan="9"
                                                    style={{
                                                        fontSize: "13px",
                                                    }}
                                                >
                                                    <center>
                                                        <i className="fa fa-spinner fa-spin fa-fw"></i>{" "}
                                                        Memproses data...
                                                    </center>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div className="modal-footer">
                                <button
                                    className="btn btn-outline-light"
                                    data-bs-dismiss="modal"
                                >
                                    <i className="fas fa-chevron-left"></i>
                                    &nbsp;&nbsp;Tutup
                                </button>
                                <button
                                    className="btn btn-warning"
                                    onClick={() => refreshNonAktif()}
                                >
                                    <i
                                        className={`fas me-1 fa-sync ${
                                            loadingTableNonAktif
                                                ? "fa-spin"
                                                : ""
                                        }`}
                                    ></i>
                                    &nbsp;&nbsp;Segarkan
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {/* Modal Aktivasi Karyawan */}
                <div
                    className="modal fade"
                    tabIndex="-1"
                    role="dialog"
                    id="aktifkanKaryawan"
                    aria-hidden="true"
                >
                    <div className="modal-dialog modal-simple modal-add-new-address modal-dialog-centered">
                        <div className="modal-content">
                            <div className="modal-header">
                                <h4 className="modal-title">
                                    Apakah Anda sudah Yakin?
                                </h4>
                            </div>
                            <div className="modal-body">
                                <input
                                    type="hidden"
                                    value={idAktifKaryawan}
                                    readOnly
                                />
                                <p style={{ textAlign: "justify" }}>
                                    Anda akan mengaktifkan kembali karyawan
                                    dengan{" "}
                                    <kbd>
                                        #ID:<a>{idAktifKaryawan}</a>
                                    </kbd>{" "}
                                    dan/apabila melanjutkan proses Submit, data
                                    Anda akan tercatat dalam database.
                                </p>
                                <label className="switch">
                                    <input
                                        type="checkbox"
                                        className="switch-input"
                                        id="setujuaktifkaryawan"
                                        checked={isCheckedAktifKaryawan}
                                        onChange={(e) =>
                                            setIsCheckedAktifKaryawan(
                                                e.target.checked
                                            )
                                        }
                                    />
                                    <span className="switch-toggle-slider me-2">
                                        <span className="switch-on"></span>
                                        <span className="switch-off"></span>
                                    </span>
                                    <span className="switch-label">
                                        Saya Setuju
                                    </span>
                                </label>
                            </div>
                            <div className="col-12 text-center mb-4">
                                <button
                                    type="submit"
                                    id="btn-aktif-karyawan"
                                    className="btn btn-danger me-sm-3 me-1"
                                    onClick={batalNonAktif}
                                >
                                    <i
                                        className={`me-1 ${
                                            loadingAktifkanKaryawan
                                                ? "fas fa-sync fa-spin"
                                                : "ti ti-checkbox"
                                        }`}
                                        style={{ fontSize: "13px" }}
                                    ></i>{" "}
                                    Submit
                                </button>
                                <button
                                    data-bs-dismiss="modal"
                                    className="btn btn-light"
                                    onClick={() => {
                                        $("#aktifkanKaryawan").modal("hide");
                                        $("#karyawanNonAktif").modal("show");
                                    }}
                                >
                                    <i
                                        className="fa fa-times me-1"
                                        style={{ fontSize: "13px" }}
                                    ></i>{" "}
                                    Tutup
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
};

export default Pegawai;

Pegawai.layout = (page) => <MainLayout>{page}</MainLayout>;
