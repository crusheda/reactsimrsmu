import MainLayout from "@/Layouts/MainLayout";
import React, { useEffect, useState } from "react";
import { Head, router, usePage } from "@inertiajs/react";
import { Link } from "@inertiajs/react";

export default function Profil() {
    const { auth, list } = usePage().props;
    const user = list.user;
    const role = list.role;
    const foto_user = list.foto_user;
    const status_user = list.status_user;

    return (
        <>
            <Head>
                <title>Profil Saya</title>
            </Head>

            <div className="container-fluid page-container main-body-container">
                <div className="page-header-breadcrumb mb-3">
                    <div className="d-flex align-center justify-content-between flex-wrap">
                        <h1 className="page-title fw-medium fs-18 mb-0">
                            Profil <b className="text-primary">Saya</b>
                        </h1>
                        <ol className="breadcrumb mb-0">
                            <li className="breadcrumb-item">
                                <a role="button">Akun</a>
                            </li>
                            <li
                                className="breadcrumb-item active"
                                aria-current="page"
                            >
                                Profil Saya
                            </li>
                        </ol>
                    </div>
                </div>

                {/* Main Content */}
                <div className="row justify-content-center">
                    <div className="col-xl-12">
                        <div className="card custom-card profile-card">
                            <div className="profile-banner-image">
                                <img
                                    src="/react/images/media/backgrounds/1.png"
                                    className="card-img-top"
                                    alt="..."
                                />
                            </div>
                            <div className="card-body p-4 pb-0 position-relative">
                                <div className="d-flex align-items-end justify-content-between flex-wrap">
                                    <div>
                                        <span className="avatar avatar-xxl avatar-rounded bg-info online">
                                            <img
                                                src={
                                                    auth?.user?.foto ||
                                                    "/react/images/faces/21.jpg"
                                                }
                                                alt=""
                                            />
                                        </span>
                                        <div className="mt-4 mb-3 d-flex align-items-center flex-wrap gap-3 justify-content-between">
                                            <div>
                                                <h5 className="fw-semibold mb-1">
                                                    {auth?.user?.nama ? (
                                                        <>{auth.user.nama}</>
                                                    ) : (
                                                        <>
                                                            {auth?.user?.name}{" "}
                                                            <b className="text-danger">
                                                                (Profil Belum
                                                                Lengkap)
                                                            </b>
                                                        </>
                                                    )}
                                                    {role && role.length > 0 ? (
                                                        role.map((val, i) => (
                                                            <span key={i} className="badge bg-primary-transparent ms-2 align-middle">
                                                                {val.nama_role}
                                                            </span>
                                                        ))
                                                    ) : (
                                                        <span className="text-muted">xxx</span>
                                                    )}
                                                </h5>
                                                <p className="fs-12 mb-0 fw-medium text-muted">
                                                    <span className="me-3">
                                                        <i className="ri-shield-user-line me-1 align-middle"></i>
                                                        {"Status: " +
                                                            status_user?.nama_status ||
                                                            "Status Tidak Diketahui"}
                                                    </span>
                                                    <span className="me-3">
                                                        <i className="ri-user-follow-line me-1 align-middle"></i>
                                                        {user?.deleted_at ? (
                                                            <>
                                                                {
                                                                    "Akun Dinonaktifkan"
                                                                }
                                                            </>
                                                        ) : (
                                                            <>{"Akun Aktif"}</>
                                                        )}
                                                    </span>
                                                    <span>
                                                        <i className="ri-login-box-line me-1 align-middle"></i>
                                                        {list?.log_user ? (
                                                            <>
                                                                {"Terakhir Login: " +
                                                                    new Date(
                                                                        list.log_user.log_date
                                                                    ).toLocaleString(
                                                                        "sv-SE"
                                                                    )}
                                                            </>
                                                        ) : (
                                                            <>Last Login: -</>
                                                        )}
                                                    </span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <ul
                                            className="nav nav-tabs mb-0 tab-style-8 scaleX"
                                            id="myTab"
                                            role="tablist"
                                        >
                                            <li
                                                className="nav-item"
                                                role="presentation"
                                            >
                                                <button
                                                    className="nav-link active"
                                                    id="profile-about-tab"
                                                    data-bs-toggle="tab"
                                                    data-bs-target="#profile-about-tab-pane"
                                                    type="button"
                                                    role="tab"
                                                    aria-controls="profile-about-tab-pane"
                                                    aria-selected="true"
                                                >
                                                    Data Diri
                                                </button>
                                            </li>
                                            <li
                                                className="nav-item"
                                                role="presentation"
                                            >
                                                <button
                                                    className="nav-link"
                                                    id="gallery-tab"
                                                    data-bs-toggle="tab"
                                                    data-bs-target="#gallery-tab-pane"
                                                    type="button"
                                                    role="tab"
                                                    aria-controls="gallery-tab-pane"
                                                    aria-selected="false"
                                                >
                                                    Ubah
                                                </button>
                                            </li>
                                            <li
                                                className="nav-item"
                                                role="presentation"
                                            >
                                                <button
                                                    className="nav-link"
                                                    id="followers-tab"
                                                    data-bs-toggle="tab"
                                                    data-bs-target="#followers-tab-pane"
                                                    type="button"
                                                    role="tab"
                                                    aria-controls="followers-tab-pane"
                                                    aria-selected="false"
                                                >
                                                    Dokumen
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div className="col-xl-12">
                        <div className="tab-content" id="profile-tabs">
                            <div
                                className="tab-pane show active p-0 border-0"
                                id="profile-about-tab-pane"
                                role="tabpanel"
                                aria-labelledby="profile-about-tab"
                                tabIndex="0"
                            >
                                <div className="row">
                                    <div className="col-xxl-4">
                                        <div className="row">
                                            <div className="col-xl-12" hidden>
                                                <div className="card custom-card">
                                                    <div className="card-body">
                                                        <div className="d-flex align-items-center justify-content-center gap-4">
                                                            <div className="text-center">
                                                                <h3 className="fw-semibold mb-1">
                                                                    13,264
                                                                </h3>
                                                                <span className="d-block text-muted">
                                                                    Followers
                                                                </span>
                                                            </div>
                                                            <div className="vr"></div>
                                                            <div className="text-center">
                                                                <h3 className="fw-semibold mb-1">
                                                                    7,238
                                                                </h3>
                                                                <span className="d-block text-muted">
                                                                    Following
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div className="col-xl-12">
                                                <div className="card custom-card">
                                                    <div className="card-header">
                                                        <div className="card-title">
                                                            Data Sensitif
                                                        </div>
                                                    </div>
                                                    <div className="card-body">
                                                        <p
                                                            className="text-muted"
                                                            dangerouslySetInnerHTML={{
                                                                __html: user
                                                                    ?.pengalaman_kerja
                                                                    ? user.pengalaman_kerja.replace(/\r\n|\r|\n/g,"<br>")
                                                                    : "Tidak ada deskripsi pengalaman kerja.",
                                                            }}
                                                        ></p>
                                                        <div className="text-muted">
                                                            <div className="mb-2 d-flex align-items-center gap-1 flex-wrap">
                                                                <span className="avatar avatar-sm avatar-rounded text-default">
                                                                    <i className="ri-file-user-line align-middle fs-15"></i>
                                                                </span>
                                                                <span className="fw-medium text-default">
                                                                    NIP :{" "}
                                                                </span>{" "}
                                                                {user?.nip ||
                                                                    "-"}
                                                            </div>
                                                            <div className="mb-2 d-flex align-items-center gap-1 flex-wrap">
                                                                <span className="avatar avatar-sm avatar-rounded text-default">
                                                                    <i className="ri-pass-valid-line align-middle fs-15"></i>
                                                                </span>
                                                                <span className="fw-medium text-default">
                                                                    NIK :{" "}
                                                                </span>{" "}
                                                                {user?.nik ||
                                                                    "-"}
                                                            </div>
                                                            <div className="mb-2 d-flex align-items-center gap-1 flex-wrap">
                                                                <span className="avatar avatar-sm avatar-rounded text-default">
                                                                    <i className="ri-mail-line align-middle fs-15"></i>
                                                                </span>
                                                                <span className="fw-medium text-default">
                                                                    Email :{" "}
                                                                </span>{" "}
                                                                {user?.email ||
                                                                    "-"}
                                                            </div>
                                                            <div className="mb-0 d-flex align-items-center gap-1">
                                                                <span className="avatar avatar-sm avatar-rounded text-default">
                                                                    <i className="ri-phone-line align-middle fs-15"></i>
                                                                </span>
                                                                <span className="fw-medium text-default">
                                                                    No.HP :{" "}
                                                                </span>{" "}
                                                                {user?.no_hp ||
                                                                    "-"}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div className="col-xl-12">
                                                <div className="card custom-card overflow-hidden">
                                                    <div className="card-header">
                                                        <div className="card-title">
                                                            Media Sosial
                                                        </div>
                                                    </div>
                                                    <div className="card-body p-0">
                                                        <ul className="list-group list-group-flush social-media-list">
                                                            <li className="list-group-item">
                                                                <div className="d-flex align-items-center gap-3 flex-wrap">
                                                                    <div>
                                                                        <span className="avatar avatar-md bg-primary-transparent">
                                                                            <i className="ri-facebook-circle-fill fs-4"></i>
                                                                        </span>
                                                                    </div>
                                                                    <div>
                                                                        <span className="d-block fw-medium">
                                                                            Facebook
                                                                        </span>
                                                                        <a
                                                                            href={user?.fb ? `https://www.facebook.com/${user.fb}` : undefined}
                                                                            target="_blank"
                                                                            rel="noopener noreferrer"
                                                                            className="text-muted"
                                                                        >
                                                                            Facebook / <mark>{user?.fb || "xxx"}</mark>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li className="list-group-item">
                                                                <div className="d-flex align-items-center gap-3 flex-wrap">
                                                                    <div>
                                                                        <span className="avatar avatar-md bg-secondary-transparent">
                                                                            <i className="ri-instagram-fill fs-4"></i>
                                                                        </span>
                                                                    </div>
                                                                    <div>
                                                                        <span className="d-block fw-medium">
                                                                            Instagram
                                                                        </span>
                                                                        <a
                                                                            href={user?.ig ? `https://www.instagram.com/${user.ig}` : undefined}
                                                                            target="_blank"
                                                                            rel="noopener noreferrer"
                                                                            className="text-muted"
                                                                        >
                                                                            Instagram / <mark>{user?.ig || "xxx"}</mark>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li className="list-group-item">
                                                                <div className="d-flex align-items-center gap-3 flex-wrap">
                                                                    <div>
                                                                        <span className="avatar avatar-md bg-dark-transparent">
                                                                            <i className="ri-tiktok-fill fs-20"></i>
                                                                        </span>
                                                                    </div>
                                                                    <div>
                                                                        <span className="d-block fw-medium">
                                                                            Tiktok
                                                                        </span>
                                                                        <a
                                                                            href={user?.tt ? `https://www.tiktok.com/@${user.tt}` : undefined}
                                                                            target="_blank"
                                                                            rel="noopener noreferrer"
                                                                            className="text-muted"
                                                                        >
                                                                            Tiktok / <mark>{user?.tt || "xxx"}</mark>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li className="list-group-item">
                                                                <div className="d-flex align-items-center gap-3 flex-wrap">
                                                                    <div>
                                                                        <span className="avatar avatar-md bg-danger-transparent">
                                                                            <i className="ri-youtube-fill fs-20"></i>
                                                                        </span>
                                                                    </div>
                                                                    <div>
                                                                        <span className="d-block fw-medium">
                                                                            Youtube <b className="text-danger">RS</b>
                                                                        </span>
                                                                        <a
                                                                            href="https://www.youtube.com/@rspkumuhsukoharjo1801"
                                                                            target="_blank"
                                                                            rel="noopener noreferrer"
                                                                            className="text-muted"
                                                                        >
                                                                            Youtube / <mark>rspkusukoharjo</mark>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div className="col-xxl-8">
                                        <div className="card custom-card">
                                            <div className="card-header">
                                                <div className="card-title">
                                                    Data Identitas
                                                </div>
                                            </div>
                                            <div className="card-body">
                                                <ul className="list-group list-group-flush">
                                                    <li className="list-group-item px-0 pt-0">
                                                        <div className="row">
                                                            <div className="col-md-6">
                                                                <p className="mb-1 text-muted">Nama Lengkap</p>
                                                                <p className="mb-0">{user?.nama || "..."}</p>
                                                            </div>
                                                            <div className="col-md-6">
                                                                <p className="mb-1 text-muted">Nama Panggilan</p>
                                                                <p className="mb-0">{user?.nick || "..."}</p>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li className="list-group-item px-0">
                                                        <div className="row">
                                                            <div className="col-md-6">
                                                                <p className="mb-1 text-muted">Tempat Lahir</p>
                                                                <p className="mb-0">{user?.temp_lahir || "..."}</p>
                                                            </div>
                                                            <div className="col-md-6">
                                                                <p className="mb-1 text-muted">Tanggal Lahir</p>
                                                                <p className="mb-0">
                                                                    {user?.tgl_lahir
                                                                        ? dayjs(user.tgl_lahir).format("D MMMM YYYY")
                                                                        : "..."}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li className="list-group-item px-0">
                                                        <div className="row">
                                                            <div className="col-md-6">
                                                                <p className="mb-1 text-muted">Jenis Kelamin</p>
                                                                <p className="mb-0">{user?.jns_kelamin || "..."}</p>
                                                            </div>
                                                            <div className="col-md-6">
                                                                <p className="mb-1 text-muted">Status Kawin</p>
                                                                <p className="mb-0">{user?.status_kawin || "..."}</p>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li className="list-group-item px-0">
                                                        <p className="mb-1 text-muted">Alamat Lengkap <strong className="text-danger">Sesuai KTP</strong></p>
                                                        <p className="mb-0">
                                                            {user?.alamat_ktp ? (
                                                                <span
                                                                    dangerouslySetInnerHTML={{
                                                                        __html: user.alamat_ktp.replace(/(\r\n|\r|\n)/g, "<br>")
                                                                    }}
                                                                />
                                                            ) : (
                                                                "..."
                                                            )}
                                                        </p>
                                                    </li>
                                                    <li className="list-group-item px-0 pb-0">
                                                        <p className="mb-1 text-muted">Alamat Domisili</p>
                                                        <p className="mb-0">
                                                            {user?.alamat_ktp ? (user?.alamat_dom ? (
                                                                <span
                                                                    dangerouslySetInnerHTML={{
                                                                        __html: user.alamat_dom.replace(/(\r\n|\r|\n)/g, "<br>")
                                                                    }}
                                                                />
                                                            ) : (
                                                                "Sama dengan alamat pada KTP"
                                                            )) : ("...")}
                                                        </p>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div className="card custom-card">
                                            <div className="card-header">
                                                <div className="card-title">
                                                    Data Pendidikan
                                                </div>
                                            </div>
                                            <div className="card-body">
                                                <ul className="list-unstyled timeline-list-3">
                                                    {[
                                                    { jenjang: "S3", jurusan: user?.s3, tahun: user?.th_s3, color: "primary" },
                                                    { jenjang: "S2", jurusan: user?.s2, tahun: user?.th_s2, color: "success" },
                                                    { jenjang: "S1 Profesi", jurusan: user?.s1_profesi, tahun: user?.th_s1_profesi, color: "info" },
                                                    { jenjang: "S1", jurusan: user?.s1, tahun: user?.th_s1, color: "warning" },
                                                    { jenjang: "D4", jurusan: user?.d4, tahun: user?.th_d4, color: "secondary" },
                                                    { jenjang: "D3", jurusan: user?.d3, tahun: user?.th_d3, color: "danger" },
                                                    { jenjang: "D2", jurusan: user?.d2, tahun: user?.th_d2, color: "purple" },
                                                    { jenjang: "SMA", jurusan: user?.sma, tahun: user?.th_sma, color: "info" },
                                                    { jenjang: "SMP", jurusan: user?.smp, tahun: user?.th_smp, color: "warning" },
                                                    { jenjang: "SD", jurusan: user?.sd, tahun: user?.th_sd, color: "secondary" },
                                                    ]
                                                    .filter(item => item.jurusan) // hanya tampil jika tidak kosong
                                                    .map((item, index) => (
                                                        <li key={index}>
                                                            <div className="d-flex align-items-center gap-2 mb-1 flex-wrap">
                                                                <div className="fw-semibold fs-15">
                                                                    <span className="text-muted">
                                                                        <a className="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover text-decoration-underline" role="button">
                                                                            {item.jurusan}
                                                                        </a>
                                                                    </span>
                                                                </div>
                                                                <span className={`badge bg-${item.color}-transparent`}>Lulus {item.tahun || "xxx"}</span>
                                                            </div>
                                                            <div className="fs-13 text-muted">
                                                                Telah selesai Pendidikan jenjang <span className="fw-medium text-default">{item.jenjang}</span> di {" "}
                                                                <span className="fw-medium text-default">{item.jurusan}</span>{item.tahun ? " pada tahun " + item.tahun : ""}.
                                                            </div>
                                                        </li>
                                                    ))}
                                                </ul>

                                                {/* Jika semua kosong */}
                                                {![user?.s3, user?.s2, user?.s1_profesi, user?.s1, user?.d4, user?.d3, user?.d2, user?.sma, user?.smp, user?.sd].some(v => v) && (
                                                    <div className="text-muted">Tidak ada data pendidikan.</div>
                                                )}
                                            </div>
                                        </div>
                                        <div className="card custom-card">
                                            <div className="card-header">
                                                <div className="card-title">
                                                    Data Kesehatan
                                                </div>
                                            </div>
                                            <div className="card-body">
                                                <ol className="list-group list-group-numbered">
                                                    <li className="list-group-item d-sm-flex justify-content-between align-items-start">
                                                        <div className="ms-2 me-auto text-muted">
                                                            <div className="fw-medium fs-14 text-default">Riwayat Penyakit?</div>
                                                            <p className="mb-0" dangerouslySetInnerHTML={{
                                                                __html: user
                                                                    ?.riwayat_penyakit
                                                                    ? user.riwayat_penyakit.replace(/\r\n|\r|\n/g,"<br>")
                                                                    : "Tidak Ada.",
                                                            }}></p>
                                                        </div>
                                                    </li>
                                                    <li className="list-group-item d-sm-flex justify-content-between align-items-start">
                                                        <div className="ms-2 me-auto text-muted">
                                                            <div className="fw-medium fs-14 text-default">Riwayat Penyakit Keluarga?</div>
                                                            <p className="mb-0" dangerouslySetInnerHTML={{
                                                                    __html: user
                                                                        ?.riwayat_penyakit_keluarga
                                                                        ? user.riwayat_penyakit_keluarga.replace(/\r\n|\r|\n/g,"<br>")
                                                                        : "Tidak Ada.",
                                                                }}>
                                                            </p>
                                                        </div>
                                                    </li>
                                                    <li className="list-group-item d-sm-flex justify-content-between align-items-start">
                                                        <div className="ms-2 me-auto text-muted">
                                                            <div className="fw-medium fs-14 text-default">Riwayat Penggunaan Obat?</div>
                                                            <p className="mb-0" dangerouslySetInnerHTML={{
                                                                    __html: user
                                                                        ?.riwayat_penggunaan_obat
                                                                        ? user.riwayat_penggunaan_obat.replace(/\r\n|\r|\n/g,"<br>")
                                                                        : "Tidak Ada.",
                                                                }}>
                                                            </p>
                                                        </div>
                                                    </li>
                                                    <li className="list-group-item d-sm-flex justify-content-between align-items-start">
                                                        <div className="ms-2 me-auto text-muted">
                                                            <div className="fw-medium fs-14 text-default">Riwayat Operasi?</div>
                                                            <p className="mb-0" dangerouslySetInnerHTML={{
                                                                    __html: user
                                                                        ?.riwayat_operasi
                                                                        ? user.riwayat_operasi.replace(/\r\n|\r|\n/g,"<br>")
                                                                        : "Tidak Ada.",
                                                                }}>
                                                            </p>
                                                        </div>
                                                    </li>
                                                </ol>
                                            </div>
                                        </div>
                                    </div>
                                    {/* <div className="col-xxl-8">
                                        <div className="card custom-card">
                                            <div className="card-header p-0">
                                                <ul
                                                    className="nav nav-tabs tab-style-8 scaleX justify-content-end"
                                                    id="myTab4"
                                                    role="tablist"
                                                >
                                                    <li
                                                        className="nav-item"
                                                        role="presentation"
                                                    >
                                                        <button
                                                            className="nav-link active"
                                                            id="status-tab"
                                                            data-bs-toggle="tab"
                                                            data-bs-target="#status-tab-pane"
                                                            type="button"
                                                            role="tab"
                                                            aria-controls="status-tab-pane"
                                                            aria-selected="true"
                                                        >
                                                            <i className="ri-radio-button-line lh-1 me-1"></i>
                                                            Status
                                                        </button>
                                                    </li>
                                                    <li
                                                        className="nav-item"
                                                        role="presentation"
                                                    >
                                                        <button
                                                            className="nav-link"
                                                            id="media-tab"
                                                            data-bs-toggle="tab"
                                                            data-bs-target="#media-tab-pane"
                                                            type="button"
                                                            role="tab"
                                                            aria-controls="media-tab-pane"
                                                            aria-selected="false"
                                                            tabindex="-1"
                                                        >
                                                            <i className="ri-video-line lh-1 me-1"></i>
                                                            Image/Video
                                                        </button>
                                                    </li>
                                                    <li
                                                        className="nav-item"
                                                        role="presentation"
                                                    >
                                                        <button
                                                            className="nav-link"
                                                            id="live-stream-tab"
                                                            data-bs-toggle="tab"
                                                            data-bs-target="#live-stream-tab-pane"
                                                            type="button"
                                                            role="tab"
                                                            aria-controls="live-stream-tab-pane"
                                                            aria-selected="false"
                                                            tabindex="-1"
                                                        >
                                                            <i className="ri-tv-line lh-1 me-1"></i>
                                                            Live Stream
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div className="card-body">
                                                <div
                                                    className="tab-content"
                                                    id="myTabContent3"
                                                >
                                                    <div
                                                        className="tab-pane show active overflow-hidden p-0 border-0"
                                                        id="status-tab-pane"
                                                        role="tabpanel"
                                                        aria-labelledby="status-tab"
                                                        tabindex="0"
                                                    >
                                                        <textarea
                                                            className="form-control"
                                                            id="text-area"
                                                            rows="4"
                                                            placeholder="What's on your mind?"
                                                        ></textarea>
                                                        <div className="mt-2">
                                                            <button className="btn btn-primary float-end">
                                                                Post{" "}
                                                                <i className="ri-send-plane-2-line ms-1"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div
                                                        className="tab-pane overflow-hidden border-0 p-0"
                                                        id="media-tab-pane"
                                                        role="tabpanel"
                                                        aria-labelledby="media-tab"
                                                        tabindex="0"
                                                    >
                                                        <textarea
                                                            className="form-control"
                                                            id="text-area"
                                                            rows="2"
                                                            placeholder="What's on your mind?"
                                                        ></textarea>
                                                        <form
                                                            data-single="true"
                                                            method="post"
                                                            action="https://httpbin.org/post"
                                                            className="dropzone company-logo-upload mt-2"
                                                        ></form>
                                                        <div className="mt-2">
                                                            <button className="btn btn-success float-end">
                                                                Upload{" "}
                                                                <i className="ri-upload-2-line ms-1"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div
                                                        className="tab-pane overflow-hidden border-0 p-0"
                                                        id="live-stream-tab-pane"
                                                        role="tabpanel"
                                                        aria-labelledby="live-stream-tab"
                                                        tabindex="0"
                                                    >
                                                        <textarea
                                                            className="form-control"
                                                            id="text-area"
                                                            rows="4"
                                                            placeholder="What's on your mind?"
                                                        ></textarea>
                                                        <div className="mt-2">
                                                            <button className="btn btn-warning float-end">
                                                                Start Streaming{" "}
                                                                <i className="ri-tv-2-line ms-1"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div className="card custom-card">
                                            <div className="card-body">
                                                <div className="d-flex align-items-center gap-2 flex-wrap mb-2">
                                                    <div className="lh-1">
                                                        <span className="avatar avatar-rounded avatar-md">
                                                            <img
                                                                src="/react/images/faces/12.jpg"
                                                                alt=""
                                                            />
                                                        </span>
                                                    </div>
                                                    <div className="flex-fill">
                                                        <span className="d-block fw-semibold">
                                                            Tom Phillip
                                                        </span>
                                                        <span className="text-muted fs-13">
                                                            14 hrs ago
                                                        </span>
                                                    </div>
                                                    <div className="dropdown">
                                                        <a
                                                            aria-label="anchor"
                                                            role="button"
                                                            className="btn btn-icon rounded-circle border btn-light"
                                                            data-bs-toggle="dropdown"
                                                            aria-expanded="false"
                                                        >
                                                            <i className="fe fe-more-vertical"></i>
                                                        </a>
                                                        <ul className="dropdown-menu">
                                                            <li>
                                                                <a
                                                                    className="dropdown-item"
                                                                    role="button"
                                                                >
                                                                    <i className="ri-edit-line me-2"></i>
                                                                    Edit
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a
                                                                    className="dropdown-item"
                                                                    role="button"
                                                                >
                                                                    <i className="ri-delete-bin-line me-2"></i>
                                                                    Delete
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div className="my-3">
                                                    Captured the serene beauty
                                                    of the blue sky as the sun
                                                    sets.
                                                </div>
                                                <div>
                                                    <img
                                                        src="/react/images/media/media-23.jpg"
                                                        className="card-img"
                                                        alt="..."
                                                    />
                                                </div>
                                            </div>
                                            <div className="card-footer">
                                                <div className="d-flex align-items-center gap-2 flex-wrap">
                                                    <div className="avatar-list-stacked">
                                                        <span className="avatar avatar-rounded">
                                                            <img
                                                                src="/react/images/faces/2.jpg"
                                                                alt="img"
                                                            />
                                                        </span>
                                                        <span className="avatar avatar-rounded">
                                                            <img
                                                                src="/react/images/faces/8.jpg"
                                                                alt="img"
                                                            />
                                                        </span>
                                                        <span className="avatar avatar-rounded">
                                                            <img
                                                                src="/react/images/faces/2.jpg"
                                                                alt="img"
                                                            />
                                                        </span>
                                                        <span className="avatar avatar-rounded">
                                                            <img
                                                                src="/react/images/faces/10.jpg"
                                                                alt="img"
                                                            />
                                                        </span>
                                                    </div>
                                                    <div className="flex-fill">
                                                        and 8 others{" "}
                                                        <i className="ri-heart-3-fill text-danger"></i>{" "}
                                                        this post
                                                    </div>
                                                    <div className="d-flex align-items-center gap-2 flex-wrap">
                                                        <a
                                                            role="button"
                                                            className="p-1 px-2 bg-primary-transparent rounded"
                                                        >
                                                            <i className="ri-message-3-line me-1"></i>
                                                            Comment
                                                        </a>
                                                        <a
                                                            role="button"
                                                            className="p-1 px-2 bg-info-transparent rounded"
                                                        >
                                                            <i className="ri-share-forward-line me-1"></i>
                                                            Share
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div className="card-footer">
                                                <ul className="list-unstyled post-comments-list">
                                                    <li>
                                                        <div className="d-flex align-items-start gap-3">
                                                            <div className="lh-1">
                                                                <span className="avatar avatar-md avatar-rounded">
                                                                    <img
                                                                        src="/react/images/faces/4.jpg"
                                                                        alt=""
                                                                    />
                                                                </span>
                                                            </div>
                                                            <div className="flex-fill p-3 rounded bg-light">
                                                                <div className="d-flex align-items-center justify-content-between flex-wrap">
                                                                    <div className="fw-semibold">
                                                                        Emily_Smith
                                                                    </div>
                                                                    <div className="text-muted fs-13">
                                                                        2 hours
                                                                        ago
                                                                    </div>
                                                                </div>
                                                                <div className="text-muted">
                                                                    Wow, what a
                                                                    peaceful
                                                                    view! Nature
                                                                    at its best
                                                                    &#x1F60D;.
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div className="d-flex align-items-start gap-3">
                                                            <div className="lh-1">
                                                                <span className="avatar avatar-md avatar-rounded">
                                                                    <img
                                                                        src="/react/images/faces/14.jpg"
                                                                        alt=""
                                                                    />
                                                                </span>
                                                            </div>
                                                            <div className="flex-fill p-3 rounded bg-light">
                                                                <div className="d-flex align-items-center justify-content-between flex-wrap">
                                                                    <div className="fw-semibold">
                                                                        JohnDoe
                                                                    </div>
                                                                    <div className="text-muted fs-13">
                                                                        1 hours
                                                                        ago
                                                                    </div>
                                                                </div>
                                                                <div className="text-muted">
                                                                    Absolutely
                                                                    stunning!
                                                                    The colors
                                                                    are just
                                                                    perfect
                                                                    &#x1F305;&#x1F499;.
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div className="d-flex align-items-center lh-1 flex-wrap">
                                                            <div className="me-3">
                                                                <span className="avatar avatar-md avatar-rounded">
                                                                    <img
                                                                        src="/react/images/faces/12.jpg"
                                                                        alt=""
                                                                    />
                                                                </span>
                                                            </div>
                                                            <div className="flex-fill">
                                                                <div className="input-group">
                                                                    <input
                                                                        type="text"
                                                                        className="form-control"
                                                                        placeholder="Write a comment"
                                                                        aria-label="comment"
                                                                    />
                                                                    <button
                                                                        className="btn btn-light = border"
                                                                        type="button"
                                                                    >
                                                                        <i className="bi bi-emoji-smile"></i>
                                                                    </button>
                                                                    <button
                                                                        className="btn btn-light = border"
                                                                        type="button"
                                                                    >
                                                                        <i className="bi bi-paperclip"></i>
                                                                    </button>
                                                                    <button
                                                                        className="btn btn-light = border"
                                                                        type="button"
                                                                    >
                                                                        <i className="bi bi-camera"></i>
                                                                    </button>
                                                                    <button
                                                                        className="btn btn-primary"
                                                                        type="button"
                                                                    >
                                                                        Post
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div className="card custom-card">
                                            <div className="card-body">
                                                <div className="d-flex align-items-center gap-2 flex-wrap mb-2">
                                                    <div className="lh-1">
                                                        <span className="avatar avatar-rounded avatar-md">
                                                            <img
                                                                src="/react/images/faces/12.jpg"
                                                                alt=""
                                                            />
                                                        </span>
                                                    </div>
                                                    <div className="flex-fill">
                                                        <span className="d-block fw-semibold">
                                                            Tom Phillip
                                                        </span>
                                                        <span className="text-muted fs-13">
                                                            2 days ago
                                                        </span>
                                                    </div>
                                                    <div className="dropdown">
                                                        <a
                                                            aria-label="anchor"
                                                            role="button"
                                                            className="btn btn-icon rounded-circle border btn-light"
                                                            data-bs-toggle="dropdown"
                                                            aria-expanded="false"
                                                        >
                                                            <i className="fe fe-more-vertical"></i>
                                                        </a>
                                                        <ul className="dropdown-menu">
                                                            <li>
                                                                <a
                                                                    className="dropdown-item"
                                                                    role="button"
                                                                >
                                                                    <i className="ri-edit-line me-2"></i>
                                                                    Edit
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a
                                                                    className="dropdown-item"
                                                                    role="button"
                                                                >
                                                                    <i className="ri-delete-bin-line me-2"></i>
                                                                    Delete
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div className="my-3">
                                                    Success is not final,
                                                    failure is not fatal: It is
                                                    the courage to continue that
                                                    counts. Keep pushing
                                                    forward!{" "}
                                                    <a role="button">
                                                        &#128170;
                                                        #MotivationMonday
                                                    </a>
                                                </div>
                                            </div>
                                            <div className="card-footer">
                                                <div className="d-flex align-items-center gap-2 flex-wrap">
                                                    <div className="avatar-list-stacked">
                                                        <span className="avatar avatar-rounded">
                                                            <img
                                                                src="/react/images/faces/12.jpg"
                                                                alt="img"
                                                            />
                                                        </span>
                                                        <span className="avatar avatar-rounded">
                                                            <img
                                                                src="/react/images/faces/3.jpg"
                                                                alt="img"
                                                            />
                                                        </span>
                                                        <span className="avatar avatar-rounded">
                                                            <img
                                                                src="/react/images/faces/15.jpg"
                                                                alt="img"
                                                            />
                                                        </span>
                                                    </div>
                                                    <div className="flex-fill">
                                                        and 2 others{" "}
                                                        <i className="ri-heart-3-fill text-danger"></i>{" "}
                                                        this post
                                                    </div>
                                                    <div className="d-flex align-items-center gap-2 flex-wrap">
                                                        <a
                                                            role="button"
                                                            className="p-1 px-2 bg-primary-transparent rounded"
                                                        >
                                                            <i className="ri-message-3-line me-1"></i>
                                                            Comment
                                                        </a>
                                                        <a
                                                            role="button"
                                                            className="p-1 px-2 bg-info-transparent rounded"
                                                        >
                                                            <i className="ri-share-forward-line me-1"></i>
                                                            Share
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div className="card-footer">
                                                <ul className="list-unstyled post-comments-list">
                                                    <li>
                                                        <div className="d-flex align-items-center lh-1 flex-wrap">
                                                            <div className="me-3">
                                                                <span className="avatar avatar-md avatar-rounded">
                                                                    <img
                                                                        src="/react/images/faces/12.jpg"
                                                                        alt=""
                                                                    />
                                                                </span>
                                                            </div>
                                                            <div className="flex-fill">
                                                                <div className="input-group">
                                                                    <input
                                                                        type="text"
                                                                        className="form-control"
                                                                        placeholder="Write a comment"
                                                                        aria-label="comment"
                                                                    />
                                                                    <button
                                                                        className="btn btn-light border"
                                                                        type="button"
                                                                    >
                                                                        <i className="bi bi-emoji-smile"></i>
                                                                    </button>
                                                                    <button
                                                                        className="btn btn-light border"
                                                                        type="button"
                                                                    >
                                                                        <i className="bi bi-paperclip"></i>
                                                                    </button>
                                                                    <button
                                                                        className="btn btn-light border"
                                                                        type="button"
                                                                    >
                                                                        <i className="bi bi-camera"></i>
                                                                    </button>
                                                                    <button
                                                                        className="btn btn-primary"
                                                                        type="button"
                                                                    >
                                                                        Post
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div className="card custom-card">
                                            <div className="card-body">
                                                <div className="d-flex align-items-center gap-2 flex-wrap mb-2">
                                                    <div className="lh-1">
                                                        <span className="avatar avatar-rounded avatar-md">
                                                            <img
                                                                src="/react/images/faces/12.jpg"
                                                                alt=""
                                                            />
                                                        </span>
                                                    </div>
                                                    <div className="flex-fill">
                                                        <span className="d-block fw-semibold">
                                                            Tom Phillip
                                                        </span>
                                                        <span className="text-muted fs-13">
                                                            14 hrs ago
                                                        </span>
                                                    </div>
                                                    <div className="dropdown">
                                                        <a
                                                            aria-label="anchor"
                                                            role="button"
                                                            className="btn btn-icon rounded-circle border btn-light"
                                                            data-bs-toggle="dropdown"
                                                            aria-expanded="false"
                                                        >
                                                            <i className="fe fe-more-vertical"></i>
                                                        </a>
                                                        <ul className="dropdown-menu">
                                                            <li>
                                                                <a
                                                                    className="dropdown-item"
                                                                    role="button"
                                                                >
                                                                    <i className="ri-edit-line me-2"></i>
                                                                    Edit
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a
                                                                    className="dropdown-item"
                                                                    role="button"
                                                                >
                                                                    <i className="ri-delete-bin-line me-2"></i>
                                                                    Delete
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div className="my-3">
                                                    The serene beauty of the
                                                    evening beach with the soft
                                                    waves and the sky painted in
                                                    shades of orange and pink is
                                                    a perfect way to unwind
                                                    after a long day. &#x1F305;
                                                    &#127754;{" "}
                                                    <a role="button">
                                                        #BeachVibes
                                                    </a>{" "}
                                                    <a role="button">
                                                        #EveningSunset
                                                    </a>{" "}
                                                    <a role="button">
                                                        #Relaxing
                                                    </a>
                                                </div>
                                                <div>
                                                    <img
                                                        src="/react/images/media/media-10.jpg"
                                                        className="card-img"
                                                        alt="..."
                                                    />
                                                </div>
                                            </div>
                                            <div className="card-footer">
                                                <div className="d-flex align-items-center gap-2 flex-wrap">
                                                    <div className="avatar-list-stacked">
                                                        <span className="avatar avatar-rounded">
                                                            <img
                                                                src="/react/images/faces/13.jpg"
                                                                alt="img"
                                                            />
                                                        </span>
                                                        <span className="avatar avatar-rounded">
                                                            <img
                                                                src="/react/images/faces/3.jpg"
                                                                alt="img"
                                                            />
                                                        </span>
                                                        <span className="avatar avatar-rounded">
                                                            <img
                                                                src="/react/images/faces/4.jpg"
                                                                alt="img"
                                                            />
                                                        </span>
                                                        <span className="avatar avatar-rounded">
                                                            <img
                                                                src="/react/images/faces/14.jpg"
                                                                alt="img"
                                                            />
                                                        </span>
                                                        <span className="avatar avatar-rounded">
                                                            <img
                                                                src="/react/images/faces/5.jpg"
                                                                alt="img"
                                                            />
                                                        </span>
                                                    </div>
                                                    <div className="flex-fill">
                                                        and 25 others{" "}
                                                        <i className="ri-heart-3-fill text-danger"></i>{" "}
                                                        this post
                                                    </div>
                                                    <div className="d-flex align-items-center gap-2 flex-wrap">
                                                        <a
                                                            role="button"
                                                            className="p-1 px-2 bg-primary-transparent rounded"
                                                        >
                                                            <i className="ri-message-3-line me-1"></i>
                                                            Comment
                                                        </a>
                                                        <a
                                                            role="button"
                                                            className="p-1 px-2 bg-info-transparent rounded"
                                                        >
                                                            <i className="ri-share-forward-line me-1"></i>
                                                            Share
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div className="card-footer">
                                                <ul className="list-unstyled post-comments-list">
                                                    <li>
                                                        <div className="d-flex align-items-start gap-3">
                                                            <div className="lh-1">
                                                                <span className="avatar avatar-md avatar-rounded">
                                                                    <img
                                                                        src="/react/images/faces/6.jpg"
                                                                        alt=""
                                                                    />
                                                                </span>
                                                            </div>
                                                            <div className="flex-fill p-3 rounded bg-light">
                                                                <div className="d-flex align-items-center justify-content-between flex-wrap">
                                                                    <div className="fw-semibold">
                                                                        Emma
                                                                        Watson
                                                                    </div>
                                                                    <div className="text-muted fs-13">
                                                                        2 hours
                                                                        ago
                                                                    </div>
                                                                </div>
                                                                <div className="text-muted">
                                                                    Such a
                                                                    peaceful
                                                                    moment at
                                                                    the beach!
                                                                    Perfect way
                                                                    to end the
                                                                    day.
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div className="d-flex align-items-center lh-1 flex-wrap">
                                                            <div className="me-3">
                                                                <span className="avatar avatar-md avatar-rounded">
                                                                    <img
                                                                        src="/react/images/faces/12.jpg"
                                                                        alt=""
                                                                    />
                                                                </span>
                                                            </div>
                                                            <div className="flex-fill">
                                                                <div className="input-group">
                                                                    <input
                                                                        type="text"
                                                                        className="form-control"
                                                                        placeholder="Write a comment"
                                                                        aria-label="comment"
                                                                    />
                                                                    <button
                                                                        className="btn btn-light border"
                                                                        type="button"
                                                                    >
                                                                        <i className="bi bi-emoji-smile"></i>
                                                                    </button>
                                                                    <button
                                                                        className="btn btn-light border"
                                                                        type="button"
                                                                    >
                                                                        <i className="bi bi-paperclip"></i>
                                                                    </button>
                                                                    <button
                                                                        className="btn btn-light border"
                                                                        type="button"
                                                                    >
                                                                        <i className="bi bi-camera"></i>
                                                                    </button>
                                                                    <button
                                                                        className="btn btn-primary"
                                                                        type="button"
                                                                    >
                                                                        Post
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div> */}
                                </div>
                            </div>
                            <div
                                className="tab-pane p-0 border-0"
                                id="gallery-tab-pane"
                                role="tabpanel"
                                aria-labelledby="gallery-tab"
                                tabIndex="0"
                            >
                                <div className="row">
                                    <div className="col-xl-12">
                                        <div className="card custom-card">
                                            <div className="card-body">
                                                <div className="row gy-4">
                                                    <div className="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                                        <a
                                                            href="../assets/images/media/media-40.jpg"
                                                            className="glightbox"
                                                            data-gallery="gallery1"
                                                        >
                                                            <img
                                                                src="/react/images/media/media-40.jpg"
                                                                alt="image"
                                                                className="img-fluid rounded"
                                                            />
                                                        </a>
                                                    </div>
                                                    <div className="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                                        <a
                                                            href="../assets/images/media/media-41.jpg"
                                                            className="glightbox"
                                                            data-gallery="gallery1"
                                                        >
                                                            <img
                                                                src="/react/images/media/media-41.jpg"
                                                                alt="image"
                                                                className="img-fluid rounded"
                                                            />
                                                        </a>
                                                    </div>
                                                    <div className="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                                        <a
                                                            href="../assets/images/media/media-42.jpg"
                                                            className="glightbox"
                                                            data-gallery="gallery1"
                                                        >
                                                            <img
                                                                src="/react/images/media/media-42.jpg"
                                                                alt="image"
                                                                className="img-fluid rounded"
                                                            />
                                                        </a>
                                                    </div>
                                                    <div className="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                                        <a
                                                            href="../assets/images/media/media-43.jpg"
                                                            className="glightbox"
                                                            data-gallery="gallery1"
                                                        >
                                                            <img
                                                                src="/react/images/media/media-43.jpg"
                                                                alt="image"
                                                                className="img-fluid rounded"
                                                            />
                                                        </a>
                                                    </div>
                                                    <div className="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                                        <a
                                                            href="../assets/images/media/media-44.jpg"
                                                            className="glightbox"
                                                            data-gallery="gallery1"
                                                        >
                                                            <img
                                                                src="/react/images/media/media-44.jpg"
                                                                alt="image"
                                                                className="img-fluid rounded"
                                                            />
                                                        </a>
                                                    </div>
                                                    <div className="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                                        <a
                                                            href="../assets/images/media/media-45.jpg"
                                                            className="glightbox"
                                                            data-gallery="gallery1"
                                                        >
                                                            <img
                                                                src="/react/images/media/media-45.jpg"
                                                                alt="image"
                                                                className="img-fluid rounded"
                                                            />
                                                        </a>
                                                    </div>
                                                    <div className="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                                        <a
                                                            href="../assets/images/media/media-46.jpg"
                                                            className="glightbox"
                                                            data-gallery="gallery1"
                                                        >
                                                            <img
                                                                src="/react/images/media/media-46.jpg"
                                                                alt="image"
                                                                className="img-fluid rounded"
                                                            />
                                                        </a>
                                                    </div>
                                                    <div className="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                                        <a
                                                            href="../assets/images/media/media-60.jpg"
                                                            className="glightbox"
                                                            data-gallery="gallery1"
                                                        >
                                                            <img
                                                                src="/react/images/media/media-60.jpg"
                                                                alt="image"
                                                                className="img-fluid rounded"
                                                            />
                                                        </a>
                                                    </div>
                                                    <div className="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                                        <a
                                                            href="../assets/images/media/media-26.jpg"
                                                            className="glightbox"
                                                            data-gallery="gallery1"
                                                        >
                                                            <img
                                                                src="/react/images/media/media-26.jpg"
                                                                alt="image"
                                                                className="img-fluid rounded"
                                                            />
                                                        </a>
                                                    </div>
                                                    <div className="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                                        <a
                                                            href="../assets/images/media/media-32.jpg"
                                                            className="glightbox"
                                                            data-gallery="gallery1"
                                                        >
                                                            <img
                                                                src="/react/images/media/media-32.jpg"
                                                                alt="image"
                                                                className="img-fluid rounded"
                                                            />
                                                        </a>
                                                    </div>
                                                    <div className="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                                        <a
                                                            href="../assets/images/media/media-30.jpg"
                                                            className="glightbox"
                                                            data-gallery="gallery1"
                                                        >
                                                            <img
                                                                src="/react/images/media/media-30.jpg"
                                                                alt="image"
                                                                className="img-fluid rounded"
                                                            />
                                                        </a>
                                                    </div>
                                                    <div className="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                                        <a
                                                            href="../assets/images/media/media-31.jpg"
                                                            className="glightbox"
                                                            data-gallery="gallery1"
                                                        >
                                                            <img
                                                                src="/react/images/media/media-31.jpg"
                                                                alt="image"
                                                                className="img-fluid rounded"
                                                            />
                                                        </a>
                                                    </div>
                                                    <div className="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                                        <a
                                                            href="../assets/images/media/media-46.jpg"
                                                            className="glightbox"
                                                            data-gallery="gallery1"
                                                        >
                                                            <img
                                                                src="/react/images/media/media-46.jpg"
                                                                alt="image"
                                                                className="img-fluid rounded"
                                                            />
                                                        </a>
                                                    </div>
                                                    <div className="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                                        <a
                                                            href="../assets/images/media/media-59.jpg"
                                                            className="glightbox"
                                                            data-gallery="gallery1"
                                                        >
                                                            <img
                                                                src="/react/images/media/media-59.jpg"
                                                                alt="image"
                                                                className="img-fluid rounded"
                                                            />
                                                        </a>
                                                    </div>
                                                    <div className="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                                        <a
                                                            href="../assets/images/media/media-61.jpg"
                                                            className="glightbox"
                                                            data-gallery="gallery1"
                                                        >
                                                            <img
                                                                src="/react/images/media/media-61.jpg"
                                                                alt="image"
                                                                className="img-fluid rounded"
                                                            />
                                                        </a>
                                                    </div>
                                                    <div className="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                                        <a
                                                            href="../assets/images/media/media-42.jpg"
                                                            className="glightbox"
                                                            data-gallery="gallery1"
                                                        >
                                                            <img
                                                                src="/react/images/media/media-42.jpg"
                                                                alt="image"
                                                                className="img-fluid rounded"
                                                            />
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div
                                className="tab-pane p-0 border-0"
                                id="followers-tab-pane"
                                role="tabpanel"
                                aria-labelledby="followers-tab"
                                tabIndex="0"
                            >
                                <div className="row">
                                    <div className="col-xl-4">
                                        <div className="card custom-card">
                                            <div className="card-body">
                                                <div className="d-flex align-items-center gap-2 flex-wrap">
                                                    <div className="lh-1">
                                                        <span className="avatar avatar-lg avatar-rounded">
                                                            <img
                                                                src="/react/images/faces/9.jpg"
                                                                alt=""
                                                            />
                                                        </span>
                                                    </div>
                                                    <div className="flex-fill">
                                                        <span className="fw-semibold d-block">
                                                            JohnDoe
                                                        </span>
                                                        <span className="text-muted fs-13">
                                                            john.doe@example.com
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <button className="btn btn-primary-ghost">
                                                            <i className="ri-user-add-line me-1"></i>
                                                            Follow
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div className="col-xl-4">
                                        <div className="card custom-card">
                                            <div className="card-body">
                                                <div className="d-flex align-items-center gap-2 flex-wrap">
                                                    <div className="lh-1">
                                                        <span className="avatar avatar-lg avatar-rounded">
                                                            <img
                                                                src="/react/images/faces/1.jpg"
                                                                alt=""
                                                            />
                                                        </span>
                                                    </div>
                                                    <div className="flex-fill">
                                                        <span className="fw-semibold d-block">
                                                            SarahSmith
                                                        </span>
                                                        <span className="text-muted fs-13">
                                                            sarah.smith@example.com
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <button className="btn btn-primary-ghost">
                                                            <i className="ri-user-add-line me-1"></i>
                                                            Follow
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div className="col-xl-4">
                                        <div className="card custom-card">
                                            <div className="card-body">
                                                <div className="d-flex align-items-center gap-2 flex-wrap">
                                                    <div className="lh-1">
                                                        <span className="avatar avatar-lg avatar-rounded">
                                                            <img
                                                                src="/react/images/faces/10.jpg"
                                                                alt=""
                                                            />
                                                        </span>
                                                    </div>
                                                    <div className="flex-fill">
                                                        <span className="fw-semibold d-block">
                                                            MichaelBrown
                                                        </span>
                                                        <span className="text-muted fs-13">
                                                            michael.brown@example.com
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <button className="btn btn-primary-ghost">
                                                            <i className="ri-user-add-line me-1"></i>
                                                            Follow
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div className="col-xl-4">
                                        <div className="card custom-card">
                                            <div className="card-body">
                                                <div className="d-flex align-items-center gap-2 flex-wrap">
                                                    <div className="lh-1">
                                                        <span className="avatar avatar-lg avatar-rounded">
                                                            <img
                                                                src="/react/images/faces/2.jpg"
                                                                alt=""
                                                            />
                                                        </span>
                                                    </div>
                                                    <div className="flex-fill">
                                                        <span className="fw-semibold d-block">
                                                            EmmaWilson
                                                        </span>
                                                        <span className="text-muted fs-13">
                                                            emma.wilson@example.com
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <button className="btn btn-primary-ghost">
                                                            <i className="ri-user-add-line me-1"></i>
                                                            Follow
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div className="col-xl-4">
                                        <div className="card custom-card">
                                            <div className="card-body">
                                                <div className="d-flex align-items-center gap-2 flex-wrap">
                                                    <div className="lh-1">
                                                        <span className="avatar avatar-lg avatar-rounded">
                                                            <img
                                                                src="/react/images/faces/11.jpg"
                                                                alt=""
                                                            />
                                                        </span>
                                                    </div>
                                                    <div className="flex-fill">
                                                        <span className="fw-semibold d-block">
                                                            JamesTaylor
                                                        </span>
                                                        <span className="text-muted fs-13">
                                                            james.taylor@example.com
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <button className="btn btn-danger-ghost">
                                                            <i className="ri-user-minus-line me-1"></i>
                                                            Unfollow
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div className="col-xl-4">
                                        <div className="card custom-card">
                                            <div className="card-body">
                                                <div className="d-flex align-items-center gap-2 flex-wrap">
                                                    <div className="lh-1">
                                                        <span className="avatar avatar-lg avatar-rounded">
                                                            <img
                                                                src="/react/images/faces/3.jpg"
                                                                alt=""
                                                            />
                                                        </span>
                                                    </div>
                                                    <div className="flex-fill">
                                                        <span className="fw-semibold d-block">
                                                            OliviaJohnson
                                                        </span>
                                                        <span className="text-muted fs-13">
                                                            olivia.johnson@example.com
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <button className="btn btn-primary-ghost">
                                                            <i className="ri-user-add-line me-1"></i>
                                                            Follow
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div className="col-xl-4">
                                        <div className="card custom-card">
                                            <div className="card-body">
                                                <div className="d-flex align-items-center gap-2 flex-wrap">
                                                    <div className="lh-1">
                                                        <span className="avatar avatar-lg avatar-rounded">
                                                            <img
                                                                src="/react/images/faces/13.jpg"
                                                                alt=""
                                                            />
                                                        </span>
                                                    </div>
                                                    <div className="flex-fill">
                                                        <span className="fw-semibold d-block">
                                                            DavidMartinez
                                                        </span>
                                                        <span className="text-muted fs-13">
                                                            david.martinez@example.com
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <button className="btn btn-primary-ghost">
                                                            <i className="ri-user-add-line me-1"></i>
                                                            Follow
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div className="col-xl-4">
                                        <div className="card custom-card">
                                            <div className="card-body">
                                                <div className="d-flex align-items-center gap-2 flex-wrap">
                                                    <div className="lh-1">
                                                        <span className="avatar avatar-lg avatar-rounded">
                                                            <img
                                                                src="/react/images/faces/4.jpg"
                                                                alt=""
                                                            />
                                                        </span>
                                                    </div>
                                                    <div className="flex-fill">
                                                        <span className="fw-semibold d-block">
                                                            SophiaGarcia
                                                        </span>
                                                        <span className="text-muted fs-13">
                                                            sophia.garcia@example.com
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <button className="btn btn-primary-ghost">
                                                            <i className="ri-user-add-line me-1"></i>
                                                            Follow
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div className="col-xl-4">
                                        <div className="card custom-card">
                                            <div className="card-body">
                                                <div className="d-flex align-items-center gap-2 flex-wrap">
                                                    <div className="lh-1">
                                                        <span className="avatar avatar-lg avatar-rounded">
                                                            <img
                                                                src="/react/images/faces/14.jpg"
                                                                alt=""
                                                            />
                                                        </span>
                                                    </div>
                                                    <div className="flex-fill">
                                                        <span className="fw-semibold d-block">
                                                            DanielLee
                                                        </span>
                                                        <span className="text-muted fs-13">
                                                            daniel.lee@example.com
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <button className="btn btn-primary-ghost">
                                                            <i className="ri-user-add-line me-1"></i>
                                                            Follow
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div className="col-xl-4">
                                        <div className="card custom-card">
                                            <div className="card-body">
                                                <div className="d-flex align-items-center gap-2 flex-wrap">
                                                    <div className="lh-1">
                                                        <span className="avatar avatar-lg avatar-rounded">
                                                            <img
                                                                src="/react/images/faces/5.jpg"
                                                                alt=""
                                                            />
                                                        </span>
                                                    </div>
                                                    <div className="flex-fill">
                                                        <span className="fw-semibold d-block">
                                                            IsabellaHarris
                                                        </span>
                                                        <span className="text-muted fs-13">
                                                            isabella.harris@example.com
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <button className="btn btn-danger-ghost">
                                                            <i className="ri-user-minus-line me-1"></i>
                                                            Unfollow
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div className="col-xl-4">
                                        <div className="card custom-card">
                                            <div className="card-body">
                                                <div className="d-flex align-items-center gap-2 flex-wrap">
                                                    <div className="lh-1">
                                                        <span className="avatar avatar-lg avatar-rounded">
                                                            <img
                                                                src="/react/images/faces/15.jpg"
                                                                alt=""
                                                            />
                                                        </span>
                                                    </div>
                                                    <div className="flex-fill">
                                                        <span className="fw-semibold d-block">
                                                            WilliamClark
                                                        </span>
                                                        <span className="text-muted fs-13">
                                                            william.clark@example.com
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <button className="btn btn-primary-ghost">
                                                            <i className="ri-user-add-line me-1"></i>
                                                            Follow
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div className="col-xl-4">
                                        <div className="card custom-card">
                                            <div className="card-body">
                                                <div className="d-flex align-items-center gap-2 flex-wrap">
                                                    <div className="lh-1">
                                                        <span className="avatar avatar-lg avatar-rounded">
                                                            <img
                                                                src="/react/images/faces/6.jpg"
                                                                alt=""
                                                            />
                                                        </span>
                                                    </div>
                                                    <div className="flex-fill">
                                                        <span className="fw-semibold d-block">
                                                            MiaLewis
                                                        </span>
                                                        <span className="text-muted fs-13">
                                                            mia.lewis@example.com
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <button className="btn btn-primary-ghost">
                                                            <i className="ri-user-add-line me-1"></i>
                                                            Follow
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div className="col-xl-4">
                                        <div className="card custom-card">
                                            <div className="card-body">
                                                <div className="d-flex align-items-center gap-2 flex-wrap">
                                                    <div className="lh-1">
                                                        <span className="avatar avatar-lg avatar-rounded">
                                                            <img
                                                                src="/react/images/faces/16.jpg"
                                                                alt=""
                                                            />
                                                        </span>
                                                    </div>
                                                    <div className="flex-fill">
                                                        <span className="fw-semibold d-block">
                                                            AlexanderWalker
                                                        </span>
                                                        <span className="text-muted fs-13">
                                                            alexander.walker@example.com
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <button className="btn btn-primary-ghost">
                                                            <i className="ri-user-add-line me-1"></i>
                                                            Follow
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div className="col-xl-4">
                                        <div className="card custom-card">
                                            <div className="card-body">
                                                <div className="d-flex align-items-center gap-2 flex-wrap">
                                                    <div className="lh-1">
                                                        <span className="avatar avatar-lg avatar-rounded">
                                                            <img
                                                                src="/react/images/faces/7.jpg"
                                                                alt=""
                                                            />
                                                        </span>
                                                    </div>
                                                    <div className="flex-fill">
                                                        <span className="fw-semibold d-block">
                                                            CharlotteAllen
                                                        </span>
                                                        <span className="text-muted fs-13">
                                                            charlotte.allen@example.com
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <button className="btn btn-primary-ghost">
                                                            <i className="ri-user-add-line me-1"></i>
                                                            Follow
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div className="col-xl-4">
                                        <div className="card custom-card">
                                            <div className="card-body">
                                                <div className="d-flex align-items-center gap-2 flex-wrap">
                                                    <div className="lh-1">
                                                        <span className="avatar avatar-lg avatar-rounded">
                                                            <img
                                                                src="/react/images/faces/8.jpg"
                                                                alt=""
                                                            />
                                                        </span>
                                                    </div>
                                                    <div className="flex-fill">
                                                        <span className="fw-semibold d-block">
                                                            BenjaminYoung
                                                        </span>
                                                        <span className="text-muted fs-13">
                                                            benjamin.young@example.com
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <button className="btn btn-danger-ghost">
                                                            <i className="ri-user-minus-line me-1"></i>
                                                            Unfollow
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
}

Profil.layout = (page) => <MainLayout>{page}</MainLayout>;
