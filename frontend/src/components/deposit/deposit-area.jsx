import React, { useState } from 'react';

const DepositArea = () => {
    const [selectedBank, setSelectedBank] = useState('');
    
    const banks = [
        { id: 1, name: 'Chase Bank', account: '**** 4567' },
        { id: 2, name: 'Bank of America', account: '**** 8901' },
        { id: 3, name: 'Wells Fargo', account: '**** 2345' },
    ];

    const history = [
        { id: 1, bank: 'Chase Bank', amount: '$1,500.00', date: '2023-10-20', status: 'Completed', ref: 'DEP-88231' },
        { id: 2, bank: 'Wells Fargo', amount: '$3,000.00', date: '2023-10-15', status: 'Completed', ref: 'DEP-88210' },
        { id: 3, bank: 'Bank of America', amount: '$500.00', date: '2023-10-10', status: 'Failed', ref: 'DEP-88195' },
    ];

    return (
        <>
            <div className="deposit-area pt-120 pb-120">
                <div className="container">
                    <div className="row">
                        <div className="col-12">
                            <div className="section-title-wrapper mb-40">
                                <h3 className="section-title">Deposit Funds</h3>
                                <p>Securely add funds to your trading account.</p>
                            </div>
                        </div>
                    </div>

                    <div className="row">
                        <div className="col-xl-5 col-lg-6">
                            <div className="tp-deposit-form-wrapper p-relative z-index-1">
                                <h4 className="tp-deposit-form-title mb-30">Make a Deposit</h4>
                                <form action="#">
                                    <div className="mb-20">
                                        <label className="form-label">Select Bank</label>
                                        <select 
                                            className="form-select tp-input-style" 
                                            value={selectedBank}
                                            onChange={(e) => setSelectedBank(e.target.value)}
                                        >
                                            <option value="">Choose a bank...</option>
                                            {banks.map(bank => (
                                                <option key={bank.id} value={bank.name}>{bank.name} ({bank.account})</option>
                                            ))}
                                        </select>
                                    </div>
                                    <div className="mb-20">
                                        <label className="form-label">Amount ($)</label>
                                        <input type="number" className="form-control tp-input-style" placeholder="Enter amount" />
                                    </div>
                                    <div className="mb-30">
                                        <div className="tp-deposit-notice p-3 bg-light border-radius-8">
                                            <small className="text-muted">
                                                <i className="fal fa-info-circle me-1"></i>
                                                Deposits via bank transfer typically take 1-3 business days to process.
                                            </small>
                                        </div>
                                    </div>
                                    <button type="submit" className="tp-btn w-100">Proceed to Deposit</button>
                                </form>
                            </div>
                        </div>

                        <div className="col-xl-7 col-lg-6">
                            <div className="tp-deposit-history-wrapper">
                                <div className="d-flex align-items-center justify-content-between mb-30">
                                    <h4 className="tp-deposit-history-title">Bank Deposit History</h4>
                                    <div className="tp-deposit-history-filter">
                                        <select className="form-select form-select-sm">
                                            <option>All Status</option>
                                            <option>Completed</option>
                                            <option>Pending</option>
                                            <option>Failed</option>
                                        </select>
                                    </div>
                                </div>
                                <div className="tp-deposit-table table-responsive">
                                    <table className="table">
                                        <thead>
                                            <tr>
                                                <th>Reference</th>
                                                <th>Bank</th>
                                                <th>Amount</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {history.map((item) => (
                                                <tr key={item.id}>
                                                    <td><code>{item.ref}</code></td>
                                                    <td>{item.bank}</td>
                                                    <td>{item.amount}</td>
                                                    <td>{item.date}</td>
                                                    <td>
                                                        <span className={`badge ${item.status === 'Completed' ? 'bg-success' : item.status === 'Failed' ? 'bg-danger' : 'bg-warning'}`}>
                                                            {item.status}
                                                        </span>
                                                    </td>
                                                </tr>
                                            ))}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <style jsx>{`
                .tp-deposit-form-wrapper, .tp-deposit-history-wrapper {
                    background: #fff;
                    border-radius: 12px;
                    padding: 40px;
                    box-shadow: 0 4px 20px rgba(0,0,0,0.05);
                }
                .tp-deposit-form-title, .tp-deposit-history-title {
                    font-size: 22px;
                    font-weight: 600;
                    color: #212529;
                }
                .tp-input-style {
                    height: 55px;
                    border: 1px solid #e5e5e5;
                    border-radius: 8px;
                    padding: 0 20px;
                    background: #f9f9f9;
                }
                .tp-input-style:focus {
                    background: #fff;
                    border-color: #007bff;
                    box-shadow: none;
                }
                .tp-deposit-table th {
                    border-top: none;
                    color: #6c757d;
                    font-weight: 500;
                    padding: 15px 10px;
                }
                .tp-deposit-table td {
                    padding: 15px 10px;
                    vertical-align: middle;
                }
                .border-radius-8 {
                    border-radius: 8px;
                }
            `}</style>
        </>
    );
};

export default DepositArea;
