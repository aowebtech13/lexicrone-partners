import React from 'react';
import HeaderSix from '@/src/layout/headers/header-6';
import Footer from '@/src/layout/footers/footer';
import DepositArea from './deposit-area';

const Deposit = () => {
    return (
        <>
            <HeaderSix style_2={true} />
            <main>
                <DepositArea />
            </main>
            <Footer />
        </>
    );
};

export default Deposit;
