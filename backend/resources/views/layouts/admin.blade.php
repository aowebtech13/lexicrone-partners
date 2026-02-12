<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Admin Lexicrone</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.7.2/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
    @yield('styles')
</head>
<body class="bg-base-200 min-h-screen">
    <div class="drawer lg:drawer-open">
        <input id="admin-drawer" type="checkbox" class="drawer-toggle" />
        <div class="drawer-content flex flex-col">
            <!-- Navbar -->
            <div class="navbar bg-base-100 shadow-sm lg:hidden">
                <div class="flex-none">
                    <label for="admin-drawer" class="btn btn-square btn-ghost">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-5 h-5 stroke-current"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </label>
                </div>
                <div class="flex-1 px-2 mx-2 font-bold text-xl text-primary">Lexicrone</div>
            </div>

            <!-- Page Content -->
            <main class="p-6 lg:p-10 space-y-6">
                @if(session('success'))
                    <div class="alert alert-success shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-error shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>

        <!-- Sidebar -->
        <div class="drawer-side z-50">
            <label for="admin-drawer" class="drawer-overlay"></label>
            <aside class="w-80 min-h-screen bg-base-100 text-base-content flex flex-col shadow-xl">
                <div class="p-8 flex items-center gap-3">
                    <div class="w-10 h-10 bg-primary rounded-xl flex items-center justify-center text-primary-content shadow-lg shadow-primary/20">
                        <i class="fas fa-crown text-xl"></i>
                    </div>
                    <span class="text-2xl font-black tracking-tight text-base-content">Lexicrone</span>
                </div>

                <ul class="menu p-4 w-full gap-2 flex-1">
                    <li class="menu-title opacity-50 text-xs font-bold uppercase tracking-widest mt-4 mb-2">Main Menu</li>
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active bg-primary/10 text-primary font-bold' : '' }} py-3">
                            <i class="fas fa-th-large w-5"></i> Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.users') }}" class="{{ request()->routeIs('admin.users') ? 'active bg-primary/10 text-primary font-bold' : '' }} py-3">
                            <i class="fas fa-users w-5"></i> Users
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.investments') }}" class="{{ request()->routeIs('admin.investments') ? 'active bg-primary/10 text-primary font-bold' : '' }} py-3">
                            <i class="fas fa-chart-pie w-5"></i> Investments
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.withdrawals') }}" class="{{ request()->routeIs('admin.withdrawals') ? 'active bg-primary/10 text-primary font-bold' : '' }} py-3">
                            <i class="fas fa-wallet w-5"></i> Withdrawals
                        </a>
                    </li>
                </ul>

                <div class="p-4 mt-auto border-t border-base-200">
                    <div class="flex items-center gap-3 p-4 bg-base-200 rounded-2xl mb-4">
                        <div class="avatar placeholder">
                            <div class="bg-neutral text-neutral-content rounded-full w-10">
                                <span>{{ substr(Auth::user()->name ?? 'A', 0, 1) }}</span>
                            </div>
                        </div>
                        <div class="flex-1 overflow-hidden text-sm">
                            <p class="font-bold truncate">{{ Auth::user()->name }}</p>
                            <p class="opacity-50 truncate">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-error btn-outline w-full gap-2 rounded-xl">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                </div>
            </aside>
        </div>
    </div>
    @yield('scripts')
</body>
</html>
