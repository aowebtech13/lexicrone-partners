<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Admin Lexicrone</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.7.2/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-base-200 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full bg-base-100 rounded-3xl shadow-2xl p-8 lg:p-12 border border-base-300">
        <div class="text-center mb-10">
            <div class="w-16 h-16 bg-success/10 rounded-2xl flex items-center justify-center text-success mx-auto mb-6 shadow-sm">
                <i class="fas fa-shield-check text-2xl"></i>
            </div>
            <h2 class="text-3xl font-black tracking-tight mb-2">Reset Password</h2>
            <p class="text-base-content/60 font-medium">Verification required to update credentials.</p>
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

        <form action="{{ route('admin.password.reset') }}" method="POST" class="space-y-5">
            @csrf
            <div class="form-control">
                <label class="label py-1"><span class="label-text font-bold opacity-70 text-xs uppercase tracking-widest">Confirmed Email</span></label>
                <input type="email" name="email" class="input input-bordered rounded-2xl bg-base-200 border-none font-bold h-12" value="{{ old('email') }}" placeholder="admin@lexicrone.com" required />
            </div>
            
            <div class="form-control text-center">
                <label class="label py-1 justify-center"><span class="label-text font-black text-primary">6-Digit Verification Token</span></label>
                <input type="text" name="token" class="input input-bordered rounded-2xl bg-primary/5 border-primary/20 text-center text-3xl font-black tracking-[1rem] h-16 focus:bg-base-100 transition-all" maxlength="6" placeholder="000000" required />
            </div>

            <div class="form-control">
                <label class="label py-1"><span class="label-text font-bold opacity-70 text-xs uppercase tracking-widest">New Secure Password</span></label>
                <input type="password" name="password" class="input input-bordered rounded-2xl bg-base-200 border-none h-12" placeholder="••••••••" required />
            </div>

            <div class="form-control">
                <label class="label py-1"><span class="label-text font-bold opacity-70 text-xs uppercase tracking-widest">Confirm Password</span></label>
                <input type="password" name="password_confirmation" class="input input-bordered rounded-2xl bg-base-200 border-none h-12" placeholder="••••••••" required />
            </div>

            <button type="submit" class="btn btn-primary w-full rounded-2xl h-14 text-lg font-black shadow-xl shadow-primary/20 mt-4">
                Update Admin Password
            </button>
        </form>
    </div>
</body>
</html>
