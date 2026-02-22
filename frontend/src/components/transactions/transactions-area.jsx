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
        <div className="pb-120 bg-slate-50 min-h-screen">
            <div className="container max-w-6xl mx-auto px-4">
                <div className="bg-white rounded-[2rem] shadow-xl shadow-slate-200/60 overflow-hidden border border-slate-100">
                    <div className="p-8 border-b border-slate-100 flex justify-between items-center">
                        <div>
                            <h3 className="text-2xl font-black text-slate-900 tracking-tight">Financial Ledger</h3>
                            <p className="text-slate-500 font-medium text-sm">Detailed history of all your platform transactions.</p>
                        </div>
                        <div className="bg-slate-50 px-4 py-2 rounded-2xl border border-slate-100">
                            <span className="text-xs font-black text-slate-400 uppercase tracking-widest">Total Records: </span>
                            <span className="text-sm font-black text-slate-900">{pagination.total}</span>
                        </div>
                    </div>
                    <div className="overflow-x-auto">
                        <table className="table table-lg w-full">
                            <thead>
                                <tr className="bg-slate-50/50">
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
                                        <tr key={tr.id} className="hover:bg-slate-50/50 transition-all group border-b border-slate-50 last:border-none">
                                            <td className="px-8 py-6">
                                                <div className="flex items-center gap-4">
                                                    <div className={`w-12 h-12 rounded-2xl flex items-center justify-center shadow-sm transition-transform group-hover:scale-110
                                                        ${tr.type.includes('deposit') || tr.type.includes('profit') ? 'bg-emerald-50 text-emerald-500' : 
                                                          tr.type.includes('withdraw') ? 'bg-rose-50 text-rose-500' : 'bg-blue-50 text-blue-500'}`}>
                                                        <i className={`fas text-base ${tr.type.includes('deposit') ? 'fa-arrow-down-to-line' : 
                                                                         tr.type.includes('withdraw') ? 'fa-arrow-up-from-line' : 
                                                                         tr.type.includes('profit') ? 'fa-chart-line' : 'fa-exchange-alt'}`}></i>
                                                    </div>
                                                    <div>
                                                        <span className="font-black text-slate-900 uppercase text-xs tracking-wider block mb-0.5">
                                                            {tr.type.replace('_', ' ')}
                                                        </span>
                                                        <span className="text-[10px] font-bold text-slate-400 uppercase tracking-tight">ID: #{tr.id.toString().padStart(6, '0')}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td className="text-center">
                                                <span className={`font-black text-xl tracking-tight ${tr.amount > 0 ? 'text-emerald-500' : 'text-rose-500'}`}>
                                                    {tr.amount > 0 ? '+' : ''}{Math.abs(tr.amount).toLocaleString('en-US', { style: 'currency', currency: 'USD' })}
                                                </span>
                                            </td>
                                            <td className="max-w-xs">
                                                <p className="text-sm font-bold text-slate-600 leading-relaxed" title={tr.description}>
                                                    {tr.description || 'System generated entry'}
                                                </p>
                                            </td>
                                            <td>
                                                <div className="font-black text-slate-900 text-sm mb-0.5">{new Date(tr.created_at).toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' })}</div>
                                                <div className="text-[10px] font-black text-slate-400 uppercase tracking-widest">{new Date(tr.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}</div>
                                            </td>
                                            <td className="text-right px-8">
                                                <div className={`badge border-2 font-black text-[10px] px-4 py-3.5 h-auto rounded-xl uppercase tracking-widest
                                                    ${tr.status === 'completed' || tr.status === 'approved' ? 'bg-emerald-50 border-emerald-100 text-emerald-600' : 
                                                      tr.status === 'pending' ? 'bg-amber-50 border-amber-100 text-amber-600' : 'bg-rose-50 border-rose-100 text-rose-600'}`}>
                                                    <span className="w-1.5 h-1.5 rounded-full mr-2 animate-pulse bg-current"></span>
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
                        <div className="bg-slate-50/50 p-8 flex justify-center border-t border-slate-100">
                            <div className="join bg-white shadow-xl shadow-slate-200/20 border border-slate-100 rounded-2xl p-1.5">
                                <button 
                                    className={`join-item btn btn-ghost btn-md rounded-xl px-5 ${pagination.current_page === 1 ? 'btn-disabled opacity-20' : 'hover:bg-slate-50'}`}
                                    onClick={() => handlePageChange(pagination.current_page - 1)}
                                >
                                    <i className="fas fa-chevron-left text-xs text-slate-400"></i>
                                </button>
                                {[...Array(pagination.last_page).keys()].map((p) => (
                                    <button 
                                        key={p + 1} 
                                        className={`join-item btn btn-md rounded-xl px-5 font-black transition-all ${pagination.current_page === p + 1 ? 'bg-slate-900 text-white shadow-lg shadow-slate-900/20 hover:bg-slate-800' : 'btn-ghost text-slate-400 hover:bg-slate-50'}`}
                                        onClick={() => handlePageChange(p + 1)}
                                    >
                                        {p + 1}
                                    </button>
                                ))}
                                <button 
                                    className={`join-item btn btn-ghost btn-md rounded-xl px-5 ${pagination.current_page === pagination.last_page ? 'btn-disabled opacity-20' : 'hover:bg-slate-50'}`}
                                    onClick={() => handlePageChange(pagination.current_page + 1)}
                                >
                                    <i className="fas fa-chevron-right text-xs text-slate-400"></i>
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
