<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Lexicrone Finance</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.7.2/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-base-200 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-6xl w-full grid lg:grid-cols-2 bg-base-100 rounded-3xl shadow-2xl overflow-hidden border border-base-300">
        <!-- Left Side: Image/Branding -->
        <div class="hidden lg:flex flex-col justify-between p-12 bg-primary text-primary-content relative overflow-hidden">
            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-12">
                    <img src="https://lexicrone.com/images/logo.png" alt="Lexicrone" class="h-12 w-auto">
                    <span class="text-3xl font-black tracking-tighter">Lexicrone</span>
                </div>
                <h1 class="text-5xl font-black mb-6 leading-tight">Master your financial <span class="text-secondary">ecosystem.</span></h1>
                <p class="text-xl opacity-80 leading-relaxed max-w-md">Access the administrative dashboard to oversee global transactions, investments, and user portfolios with precision.</p>
            </div>
            
            <div class="relative z-10 flex gap-8">
                <div>
                    <p class="text-3xl font-black">99.9%</p>
                    <p class="text-sm opacity-70 uppercase font-bold tracking-widest">Uptime</p>
                </div>
                <div>
                    <p class="text-3xl font-black">256-bit</p>
                    <p class="text-sm opacity-70 uppercase font-bold tracking-widest">Encryption</p>
                </div>
            </div>

            <!-- Abstract Background Shapes -->
            <div class="absolute top-0 right-0 w-96 h-96 bg-white/10 rounded-full -mr-20 -mt-20 blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-96 h-96 bg-secondary/20 rounded-full -ml-20 -mb-20 blur-3xl"></div>
        </div>

        <!-- Right Side: Login Form -->
        <div class="p-8 lg:p-20 flex flex-col justify-center">
            <div class="mb-10 text-center lg:text-left">
                <h2 class="text-4xl font-black text-base-content mb-3 tracking-tight">Admin Portal</h2>
                <p class="text-base-content/60 font-medium">Please sign in to your administrative account</p>
            </div>

            @if(session('success'))
                <div class="alert alert-success rounded-2xl mb-6 shadow-sm">
                    <i class="fas fa-check-circle"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-error rounded-2xl mb-6 shadow-sm">
                    <i class="fas fa-exclamation-triangle"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <form action="{{ route('admin.login') }}" method="POST" class="space-y-6">
                @csrf
                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text font-bold text-base-content/70">Email Address</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-base-content/40">
                            <i class="fas fa-envelope"></i>
                        </span>
                        <input type="email" name="email" class="input input-bordered w-full pl-12 rounded-2xl bg-base-200 border-none focus:bg-base-100 transition-all duration-300" placeholder="admin@lexicrone.com" required autofocus />
                    </div>
                </div>

                <div class="form-control w-full">
                    <div class="flex justify-between items-center mb-1">
                        <label class="label py-0">
                            <span class="label-text font-bold text-base-content/70">Password</span>
                        </label>
                        <a href="{{ route('admin.password.forgot') }}" class="text-sm font-bold text-primary hover:underline">Forgot password?</a>
                    </div>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-base-content/40">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input type="password" name="password" class="input input-bordered w-full pl-12 rounded-2xl bg-base-200 border-none focus:bg-base-100 transition-all duration-300" placeholder="••••••••" required />
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <input type="checkbox" name="remember" class="checkbox checkbox-primary checkbox-sm rounded-lg" id="remember" />
                    <label for="remember" class="text-sm font-bold text-base-content/60 cursor-pointer">Stay logged in</label>
                </div>

                <button type="submit" class="btn btn-primary w-full rounded-2xl h-14 text-lg font-black shadow-xl shadow-primary/20 hover:shadow-none transition-all duration-300">
                    Sign in to Dashboard
                </button>
            </form>

            <div class="mt-12 text-center">
                <p class="text-sm font-bold text-base-content/40 mb-4">Secured by Lexicrone Auth Engine</p>
                <div class="flex justify-center gap-4 text-base-content/30">
                    <i class="fas fa-shield-halved text-xl"></i>
                    <i class="fas fa-fingerprint text-xl"></i>
                    <i class="fas fa-key text-xl"></i>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
