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

        foreach ($investments as $investment) {
            DB::transaction(function () use ($investment) {
                $plan = $investment->plan;
                $dailyProfit = $investment->amount * ($plan->interest_rate / 100);

                // Update investment
                $investment->increment('profit', $dailyProfit);
                $investment->last_profit_at = now();
                
                if (now()->greaterThanOrEqualTo($investment->end_date)) {
                    $investment->status = 'completed';
                    // Return principal if that's the business logic, or handle otherwise
                    $investment->user->increment('balance', $investment->amount);
                }
                $investment->save();

                // Update user
                $investment->user->increment('balance', $dailyProfit);
                $investment->user->increment('total_profit', $dailyProfit);

                // Create transaction
                Transaction::create([
                    'user_id' => $investment->user_id,
                    'type' => 'profit',
                    'amount' => $dailyProfit,
                    'status' => 'completed',
                    'description' => "Daily profit from {$plan->name}",
                ]);
            });
        }

        $this->info('Profits distributed successfully.');
    }
}
