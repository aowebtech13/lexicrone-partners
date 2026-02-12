<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Admin Lexicrone</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; height: 100vh; display: flex; align-items: center; justify-content: center; }
        .auth-card { width: 100%; max-width: 400px; padding: 30px; border-radius: 10px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); background: #fff; }
    </style>
</head>
<body>
    <div class="auth-card">
        <h3 class="text-center mb-4">Forgot Password</h3>
        <p class="text-muted text-center mb-4">Enter your admin email to receive a 6-digit reset token.</p>
        
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form action="{{ route('admin.password.forgot') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control" placeholder="admin@lexicrone.com" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Send Reset Token</button>
        </form>
        <div class="mt-3 text-center">
            <a href="{{ config('app.frontend_url') }}/sign-in">Back to Login</a>
        </div>
    </div>
</body>
</html>
