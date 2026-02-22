<!DOCTYPE html>
<html lang="en" data-theme="winter">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Lexicrone Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.7.2/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: "#2563eb",
                        secondary: "#7c3aed",
                        accent: "#0ea5e9",
                        neutral: "#1f2937",
                        "base-100": "#ffffff",
                        "base-200": "#f8fafc",
                        "base-300": "#f1f5f9",
                    },
                    borderRadius: {
                        '2xl': '1rem',
                        '3xl': '1.5rem',
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; letter-spacing: -0.01em; }
        .glass-sidebar {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border-right: 1px solid rgba(0, 0, 0, 0.05);
        }
        .menu li > a.active {
            background: linear-gradient(90deg, rgba(37, 99, 235, 0.1) 0%, rgba(37, 99, 235, 0) 100%);
            border-left: 4px solid #2563eb;
            border-radius: 0;
            color: #2563eb;
            font-weight: 700;
        }
        .card {
            border: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }
        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.05);
        }
    </style>
    @yield('styles')
</head>
<body class="bg-[#f1f5f9] min-h-screen">
    <div class="drawer lg:drawer-open">
        <input id="admin-drawer" type="checkbox" class="drawer-toggle" />
        <div class="drawer-content flex flex-col">
            <!-- Navbar -->
            <div class="navbar bg-white/80 backdrop-blur-md sticky top-0 z-30 border-b border-base-200 lg:hidden">
                <div class="flex-none">
                    <label for="admin-drawer" class="btn btn-square btn-ghost">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-5 h-5 stroke-current"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </label>
                </div>
                <div class="flex-1 px-4">
                    <span class="text-xl font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-primary to-secondary">Lexicrone</span>
                </div>
            </div>

            <!-- Page Content -->
            <main class="p-6 lg:p-12 max-w-[1600px] mx-auto w-full space-y-8">
                @if(session('success'))
                    <div class="alert alert-success border-none shadow-xl shadow-success/10 bg-success text-white rounded-2xl">
                        <i class="fas fa-check-circle text-xl"></i>
                        <span class="font-bold">{{ session('success') }}</span>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-error border-none shadow-xl shadow-error/10 bg-error text-white rounded-2xl">
                        <i class="fas fa-exclamation-triangle text-xl"></i>
                        <span class="font-bold">{{ session('error') }}</span>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>

        <!-- Sidebar -->
        <div class="drawer-side z-50">
            <label for="admin-drawer" class="drawer-overlay"></label>
            <aside class="w-72 min-h-screen glass-sidebar flex flex-col">
                <div class="p-8 mb-4">
                    <div class="flex items-center gap-3">
                        <img src="https://lexicrone.com/images/logo.png"  alt="Lexicrone" class="h-16 w-auto">
                        <div class="flex flex-col">

                            <span class="text-[10px] font-bold text-primary uppercase tracking-[0.2em] mt-1">Admin Portal</span>
                        </div>
                    </div>
                </div>

                <ul class="menu px-0 w-full gap-1 flex-1">
                    <li class="px-6 mb-2">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Core Management</span>
                    </li>
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }} py-4 px-8 flex items-center gap-4 hover:bg-slate-100 transition-all">
                            <i class="fas fa-grid-2 text-lg"></i> 
                            <span class="font-semibold">Overview</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.users') }}" class="{{ request()->routeIs('admin.users') ? 'active' : '' }} py-4 px-8 flex items-center gap-4 hover:bg-slate-100 transition-all">
                            <i class="fas fa-user-group text-lg"></i> 
                            <span class="font-semibold">Investors</span>
                        </a>
                    </li>
                    <li class="px-6 mt-6 mb-2">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Financials</span>
                    </li>
                    <li>
                        <a href="{{ route('admin.investments') }}" class="{{ request()->routeIs('admin.investments') ? 'active' : '' }} py-4 px-8 flex items-center gap-4 hover:bg-slate-100 transition-all">
                            <i class="fas fa-chart-line-up text-lg"></i> 
                            <span class="font-semibold">Active Plans</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.withdrawals') }}" class="{{ request()->routeIs('admin.withdrawals') ? 'active' : '' }} py-4 px-8 flex items-center gap-4 hover:bg-slate-100 transition-all">
                            <i class="fas fa-money-bill-transfer text-lg"></i> 
                            <span class="font-semibold">Payouts</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.transactions') }}" class="{{ request()->routeIs('admin.transactions') ? 'active' : '' }} py-4 px-8 flex items-center gap-4 hover:bg-slate-100 transition-all">
                            <i class="fas fa-list-check text-lg"></i> 
                            <span class="font-semibold">Audit Logs</span>
                        </a>
                    </li>
                </ul>

                <div class="p-6 mt-auto">
                    <div class="p-4 bg-slate-900 rounded-3xl mb-6 shadow-2xl shadow-slate-900/20 text-white relative overflow-hidden group">
                        <div class="absolute -right-4 -top-4 w-24 h-24 bg-primary/20 rounded-full blur-2xl group-hover:bg-primary/40 transition-all"></div>
                        <div class="flex items-center gap-3 relative z-10">
                            <div class="avatar">
                                <div class="rounded-xl w-10 h-10 overflow-hidden bg-primary flex items-center justify-center">
                                    @if(Auth::user()->avatar_url)
                                        <img src="{{ Auth::user()->avatar_url }}" alt="{{ Auth::user()->name }}" class="object-cover w-full h-full" />
                                    @else
                                        <span class="font-bold text-sm text-white">{{ substr(Auth::user()->name ?? 'A', 0, 1) }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="flex-1 overflow-hidden">
                                <p class="font-bold text-sm truncate">{{ Auth::user()->name }}</p>
                                <p class="text-[10px] opacity-60 truncate">System Administrator</p>
                            </div>
                        </div>
                        <form action="{{ route('admin.logout') }}" method="POST" class="mt-4 relative z-10">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-ghost bg-white/10 hover:bg-white/20 text-white w-full rounded-xl border-none">
                                <i class="fas fa-power-off text-xs mr-2"></i> Sign Out
                            </button>
                        </form>
                    </div>
                </div>
            </aside>
        </div>
    </div>
    @yield('scripts')
</body>
</html>
    @yield('scripts')
</body>
</html>
