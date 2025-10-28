import MainLayout from "@/Layouts/MainLayout";
import React, { useRef, useEffect, useState } from "react";
import { Head, router, usePage, useForm, Link } from "@inertiajs/react";
import { validateForm } from "@/Helpers/formValidation";
import { initDataTable, initTooltips, showLoading } from "@/Helpers/Helper";

export default function Profil() {
    // TAB UBAH PROFIL ------------------------------------------------------------------
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
    const fileInputRefFoto = useRef(null);
    useEffect(() => {
        const lightbox = GLightbox({
            selector: ".glightbox",
            touchNavigation: true,
            loop: true,
            zoomable: true,
            openEffect: "zoom",
            closeEffect: "fade",
        });

        return () => {
            lightbox.destroy(); // cleanup saat komponen unmount
        };
    }, []);

    // useEffect(() => {
    //     if (flash?.message) {
    //         Swal.fire({
    //             icon: "success",
    //             title: "Berhasil!",
    //             text: flash.message,
    //             timer: 2000,
    //             showConfirmButton: false,
    //         });
    //     }
    // }, [flash]);

    const { data, setData, post, processing, errors } = useForm({
        pengalaman_kerja: list.user.pengalaman_kerja || "",
        gelar_depan: list.user.gelar_depan || "",
        nama: list.user.nama || "",
        gelar_belakang: list.user.gelar_belakang || "",
        nip: list.user.nip || "",
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

    const handleChangeUbahPendidikan = (name, value) => {
        setData((prev) => ({ ...prev, [name]: value }));
    };

    const handleFileChange = (e, field) => {
        const file = e.target.files[0];
        if (file) {
            handleChangeUbahPendidikan(field, file);
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
            axios.get(`/api/v4/provinsi/${data.ktp_provinsi}`).then((res) => {
                setListKota(res.data);
            });
        }

        if (data.ktp_kabupaten && listKecamatan.length === 0) {
            axios.get(`/api/v4/kota/${data.ktp_kabupaten}`).then((res) => {
                setListKecamatan(res.data);
            });
        }

        if (data.ktp_kecamatan && listKelurahan.length === 0) {
            axios.get(`/api/v4/kecamatan/${data.ktp_kecamatan}`).then((res) => {
                setListKelurahan(res.data);
            });
        }

        // Prefill DOMISILI
        if (data.dom_provinsi && listDomKota.length === 0) {
            axios.get(`/api/v4/provinsi/${data.dom_provinsi}`).then((res) => {
                setListDomKota(res.data);
            });
        }

        if (data.dom_kabupaten && listDomKecamatan.length === 0) {
            axios.get(`/api/v4/kota/${data.dom_kabupaten}`).then((res) => {
                setListDomKecamatan(res.data);
            });
        }

        if (data.dom_kecamatan && listDomKelurahan.length === 0) {
            axios.get(`/api/kecamatan/${data.dom_kecamatan}`).then((res) => {
                setListDomKelurahan(res.data);
            });
        }
    }, []);

    // ALAMAT KTP
    useEffect(() => {
        if (data.ktp_provinsi) {
            axios.get(`/api/v4/provinsi/${data.ktp_provinsi}`).then((res) => {
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
            axios.get(`/api/v4/kota/${data.ktp_kabupaten}`).then((res) => {
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
            axios.get(`/api/v4/kecamatan/${data.ktp_kecamatan}`).then((res) => {
                setListKelurahan(res.data);
                if (!data.ktp_kelurahan) {
                    setData("ktp_kelurahan", "");
                }
            });
        } else {
            setListKelurahan([]);
        }
    }, [data.ktp_kecamatan]);

    // ALAMAT DOMISILI
    useEffect(() => {
        if (data.dom_provinsi) {
            axios.get(`/api/v4/provinsi/${data.dom_provinsi}`).then((res) => {
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
            axios.get(`/api/v4/kota/${data.dom_kabupaten}`).then((res) => {
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
            axios.get(`/api/v4/kecamatan/${data.dom_kecamatan}`).then((res) => {
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

    const handleSubmitUbahProfil = (e) => {
        e.preventDefault();
        const form = e.target;

        // 🔍 Jalankan validasi
        const valid = validateForm(form);
        if (!valid) {
            Swal.fire({
                icon: "error",
                title: "Validasi Gagal!",
                text: "Mohon lengkapi data yang belum sesuai.",
            });
            return;
        }

        const formData = new FormData();
        Object.keys(data).forEach((key) => {
            formData.append(key, data[key]);
        });

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
            forceFormData: true,
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

    // TAB UBAH PROFIL x FOTO PROFIL ------------------------------------------------------------------
    const handleChangeFileFoto = (e) => {
        const selected = e.target.files[0];
        if (selected) {
            setPreview(URL.createObjectURL(selected));
            setFile(selected);
        } else {
            setFile(null);
        }
    };

    const handleSubmitUbahFotoProfil = () => {
        if (!fileFoto) {
            Swal.fire({
                icon: "warning",
                title: "Pilih Foto Dulu",
                text: "Silakan pilih foto Anda terlebih dahulu sebelum mengunggah.",
                confirmButtonText: "OK",
            });
            return;
        }

        const formData = new FormData();
        formData.append("file", fileFoto);

        Swal.fire({
            title: "Yakin ingin memperbarui foto profil?",
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Ya, Ubah!",
            cancelButtonText: "Batal",
            reverseButtons: true,
        }).then((result) => {
            if (result.isConfirmed) {
                router.post("/v4/profil/ubahfoto", formData, {
                    preserveScroll: true,
                    onStart: () => {
                        Swal.fire({
                            title: "Mengunggah...",
                            text: "Foto Anda sedang diproses",
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            },
                        });
                    },
                    onSuccess: () => {
                        Swal.fire({
                            icon: "success",
                            title: "Berhasil!",
                            text: "Foto profil berhasil diperbarui.",
                            timer: 2000,
                            showConfirmButton: false,
                        });
                        if (fileInputRef.current) {
                            fileInputRef.current.value = null;
                        }
                    },
                    onError: (errors) => {
                        let pesan =
                            "Terjadi kesalahan saat memperbarui foto profil.";
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
            }
        });
    };

    const handleHapusFoto = () => {
        Swal.fire({
            title: "Hapus Foto Profil?",
            text: "Foto Anda akan dihapus dan diganti dengan foto default.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Ya, Hapus!",
            cancelButtonText: "Batal",
            reverseButtons: true,
        }).then((result) => {
            if (result.isConfirmed) {
                router.delete("/v4/profil/hapusfoto", {
                    onStart: () => {
                        Swal.fire({
                            title: "Menghapus...",
                            text: "Mohon tunggu sebentar",
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            },
                        });
                    },
                    onSuccess: () => {
                        Swal.fire({
                            icon: "success",
                            title: "Foto Dihapus",
                            text: "Foto profil berhasil dihapus.",
                            timer: 2000,
                            showConfirmButton: false,
                        });
                        setPreview("/react/images/faces/21.jpg");
                        setFile(null);
                        if (fileInputRefFoto.current) {
                            fileInputRefFoto.current.value = null;
                        }
                    },
                    onError: (errors) => {
                        let pesan =
                            "Terjadi kesalahan saat memperbarui foto profil.";
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
            }
        });
    };

    // TAB UBAH PASSWORD ------------------------------------------------------------------

    const [form, setForm] = useState({
        current_password: "",
        new_password: "",
        new_password_confirmation: "",
    });

    const [validReq, setValidReq] = useState({
        minLength: false,
        capital: false,
        number: false,
        special: false,
    });

    const [isPasswordValid, setIsPasswordValid] = useState(false);

    // 🔍 Cek validasi password baru setiap perubahan
    useEffect(() => {
        const pwd = form.new_password;

        const newValidReq = {
            minLength: pwd.length >= 8,
            capital: /[A-Z]/.test(pwd),
            number: /\d/.test(pwd),
            special: /[!@#$%^&*]/.test(pwd),
        };

        setValidReq(newValidReq);
        setIsPasswordValid(Object.values(newValidReq).every(Boolean));

        // Reset konfirmasi jika password baru berubah dan tidak cocok
        if (
            form.new_password_confirmation &&
            form.new_password_confirmation !== pwd
        ) {
            setForm((prev) => ({
                ...prev,
                new_password_confirmation: "",
            }));
        }
    }, [form.new_password]);

    const handleChangePassword = (e) => {
        const { name, value } = e.target;
        setForm((prev) => ({ ...prev, [name]: value }));
    };

    const validateFormPassword = () => {
        const required = [
            "current_password",
            "new_password",
            "new_password_confirmation",
        ];
        return required.every((field) => form[field]?.trim() !== "");
    };

    const handleSubmitPassword = (e) => {
        e.preventDefault();
        const formEl = e.target;

        if (!validateFormPassword(formEl)) {
            Swal.fire({
                icon: "error",
                title: "Validasi Gagal!",
                text: "Mohon lengkapi semua field wajib.",
            });
            return;
        }

        if (!isPasswordValid) {
            Swal.fire({
                icon: "error",
                title: "Password Tidak Memenuhi Kriteria!",
                text: "Pastikan password memiliki huruf besar, angka, dan karakter khusus.",
            });
            return;
        }

        if (form.new_password !== form.new_password_confirmation) {
            Swal.fire({
                icon: "error",
                title: "Password Tidak Sama!",
                text: "Pastikan password konfirmasi sesuai.",
            });
            return;
        }

        router.post(
            "/v4/profil/ubahpassword",
            { ...form, _method: "PATCH" },
            {
                onStart: () => {
                    Swal.fire({
                        title: "Memproses...",
                        text: "Sedang memperbarui password",
                        allowOutsideClick: false,
                        didOpen: () => Swal.showLoading(),
                    });
                },
                onSuccess: () => {
                    Swal.fire({
                        icon: "success",
                        title: "Berhasil!",
                        text: "Password berhasil diperbarui 🎉",
                        timer: 2000,
                        showConfirmButton: false,
                    });

                    // Reset form & state
                    setForm({
                        current_password: "",
                        new_password: "",
                        new_password_confirmation: "",
                    });
                    setValidReq({
                        minLength: false,
                        capital: false,
                        number: false,
                        special: false,
                    });
                    setIsPasswordValid(false);
                },
                onError: (errors) => {
                    Swal.fire({
                        icon: "error",
                        title: "Gagal!",
                        text:
                            Object.values(errors || {}).join("\n") ||
                            "Terjadi kesalahan saat memperbarui password.",
                    });
                },
            }
        );
    };

    // TAB DOKUMEN ------------------------------------------------------------------
    const switchStrRef = useRef();
    const jenisRef = useRef();
    const tglMulaiRef = useRef();
    const tglAkhirRef = useRef();
    const noSuratRef = useRef();
    const deskripsiRef = useRef();
    const uploadRef = useRef();

    // const [tableLoaded, setTableLoaded] = useState(false);
    const [loadingTabelDokumen, setLoadingTabelDokumen] = useState(false);
    const [loadingSimpanDokumen, setLoadingSimpanDokumen] = useState(false);

    // inisialisasi event handler seperti jQuery
    useEffect(() => {
        const switchStr = switchStrRef.current;
        const jenis = jenisRef.current;
        const tglMulai = tglMulaiRef.current;
        const tglAkhir = tglAkhirRef.current;
        const noSurat = noSuratRef.current;
        const deskripsi = deskripsiRef.current;
        const upload = uploadRef.current;

        // event change jenis dokumen
        const onJenisChange = () => {
            switchStr.checked = false;
            tglMulai.disabled = false;
            tglAkhir.disabled = false;
            noSurat.disabled = false;
            deskripsi.disabled = false;
            upload.disabled = false;

            if (jenis.value == 139) {
                switchStr.parentElement.parentElement.hidden = false;
            } else {
                switchStr.parentElement.parentElement.hidden = true;
            }

            if (jenis.value == 141 || jenis.value == 153) {
                tglMulai.disabled = true;
                noSurat.disabled = true;
                deskripsi.disabled = true;
            } else {
                tglMulai.disabled = false;
                noSurat.disabled = false;
                deskripsi.disabled = false;
            }
        };

        jenis.addEventListener("change", onJenisChange);

        // event switch STR
        const onSwitchChange = () => {
            if (switchStr.checked) {
                tglMulai.disabled = true;
                tglAkhir.disabled = true;
                deskripsi.disabled = true;
            } else {
                tglMulai.disabled = false;
                tglAkhir.disabled = false;
                deskripsi.disabled = false;
            }
        };
        switchStr.addEventListener("change", onSwitchChange);

        return () => {
            jenis.removeEventListener("change", onJenisChange);
            switchStr.removeEventListener("change", onSwitchChange);
        };
    }, []);

    const prosesTambahDokumen = () => {
        setLoadingSimpanDokumen(true);

        const switchStr = switchStrRef.current;
        const jenis = jenisRef.current.value;
        const tglMulai = tglMulaiRef.current.value;
        const tglAkhir = tglAkhirRef.current.value;
        const noSurat = noSuratRef.current.value;
        const deskripsi = deskripsiRef.current.value;
        const filex = uploadRef.current.files.length;

        let validasi = true;

        if (jenis === "") {
            validasi = false;
        } else {
            if (jenis == 139) {
                if (switchStr.checked) {
                    if (jenis === "" || noSurat === "" || filex === 0)
                        validasi = false;
                } else {
                    if (
                        jenis === "" ||
                        tglMulai === "" ||
                        tglAkhir === "" ||
                        noSurat === "" ||
                        filex === 0
                    ) {
                        validasi = false;
                    } else if (tglMulai === tglAkhir) {
                        validasi = false;
                        iziToast.error({
                            title: "Pesan Galat!",
                            message:
                                "Tanggal Mulai Berlaku tidak diperbolehkan sama dengan Tanggal Berakhir Surat",
                            position: "topRight",
                        });
                    }
                }
            } else if (jenis == 141 || jenis == 153) {
                if (jenis === "" || tglAkhir === "" || filex === 0)
                    validasi = false;
            } else {
                if (
                    jenis === "" ||
                    tglMulai === "" ||
                    tglAkhir === "" ||
                    noSurat === "" ||
                    filex === 0
                ) {
                    validasi = false;
                } else if (tglMulai === tglAkhir) {
                    validasi = false;
                    iziToast.error({
                        title: "Pesan Galat!",
                        message:
                            "Tanggal Mulai Berlaku tidak diperbolehkan sama dengan Tanggal Berakhir Surat",
                        position: "topRight",
                    });
                }
            }
        }

        if (!validasi) {
            iziToast.warning({
                title: "Pesan Ambigu!",
                message:
                    'Mohon lengkapi semua data (<span class="text-danger">*</span>) terlebih dahulu dan pastikan tidak ada yang kosong',
                position: "topRight",
            });
            setLoadingSimpanDokumen(false);
            return;
        }

        const fd = new FormData();
        fd.append("file", uploadRef.current.files[0]);
        fd.append("user_id", auth?.user?.id);
        fd.append("jenis", jenis);
        fd.append("tgl_mulai", tglMulai);
        fd.append("tgl_akhir", tglAkhir);
        fd.append("no_surat", noSurat);
        fd.append("deskripsi", deskripsi);

        axios
            .post(`/api/v4/profil/dokumen/add`, fd, {
                withCredentials: true,
            })
            .then((res) => {
                iziToast.success({
                    title: "Pesan Sukses!",
                    message: `Dokumen berhasil ditambahkan pada ${res.data}`,
                    position: "topRight",
                });
                refreshDokumen();
            })
            .catch((err) => {
                console.log(err);
                iziToast.error({
                    title: "Pesan Galat!",
                    message: "Proses upload Dokumen Gagal!",
                    position: "topRight",
                });
            })
            .finally(() => {
                setLoadingSimpanDokumen(false);
            });
    };

    const refreshDokumen = () => {
        setLoadingTabelDokumen(true);
        showLoading("#tampil-tbody-dokumen", 9);

        const switchStr = switchStrRef.current;
        const jenis = jenisRef.current;
        const tglMulai = tglMulaiRef.current;
        const tglAkhir = tglAkhirRef.current;
        const noSurat = noSuratRef.current;
        const deskripsi = deskripsiRef.current;
        const upload = uploadRef.current;

        switchStr.checked = false;
        jenis.value = "";
        tglMulai.value = "";
        tglMulai.disabled = false;
        tglAkhir.value = "";
        tglAkhir.disabled = false;
        noSurat.value = "";
        noSurat.disabled = false;
        deskripsi.value = "";
        deskripsi.disabled = false;
        upload.value = "";
        upload.disabled = false;

        // render table menggunakan AJAX
        axios
            .get(`/api/v4/profil/dokumen/table/${auth?.user?.id}`, {
                withCredentials: true,
            })
            .then((res) => {
                const data = res.data.show;
                const tableBody = $("#tampil-tbody-dokumen");
                if ($.fn.DataTable.isDataTable("#dttable-dokumen")) {
                    $("#dttable-dokumen").DataTable().clear().destroy();
                }
                tableBody.empty();

                data.forEach((item) => {
                    let content = `<tr id='data${item.id}'>`;
                    content += `<td><center><div class='dropend'><a href='javascript:void(0);' class='btn btn-light btn-sm text-muted font-size-16 rounded' data-bs-toggle='dropdown'><i class="ti ti-dots"></i></a><div class='dropdown-menu'>`;

                    if (item.title) {
                        content += `<a href='javascript:void(0);' class='dropdown-item text-primary' onclick="window.open('/v4/profil/dokumen/download/${item.id}')"><i class='fas fa-download me-1'></i> Download</a>`;
                    } else {
                        content += `<a href='javascript:void(0);' class='dropdown-item text-secondary' disabled><i class='fas fa-download me-1'></i> Download</a>`;
                    }

                    content += `</div></center></td>`;
                    content += `<td>
                        <h5 class="mb-0"><span class="badge me-1" style="font-size: 10px;${
                            item.color ? "background-color:" + item.color : ""
                        }">${item.nama_ref}</span> ${
                        item.status
                            ? item.no_surat
                            : "<s>" + item.no_surat + "</s>"
                    }</h5>`;
                    if (!item.tgl_akhir) {
                        if (item.ref_id == 139)
                            content += `<p class="text-muted f-12 mb-0">Masa Berlaku <a class="text-primary">Seumur Hidup</a></p>`;
                    } else {
                        if (!item.tgl_mulai)
                            content += `<p class="text-muted f-12 mb-0">${item.tgl_akhir}</p>`;
                        else
                            content += `<p class="text-muted f-12 mb-0">${item.tgl_mulai}&nbsp;<i class="ti ti-arrow-narrow-right text-primary"></i>&nbsp;${item.tgl_akhir}</p>`;
                    }
                    content += `</td><td style='white-space: normal !important;word-wrap: break-word;'>${
                        item.deskripsi ?? "-"
                    }</td>`;
                    content += `<td><center>${
                        item.status
                            ? '<span class="badge bg-success">Aktif</span>'
                            : '<span class="badge bg-danger">Nonaktif</span>'
                    }</center></td>`;
                    content += `<td>${new Date(item.updated_at).toLocaleString(
                        "sv-SE"
                    )}</td></tr>`;

                    tableBody.append(content);
                });
                initTooltips(tableBody);
                initDataTable("#dttable-dokumen", {
                    orderCol: 4,
                    sort: "desc",
                    displayLength: 10,
                    columnDefs: [
                        { width: "5%", targets: 0 },
                        { width: "30%", targets: 1 },
                        { width: "40%", targets: 2 },
                        { width: "10%", targets: 3 },
                        { width: "15%", targets: 3 },
                    ],
                    enableExport: false,
                });
            })
            .catch((err) => {
                iziToast.error({
                    title: "Pesan Galat!",
                    message: "Proses memuat Data Gagal!",
                    position: "topRight",
                });
            })
            .finally(() => {
                setLoadingTabelDokumen(false);
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
                                                        <>{auth.user.nama}</>
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
                                            <li
                                                className="nav-item"
                                                role="presentation"
                                            >
                                                <button
                                                    className="nav-link"
                                                    id=""
                                                    data-bs-toggle="tab"
                                                    data-bs-target="#ubah-profil-tab"
                                                    type="button"
                                                    role="tab"
                                                    aria-controls="ubah-profil-tab"
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
                                                    id=""
                                                    data-bs-toggle="tab"
                                                    data-bs-target="#password-tab"
                                                    type="button"
                                                    role="tab"
                                                    aria-controls="password-tab"
                                                    aria-selected="false"
                                                >
                                                    Password
                                                </button>
                                            </li>
                                            <li
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
                                                    onClick={() =>
                                                        refreshDokumen()
                                                    }
                                                >
                                                    Dokumen
                                                </button>
                                            </li>
                                            <li
                                                className="nav-item"
                                                role="presentation"
                                            >
                                                <button
                                                    className="nav-link"
                                                    id=""
                                                    data-bs-toggle="tab"
                                                    data-bs-target="#spkrkk-tab"
                                                    type="button"
                                                    role="tab"
                                                    aria-controls="spkrkk-tab"
                                                    aria-selected="false"
                                                    // onClick={() =>
                                                    //     refreshDokumen()
                                                    // }
                                                >
                                                    SPK & RKK
                                                </button>
                                            </li>
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
                            <div
                                className="tab-pane p-0 border-0"
                                id="ubah-profil-tab"
                                role="tabpanel"
                                aria-labelledby="ubah-profil-tab"
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
                                            onSubmit={handleSubmitUbahProfil}
                                            className="g-3 needs-validation"
                                            noValidate
                                        >
                                            <div className="row">
                                                <div className="col-xl-12">
                                                    <div className="row">
                                                        <div className="col-xl-5">
                                                            <label className="form-label fw-bold">
                                                                Foto Profil
                                                            </label>
                                                            <div className="card mb-3">
                                                                <div className="card-body">
                                                                    <div className="d-flex flex-column gap-2">
                                                                        <div className="d-flex align-items-center gap-3 flex-wrap">
                                                                            <span className="avatar avatar-xxl">
                                                                                <img
                                                                                    src={
                                                                                        preview
                                                                                    }
                                                                                    alt="Foto Profil"
                                                                                />
                                                                            </span>

                                                                            <div className="d-flex flex-column">
                                                                                <div className="d-flex align-items-center gap-2 flex-wrap">
                                                                                    <input
                                                                                        ref={
                                                                                            fileInputRefFoto
                                                                                        }
                                                                                        type="file"
                                                                                        accept="image/*"
                                                                                        onChange={
                                                                                            handleChangeFileFoto
                                                                                        }
                                                                                        className="form-control form-control-sm"
                                                                                        style={{
                                                                                            width: "auto",
                                                                                        }}
                                                                                    />

                                                                                    <button
                                                                                        type="button"
                                                                                        className="btn btn-sm btn-primary"
                                                                                        onClick={
                                                                                            handleSubmitUbahFotoProfil
                                                                                        }
                                                                                        disabled={
                                                                                            !fileFoto
                                                                                        }
                                                                                    >
                                                                                        <i className="ri-upload-2-line me-1"></i>{" "}
                                                                                        Ganti
                                                                                    </button>

                                                                                    <button
                                                                                        type="button"
                                                                                        className="btn btn-sm btn-light"
                                                                                        onClick={
                                                                                            handleHapusFoto
                                                                                        }
                                                                                        disabled={
                                                                                            preview ===
                                                                                            "/react/images/faces/21.jpg"
                                                                                        }
                                                                                    >
                                                                                        <i className="ri-delete-bin-line me-1"></i>{" "}
                                                                                        Hapus
                                                                                    </button>
                                                                                </div>
                                                                                <span className="d-block fs-12 text-muted mt-1">
                                                                                    Ekstensi
                                                                                    JPG
                                                                                    /
                                                                                    PNG.
                                                                                    Ukuran
                                                                                    ideal
                                                                                    200x200
                                                                                    pixels.
                                                                                    Maksimal
                                                                                    3MB.
                                                                                </span>
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
                                                                Data Sensitif
                                                            </label>
                                                            <div className="card mb-3">
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
                                                    <label className="form-label fw-bold">
                                                        Pengalaman Kerja
                                                    </label>
                                                    <textarea
                                                        id="pengalaman_kerja"
                                                        name="pengalaman_kerja"
                                                        rows="5"
                                                        className="form-control mb-3"
                                                        placeholder="e.g. Saya pernah bekerja pada suatu instansi swasta ternama bertempat di Kota X dan berprofesi sebagai X..."
                                                        value={
                                                            data.pengalaman_kerja ||
                                                            ""
                                                        }
                                                        onChange={(e) =>
                                                            setData(
                                                                "pengalaman_kerja",
                                                                e.target.value
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
                                                                                Provinsi{" "}
                                                                                <span className="text-danger">
                                                                                    *
                                                                                </span>
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
                                                                                    --
                                                                                    Pilih
                                                                                    Provinsi
                                                                                    --
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
                                                                                Kabupaten{" "}
                                                                                <span className="text-danger">
                                                                                    *
                                                                                </span>
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
                                                                                    --
                                                                                    Pilih
                                                                                    Kabupaten
                                                                                    --
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
                                                                                Kecamatan{" "}
                                                                                <span className="text-danger">
                                                                                    *
                                                                                </span>
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
                                                                                    --
                                                                                    Pilih
                                                                                    Kecamatan
                                                                                    --
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
                                                                                Kelurahan{" "}
                                                                                <span className="text-danger">
                                                                                    *
                                                                                </span>
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
                                                                                    --
                                                                                    Pilih
                                                                                    Kelurahan
                                                                                    --
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
                                                                                Lengkap{" "}
                                                                                <span className="text-danger">
                                                                                    *
                                                                                </span>
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
                                                                            className={
                                                                                nama !==
                                                                                "s3"
                                                                                    ? "mb-3 border-bottom pb-3"
                                                                                    : ""
                                                                            }
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
                                                                                        handleChangeUbahPendidikan(
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
                                                                                        handleChangeUbahPendidikan(
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
                                id="password-tab"
                                role="tabpanel"
                                aria-labelledby="password-tab"
                                tabIndex="0"
                            >
                                <div className="card custom-card">
                                    <div className="card-header fw-bold justify-content-between">
                                        <div>
                                            Ubah{" "}
                                            <b className="text-danger">
                                                Password
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
                                    <form
                                        className="needs-validation"
                                        noValidate
                                        onSubmit={handleSubmitPassword}
                                        encType="multipart/form-data"
                                    >
                                        <div className="card-body">
                                            <div className="row">
                                                <div className="col-sm-12 mb-3">
                                                    <div
                                                        className="alert alert-danger alert-dismissible fade show custom-alert-icon shadow-sm"
                                                        role="alert"
                                                    >
                                                        <h6 className="alert-heading fw-bold mb-3">
                                                            Keamanan Password
                                                        </h6>
                                                        <ul>
                                                            <li className="mb-2">
                                                                Jangan berikan{" "}
                                                                <strong className="text-danger fw-bold">
                                                                    Password
                                                                </strong>{" "}
                                                                anda kepada
                                                                orang lain
                                                            </li>
                                                            <li className="mb-2">
                                                                Password akan
                                                                diproses melalui
                                                                metode{" "}
                                                                <i className="text-dark fw-bold">
                                                                    Bcrypt Hash
                                                                    Password
                                                                </i>{" "}
                                                                oleh sistem
                                                            </li>
                                                            <li>
                                                                Apabila anda
                                                                lupa Password
                                                                akun Simrsmu,
                                                                silakan masuk ke
                                                                laman{" "}
                                                                <b className="text-danger fw-bold">
                                                                    Lupa
                                                                    Password
                                                                </b>{" "}
                                                                pada halaman
                                                                Login
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>

                                                <div className="col-sm-6">
                                                    <div className="mb-3">
                                                        <label className="form-label">
                                                            Password Lama{" "}
                                                            <span className="text-danger">
                                                                *
                                                            </span>
                                                        </label>
                                                        <input
                                                            type="password"
                                                            className="form-control"
                                                            id="oldPassword"
                                                            name="current_password"
                                                            autoComplete="current-password"
                                                            value={
                                                                form.current_password
                                                            }
                                                            onChange={
                                                                handleChangePassword
                                                            }
                                                            required
                                                            placeholder="••••••••••"
                                                        />
                                                    </div>

                                                    <div className="mb-3">
                                                        <label className="form-label">
                                                            Password Baru{" "}
                                                            <span className="text-danger">
                                                                *
                                                            </span>
                                                        </label>
                                                        <input
                                                            type="password"
                                                            className="form-control"
                                                            id="newPassword"
                                                            name="new_password"
                                                            autoComplete="new_password"
                                                            value={
                                                                form.new_password
                                                            }
                                                            onChange={
                                                                handleChangePassword
                                                            }
                                                            required
                                                            placeholder="••••••••••"
                                                        />
                                                    </div>

                                                    <div className="mb-3">
                                                        <label className="form-label">
                                                            Konfirmasi Password
                                                            Baru{" "}
                                                            <span className="text-danger">
                                                                *
                                                            </span>
                                                        </label>
                                                        <input
                                                            type="password"
                                                            className="form-control"
                                                            id="confirmPassword"
                                                            name="new_password_confirmation"
                                                            autoComplete="new_password_confirmation"
                                                            value={
                                                                form.new_password_confirmation
                                                            }
                                                            onChange={
                                                                handleChangePassword
                                                            }
                                                            required
                                                            placeholder="••••••••••"
                                                        />
                                                        <small>
                                                            Tuliskan password
                                                            baru yang sama untuk
                                                            konfirmasi password
                                                            baru Anda
                                                        </small>
                                                    </div>
                                                </div>

                                                <div className="col-sm-6">
                                                    <h6>
                                                        Password Baru Anda harus
                                                        memenuhi kriteria
                                                        sebagai berikut :
                                                    </h6>
                                                    <ul className="list-group list-group-flush mb-3">
                                                        <li className="list-group-item requirements">
                                                            <i
                                                                className={`ti ti-circle-check f-16 me-2 ${
                                                                    validReq.minLength
                                                                        ? "text-success"
                                                                        : "text-danger"
                                                                }`}
                                                            ></i>
                                                            Melebihi 8 karakter
                                                        </li>
                                                        <li className="list-group-item requirements">
                                                            <i
                                                                className={`ti ti-circle-check f-16 me-2 ${
                                                                    validReq.capital
                                                                        ? "text-success"
                                                                        : "text-danger"
                                                                }`}
                                                            ></i>
                                                            Minimal 1 Huruf
                                                            Kapital (A-Z)
                                                        </li>
                                                        <li className="list-group-item requirements">
                                                            <i
                                                                className={`ti ti-circle-check f-16 me-2 ${
                                                                    validReq.number
                                                                        ? "text-success"
                                                                        : "text-danger"
                                                                }`}
                                                            ></i>
                                                            Minimal 1 Angka
                                                            (0-9)
                                                        </li>
                                                        <li className="list-group-item requirements">
                                                            <i
                                                                className={`ti ti-circle-check f-16 me-2 ${
                                                                    validReq.special
                                                                        ? "text-success"
                                                                        : "text-danger"
                                                                }`}
                                                            ></i>
                                                            Minimal 1 Karakter
                                                            Khusus (!@#$%^&*)
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div className="card-footer btn-page">
                                            <div className="d-flex justify-content-between flex-wrap gap-2">
                                                <div className="fs-semibold fs-14">
                                                    <p className="card-text align-middle">
                                                        <small>
                                                            Terakhir password
                                                            diperbarui :
                                                        </small>
                                                        <br />
                                                        <a
                                                            className="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover text-decoration-underline"
                                                            role="button"
                                                        >
                                                            {user?.last_updated_password ? (
                                                                new Date(
                                                                    user.last_updated_password
                                                                ).toLocaleString(
                                                                    "sv-SE"
                                                                )
                                                            ) : (
                                                                <>{"-"}</>
                                                            )}
                                                        </a>
                                                    </p>
                                                </div>
                                                <button
                                                    className="btn btn-secondary"
                                                    type="submit"
                                                    id="btn-submit-password"
                                                    disabled={!isPasswordValid}
                                                >
                                                    <i className="ri-rocket-2-line me-1"></i>{" "}
                                                    Perbarui
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div
                                className="tab-pane p-0 border-0"
                                id="dokumen-tab"
                                role="tabpanel"
                                aria-labelledby="dokumen-tab"
                                tabIndex="0"
                            >
                                <div className="card custom-card">
                                    <div className="card-header fw-bold justify-content-between">
                                        <div>
                                            Daftar{" "}
                                            <b className="text-teal">
                                                Upload Dokumen
                                            </b>
                                        </div>
                                        <div>
                                            <div className="btn-group">
                                                <button
                                                    type="button"
                                                    className="btn btn-sm btn-warning-light btn-wave"
                                                    onClick={() =>
                                                        refreshDokumen()
                                                    }
                                                >
                                                    <i
                                                        className={`fas me-1 ${
                                                            loadingTabelDokumen
                                                                ? "fa-sync fa-spin"
                                                                : "fa-sync"
                                                        }`}
                                                        data-bs-toggle="tooltip"
                                                        title="Refresh Daftar Dokumen Upload"
                                                    ></i>{" "}
                                                    Refresh Tabel
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div className="card-body pb-0">
                                        <div className="d-flex align-items-center justify-content-between">
                                            <h5 className="mb-0 flex-grow-1">
                                                <a className="text-danger">*</a>
                                                /x{" "}
                                                <small>
                                                    dokumen wajib sudah
                                                    terupload.
                                                </small>
                                            </h5>
                                            <div
                                                className="flex-shrink-0"
                                                id="switch-str"
                                                hidden
                                            >
                                                <div className="form-check form-switch custom-switch-v1 switch-sm">
                                                    <input
                                                        type="checkbox"
                                                        className="form-check-input input-primary"
                                                        id="checkboxseumurhidup"
                                                        ref={switchStrRef}
                                                    />
                                                    <label
                                                        className="form-check-label"
                                                        htmlFor="checkboxseumurhidup"
                                                    >
                                                        Seumur Hidup ?
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <hr className="my-2" />
                                        <div className="row">
                                            <div className="col-md-3">
                                                <div className="form-group mb-3">
                                                    <label className="form-label">
                                                        Jenis Surat{" "}
                                                        <span className="text-danger">
                                                            *
                                                        </span>
                                                    </label>
                                                    <select
                                                        className="form-control"
                                                        id="jenis_dokumen"
                                                        ref={jenisRef}
                                                        defaultValue=""
                                                    >
                                                        <option value="" hidden>
                                                            Pilih Jenis Surat
                                                        </option>
                                                        {list.ref_dokumen &&
                                                            list.ref_dokumen.map(
                                                                (item) => (
                                                                    <option
                                                                        key={
                                                                            item.id
                                                                        }
                                                                        value={
                                                                            item.id
                                                                        }
                                                                    >
                                                                        {
                                                                            item.deskripsi
                                                                        }
                                                                    </option>
                                                                )
                                                            )}
                                                    </select>
                                                </div>
                                            </div>
                                            <div className="col-md-3">
                                                <div className="form-group mb-3">
                                                    <label className="form-label">
                                                        Tgl. Mulai Berlaku{" "}
                                                        <span className="text-danger">
                                                            *
                                                        </span>
                                                    </label>
                                                    <input
                                                        type="date"
                                                        className="form-control"
                                                        id="tgl_mulai_dokumen"
                                                        ref={tglMulaiRef}
                                                    />
                                                </div>
                                            </div>
                                            <div className="col-md-3">
                                                <div className="form-group mb-3">
                                                    <label className="form-label">
                                                        Tgl. Berakhir Surat{" "}
                                                        <span className="text-danger">
                                                            *
                                                        </span>
                                                    </label>
                                                    <input
                                                        type="date"
                                                        className="form-control"
                                                        id="tgl_akhir_dokumen"
                                                        ref={tglAkhirRef}
                                                    />
                                                </div>
                                            </div>
                                            <div className="col-md-3">
                                                <div className="form-group mb-3">
                                                    <label className="form-label">
                                                        Nomor Surat{" "}
                                                        <span className="text-danger">
                                                            *
                                                        </span>
                                                    </label>
                                                    <input
                                                        type="text"
                                                        className="form-control"
                                                        id="no_surat_dokumen"
                                                        ref={noSuratRef}
                                                        placeholder="e.g. III.l23213.AKBV"
                                                    />
                                                </div>
                                            </div>
                                            <div className="col-md-5">
                                                <div className="form-group mb-3">
                                                    <label className="form-label">
                                                        Deskripsi
                                                    </label>
                                                    <textarea
                                                        className="form-control"
                                                        id="deskripsi_dokumen"
                                                        placeholder="Tuliskan Keterangan (Optional)"
                                                        rows={3}
                                                        ref={deskripsiRef}
                                                    ></textarea>
                                                </div>
                                            </div>
                                            <div className="col-md-7">
                                                <div className="form-group mb-3 d-flex flex-column">
                                                    <label className="form-label">
                                                        Upload Dokumen{" "}
                                                        <span className="text-danger">
                                                            *
                                                        </span>
                                                    </label>
                                                    <div className="row mb-2">
                                                        <div className="col">
                                                            <input
                                                                type="file"
                                                                className="form-control form-control-sm"
                                                                id="upload_dokumen"
                                                                accept="application/pdf"
                                                                ref={uploadRef}
                                                            />
                                                        </div>
                                                        <div className="col-auto">
                                                            <button
                                                                className="btn btn-primary"
                                                                onClick={
                                                                    prosesTambahDokumen
                                                                }
                                                                id="btn-upload-dokumen"
                                                                disabled={
                                                                    loadingSimpanDokumen
                                                                }
                                                            >
                                                                <i
                                                                    className={`fas me-1 ${
                                                                        loadingSimpanDokumen
                                                                            ? "fa-sync fa-spin"
                                                                            : "fa-upload"
                                                                    }`}
                                                                ></i>{" "}
                                                                Upload
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <span className="d-block fs-12 text-muted mt-1">
                                                        Ekstensi Wajib{" "}
                                                        <mark>PDF</mark>.
                                                        Maksimal <b>2MB</b>.
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div className="card-body">
                                        <div className="table-responsive">
                                            <table
                                                className="table mb-0 table-hover text-nowrap w-100 dataTable no-footer"
                                                id="dttable-dokumen"
                                            >
                                                <thead>
                                                    <tr>
                                                        <th>
                                                            <center>
                                                                AKSI
                                                            </center>
                                                        </th>
                                                        <th>DOKUMEN SURAT</th>
                                                        <th>DESKRIPSI</th>
                                                        <th>
                                                            <center>
                                                                STATUS
                                                            </center>
                                                        </th>
                                                        <th className="text-end">
                                                            TERAKHIR DIPERBARUI
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tampil-tbody-dokumen">
                                                    <tr>
                                                        <td
                                                            colSpan="9"
                                                            style={{
                                                                fontSize:
                                                                    "13px",
                                                            }}
                                                        >
                                                            <center>
                                                                <i className="fa fa-spinner fa-spin fa-fw"></i>{" "}
                                                                Memproses
                                                                data...
                                                            </center>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div
                                className="tab-pane p-0 border-0"
                                id="spkrkk-tab"
                                role="tabpanel"
                                aria-labelledby="spkrkk-tab"
                                tabIndex="0"
                            >
                                <div className="card custom-card">
                                    <div className="card-header fw-bold justify-content-between">
                                        <div>
                                            Daftar Dokumen{" "}
                                            <b className="text-indigo">
                                                SPK
                                            </b>{" "}&{" "}
                                            <b className="text-info">
                                                RKK
                                            </b>
                                        </div>
                                        <div>
                                            <div className="btn-group">
                                            </div>
                                        </div>
                                    </div>
                                    <div className="card-body">
                                        coming soon, as fast as i can.
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
