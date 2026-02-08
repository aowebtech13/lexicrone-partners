import React from 'react';
import HeaderSix from '@/src/layout/headers/header-6';
import Footer from '@/src/layout/footers/footer';
import DashboardArea from './dashboard-area';

const Dashboard = () => {
    return (
        <>
            <HeaderSix style_2={true} />
            <main>
                <DashboardArea />
            </main>
            <Footer />
        </>
    );
};

export default Dashboard;
