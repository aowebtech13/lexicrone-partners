import React, { useEffect, useState } from 'react';
import api from '@/src/utils/api';

const TransactionsArea = () => {
    const [transactions, setTransactions] = useState([]);
    const [loading, setLoading] = useState(true);
    const [pagination, setPagination] = useState({
        current_page: 1,
        last_page: 1,
        total: 0
    });

    const fetchTransactions = async (page = 1) => {
        setLoading(true);
        try {
            const { data } = await api.get(`transactions?page=${page}`);
            setTransactions(data.data);
            setPagination({
                current_page: data.current_page,
                last_page: data.last_page,
                total: data.total
            });
        } catch (error) {
            console.error("Error fetching transactions:", error);
        } finally {
            setLoading(false);
        }
    };

    useEffect(() => {
        fetchTransactions();
    }, []);

    const handlePageChange = (page) => {
        if (page >= 1 && page <= pagination.last_page) {
            fetchTransactions(page);
        }
    };

    if (loading && transactions.length === 0) return (
        <div className="container pt-120 pb-120">
            <div className="row justify-content-center">
                <div className="col-12 text-center">
                    <div className="spinner-border text-primary" role="status">
                        <span className="visually-hidden">Loading...</span>
                    </div>
                    <p className="mt-2">Loading transactions...</p>
                </div>
            </div>
        </div>
    );

    return (
        <>
            <div className="transactions-area pt-120 pb-120">
                <div className="container">
                    <div className="row">
                        <div className="col-12">
                            <div className="section-title-wrapper mb-40">
                                <h3 className="section-title">Transaction History</h3>
                                <p>A complete list of all your financial activities.</p>
                            </div>
                        </div>
                    </div>

                    <div className="row">
                        <div className="col-12">
                            <div className="tp-dashboard-widget">
                                <div className="tp-dashboard-table table-responsive">
                                    <table className="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Type</th>
                                                <th>Amount</th>
                                                <th>Description</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {transactions.length > 0 ? (
                                                transactions.map((tr) => (
                                                    <tr key={tr.id}>
                                                        <td className="text-capitalize">
                                                            <span className={`transaction-type ${tr.type}`}>
                                                                {tr.type}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span className={tr.amount > 0 ? 'text-success' : 'text-danger'}>
                                                                {tr.amount > 0 ? '+' : ''}${Math.abs(tr.amount).toFixed(2)}
                                                            </span>
                                                        </td>
                                                        <td>{tr.description || 'N/A'}</td>
                                                        <td>{new Date(tr.created_at).toLocaleString()}</td>
                                                        <td>
                                                            <span className={`badge ${tr.status === 'completed' ? 'bg-success' : 'bg-warning'}`}>
                                                                {tr.status}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                ))
                                            ) : (
                                                <tr>
                                                    <td colSpan="5" className="text-center py-5">
                                                        No transactions found.
                                                    </td>
                                                </tr>
                                            )}
                                        </tbody>
                                    </table>
                                </div>

                                {pagination.last_page > 1 && (
                                    <div className="tp-pagination mt-40">
                                        <nav>
                                            <ul className="pagination justify-content-center">
                                                <li className={`page-item ${pagination.current_page === 1 ? 'disabled' : ''}`}>
                                                    <button className="page-link" onClick={() => handlePageChange(pagination.current_page - 1)}>
                                                        <i className="fal fa-angle-left"></i>
                                                    </button>
                                                </li>
                                                {[...Array(pagination.last_page).keys()].map((p) => (
                                                    <li key={p + 1} className={`page-item ${pagination.current_page === p + 1 ? 'active' : ''}`}>
                                                        <button className="page-link" onClick={() => handlePageChange(p + 1)}>
                                                            {p + 1}
                                                        </button>
                                                    </li>
                                                ))}
                                                <li className={`page-item ${pagination.current_page === pagination.last_page ? 'disabled' : ''}`}>
                                                    <button className="page-link" onClick={() => handlePageChange(pagination.current_page + 1)}>
                                                        <i className="fal fa-angle-right"></i>
                                                    </button>
                                                </li>
                                            </ul>
                                        </nav>
                                    </div>
                                )}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <style jsx>{`
                .tp-dashboard-widget {
                    background: #fff;
                    border-radius: 12px;
                    padding: 30px;
                    box-shadow: 0 4px 20px rgba(0,0,0,0.05);
                }
                .tp-dashboard-table .table {
                    margin-bottom: 0;
                }
                .tp-dashboard-table th {
                    border-top: none;
                    font-weight: 600;
                    color: #444;
                    padding: 15px;
                }
                .tp-dashboard-table td {
                    padding: 15px;
                    vertical-align: middle;
                    color: #666;
                }
                .transaction-type {
                    font-weight: 500;
                }
                .transaction-type.investment { color: #007bff; }
                .transaction-type.deposit { color: #28a745; }
                .transaction-type.withdrawal { color: #dc3545; }
                
                .page-link {
                    color: #007bff;
                    border: 1px solid #eee;
                    margin: 0 5px;
                    border-radius: 5px !important;
                    padding: 8px 16px;
                }
                .page-item.active .page-link {
                    background-color: #007bff;
                    border-color: #007bff;
                }
                .badge {
                    padding: 8px 12px;
                    font-weight: 500;
                    border-radius: 6px;
                }
            `}</style>
        </>
    );
};

export default TransactionsArea;
