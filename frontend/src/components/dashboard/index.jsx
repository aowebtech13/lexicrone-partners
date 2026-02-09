import React from 'react';
import HeaderSix from '@/src/layout/headers/header-6';
import Footer from '@/src/layout/footers/footer';
import DashboardArea from './dashboard-area';
import HeroArea from '../homes/home-2/hero-area';
import PaymentArea from '../homes/home-2/payment-area';
import PaymentMethodArea from '../homes/home-2/payment-method-area';
import ServiceArea from '../homes/home-2/service-area';
import OpenAccountArea from '../homes/home-2/open-account-area';
import TestimonialArea from '../homes/home-2/testimonial-area';
import FaqArea from '../homes/home-2/faq-area';
import CtaArea from '../homes/home-2/cta-area';

const Dashboard = () => {
    return (
        <>
            <HeaderSix style_2={true} />
            <div id="smooth-wrapper">
                <div id="smooth-content">
                    <main className="fix">
                        <HeroArea />
                        <ServiceArea />
                        <DashboardArea />
                        <PaymentArea />
                        
                     
                        <OpenAccountArea />
                
                        <FaqArea />
                       
                    </main>
                    <Footer />
                </div>
            </div>
        </>
    );
};

export default Dashboard;
