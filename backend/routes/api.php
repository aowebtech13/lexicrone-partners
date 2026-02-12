<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\PageDataController;
use App\Http\Controllers\InvestmentController;

use App\Http\Controllers\WithdrawalController;

use App\Http\Controllers\Api\ProfileController;

Route::get('/services', [PageDataController::class, 'services']);
Route::get('/investment-plans', [InvestmentController::class, 'getPlans']);

require __DIR__.'/auth.php';

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::get('/dashboard-data', [InvestmentController::class, 'getDashboardData']);
    Route::get('/transactions', [InvestmentController::class, 'getTransactions']);
    Route::post('/invest', [InvestmentController::class, 'invest']);
    
    Route::get('/withdrawals', [WithdrawalController::class, 'index']);
    Route::post('/withdraw', [WithdrawalController::class, 'store']);

    Route::get('/profile', [ProfileController::class, 'show']);
    Route::post('/profile', [ProfileController::class, 'update']);
});

use App\Mail\AdminNotificationMail;
use Illuminate\Support\Facades\Mail;

Route::middleware(['auth:sanctum', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index']);
    Route::get('/users', [AdminController::class, 'getAllUsers']);
    Route::delete('/users/{id}', [AdminController::class, 'deleteUser']);
    Route::get('/investments', [AdminController::class, 'getAllInvestments']);
    // Correction: Use post or patch for status updates/cancellations
    Route::post('/investments/{id}/cancel', [AdminController::class, 'cancelInvestment']);
    Route::post('/investments/{id}/extend', [AdminController::class, 'extendInvestmentDate']);
    Route::get('/withdrawals', [AdminController::class, 'getAllWithdrawals']);
    Route::post('/withdrawals/{id}/status', [AdminController::class, 'updateWithdrawalStatus']);
    
    Route::post('/send-test-email', function (Request $request) {
        $user = $request->user();
        Mail::to($user->email)->send(new AdminNotificationMail(
            $user,
            'Test Notification',
            'This is a test notification from the admin area.',
            config('app.url') . '/admin/dashboard'
        ));

        return response()->json(['message' => 'Test email sent successfully.']);
    });
});
