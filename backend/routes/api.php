<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\PageDataController;

Route::get('/services', [PageDataController::class, 'services']);

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

use App\Mail\AdminNotificationMail;
use Illuminate\Support\Facades\Mail;

Route::middleware(['auth:sanctum', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index']);
    
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

require __DIR__.'/auth.php';
