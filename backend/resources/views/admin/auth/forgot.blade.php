<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Admin Lexicrone</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.7.2/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-base-200 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full bg-base-100 rounded-3xl shadow-2xl p-8 lg:p-12 border border-base-300">
        <div class="text-center mb-10">
            <div class="w-16 h-16 bg-primary/10 rounded-2xl flex items-center justify-center text-primary mx-auto mb-6 shadow-sm">
                <i class="fas fa-key text-2xl"></i>
            </div>
            <h2 class="text-3xl font-black tracking-tight mb-2">Forgot Password?</h2>
            <p class="text-base-content/60 font-medium">Enter your admin email to receive a 6-digit reset token.</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success rounded-2xl mb-6">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-error rounded-2xl mb-6">
                <i class="fas fa-exclamation-triangle"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <form action="{{ route('admin.password.forgot') }}" method="POST" class="space-y-6">
            @csrf
            <div class="form-control">
                <label class="label"><span class="label-text font-bold">Email Address</span></label>
                <input type="email" name="email" class="input input-bordered rounded-2xl bg-base-200 border-none focus:bg-base-100 transition-all duration-300 h-14" placeholder="admin@lexicrone.com" required />
            </div>
            <button type="submit" class="btn btn-primary w-full rounded-2xl h-14 text-lg font-black shadow-xl shadow-primary/20">
                Send Reset Token
            </button>
        </form>

        <div class="mt-8 text-center">
            <a href="{{ route('admin.login') }}" class="text-sm font-bold text-base-content/40 hover:text-primary transition-colors">
                <i class="fas fa-arrow-left mr-2"></i> Return to Sign In
            </a>
        </div>
    </div>
</body>
</html>
