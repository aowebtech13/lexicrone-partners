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
        <div className="py-12 bg-slate-50 min-h-screen">
            <div className="container max-w-6xl mx-auto px-4">
                <div className="mb-10">
                    <h1 className="text-4xl font-black text-slate-900 tracking-tight">Financial Ledger</h1>
                    <p className="text-slate-500 font-medium mt-2 text-lg">Detailed history of all your platform transactions.</p>
                </div>

                <div className="bg-white rounded-[2rem] shadow-xl shadow-slate-200/60 overflow-hidden border border-slate-100">
                    <div className="overflow-x-auto">
                        <table className="table table-lg w-full">
                            <thead>
                                <tr className="bg-slate-50 border-b border-slate-100">
                                    <th className="font-black text-[10px] uppercase tracking-[0.2em] text-slate-400 py-6 px-8">Activity</th>
                                    <th className="font-black text-[10px] uppercase tracking-[0.2em] text-slate-400 text-center">Amount</th>
                                    <th className="font-black text-[10px] uppercase tracking-[0.2em] text-slate-400">Description</th>
                                    <th className="font-black text-[10px] uppercase tracking-[0.2em] text-slate-400">Timestamp</th>
                                    <th className="font-black text-[10px] uppercase tracking-[0.2em] text-slate-400 text-right px-8">Status</th>
                                </tr>
                            </thead>
                            <tbody className="divide-y divide-slate-50">
                                {transactions.length > 0 ? (
                                    transactions.map((tr) => (
                                        <tr key={tr.id} className="hover:bg-slate-50/50 transition-all group">
                                            <td className="px-8 py-6">
                                                <div className="flex items-center gap-3">
                                                    <div className={`w-10 h-10 rounded-xl flex items-center justify-center shadow-sm 
                                                        ${tr.type.includes('deposit') || tr.type.includes('profit') ? 'bg-emerald-50 text-emerald-500' : 
                                                          tr.type.includes('withdraw') ? 'bg-rose-50 text-rose-500' : 'bg-blue-50 text-blue-500'}`}>
                                                        <i className={`fas ${tr.type.includes('deposit') ? 'fa-arrow-down-to-line' : 
                                                                         tr.type.includes('withdraw') ? 'fa-arrow-up-from-line' : 
                                                                         tr.type.includes('profit') ? 'fa-chart-line' : 'fa-exchange-alt'}`}></i>
                                                    </div>
                                                    <span className="font-extrabold text-slate-700 uppercase text-xs tracking-wider">
                                                        {tr.type.replace('_', ' ')}
                                                    </span>
                                                </div>
                                            </td>
                                            <td className="text-center">
                                                <span className={`font-black text-lg ${tr.amount > 0 ? 'text-emerald-500' : 'text-rose-500'}`}>
                                                    {tr.amount > 0 ? '+' : ''}{Math.abs(tr.amount).toLocaleString('en-US', { style: 'currency', currency: 'USD' })}
                                                </span>
                                            </td>
                                            <td className="max-w-xs">
                                                <p className="text-sm font-bold text-slate-500 truncate" title={tr.description}>
                                                    {tr.description || 'System generated entry'}
                                                </p>
                                            </td>
                                            <td>
                                                <div className="font-bold text-slate-700 text-sm">{new Date(tr.created_at).toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' })}</div>
                                                <div className="text-[10px] font-bold text-slate-400 uppercase">{new Date(tr.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}</div>
                                            </td>
                                            <td className="text-right px-8">
                                                <div className={`badge border-none font-black text-[10px] px-3 py-3 h-auto rounded-lg uppercase tracking-widest
                                                    ${tr.status === 'completed' || tr.status === 'approved' ? 'bg-emerald-100 text-emerald-600' : 
                                                      tr.status === 'pending' ? 'bg-amber-100 text-amber-600' : 'bg-rose-100 text-rose-600'}`}>
                                                    {tr.status}
                                                </div>
                                            </td>
                                        </tr>
                                    ))
                                ) : (
                                    <tr>
                                        <td colSpan="5" className="px-8 py-20 text-center">
                                            <div className="flex flex-col items-center gap-4">
                                                <div className="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center text-slate-200 text-3xl">
                                                    <i className="fas fa-folder-open"></i>
                                                </div>
                                                <p className="font-bold text-slate-400 uppercase tracking-widest text-xs">No transaction records found</p>
                                            </div>
                                        </td>
                                    </tr>
                                )}
                            </tbody>
                        </table>
                    </div>

                    {pagination.last_page > 1 && (
                        <div className="bg-slate-50 p-6 flex justify-center border-t border-slate-100">
                            <div className="join bg-white shadow-sm border border-slate-200 rounded-2xl p-1">
                                <button 
                                    className={`join-item btn btn-ghost btn-sm rounded-xl px-4 ${pagination.current_page === 1 ? 'btn-disabled opacity-30' : ''}`}
                                    onClick={() => handlePageChange(pagination.current_page - 1)}
                                >
                                    <i className="fas fa-chevron-left text-xs"></i>
                                </button>
                                {[...Array(pagination.last_page).keys()].map((p) => (
                                    <button 
                                        key={p + 1} 
                                        className={`join-item btn btn-sm rounded-xl px-4 font-black ${pagination.current_page === p + 1 ? 'btn-primary text-white shadow-lg shadow-primary/20' : 'btn-ghost text-slate-400'}`}
                                        onClick={() => handlePageChange(p + 1)}
                                    >
                                        {p + 1}
                                    </button>
                                ))}
                                <button 
                                    className={`join-item btn btn-ghost btn-sm rounded-xl px-4 ${pagination.current_page === pagination.last_page ? 'btn-disabled opacity-30' : ''}`}
                                    onClick={() => handlePageChange(pagination.current_page + 1)}
                                >
                                    <i className="fas fa-chevron-right text-xs"></i>
                                </button>
                            </div>
                        </div>
                    )}
                </div>
            </div>
        </div>
    );
};

export default TransactionsArea;
