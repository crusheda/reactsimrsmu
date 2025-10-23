import React, { useEffect, useRef, useState } from "react";
import { Head } from "@inertiajs/react";
import MainLayout from "@/Layouts/MainLayout";
import { initDataTable, initTooltips, showLoading } from "@/Helpers/Helper";

const Pegawai = () => {
    // Modal state
    const [showNonAktif, setShowNonAktif] = useState(false);
    const [showNonLengkap, setShowNonLengkap] = useState(false);
    const [showAktifKaryawan, setShowAktifKaryawan] = useState(false);

    // Loading state
    const [loadingTabelSimpel, setLoadingTabelSimpel] = useState(false);

    // Ref untuk grafik
    const grafikRef = useRef(null);
    const [grafik, setGrafik] = useState(null);
    const [grafikTitle, setGrafikTitle] = useState("");

    // ============ AJAX FUNCTIONS ==============
    const refresh = () => {
        // Table simpel
        setLoadingTabelSimpel(true);
        showLoading("#tampil-tbody", 9);
        $.ajax({
            url: "/api/profilkaryawan/table",
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
                                            <li><a class="dropdown-item" href="/kepegawaian/profilkaryawan/${item.id}"><i class="fa-fw fas fa-search nav-icon me-1"></i> Lihat Profil</a></li>
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
                initTooltips(document.querySelector("#tampil-tbody"));
                // initDataTable("#dttable", { orderCol: 3, enableExport: true });
                initDataTable("#dttable", {
                    orderCol: 3,
                    sort: "desc",
                    displayLength: 10,
                    columnDefs: [
                        { width: "10%", targets: 0 },
                        { width: "20%", targets: 1 },
                        { width: "55%", targets: 2 },
                        { width: "15%", targets: 3 },
                    ],
                    enableExport: true,
                });
            },
            error: () => {
                iziToast.error({
                    title: "Pesan Galat!",
                    message: "Proses memuat Data Gagal!",
                    position: "topRight",
                });
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
        showLoading("#tampil-tbody-all", 20);
        $.ajax({
            url: "/profilkaryawan/tableall",
            type: "GET",
            dataType: "json",
            success: (res) => {
                $("#tampil-tbody-all").empty();
                res.show.forEach((item) => {
                    $("#tampil-tbody-all").append(`
            <tr>
              <td>${item.id}</td>
              <td>${item.nip}</td>
              <td>${item.nik}</td>
              <td>${item.nama_lengkap}</td>
              <!-- Tambahkan kolom lain sesuai data -->
              <td>${item.updated_at}</td>
            </tr>
          `);
                });
                initDataTable("#dttable-all", 0, 20);
            },
            error: () => {
                iziToast.error({
                    title: "Pesan Galat!",
                    message: "Proses memuat Data Lengkap Gagal!",
                    position: "topRight",
                });
            },
        });
    };

    const refreshNonAktif = () => {
        showLoading("#tampil-tbody-nonaktif", 9);
        $.ajax({
            url: "/profilkaryawan/nonaktif",
            type: "GET",
            dataType: "json",
            success: (res) => {
                $("#tampil-tbody-nonaktif").empty();
                res.show.forEach((item) => {
                    $("#tampil-tbody-nonaktif").append(`
            <tr>
              <td><center>${item.id}</center></td>
              <td>${item.name}</td>
              <td>${item.nama_lengkap}</td>
              <td>${item.tgl_nonaktif}</td>
              <td><button class="btn btn-sm btn-primary">Aktifkan</button></td>
            </tr>
          `);
                });
                initDataTable("#dttable-nonaktif", 3, 7);
            },
            error: () => {
                iziToast.error({
                    title: "Pesan Galat!",
                    message: "Proses memuat Data Nonaktif Gagal!",
                    position: "topRight",
                });
            },
        });
    };

    const refreshNonLengkap = () => {
        showLoading("#tampil-tbody-nonlengkap", 9);
        $.ajax({
            url: "/profilkaryawan/nonlengkap",
            type: "GET",
            dataType: "json",
            success: (res) => {
                $("#tampil-tbody-nonlengkap").empty();
                res.show.forEach((item) => {
                    $("#tampil-tbody-nonlengkap").append(`
            <tr>
              <td><center>${item.id}</center></td>
              <td>${item.name}</td>
              <td>${item.dibuat}</td>
            </tr>
          `);
                });
                initDataTable("#dttable-nonlengkap", 2, 7);
            },
            error: () => {
                iziToast.error({
                    title: "Pesan Galat!",
                    message: "Proses memuat Data Nonlengkap Gagal!",
                    position: "topRight",
                });
            },
        });
    };

    // ============ GRAFIK ==============
    const showGrafikStatusPegawai = () =>
        loadGrafik(5, "Berdasarkan Status Pegawai");

    const loadGrafik = (id, title) => {
        $.ajax({
            url: `/profilkaryawan/grafik/${id}`,
            type: "GET",
            dataType: "json",
            success: (res) => {
                setGrafikTitle(
                    title +
                        (res.belumMasuk
                            ? ` (${res.belumMasuk} pegawai belum diinput)`
                            : " (Data Seluruh Pegawai)")
                );

                if (grafik) grafik.destroy();

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

                const chart = new ApexCharts(grafikRef.current, options);
                chart.render();
                setGrafik(chart);
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
                        <h1 className="page-title fw-medium fs-18 mb-0">Table Pegawai <b className="text-primary">RS</b></h1>
                        <ol className="breadcrumb mb-0">
                            <li className="breadcrumb-item"><a role="button">SDI</a></li>
                            <li className="breadcrumb-item active" aria-current="page">Daftar Pegawai</li>
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
                                                        showGrafikJenisPegawai()
                                                    }
                                                >
                                                    Jenis Pegawai
                                                </a>
                                                <a
                                                    className="dropdown-item"
                                                    href="#"
                                                    onClick={() =>
                                                        showGrafikJenisKelamin()
                                                    }
                                                >
                                                    Jenis Kelamin
                                                </a>
                                                <a
                                                    className="dropdown-item"
                                                    href="#"
                                                    onClick={() =>
                                                        showGrafikPendidikan()
                                                    }
                                                >
                                                    Pendidikan
                                                </a>
                                                <a
                                                    className="dropdown-item"
                                                    href="#"
                                                    onClick={() =>
                                                        showGrafikProfesi()
                                                    }
                                                >
                                                    Profesi
                                                </a>
                                                <a
                                                    className="dropdown-item"
                                                    href="#"
                                                    onClick={() =>
                                                        showGrafikStatusPegawai()
                                                    }
                                                >
                                                    Status Pegawai
                                                </a>
                                                <a
                                                    className="dropdown-item"
                                                    href="#"
                                                    onClick={() =>
                                                        showGrafikStatusKawin()
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
                                    <h5
                                        className="text-center my-2"
                                        id="show-name-grafik"
                                    ></h5>
                                    <div
                                        id="grafik-show"
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

                    {/* Profil Card */}
                    <div className="col-sm-12">
                        <div className="card">
                            <div className="card-header d-flex align-items-center justify-content-between py-3">
                                <div className="btn-group shadow">
                                    <button
                                        className="btn btn-primary btn-wave"
                                        onClick={() =>
                                            (window.location.href = "/akunpengguna")
                                        }
                                        data-bs-toggle="tooltip"
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
                                        title="Menampilkan Data Simpel Pegawai"
                                    >
                                        <i className={`fas me-1 ${loadingTabelSimpel ? "fa-sync fa-spin" : "fa-sync"}`}></i>
                                        Tabel Simpel
                                    </button>

                                    <button
                                        className="btn btn-danger-light btn-wave"
                                        id="btn-tabel-lengkap"
                                        onClick={() => showAll()}
                                        data-bs-toggle="tooltip"
                                        title="Menampilkan Seluruh Data Profil Pegawai"
                                    >
                                        <i className="fa-fw fas fa-infinity nav-icon me-1"></i>{" "}
                                        Tabel Lengkap
                                    </button>
                                </div>

                                <div className="">
                                    <button
                                        className="btn btn-sm btn-outline-primary shadow-sm btn-wave"
                                        data-bs-toggle="dropdown" data-bs-auto-close="true" type="button"
                                        onClick={() => {}}
                                    >
                                        <i className="ti ti-dots-vertical f-18" data-bs-toggle="tooltip" title="Pilihan Menu Lainnya"></i>
                                    </button>
                                    <ul className="dropdown-menu">
                                        <li>
                                            <a
                                                className="dropdown-item"
                                                href="#"
                                                onClick={() =>
                                                    setShowNonLengkap(true)
                                                }
                                            >
                                                Profil Belum Lengkap
                                            </a>
                                            <a
                                                className="dropdown-item"
                                                href="#"
                                                onClick={() =>
                                                    setShowNonAktif(true)
                                                }
                                            >
                                                Karyawan Nonaktif
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div className="card-body p-3">
                                <div className="alert alert-light shadow-sm">
                                    <small>
                                        <i className="fa-fw fas fa-caret-right nav-icon me-1"></i>{" "}
                                        Refresh browser Anda apabila terjadi Error
                                        saat pengambilan data karyawan
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
                                <div className="table-responsive">
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
                                    {/* Copy table lengkap dari Blade di sini */}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {/* Modal Nonaktif */}
                {showNonAktif && (
                    <div
                        className="modal fade show d-block"
                        tabIndex="-1"
                        role="dialog"
                    >
                        <div
                            className="modal-dialog modal-dialog-centered modal-xl"
                            role="document"
                        >
                            <div className="modal-content">
                                <div className="modal-header">
                                    <h4 className="modal-title">
                                        Daftar Karyawan Nonaktif
                                    </h4>
                                    <button
                                        type="button"
                                        className="btn-close"
                                        onClick={() => setShowNonAktif(false)}
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
                                </div>
                                <div className="modal-footer">
                                    <button
                                        className="btn btn-label-secondary"
                                        onClick={() => setShowNonAktif(false)}
                                    >
                                        <i className="fas fa-chevron-left"></i>
                                        &nbsp;&nbsp;Tutup
                                    </button>
                                    <button
                                        className="btn btn-warning"
                                        onClick={() => refreshNonAktif()}
                                    >
                                        <i className="fa-fw fas fa-sync nav-icon"></i>
                                        &nbsp;&nbsp;Segarkan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                )}

                {/* Modal Nonlengkap */}
                {showNonLengkap && (
                    <div
                        className="modal fade show d-block"
                        tabIndex="-1"
                        role="dialog"
                    >
                        <div
                            className="modal-dialog modal-dialog-centered modal-lg"
                            role="document"
                        >
                            <div className="modal-content">
                                <div className="modal-header">
                                    <h4 className="modal-title">
                                        Daftar Profil Karyawan Belum Lengkap
                                    </h4>
                                    <button
                                        type="button"
                                        className="btn-close"
                                        onClick={() => setShowNonLengkap(false)}
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
                                </div>
                                <div className="modal-footer">
                                    <button
                                        className="btn btn-label-secondary"
                                        onClick={() => setShowNonLengkap(false)}
                                    >
                                        <i className="fas fa-chevron-left"></i>
                                        &nbsp;&nbsp;Tutup
                                    </button>
                                    <button
                                        className="btn btn-warning"
                                        onClick={() => refreshNonLengkap()}
                                    >
                                        <i className="fa-fw fas fa-sync nav-icon"></i>
                                        &nbsp;&nbsp;Segarkan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                )}

                {/* Modal Aktif Karyawan */}
                {showAktifKaryawan && (
                    <div
                        className="modal fade show d-block"
                        tabIndex="-1"
                        role="dialog"
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
                                        type="text"
                                        id="id_aktif_karyawan"
                                        hidden
                                    />
                                    <p style={{ textAlign: "justify" }}>
                                        Anda akan mengaktifkan kembali karyawan
                                        dengan{" "}
                                        <kbd>
                                            ID : <a id="show_id_aktif_karyawan"></a>
                                        </kbd>{" "}
                                        dan/apabila melanjutkan proses Submit, data
                                        Anda akan tercatat dalam database.
                                    </p>
                                    <label className="switch">
                                        <input
                                            type="checkbox"
                                            className="switch-input"
                                            id="setujuaktifkaryawan"
                                        />
                                        <span className="switch-toggle-slider">
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
                                        onClick={() => batalNonAktif()}
                                    >
                                        <i
                                            className="ti ti-checkbox me-1"
                                            style={{ fontSize: "13px" }}
                                        ></i>{" "}
                                        Submit
                                    </button>
                                    <button
                                        type="reset"
                                        className="btn btn-outline-secondary"
                                        onClick={() => setShowAktifKaryawan(false)}
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
                )}
            </div>
        </>
    );
};

export default Pegawai;

Pegawai.layout = (page) => <MainLayout>{page}</MainLayout>;
