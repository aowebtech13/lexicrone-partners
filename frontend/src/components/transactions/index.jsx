import React from 'react';
import HeaderSix from '@/src/layout/headers/header-6';
import Footer from '@/src/layout/footers/footer';
import TransactionsArea from './transactions-area';

const Transactions = () => {
    return (
        <>
            <HeaderSix style_2={true} />
            <div id="smooth-wrapper">
                <div id="smooth-content">
                    <main className="fix">
                        <TransactionsArea />
                    </main>
                    <Footer />
                </div>
            </div>
        </>
    );
};

export default Transactions;
