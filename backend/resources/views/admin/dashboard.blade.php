@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <h1 class="text-4xl font-extrabold tracking-tight text-slate-900">Dashboard</h1>
        <p class="text-slate-500 font-medium mt-1">Global platform performance and investor overview</p>
    </div>
    <div class="flex gap-3">
        <button class="btn bg-white border-slate-200 text-slate-700 hover:bg-slate-50 rounded-2xl shadow-sm px-6 font-bold">
            <i class="fas fa-download mr-2 text-primary"></i> Export Report
        </button>
        <a href="{{ route('admin.transactions') }}" class="btn btn-primary rounded-2xl shadow-lg shadow-primary/20 px-6 font-bold">
            <i class="fas fa-plus mr-2"></i> Audit Logs
        </a>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mt-4">
    <!-- Total Users -->
    <div class="card bg-white p-8 rounded-3xl relative overflow-hidden group">
        <div class="absolute top-0 right-0 w-32 h-32 bg-primary/5 rounded-bl-[100px] -mr-10 -mt-10 group-hover:bg-primary/10 transition-all duration-500"></div>
        <div class="relative z-10 flex flex-col gap-6">
            <div class="w-14 h-14 bg-primary/10 rounded-2xl flex items-center justify-center text-primary shadow-inner">
                <i class="fas fa-user-group text-2xl"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-[0.1em]">Total Investors</p>
                <h3 class="text-4xl font-black text-slate-900 mt-2">{{ number_format($stats['total_users']) }}</h3>
            </div>
            <div class="flex items-center gap-2">
                <span class="flex items-center gap-1 text-[10px] font-black text-emerald-500 bg-emerald-50 px-2 py-1 rounded-lg">
                    <i class="fas fa-arrow-up"></i> 12%
                </span>
                <span class="text-[10px] font-bold text-slate-400">vs last month</span>
            </div>
        </div>
    </div>

    <!-- Active Investments -->
    <div class="card bg-white p-8 rounded-3xl relative overflow-hidden group">
        <div class="absolute top-0 right-0 w-32 h-32 bg-secondary/5 rounded-bl-[100px] -mr-10 -mt-10 group-hover:bg-secondary/10 transition-all duration-500"></div>
        <div class="relative z-10 flex flex-col gap-6">
            <div class="w-14 h-14 bg-secondary/10 rounded-2xl flex items-center justify-center text-secondary shadow-inner">
                <i class="fas fa-chart-pie-simple text-2xl"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-[0.1em]">Active Plans</p>
                <h3 class="text-4xl font-black text-slate-900 mt-2">{{ number_format($stats['total_investments']) }}</h3>
            </div>
            <div class="flex items-center gap-2">
                <span class="flex items-center gap-1 text-[10px] font-black text-emerald-500 bg-emerald-50 px-2 py-1 rounded-lg">
                    <i class="fas fa-circle-check"></i> Healthy
                </span>
            </div>
        </div>
    </div>

    <!-- Total Invested -->
    <div class="card bg-white p-8 rounded-3xl relative overflow-hidden group border-l-4 border-primary">
        <div class="absolute top-0 right-0 w-32 h-32 bg-primary/5 rounded-bl-[100px] -mr-10 -mt-10 group-hover:bg-primary/10 transition-all duration-500"></div>
        <div class="relative z-10 flex flex-col gap-6">
            <div class="w-14 h-14 bg-primary text-white rounded-2xl flex items-center justify-center shadow-lg shadow-primary/30">
                <i class="fas fa-vault text-2xl"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-[0.1em]">Assets Managed</p>
                <h3 class="text-4xl font-black text-slate-900 mt-2">${{ number_format($stats['total_invested_amount'], 0) }}</h3>
            </div>
            <div class="flex items-center gap-2 text-primary font-bold text-[10px] uppercase tracking-wider">
                Total aggregate capital
            </div>
        </div>
    </div>

    <!-- Pending Withdrawals -->
    <div class="card bg-slate-900 p-8 rounded-3xl relative overflow-hidden group">
        <div class="absolute top-0 right-0 w-40 h-40 bg-white/5 rounded-bl-full -mr-12 -mt-12 group-hover:bg-white/10 transition-all duration-500"></div>
        <div class="relative z-10 flex flex-col gap-6">
            <div class="w-14 h-14 bg-white/10 rounded-2xl flex items-center justify-center text-warning shadow-xl">
                <i class="fas fa-clock-rotate-left text-2xl animate-spin-slow"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-[0.1em]">Pending Payouts</p>
                <h3 class="text-4xl font-black text-white mt-2">{{ number_format($stats['pending_withdrawals']) }}</h3>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.withdrawals') }}" class="text-[10px] font-black text-warning bg-warning/10 px-3 py-1.5 rounded-xl border border-warning/20 hover:bg-warning hover:text-slate-900 transition-all">
                    ACTION REQUIRED
                </a>
            </div>
        </div>
    </div>
</div>

<div class="grid lg:grid-cols-3 gap-8 mt-8">
    <div class="lg:col-span-2 space-y-8">
        <div class="card bg-white p-8 rounded-3xl">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h3 class="text-xl font-extrabold text-slate-900">Capital Flow</h3>
                    <p class="text-sm text-slate-500 font-medium">Monthly investment vs Withdrawal data</p>
                </div>
                <div class="flex bg-slate-100 p-1 rounded-xl">
                    <button class="px-4 py-1.5 text-xs font-bold bg-white text-primary rounded-lg shadow-sm">Daily</button>
                    <button class="px-4 py-1.5 text-xs font-bold text-slate-500">Weekly</button>
                    <button class="px-4 py-1.5 text-xs font-bold text-slate-500">Monthly</button>
                </div>
            </div>
            <div class="w-full h-80 bg-slate-50 rounded-3xl flex items-center justify-center border-2 border-dashed border-slate-200 relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-t from-primary/5 to-transparent"></div>
                <div class="relative z-10 text-center">
                    <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center text-slate-300 mx-auto mb-4 shadow-sm">
                        <i class="fas fa-chart-column text-3xl"></i>
                    </div>
                    <p class="text-slate-400 font-black uppercase tracking-[0.2em] text-xs">Analytics Interface</p>
                    <p class="text-[10px] text-slate-300 font-bold mt-1 uppercase">Integrating live data feed...</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="space-y-8">
        <div class="card bg-white p-8 rounded-3xl">
            <h3 class="text-xl font-extrabold text-slate-900 mb-6">Quick Hub</h3>
            <div class="flex flex-col gap-4">
                <a href="{{ route('admin.users') }}" class="group flex items-center gap-4 p-4 bg-slate-50 rounded-2xl hover:bg-primary transition-all duration-300">
                    <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center text-primary shadow-sm group-hover:scale-90 transition-transform">
                        <i class="fas fa-user-plus text-xl"></i>
                    </div>
                    <div class="flex-1">
                        <p class="font-bold text-slate-900 group-hover:text-white">Verify Users</p>
                        <p class="text-[10px] font-medium text-slate-400 group-hover:text-white/60 uppercase">Manage registrations</p>
                    </div>
                    <i class="fas fa-chevron-right text-slate-300 group-hover:text-white group-hover:translate-x-1 transition-all"></i>
                </a>
                
                <a href="{{ route('admin.withdrawals') }}" class="group flex items-center gap-4 p-4 bg-slate-50 rounded-2xl hover:bg-warning transition-all duration-300">
                    <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center text-warning shadow-sm group-hover:scale-90 transition-transform">
                        <i class="fas fa-money-bill-check text-xl"></i>
                    </div>
                    <div class="flex-1">
                        <p class="font-bold text-slate-900 group-hover:text-slate-900">Approve Payouts</p>
                        <p class="text-[10px] font-medium text-slate-400 group-hover:text-slate-900/60 uppercase">Processing queue</p>
                    </div>
                    <i class="fas fa-chevron-right text-slate-300 group-hover:text-slate-900 group-hover:translate-x-1 transition-all"></i>
                </a>

                <a href="{{ route('admin.transactions') }}" class="group flex items-center gap-4 p-4 bg-slate-50 rounded-2xl hover:bg-secondary transition-all duration-300">
                    <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center text-secondary shadow-sm group-hover:scale-90 transition-transform">
                        <i class="fas fa-receipt text-xl"></i>
                    </div>
                    <div class="flex-1">
                        <p class="font-bold text-slate-900 group-hover:text-white">System Audit</p>
                        <p class="text-[10px] font-medium text-slate-400 group-hover:text-white/60 uppercase">Transaction logs</p>
                    </div>
                    <i class="fas fa-chevron-right text-slate-300 group-hover:text-white group-hover:translate-x-1 transition-all"></i>
                </a>
            </div>
        </div>

        <div class="card bg-gradient-to-br from-primary to-secondary p-8 rounded-3xl text-white shadow-2xl shadow-primary/20 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16 blur-3xl"></div>
            <div class="relative z-10">
                <p class="text-[10px] font-black uppercase tracking-widest opacity-80">Security Status</p>
                <h4 class="text-lg font-black mt-1">Advanced Protection</h4>
                <div class="flex items-center gap-2 mt-4 text-xs font-bold bg-white/20 w-fit px-3 py-1.5 rounded-lg border border-white/20">
                    <div class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></div>
                    System Encryption Active
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
