import React from 'react';
import HeaderSix from '@/src/layout/headers/header-6';
import Footer from '@/src/layout/footers/footer';
import AdminArea from './admin-area';

const AdminDashboard = () => {
    return (
        <>
            <HeaderSix style_2={true} />
            <div id="smooth-wrapper">
                <div id="smooth-content">
                    <main className="fix">
                        <AdminArea />
                    </main>
                    <Footer />
                </div>
            </div>
        </>
    );
};

export default AdminDashboard;
