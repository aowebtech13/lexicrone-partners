<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Investment;
use App\Models\Withdrawal;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Display admin dashboard stats.
     */
    public function index()
    {
        return response()->json([
            'stats' => [
                'total_users' => User::count(),
                'total_investments' => Investment::count(),
                'total_invested_amount' => Investment::sum('amount'),
                'pending_withdrawals' => Withdrawal::where('status', 'pending')->count(),
            ],
            'message' => 'Admin dashboard data retrieved successfully.'
        ]);
    }

    public function getAllUsers()
    {
        return response()->json(User::where('role', '!=', 'admin')->latest()->get());
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        if ($user->role === 'admin') {
            return response()->json(['message' => 'Cannot delete admin user.'], 403);
        }
        $user->delete();
        return response()->json(['message' => 'User deleted successfully.']);
    }

    public function getAllInvestments()
    {
        return response()->json(Investment::with(['user', 'plan'])->latest()->get());
    }

    public function cancelInvestment($id)
    {
        $investment = Investment::findOrFail($id);
        if ($investment->status !== 'active') {
            return response()->json(['message' => 'Only active investments can be cancelled.'], 422);
        }

        return DB::transaction(function () use ($investment) {
            $investment->status = 'cancelled';
            $investment->save();

            // Return principal to user balance
            $investment->user->increment('balance', $investment->amount);

            Transaction::create([
                'user_id' => $investment->user_id,
                'type' => 'cancellation_refund',
                'amount' => $investment->amount,
                'status' => 'completed',
                'description' => "Refund from cancelled investment #{$investment->id}",
            ]);

            return response()->json(['message' => 'Investment cancelled and principal refunded.']);
        });
    }

    public function extendInvestmentDate(Request $request, $id)
    {
        $request->validate([
            'end_date' => 'required|date|after:today',
        ]);

        $investment = Investment::findOrFail($id);
        $investment->end_date = $request->end_date;
        $investment->save();

        return response()->json(['message' => 'Investment end date extended successfully.', 'investment' => $investment]);
    }

    public function getAllWithdrawals()
    {
        return response()->json(Withdrawal::with('user')->latest()->get());
    }

    public function updateWithdrawalStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
            'rejection_reason' => 'required_if:status,rejected',
        ]);

        $withdrawal = Withdrawal::findOrFail($id);
        if ($withdrawal->status !== 'pending') {
            return response()->json(['message' => 'Only pending withdrawals can be updated.'], 422);
        }

        return DB::transaction(function () use ($withdrawal, $request) {
            $withdrawal->status = $request->status;
            if ($request->status === 'rejected') {
                $withdrawal->rejection_reason = $request->rejection_reason;
                // Refund the amount to user balance if it was deducted upon request
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

            return response()->json(['message' => "Withdrawal {$request->status} successfully."]);
        });
    }
}
