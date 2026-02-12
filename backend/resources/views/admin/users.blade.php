@extends('layouts.admin')

@section('title', 'User Management')

@section('content')
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-3xl font-black tracking-tight">User Management</h1>
        <p class="text-base-content/60 font-medium">Oversee and manage registered investors</p>
    </div>
    <div class="join shadow-sm bg-base-100 p-1 rounded-2xl">
        <input class="input input-ghost join-item focus:bg-transparent" placeholder="Search users..."/>
        <button class="btn btn-primary join-item rounded-xl">Search</button>
    </div>
</div>

<div class="card bg-base-100 shadow-xl border border-base-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="table table-lg">
            <thead>
                <tr class="bg-base-200/50">
                    <th class="font-bold text-xs uppercase tracking-widest opacity-50">User Details</th>
                    <th class="font-bold text-xs uppercase tracking-widest opacity-50 text-center">Balance</th>
                    <th class="font-bold text-xs uppercase tracking-widest opacity-50">Registration</th>
                    <th class="font-bold text-xs uppercase tracking-widest opacity-50 text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr class="hover:bg-base-200/30 transition-colors duration-200">
                    <td>
                        <div class="flex items-center gap-3">
                            <div class="avatar placeholder">
                                <div class="bg-primary/10 text-primary rounded-xl w-12 h-12">
                                    <span class="text-xl font-black uppercase">{{ substr($user->name, 0, 1) }}</span>
                                </div>
                            </div>
                            <div>
                                <div class="font-black text-lg">{{ $user->name }}</div>
                                <div class="text-sm opacity-50 font-medium">{{ $user->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="text-center">
                        <span class="font-black text-lg text-primary">${{ number_format($user->balance, 2) }}</span>
                    </td>
                    <td>
                        <div class="font-bold">{{ $user->created_at->format('M d, Y') }}</div>
                        <div class="text-xs opacity-50">{{ $user->created_at->format('H:i A') }}</div>
                    </td>
                    <td class="text-right">
                        <div class="dropdown dropdown-left">
                            <label tabindex="0" class="btn btn-ghost btn-circle btn-sm">
                                <i class="fas fa-ellipsis-v"></i>
                            </label>
                            <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow-2xl bg-base-100 rounded-2xl w-52 border border-base-200 mt-2">
                                <li><a><i class="fas fa-edit text-info"></i> Edit Details</a></li>
                                <li><a><i class="fas fa-wallet text-success"></i> Fund Wallet</a></li>
                                <div class="divider my-0"></div>
                                <li>
                                    <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" onsubmit="return confirm('Permanently delete this user?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-error font-bold w-full text-left">
                                            <i class="fas fa-trash-alt"></i> Delete User
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
