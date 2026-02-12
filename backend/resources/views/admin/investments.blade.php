@extends('layouts.admin')

@section('title', 'Investment Logs')

@section('content')
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-3xl font-black tracking-tight">Investments</h1>
        <p class="text-base-content/60 font-medium">Monitor active and historical investment plans</p>
    </div>
</div>

<div class="card bg-base-100 shadow-xl border border-base-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="table table-lg">
            <thead>
                <tr class="bg-base-200/50">
                    <th class="font-bold text-xs uppercase tracking-widest opacity-50">Investor</th>
                    <th class="font-bold text-xs uppercase tracking-widest opacity-50">Plan Info</th>
                    <th class="font-bold text-xs uppercase tracking-widest opacity-50 text-center">ROI / Profit</th>
                    <th class="font-bold text-xs uppercase tracking-widest opacity-50">Timeline</th>
                    <th class="font-bold text-xs uppercase tracking-widest opacity-50">Status</th>
                    <th class="font-bold text-xs uppercase tracking-widest opacity-50 text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($investments as $investment)
                <tr class="hover:bg-base-200/30 transition-colors duration-200">
                    <td>
                        <div class="font-black">{{ $investment->user->name }}</div>
                        <div class="text-xs opacity-50">{{ $investment->user->email }}</div>
                    </td>
                    <td>
                        <div class="badge badge-outline badge-md font-bold mb-1">{{ $investment->plan->name }}</div>
                        <div class="font-black text-primary">${{ number_format($investment->amount, 2) }}</div>
                    </td>
                    <td class="text-center">
                        <div class="font-black text-success">+${{ number_format($investment->profit, 2) }}</div>
                        <div class="text-[10px] uppercase font-bold opacity-40">Accrued profit</div>
                    </td>
                    <td>
                        <div class="text-xs font-bold opacity-60">Expires:</div>
                        <div class="font-black">{{ date('M d, Y', strtotime($investment->end_date)) }}</div>
                    </td>
                    <td>
                        @php
                            $statusColor = [
                                'active' => 'success',
                                'completed' => 'primary',
                                'cancelled' => 'error'
                            ][$investment->status] ?? 'neutral';
                        @endphp
                        <span class="badge badge-{{ $statusColor }} badge-sm font-black uppercase text-[10px] p-2 px-3">{{ $investment->status }}</span>
                    </td>
                    <td class="text-right">
                        @if($investment->status === 'active')
                        <div class="flex justify-end gap-2">
                            <button class="btn btn-square btn-ghost btn-sm text-info" onclick="extend_modal_{{ $investment->id }}.showModal()">
                                <i class="fas fa-calendar-plus"></i>
                            </button>
                            <form action="{{ route('admin.investments.cancel', $investment->id) }}" method="POST" onsubmit="return confirm('Refund and cancel this investment?')">
                                @csrf
                                <button class="btn btn-square btn-ghost btn-sm text-error">
                                    <i class="fas fa-ban"></i>
                                </button>
                            </form>
                        </div>

                        <!-- Extend Modal -->
                        <dialog id="extend_modal_{{ $investment->id }}" class="modal">
                            <div class="modal-box rounded-3xl p-8">
                                <h3 class="font-black text-2xl mb-4">Extend Investment</h3>
                                <p class="text-base-content/60 mb-6 font-medium">Modify the maturity date for this investment plan.</p>
                                <form action="{{ route('admin.investments.extend', $investment->id) }}" method="POST">
                                    @csrf
                                    <div class="form-control mb-6">
                                        <label class="label"><span class="label-text font-bold">New End Date</span></label>
                                        <input type="date" name="end_date" class="input input-bordered rounded-2xl font-bold" value="{{ date('Y-m-d', strtotime($investment->end_date)) }}" required>
                                    </div>
                                    <div class="modal-action">
                                        <button type="submit" class="btn btn-primary rounded-xl px-8">Save Extension</button>
                                        <button type="button" class="btn btn-ghost rounded-xl" onclick="this.closest('dialog').close()">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </dialog>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
