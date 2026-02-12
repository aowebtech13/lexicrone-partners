@extends('layouts.admin')

@section('title', 'Payout Requests')

@section('content')
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-3xl font-black tracking-tight">Withdrawals</h1>
        <p class="text-base-content/60 font-medium">Review and process user payout requests</p>
    </div>
</div>

<div class="card bg-base-100 shadow-xl border border-base-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="table table-lg">
            <thead>
                <tr class="bg-base-200/50">
                    <th class="font-bold text-xs uppercase tracking-widest opacity-50">User</th>
                    <th class="font-bold text-xs uppercase tracking-widest opacity-50">Amount</th>
                    <th class="font-bold text-xs uppercase tracking-widest opacity-50">Method</th>
                    <th class="font-bold text-xs uppercase tracking-widest opacity-50">Status</th>
                    <th class="font-bold text-xs uppercase tracking-widest opacity-50">Date</th>
                    <th class="font-bold text-xs uppercase tracking-widest opacity-50 text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($withdrawals as $withdrawal)
                <tr class="hover:bg-base-200/30 transition-colors duration-200">
                    <td>
                        <div class="flex items-center gap-3">
                            <div class="avatar">
                                <div class="bg-neutral text-neutral-content rounded-xl w-10 h-10 overflow-hidden flex items-center justify-center">
                                    @if($withdrawal->user->avatar_url)
                                        <img src="{{ $withdrawal->user->avatar_url }}" alt="{{ $withdrawal->user->name }}" class="object-cover w-full h-full" />
                                    @else
                                        <span class="text-xs font-black uppercase text-white">{{ substr($withdrawal->user->name ?? 'U', 0, 1) }}</span>
                                    @endif
                                </div>
                            </div>
                            <div>
                                <div class="font-black">{{ $withdrawal->user->name }}</div>
                                <div class="text-[10px] bg-base-200 p-1 px-2 rounded-lg font-bold truncate max-w-[150px]">{{ $withdrawal->details }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="font-black text-error text-lg">${{ number_format($withdrawal->amount, 2) }}</div>
                    </td>
                    <td>
                        <span class="badge badge-ghost font-bold text-[10px] uppercase">{{ $withdrawal->method }}</span>
                    </td>
                    <td>
                        @php
                            $statusColor = [
                                'approved' => 'success',
                                'pending' => 'warning',
                                'rejected' => 'error'
                            ][$withdrawal->status] ?? 'neutral';
                        @endphp
                        <span class="badge badge-{{ $statusColor }} badge-sm font-black uppercase text-[10px] p-2 px-3">{{ $withdrawal->status }}</span>
                    </td>
                    <td>
                        <div class="font-bold text-sm">{{ $withdrawal->created_at->format('M d, Y') }}</div>
                    </td>
                    <td class="text-right">
                        @if($withdrawal->status === 'pending')
                        <div class="flex justify-end gap-2">
                            <form action="{{ route('admin.withdrawals.update', $withdrawal->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="approved">
                                <button class="btn btn-success btn-sm rounded-xl px-4 font-black text-[10px]">Approve</button>
                            </form>
                            <button class="btn btn-error btn-outline btn-sm rounded-xl px-4 font-black text-[10px]" onclick="reject_modal_{{ $withdrawal->id }}.showModal()">Reject</button>
                        </div>

                        <!-- Reject Modal -->
                        <dialog id="reject_modal_{{ $withdrawal->id }}" class="modal">
                            <div class="modal-box rounded-3xl p-8 text-left">
                                <h3 class="font-black text-2xl mb-2 text-error">Reject Withdrawal</h3>
                                <p class="text-base-content/60 mb-6 font-medium text-sm">Please provide a reason for rejecting this payout request.</p>
                                <form action="{{ route('admin.withdrawals.update', $withdrawal->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="status" value="rejected">
                                    <div class="form-control mb-6">
                                        <textarea name="rejection_reason" class="textarea textarea-bordered rounded-2xl h-32 font-medium focus:border-error" placeholder="e.g. Invalid wallet address or insufficient verification..." required></textarea>
                                    </div>
                                    <div class="modal-action">
                                        <button type="submit" class="btn btn-error rounded-xl px-8 text-white font-black">Confirm Rejection</button>
                                        <button type="button" class="btn btn-ghost rounded-xl font-bold" onclick="this.closest('dialog').close()">Cancel</button>
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
