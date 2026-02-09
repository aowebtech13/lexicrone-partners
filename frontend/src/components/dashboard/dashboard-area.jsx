import React, { useEffect, useState } from 'react';
import { useAuth } from '@/src/context/AuthContext';
import api from '@/src/utils/api';

const TradingViewWidget = () => {
    useEffect(() => {
        const script = document.createElement('script');
        script.src = 'https://s3.tradingview.com/external-embedding/embed-widget-market-overview.js';
        script.async = true;
        script.innerHTML = JSON.stringify({
            "showChart": true,
            "locale": "en",
            "width": "100%",
            "height": "400",
            "largeChartUrl": "",
            "plotLineColorGrowing": "rgba(41, 98, 255, 1)",
            "plotLineColorFalling": "rgba(41, 98, 255, 1)",
            "gridLineColor": "rgba(240, 243, 250, 0)",
            "scaleFontColor": "rgba(106, 109, 120, 1)",
            "belowLineFillColorGrowing": "rgba(41, 98, 255, 0.12)",
            "belowLineFillColorFalling": "rgba(41, 98, 255, 0.12)",
            "belowLineFillColorGrowingBottom": "rgba(41, 98, 255, 0)",
            "belowLineFillColorFallingBottom": "rgba(41, 98, 255, 0)",
            "symbolActiveHandleBorderColor": "rgba(41, 98, 255, 1)",
            "tabs": [
                {
                    "title": "Forex",
                    "symbols": [
                        { "s": "FX:EURUSD", "d": "EUR/USD" },
                        { "s": "FX:GBPUSD", "d": "GBP/USD" },
                        { "s": "FX:USDJPY", "d": "USD/JPY" },
                        { "s": "FX:AUDUSD", "d": "AUD/USD" },
                        { "s": "FX:USDCAD", "d": "USD/CAD" }
                    ]
                }
            ]
        });
        const container = document.getElementById('tradingview-widget-container');
        if (container) container.appendChild(script);
    }, []);

    return (
        <div id="tradingview-widget-container" className="mb-40">
            <div className="tradingview-widget-container__widget"></div>
        </div>
    );
};

const DashboardArea = () => {
    const { user } = useAuth();
    const [dashboardData, setDashboardData] = useState(null);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        const fetchDashboardData = async () => {
            try {
                const { data } = await api.get('dashboard-data');
                setDashboardData(data);
            } catch (error) {
                console.error("Error fetching dashboard data:", error);
            } finally {
                setLoading(false);
            }
        };
        fetchDashboardData();
    }, []);

    if (loading) return <div>Loading dashboard...</div>;

    const stats = [
        { id: 1, title: 'Total Balance', value: `$${dashboardData?.stats?.balance || '0.00'}`, icon: 'fa-wallet' },
        { id: 2, title: 'Active Investments', value: `${dashboardData?.stats?.active_investments_count || 0}`, icon: 'fa-chart-line' },
        { id: 3, title: 'Total Profit', value: `$${dashboardData?.stats?.total_profit || '0.00'}`, icon: 'fa-arrow-up-right-dots' },
        { id: 4, title: 'Total Invested', value: `$${dashboardData?.stats?.total_invested || '0.00'}`, icon: 'fa-clock' },
    ];

    const transactions = dashboardData?.recent_transactions || [];

    return (
        <>
            <div className="dashboard-area pt-120 pb-120">
                <div className="container">
                    <div className="row">
                        <div className="col-12">
                            <div className="section-title-wrapper mb-40">
                                <h3 className="section-title">Welcome Back, {user?.name || 'User'}</h3>
                                <p>Here's what's happening with your finance today.</p>
                            </div>
                        </div>
                    </div>

                    <div className="row">
                        <div className="col-12">
                            <TradingViewWidget />
                        </div>
                    </div>

                    <div className="row">
                        {stats.map((item) => (
                            <div key={item.id} className="col-xl-3 col-lg-6 col-md-6 mb-30">
                                <div className="tp-dashboard-card p-relative z-index-1">
                                    <div className="tp-dashboard-card-icon mb-20">
                                        <i className={`fal ${item.icon}`}></i>
                                    </div>
                                    <div className="tp-dashboard-card-content">
                                        <h4 className="tp-dashboard-card-title">{item.title}</h4>
                                        <div className="tp-dashboard-card-value">{item.value}</div>
                                    </div>
                                </div>
                            </div>
                        ))}
                    </div>

                    <div className="row mt-40">
                        <div className="col-xl-8 col-lg-12">
                            <div className="tp-dashboard-widget">
                                <div className="tp-dashboard-widget-header d-flex align-items-center justify-content-between mb-30">
                                    <h4 className="tp-dashboard-widget-title">Recent Transactions</h4>
                                    <button className="tp-btn-inner">View All</button>
                                </div>
                                <div className="tp-dashboard-table table-responsive">
                                    <table className="table">
                                        <thead>
                                            <tr>
                                                <th>Type</th>
                                                <th>Amount</th>
                                                <th>Date</th>
                                                <th>Method</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {transactions.map((tr) => (
                                                <tr key={tr.id}>
                                                    <td>{tr.type}</td>
                                                    <td>${Math.abs(tr.amount)}</td>
                                                    <td>{new Date(tr.created_at).toLocaleDateString()}</td>
                                                    <td>{tr.method || 'System'}</td>
                                                    <td>
                                                        <span className={`badge ${tr.status === 'completed' ? 'bg-success' : 'bg-warning'}`}>
                                                            {tr.status}
                                                        </span>
                                                    </td>
                                                </tr>
                                            ))}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div className="col-xl-4 col-lg-12">
                            <div className="tp-dashboard-widget">
                                <h4 className="tp-dashboard-widget-title mb-30">Quick Actions</h4>
                                <div className="tp-dashboard-actions d-grid gap-3">
                                    <button className="tp-btn w-100">Deposit Funds</button>
                                    <button className="tp-btn-blue w-100">Withdraw Funds</button>
                                    <button className="tp-btn-inner w-100">Contact Support</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <style jsx>{`
                .tp-dashboard-card {
                    background: #fff;
                    border-radius: 12px;
                    padding: 30px;
                    box-shadow: 0 4px 20px rgba(0,0,0,0.05);
                    transition: all 0.3s ease;
                }
                .tp-dashboard-card:hover {
                    transform: translateY(-5px);
                }
                .tp-dashboard-card-icon {
                    width: 50px;
                    height: 50px;
                    background: #f0f7ff;
                    border-radius: 10px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    color: #007bff;
                    font-size: 20px;
                }
                .tp-dashboard-card-title {
                    font-size: 16px;
                    font-weight: 500;
                    color: #6c757d;
                    margin-bottom: 10px;
                }
                .tp-dashboard-card-value {
                    font-size: 24px;
                    font-weight: 700;
                    color: #212529;
                    margin-bottom: 5px;
                }
                .tp-dashboard-card-change {
                    font-size: 13px;
                    color: #6c757d;
                }
                .tp-dashboard-widget {
                    background: #fff;
                    border-radius: 12px;
                    padding: 30px;
                    box-shadow: 0 4px 20px rgba(0,0,0,0.05);
                    height: 100%;
                }
                .tp-dashboard-widget-title {
                    font-size: 20px;
                    font-weight: 600;
                }
                .tp-dashboard-table .table {
                    margin-bottom: 0;
                }
                .tp-dashboard-table th {
                    border-top: none;
                    font-weight: 500;
                    color: #6c757d;
                }
            `}</style>
        </>
    );
};

export default DashboardArea;
