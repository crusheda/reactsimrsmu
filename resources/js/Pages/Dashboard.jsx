import { useEffect } from 'react';
import { Head } from '@inertiajs/react';
import MainLayout from '../Layouts/MainLayout';

export default function Dashboard({ list }) {
    return (
        <>
            <Head>
                <title>Dashboard</title>
            </Head>
            <div>{list.user?.nama || 'noooot'}</div>
        </>
    );
}

Dashboard.layout = page => <MainLayout>{page}</MainLayout>;
