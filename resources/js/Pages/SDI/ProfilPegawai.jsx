import MainLayout from "@/Layouts/MainLayout";
import React, { useRef, useEffect, useState } from "react";
import { Head, router, usePage, useForm, Link } from "@inertiajs/react";
import { validateForm } from "@/Helpers/formValidation";
import { initDataTable, initTooltips, showLoading } from "@/Helpers/Helper";

export default function ProfilPegawai() {
    const [fileFoto, setFile] = useState(null);
    const { auth, list, flash } = usePage().props;
    const user = list.user;
    const role = list.role;
    const foto_user = list.foto_user;
    const status_user = list.status_user;
    const [preview, setPreview] = useState(
        foto_user && foto_user?.filename
            ? foto_user.filename.replace("public/", "/storage/")
            : "/react/images/faces/21.jpg"
    );
    return (
        <>
            <Head title={`Profil ${user?.name ?? "Pegawai"}`} />

            <div className="container-fluid page-container main-body-container">
                <div className="page-header-breadcrumb mb-3">
                    <div className="d-flex align-center justify-content-between flex-wrap">
                        <div>
                            <div className="d-flex align-items-center">
                                <Link
                                    href={route("v4.sdi.pegawai.index")}
                                    as="button"
                                    className="btn btn-sm btn-primary-light rounded-pill shadow-sm me-2"
                                >
                                    <i className="ri-arrow-left-s-line me-1"></i>{" "}
                                    Kembali
                                </Link>
                                <h1 className="page-title fw-medium fs-18 mb-0">
                                    Profil{" "}
                                    <b className="text-primary">{user.name}</b>
                                </h1>
                            </div>
                        </div>
                        <ol className="breadcrumb mb-0">
                            <li className="breadcrumb-item">
                                <a role="button">SDI</a>
                            </li>
                            <li className="breadcrumb-item">
                                <a role="button">Daftar Pegawai</a>
                            </li>
                            <li
                                className="breadcrumb-item active"
                                aria-current="page"
                            >
                                Profil Pegawai
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
                                        <a
                                            href={
                                                foto_user?.filename
                                                    ? foto_user?.filename.replace(
                                                          "public/",
                                                          "/storage/"
                                                      )
                                                    : "/react/images/faces/21.jpg"
                                            }
                                            className="glightbox"
                                            data-gallery="fotoProfil"
                                            role="button"
                                        >
                                            <span className="avatar avatar-xxl avatar-rounded bg-light-transparent online">
                                                {/* <img src="../assets/images/media/media-40.jpg" alt="image" class="img-fluid rounded"> */}
                                                <img
                                                    src={
                                                        foto_user?.filename
                                                            ? foto_user?.filename.replace(
                                                                  "public/",
                                                                  "/storage/"
                                                              )
                                                            : "/react/images/faces/21.jpg"
                                                    }
                                                    alt="Foto Profil"
                                                />
                                            </span>
                                        </a>
                                        <div className="mt-4 mb-3 d-flex align-items-center flex-wrap gap-3 justify-content-between">
                                            <div>
                                                <h5 className="fw-semibold mb-1">
                                                    {user?.nama ? (
                                                        <>{user.nama}</>
                                                    ) : (
                                                        <>
                                                            {user?.name}{" "}
                                                            <b className="text-danger">
                                                                (Profil Belum
                                                                Lengkap)
                                                            </b>
                                                        </>
                                                    )}
                                                    {role && role.length > 0 ? (
                                                        role.map((val, i) => (
                                                            <span
                                                                key={i}
                                                                className="badge bg-primary-transparent ms-2 align-middle"
                                                            >
                                                                {val.nama_role}
                                                            </span>
                                                        ))
                                                    ) : (
                                                        <span className="text-muted">
                                                            xxx
                                                        </span>
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
                                                            <>
                                                                {
                                                                    "Terakhir Login: -"
                                                                }
                                                            </>
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
                                                    id=""
                                                    data-bs-toggle="tab"
                                                    data-bs-target="#profil-tab"
                                                    type="button"
                                                    role="tab"
                                                    aria-controls="profil-tab"
                                                    aria-selected="true"
                                                >
                                                    Data Diri
                                                </button>
                                            </li>
                                            {/* <li
                                                    className="nav-item"
                                                    role="presentation"
                                                >
                                                    <button
                                                        className="nav-link"
                                                        id=""
                                                        data-bs-toggle="tab"
                                                        data-bs-target="#dokumen-tab"
                                                        type="button"
                                                        role="tab"
                                                        aria-controls="dokumen-tab"
                                                        aria-selected="false"
                                                        // onClick={() =>
                                                        //     refreshDokumen()
                                                        // }
                                                    >
                                                        Dokumen
                                                    </button>
                                                </li> */}
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div className="col-xl-12">
                        <div className="tab-content" id="">
                            <div
                                className="tab-pane show active p-0 border-0"
                                id="profil-tab"
                                role="tabpanel"
                                aria-labelledby="profil-tab"
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
                                                            Pengalaman Kerja
                                                        </div>
                                                    </div>
                                                    <div className="card-body">
                                                        <p
                                                            className="text-muted mb-0"
                                                            dangerouslySetInnerHTML={{
                                                                __html: user?.pengalaman_kerja
                                                                    ? user.pengalaman_kerja.replace(
                                                                          /\r\n|\r|\n/g,
                                                                          "<br>"
                                                                      )
                                                                    : "Tidak ada deskripsi pengalaman kerja.",
                                                            }}
                                                        ></p>
                                                    </div>
                                                </div>
                                                <div className="card custom-card">
                                                    <div className="card-header">
                                                        <div className="card-title">
                                                            Data Sensitif
                                                        </div>
                                                    </div>
                                                    <div className="card-body">
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
                                                                            href={
                                                                                user?.fb
                                                                                    ? `https://www.facebook.com/${user.fb}`
                                                                                    : undefined
                                                                            }
                                                                            target="_blank"
                                                                            rel="noopener noreferrer"
                                                                            className="text-muted"
                                                                        >
                                                                            Facebook
                                                                            /{" "}
                                                                            <mark>
                                                                                {user?.fb ||
                                                                                    "xxx"}
                                                                            </mark>
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
                                                                            href={
                                                                                user?.ig
                                                                                    ? `https://www.instagram.com/${user.ig}`
                                                                                    : undefined
                                                                            }
                                                                            target="_blank"
                                                                            rel="noopener noreferrer"
                                                                            className="text-muted"
                                                                        >
                                                                            Instagram
                                                                            /{" "}
                                                                            <mark>
                                                                                {user?.ig ||
                                                                                    "xxx"}
                                                                            </mark>
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
                                                                            href={
                                                                                user?.tt
                                                                                    ? `https://www.tiktok.com/@${user.tt}`
                                                                                    : undefined
                                                                            }
                                                                            target="_blank"
                                                                            rel="noopener noreferrer"
                                                                            className="text-muted"
                                                                        >
                                                                            Tiktok
                                                                            /{" "}
                                                                            <mark>
                                                                                {user?.tt ||
                                                                                    "xxx"}
                                                                            </mark>
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
                                                                            Youtube{" "}
                                                                            <b className="text-danger">
                                                                                RS
                                                                            </b>
                                                                        </span>
                                                                        <a
                                                                            href="https://www.youtube.com/@rspkumuhsukoharjo1801"
                                                                            target="_blank"
                                                                            rel="noopener noreferrer"
                                                                            className="text-muted"
                                                                        >
                                                                            Youtube
                                                                            /{" "}
                                                                            <mark>
                                                                                rspkusukoharjo
                                                                            </mark>
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
                                                                <p className="mb-1 text-muted">
                                                                    Nama Lengkap
                                                                </p>
                                                                <p className="mb-0">
                                                                    {user?.nama ||
                                                                        "..."}
                                                                </p>
                                                            </div>
                                                            <div className="col-md-6">
                                                                <p className="mb-1 text-muted">
                                                                    Nama
                                                                    Panggilan
                                                                </p>
                                                                <p className="mb-0">
                                                                    {user?.nick ||
                                                                        "..."}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li className="list-group-item px-0">
                                                        <div className="row">
                                                            <div className="col-md-6">
                                                                <p className="mb-1 text-muted">
                                                                    Tempat Lahir
                                                                </p>
                                                                <p className="mb-0">
                                                                    {user?.temp_lahir ||
                                                                        "..."}
                                                                </p>
                                                            </div>
                                                            <div className="col-md-6">
                                                                <p className="mb-1 text-muted">
                                                                    Tanggal
                                                                    Lahir
                                                                </p>
                                                                <p className="mb-0">
                                                                    {user?.tgl_lahir
                                                                        ? dayjs(
                                                                              user.tgl_lahir
                                                                          ).format(
                                                                              "D MMMM YYYY"
                                                                          )
                                                                        : "..."}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li className="list-group-item px-0">
                                                        <div className="row">
                                                            <div className="col-md-6">
                                                                <p className="mb-1 text-muted">
                                                                    Jenis
                                                                    Kelamin
                                                                </p>
                                                                <p className="mb-0">
                                                                    {user?.jns_kelamin ||
                                                                        "..."}
                                                                </p>
                                                            </div>
                                                            <div className="col-md-6">
                                                                <p className="mb-1 text-muted">
                                                                    Status Kawin
                                                                </p>
                                                                <p className="mb-0">
                                                                    {user?.status_kawin ||
                                                                        "..."}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li className="list-group-item px-0">
                                                        <p className="mb-1 text-muted">
                                                            Alamat Lengkap{" "}
                                                            <strong className="text-danger">
                                                                Sesuai KTP
                                                            </strong>
                                                        </p>
                                                        <p className="mb-0">
                                                            {user?.alamat_ktp ? (
                                                                <span
                                                                    dangerouslySetInnerHTML={{
                                                                        __html: user.alamat_ktp.replace(
                                                                            /(\r\n|\r|\n)/g,
                                                                            "<br>"
                                                                        ),
                                                                    }}
                                                                />
                                                            ) : (
                                                                "..."
                                                            )}
                                                        </p>
                                                    </li>
                                                    <li className="list-group-item px-0 pb-0">
                                                        <p className="mb-1 text-muted">
                                                            Alamat Domisili
                                                        </p>
                                                        <p className="mb-0">
                                                            {user?.alamat_ktp ? (
                                                                user?.alamat_dom ? (
                                                                    <span
                                                                        dangerouslySetInnerHTML={{
                                                                            __html: user.alamat_dom.replace(
                                                                                /(\r\n|\r|\n)/g,
                                                                                "<br>"
                                                                            ),
                                                                        }}
                                                                    />
                                                                ) : (
                                                                    "Sama dengan alamat pada KTP"
                                                                )
                                                            ) : (
                                                                "..."
                                                            )}
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
                                                        {
                                                            jenjang: "S3",
                                                            jurusan: user?.s3,
                                                            tahun: user?.th_s3,
                                                            color: "primary",
                                                        },
                                                        {
                                                            jenjang: "S2",
                                                            jurusan: user?.s2,
                                                            tahun: user?.th_s2,
                                                            color: "success",
                                                        },
                                                        {
                                                            jenjang:
                                                                "S1 Profesi",
                                                            jurusan:
                                                                user?.s1_profesi,
                                                            tahun: user?.th_s1_profesi,
                                                            color: "info",
                                                        },
                                                        {
                                                            jenjang: "S1",
                                                            jurusan: user?.s1,
                                                            tahun: user?.th_s1,
                                                            color: "warning",
                                                        },
                                                        {
                                                            jenjang: "D4",
                                                            jurusan: user?.d4,
                                                            tahun: user?.th_d4,
                                                            color: "secondary",
                                                        },
                                                        {
                                                            jenjang: "D3",
                                                            jurusan: user?.d3,
                                                            tahun: user?.th_d3,
                                                            color: "danger",
                                                        },
                                                        {
                                                            jenjang: "D2",
                                                            jurusan: user?.d2,
                                                            tahun: user?.th_d2,
                                                            color: "purple",
                                                        },
                                                        {
                                                            jenjang: "SMA",
                                                            jurusan: user?.sma,
                                                            tahun: user?.th_sma,
                                                            color: "info",
                                                        },
                                                        {
                                                            jenjang: "SMP",
                                                            jurusan: user?.smp,
                                                            tahun: user?.th_smp,
                                                            color: "warning",
                                                        },
                                                        {
                                                            jenjang: "SD",
                                                            jurusan: user?.sd,
                                                            tahun: user?.th_sd,
                                                            color: "secondary",
                                                        },
                                                    ]
                                                        .filter(
                                                            (item) =>
                                                                item.jurusan
                                                        ) // hanya tampil jika tidak kosong
                                                        .map((item, index) => (
                                                            <li key={index}>
                                                                <div className="d-flex align-items-center gap-2 mb-1 flex-wrap">
                                                                    <div className="fw-semibold fs-15">
                                                                        <span className="text-muted">
                                                                            <a
                                                                                className="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover text-decoration-underline"
                                                                                role="button"
                                                                            >
                                                                                {
                                                                                    item.jurusan
                                                                                }
                                                                            </a>
                                                                        </span>
                                                                    </div>
                                                                    <span
                                                                        className={`badge bg-${item.color}-transparent`}
                                                                    >
                                                                        Lulus{" "}
                                                                        {item.tahun ||
                                                                            "xxx"}
                                                                    </span>
                                                                </div>
                                                                <div className="fs-13 text-muted">
                                                                    Telah
                                                                    selesai
                                                                    Pendidikan
                                                                    jenjang{" "}
                                                                    <span className="fw-medium text-default">
                                                                        {
                                                                            item.jenjang
                                                                        }
                                                                    </span>{" "}
                                                                    di{" "}
                                                                    <span className="fw-medium text-default">
                                                                        {
                                                                            item.jurusan
                                                                        }
                                                                    </span>
                                                                    {item.tahun
                                                                        ? " pada tahun " +
                                                                          item.tahun
                                                                        : ""}
                                                                    .
                                                                </div>
                                                            </li>
                                                        ))}
                                                </ul>

                                                {/* Jika semua kosong */}
                                                {![
                                                    user?.s3,
                                                    user?.s2,
                                                    user?.s1_profesi,
                                                    user?.s1,
                                                    user?.d4,
                                                    user?.d3,
                                                    user?.d2,
                                                    user?.sma,
                                                    user?.smp,
                                                    user?.sd,
                                                ].some((v) => v) && (
                                                    <div className="text-muted">
                                                        Tidak ada data
                                                        pendidikan.
                                                    </div>
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
                                                            <div className="fw-medium fs-14 text-default">
                                                                Riwayat
                                                                Penyakit?
                                                            </div>
                                                            <p
                                                                className="mb-0"
                                                                dangerouslySetInnerHTML={{
                                                                    __html: user?.riwayat_penyakit
                                                                        ? user.riwayat_penyakit.replace(
                                                                              /\r\n|\r|\n/g,
                                                                              "<br>"
                                                                          )
                                                                        : "Tidak Ada.",
                                                                }}
                                                            ></p>
                                                        </div>
                                                    </li>
                                                    <li className="list-group-item d-sm-flex justify-content-between align-items-start">
                                                        <div className="ms-2 me-auto text-muted">
                                                            <div className="fw-medium fs-14 text-default">
                                                                Riwayat Penyakit
                                                                Keluarga?
                                                            </div>
                                                            <p
                                                                className="mb-0"
                                                                dangerouslySetInnerHTML={{
                                                                    __html: user?.riwayat_penyakit_keluarga
                                                                        ? user.riwayat_penyakit_keluarga.replace(
                                                                              /\r\n|\r|\n/g,
                                                                              "<br>"
                                                                          )
                                                                        : "Tidak Ada.",
                                                                }}
                                                            ></p>
                                                        </div>
                                                    </li>
                                                    <li className="list-group-item d-sm-flex justify-content-between align-items-start">
                                                        <div className="ms-2 me-auto text-muted">
                                                            <div className="fw-medium fs-14 text-default">
                                                                Riwayat
                                                                Penggunaan Obat?
                                                            </div>
                                                            <p
                                                                className="mb-0"
                                                                dangerouslySetInnerHTML={{
                                                                    __html: user?.riwayat_penggunaan_obat
                                                                        ? user.riwayat_penggunaan_obat.replace(
                                                                              /\r\n|\r|\n/g,
                                                                              "<br>"
                                                                          )
                                                                        : "Tidak Ada.",
                                                                }}
                                                            ></p>
                                                        </div>
                                                    </li>
                                                    <li className="list-group-item d-sm-flex justify-content-between align-items-start">
                                                        <div className="ms-2 me-auto text-muted">
                                                            <div className="fw-medium fs-14 text-default">
                                                                Riwayat Operasi?
                                                            </div>
                                                            <p
                                                                className="mb-0"
                                                                dangerouslySetInnerHTML={{
                                                                    __html: user?.riwayat_operasi
                                                                        ? user.riwayat_operasi.replace(
                                                                              /\r\n|\r|\n/g,
                                                                              "<br>"
                                                                          )
                                                                        : "Tidak Ada.",
                                                                }}
                                                            ></p>
                                                        </div>
                                                    </li>
                                                </ol>
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

ProfilPegawai.layout = (page) => <MainLayout>{page}</MainLayout>;
