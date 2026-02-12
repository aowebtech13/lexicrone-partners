<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Investment;
use App\Models\Withdrawal;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Mail\AdminResetToken;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AdminWebController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_investments' => Investment::count(),
            'total_invested_amount' => Investment::sum('amount'),
            'pending_withdrawals' => Withdrawal::where('status', 'pending')->count(),
        ];
        return view('admin.dashboard', compact('stats'));
    }

    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            if (Auth::user()->role !== 'admin') {
                Auth::logout();
                return back()->with('error', 'Unauthorized access.');
            }
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->with('error', 'The provided credentials do not match our records.');
    }

    public function showForgotForm()
    {
        return view('admin.auth.forgot');
    }

    public function sendResetToken(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);
        
        $user = User::where('email', $request->email)->where('role', 'admin')->first();
        if (!$user) {
            return back()->with('error', 'Admin user not found.');
        }

        $token = sprintf("%06d", mt_rand(1, 999999));
        
        DB::table('admin_password_resets')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => Hash::make($token),
                'expires_at' => now()->addMinutes(15),
                'created_at' => now()
            ]
        );

        Mail::to($request->email)->send(new AdminResetToken($token));

        return redirect()->route('admin.password.reset')->with('success', 'A 6-digit reset token has been sent to your email.');
    }

    public function showResetForm()
    {
        return view('admin.auth.reset');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'token' => 'required|string|size:6',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $reset = DB::table('admin_password_resets')->where('email', $request->email)->first();

        if (!$reset || now()->greaterThan($reset->expires_at) || !Hash::check($request->token, $reset->token)) {
            return back()->with('error', 'Invalid or expired token.');
        }

        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        DB::table('admin_password_resets')->where('email', $request->email)->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Password reset successful.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }

    public function users()
    {
        $users = User::where('role', '!=', 'admin')->latest()->get();
        return view('admin.users', compact('users'));
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        if ($user->role === 'admin') {
            return back()->with('error', 'Cannot delete admin user.');
        }
        $user->delete();
        return back()->with('success', 'User deleted successfully.');
    }

    public function investments()
    {
        $investments = Investment::with(['user', 'plan'])->latest()->get();
        return view('admin.investments', compact('investments'));
    }

    public function cancelInvestment($id)
    {
        $investment = Investment::findOrFail($id);
        if ($investment->status !== 'active') {
            return back()->with('error', 'Only active investments can be cancelled.');
        }

        DB::transaction(function () use ($investment) {
            $investment->status = 'cancelled';
            $investment->save();

            $investment->user->increment('balance', $investment->amount);

            Transaction::create([
                'user_id' => $investment->user_id,
                'type' => 'cancellation_refund',
                'amount' => $investment->amount,
                'status' => 'completed',
                'description' => "Refund from cancelled investment #{$investment->id}",
            ]);
        });

        return back()->with('success', 'Investment cancelled and principal refunded.');
    }

    public function extendInvestment(Request $request, $id)
    {
        $request->validate(['end_date' => 'required|date|after:today']);
        $investment = Investment::findOrFail($id);
        $investment->end_date = $request->end_date;
        $investment->save();

        return back()->with('success', 'Investment end date extended.');
    }

    public function withdrawals()
    {
        $withdrawals = Withdrawal::with('user')->latest()->get();
        return view('admin.withdrawals', compact('withdrawals'));
    }

    public function updateWithdrawal(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
            'rejection_reason' => 'required_if:status,rejected',
        ]);

        $withdrawal = Withdrawal::findOrFail($id);
        if ($withdrawal->status !== 'pending') {
            return back()->with('error', 'Only pending withdrawals can be updated.');
        }

        DB::transaction(function () use ($withdrawal, $request) {
            $withdrawal->status = $request->status;
            if ($request->status === 'rejected') {
                $withdrawal->rejection_reason = $request->rejection_reason;
                $withdrawal->user->increment('balance', $withdrawal->amount);
            }
            $withdrawal->save();

            Transaction::create([
                'user_id' => $withdrawal->user_id,
                'type' => 'withdrawal_' . $request->status,
                'amount' => $request->status === 'approved' ? -$withdrawal->amount : $withdrawal->amount,
                'status' => 'completed',
                'description' => "Withdrawal request #{$withdrawal->id} was {$request->status}",
            ]);
        });

        return back()->with('success', "Withdrawal {$request->status} successfully.");
    }
}
