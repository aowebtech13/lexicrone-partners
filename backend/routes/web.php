<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\AdminWebController;

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});

// Public Admin Auth Routes
Route::prefix('admin')->group(function () {
    Route::get('/password/forgot', [AdminWebController::class, 'showForgotForm'])->name('admin.password.forgot');
    Route::post('/password/forgot', [AdminWebController::class, 'sendResetToken']);
    Route::get('/password/reset', [AdminWebController::class, 'showResetForm'])->name('admin.password.reset');
    Route::post('/password/reset', [AdminWebController::class, 'resetPassword']);
    
    // Add a simple login view for the admin blade panel
    Route::get('/login', [AdminWebController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminWebController::class, 'login']);
});

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminWebController::class, 'dashboard'])->name('admin.dashboard');
    
    Route::get('/users', [AdminWebController::class, 'users'])->name('admin.users');
    Route::delete('/users/{id}', [AdminWebController::class, 'deleteUser'])->name('admin.users.delete');
    
    Route::get('/investments', [AdminWebController::class, 'investments'])->name('admin.investments');
    Route::post('/investments/{id}/cancel', [AdminWebController::class, 'cancelInvestment'])->name('admin.investments.cancel');
    Route::post('/investments/{id}/extend', [AdminWebController::class, 'extendInvestment'])->name('admin.investments.extend');
    
    Route::get('/withdrawals', [AdminWebController::class, 'withdrawals'])->name('admin.withdrawals');
    Route::post('/withdrawals/{id}/update', [AdminWebController::class, 'updateWithdrawal'])->name('admin.withdrawals.update');
    
    Route::post('/logout', [AdminWebController::class, 'logout'])->name('admin.logout');
});
