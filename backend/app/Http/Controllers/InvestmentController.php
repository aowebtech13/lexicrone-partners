<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\InvestmentPlan;
use App\Models\Investment;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InvestmentController extends Controller
{
    public function getPlans()
    {
        return response()->json(InvestmentPlan::where('is_active', true)->get());
    }

    public function invest(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:investment_plans,id',
            'amount' => 'required|numeric|min:0',
        ]);

        $user = Auth::user();
        $plan = InvestmentPlan::findOrFail($request->plan_id);

        if ($request->amount < $plan->min_amount || $request->amount > $plan->max_amount) {
            return response()->json(['message' => "Amount must be between {$plan->min_amount} and {$plan->max_amount}"], 422);
        }

        if ($user->balance < $request->amount) {
            return response()->json(['message' => 'Insufficient balance'], 422);
        }

        return DB::transaction(function () use ($user, $plan, $request) {
            // Deduct from balance
            $user->decrement('balance', $request->amount);
            $user->increment('total_invested', $request->amount);

            // Create investment
            $investment = Investment::create([
                'user_id' => $user->id,
                'investment_plan_id' => $plan->id,
                'amount' => $request->amount,
                'start_date' => now(),
                'end_date' => now()->addDays($plan->duration_days),
                'status' => 'active',
            ]);

            // Create transaction
            Transaction::create([
                'user_id' => $user->id,
                'type' => 'investment',
                'amount' => -$request->amount,
                'status' => 'completed',
                'description' => "Invested in {$plan->name}",
            ]);

            return response()->json([
                'message' => 'Investment successful',
                'investment' => $investment->load('plan'),
                'user' => $user->fresh(),
            ]);
        });
    }

    public function getDashboardData()
    {
        $user = Auth::user()->load(['investments.plan', 'transactions' => function($query) {
            $query->latest()->limit(10);
        }]);

        return response()->json([
            'stats' => [
                'balance' => $user->balance,
                'total_profit' => $user->total_profit,
                'total_invested' => $user->total_invested,
                'active_investments_count' => $user->investments()->where('status', 'active')->count(),
            ],
            'recent_transactions' => $user->transactions,
            'active_investments' => $user->investments()->where('status', 'active')->with('plan')->get(),
        ]);
    }
}
