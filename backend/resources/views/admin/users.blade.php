@extends('layouts.admin')

@section('title', 'User Management')

@section('content')
<div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
    <div>
        <h1 class="text-4xl font-extrabold tracking-tight text-slate-900">Investors</h1>
        <p class="text-slate-500 font-medium mt-1">Manage and monitor registered platform members</p>
    </div>
    <div class="flex bg-white p-2 rounded-2xl shadow-sm border border-slate-200 w-full md:w-96">
        <i class="fas fa-search self-center px-4 text-slate-400"></i>
        <input class="bg-transparent border-none focus:ring-0 w-full font-bold text-slate-700 placeholder:text-slate-400" placeholder="Search by name or email..."/>
    </div>
</div>

<div class="card bg-white shadow-xl shadow-slate-200/50 rounded-[2rem] border-none overflow-hidden mt-8">
    <div class="overflow-x-auto">
        <table class="table table-lg">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100">
                    <th class="font-black text-[10px] uppercase tracking-[0.2em] text-slate-400 py-6 px-8">Member</th>
                    <th class="font-black text-[10px] uppercase tracking-[0.2em] text-slate-400 text-center">Portfolio Balance</th>
                    <th class="font-black text-[10px] uppercase tracking-[0.2em] text-slate-400 text-center">Payout Status</th>
                    <th class="font-black text-[10px] uppercase tracking-[0.2em] text-slate-400">Joined Date</th>
                    <th class="font-black text-[10px] uppercase tracking-[0.2em] text-slate-400 text-right px-8">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($users as $user)
                <tr class="hover:bg-slate-50/50 transition-all group">
                    <td class="px-8 py-6">
                        <div class="flex items-center gap-4">
                            <div class="avatar">
                                <div class="rounded-2xl w-14 h-14 shadow-lg shadow-primary/20 bg-slate-100 flex items-center justify-center">
                                    @if($user->avatar_url)
                                        <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="object-cover" />
                                    @else
                                        <div class="bg-gradient-to-br from-primary to-secondary text-white w-full h-full flex items-center justify-center">
                                            <span class="text-xl font-black">{{ substr($user->name, 0, 1) }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div>
                                <div class="font-extrabold text-slate-900 text-lg">{{ $user->name }}</div>
                                <div class="text-xs font-bold text-slate-400 group-hover:text-primary transition-colors">{{ $user->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="text-center">
                        <div class="inline-flex flex-col">
                            <span class="font-black text-xl text-slate-900">${{ number_format($user->balance, 2) }}</span>
                            <span class="text-[10px] font-bold text-emerald-500 uppercase tracking-widest mt-1">Available Capital</span>
                        </div>
                    </td>
                    <td class="text-center">
                        @if($user->withdrawal_date)
                            <div class="badge bg-blue-50 text-blue-600 border-none font-black text-[10px] px-3 py-3 h-auto rounded-lg">
                                <i class="fas fa-calendar-check mr-2"></i> {{ date('M d, Y', strtotime($user->withdrawal_date)) }}
                            </div>
                        @else
                            <div class="badge bg-slate-100 text-slate-400 border-none font-black text-[10px] px-3 py-3 h-auto rounded-lg">
                                <i class="fas fa-clock mr-2"></i> UNSCHEDULED
                            </div>
                        @endif
                    </td>
                    <td>
                        <div class="font-bold text-slate-700">{{ $user->created_at->format('M d, Y') }}</div>
                        <div class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">{{ $user->created_at->diffForHumans() }}</div>
                    </td>
                    <td class="text-right px-8">
                        <div class="dropdown dropdown-left">
                            <button tabindex="0" class="btn btn-ghost btn-circle hover:bg-white hover:shadow-md border-none">
                                <i class="fas fa-ellipsis-h text-slate-400"></i>
                            </button>
                            <ul tabindex="0" class="dropdown-content z-[20] menu p-3 shadow-2xl bg-white rounded-2xl w-56 border border-slate-100 mt-2">
                                <li><a onclick="edit_modal_{{ $user->id }}.showModal()" class="py-3 px-4 rounded-xl hover:bg-slate-50 font-bold text-slate-600"><i class="fas fa-pen-to-square text-primary w-5"></i> Profile Settings</a></li>
                                <li><a onclick="fund_modal_{{ $user->id }}.showModal()" class="py-3 px-4 rounded-xl hover:bg-slate-50 font-bold text-slate-600"><i class="fas fa-wallet text-emerald-500 w-5"></i> Capital Adjustment</a></li>
                                <div class="divider my-1 opacity-50"></div>
                                <li>
                                    <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" onsubmit="return confirm('Permanently remove this investor from the system?')" class="w-full">
                                        @csrf
                                        @method('DELETE')
                                        <button class="py-3 px-4 rounded-xl hover:bg-error/10 text-error font-bold w-full text-left flex items-center gap-3">
                                            <i class="fas fa-user-slash w-5"></i> Terminate Account
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>

                        <!-- Edit Modal -->
                        <dialog id="edit_modal_{{ $user->id }}" class="modal backdrop-blur-sm">
                            <div class="modal-box rounded-[2.5rem] p-10 max-w-2xl border-none shadow-2xl overflow-visible relative">
                                <div class="absolute -top-6 -left-6 w-24 h-24 bg-primary/10 rounded-full blur-3xl"></div>
                                <h3 class="font-black text-3xl text-slate-900 mb-2">Member Profile</h3>
                                <p class="text-slate-500 font-medium mb-8">Synchronize account identity and withdrawal schedules.</p>
                                
                                <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                                    @csrf
                                    <div class="flex flex-col items-center mb-6">
                                        <div class="avatar mb-4">
                                            <div class="rounded-2xl w-24 h-24 shadow-lg shadow-primary/20 bg-slate-100 flex items-center justify-center overflow-hidden">
                                                @if($user->avatar_url)
                                                    <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="object-cover w-full h-full" />
                                                @else
                                                    <div class="bg-gradient-to-br from-primary to-secondary text-white w-full h-full flex items-center justify-center">
                                                        <span class="text-3xl font-black">{{ substr($user->name, 0, 1) }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-control w-full max-w-xs">
                                            <label class="label justify-center">
                                                <span class="label-text font-black text-slate-400 uppercase text-[10px] tracking-widest text-center">Update Avatar</span>
                                            </label>
                                            <input type="file" name="avatar" class="file-input file-input-bordered file-input-primary w-full rounded-2xl h-12 text-sm" accept="image/*" />
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div class="form-control">
                                            <label class="label"><span class="label-text font-black text-slate-400 uppercase text-[10px] tracking-widest">Full Identity</span></label>
                                            <input type="text" name="name" class="input input-bordered rounded-2xl font-bold bg-slate-50 border-slate-100 focus:bg-white transition-all h-14" value="{{ $user->name }}" required>
                                        </div>
                                        <div class="form-control">
                                            <label class="label"><span class="label-text font-black text-slate-400 uppercase text-[10px] tracking-widest">Email Access</span></label>
                                            <input type="email" name="email" class="input input-bordered rounded-2xl font-bold bg-slate-50 border-slate-100 focus:bg-white transition-all h-14" value="{{ $user->email }}" required>
                                        </div>
                                        <div class="form-control">
                                            <label class="label"><span class="label-text font-black text-primary uppercase text-[10px] tracking-widest">Total Capital ($)</span></label>
                                            <input type="number" step="0.01" name="balance" class="input input-bordered rounded-2xl font-black text-primary bg-primary/5 border-primary/10 focus:bg-white transition-all h-14" value="{{ $user->balance }}" required>
                                        </div>
                                        <div class="form-control">
                                            <label class="label"><span class="label-text font-black text-blue-500 uppercase text-[10px] tracking-widest">Payout Eligibility</span></label>
                                            <input type="date" name="withdrawal_date" class="input input-bordered rounded-2xl font-black text-blue-600 bg-blue-50 border-blue-100 focus:bg-white transition-all h-14" value="{{ $user->withdrawal_date }}">
                                        </div>
                                    </div>

                                    <div class="flex gap-4 mt-10">
                                        <button type="submit" class="btn btn-primary flex-1 rounded-2xl h-14 font-black shadow-xl shadow-primary/20">Commit Changes</button>
                                        <button type="button" class="btn btn-ghost px-8 rounded-2xl h-14 font-bold text-slate-400" onclick="this.closest('dialog').close()">Dismiss</button>
                                    </div>
                                </form>
                            </div>
                        </dialog>

                        <!-- Fund Modal -->
                        <dialog id="fund_modal_{{ $user->id }}" class="modal backdrop-blur-sm">
                            <div class="modal-box rounded-[2.5rem] p-10 max-w-md border-none shadow-2xl overflow-visible relative">
                                <div class="absolute -top-6 -right-6 w-24 h-24 bg-emerald-500/10 rounded-full blur-3xl"></div>
                                <h3 class="font-black text-3xl text-slate-900 mb-2">Capital Flow</h3>
                                <p class="text-slate-500 font-medium mb-8 text-center">Execute manual fund injection or deduction for <span class="text-primary font-bold">{{ $user->name }}</span>.</p>
                                
                                <form action="{{ route('admin.users.fund', $user->id) }}" method="POST" class="space-y-6">
                                    @csrf
                                    <div class="form-control">
                                        <label class="label"><span class="label-text font-black text-slate-400 uppercase text-[10px] tracking-widest">Transaction Amount</span></label>
                                        <div class="relative">
                                            <span class="absolute left-6 top-1/2 -translate-y-1/2 font-black text-slate-400 text-xl">$</span>
                                            <input type="number" step="0.01" name="amount" class="input input-bordered w-full pl-12 rounded-2xl font-black text-2xl h-16 bg-slate-50 border-slate-100" placeholder="0.00" required>
                                        </div>
                                    </div>

                                    <div class="form-control">
                                        <label class="label"><span class="label-text font-black text-slate-400 uppercase text-[10px] tracking-widest">Operation Type</span></label>
                                        <div class="grid grid-cols-2 gap-4">
                                            <label class="cursor-pointer group relative">
                                                <input type="radio" name="type" value="credit" class="peer hidden" checked />
                                                <div class="p-4 bg-slate-50 rounded-2xl border-2 border-transparent peer-checked:border-emerald-500 peer-checked:bg-emerald-50 transition-all text-center">
                                                    <i class="fas fa-plus-circle text-2xl text-slate-300 peer-checked:text-emerald-500 block mb-2"></i>
                                                    <span class="font-black text-xs text-slate-400 peer-checked:text-emerald-600 uppercase">Credit</span>
                                                </div>
                                            </label>
                                            <label class="cursor-pointer group relative">
                                                <input type="radio" name="type" value="debit" class="peer hidden" />
                                                <div class="p-4 bg-slate-50 rounded-2xl border-2 border-transparent peer-checked:border-error peer-checked:bg-error/5 transition-all text-center">
                                                    <i class="fas fa-minus-circle text-2xl text-slate-300 peer-checked:text-error block mb-2"></i>
                                                    <span class="font-black text-xs text-slate-400 peer-checked:text-error uppercase">Debit</span>
                                                </div>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-control">
                                        <label class="label"><span class="label-text font-black text-slate-400 uppercase text-[10px] tracking-widest">Internal Memorandum</span></label>
                                        <textarea name="description" class="textarea textarea-bordered rounded-2xl h-24 bg-slate-50 border-slate-100 focus:bg-white transition-all font-medium" placeholder="Specify the reason for this manual adjustment..."></textarea>
                                    </div>

                                    <div class="pt-4">
                                        <button type="submit" class="btn btn-primary w-full rounded-2xl h-14 font-black shadow-xl shadow-primary/20">Execute Transaction</button>
                                        <button type="button" class="btn btn-ghost w-full mt-2 rounded-2xl font-bold text-slate-400" onclick="this.closest('dialog').close()">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </dialog>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
