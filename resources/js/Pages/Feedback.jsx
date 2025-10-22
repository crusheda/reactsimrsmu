import React from "react";
import { Head } from '@inertiajs/react';
import MainLayout from "@/Layouts/MainLayout";

export default function Feedback() {
    return (
        <>
            <Head>
                <title>Feedback</title>
            </Head>
            <div>ini halaman Masukan & Saran</div>
        </>
    );
}

Feedback.layout = (page) => <MainLayout>{page}</MainLayout>;
