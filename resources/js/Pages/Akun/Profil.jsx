import React from "react";
import { Head } from '@inertiajs/react';
import MainLayout from "@/Layouts/MainLayout";

export default function Profil() {
    return (
        <>
            <Head>
                <title>Profil Saya</title>
            </Head>
            <div>ini halaman profil</div>
        </>
    );
}

Profil.layout = (page) => <MainLayout>{page}</MainLayout>;
