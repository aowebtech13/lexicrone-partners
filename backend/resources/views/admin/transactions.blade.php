@extends('layouts.admin')

@section('title', 'Transaction History')

@section('content')
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-3xl font-black tracking-tight">Transaction History</h1>
        <p class="text-base-content/60 font-medium">Complete financial log of all platform activities</p>
    </div>
    <div class="join shadow-sm bg-base-100 p-1 rounded-2xl">
        <input class="input input-ghost join-item focus:bg-transparent" placeholder="Search transactions..."/>
        <button class="btn btn-primary join-item rounded-xl">Filter</button>
    </div>
</div>

<div class="card bg-base-100 shadow-xl border border-base-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="table table-lg">
            <thead>
                <tr class="bg-base-200/50">
                    <th class="font-bold text-xs uppercase tracking-widest opacity-50">Investor</th>
                    <th class="font-bold text-xs uppercase tracking-widest opacity-50 text-center">Type</th>
                    <th class="font-bold text-xs uppercase tracking-widest opacity-50 text-center">Amount</th>
                    <th class="font-bold text-xs uppercase tracking-widest opacity-50">Description</th>
                    <th class="font-bold text-xs uppercase tracking-widest opacity-50">Status</th>
                    <th class="font-bold text-xs uppercase tracking-widest opacity-50 text-right">Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $transaction)
                <tr class="hover:bg-base-200/30 transition-colors duration-200">
                    <td>
                        <div class="flex items-center gap-3">
                            <div class="avatar">
                                <div class="bg-neutral text-neutral-content rounded-xl w-10 h-10 overflow-hidden flex items-center justify-center">
                                    @if($transaction->user && $transaction->user->avatar_url)
                                        <img src="{{ $transaction->user->avatar_url }}" alt="{{ $transaction->user->name }}" class="object-cover w-full h-full" />
                                    @else
                                        <span class="text-xs font-black uppercase text-white">{{ substr($transaction->user->name ?? 'U', 0, 1) }}</span>
                                    @endif
                                </div>
                            </div>
                            <div>
                                <div class="font-black text-sm">{{ $transaction->user->name ?? 'Deleted User' }}</div>
                                <div class="text-[10px] opacity-50 font-bold uppercase">{{ $transaction->user->email ?? 'N/A' }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="text-center">
                        @php
                            $badgeClass = 'badge-ghost';
                            $typeName = str_replace('_', ' ', $transaction->type);
                            
                            if (strpos($transaction->type, 'deposit') !== false) $badgeClass = 'badge-success text-white';
                            if (strpos($transaction->type, 'withdrawal') !== false) $badgeClass = 'badge-error text-white';
                            if (strpos($transaction->type, 'investment') !== false) $badgeClass = 'badge-info text-white';
                            if (strpos($transaction->type, 'profit') !== false) $badgeClass = 'badge-primary text-white';
                            if (strpos($transaction->type, 'admin_') !== false) $badgeClass = 'badge-secondary text-white';
                        @endphp
                        <span class="badge {{ $badgeClass }} border-none font-bold text-[10px] uppercase px-3 py-2 h-auto tracking-tighter">
                            {{ $typeName }}
                        </span>
                    </td>
                    <td class="text-center">
                        <span class="font-black {{ $transaction->amount >= 0 ? 'text-success' : 'text-error' }}">
                            {{ $transaction->amount >= 0 ? '+' : '' }}{{ number_format($transaction->amount, 2) }}
                        </span>
                    </td>
                    <td class="max-w-xs">
                        <p class="text-xs font-medium opacity-70 truncate" title="{{ $transaction->description }}">
                            {{ $transaction->description }}
                        </p>
                    </td>
                    <td>
                        @if($transaction->status === 'completed' || $transaction->status === 'approved')
                            <div class="flex items-center gap-1.5 text-success">
                                <div class="w-1.5 h-1.5 rounded-full bg-success"></div>
                                <span class="text-[10px] font-black uppercase">Success</span>
                            </div>
                        @elseif($transaction->status === 'pending')
                            <div class="flex items-center gap-1.5 text-warning">
                                <div class="w-1.5 h-1.5 rounded-full bg-warning animate-pulse"></div>
                                <span class="text-[10px] font-black uppercase">Pending</span>
                            </div>
                        @else
                            <div class="flex items-center gap-1.5 text-error">
                                <div class="w-1.5 h-1.5 rounded-full bg-error"></div>
                                <span class="text-[10px] font-black uppercase">{{ $transaction->status }}</span>
                            </div>
                        @endif
                    </td>
                    <td class="text-right">
                        <div class="font-bold text-xs">{{ $transaction->created_at->format('M d, Y') }}</div>
                        <div class="text-[10px] opacity-40 font-bold">{{ $transaction->created_at->format('H:i A') }}</div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="mt-8">
    {{ $transactions->links() }}
</div>
@endsection
