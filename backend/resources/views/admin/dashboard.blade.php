@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <h1 class="text-3xl font-black tracking-tight">Overview</h1>
        <p class="text-base-content/60 font-medium">Welcome back, {{ Auth::user()->name }}</p>
    </div>
    <div class="flex gap-2">
        <button class="btn btn-primary rounded-xl shadow-lg shadow-primary/20">
            <i class="fas fa-plus"></i> New Report
        </button>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <!-- Stat Card 1 -->
    <div class="card bg-base-100 shadow-xl border border-base-200 overflow-hidden">
        <div class="card-body p-6 relative">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-bold text-base-content/50 uppercase tracking-widest">Total Users</p>
                    <h3 class="text-3xl font-black mt-1">{{ number_format($stats['total_users']) }}</h3>
                </div>
                <div class="w-12 h-12 bg-blue-500/10 rounded-2xl flex items-center justify-center text-blue-500">
                    <i class="fas fa-users text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-2 text-sm">
                <span class="badge badge-success badge-sm font-bold text-[10px]">+12%</span>
                <span class="opacity-50 font-medium text-xs">Since last month</span>
            </div>
            <div class="absolute -right-4 -bottom-4 opacity-[0.03] text-8xl -rotate-12">
                <i class="fas fa-users"></i>
            </div>
        </div>
    </div>

    <!-- Stat Card 2 -->
    <div class="card bg-base-100 shadow-xl border border-base-200 overflow-hidden">
        <div class="card-body p-6 relative">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-bold text-base-content/50 uppercase tracking-widest">Investments</p>
                    <h3 class="text-3xl font-black mt-1">{{ number_format($stats['total_investments']) }}</h3>
                </div>
                <div class="w-12 h-12 bg-emerald-500/10 rounded-2xl flex items-center justify-center text-emerald-500">
                    <i class="fas fa-chart-line text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-2 text-sm">
                <span class="badge badge-success badge-sm font-bold text-[10px]">+5.4%</span>
                <span class="opacity-50 font-medium text-xs">Active plans</span>
            </div>
            <div class="absolute -right-4 -bottom-4 opacity-[0.03] text-8xl -rotate-12">
                <i class="fas fa-chart-line"></i>
            </div>
        </div>
    </div>

    <!-- Stat Card 3 -->
    <div class="card bg-base-100 shadow-xl border border-base-200 overflow-hidden">
        <div class="card-body p-6 relative">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-bold text-base-content/50 uppercase tracking-widest">Total Capital</p>
                    <h3 class="text-3xl font-black mt-1">${{ number_format($stats['total_invested_amount'] / 1000, 1) }}k</h3>
                </div>
                <div class="w-12 h-12 bg-indigo-500/10 rounded-2xl flex items-center justify-center text-indigo-500">
                    <i class="fas fa-dollar-sign text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-2 text-sm">
                <span class="opacity-50 font-medium text-xs text-indigo-500 font-bold tracking-tight">Real-time aggregate</span>
            </div>
            <div class="absolute -right-4 -bottom-4 opacity-[0.03] text-8xl -rotate-12">
                <i class="fas fa-dollar-sign"></i>
            </div>
        </div>
    </div>

    <!-- Stat Card 4 -->
    <div class="card bg-base-100 shadow-xl border border-base-200 overflow-hidden">
        <div class="card-body p-6 relative">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-bold text-base-content/50 uppercase tracking-widest">Withdrawals</p>
                    <h3 class="text-3xl font-black mt-1 text-warning">{{ number_format($stats['pending_withdrawals']) }}</h3>
                </div>
                <div class="w-12 h-12 bg-warning/10 rounded-2xl flex items-center justify-center text-warning">
                    <i class="fas fa-clock text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-2 text-sm">
                <span class="opacity-50 font-medium text-xs">Awaiting approval</span>
            </div>
            <div class="absolute -right-4 -bottom-4 opacity-[0.03] text-8xl -rotate-12">
                <i class="fas fa-clock"></i>
            </div>
        </div>
    </div>
</div>

<div class="grid lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 card bg-base-100 shadow-xl border border-base-200">
        <div class="card-body">
            <h3 class="text-xl font-black mb-4">Market Trends</h3>
            <div class="w-full h-80 bg-base-200/50 rounded-3xl flex items-center justify-center border-2 border-dashed border-base-300">
                <p class="text-base-content/30 font-bold uppercase tracking-widest text-sm">Live Charts Interface</p>
            </div>
        </div>
    </div>
    
    <div class="card bg-base-100 shadow-xl border border-base-200">
        <div class="card-body">
            <h3 class="text-xl font-black mb-4">Quick Actions</h3>
            <div class="space-y-3">
                <a href="{{ route('admin.users') }}" class="btn btn-ghost w-full justify-start gap-4 rounded-2xl hover:bg-primary hover:text-primary-content transition-all duration-300">
                    <div class="w-10 h-10 bg-base-200 rounded-xl flex items-center justify-center text-lg"><i class="fas fa-user-plus"></i></div>
                    <span class="font-bold">Manage Users</span>
                </a>
                <a href="{{ route('admin.withdrawals') }}" class="btn btn-ghost w-full justify-start gap-4 rounded-2xl hover:bg-warning hover:text-warning-content transition-all duration-300">
                    <div class="w-10 h-10 bg-base-200 rounded-xl flex items-center justify-center text-lg"><i class="fas fa-money-check-dollar"></i></div>
                    <span class="font-bold text-warning">Process Payouts</span>
                </a>
                <a href="{{ route('admin.investments') }}" class="btn btn-ghost w-full justify-start gap-4 rounded-2xl hover:bg-secondary hover:text-secondary-content transition-all duration-300">
                    <div class="w-10 h-10 bg-base-200 rounded-xl flex items-center justify-center text-lg"><i class="fas fa-gear"></i></div>
                    <span class="font-bold">Investment Logs</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
