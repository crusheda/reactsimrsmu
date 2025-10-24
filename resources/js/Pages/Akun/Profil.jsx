import MainLayout from "@/Layouts/MainLayout";
import React, { useEffect, useState } from "react";
import { Head, router, usePage, useForm, Link } from "@inertiajs/react";

export default function Profil() {
    const { auth, list } = usePage().props;
    const user = list.user;
    const role = list.role;
    const foto_user = list.foto_user;
    const status_user = list.status_user;
    const { data, setData, post, processing, errors } = useForm({
        pengalaman_kerja: list.user.pengalaman_kerja || "",
        gelar_depan: list.user.gelar_depan || "",
        nama: list.user.nama || "",
        gelar_belakang: list.user.gelar_belakang || "",
        nik: list.user.nik || "",
        email: list.user.email || "",
        no_hp: list.user.no_hp || "",
        nick: list.user.nick || "",
        temp_lahir: list.user.temp_lahir || "",
        tgl_lahir: list.user.tgl_lahir || "",
        jns_kelamin: list.user.jns_kelamin || "",
        status_kawin: list.user.status_kawin || "",
        ktp_provinsi: list.user.ktp_provinsi || "",
        ktp_kabupaten: list.user.ktp_kabupaten || "",
        ktp_kecamatan: list.user.ktp_kecamatan || "",
        ktp_kelurahan: list.user.ktp_kelurahan || "",
        alamat_ktp: list.user.alamat_ktp || "",
        dom_provinsi: list.user.dom_provinsi || "",
        dom_kabupaten: list.user.dom_kabupaten || "",
        dom_kecamatan: list.user.dom_kecamatan || "",
        dom_kelurahan: list.user.dom_kelurahan || "",
        alamat_dom: list.user.alamat_dom || "",
        cek_dom: list.user.alamat_dom ? false : true,
        fb: list.user.fb || "",
        ig: list.user.ig || "",
        tt: list.user.tt || "",
        riwayat_penyakit: list.user.riwayat_penyakit || "",
        riwayat_penyakit_keluarga: list.user.riwayat_penyakit_keluarga || "",
        riwayat_operasi: list.user.riwayat_operasi || "",
        riwayat_penggunaan_obat: list.user.riwayat_penggunaan_obat || "",
        sd: list.user.sd || "",
        th_sd: list.user.th_sd || "",
        filename_sd: list.user.filename_sd || "",
        smp: list.user.smp || "",
        th_smp: list.user.th_smp || "",
        filename_smp: list.user.filename_smp || "",
        sma: list.user.sma || "",
        th_sma: list.user.th_sma || "",
        filename_sma: list.user.filename_sma || "",
        d2: list.user.d2 || "",
        th_d2: list.user.th_d2 || "",
        filename_d2: list.user.filename_d2 || "",
        d3: list.user.d3 || "",
        th_d3: list.user.th_d3 || "",
        filename_d3: list.user.filename_d3 || "",
        d4: list.user.d4 || "",
        th_d4: list.user.th_d4 || "",
        filename_d4: list.user.filename_d4 || "",
        s1: list.user.s1 || "",
        th_s1: list.user.th_s1 || "",
        filename_s1: list.user.filename_s1 || "",
        s1_profesi: list.user.s1_profesi || "",
        th_s1_profesi: list.user.th_s1_profesi || "",
        filename_s1_profesi: list.user.filename_s1_profesi || "",
        s2: list.user.s2 || "",
        th_s2: list.user.th_s2 || "",
        filename_s2: list.user.filename_s2 || "",
        s3: list.user.s3 || "",
        th_s3: list.user.th_s3 || "",
        filename_s3: list.user.filename_s3 || "",
    });

    const pendidikanList = [
        { key: "sd", label: "Sekolah Dasar (SD) atau sederajat" },
        { key: "smp", label: "SMP/SLTP atau sederajat" },
        { key: "sma", label: "SMA/SMK atau sederajat" },
        { key: "d2", label: "Diploma 2" },
        { key: "d3", label: "Diploma 3" },
        { key: "d4", label: "Diploma 4" },
        { key: "s1", label: "Strata 1" },
        { key: "s1_profesi", label: "Strata 1 (Khusus Profesi)" },
        { key: "s2", label: "Strata 2" },
        { key: "s3", label: "Strata 3" },
    ];

    const handleCheckbox = (e) => {
        setData("cek_dom", e.target.checked);
    };

    const handleChange = (name, value) => {
        setData((prev) => ({ ...prev, [name]: value }));
    };

    const handleFileChange = (e, field) => {
        const file = e.target.files[0];
        if (file) {
            handleChange(field, file);
        }
    };

    // --- STATE ALAMAT KTP ---
    const [listKota, setListKota] = useState(list.kota || []);
    const [listKecamatan, setListKecamatan] = useState([]);
    const [listKelurahan, setListKelurahan] = useState([]);

    // --- STATE ALAMAT DOMISILI ---
    const [listDomKota, setListDomKota] = useState([]);
    const [listDomKecamatan, setListDomKecamatan] = useState([]);
    const [listDomKelurahan, setListDomKelurahan] = useState([]);

    // ====================
    // PREFILL DATA SAAT MOUNT
    // ====================
    useEffect(() => {
        // Prefill KTP
        if (data.ktp_provinsi && listKota.length === 0) {
            axios.get(`/api/provinsi/${data.ktp_provinsi}`).then((res) => {
                setListKota(res.data);
            });
        }

        if (data.ktp_kabupaten && listKecamatan.length === 0) {
            axios.get(`/api/kota/${data.ktp_kabupaten}`).then((res) => {
                setListKecamatan(res.data);
            });
        }

        if (data.ktp_kecamatan && listKelurahan.length === 0) {
            axios.get(`/api/kecamatan/${data.ktp_kecamatan}`).then((res) => {
                setListKelurahan(res.data);
            });
        }

        // Prefill DOMISILI
        if (data.dom_provinsi && listDomKota.length === 0) {
            axios.get(`/api/provinsi/${data.dom_provinsi}`).then((res) => {
                setListDomKota(res.data);
            });
        }

        if (data.dom_kabupaten && listDomKecamatan.length === 0) {
            axios.get(`/api/kota/${data.dom_kabupaten}`).then((res) => {
                setListDomKecamatan(res.data);
            });
        }

        if (data.dom_kecamatan && listDomKelurahan.length === 0) {
            axios.get(`/api/kecamatan/${data.dom_kecamatan}`).then((res) => {
                setListDomKelurahan(res.data);
            });
        }
    }, []);

    // ====================
    // REAKTIF SAAT ADA PERUBAHAN
    // ====================
    // ===================== ALAMAT KTP ===================== //
    useEffect(() => {
        if (data.ktp_provinsi) {
            axios.get(`/api/provinsi/${data.ktp_provinsi}`).then((res) => {
                setListKota(res.data);
                // hanya reset jika belum ada kabupaten terpilih
                if (!data.ktp_kabupaten) {
                    setData("ktp_kabupaten", "");
                    setListKecamatan([]);
                    setListKelurahan([]);
                }
            });
        } else {
            setListKota([]);
            setListKecamatan([]);
            setListKelurahan([]);
        }
    }, [data.ktp_provinsi]);

    useEffect(() => {
        if (data.ktp_kabupaten) {
            axios.get(`/api/kota/${data.ktp_kabupaten}`).then((res) => {
                setListKecamatan(res.data);
                if (!data.ktp_kecamatan) {
                    setData("ktp_kecamatan", "");
                    setListKelurahan([]);
                }
            });
        } else {
            setListKecamatan([]);
            setListKelurahan([]);
        }
    }, [data.ktp_kabupaten]);

    useEffect(() => {
        if (data.ktp_kecamatan) {
            axios.get(`/api/kecamatan/${data.ktp_kecamatan}`).then((res) => {
                setListKelurahan(res.data);
                if (!data.ktp_kelurahan) {
                    setData("ktp_kelurahan", "");
                }
            });
        } else {
            setListKelurahan([]);
        }
    }, [data.ktp_kecamatan]);

    // ===================== ALAMAT DOMISILI ===================== //
    useEffect(() => {
        if (data.dom_provinsi) {
            axios.get(`/api/provinsi/${data.dom_provinsi}`).then((res) => {
                setListDomKota(res.data);
                if (!data.dom_kabupaten) {
                    setData("dom_kabupaten", "");
                    setListDomKecamatan([]);
                    setListDomKelurahan([]);
                }
            });
        } else {
            setListDomKota([]);
            setListDomKecamatan([]);
            setListDomKelurahan([]);
        }
    }, [data.dom_provinsi]);

    useEffect(() => {
        if (data.dom_kabupaten) {
            axios.get(`/api/kota/${data.dom_kabupaten}`).then((res) => {
                setListDomKecamatan(res.data);
                if (!data.dom_kecamatan) {
                    setData("dom_kecamatan", "");
                    setListDomKelurahan([]);
                }
            });
        } else {
            setListDomKecamatan([]);
            setListDomKelurahan([]);
        }
    }, [data.dom_kabupaten]);

    useEffect(() => {
        if (data.dom_kecamatan) {
            axios.get(`/api/kecamatan/${data.dom_kecamatan}`).then((res) => {
                setListDomKelurahan(res.data);
                if (!data.dom_kelurahan) {
                    setData("dom_kelurahan", "");
                }
            });
        } else {
            setListDomKelurahan([]);
        }
    }, [data.dom_kecamatan]);

    // Reset field domisili saat checkbox dicentang
    useEffect(() => {
        if (data.cek_dom) {
            setData((prev) => ({
                ...prev,
                dom_provinsi: "",
                dom_kabupaten: "",
                dom_kecamatan: "",
                dom_kelurahan: "",
                alamat_dom: "",
            }));
        }
    }, [data.cek_dom]);

    const handleSubmit = (e) => {
        e.preventDefault();

        const formData = new FormData();
        Object.keys(data).forEach((key) => {
            formData.append(key, data[key]);
        });

        // 🟢 Ambil semua input file dari form
        const uploadFields = [
            "sd",
            "smp",
            "sma",
            "d2",
            "d3",
            "d4",
            "s1",
            "s1_profesi",
            "s2",
            "s3",
        ];

        uploadFields.forEach((field) => {
            const fileInput = document.querySelector(`#upload_${field}`);
            if (fileInput && fileInput.files[0]) {
                formData.append(`upload_${field}`, fileInput.files[0]);
            }
        });

        router.post("/v4/profil/store", formData, {
            forceFormData: true, // 🟢 penting biar dikirim sebagai multipart/form-data
            preserveScroll: true,

            onStart: () => {
                Swal.fire({
                    title: "Menyimpan...",
                    text: "Data profil sedang diproses",
                    allowOutsideClick: false,
                    didOpen: () => Swal.showLoading(),
                });
            },

            onSuccess: () => {
                Swal.fire({
                    icon: "success",
                    title: "Berhasil!",
                    text: "Profil berhasil diperbarui 🎉",
                    timer: 2000,
                    showConfirmButton: false,
                });
            },

            onError: (errors) => {
                let pesan = "Terjadi kesalahan saat menyimpan data profil.";
                if (errors && typeof errors === "object") {
                    pesan = Object.values(errors).join("\n");
                }
                Swal.fire({
                    icon: "error",
                    title: "Gagal!",
                    text: pesan,
                });
            },
        });
    };

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
                            <div
                                className="tab-pane p-0 border-0"
                                id="gallery-tab-pane"
                                role="tabpanel"
                                aria-labelledby="gallery-tab"
                                tabIndex="0"
                            >
                                <div className="card custom-card">
                                    <div className="card-header fw-bold justify-content-between">
                                        <div>
                                            Ubah{" "}
                                            <b className="text-primary">
                                                Profil Saya
                                            </b>
                                        </div>
                                        <div>
                                            (
                                            <span className="text-danger">
                                                *
                                            </span>
                                            ) Wajib Diisi
                                        </div>
                                    </div>
                                    <div className="card-body">
                                        <form
                                            onSubmit={handleSubmit}
                                            className=""
                                        >
                                            <div className="row">
                                                <div className="col-xl-12">
                                                    <div className="row">
                                                        <div className="col-xl-4 mb-3">
                                                            <label className="form-label fw-bold">
                                                                Pengalaman Kerja
                                                            </label>
                                                            <textarea
                                                                id="pengalaman_kerja"
                                                                name="pengalaman_kerja"
                                                                rows="5"
                                                                className="form-control"
                                                                placeholder="e.g. Saya pernah bekerja pada suatu instansi swasta ternama bertempat di Kota X dan berprofesi sebagai X..."
                                                                value={
                                                                    data.pengalaman_kerja ||
                                                                    ""
                                                                }
                                                                onChange={(e) =>
                                                                    setData(
                                                                        "pengalaman_kerja",
                                                                        e.target
                                                                            .value
                                                                    )
                                                                }
                                                            ></textarea>
                                                            {errors.pengalaman_kerja && (
                                                                <div className="text-danger mt-1 small">
                                                                    {
                                                                        errors.pengalaman_kerja
                                                                    }
                                                                </div>
                                                            )}
                                                        </div>
                                                        <div className="col-xl-8">
                                                            <label
                                                                htmlFor="pengalaman_kerja"
                                                                className="form-label fw-bold"
                                                            >
                                                                Data Sensitif
                                                            </label>
                                                            <div className="card custom-card">
                                                                <div className="card-body">
                                                                    <div className="row">
                                                                        <div className="col-sm-3 mb-3">
                                                                            <label className="block font-medium mb-1">
                                                                                Nomor
                                                                                Induk
                                                                                Pegawai
                                                                                (NIP)
                                                                            </label>
                                                                            <input
                                                                                type="text"
                                                                                name="nip"
                                                                                value={
                                                                                    data.nip
                                                                                }
                                                                                readOnly
                                                                                className="w-full form-control p-2 bg-light"
                                                                                placeholder="(otomatis terisi)"
                                                                            />
                                                                        </div>
                                                                        <div className="col-sm-5 mb-3">
                                                                            <label className="block font-medium mb-1">
                                                                                Nomor
                                                                                Induk
                                                                                Kependudukan
                                                                                (NIK){" "}
                                                                                <span className="text-danger">
                                                                                    *
                                                                                </span>
                                                                            </label>
                                                                            <input
                                                                                type="text"
                                                                                name="nik"
                                                                                value={
                                                                                    data.nik
                                                                                }
                                                                                onChange={(
                                                                                    e
                                                                                ) =>
                                                                                    setData(
                                                                                        "nik",
                                                                                        e
                                                                                            .target
                                                                                            .value
                                                                                    )
                                                                                }
                                                                                className="w-full form-control p-2"
                                                                            />
                                                                        </div>

                                                                        <div className="col-sm-4 mb-3">
                                                                            <label className="block font-medium mb-1">
                                                                                Email
                                                                                Aktif{" "}
                                                                                <span className="text-danger">
                                                                                    *
                                                                                </span>
                                                                            </label>
                                                                            <input
                                                                                type="email"
                                                                                name="email"
                                                                                value={
                                                                                    data.email
                                                                                }
                                                                                onChange={(
                                                                                    e
                                                                                ) =>
                                                                                    setData(
                                                                                        "email",
                                                                                        e
                                                                                            .target
                                                                                            .value
                                                                                    )
                                                                                }
                                                                                className="w-full form-control p-2"
                                                                            />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div className="col-xl-7">
                                                    <label
                                                        htmlFor="pengalaman_kerja"
                                                        className="form-label fw-bold"
                                                    >
                                                        Data Identitas
                                                    </label>
                                                    <div className="card custom-card">
                                                        <div className="card-body">
                                                            <div className="row">
                                                                {/* --- Biodata --- */}
                                                                <div className="col-md-3 mb-3">
                                                                    <label className="block font-medium mb-1">
                                                                        Gelar
                                                                        Depan{" "}
                                                                        <span className="text-danger">
                                                                            *
                                                                        </span>
                                                                    </label>
                                                                    <input
                                                                        type="text"
                                                                        name="gelar_depan"
                                                                        value={
                                                                            data.gelar_depan
                                                                        }
                                                                        onChange={(
                                                                            e
                                                                        ) =>
                                                                            setData(
                                                                                "gelar_depan",
                                                                                e
                                                                                    .target
                                                                                    .value
                                                                            )
                                                                        }
                                                                        className="w-full form-control p-2"
                                                                        placeholder="dr."
                                                                    />
                                                                </div>
                                                                <div className="col-md-6 mb-3">
                                                                    <label className="block font-medium mb-1">
                                                                        Nama
                                                                        Lengkap
                                                                        (Tanpa
                                                                        Gelar){" "}
                                                                        <span className="text-danger">
                                                                            *
                                                                        </span>
                                                                    </label>
                                                                    <input
                                                                        type="text"
                                                                        name="nama"
                                                                        value={
                                                                            data.nama
                                                                        }
                                                                        onChange={(
                                                                            e
                                                                        ) =>
                                                                            setData(
                                                                                "nama",
                                                                                e
                                                                                    .target
                                                                                    .value
                                                                            )
                                                                        }
                                                                        className="w-full form-control p-2"
                                                                        placeholder="Mayor Sunaryo Tiga Tujuh"
                                                                    />
                                                                </div>
                                                                <div className="col-md-3 mb-3">
                                                                    <label className="block font-medium mb-1">
                                                                        Gelar
                                                                        Belakang{" "}
                                                                        <span className="text-danger">
                                                                            *
                                                                        </span>
                                                                    </label>
                                                                    <input
                                                                        type="text"
                                                                        name="gelar_belakang"
                                                                        value={
                                                                            data.gelar_belakang
                                                                        }
                                                                        onChange={(
                                                                            e
                                                                        ) =>
                                                                            setData(
                                                                                "gelar_belakang",
                                                                                e
                                                                                    .target
                                                                                    .value
                                                                            )
                                                                        }
                                                                        className="w-full form-control p-2"
                                                                        placeholder="Sp.x.FinaCS"
                                                                    />
                                                                </div>

                                                                <div className="col-sm-5 mb-3">
                                                                    <label className="block font-medium mb-1">
                                                                        Nama
                                                                        Panggilan{" "}
                                                                        <span className="text-danger">
                                                                            *
                                                                        </span>
                                                                    </label>
                                                                    <input
                                                                        type="text"
                                                                        name="nick"
                                                                        value={
                                                                            data.nick
                                                                        }
                                                                        onChange={(
                                                                            e
                                                                        ) =>
                                                                            setData(
                                                                                "nick",
                                                                                e
                                                                                    .target
                                                                                    .value
                                                                            )
                                                                        }
                                                                        className="w-full form-control p-2"
                                                                    />
                                                                </div>

                                                                <div className="col-md-4 mb-3">
                                                                    <label className="block font-medium mb-1">
                                                                        No. HP{" "}
                                                                        <span className="text-danger">
                                                                            *
                                                                        </span>
                                                                    </label>
                                                                    <input
                                                                        type="text"
                                                                        name="no_hp"
                                                                        value={
                                                                            data.no_hp
                                                                        }
                                                                        onChange={(
                                                                            e
                                                                        ) =>
                                                                            setData(
                                                                                "no_hp",
                                                                                e
                                                                                    .target
                                                                                    .value
                                                                            )
                                                                        }
                                                                        className="w-full form-control p-2"
                                                                        placeholder="628xxx"
                                                                    />
                                                                </div>

                                                                <div className="col-md-3 mb-3">
                                                                    <label className="block font-medium mb-1">
                                                                        Jenis
                                                                        Kelamin{" "}
                                                                        <span className="text-danger">
                                                                            *
                                                                        </span>
                                                                    </label>
                                                                    <select
                                                                        name="jns_kelamin"
                                                                        value={
                                                                            data.jns_kelamin
                                                                        }
                                                                        onChange={(
                                                                            e
                                                                        ) =>
                                                                            setData(
                                                                                "jns_kelamin",
                                                                                e
                                                                                    .target
                                                                                    .value
                                                                            )
                                                                        }
                                                                        className="w-full form-control p-2"
                                                                    >
                                                                        <option value="">
                                                                            --
                                                                            Pilih
                                                                            --
                                                                        </option>
                                                                        <option value="LAKI-LAKI">
                                                                            Laki-laki
                                                                        </option>
                                                                        <option value="PEREMPUAN">
                                                                            Perempuan
                                                                        </option>
                                                                    </select>
                                                                </div>

                                                                <div className="col-md-5 mb-3">
                                                                    <label className="block font-medium mb-1">
                                                                        Tempat
                                                                        Lahir{" "}
                                                                        <span className="text-danger">
                                                                            *
                                                                        </span>
                                                                    </label>
                                                                    <select
                                                                        id="temp_lahir"
                                                                        name="temp_lahir"
                                                                        className="form-control"
                                                                        value={
                                                                            data.temp_lahir
                                                                        }
                                                                        required
                                                                        onChange={(
                                                                            e
                                                                        ) =>
                                                                            setData(
                                                                                "temp_lahir",
                                                                                e
                                                                                    .target
                                                                                    .value
                                                                            )
                                                                        }
                                                                    >
                                                                        <option value="">
                                                                            --
                                                                            Pilih
                                                                            Kota
                                                                            --
                                                                        </option>
                                                                        {list.kota?.map(
                                                                            (
                                                                                item,
                                                                                index
                                                                            ) => (
                                                                                <option
                                                                                    key={
                                                                                        index
                                                                                    }
                                                                                    value={
                                                                                        item.nama_kabkota
                                                                                    }
                                                                                >
                                                                                    {
                                                                                        item.nama_kabkota
                                                                                    }
                                                                                </option>
                                                                            )
                                                                        )}
                                                                    </select>
                                                                </div>

                                                                <div className="col-md-3 mb-3">
                                                                    <label className="block font-medium mb-1">
                                                                        Tanggal
                                                                        Lahir{" "}
                                                                        <span className="text-danger">
                                                                            *
                                                                        </span>
                                                                    </label>
                                                                    <input
                                                                        type="date"
                                                                        name="tgl_lahir"
                                                                        value={
                                                                            data.tgl_lahir
                                                                        }
                                                                        onChange={(
                                                                            e
                                                                        ) =>
                                                                            setData(
                                                                                "tgl_lahir",
                                                                                e
                                                                                    .target
                                                                                    .value
                                                                            )
                                                                        }
                                                                        className="w-full form-control p-2"
                                                                    />
                                                                </div>

                                                                <div className="col-md-4 mb-3">
                                                                    <label className="block font-medium mb-1">
                                                                        Status
                                                                        Perkawinan{" "}
                                                                        <span className="text-danger">
                                                                            *
                                                                        </span>
                                                                    </label>
                                                                    <select
                                                                        name="status_kawin"
                                                                        value={
                                                                            data.status_kawin
                                                                        }
                                                                        onChange={(
                                                                            e
                                                                        ) =>
                                                                            setData(
                                                                                "status_kawin",
                                                                                e
                                                                                    .target
                                                                                    .value
                                                                            )
                                                                        }
                                                                        className="w-full form-control p-2"
                                                                    >
                                                                        <option value="">
                                                                            --
                                                                            Pilih
                                                                            --
                                                                        </option>
                                                                        <option value="BELUM">
                                                                            Belum
                                                                            Kawin
                                                                        </option>
                                                                        <option value="SUDAH">
                                                                            Sudah
                                                                            Kawin
                                                                        </option>
                                                                        <option value="CERAI">
                                                                            Cerai
                                                                        </option>
                                                                        <option value="RAHASIA">
                                                                            Tidak
                                                                            ingin
                                                                            memberi
                                                                            tahu
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <label className="form-label fw-bold">
                                                        Alamat KTP
                                                    </label>
                                                    <div className="card custom-card">
                                                        <div className="card-body">
                                                            <div className="alert alert-light">
                                                                <div className="form-check">
                                                                    <input
                                                                        className="form-check-input"
                                                                        type="checkbox"
                                                                        id="checkbox_alamat"
                                                                        name="cek_dom"
                                                                        checked={
                                                                            data.cek_dom
                                                                        }
                                                                        onChange={
                                                                            handleCheckbox
                                                                        }
                                                                    />
                                                                    <label
                                                                        className="form-check-label"
                                                                        htmlFor="checkbox_alamat"
                                                                    >
                                                                        <u>
                                                                            <b>
                                                                                Alamat
                                                                                Domisili
                                                                                sama
                                                                                dengan
                                                                                KTP
                                                                            </b>
                                                                        </u>
                                                                    </label>
                                                                </div>
                                                                <small>
                                                                    Hilangkan
                                                                    centang
                                                                    untuk
                                                                    menampilkan
                                                                    Pilihan
                                                                    Domisili
                                                                </small>
                                                            </div>

                                                            <div className="row">
                                                                {/* PROVINSI */}
                                                                <div className="col-md-6 mb-3">
                                                                    <label className="block mb-1">
                                                                        Provinsi{" "}
                                                                        <span className="text-danger">
                                                                            *
                                                                        </span>
                                                                    </label>
                                                                    <select
                                                                        name="ktp_provinsi"
                                                                        value={
                                                                            data.ktp_provinsi ||
                                                                            ""
                                                                        }
                                                                        onChange={(
                                                                            e
                                                                        ) =>
                                                                            setData(
                                                                                "ktp_provinsi",
                                                                                e
                                                                                    .target
                                                                                    .value
                                                                            )
                                                                        }
                                                                        required
                                                                        className="w-full form-control p-2"
                                                                    >
                                                                        <option value="">
                                                                            --
                                                                            Pilih
                                                                            Provinsi
                                                                            --
                                                                        </option>
                                                                        {list.provinsi.map(
                                                                            (
                                                                                p,
                                                                                i
                                                                            ) => (
                                                                                <option
                                                                                    key={
                                                                                        i
                                                                                    }
                                                                                    value={
                                                                                        p.provinsi
                                                                                    }
                                                                                >
                                                                                    {
                                                                                        p.provinsi
                                                                                    }
                                                                                </option>
                                                                            )
                                                                        )}
                                                                    </select>
                                                                </div>

                                                                {/* KABUPATEN */}
                                                                <div className="col-md-6 mb-3">
                                                                    <label className="block mb-1">
                                                                        Kabupaten
                                                                        / Kota{" "}
                                                                        <span className="text-danger">
                                                                            *
                                                                        </span>
                                                                    </label>
                                                                    <select
                                                                        name="ktp_kabupaten"
                                                                        value={
                                                                            data.ktp_kabupaten ||
                                                                            ""
                                                                        }
                                                                        onChange={(
                                                                            e
                                                                        ) =>
                                                                            setData(
                                                                                "ktp_kabupaten",
                                                                                e
                                                                                    .target
                                                                                    .value
                                                                            )
                                                                        }
                                                                        required={
                                                                            !!data.ktp_provinsi
                                                                        }
                                                                        disabled={
                                                                            !data.ktp_provinsi
                                                                        }
                                                                        className="w-full form-control p-2"
                                                                    >
                                                                        <option value="">
                                                                            --
                                                                            Pilih
                                                                            Kabupaten
                                                                            --
                                                                        </option>
                                                                        {listKota.map(
                                                                            (
                                                                                k,
                                                                                i
                                                                            ) => (
                                                                                <option
                                                                                    key={
                                                                                        i
                                                                                    }
                                                                                    value={
                                                                                        k.nama_kabkota
                                                                                    }
                                                                                >
                                                                                    {
                                                                                        k.nama_kabkota
                                                                                    }
                                                                                </option>
                                                                            )
                                                                        )}
                                                                    </select>
                                                                </div>

                                                                {/* KECAMATAN */}
                                                                <div className="col-md-6 mb-3">
                                                                    <label className="block mb-1">
                                                                        Kecamatan{" "}
                                                                        <span className="text-danger">
                                                                            *
                                                                        </span>
                                                                    </label>
                                                                    <select
                                                                        name="ktp_kecamatan"
                                                                        value={
                                                                            data.ktp_kecamatan ||
                                                                            ""
                                                                        }
                                                                        onChange={(
                                                                            e
                                                                        ) =>
                                                                            setData(
                                                                                "ktp_kecamatan",
                                                                                e
                                                                                    .target
                                                                                    .value
                                                                            )
                                                                        }
                                                                        required={
                                                                            !!data.ktp_kabupaten
                                                                        }
                                                                        disabled={
                                                                            !data.ktp_kabupaten
                                                                        }
                                                                        className="w-full form-control p-2"
                                                                    >
                                                                        <option value="">
                                                                            --
                                                                            Pilih
                                                                            Kecamatan
                                                                            --
                                                                        </option>
                                                                        {listKecamatan.map(
                                                                            (
                                                                                c,
                                                                                i
                                                                            ) => (
                                                                                <option
                                                                                    key={
                                                                                        i
                                                                                    }
                                                                                    value={
                                                                                        c.kecamatan
                                                                                    }
                                                                                >
                                                                                    {
                                                                                        c.kecamatan
                                                                                    }
                                                                                </option>
                                                                            )
                                                                        )}
                                                                    </select>
                                                                </div>

                                                                {/* KELURAHAN */}
                                                                <div className="col-md-6 mb-3">
                                                                    <label className="block mb-1">
                                                                        Kelurahan
                                                                        / Desa{" "}
                                                                        <span className="text-danger">
                                                                            *
                                                                        </span>
                                                                    </label>
                                                                    <select
                                                                        name="ktp_kelurahan"
                                                                        value={
                                                                            data.ktp_kelurahan ||
                                                                            ""
                                                                        }
                                                                        onChange={(
                                                                            e
                                                                        ) =>
                                                                            setData(
                                                                                "ktp_kelurahan",
                                                                                e
                                                                                    .target
                                                                                    .value
                                                                            )
                                                                        }
                                                                        required={
                                                                            !!data.ktp_kecamatan
                                                                        }
                                                                        disabled={
                                                                            !data.ktp_kecamatan
                                                                        }
                                                                        className="w-full form-control p-2"
                                                                    >
                                                                        <option value="">
                                                                            --
                                                                            Pilih
                                                                            Kelurahan
                                                                            --
                                                                        </option>
                                                                        {listKelurahan.map(
                                                                            (
                                                                                d,
                                                                                i
                                                                            ) => (
                                                                                <option
                                                                                    key={
                                                                                        i
                                                                                    }
                                                                                    value={
                                                                                        d.desa
                                                                                    }
                                                                                >
                                                                                    {
                                                                                        d.desa
                                                                                    }
                                                                                </option>
                                                                            )
                                                                        )}
                                                                    </select>
                                                                </div>

                                                                {/* ALAMAT LENGKAP */}
                                                                <div className="col-md-12">
                                                                    <label className="block mb-1">
                                                                        Alamat
                                                                        Lengkap
                                                                        (KTP){" "}
                                                                        <span className="text-danger">
                                                                            *
                                                                        </span>
                                                                    </label>
                                                                    <textarea
                                                                        name="alamat_ktp"
                                                                        rows="2"
                                                                        value={
                                                                            data.alamat_ktp ||
                                                                            ""
                                                                        }
                                                                        onChange={(
                                                                            e
                                                                        ) =>
                                                                            setData(
                                                                                "alamat_ktp",
                                                                                e
                                                                                    .target
                                                                                    .value
                                                                            )
                                                                        }
                                                                        required={
                                                                            !!data.ktp_kelurahan
                                                                        }
                                                                        disabled={
                                                                            !data.ktp_kelurahan
                                                                        }
                                                                        className="w-full form-control p-2"
                                                                    ></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    {/* === ALAMAT DOMISILI === */}
                                                    {!data.cek_dom && (
                                                        <>
                                                            <label className="form-label fw-bold">
                                                                Alamat Domisili
                                                            </label>
                                                            <div className="card custom-card mt-2">
                                                                <div className="card-body">
                                                                    <div className="row">
                                                                        <div className="col-sm-6 mb-3">
                                                                            <label className="form-label">
                                                                                Provinsi
                                                                            </label>
                                                                            <select
                                                                                name="dom_provinsi"
                                                                                className="form-control"
                                                                                value={
                                                                                    data.dom_provinsi ||
                                                                                    ""
                                                                                }
                                                                                onChange={(
                                                                                    e
                                                                                ) =>
                                                                                    setData(
                                                                                        "dom_provinsi",
                                                                                        e
                                                                                            .target
                                                                                            .value
                                                                                    )
                                                                                }
                                                                                required={
                                                                                    !data.cek_dom
                                                                                }
                                                                            >
                                                                                <option value="">
                                                                                    Pilih
                                                                                    Provinsi
                                                                                </option>
                                                                                {list.provinsi.map(
                                                                                    (
                                                                                        item
                                                                                    ) => (
                                                                                        <option
                                                                                            key={
                                                                                                item.provinsi
                                                                                            }
                                                                                            value={
                                                                                                item.provinsi
                                                                                            }
                                                                                        >
                                                                                            {
                                                                                                item.provinsi
                                                                                            }
                                                                                        </option>
                                                                                    )
                                                                                )}
                                                                            </select>
                                                                        </div>

                                                                        <div className="col-sm-6 mb-3">
                                                                            <label className="form-label">
                                                                                Kabupaten
                                                                            </label>
                                                                            <select
                                                                                name="dom_kabupaten"
                                                                                className="form-control"
                                                                                value={
                                                                                    data.dom_kabupaten ||
                                                                                    ""
                                                                                }
                                                                                onChange={(
                                                                                    e
                                                                                ) =>
                                                                                    setData(
                                                                                        "dom_kabupaten",
                                                                                        e
                                                                                            .target
                                                                                            .value
                                                                                    )
                                                                                }
                                                                                required={
                                                                                    !data.cek_dom &&
                                                                                    !!data.dom_provinsi
                                                                                }
                                                                                disabled={
                                                                                    !data.dom_provinsi
                                                                                }
                                                                            >
                                                                                <option value="">
                                                                                    Pilih
                                                                                    Kabupaten
                                                                                </option>
                                                                                {(
                                                                                    listDomKota ||
                                                                                    []
                                                                                ).map(
                                                                                    (
                                                                                        item,
                                                                                        i
                                                                                    ) => (
                                                                                        <option
                                                                                            key={
                                                                                                i
                                                                                            }
                                                                                            value={
                                                                                                item.nama_kabkota
                                                                                            }
                                                                                        >
                                                                                            {
                                                                                                item.nama_kabkota
                                                                                            }
                                                                                        </option>
                                                                                    )
                                                                                )}
                                                                            </select>
                                                                        </div>

                                                                        <div className="col-sm-6 mb-3">
                                                                            <label className="form-label">
                                                                                Kecamatan
                                                                            </label>
                                                                            <select
                                                                                name="dom_kecamatan"
                                                                                className="form-control"
                                                                                value={
                                                                                    data.dom_kecamatan ||
                                                                                    ""
                                                                                }
                                                                                onChange={(
                                                                                    e
                                                                                ) =>
                                                                                    setData(
                                                                                        "dom_kecamatan",
                                                                                        e
                                                                                            .target
                                                                                            .value
                                                                                    )
                                                                                }
                                                                                required={
                                                                                    !data.cek_dom &&
                                                                                    !!data.dom_kabupaten
                                                                                }
                                                                                disabled={
                                                                                    !data.dom_kabupaten
                                                                                }
                                                                            >
                                                                                <option value="">
                                                                                    Pilih
                                                                                    Kecamatan
                                                                                </option>
                                                                                {(
                                                                                    listDomKecamatan ||
                                                                                    []
                                                                                ).map(
                                                                                    (
                                                                                        item
                                                                                    ) => (
                                                                                        <option
                                                                                            key={
                                                                                                item.kecamatan
                                                                                            }
                                                                                            value={
                                                                                                item.kecamatan
                                                                                            }
                                                                                        >
                                                                                            {
                                                                                                item.kecamatan
                                                                                            }
                                                                                        </option>
                                                                                    )
                                                                                )}
                                                                            </select>
                                                                        </div>

                                                                        <div className="col-sm-6 mb-3">
                                                                            <label className="form-label">
                                                                                Kelurahan
                                                                            </label>
                                                                            <select
                                                                                name="dom_kelurahan"
                                                                                className="form-control"
                                                                                value={
                                                                                    data.dom_kelurahan ||
                                                                                    ""
                                                                                }
                                                                                onChange={(
                                                                                    e
                                                                                ) =>
                                                                                    setData(
                                                                                        "dom_kelurahan",
                                                                                        e
                                                                                            .target
                                                                                            .value
                                                                                    )
                                                                                }
                                                                                required={
                                                                                    !data.cek_dom &&
                                                                                    !!data.dom_kecamatan
                                                                                }
                                                                                disabled={
                                                                                    !data.dom_kecamatan
                                                                                }
                                                                            >
                                                                                <option value="">
                                                                                    Pilih
                                                                                    Kelurahan
                                                                                </option>
                                                                                {(
                                                                                    listDomKelurahan ||
                                                                                    []
                                                                                ).map(
                                                                                    (
                                                                                        item
                                                                                    ) => (
                                                                                        <option
                                                                                            key={
                                                                                                item.desa
                                                                                            }
                                                                                            value={
                                                                                                item.desa
                                                                                            }
                                                                                        >
                                                                                            {
                                                                                                item.desa
                                                                                            }
                                                                                        </option>
                                                                                    )
                                                                                )}
                                                                            </select>
                                                                        </div>

                                                                        <div className="col-sm-12">
                                                                            <label className="form-label">
                                                                                Alamat
                                                                                Lengkap
                                                                            </label>
                                                                            <textarea
                                                                                className="form-control"
                                                                                name="alamat_dom"
                                                                                rows="4"
                                                                                placeholder="Tuliskan alamat lengkap domisili Anda"
                                                                                value={
                                                                                    data.alamat_dom ||
                                                                                    ""
                                                                                }
                                                                                onChange={(
                                                                                    e
                                                                                ) =>
                                                                                    setData(
                                                                                        "alamat_dom",
                                                                                        e
                                                                                            .target
                                                                                            .value
                                                                                    )
                                                                                }
                                                                                required={
                                                                                    !data.cek_dom &&
                                                                                    !!data.dom_kelurahan
                                                                                }
                                                                                disabled={
                                                                                    data.cek_dom
                                                                                }
                                                                            ></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </>
                                                    )}

                                                    <label
                                                        htmlFor="pengalaman_kerja"
                                                        className="form-label fw-bold"
                                                    >
                                                        Data Media Sosial
                                                    </label>
                                                    <div className="card custom-card">
                                                        <div className="card-body">
                                                            <div className="row">
                                                                {/* --- Sosial Media --- */}
                                                                <div className="col-md-4 mb-3">
                                                                    <label className="block font-medium mb-1">
                                                                        <i className="ri-facebook-circle-fill fs-6 me-1"></i>{" "}
                                                                        Facebook
                                                                    </label>
                                                                    <input
                                                                        type="text"
                                                                        name="fb"
                                                                        value={
                                                                            data.fb
                                                                        }
                                                                        onChange={(
                                                                            e
                                                                        ) =>
                                                                            setData(
                                                                                "fb",
                                                                                e
                                                                                    .target
                                                                                    .value
                                                                            )
                                                                        }
                                                                        placeholder="Facebook"
                                                                        className="form-control"
                                                                    />
                                                                </div>
                                                                <div className="col-md-4 mb-3">
                                                                    <label className="block font-medium mb-1">
                                                                        <i className="ri-instagram-fill fs-6 me-1"></i>{" "}
                                                                        Instagram
                                                                    </label>
                                                                    <input
                                                                        type="text"
                                                                        name="ig"
                                                                        value={
                                                                            data.ig
                                                                        }
                                                                        onChange={(
                                                                            e
                                                                        ) =>
                                                                            setData(
                                                                                "ig",
                                                                                e
                                                                                    .target
                                                                                    .value
                                                                            )
                                                                        }
                                                                        placeholder="Instagram"
                                                                        className="form-control"
                                                                    />
                                                                </div>
                                                                <div className="col-md-4">
                                                                    <label className="block font-medium mb-1">
                                                                        <i className="ri-tiktok-fill fs-6 me-1"></i>{" "}
                                                                        Tiktok
                                                                    </label>
                                                                    <input
                                                                        type="text"
                                                                        name="tt"
                                                                        value={
                                                                            data.tt
                                                                        }
                                                                        onChange={(
                                                                            e
                                                                        ) =>
                                                                            setData(
                                                                                "tt",
                                                                                e
                                                                                    .target
                                                                                    .value
                                                                            )
                                                                        }
                                                                        placeholder="Tiktok"
                                                                        className="form-control"
                                                                    />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div className="col-xl-5">
                                                    <label className="form-label fw-bold">
                                                        Data Pendidikan
                                                    </label>
                                                    <div className="card">
                                                        <div className="card-body">
                                                            <div className="alert alert-light mb-4">
                                                                <label className="form-label fw-bold">
                                                                    Keterangan
                                                                    Pengisian
                                                                </label>
                                                                <ul className="list-unstyled ms-2">
                                                                    <li>
                                                                        <i className="ti ti-arrow-narrow-right text-primary"></i>{" "}
                                                                        Kolom
                                                                        pertama
                                                                        adalah
                                                                        nama
                                                                        sekolah/universitas
                                                                    </li>
                                                                    <li>
                                                                        <i className="ti ti-arrow-narrow-right text-primary"></i>{" "}
                                                                        Kolom
                                                                        kedua
                                                                        adalah
                                                                        tahun
                                                                        lulus
                                                                        sesuai
                                                                        ijazah
                                                                    </li>
                                                                    <li>
                                                                        <i className="ti ti-arrow-narrow-right text-primary"></i>{" "}
                                                                        Kolom
                                                                        ketiga
                                                                        adalah
                                                                        upload
                                                                        dokumen
                                                                        Ijazah
                                                                        (PDF)
                                                                    </li>
                                                                    <li>
                                                                        <i className="ti ti-arrow-narrow-right text-primary"></i>{" "}
                                                                        Upload
                                                                        ulang
                                                                        dokumen
                                                                        untuk
                                                                        memperbarui
                                                                        ijazah
                                                                        baru
                                                                    </li>
                                                                </ul>
                                                            </div>

                                                            {pendidikanList.map(
                                                                (item) => {
                                                                    const nama =
                                                                        item.key;
                                                                    const tahun = `th_${nama}`;
                                                                    const fileKey = `filename_${nama}`;
                                                                    const namaSekolah =
                                                                        data[
                                                                            nama
                                                                        ]?.trim() ||
                                                                        "";

                                                                    return (
                                                                        <div
                                                                            className="mb-4 border-bottom pb-3"
                                                                            key={
                                                                                nama
                                                                            }
                                                                        >
                                                                            <label className="block font-medium mb-1">
                                                                                {
                                                                                    item.label
                                                                                }
                                                                            </label>

                                                                            {/* NAMA SEKOLAH + TAHUN LULUS */}
                                                                            <div className="input-group mb-2">
                                                                                <input
                                                                                    type="text"
                                                                                    name={
                                                                                        nama
                                                                                    }
                                                                                    value={
                                                                                        data[
                                                                                            nama
                                                                                        ] ||
                                                                                        ""
                                                                                    }
                                                                                    onChange={(
                                                                                        e
                                                                                    ) =>
                                                                                        handleChange(
                                                                                            nama,
                                                                                            e
                                                                                                .target
                                                                                                .value
                                                                                        )
                                                                                    }
                                                                                    placeholder="Nama Sekolah / Universitas"
                                                                                    className="form-control"
                                                                                    required={
                                                                                        !!data[
                                                                                            tahun
                                                                                        ]
                                                                                    } // jika tahun diisi, maka nama wajib juga
                                                                                />
                                                                                <input
                                                                                    type="number"
                                                                                    name={
                                                                                        tahun
                                                                                    }
                                                                                    value={
                                                                                        data[
                                                                                            tahun
                                                                                        ] ||
                                                                                        ""
                                                                                    }
                                                                                    onChange={(
                                                                                        e
                                                                                    ) =>
                                                                                        handleChange(
                                                                                            tahun,
                                                                                            e
                                                                                                .target
                                                                                                .value
                                                                                        )
                                                                                    }
                                                                                    placeholder="Tahun Lulus"
                                                                                    className="form-control"
                                                                                    disabled={
                                                                                        !namaSekolah
                                                                                    } // disable kalau nama kosong
                                                                                    required={
                                                                                        !!namaSekolah
                                                                                    } // wajib kalau nama sudah diisi
                                                                                />
                                                                            </div>

                                                                            {/* UPLOAD IJAZAH (opsional) */}
                                                                            <div className="input-group">
                                                                                <input
                                                                                    type="file"
                                                                                    accept="application/pdf"
                                                                                    id={`upload_${nama}`}
                                                                                    name={`upload_${nama}`}
                                                                                    onChange={(
                                                                                        e
                                                                                    ) =>
                                                                                        handleFileChange(
                                                                                            e,
                                                                                            fileKey
                                                                                        )
                                                                                    }
                                                                                    className="form-control"
                                                                                />
                                                                                <label
                                                                                    htmlFor={`upload_${nama}`}
                                                                                    className="btn btn-secondary-light"
                                                                                    title="Upload Ijazah"
                                                                                >
                                                                                    <i className="ri-upload-2-fill fs-6"></i>
                                                                                </label>

                                                                                {list
                                                                                    .user[
                                                                                    fileKey
                                                                                ] && (
                                                                                    <a
                                                                                        href={`/storage/${list.user[
                                                                                            fileKey
                                                                                        ].substring(
                                                                                            7
                                                                                        )}`}
                                                                                        target="_blank"
                                                                                        rel="noopener noreferrer"
                                                                                        className="btn btn-success-light"
                                                                                        title="Download Ijazah"
                                                                                    >
                                                                                        <i className="ri-download-2-fill fs-6"></i>
                                                                                    </a>
                                                                                )}
                                                                            </div>
                                                                        </div>
                                                                    );
                                                                }
                                                            )}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div className="col-xl-12">
                                                    {/* --- Tombol Simpan --- */}
                                                    <div className="d-flex justify-content-end">
                                                        <button
                                                            type="submit"
                                                            disabled={
                                                                processing
                                                            }
                                                            className={`btn btn-primary btn-loader ${
                                                                processing
                                                                    ? "opacity-75 cursor-not-allowed"
                                                                    : ""
                                                            }`}
                                                        >
                                                            {processing ? (
                                                                <>
                                                                    <span className="me-2">
                                                                        Menyimpan...
                                                                    </span>
                                                                    <span className="loading">
                                                                        <i className="ri-loader-2-fill fs-16 animate-spin"></i>
                                                                    </span>
                                                                </>
                                                            ) : (
                                                                <>
                                                                    <span className="me-2">
                                                                        Simpan
                                                                        Perubahan
                                                                    </span>
                                                                </>
                                                            )}
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
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
