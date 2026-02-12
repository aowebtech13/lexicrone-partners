<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Investment;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DistributeProfits extends Command
{
    protected $signature = 'app:distribute-profits';
    protected $description = 'Distribute daily profits to active investments';

    public function handle()
    {
        $investments = Investment::where('status', 'active')->with(['plan', 'user'])->get();
        $count = 0;

        foreach ($investments as $investment) {
            $plan = $investment->plan;
            $now = now();
            $shouldDistribute = false;
            $isLastProfit = false;

            // Check if investment has ended
            if ($now->greaterThanOrEqualTo($investment->end_date)) {
                $shouldDistribute = true;
                $isLastProfit = true;
            } else {
                $lastProfitAt = $investment->last_profit_at ?? $investment->start_date;

                switch ($plan->return_type) {
                    case 'daily':
                        if ($now->diffInDays($lastProfitAt) >= 1) {
                            $shouldDistribute = true;
                        }
                        break;
                    case 'weekly':
                        if ($now->diffInWeeks($lastProfitAt) >= 1) {
                            $shouldDistribute = true;
                        }
                        break;
                    case 'monthly':
                        if ($now->diffInMonths($lastProfitAt) >= 1) {
                            $shouldDistribute = true;
                        }
                        break;
                    case 'end_of_term':
                        // Only distributed at the end, handled by the end_date check above
                        break;
                }
            }

            if ($shouldDistribute) {
                DB::transaction(function () use ($investment, $plan, $isLastProfit, &$count) {
                    $profitAmount = 0;

                    if ($plan->return_type === 'end_of_term') {
                        if ($isLastProfit) {
                            $profitAmount = $investment->amount * ($plan->interest_rate / 100);
                        }
                    } else {
                        // For daily/weekly/monthly, we assume the interest_rate is the profit PER period
                        // Or if interest_rate is total, we divide by periods. 
                        // Let's assume interest_rate is PER PERIOD for simplicity in this logic, 
                        // OR if it's total interest, we should have calculated it differently.
                        // Given the existing code: $dailyProfit = $investment->amount * ($plan->interest_rate / 100);
                        // It seems interest_rate is treated as period profit.
                        $profitAmount = $investment->amount * ($plan->interest_rate / 100);
                    }

                    if ($profitAmount > 0) {
                        // Update investment
                        $investment->increment('profit', $profitAmount);
                        $investment->last_profit_at = now();

                        // Update user
                        $investment->user->increment('balance', $profitAmount);
                        $investment->user->increment('total_profit', $profitAmount);

                        // Create transaction
                        Transaction::create([
                            'user_id' => $investment->user_id,
                            'type' => 'profit',
                            'amount' => $profitAmount,
                            'status' => 'completed',
                            'description' => "Profit distribution ({$plan->return_type}) from {$plan->name}",
                        ]);
                    }

                    if ($isLastProfit) {
                        $investment->status = 'completed';
                        // Return principal
                        $investment->user->increment('balance', $investment->amount);
                        
                        // Create transaction for principal return
                        Transaction::create([
                            'user_id' => $investment->user_id,
                            'type' => 'principal_return',
                            'amount' => $investment->amount,
                            'status' => 'completed',
                            'description' => "Principal return from {$plan->name}",
                        ]);
                    }

                    $investment->save();
                    $count++;
                });
            }
        }

        $this->info("Processed {$count} investments for profit distribution.");
    }
}
