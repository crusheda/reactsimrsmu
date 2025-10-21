// resources/js/Layouts/MainLayout.jsx
import React from 'react';
import { Link } from '@inertiajs/react';

export default function MainLayout({ children }) {
    return (
        <div className="main-wrapper">
            <Sidebar />
            <Header />
            <main>{children}</main>
        </div>
    );
}
