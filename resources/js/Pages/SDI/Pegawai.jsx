import React from "react";
import { Head } from '@inertiajs/react';
import MainLayout from "@/Layouts/MainLayout";

export default function Pegawai() {
    return (
        <>
            <Head>
                <title>SDI - Pegawai</title>
            </Head>
            <div>ini halaman SDI - Pegawai</div>
        </>
    );
}

Pegawai.layout = (page) => <MainLayout>{page}</MainLayout>;
